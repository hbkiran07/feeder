<?php

namespace App\Http\Requests;

class GetFeedRequest
{
    public static function rules()
    {
        return [
            'feedId' => 'required|numeric',
            'value' => 'required|max:255',
        ];
    }
}