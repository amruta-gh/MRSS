@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>Add Prescription <a href="{{ url('/patient/record/'.$patientid) }}" class="ui purple right button"> <i class="fa fa-chevron-left"></i> Back to Pateint Record</a></h1>

      <div class="ui divider"></div>
    </div>
  </div>
	<div class="row">
		<div class="large-12 columns">
      <form class="form-horizontal" role="form" method="POST" action="{{ url('record/prescription/add/'.$patientid) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
          <label class="col-md-4 control-label">Drug</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="drug">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-4 control-label">Dosage</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="dosage">
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
