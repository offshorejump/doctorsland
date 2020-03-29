@extends('layouts.layout')
@section('title', 'Team Tasks')
@section('breadcrumbs', '<li class="active">Running Tasks</li>')

@section('content')

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Running Tasks</h3>
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#addnewtask">Add New
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

                                @foreach($task_list as $items)
                                    <li><a href="{{url('tasks',['id' => $items->id])}}">{{$items->title}}</a></li>
                                @endforeach

                            </ul>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <h1 class="text-muted select-text">Please select task title first</h1>
                            @foreach($task_id as $item)

                                <div class="box box-success des-box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">{{$item->title}}</h3>

                                        <div class="box-tools pull-right">

                                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#edittask">
                                                <span data-toggle="tooltip" title="Edit Task">
                                                    <i class="fa fa-pencil"></i>
                                                </span>
                                            </button>
                                            <button type="button" title="delete" data-target="#delete_modal" data-toggle="modal" class="btn btn-box-tool">
                                                <span data-toggle="tooltip" title="Delete Task">
                                                    <i class="fa fa-trash"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        {{Form::open(['url' => ['add_tasks', $item->id]])}}

                                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                                        <div class="form-group">
                                            {{Form::textarea('description',$item->description, ['class' => 'form-control','placeholder'=>'Please add description'])}}
                                        </div>

                                        {{Form::submit('Update Description', ['class' => 'btn btn-primary'])}}

                                        {{Form::close()}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-3">
                        @foreach($task_id as $item)
                            <div class="task-right">
                                <div class="alert alert-success">
                                    <a href="javascript:;" data-status="{{$item->status}}"  class="close" data-toggle="tooltip" id="archive_btn" title="Move to Archive"><i class="fa fa-archive"></i> <button class="task_id hidden" value="{{$item->id}}" class="hidden">{{$item->id}}</button> </a>
                                    Running task.
                                </div>
                                <div class="task-duration">
                                    <table width="100%" class="text-center">
                                        <tbody>

                                        <tr>
                                            <td  class="text-left">Date Create</td>
                                            <td> : </td>
                                            <td>{{$item->start_date}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Due Date</td>
                                            <td> : </td>
                                            <td>{{$item->end_date}}</td>
                                        </tr>

                                        </tbody></table>

                                </div>

                                <div class="assign-team box box-default">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Assigned Staff</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" data-toggle="modal" data-target="#edittask" class="btn btn-box-tool">
                                            <span data-toggle="tooltip" title="Add Staff">
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        @foreach(explode(',', $item->team_id) as $staff_name)
                                            <span class="label label-default">{{$staff_name}}</span>
                                        @endforeach
                                    </div>
                                </div>


                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Add files</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" data-toggle="modal" data-target="#file_upload" class="btn btn-box-tool">
                                            <span data-toggle="tooltip" title="Add File">
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        @foreach(explode(',', $item->files) as $task_files)
                                            @if(!empty($task_files))
                                            <span class="label label-default" style="margin: 0px 3px;"><a download href="{{ getenv('APP_STORAGE') }}/app/{{$task_files}}">{{$task_files}}</a> </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="addnewtask" class="modal fade" role="dialog">
        {{Form::open(['url'=> 'add_tasks']) }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add New Task</h4>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            {{Form::label('title', 'Title')}}
                            {{Form::Text('title',null, ['class' => 'form-control','placeholder'=>'Enter Title','required'])}}
                        </div>


                        <div class="form-group">
                            {{Form::label('startDate', 'Creation Date')}}
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                {{Form::text('startDate',null,['class'=>'form-control datepicker'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('dueDate', 'Due Date')}}
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                {{Form::text('dueDate',null,['class'=>'form-control datepicker'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Assign Staff</label>



                            <select name="staff[]" class="form-control select2" multiple="multiple" data-placeholder="Select Staff" style="width: 100%;">
                                @foreach($staff as $items)
                                    <option  value="{{$items->name}}">{{$items->name}}</option>
                                @endforeach
                            </select>


                        </div>


                        <div class="form-group">
                            {{Form::label('status', 'Status')}}
                            <div class="input-group" style="width:100%">
                                {{Form::select('status', array('Active'=>'Active','Inactive'=>'Inactive'), null,array('class' => 'form-control','style'=>'width:100%','required')) }}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    {{Form::submit('Add Task', ['class' => 'btn btn-primary'])}}
                </div>
            </div>
        </div>
        {{Form::close() }}
    </div>

    <div id="edittask" class="modal fade" role="dialog">

        @foreach($task_id as $item)

            {{Form::open(['url'=> ['add_tasks', $item->id]])}}
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Edit Task</h4>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                {{Form::label('title', 'Title')}}
                                {{Form::Text('title',$item->title, ['class' => 'form-control','placeholder'=>'Enter Title','required'])}}
                            </div>


                            <div class="form-group">
                                {{Form::label('startDate', 'Creation Date')}}
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {{Form::text('startDate',$item->start_date,['class'=>'form-control datepicker'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                {{Form::label('dueDate', 'Due Date')}}
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {{Form::text('dueDate',$item->end_date,['class'=>'form-control datepicker'])}}
                                </div>
                            </div>




                            <div class="form-group">
                                <label>Assign Staff</label>

                                <select name="staff[]" class="form-control select2" multiple="multiple" data-placeholder="Select Staff" style="width: 100%;">

                                    @foreach($staff as $items)
                                        <option  value="{{$items->name}}">{{$items->name}}</option>
                                    @endforeach

                                    @foreach (explode(',', $item->team_id) as $staff_name)
                                        <option value="{{$staff_name}}" selected="selected">{{$staff_name}}</option>
                                    @endforeach

                                </select>


                            </div>


                            <div class="form-group">
                                {{Form::label('status', 'Status')}}
                                <div class="input-group" style="width:100%">
                                    {{Form::select('status', array('Active'=>'Active','Inactive'=>'Inactive'), $item->status ,array('class' => 'form-control','style'=>'width:100%','required')) }}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        {{Form::submit('Update Task', ['class' => 'btn btn-primary'])}}
                    </div>
                </div>
            </div>
            {{Form::close() }}

        @endforeach

    </div>

    <div id="delete_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Delete Task</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this task?</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    @foreach($task_id as $item)
                        <button type="button" class="btn btn-danger" id='delete-btn' value="{{$item->id}}">Delete</button>
                    @endforeach
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="file_upload" class="modal fade" role="dialog">
        @foreach($task_id as $item)

            <div class="modal-dialog">
                <div class="modal-content">
                    {{Form::open(['url'=> ['add_tasks', $item->id], 'files' => true])}}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add Task File</h4>
                    </div>

                    <div class="modal-body">
                        <div class="box-body">
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            <div class="form-group">
                                <input name="file" type="file" multiple/>
                                <input name="p_files" type="hidden" value="{{$item->files}}"/>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-primary">Add File</button>

                    </div>
                    {{Form::close() }}
                </div>

            </div>


        @endforeach
    </div>

@endsection


@section('script')
    <script>

        $(document).ready(function () {

            $(".des-box").parent('.tab-content').find('.select-text').remove();


            $(".select2 option:selected").each(function(){
                $(this).siblings("[value='"+ this.value+"']").remove();
            });

        });


        /**
         *  Ajax Request
         *
         *  Delete Tasks
         **/
        $("#delete-btn").on('click',function () {
            var task_id = $(this).attr('value');
            $.ajax({
                type: 'POST',
                url: '{{url("/dell_tasks")}}',
                data:{
                    task_id:task_id,
                    '_token': '{{csrf_token()}}'
                },
                success: function (data) {
                    window.location.href = "{{ url('/tasks')}}";
                },
                error:function () {
                    alert("fail");
                }
            });
        });


        /**
         *  Ajax Request
         *
         *  Make Tasks Archived
         **/
        $("#archive_btn").on('click',function(){
            var task_id = $(".task_id").val();
            var task_status = $(this).attr('data-status');
            $.ajax({
                type: 'POST',
                url: '{{url("/archive_task")}}',
                data:{
                    task_id:task_id,
                    task_status:task_status,
                    '_token':'{{csrf_token()}}'
                },
                success:function(data){
                    window.location.href = "{{ url('/tasks')}}";
                },
                error:function(){
                    alert('failed');
                }
            });


        });
    </script>

@endsection