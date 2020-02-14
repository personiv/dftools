@extends('layouts.app')
@section('title', 'DFTools — Session')
@section('sidebar', URL::asset('css/sidebar.css'))
@section('css', URL::asset('css/session.css'))
@section('js', URL::asset('js/session.js'))

<?php
    $data = $session->CompatibleData();
    $items = $data["items"];
    $values = $data["values"];
    $agent = $session->Agent();
    $supervisor = $agent->TeamLeader();
    $manager = $supervisor->TeamLeader();
    $head = $manager->TeamLeader();
    $signees = [$agent, $supervisor, $manager, $head];
    $pendingLevel = $session->PendingLevel();
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
@for ($i = 0; $i < count($items); $i++)
    <tr>
        <td class="align-middle">{{ $items[$i]['score_item_class'] }}</td>
        <td class="align-middle">{{ $items[$i]['score_item_name'] }}</td>
        <td style="max-width: 350px;"><pre>{{ $items[$i]['score_item_desc'] }}</pre></td>
        <td class="align-middle">{{ $items[$i]['score_item_goal'] }}</td>
        <td class="align-middle">{{ $items[$i]['score_item_weight'] }}%</td>
        @if (!empty($values))
            <td class="align-middle">{{ $values[$i + 1] }}%</td>
            @if ($i == 0)
                <td class="align-middle" rowspan="{{ count($items) }}">{{ $values[count($items) + 1] }}%</td>
            @endif
        @else
            <td class="align-middle">NaN</td>
            @if ($i == 0)
                <td class="align-middle" rowspan="{{ count($items) }}">NaN</td>
            @endif
        @endif
    </tr>
@endfor
</tbody>
</table>
</div>
<div class="container mt-4">
    <div class="row">
        @for ($i = 0; $i < count($signees); $i++)
            <div class="col-3">
                <div class="font-weight-bold">{{ $signees[$i]->JobPosition() }}</div>
                <div class="mb-3">{{ $signees[$i]->FullName() }}</div>
                @if ($signees[$i]->EmployeeID() == session("user"))
                    @if ($session->PendingLevel() == $i)
                        <form id="pending-form" action="{{ action('HomeController@movePendingLevel') }}" method="post">
                            {{ csrf_field() }}
                            <div class="custom-control custom-checkbox mt-4">
                                <input type="checkbox" class="custom-control-input" id="pending-signee" name="pending-signee" onclick="document.querySelector('#pending-form').submit()">
                                <label class="custom-control-label" for="pending-signee">{{ $session::SIGNVERBIAGE }}</label>
                            </div>
                            <input type="hidden" id="pending-sid" name="pending-sid" value="{{ $session->SessionID() }}">
                        </form>
                    @elseif ($session->PendingLevel() > $i)
                        <label>{{ $session::SIGNVERBIAGE }}</label>
                    @endif
                @elseif ($session->PendingLevel() > $i)
                    <label>{{ $session::SIGNVERBIAGE }}</label>
                @endif
            </div>
        @endfor
    </div>
</div>
@endsection