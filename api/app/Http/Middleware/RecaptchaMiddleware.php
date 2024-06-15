<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use ReCaptcha\ReCaptcha;

class RecaptchaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRET_KEY'));
        $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        if (!$response->isSuccess()) {
            return response()->json(['error' => 'reCAPTCHA validation failed'], 422);
        }

        return $next($request);
    }
}