@extends('layouts.app')
@section('title', 'DFTools — Dashboard')
@section('sidebar', 'css/sidebar.css')
@section('css', 'css/dashboard.css')
@section('js', 'js/dashboard.js')

@section('content')

    <!-- 1st row dashboard -->
    <div class="row">

        <!-- Overview of coaching completed -->
        <div class="col-md">
            <div class="ov-container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="overview-txt ov-completed d-flex flex-column">
                            <div class="ov-title">Overview</div>
                            <div class="ov-oth-txt">Coaching Completed</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="overview-prcnt">
                            <div id="ovTotal1" class="ov-total">
                                <div class="sr-only">
                                    Total count of coaching completed
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overview of coaching pending -->
        <div class="col-md">
            <div class="ov-container">
                <div class="row">
                    <div class="col-6">
                        <div class="overview-txt ov-pending d-flex flex-column">
                            <div class="ov-title">Overview</div>
                            <div class="ov-oth-txt">Coaching Pending</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="overview-prcnt">
                            <div id="ovTotal2" class="ov-total">
                                <div class="sr-only">
                                    Total count of coaching pending
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overview of coaching exception -->
        <div class="col-md">
            <div class="ov-container">
            <div class="row">
                    <div class="col-6">
                        <div class="overview-txt ov-exception d-flex flex-column">
                            <div class="ov-title">Overview</div>
                            <div class="ov-oth-txt">Coaching Exception</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="overview-prcnt">
                            <div id="ovTotal3" class="ov-total">
                                <div class="sr-only">
                                    Total count of coaching exception
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- 2nd row dashboard -->
    <div class="row mt-5">

        <!-- Summary section -->
        <div class="col-md">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">Summary</div>
                    <div class="dboard-othtext">of <span class="stats-for-coaching">For Coaching</span>, pending and completed</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="table-responsive px-4 pt-0 pb-4">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-for-coaching">For Coaching</span></td>
                            <td>
                                <!-- Button trigger modal -->
                                <a data-toggle="modal" data-target="#exampleModalCenter">
                                    <span id="action-btn" class="action-btn-crsession"><i class="fa fa-file-text mr-2"></i>Create Session</span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-for-coaching">For Coaching</span></td>
                            <td>
                                <!-- Button trigger modal -->
                                <a data-toggle="modal" data-target="#exampleModalCenter">
                                    <span id="action-btn" class="action-btn-crsession"><i class="fa fa-file-text mr-2"></i>Create Session</span>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-pending">Pending</span></td>
                            <td>N/A</td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-pending">Pending</span></td>
                            <td>N/A</td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-completed">Completed</span></td>
                            <td><span id="action-btn" class="action-btn-rtsession">Retake Session</span></td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-completed">Completed</span></td>
                            <td><span id="action-btn" class="action-btn-rtsession">Retake Session</span></td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-completed">Completed</span></td>
                            <td><span id="action-btn" class="action-btn-rtsession">Retake Session</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- 3rd row dashboard -->
    <div class="row mt-5">

         <!-- Exception section -->
         <div class="col-md">
            <div class="tb-container">
                <div class="row">
                    <div class="col-sm">
                        <div class="dboard-text px-4 pt-4 pb-3">
                            <div class="dboard-title">Exception</div>
                            <div class="dboard-othtext">with valid reason</div>
                        </div>
                    </div>
                    <div class="col-sm d-inline-flex align-items-center justify-content-end pr-5">
                        <div class="excp-btn d-inline-flex">
                            <a type="button" id="edit-btn" class="action-btn-edit mr-2"><i class="fa fa-edit mr-2"></i>Edit</a>
                            <a type="button" id="add-btn" class="action-btn-add" data-toggle="modal" data-target="#exceptionModal"><i class="fa fa-plus mr-2"></i>Add</a>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="table-responsive px-4 pt-0 pb-4">
                    <table class="table table-hover table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Role</th>
                            <th scope="col">Reason</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>For Coaching</td>
                            <td><span id="action-btn" class="action-btn-rtsession"><i class="fa fa-trash mr-2"></i>Delete</span></td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>For Coaching</td>
                            <td><span id="action-btn" class="action-btn-rtsession"><i class="fa fa-trash mr-2"></i>Delete</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">

        <!-- Top Resource section -->
        <div class="col-md">
            <div class="tb-container pb-4">
                <div class="dboard-text  px-4 pt-4 pb-3">
                    <div class="dboard-title">Top Resource</div>
                    <div class="dboard-othtext">for the month of June</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="top-resource-container">
                    <div class="row remove-padding">
                        <div class="col-7">

                        <!-- Name, role, scorecard title, top 1 -->
                            <div class="tr-section-container flex-column pt-4">
                                <div class="tr-section1 px-4 mb-4">
                                    <i class="fa fa-user my-auto"></i>
                                    <div class="tr-name-role">
                                        <div class="r-name">John Doe</div>
                                        <div class="r-role">Web Designer</div>
                                    </div>
                                </div>
                                <div class="title-scorecard-container">
                                    <div class="title-scc">
                                        Scorecard
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Total score -->
                        <div class="col-5 remove-p-left">
                            <div class="totalScore-container flex-column p-4">
                                <div class="total-heading">
                                    TOTAL
                                </div>
                                <div class="total-score">
                                    95%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress bar, categories score, and total score -->
                <div class="row mt-1">
                    <div class="col">
                        <div class="eachScore-container px-4 pt-3">
                            <!-- Productivity score -->
                            <div class="progress mt-1">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 89%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span id="count-example">Productivity: 89%</span></div>
                            </div>

                            <!-- Quality score -->
                            <div class="progress mt-1">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 99.4%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span id="count-example">Quality: 99.4%</span></div>
                            </div>

                            <!-- Churn score -->
                            <div class="progress mt-1">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 90%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span id="count-example">Churn: 90%</span></div>
                            </div>

                            <!-- Product Knowledge Test score -->
                            <div class="progress mt-1">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 85%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span id="count-example">Product Knowledge Test: 85%</span></div>
                            </div>

                            <!-- Attendance score -->
                            <div class="progress mt-1">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span id="count-example">Attendance: 100%</span></div>
                            </div>

                            <!-- Attendance score -->
                            <div class="progress mt-1">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 5%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span id="count-example">Bonus: 5%</span></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ranking of resource section -->
        <div class="col-md">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">Resource Ranking</div>
                    <div class="dboard-othtext">for the month of june</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="table-responsive px-4 pt-0 pb-4">
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>John Doe</td>
                            <td>Custom Designer</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>John Doe</td>
                            <td>Logo Designer</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>John Doe</td>
                            <td>Banner Designer</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>

@endsection