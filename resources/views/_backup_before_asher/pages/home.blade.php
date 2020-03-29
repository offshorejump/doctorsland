@extends('layouts.layout')

@section('title')
	Doctors Referral System
@stop

@section('content')
<div class="jumbotron text-center">
    <h1>Welcome to DRS</h1>
    <p>
        Start managing system with control and ease.
    </p>
    <!--<p>
        <a role="button" href="{{ url('/') }}" class="btn btn-lg btn-success">
            Action
        </a>
        <a role="button" href="{{ url('/') }}" class="btn btn-lg btn-primary">
            Action 2
        </a>
    </p>-->
</div>
<div id="viewReferredOnes" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Patient(s) Referred</h4>
            </div>
            <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
            <div class="modal-body" id="viewReferredOnesData">
            	<h3>Some Doctor Referred you new Patient(s)</h3>
                <a href="{{ url('/patient/referedtome') }}">Click Here to see.</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <!--<button type="submit" class="btn btn-primary">Save</button>--> 
            </div>
        </div>
        {{ Form::close() }} </div>
</div>
@stop
