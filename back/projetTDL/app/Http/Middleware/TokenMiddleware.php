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
        
        $token_expiration = DB::table('users')
          ->select('token_expiration')
          ->where('token','=', 'c1ca62403744b69047754f4e0fed319d82716bd1')
          ->get();
        
        $yet = date('Y/m/d h:i:s', time() +3600);
        
        $token_expiration = str_replace("-", "", $token_expiration);
        $token_expiration = str_replace(":", "", $token_expiration);
        $token_expiration = str_replace(" ", "", $token_expiration);
        
        $yet = str_replace("/", "", $yet);
        $yet = str_replace(":", "", $yet);
        $yet = str_replace(" ", "", $yet);
        
        $token_expiration =1;
        
        if($token_expiration <= $yet) {
            
            $username = DB::table('users')
                ->select('username')
                ->where('token', '=', 'c1ca62403744b69047754f4e0fed319d82716bd1')
                ->get();
            
            $password = DB::table('users')
                ->select('password')
                ->where('token', '=', 'c1ca62403744b69047754f4e0fed319d82716bd1')
                ->get();
            
            return redirect()->to("/");
        } else {
            return $next($request);
        }
    }

}
