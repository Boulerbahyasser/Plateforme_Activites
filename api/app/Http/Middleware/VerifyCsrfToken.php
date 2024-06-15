<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{

    protected $except = [
// Cette route ne va pas appeler le token CSRF.
        'test/ask-csrf-token'
    ];
}
