<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $fillable = ['name', 'kurs_num'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }

    public function dates(): HasMany
    {
        return $this->hasMany(PracticDate::class);
    }
}
