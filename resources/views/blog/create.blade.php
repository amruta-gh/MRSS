@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>Add Blog Post <a href="{{ url('blogs') }}" class="ui purple right button"> <i class="fa fa-chevron-left"></i> Back to blogs</a></h1>
      <div class="ui divider"></div>
    </div>
  </div>
	<div class="row">
		<div class="large-12 columns">
      <form class="form-horizontal" role="form" method="POST" action="{{ url('doctor/blog/post') }}" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
          <label class="col-md-4 control-label">Blog Title</label>
          <div class="col-md-6">
            <input type="text" class="form-control" name="name" placeholder="Blog Title">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-4 control-label">Blog Content</label>
          <div class="col-md-6">
            <textarea class="form-control" name="content">
            </textarea>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-4 control-label">Upload Images</label>
          <div class="col-md-6">
            <input type="file" name="images[]" accept=".jpg,.jpeg,.png" multiple>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="ui purple button">
              Create
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>
</div>
@endsection
