<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'department',
        'status',
        'image', // Make sure this is in fillable
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Define departments constant
    const DEPARTMENTS = [
        'IT' => 'Information Technology',
        'HR' => 'Human Resources',
        'FIN' => 'Finance',
        'MKT' => 'Marketing',
        'OPS' => 'Operations',
        'ADM' => 'Administration',
    ];

    /**
     * Check if event has an image
     */
    public function hasImage()
    {
        return !empty($this->image) && Storage::disk('public')->exists($this->image);
    }

    /**
     * Get the full URL for the event image
     */
    public function getImageUrlAttribute()
    {
        if ($this->hasImage()) {
            return Storage::disk('public')->url($this->image);
        }
        
        return null;
    }

    /**
     * Alternative method to get image URL
     */
    public function getImageAttribute($value)
    {
        if ($value) {
            // If it's already a full URL, return as is
            if (filter_var($value, FILTER_VALIDATE_URL)) {
                return $value;
            }
            
            // If it's a relative path, convert to full URL
            return Storage::disk('public')->url($value);
        }
        
        return null;
    }
}