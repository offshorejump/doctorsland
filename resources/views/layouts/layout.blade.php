@if(!isset( Auth::user()->name ))
    <script>
        window.location.href = "{{ url('/login')}}";
    </script>
@endif

<!--getenv('APP_URL', 'http://newtest.byethost7.com/')-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <base href="http://localhost:8000/" />
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="assets/css/static.css">
    @yield('css')
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Data table -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!--date picker-->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!--bootstrap slider-->
    <link rel="stylesheet" href="plugins/bootstrap-slider/slider.css">
    <!--select 2-->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!--select 2-->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.css"/>
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="plugins/dropzone-master/dist/dropzone.css">
	<link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.css">

	@yield('styles')
</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

    <!-- Main Header -->
@include("partials.header")
<!-- Left side column. contains the logo and sidebar -->
@include("partials.sidebar")

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> @yield('title')</h1>
            <ol class="breadcrumb">
                <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                @yield('breadcrumbs')
            </ol>
        </section>

        <!-- Main content -->
        <section class="content"> @yield('content') </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">Laravel PMS</div>
        <!-- Default to the left -->
        <strong>Copyright &copy; {{date('Y')}} <a target="_blank" href="#">Softsourcepk</a>.</strong> All rights reserved. </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>	
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li> <a href="javascript:;"> <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a> </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li> <a href="javascript:;">
                            <h4 class="control-sidebar-subheading"> Custom Template Design <span class="pull-right-container"> <span class="label label-danger pull-right">70%</span> </span> </h4>
                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width:70%"></div>
                            </div>
                        </a> </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>
                    <div class="form-group">
                        <label class="control-sidebar-subheading"> Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                        <p> Some information about this general settings option </p>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->








</body>

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script type="text/javascript" src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!--<script type="text/javascript" src="https://adminlte.io/themes/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>-->
<!-- Bootstrap 3.3.6 -->
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script type="text/javascript" src="plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script type="text/javascript" src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script type="text/javascript" src="plugins/fastclick/fastclick.js"></script>
<script type="text/javascript" src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!--datepicker-->
<script type="text/javascript" src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!--bootstrap slider-->
<script type="text/javascript" src="plugins/bootstrap-slider/bootstrap-slider.js"></script>
<!--select 2-->
<script type="text/javascript" src="plugins/select2/select2.full.min.js"></script>
<!--pair select-->
<script type="text/javascript" src="plugins/pair-select/pair-select.min.js"></script>
<!--pair select-->
<script type="text/javascript" src="plugins/iCheck/icheck.min.js"></script>
<!-- AdminLTE App -->
<script  type="text/javascript" src="dist/js/app.js"></script>

<!-- AdminLTE for demo purposes -->
<script type="text/javascript" src="dist/js/demo.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>




<script type="text/javascript" src="https://adminlte.io/themes/AdminLTE/bower_components/Flot/jquery.flot.js"></script>
<script type="text/javascript" src="https://adminlte.io/themes/AdminLTE/bower_components/Flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="https://adminlte.io/themes/AdminLTE/bower_components/Flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="https://adminlte.io/themes/AdminLTE/bower_components/Flot/jquery.flot.categories.js"></script>


<script type="text/javascript" src="plugins/fullcalendar/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="plugins/fullcalendar/moment.min.js"></script>
<script type="text/javascript" src="plugins/fullcalendar/fullcalendar.js"></script>




@yield('script')
<script>
	$(document).ready(function() {
		var ref_patients = <?=nonviewed_patient_notifications();?>;
		if( ref_patients > 0 ) {
			$('#viewReferredOnes').modal("show");
		}
    });
</script>
<script>
    $(function() {
        $(".datepicker").datepicker({ format: 'yyyy/mm/dd',autoclose:true });
        $('.datatable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        $(".select2").select2();
    });


</script>

</html>
