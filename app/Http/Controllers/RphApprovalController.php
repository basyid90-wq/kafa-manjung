<?php

namespace App\Http\Controllers;

use App\Models\RphRecord;
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

        if ($user->hasRole('Guru Besar') && !$user->isSuperAdmin()) {
            // Guru Besar: semak RPH yang dihantar oleh Guru KAFA dalam sekolah yang sama
            $base->where('school_id', $user->school_id)
                 ->whereHas('user', fn($q) => $q->whereHas('roles', fn($r) => $r->where('name', 'Guru KAFA')));
        } elseif (!$user->isSuperAdmin()) {
            $base->whereRaw('0 = 1'); // role lain tiada akses
        }

        $records = $base->paginate(10);

        return view('rph_approvals.index', compact('records'));
    }

    public function update(Request $request, RphRecord $rph)
    {
        $user = auth()->user();

        if (!$user->isSuperAdmin()) {
            $this->authorizeSchool($rph->school_id);
            // Guru Besar hanya boleh semak RPH dari Guru KAFA
            $submitter = User::find($rph->user_id);
            if (!$submitter || !$submitter->hasRole('Guru KAFA')) abort(403);
        }

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

        if (!$user->isSuperAdmin()) {
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

        $this->authorizeSchool($rph->school_id);
        if (!$user->isSuperAdmin() && $user->id !== $rph->reviewer_id) {
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
