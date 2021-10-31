<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function get_user_by_email($email)
    {
        return User::where('email', $email)->first();
    }
}