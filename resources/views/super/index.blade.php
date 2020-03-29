@extends('layouts.layout')
@section('title', 'Companies List')
@section('breadcrumbs', '<li class="active">Companies List</li>')

@section('content')

<!-- Company list -->

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Companies List</h3>
        </div>
        <!-- Company-header -->

        <div class="box-body">
            <button type="button" class="btn btn-primary" style="float:right" data-toggle="modal" data-target="#addnewcompany">Add New</button>
            
            <table id="datatable" class="table table-bordered table-striped dataTable">
                <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @if( !empty( $companies ) && count( $companies ) > 0 )
                    @foreach($companies as $company)
                        <tr>
                            <td>{{$company->title}}</td>
                            <td>{{$company->email}}</td>
                            <td>
                                @if( !empty( $company->email ) )
                                  <a data-original-title="Send Email" href="mailto:{{$company->email}}"> 
                                     <i class="fa fa-envelope-o" aria-hidden="true"></i> 
                                  </a> 
                                @endif
                                
                                @if( !empty( $company->facebook ) )
                                    <a data-original-title="Facebook" href="https://www.facebook.com/{{$company->facebook}}" target="_blank">
                                        <i class="fa fa-facebook" aria-hidden="true"></i> 
                                    </a>
                              @endif
                              
                              @if( !empty( $company->skype ) )
                                <a data-original-title="Skype" href="skype:{{$company->skype}}" target="_blank">
                                    <i class="fa fa-skype" aria-hidden="true"></i> 
                                </a>
                              @endif
                              
                              @if( !empty( $company->linkedin ) )
                                  <a data-original-title="linkedin" href="https://linkedin.com/in/{{$company->linkedin}}" target="_blank">
                                     <i class="fa fa-linkedin" aria-hidden="true"></i> 
                                  </a>
                              @endif
                              
                               @if( !empty( $company->twitter ) )
                                  <a data-original-title="Twitter" href="https://twitter.com/{{$company->twitter}}" target="_blank"> 
                                     <i class="fa fa-twitter" aria-hidden="true"></i>
                                  </a>
                              @endif
                            </td>
                            <td>{{$company->address}} <br /> {{$company->city}}, {{$company->state}}<br /> {{$company->Country->name}}</td>

                            
                            <td  style="width:10%;"><input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button class="btn btn-primary btn-sm edit_company_btn" type="submit" name="id"
                                        value="{{$company->id}}"><i class="fa fa-edit " aria-hidden="true"></i></button>

                                    <!--<button class="btn btn-danger btn-sm delete_company_btn" type="submit" name="dell_id" value="{{$company->id}}">
                                    <i class="fa  fa-trash"></i>
                                    </button>-->
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>

            </table>
        </div>
    </div>

    <!-- New Company Modal Start -->
    <div id="addnewcompany" class="modal fade"
         role="dialog"> 
        {{ Form::open(array('url' => 'company/new/','id'=>'new_company')) }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">New Company</h4>
                </div>
                
                <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
                <div class="alert alert-success" style="display:none"><strong>Success!</strong> <span></span></div>
                
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group"> {{Form::label('title', 'Company Name')}}
                            {{Form::Text('title','', array('class' => 'form-control', 'placeholder'=>'Enter Company Name', 'required'=>'required'))}} </div>
                                                        
                        <div class="form-group"> {{Form::label('email', 'Email Address')}}
                            {{Form::Email('email','', array('class' => 'form-control', 'placeholder'=>'Enter Email Address', 'required'=>'required'))}}
                            <i id="email_message" style="color:red"></i></div>
                        
                        
                         <div class="form-group"> {{Form::label('address', 'Address')}}
                             {{Form::textarea('address',null,['class' =>'form-control','style'=>'height:120px;resize:none'])}}
                         </div>
                        
                        <div class="form-group"> {{Form::label('city', 'City')}}
                            {{Form::Text('city','', array('class' => 'form-control', 'placeholder'=>'City Name'))}} 
                        </div>
                        
                        <div class="form-group"> {{Form::label('state', 'State')}}
                            {{Form::Text('state','', array('class' => 'form-control', 'placeholder'=>'State'))}} 
                        </div>
                        
                        <div class="form-group"> {{Form::label('country', 'Country')}}
                            {{Form::Select('country',$countries,'', array('class' => 'form-control'))}} 
                        </div>

                        
                        <div class="form-group"> {{Form::label('facebook', 'Facebook')}}
                            {{Form::Text('facebook','', array('class' => 'form-control', 'placeholder'=>'Facebook ID'))}} </div>
                            
                        
                        <div class="form-group"> {{Form::label('twitter', 'Twitter')}}
                            {{Form::Text('twitter','', array('class' => 'form-control', 'placeholder'=>'Twitter ID'))}} </div>
                            
                            
                        <div class="form-group"> {{Form::label('linkedin', 'Linked In')}}
                            {{Form::Text('linkedin','', array('class' => 'form-control', 'placeholder'=>'LinkedIn ID'))}} </div>
                            
                            
                            
                            
                       	
                            
                        
                            
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            {{ Form::close() }} </div>
    </div>
    <!--  New Staff Modal end-->

    <!-- Edit Company Modal Start -->
    <div id="editcompany" class="modal fade" role="dialog"> {{ Form::open(array('url' => 'company/update', 'id'=>'update_company')) }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Update Company</h4>
                </div>
                
                <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
                <div class="alert alert-success" style="display:none"><strong>Success!</strong> <span></span></div>
                
                <div class="modal-body" id="editcompanydata"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            {{ Form::close() }} </div>
    </div>
    <!--  New Staff Modal end-->


<div id="dell_client" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">New Client Person</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <button type="button" name="dell_id" id="person_id" class="hidden"></button>
                        Are you sure you want to delete this client?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" id="delete_person" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')
    <!-- jQuery 2.2.3 -->
    <script type="text/javascript">
        $(document).ready(function () {

             /*$('datatable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });*/


            /**
            *	Fetch Data and Put into Edit Model
            */
            $(".edit_company_btn").click(function () {
                var dataString = {'id': $(this).val(), '_token': $('input[name="_token"]').val()};

                $.ajax({
                    type: "POST",
                    url: "{{url('company/get-company')}}",
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        $('#editcompanydata').html(data);
                        $('#editcompany').modal('toggle');
                    }
                });
            });


            /**
             *	Function to fetch roles
             */
            function fetch_roles(){
                $.ajax({
                    type: "POST",
                    data: {'_token': "{{ csrf_token() }}"},
                    url: "{{ url('/')}}/get-roles",
                    cache: false,
                    success: function (response) {
                        $("#roleslist").html(response);
                    }
                });

            }



            /**
            * Trigger when Add new Company button pressed.
            */
            $("#new_company").on('submit', function (e) {

                var options = {
                    url: $(this).attr("action"),
                    success: onsuccess
                };
                $(this).ajaxSubmit(options);

                return false;
            });



            /**
             *	jQuery: Call back function for New Staff
             */
            function onsuccess(response, status) {
                if (response == 'Email already registered')
                    $('#email_message').html(response);

                if (response == 'Please fill all the required feilds') {

                }
                if (response == 'Success') {
                    $(".alert-success span").html( "New Company Added Successfully." );
                    $(".alert-success").fadeIn(400);

                    var mover = setInterval( function(){
                        window.location.reload();
                        clearInterval( mover );

                        $("#new_company")[0].reset();
                    }, 1000);
                } else {
					 $(".alert-danger span").html( response );
                     $(".alert-danger").fadeIn(400);	
				}
            }


            /**
            *	Trigger when update is pressed.
            */
            $("#update_company").on('submit', function (e) {
                var options = {
                    url: $(this).attr("action"),
                    success: onUpdateSuccessCallback,
                };

                $(this).ajaxSubmit(options);
                return false;
            });


            /**
             *	jQuery: Callback function for Staff Update
             */
            function onUpdateSuccessCallback(response, status) {
                if (response == 'Email already registered')
                {
                    $(".alert-danger span").text( response );
                    $(".alert-danger").fadeIn(400);
                }
                    

                if (response == 'Please fill all the required feilds') {
                    $(".alert-danger span").text( response );
                    $(".alert-danger").fadeIn(400);
                }


                if (response == 'Success') {
                    $(".alert-success span").html( "Company Details Updated Successfully." );
                    $(".alert-success").fadeIn(400);

                    var mover = setInterval( function(){
                        window.location.reload();
                        clearInterval( mover );

                        $("#new_company")[0].reset();
                    }, 2000);
                }
            }



            /**
            * Trigger when Delete Client Button is pressed. Will show Del Model
            */
            $(".delete_company_btn").on('click',function () {
                var client_id = $(this).attr('value');
                $('#person_id').val(client_id);
                $('#dell_client').modal('show');
            });



            /**
             * Trigger when Delete button from model is pressed
             */
            $('#delete_person').on('click',function () {
                var company_id = $('#person_id').val();

                $.ajax({
                    type: 'POST',
                    url: "{{url('company/remove')}}",
                    data:{
                        'company_id':company_id,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (response) {

                        $('#client_person_record tr').each(function() {
                            if ($(this).attr('id') == client_id) {
                                $(this).remove();
                            }else{}
                        });


                       window.location.reload();
                    },
                    error:function () {
                        alert("fail");
                    }
                });
            });

        });

    </script>
@stop