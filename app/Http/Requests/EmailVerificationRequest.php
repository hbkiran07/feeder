<?php

namespace App\Http\Requests;

class EmailVerificationRequest
{
    public static function rules()
    {
        return [
            'email' => 'required|email:filter',
            'verificationCode' => 'required|max:70',
        ];
    }
}