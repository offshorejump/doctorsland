<?php

namespace App\Http\Controllers;

use Auth;
use App\Refer;
use App\Patient;
use App\User;

use Validator;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ReferController extends Controller
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
     * Controller Method: List all Tickets
     **/
    public function index()
    {

		$patients = Patient::where("created_by", Auth::user()->id)->get();



		$doctors  = User::where(["role_id" => 2])->whereNotIn("id", [Auth::user()->id])->get();

		return view('patients.refer')->with([
            'patients' 	=> $patients,
			'doctors'   => $doctors,
        ]);
	}


	/**
	*	Controller Method: Add Patient Refering Record
	**/
	public function add(Request $request)
	{
		$input = [
            "patient_id" 	=> $request->patient_id,
            "refer_to"		=> $request->refer_to,
        ];


        $rules = [
            'patient_id' 	=> 'required',
            'refer_to'		=> 'required',
        ];

        $messages =  [
            'patient_id.required' 	=> 'Select Patient from List.',
            'refer_to.required' 	=> 'Select Doctor from List.',
        ];

        $validate = Validator::make($input,$rules, $messages);

        if($validate->passes())
        {
			$refering = new Refer;

            $refering->patient_id	= $request->patient_id;
            $refering->refer_to		= $request->refer_to;
            $refering->refer_by 	= Auth::user()->id;
            $refering->findings 	= $request->findings;
            $refering->reason 		= $request->reason;
			$refering->refer_date	= date("Y-m-d", strtotime($request->refer_date));

            $result = $refering->save();

			if( $result == 1 )
			{
				return "Success";
            } else {
                return "error";
            }

		} else {
            $messages = $validate->messages();
            $messages = json_decode( $messages );
            $message_html = "";

            foreach($messages as $index => $value) {
                $message_html .=  "<p>".$value[0]."</p>";
            }


			return $message_html; //redirect()->back()->with("error", $message_html);
        }


	}



	public function referedtodoctor(Request $request)
	{
		$patients = Refer::where("refer_by", Auth::user()->id)->get();
		return view('patients.referbyme')->with(['patients' => $patients ]);
	}

	public function referedtome( Request $request )
	{
		$patients = Refer::where("refer_to", Auth::user()->id)->get();
		return view('patients.refertome')->with(['patients' => $patients ]);
	}



	/**
    *	Fetch Patient by ID
    */
    public function view_by_id(Request $request)
    {

        $patient = Refer::find($request->id);

        if( isset( $patient )  &&  !is_null( $patient ) > 0 ) {

    			if( empty( $patient->patients->avatar ) ) {
    				$avatar_image = "no-image.png";
    			} else {
    				$avatar_image = $patient->patients->avatar;
    			}

    			$returndata = '<div class="box-body">
    				<table class="table table-bordered table-striped">
    					<tr><th>Picture</th><td><img width="84" height="84" src="'.url("/assets/images/")."/".$avatar_image.'" alt="No Image"></td></tr>
    					<tr><th>Full Name</th><td>'.$patient->patients->name.'</td></tr>
    					<tr><th>Date of Birth</th><td>'.$patient->patients->dob.'</td></tr>
    					<tr><th>Email</th><td>'.$patient->patients->email.'</td></tr>
    					<tr><th>Address</th><td>'.$patient->patients->address.'</td></tr>
    					<tr><th>Phone</th><td>'.$patient->patients->phone.'</td></tr>
    					<tr><th>Insurance Name</th><td>'.$patient->patients->insurance_name.'</td></tr>
    					<tr><th>Insurance Type</th><td>'.$patient->patients->insurance_type.'</td></tr>
    					<tr><th>Insurance Number</th><td>'.$patient->patients->insurance_number.'</td></tr>
    					<tr><th>Referred By</th><td>'.$patient->referedby->name.'<br><span style="font-size:12px; color:#090;">'.$patient->referedby->address.'</label></td></tr>
    					<tr><th>Dated</th><td>'.date("Y-m-d", strtotime($patient->refer_date)).'</td></tr>
    					<tr><th>Reason of Reffering</th><td>'.$patient->reason.'</td></tr>
    				</table>
    			</div>';

    			$patient->is_viewed = 1;
    			$patient->save();
    		} else {


    			$returndata = '<div class="box-body">
    				<table class="table table-bordered table-striped">
    					<tr><td>No Patient Found</td></tr>

    				</table>
    			</div>';
    		}

        return $returndata;
    }



	/**
	*
	**/
	public function show_by_id($id)
	{
		$patient = Refer::find($id);


		if( Auth::check() && $patient->refer_to == Auth::user()->id ) {
			$patient->is_viewed = 1;
			$patient->save();

			return view("patients.referredsingle")->with("patient", $patient);
			//
		} else {
			$errors = ["You are not authorized to see this page."];
          	return view("errors.notauthorized")->with("errors", $errors);
        }
	}


}
