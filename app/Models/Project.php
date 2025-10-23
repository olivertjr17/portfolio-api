<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'tech_stack',
        'demo_link',
        'github_link',
        'image',
        'is_featured',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Accessor for full image URL (optional but nice for frontend).
     */
    protected $appends = ['image_url'];
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-project.png'); // fallback image
        }

        // If image is already a full URL, just return it
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Otherwise, prepend storage path
        return asset('storage/' . $this->image);
    }
}
