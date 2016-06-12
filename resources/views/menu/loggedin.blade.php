<ul class="right">
  <li class=""><a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a></li>
  <li class=""><a href="{{ url('blogs') }}"><i class="fa fa-rss"></i> Blogs</a></li>
  <li class=""><a href="{{ url('doctor/all') }}"><i class="doctor icon"></i> Doctors</a></li>
  <li class="has-dropdown">
    <a href="#"><i class="fa fa-bars"></i> Menu</a>
    <ul class="dropdown">
      <li><a href="{{ url('/auth/logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
    </ul>
  </li>
</ul>
