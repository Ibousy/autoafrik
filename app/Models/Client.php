<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'first_name', 'last_name', 'email', 'phone', 'phone2',
        'address', 'city', 'nationality', 'profession', 'date_of_birth',
        'id_type', 'id_number', 'type', 'company_name', 'notes',
    ];

    protected function casts(): array
    {
        return ['date_of_birth' => 'date'];
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyScope());
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function getTotalSpentAttribute(): int
    {
        $repairs  = $this->repairs()->where('payment_status', 'paid')->sum('total_cost');
        $rentals  = $this->rentals()->where('payment_status', 'paid')->sum('total_price');
        return $repairs + $rentals;
    }
}
