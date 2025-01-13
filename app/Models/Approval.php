<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'suggestion_id',
        'admin_id',
        'status',
    ];

    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * Relacionamento com a sugestão associada à aprovação.
     */
    public function suggestion()
    {
        return $this->belongsTo(Suggestion::class, 'suggestion_id');
    }

    /**
     * Relacionamento com o administrador responsável pela aprovação/rejeição.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
