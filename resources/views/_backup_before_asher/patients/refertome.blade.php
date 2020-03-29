@extends('layouts.layout')
@section('title', 'Patients Refered To Me')
@section('breadcrumbs', '
<li class="active">Patients Refered To Me</li>
')

@section('content') 

<!-- Patients list -->

<div class="box">
  <div class="box-header">
    <h3 class="box-title">Patients Refered To Me</h3>
  </div>
  <!-- Patient-header -->
  
  <div class="box-body">
    
    <table id="patientdatatable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Contact</th>
          <th>Address</th>
          <th>Refered By</th>
          @if( Auth::check() && Auth::user()->role_id > 1 )<th>Actions</th>@endif
        </tr>
      </thead>
      <tbody>
      
      @if( !empty( $patients ) && count( $patients ) > 0 )
      @foreach($patients as $patient)
      
      @if( $patient->is_viewed == 0 )
      	<tr style="font-weight:bold;">
      @else
      	<tr>
      @endif
      
      
        <td>{{$patient->patients->name}}</td>
        <td>{{$patient->patients->email}}</td>
        <td> @if( !empty( $patient->patients->email ) )  <i class="fa fa-envelope-o" aria-hidden="true">  {{$patient->patients->email}}</i>  @endif
        
        
        <br />
        @if( $patient->patients->phone ) 
        <a data-original-title="Call" href="tel:{{$patient->patients->phone}}"> <i class="fa fa-phone" aria-hidden="true"></i> {{$patient->patients->phone}}</a>
        @endif
        
        
        </td>
        <td>{{$patient->patients->address}}</td>
        
        <td> {{$patient->referedby->name}} </td>
        @if( Auth::check() && Auth::user()->role_id > 1 )
        <td  style="width:10%;"><input type="hidden" name="_token" value="{{ csrf_token() }}">
          <a href="patient/show/{{$patient->id}}" class="btn btn-success btn-sm view_patient_button_disabled" data-id="{{$patient->id}}"><i class="fa fa-eye" aria-hidden="true"></i></a>
          
          
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
<!-- View Patient Modal Start -->
<div id="viewPatients" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">View Patient Details</h4>
            </div>
            <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
            <div class="modal-body" id="viewPatientsdata"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <!--<button type="submit" class="btn btn-primary">Save</button>--> 
            </div>
        </div>
        {{ Form::close() }} </div>
</div>
<!--./ View Patient Modal end-->


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
		
		
		/**
            *	Fetch Patients Data and VIEW
            */
            $(".view_patient_button").click( function () {
                var dataString = {
					'id': $(this).attr("data-id"), 
					'_token': $('input[name="_token"]').val(),
					'is_view':"1",
				};
				
				
                $.ajax({
                    type: "POST",
                    url: "{{ url('patient/view')}}",
                    data: dataString,
                    success: function (data) {
						$(".alert").fadeOut(1);
                        $('#viewPatientsdata').html(data);
                        $('#viewPatients').modal("show");
                    }
                });
				
				
				return false;
				
            });
		
	});

</script> 
@stop