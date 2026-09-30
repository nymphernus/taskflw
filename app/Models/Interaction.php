<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model
{
    protected $fillable = ['client_id', 'type', 'description', 'happened_at'];

    protected $casts = ['happened_at' => 'datetime'];

    public const TYPES = [
        'call'    => 'Звонок',
        'email'   => 'Письмо',
        'meeting' => 'Встреча',
        'other'   => 'Другое',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
