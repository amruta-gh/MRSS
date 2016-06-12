@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>All Patients</h1>
      <div class="ui divider"></div>
    </div>
  </div>
  <div class="row">
  </div>
	<div class="row">
		<div class="large-12 columns">
      <div class="ui items">
        @foreach ($patients as $patient)
        <div class="item">
          <div class="image">
            @if(!is_null($patient->get('dp')) && is_object($patient->get('dp')))
            <img src="{{$patient->get('dp')->getURL()}}">
            @else
            <i class="user icon" style="font-size:128px;"></i>
            @endif
          </div>
          <div class="content">
            <a class="header" href="{{url('patient/record/'.$patient->getObjectId())}}">{{$patient->get('name')}}</a>
            <div class="meta">
              <span>
                <div><b>Email:</b> {{$patient->get('email')}}</div>
                <div><b>Date of Birth:</b> {{$patient->get('dob')}}</div>
                <div><b>Gender:</b> {{$patient->get('gender')}}</div>
                <div><b>Address:</b> {{$patient->get('address')}}  {{$patient->get('state')}}  {{$patient->get('zip')}}</div>
              </span>
            </div>
            <div class="description">
              <p></p>
            </div>
            <div class="extra">
              <p><b>Allergies</b><br>
                {{$patient->get('allergies')}}
              </p>

              <p><b>Notes</b><br>
                {{$patient->get('notes')}}
              </p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>
</div>
@endsection
