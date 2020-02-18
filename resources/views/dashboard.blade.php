@extends('layouts.app')
@section('title', 'DFTools — Dashboard')
@section('sidebar', URL::asset('css/sidebar.css'))
@section('css', URL::asset('css/dashboard.css'))
@section('js', URL::asset('js/dashboard.js'))

@php
    $user = session("user");
    $userTeam = $user->TeamMembers();
    $coachingSummary = $user->CoachingSummaryThisWeek();
    $totalCoaching = $user->TotalOfCoachingSummaryThisWeek();
    $exceptions = $user->ExceptionsThisWeek();
    if ($userTeam->count()) {
        $stackRank = $user->TeamStackRank();
        $topResource = $stackRank[0];
        $topResourceProductivity = round($topResource["productivity"] * 100, 2);
        $topResourceQuality = round($topResource["quality"] * 100, 2);
        $topResourceChurn = round($topResource["churn"] * 100, 2);
        $topResourcePKT = round($topResource["pkt"] * 100, 2);
        $topResourceAttendance = round($topResource["attendance"] * 100, 2);
        $topResourceBonus = round($topResource["bonus"] * 100, 2);
    }
@endphp

@section('bladescript')
<script type="text/javascript">
    createCircle("ovTotal1", "#5cb85c", "#5cb85c", {{ count($coachingSummary['Completed']) }}, {{ $totalCoaching }});
    createCircle("ovTotal2", "#f0ad4e", "#f0ad4e", {{ count($coachingSummary['Pending']) }}, {{ $totalCoaching }});
    createCircle("ovTotal3", "#5bc0de", "#5bc0de", {{ $exceptions->count() }}, {{ $userTeam->count() }});
    @if ($userTeam->count())
        lazyFill("#pb-productivity", {{ $topResourceProductivity }});
        lazyFill("#pb-quality", {{ $topResourceQuality }});
        lazyFill("#pb-churn", {{ $topResourceChurn }});
        lazyFill("#pb-pkt", {{ $topResourcePKT }});
        lazyFill("#pb-attendance", {{ $topResourceAttendance }});
        lazyFill("#pb-bonus", {{ $topResourceBonus }});
    @endif
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
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($coachingSummary as $summaryStatus => $summaryItems)
                                @for ($i = 0; $i < count($summaryItems); $i++)
                                    <?php $summaryEmployeeID = $summaryItems[$i]["employeeID"]; ?>
                                    @if ($summaryStatus == "For Coaching")
                                        <tr>
                                            <td>{{ $summaryEmployeeID }}</td>
                                            <td>{{ $summaryItems[$i]["fullName"] }}</td>
                                            <td>{{ $summaryItems[$i]["jobPosition"] }}</td>
                                            <td>N/A</td>
                                            <td><span class="stats-for-coaching">For Coaching</span></td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <a data-toggle="modal" data-target="#exampleModalCenter" onclick="document.querySelector('#session-agent').value = '{{ $summaryEmployeeID }}';">
                                                    <span id="action-btn" class="action-btn-crsession"><i class="fa fa-file-text mr-2"></i>Create Session</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @elseif ($summaryStatus == "Pending")
                                        <tr>
                                            <td>{{ $summaryItems[$i]["employeeID"] }}</td>
                                            <td>{{ $summaryItems[$i]["fullName"] }}</td>
                                            <td>{{ $summaryItems[$i]["jobPosition"] }}</td>
                                            <td>{{ $summaryItems[$i]["sessionType"] }}</td>
                                            <td><span class="stats-pending">Pending</span></td>
                                            <td><a href="{{ route('session', [$summaryItems[$i]['sessionID']]) }}"><span id="action-btn" class="action-btn-rtsession">Confirm Session</span></a></td>
                                        </tr>
                                    @elseif ($summaryStatus == "Completed")
                                        <tr>
                                            <td>{{ $summaryItems[$i]["employeeID"] }}</td>
                                            <td>{{ $summaryItems[$i]["fullName"] }}</td>
                                            <td>{{ $summaryItems[$i]["jobPosition"] }}</td>
                                            <td>{{ $summaryItems[$i]["sessionType"] }}</td>
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
                        @foreach ($exceptions as $exception)
                            <?php $agent = App\Credential::GetCredential($exception->exception_agent) ?>
                            <tr>
                                <td>{{ $agent->EmployeeID() }}</td>
                                <td>{{ $agent->FullName() }}</td>
                                <td>{{ $agent->JobPosition() }}</td>
                                <td>{{ $exception->exception_reason }}</td>
                                <td>
                                    <span id="btn-edit" class="action-btn-edit mr-2"><i class="fa fa-edit mr-2"></i>Edit</span>
                                    <a href="{{ route('deleteexception', [$exception->exception_id]) }}"><span id="btn-delete" class="action-btn-delete"><i class="fa fa-trash mr-2"></i>Delete</span></a>
                                </td>
                            </tr>
                        @endforeach
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
                                        <div class="r-name">{{ $topResource["agent"]->FullName() }}</div>
                                        <div class="r-role">{{ $topResource["agent"]->JobPosition() }}</div>
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
                                    {{ round($topResource["overall"] * 100) }}<sup>%</sup>
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
                                <div id="pb-productivity" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Productivity: <span class="progress-score">{{ $topResourceProductivity }}%</span></span></div> 
                            </div>

                            <!-- Quality score -->
                            <div class="progress mt-1">
                                <div id="pb-quality" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Quality: <span class="progress-score">{{ $topResourceQuality }}%</span></span></div>
                            </div>

                            <!-- Churn score -->
                            <div class="progress mt-1">
                                <div id="pb-churn" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Churn: <span class="progress-score">{{ $topResourceChurn }}%</span></span></div>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="eachScore-container px-4 py-3">
                            <!-- Product Knowledge Test score -->
                            <div class="progress mt-1">
                                <div id="pb-pkt" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">PKT: <span class="progress-score">{{ $topResourcePKT }}%</span></span></div>
                            </div>

                            <!-- Attendance score -->
                            <div class="progress mt-1">
                                <div id="pb-attendance" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Attendance: <span class="progress-score">{{ $topResourceAttendance }}%</span></span></div>
                            </div>

                            <!-- Attendance score -->
                            <div class="progress mt-1">
                                <div id="pb-bonus" class="progress-bar pb-color-bonus" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span class="progress-title">Bonus: <span class="progress-score">{{ $topResourceBonus }}%</span></span></div>
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
                        @for ($i = 0; $i < 3; $i++)
                            @if ($i < count($stackRank))
                                <tr>
                                    <td>
                                    @if ($i == 0)
                                        <div class="tr-3 tr-topOne d-inline-flex justify-content-center align-items-center">
                                            <span class="mr-2">1</span>
                                            <i class="fas fa-trophy"></i>
                                        </div>
                                    @elseif ($i == 1)
                                        <div class="tr-3 tr-topTwo d-inline-flex justify-content-center align-items-center">
                                            <span class="mr-2">2</span>
                                            <i class="fas fa-medal"></i>
                                        </div>
                                    @elseif ($i == 2)
                                        <div class="tr-3 tr-topThree d-inline-flex justify-content-center align-items-center">
                                            <span class="mr-2">3</span>
                                            <i class="fas fa-award"></i>
                                        </div>
                                    @endif
                                    </td>
                                    <td>{{ $stackRank[$i]["agent"]->FullName() }}</td>
                                    <td>{{ $stackRank[$i]["agent"]->JobPosition() }}</td>
                                </tr>
                            @endif
                        @endfor
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
                                        <div class="r-name">{{ $user->FullName() }}</div>
                                        <div class="r-role">{{ $user->JobPosition() }}</div>
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

                        <!-- Current points and days, Average and Progress starts here -->
                        <div class="productivity-container pcon-1">

                            <!-- Current points -->
                            <div class="current-points">
                                <div>Current Points</div>
                                <input type="number" value="113.63" class="form-control" disabled>
                            </div>

                            <!-- Current days passed -->
                            <div class="days-passed mt-3">
                                <div>Days Passed</div>
                                <input type="number" value="22" class="form-control" disabled>
                            </div>

                            <!-- Average -->
                            <div class="average-points mt-3">
                                <div>Average</div>
                                <input type="number" value="5.165" class="form-control" disabled>
                            </div>

                            <!-- Progress -->
                            <div class="prog-total mt-3">
                                <div>Progress</div>
                                <input type="text" value="74.76%" class="form-control prog-f" disabled>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm">

                        <!-- Target and Deficit points and Current target/day starts here -->
                        <div class="productivity-container pcon-2">

                            <!-- Target points -->
                            <div class="target-points">
                                <div>Target Points</div>
                                <input type="number" value="152" class="form-control" disabled>
                            </div>

                            <!-- Deficit points -->
                            <div class="deficit-points mt-3">
                                <div>Deficit Points</div>
                                <input type="number" value="38.37" class="form-control" disabled>
                            </div>

                            <!-- Current target per day -->
                            <div class="target-pday mt-3">
                                <div>Target Per Day</div>
                                <input type="number" value="8" class="form-control">
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
                                <span id="btn-add-notes" class="action-btn-addNotes mr-2"><i class="fa fa-pencil-alt mr-2"></i>Start Adding Notes</span>
                            </td>
                        </tr>
                        <tr>
                            <td>03/05/2020</td>
                            <td>Coaching</td>
                            <td>{{ $user->FullName() }}</td>
                            <td>
                                <span id="btn-add-notes" class="action-btn-addNotes mr-2"><i class="fa fa-pencil-alt mr-2"></i>Start Adding Notes</span>
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