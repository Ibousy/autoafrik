<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Company extends Model
{
    protected $fillable = [
        'name', 'slug', 'logo_path', 'address', 'phone', 'email',
        'website', 'currency', 'plan', 'trial_ends_at', 'plan_expires_at',
        'max_agents', 'status',
    ];

    protected $casts = [
        'trial_ends_at'   => 'datetime',
        'plan_expires_at' => 'datetime',
    ];

    public static function plans(): array
    {
        return [
            'trial'      => ['label' => 'Essai gratuit', 'max_agents' => 3,   'price' => 0,      'color' => '#64748B', 'icon' => 'fa-gift'],
            'starter'    => ['label' => 'Starter',       'max_agents' => 5,   'price' => 15000,  'color' => '#3B82F6', 'icon' => 'fa-rocket'],
            'pro'        => ['label' => 'Pro',            'max_agents' => 20,  'price' => 35000,  'color' => '#F97316', 'icon' => 'fa-star'],
            'enterprise' => ['label' => 'Enterprise',     'max_agents' => 999, 'price' => 80000,  'color' => '#8B5CF6', 'icon' => 'fa-crown'],
        ];
    }

    public function getPlanInfoAttribute(): array
    {
        return self::plans()[$this->plan] ?? self::plans()['trial'];
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : null;
    }

    public function isOnTrial(): bool
    {
        return $this->plan === 'trial' && ($this->trial_ends_at === null || $this->trial_ends_at->isFuture());
    }

    public function trialDaysLeft(): int
    {
        if (!$this->trial_ends_at) return 0;
        return max(0, (int) now()->diffInDays($this->trial_ends_at, false));
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function canAddAgent(): bool
    {
        return $this->users()->count() < $this->max_agents;
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function owner(): HasOne
    {
        return $this->hasOne(User::class)->where('role', 'owner');
    }

    public static function generateSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
