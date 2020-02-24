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

    <!-- 1st row supervisor history -->
 @if ($user->AccountType() == "SPRVR" || $user->AccountType() == "MANGR" || $user->AccountType() == "HEAD")


    <div class="row mt-5">

        <!-- Pending section -->
        <div class="col-lg">
            <div class="tb-container">
                <div class="row">
                    <div class="col-sm">
                        <div class="dboard-text px-4 pt-4 pb-3">
                            <div class="dboard-title">Coaching History</div>
                            <div class="dboard-othtext">Of Scorecard And/Or Coaching Session</div>
                        </div>
                    </div>
                    <div class="col-sm d-inline-flex align-items-center justify-content-end pr-5">
                        <div class="date-btn-container mx-wdth d-inline-flex">
                            <span id="date-btn" class="action-btn-add" data-toggle="modal" data-target="#dateHistoryModal"><i class="fas fa-calendar-day mr-2"></i>Date</span>
                        </div>
                    </div>
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
                            @if ($user->AccountType() == "MANGR" || $user->AccountType() == "HEAD")
                                <th scope="col">Supervisor</th>
                            @endif
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (session('historySessions') != null)
                            @foreach (session('historySessions') as $session)
                                <tr>
                                    <td>{{ $session->DateCreated()->format("Y-m-d") }}</td>
                                    <td>{{ $session->TypeDescription() }}</td>
                                    <td>{{ $session->AgentID() }}</td>
                                    <td>{{ $session->Agent()->FullName() }}</td>
                                    <td>{{ $session->Agent()->JobPosition() }}</td>
                                    @if ($user->AccountType() == "MANGR" || $user->AccountType() == "HEAD")
                                        <td>{{ $session->Agent()->TeamLeader()->FullName() }}</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('session', [$session->SessionID()]) }}"><span class="action-btn-view mr-2"><i class="far fa-eye mr-2"></i>View</span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Agent history view -->
    <!-- Date    Type    Sent By    Action -->

    <!-- 1st row agent history -->
@else
    <div class="row mt-5">

        <!-- Pending section -->
        <div class="col-lg">
            <div class="tb-container">
                <div class="row">
                    <div class="col-sm">
                        <div class="dboard-text px-4 pt-4 pb-3">
                            <div class="dboard-title">Coaching History</div>
                            <div class="dboard-othtext">Of Scorecard And/Or Coaching Session</div>
                        </div>
                    </div>
                    <div class="col-sm d-inline-flex align-items-center justify-content-end pr-5">
                        <div class="date-btn-container mx-wdth d-inline-flex">
                            <span id="date-btn" class="action-btn-add" data-toggle="modal" data-target="#dateHistoryModal"><i class="fas fa-calendar-day mr-2"></i>Date</span>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="table-responsive px-4 pt-0 pb-4">
                    <table class="table table-hover table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Type</th>
                            <th scope="col">Sent By</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (session('historySessions') != null)
                            @foreach (session('historySessions') as $session)
                                <tr>
                                    <td>{{ $session->DateCreated()->format("Y-m-d") }}</td>
                                    <td>{{ $session->TypeDescription() }}</td>
                                    <td>{{ $session->Agent()->TeamLeader()->FullName() }}</td>
                                    <td>
                                        <a href="{{ route('session', [$session->SessionID()]) }}"><span class="action-btn-view mr-2"><i class="far fa-eye mr-2"></i>View</span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    
    
@endif

@endsection