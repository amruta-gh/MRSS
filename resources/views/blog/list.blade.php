@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection


@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>Blogs
        @if($is_doctor)
        <a class="ui purple button right" href="{{ url('/doctor/blog/post') }}"><i class="fa fa-plus-circle"></i> Blog</a></a>
        @endif
        <a class="ui purple button right" href="{{ url('/home') }}"><i class="fa fa-home"></i> Home</a>

        </h1>
      <div class="ui divider"></div>
    </div>
  </div>
  <div class="row">
  </div>
	<div class="row">
		<div class="large-12 columns">

        @foreach ($blogs as $blog)
        <div class="panel">
        <div class="ui items">
        <div class="item">
          <div class="image">
            @if(!is_null($userquery->equalTo('objectId',$blog->get('doctor_id'))->find()[0]->get('dp')))
            <img class="right" src="{{$userquery->equalTo('objectId',$blog->get('doctor_id'))->find()[0]->get('dp')->getURL()}}" style="height:128px; width: auto;">
            @else
            <i class="user icon" style="font-size:128px;"></i>
            @endif
          </div>
          <div class="content">
            <a class="header" href="{{url('blog/'.$blog->getObjectId())}}">{{$blog->get('name')}}</a>
            <div class="meta">
              <span>
                By Dr. {{$userquery->equalTo('objectId',$blog->get('doctor_id'))->find()[0]->get('name')}}
              </span>
            </div>
            <div class="description">
              <p>
                @if(strlen($blog->get('content')) > 200 )
                <div>{{ substr($blog->get('content'), 0, 200) }} ...</div>
                @else
                <div>{{$blog->get('content')}}</div>
                @endif
              </p>
            </div>
            <div class="extra">
              <p><b>{{$userquery->equalTo('objectId',$blog->get('doctor_id'))->find()[0]->getCreatedAt()->format('Y-m-d H:i:s')}}</b><br>
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
