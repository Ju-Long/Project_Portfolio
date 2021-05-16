<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'stripe/*',
        'http://localhost:8000/email',
        'https://babasama.com/email',
        'http://localhost:8000/api/signup',
        'https://babasama.com/api/signup',
    ];
}
