<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $fillable = ['name', 'url', 'inspector_id'];
    public function inspector(): BelongsTo
    {
        return $this->belongsTo(Inspector::class);
    }
}
