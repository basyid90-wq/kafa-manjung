<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\School;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /** Roles each actor may assign. Ibu Bapa accounts are created via the student/parent flow. */
    private function assignableRoles(User $authUser): array
    {
        return $authUser->hasRole('Super Admin')
            ? ['Super Admin', 'Guru Besar', 'Guru KAFA']
            : ['Guru KAFA'];
    }

    /** Guru Besar may only manage Guru KAFA / Ibu Bapa accounts in their own school. */
    private function authorizeManage(User $authUser, User $target): void
    {
        if ($authUser->hasRole('Super Admin')) {
            return;
        }

        if ($target->school_id !== $authUser->school_id
            || $target->hasAnyRole(['Super Admin', 'Guru Besar'])) {
            abort(403);
        }
    }

    public function index(Request $request)
    {
        $authUser  = auth()->user();
        $authRole  = $authUser->getRoleNames()->first();
        $search     = $request->input('search');
        $filterRole = $request->input('role', 'semua');

        // Base query factory — applies role-based data isolation
        $makeBase = function () use ($authUser) {
            $q = User::with(['roles', 'school']);
            if (!$authUser->hasRole('Super Admin')) {
                $q->whereDoesntHave('roles', fn($sq) => $sq->where('name', 'Super Admin'));
                $q->where('school_id', $authUser->school_id);
            }
            return $q;
        };

        $tabRoles = $authUser->hasRole('Super Admin')
            ? ['Guru Besar', 'Guru KAFA', 'Ibu Bapa']
            : ['Guru KAFA', 'Ibu Bapa'];

        // Count per tab (for badges)
        $roleCounts = ['semua' => $makeBase()->count()];
        foreach ($tabRoles as $tabRole) {
            $roleCounts[$tabRole] = $makeBase()
                ->whereHas('roles', fn($q) => $q->where('name', $tabRole))
                ->count();
        }

        // Apply filters on top of base
        $query = $makeBase();
        if ($filterRole !== 'semua') {
            $query->whereHas('roles', fn($q) => $q->where('name', $filterRole));
        }
        if ($search) {
            $query->where(fn($q) => $q
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%'));
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString();

        $invitations = $authUser->school_id
            ? \App\Models\Invitation::where('school_id', $authUser->school_id)->whereNull('accepted_at')->latest()->get()
            : collect();

        return view('users.index', compact('users', 'roleCounts', 'tabRoles', 'filterRole', 'search', 'authRole', 'invitations'));
    }

    public function show(User $user)
    {
        $this->authorizeManage(auth()->user(), $user);

        return view('users.show', compact('user'));
    }

    public function create()
    {
        $authUser = auth()->user();

        $roles   = Role::whereIn('name', $this->assignableRoles($authUser))->get();
        $schools = $authUser->hasRole('Super Admin')
            ? School::orderBy('name')->get()
            : School::where('id', $authUser->school_id)->get();

        return view('users.create', compact('roles', 'schools'));
    }

    public function store(Request $request)
    {
        $authUser = auth()->user();

        if (!$authUser->hasRole('Super Admin')) {
            $request->merge([
                'school_id' => $authUser->school_id,
                'roles'     => ['Guru KAFA'],
            ]);
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'roles'     => 'required|array',
            'roles.*'   => 'in:' . implode(',', $this->assignableRoles($authUser)),
            'school_id' => 'nullable|exists:schools,id',
        ]);

        $newUser = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'school_id' => $validated['school_id'] ?? null,
        ]);
        // Created by an admin who vouches for the address; no self-verification needed
        $newUser->forceFill(['email_verified_at' => now()])->save();

        $newUser->syncRoles($validated['roles']);

        return redirect()->route('users.index')->with('success', 'Pengguna berjaya ditambah.');
    }

    public function edit(User $user)
    {
        $authUser = auth()->user();
        $this->authorizeManage($authUser, $user);

        $roles     = Role::whereIn('name', $this->assignableRoles($authUser))->get();
        $userRoles = $user->roles->pluck('name')->toArray();
        $schools   = $authUser->hasRole('Super Admin')
            ? School::orderBy('name')->get()
            : School::where('id', $authUser->school_id)->get();

        return view('users.edit', compact('user', 'roles', 'userRoles', 'schools'));
    }

    public function update(Request $request, User $user)
    {
        $authUser = auth()->user();
        $this->authorizeManage($authUser, $user);

        if (!$authUser->hasRole('Super Admin')) {
            $request->merge([
                'school_id' => $authUser->school_id,
                'roles'     => ['Guru KAFA'],
            ]);
        }

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'roles'     => 'required|array',
            'roles.*'   => 'in:' . implode(',', $this->assignableRoles($authUser)),
            'school_id' => 'nullable|exists:schools,id',
            'password'  => 'nullable|string|min:8',
        ]);

        $user->update([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'school_id' => $validated['school_id'] ?? null,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles($validated['roles']);

        return redirect()->route('users.index')->with('success', 'Pengguna berjaya dikemaskini.');
    }

    public function destroy(User $user)
    {
        $authUser = auth()->user();
        $this->authorizeManage($authUser, $user);

        if ($user->id === $authUser->id) {
            return back()->with('error', 'Anda tidak boleh memadam akaun sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berjaya dipadam.');
    }
}
