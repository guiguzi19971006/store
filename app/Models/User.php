<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

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
