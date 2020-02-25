@extends('layouts.app')
@section('title', 'DFTools — Dashboard')
@section('sidebar', URL::asset('css/sidebar.css'))
@section('css', URL::asset('css/dashboard.css'))
@section('js', URL::asset('js/dashboard.js'))

@php
    $user = session("user");
    $userTeam = $user->TeamMembers();

    // Pending Session
    $mySessions = $user->MySessionsThisWeek();

    if ($user->AccountType() == "SPRVR") {
        $exceptions = $user->ExceptionsThisWeek();
        $coachingSummary = $user->CoachingSummaryThisWeek();
        $stackRank = $user->TeamStackRank();
        $topResource = $stackRank[0];
        $scoreItem = App\ScoreItem::where("score_item_role", $topResource["agent"]->AccountType())->get();
        $totalCoaching = $user->TotalOfCoachingSummaryThisWeek();
    } else if ($user->AccountType() == "MANGR" || $user->AccountType() == "HEAD") {
        $exceptionCount = 0;
        $agentCount = 0;
        foreach ($user->TeamMembers() as $leader) {
            $exceptionCount += $leader->ExceptionsThisWeek()->count();
            $agentCount += $leader->TeamMembers()->count();
        }
        $coachingSummary = array("Pending" => [], "Completed" => []);
        foreach ($user->SessionsThisWeek() as $weekSession) {
            if (!$weekSession->IsSigned($user->EmployeeID())) {
                array_push($coachingSummary["Pending"], $weekSession);
            } else {
                array_push($coachingSummary["Completed"], $weekSession);
            }
        }
        $totalCoaching = count($coachingSummary["Pending"]) + count($coachingSummary["Completed"]);
        $prefix = $user->AccountType() == "MANGR" ? "Team " : ($user->AccountType() == "HEAD" ? "Cluster " : "");
    } else {
        // Productivity Improvement
        $row = App\Session::GetRowData(date('Y'), date('M'), $user->EmployeeID(), 'B', "PRODUCTIVITY RAW");
        $productivityPoints = $row[App\Session::IndexOfCell('L')];
        $pointsPerDay = $row[App\Session::IndexOfCell('O')];
        $daysPassed = $row[App\Session::IndexOfCell('N')];
        $totalTarget = $row[App\Session::IndexOfCell('R')];
        $targetPerDay = $row[App\Session::IndexOfCell('P')];
        $deficitPoints = $totalTarget - $productivityPoints;

        // Pending Session
        $agentSummary = $user->ScorecardSummary();
        $scoreItem = App\ScoreItem::where("score_item_role", $agentSummary["agent"]->AccountType())->get();

        // Productivity Improvement
        $productivityScore = perc($agentSummary['data'][App\Session::IndexOfCell('W')]);
        $productivityProgressClass = $productivityScore < 80 ? "prog-f" : ($productivityScore >= 80 && $productivityScore < 90 ? "prog-sp" : "prog-p");
    }

    function perc($value) { return is_numeric($value) ? round($value * 100, 2) : 0; }
@endphp

@section('bladescript')
<script type="text/javascript">
    @if ($user->AccountType() == "SPRVR")
        createCircle("ovTotal1", "#5cb85c", "#5cb85c", {{ count($coachingSummary['Completed']) }}, {{ $totalCoaching }});
        createCircle("ovTotal2", "#f0ad4e", "#f0ad4e", {{ count($coachingSummary['Pending']) }}, {{ $totalCoaching }});
        createCircle("ovTotal3", "#5bc0de", "#5bc0de", {{ $exceptions->count() }}, {{ $userTeam->count() }});
        @foreach ($scoreItem as $item)
            @if ($item->getAttribute('score_item_title') != "Bonus")
                lazyFill("#pb-{{ strtolower(str_replace(' ', '-', $item->getAttribute('score_item_title'))) }}", {{ perc($topResource["data"][App\Session::IndexOfCell($item->getAttribute('score_item_cell'))]) }});
            @else
                lazyFillBonus("#pb-{{ strtolower(str_replace(' ', '-', $item->getAttribute('score_item_title'))) }}");
            @endif
        @endforeach
    @elseif ($user->AccountType() == "MANGR" || $user->AccountType() == "HEAD")
        createCircle("ovTotal1", "#5cb85c", "#5cb85c", {{ count($coachingSummary['Completed']) }}, {{ $totalCoaching }});
        createCircle("ovTotal2", "#f0ad4e", "#f0ad4e", {{ count($coachingSummary['Pending']) }}, {{ $totalCoaching }});
        createCircle("ovTotal3", "#5bc0de", "#5bc0de", {{ $exceptionCount }}, {{ $agentCount }});
    @else
        @foreach ($scoreItem as $item)
            @if ($item->getAttribute('score_item_title') != "Bonus")
                lazyFill("#pb-{{ strtolower(str_replace(' ', '-', $item->getAttribute('score_item_title'))) }}", {{ perc($agentSummary["data"][App\Session::IndexOfCell($item->getAttribute('score_item_cell'))]) }});
            @else
                lazyFillBonus("#pb-{{ strtolower(str_replace(' ', '-', $item->getAttribute('score_item_title'))) }}");
            @endif
        @endforeach
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
                    <div class="dboard-title">Team Summary</div>
                    <div class="dboard-othtext">of For Coaching, Pending and Completed</div>
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
                                            <td><a href="{{ route('session', [$summaryItems[$i]['sessionID']]) }}"><span id="action-btn" class="action-btn-psession"><i class="fa fa-check mr-2"></i>Confirm Session</span></a></td>
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

        <!-- Pending section -->
        <div class="col-lg">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">My Summary</div>
                    <div class="dboard-othtext">Of Triad Coaching</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="table-responsive px-4 pt-0 pb-4">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Type</th>
                            <th scope="col">Sent by</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($mySessions as $summaryStatus => $summaryItems)
                                @for ($i = 0; $i < count($summaryItems); $i++)
                                    @if ($summaryStatus == "Pending")
                                        <tr>
                                            <td>{{ $summaryItems[$i]["sessionDate"]->format('Y-m-d') }}</td>
                                            <td>{{ $summaryItems[$i]["sessionType"] }}</td>
                                            <td>{{ $summaryItems[$i]["sentBy"] }}</td>
                                            <td><span class="stats-pending">Pending</span></td>
                                            <td><a href="{{ route('session', [$summaryItems[$i]['sessionID']]) }}"><span id="action-btn" class="action-btn-psession"><i class="fa fa-check mr-2"></i>Confirm Session</span></a></td>
                                        </tr>
                                    @elseif ($summaryStatus == "Completed")
                                        <tr>
                                            <td>{{ $summaryItems[$i]["sessionDate"]->format('Y-m-d') }}</td>
                                            <td>{{ $summaryItems[$i]["sessionType"] }}</td>
                                            <td>{{ $summaryItems[$i]["sentBy"] }}</td>
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

    <!-- 4th row supervisor dashboard -->
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

    <!-- 5th row supervisor dashboard -->
    <div class="row mt-5">

        <!-- Top Resource section -->
        <div class="col-lg">
            <div class="tb-container pb-2">
                <div class="dboard-text  px-4 pt-4 pb-3">
                    <div class="dboard-title">Overall Top Resource</div>
                    <div class="dboard-othtext">for the month of {{ date('F') }}</div>
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
                                       <a tabindex="0" class="popover-dismiss" role="button" data-toggle="popover" data-trigger="focus" title="Scorecard Overview" data-content="This is the overall scorecard of the resource for the month of {{ date('F') }}"><i class="fa fa-question-circle"></i></a>
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
                                    {{ perc($topResource["data"][App\Session::IndexOfCell("AG")]) }}<sup>%</sup>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress bar, categories score, and total score -->
                <div class="row mt-1">
                    <div class="col-sm">
                        <div class="eachScore-container px-4 py-3">
                            @for ($i = 0; $i < $scoreItem->count() / 2; $i++)
                                <div class="progress mt-1">
                                    <div id="pb-{{ strtolower(str_replace(' ', '-', $scoreItem[$i]->getAttribute('score_item_title'))) }}" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                    <span class="progress-title">{{ $scoreItem[$i]->getAttribute('score_item_title') }}: <span class="progress-score">{{ perc($topResource["data"][App\Session::IndexOfCell($scoreItem[$i]->getAttribute('score_item_cell'))]) }}%</span></span></div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="eachScore-container px-4 py-3">
                            @for ($i = $scoreItem->count() / 2; $i < $scoreItem->count(); $i++)
                                <div class="progress mt-1">
                                    <div id="pb-{{ strtolower(str_replace(' ', '-', $scoreItem[$i]->getAttribute('score_item_title'))) }}" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                    <span class="progress-title">{{ $scoreItem[$i]->getAttribute('score_item_title') }}: <span class="progress-score">{{ perc($topResource["data"][App\Session::IndexOfCell($scoreItem[$i]->getAttribute('score_item_cell'))]) }}%</span></span></div>
                                </div>
                            @endfor
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
                    <div class="dboard-othtext">for the month of {{ date('F') }}</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="table-responsive px-4 pt-0 pb-4">
                    <table class="table table-borderless custom-tb-hover">
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

@elseif ($user->AccountType() == "MANGR" || $user->AccountType() == "HEAD")

    <!-- 1st row manager/head dashboard -->
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

    <!-- 2nd row manager/head dashboard -->
    <div class="row mt-5">

        <!-- Summary section -->
        <div class="col-lg">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">Summary</div>
                    <div class="dboard-othtext">of Pending and Completed</div>
                </div>
                <div class="dropdown-divider"></div>
                
                <!-- Nav tab item starts here -->
                <nav class="page-tab-container">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <?php $l = 0; ?>
                        @foreach ($userTeam as $leader)
                            @if ($l == 0)
                                <a class="nav-item nav-link active" id="nav-{{ strtolower($leader->FirstName()) }}-tab" data-toggle="tab" href="#nav-{{ strtolower($leader->FirstName()) }}" role="tab" aria-controls="nav-{{ strtolower($leader->FirstName()) }}" aria-selected="true">{{ $prefix . $leader->FirstName() }}</a>
                            @else
                                <a class="nav-item nav-link" id="nav-{{ strtolower($leader->FirstName()) }}-tab" data-toggle="tab" href="#nav-{{ strtolower($leader->FirstName()) }}" role="tab" aria-controls="nav-{{ strtolower($leader->FirstName()) }}" aria-selected="true">{{ $prefix . $leader->FirstName() }}</a>
                            @endif
                        <?php $l++; ?>
                        @endforeach
                                <!-- triad coaching button
                                <div class="excp-btn d-flex justify-content-end align-items-center ml-auto">
                                    <span id="triad-btn" class="triad-btn-view"><i class="fas fa-pager mr-2"></i>Triad Coaching Summary</span>
                                </div> -->
                    </div>
                </nav>

                <!-- Nav tab content starts here -->
                <div class="tab-content" id="nav-tabContent">
                    <?php $m = 0; ?>
                    @foreach ($userTeam as $leader)
                        @if ($m == 0)
                            <div class="tab-pane fade show active" id="nav-{{ strtolower($leader->FirstName()) }}" role="tabpanel" aria-labelledby="nav-{{ strtolower($leader->FirstName()) }}-tab">
                        @else
                            <div class="tab-pane fade" id="nav-{{ strtolower($leader->FirstName()) }}" role="tabpanel" aria-labelledby="nav-{{ strtolower($leader->FirstName()) }}-tab">
                        @endif
                        <div class="scrollbar scrollbar-primary">
                            <div class="table-responsive px-4 pt-0 pb-4">
                                <table class="table table-striped table-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col">Employee ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Type</th>
                                        @if ($user->AccountType() == "HEAD")
                                        <th scope="col">Sent by</th>
                                        @endif
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coachingSummary["Pending"] as $weekSession)
                                            @if ($weekSession->IsSignee($leader->EmployeeID()))
                                                <tr>
                                                    <td>{{ $weekSession->AgentID() }}</td>
                                                    <td>{{ $weekSession->Agent()->FullName() }}</td>
                                                    <td>{{ $weekSession->Agent()->JobPosition() }}</td>
                                                    <td>{{ $weekSession->TypeDescription() }}</td>
                                                    @if ($user->AccountType() == "HEAD")
                                                    <td>{{ $weekSession->Agent()->TeamLeader()->FullName() }}</td>
                                                    @endif
                                                    <td><span class="stats-pending">Pending</span></td>
                                                    <td><a href="{{ route('session', [$weekSession->SessionID()]) }}"><span id="action-btn" class="action-btn-psession"><i class="fa fa-check mr-2"></i>Confirm Session</span></a></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        @foreach ($coachingSummary["Completed"] as $weekSession)
                                            @if ($weekSession->IsSignee($leader->EmployeeID()))
                                                <tr>
                                                    <td>{{ $weekSession->AgentID() }}</td>
                                                    <td>{{ $weekSession->Agent()->FullName() }}</td>
                                                    <td>{{ $weekSession->Agent()->JobPosition() }}</td>
                                                    <td>{{ $weekSession->TypeDescription() }}</td>
                                                    @if ($user->AccountType() == "HEAD")
                                                    <td>{{ $weekSession->Agent()->TeamLeader()->FullName() }}</td>
                                                    @endif
                                                    <td><span class="stats-completed">Completed</span></td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- -->
                    </div>
                    <?php $m++; ?>
                    @endforeach

                </div>

            </div>
        </div>

    </div>

    <!-- 3rd row manager/head dashboard -->
    <div class="row mt-5">

        <!-- Triad coaching section -->
        <div class="col-lg">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">Summary</div>
                    <div class="dboard-othtext">of Pending and Completed</div>
                </div>
                <div class="dropdown-divider"></div>
                
                <!-- Nav tab item starts here -->
                <nav class="page-tab-container">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <?php $l = 0; ?>
                        @foreach ($userTeam as $leader)
                            @if ($l == 0)
                                <a class="nav-item nav-link active" id="nav-{{ strtolower($leader->FirstName()) }}-tab" data-toggle="tab" href="#nav-{{ strtolower($leader->FirstName()) }}" role="tab" aria-controls="nav-{{ strtolower($leader->FirstName()) }}" aria-selected="true">{{ $prefix . $leader->FirstName() }}</a>
                            @else
                                <a class="nav-item nav-link" id="nav-{{ strtolower($leader->FirstName()) }}-tab" data-toggle="tab" href="#nav-{{ strtolower($leader->FirstName()) }}" role="tab" aria-controls="nav-{{ strtolower($leader->FirstName()) }}" aria-selected="true">{{ $prefix . $leader->FirstName() }}</a>
                            @endif
                        <?php $l++; ?>
                        @endforeach
                                <!-- triad coaching button
                                <div class="excp-btn d-flex justify-content-end align-items-center ml-auto">
                                    <span id="triad-btn" class="triad-btn-view"><i class="fas fa-pager mr-2"></i>Triad Coaching Summary</span>
                                </div> -->
                    </div>
                </nav>

                <!-- Nav tab content starts here -->
                <div class="tab-content" id="nav-tabContent">
                    <?php $m = 0; ?>
                    @foreach ($userTeam as $leader)
                        @if ($m == 0)
                            <div class="tab-pane fade show active" id="nav-{{ strtolower($leader->FirstName()) }}" role="tabpanel" aria-labelledby="nav-{{ strtolower($leader->FirstName()) }}-tab">
                        @else
                            <div class="tab-pane fade" id="nav-{{ strtolower($leader->FirstName()) }}" role="tabpanel" aria-labelledby="nav-{{ strtolower($leader->FirstName()) }}-tab">
                        @endif
                            <div class="table-responsive px-4 pt-0 pb-4">
                                <table class="table table-striped table-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col">Employee ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Type</th>
                                        @if ($user->AccountType() == "HEAD")
                                        <th scope="col">Sent by</th>
                                        @endif
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coachingSummary["Pending"] as $weekSession)
                                            @if ($weekSession->IsSignee($leader->EmployeeID()))
                                                <tr>
                                                    <td>{{ $weekSession->AgentID() }}</td>
                                                    <td>{{ $weekSession->Agent()->FullName() }}</td>
                                                    <td>{{ $weekSession->Agent()->JobPosition() }}</td>
                                                    <td>{{ $weekSession->TypeDescription() }}</td>
                                                    @if ($user->AccountType() == "HEAD")
                                                    <td>{{ $weekSession->Agent()->TeamLeader()->FullName() }}</td>
                                                    @endif
                                                    <td><span class="stats-pending">Pending</span></td>
                                                    <td><a href="{{ route('session', [$weekSession->SessionID()]) }}"><span id="action-btn" class="action-btn-psession"><i class="fa fa-check mr-2"></i>Confirm Session</span></a></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        @foreach ($coachingSummary["Completed"] as $weekSession)
                                            @if ($weekSession->IsSignee($leader->EmployeeID()))
                                                <tr>
                                                    <td>{{ $weekSession->AgentID() }}</td>
                                                    <td>{{ $weekSession->Agent()->FullName() }}</td>
                                                    <td>{{ $weekSession->Agent()->JobPosition() }}</td>
                                                    <td>{{ $weekSession->TypeDescription() }}</td>
                                                    @if ($user->AccountType() == "HEAD")
                                                    <td>{{ $weekSession->Agent()->TeamLeader()->FullName() }}</td>
                                                    @endif
                                                    <td><span class="stats-completed">Completed</span></td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        <!-- -->
                    </div>
                    <?php $m++; ?>
                    @endforeach

                </div>

            </div>
        </div>

    </div>

    <!-- 3rd row manager/head dashboard -->
    <div class="row mt-5">

        <!-- Exception section -->
        <div class="col-lg">
            <div class="tb-container">
                <div class="dboard-text px-4 pt-4 pb-3">
                    <div class="dboard-title">Exception</div>
                    <div class="dboard-othtext">with valid reason</div>
                </div>
                <div class="dropdown-divider"></div>
                
                <!-- Nav tab item starts here -->
                <nav class="page-tab-container">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <?php $l = 0; ?>
                        @foreach ($userTeam as $leader)
                            @if ($l == 0)
                                <a class="nav-item nav-link active" id="nav-{{ strtolower($leader->FirstName()) }}-tab-except" data-toggle="tab" href="#nav-{{ strtolower($leader->FirstName()) }}-except" role="tab" aria-controls="nav-{{ strtolower($leader->FirstName()) }}" aria-selected="true">{{ $prefix . $leader->FirstName() }}</a>
                            @else
                                <a class="nav-item nav-link" id="nav-{{ strtolower($leader->FirstName()) }}-tab-except" data-toggle="tab" href="#nav-{{ strtolower($leader->FirstName()) }}-except" role="tab" aria-controls="nav-{{ strtolower($leader->FirstName()) }}-except" aria-selected="true">{{ $prefix . $leader->FirstName() }}</a>
                            @endif
                        <?php $l++; ?>
                        @endforeach
                    </div>
                </nav>

                <!-- Nav tab content starts here -->
                <div class="tab-content" id="nav-tabContent">
                    <?php $m = 0; ?>
                    @foreach ($userTeam as $leader)
                        @if ($m == 0)
                            <div class="tab-pane fade show active" id="nav-{{ strtolower($leader->FirstName()) }}-except" role="tabpanel" aria-labelledby="nav-{{ strtolower($leader->FirstName()) }}-tab-except">
                        @else
                            <div class="tab-pane fade" id="nav-{{ strtolower($leader->FirstName()) }}-except" role="tabpanel" aria-labelledby="nav-{{ strtolower($leader->FirstName()) }}-tab-except">
                        @endif
                        <div class="scrollbar scrollbar-primary">
                            <div class="table-responsive px-4 pt-0 pb-4">
                                <table class="table table-striped table-borderless">
                                    <thead>
                                    <tr>
                                        <th scope="col">Employee ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Reason</th>
                                        @if ($user->AccountType() == "HEAD")
                                            <th scope="col">Recorded by</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($leader->ExceptionsThisWeek() as $exception)
                                            <tr>
                                                <td>{{ $weekSession->AgentID() }}</td>
                                                <td>{{ $weekSession->Agent()->FullName() }}</td>
                                                <td>{{ $weekSession->Agent()->JobPosition() }}</td>
                                                <td>{{ $exception->exception_reason }}</td>
                                                @if ($user->AccountType() == "HEAD")
                                                    <td>{{ $weekSession->Agent()->TeamLeader()->FullName() }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- -->
                    </div>
                    <?php $m++; ?>
                    @endforeach

                </div>

            </div>
        </div>

    </div>


<!-- Agent Dashboard -->    
@else

    <!-- 1st row designer dashboard -->
    <div class="row">

        <!-- Resource Scorecard Status Section -->
        <div class="col-lg">
            <div class="tb-container pb-2">
                <div class="dboard-text  px-4 pt-4 pb-3">
                    <div class="dboard-title">My Scorecard Status</div>
                    <div class="dboard-othtext">for the month of {{ date('F') }}</div>
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
                                       <a tabindex="0" class="popover-dismiss" role="button" data-toggle="popover" data-trigger="focus" title="Scorecard Overview" data-content="This is the overall status of your scorecard for the month of {{ date('F') }}"><i class="fa fa-question-circle"></i></a>
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
                                    {{ perc($agentSummary["data"][App\Session::IndexOfCell("AG")]) }}<sup>%</sup>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress bar, categories score, and total score -->
                <div class="row mt-1">
                    <div class="col-sm">
                        <div class="eachScore-container px-4 py-3">
                            @for ($i = 0; $i < $scoreItem->count() / 2; $i++)
                                <div class="progress mt-1">
                                    <div id="pb-{{ strtolower(str_replace(' ', '-', $scoreItem[$i]->getAttribute('score_item_title'))) }}" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                    <span class="progress-title">{{ $scoreItem[$i]->getAttribute('score_item_title') }}: <span class="progress-score">{{ perc($agentSummary["data"][App\Session::IndexOfCell($scoreItem[$i]->getAttribute('score_item_cell'))]) }}%</span></span></div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="eachScore-container px-4 py-3">
                            @for ($i = $scoreItem->count() / 2; $i < $scoreItem->count(); $i++)
                                <div class="progress mt-1">
                                    <div id="pb-{{ strtolower(str_replace(' ', '-', $scoreItem[$i]->getAttribute('score_item_title'))) }}" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                                    <span class="progress-title">{{ $scoreItem[$i]->getAttribute('score_item_title') }}: <span class="progress-score">{{ perc($agentSummary["data"][App\Session::IndexOfCell($scoreItem[$i]->getAttribute('score_item_cell'))]) }}%</span></span></div>
                                </div>
                            @endfor
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
                    <div class="dboard-othtext">for the month of {{ date('F') }}</div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="row p-4">
                    <div class="col-sm">

                        <!-- Current points and days, Average and Progress starts here -->
                        <div class="productivity-container pcon-1">

                            <!-- Current points -->
                            <div class="current-points">
                                <div>Current Points</div>
                                <input id="sim-productivity" type="number" value="{{ $productivityPoints }}" class="form-control allowed" oninput="recalculateProductivity()">
                            </div>

                            <!-- Current days passed -->
                            <div class="days-passed mt-3">
                                <div>Days Passed</div>
                                <input id="sim-days" type="number" value="{{ round($daysPassed, 2) }}" class="form-control allowed" oninput="recalculateProductivity()">
                            </div>

                            <!-- Average -->
                            <div class="average-points mt-3">
                                <div>Average</div>
                                <input id="sim-average" type="number" value="{{ round($pointsPerDay, 2) }}" class="form-control not-allowed" disabled>
                            </div>

                            <!-- Progress -->
                            <div class="prog-total mt-3">
                                <div>Progress</div>
                                <input id="sim-progress" type="text" value="{{ $productivityScore }}%" class="form-control not-allowed {{ $productivityProgressClass }}" disabled>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm">

                        <!-- Target and Deficit points and Current target/day starts here -->
                        <div class="productivity-container pcon-2">

                            <!-- Target points -->
                            <div class="target-points">
                                <div>Target Points</div>
                                <input id="sim-total" type="number" value="{{ round($totalTarget, 2) }}" class="form-control not-allowed" disabled>
                            </div>

                            <!-- Deficit points -->
                            <div class="deficit-points mt-3">
                                <div>Deficit Points</div>
                                <input id="sim-deficit" type="number" value="{{ round($deficitPoints, 2) }}" class="form-control not-allowed" disabled>
                            </div>

                            <!-- Current target per day -->
                            <div class="target-pday mt-3">
                                <div>Target Per Day</div>
                                <input id="sim-goal" type="number" value="{{ round($targetPerDay, 2) }}" class="form-control allowed" oninput="recalculateProductivity()">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2nd row designer dashboard -->
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
                            <th scope="col">Sent By</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($mySessions as $summaryStatus => $summaryItems)
                            @for ($i = 0; $i < count($summaryItems); $i++)
                                @if ($summaryStatus == "Pending")
                                    <tr>
                                        <td>{{ $summaryItems[$i]["sessionDate"]->format('Y-m-d') }}</td>
                                        <td>{{ $summaryItems[$i]["sessionType"] }}</td>
                                        <td>{{ $summaryItems[$i]["sentBy"] }}</td>
                                        <td><span class="stats-pending">Pending</span></td>
                                        <td><a href="{{ route('session', [$summaryItems[$i]['sessionID']]) }}"><span id="action-btn" class="action-btn-psession"><i class="fa fa-check mr-2"></i>Confirm Session</span></a></td>
                                    </tr>
                                @elseif ($summaryStatus == "Completed")
                                    <tr>
                                        <td>{{ $summaryItems[$i]["sessionDate"]->format('Y-m-d') }}</td>
                                        <td>{{ $summaryItems[$i]["sessionType"] }}</td>
                                        <td>{{ $summaryItems[$i]["sentBy"] }}</td>
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

@endif

@endsection