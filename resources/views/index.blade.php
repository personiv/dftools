<?php
    $ruser = $_COOKIE['rememberedUser'] ?? '';
    $rpass = $_COOKIE['rememberedPass'] ?? '';
    $rme = $ruser != '' && $rpass != '';
?>
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
                        <img src="{{ URL::asset('images/df_logo.png') }}" alt="Digital Fulfillment">
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
                        <form id="main-login-form" method="POST"action="{{ action('LoginController@login') }}"> 
                            {{ csrf_field() }}

                            <!-- Employee ID -->
                            <div class="field-items effect-container"> <!-- input line animation -->
                                    <label class="item-f username" for="user-id">Employee ID</label>
                                    <input type="text" id="user-id" name="user-id" class="line-effect form-control mb-2" value="{{ $_COOKIE['rememberedUser'] ?? '' }}" required pattern="^[a-zA-Z0-9]*$">
                                    <span class="focus-border">
                                    <i></i>
                                    </span>
                            </div> <!-- input line animation end -->

                            <!-- Password -->
                            <div class="field-items effect-container mt-4 mb-4"> <!-- input line animation -->
                                    <label class="item-f password" for="user-pass">Password</label>
                                    <input type="password" id="user-pass" name="user-pass" class="line-effect form-control mb-2" value="{{ $_COOKIE['rememberedPass'] ?? '' }}" required pattern="^[a-zA-Z0-9]*$">
                                    <span class="focus-border">
                                    <i></i>
                                    </span>
                            </div> <!-- input line animation end -->
                            
                            <!-- Remember me -->
                            @if ($rme)
                                <div class="custom-control custom-checkbox clear">
                                    <input type="checkbox" class="custom-control-input" id="user-remember" name="user-remember" checked>
                                    <label class="custom-control-label" for="user-remember">Remember Me</label>
                                </div>
                            @else
                                <div class="custom-control custom-checkbox clear">
                                    <input type="checkbox" class="custom-control-input" id="user-remember" name="user-remember">
                                    <label class="custom-control-label" for="user-remember">Remember Me</label>
                                </div>
                            @endif

                            <!-- Sign in button -->
                            <button class="btn custom-btn my-4" onclick="submitLoginForm()">Sign In</button>
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
                    DFC<span>oaching</span>
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
<script type="text/javascript" src="{{ URL::asset('particle-js/particles.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('particle-js/particles.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('particle-js/app.js') }}"></script>
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

<script>

// presentation only log
console.log("Operations Head: 10072397");
console.log("Operations Manager (Daryl): 7010609");
console.log("Operations Manager (Carlo): 10072003");
console.log("Operations Manager (Ryan): 10071937");
console.log("Supervisor: 10071309");
console.log("Agent: 10072444");

</script>

</body>
</html>