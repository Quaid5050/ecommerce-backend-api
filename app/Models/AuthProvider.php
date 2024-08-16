<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthProvider extends Model
{
    use HasFactory;
    protected $fillable = ['provider_name', 'provider_id', 'email','user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
