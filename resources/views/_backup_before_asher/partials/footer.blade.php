 <!-- Main Footer -->
  <footer class="main-footer"> 
    <!-- To the right -->
    <div class="pull-right hidden-xs"> Anything you want </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ date('Y') }} <a href="#">Company</a>.</strong> All rights reserved. </footer>
  
  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper --> 

<!-- REQUIRED JS SCRIPTS --> 

<!-- jQuery 2.2.3 --> 
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script> 
<!-- Bootstrap 3.3.6 --> 
<script src="bootstrap/js/bootstrap.min.js"></script> 
<!-- AdminLTE App --> 
<script src="dist/js/app.min.js"></script> 
<!-- DataTables --> 
<script src="plugins/datatables/jquery.dataTables.min.js"></script> 
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script> 
<!-- SlimScroll --> 
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script> 
<!-- FastClick --> 
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<script src="js/apps.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->


<script>
  $(function () {
    $('#adminlistdatatable').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>

<!-- Scripts -->
<script src="assets/js/all.js"></script>

@include('flash')
@yield('script')
</body>
</html>