<?php

namespace App\Http\Requests;

class SmsVerificationRequest
{
    public static function rules()
    {
        return [
            //'userName' => 'required|email:filter',
            'userName' => 'required|string|max:25|regex:/(^[A-Za-zÇŞĞÜÖİçşğüöı ]+$)+/',
            'verificationCode' => 'required|size:8',
        ];
    }
}