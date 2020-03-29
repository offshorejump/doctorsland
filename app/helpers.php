<?php

use App\UsersModules;
use App\Refer;
use App\User;

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


if (!function_exists('nonviewed_patient_notifications')) {
    function nonviewed_patient_notifications() {
		$notification = Refer::where([
			"refer_to"  => (Auth::check())?Auth::user()->id:0,
			"is_viewed" => 0,
			])->get();
			
		return count($notification);
    }
}


/**
*
*
**/
if (!function_exists('total_doctors')) {
    function total_doctors() {
		$doctors = User::where(["role_id" => 2])->get();
			
		return count($doctors);
    }
}

/**
*
**/
if (!function_exists('past_30_sent')) {
    function past_30_sent() {
		$result = Refer::where("refer_date", ">=", date('Y-m-d H:i:s', strtotime('-30 days')))->get();			
		return count($result);
    }
}

/**
*
**/
if (!function_exists('past_30_apt')) {
    function past_30_apt() {
		$result = Refer::where("refer_date", ">=", date('Y-m-d H:i:s', strtotime('-30 days')))->get();			
		return count($result);
    }
}



/**
*
*
**/
if (!function_exists('recent_10_refers')) {
    function recent_10_refers() {
		$results = Refer::skip(0)->take(5)->orderBy('refer_date', 'desc')->get();
		return $results;
    }

}