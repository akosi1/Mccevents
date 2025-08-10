<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, Relations\HasMany, Relations\BelongsToMany};

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'date', 'location', 'status', 
        'department', 'repeat_type', 'repeat_interval', 'repeat_until',
        'parent_event_id', 'cancel_reason', 'image',
    ];

    protected $casts = [
        'date' => 'datetime',
        'repeat_until' => 'datetime',
    ];

    public function hasImage(): bool
    {
        return !empty($this->image);
    }

    public function joins(): HasMany
    {
        return $this->hasMany(EventJoin::class);
    }

    public function joinedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_joins')
                    ->withTimestamps()
                    ->withPivot('joined_at');
    }

    public function isJoinedByUser($userId): bool
    {
        return $this->joins()->where('user_id', $userId)->exists();
    }

    public function getJoinedCountAttribute(): int
    {
        return $this->joins()->count();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now());
    }
}