<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'company_id', 'from_user_id', 'to_user_id',
        'is_bot', 'is_broadcast', 'content',
        'file_path', 'file_name', 'file_mime', 'read_at',
    ];

    protected function casts(): array
    {
        return [
            'is_bot'       => 'boolean',
            'is_broadcast' => 'boolean',
            'read_at'      => 'datetime',
        ];
    }

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}
