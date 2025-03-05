<?php

use App\Http\Middleware\AdminApotekerMiddleware;
use App\Http\Middleware\AdminDokterApotekerMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminKasirMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DokterApotekerMiddleware;
use App\Http\Middleware\NonPelangganMiddleware;
use App\Http\Middleware\PelangganMiddleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin.apoteker' => AdminApotekerMiddleware::class,
            'admin.dokter.apoteker' => AdminDokterApotekerMiddleware::class,
            'admin.kasir' => AdminKasirMiddleware::class,
            'admin' => AdminMiddleware::class,
            'dokter.apoteker' => DokterApotekerMiddleware::class,
            'non.pelanggan' => NonPelangganMiddleware::class,
            'pelanggan' => PelangganMiddleware::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
