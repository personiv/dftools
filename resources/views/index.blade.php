<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DFTools — Login</title>
    
    <!-- Global Style and Script -->
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    <!-- Page Style and Script -->
    <link rel="stylesheet" href="{{ URL::asset('css/index.css') }}">
    <script type="text/javascript" src="{{ URL::asset('js/index.js') }}"></script>

    <!-- Plugins -->
    <script type="text/javascript" src="{{ URL::asset('js/jquery-3.4.1.min.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
</head>
<body>
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
</body>
</html>