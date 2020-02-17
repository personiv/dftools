@extends('layouts.app')
@section('title', 'DFTools — Dashboard')
@section('sidebar', URL::asset('css/sidebar.css'))
@section('css', URL::asset('css/dashboard.css'))
@section('js', URL::asset('js/dashboard.js'))

@php
    $user = session("user");
    $userTeam = $user->TeamMembers();
    $coachingSummary = $user->CoachingSummaryThisWeek();
@endphp

@section('bladescript')
<script type="text/javascript">
    createCircle("ovTotal1", "#5cb85c", "#5cb85c", {{ count($coachingSummary['Completed']) }}, {{ $userTeam->count() }});
    createCircle("ovTotal2", "#f0ad4e", "#f0ad4e", {{ count($coachingSummary['Pending']) }}, {{ $userTeam->count() }});
    createCircle("ovTotal3", "#5bc0de", "#5bc0de", 1, 2);
</script>
@endsection

@section('content')


<!-- Supervisor Dashboard -->    
@if ($user->AccountType() == "SPRVR")

    <!-- 1st row supervisor dashboard -->
    <div class="row">

        <!-- Overview of coaching completed -->
        <div class="col-lg">
            <div class="ov-container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="overview-txt ov-completed d-flex flex-column">
                            <div class="ov-title">Completed</div>
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
        <div class="col-lg">
            <div class="ov-container">
                <div class="row">
                    <div class="col-6">
                        <div class="overview-txt ov-pending d-flex flex-column">
                            <div class="ov-title">Pending</div>
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
        <div class="col-lg">
            <div class="ov-container">
            <div class="row">
                    <div class="col-6">
                        <div class="overview-txt ov-exception d-flex flex-column">
                            <div class="ov-title">Exception</div>
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

    <!-- 2nd row supervisor dashboard -->
    <div class="row mt-5">

        <!-- Summary section -->
        <div class="col-lg">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">Summary</div>
                    <div class="dboard-othtext">of <span class="stats-for-coaching">For Coaching</span>, pending and completed</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="scrollbar scrollbar-primary">
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
                            @foreach ($coachingSummary as $summaryStatus => $summaryItems)
                                @for ($i = 0; $i < count($summaryItems); $i++)
                                    @if ($summaryStatus == "For Coaching")
                                        <tr>
                                            <td>{{ $summaryItems[$i]["employeeID"] }}</td>
                                            <td>{{ $summaryItems[$i]["fullName"] }}</td>
                                            <td>{{ $summaryItems[$i]["jobPosition"] }}</td>
                                            <td><span class="stats-for-coaching">For Coaching</span></td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <a data-toggle="modal" data-target="#exampleModalCenter">
                                                    <span id="action-btn" class="action-btn-crsession"><i class="fa fa-file-text mr-2"></i>Create Session</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @elseif ($summaryStatus == "Pending")
                                        <tr>
                                            <td>{{ $summaryItems[$i]["employeeID"] }}</td>
                                            <td>{{ $summaryItems[$i]["fullName"] }}</td>
                                            <td>{{ $summaryItems[$i]["jobPosition"] }}</td>
                                            <td><span class="stats-pending">Pending</span></td>
                                            <td><a href="{{ route('session', [$summaryItems[$i]['sessionID']]) }}"><span id="action-btn" class="action-btn-rtsession">Complete Session</span></a></td>
                                        </tr>
                                    @elseif ($summaryStatus == "Completed")
                                        <tr>
                                            <td>{{ $summaryItems[$i]["employeeID"] }}</td>
                                            <td>{{ $summaryItems[$i]["fullName"] }}</td>
                                            <td>{{ $summaryItems[$i]["jobPosition"] }}</td>
                                            <td><span class="stats-completed">Completed</span></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                @endfor
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>

    </div>

    <!-- 3rd row supervisor dashboard -->
    <div class="row mt-5">

         <!-- Exception section -->
         <div class="col-lg">
            <div class="tb-container">
                <div class="row">
                    <div class="col-sm">
                        <div class="dboard-text px-4 pt-4 pb-3">
                            <div class="dboard-title">Exception</div>
                            <div class="dboard-othtext">with valid reason</div>
                        </div>
                    </div>
                    <div class="col-sm d-inline-flex align-items-center justify-content-end pr-5">
                        <div class="excp-btn mx-wdth d-inline-flex">
                            <span id="add-btn" class="action-btn-add" data-toggle="modal" data-target="#exceptionModal"><i class="fa fa-plus mr-2"></i>Add</span>
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
                            <td>Core Leave</td>
                            <td>
                                <span id="btn-edit" class="action-btn-edit mr-2"><i class="fa fa-edit mr-2"></i>Edit</span>
                                <span id="btn-delete" class="action-btn-delete"><i class="fa fa-trash mr-2"></i>Delete</span>
                            </td>
                        </tr>
                        <tr>
                            <td>10021002</td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                            <td>Suspended</td>
                            <td>
                                <span id="btn-edit" class="action-btn-edit mr-2"><i class="fa fa-edit mr-2"></i>Edit</span>
                                <span id="btn-delete" class="action-btn-delete"><i class="fa fa-trash mr-2"></i>Delete</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- 4th row supervisor dashboard -->
    <div class="row mt-5">

        <!-- Top Resource section -->
        <div class="col-lg">
            <div class="tb-container pb-2">
                <div class="dboard-text  px-4 pt-4 pb-3">
                    <div class="dboard-title">Overall Top Resource</div>
                    <div class="dboard-othtext">for the month of June</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="top-resource-container">
                    <div class="row remove-padding">
                        <div class="col-7">

                        <!-- Name, role, scorecard title, top 1 -->
                            <div class="tr-section-container flex-column pt-4">
                                <div class="tr-section1 px-4 mb-4">
                                <img src="{{ URL::asset('images/john_doe.jpg') }}" class="rounded-circle shadow border float-left" alt="{{ $user->FullName() }}" width="40" height="40"> 
                                    <div class="tr-name-role flex-column ml-3">
                                        <div class="r-name">John Doe</div>
                                        <div class="r-role">Web Designer</div>
                                    </div>
                                </div>
                                <div class="title-scorecard-container">
                                    <div class="title-scc d-inline-flex justify-content-center align-items-center">
                                       <div class="mr-2">Scorecard</div>
                                       <a tabindex="0" class="popover-dismiss" role="button" data-toggle="popover" data-trigger="focus" title="Scorecard Overview" data-content="This is the overall scorecard of the resource for the month of June"><i class="fa fa-question-circle"></i></a>
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
                                    95<sup>%</sup>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress bar, categories score, and total score -->
                <div class="row mt-1">
                    <div class="col-sm">
                        <div class="eachScore-container px-4 py-3">
                            <!-- Productivity score -->
                            <div class="progress mt-1">
                                <div class="progress-bar pb-color-sp" role="progressbar" style="width: 89%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Productivity: <span class="progress-score">89%</span></span></div> 
                            </div>

                            <!-- Quality score -->
                            <div class="progress mt-1">
                                <div class="progress-bar pb-color-p" role="progressbar" style="width: 99.4%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Quality: <span class="progress-score">99.4%</span></span></div>
                            </div>

                            <!-- Churn score -->
                            <div class="progress mt-1">
                                <div class="progress-bar pb-color-f" role="progressbar" style="width: 70%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Churn: <span class="progress-score">70%</span></span></div>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="eachScore-container px-4 py-3">
                            <!-- Product Knowledge Test score -->
                            <div class="progress mt-1">
                                <div class="progress-bar pb-color-sp" role="progressbar" style="width: 85%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">PKT: <span class="progress-score">85%</span></span></div>
                            </div>

                            <!-- Attendance score -->
                            <div class="progress mt-1">
                                <div class="progress-bar pb-color-p" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Attendance: <span class="progress-score">100%</span></span></div>
                            </div>

                            <!-- Attendance score -->
                            <div class="progress mt-1">
                                <div class="progress-bar pb-color-bonus" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Bonus: <span class="progress-score">5%</span></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ranking of resource section -->
        <div class="col-lg">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">Top 3 Resource</div>
                    <div class="dboard-othtext">for the month of june</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="table-responsive px-4 pt-0 pb-4">
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">&nbsp;&nbsp;#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="tr-3 tr-topOne d-inline-flex justify-content-center align-items-center">
                                    <span class="mr-2">1</span>
                                    <i class="fas fa-trophy"></i>
                                </div>
                            </td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="tr-3 tr-topTwo d-inline-flex justify-content-center align-items-center">
                                    <span class="mr-2">2</span>
                                    <i class="fas fa-medal"></i>
                                </div>
                            </td>
                            <td>John Doe</td>
                            <td>Custom Designer</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="tr-3 tr-topThree d-inline-flex justify-content-center align-items-center">
                                    <span class="mr-2">3</span>
                                    <i class="fas fa-award"></i>
                                </div>
                            </td>
                            <td>John Doe</td>
                            <td>Web Designer</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>


<!-- Agent Dashboard -->    
@elseif ($user->AccountType() == "DESGN")

    <!-- 1st row designer dashboard -->
    <div class="row">

        <!-- Resource Scorecard Status Section -->
        <div class="col-lg">
            <div class="tb-container pb-2">
                <div class="dboard-text  px-4 pt-4 pb-3">
                    <div class="dboard-title">My Scorecard Status</div>
                    <div class="dboard-othtext">for the month of June</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="top-resource-container">
                    <div class="row remove-padding">
                        <div class="col-7">

                        <!-- Name, role, scorecard title, top 1 -->
                            <div class="tr-section-container flex-column pt-4">
                                <div class="tr-section1 px-4 mb-4">
                                <img src="images/john_doe.jpg" class="rounded-circle shadow border float-left" alt="{{ $user->FullName() }}" width="40" height="40"> 
                                    <div class="tr-name-role flex-column ml-3">
                                        <div class="r-name">John Doe</div>
                                        <div class="r-role">Web Designer</div>
                                    </div>
                                </div>
                                <div class="title-scorecard-container">
                                    <div class="title-scc d-inline-flex justify-content-center align-items-center">
                                       <div class="mr-2">Scorecard</div>
                                       <a tabindex="0" class="popover-dismiss" role="button" data-toggle="popover" data-trigger="focus" title="Scorecard Overview" data-content="This is the overall status of your scorecard for the month of June"><i class="fa fa-question-circle"></i></a>
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
                                    95<sup>%</sup>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress bar, categories score, and total score -->
                <div class="row mt-1">
                    <div class="col-sm">
                        <div class="eachScore-container px-4 py-3">
                            <!-- Productivity score -->
                            <div class="progress">
                                <div class="progress-bar pb-color-sp" role="progressbar" style="width: 89%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Productivity: <span class="progress-score">89%</span></span></div>
                            </div>

                            <!-- Quality score -->
                            <div class="progress">
                                <div class="progress-bar pb-color-p" role="progressbar" style="width: 99.4%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Quality: <span class="progress-score">99.4%</span></span></div>
                            </div>

                            <!-- Churn score -->
                            <div class="progress">
                                <div class="progress-bar pb-color-f" role="progressbar" style="width: 70%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Churn: <span class="progress-score">70%</span></span></div>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="eachScore-container px-4 py-3">
                            <!-- Product Knowledge Test score -->
                            <div class="progress">
                                <div class="progress-bar pb-color-sp" role="progressbar" style="width: 85%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">PKT: <span class="progress-score">85%</span></span></div>
                            </div>

                            <!-- Attendance score -->
                            <div class="progress">
                                <div class="progress-bar pb-color-p" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Attendance: <span class="progress-score">100%</span></span></div>
                            </div>

                            <!-- Attendance score -->
                            <div class="progress">
                                <div class="progress-bar pb-color-bonus" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Bonus: <span class="progress-score">5%</span></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room for improvement section -->
        <div class="col-lg">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">Productivity Improvement</div>
                    <div class="dboard-othtext">for the month of june</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="row p-4">
                    <div class="col-sm">

                    <!-- Current, Target, and Deficit points starts here -->
                        <div class="points-container">

                            <!-- Current points -->
                                <div class="current-p">
                                    <span class="cp-span">Current Points</span>
                                    <input type="text" value="113.63" disabled>
                                </div>

                            <!-- Target points -->
                            <div class="target-p mt-1">
                                <span class="tp-span">Target Points</span>
                                <input type="text" value="152" disabled>
                            </div>

                            <!-- Deficit points -->
                            <div class="deficit-p mt-1">
                                <span class="dp-span">Deficit Points</span>
                                <input type="text" value="38.37" disabled>
                            </div>

                            <!-- Average -->
                            <div class="average-p% mt-1">
                                <span class="dp-span">Average</span>
                                <input type="text" value="5.165" disabled>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="days-container">
                            
                        <!-- Current points -->
                        <div class="current-p">
                                    <span class="cp-span">Current Days Passed</span>
                                    <input type="text" value="22" disabled>
                                </div>

                            <!-- Target points -->
                            <div class="target-p mt-1">
                                <span class="tp-span">Current Target/Day</span>
                                <input type="text" value="8">
                            </div>

                            <!-- Deficit points -->
                            <div class="deficit-p mt-1">
                                <span class="dp-span">Progress</span>
                                <input type="text" value="74.76%" disabled>
                            </div>

                        </div>
                    </div>
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
                    <div class="dboard-title">Pending Session</div>
                    <div class="dboard-othtext">Of Scorecard And/Or Coaching Session</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="table-responsive px-4 pt-0 pb-4">
                    <table class="table table-hover table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Session Type</th>
                            <th scope="col">Send By</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>03/05/2020</td>
                            <td>Mid Month Scorecard</td>
                            <td>{{ $user->FullName() }}</td>
                            <td>
                                <span id="btn-edit" class="action-btn-edit mr-2"><i class="fa fa-edit mr-2"></i>Start Adding Notes</span>
                            </td>
                        </tr>
                        <tr>
                            <td>03/05/2020</td>
                            <td>Coaching</td>
                            <td>{{ $user->FullName() }}</td>
                            <td>
                                <span id="btn-edit" class="action-btn-edit mr-2"><i class="fa fa-edit mr-2"></i>Start Adding Notes</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endif

@endsection