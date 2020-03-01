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
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker3.min.css') }}">
</head>
<body>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">DFC<span>oaching</span></div>
        <div class="list-group list-group-flush">
            @if ($user->AccountType() != "ADMIN")
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                <i class="fa fa-pie-chart mr-3"></i><span>Dashboard</span>
            </a>
            @if ($user->IsLeader())
            <!-- Modal style menu -->
            <!-- Button trigger modal for create session -->
            <a class="list-group-item list-group-item-action list-item-modal" data-toggle="modal" data-target="#createSessionModal">
                <i class="fa fa-file-text mr-3"></i><span>Create Session</span>
            </a>
            @endif
            <a href="{{ route('history') }}" class="list-group-item list-group-item-action">
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
                            <img src="{{ $user->ImagePath() }}" class="rounded-circle shadow border float-left" alt="{{ $user->FullName() }}" width="40" height="40"> 
                                <div class="d-flex flex-column ml-3">
                                    <span id="navItem-user">{{ $user->FullName() }}</span>
                                    <span id="navItem-role">{{ $user->JobPosition() }}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" data-toggle="modal" data-target="#changePassModal" href="#">
                                <i class="fas fa-key"></i>
                                <span>Change Password</span>
                            </a>
                            <a class="dropdown-item" href="#" onclick="document.querySelector('#new-img').click()">
                                <i class="fas fa-photo"></i>
                                <span>Change Photo</span>
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
            <div class="container-fluid px-5 pb-5 footer-container">
                <footer>
                    <div class="row">
                        <div class="col">
                            <div class="copyright-index d-flex justify-content-center">
                            Copyright © 2020 | DFCoaching All rights reserved.
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
        <div class="modal fade" id="createSessionModal" tabindex="-1" role="dialog" aria-labelledby="createSessionModalCenterTitle"
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
                                <div class="effect-container width-custom"> <!-- input line animation -->
                                    <select class="line-effect custom-select" id="session-agent" name="session-agent" required>
                                        <?php $members = $user->TeamMembers(); ?>
                                        @for ($i = 0; $i < count($members); $i++)
                                            <?php $member = $members[$i]; ?>
                                            <option value="{{ $member->EmployeeID() }}">{{ $member->FullName() }}</option>
                                        @endfor
                                    </select>
                                    <span class="focus-border">
                                    <i></i>
                                    </span>
                                </div> <!-- input line animation -->
                            </div>
                            <div class="input-group mb-4">
                                <label class="custom-label" for="session-type">Session Type:</label>
                                <div class="effect-container width-custom"> <!-- input line animation -->
                                    <select class="line-effect custom-select" id="session-type" name="session-type" required>
                                        <?php $tagType = $user->AccountType() == "SPRVR" ? "SESSION" : ($user->AccountType() == "MANGR" ? "SESSION2" : "SESSION3"); ?>
                                        @foreach (App\Tag::where("tag_type", $tagType)->get() as $tag)
                                            <option class="modal-option" value="{{ $tag->Name() }}">{{ $tag->Description() }}</option>
                                        @endforeach
                                    </select>
                                    <span class="focus-border">
                                    <i></i>
                                    </span>
                                </div> <!-- input line animation end -->
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
        <div class="modal fade" id="exceptionModal" tabindex="-1" role="dialog" aria-labelledby="addExceptionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Exception</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ action('HomeController@addException') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="input-group mb-4">
                                <label class="custom-label" for="exception-agent">Agent:</label>
                                <div class="effect-container width-custom"> <!-- input line animation -->
                                    <select class="line-effect custom-select" id="exception-agent" name="exception-agent" required>
                                        <?php $members = $user->TeamMembers(); ?>
                                        @for ($i = 0; $i < count($members); $i++)
                                        <?php $member = $members[$i]; ?>
                                        <option value="{{ $member->EmployeeID() }}">{{ $member->FullName() }}</option>
                                        @endfor
                                    </select>
                                    <span class="focus-border">
                                    <i></i>
                                    </span>
                                </div> <!-- input line animation end -->
                            </div>

                            <div class="input-group">
                                <label class="custom-label" for="exception-reason">Reason:</label>
                                <div class="effect-container width-custom"> <!-- input line animation -->
                                    <textarea class="line-effect form-control" id="exception-reason" name="exception-reason" placeholder="Enjoying his/her vacation leave!" rows="3" required></textarea>
                                    <span class="focus-border">
                                    <i></i>
                                    </span>
                                </div> <!-- input line animation end -->
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
        <!--
        <
        <
        <   Edit exception data
        <
        <
        -->
        <!-- Modal -->
        <div class="modal fade" id="editExceptionModal" tabindex="-1" role="dialog" aria-labelledby="editExceptionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editExceptionModalLongTitle">Edit Exception</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ action('HomeController@editException') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="input-group mb-4">
                                <label class="custom-label">Agent:</label>
                                <div class="effect-container width-custom">
                                    <input type="hidden" id="edit-exception-agent" name="edit-exception-agent">
                                    <label class="custom-label" id="edit-exception-agent-name"></label>
                                </div>
                            </div>

                            <div class="input-group">
                                <label class="custom-label" for="edit-exception-reason">Reason:</label>
                                <div class="effect-container width-custom"> <!-- input line animation -->
                                    <textarea class="line-effect form-control" id="edit-exception-reason" name="edit-exception-reason" placeholder="Enjoying his/her vacation leave!" rows="3" required></textarea>
                                    <span class="focus-border">
                                    <i></i>
                                    </span>
                                </div> <!-- input line animation end -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="edit-exception-id" name="edit-exception-id">
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
                    <form action="{{ action('HomeController@addFeedback') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="input-group mb-4">
                                <label class="custom-label" for="feedback-sender">Name:</label>
                                <div class="effect-container width-custom"> <!-- input line animation -->
                                    <input type="text" class="line-effect form-control" id="feedback-sender" name="feedback-sender" placeholder="John Doe">
                                    <span class="focus-border">
                                    <i></i>
                                    </span>
                                </div> <!-- input line animation end -->
                            </div>

                            <div class="input-group">
                                <label class="custom-label" for="feedback-comment">Comments:</label>
                                
                                <div class="effect-container width-custom"> <!-- input line animation -->
                                    <textarea class="line-effect form-control" id="feedback-comment" name="feedback-comment" placeholder="Well done!" rows="3" required></textarea>
                                    <span class="focus-border">
                                    <i></i>
                                    </span>
                                </div> <!-- input line animation end -->
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
        <!--
        <
        <
        <   Change Photo form
        <
        <
        -->
        <!-- Hidden Form -->
        <form id="new-img-form" class="hidden-form" action="{{ action('HomeController@changePhoto') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="file" name="new-img" id="new-img" accept="image/*">
        </form>
        <!--
        <
        <
        <   History
        <
        <
        -->
        <!-- Modal -->
        <div class="modal fade" id="dateHistoryModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ action('HomeController@viewHistorySessions') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col d-flex justify-content-start align-items-center">
                                    <div class="history-desc">
                                        <div><i class="far fa-calendar-alt mr-2"></i></div>
                                        <div>Set the date <div class="arrows"></div></div>
                                        <div>to view the</div>
                                        <div>session history</div>
                                    </div>
                                </div>
                                
                                <div class="col d-flex justify-content-start align-items-center">

                                    <!-- Date picker -->
                                    <div id="history-wrapper">
                                        <div class="input-daterange input-group" id="datepicker">

                                            <!-- Date start -->
                                            <div class="date-start mb-4">
                                                <div>From date:</div>
                                                <div class="effect-container date-input-container mt-1"> <!-- input line animation -->
                                                    <input class="line-effect form-control" type="text" name="history-start" required>
                                                    <span class="focus-border">
                                                    <i></i>
                                                    </span>
                                                </div> <!-- input line animation end -->
                                            </div>

                                            <!-- Date end -->
                                            <div class="date-end">
                                                <div>To date:</div>
                                                <div class="effect-container date-input-container mt-1"> <!-- input line animation -->
                                                    <input class="line-effect form-control" type="text" name="history-end" required>
                                                    <span class="focus-border">
                                                    <i></i>
                                                    </span>
                                                </div> <!-- input line animation end -->
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!-- Date picker end -->

                                </div>
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
        <!--
        <
        <
        <   Chnage Password
        <
        <
        -->
        <!-- Modal -->
        <div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="changepassModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ action('HomeController@changePassword') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="input-group mb-4">
                                <label class="custom-label width-30" for="feedback-sender">
                                    New Password:
                                    <a tabindex="0" class="popover-dismiss ml-1" role="button" data-toggle="popover" data-trigger="focus" title="Changing your password?" data-content="Password should not contain any special characters, symbols or spaces and must be at least 6-24 characters long.">
                                    <i class="fa fa-question-circle text-primary"></i>
                                </a>
                                </label>
                                <div class="effect-container width-70"> <!-- input line animation -->
                                    <input type="password" class="line-effect form-control" id="new-pass" name="new-pass" pattern="^[a-zA-Z0-9]\w{5,23}$" required>
                                    <span class="focus-border">
                                    <i></i>
                                    </span>
                                </div> <!-- input line animation end -->
                            </div>

                            <div class="input-group">
                                <label class="custom-label width-30" for="feedback-comment">Confirm Password:</label>
                                
                                <div class="effect-container width-70"> <!-- input line animation -->
                                    <input type="password" class="line-effect form-control" id="new-pass-verify" name="new-pass-verify" pattern="^[a-zA-Z0-9]\w{5,23}$" required>
                                    <span class="focus-border">
                                    <i></i>
                                    </span>
                                </div> <!-- input line animation end -->
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

    <!-- Toast Template -->
    <div class="row">
        <div class="col">
            <div aria-live="polite" aria-atomic="true" style="position: relative;">
                <!-- Position it -->
                <div style="position: fixed; top: 12%; right: 1%;">

                <!-- Toast message starts here -->
                <div id="toast-template" role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">
                    <div class="toast-header">
                        <div class="mr-auto toast-title"></div>
                        <small class="toast-time"></small>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body"></div>
                </div>
                <!-- end -->

            </div>
            </div>
        </div>
    </div>

    <!-- Plugins -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="{{ URL::asset('js/jquery.waypoints.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/progressbar.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <!-- Global Script -->
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    @yield('bladescript')

    @if ($user->AccountType() != "ADMIN")
    <!-- Poll Script -->
    <script type="text/javascript">
        // Poll messages
        Poll("{{ action('HomeController@getPolls') }}", "{{ action('HomeController@dequeuePoll') }}", '{{ $user->EmployeeID() }}');
    </script>
    @endif

    <script> $('.popover-dismiss').popover({ trigger: 'focus' }); </script>

</body>
</html>