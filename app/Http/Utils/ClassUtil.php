<?php

namespace App\Http\Utils;

use App\Models\User;
use Illuminate\Http\Request;

class ClassUtil
{
    /**
     * Generate a random password of specified length.
     *
     * @param int $length
     * @return string
     */
    public static function randomPassword($length = 8): string
    {
        // Define possible characters for the password
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@$!%*?&#';
        return substr(str_shuffle($characters), 0, $length);
    }

    /**
     * Get a user by email or phone from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @param bool $isEmail
     * @return \App\Models\User|null
     */
    public static function getUser(Request $request, bool $isEmail = true): ?User
    {
        $user = null;
        if ($isEmail) {
            $user = User::where('email', $request->login)->first();
        } else {
            $user = User::where('phone', $request->login)->first();
        }

        if (!$user){

        }

        return $user;
    }
}
