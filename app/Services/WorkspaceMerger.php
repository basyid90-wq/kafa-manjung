<?php

namespace App\Services;

use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Moves a teacher's Personal workspace into a school workspace when the teacher
 * accepts an invitation from that school. All tenant-owned rows follow the teacher;
 * the emptied personal workspace is kept as an inert record (never deleted, so a
 * table missed by this list can never be wiped by a cascade).
 */
class WorkspaceMerger
{
    /** Tables that must not be re-pointed wholesale. */
    private const SKIP_TABLES = ['users', 'schools', 'invitations', 'sessions'];

    /** A personal workspace owner (or a user without a workspace) can be merged; anyone else cannot. */
    public function canJoin(User $user): bool
    {
        if ($user->isSuperAdmin() || $user->hasRole('Ibu Bapa')) {
            return false;
        }
        if (!$user->school_id) {
            return true;
        }

        $school = $user->school;

        return $school && $school->isPersonal() && (int) $school->owner_id === (int) $user->id;
    }

    /** Students whose MyKid already exists in the target school (must be resolved before merging). */
    public function conflicts(School $from, School $to): Collection
    {
        $targetMykids = Student::withoutGlobalScope('school')->where('school_id', $to->id)->pluck('mykid');

        return Student::withoutGlobalScope('school')
            ->where('school_id', $from->id)
            ->whereIn('mykid', $targetMykids)
            ->orderBy('name')
            ->get(['id', 'name', 'mykid']);
    }

    /** Summary of what will move, for the confirmation screen. */
    public function preview(School $from): array
    {
        return [
            'classes'  => DB::table('kafa_classes')->where('school_id', $from->id)->count(),
            'students' => DB::table('students')->where('school_id', $from->id)->count(),
            'rph'      => DB::table('rph_records')->where('school_id', $from->id)->count(),
        ];
    }

    public function merge(School $from, School $to): void
    {
        if ((int) $from->id === (int) $to->id) {
            return;
        }

        DB::transaction(function () use ($from, $to) {
            foreach ($this->tenantTables() as $table) {
                DB::table($table)->where('school_id', $from->id)->update(['school_id' => $to->id]);
            }

            if (Schema::hasColumn('student_transfers', 'from_school_id')) {
                DB::table('student_transfers')->where('from_school_id', $from->id)->update(['from_school_id' => $to->id]);
            }

            $from->forceFill([
                'name'            => mb_substr($from->name . ' (digabung ke ' . $to->name . ')', 0, 255),
                'owner_id'        => null,
                'plan'            => 'free',
                'plan_expires_at' => null,
            ])->save();
        });
    }

    private function tenantTables(): array
    {
        return collect(Schema::getTables())
            ->pluck('name')
            ->reject(fn ($t) => in_array($t, self::SKIP_TABLES, true))
            ->filter(fn ($t) => Schema::hasColumn($t, 'school_id'))
            ->values()
            ->all();
    }
}
