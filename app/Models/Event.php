<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'cover_image',
        'location', 'address', 'starts_at', 'ends_at',
        'max_participants', 'status', 'created_by',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Event $event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'event_registrations')
            ->withPivot('status', 'registered_at')
            ->withTimestamps();
    }

    public function isFull(): bool
    {
        if (is_null($this->max_participants)) {
            return false;
        }
        return $this->registrations()->where('status', 'registered')->count() >= $this->max_participants;
    }

    public function isUpcoming(): bool
    {
        return $this->starts_at->isFuture();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('starts_at', '>', now())->orderBy('starts_at');
    }
}
