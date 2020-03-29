<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Specialization;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProfileSettingController extends Controller
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
     * Controller Method: Get Profile Details
     **/
    public function get_profile()
    {
        $profile_data = User::all()->where("id", Auth::user()->id);
		$specialization = Specialization::get();
		
		//dd( $profile_data );
		/*foreach( $profile_data as $profile )
		{
			
		}*/
		
        return view("settings.profile")->with([
						'profiles' 	=> $profile_data,
						'types'		=> $specialization
					]);
    }


    /**
    *  Controller Method: Update Profile Details
    */
    public function update_profile(Request $request)
    {	
		//dd( $request );
		$fileName = "";
		$fileName_certificate = "";
		
		if (Input::hasFile('avatar'))
        {
            if (Input::file('avatar')->isValid()) {
                $destinationPath = 'dist/img'; 
                $extension = Input::file('avatar')->getClientOriginalExtension();
                $fileName = date("YmdHis").rand(111, 999).'.'.$extension; 
				Input::file('avatar')->move($destinationPath, $fileName);
            }
        } 
		
		if (Input::hasFile('certificate'))
        {
            if (Input::file('certificate')->isValid()) {
                $destinationPath = 'dist/img'; 
                $extension = Input::file('certificate')->getClientOriginalExtension();
                $fileName_certificate = "certificate_".date("YmdHis").rand(11, 99).'.'.$extension; 
				Input::file('certificate')->move($destinationPath, $fileName_certificate);
            }
        } 
		
		
        $profile = User::find( Auth::user()->id );
	        $profile->first_name = $request->first_name;
    	    $profile->last_name  = $request->last_name;
        	$profile->name       = $request->first_name . " " . $request->last_name;
	        $profile->email      = $request->email;
    	    $profile->address    = $request->address;
        	$profile->phone      = $request->phone;
			$profile->avatar	 = $fileName;
			$profile->certificate	 = $fileName_certificate;
			
			if( Auth::check() && Auth::user()->role_id > 1 ) {
				$profile->qualifications  = $request->qualification;
				$profile->type = $request->specialization;
			}
			
        $response = $profile->save();
				
		if( $response == 1 || $response == NULL )
			return redirect()->back()->with("Success", "Profile Updated Successfully.")->withInput();
					
		return redirect()->back()->with("Error", "An Error Occured! Please! try again.");
			
    }

}
