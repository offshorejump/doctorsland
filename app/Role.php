<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;
use Savannabits\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function get_role(){
        $rolelist = DB::table('roles')->get();
        return $rolelist;
    }
	
	
	
	/**
	 *	Reltionship to Permission Table
	 **/
	public function usersmodules()
	{
		return $this->hasMany('App\UsersModules', 'role_id');	
	}
	
	/**
	 *	Reltionship to Users Table
	 **/
	public function totalusers()
	{
		return $this->hasMany('App\User', 'role_id');
	}
}
