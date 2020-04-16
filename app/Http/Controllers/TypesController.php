<?php

namespace App\Http\Controllers;

use Auth;
use App\Specialization;

use Illuminate\Http\Request;

class TypesController extends Controller
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
     * Controller Method: List all Types
     **/
    public function index()
    {
        $types = Specialization::all();

        return view('types.index')->with([
          'types' 	=> $types,
        ]);
    }


	public function new_type(Request $request)
	{
		$type = new Specialization();

		$type->title = $request->title;
		$result = $type->save();

		if( $result == 1 || $result == "1" ) {
			return "Success";
		} else {
			return $result;
		}



	}



	/**
	*
	**/
	public function get_type(Request $request)
	{
		$type_result = Specialization::where("id", $request->id)->get();

        $returndata = '<div class="box-body">
          <input type="hidden" name="id" id="id" value="' . $type_result[0]->id . '"/>
          <div class="form-group">
            <label>Type Name/Title</label>
            <input class="form-control" type="text" name="title" id="title" value="' . $type_result[0]->title . '"/>
          </div>
	     </div>';

        return $returndata;
	}


	/**
	*	Update Type
	**/
	public function update_type(Request $request)
	{
		//$request->id = 4;

		$type = Specialization::find( $request->id );
            $type->title   = $request->title;
        $result = $type->save();

        if( $result == 1 || empty( $result )) {
            return "Success";
        } elseif( $result == 0 ) {
            return "Nothing to Update";
        } else {
            return "Error";
        }
	}


	/**
	*
	**/
	public function new_type_form(){
		return view('types.newtypes');
	}
	/*
	*
	**/
	public function save_new_type(Request $request)
	{
		$type = new Specialization();
			$type->title = $request->title;
			$type->created_by = Auth::user()->id;
		$status = $type->save();

		if( $status == 1 || empty( $status )) {
				return redirect()->back()->with("Success", "New Type Created Successfully.")->withInput();
			} elseif( $status == 0 ) {
				return redirect()->back()->with("Success", "Nothing to Creat.")->withInput();
			} else {
				return redirect()->back()->with("Error", "An Error Occured. Please! try again.")->withInput();
			}
	}
}
