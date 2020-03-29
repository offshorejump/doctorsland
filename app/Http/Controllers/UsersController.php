<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use App\specialization;

use Session;
use Validator;
//use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Facades\Datatables;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }


    /**
     * Display the users page according to type (Admin, Doctor).
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_type)
    {
		// Permission Check
        if( Auth::user()->role_id != 1 ){
            $errors = ["You are not authorized to see this page."];
            return view("errors.notauthorized")->with("errors", $errors);
        }
		
				
        // Making Single Controler for All Users
        $user_list = new User();

			

        if( $user_type == "admins") {			//	If User Type is Admin
            $userlist = User::where(['role_id' => 1]);
            $title  = 'Administrator';
            $op_key = 'admin';
        } elseif( $user_type == "doctors" ) {		//	If User Type is Staff
            $userlist = User::where(['role_id' => 2]);
            $title  = 'Doctor';
            $op_key = 'doctor';

        }
		
        $userlist = $userlist->with(["Levels", "Roles"])->get();
		
		$type = specialization::get();
		
		//dd( $userlist );
		
        return view('users.index')->with([
            'userlist' 	=> $userlist,
            'op_key' 	=> $op_key,
            'title' 	=> $title,
			'types'		=> $type,
        ]);
    }


    /**
     * Save New User
     *
     * Type paramerter:
     */
    public function new_user($user_type, Request $request)
    {
        $role_id = isset( $request->roles )? $request->roles : 1;

        $user = new User();
            $user->first_name = $request->firstname;
            $user->last_name  = $request->lastname;
            $user->name       = $request->firstname." ".$request->lastname;
            $user->email      = $request->email;
            $user->password   = bcrypt($request->password);
            $user->role_id    = $role_id;
        $result = $user->save();

        if( $result == 1 || empty($result))
            return 'Success';

        return 'Error';
    }


    /**
     *  Get User data by id
     **/
    public function get_user_byId(Request $request) 
    {	
        $user_result = User::where("id", $request->id)->get();
        $returndata = '';
		
		$partials = '';
		$type = specialization::get();
		$type_data = "";
		
		
		foreach( $type as $type )
		{
			$type_data .= "<option value='".$type->id."' ".(($user_result[0]->type == $type->id)?"selected":"").">".$type->title."</option>";
		}
				
		if( $user_result[0]->role_id > 1 ) {
			$partials = '<div class="form-group">
				<label>Type of Doctor</label>
				<select class="form-control" name="type" id="type">
				'.$type_data.'
				</select>
			  </div>';
		}	
		
		

        $returndata .= '<div class="box-body">
          <input type="hidden" name="id" id="id" value="' . $user_result[0]->id . '"/>
		  <input type="hidden" name="roles" id="roles" value="' . $user_result[0]->role_id . '"/>
          <div class="form-group">
            <label>First Name</label>
            <input class="form-control" type="text" name="first_name" id="first_name" value="' . $user_result[0]->first_name . '"/>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input class="form-control" type="text" name="last_name" id="last_name" value="' . $user_result[0]->last_name . '"/>
          </div>
          <div class="form-group">
            <label>Email Address</label>
            <input class="form-control" type="text" name="email" id="email" value="' . $user_result[0]->email . '"/>
          </div>
		  <div class="form-group">
            <label>Address</label>
            <textarea class="form-control" name="address" id="address">' . $user_result[0]->address . '</textarea>
          </div>
		  <div class="form-group">
            <label>Phone</label>
            <input class="form-control" type="text" name="phone" id="phone" value="' . $user_result[0]->phone . '"/>
          </div>'.$partials.'
	     </div>';

        return $returndata;
    }



    /**
     * Update Admin/Staff by Id
     *
     **/
    public function update_user(Request $request) 
    {
        $role_id = isset( $request->roles )? $request->roles : 1;

        if( isset( $request->id ))
        {
            $user_id = $request->id;
        } elseif( isset( $request->u_id ) ) {
            $user_id = $request->u_id;
        } else {
            $user_id = 0;
        }

        $user = User::find( $user_id );
            $user->first_name   = $request->first_name;
            $user->last_name    = $request->last_name;
            $user->name         = $request->first_name . " " . $request->last_name;
			$user->address		= $request->address;
			$user->phone		= $request->phone;
		
        if( isset( $request->email) && !empty( $request->email )  ) {
            $user->email = $request->email;
        }
		
		if( isset( $request->type) && !empty( $request->type )  ) {
            $user->type = $request->type;
        }
		
		if( Auth::check() && Auth::user()->role_id > 2 ) {
			$user->qualification  = $request->qualification;
			$user->type = $request->type;
		}
		

            $user->role_id  = $role_id;

        $result = $user->save();

        if( $result == 1 || empty( $result )) {
            return "Success";
        } elseif( $result == 0 ) {
            return "Nothing to Update";
        } else {
            return "Error";
        }
    }



    /**
     * Display listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax()
    {
        $actions = '<div class="btn-group btn-group-justified">
            <div class="btn-group" role="group">
            <a class="btn btn-primary btn-xs" href="{{ url(\'/users/\'.$id.\'/edit\') }}">
                    <i class="glyphicon glyphicon-edit"></i>
                </a>
            </div>
            <div class="btn-group" role="group">
                <a href="#" class="btn btn-danger btn-xs" data-delete data-token="{{ csrf_token() }}" data-action="{{ url(\'/admin/users/\'.$id) }}">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </div>
        </div>';
        return Datatables::eloquent(User::with('roles'))
                ->addColumn('actions', $actions)->make(true);
    }


    /**
     * Display a change password form.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_password()
    {
        $user    = Auth::user();
        $profile = Auth::user()->profile;

        return view('users.change_password', ['usr' => $user, 'profile' => $profile]);
    }


    /**
     * Update the specified user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        if ($request->id != Auth::user()->id) {
            $request->session()->flash('Error', 'You don\'t have permission to perform the action');
            return redirect('settings/profile');
        }

        $this->validate($request, [
            'current' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);


        $user    = User::findOrFail($request->id);
        $current = bcrypt($request->current);
        $data['password'] = bcrypt($request->password);

        if ( ! Hash::check($request->current, $user->password)) {
            $request->session()->flash('Error', 'Plesae type the correct current password.');
            return redirect('settings/profile');
        }


        $user->update($data);
        $request->session()->flash('Success', 'Your password has successfully changed.');	

        return redirect('settings/profile');
    }


    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Request $request ) {
        User::destroy($request->user_id);

        if ( $request->ajax() ) {
            return response(['status' => 'success', 'message' => 'User successfully deleted,']);
        }

        flash()->success('Success!', 'User successfully deleted.');
        return redirect('/admin/users');
    }
	
	
	
	
	/**
    *	Fetch Patient by ID
    */
    public function doctor_by_id(Request $request)
    {		
        $doctor = User::find($request->id);
		
		if( isset( $doctor )  &&  count( $doctor ) > 0 ) {
			
			if( empty( $doctor->avatar ) ) {
				$avatar_image = "no-image.png";
			} else {
				$avatar_image = $doctor->avatar;
			}
			$returndata = '<div class="box-body">
				<table class="table table-bordered table-striped">
					<tr><th>Picture</th><td><img src="'.url("/assets/images/")."/".$avatar_image.'" alt="No Image"></td></tr>
					<tr><th>Full Name</th><td>'.$doctor->name.'</td></tr>
					<tr><th>Email</th><td>'.$doctor->email.'</td></tr>
					<tr><th>Address</th><td>'.$doctor->address.'</td></tr>
					<tr><th>Phone</th><td>'.$doctor->phone.'</td></tr>
					<tr><th>Qualification</th><td>'.$doctor->qualifications.'</td></tr>
				</table>
			</div>';
		} else {
			$returndata = '<div class="box-body">
				<table class="table table-bordered table-striped">
					<tr><td>No Doctor Found: '.$request->id.'</td></tr>
					
				</table>
			</div>';
		}
		
        return $returndata;
    }



    /**
    *   Delete User
    **/
    public function delete( Request $request )
    {
        return User::destroy($request->user_id);
    }
	
	/**
	*	New Account Page
	**/	

	public function new_account_form($type = "doctor"){
		 //$profile_data = User::all()->where("id", Auth::user()->id);
		$type = specialization::get();
		
        return view("users.newdoctor")->with([
						//'profiles' 	=> $profile_data,
						'types'		=> $type
					]);
	}
	
	
	/***
	*
	*
	***/
	/**
     * Update Admin/Staff by Id
     *
     **/
    public function new_account_post(Request $request) 
    {
		//dd($request);

		$input = [
            "first_name" 	=> $request->first_name,
			"last_name" 	=> $request->last_name,
            "email"			=> $request->email,
			"password"		=> $request->password,
        ];


        $rules = [
            'first_name' 	=> 'required|min:3',
			'last_name' 	=> 'required|min:3',
            'email'			=> 'unique:users,email|required|min:5',
			'password'		=> 'required|min:8',
        ];

        $messages =  [
            'first_name.required' 	=> 'Enter First Name.',
            'last_name.required' 	=> 'Enter Last Name',
            'email.required' 		=> 'Correct Email.',
			'email.unique' 		=> 'Email Already Exists.',
			'password.required' 	=> 'Enter Insurance Number',
        ];

        $validate = Validator::make($input,$rules, $messages);

        if($validate->passes())
        {
			$role_id = 2;

			$user = new User();
				$user->first_name   = $request->first_name;
				$user->last_name    = $request->last_name;
				$user->name         = $request->first_name . " " . $request->last_name;
				$user->address		= $request->address;
				$user->phone		= $request->phone;
				$user->company_name = $request->company_name;
				$user->password		= bcrypt($request->password);
				
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
					//"requesting" => $request
					]);
		}
		
		
		
    }
	
}
