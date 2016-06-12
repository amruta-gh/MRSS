@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1><i class="fa fa-user"></i> Patient Record  <a class="ui purple button right" href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a></h1>
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
            <i class="user icon" style="font-size: 128px"></i>
            @endif
          </div>
          <div class="content">
            <a class="header" style="font-size: 24px;">{{$user->get('name')}}</a><br>
            <div class="meta" style="font-size: 16px;">
              <div><b><i class="fa fa-at"></i> Email:</b> {{$user->get('email')}}</div><br>
              <div><b><i class="fa fa-calendar"></i> Date of Birth:</b> {{$user->get('dob')}}</div><br>
              <div><b><i class="fa fa-user"></i> Gender:</b> {{$user->get('gender')}}</div><br>
              <div><b><i class="fa fa-home"></i> Address:</b> {{$user->get('address')}}  {{$user->get('state')}}  {{$user->get('zip')}}</div><br>
            </div>
            <div class="description" >
              <p ><b style="font-size: 20px;"><i class="fa fa-frown-o"></i> Allergies</b><br>
                {{$user->get('allergies')}}
              </p>

              <p ><b style="font-size: 20px;"><i class="fa fa-edit"></i> Notes</b><br>
                {{$user->get('notes')}}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div class="row">

	</div>
</div>

  <div class="row">
		<div class="large-12 columns">
    <div class="clear"></div><div class="ui divider"></div>
        <h3><i class="fa fa-heartbeat"></i> Vitals
          @if($role == 1 || $role == 2)
          <div class="right"><a href="#" data-reveal-id="bp-modal" class="ui button"><i class="fa fa-plus-circle"></i> Blood Preasure</a></div>
          <div class="right"><a href="#" data-reveal-id="weight-modal" class="ui button"><i class="fa fa-plus-circle"></i> Weight</a></div>
          <div class="right"><a href="#" data-reveal-id="temperature-modal" class="ui button"><i class="fa fa-plus-circle"></i> Temperature</a></div>
          <div class="right"><a href="#" data-reveal-id="pulse-modal" class="ui button"><i class="fa fa-plus-circle"></i> Pulse</a></div>
          @endif
        </h3>
        <br><br>
        <div class="ui cards">
          <div class="blue card" style="width:48%">
            <div class="content">
              <div class="header">Weight <a href="#" data-reveal-id="weight-chart-modal" class="ui button right"><i class="fa fa-line-chart"></i> Chart</a></div>
              <div class="description" style=" text-align:center;">
                @if(count($weights) > 0)
                <b style="font-size:26px;">{{$weights[0]->get('weight')}}</b>lbs<br>
                Most Recent Reading
                @else
                <b style="font-size:26px;">No Readings Yet</b><br>
                @endif
              </div>
            </div>
          </div>
          <div class="green card" style="width:48%">
            <div class="content">
              <div class="header">Pulse <a href="#" data-reveal-id="pulse-chart-modal" class="ui button right"><i class="fa fa-line-chart"></i> Chart</a></div>
              <div class="description" style=" text-align:center;">
                @if(count($pulses) > 0)
                <b style="font-size:26px;">{{$pulses[0]->get('pulse')}}</b>bpm<br>
                Most Recent Reading
                @else
                <b style="font-size:26px;">No Readings Yet</b><br>
                @endif
              </div>
            </div>
          </div>
          <div class="red card" style="width:48%">
            <div class="content">
              <div class="header">Temperature <a href="#" data-reveal-id="temperature-chart-modal" class="ui button right"><i class="fa fa-line-chart"></i> Chart</a></div>
              <div class="description" style=" text-align:center;">
                @if(count($temperatures) > 0)
                <b style="font-size:26px;">{{$temperatures[0]->get('temperature')}}</b>F<br>
                Most Recent Reading
                @else
                <b style="font-size:26px;">No Readings Yet</b><br>
                @endif
              </div>
            </div>
          </div>
          <div class="purple card" style="width:48%">
            <div class="content">
              <div class="header">Blood Presure <a href="#" data-reveal-id="bp-chart-modal" class="ui button right"><i class="fa fa-line-chart"></i> Chart</a></div>
              <div class="description" style=" text-align:center;">
                @if(count($bps) > 0)
                <b style="font-size:26px;">{{$bps[0]->get('systolic')}}/{{$bps[0]->get('diastolic')}}</b>sys/dia<br>
                Most Recent Reading
                @else
                <b style="font-size:26px;">No Readings Yet<br></b>
                @endif
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>

  <div class="row">
		<div class="large-12 columns">
    <div class="clear"></div><div class="ui divider"></div>
        <h3><i class="fa fa-dot-circle-o"></i> Prescriptions
          @if($role == 1)
          <a class="ui pink button right" href="{{ url('/record/prescription/add/'.$patient->getObjectId()) }}"><i class="fa fa-plus-circle"></i> Add Prescription</a>
          @endif
        </h3>
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
                @if($role == 1 || $role ==2)
                @if(is_null($prescription->get('is_dispensed')) || $prescription->get('is_dispensed') == false )
                <a class="ui blue button" href="{{url('record/prescription/dispense/'.$prescription->getObjectId())}}">Dispense</a>
                @else
                @if($role == 1)
                <a class="ui green button" href="{{url('record/prescription/refill/'.$prescription->getObjectId())}}">Refill</a>
                @endif
                @endif
                @if($role == 1)
                <a class="ui red button" href="{{url('record/prescription/cancel/'.$prescription->getObjectId())}}">Cancel</a>
                @endif
                @endif
              </div>
            </div>
          </div>
          @endforeach
        </div>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>

  <div class="row">
		<div class="large-12 columns">
    <div class="clear"></div><div class="ui divider"></div>
    <h3><i class="fa fa-file-image-o"></i> Scans
      @if($role == 1 || $role == 2)
      <a class="ui black button right" href="{{ url('/record/scan/add/'.$patient->getObjectId()) }}"><i class="fa fa-plus-circle"></i> Add Scan</a>
      @endif
    </h3>
    <div class="panel">
    <div class="ui items">
      @foreach ($scans as $scan)
        <div class="item">
          <div class="image">
            <a href="{{$scan->get('file')->getURL()}}"><img src="{{$scan->get('file')->getURL()}}"></a>
          </div>
          <div class="content">
            <a class="header">{{$scan->get('name')}}</a>
            <div class="meta">
              <span>Description</span>
            </div>
            <div class="description">
              <p>{{$scan->get('note')}}</p>
              @if($role == 1)
              <a class="ui red button right" href="{{ url('/record/scan/delete/'.$scan->getObjectId()) }}"><i class="fa fa-trash-o"></i> Delete Scan</a>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>

  <div class="row">
		<div class="large-12 columns">
    <div class="clear"></div><div class="ui divider"></div>
        <h3><i class="fa fa-pencil-square-o"></i> Doctor Notes
          @if($role == 1)
          <a class="ui teal button right" href="{{ url('/record/notes/add/'.$patient->getObjectId()) }}"><i class="fa fa-plus-circle"></i> Add Note</a>
          @endif
        </h3>
        <div class="ui cards" style="width:100%">
          @foreach ($notes as $note)
          <div class="teal card"  style="width:48%">
            <div class="content">
              <div class="header">Dr. {{$doctor->equalTo('objectId',$note->get('doctorId'))->find()[0]->get('name')}}</div>
              <div class="description">
                {{$note->get('note')}}
                @if( $role == 1)
                <a class="ui red button right" href="{{ url('/record/notes/delete/'.$note->getObjectId()) }}"><i class="fa fa-trash-o"></i> Delete Note</a>
                @endif
              </div>
            </div>

          </div>
          @endforeach
        </div>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>

</div>

<div id="bp-modal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <h2 id="modalTitle">Add Blood Preasure</h2>
  <p>
    <div class="ui fluid form segment">
      <form method="POST" action="{{ url('/record/vitalbp/add/'.$patient->getObjectId()) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="two fields">
        <div class="field">
          <label>Systolic</label>
          <input placeholder="Systolic" type="deciaml" name="systolic">
        </div>
        <div class="field">
          <label>Diastolic</label>
          <input placeholder="Diastolic" type="deciaml" name="diastolic">
        </div>
      </div>
      <input type="submit" class="ui submit button" value="+ Add">
    </form>
    </div>
  </p>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="weight-modal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <h2 id="modalTitle">Add Weight</h2>
  <p>
    <div class="ui fluid form segment">
      <form method="POST" action="{{ url('/record/vitalweight/add/'.$patient->getObjectId()) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="field">
          <label>Weight</label>
          <input placeholder="wright in lbs" type="deciaml" name="weight">
        </div>
        <input type="submit" class="ui submit button" value="+ Add">
      </form>
    </div>
  </p>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="temperature-modal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <h2 id="modalTitle">Add Temperature</h2>
  <p>
    <div class="ui fluid form segment">
      <form method="POST" action="{{ url('/record/vitaltemperature/add/'.$patient->getObjectId()) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="field">
          <label>Temperature</label>
          <input placeholder="Temperature in F" type="deciaml" name="temperature">
        </div>
        <input type="submit" class="ui submit button" value="+ Add">
      </form>
    </div>
  </p>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="pulse-modal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <h2 id="modalTitle">Add Pulse</h2>
  <p>
    <div class="ui fluid form segment">
      <form method="POST" action="{{ url('/record/vitalpulse/add/'.$patient->getObjectId()) }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="field">
          <label>Pulse</label>
          <input placeholder="Pulse" type="deciaml" name="pulse">
        </div>
        <input type="submit" class="ui submit button" value="+ Add">
      </form>
    </div>
  </p>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="pulse-chart-modal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" >
  <h2 id="modalTitle">Pulse Graph</h2>
  <div style="width:1150px height:800px;">
    <div id="curve_chart_pulse" ></div>
  </div>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="weight-chart-modal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" >
  <h2 id="modalTitle">Weight Graph</h2>
  <div style="width:1150px height:800px;">
    <div id="curve_chart_weight" ></div>
  </div>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="bp-chart-modal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" >
  <h2 id="modalTitle">Blood Presure Graph</h2>
  <div style="width:1150px height:800px;">
    <div id="curve_chart_bp" ></div>
  </div>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="temperature-chart-modal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" >
  <h2 id="modalTitle">Temperature Graph</h2>
  <div style="width:1150px height:800px;">
    <div id="curve_chart_temperature" ></div>
  </div>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>



<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script>
google.load('visualization', '1', {packages: ['corechart', 'line']});
google.setOnLoadCallback(drawBackgroundColor);

function drawBackgroundColor() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'X');
      data.addColumn('number', 'BPM');

      data.addRows([

        @foreach (array_reverse($pulses) as $pulse)
        ['{{$pulse->getCreatedAt()->format('Y-m-d H:i:s')}}',{{$pulse->get('pulse')}}],
        @endforeach

      ]);
      var options = {
        hAxis: {
          title: 'Time'
        },
        vAxis: {
          title: 'Pulse'
        },
        backgroundColor: '#eeeeee'
        ,height: 600
        ,width: 1000
      };
      var chart = new google.visualization.LineChart(document.getElementById('curve_chart_pulse'));
      chart.draw(data, options);


      /*
      *WEIGHT
      */

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'X');
      data.addColumn('number', 'lbs');

      data.addRows([

        @foreach (array_reverse($weights) as $weight)
        ['{{$weight->getCreatedAt()->format('Y-m-d H:i:s')}}',{{$weight->get('weight')}}],
        @endforeach
      ]);
      var options = {
        hAxis: {
          title: 'Time'
        },
        vAxis: {
          title: 'Weight'
        },
        backgroundColor: '#eeeeee'
        ,height: 600
        ,width: 1000
      };
      var chart = new google.visualization.LineChart(document.getElementById('curve_chart_weight'));
      chart.draw(data, options);

      /*
      *temperature
      */

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'X');
      data.addColumn('number', 'F');

      data.addRows([

        @foreach (array_reverse($temperatures) as $temperature)
        ['{{$temperature->getCreatedAt()->format('Y-m-d H:i:s')}}',{{$temperature->get('temperature')}}],
        @endforeach
      ]);
      var options = {
        hAxis: {
          title: 'Time'
        },
        vAxis: {
          title: 'Temperature'
        },
        backgroundColor: '#eeeeee'
        ,height: 600
        ,width: 1000
      };
      var chart = new google.visualization.LineChart(document.getElementById('curve_chart_temperature'));
      chart.draw(data, options);

      /*
      *BP
      */

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'X');
      data.addColumn('number', 'Y');
      data.addColumn('number', 'Y');

      data.addRows([

        @foreach (array_reverse($bps) as $bp)
        ['{{$bp->getCreatedAt()->format('Y-m-d H:i:s')}}',{{$bp->get('systolic')}},{{$bp->get('diastolic')}}],
        @endforeach
      ]);
      var options = {
        hAxis: {
          title: 'Time'
        },
        vAxis: {
          title: 'Blood Presure'
        },
        backgroundColor: '#eeeeee'
        ,height: 600
        ,width: 1000
      };
      var chart = new google.visualization.LineChart(document.getElementById('curve_chart_bp'));
      chart.draw(data, options);
    }

</script>

@endsection
