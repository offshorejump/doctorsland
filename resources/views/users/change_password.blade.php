@extends('layouts.default')

@section('title')
<title>Change Password - {{ $signedInUser->username }}</title>
@stop

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                Change Password - {{ $signedInUser->username }}
            </div>
            <div class="panel-body">

                @include('errors.errors')
<form class="form-horizontal validate" role="form" method="POST" action="{{ url('/update_password/'.$signedInUser->id) }}">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="current" class="col-md-4 control-label">Current Password</label>

                        <div class="col-md-6">
                            <input id="current" type="password" class="form-control"
                            name="current" value=""
                            required data-fv-notempty-message="Current password is required">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">New Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control"
                            name="password" value=""
                            required data-fv-notempty-message="New password is required"
                            data-fv-different="true" data-fv-different-field="current"
                            data-fv-different-message="The new password shouldn't be same as current"
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                            data-fv-regexp-message="Password must be at least 1 capital, 1 lowercase, 1 number and 8+ characters long">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="col-md-4 control-label">Confirm New Password</label>

                        <div class="col-md-6">
                            <input id="password_confirmation" type="password" class="form-control"
                            name="password_confirmation" value=""
                            required data-fv-notempty-message="Confirm new password is required"
                            data-fv-identical="true" data-fv-identical-field="password"
                            data-fv-identical-message="The new password and it's confirmation are not the same">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
