<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'type', 'brand', 'model', 'registration', 'year',
        'fuel_type', 'transmission', 'seats', 'mileage',
        'price_per_day', 'status', 'color', 'image', 'notes',
        'owner_name', 'owner_phone', 'owner_phone2', 'owner_email',
        'owner_address', 'owner_id_type', 'owner_id_number',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyScope());
    }

    protected function casts(): array
    {
        return [
            'year'          => 'integer',
            'mileage'       => 'integer',
            'price_per_day' => 'integer',
            'seats'         => 'integer',
        ];
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->brand} {$this->model}";
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available'   => 'Disponible',
            'rented'      => 'Loué',
            'maintenance' => 'Maintenance',
            'repair'      => 'En réparation',
            default       => $this->status,
        };
    }

    public function repairs(): HasMany
    {
        return $this->hasMany(Repair::class);
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    public function activeRental()
    {
        return $this->rentals()->where('status', 'active')->latest()->first();
    }
}
