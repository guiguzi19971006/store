<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $guarded = [];

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function photos() {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public function user_token_types() {
        return $this->belongsToMany(UserTokenType::class, 'user_tokens', 'user_id', 'user_token_type_id');
    }
}
