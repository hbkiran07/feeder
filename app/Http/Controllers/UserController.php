<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $user;
    private $response;
    
    public function __construct()
    {
        $user = new User();
        $this->user = $user;
        $this->response['status'] = true;
    }
    
    /**
     * Register user
     *
     * @param array $data
     *
     * @return mixed
     */
    public function register(array $data)
    {
        $responseValues = $this->checkValues($data);
        if (!$responseValues['status']) {
            return $responseValues;
        }
        
        $responseUser = $this->user->insert($data);
        if (!$responseUser['status']) {
            return $responseUser;
        }
        
        $verification = new VerificationController();
        $responseVerification = $verification->generateAndSendVerificationCodes(
            $responseUser['data']
        );
        if (!$responseVerification['status']) {
            $this->user->remove($responseUser['data']);
            return $responseVerification;
        }
        
        return $this->response;
    }
    
    
    /**
     * Login user create new token and check session
     *
     * @param array $data
     *
     * @return mixed
     */
    public function login(array $data)
    {
        $userData = $this->user->getData(
            [['user_name', '=', $data['userName']]],
            ['id', 'user_name', 'password']
        );
        if (!$userData['status']) {
            return $userData;
        }
        
        if (Hash::check($data['password'],$userData['data']['password'])) {
            $token = new TokenController();
            $responseToken = $token->create($userData['data']);
            if (!$responseToken['status']) {
                return $responseToken;
            }
            $this->response['data'] = $responseToken['data'];
            
            $session = new SessionController();
            $sessionResponse = $session->doOperation(
                $userData['data']['id'],
                session()->getId()
            );
            if (!$sessionResponse['status']) {
                return $responseToken;
            }
        } else {
            $this->response['status'] = false;
        }
        
        return $this->response;
    }
    
    /**
     * Check user email username phone number values.
     * @param array $data
     * @return mixed
     */
    public function checkValues(array $data)
    {
        $response['status'] = true;
        
        $email = $this->user->checkExist([['email', '=', $data['email']]]);
        if (!$email['status']) {
            $email['message'] = 'This email address already in use.';
            return $email;
        }
        
        $userName = $this->user->checkExist([['user_name', '=', $data['userName']]]);
        if (!$userName['status']) {
            $userName['message'] = 'This username already in use.';
            return $userName;
        }
        
        $phoneNumber = $this->user->checkExist([['phone_number', '=', $data['phoneNumber']]]);
        if (!$phoneNumber['status']) {
            $phoneNumber['message'] = 'This phone number already in use.';
            return $phoneNumber;
        }
        
        return $response;
    }
}