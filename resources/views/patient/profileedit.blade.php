@extends('app')

@section('menu')
@include('menu.loggedin')
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="large-12 columns">
      <h1>Edit Profile <a class="ui purple button right" href="{{ url('/home') }}"><i class="fa fa-chevron-left"></i> Back</a></h1>
      <div class="ui divider"></div>
    </div>
  </div>
	<div class="row">
		<div class="large-12 columns">
      <div class="panel" style="background:white;">
        <form class="ui form" method="post" action="{{url('patient/profile/edit')}}" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <h4 class="ui dividing header">Patient Information</h4>
          <div class="field">
            <div class="ui items">
            <div class="item">
              <div class="image" >
                @if(!is_null($url))
                <img src="{{$url}}">
                @else
                <i class="user icon" style="font-size:128px;"></i>
                @endif
              </div>
              <div class="content">
                <a class="header">Display Image</a>

                <div class="description">
                  <p><input type="file" name="dp" accept=".jpg,.jpeg,.png"></p>
                </div>

              </div>
            </div>

          </div>
        </div>
            <div class="field">
              <label>Name</label>
                  <input type="text" name="name" placeholder="First Name" value="{{$user->get('name')}}">
            </div>


          <div class="three fields">
            <div class="field">
              <label>Street Address</label>
              <input type="text" name="address" placeholder="Street Address" value="{{$user->get('address')}}">
            </div>

            <div class="field">
              <label>State</label>
              <input type="text" name="state" placeholder="State" value="{{$user->get('state')}}">
            </div>
            <div class="field">
              <label>Zip</label>
              <input type="text" name="zip" placeholder="Zip Code" value="{{$user->get('zip')}}">
            </div>
          </div>
          <div class="two fields">
            <div class="field">
              <label>Date Of Birth</label>
              <div class="ui icon input">
                <input type="date" placeholder="00/00/0000" name="dob" value="{{$user->get('dob')}}">
              </div>
            </div>
            <div class="field">
              <label>Gender</label>
              <select class="ui dropdown" name="gender">
                  @if($user->get('gender') == 'M')
                  <option value="M" selected>Male</option>
                  <option value="F">Female</option>
                  @elseif($user->get('gender') == 'F')
                  <option value="M">Male</option>
                  <option value="F" selected>Female</option>
                  @else
                  <option value="M">Male</option>
                  <option value="F">Female</option>
                  @endif
              </select>
          </div></div>
          <div class="field">
            <label>Email Address</label>
            <div class="ui icon input">
              <input type="email" placeholder="email" name="email" value="{{$user->get('email')}}">
            </div>
          </div>
          <div class="field">
            <label>Alergies</label>
            <div class="ui icon input">
              <textarea name="allergies" placeholder="allergies">{{$user->get('allergies')}}</textarea>
            </div>
          </div>
          <div class="field">
            <label>Notes</label>
            <div class="ui icon input">
              <textarea name="notes" placeholder="notes">{{$user->get('notes')}}</textarea>
            </div>
          </div>

          <input type="submit" class="ui purple button" value="Update">
          </form>
      </div>
    </div>
    <div class="clear" style="min-heiight:12px;"></div>
  </div>
</div>
@endsection
