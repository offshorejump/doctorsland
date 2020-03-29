@extends('layouts.layout')
@section('title', 'Messages')
@section('breadcrumbs', '<li class="active">Messages</li>')

@section('content')

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Messages</h3>
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addnew">Add New
            </button>
        </div>
        <!-- Admins-header -->
        <div class="box-body">
            <div class="notes-list">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="notes-title-list">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                    <li><a href="#">z</a></li>
                                    <li><a href="#">z</a></li>
                                    <li><a href="#">z</a></li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-sm-9">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <h1 class="text-muted select-text">Please select task title first</h1>


                                <div class="box box-custom des-box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">ddd</h3>

                                        <div class="box-tools pull-right">

                                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <p>skdfjdskfjdskfdjsfksdfkds sdjfdskf jsdfjdsf sdkfjsd aoweiru </p>
                                    </div>
                                </div>
                            <div class="box box-custom des-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">ddd</h3>

                                    <div class="box-tools pull-right">

                                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <p>skdfjdskfjdskfdjsfksdfkds sdjfdskf jsdfjdsf sdkfjsd aoweiru </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop



@section('script')
@stop
