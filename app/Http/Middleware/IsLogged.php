<?php

// app/Http/Middleware/IsLogged.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsLogged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Your middleware logic here
        if (!auth()->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
