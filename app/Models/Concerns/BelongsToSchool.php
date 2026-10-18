<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

/**
 * Tenant isolation for school-owned records.
 *
 * For Guru Besar / Guru KAFA every query (including route-model binding) is
 * limited to the user's own school, and new records default to that school.
 * Super Admin, Ibu Bapa, guests, console and queued jobs are not scoped.
 *
 * Models where school_id NULL means "shared by every tenant" (e.g. default
 * subjects, platform announcements) set: protected bool $sharedWhenSchoolIsNull = true;
 */
trait BelongsToSchool
{
    public static function bootBelongsToSchool(): void
    {
        static::addGlobalScope('school', function (Builder $builder) {
            $schoolId = static::tenantSchoolId();
            if ($schoolId === false) {
                return;
            }

            $model  = $builder->getModel();
            $column = $model->qualifyColumn('school_id');

            // where(col, null) would turn into IS NULL — a user without a school must see nothing.
            if ($schoolId === null) {
                $builder->whereRaw('1 = 0');
                return;
            }

            if ($model->sharedWhenSchoolIsNull ?? false) {
                $builder->where(fn ($q) => $q->where($column, $schoolId)->orWhereNull($column));
            } else {
                $builder->where($column, $schoolId);
            }
        });

        static::creating(function ($model) {
            $schoolId = static::tenantSchoolId();
            if ($schoolId !== false && empty($model->school_id) && !($model->sharedWhenSchoolIsNull ?? false)) {
                $model->school_id = $schoolId;
            }
        });
    }

    /** School id to scope by, or false when the current context is not tenant-scoped. */
    protected static function tenantSchoolId(): int|null|false
    {
        if (!auth()->hasUser()) {
            return false;
        }

        $user = auth()->user();
        if (!$user->hasAnyRole(['Guru Besar', 'Guru KAFA']) || $user->isSuperAdmin()) {
            return false;
        }

        return $user->school_id;
    }
}
