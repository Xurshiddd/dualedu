<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    protected $fillable = ['name', 'kurs_num'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }
}
