@extends('layouts.app')
@section('title', 'DFTools — Dashboard')
@section('sidebar', 'css/sidebar.css')
@section('css', 'css/dashboard.css')
@section('js', 'js/dashboard.js')

@section('content')
    <!-- 1st row -->
    <div class="row">

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
                            <td><span id="action-btn" class="action-btn-crsession">Retake Session</span></td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-completed">Completed</span></td>
                            <td><span id="action-btn" class="action-btn-crsession">Retake Session</span></td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td><span class="stats-completed">Completed</span></td>
                            <td><span id="action-btn" class="action-btn-crsession">Retake Session</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Resource section -->
        <div class="col-md-4">
            <div class="tb-container">
                <div class="dboard-text  px-4 pt-4 pb-3">
                    <div class="dboard-title">Top Resource</div>
                    <div class="dboard-othtext">for the month of June</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="top-resource-container px-4 py-3">
                    <div>John Doe</div>
                    <div>Web Designer</div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="eachScore-container px-4 pt-0 pb-4">
                            <div class="score-title">Productivity</div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="score-title">Quality</div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                            <div class="score-title">Churn</div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="score-title">Product Knowledge Test</div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="score-title">Attendance</div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div>
                    </div>
                    <div class="col-4">
                        <div class="totalScore-container px-4 pt-1 pb-4">
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

    </div>

    <!-- 2nd row -->
    <div class="row mt-5">

        <!-- Exception section -->
        <div class="col-md-6">
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

        <!-- Ranking of resource section -->
        <div class="col-md-3">
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
@endsection