<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Company;
use App\Country;


class SuperController extends Controller
{
    /**
     * Create a new controller instance.
     **/
    public function __construct()
    {
        $this->middleware('auth');

        parent::__construct();
    }
	
	
	
	/**
	*	List All Companies for Super Admin
	**/
	public function index()
	{
		
		// Permission Check
        if( Auth::user()->role_id != 1 ) {
            $errors = ["You are not authorized to see this page."];
            return view("errors.notauthorized")->with("errors", $errors);
        }
	}
}
