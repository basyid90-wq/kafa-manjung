<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'ic_number',
        'phone',
        'password',
        'school_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('Super Admin');
    }

    /** Tenant check: Super Admin sees every school, everyone else only their own. */
    public function canAccessSchool($schoolId): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $schoolId !== null && $this->school_id !== null && (int) $schoolId === (int) $this->school_id;
    }

    /** Guru KAFA (not also Guru Besar / Super Admin): student data limited to the classes they teach. */
    public function isClassScoped(): bool
    {
        return $this->hasRole('Guru KAFA') && !$this->hasAnyRole(['Super Admin', 'Guru Besar']);
    }

    /** Whether the user may access a student record (school tenant + own class for Guru KAFA). */
    public function canAccessStudent(Student $student): bool
    {
        if (!$this->canAccessSchool($student->school_id)) {
            return false;
        }

        return !$this->isClassScoped()
            || KafaClass::whereKey($student->kafa_class_id)->where('teacher_id', $this->id)->exists();
    }

    /** Whether the user's workspace plan includes a module (Super Admin: always). */
    public function canUse(string $module): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->hasRole('Ibu Bapa') && !$this->hasAnyRole(['Guru Besar', 'Guru KAFA'])) {
            return $this->hasPortalChildren();
        }

        return (bool) $this->school?->allows($module);
    }

    /** Parent portal is open only for children enrolled in a school whose plan includes it. */
    public function hasPortalChildren(): bool
    {
        $ic = preg_replace('/[^0-9]/', '', $this->ic_number ?? '');

        return Student::query()
            ->where(function ($q) use ($ic) {
                $q->where('parent_id', $this->id);
                if ($ic) {
                    $q->orWhere('father_ic', $ic)->orWhere('mother_ic', $ic);
                }
            })
            ->whereHas('school', fn ($q) => $q->withModule('portal_ibu_bapa'))
            ->exists();
    }

    /** Role name as shown in the UI; the owner of a personal workspace is a teacher, not a headmaster. */
    public function roleLabel(): string
    {
        $role = $this->getRoleNames()->first() ?? '';

        if ($role === 'Guru Besar' && $this->school?->isPersonal()) {
            return 'Guru (Personal)';
        }

        return $role;
    }
}
