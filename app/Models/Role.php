<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'permissions',
    ];

    /**
     * Cast do campo 'permissions' para array.
     */
    protected $casts = [
        'permissions' => 'array',
    ];

    /**
     * Relacionamento com usuários.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
