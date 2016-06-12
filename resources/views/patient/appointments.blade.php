@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection


@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>Manage Appointmemnts <a class="ui purple button right" href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></h1>
      <div class="ui divider"></div>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <a class="ui purple button right" href="{{ url('/patient/appointments/add') }}"><i class="fa fa-plus-circle"></i> Make Appointment</a>
    </div>
  </div>
	<div class="row">
		<div class="large-12 columns">
      <h3>My Appointments</h3>
      <div class="ui cards">
        @foreach ($myAppointments as $appointment)
        <div class="red card">
          <div class="content">
            <a href="{{url('doctor/profile/'.$appointment->get('doctorid'))}}"><div class="header">Dr. {{$doctor->equalTo('objectId',$appointment->get('doctorid'))->find()[0]->get('name')}}</div></a>
            <div class="description">
              {{$appointment->get('location')}}<br/>
              {{$appointment->get('date')}} at {{$appointment->get('time')}}
            </div>
          </div>
          <a href="{{ url('/patient/appointments/cancel/'.$appointment->getObjectId()) }}"><div class="ui bottom attached button">
            <i class="remove icon"></i>
            Cancel Appointment
          </div></a>
        </div>
        @endforeach
      </div>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>
</div>
@endsection
