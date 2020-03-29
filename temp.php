<?php

use App\UsersModules;

if (!function_exists('flash')) {
    function flash($title = null, $message = null)
    {
        $flash = app('App\Http\Flash');

        if (func_num_args() == 0) {
            return $flash;
        }

        return $flash->info($title, $message);
    }
}

if (!function_exists('set_active')) {
    function set_active($path, $active = 'active') {
        return call_user_func_array('Request::is', (array)$path) ? $active : '';
    }
}


/**
 *	
 **/
if (!function_exists('load_permissions_module')) {
	function load_permissions_module( $level ){
		$permissions = UsersModules::where("role_id", $level)->get();
		
		$html = '';
		
		foreach( $permissions as $permission ) {
			//$permission_list[$permission->module_id] = $permission->Modules->key_title;
		}
		
		return $permissions;
	}
}