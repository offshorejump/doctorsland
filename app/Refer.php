<?php

namespace App;
use Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Refer extends Model
{
	protected $with = ["Patients", "ReferedTo", "ReferedBy"];
	
    public function patients()
    {
        return $this->belongsTo('App\Patient', "patient_id", "id");
    }
	
	public function referedto()
    {
        return $this->belongsTo('App\User', "refer_to", "id");
    }
	
	public function referedby()
    {
        return $this->belongsTo('App\User', "refer_by", "id");
    }
}
