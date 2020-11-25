<?php

namespace App\Http\Middleware;

use App\Http\Requests\EditFeedRequest;
use App\Http\Requests\EmailVerificationRequest;
use App\Http\Requests\ActivateFeedRequest;
use App\Http\Requests\FeedAllRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SmsVerificationRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Validate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    
    public function handle(Request $request, Closure $next)
    {
        $rules = $this->getRules($request->getRequestUri());
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $response['message'] = $validator->messages();
            return response(
                [
                    'status' => false,
                    'message' => $validator->messages()
                ], config('constants.status_codes.bad_request'));
        }
        
        return $next($request);
    }
    
    //Normally laravel validate with response but ı can not get validation fails. I know it is but idea 
    private function getRules(string $uri)
    {
        switch ($uri){
            case '/api/register':
                return RegisterRequest::rules();
            case '/api/login':
                return LoginRequest::rules();
            case '/api/verificate/sms':
                return SmsVerificationRequest::rules();
            case '/api/feed/activate':
                return ActivateFeedRequest::rules();
            case '/api/feed/edit':
                return EditFeedRequest::rules();
            case '/api/verificate/email':
                return EmailVerificationRequest::rules();
        }
    }
}
