<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use DB;
use view;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Illuminate\Auth\AuthenticationException || $exception instanceof \Illuminate\Session\TokenMismatchException) {
            return redirect('/login');
        }
        return parent::render($request, $exception);
//        echo $_SERVER['REMOTE_ADDR'];exit;
        $developerIps = DB::table("developer_ip")->get()->pluck("ip")->toArray();

        if(in_array($_SERVER['REMOTE_ADDR'],$developerIps))
        {
            return parent::render($request, $exception);
        }
        else
        {
            return view("error");
        }
        return parent::render($request, $exception);
    }
}
