@extends('layouts.layout')
@section('title', 'Manage Account Roles')
@section('breadcrumbs')

    <li class="active">Account Roles</li>
    
@stop

@section('styles')

	<link rel="stylesheet" href="assets/plugins/bootstrap-switch-master/dist/css/bootstrap-switch.css" />

@stop

@section('content') 

<!-- Users list -->

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Manage Account Roles</h3>
        <button type="button" class="btn btn-primary" style="float:right" data-toggle="modal" data-target="#addnewrole">Add New</button>
    </div>
    <!-- User-header -->
    
    <div class="box-body">
        @if (session('success'))
            <div class="alert alert-success"> {{ session('success') }} </div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-danger"> {{ session('error') }} </div>
        @endif


        <table id="rolesTable" class="table table-bordered table-striped datatable">
            <thead>
                <tr>
                    <th>Role ID</th>
                    <th>Name</th>
                    <th>Permissions</th>
                    <th>Number of Staff</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            
            
            @foreach($permissions as $permission)
                @if( $permission->id <= Auth::user()->role_id )
                    @continue
                @endif
                
                <tr>
                    <td>{{$permission->id}}</td>
                    <td>{{$permission->display_name}}</td>
                    <td> @foreach( $permission->UsersModules as $umodule) <span class="label label-info">{{$umodule->Modules->title}}</span> <br />
                        @endforeach </td>

                    <td><span class="badge">{{count($permission->TotalUsers)}}</span></td>
                    <td><input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-primary btn-sm edit_roles_btn" type="submit" name="id"
                                        value="{{$permission->id}}"><i class="fa fa-edit " aria-hidden="true"></i></button>
                        @if( $permission->role_id > 1 )
                            <button class="btn btn-danger btn-sm delete_roles_btn" type="submit" name="dell_id" value="{{$permission->id}}"> <i class="fa  fa-trash"></i> </button>
                        @endif </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- New User Modal Start -->
<div id="addnewrole" class="modal fade"
         role="dialog"> {{ Form::open(array('url' => 'permissions/add-role' ,'id'=>'new_role')) }}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                <h4 class="modal-title">New Role</h4>
            </div>
            <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
            <div class="alert alert-success" style="display:none"><strong>Success!</strong> <span></span></div>
            <div class="modal-body">
            	
                <div class="box-body"> 

                    <div class="form-group"> {{Form::label('name', 'Role Name')}}
                        {{Form::Text('name',old('name'), ['class' => 'form-control', 'placeholder'=>'Enter Role Name', 'required'=>'required'])}}
                    </div>
                        
                    <div class="form-group"> {{Form::label('display_name', 'Display Name')}}
                        {{Form::Text('display_name', old('display_name'), ['class' => 'form-control', 'placeholder'=>'Display Name', 'required'=>'required'])}}
                    </div>
                        
                    <div class="form-group"> {{Form::label('description', 'Description')}}
                        {{Form::Text('description', old('description'), ['class' => 'form-control', 'placeholder'=>'Description', 'required'=>'required'])}}
                    </div>

                    @foreach( $modules as $module )
                    	@if( $module->id == 13 )
                        	<div class="form-group row" style="visibility:hidden;">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    {{Form::label('module_title', $module->title)}}
                                </div>
                                <input type="hidden" class="col-sm-12 col-md-6 col-lg-6" name="permission[]" value="{{$module->id}}" />
                            </div>	
                            @continue
                        @endif
                        
                        
                        <div class="form-group row">
                        	<div class="col-sm-12 col-md-6 col-lg-6">
	                            {{Form::label('module_title', $module->title)}}
                            </div>
                            <input type="checkbox" class="col-sm-12 col-md-6 col-lg-6" data-toggle="switch" data-size="small" name="permission[]" value="{{$module->id}}" />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dkefault pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        {{ Form::close() }} </div>
</div>
<!--  New Staff Modal end--> 

<!-- Edit User Modal Start -->
<div id="editroles" class="modal fade" role="dialog">
    {{ Form::open(array('url' => 'permissions/edit-role', 'id'=>'update_role')) }}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                <h4 class="modal-title">Update Role</h4>
            </div>

            <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
            <div class="alert alert-success" style="display:none"><strong>Success!</strong> <span></span></div>
            
            <div class="modal-body" id="editrolesdata"></div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        {{ Form::close() }} </div>
</div>
<!--  New Staff Modal end-->

<div id="dell_permission" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Permission</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <button type="button" name="dell_id" id="person_id" class="hidden"></button>
                    Are you sure you want to delete this Permission? </div>
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
<script src='assets/plugins/bootstrap-switch-master/dist/js/bootstrap-switch.min.js'></script>
<script type="text/javascript">

        $(document).ready(function () {
			
			$("input[type=checkbox]").bootstrapSwitch({
					onText: 'YES',
					offText: 'NO',
					onColor: 'success',
		            offColor: 'danger',
				});
			
			/**
			 *	Hide any Alert windows (i.e Alert Success or Alert Error) in 3 Seconds if open on page load.
			 **/
            var mover = setInterval(function(){
                $(".alert").slideUp(500);
                clearInterval( mover );
            }, 3000);

           
            /**
            *	Fetch Data and Put into Edit Model
            */
            $(".edit_roles_btn").click(function () {
                var dataString = {'id': $(this).val(), '_token': $('input[name="_token"]').val()};

                $.ajax({
                    type: "POST",
                    url: "{{url('/permissions/get-role-data')}}",
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        $('#editrolesdata').html(data);
                        $('#editroles').modal('toggle');
						
						$("input[type=checkbox]").bootstrapSwitch({
							onText: 'YES',
							offText: 'NO',
							onColor: 'success',
							offColor: 'danger',
						});
                    }
                });
            });


            /**
             *	Function to fetch roles
             */
            function fetch_roles(){
                $.ajax({
                    type: "POST",
                    data: {'_token': "{{csrf_token()}}"},
                    url: "{{ url('/')}}/get-roles",
                    cache: false,
                    success: function (response) {
                        $("#roleslist").html(response);
                    }
                });

            }



            /**
            * Trigger when Add new Permission button pressed.
            */
            $("#new_role").on('submit', function ()
            {
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
                    $(".alert-success span").html( "New Role Added Successfully." );
                    $(".alert-success").fadeIn(400);

                    var mover = setInterval( function(){
                        window.location.reload();
                        clearInterval( mover );

                        $("#new_roles")[0].reset();
                    }, 1000);
                }
            }



            /**
             * Trigger when update is pressed.
             */
            $("#update_role").on('submit', function () 
			{
                var options = {
                    url: $(this).attr("action"),
                    success: onUpdateSuccessCallback,
                };

                $(this).ajaxSubmit(options);
                return false;
            });


			/**
			 *
			 **
			$("#update_role").submit(function () 
			{
                var options = {
                    url: $(this).attr("action"),
                    success: onUpdateSuccessCallback,
                };

                $(this).ajaxSubmit(options);
                return false;
            });

            /**
             *	jQuery: Callback function for Staff Update
             **/
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
                    $(".alert-success span").html( "Role Updated Successfully." );
                    $(".alert-success").fadeIn(400);

                    var mover = setInterval( function(){
                        window.location.reload();
                        clearInterval( mover );

                        $("#new_roles")[0].reset();
                    }, 1000);
                }
            }



            /**
            * Trigger when Delete Permission Button is pressed. Will show Del Model
            *
            $(".delete_roles_btn").on('click',function () {
                var permission_id = $(this).attr('value');
                $('#person_id').val(permission_id);
                $('#dell_permission').modal('show');
            });


            /**
             * Trigger when Delete button from model is pressed
             *
            $('#delete_person').on('click',function () {
                var permission_id = $('#person_id').val();

                $.ajax({
                    type: 'POST',
                    url: "{{url('/delete-permission-person')}}",
                    data:{
                        permission_id:permission_id,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function () {
                        $('#permission_person_record tr').each(function() {
                            if ($(this).attr('id') == permission_id) {
                                $(this).remove();
                            }else{}
                        });
                        alert('Role Deleted successfully');

                        window.location.reload();
                    },
                    error:function () {
                        alert("fail");
                    }
                });
            });*/

        });

    </script> 
@stop