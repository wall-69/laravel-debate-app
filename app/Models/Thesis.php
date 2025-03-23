<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    use HasFactory;

    protected $fillable = [
        "content"
    ];

    protected function casts(): array
    {
        return [
            "created_at" => "datetime:d.m.Y H:i",
            "updated_at" => "datetime:d.m.Y H:i",
        ];
    }

    public function arguments()
    {
        return $this->hasMany(Argument::class);
    }

    public function scopeSearch(Builder $query, string $search)
    {
        $query->where("content", "LIKE", "%$search%");
    }
}
