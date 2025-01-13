<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'user_id', // Certifique-se de que este campo está migrado corretamente no banco de dados
    ];

    /**
     * Relacionamento com o usuário administrador que gerencia o link.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}