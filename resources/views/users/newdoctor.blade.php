@extends('layouts.layout')
@section('title', 'New Doctor')

@section('breadcrumbs', '
<li class="active">New Doctor</li>
')

@section('content')
    @if (count($errors) > 0)
    <div class="alert alert-danger">
  <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
</div>
@endif

    @if(Session::has('Success'))
<div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-check"></i> Success</h4>
  {{ Session::get('Success') }} </div>
@endif
    
    
    @if(Session::has('Error'))
<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-close"></i> Error</h4>
  {{ Session::get('Error') }} </div>
@endif
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title" id="ProfileBlock">New Doctor</h3>
    <div class="box-tools pull-right"> </div>
  </div>
  <!-- Admins-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        <div class="alert alert-danger" style="display:none"><strong>Alert! </strong><span></span></div>
        <div class="alert alert-success" style="display:none"><strong>Success! </strong><span></span></div>
        {{ Form::open(array('url' => 'accounts/doctor/add_new','id' => 'add_new_doctor', 'files'=> true)) }}
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="form-group"> {{Form::label('avatar', 'New Avatar')}}<br />
                {{ Form::file('avatar') }} </div>
            </div>
            
            
            <div class="form-group">
              <label>First Name *</label>
              {{ Form::text('first_name', (isset($requesting->first_name)?$requesting->first_name:""), ['class' => 'form-control','placeholder' => 'Enter First Name','required']) }} </div>
            
            <div class="form-group">
              <label>Last Name *</label>
              {{ Form::text('last_name', '',['class' => 'form-control','placeholder' => 'Enter Last Name','required']) }} </div>
            
            <div class="form-group">
              <label>Comapny Name</label>
              {{ Form::text('company_name', '',['class' => 'form-control','placeholder' => 'Enter Company']) }} </div>  
              
            <div class="form-group">
              <label>Email *</label>
              {{ Form::email('email', '',['class'=>'form-control','placeholder' => 'email@gmail.com','required']) }} </div>
            <div class="form-group">
              <label>Address</label>
              {{ Form::textarea('address', '',['placeholder'=>'Enter Complete Address','class'=>'textarea', 'style'=>'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #ddd; padding: 10px;']) }} </div>
            <div class="form-group">
              <label>Phone</label>
              <div class="input-group"> <span class="input-group-addon"><i class="fa fa-phone"></i></span> {{ Form::text('phone', '',['class'=>'form-control','placeholder'=>'Phone Number'] )}} </div>
            </div>
            
            
            
            <div class="form-group"> {{ Form::label('avatar', 'Current Certificate') }}<br />
              <img class="user-image" alt="Certificate" src="{{url('/dist/img')}}/" width="96" /> </div>
            <div class="form-group">
              <div class="form-group"> {{Form::label('certificate', 'New Certificate')}}<br />
                {{ Form::file('certificate') }} </div>
            </div>
            
            
            
            <div class="form-group">
              <label>Type of Doctor *</label>
              
              <select class="form-control select2" name="specialization" id="specialization" data-placeholder="-- Type of Doctor --" style="width: 100%;">
                <option disabled selected value> -- Type of Doctor -- </option>
				@foreach($types as $type)
                    
                	<option value="{{$type->id}}">{{$type->title}}</option>
				@endforeach
                                        
              </select>
              
              
             
              
              
              <div class="form-group">
              <label>Qualification *</label>
              {{ Form::text('qualification', '', ['class' => 'form-control','placeholder' => 'Qualification (i.e M.B.B.S, F.Sp)','required']) }} </div>
              
              
             
            
            <div class="form-group">
              <label>New Pasword *</label>
              {{ Form::Password('password',['class'=>'form-control','placeholder'=>'Enter New Password','required']) }} </div>
            <div class="form-group">
              <label>Confirm Pasword *</label>
              {{ Form::Password('password_confirmation',['class'=>'form-control','placeholder'=>'Enter New Password','required']) }} </div>
            

           
            <div class="form-group">
              <input type="submit" class="btn btn-info" value="Add New Doctor"/>
            </div>
          </div>
        </div>
        
        {{ Form::close() }} </div>
    </div>
  </div>
</div>

@stop


@section('script') 
<script>
        $(document).ready(function () {
            $(".textarea").wysihtml5();

            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass:  'icheckbox_minimal-red',
                radioClass:     'iradio_minimal-red'
            });

            $('#MasterSelectBox').pairMaster();

            $('.btnAdd').click(function(){ $('#MasterSelectBox').addSelected('#PairedSelectBox'); });

            $('.btnRemove').click(function(){ $('#PairedSelectBox').removeSelected('#MasterSelectBox'); });

        });
    </script> 
@stop