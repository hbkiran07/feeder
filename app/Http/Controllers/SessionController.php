<?php

namespace App\Http\Controllers;

use App\Models\Session;

class SessionController
{
    private $response;
    
    public function __construct()
    {
        $session = new Session();
        $this->session = $session;
        $this->response['status'] = true;
    }
    
    /**
     *Do user session operations
     *
     * @param string $userId
     * @param string $sessionId
     *
     * @return mixed
     */
    public function doOperation(string $userId, string $sessionId)
    {
        $getResponse = $this->session->getSession(
            [['user_id', '=', $userId]],
            ['session']
        );
        //Check db any session data.
        // if not insert session.
        // if valid any data check session or update session 
        if (!$getResponse['status']) {
            $insertResponse = $this->session->insertSession(
                $userId,
                $sessionId
            );
            if (!$insertResponse['status']) {
                return $insertResponse;
            }
        } else {
            if ($getResponse['data']['session'] == $sessionId) {
                $this->response['status'] = false;
                $this->response['message'] = 'Session expired.';
            } else {
                $responseUpdata = $this->session->updateSession(
                    [['user_id', '=', $userId]],
                    ['session' => $sessionId]
                );
                if (!$responseUpdata['status']) {
                    return $responseUpdata;
                }
            }
        }
        
        return $this->response;
    }
}