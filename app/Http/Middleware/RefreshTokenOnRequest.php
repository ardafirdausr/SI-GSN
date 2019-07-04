<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Illuminate\Support\Str;
use \Tymon\JWTAuth\Exceptions\JWTException;
use \Tymon\JWTAuth\Exceptions\TokenExpiredException;

class RefreshTokenOnRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        try{
            if (! $user = JWTAuth::parseToken()->authenticate() ){
                return response()->json([
                    'message' => 'Auth error'
                ], 500);
            }
        }
        catch (TokenExpiredException $exception){
            // If the token is expired, then it will be refreshed and added to the headers
            try{
                $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                // if user need logout when token expired, the last token will be blacklisted and return success
                if(Str::endsWith($request->url(), 'logout')){
                    return response()->json(['message'=> 'response you have successfully logged_out']);
                }
                $user = JWTAuth::setToken($refreshed)->toUser();
                header('Authorization: Bearer ' . $refreshed);
                header('Access-Control-Expose-Headers: Authorization');
            }
            catch (JWTException $e){
                return response()->json([
                    'error_code' => '401-1',
                    'message' => 'Token not refreshable'
                ], 401);
            }
        }
        catch (JWTException $e){
            return response()->json([
                'message' => 'Auth error'
            ], 500);
        }

        // TODO: change this to real login
        // Login the user instance for global usage
        // Auth::login($user, false);

        return  $next($request);
    }
}
