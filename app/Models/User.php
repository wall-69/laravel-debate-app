<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function arguments()
    {
        return $this->hasMany(Argument::class);
    }

    public function theses()
    {
        return $this->hasManyThrough(
            Thesis::class,  // Final model
            Argument::class, // Intermediate model
            'user_id',       // Foreign key in arguments table (linking to users)
            'id',            // Primary key in theses table
            'id',            // Primary key in users table
            'thesis_id'      // Foreign key in arguments table (linking to theses)
        );
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
}
