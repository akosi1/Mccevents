<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model, Relations\HasMany, Relations\BelongsToMany, Relations\BelongsTo};

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'date', 'start_time', 'end_time', 'location', 'status', 
        'department', 'is_exclusive', 'allowed_departments', 'is_recurring', 
        'recurrence_pattern', 'recurrence_interval', 'recurrence_end_date', 
        'recurrence_count', 'repeat_type', 'repeat_interval', 'repeat_until',
        'parent_event_id', 'cancel_reason', 'image',
    ];

    protected $casts = [
        'date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'repeat_until' => 'datetime',
        'recurrence_end_date' => 'datetime',
        'is_exclusive' => 'boolean',
        'is_recurring' => 'boolean',
        'allowed_departments' => 'array',
    ];

    // Department constants
    const DEPARTMENTS = [
        'BSIT' => 'Bachelor of Science in Information Technology',
        'BSBA' => 'Bachelor of Science in Business Administration',
        'BSED' => 'Bachelor of Science in Education',
        'BEED' => 'Bachelor of Elementary Education',
        'BSHM' => 'Bachelor of Science in Hospitality Management'
    ];

    // Recurrence pattern constants
    const RECURRENCE_PATTERNS = [
        'daily' => 'Daily',
        'weekly' => 'Weekly',
        'monthly' => 'Monthly',
        'yearly' => 'Yearly',
        'weekdays' => 'Weekdays Only',
        'custom' => 'Custom'
    ];

    public function hasImage(): bool
    {
        return !empty($this->image);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->hasImage()) {
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            return asset('storage/' . $this->image);
        }
        return asset('images/default-event.jpg');
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

    public function parentEvent(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'parent_event_id');
    }

    public function childEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'parent_event_id');
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

    public function scopeForDepartment($query, $department)
    {
        return $query->where(function ($q) use ($department) {
            $q->where('is_exclusive', false)
              ->orWhere('department', $department)
              ->orWhereJsonContains('allowed_departments', $department);
        });
    }

    public function isAvailableForDepartment($department): bool
    {
        if (!$this->is_exclusive) {
            return true; // Open to all departments
        }

        if ($this->department === $department) {
            return true; // Matches primary department
        }

        if ($this->allowed_departments && in_array($department, $this->allowed_departments)) {
            return true; // In allowed departments list
        }

        return false;
    }

    public function getDepartmentDisplayAttribute(): string
    {
        if (!$this->is_exclusive) {
            return 'All Departments';
        }

        $departments = [];
        
        if ($this->department) {
            $departments[] = $this->department;
        }

        if ($this->allowed_departments) {
            $departments = array_merge($departments, $this->allowed_departments);
        }

        return implode(', ', array_unique($departments));
    }

    public function isRecurring(): bool
    {
        return $this->is_recurring && !empty($this->recurrence_pattern);
    }

    public function isChildEvent(): bool
    {
        return !is_null($this->parent_event_id);
    }

    public function getRecurrenceDisplayAttribute(): string
    {
        if (!$this->isRecurring()) {
            return 'One-time event';
        }

        $pattern = self::RECURRENCE_PATTERNS[$this->recurrence_pattern] ?? $this->recurrence_pattern;
        $interval = $this->recurrence_interval > 1 ? " (Every {$this->recurrence_interval})" : '';
        
        return $pattern . $interval;
    }
}