<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CSPC 542 Project</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/semantic/dist/semantic.min.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div class="bg">
		<img src="{{asset('images/bg_light.jpg')}}" style="width:100%">
	</div>
	<nav class="top-bar" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <h1><a href="{{ url('/') }}">Medicalize</a></h1>
    </li>
     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
  </ul>

  <section class="top-bar-section">
    <!-- Right Nav Section -->
		@yield('menu')

  </section>
</nav>
<div class="clear"></div>
	@yield('content')
<div class="clear" style="height:56px"></div>
<div class="footer">
	CPSC 542 Project | Melina Devaraj & Amruta Ghangale
</div>
	<!-- Scripts -->
	<script src="{{ asset('/semantic/dist/semantic.min.js') }}"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="{{ asset('/bower_components/foundation/js/foundation.min.js') }}"></script>
	<script src="{{ asset('/bower_components/foundation/js/vendor/modernizr.js') }}"></script>
	<script src="{{ asset('/bower_components/foundation/js/foundation/foundation.clearing.js') }}"></script>
	<script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>
