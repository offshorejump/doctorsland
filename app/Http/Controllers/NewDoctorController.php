<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\specialization;
use Validator;
use App\User;

//  CODE ON THIS PAGE IS IN BAD STRUCTURE. NEED TO WORK that
//  add_new_doctor METHOND HAS BUGS. NEED TO RESOLVE ASAP


class NewDoctorController extends Controller
{
    /**
     * Create a new controller instance.
    **/
    public function __construct()
    {
        parent::__construct();
    }


    /**
    * Show New Docotor Form
    **/
    public function index()
    {
        $type = specialization::get();

        return view("doctor.index")->with([
           'types' => $type
        ]);
    }



    /**
    *   Create Doctor Account
    **/
    public function add_new_doctor(Request $request)
    {
		    //dd($request);

        /*echo "<pre>";
          print_r( $request );
        echo "</pre>";
        exit;*/

        $input = [
           "first_name" =>  $request->first_name,
           "last_name"  =>  $request->last_name,
           "email"      =>  $request->email,
           "password"   =>  $request->password,
        ];


        $rules = [
           'first_name' => 'required|min:3',
           'last_name'  => 'required|min:3',
           'email'      => 'unique:users,email|required|min:5',
           'password'   => 'required|min:8',
        ];


        $messages =  [
            'first_name.required' => 'Enter First Name.',
            'last_name.required'  => 'Enter Last Name',
            'email.required'      => 'Correct Email.',
            'email.unique'        => "Email Already Exists. If you already have account <a href='/login'>Click Here to Login</a>",
            'password.required'   => 'Enter Insurance Number',
        ];

        $validate = Validator::make($input,$rules, $messages);

        if($validate->passes())
        {
            $role_id = 2;

            $user = new User();
               $user->first_name    =  $request->first_name;
               $user->last_name     =  $request->last_name;
               $user->name          =  $request->first_name . " " . $request->last_name;
               $user->address       =  $request->address;
               $user->phone         =  $request->phone;
               $user->company_name  =  $request->company_name;
               $user->password      =  bcrypt($request->password);

               if( isset( $request->email) && !empty( $request->email )  ) {
                   $user->email = $request->email;
               }

			$user->qualifications  = $request->qualification;
			//if( isset( $request->specialization) && !empty( $request->specialization )  ) {
				$user->type = $request->specialization;
			//}

			//dd($request->specialization);
			$user->role_id  = $role_id;
	//dd($user);
			$result = $user->save();

			if( $result == 1 || empty( $result )) {
				return redirect()->back()->with("Success", "New Doctor Created Successfully.")->withInput();
			} elseif( $result == 0 ) {
				return redirect()->back()->with("Success", "Nothing to Update.")->withInput();
			} else {
				return redirect()->back()->with("Error", "An Error Occured. Please! try again.")->withInput();
			}
		}else {
			$messages = $validate->messages();
            $messages = json_decode( $messages );
            $message_html = "";

            foreach($messages as $index => $value) {
                $message_html .=  $value[0]."";
            }

            return redirect()->back()->with([
                "Error" => $message_html,
                "requesting" => $request
            ]);
        }



    }








}
