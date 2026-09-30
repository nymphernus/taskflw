<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = ['client_id', 'title', 'description', 'due_date', 'status'];

    protected $casts = ['due_date' => 'date'];

    public const STATUSES = [
        'open' => 'Открыта',
        'done' => 'Выполнена',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
