<?php

namespace App\Http\Middleware;

use App\Http\Controllers\SessionController;
use App\Models\Token;
use Closure;
use Illuminate\Http\Request;

class AuthCustom
{
    /**
     * Handle get request
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\JsonResponse|mixed|object
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty($request->bearerToken()) || empty(session()->getId())
        ) {
            return response()->json([
                'success' => 'false',
                'message' => 'Invalid token or session.',
            ])->setStatusCode(config('constants.status_codes.unauthorized'));
        }
        
        $token = new Token();
        $tokenData = $token->checkToken($request->bearerToken());
        if (!$tokenData['status']) {
            return response()->json([
                'success' => $tokenData['status'],
                'message' => $tokenData['message'],
            ])->setStatusCode(config('constants.status_codes.unauthorized'));
        }
        
        $session = new SessionController();
        $sessionResponse = $session->doOperation(
            $tokenData['data']['user_id'],
            session()->getId()
        );
        if (!$sessionResponse['status']) {
            return response()->json([
                'success' => $sessionResponse['status'],
                'message' => $tokenData['message'],
            ])->setStatusCode(config('constants.status_codes.login_time_out'));
        }
        
        $request->merge(["userId" => $tokenData['data']['user_id']]);
        
        return $next($request);
    }
}
