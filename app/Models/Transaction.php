<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'type', 'category', 'amount', 'description',
        'reference_type', 'reference_id', 'date',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new \App\Models\Scopes\CompanyScope());
    }

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'date'   => 'date',
        ];
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->type === 'revenue' ? 'Revenu' : 'Dépense';
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'reparation'   => 'Réparation',
            'location'     => 'Location',
            'salaires'     => 'Salaires',
            'fournitures'  => 'Fournitures',
            'charges'      => 'Charges',
            'achat_pieces' => 'Achat pièces',
            default        => 'Autre',
        };
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}
