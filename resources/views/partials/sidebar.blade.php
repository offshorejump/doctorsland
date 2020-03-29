<!-- Left side column. contains the logo and sidebar -->

<aside class="main-sidebar">   
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar"> 
    
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image" style="position:relative;">
       @if( nonviewed_patient_notifications() > 0 )
      	 <span class="nofication-hub" style="position:absolute; left:0; top:0; background:#f00; color:#fff; border-radius:100px; padding:2px 7px 2px 6px; font-size:12px;"><a href="{{url('patient/referedtome')}}" style="color:#fff;">{{nonviewed_patient_notifications()}}</a></span>
       @endif
      <img src="{{{ Auth::check() ? url('dist/img/').'/'.Auth::user()->avatar : 'dist/img/no-image.png' }}}" class="img-circle" alt="User Image"> </div>
      <div class="pull-left info">
        <p>@if(Session::has('u_fullname'))
          {{ Session::get('u_fullname') }}
          @endif</p>
        <!-- Status --> 
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a> </div>
    </div>
    
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">Navigations</li>

      <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <!-- Navigations for Super Admin and Admin Account --> 
      @if( Auth::check() && Auth::user()->role_id == 1 )
      
      <li><a href="{{ url('/accounts/admins') }}"><i class="fa fa-user"></i> <span>Administrators</span></a></li>
      <li><a href="{{ url('/accounts/doctors') }}"><i class="fa fa-medkit"></i> <span>Doctors</span></a></li>
      <li><a href="{{ url('/types/list') }}"><i class="fa fa-link"></i> <span>Type of Doctor</span></a></li>
      @endif
      
      
      <li><a href="{{ url('/patient/list') }}"><i class="fa fa-link"></i> <span>Patients List</span></a></li>
          
      @if( Auth::check() && Auth::user()->role_id != 1 )
      <li><a href="{{ url('/patient/refer') }}"><i class="fa fa-link"></i> <span>Refer Patient</span></a></li>
      
      <li><a href="{{ url('/patient/refered') }}"><i class="fa fa-link"></i> <span>Patients Referred By Me</span></a></li>
      <li><a href="{{ url('/patient/referedtome') }}"><i class="fa fa-link"></i> <span>Patients Referred To Me</span></a></li>
      @endif
      
      <li><a href="{{ url('settings/profile') }}"><i class="fa fa-gears"></i> <span>Profile Settings</span></a></li>
      <!-- /. Navigations for Admin Account -->
      
    </ul>
    <!-- /.sidebar-menu --> 
  </section>
  <!-- /.sidebar --> 
</aside>



