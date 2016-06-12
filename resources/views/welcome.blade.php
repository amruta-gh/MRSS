<html>
	<head>
		<title>Medicalize</title>

		<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
		<link href="{{ asset('/semantic/dist/semantic.min.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #FFFFFF;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
				background : grey;

			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			  background: url({{asset('images/bg.jpg')}}) no-repeat center center fixed;
				-webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 36px;
				margin-bottom: 40px;
				position: absolute;
				top: 0px;
				left: 0px;
				padding: 16px;
				font-weight: 300;
				width:100%;
				text-align: left;
				text-shadow: 2px 2px 2px #000000;
				background: rgba(0,0,0,0.4);
			}

			.quote {
				font-size: 24px;
			}

			.doctorpanel{
				position: absolute;
				top: 115px;
				right: 0px;
				text-align: right;
				background: rgba(65,9,84,0.4);
				padding:16px;
			}

			.nursepanel{
				position: absolute;
				top: 266px;
				right: 0px;
				text-align: right;
				background: rgba(65,9,84,0.4);
				padding:16px;
				text-shadow: 2px 2px 2px #000000;

			}

			.patientpanel{
				position: absolute;
				top: 417px;
				right: 0px;
				text-align: right;
				background: rgba(65,9,84,0.4);
				padding:16px;
				text-shadow: 2px 2px 2px #000000;
			}

			.titlepanel{
				font-size: 42px;
				font-weight: 400;
			}

		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">Medicalize</div>
				<div class="quote">
					<div class="ui buttons">
						<a href="{{url('auth/login')}}"><div class="ui black massive button"><i class="fa fa-sign-in"></i> Log In</div></a>
					  <div class="or" style="margin-top: 12px;"></div>
						<a href="{{url('auth/register')}}"><div class="ui purple massive button"><i class="fa fa-plus"></i> Sign Up</div></a>
					</div>
					<div style="text-shadow: 2px 2px 2px #000000; padding: 16px; position: absolute; bottom:0px; right: 0px;"><br>
						CPSC 542 Project By Melina Devaraj & Amruta Ghangale
					</div>
				</div>
			</div>
			<div class="doctorpanel">
				<div class="titlepanel">
					 Doctors
				</div>
				<div class="textpanel">
					Check Medical Records, Add Prescriptions<br> and Manage Appoitments
				</div>
			</div>

			<div class="nursepanel">
				<div class="titlepanel">
					 Nurses
				</div>
				<div class="textpanel">
					Check vitals, upload scans<br> and dispense prescribed drugs
				</div>
			</div>

			<div class="patientpanel">
				<div class="titlepanel">
					 Patients
				</div>
				<div class="textpanel">
					Manage appointments, review your record<br> and check your prescriptions
				</div>
			</div>

		</div>
	</body>
</html>
