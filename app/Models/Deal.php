<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deal extends Model
{
    protected $fillable = ['client_id', 'title', 'amount', 'status', 'notes'];

    public const STATUSES = [
        'lead'        => 'Лид',
        'in_progress' => 'В работе',
        'paid'        => 'Оплачено',
        'rejected'    => 'Отказ',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
