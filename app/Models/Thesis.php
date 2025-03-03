<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    protected $fillable = [
        "content"
    ];

    public function arguments()
    {
        return $this->hasMany(Argument::class);
    }
}
