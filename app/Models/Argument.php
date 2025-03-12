<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Argument extends Model
{
    use HasUlids;

    protected $primaryKey = 'ulid';

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

    public function judgement()
    {
        return $this->hasOne(Judgement::class);
    }
}
