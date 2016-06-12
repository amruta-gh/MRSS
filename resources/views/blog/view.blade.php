@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection


@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>Blog
        <a href="{{ url('blogs') }}" class="ui purple right button"> <i class="fa fa-chevron-left"></i> Back to blogs</a>
        @if($blog->get('doctor_id') == $user->getObjectId())
        <a href="{{ url('blog/delete/'.$blog->getObjectId()) }}" class="ui red right button"> <i class="fa fa-trash-o"></i> Delete</a>
        <a href="{{ url('doctor/blog/update/'.$blog->getObjectId()) }}" class="ui yellow right button"> <i class="fa fa-pencil"></i> Edit</a>
        @endif
      </h1>
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
            <a class="header" style="font-size: 24px;">{{$blog->get('name')}}</a><br>
            <div class="meta" style="font-size: 16px;">
              <div><b>By </b><a href="{{URL('doctor/profile/'.$doctor->getObjectId())}}">Dr. {{$doctor->get('name')}}</a></div><br>
              <div><b>At </b>{{$blog->getCreatedAt()->format('Y-m-d H:i:s')}}</div><br>
            </div>
            <div class="description" >
              <p>
                <ul class="clearing-thumbs" data-clearing>
                  @foreach($images as $image)
                  <li><a href="{{$image->get('image')->getURL()}}"><img src="{{$image->get('image')->getURL()}}" style="height:128px"></a></li>
                  @endforeach
                </ul>

              </p><br>
              <p>
                {{$blog->get('content')}}
              </p>
              <br>
              <div class="ui divider"></div>

              <div class="ui comments">
                <h3 class="ui dividing header">Comments</h3>

                <form class="ui reply form" method="POST" action="{{URL('blog/comment/add/'.$blog->getObjectId())}}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="field">
                    <textarea placeholder="Comment" name="comment"></textarea>
                  </div>
                  <input type="submit" class="ui blue button" value="Add Reply">
                </form>
                @foreach($comments as $comment)
                <div class="comment">
                  <a class="avatar">
                    @if( !is_null($userquery->equalTo('objectId',$comment->get('user_id'))->find()[0]->get('dp')))
                    <img src="{{$userquery->equalTo('objectId',$comment->get('user_id'))->find()[0]->get('dp')->getURL()}}">
                    @else
                    <i class="user icon" style="font-size:32px;"></i>
                    @endif
                  </a>
                  <div class="content" style="margin-top:0px; padding:0px;">
                    <a class="author">{{$userquery->equalTo('objectId',$comment->get('user_id'))->find()[0]->get('name')}}</a>
                    <div class="metadata">
                      <span class="date">{{$comment->getCreatedAt()->format('Y-m-d H:i:s')}}</span>
                    </div>
                    <div class="text">
                      {{$comment->get('comment')}}
                    </div>
                    @if($comment->get('user_id') == $user->getObjectId())
                    <div class="actions">
                      <a class="reply" href="{{URL('blog/comment/delete/'.$comment->getObjectId())}}">Delete</a>
                    </div>
                    @endif
                  </div>
                </div><br>
                @endforeach

              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</div><div class="clear" style="min-heiight:12px;"></div><div class="clear" style="min-heiight:12px;"></div>

@endsection
