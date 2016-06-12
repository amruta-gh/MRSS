@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>Prescriptions</h1>
      <div class="ui divider"></div>
    </div>
  </div>

  <div class="row">
		<div class="large-12 columns">
        </h3>
        @if(count($prescriptions) == 0)
        <b>No Prescriptions Found</b>
        @endif
        <div class="ui cards" style="width:100%">
          @foreach ($prescriptions as $prescription)
          <div class="pink card"  style="width:48%">
            <div class="content">
              <div class="header">{{$prescription->get('drug')}}
                @if(!is_null($prescription->get('is_dispensed')) || $prescription->get('is_dispensed') == true )
                  <div class="label" style="margin:8px;">Dispensed</div>
                @endif
              </div>
              <div class="description">
                {{$prescription->get('dosage')}}<br>
                By Dr. {{$doctor->equalTo('objectId',$prescription->get('doctorId'))->find()[0]->get('name')}} 

                <br>
                @if(is_null($prescription->get('is_dispensed')) || $prescription->get('is_dispensed') == false )
                <a class="ui blue button" href="{{url('record/prescription/dispense/'.$prescription->getObjectId())}}">Dispense</a>
                @else
                <a class="ui green button" href="{{url('record/prescription/refill/'.$prescription->getObjectId())}}">Refill</a>
                @endif
              </div>
            </div>
          </div>
          @endforeach
        </div>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>

@endsection
