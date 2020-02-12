<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="cache-control" content="private, max-age=0, no-cache, must-revalidate">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
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
                            <label class="item-f username" for="user-id">Username</label>
                            <input type="text" id="user-id" name="user-id" class="form-control mb-2" value="{{ $_COOKIE['rememberedUser'] ?? '' }}" required>
                        </div>

                        <!-- Password -->
                        <div class="field-items mt-4">
                            <label class="item-f password" for="user-pass">Password</label>
                            <input type="password" id="user-pass" name="user-pass" class="form-control mb-2" value="{{ $_COOKIE['rememberedPass'] ?? '' }}" required>
                        </div>
                        
                        <!-- Remember me -->
                        <div class="custom-control custom-checkbox mt-4">
                            <input type="checkbox" class="custom-control-input" id="user-remember" name="user-remember" value="remembered">
                            <label class="custom-control-label" for="user-remember">Remember Me</label>
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
                <div id="particles-js">
                <div class="graphic-brname"> 
                    <span>df</span><span>scorecard</span>
                </div>
                <div class="graphic-slogan">
                    <div>A new way to understand and motivate your teams</div>
                </div>
                </div>  
            </div>
        </div>
    </div>
</div>

<!-- Plugins -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="particle-js/particles.js"></script>
<script type="text/javascript" src="particle-js/particles.min.js"></script>
<script type="text/javascript" src="particle-js/app.js"></script>
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