@extends('layouts.layout')
@section('title', "Patient Details")
@section('breadcrumbs', '
<li class="active">Patient Details</li>
')

@section('content') 

<!-- Users list -->

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Patient Details</h3>
  </div>
  <!-- User-header -->
  
  <div class="box-body">
    <div class="box-body">
    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        <div class="alert alert-danger" style="display:none"><strong>Alert! </strong><span></span></div>
        <div class="alert alert-success" style="display:none"><strong>Success! </strong><span></span></div>
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        @if( !empty( $patient ) )

        {{ Form::hidden('id',$patient->patients->id) }}
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group"> <label>Patient Picture</label> <br />
              <img class="user-image" alt="Avatar" src="{{url('/assets/images/')}}/{{$patient->patients->avatar}}" width="96" /> </div>
            
            
            
            <div class="form-group">
              <label>First Name:</label>
              <span>{{$patient->patients->first_name}}</span>
            </div>
            <br />
            
            <div class="form-group">
              <label>Last Name:</label>
              <span>{{$patient->patients->last_name}}</span>
            </div>
            <br />
            
            <div class="form-group">
              <label>Date of Birth:</label>
              <span>{{$patient->patients->dob}}</span>
            </div>
            <br />
            
            <div class="form-group">
              <label>Email:</label>
              <span>{{$patient->patients->email}}</span>
            </div>
            <br />
            
            <div class="form-group">
              <label>Address:</label>
              <span>{{$patient->patients->address}}</span>
            </div>
            <br />
            
            
            <div class="form-group">
              <label>Phone:</label>
               <span>{{$patient->patients->phone}}</span>
            </div>
            <br />
            
            <div class="form-group">
              <label>Insurance Name:</label>
               <span>{{$patient->patients->insurance_name}}</span>
            </div>
            <br />
            
            <div class="form-group">
              <label>Insurance Type:</label>
               <span>{{$patient->patients->insurance_type}}</span>
            </div>
            <br />
            
            <div class="form-group">
              <label>Insurance Number:</label>
               <span>{{$patient->patients->insurance_number}}</span>
            </div>
            <br />
            
            <div class="form-group">
              <label>Reason of Refer:</label>
               <span>{{$patient->reason}}</span>
            </div>
            <br />
            
            
        </div>
        @endif
        
         </div>
    </div>
  </div>
</div>
    
    
    
    
    
  </div>
</div>
<style>
	label {
		display:inline-block;
		min-width:150px;
		font-weight:normal;
		font-size:16px;
	}
	.form-group > span {
		font-size:16px;
		font-weight:bold;
	}
</style>
@stop

@section('script') 
<!-- jQuery 2.2.3 --> 
<script type="text/javascript">
	$(document).ready(function () {

	});
</script> 
@stop