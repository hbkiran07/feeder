<?php

namespace App\Http\Feeders;

use Illuminate\Support\Facades\Http;

class TwitterFeeder implements IFeeder
{
    private $response;
    
    public function __construct()
    {
        $this->response['status'] = true;
    }
    
    /**
     * Get token for feed service
     * 
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getToken()
    {
        return config('app.fake_json_data_token');
    }
    
    /**
     * Get feed from feed service
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function getFeeds(array $data)
    {
        $body['token'] = $this->getToken();
        $body['data'] =
            [
                'string' => 'stringShort',
                '_repeat' => 20
            ];
        
        try {
            $feeds = Http::post(config('app.twitter_feeder_url'), $body);
            $feedsResponse = json_decode($feeds->body(), true);
            
            if (!empty($feedsResponse['error'])) {
                $this->response['status'] = false;
                $this->response['message'] = 'Unexpected Error.';
                return $this->response;
            }
            
            $this->response['data'] = $feedsResponse;
        } catch (\Exception $ex) {
            logger()->error('Error TwitterFeeder->getFeeds => ' . $ex->getMessage());
            $this->response['status'] = false;
            $this->response['message'] = 'Unexpected Error.';
        }
        
        return $this->response;
    }
}