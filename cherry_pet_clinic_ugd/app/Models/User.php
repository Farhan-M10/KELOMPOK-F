<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'status',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Otomatis hash password saat di-set
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Scope untuk filter berdasarkan role
     */
    public function scopeStaff($query)
    {
        return $query->where('role', 'staff');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeVeterinarian($query)
    {
        return $query->where('role', 'veterinarian');
    }

    /**
     * Accessor untuk badge role
     */
    public function getRoleBadgeAttribute()
    {
        $badges = [
            'admin' => '<span class="badge bg-danger">Admin</span>',
            'staff' => '<span class="badge bg-primary">Staff</span>',
            'veterinarian' => '<span class="badge bg-success">Veterinarian</span>',
        ];

        return $badges[$this->role] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    /**
     * Accessor untuk badge status
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'active'
            ? '<span class="badge bg-success">Aktif</span>'
            : '<span class="badge bg-danger">Nonaktif</span>';
    }

    /**
     * Check apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check apakah user adalah staff
     */
    public function isStaff()
    {
        return $this->role === 'staff';
    }

    /**
     * Check apakah user adalah veterinarian
     */
    public function isVeterinarian()
    {
        return $this->role === 'veterinarian';
    }

    /**
     * Check apakah user aktif
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
