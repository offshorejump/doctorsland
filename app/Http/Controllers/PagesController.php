<?php

namespace App\Http\Controllers;
use App\Role;

class PagesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Home page
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('pages.home');
    }

}
