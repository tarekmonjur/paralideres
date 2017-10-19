<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class WebController extends Controller
{
    protected $auth;


    public function __construct()
    {
        $this->middleware(function($request, $next){
            $this->auth = Auth::user();
            view()->share('auth',$this->auth);
            return $next($request);
        });
    }

}
