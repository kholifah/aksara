<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Aksara\Exceptions\LoadModuleException;
use Aksara\ErrorLoadModule\ErrorLoadModuleHandler;

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

    private $loadModuleHandler;

    public function __construct(
        Container $container,
        ErrorLoadModuleHandler $loadModuleHandler
    ){
        $this->loadModuleHandler = $loadModuleHandler;
        parent::__construct($container);
    }

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
        if ($exception instanceof LoadModuleException) {
            $this->loadModuleHandler->handle($exception);

            //TODO flash session tidak tampil
            $redir = redirect('admin/aksara-module-manager')->with(
                'admin_notice',
                [
                    [
                        'labelClass' => 'warning',
                        'content' => $exception->getMessage(),
                    ],
                ]
            );
            //dd($redir);
            return $redir;
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
      return redirect(route('admin.login'));
    }


}
