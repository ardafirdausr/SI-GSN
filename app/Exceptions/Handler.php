<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception){
        // set localization in handler
        $local = $request->header('Accept-Language') ?? 'en';
        app()->setLocale($local);

        if($exception instanceof QueryException){
            if($request->wantsJson()){
                return response()->json(
                    [
                        'message' => env('APP_DEBUG') ?
                            $exception->getMessage() :
                            __('response.500')
                    ], 500
                );
            }
        }

        // ? for unavailable model id
        // ? not available url handled by fallback
        if($exception instanceof ModelNotFoundException){
            if($request->wantsJson()){
                return response()->json(['message' => __('response.404')], 404);
            }
        }

        // ? for unavailable model id
        // ? not available url handled by fallback
        if($exception instanceof NotFoundHttpException){
            if($request->wantsJson()){
                return response()->json(['message' => __('response.404')], 404);
            }
        }

        // ? handle wrong method
        if($exception instanceOf MethodNotAllowedHttpException){
            if($request->wantsJson()){
                return response()->json(['message' => __('response.400')], 400);
            }
        }
        // ? handle unauthenticated, default : Unauthenticated
        if($exception instanceOf AuthenticationException){
            if($request->wantsJson()){
                return response()->json(['message' => __('response.401')], 401);
            }
        }

        // ? handle unauthorized, default : ?
        if($exception instanceOf AuthorizationException){
            if($request->wantsJson()){
                return response()->json(['message' => __('response.403')], 403);
            }
        }

        // ? handle token expired
        if ($exception instanceof TokenExpiredException) {
            if($request->wantsJson()){
                return response()->json(['message' => __('response.token_expired')], 404);
            }
        }

        // ? handle token invalid
        if ($exception instanceof TokenInvalidException) {
            if($request->wantsJson()){
                return response()->json(['message' => __('response.token_invalid')], 404);
            }
        }

        // ? handle unknow exception
        if($exception){
            if($request->wantsJson()){
                return response()->json(
                    [
                        'message' => env('APP_DEBUG') ?
                            $exception->getMessage() :
                            __('response.500')
                    ], 500
                );
            }
        }
        return parent::render($request, $exception);
    }
}
