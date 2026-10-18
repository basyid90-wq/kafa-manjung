<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    // type, plan, plan_expires_at and owner_id are deliberately NOT fillable:
    // they change only through the Super Admin plan editor or the billing flow (forceFill).
    protected $fillable = [
        'name',
        'code',
        'jenis_premis',
        'nama_guru_besar',
        'no_telefon',
        'alamat',
        'logo',
        'attendance_cutoff_time',
    ];

    protected $casts = [
        'plan_expires_at' => 'datetime',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function kafaClasses()
    {
        return $this->hasMany(KafaClass::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function achievementRecords()
    {
        return $this->hasMany(StudentAchievementRecord::class);
    }

    // ── Subscription plan ────────────────────────────────────────────────────

    public static function planConfig(string $plan): array
    {
        return config("plans.plans.{$plan}") ?? config('plans.plans.free');
    }

    public static function moduleMinPlan(string $module): string
    {
        return config("plans.modules.{$module}.plan") ?? 'sekolah';
    }

    public function isPersonal(): bool
    {
        return $this->type === 'personal';
    }

    /** Paid plan still counts during the grace period after expiry; otherwise it falls back to free. */
    public function effectivePlan(): string
    {
        $plan = $this->plan ?: 'free';

        if ($plan !== 'free' && $this->plan_expires_at
            && $this->plan_expires_at->copy()->addDays(config('plans.grace_days', 0))->isPast()) {
            return 'free';
        }

        return $plan;
    }

    public function planLabel(): string
    {
        return self::planConfig($this->effectivePlan())['label'];
    }

    public function isPlanExpired(): bool
    {
        return $this->plan !== 'free' && $this->effectivePlan() === 'free';
    }

    public function allows(string $module): bool
    {
        $minRank = self::planConfig(self::moduleMinPlan($module))['rank'];

        return self::planConfig($this->effectivePlan())['rank'] >= $minRank;
    }

    /** Plan limit (null = unlimited). */
    public function limit(string $key): ?int
    {
        return self::planConfig($this->effectivePlan())[$key] ?? null;
    }

    public function classCount(): int
    {
        return KafaClass::withoutGlobalScope('school')->where('school_id', $this->id)->count();
    }

    public function canAddClass(): bool
    {
        $max = $this->limit('max_classes');

        return $max === null || $this->classCount() < $max;
    }

    /** Free places left in a class under the plan (null = unlimited). */
    public function studentPlacesLeft(?int $classId, ?int $ignoreStudentId = null): ?int
    {
        $max = $this->limit('max_students_per_class');
        if ($max === null || !$classId) {
            return null;
        }

        $used = Student::withoutGlobalScope('school')
            ->where('school_id', $this->id)
            ->where('kafa_class_id', $classId)
            ->whereNotIn('status', ['Berhenti', 'Pindah'])
            ->when($ignoreStudentId, fn ($q) => $q->where('id', '!=', $ignoreStudentId))
            ->count();

        return max(0, $max - $used);
    }

    /** Schools whose current plan includes the module (used for parent-portal access). */
    public function scopeWithModule(Builder $query, string $module): Builder
    {
        $minRank = self::planConfig(self::moduleMinPlan($module))['rank'];
        $plans = collect(config('plans.plans'))
            ->filter(fn ($p) => $p['rank'] >= $minRank)
            ->keys()
            ->all();

        return $query->whereIn('plan', $plans)->where(function ($q) {
            $q->where('plan', 'free')
              ->orWhereNull('plan_expires_at')
              ->orWhere('plan_expires_at', '>', now()->subDays(config('plans.grace_days', 0)));
        });
    }
}
