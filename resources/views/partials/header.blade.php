<!-- Main Header -->

<header class="main-header"> 
  
  <!-- Logo --> 
  <a href="{{url('/')}}" class="logo"> 
  <!-- mini logo for sidebar mini 50x50 pixels --> 
  <span class="logo-mini"><b>A</b>LT</span> 
  <!-- logo for regular state and mobile devices --> 
  <span class="logo-lg">DRS Panel</span> </a> 
  
  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation"> 
    <!-- Sidebar toggle button--> 
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> </a> 
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        @if( Auth::check() ) 
        
        @endif
        
        @if ( $signedIn) 
        <!-- User Account Menu -->
        <li class="dropdown user user-menu"> 
          <!-- Menu Toggle Button --> 
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
          <!-- The user image in the navbar--> 
          <img src="{{isset(Auth::user()->name) ? url('dist/img/').'/'.Auth::user()->avatar : "dist/img/no-image.png"}}" class="user-image" alt="User Image"> 
          <!-- hidden-xs hides the username on small devices so only the image appears. --> 
          <span class="hidden-xs">{{Auth::check() ? Auth::user()->name : ""}}</span> </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header"> <img src="{{ Auth::check() ? 'dist/img/'.Auth::user()->avatar : "dist/img/no-image.png" }}" class="img-circle" alt="User Image">
              <p> {{Auth::check() ? Auth::user()->name : ""}} <small>Member since <b>{{date("M. Y",strtotime(Auth::user()->created_at))}}</b></small> </p>
            </li>
            <li class="user-footer">
              <div class="pull-left"> <a href="#" class="btn btn-default btn-flat">Profile</a> </div>
              <div class="pull-right">
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
                <a href="#" onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a> </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button --> 
        @else
        <li class="dropdown user user-menu"> 
          <!-- Menu Toggle Button --> 
          <a href="{{ url('/login') }}">Login</a> </li>
        @endif
      </ul>
    </div>
  </nav>
</header>
<!-- /. Main Header --> 
