<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;

    protected $fillable = [
        "content"
    ];

    public function arguments()
    {
        return $this->hasMany(Argument::class);
    }
}
