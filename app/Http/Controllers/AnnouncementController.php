<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use App\Models\School;
use App\Models\District;
use App\Notifications\NewAnnouncementNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Filter announcements for this user based on targeting
        $query = Announcement::query();

        // Super Admin sees ALL announcements (including homepage)
        if ($user->hasRole('Super Admin')) {
            $query->with(['user', 'school', 'district']);
        } else {
            // Other users only see targeted announcements (exclude homepage)
            $query->forUser($user)
                ->where('is_homepage', false)
                ->with(['user', 'school', 'district']);
        }

        $announcements = $query->latest()->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    public function show(Announcement $announcement)
    {
        $user = Auth::user();

        // Homepage announcements cannot be viewed individually (public only)
        if ($announcement->is_homepage) {
            abort(404, 'Hebahan homepage tidak boleh dilihat secara individu.');
        }

        // Check if user is targeted
        if (!$announcement->targetedUsers()->where('user_id', $user->id)->exists()) {
            abort(403, 'Anda tidak mempunyai akses kepada hebahan ini.');
        }

        // Mark as read
        $announcement->markAsReadBy($user);

        return view('announcements.show', compact('announcement'));
    }

    public function create()
    {
        $user = Auth::user();

        // Check role permission
        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir', 'Penyelia KAFA', 'Guru Besar', 'Pembekal'])) {
            abort(403);
        }

        // Get available options based on role
        $districts = [];
        $schools = [];

        if ($user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            $districts = District::all();
            $schools = School::with('district')->get();
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $schools = School::where('district_id', $user->district_id)->get();
        } elseif ($user->hasRole('Guru Besar')) {
            // Guru Besar only sees their school
            $schools = School::where('id', $user->school_id)->get();
        } elseif ($user->hasRole('Pembekal')) {
            // Pembekal can see schools that have ordered from them
            $schools = School::whereHas('bookOrders', function($q) use ($user) {
                $q->whereHas('items', function($q2) use ($user) {
                    $q2->whereHas('book', function($q3) use ($user) {
                        $q3->where('supplier_id', $user->id);
                    });
                });
            })->get();
        }

        return view('announcements.create', compact('districts', 'schools'));
    }

    public function createHomepage()
    {
        // Only Super Admin can create homepage announcements
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403);
        }

        return view('announcements.create-homepage');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'content' => 'required|string',
            'target_role' => 'required|string',
            'target_scope' => 'required|in:all,district,school,specific',
            'district_ids' => 'nullable|array',
            'district_ids.*' => 'exists:districts,id',
            'school_ids' => 'nullable|array',
            'school_ids.*' => 'exists:schools,id',
        ]);

        DB::beginTransaction();
        try {
            // Create announcement
            $announcement = Announcement::create([
                'title' => $request->title,
                'category' => $request->category,
                'content' => $request->content,
                'user_id' => $user->id,
                'school_id' => $user->school_id,
                'district_id' => $user->district_id,
                'is_global' => false,
                'target_role' => $request->target_role,
                'target_scope' => $request->target_scope,
                'is_homepage' => false,
            ]);

            // Get targeted users based on role and scope
            $targetUsers = $this->getTargetedUsers($request, $user);

            // Attach targeted users to pivot table
            $announcement->targetedUsers()->attach($targetUsers->pluck('id'));

            // Send notifications
            Notification::send($targetUsers, new NewAnnouncementNotification($announcement));

            DB::commit();
            return redirect()->route('announcements.index')->with('success', 'Hebahan berjaya diterbitkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menerbitkan hebahan: ' . $e->getMessage());
        }
    }

    public function storeHomepage(Request $request)
    {
        // Only Super Admin
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'homepage_label' => 'required|in:Ciri Baharu,Pembaikan,Penyelenggaraan,Kritikal,Pengumuman',
            'expires_at' => 'required|date|after:now',
        ]);

        DB::beginTransaction();
        try {
            // Create homepage announcement
            $announcement = Announcement::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => Auth::id(),
                'is_global' => true,
                'is_homepage' => true,
                'homepage_label' => $request->homepage_label,
                'expires_at' => $request->expires_at,
                'target_role' => 'Public',
                'target_scope' => 'all',
            ]);

            // Homepage announcements don't need targeting or notifications
            // They are public on login page

            DB::commit();
            return redirect()->route('announcements.index')->with('success', 'Hebahan homepage berjaya diterbitkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menerbitkan hebahan: ' . $e->getMessage());
        }
    }

    public function editHomepage(Announcement $announcement)
    {
        // Only Super Admin can edit homepage announcements
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403);
        }

        // Must be a homepage announcement
        if (!$announcement->is_homepage) {
            abort(404, 'Hebahan ini bukan hebahan homepage.');
        }

        return view('announcements.edit-homepage', compact('announcement'));
    }

    public function updateHomepage(Request $request, Announcement $announcement)
    {
        // Only Super Admin
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403);
        }

        // Must be a homepage announcement
        if (!$announcement->is_homepage) {
            abort(404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'homepage_label' => 'required|in:Ciri Baharu,Pembaikan,Penyelenggaraan,Kritikal,Pengumuman',
            'expires_at' => 'required|date|after:now',
        ]);

        DB::beginTransaction();
        try {
            $announcement->update([
                'title' => $request->title,
                'content' => $request->content,
                'homepage_label' => $request->homepage_label,
                'expires_at' => $request->expires_at,
            ]);

            DB::commit();
            return redirect()->route('announcements.index')->with('success', 'Hebahan homepage berjaya dikemaskini.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal mengemaskini hebahan: ' . $e->getMessage());
        }
    }

    public function incrementView(Announcement $announcement)
    {
        // Increment view count for homepage announcements
        if ($announcement->is_homepage) {
            $announcement->incrementViewCount();
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Announcement $announcement)
    {
        if (Auth::id() !== $announcement->user_id && !Auth::user()->hasRole('Super Admin')) {
            abort(403);
        }

        $announcement->delete();
        return back()->with('success', 'Hebahan berjaya dipadam.');
    }

    // Helper method to get targeted users
    private function getTargetedUsers(Request $request, $user)
    {
        $query = User::query();

        // Exclude Ibu Bapa role
        $query->whereDoesntHave('roles', function($q) {
            $q->where('name', 'Ibu Bapa');
        });

        // Filter by target role
        if ($request->target_role !== 'Semua') {
            $query->role($request->target_role);
        }

        // Filter by scope
        switch ($request->target_scope) {
            case 'all':
                // All users with that role (already filtered above)
                break;

            case 'district':
                if ($request->has('district_ids') && !empty($request->district_ids)) {
                    $query->whereIn('district_id', $request->district_ids);
                } else {
                    // Default to user's district if not specified
                    $query->where('district_id', $user->district_id);
                }
                break;

            case 'school':
                if ($request->has('school_ids') && !empty($request->school_ids)) {
                    $query->whereIn('school_id', $request->school_ids);
                } else {
                    // Default to user's school if not specified
                    $query->where('school_id', $user->school_id);
                }
                break;

            case 'specific':
                // Specific users (can be extended later)
                if ($request->has('school_ids') && !empty($request->school_ids)) {
                    $query->whereIn('school_id', $request->school_ids);
                }
                break;
        }

        return $query->get();
    }
}
