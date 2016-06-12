@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1><i class="doctor icon"></i> Dr. {{$user->get('name')}}</h1>
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
            <a class="header" style="font-size: 24px;">{{$user->get('name')}}</a><br>
            <div class="meta" style="font-size: 16px;">
              <div>Doctor ID: <b>{{$user->get('regid')}}</b></div><br>
              <div><b><i class="fa fa-at"></i> Email:</b> {{$user->get('email')}}</div><br>
              <div><b><i class="fa fa-calendar"></i> Date of Birth:</b> {{$user->get('dob')}}</div><br>
              <div><b><i class="fa fa-user"></i> Gender:</b> {{$user->get('gender')}}</div><br>
              <div><b><i class="fa fa-home"></i> Address:</b> {{$user->get('address')}}  {{$user->get('state')}}  {{$user->get('zip')}}</div><br>
            </div>
            <div class="description" >
              <p ><b style="font-size: 20px;"><i class="fa fa-user-md"></i> About</b><br>
                {{$user->get('about')}}
              </p>

              <p ><b style="font-size: 20px;"><i class="fa fa-graduation-cap"></i> Qualifications</b><br>
                {{$user->get('qualifications')}}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">

</div>
</div><div class="clear" style="min-heiight:12px;"></div><div class="clear" style="min-heiight:12px;"></div>
	<div class="row">
		<div class="large-4 columns">
          <div class="ui fluid card">
            <div class="content">
              <div class="header center aligned">Appointments</div>
              <div class="description">
                <div class="large column center aligned"><h1 style="font-size:128px"><i class="alarm icon"></i></h1></div>
              </div>
            </div>
            <a href="{{url('doctor/appointments')}}"><div class="ui bottom attached button">
              Manage Appoinments
            </div></a>
          </div>
    </div>
    <div class="large-4 columns">
      <div class="ui fluid card">
        <div class="content">
          <div class="header center aligned">Patients</div>
          <div class="description">
            <div class="large column center aligned"><h1 style="font-size:128px"><i class="user icon"></i></h1></div>
          </div>
        </div>
        <a href="{{url('doctor/patients')}}"><div class="ui bottom attached button">
          Manage Patients
        </div></a>
      </div>
    </div>
    <div class="large-4 columns">
      <div class="ui fluid card">
        <div class="content">
          <div class="header center aligned">My Profile</div>
          <div class="description">
            <div class="large column center aligned"><h1 style="font-size:128px"><i class="doctor icon"></i></h1></div>
          </div>
        </div>
        <a href="{{ url('doctor/profile/edit') }}"><div class="ui bottom attached button">
          Edit My Profile
        </div></a>
      </div>

    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>
  <div class="clear" style="min-heiight:12px;"></div><div class="clear" style="min-heiight:12px;"></div>

@endsection
