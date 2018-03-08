<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Closure;
use DB;

class MainController extends Controller {
    
    public function main(Request $req, Closure $next, $token) {

        $token = substr($req->url(), 26);        
        
        $token_expiration = date("Y-m-d H:i:s", time() + 18000);
    
        DB::table('users')
            ->where([
                ['token', '=', 'c1ca62403744b69047754f4e0fed319d82716bd1'],
            ])->update(array(
                'token_expiration' => $token_expiration
        ));
        
        return $next($request);
    }

}



    