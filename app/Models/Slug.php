<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Slug extends Model
{
    public $timestamps = false;

    protected $fillable = ['value'];

    protected $hidden = [
        'reference_id',
        'reference_type',
    ];

    public function sluggable(): MorphTo
    {
        return $this->morphTo();
    }
}
