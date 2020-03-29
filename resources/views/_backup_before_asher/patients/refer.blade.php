@extends('layouts.layout')
@section('title')
    Refer Patient
@stop

@section('breadcrumbs', '
<li><a href="list_project">Patient</a></li>
<li class="active">Refer Patient</li>
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

    @if(Session::has('success'))
<div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-check"></i> Success</h4>
  <!--{{ Session::get('success') }}--> 
</div>
@endif
<div id="moveto-top"></div>
<div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
<div class="alert alert-success" style="display:none"><strong>Success!</strong> <span></span></div>
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Refer Patient</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
    </div>
  </div>
  <!-- Admins-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-md-offset-2 col-md-8"> {{Form::open(['url' => '/patient/add-refer','id'=>'new_patient']) }}
        <input type="hidden" name="_token" value={{csrf_token()}} />
        
        
            
        <div class="row">
          <div class="col-sm-12">
          
          	<div class="form-group">
              <label>Date</label>
              <div class="input-group date">
                <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
                {{Form::text('refer_date',null,['class'=>'form-control datepicker'])}} </div>
            </div>
          
            <div class="form-group">
              <label>Patient</label>
              <select class="form-control select2" name="patient_id" id="patient_id" data-placeholder="-- Select A Patient --">
                <option disabled selected value> -- Select A Patient -- </option>
                
					@foreach($patients as $patient)                    
						<option value="{{$patient->id}}">{{$patient->name}}</option>
					@endforeach
                                    
              </select>
            </div>
            <div class="form-group">
              <label>Doctor</label>
              <select class="form-control select2" name="refer_to" id="doctor_id" data-placeholder="-- Select A Doctor --" style="width: 100%;">
                <option disabled selected value> -- Select A Doctor -- </option>
				@foreach($doctors as $doctor)                            
                	<option value="{{$doctor->id}}">{{$doctor->name}}</option>
				@endforeach
                                        
              </select>
              <br />
              
              <a href="#" class="btn btn-md btn-default view-doc-info">View Doctor</a>
            </div>
            <div class="form-group">
              <label>Reason</label>
              {{Form::textarea('reason',null,['placeholder'=>'Reason of Refering','class'=>'textarea', 'style'=>'width:100%; height:200px; font-size:14px; line-height:18px; border:1px solid #ddd; padding:10px;'])}} </div>
            <div class="form-group">
              <label>Findings</label>
              {{Form::textarea('findings',null,['placeholder'=>'Any Findings related to Patient','class'=>'textarea', 'style'=>'width:100%; height:200px; font-size:14px; line-height:18px; border:1px solid #ddd; padding:10px;'])}} </div>
            
            <div class="form-group">
              <input type="submit" class="btn btn-info" value="Refer Patient"/>
            </div>
          </div>
        </div>
        {{Form::close() }} </div>
    </div>
  </div>
</div>

<div id="viewDoctor" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">View Details</h4>
            </div>
            <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
            <div class="modal-body" id="viewDoctorData"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        {{ Form::close() }} </div>
</div>


@stop


@section('script') 
<script>
        $(document).ready(function () {

            $('.slider').slider();
            $(".textarea").wysihtml5();

            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            });

            $('#MasterSelectBox').pairMaster();

            $('.btnAdd').click(function(){
                $('#MasterSelectBox').addSelected('#PairedSelectBox');
            });

            $('.btnRemove').click(function(){
                $('#PairedSelectBox').removeSelected('#MasterSelectBox');
            });


            /**
             *  Ajax request
             *
             *  Create New Project
             **/
            $("form").submit(function(){
				
                var obj = $(this);

                $(".alert").fadeOut(100);

                $.ajax({
                    type: "POST",
                    url: $(this).attr("action"),
                    data: $(this).serialize(),
                    success: function (response) {
						
                        if (response == 'Success') {
                            $(".alert-success span").html( "Patient Refered Successfully." );
                            $(".alert-success").fadeIn(400);

                            $("form")[0].reset();

                            var mover = setInterval( function(){
                                $("#addnewcate #category_title").val("");

                                $(".alert").fadeOut(100);
                                clearInterval( mover );
                            }, 2500);
                        } else {
							
                            $(".alert-danger span").html( response );
                            $(".alert-danger").fadeIn(400);
                        }
                    }
                });

                $('html, body').animate({
                    scrollTop: $( "#moveto-top" ).offset().top
                }, 500);

                return false;
            });
			
			
			
			
			/**
            *	Fetch Doctors Data and VIEW
            */
            $(".view-doc-info").click( function () {
                var dataString = {
					'id': $("#doctor_id").val(), 
					'_token': $('input[name="_token"]').val(),
					'is_view':"1",
				};				
				
                $.ajax({
                    type: "POST",
                    url: "{{ url('doctor/view')}}",
                    data: dataString,
                    success: function (data) {
						$(".alert").fadeOut(1);
                        $('#viewDoctorData').html(data);
                        $('#viewDoctor').modal("show");
                    }
                });
				
				
				return false;
				
            });

        });
    </script> 
@stop 