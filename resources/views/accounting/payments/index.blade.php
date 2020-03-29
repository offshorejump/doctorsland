@extends('layouts.layout')
@section('title', 'Client Payments')
@section('breadcrumbs', '<li class="active">Client Paymnets</li>')

@section('content')

<!-- Payments list -->

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Client Payments</h3>
        </div>
        <!-- payments-header -->

        <div class="box-body">
            <table id="paymentlistdatatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Project</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($payments as $payment)
                    <tr>
                        <td>{{$payment->Projects->title}}</td>
                        <td>{{$payment->Projects->Client->name}}</td>
                        <td>{{date("M d, Y", strtotime($payment->created_at))}}</td>
                        <td>{{$payment->amount}}</td>
                        <td><input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-primary btn-sm edit_payment_btn" type="submit" name="id" value="{{$payment->id}}"><i class="fa fa-info" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>

    
    <!-- bootstrape Modal to Edit payments -->
    <div id="editpayment" class="modal fade" role="dialog">
    {{ Form::open(array('url' => '/project-room/payments/update-payment', 'id'=>'update_payment')) }}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">View Invoice</h4>
            </div>

            <div class="alert alert-danger" style="display:none"><strong>Alert!</strong> <span></span></div>
            <div class="alert alert-success" style="display:none"><strong>Success!</strong> <span></span></div>

            <div class="modal-body" id="editpaymentdata">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary pull-update">Save</button>
            </div>
        </div>
        {{ Form::close() }} </div>
</div>
    <!-- ./ Modal end-->


@stop


@section('script')
    <script>
        $(document).ready(function () {
            $('#paymentlistdatatable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });


            /**
            *	Fetch Payment Data and Put into Edit Model
            */
            $(".edit_payment_btn").click(function () {
                var payment_id = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: "{{url('/project-room/payments/view-payment')}}",
                    data:{
                        'payment_id': payment_id,
                        '_token': '{{csrf_token()}}'
                    },
                    success: function (response) {
                        $('#editpaymentdata').html(response);
                        $("#editpayment").modal('show');
                    },
                    error:function () {
                        alert("fail");
                    }
                });
            });


        });
    </script>

@stop