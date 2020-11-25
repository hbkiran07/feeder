<?php

namespace App\Http\Requests;

class LoginRequest
{
    public static function rules()
    {
        return [
            'userName' => 'required|string|max:25|regex:/(^[A-Za-zÇŞĞÜÖİçşğüöı ]+$)+/',
            'password' => 'required|string|max:25',
        ];
    }
}