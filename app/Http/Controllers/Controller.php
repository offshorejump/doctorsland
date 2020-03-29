<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

        $this->middleware(function ($request, $next) {

           view()->share('signedIn', Auth::check());

           if (Auth::check()) {

               view()->share('signedInUser', Auth::user());
               view()->share('Admin', Auth::user()->hasRole('admin'));

           } else {

               view()->share('user', NULL);
               view()->share('Admin', FALSE);

           }

           return $next($request);

       });
    }
}
