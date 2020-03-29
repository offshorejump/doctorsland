@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">

                    @include('errors.errors')

                    <form class="form-horizontal validate" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control"
                                name="name" value="{{ old('name') }}"
                                required data-fv-notempty-message="Name is required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username" class="col-md-4 control-label">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control"
                                name="username" value="{{ old('username') }}"
                                required data-fv-notempty-message="Username is required"
                                pattern="^[a-zA-Z][a-zA-Z0-9\.]{6,30}$"
                                data-fv-regexp-message="Password must start with alphabet and contain alphanumeric characters & dot only. It should be 6+ characters long.">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control"
                                name="email" value="{{ old('email') }}"
                                required data-fv-notempty-message="Email is required">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control"
                                name="password"
                                required data-fv-notempty-message="Password is required"
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                data-fv-regexp-message="Password must be at least 1 capital, 1 lowercase, 1 number and 8+ characters long">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation"
                                required data-fv-notempty-message="Password Confirmation is required"
                                data-fv-identical="true" data-fv-identical-field="password"
                                data-fv-identical-message="The password and it's confirmation are not the same">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
