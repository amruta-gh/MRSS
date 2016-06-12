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
      <a class="ui purple button right" href="{{ url('/doctor/appointments/add') }}"><i class="fa fa-plus-circle"></i> Add</a>
    </div>
  </div>
	<div class="row">
		<div class="large-12 columns">
      <h3>Booked Appointments</h3>
      <div class="ui cards">
        @foreach ($bookedAppointments as $appointment)
        <div class="red card">
          <div class="content">
            <div class="header"><a href="{{ url('/patient/record/'.$appointment->get('appointmentfor')) }}"> {{$patient->equalTo('objectId', $appointment->get('appointmentfor'))->find()[0]->get('name')}}</a></div>
            <div class="description">
              {{$appointment->get('location')}}<br>
              {{$appointment->get('date')}} at {{$appointment->get('time')}}
            </div>
          </div>
          <a href="{{URL('doctor/appointments/delete/'.$appointment->getObjectId())}}"><div class="ui bottom attached button">
            <i class="remove icon"></i>
            Delete
          </div></a>
        </div>
        @endforeach
      </div>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>
  <div class="row">
    <br><div class="ui divider"></div><br>
		<div class="large-12 columns">
      <h3>Available Appointments</h3>
      <div class="ui cards">
        @foreach ($availableAppointments as $appointment)
        <div class="green card">
          <div class="content">
            <div class="header">{{$appointment->get('location')}}</div>
            <div class="description">
              {{$appointment->get('date')}} at {{$appointment->get('time')}}
            </div>
          </div>
          <a href="{{URL('doctor/appointments/delete/'.$appointment->getObjectId())}}"><div class="ui bottom attached button">
            <i class="remove icon"></i>
            Delete
          </div></a>
        </div>
        @endforeach
      </div>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>
</div>
@endsection
