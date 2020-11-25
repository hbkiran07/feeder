<?php

namespace App\Http\Requests;

class RegisterRequest
{
    public static function rules()
    {
        return [
            'name' => 'required|string|max:25|regex:/(^[A-Za-zÇŞĞÜÖİçşğüöı ]+$)+/',
            'surname' => 'required|string|max:25|regex:/(^[A-Za-zÇŞĞÜÖİçşğüöı ]+$)+/',
            'userName' => 'required|string|max:25|regex:/(^[A-Za-zÇŞĞÜÖİçşğüöı ]+$)+/',
            'email' => 'required|email:filter',
            'password' => 'required|string|max:25',
            'phoneNumber' => 'required|size:10|regex:/[0-9]{10}/',
            'feederPlatform' => 'required|in:twitter',
            'feederAddress' => 'required|max:50',
        ];
    }
}