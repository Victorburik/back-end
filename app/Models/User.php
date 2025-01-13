<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Relacionamento com Sugestões (Suggestion).
     * Um usuário pode ter várias sugestões.
     */
    public function suggestions()
    {
        return $this->hasMany(Suggestion::class);
    }

    /**
     * Relacionamento com Aprovações (Approval).
     * Um usuário (admin) pode aprovar várias sugestões.
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'admin_id');
    }

    /**
     * Verifica se o usuário é administrador.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
