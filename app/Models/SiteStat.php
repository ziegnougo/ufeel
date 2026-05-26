<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteStat extends Model
{
    public $timestamps = false;

    protected $fillable = ['key', 'value', 'label', 'icon', 'updated_at'];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    public static function getValue(string $key, int $default = 0): int
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function incrementStat(string $key, int $amount = 1): void
    {
        static::where('key', $key)->increment('value', $amount);
        static::where('key', $key)->update(['updated_at' => now()]);
    }
}
