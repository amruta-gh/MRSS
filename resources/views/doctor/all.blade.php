@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection


@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>All Doctors <a class="ui purple button right" href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></h1>
      <div class="ui divider"></div>
    </div>
  </div>
  <div class="row">
  </div>
	<div class="row">
		<div class="large-12 columns">

        @foreach ($doctors as $doctor)
        <div class="panel">
        <div class="ui items">
        <div class="item">
          <div class="image">
            @if(!is_null($doctor->get('dp')) && is_object($doctor->get('dp')))
            <img src="{{$doctor->get('dp')->getURL()}}">
            @else
            <i class="user icon" style="font-size:128px;"></i>
            @endif
          </div>
          <div class="content">
            <a class="header" href="{{url('doctor/profile/'.$doctor->getObjectId())}}">Dr. {{$doctor->get('name')}}</a>
            <div class="meta">
              <span>
                <div><b>Email:</b> {{$doctor->get('email')}}</div>
                <div><b>Date of Birth:</b> {{$doctor->get('dob')}}</div>
                <div><b>Gender:</b> {{$doctor->get('gender')}}</div>
                <div><b>Address:</b> {{$doctor->get('address')}}  {{$doctor->get('state')}}  {{$doctor->get('zip')}}</div>
              </span>
            </div>
            <div class="description">
              <p></p>
            </div>
            <div class="extra">
              <p><b>About</b><br>
                {{$doctor->get('about')}}
              </p>

              <p><b>Qualifications</b><br>
                {{$doctor->get('qualifications')}}
              </p>
            </div>
          </div><br><br>
        </div>
        </div>
      </div>
        @endforeach

    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>
</div>
@endsection
