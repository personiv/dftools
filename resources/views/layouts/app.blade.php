<?php $user = session("user") ?>
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
    
    <!-- Global Style -->
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

    <!-- Page Style and Script -->
    <link rel="stylesheet" href="@yield('sidebar')">
    <link rel="stylesheet" href="@yield('css')">
    <script type="text/javascript" src="@yield('js')"></script>

    <!-- Plugins -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    
</head>
<body>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">dfs<span>corecard</span></div>
        <div class="list-group list-group-flush">
            @if ($user->AccountType() != "ADMIN")
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                <i class="fa fa-pie-chart mr-3"></i><span>Dashboard</span>
            </a>
            @if ($user->IsLeader())
            <!-- Modal style menu -->
            <!-- Button trigger modal for create session -->
            <a class="list-group-item list-group-item-action list-item-modal" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="fa fa-file-text mr-3"></i><span>Create Session</span>
            </a>
            @endif
            <a href="#" class="list-group-item list-group-item-action">
                <i class="fa fa-history mr-3"></i><span>History</span>
            </a>
            <!-- Modal style menu -->
            <!-- Button trigger modal for feedback -->
            <a href="#" class="list-group-item list-group-item-action list-item-modal" data-toggle="modal" data-target="#feedbackModal">
                <i class="fa fa-commenting mr-3"></i><span>Feedback</span>
            </a>
            @else
            <a href="{{ route('addcredential') }}" class="list-group-item list-group-item-action">
                <i class="fa fa-plus mr-3"></i><span>Add Credential</span>
            </a>
            <a href="{{ route('updatecredential') }}" class="list-group-item list-group-item-action">
                <i class="fa fa-edit mr-3"></i><span>Update Credential</span>
            </a>
            <a href="{{ route('deletecredential') }}" class="list-group-item list-group-item-action">
                <i class="fa fa-trash mr-3"></i><span>Delete Credential</span>
            </a>
            <a href="{{ route('uploaddata') }}" class="list-group-item list-group-item-action">
                <i class="fa fa-upload mr-3"></i><span>Upload Data</span>
            </a>
            <a href="{{ route('uploadmanualdata') }}" class="list-group-item list-group-item-action">
                <i class="fa fa-upload mr-3"></i><span>Upload Manual Data</span>
            </a>
            <a href="{{ route('updatescorecarditems') }}" class="list-group-item list-group-item-action">
                <i class="fa fa-table mr-3"></i><span>Update Scorecard Items</span>
            </a>
            @endif
            <div class="bottom-button mb-5">
            <a href="{{ action('LoginController@logout') }}" class="list-group-itemX list-group-item-action">
                <i class="fas fa-sign-out-alt mr-3"></i><span>Logout</span>
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
            
            <!-- 
            / Disabled responsive button for tablet view or small screen /bootstrap
            /
            /
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> 
            /
            /
            / Ends here
            -->

            <div class="navbar-collapse">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="user-container justify-content-center align-items-center">
                            <img src="{{ URL::asset('images/john_doe.jpg') }}" class="rounded-circle shadow border float-left" alt="{{ $user->FullName() }}" width="40" height="40"> 
                                <div class="d-flex flex-column ml-3">
                                    <span id="navItem-user">{{ $user->FullName() }}</span>
                                    <span id="navItem-role">{{ $user->JobPosition() }}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-key"></i>
                                <span>Change Password</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ action('LoginController@logout') }}">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

            <div class="container-fluid p-5 dboard-wrapper">
                @yield('content')

            <!-- Footer  area here -->
            </div>
        <!-- /#page-content-wrapper -->
            <div class="container-fluid px-5 pb-5">
                <footer>
                    <div class="row">
                        <div class="col">
                            <div class="copyright-index d-flex justify-content-center">
                            Copyright © 2020 | DFScorecard All rights reserved.
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        @if ($user->IsLeader())
        <!--
        <
        <
        <   Create Session
        <
        <
        -->
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title" id="exampleModalLongTitle">Create Session</div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ action('HomeController@createSession') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="input-group mb-4">
                                    <label class="custom-label" for="session-agent">Resource:</label>
                                <select class="custom-select" id="session-agent" name="session-agent" required>
                                    <?php $members = $user->TeamMembers(); ?>
                                    @for ($i = 0; $i < count($members); $i++)
                                        <?php $member = $members[$i]; ?>
                                        <option value="{{ $member->EmployeeID() }}">{{ $member->FullName() }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="input-group mb-4">
                                    <label class="custom-label" for="session-type">Session Type:</label>
                                <select class="custom-select" id="session-type" name="session-type" required>
                                    <option class="modal-option" value="SCORE">Scorecard</option>
                                    <option class="modal-option" value="COACH">Coaching</option>
                                    <option class="modal-option" value="TRIAD">Triad</option>
                                    <option class="modal-option" value="GOAL">Goal Setting</option>
                                </select>
                            </div>
                            <div class="custom-control custom-checkbox mt-5">
                                <input type="checkbox" class="custom-control-input" id="session-mode" name="session-mode" value="MANUAL">
                                <label class="custom-control-label" for="session-mode">Manual Mode&nbsp;</label>
                                <a tabindex="0" class="popover-dismiss" role="button" data-toggle="popover" data-trigger="focus" title="Manual Scorecard" data-content="Please be informed that this checkbox is for scorecard only!">
                                    <i class="fa fa-question-circle"></i>
                                </a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="modal-btn btn-close" data-dismiss="modal">Close</button>
                            <button type="submit" class="modal-btn btn-start">Start</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--
        <
        <
        <   Add exception data
        <
        <
        -->
        <!-- Modal -->
        <div class="modal fade" id="exceptionModal" tabindex="-1" role="dialog" aria-labelledby="exceptionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Exception</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="#" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="input-group mb-4">
                                    <label class="custom-label" for="exception-agent">Resource:</label>
                                <select class="custom-select" id="exception-agent" name="exception-agent" required>
                                    <?php $members = $user->TeamMembers(); ?>
                                    @for ($i = 0; $i < count($members); $i++)
                                        <?php $member = $members[$i]; ?>
                                        <option value="{{ $member->EmployeeID() }}">{{ $member->FullName() }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="input-group">
                                    <label class="custom-label" for="FormControlTextarea">Reason:</label>
                                    <textarea class="form-control" id="FormControlTextarea" placeholder="Here you can add a valid reason..." rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="modal-btn btn-close" data-dismiss="modal">Close</button>
                            <button type="submit" class="modal-btn btn-start">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        <!--
        <
        <
        <   Feedback
        <
        <
        -->
        <!-- Modal -->
        <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="exceptionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Feedback</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="#" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="input-group mb-4">
                                    <label class="custom-label" for="feedback-name">Name:</label>
                                    <input type="text" class="form-control" id="feedback-name" placeholder="John Doe">
                            </div>

                            <div class="input-group">
                                    <label class="custom-label" for="FormControlTextarea">Comments:</label>
                                    <textarea class="form-control" id="FormControlTextarea" placeholder="Here you can share your feedback and stayed anonymous..." rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="modal-btn btn-close" data-dismiss="modal">Close</button>
                            <button type="submit" class="modal-btn btn-start">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- End of main wrapper -->
    </div>

    <!-- Plugins -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/progressbar.js') }}"></script>
    <!-- Global Script -->
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    @yield('bladescript')
    <script>
        $('.popover-dismiss').popover({
            trigger: 'focus'
        })
    </script>
</body>
</html>