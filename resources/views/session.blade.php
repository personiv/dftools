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
    $signDates = $data["signDates"] ?? [];
    $altRoles = $data["altRoles"] ?? [];
    $pendingLevel = $session->PendingLevel();
    $s = 0;
?>

@section('bladescript')
<script type="text/javascript">
function updateFieldValue(e) {
    request("{{ action('HomeController@updateFieldValue') }}", JSON.stringify({
        fieldName: e.id.split('-')[1],
        fieldValue: e.value,
        sessionID: "{{ $session->SessionID() }}"
    }), null)
}
</script>
@endsection

@section('content')

<!-- Print section -->
<div class="container-fluid mb-5">
    <div class="row">
        <div class="col">
            <div class="session-type">
                <div class="coaching-styling">— Coaching Session</div>
                {{ $session->TypeDescription() }}
            </div>
        </div>
        <div class="col d-flex align-items-center">
            <div class="ml-auto">
                <a class="action-btn-print" href="{{ route('print', [$session->SessionID()]) }}" target="_blank"><i class="fa fa-print mr-2"></i><span>Print This Session</span></a>
            </div>
        </div>
    </div>
</div>

<!-- Resource's credential -->
<div class="container-fluid mb-1" style="color: var(--dark-color);">
    <div class="row field-container">

    <div class="col">
        <div class="fields-name">
            <span class="mr-2">Shift Date:</span> <!-- Field type -->
            <span>{{ $session->DateCreated()->format('Y-m-d') }}</span>
        </div>

        <div class="fields-name">
            <span class="mr-2">Time:</span> <!-- Field type -->
            <span>{{ $session->DateCreated()->format('h:i A') }}</span>
        </div>

        <div class="fields-name">
            <span class="mr-2">Venue:</span> <!-- Field type -->
            <span>Digital Fulfillment Production Area</span>
        </div>
    </div> 

    <div class="col">
        <div class="fields-name">
            <span class="mr-2">Facilitator:</span> <!-- Field type -->
            <span>{{ $agent->TeamLeader()->FullName() }} </span>
        </div>
        <div class="fields-name">
            <span class="mr-2">Participant/s:</span> <!-- Field type -->
            <span>{{ $agent->FullName() . " & " . $agent->TeamLeader()->FullName() }} </span>
        </div>
    </div>
    </div>
</div>

@if (!empty($scorecard))
<div class="container-fluid pt-4">
    <div class="row">
        <div class="col-lg">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">Strengths & Opportunities</div>
                <div class="card-body">
                    <div class="table-responsive session-container">
                        <table id="scorecard" class="table table-bordered" style="visibility: hidden;">
                            <thead class="thead-custom">
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
    </div>
</div>
@elseif (!empty($scorecardGoal))
<div class="container-fluid mb-4">
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

<div class="container-fluid pt-4">
    <div class="row">
@foreach ($fields as $fieldName => $fieldProperties)
    <?php
        $field_title = $fieldProperties["title"];
        $field_size = $fieldProperties["size"];
        $field_value = $fieldProperties["value"];
        if ($field_value == "") {
            if (old("session-${fieldName}") != null) {
                $field_value = old("session-${fieldName}");
            }
        }
        $field_for = $fieldProperties["for"];
        $field_pending = $fieldProperties["pending"];
        if (!array_key_exists("placeholder", $fieldProperties)) {
            $customPlaceholder = "placeholder='* Required'";
        } else {
            $field_placeholder = $fieldProperties['placeholder'];
            $customPlaceholder = "placeholder='$field_placeholder'";
        }
        if (!array_key_exists("height", $fieldProperties)) {
            $customHeight = "";
        } else {
            $customHeight = "style='height: " . $fieldProperties['height'] . "px;'";
        }
    ?>
        <div class="col-{{ $field_size }}">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">{{ $field_title }}</div>
                <div class="card-body">
                    @if ($field_for == $user->EmployeeID() && $field_pending == $pendingLevel)
                        @if (array_key_exists('instant', $fieldProperties) && $fieldProperties['instant'])
                            <textarea class="session-field" id="session-{{ $fieldName }}" onchange="updateFieldValue(this)" <?= $customHeight ?> <?= $customPlaceholder ?>>{{ $field_value }}</textarea>
                        @else
                            <textarea form="session-form" class="session-field" id="session-{{ $fieldName }}" name="session-{{ $fieldName }}" <?= $customHeight ?> <?= $customPlaceholder ?> required>{{ $field_value }}</textarea>
                        @endif
                    @else
                        <div class="session-field" <?= $customHeight ?>>{{ $field_value }}</div>
                    @endif
                </div>
                @if ($field_pending < $pendingLevel && $field_for != $user->EmployeeID() && $session->IsSignee($user->EmployeeID()) && !$session->IsSigned($user->EmployeeID()) && $session->SigneeLevel($field_for) < $session->SigneeLevel($user->EmployeeID()))
                    <form action="{{ action('HomeController@resetPending') }}" method="post">
                        <div class="card-footer">
                            {{ csrf_field() }}
                            <input type="hidden" name="session-id" value="{{ $session->SessionID() }}" required>
                            <input type="hidden" name="session-pending" value="{{ $field_pending }}" required>
                            <input type="hidden" name="session-field" value="{{ $fieldName }}" required>
                            <input type="submit" class="btn btn-danger" value="Reset">
                        </div>
                    </form>
                @endif
            </div>
        </div>
@endforeach
    </div>
</div>
<div class="container-fluid mt-5">
    <div class="row">
        @foreach ($signees as $employeeID => $signed)
<?php
            $employee = App\Credential::where("credential_user", $employeeID)->first();
            $altRole = empty($altRoles) == false ? $altRoles[$s] : null;
            $signeeRole = $altRole == null ? $employee->JobPosition() : $altRole;
?>
            <div class="col">
                <div class="signi-container">
                <div class="font-weight-bold" style="color: var(--dark-color);">{{ $signeeRole }}</div>
                <div class="mb-3" style="color: var(--dark-color);">{{ $employee->FullName() }}</div>
                @if ($employeeID == $user->EmployeeID())
                    @if ($pendingLevel == $s)
                        <form id="session-form" action="{{ action('HomeController@movePendingLevel') }}" method="post">
                            {{ csrf_field() }}
                            <div id="session-verify-trigger-wrapper" class="custom-control custom-checkbox mt-3">
                                <input type="checkbox" class="custom-control-input" id="session-verify-trigger" onclick="showVerify()">
                                <label class="custom-control-label" for="session-verify-trigger">{{ $session::SIGNEDVERBIAGE }}</label>
                            </div>
                            <div id="session-verify-wrapper" style="display: none;">
                                <div class="effect-container"> <!-- input line animation -->
                                    <input type="password" name="session-verify-password" class="line-effect form-control" id="session-verify-password" placeholder="Verify password" required>
                                    <span class="focus-border">
                                    <i></i>
                                    </span>
                                </div> <!-- input line animation end -->
                                <div>
                                    <input type="hidden" name="session-id" value="{{ $session->SessionID() }}" required>
                                    <input type="submit" class="signi-btn" value="Sign">
                                </div>
                            </div>
                        </form>
                    @elseif ($pendingLevel > $s)
                        <label>{{ $session::SIGNEDVERBIAGE }}</label>
                        <span class="sign-date-wrapper">Date Signed: {{ $signDates[$employeeID] }}</span>
                    @else
                        <label>{{ $session::PENDINGVERBIAGE }}</label>
                    @endif
                @elseif ($pendingLevel > $s)
                    <label>{{ $session::SIGNEDVERBIAGE }}</label>
                    <span class="sign-date-wrapper">Date Signed: {{ $signDates[$employeeID] }}</span>
                @else
                    <label>{{ $session::UNSIGNEDVERBIAGE }}</label>
                @endif
                </div>
            </div>
            <?php $s++ ?>
        @endforeach
    </div>
</div>
@endsection