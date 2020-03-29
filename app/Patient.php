<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
	protected $with = ["Doctor"];
	 /**
     * The roles that belong to the user.
     */
    public function doctor()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
