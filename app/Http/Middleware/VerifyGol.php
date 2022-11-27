<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Utils\ApiResponseTrait;
use Auth;
use Closure;
use Illuminate\Http\Request;

class VerifyGol
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->hasRole([Role::ADMINISTRADOR, Role::CAPELLAN])) {
            if (Auth::user()->person->cycle->gol == null) {
                return $this->respondForbidden('El ciclo al que pertenece este usuario no tiene un gol asignado.');
            }
        }

        return $next($request);
    }
}
