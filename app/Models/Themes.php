<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Themes extends Model
{
    protected $fillable = [
        "name"
    ];

     public function questions(): HasMany
    {
        return $this->hasMany(Questions::class,"theme_id");
    }
}
