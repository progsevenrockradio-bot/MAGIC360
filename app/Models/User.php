<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'activo',
        'telefono',
        'ultimo_acceso_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
            'ultimo_acceso_at' => 'datetime',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->activo) {
            $this->update(['ultimo_acceso_at' => Carbon::now()]);
            return true;
        }
        return false;
    }

    public function esAdministrador(): bool
    {
        return $this->rol === 'administrador';
    }

    public function esEmpleado(): bool
    {
        return $this->rol === 'empleado';
    }

    public function esComercial(): bool
    {
        return $this->rol === 'comercial';
    }

    public function puede(string $permiso): bool
    {
        if ($this->esAdministrador()) {
            return true;
        }
        
        if ($this->esEmpleado()) {
            return in_array($permiso, ['ver_agenda', 'editar_agenda', 'ver_clientes', 'editar_clientes', 'ver_presupuestos']);
        }
        
        if ($this->esComercial()) {
            return in_array($permiso, ['ver_agenda', 'ver_clientes', 'editar_clientes', 'ver_presupuestos', 'editar_presupuestos']);
        }

        return false;
    }

    public function scopeActivos(Builder $query): Builder
    {
        return $query->where('activo', true);
    }
}
