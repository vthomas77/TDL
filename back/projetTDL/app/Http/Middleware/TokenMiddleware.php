<?php

namespace App\Http\Middleware;

use Illuminate\Http\RedirectResponse;
use Closure;
use DB;

class TokenMiddleware 
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
        $token = $request->route()[2]['token'];
        
        $token_expiration = DB::table('users')
          ->select('token_expiration')
          ->where('token','=', $token)
          ->get();
        
        $yet = date('Y/m/d h:i:s', time() +3600);
        
        $token_expiration = str_replace("-", "", $token_expiration);
        $token_expiration = str_replace(":", "", $token_expiration);
        $token_expiration = str_replace(" ", "", $token_expiration);
        $token_expiration = intval($token_expiration);
        
        $yet = str_replace("/", "", $yet);
        $yet = str_replace(":", "", $yet);
        $yet = str_replace(" ", "", $yet);
        $yet = intval($yet);
        
        if($token_expiration <= $yet) {            
            //return redirect()->to("/" + $token);
            return $next($request);
        } else {
            return $next($request);
        }
    }

}
