<?php

namespace App\Http\Requests;

class ActivateFeedRequest
{
    public static function rules()
    {
        return [
            'feedId' => 'required|numeric',
        ];
    }
}