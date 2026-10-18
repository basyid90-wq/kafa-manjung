<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use App\Notifications\TeacherInvitation;
use App\Services\WorkspaceMerger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;

class InvitationController extends Controller
{
    // ── Guru Besar side (auth + plan:pengguna) ──────────────────────────────

    public function store(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->school_id, 403);

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);
        $email = strtolower(trim($data['email']));

        if (User::where('email', $email)->where('school_id', $user->school_id)->exists()) {
            return back()->with('error', 'Pengguna dengan e-mel ini sudah berada dalam sekolah anda.');
        }

        // One pending invite per e-mail: replace the old one so only the newest link works
        Invitation::where('email', $email)->whereNull('accepted_at')->delete();

        [$invitation, $token] = Invitation::issue([
            'school_id'  => $user->school_id,
            'invited_by' => $user->id,
            'name'       => $data['name'],
            'email'      => $email,
            'role'       => 'Guru KAFA',
        ]);

        Notification::route('mail', $email)->notify(new TeacherInvitation($invitation, $token));

        return redirect()->route('users.index')->with('success', "Jemputan telah dihantar ke {$email}.");
    }

    public function destroy(Invitation $invitation)
    {
        $this->authorizeSchool($invitation->school_id);

        $invitation->delete();

        return redirect()->route('users.index')->with('success', 'Jemputan telah dibatalkan.');
    }

    // ── Invitee side (public link) ──────────────────────────────────────────

    public function show(string $token, WorkspaceMerger $merger)
    {
        $invitation = Invitation::findPendingByToken($token);
        if (!$invitation || !$invitation->school?->allows('pengguna')) {
            return view('invitations.invalid');
        }

        $existing = User::where('email', $invitation->email)->first();
        $current  = Auth::user();

        // Existing account: must log in as that account first
        if ($existing && (!$current || $current->id !== $existing->id)) {
            session()->put('url.intended', route('invitations.show', $token));
            return view('invitations.login-required', compact('invitation'));
        }

        if ($existing && !$merger->canJoin($existing)) {
            return view('invitations.invalid', ['reason' => 'Akaun anda sudah terikat dengan sekolah lain dan tidak boleh digabungkan. Sila hubungi kami.']);
        }

        $merge = null;
        if ($existing && $existing->school) {
            $merge = [
                'from'      => $existing->school,
                'preview'   => $merger->preview($existing->school),
                'conflicts' => $merger->conflicts($existing->school, $invitation->school),
            ];
        }

        return view('invitations.show', compact('invitation', 'token', 'existing', 'merge'));
    }

    public function accept(Request $request, string $token, WorkspaceMerger $merger)
    {
        $invitation = Invitation::findPendingByToken($token);
        if (!$invitation || !$invitation->school?->allows('pengguna')) {
            return view('invitations.invalid');
        }

        $existing = User::where('email', $invitation->email)->first();

        if (!$existing) {
            $data = $request->validate([
                'name'     => ['required', 'string', 'max:255'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'terms'    => ['accepted'],
            ], [
                'terms.accepted' => 'Anda perlu bersetuju dengan Terma Perkhidmatan dan Notis Privasi.',
            ]);

            $user = DB::transaction(function () use ($invitation, $data) {
                $user = User::create([
                    'name'      => $data['name'],
                    'email'     => $invitation->email,
                    'password'  => Hash::make($data['password']),
                    'school_id' => $invitation->school_id,
                ]);
                // The invite link was delivered to this address, so it is verified
                $user->forceFill(['email_verified_at' => now()])->save();
                $user->assignRole($invitation->role);
                $invitation->forceFill(['accepted_at' => now()])->save();

                return $user;
            });

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Selamat datang ke ' . $invitation->school->name . '!');
        }

        // Existing account: only the logged-in owner of that e-mail may accept
        $current = Auth::user();
        abort_unless($current && $current->id === $existing->id, 403);

        if (!$merger->canJoin($current)) {
            return view('invitations.invalid', ['reason' => 'Akaun anda sudah terikat dengan sekolah lain dan tidak boleh digabungkan. Sila hubungi kami.']);
        }

        $from = $current->school;
        if ($from && $merger->conflicts($from, $invitation->school)->isNotEmpty()) {
            return redirect()->route('invitations.show', $token)
                ->with('error', 'Terdapat murid yang sudah wujud di sekolah tersebut. Selesaikan pertindihan dahulu.');
        }

        DB::transaction(function () use ($merger, $from, $invitation, $current) {
            if ($from) {
                $merger->merge($from, $invitation->school);
            }
            $current->forceFill([
                'school_id'         => $invitation->school_id,
                'email_verified_at' => $current->email_verified_at ?? now(),
            ])->save();
            $current->syncRoles([$invitation->role]);
            $invitation->forceFill(['accepted_at' => now()])->save();
        });

        return redirect()->route('dashboard')->with('success', 'Akaun anda kini sebahagian daripada ' . $invitation->school->name . '.');
    }
}
