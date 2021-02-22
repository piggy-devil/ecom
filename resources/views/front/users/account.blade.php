@extends('layouts.frontend.layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active">Login</li>
    </ul>
    <h3>MY Account</h3>
    <hr class="soft" />
    @if(Session::has('error_message'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="span4">
            <div class="well">
                <h5>CONTACT DETAILS</h5><br />
                @if(Session::has('success_message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                Enter your email to get the new password.<br /><br />
                <form id="accountForm" action="{{ url('/account') }}" method="post"> @csrf
                    <div class="control-group">
                        <label class="control-label" for="name">Name</label>
                        <div class="controls">
                            <input class="span3" type="text" id="name" name="name" placeholder="Enter Name" value="{{ $userDetails['name'] }}">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="address">Address</label>
                        <div class="controls">
                            <input class="span3" type="text" id="address" name="address" placeholder="Enter Address" value="{{ $userDetails['address'] }}">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="city">City</label>
                        <div class="controls">
                            <input class="span3" type="text" id="city" name="city" placeholder="Enter City" value="{{ $userDetails['city'] }}">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="state">State</label>
                        <div class="controls">
                            <input class="span3" type="text" id="state" name="state" placeholder="Enter State" value="{{ $userDetails['state'] }}">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="country">Country</label>
                        <div class="controls">
                            <input class="span3" type="text" id="country" name="country" placeholder="Enter Country" value="{{ $userDetails['country'] }}">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="pincode">Pincode</label>
                        <div class="controls">
                            <input class="span3" type="text" id="pincode" name="pincode" placeholder="Enter Pincode" value="{{ $userDetails['pincode'] }}">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="mobile">Mobile</label>
                        <div class="controls">
                            <input class="span3" type="text" id="mobile" name="mobile" placeholder="Enter Mobile" value="{{ $userDetails['mobile'] }}">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="email">Email</label>
                        <div class="controls">
                            <input class="span3" value="{{ $userDetails['email'] }}" readonly>
                        </div>
                    </div>
                    <div class="controls">
                        <button type="submit" class="btn block">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="span1"> &nbsp;</div>
        <div class="span4">
            <div class="well">
                <h5>UPDATE PASSWORD</h5>
                <form id="passwordForm" action="{{ url('/update-password') }}" method="post">@csrf
                    <div class="control-group">
                        <label class="control-label" for="password">Current Password</label>
                        <div class="controls">
                            <input class="span3" type="password" id="password" name="password" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="password">New Password</label>
                        <div class="controls">
                            <input class="span3" type="password" id="password" name="password" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="password">Confirm Password</label>
                        <div class="controls">
                            <input class="span3" type="password" id="password" name="password" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection