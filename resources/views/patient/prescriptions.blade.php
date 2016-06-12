@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>My Prescriptions</h1>
      <div class="ui divider"></div>
    </div>
  </div>
  <div class="row">
    <div class="large-12 columns">
      <a class="ui purple button right" href="{{ url('/home') }}"><i class="fa fa-chevron-left"></i> Back</a>
    </div>
  </div>
	<div class="row">
		<div class="large-12 columns">
      <h3>Prescription</h3>
      <div class="ui cards">
        @foreach ($prescriptions as $prescription)
        <div class="red card">
          <div class="content">
            <div class="header">{{$prescription->get('drug')}}</div>
            <div class="description">
              {{$prescription->get('dosage')}}<br/>
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
