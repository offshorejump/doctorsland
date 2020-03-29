@extends('layouts.layout')
@section('title')
    Refer Patient
@stop

@section('breadcrumbs', '
<li><a href="list_project">Refer Patient</a></li>
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
      <div class="col-md-offset-2 col-md-8"> {{Form::open(['url' => '/patient/add-patient', 'files'=> true, 'id'=>'new_patient']) }}
        <input type="hidden" name="_token" value={{csrf_token()}} />
        <div class="row">
          <div class="col-sm-12">
            <div class="row">
              <div class="col-sm-offset-1 col-sm-2"> {{Form::label('avatar', 'Picture')}} </div>
              <div class="col-sm-8">
                <div class="form-group"> {{Form::File('avatar')}} </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-offset-1 col-sm-2"> {{Form::label('first_name', 'First Name:', ["class" => "text-right"])}} </div>
              <div class="col-sm-8">
                <div class="form-group"> {{Form::Text('first_name','', ['class' => 'form-control', 'placeholder'=>'First Name', 'required'=>'required'])}} </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-offset-1 col-sm-2"> {{Form::label('last_name', 'Last Name:', ["class" => "text-right"])}} </div>
              <div class="col-sm-8">
                <div class="form-group"> {{Form::Text('last_name','', ['class' => 'form-control', 'placeholder'=>'Last Name', 'required'=>'required'])}} </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-offset-1 col-sm-2"> {{Form::label('email', 'Email', ["class" => "text-right"])}} </div>
              <div class="col-sm-8">
                <div class="form-group"> {{Form::Email('email','', ['class' => 'form-control', 'placeholder'=>'Email Address', 'required'=>'required'])}} </div>
              </div>
            </div>
            <div class="form-group">
              <label>Address</label>
              {{Form::textarea('address',null,['placeholder'=>'Address','class'=>'textarea', 'style'=>'width:100%; height:200px; font-size:14px; line-height:18px; border:1px solid #ddd; padding:10px;'])}} </div>
            <div class="row">
              <div class="col-sm-offset-1 col-sm-2"> {{Form::label('phone', 'Phone', ["class" => "text-right"])}} </div>
              <div class="col-sm-8">
                <div class="form-group"> {{Form::Text('phone','', ['class' => 'form-control', 'placeholder'=>'Phone'])}} </div>
              </div>
            </div>
            
            
            <div class="row">
              <div class="col-sm-offset-1 col-sm-2"> {{Form::label('insurance_name', 'Insurance Name', ["class" => "text-right"])}} </div>
              <div class="col-sm-8">
                <div class="form-group"> {{Form::Text('insurance_name','', ['class' => 'form-control', 'placeholder'=>'Insurance Name', 'required'=>'required'])}} </div>
              </div>
            </div>
            
            
            <div class="row">
              <div class="col-sm-offset-1 col-sm-2"> {{Form::label('insurance_type', 'Insurance Type', ["class" => "text-right"])}} </div>
              <div class="col-sm-8">
                <div class="form-group"> {{Form::Text('insurance_type','', ['class' => 'form-control', 'placeholder'=>'Insurance Type', 'required'=>'required'])}} </div>
              </div>
            </div>
            
            
            <div class="row">
              <div class="col-sm-offset-1 col-sm-2"> {{Form::label('insurance_number', 'Insurance Number', ["class" => "text-right"])}} </div>
              <div class="col-sm-8">
                <div class="form-group"> {{Form::Text('insurance_number','', ['class' => 'form-control', 'placeholder'=>'Insurance Number', 'required'=>'required'])}} </div>
              </div>
            </div>
            
            
            <div class="form-group">
              <input type="submit" class="btn btn-info" value="Refer Patient"/>
            </div>
          </div>
        </div>
        {{Form::close() }} </div>
    </div>
  </div>
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

        });
    </script> 
@stop 