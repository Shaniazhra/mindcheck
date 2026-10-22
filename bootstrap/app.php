<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureRole::class,
        ]);

        // Aktifkan HANYA jika server berada di belakang proxy / load balancer /
        // Cloudflare (supaya https dan IP pengunjung terbaca benar, dan link
        // verifikasi email tidak ditolak). Jangan aktifkan kalau tidak perlu.
        // $middleware->trustProxies(at: '*');

        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is(
                'dashboard',
                'riwayat',
                'riwayat/*',
                'riwayat_angkatan',
                'riwayat_angkatan/*',
                'kelas',
                'kelas/*',
                'super-admin/*'
            )) {
                return '/login-guru';
            }

            return '/login';
        });

        $middleware->redirectUsersTo('/');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();