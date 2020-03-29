<?php

namespace App\Http\Controllers;

use Auth;
use App\Patient;
use App\User;

use Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Facades\Datatables;

use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PatientController extends Controller
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
     * Controller Method: List all Patients
     **/
    public function index()
    {
		if( Auth::user()->role_id == 1 ) {
			$patientlist = Patient::all();
		} else {
			$patientlist = Patient::where("created_by", Auth::user()->id)->get();
		}
				
		return view('patients.index')->with([
            'patientlist' 	=> $patientlist,
        ]);
	}
	
	
	/**
	*	Controller Method: Get Patient By ID
	**/
	public function get_by_Id(Request $request)
	{
		$patient_result = Patient::where("id", $request->id)->get();
        $returndata = '';

        if( $patient_result[0]->role_id > 2 ) {
            $returndata .= '<input type="hidden" id="roles" name="roles" value="'.$patient_result[0]->role_id.'">';
        }
		
		/*echo "<pre>";
			print_r( $patient_result );
		echo "</pre>";*/

        $returndata .= '<div class="box-body">
          <input type="hidden" name="id" id="id" value="' . $patient_result[0]->id . '"/>
		  <input type="hidden" name="roles" id="roles" value="' . $patient_result[0]->role_id . '"/>
          <div class="form-group">
            <label>First Name</label>
            <input class="form-control" type="text" name="first_name" id="first_name" value="' . $patient_result[0]->first_name . '" required="required"/>
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input class="form-control" type="text" name="last_name" id="last_name" value="' . $patient_result[0]->last_name . '" required="required"/>
          </div>
          <div class="form-group">
            <label>Email Address</label>
            <input class="form-control" type="text" name="email" id="email" value="' . $patient_result[0]->email . '" required="required" />
          </div>
		  <div class="form-group">
            <label>Address</label>
            <textarea class="form-control" name="address" id="address">' . $patient_result[0]->address . '</textarea>
          </div>
		  <div class="form-group">
            <label>Phone</label>
            <input class="form-control" type="text" name="phone" id="phone" value="' . $patient_result[0]->phone . '"/>
          </div>
		  <div class="form-group">
            <label>Insurance Name</label>
            <input class="form-control" type="text" name="insurance_name" id="insurance_name" value="' . $patient_result[0]->insurance_name . '" required="required"/>
          </div>
		  <div class="form-group">
            <label>Insurance Type</label>
            <input class="form-control" type="text" name="insurance_type" id="insurance_type" value="' . $patient_result[0]->insurance_type . '" required="required"/>
          </div>
		  <div class="form-group">
            <label>Insurance Number</label>
            <input class="form-control" type="text" name="insurance_number" id="insurance_number" value="' . $patient_result[0]->insurance_number . '" required="required"/>
          </div>
          
        </div>';

        return $returndata;
	}
	
	
	/**
	*	Controller MEthod: Update Patient Information
	**/
	public function update(Request $request)
	{
		
        if( isset( $request->id ))
        {
            $patient_id = $request->id;
        } elseif( isset( $request->u_id ) ) {
            $patient_id = $request->u_id;
        } else {
            $patient_id = 0;
        }

		
		
        $patient = Patient::find( $patient_id );
            $patient->first_name   	= $request->first_name;
            $patient->last_name    	= $request->last_name;
            $patient->name         	= $request->first_name . " " . $request->last_name;
			$patient->address		= $request->address;
			$patient->phone			= $request->phone;
			$patient->insurance_name	= $request->insurance_name;
			$patient->insurance_type	= $request->insurance_type;
			$patient->insurance_number	= $request->insurance_number;
			
        if( isset( $request->email) && !empty( $request->email )  )
        {
            $patient->email = $request->email;
        }

        $result = $patient->save();

        if( $result == 1 || empty( $result )) {
            return "Success";
        } elseif( $result == 0 ) {
            return "Nothing to Update";
        } else {
            return "Error";
        }	
	}
	
	
	/**
    *	Add new Patient Page
    */
    public function new_Patient(Request $request)
    {
        return view("patients.new");
    }
	
	
	/**
	*	New Patient
	**/
	public function add_patient(Request $request)
	{
		
		$input = [
            "first_name" 	=> $request->first_name,
			"last_name" 	=> $request->last_name,
            "email"			=> $request->email,
			"insurance_name"		=> $request->insurance_name,
			"insurance_type"		=> $request->insurance_type,
			"insurance_number"		=> $request->insurance_number,
        ];


        $rules = [
            'first_name' 	=> 'required|min:3',
			'last_name' 	=> 'required|min:3',
            'email'			=> 'unique:patients,email',
			'insurance_name'		=> 'required|min:5',
			'insurance_type'		=> 'required|min:5',
			'insurance_number'		=> 'required|min:3',
        ];

        $messages =  [
            'first_name.required' 	=> 'Enter First Name.',
            'last_name.required' 	=> 'Enter Last Name',
            'email.required' 		=> 'Correct Email.',
			'insurance_name.required' 	=> 'Enter Insurance Name',
			'insurance_type.required' 	=> 'Enter Insurance Type',
			'insurance_number.required' 	=> 'Enter Insurance Number',
        ];

        $validate = Validator::make($input,$rules, $messages);

        if($validate->passes())
        {		
			$avatar_fileName 	= "";
			
			if (Input::hasFile('avatar'))
			{
				if (Input::file('avatar')->isValid()) {
					$destinationPath = 'assets/images'; // upload path
					$extension = Input::file('logo')->getClientOriginalExtension(); // getting image extension
					$avatar_fileName = "logo_".date("YmdHis").rand(111,999).'.'.$extension; // renameing image
					Input::file('avatar')->move($destinationPath, $avatar_fileName); // uploading file to given path
				  
				} else {
					return "Avatar Could be Uploaded.";
				}
			}
			
			
           $patient = new Patient;

            $patient->first_name	= $request->first_name;
            $patient->last_name		= $request->last_name;
			$patient->name       	= $request->first_name." ".$request->last_name;
            $patient->address 		= $request->address;
            $patient->phone 		= $request->phone;
            $patient->email 		= $request->email;
			$patient->insurance_name	= $request->insurance_name;
			$patient->insurance_type	= $request->insurance_type;
			$patient->insurance_number 	= $request->insurance_number;
            $patient->avatar 		= $avatar_fileName;
			$patient->created_by 	= Auth::user()->id;

            $result = $patient->save();

            if( $result == 1 ) 
			{	
				return "Success";
            } else {
                return "An Error Occured";
            }
		} else {
            $messages = $validate->messages();
            $messages = json_decode( $messages );
            $message_html = "";

            foreach($messages as $index => $value) {
                $message_html .=  "<p>".$value[0]."</p>";
            }


			return $message_html;
            //return $message_html;
        }	
	}

	
	

	
	/**
    *   Delete Patient
    **/
    public function delete( Request $request )
    {
        return Patient::destroy($request->patient_id);
    }
}
