<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Questions extends Model
{
     protected $fillable = [
        "question",
        "theme_id",
    ];

     public function theme(): BelongsTo
    {
        return $this->belongsTo(Themes::class, 'theme_id');
    }

     public function reponses(): HasMany
    {
        return $this->hasMany(Reponses::class, "question_id");
    }
}
