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
        '/'
    ];

    public function render($request, Exception $exception) { 
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            //https://gist.github.com/jrmadsen67/bd0f9ad0ef1ed6bb594e 
            //https://laravel.com/docs/5.6/validation#quick-displaying-the-validation-errors 
            $errors = new \Illuminate\Support\MessageBag(['password' => 'For security purposes, the form expired after sitting idle for too long. Please try again.']); 
            return redirect() 
            ->back() 
            ->withInput($request->except($this->dontFlash)) 
            ->with(['errors' => $errors]); } 
            return parent::render($request, $exception); 
        }
}
