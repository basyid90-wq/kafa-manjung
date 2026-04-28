<?php

namespace App\Http\Controllers;

use App\Models\RphRecord;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class RphApprovalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $base = RphRecord::where('status', 'pending')
            ->with(['user', 'kafaClass', 'school', 'periods.kafaClass'])
            ->orderBy('date', 'asc');

        if ($user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            // Super Admin: semua pending
            // Pentadbir: hanya sekolah sendiri jika ada school_id
            if ($user->hasRole('Pentadbir') && $user->school_id) {
                $base->where('school_id', $user->school_id);
            }
        } elseif ($user->hasRole('Penyelia KAFA')) {
            // Penyelia KAFA: semak RPH yang dihantar oleh Guru Besar
            // dalam sekolah-sekolah di bawah daerah seliaannya
            $base->whereHas('school', fn($q) => $q->where('district_id', $user->district_id))
                 ->whereHas('user', fn($q) => $q->whereHas('roles', fn($r) => $r->where('name', 'Guru Besar')));
        } elseif ($user->hasRole('Guru Besar')) {
            // Guru Besar: semak RPH yang dihantar oleh Guru KAFA dalam sekolah yang sama
            $base->where('school_id', $user->school_id)
                 ->whereHas('user', fn($q) => $q->whereHas('roles', fn($r) => $r->where('name', 'Guru KAFA')));
        } else {
            $base->whereRaw('0 = 1'); // role lain tiada akses
        }

        $records = $base->paginate(10);

        return view('rph_approvals.index', compact('records'));
    }

    public function update(Request $request, RphRecord $rph)
    {
        $user = auth()->user();

        if ($user->hasRole('Penyelia KAFA')) {
            $schoolInDistrict = School::where('id', $rph->school_id)
                ->where('district_id', $user->district_id)->exists();
            if (!$schoolInDistrict) abort(403);
            // Penyelia hanya boleh semak RPH dari Guru Besar
            $submitter = User::find($rph->user_id);
            if (!$submitter || !$submitter->hasRole('Guru Besar')) abort(403);
        } elseif ($user->hasRole('Guru Besar')) {
            if ($rph->school_id !== $user->school_id) abort(403);
            // Guru Besar hanya boleh semak RPH dari Guru KAFA
            $submitter = User::find($rph->user_id);
            if (!$submitter || !$submitter->hasRole('Guru KAFA')) abort(403);
        } elseif ($user->hasRole('Pentadbir') && $user->school_id) {
            if ($rph->school_id !== $user->school_id) abort(403);
        }
        // Super Admin: tiada sekatan

        $request->validate([
            'status'         => 'required|in:approved,rejected,revision_needed',
            'review_comment' => 'nullable|string',
        ]);

        $rph->update([
            'status'         => $request->status,
            'review_comment' => $request->review_comment,
            'reviewer_id'    => auth()->id(),
        ]);

        $msg = $request->status === 'approved'
            ? 'RPH berjaya diluluskan.'
            : 'RPH telah direkod dan dikembalikan kepada guru.';

        return redirect()->route('rph_approvals.index')->with('success', $msg);
    }

    public function history(Request $request)
    {
        $user  = auth()->user();
        $query = RphRecord::where('status', '!=', 'pending')
            ->with(['user', 'school', 'reviewer', 'kafaClass']);

        if ($user->hasRole('Penyelia KAFA')) {
            $query->whereHas('school', fn($q) => $q->where('district_id', $user->district_id));
        } elseif ($user->hasRole('Guru Besar')) {
            $query->where('school_id', $user->school_id);
        } elseif ($user->hasRole('Pentadbir') && $user->school_id) {
            $query->where('school_id', $user->school_id);
        }

        if ($request->search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }

        $records = $query->orderBy('updated_at', 'desc')->paginate(10);

        return view('rph_approvals.history', compact('records'));
    }

    public function revert(RphRecord $rph)
    {
        $user = auth()->user();

        if (!$user->hasRole('Super Admin') && $user->id !== $rph->reviewer_id) {
            abort(403, 'Anda hanya boleh membatalkan RPH yang anda luluskan sendiri.');
        }

        $rph->update([
            'status'         => 'pending',
            'reviewer_id'    => null,
            'review_comment' => null,
        ]);

        return redirect()->route('rph_approvals.history')
            ->with('success', 'Kelulusan RPH telah dibatalkan dan dikembalikan ke senarai menunggu.');
    }
}
