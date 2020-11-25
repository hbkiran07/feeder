<?php

namespace App\Http\Controllers;

use App\Models\Token;

class TokenController
{
    private $token;
    private $response;
    
    public function __construct()
    {
        $token = new Token();
        $this->token = $token;
        $this->response['status'] = true;
    }
    
    /**
     * Do user token operation
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        $token = md5(uniqid(mt_rand(), true));
        $tokenData = $this->token->get(
            ['token'],
            [['user_id', '=', $data['id']]]
        );
        //If token have update token if not insert
        if (!$tokenData['status']) {
            $insertResponse = $this->token->insertToken(
                $token,
                $data
            );
            if (!$insertResponse['status']) {
                return $insertResponse;
            }
            $this->response['data'] = $token;
        } else {
            $updateResponse = $this->token->updateToken(
                ['token' => $token],
                [['user_id', '=', $data['id']]]
            );
            if (!$updateResponse['status']) {
                return $updateResponse;
            }
            $this->response['data'] = $token;
        }
        
        return $this->response;
    }
}