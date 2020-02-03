@extends('layouts.app')
@section('title', 'DF Tools — Login')
@section('css', URL::asset('css/index.css'))
@section('js', URL::asset('js/index.js'))

@section('content')
<div class="wrapper">
    <div class="container-fluid">
        <div class="row main-container">

            <!-- Login wrapper here -->
            <div class="col-md-7 intro-one flex-column">

                <!-- Brand name here -->
                <div class="brand-name">
                    <span>DF Scorecard & Coaching System</span>
                </div>

                <!-- Greetings intro here -->
                <div class="greetings mt-5 mb-4">

                    <!-- day, night, afternoon here -->
                    <div class="day-greeting">
                        <span>Good morning!</span>
                    </div>

                    <!-- Greetings slogan here -->
                    <div class="slogan-greeting">
                        <span>This day will be great.</span>
                    </div>
                </div>

                <!-- Login form here -->
                <div class="login-container">

                    <!-- Default form login -->
                    <form method="POST" action="{{ action('LoginController@login') }}">
                        {{ csrf_field() }}

                        <!-- Email -->
                        <label for="defaultLoginFormEmail">Username</label>
                        <input type="text" id="defaultLoginFormEmail" name="user-id" class="form-control mb-4" required>

                        <!-- Password -->
                        <label for="defaultLoginFormPassword">Password</label>
                        <input type="password" id="defaultLoginFormPassword" name="user-pass" class="form-control mb-4" required>

                            
                        <!-- Remember me -->
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember">
                            <label class="custom-control-label" for="defaultLoginFormRemember">Remember Me</label>
                        </div>

                        <!-- Sign in button -->
                        <button type="submit" class="btn btn-info custom-btn my-4">Sign In</button>

                    </form>
                    <!-- Default form login -->

                </div>

            </div>

            <!-- Graphic brand name and slogan here -->
            <div class="col-md-5 intro-two flex-column">
                <div class="graphic-brname"> 
                    DF Scorecard & Coaching System
                </div>
                <div class="graphic-slogan">
                    <span>A new way to understand and motivate your teams</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection