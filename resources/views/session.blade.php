@extends('layouts.app')
@section('title', 'DFTools — Session')
@section('sidebar', 'css/sidebar.css')
@section('css', 'css/session.css')
@section('js', 'js/session.js')

<?php
    $items = $data->getAttribute('session_data')["scoreitems"];
    $values = $data->getAttribute('session_data')["scorevalues"];
    $agentFullName = $agent->getAttribute('credential_first') . ' ' . $agent->getAttribute('credential_last');
    $supervisorFullName = $supervisor->getAttribute('credential_first') . ' ' . $supervisor->getAttribute('credential_last');
    $managerFullName = $manager->getAttribute('credential_first') . ' ' . $manager->getAttribute('credential_last');
    $headFullName = $head->getAttribute('credential_first') . ' ' . $head->getAttribute('credential_last');
    $role = $agent->getAttribute('credential_type');
    $type = $data->getAttribute('session_type');
    $mode = $data->getAttribute('session_mode');
    $date = $data->getAttribute('created_at');
?>

@section('content')
<div class="container mb-4">
    <div class="row">
        <div class="col-4">
            <div><span class="font-weight-bold">Last Name:</span> {{ $agent->getAttribute('credential_last') }}</div>
            <div><span class="font-weight-bold">First Name:</span> {{ $agent->getAttribute('credential_first') }}</div>
        </div>
        <div class="col-4">
            <div><span class="font-weight-bold">Status:</span> Regular</div>
            <div><span class="font-weight-bold">Process:</span> {{ $process }}</div>
        </div>
        <div class="col-4">
            <div><span class="font-weight-bold">Proficiency:</span> {{ $proficiency }}</div>
            <div><span class="font-weight-bold">Period Covered:</span> {{ $date->format('Y-m-d') }}</div>
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
        <div class="col-3">
            <div class="font-weight-bold">Agent:</div>
            <div class="mb-3">{{ $agentFullName }}</div>
            <div class="custom-control custom-checkbox mt-4">
                <input type="checkbox" class="custom-control-input" id="agent-sign">
                <label class="custom-control-label" for="agent-sign">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</label>
            </div>
        </div>
        <div class="col-3">
            <div class="font-weight-bold">Supervisor:</div>
            <div class="mb-3">{{ $supervisorFullName }}</div>
            <div class="custom-control custom-checkbox mt-4">
                <input type="checkbox" class="custom-control-input" id="supervisor-sign">
                <label class="custom-control-label" for="supervisor-sign">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</label>
            </div>
        </div>
        <div class="col-3">
            <div class="font-weight-bold">Operation Manager:</div>
            <div class="mb-3">{{ $managerFullName }}</div>
            <div class="custom-control custom-checkbox mt-4">
                <input type="checkbox" class="custom-control-input" id="manager-sign">
                <label class="custom-control-label" for="manager-sign">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</label>
            </div>
        </div>
        <div class="col-3">
            <div class="font-weight-bold">Operation Head:</div>
            <div class="mb-3">{{ $headFullName }}</div>
            <div class="custom-control custom-checkbox mt-4">
                <input type="checkbox" class="custom-control-input" id="head-sign">
                <label class="custom-control-label" for="head-sign">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</label>
            </div>
        </div>
    </div>
</div>
@endsection