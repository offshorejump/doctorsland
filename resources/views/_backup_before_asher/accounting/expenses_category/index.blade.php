@extends('layouts.layout')
@section('title')Expenses Category @stop

@section('breadcrumbs', '<li class="active">Expenses Category</li>')

@section('content')

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Manage Expenses Categories</h3>
            <button type="button" class="btn btn-primary" style="float:right" data-toggle="modal" data-target="#addnew" >Add New</button>
        </div>

        <!-- /.box-header -->

        <div class="box-body">

            <table class="table table-bordered table-striped datatable" id="cat_record">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($all_cat as $items)
                    <tr id="{{$items->id}}">
                        <td>{{$items->title}}</td>
                        <td>{{$items->description}}</td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-btn" value="{{$items->id}}">
                                <i class="fa fa-edit"></i>
                            </button>
                                <button class="btn btn-danger btn-sm delete-modal" data-target="#delete_cat" data-toggle="modal" value="{{$items->id}}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>


    <div id="addnew" class="modal fade" role="dialog">
        <div class="modal-dialog">

            {{Form::open(['url' => '/new_cat']) }}

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add New Category</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            {{Form::label('title', 'Title')}}
                            {{Form::Text('title','', array('class' => 'form-control', 'placeholder'=>'Enter Category Title', 'required'=>'required'))}} </div>
                        <div class="form-group">
                            {{Form::label('description', 'Description')}}
                            {{Form::textarea('description','', array('class' => 'form-control', 'placeholder'=>'Add Description', 'required'=>'required'))}} </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            {{Form::close() }} </div>
    </div>

    <div id="edit_cat" class="modal fade" role="dialog">
        <div class="modal-dialog">

            {{Form::open(['url' => '/update_cat']) }}
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add New Category</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body edit-box">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            {{Form::close() }} </div>
    </div>

    <div id="delete_cat" class="modal fade" role="dialog">
        <div class="modal-dialog">


            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete Category</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body edit-box">
                        Are you sure you want to delete this category?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger delete_cat_btn">Delete</button>
                </div>
            </div>
        </div>
    </div>
@stop


@section('script')

    <script>
        $(document).ready(function(){
           $(".edit-btn").on('click',function(){
               var cat_id = $(this).attr('value');
               $.ajax({
                   type: 'POST',
                   url: '{{url("/edit_cat")}}',
                   data:{
                       cat_id:cat_id,
                       '_token': '{{csrf_token()}}'
                   },
                   success:function (data) {
                       $('.edit-box').html(data);
                       $('#edit_cat').modal('show');
                   },
                   error:function () {
                       alert('error');
                   }

               })

           });

            /**
            *   Show Delete Confirmation Model
            **/
            $('.delete-modal').click(function () {
               var cat_value_id =  $(this).attr('value');
                $('.delete_cat_btn').attr('value', cat_value_id);
            });


            /**
             *  Delete Category
             **/
            $('.delete_cat_btn').on('click',function(){
                var cat_id = $(this).attr('value');
                $.ajax({
                    type: 'POST',
                    url: '{{url("/dell_cat")}}',
                    data:{
                        cat_id:cat_id,
                        '_token': '{{csrf_token()}}'
                    },
                    success:function (data) {
                        $('#cat_record tr#'+cat_id+'').hide();
                        $('#delete_cat').modal("hide");
                    },
                    error:function () {
                        alert('error');
                    }

                })
            });
        });
    </script>


    @stop