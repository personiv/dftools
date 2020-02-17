@extends('layouts.app')
@section('title', 'DFTools — Session')
@section('sidebar', URL::asset('css/sidebar.css'))
@section('css', URL::asset('css/session.css'))
@section('js', URL::asset('js/session.js'))

<?php
    $user = session("user");
    $agent = $session->Agent();
    $data = $session->Data();
    $scorecard = $data["scorecard"] ?? [];
    $scorecardGoal = $data["scorecardGoal"] ?? [];
    $fields = $data["fields"] ?? [];
    $signees = $data["signatures"] ?? [];
    $pendingLevel = $session->PendingLevel();
    $s = 0;
?>

@section('content')

<!-- Resource's credential -->
<div class="container-fluid mb-4">
    <div class="row">
        <div class="col">
            <div><span class="font-weight-bold">Last Name:</span>&nbsp;&nbsp;{{ $agent->FirstName() }}</div>
            <div><span class="font-weight-bold">First Name:</span>&nbsp;&nbsp;{{ $agent->LastName() }}</div>
        </div>
        <div class="col">
            <div><span class="font-weight-bold">Status:</span>&nbsp;&nbsp;{{ $agent->Status() }}</div>
            <div><span class="font-weight-bold">Process:</span>&nbsp;&nbsp;{{ $agent->JobPosition() }}</div>
        </div>
        <div class="col">
            <div><span class="font-weight-bold">Proficiency:</span>&nbsp;&nbsp;{{ $agent->ProficiencyDetail() }}</div>
            <div><span class="font-weight-bold">Period Covered:</span>&nbsp;&nbsp;{{ $session->DateCreated()->format('Y-m-d') }}</div>
        </div>
    </div>
</div>

@if (!empty($scorecard))
<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            <div class="table-responsive session-container">
                <table id="scorecard" class="table table-bordered" style="visibility: hidden;">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Measure Classification</th>
                            <th scope="col">Item</th>
                            <th scope="col">Description</th>
                            <th scope="col">Goal</th>
                            <th scope="col">Weight</th>
                            <th scope="col">Actual</th>
                            <th scope="col">Overall Score</th>
                        </tr>
                    </thead>
                    <tbody>
                    @for ($i = 0; $i < count($scorecard); $i++)
                        <tr>
                            <td>{{ $scorecard[$i]['score_item_class'] }}</td>
                            <td>{{ $scorecard[$i]['score_item_name'] }}</td>
                            <td>{{ $scorecard[$i]['score_item_desc'] }}</td>
                            <td>{{ $scorecard[$i]['score_item_goal'] }}</td>
                            <td>{{ $scorecard[$i]['score_item_weight'] }}%</td>
                            <td>{{ $scorecard[$i]['score_item_actual'] }}%</td>
                            <td>{{ $scorecard[$i]['score_item_overall'] }}%</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@elseif (!empty($scorecardGoal))
<div class="container-fluid">
    <div class="row">
        <div class="col-lg">
            <div class="table-responsive session-container">
                <table id="scorecard" class="table table-bordered" style="visibility: hidden;">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Measure Classification</th>
                            <th scope="col">Item</th>
                            <th scope="col">Description</th>
                            <th scope="col">Goal</th>
                            <th scope="col">Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                    @for ($i = 0; $i < count($scorecardGoal); $i++)
                        <tr>
                            <td>{{ $scorecardGoal[$i]['score_item_class'] }}</td>
                            <td>{{ $scorecardGoal[$i]['score_item_name'] }}</td>
                            <td>{{ $scorecardGoal[$i]['score_item_desc'] }}</td>
                            <td>{{ $scorecardGoal[$i]['score_item_goal'] }}</td>
                            <td>{{ $scorecardGoal[$i]['score_item_weight'] }}%</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Target, Score Tiering -->
<div class="container-fluid mb-4">
    <div class="row">
        <div class="col">

        <!-- For 1st Assistant bonus score -->
            <div class="extra-score-wrapper">
                <div class="extra-heading">Adming Task Assignment (For 1st Assistant Only)</div>
                <div class="table-responsive session-container">
                    <table class="table table-bordered">
                        <thead class="">
                            <tr>
                                <th scope="col">Actual</th>
                                <th scope="col">Percentage Equivalent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>4.01 to 5</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>3.01 to 4</td>
                                <td>80%</td>
                            </tr>
                            <tr>
                                <td>2.01 to 3</td>
                                <td>60%</td>
                            </tr>
                            <tr>
                                <td>1.01 to 2</td>
                                <td>40%</td>
                            </tr>
                            <tr>
                                <td>< 1</td>
                                <td>0%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="extra-footer">* Agreed scoring for both OS and Designer</div>
            </div>
        </div>
        <div class="col">

            <!-- Churn Tiering -->
            <div class="extra-score-wrapper">
                <div class="extra-heading">Design Churn Tiering</div>
                <div class="table-responsive session-container">
                    <table class="table table-bordered">
                        <thead class="">
                            <tr>
                                <th scope="col">Actual</th>
                                <th scope="col">Percentage Equivalent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0%-4.99%</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>5%-14.99%</td>
                                <td>90%</td>
                            </tr>
                            <tr>
                                <td>15%-24.99%</td>
                                <td>80%</td>
                            </tr>
                            <tr>
                                <td>25%-29.99%</td>
                                <td>70%</td>
                            </tr>
                            <tr>
                                <td>> = 30% </td>
                                <td>0%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="extra-footer">* Agreed scoring for both OS and Designer</div>
            </div> 
        </div>
        <div class="col"></div>
    </div>
</div>

@foreach ($fields as $fieldName => $fieldProperties)
<?php
    $field_title = $fieldProperties["title"];
    $field_size = $fieldProperties["size"];
    $field_value = $fieldProperties["value"];
    $field_for = $fieldProperties["for"];
    $field_pending = $fieldProperties["pending"];
?>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-{{ $field_size }}">
            <div class="card">
                <div class="card-header bg-dark text-white font-weight-bold">{{ $field_title }}</div>
                <div class="card-body">
                    @if ($field_for == $user->EmployeeID() && $field_pending == $pendingLevel)
                        <textarea form="session-form" class="session-field" id="session-{{ $fieldName }}" name="session-{{ $fieldName }}" required>{{ $field_value }}</textarea>
                    @else
                        <div class="session-field"><pre>{{ $field_value }}</pre></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="container-fluid mt-5">
    <div class="row">
        @foreach ($signees as $employeeID => $signed)
            <?php $employee = App\Credential::where("credential_user", $employeeID)->first() ?>
            <div class="col">
                <div class="font-weight-bold">{{ $employee->JobPosition() }}</div>
                <div class="mb-3">{{ $employee->FullName() }}</div>
                @if ($employeeID == $user->EmployeeID())
                    @if ($pendingLevel == $s)
                        <form id="session-form" action="{{ action('HomeController@movePendingLevel') }}" method="post">
                            {{ csrf_field() }}
                            <div id="session-verify-trigger-wrapper" class="custom-control custom-checkbox mt-4">
                                <input type="checkbox" class="custom-control-input" id="session-verify-trigger" onclick="showVerify()">
                                <label class="custom-control-label" for="session-verify-trigger">{{ $session::SIGNEDVERBIAGE }}</label>
                            </div>
                            <div id="session-verify-wrapper" style="display: none;">
                                <input type="password" name="session-verify-password" id="session-verify-password" placeholder="Verify password" required>
                                <input type="hidden" id="session-id" name="session-id" value="{{ $session->SessionID() }}" required>
                                <input type="submit" class="btn btn-primary" value="Sign">
                            </div>
                        </form>
                    @elseif ($pendingLevel > $s)
                        <label>{{ $session::SIGNEDVERBIAGE }}</label>
                    @else
                        <label>{{ $session::PENDINGVERBIAGE }}</label>
                    @endif
                @elseif ($pendingLevel > $s)
                    <label>{{ $session::SIGNEDVERBIAGE }}</label>
                @else
                    <label>{{ $session::UNSIGNEDVERBIAGE }}</label>
                @endif
            </div>
            <?php $s++ ?>
        @endforeach
    </div>
</div>
@endsection