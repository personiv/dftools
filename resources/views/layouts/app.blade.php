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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    
    <!-- Global Style and Script -->
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    <!-- Page Style and Script -->
    <link rel="stylesheet" href="@yield('sidebar')">
    <link rel="stylesheet" href="@yield('css')">
    <script type="text/javascript" src="@yield('js')"></script>

    <!-- Plugins -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">dfs<span>dfscorecard</span></div>
        <div class="list-group list-group-flush">
            <a href="#" class="list-group-item list-group-item-action">
                <i class="fa fa-dashboard mr-3"></i><span>Dashboard</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <i class="fa fa-folder mr-3"></i><span>Create Session</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <i class="fa fa-history mr-3"></i><span>History</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <i class="fa fa-comments-o mr-3"></i><span>Feedback</span>
            </a>
            <div class="bottom-button mb-5">
            <a href="logout" class="list-group-itemX list-group-item-action">
                <i class="fa fa-sign-out mr-3"></i><span>Logout</span>
            </a>
            </div>  
        </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light">
            
            <!-- Collapse button -->
            <button id="menu-toggle" class="first-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent20"
                aria-controls="navbarSupportedContent20" aria-expanded="false" aria-label="Toggle navigation">
                <div class="animated-icon1"><span></span><span></span><span></span></div>
            </button>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="user-container justify-content-center align-items-center">
                                <div><i class="fa fa-user mr-2"></i></div>
                                <div class="d-flex flex-column">
                                    <span id="navItem-user">John Doe</span>
                                    <span id="navItem-role">Web Designer</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Change Password</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid p-5 dboard-wrapper">
            @yield('content')
        </div>

        <!-- /#page-content-wrapper -->
        </div>
    </div>

    <!-- Plugins -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
        // collapse menu / sidebar
        $("#menu-toggle").click(function(e) {
            var currentToggle = isToggled();
            document.cookie = "toggled=" + (currentToggle * -1).toString();
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        function getCookie(cname) {
          var name = cname + "=";
          var decodedCookie = decodeURIComponent(document.cookie);
          var ca = decodedCookie.split(';');
          for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
              c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
              return c.substring(name.length, c.length);
            }
          }
          return "";
        }

        function isToggled() {
            return parseInt(getCookie("toggled"));
        }
    </script>

    <script>
    // animated menu / hamburger 
    $(document).ready(function () {
        $('.first-button').on('click', function() {
            $('.animated-icon1').toggleClass('open');
        });
        if (getCookie("toggled") == "NaN") document.cookie = "toggled=1";
        if (isToggled() < 0) {
            $("#wrapper").toggleClass("toggled");
            $('.animated-icon1').toggleClass('open');
        }
    });
    </script>

</body>
</html>