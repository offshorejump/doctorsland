@extends('layouts.layout')
@section('title', $title . ' Accounts')
@section('breadcrumbs', '
<li class="active">'.$op_key.'</li>
')

@section('content') 

<!-- Users list -->

<div class="box">
  <div class="box-header">
    <h3 class="box-title">{{$title}} Accounts</h3>
  </div>
  <!-- User-header -->
  
  <div class="box-body">
    <button type="button" class="btn btn-primary" style="float:right" data-toggle="modal" data-target="#addnew{{$op_key}}">Add New</button>
    <table id="{{$op_key}}datatable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Company Logo</th>
          <th>Company Name</th>
          <th>Dr. First Name</th>	
          <th>Dr. Last Name</th>
          @if( Auth::check() && Auth::user()->role_id > 1 )
          <th>Dr. Type</th>
          @endif
          <th>Main Office Number</th>
          @if( Auth::check() && Auth::user()->role_id = 1 )
          <th># Patients Referred</th>
          <th># Patients Sent</th>
          <th># Patients Scheduled</th>
          @endif
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      
      @if( !empty( $userlist ) && count( $userlist ) > 0 )
      @foreach($userlist as $user)
      <tr>
        <td><img width="64" height="64" src="{{url('/dist/img/')}}/{{$user->avatar}}" class="img-circle" alt="User Image"></td>
        <td>{{$user->company_name}}</td>
        <td>{{$user->first_name}}</td>
        <td>{{$user->last_name}}</td>
        @if( Auth::check() && Auth::user()->role_id > 1 )
        <td>{{$user->Type->title}}</td>
        @endif
        <td>{{$user->phone}}</td>
        @if( Auth::check() && Auth::user()->role_id = 1 )
        <td>{{count($user->referto)}}</td>
        <td>{{count($user->referby)}}</td>
        <td>No Field</td>
        @endif
        <!--<td> @if( !empty( $user->email ) ) <i class="fa fa-envelope-o" aria-hidden="true"></i>  {{$user->email}}  @endif
        	<br />
        	@if( !empty( $user->phone ) ) <a data-original-title="Send Email" href="tel:{{$user->phone}}"> <i class="fa fa-phone" aria-hidden="true"></i> {{$user->phone}} </a> @endif
            
           </td>
        <td>{{$user->address}}</td>-->
        <td  style="width:10%;">
        	<button class="btn btn-success btn-sm view_{{$op_key}}_btn" type="submit" name="view_id" value="{{$user->id}}"> <i class="fa fa-eye"></i> </button>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button class="btn btn-primary btn-sm edit_{{$op_key}}_btn" type="submit" name="id"
                                        value="{{$user->id}}"><i class="fa fa-edit " aria-hidden="true"></i></button>
          <!--<button class="btn btn-danger btn-sm delete_{{$op_key}}_btn" type="submit" name="dell_id" value="{{$user->id}}"> <i class="fa  fa-trash"></i> </button>-->
          	<button class="btn btn-warning btn-sm all_list_{{$op_key}}_btn" type="submit" name="all_list_id" value="{{$user->id}}"> <i class="fa fa-list"></i> </button>
          </td>
      </tr>
      @endforeach
      @endif
        </tbody>
      
    </table>
  </div>
</div>

<!-- New User Modal Start -->
<div id="addnew{{$op_key}}" class="modal fade"
         role="dialog"> {{ Form::open(array('url' => 'accounts/new/'.$op_key,'id'=>'new_'.$op_key)) }}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <h4 class="modal-title">New {{ucfirst($op_key)}}</h4>
      </div>
      <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
      <div class="alert alert-success" style="display:none"><strong>Success!</strong> <span></span></div>
      <div class="modal-body">
        <div class="box-body">
          <div class="form-group"> {{Form::label('firstname', 'First Name')}}
            {{Form::Text('firstname','', array('class' => 'form-control', 'placeholder'=>'Enter First Name', 'required'=>'required'))}} </div>
          <div class="form-group"> {{Form::label('lastname', 'Last Name')}}
            {{Form::Text('lastname','', array('class' => 'form-control', 'placeholder'=>'Enter Last Name', 'required'=>'required'))}} </div>
          <div class="form-group"> {{Form::label('email', 'Email Address')}}
            {{Form::Email('email','', array('class' => 'form-control', 'placeholder'=>'Enter Email Address', 'required'=>'required'))}} <i id="email_message" style="color:red"></i></div>
          <div class="form-group"> {{Form::label('password', 'Password')}}
            {{Form::password('password', array('class' => 'form-control', 'placeholder'=>'Enter password', 'required'=>'required'))}} </div>
            
            <div class="form-group">
              <label>Patient</label>
              <select class="form-control" name="specialization" id="specialization" data-placeholder="-- Select Doctor Type --">
                <option disabled selected value> -- Select Doctor Type -- </option>
                
					@foreach($types as $type)         
						<option value="{{$type->id}}">{{$type->title}}</option>
					@endforeach
                                    
              </select>
            </div>
            
            
          @if( $op_key != "admin" )
          <div class="form-group"> 
            {{Form::hidden('roles', '2')}} </div>
          @endif
          
           </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
    {{ Form::close() }} </div>
</div>
<!--  New Staff Modal end--> 

<!-- Edit User Modal Start -->
<div id="edit{{$op_key}}" class="modal fade" role="dialog"> {{ Form::open(array('url' => '/update-user', 'id'=>'update_'.$op_key)) }}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <h4 class="modal-title">Update {{ucfirst($op_key)}}</h4>
      </div>
      <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
      <div class="alert alert-success" style="display:none"><strong>Success!</strong> <span></span></div>
      <div class="modal-body" id="edit{{$op_key}}data"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
    {{ Form::close() }} </div>
</div>
<!--  New Staff Modal end-->

<div id="dell_client" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">New Client Person</h4>
      </div>
      <div class="modal-body">
        <div class="box-body">
          <button type="button" name="dell_id" id="person_id" class="hidden"></button>
          Are you sure you want to delete this client? </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger" id="delete_person" data-dismiss="modal">Delete</button>
      </div>
    </div>
  </div>
</div>
@stop

@section('script') 
<!-- jQuery 2.2.3 --> 
<script type="text/javascript">
        $(document).ready(function () {

             $('#{{$op_key}}datatable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });


            /**
            *	Fetch Data and Put into Edit Model
            */
            $(".edit_{{$op_key}}_btn").click(function () {
                var dataString = {'id': $(this).val(), '_token': $('input[name="_token"]').val()};

                $.ajax({
                    type: "POST",
                    url: "{{url('/accounts/get-user')}}",
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        $('#edit{{$op_key}}data').html(data);
                        $('#edit{{$op_key}}').modal('toggle');
                    }
                });
            });


            /**
             *	Function to fetch roles
             */
            function fetch_roles(){
                $.ajax({
                    type: "POST",
                    data: {'_token': "{{ csrf_token() }}"},
                    url: "{{ url('/')}}/get-roles",
                    cache: false,
                    success: function (response) {
                        $("#roleslist").html(response);
                    }
                });

            }



            /**
            * Trigger when Add new User button pressed.
            */
            $("#new_{{$op_key}}").on('submit', function (e) {

                var options = {
                    url: $(this).attr("action"),
                    success: onsuccess
                };
                $(this).ajaxSubmit(options);

                return false;
            });



            /**
             *	jQuery: Call back function for New Staff
             */
            function onsuccess(response, status) {
                if (response == 'Email already registered')
                    $('#email_message').html(response);

                if (response == 'Please fill all the required feilds') {

                }
                if (response == 'Success') {
                    $(".alert-success span").html( "New {{$title}} Added Successfully." );
                    $(".alert-success").fadeIn(400);

                    var mover = setInterval( function(){
                        window.location.reload();
                        clearInterval( mover );

                        $("#new_{{$op_key}}")[0].reset();
                    }, 1000);
                }
            }


            /**
            *	Trigger when update is pressed.
            */
            $("#update_{{$op_key}}").on('submit', function (e) {
                var options = {
                    url: $(this).attr("action"),
                    success: onUpdateSuccessCallback,
                };

                $(this).ajaxSubmit(options);
                return false;
            });


            /**
             *	jQuery: Callback function for Staff Update
             */
            function onUpdateSuccessCallback(response, status) {
                if (response == 'Email already registered')
                {
                    $(".alert-danger span").text( response );
                    $(".alert-danger").fadeIn(400);
                }
                    

                if (response == 'Please fill all the required feilds') {
                    $(".alert-danger span").text( response );
                    $(".alert-danger").fadeIn(400);
                }


                if (response == 'Success') {
                    $(".alert-success span").html( "{{$title}} Details Updated Successfully." );
                    $(".alert-success").fadeIn(400);

                    var mover = setInterval( function(){
                        window.location.reload();
                        clearInterval( mover );

                        $("#new_{{$op_key}}")[0].reset();
                    }, 2000);
                }
            }



            /**
            * Trigger when Delete Client Button is pressed. Will show Del Model
            */
            $(".delete_{{$op_key}}_btn").on('click',function () {
                var client_id = $(this).attr('value');
                $('#person_id').val(client_id);
                $('#dell_client').modal('show');
            });



            /**
             * Trigger when Delete button from model is pressed
             */
            $('#delete_person').on('click',function () {
                var user_id = $('#person_id').val();

                $.ajax({
                    type: 'POST',
                    url: "{{url('/account/remove')}}",
                    data:{
                        'user_id':user_id,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (response) {

                        $('#client_person_record tr').each(function() {
                            if ($(this).attr('id') == client_id) {
                                $(this).remove();
                            }else{}
                        });
                        //alert('{{$title}} Deleted successfully');

                       window.location.reload();
                    },
                    error:function () {
                        alert("fail");
                    }
                });
            });

        });

    </script> 
@stop