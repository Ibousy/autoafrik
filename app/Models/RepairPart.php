<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairPart extends Model
{
    protected $fillable = [
        'repair_id', 'stock_item_id', 'quantity', 'unit_price',
    ];

    protected function casts(): array
    {
        return [
            'quantity'   => 'integer',
            'unit_price' => 'integer',
        ];
    }

    public function getSubtotalAttribute(): int
    {
        return $this->quantity * $this->unit_price;
    }

    public function repair(): BelongsTo
    {
        return $this->belongsTo(Repair::class);
    }

    public function stockItem(): BelongsTo
    {
        return $this->belongsTo(StockItem::class);
    }

    protected static function booted(): void
    {
        // Decrease stock when a part is used
        static::created(function (RepairPart $part) {
            $part->stockItem->decrement('quantity', $part->quantity);
            $part->repair->recalculateCosts();
        });

        static::deleted(function (RepairPart $part) {
            $part->stockItem->increment('quantity', $part->quantity);
            $part->repair->recalculateCosts();
        });
    }
}
