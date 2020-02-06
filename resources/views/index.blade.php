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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row main-container">

            <!-- Login wrapper here -->
            <div class="col-md-7 intro-one">
                <div class="introOne-wrapper flex-column">
                <!-- Brand name here -->
                <div class="brand-name">
                    <span>d</span><span>f</span><span>S</span>
                </div>

                <!-- Greetings intro here -->
                <div class="greetings">

                    <!-- day, night, afternoon here -->
                    <div class="day-greeting">

                    </div>

                    <!-- Greetings slogan here -->
                    <div class="slogan-greeting">
                        
                    </div>
                </div>

                <!-- Login form here -->
                <div class="login-container">

                    <!-- Default form login -->
                    <form method="POST"action="{{ action('LoginController@login') }}"> 
                    {{ csrf_field() }}

                        <!-- Email -->
                        <div class="field-items">
                            <label class="item-f username" for="defaultLoginFormUsername">Username</label>
                            <input type="text" id="defaultLoginFormUsername" name="user-id" class="form-control mb-2" required>
                        </div>

                        <!-- Password -->
                        <div class="field-items mt-4">
                            <label class="item-f password" for="defaultLoginFormPassword">Password</label>
                            <input type="password" id="defaultLoginFormPassword" name="user-pass" class="form-control mb-2" required>
                        </div>

                            
                        <!-- Remember me -->
                        <div class="custom-control custom-checkbox mt-4">
                            <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember">
                            <label class="custom-control-label" for="defaultLoginFormRemember">Remember Me</label>
                        </div>

                        <!-- Sign in button -->
                        <button type="submit" class="btn custom-btn my-4">Sign In</button>
                    </form>
                    <!-- Default form login -->
                    <span style="color: var(--tertiary-color);">{{ session("msg") }}</span>
                </div>
                </div>
            </div>

            <!-- Graphic brand name and slogan here -->
            <div class="col-md-5 intro-two flex-column">
                <div class="graphic-brname"> 
                    <span>df</span><span>scorecard</span>
                </div>
                <div class="graphic-slogan">
                    <div>A new way</div>
                    <div>to understand</div>
                    <div>and motivate</div>
                    <div>your teams</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Plugins -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script>

    var hours = new Date().getHours();
    var message;
    var slogan;
    var morning = "Good Morning!";
    var afternoon = "Good Afternoon!";
    var evening = "Good Evening!";

    if (hours >= 0 && hours < 12) {
        message = morning;
        slogan = "— This day will be great.";
    } else if (hours >= 12 && hours < 18) {
        message = afternoon;
        slogan = "— Good, better, best. Never let it rest. 'Til your good is better and your better is best. Good Afternoon.";
    } else {
        message = evening;
        slogan = "— Welcome to night shift.";
    }

    $(".day-greeting").html(message);
    $(".slogan-greeting").html(slogan);

</script>
</body>
</html>