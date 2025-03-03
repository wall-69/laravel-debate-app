<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Argument extends Model
{
    protected $fillable = [
        "user_id", "thesis_id", "content"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thesis()
    {
        return $this->belongsTo(Thesis::class);
    }
}
