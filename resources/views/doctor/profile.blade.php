@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection


@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>Dr. {{$doctor->get('name')}} <a class="ui purple button right" href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></h1>
      <div class="ui divider"></div>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <div class="panel">
        <div class="ui items">
        <div class="item">
          <div class="image">
            @if(!is_null($url))
            <img src="{{$url}}">
            @else
            <i class="user icon" style="font-size:128px;"></i>
            @endif
          </div>
          <div class="content">
            <a class="header" style="font-size: 24px;">{{$doctor->get('name')}}

            </a><br>

            <div class="meta" style="font-size: 16px;">
              <div>Doctor ID: <b>{{$doctor->get('regid')}}</b></div><br>
              <div><b><i class="fa fa-at"></i> Email:</b> {{$doctor->get('email')}}</div><br>
              <div><b><i class="fa fa-calendar"></i> Date of Birth:</b> {{$doctor->get('dob')}}</div><br>
              <div><b><i class="fa fa-user"></i> Gender:</b> {{$doctor->get('gender')}}</div><br>
              <div><b><i class="fa fa-home"></i> Address:</b> {{$doctor->get('address')}}  {{$doctor->get('state')}}  {{$doctor->get('zip')}}</div><br>
            </div>
            <div class="description" >
              <p ><b style="font-size: 20px;"><i class="fa fa-user-md"></i> About</b><br>
                {{$doctor->get('about')}}
              </p>

              <p ><b style="font-size: 20px;"><i class="fa fa-graduation-cap"></i> Qualifications</b><br>
                {{$doctor->get('qualifications')}}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if($ispatient)
    <div class="panel">
      Available Appointments
      <div class="ui divider"></div>
      @if(count($appointments) == 0)
      <p>No Appointments Available</p>
      @endif
      <div class="ui cards">
        @foreach ($appointments as $appointment)
        <div class="green card">
          <div class="content">
            <a href="{{url('doctor/profile/'.$appointment->get('doctorid'))}}"><div class="header">Dr. {{$doctor->get('name')}}</div></a>
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
    @endif
  </div>


</div><div class="clear" style="min-heiight:12px;"></div><div class="clear" style="min-heiight:12px;"></div>


@endsection
