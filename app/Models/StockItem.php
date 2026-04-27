<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'reference', 'name', 'category', 'quantity',
        'min_quantity', 'unit_price', 'supplier', 'notes',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\CompanyScope());
    }

    protected function casts(): array
    {
        return [
            'quantity'     => 'integer',
            'min_quantity' => 'integer',
            'unit_price'   => 'integer',
        ];
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->quantity === 0) return 'critical';
        if ($this->quantity <= $this->min_quantity) return 'low';
        return 'normal';
    }

    public function getStockStatusLabelAttribute(): string
    {
        return match ($this->stock_status) {
            'critical' => 'Critique',
            'low'      => 'Faible',
            default    => 'Normal',
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'freinage'      => 'Freinage',
            'moteur'        => 'Moteur',
            'climatisation' => 'Climatisation',
            'pneumatiques'  => 'Pneumatiques',
            'electrique'    => 'Électricité',
            'transmission'  => 'Transmission',
            'carrosserie'   => 'Carrosserie',
            'echappement'   => 'Échappement',
            default         => 'Autre',
        };
    }

    public function repairParts(): HasMany
    {
        return $this->hasMany(RepairPart::class);
    }
}
