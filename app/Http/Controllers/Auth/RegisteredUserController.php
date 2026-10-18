<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

/**
 * Self-signup: every new account gets its own workspace (school row) on the Free plan.
 * The registering user owns it with role Guru Besar (shown as "Guru (Personal)" for personal workspaces).
 */
class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // Honeypot: bots fill every field
        if ($request->filled('website')) {
            return redirect()->route('register');
        }

        $request->validate([
            'account_type' => ['required', 'in:personal,sekolah'],
            'school_name'  => ['required_if:account_type,sekolah', 'nullable', 'string', 'max:255'],
            'name'         => ['required', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'email'        => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'     => ['required', 'confirmed', Rules\Password::defaults()],
            'terms'        => ['accepted'],
        ], [
            'school_name.required_if' => 'Sila masukkan nama sekolah KAFA.',
            'terms.accepted'          => 'Anda perlu bersetuju dengan Terma Perkhidmatan dan Notis Privasi.',
            'email.unique'            => 'E-mel ini sudah berdaftar. Sila log masuk.',
        ]);

        $user = DB::transaction(function () use ($request) {
            $type = $request->account_type;

            $school = new School([
                'name' => $request->school_name ?: 'Kelas ' . $request->name,
            ]);
            $school->forceFill(['type' => $type, 'plan' => 'free'])->save();

            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'password'  => Hash::make($request->password),
                'school_id' => $school->id,
            ]);
            $user->assignRole('Guru Besar');

            if ($type === 'sekolah') {
                $school->update(['nama_guru_besar' => $request->name, 'no_telefon' => $request->phone]);
            }
            $school->forceFill(['owner_id' => $user->id])->save();

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
