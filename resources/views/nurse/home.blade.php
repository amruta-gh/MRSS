@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection


@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>{{$user->get('name')}}</h1>
      <div class="ui divider"></div>
    </div>
  </div>

  <div class="row">
    <div class="large-12 columns">
      <h3>Nurse Home</h3>
    </div>
</div>
</div><div class="clear" style="min-heiight:12px;"></div><div class="clear" style="min-heiight:12px;"></div>
	<div class="row">
		<div class="large-6 columns">
          <div class="ui fluid card">
            <div class="content">
              <div class="header center aligned">Prescriptions</div>
              <div class="description">
                <div class="large column center aligned"><h1 style="font-size:128px"><i class="newspaper icon"></i></h1></div>
              </div>
            </div>
            <a href="{{url('nurse/prescriptions')}}"><div class="ui bottom attached button">
              Manage Prescriptions
            </div></a>
          </div>
    </div>
    <div class="large-6 columns">
      <div class="ui fluid card">
        <div class="content">
          <div class="header center aligned">Patients</div>
          <div class="description">
            <div class="large column center aligned"><h1 style="font-size:128px"><i class="user icon"></i></h1></div>
          </div>
        </div>
        <a href="{{url('nurse/patients')}}"><div class="ui bottom attached button">
          Manage Patients
        </div></a>
      </div>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>
  <div class="clear" style="min-heiight:12px;"></div><div class="clear" style="min-heiight:12px;"></div>

@endsection
