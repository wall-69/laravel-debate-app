<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Judgement extends Model
{
    protected $fillable = [
        "argument_ulid", "content"
    ];

    public function argument()
    {
        return $this->belongsTo(Argument::class);
    }
}
