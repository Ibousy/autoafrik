<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'vehicle_id', 'client_id', 'start_date', 'end_date',
        'price_per_day', 'total_price', 'status', 'payment_status',
        'payment_method', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date'    => 'date',
            'end_date'      => 'date',
            'price_per_day' => 'integer',
            'total_price'   => 'integer',
        ];
    }

    public function getDaysAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active'    => 'En cours',
            'completed' => 'Terminée',
            'cancelled' => 'Annulée',
            default     => $this->status,
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'paid'    => 'Payé',
            'pending' => 'En attente',
            'partial' => 'Acompte',
            default   => $this->payment_status,
        };
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\CompanyScope());

        static::created(function (Rental $rental) {
            $rental->vehicle->update(['status' => 'rented']);
        });

        static::updated(function (Rental $rental) {
            if ($rental->isDirty('status') && in_array($rental->status, ['completed', 'cancelled'])) {
                $rental->vehicle->update(['status' => 'available']);
            }
        });
    }
}
