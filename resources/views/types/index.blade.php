@extends('layouts.layout')
@section('title', 'Types of Doctor')
@section('breadcrumbs', '
<li class="active">Types of Doctor</li>
')

@section('content') 

<!-- Users list -->

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Types of Doctor</h3>
  </div>
  <!-- User-header -->
  
  <div class="box-body">
    <button type="button" class="btn btn-primary" style="float:right" data-toggle="modal" data-target="#addnew">Add New</button>
    <table id="datatable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>id</th>
          <th>Title</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      
      @if( !empty( $types ) && count( $types ) > 0 )
      @foreach($types as $type)
      <tr>
        <td>{{$type->id}}</td>
        <td>{{$type->title}}</td>
        
        <td  style="width:10%;"><input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button class="btn btn-primary btn-sm edit_btn" type="submit" name="id" value="{{$type->id}}"><i class="fa fa-edit " aria-hidden="true"></i></button>
           </td>
      </tr>
      @endforeach
      @endif
        </tbody>
      
    </table>
  </div>
</div>

<!-- New User Modal Start -->
<div id="addnew" class="modal fade"
         role="dialog"> {{ Form::open(array('url' => 'types/new/','id'=>'new')) }}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
		<h3>Add new Doctor Type</h3>
      </div>
      <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
      <div class="alert alert-success" style="display:none"><strong>Success!</strong> <span></span></div>
      <div class="modal-body">
        <div class="box-body">
          <div class="form-group"> {{Form::label('title', 'Type Name/Title')}}
            {{Form::Text('title','', array('class' => 'form-control', 'placeholder'=>'Enter Type Name/Title', 'required'=>'required'))}} </div>
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
<div id="edit" class="modal fade" role="dialog"> {{ Form::open(array('url' => 'types/update-type', 'id'=>'update')) }}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <h4 class="modal-title">Update Type of Doctor</h4>
      </div>
      <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
      <div class="alert alert-success" style="display:none"><strong>Success!</strong> <span></span></div>
      <div class="modal-body" id="editdata"></div>
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

             $('#datatable').DataTable({
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
            $(".edit_btn").click(function () {
                var dataString = {'id': $(this).val(), '_token': $('input[name="_token"]').val()};

                $.ajax({
                    type: "POST",
                    url: "{{url('/types/get-type')}}",
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        $('#editdata').html(data);
                        $('#edit').modal('toggle');
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
            $("#new").on('submit', function (e) {

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
                    $(".alert-success span").html( "New Type Added Successfully." );
                    $(".alert-success").fadeIn(400);

                    var mover = setInterval( function(){
                        window.location.reload();
                        clearInterval( mover );

                        $("#new")[0].reset();
                    }, 1000);
                }
            }


            /**
            *	Trigger when update is pressed.
            */
            $("#update").on('submit', function (e) {
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
                
                if (response == 'Success') {
                    $(".alert-success span").html( "Type Details Updated Successfully." );
                    $(".alert-success").fadeIn(400);

                    var mover = setInterval( function(){
                        window.location.reload();
                        clearInterval( mover );

                        $("#new")[0].reset();
                    }, 2000);
                }
            }


        });

    </script> 
@stop