<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use BelongsToSchool;

    public const VALID_DAYS = 7;

    protected $fillable = ['school_id', 'invited_by', 'name', 'email', 'role', 'expires_at'];

    protected $casts = [
        'expires_at'  => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    /** Create a pending invite and return [invitation, raw token]; only the hash is stored. */
    public static function issue(array $attributes): array
    {
        $token = Str::random(48);

        $invitation = new static($attributes + ['expires_at' => now()->addDays(self::VALID_DAYS)]);
        $invitation->token_hash = hash('sha256', $token);
        $invitation->save();

        return [$invitation, $token];
    }

    /** Look up a pending invite by raw token (bypasses the tenant scope: the invitee is not logged in yet). */
    public static function findPendingByToken(string $token): ?self
    {
        return static::withoutGlobalScope('school')
            ->where('token_hash', hash('sha256', $token))
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->first();
    }

    public function isPending(): bool
    {
        return $this->accepted_at === null && $this->expires_at->isFuture();
    }
}
