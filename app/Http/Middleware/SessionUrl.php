<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SessionUrl
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

        if( $request->getMethod() == 'GET'){

            $links = session()->has('links') ? session('links') : [];
            $currentLink = $request->getRequestUri(); // Getting current URI like 'category/books/'

            if( count($links) === 0 || $links[0] != $currentLink){
                array_unshift($links, $currentLink); // Putting it in the beginning of links array
                $links = array_slice($links, 0, 5);
                session(['links' => $links]);
            }
        }

        return $next($request);
    }
}
