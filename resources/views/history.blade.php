@extends('layouts.app')
@section('title', 'DFTools — History')
@section('sidebar', URL::asset('css/sidebar.css'))
@section('css', URL::asset('css/history.css'))
@section('js', URL::asset('js/history.js'))

@php
    $user = session("user");
@endphp

@section('content')

    <!-- Supervisor history view -->
    <!-- Date    Session Type    Employee ID     Name    Role    Action -->
    <!-- Starts here -->
    <div class="row">
        <div class="col">
            <div id="history-wrapper">
            <div class="input-daterange input-group" id="datepicker">
            <input type="text" class="input-sm form-control" name="start" />
            <span class="input-group-addon">to</span>
            <input type="text" class="input-sm form-control" name="end" />
            </div>
            </div>
        </div>
    </div>

    <!-- 1st row designer dashboard -->
    <div class="row mt-5">

        <!-- Pending section -->
        <div class="col-lg">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">Coaching History</div>
                    <div class="dboard-othtext">Of Scorecard And/Or Coaching Session</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="table-responsive px-4 pt-0 pb-4">
                    <table class="table table-hover table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Session Type</th>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>03/05/2020</td>
                            <td>Mid Month Scorecard</td>
                            <td>{{ $user->EmployeeID() }}</td>
                            <td>{{ $user->FullName() }}</td>
                            <td>{{ $user->JobPosition() }}</td>
                            <td>
                                <span id="btn-add-notes" class="action-btn-addNotes mr-2"><i class="far fa-eye mr-2"></i>View</span>
                            </td>
                        </tr>
                        <tr>
                            <td>03/05/2020</td>
                            <td>Coaching</td>
                            <td>{{ $user->EmployeeID() }}</td>
                            <td>{{ $user->FullName() }}</td>
                            <td>{{ $user->JobPosition() }}</td>
                            <td>
                                <span id="btn-add-notes" class="action-btn-addNotes mr-2"><i class="far fa-eye mr-2"></i>View</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Agent history view -->
    <!-- Date    Type    Sent By    Action -->
    

@endsection