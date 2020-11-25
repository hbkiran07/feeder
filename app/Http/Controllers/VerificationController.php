<?php

namespace App\Http\Controllers;

use App\Models\VerificationCode;

class VerificationController
{
    private $response;
    
    public function __construct()
    {
        $verification = new VerificationCode();
        $this->verification = $verification;
        $this->response['status'] = true;
    }
    
    /**
     * Send sms verification codes.
     *
     * @param string $userPhoneNumber
     * @param string $smsVerificationCode
     *
     * @return bool
     */
    private function sendSmsCode(string $userPhoneNumber, string $smsVerificationCode)
    {
        logger()->info('Sms verification code send. User phone number =>' . $userPhoneNumber . ' Sms veirification code => ' . $smsVerificationCode);
        return true;
    }
    
    /**
     *Send email verification codes.
     *
     * @param string $userEmail
     * @param string $emailVerificationCode
     *
     * @return bool
     */
    private function sendEmailCode(string $userEmail, string $emailVerificationCode)
    {
        logger()->info('Email verification code send. User email =>' . $userEmail . ' Email veirification code => ' . $emailVerificationCode);
        return true;
    }
    
    /**
     * Send sms and email verification codes.
     *
     * @param array $userData
     *
     * @param array $verificationCodes
     */
    private function sendCodes(array $userData, array $verificationCodes)
    {
        $this->sendSmsCode(
            $userData['phone_number'],
            $verificationCodes['smsCode']
        );
        $this->sendEmailCode(
            $userData['email'],
            $verificationCodes['emailCode']
        );
    }
    
    /**
     * Generate sms and email verification codes.
     *
     * @return mixed
     */
    private function generateVerificationCodes()
    {
        $this->response['smsCode'] = substr(md5(uniqid(mt_rand(), true)), 0, 8);;
        $this->response['emailCode'] = md5(uniqid(mt_rand(), true));
        return $this->response;
    }
    
    /**
     * Generate and send verification codes.
     *
     * @param array $userData
     *
     * @return mixed
     */
    public function generateAndSendVerificationCodes(array $userData)
    {
        $codes = $this->generateVerificationCodes();
        $response = $this->verification->insert(
            $userData,
            $codes['smsCode'],
            $codes['emailCode']
        );
        if (!$response['status']) {
            return $response;
        }
        $this->sendCodes($userData, $codes);
        
        return $this->response;
    }
    
    /**
     * Verificate account with sms code.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function verifyWithSms(array $data)
    {
        $verificationData = $this->verification->getData([['user_name', '=', $data['userName']]]);
        if (empty($verificationData['data'])) {
            return $verificationData;
        } elseif ($verificationData['data']['status'] == config('constants.status.active')) {
            $verificationData['status'] = false;
            $verificationData['message'] = 'This user already verified.';
            return $verificationData;
        }
        
        if ($verificationData['data']['user_name'] == $data['userName'] &&
            $verificationData['data']['sms_code'] == $data['verificationCode']
        ) {
            return $this->verification->updateVerification(
                [
                    ['user_name', '=', $data['userName']],
                    ['sms_code', '=', $data['verificationCode']]
                ],
                ['status' => config('constants.status.active')]
            );
        } else {
            $this->response['status'] = false;
        }
        
        return $this->response;
    }
    
    /**
     * Verificate with email
     *
     * @param array $data
     *
     * @return mixed
     */
    public function verifyWithEmail(array $data)
    {
        $verificationData = $this->verification->getData([['user_email', '=', $data['email']]]);
        if (empty($verificationData['data'])) {
            return $verificationData;
        } elseif ($verificationData['data']['status'] == config('constants.status.active')) {
            $verificationData['status'] = false;
            $verificationData['message'] = 'This user already verified.';
            return $verificationData;
        }
        
        if ($verificationData['data']['user_email'] == $data['email'] &&
            $verificationData['data']['email_code'] == $data['verificationCode']
        ) {
            return $this->verification->updateVerification(
                [
                    ['user_email', '=', $data['email']],
                    ['email_code', '=', $data['verificationCode']]
                ],
                ['status' => config('constants.status.active')]
            );
        } else {
            $this->response['status'] = false;
        }
        
        return $this->response;
    }
}