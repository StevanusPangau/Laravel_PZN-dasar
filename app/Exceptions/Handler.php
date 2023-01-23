<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

use function Termwind\render;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        // contoh error yang tidak akan di report
        ValidationException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // jika terjadi error taru program disini misal untuk mengiriim ke telegram atau email kita
            var_dump($e); // contoh, bisa dikirim ke email juga
            return false; // gunakan return false jika tidak ingin reportable yang lain muncuk jika sudah diketahui errornya apa
        });

        // bisa lebih dari satu untuk reportablenya

        // $this->reportable(function (Throwable $e) {
        //     var_dump($e);
        // });

        // $this->reportable(function (Throwable $e) {
        //     var_dump($e);
        // });

        // untuk mencampilkan view jika exception tidak di report
        $this->renderable(function (ValidationException $exception, Request $request) {
            return response("Bad Request", 400);
        });
    }
}
