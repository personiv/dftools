@extends('layouts.app')
@section('title', 'DFTools — Dashboard')
@section('sidebar', 'css/sidebar.css')
@section('css', 'css/dashboard.css')
@section('js', 'js/dashboard.js')

@section('content')

    <!-- 1st row dashboard -->
    <div class="row">

        <!-- Top Resource section -->
        <div class="col-md-4">
            <div class="tb-container">
                <div class="dboard-text  px-4 pt-4 pb-3">
                    <div class="dboard-title">Top Resource</div>
                    <div class="dboard-othtext">for the month of June</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="top-resource-container">
                    <div class="row">
                        <div class="col-7">
                            <div class="tr-section1 px-4">
                                <i class="fa fa-user my-auto"></i>
                                <div class="tr-name-role">
                                    <div class="r-name">John Doe</div>
                                    <div class="r-role">Web Designer</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="tr-section2 px-4">
                                <span>1</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-7">
                        <div class="eachScore-container px-4 pt-0 pb-4">
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
                            <span class="score-title">Churn:</span>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 80%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span id="count-example">80%</span></div>
                            </div>

                            <!-- Product Knowledge Test score -->
                            <span class="score-title">Product Knowledge Test:</span>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 85%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span id="count-example">85%</span></div>
                            </div>

                            <!-- Attendance score -->
                            <span class="score-title">Attendance:</span>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span id="count-example">99.4%</span></div>
                            </div>

                        </div>
                    </div>
                    <div class="col-5">
                        <div class="totalScore-container flex-column px-4 pb-4">
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
        </div>

        <!-- Ranking of resource section -->
        <div class="col-md-5">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">Resource Rankking</div>
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

        <!-- Date plugin -->
        <div class="col-md-3">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">Date and Time</div>
                    <div class="dboard-othtext">for the month of june</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="table-responsive px-4 pt-0 pb-4">
                    <div class="mt-3" id="date">Date today</div>
                </div>
            </div>
        </div>
        
    </div>

    <!-- 2nd row dashboard -->
    <div class="row mt-5">

        <!-- Summary section -->
        <div class="col-md-8">
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
                            <td><span id="action-btn" class="action-btn-crsession">Create Session</span></td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-for-coaching">For Coaching</span></td>
                            <td><span id="action-btn" class="action-btn-crsession">Create Session</span></td>
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

        <!-- Exception section -->
        <div class="col-md-4">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">Exception</div>
                    <div class="dboard-othtext">with valid reason</div>
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
                            <td><span class="stats-for-coaching">For Coaching</span></td>
                            <td><span id="action-btn" class="action-btn-crsession">Create Session</span></td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-for-coaching">For Coaching</span></td>
                            <td><span id="action-btn" class="action-btn-crsession">Create Session</span></td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-for-coaching">For Coaching</span></td>
                            <td><span id="action-btn" class="action-btn-crsession">Create Session</span></td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-for-coaching">For Coaching</span></td>
                            <td><span id="action-btn" class="action-btn-crsession">Create Session</span></td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-for-coaching">For Coaching</span></td>
                            <td><span id="action-btn" class="action-btn-crsession">Create Session</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection