@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>Book Appointmemnt <a href="{{ url('/patient/appointments') }}" class="ui purple button right"><i class="fa fa-chevron-left"></i> Back to appointments</a></h1>

      <div class="ui divider"></div>
    </div>
  </div>
	<div class="row">
		<div class="large-12 columns">
      <div class="ui cards">
        @foreach ($availableAppointments as $appointment)
        <div class="green card">
          <div class="content">
            <a href="{{url('doctor/profile/'.$appointment->get('doctorid'))}}"><div class="header">Dr. {{$doctor->equalTo('objectId',$appointment->get('doctorid'))->find()[0]->get('name')}}</div></a>
            <div class="description">
              {{$appointment->get('location')}}<br/>
              {{$appointment->get('date')}} at {{$appointment->get('time')}}
            </div>
          </div>
          <a href="{{ url('/patient/appointments/add/'.$appointment->getObjectId()) }}"><div class="ui bottom attached button">
            <i class="add icon"></i>
            Book Appointment
          </div></a>
        </div>
        @endforeach
      </div>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>
</div>
@endsection
