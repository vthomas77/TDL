<?php

namespace App\Http\Middleware;

use Illuminate\Http\RedirectResponse;
use Closure;
use DB;

class MainMiddleware 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($req, Closure $next)
    {
        $token = $req->route()[2]['token'];        
        
        $token_expiration = date("Y-m-d H:i:s", time() + 18000);
    
        DB::table('users')
            ->where([
                ['token', '=', $token],
            ])->update(array(
                'token_expiration' => $token_expiration
        ));
        
        //var_dump($token);
        
        return $next($req);
    }

}
