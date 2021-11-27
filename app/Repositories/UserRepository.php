<?php

namespace App\Repositories;

use App\Models\User;
use DB;

class UserRepository
{
    public function get_user_by_email($email)
    {
        return User::where('email', $email)->first();
    }

    public function generate_user_tokens($data)
    {
        return DB::table('user_tokens')->insertGetId($data);
    }

    public function get_user_token_by_id($user_token_id)
    {
        return DB::table('user_tokens')->find($user_token_id);
    }
}