@extends('layouts.layout')
@section('title', 'Patients List')
@section('breadcrumbs', "<li class='active'>Patients</li>")

@section('content')

<!-- Patients list -->

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Patients List</h3>
  </div>
  <!-- Patient-header -->

  <div class="box-body">
    @if( Auth::check() && Auth::user()->role_id > 1 )
    <a class="btn btn-primary" style="float:right" href="{{url('patient/new')}}">Add New</a>
    @endif
    <table id="patientdatatable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Phone Number</th>
          <!--<th>Address</th>-->
		  @if( Auth::check() && Auth::user()->role_id <= 1 )
          <th>Doctor</th>
          @endif

          @if( Auth::check() && Auth::user()->role_id > 0 )<th>Actions</th>@endif
        </tr>
      </thead>
      <tbody>

      @if( !empty( $patientlist ) && count( $patientlist ) > 0 )
      @foreach($patientlist as $patient)
      <tr>
        <td>{{$patient->first_name}}</td>
        <td>{{$patient->last_name}}</td>
        <td>@if( !empty( $patient->email ) ) <i class="fa fa-envelope-o" aria-hidden="true"></i> {{$patient->email}} @endif</td>
        <td>@if( !empty( $patient->phone ) ) <a data-original-title="Call" href="tel:{{$patient->phone}}"> <i class="fa fa-envelope-o" aria-hidden="true"></i> {{$patient->phone}}</a> @endif</td>
      <!--  <td>
        	<button class="btn btn-success btn-sm" type="submit" name="" value=""> <i class="fa fa-eye"></i> </button>
        	<button class="btn btn-primary btn-sm edit_patient_btn" type="submit" name="" value=""><i class="fa fa-edit " aria-hidden="true"></i></button>
            <button class="btn btn-info btn-sm" type="submit" name="" value=""><i class="fa fa-archive " aria-hidden="true"></i></button>
        </td>-->
        <!--<td>

         </td>-->
        <!--<td>{{$patient->address}}</td>-->
        @if( Auth::check() && Auth::user()->role_id <= 1 )
        <td> {{$patient->Doctor->name}} </td>
        @endif
        @if( Auth::check() && Auth::user()->role_id > 0 )

        <td  style="width:15%;"><input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button class="btn btn-success btn-sm view_Patient_button" type="submit" name="" value="{{$patient->id}}"> <i class="fa fa-eye"></i> </button>

          <button class="btn btn-primary btn-sm edit_patient_btn" type="submit" name="id"
                                        value="{{$patient->id}}"><i class="fa fa-edit " aria-hidden="true"></i></button>

          <button class="btn btn-danger btn-sm delete_patient_btn" type="submit" name="dell_id" value="{{$patient->id}}"> <i class="fa  fa-trash"></i> </button>
           </td>
        @endif
      </tr>
      @endforeach
      @endif
        </tbody>

    </table>
  </div>
</div>

<!-- New Patient Modal Start -->
<div id="addnewpatient" class="modal fade"
         role="dialog"> {{ Form::open(array('url' => 'patinet/new/','id'=>'new_patient')) }}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <h4 class="modal-title">New Patient</h4>
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
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
    {{ Form::close() }} </div>
</div>
<!--  New Patient Modal end-->

<!-- Edit Patient Modal Start -->
<div id="editpatient" class="modal fade" role="dialog"> {{ Form::open(array('url' => '/patient/update-patient', 'id'=>'update_patient')) }}
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <h4 class="modal-title">Update Patient</h4>
      </div>
      <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
      <div class="alert alert-success" style="display:none"><strong>Success!</strong> <span></span></div>
      <div class="modal-body" id="editpatientdata"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
    {{ Form::close() }} </div>
</div>

<!-- Edit Patient Modal Start -->
<div id="viewPatient" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <h4 class="modal-title">Patient Information</h4>
      </div>
      <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
      <div class="alert alert-success" style="display:none"><strong>Success!</strong> <span></span></div>
      <div class="modal-body" id="viewPatientdata"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
    </div>
</div>


<!--  New Patient Modal end-->
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
        <button type="submit" class="btn btn-danger" id="delete_patient" data-dismiss="modal">Delete</button>
      </div>
    </div>
  </div>
</div>
@stop

@section('script')
<!-- jQuery 2.2.3 -->
<script type="text/javascript">
        $(document).ready(function () {

            /**
            *	Fetch Data and Put into Edit Model
            */
            $(".edit_patient_btn").click(function () {
                var dataString = {'id': $(this).val(), '_token': $('input[name="_token"]').val()};

                $.ajax({
                    type: "POST",
                    url: "{{url('/patient/get-patient')}}",
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        $('#editpatientdata').html(data);
                        $('#editpatient').modal('toggle');
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
            * Trigger when Add new Patient button pressed.
            *
            $("#new_patient").on('submit', function (e) {

                var options = {
                    url: $(this).attr("action"),
                    success: onsuccess
                };
                $(this).ajaxSubmit(options);

                return false;
            });



            /**
             *	jQuery: Call back function for New Patient
             *
            function onsuccess(response, status) {
                if (response == 'Email already registered')
                    $('#email_message').html(response);

                if (response == 'Please fill all the required feilds') {

                }
                if (response == 'Success') {
                    $(".alert-success span").html( "New Patient Added Successfully." );
                    $(".alert-success").fadeIn(400);

                    var mover = setInterval( function(){
                        window.location.reload();
                        clearInterval( mover );

                        $("#new_patient")[0].reset();
                    }, 1000);
                }
            }


            /**
            *	Fetch Patient Data and VIEW
            */
            $(".view_Patient_button").click( function () {
                var dataString = {
					        'id': $(this).attr("value"),
					        '_token': $('input[name="_token"]').val(),
					        'is_view':"1",
				        };

                $.ajax({
                    type: "POST",
                    url: "{{ url('patient/view')}}",
                    data: dataString,
                    success: function (data) {
                      // alert("Kill india");
					              $(".alert").fadeOut(1);
                        $('#viewPatientdata').html(data);
                        $('#viewPatient').modal("show");
                    }
                });

				         return false;

            });



            /**
            *	Trigger when update is pressed.
            */
            $("#update_patient").on('submit', function (e) {
                var options = {
                    url: $(this).attr("action"),
                    success: onUpdateSuccessCallback,
                };

                $(this).ajaxSubmit(options);
                return false;
            });


            /**
             *	jQuery: Callback function for Patient Update
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
                    $(".alert-success span").html( "Patient Details Updated Successfully." );
                    $(".alert-success").fadeIn(400);

                    var mover = setInterval( function(){
                        window.location.reload();
                        clearInterval( mover );

                        $("#new_patient")[0].reset();
                    }, 2000);
                }
            }



            /**
            * Trigger when Delete Client Button is pressed. Will show Del Model
            */
            $(".delete_patient_btn").on('click',function () {
                var client_id = $(this).attr('value');
                $('#person_id').val(client_id);
                $('#dell_client').modal('show');
            });



            /**
             * Trigger when Delete button from model is pressed
             */
            $('#delete_patient').on('click',function () {
                var patient_id = $('#person_id').val();

                $.ajax({
                    type: 'POST',
                    url: "{{url('/patient/delete')}}",
                    data:{
                        'patient_id':patient_id,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (response) {
                        $('#client_person_record tr').each(function() {
                            if ($(this).attr('id') == client_id) {
                                $(this).remove();
                            }else{}
                        });

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
