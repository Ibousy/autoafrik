<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'user_id', 'first_name', 'last_name', 'role',
        'phone', 'email', 'salary', 'hired_at', 'status',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\CompanyScope());
    }

    protected function casts(): array
    {
        return [
            'hired_at' => 'date',
            'salary'   => 'integer',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'chef_mecanicien'  => 'Chef mécanicien',
            'mecanicien_senior' => 'Mécanicien senior',
            'mecanicien'       => 'Mécanicien',
            'electricien'      => 'Électricien auto',
            'magasinier'       => 'Magasinier',
            'receptionniste'   => 'Accueil & Admin',
            'gerant'           => 'Gérant / Admin',
            'comptable'        => 'Comptable',
            default            => $this->role,
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }

    public function getRepairsThisMonthAttribute(): int
    {
        return $this->repairs()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }
}
