<?php
 
namespace App\Exceptions;
 
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Auth;
class Handler extends ExceptionHandler
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        if ($request->is('patient') || $request->is('patient/*')) {
            return redirect()->guest('/login/patient');
        }

        if ($request->is('medecin') || $request->is('medecin/*')) {
            return redirect()->guest('/login/medecin');
        }


        if ($request->is('secretaire') || $request->is('secretaire/*')) {
            return redirect()->guest('/login/secretaire');
        }
 
        
 
        return redirect()->guest(route('login'));
    }
}