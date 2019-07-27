<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Illuminate\Auth\AuthenticationException;
use \Illuminate\Auth\Access\AuthorizationException;
use \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Contracts\Filesystem\FileNotFoundException;
use \Tymon\JWTAuth\Exceptions\TokenExpiredException;
use \Tymon\JWTAuth\Exceptions\TokenInvalidException;
use \Illuminate\Database\QueryException;

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
    public function render($request, Exception $exception) {

        // set localization in handler
        $locale = $request->wantsJson()
                    ? $request->header('Accept-Language') ?? 'id'
                    : $request->cookie('language') ?? 'id';
        // set laravel localization
        app()->setLocale($locale);

        // handle query exception
        if($exception instanceof QueryException) {
            $message = env('APP_DEBUG') ? $exception->getMessage() : __('response.500');
            $code = 500;
            if($request->wantsJson()) {
                return response()->json(compact('message'), $code);
            }
        }

        // handle accessing undefined model id in url
        if($exception instanceof ModelNotFoundException) {
            $message = env('APP_DEBUG') ? $exception->getMessage() : __('response.404');
            $code = 404;
            if($request->wantsJson()) {
                return response()->json(compact('message'), $code);
            }
        }

        // handle wrong accessing routes's url
        if($exception instanceof NotFoundHttpException) {
            $message = env('APP_DEBUG') ? $exception->getMessage() : __('response.404');
            $code = 404;
            if($request->wantsJson()) {
                return response()->json(compact('message'), $code);
            }
        }

        // handle wrong accessing route's method
        if($exception instanceOf MethodNotAllowedHttpException) {
            $message = env('APP_DEBUG') ? $exception->getMessage() : __('response.400');
            $code = 405;
            if($request->wantsJson()) {
                return response()->json(compact('message'), $code);
            }
        }

        if($exception instanceof FileNotFoundException ){
            $message = env('APP_DEBUG') ? $exception->getMessage() : __('response.500');
            $code = 500;
            if($request->wantsJson()) {
                return response()->json(compact('message'), $code);
            }
        }

        // handle unauthenticated user when accessing authenticated route
        if($exception instanceOf AuthenticationException) {
            $message = env('APP_DEBUG') ? $exception->getMessage() : __('response.401');
            $code = 401;
            if($request->wantsJson()) {
                return response()->json(compact('message'), $code);
            }
        }

        // handle unauthorized user when accessing authorized route
        if($exception instanceOf AuthorizationException) {
            $message = env('APP_DEBUG') ? $exception->getMessage() : __('response.403');
            $code = 403;
            if($request->wantsJson()) {
                return response()->json($message, $code);
            }
        }

        // handle token expired
        if ($exception instanceof TokenExpiredException) {
            $message = env('APP_DEBUG') ? $exception->getMessage() : __('auth.token_expired');
            $code = 400;
            if($request->wantsJson()) {
                return response()->json(compact('message'), $code);
            }
        }

        // handle invalid token
        if ($exception instanceof TokenInvalidException) {
            $message = env('APP_DEBUG') ? $exception->getMessage() : __('auth.token_invalid');
            $code = 400;
            if($request->wantsJson()) {
                return response()->json(compact('message'), $code);
            }
        }

        // if unknow exceptions happends return server error on production
        if($exception) {
            $message = env('APP_DEBUG') ? $exception->getMessage() : __('response.500');
            $code = 500;
            if($request->wantsJson()) {
                return response()->json(compact('message'), $code);
            }
        }

        return parent::render($request, $exception);
    }
}
