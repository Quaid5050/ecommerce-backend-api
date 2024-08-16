<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'google_id', 'auth_type', 'auth_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    private mixed $auth_type;

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


    public function authCredential()
    {
        return $this->hasOne(AuthCredential::class, 'id', 'auth_id');
    }

    public function authProvider()
    {
        return $this->hasOne(AuthProvider::class, 'id', 'auth_id');
    }

    // Additional method to select the correct relationship
    public function authDetails()
    {
        if ($this->auth_type === 'credentials') {
            return $this->authCredential;
        } elseif ($this->auth_type === 'oauth') {
            return $this->authProvider;
        }

        return null;
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            if ($user->auth_type === 'credentials') {
                AuthCredential::find($user->auth_id)->delete();
            } elseif ($user->auth_type === 'oauth') {
                AuthProvider::find($user->auth_id)->delete();
            }
        });
    }
}
