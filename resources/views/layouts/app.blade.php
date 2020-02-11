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
</head>
<body>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">dfs<span>corecard</span></div>
        <div class="list-group list-group-flush">
            @if (session("user-type") != "ADMIN")
            <a href="#" class="list-group-item list-group-item-action">
                <i class="fa fa-pie-chart mr-3"></i><span>Dashboard</span>
            </a>
            @if (session("user-type") == "SPRVR")
            <!-- Modal style menu -->
            <!-- Button trigger modal -->
            <a class="list-group-item list-group-item-action list-item-modal" data-toggle="modal" data-target="#exampleModalCenter">
                <i class="fa fa-file-text mr-3"></i><span>Create Session</span>
            </a>
            @endif
            <a href="#" class="list-group-item list-group-item-action">
                <i class="fa fa-history mr-3"></i><span>History</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <i class="fa fa-weixin mr-3"></i><span>Feedback</span>
            </a>
            @else
            <a href="add-credential" class="list-group-item list-group-item-action">
                <i class="fa fa-plus mr-3"></i><span>Add Credential</span>
            </a>
            <a href="update-credential" class="list-group-item list-group-item-action">
                <i class="fa fa-edit mr-3"></i><span>Update Credential</span>
            </a>
            <a href="delete-credential" class="list-group-item list-group-item-action">
                <i class="fa fa-trash mr-3"></i><span>Delete Credential</span>
            </a>
            <a href="upload-data" class="list-group-item list-group-item-action">
                <i class="fa fa-upload mr-3"></i><span>Upload Data</span>
            </a>
            <a href="upload-manual-data" class="list-group-item list-group-item-action">
                <i class="fa fa-upload mr-3"></i><span>Upload Manual Data</span>
            </a>
            <a href="update-scorecard-items" class="list-group-item list-group-item-action">
                <i class="fa fa-table mr-3"></i><span>Update Scorecard Items</span>
            </a>
            @endif
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
                            <a class="dropdown-item" href="logout">Logout</a>
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
        @if (session("user-type") == "SPRVR")
        <!-- Modal / Create Session -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
            <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Here, you can manually Create Session</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="session" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="session-agent">Resource</label>
                                </div>
                                <select class="custom-select" id="session-agent" name="session-agent" required>
                                    @for ($i = 0; $i < count(session("user-team")); $i++)
                                        <?php $member = session("user-team")[$i]; ?>
                                        <option value="{{ $member->getAttribute('credential_user') }}">{{ $member->getAttribute('credential_first') . ' ' . $member->getAttribute('credential_last') }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="session-type">Session Type</label>
                                </div>
                                <select class="custom-select" id="session-type" name="session-type" required>
                                    <option value="SCORE">Scorecard</option>
                                    <option value="COACH">Coaching</option>
                                    <option value="TRIAD">Triad</option>
                                    <option value="GOAL">Goal Setting</option>
                                </select>
                            </div>
                            <div class="custom-control custom-checkbox mt-4">
                                <input type="checkbox" class="custom-control-input" id="session-mode" name="session-mode" value="MANUAL">
                                <label class="custom-control-label" for="session-mode">Manual Mode (Please note that this checkbox is for scorecard only!</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Start</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    <!-- End of main wrapper -->
    </div>

    <!-- Plugins -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/progressbar.js"></script>
    <!-- Global Script -->
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
</body>
</html>