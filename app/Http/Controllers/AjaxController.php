<?php

namespace App\Http\Controllers;

use App\Projects;
use App\User;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    /**
     *  Get Client Related to Project
     **/
    public function ajax_get_clients(Request $request)
    {
        $attached_client = Projects::with("Client")
                            ->where("project_key", $request->project_key)
                            ->get();

        $client = $attached_client[0]->Client;
        
        $html = '<img class="img-circle" width="96" src="'.url("/dist/img").'/'.$client->avatar.'" align="No image"><p>'.$client->name.'</p><p><a data-original-title="Send Email" href="mailto:'.$client->email.'"> 
                             <i class="fa fa-envelope-o" aria-hidden="true"></i> 
                          </a> 
                          <a data-original-title="Facebook" href="https://www.facebook.com/'.$client->facebook.'" target="_blank">
                             <i class="fa fa-facebook" aria-hidden="true"></i> 
                          </a>
                          <a data-original-title="Skype" href="skype:'.$client->skype.'" target="_blank">
                             <i class="fa fa-skype" aria-hidden="true"></i> 
                          </a>   
                          <a data-original-title="linkedin" href="https://linkedin.com/in/'.$client->linkedin.'" target="_blank">
                             <i class="fa fa-linkedin" aria-hidden="true"></i> 
                          </a>
                          <a data-original-title="Twitter" href="https://twitter.com/'.$client->twitter.'" target="_blank"> 
                             <i class="fa fa-twitter" aria-hidden="true"></i>
                          </a></p>';

        return $html;
    }

    /**
     *  Get Client Related to Project
     **/
    public function ajax_get_staff(Request $request)
    {
        $staff_ids = Projects::with("Staff")
                            ->where("project_key", $request->project_key)
                            ->select(["staff"])
                            ->get();

        $staff_ids_array = explode(",", $staff_ids[0]->staff);

        $staff_list = User::get();

        $html = "";

        foreach( $staff_list as $staff )
        {
            if( in_array( $staff->id, $staff_ids_array ) ){
                $html .= "<span class='label label-default'>".$staff->name."</span>";
            }
        }

        return $html;
    }
}
