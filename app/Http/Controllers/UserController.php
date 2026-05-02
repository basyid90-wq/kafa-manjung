<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\District;
use App\Models\School;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $authUser  = auth()->user();
        $authRole  = $authUser->getRoleNames()->first();
        $search     = $request->input('search');
        $filterRole = $request->input('role', 'semua');

        // Base query factory — applies role-based data isolation
        $makeBase = function () use ($authUser, $authRole) {
            $q = User::with(['roles', 'district', 'school']);
            if ($authRole === 'Pentadbir') {
                $q->whereDoesntHave('roles', fn($sq) => $sq->where('name', 'Super Admin'));
            } elseif ($authRole === 'Penyelia KAFA') {
                $q->whereDoesntHave('roles', fn($sq) => $sq->whereIn('name', ['Super Admin', 'Pentadbir']));
                $q->where(fn($sq) => $sq
                    ->where('district_id', $authUser->district_id)
                    ->orWhereHas('roles', fn($sssq) => $sssq->where('name', 'Pembekal')));
            } elseif ($authRole === 'Guru Besar') {
                $q->whereDoesntHave('roles', fn($sq) => $sq->whereIn('name', ['Super Admin', 'Pentadbir', 'Penyelia KAFA']));
                $q->where('school_id', $authUser->school_id);
            }
            return $q;
        };

        // Define tabs per role
        if (in_array($authRole, ['Super Admin', 'Pentadbir'])) {
            $tabRoles = ['Pentadbir', 'Penyelia KAFA', 'Guru Besar', 'Guru KAFA', 'Pembekal', 'Ibu Bapa'];
        } elseif ($authRole === 'Penyelia KAFA') {
            $tabRoles = ['Guru Besar', 'Guru KAFA', 'Pembekal'];
        } else {
            $tabRoles = [];
        }

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

        $users = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('users.index', compact('users', 'roleCounts', 'tabRoles', 'filterRole', 'search', 'authRole'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create()
    {
        $authUser = auth()->user();
        
        // Filter roles based on auth user
        $rolesQuery = Role::where('name', '!=', 'Ibu Bapa');
        if ($authUser->hasRole('Pentadbir')) {
            $rolesQuery->where('name', '!=', 'Super Admin');
        } elseif ($authUser->hasRole('Penyelia KAFA')) {
            $rolesQuery->whereNotIn('name', ['Super Admin', 'Pentadbir']);
        } elseif ($authUser->hasRole('Guru Besar')) {
            $rolesQuery->where('name', 'Guru KAFA');
        }
        $roles = $rolesQuery->get();

        $districts = District::all();

        if ($authUser->hasRole('Penyelia KAFA')) {
            $schools = School::where('district_id', $authUser->district_id)->get();
        } else {
            $schools = School::all();
        }

        return view('users.create', compact('roles', 'districts', 'schools'));
    }

    public function store(Request $request)
    {
        $authUser = auth()->user();

        // Data Isolation Logic
        if ($authUser->hasRole('Guru Besar')) {
            // Guru Besar: Force School/District and Role
            $request->merge([
                'school_id' => $authUser->school_id,
                'district_id' => $authUser->district_id ?? $authUser->school?->district_id,
                'roles' => ['Guru KAFA']
            ]);
        } elseif ($authUser->hasRole('Penyelia KAFA')) {
            // Penyelia KAFA: Force District
            $request->merge(['district_id' => $authUser->district_id]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'district_id' => 'nullable|exists:districts,id',
            'school_id' => 'nullable|exists:schools,id',
        ]);

        // Security Check: Authorized roles only
        $allowedRolesQuery = Role::where('name', '!=', 'Ibu Bapa');
        if ($authUser->hasRole('Pentadbir')) {
            $allowedRolesQuery->where('name', '!=', 'Super Admin');
        } elseif ($authUser->hasRole('Penyelia KAFA')) {
            $allowedRolesQuery->whereNotIn('name', ['Super Admin', 'Pentadbir']);
        } elseif ($authUser->hasRole('Guru Besar')) {
            $allowedRolesQuery->where('name', 'Guru KAFA');
        }
        $allowedRoles = $allowedRolesQuery->pluck('name')->toArray();

        foreach ($validated['roles'] as $role) {
            if (!in_array($role, $allowedRoles)) {
                abort(403, 'Anda tidak dibenarkan memberikan peranan ' . $role);
            }
        }

        // Penyelia KAFA can only assign users to schools in their district
        if ($authUser->hasRole('Penyelia KAFA') && $validated['school_id']) {
            $schoolInDistrict = School::where('id', $validated['school_id'])
                ->where('district_id', $authUser->district_id)->exists();
            if (!$schoolInDistrict) abort(403);
        }

        $newUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'district_id' => $validated['district_id'] ?? null,
            'school_id' => $validated['school_id'] ?? null,
        ]);

        $newUser->syncRoles($validated['roles']);

        return redirect()->route('users.index')->with('success', 'Pengguna berjaya ditambah.');
    }

    public function edit(User $user)
    {
        $authUser = auth()->user();

        // Penyelia KAFA can only edit users in their district
        if ($authUser->hasRole('Penyelia KAFA') && $user->district_id !== $authUser->district_id) {
            abort(403);
        }

        // Filter roles based on auth user
        $rolesQuery = Role::where('name', '!=', 'Ibu Bapa');
        if ($authUser->hasRole('Pentadbir')) {
            $rolesQuery->where('name', '!=', 'Super Admin');
        } elseif ($authUser->hasRole('Penyelia KAFA')) {
            $rolesQuery->whereNotIn('name', ['Super Admin', 'Pentadbir']);
        } elseif ($authUser->hasRole('Guru Besar')) {
            $rolesQuery->where('name', 'Guru KAFA');
        }
        $roles = $rolesQuery->get();

        $userRoles = $user->roles->pluck('name')->toArray();
        $districts = District::all();

        if ($authUser->hasRole('Penyelia KAFA')) {
            $schools = School::where('district_id', $authUser->district_id)->get();
        } else {
            $schools = School::all();
        }

        return view('users.edit', compact('user', 'roles', 'userRoles', 'districts', 'schools'));
    }

    public function update(Request $request, User $user)
    {
        $authUser = auth()->user();

        // Penyelia KAFA can only update users in their district
        if ($authUser->hasRole('Penyelia KAFA') && $user->district_id !== $authUser->district_id) {
            abort(403);
        }

        // Data Isolation Logic
        if ($authUser->hasRole('Guru Besar')) {
            // Guru Besar: Force School/District and Role
            $request->merge([
                'school_id' => $authUser->school_id,
                'district_id' => $authUser->district_id ?? $authUser->school?->district_id,
                'roles' => ['Guru KAFA']
            ]);
        } elseif ($authUser->hasRole('Penyelia KAFA')) {
            // Penyelia KAFA: Force District
            $request->merge(['district_id' => $authUser->district_id]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'roles' => 'required|array',
            'district_id' => 'nullable|exists:districts,id',
            'school_id' => 'nullable|exists:schools,id',
        ]);

        // Security Check: Authorized roles only
        $allowedRolesQuery = Role::where('name', '!=', 'Ibu Bapa');
        if ($authUser->hasRole('Pentadbir')) {
            $allowedRolesQuery->where('name', '!=', 'Super Admin');
        } elseif ($authUser->hasRole('Penyelia KAFA')) {
            $allowedRolesQuery->whereNotIn('name', ['Super Admin', 'Pentadbir']);
        } elseif ($authUser->hasRole('Guru Besar')) {
            $allowedRolesQuery->where('name', 'Guru KAFA');
        }
        $allowedRoles = $allowedRolesQuery->pluck('name')->toArray();

        foreach ($validated['roles'] as $role) {
            if (!in_array($role, $allowedRoles)) {
                abort(403, 'Anda tidak dibenarkan memberikan peranan ' . $role);
            }
        }

        // Penyelia KAFA can only assign users to schools in their district
        if ($authUser->hasRole('Penyelia KAFA') && $validated['school_id']) {
            $schoolInDistrict = School::where('id', $validated['school_id'])
                ->where('district_id', $authUser->district_id)->exists();
            if (!$schoolInDistrict) abort(403);
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'district_id' => $validated['district_id'] ?? null,
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

        // Penyelia KAFA can only delete users in their district
        if ($authUser->hasRole('Penyelia KAFA') && $user->district_id !== $authUser->district_id) {
            abort(403);
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berjaya dipadam.');
    }
}
