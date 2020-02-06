@extends('layouts.app')
@section('title', 'DFTools — Dashboard')
@section('sidebar', 'css/sidebar.css')
@section('css', 'css/dashboard.css')
@section('js', 'js/dashboard.js')

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="tb-container p-4 border">
                <div class="summary-heading">
                    <h2>
                        <span>Summary</span>
                    </h2>
                </div>
                <div class="table-responsive">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="tb-container p-4 border">
                <div class="summary-heading">
                    <h2>
                        <span>Top Resource</span>
                    </h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="eachScore-container">
                            <div class="score-title">Productivity</div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="score-title">Productivity</div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                            <div class="score-title">Productivity</div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="score-title">Productivity</div>
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
    <div class="row">
        <div class="col-8">
            <div class="tb-container p-4 border">
                <div class="summary-heading">
                    <h2>
                        <span>Summary</span>
                    </h2>
                </div>
                <div class="table-responsive">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="tb-container p-4 border">
                <div class="summary-heading">
                    <h2>
                        <span>Top Resource</span>
                    </h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="eachScore-container">
                            <div class="score-title">Productivity</div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="score-title">Productivity</div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                            <div class="score-title">Productivity</div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                            <div class="score-title">Productivity</div>
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
    <div class="row">
        <div class="col-8">
            <div class="tb-container p-4 border">
                <div class="summary-heading">
                    <h2>
                        <span>Summary</span>
                    </h2>
                </div>
                <div class="table-responsive">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="tb-container p-4 border">
                <div class="summary-heading">
                    <h2>
                        <span>Top Resource</span>
                    </h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="eachScore-container">
                            <div class="score-title">Productivity</div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="score-title">Productivity</div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                            <div class="score-title">Productivity</div>
                            <div class="progress mt-1">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                            <div class="score-title">Productivity</div>
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
@endsection