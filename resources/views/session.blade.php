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
    $fields = $data["fields"] ?? [];
    $signees = $data["signatures"] ?? [];
    $pendingLevel = $session->PendingLevel();
    $s = 0;
?>

@section('content')
<div class="container mb-4">
    <div class="row">
        <div class="col-4">
            <div><span class="font-weight-bold">Last Name:</span> {{ $agent->FirstName() }}</div>
            <div><span class="font-weight-bold">First Name:</span> {{ $agent->LastName() }}</div>
        </div>
        <div class="col-4">
            <div><span class="font-weight-bold">Status:</span> {{ $agent->Status() }}</div>
            <div><span class="font-weight-bold">Process:</span> {{ $agent->JobPosition() }}</div>
        </div>
        <div class="col-4">
            <div><span class="font-weight-bold">Proficiency:</span> {{ $agent->ProficiencyDetail() }}</div>
            <div><span class="font-weight-bold">Period Covered:</span> {{ $session->DateCreated()->format('Y-m-d') }}</div>
        </div>
    </div>
</div>
@if (!empty($scorecard))
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="scorecard" class="table table-bordered" style="visibility: hidden;">
                    <thead class="thead-dark">
                        <tr>
                            <th>Classification</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Goal</th>
                            <th>Weight</th>
                            <th>Actual</th>
                            <th>Overall</th>
                        </tr>
                    </thead>
                    <tbody>
                    @for ($i = 0; $i < count($scorecard); $i++)
                        <tr>
                            <td class="align-middle">{{ $scorecard[$i]['score_item_class'] }}</td>
                            <td class="align-middle">{{ $scorecard[$i]['score_item_name'] }}</td>
                            <td style="max-width: 350px;"><pre>{{ $scorecard[$i]['score_item_desc'] }}</pre></td>
                            <td class="align-middle">{{ $scorecard[$i]['score_item_goal'] }}</td>
                            <td class="align-middle">{{ $scorecard[$i]['score_item_weight'] }}%</td>
                            <td class="align-middle">{{ $scorecard[$i]['score_item_actual'] }}%</td>
                            <td class="align-middle">{{ $scorecard[$i]['score_item_overall'] }}%</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@foreach ($fields as $fieldName => $fieldProperties)
<?php
    $field_title = $fieldProperties["title"];
    $field_size = $fieldProperties["size"];
    $field_value = $fieldProperties["value"];
    $field_for = $fieldProperties["for"];
    $field_pending = $fieldProperties["pending"];
?>
<div class="container mt-4">
    <div class="row">
        <div class="col-{{ $field_size }}">
            <div class="card">
                <div class="card-header bg-dark text-white font-weight-bold">{{ $field_title }}</div>
                <div class="card-body">
                    @if ($field_for == $user->EmployeeID() && $field_pending == $pendingLevel)
                        <textarea form="session-form" class="session-field" id="session-{{ $fieldName }}" name="session-{{ $fieldName }}" required>{{ $field_value }}</textarea>
                    @else
                        <div class="session-field">{{ $field_value }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="container mt-5">
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