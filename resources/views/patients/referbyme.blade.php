@extends('layouts.layout')
@section('title', 'Patients Refered By Me')
@section('breadcrumbs', '
<li class="active">Patients Refered By Me</li>
')

@section('content') 

<!-- Patients list -->

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Patients Refered By Me</h3>
  </div>
  <!-- Patient-header -->
  
  <div class="box-body">
    @if( Auth::check() && Auth::user()->role_id > 1 )
    
    @endif
    <table id="patientdatatable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th>Refer Date</th>
          <th>Dr. Referred</th>
          <th>Action</th>
          <!--<th>Address</th>-->
          <!--<th>Refered To</th>
          @if( Auth::check() && Auth::user()->role_id > 1 )<th>Actions</th>@endif-->
        </tr>
      </thead>
      <tbody>
      
      @if( !empty( $patients ) && count( $patients ) > 0 )
      @foreach($patients as $patient)
      <tr>
        <td>{{$patient->patients->first_name}}</td>
        <td>{{$patient->patients->last_name}}</td>
        <td>@if( !empty( $patient->patients->email ) ) <i class="fa fa-envelope-o" aria-hidden="true"></i>  {{$patient->patients->email}}
        @endif
        </td>
        <td> 
        @if( !empty( $patient->patients->phone ) ) <a data-original-title="Call" href="tel:{{$patient->patients->phone}}"> <i class="fa fa-phone" aria-hidden="true"></i>  {{$patient->patients->phone}}</a> 
        @endif
         </td>
        <!--<td>{{$patient->patients->address}}</td>-->
        <td>{{$patient->patients->address}}</td>
        <td> {{$patient->referedto->name}} </td>
        <td>
        	<button class="btn btn-success btn-sm" type="submit" name="" value=""> <i class="fa fa-eye"></i> </button>
        	<button class="btn btn-primary btn-sm" type="submit" name="" value=""><i class="fa fa-edit " aria-hidden="true"></i></button>
        </td>
        @if( Auth::check() && Auth::user()->role_id > 1 )
        <!--<td  style="width:10%;"><input type="hidden" name="_token" value="{{ csrf_token() }}">
          
           </td>-->
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


@stop

@section('script') 
<!-- jQuery 2.2.3 --> 
<script type="text/javascript">
	$(document).ready(function () {
		 $('#patientdatatable').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": true,
			"info": true,
			"autoWidth": false
		});
	});

</script> 
@stop