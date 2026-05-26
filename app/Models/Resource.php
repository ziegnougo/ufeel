<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'type',
        'file_url', 'external_url', 'thumbnail',
        'is_public', 'status',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function getDownloadUrl(): ?string
    {
        return $this->file_url ?? $this->external_url;
    }
}
