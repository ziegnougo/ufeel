<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'content', 'type',
        'organization', 'location', 'deadline',
        'external_url', 'cover_image', 'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (Opportunity $opportunity) {
            if (empty($opportunity->slug)) {
                $opportunity->slug = Str::slug($opportunity->title);
            }
        });
    }

    public function isExpired(): bool
    {
        return $this->deadline && $this->deadline->isPast();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeActive($query)
    {
        return $query->published()
            ->where(fn($q) => $q->whereNull('deadline')->orWhere('deadline', '>=', today()));
    }
}
