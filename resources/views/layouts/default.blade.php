@if(isset( Auth::user()->name ))
  <script>
    window.location.href = "{{ url('/login')}}";
  </script>
@endif

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <base href="http://newtest.byethost7.com/public/" />
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
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <!-- Main Header -->
  @include("partials.header")
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper login">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content"> @yield('content') </section>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="js/jquery.form.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!--datepicker-->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!--bootstrap slider-->
<script src="plugins/bootstrap-slider/bootstrap-slider.js"></script>
<!--select 2-->
<script src="plugins/select2/select2.full.min.js"></script>
<!--pair select-->
<script src="plugins/pair-select/pair-select.min.js"></script>
<!--pair select-->
<script src="plugins/iCheck/icheck.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->

@yield('script')
<script>

  $(function() {
    $(".datepicker").datepicker({ format: 'yyyy/mm/dd',autoclose:true });
    $('.datatable').DataTable();
    $(".select2").select2();
  });

</script>
</body>
</html>
