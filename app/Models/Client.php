<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = ['name', 'company', 'email', 'phone', 'notes'];

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class)->latest('happened_at');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
