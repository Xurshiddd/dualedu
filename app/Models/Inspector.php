<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inspector extends Model
{
    protected $fillable = [
        'user_id',
        'group_id',
        'status',
        'distance',
        'longitude',
        'latitude',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
