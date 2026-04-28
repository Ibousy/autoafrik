<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'company_id', 'name', 'email', 'password', 'role', 'phone', 'is_active', 'permissions',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
            'permissions'       => 'array',
            'company_id'        => 'integer',
        ];
    }

    public static array $roles = [
        'super_admin'  => ['label' => 'Super Admin',    'color' => '#DC2626', 'icon' => 'fa-user-shield'],
        'owner'        => ['label' => 'Propriétaire',   'color' => '#8B5CF6', 'icon' => 'fa-crown'],
        'admin'        => ['label' => 'Administrateur', 'color' => '#0D1B3E', 'icon' => 'fa-shield'],
        'manager'      => ['label' => 'Manager',        'color' => '#3B82F6', 'icon' => 'fa-briefcase'],
        'mechanic'     => ['label' => 'Mécanicien',     'color' => '#F97316', 'icon' => 'fa-wrench'],
        'accountant'   => ['label' => 'Comptable',      'color' => '#10B981', 'icon' => 'fa-calculator'],
        'receptionist' => ['label' => 'Réceptionniste', 'color' => '#F59E0B', 'icon' => 'fa-headset'],
    ];

    // Views each role can access
    public static array $viewPermissions = [
        'owner'        => ['dashboard','clients','vehicules','reparations','entretien','locations','stock','employes','comptabilite','rapports','equipe','parametres'],
        'admin'        => ['dashboard','clients','vehicules','reparations','entretien','locations','stock','employes','comptabilite','rapports','equipe','parametres'],
        'manager'      => ['dashboard','clients','vehicules','reparations','entretien','locations','stock','employes','rapports'],
        'mechanic'     => ['dashboard','reparations','entretien','stock'],
        'accountant'   => ['dashboard','comptabilite','rapports'],
        'receptionist' => ['dashboard','clients','vehicules','locations'],
    ];

    public function getAllowedViewsAttribute(): array
    {
        if (!empty($this->permissions)) {
            return $this->permissions;
        }
        return self::$viewPermissions[$this->role] ?? ['dashboard'];
    }

    public function canView(string $view): bool
    {
        return in_array($view, $this->allowed_views);
    }

    public function getRoleInfoAttribute(): array
    {
        return self::$roles[$this->role] ?? self::$roles['mechanic'];
    }

    public function isSuperAdmin(): bool { return $this->role === 'super_admin'; }
    public function isOwner(): bool      { return $this->role === 'owner'; }
    public function isAdmin(): bool      { return in_array($this->role, ['owner', 'admin']); }
    public function canManage(): bool    { return in_array($this->role, ['owner', 'admin', 'manager']); }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }
}
