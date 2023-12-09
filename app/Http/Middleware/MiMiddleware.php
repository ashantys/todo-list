<?php

namespace App\Http\Middleware;

use Closure;

class MiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Verifica la lógica para determinar si la edad está permitida
        $title = $request->input('title');

        if ($title != "a") {
            // Redirige a la ruta de destino si la edad no está permitida
            return response()->json(["message" => "No es a chamaco baboso"]);
        }

        return $next($request);
    }
}
