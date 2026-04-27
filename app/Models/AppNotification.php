<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppNotification extends Model
{
    protected $table = 'app_notifications';

    protected $fillable = [
        'company_id', 'user_id', 'type', 'icon', 'title', 'body', 'link_view', 'read_at',
    ];

    protected function casts(): array
    {
        return ['read_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function notify(int $companyId, int $userId, string $title, string $body = '', string $type = 'info', string $icon = 'bell', string $linkView = ''): void
    {
        static::create([
            'company_id' => $companyId,
            'user_id'    => $userId,
            'type'       => $type,
            'icon'       => $icon,
            'title'      => $title,
            'body'       => $body,
            'link_view'  => $linkView ?: null,
        ]);
    }

    public static function notifyAll(int $companyId, string $title, string $body = '', string $type = 'info', string $icon = 'bell', string $linkView = ''): void
    {
        User::where('company_id', $companyId)->pluck('id')->each(function ($uid) use ($companyId, $title, $body, $type, $icon, $linkView) {
            static::notify($companyId, $uid, $title, $body, $type, $icon, $linkView);
        });
    }
}
