@extends('layouts.layout')
@section('title', 'New Type')

@section('breadcrumbs', '
<li class="active">New Type</li>
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
    <h3 class="box-title" id="ProfileBlock">New Type</h3>
    <div class="box-tools pull-right"> </div>
  </div>
  <!-- Admins-header -->
  <div class="box-body">
    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        <div class="alert alert-danger" style="display:none"><strong>Alert! </strong><span></span></div>
        <div class="alert alert-success" style="display:none"><strong>Success! </strong><span></span></div>
        {{ Form::open(array('url' => 'types/add_new','id' => 'add_new_type', 'files'=> true)) }}
        <input type="hidden" name="_token" value="{{csrf_token()}}" />
        
        <div class="row">
          <div class="col-sm-12">
            
            <div class="form-group">
              <label>Type Title *</label>
              {{ Form::text('title', '', ['class' => 'form-control','placeholder' => 'Type Title','required']) }} </div>
            
          
            <div class="form-group">
              <input type="submit" class="btn btn-info" value="Add New Type"/>
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