<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTokenType extends Model
{
    use HasFactory;

    protected $table = 'user_token_types';
    protected $guarded = [];

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
