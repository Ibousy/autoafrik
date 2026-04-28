<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'company_id', 'vehicle_id', 'client_id', 'type', 'description',
        'scheduled_at', 'completed_at', 'mileage', 'cost', 'status', 'notes',
    ];

    protected $casts = [
        'scheduled_at'  => 'date',
        'completed_at'  => 'date',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyScope);
    }

    public static array $types = [
        'vidange'            => ['label' => 'Vidange / Huile',         'icon' => 'fa-oil-can',       'color' => '#F97316'],
        'revision'           => ['label' => 'Révision complète',       'icon' => 'fa-tools',         'color' => '#3B82F6'],
        'controle_technique' => ['label' => 'Contrôle technique',      'icon' => 'fa-clipboard-check','color' => '#8B5CF6'],
        'pneumatiques'       => ['label' => 'Pneumatiques',            'icon' => 'fa-circle-notch',   'color' => '#10B981'],
        'freins'             => ['label' => 'Freins',                  'icon' => 'fa-stop-circle',   'color' => '#EF4444'],
        'batterie'           => ['label' => 'Batterie',                'icon' => 'fa-car-battery',   'color' => '#F59E0B'],
        'courroie'           => ['label' => 'Courroie / Distribution', 'icon' => 'fa-cog',           'color' => '#06B6D4'],
        'filtre'             => ['label' => 'Filtres',                 'icon' => 'fa-filter',        'color' => '#64748B'],
        'climatisation'      => ['label' => 'Climatisation',          'icon' => 'fa-snowflake',     'color' => '#0EA5E9'],
        'geometrie'          => ['label' => 'Géométrie',               'icon' => 'fa-ruler-combined','color' => '#EC4899'],
        'autre'              => ['label' => 'Autre',                   'icon' => 'fa-wrench',        'color' => '#94A3B8'],
    ];

    public static array $statuses = [
        'planifie'  => ['label' => 'Planifié',    'color' => '#3B82F6', 'bg' => 'rgba(59,130,246,.1)'],
        'en_cours'  => ['label' => 'En cours',    'color' => '#F59E0B', 'bg' => 'rgba(245,158,11,.1)'],
        'termine'   => ['label' => 'Terminé',     'color' => '#10B981', 'bg' => 'rgba(16,185,129,.1)'],
        'annule'    => ['label' => 'Annulé',      'color' => '#EF4444', 'bg' => 'rgba(239,68,68,.1)'],
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
