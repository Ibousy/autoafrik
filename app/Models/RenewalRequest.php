<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RenewalRequest extends Model
{
    protected $fillable = [
        'company_id', 'plan', 'duration_months', 'amount', 'status', 'rejection_reason', 'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public static function priceFor(string $plan, int $months): int
    {
        $monthly = Company::plans()[$plan]['price'] ?? 0;
        $discount = match (true) {
            $months >= 12 => 0.80,
            $months >= 6  => 0.90,
            $months >= 3  => 0.95,
            default       => 1.00,
        };
        return (int) ($monthly * $months * $discount);
    }
}
