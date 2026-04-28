<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'category',
        'content',
        'user_id',
        'school_id',
        'district_id',
        'is_global',
        'target_role',
        'target_scope',
        'is_homepage',
        'homepage_label',
        'expires_at'
    ];

    protected $casts = [
        'is_global' => 'boolean',
        'is_homepage' => 'boolean',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    // Pivot: Users yang disasarkan oleh hebahan ini
    public function targetedUsers()
    {
        return $this->belongsToMany(User::class, 'announcement_targets')
            ->withTimestamps();
    }

    // Pivot: Users yang sudah baca hebahan ini
    public function readByUsers()
    {
        return $this->belongsToMany(User::class, 'announcement_reads')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    public function scopeHomepage($query)
    {
        return $query->where('is_homepage', true)
            ->active()
            ->latest()
            ->limit(5);
    }

    public function scopeForUser($query, $user)
    {
        return $query->whereHas('targetedUsers', function($q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }

    // Helper methods
    public function isReadBy($user)
    {
        return $this->readByUsers()->where('user_id', $user->id)->exists();
    }

    public function markAsReadBy($user)
    {
        if (!$this->isReadBy($user)) {
            $this->readByUsers()->attach($user->id, ['read_at' => now()]);
        }
    }

    public function getReadCountAttribute()
    {
        return $this->readByUsers()->count();
    }

    public function getTargetCountAttribute()
    {
        return $this->targetedUsers()->count();
    }
}
