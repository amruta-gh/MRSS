<!doctype html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Health Record System</title>
		{{ HTML::style('css/app.css'); }}
		{{ HTML::script('bower_components/modernizr/modernizr.js'); }}
	</head>
	<body>
		<div>
			<nav class="top-bar" data-topbar role="navigation">
				<ul class="title-area">
					<li class="name">
						<h1><a href="#">Health Record System</a></h1>
					</li>
					<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
					<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
				</ul>

				<section class="top-bar-section">
					<!-- Right Nav Section -->
					<ul class="right">
						<li class=""><a href="#" class="button success" style="right:5px; ">Sermons</a></li>
						<li class="divider"></li>
						<li class=""><a href="#">Study Material</a></li>
						<li class="divider"></li>
						<li class="has-dropdown">
							<a href="#">Departments</a>
							<ul class="dropdown">
								<li><a href="#">Sunday School</a></li>
								<li><a href="#">Teens' Fellowship</a></li>
								<li><a href="#">Young Adults</a></li>
								<li><a href="#">Men's Fellowship</a></li>
								<li><a href="#">Women's Fellowship</a></li>
								<li><a href="#">Senior Citizens</a></li>
							</ul>
						</li>
						<li class="divider"></li>
						<li class="has-dropdown">
							<a href="#">About Us</a>
							<ul class="dropdown">
								<li><a href="#">We Believe</a></li>
								<li><a href="#">The Board and Elders</a></li>
								<li class=""><a href="#">Gallery</a></li>
								<li><a href="#">Contact Us</a></li>
							</ul>
						</li>
					</ul>

					<!-- Left Nav Section -->
					<ul class="left">
						<!--<li><a href="#">BBC</a></li>-->
					</ul>
				</section>
			</nav>
		</div>

		<div class="clear"></div>
		<div class="clear"></div>

		<div class="row">
			<div class="small-2 medium-3 large-4 columns">
				&nbsp
			</div>
			<div class="small-8 medium-6 large-4 columns">
				{{ HTML::image('images/logo.png'); }}
			</div>
			<div class="small-2 medium-3 large-4 columns">
			</div>
		</div>

		<div class="clear"></div>

		<div class="row">
			<div class="small-12 columns">
				<div class="panel callout radius">
					<h5>Website Under Construction.</h5>
					<div class="progress large-12 secondary radius">
						<span class="meter" style="width: 10%"></span>
					</div>
				</div>
			</div>
		</div>



		{{ HTML::script('bower_components/jquery/dist/jquery.min.js'); }}
		{{ HTML::script('bower_components/foundation/js/foundation.min.js'); }}
		{{ HTML::script('js/app.js'); }}
	</body>
</html>
