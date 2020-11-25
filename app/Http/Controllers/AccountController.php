<?php

namespace App\Http\Controllers;

use App\Http\Feeders\TwitterFeeder;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Register user function
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function register(Request $request)
    {
        $user = New UserController();
        $userResponse = $user->register($request->input());
        
        if (!$userResponse['status']) {
            return response()->json([
                'success' => $userResponse['status'],
                'message' => $userResponse['message']
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        return response()->json([
            'success' => $userResponse['status'],
            'message' => 'User create successfully. Please verificate your acoount'
        ])->setStatusCode(config('constants.status_codes.success'));
    }
    
    /**
     * Verify account with SMS code
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function verifyWithSms(Request $request)
    {
        $verification = new VerificationController();
        $verificationResponse = $verification->verifyWithSms($request->input());
        if (!$verificationResponse['status']) {
            return response()->json([
                'success' => $verificationResponse['status'],
                'message' => (
                !empty($verificationResponse['message'])) ? $verificationResponse['message']
                    : 'Check username or verification code.',
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        $feeder = new FeederController();
        $feederResponse = $feeder->getFeedSource(
            new TwitterFeeder(),
            $request->input()
        );
        if (!$feederResponse['status']) {
            return response()->json([
                'success' => $feederResponse['status'],
                'message' => $feederResponse['message']
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        return response()->json([
            'success' => $verificationResponse['status'],
            'message' => 'Account successfully verification with SMS.'
        ])->setStatusCode(config('constants.status_codes.success'));
    }
    
    /**
     * Verify account with Email code
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function verifyWithEmail(Request $request)
    {
        $verification = new VerificationController();
        $verificationResponse = $verification->verifyWithEmail($request->input());
        if (!$verificationResponse['status']) {
            return response()->json([
                'success' => $verificationResponse['status'],
                'message' => (
                !empty($verificationResponse['message'])) ? $verificationResponse['message']
                    : 'Check email or verification code.',
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        $feeder = new FeederController();
        $feederResponse = $feeder->getFeedSource(
            new TwitterFeeder(),
            $request->input()
        );
        if (!$feederResponse['status']) {
            return response()->json([
                'success' => $feederResponse['status'],
                'message' => $feederResponse['message']
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        return response()->json([
            'success' => $verificationResponse['status'],
            'message' => 'Account successfully verification with Email.'
        ])->setStatusCode(config('constants.status_codes.success'));
    }
    
    /**
     * User login
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function login(Request $request)
    {
        $user = new UserController();
        $loginResponse = $user->login(
            $request->input(),
            RegisterRequest::rules()
        );
        if (!$loginResponse['status']) {
            return response()->json([
                'success' => $loginResponse['status'],
                'message' => 'Check username or password.',
            ])->setStatusCode(config('constants.status_codes.bad_request'));
        }
        
        return response()->json([
            'success' => $loginResponse['status'],
            'message' => 'Login successfully.',
            'token' => $loginResponse['data']
        ])->setStatusCode(config('constants.status_codes.success'));
    }
}
