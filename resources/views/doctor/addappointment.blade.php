@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection


@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>Add Appointmemnt <a href="{{ url('/doctor/appointments') }}" class="ui purple right button"><i class="fa fa-chevron-left"></i> Back to appointments</a></h1>

      <div class="ui divider"></div>
    </div>
  </div>
	<div class="row">
		<div class="large-12 columns">
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/doctor/appointments/add') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
          <label class="col-md-4 control-label">Location</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="location">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-4 control-label">Date</label>
          <div class="col-md-6">
            <input type="date" class="form-control" name="date">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-4 control-label">Time</label>
          <div class="col-md-6">
            <input type="time" class="form-control" name="time">
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="ui purple button">
              Add
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>
</div>
@endsection
