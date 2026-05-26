<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiConversation extends Model
{
    use HasFactory;

    protected $fillable = ['session_token', 'user_id', 'messages'];

    protected $casts = [
        'messages' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addMessage(string $role, string $content): void
    {
        $messages = $this->messages ?? [];
        $messages[] = [
            'role' => $role,
            'content' => $content,
            'created_at' => now()->toIso8601String(),
        ];
        $this->update(['messages' => $messages]);
    }

    public function getFormattedMessages(): array
    {
        return collect($this->messages)->map(fn($m) => [
            'role' => $m['role'],
            'content' => $m['content'],
        ])->toArray();
    }
}
