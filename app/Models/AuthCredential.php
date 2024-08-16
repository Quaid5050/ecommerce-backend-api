<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthCredential extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'password', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
