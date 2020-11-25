<?php

namespace App\Http\Feeders;

interface IFeeder
{
    public function getToken();
    
    public function getFeeds(array $data);
}