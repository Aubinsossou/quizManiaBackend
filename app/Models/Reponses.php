<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Reponses extends Model
{
    protected $fillable = [
        "name",
        "status",
        "question_id",
        
    ];

      public function question(): BelongsTo
    {
        return $this->belongsTo(Questions::class, 'questions')->inRandomOrder();
    }
    
}
