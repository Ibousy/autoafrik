<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'vehicle_id', 'client_id', 'employee_id',
        'type', 'status', 'priority',
        'description', 'diagnosis', 'labor_cost', 'parts_cost', 'total_cost',
        'payment_status', 'entered_at', 'completed_at',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\CompanyScope());
    }

    protected function casts(): array
    {
        return [
            'labor_cost'   => 'integer',
            'parts_cost'   => 'integer',
            'total_cost'   => 'integer',
            'entered_at'   => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'     => 'En attente',
            'in_progress' => 'En cours',
            'done'        => 'Terminé',
            default       => $this->status,
        };
    }

    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            'urgent' => 'Urgent',
            'high'   => 'Priorité haute',
            default  => 'Priorité normale',
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

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function parts(): HasMany
    {
        return $this->hasMany(RepairPart::class);
    }

    public function recalculateCosts(): void
    {
        $partsCost        = $this->parts()->sum(\DB::raw('quantity * unit_price'));
        $this->parts_cost = $partsCost;
        $this->total_cost = $this->labor_cost + $partsCost;
        $this->saveQuietly();
    }
}
