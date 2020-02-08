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
            <div class="tb-container p-4">
                <div class="dboard-text">
                    <div class="dboard-title">Summary</div>
                    <div class="dboard-othtext">of Lorem Ipsum</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="table-responsive tb-1strow-1">
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
                            <td>Not Coach</td>
                            <td>Create Session</td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>Not Coach</td>
                            <td>Create Session</td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>Not Coach</td>
                            <td>Create Session</td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>Not Coach</td>
                            <td>Create Session</td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>Not Coach</td>
                            <td>Create Session</td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>Not Coach</td>
                            <td>Create Session</td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>Not Coach</td>
                            <td>Create Session</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top Resource section -->
        <div class="col-md-4">
            <div class="tb-container p-4">
                <div class="dboard-text">
                    <div class="dboard-title">Top Resource</div>
                    <div class="dboard-othtext">for the month of June</div>
                </div>
                <div class="top-resource-container py-4">
                    <div><span>Name:</span>&nbsp;<span>John Doe</span></div>
                    <div><span>Role:</span>&nbsp;<span>Web Designer</span></div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="eachScore-container">
                            <div class="score-title">Productivity&nbsp;<span>90%</span></div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="score-title">Quality&nbsp;<span>90%</span></div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                            <div class="score-title">Churn&nbsp;<span>90%</span></div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="score-title">Product Knowledge Test&nbsp;<span>90%</span></div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="score-title">Attendance&nbsp;<span>90%</span></div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div>
                    </div>
                    <div class="col-4">
                        <div class="totalScore-container">
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
            <div class="tb-container p-4">
                <div class="dboard-text">
                    <div class="dboard-title">Exception</div>
                    <div class="dboard-othtext">with valid reason</div>
                </div>
                <div class="table-responsive">
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
                            <td>Not Coach</td>
                            <td>Create Session</td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>Not Coach</td>
                            <td>Create Session</td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>Not Coach</td>
                            <td>Create Session</td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>Not Coach</td>
                            <td>Create Session</td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>Not Coach</td>
                            <td>Create Session</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ranking of resource section -->
        <div class="col-md-3">
            <div class="tb-container p-4">
                <div class="dboard-text">
                    <div class="dboard-title">Resource Rankking</div>
                    <div class="dboard-othtext">for the month of june</div>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>John Doe</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>John Doe</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>John Doe</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>John Doe</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Date plugin -->
        <div class="col-md-3">
            <div class="tb-container p-4">
                <div class="dboard-text">
                    <div class="dboard-title">Date and Time</div>
                    <div class="dboard-othtext">for the month of june</div>
                </div>
                
                <div class="mt-5" id="date">Date today</div>
            </div>
        </div>

    </div>
@endsection