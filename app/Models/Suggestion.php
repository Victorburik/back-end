<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'link',
        'status',
    ];

    /**
     * Status para sugestões.
     */
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * Relacionamento com Usuário (User).
     * Uma sugestão pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com Aprovação (Approval).
     * Uma sugestão pode ter uma aprovação.
     */
    public function approval()
    {
        return $this->hasOne(Approval::class);
    }

    /**
     * Verifica se a sugestão está pendente.
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Verifica se a sugestão foi aprovada.
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Verifica se a sugestão foi rejeitada.
     */
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }
}
