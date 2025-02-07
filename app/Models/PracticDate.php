<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticDate extends Model
{
    protected $fillable = ['day', 'group_id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
