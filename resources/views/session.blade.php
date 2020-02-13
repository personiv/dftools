@extends('layouts.app')
@section('title', 'DFTools — Session')
@section('sidebar', 'css/sidebar.css')
@section('css', 'css/session.css')
@section('js', 'js/session.js')

<?php
    $data = $session->Data();
    $items = $data["items"];
    $values = $data["values"];
    $supervisor = $session->Agent()->TeamLeader();
    $manager = $supervisor->TeamLeader();
    $head = $manager->TeamLeader();
?>

@section('content')
<div class="container mb-4">
    <div class="row">
        <div class="col-4">
            <div><span class="font-weight-bold">Last Name:</span> {{ $session->Agent()->FirstName() }}</div>
            <div><span class="font-weight-bold">First Name:</span> {{ $session->Agent()->LastName() }}</div>
        </div>
        <div class="col-4">
            <div><span class="font-weight-bold">Status:</span> {{ $session->Agent()->Status() }}</div>
            <div><span class="font-weight-bold">Process:</span> {{ $session->Agent()->JobPosition() }}</div>
        </div>
        <div class="col-4">
            <div><span class="font-weight-bold">Proficiency:</span> {{ $session->Agent()->ProficiencyDetail() }}</div>
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
        <div class="col-3">
            <div class="font-weight-bold">Agent:</div>
            <div class="mb-3">{{ $session->Agent()->FullName() }}</div>
            <div class="custom-control custom-checkbox mt-4">
                <input type="checkbox" class="custom-control-input" id="agent-sign">
                <label class="custom-control-label" for="agent-sign">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</label>
            </div>
        </div>
        <div class="col-3">
            <div class="font-weight-bold">Supervisor:</div>
            <div class="mb-3">{{ $supervisor->FullName() }}</div>
            <div class="custom-control custom-checkbox mt-4">
                <input type="checkbox" class="custom-control-input" id="supervisor-sign">
                <label class="custom-control-label" for="supervisor-sign">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</label>
            </div>
        </div>
        <div class="col-3">
            <div class="font-weight-bold">Operation Manager:</div>
            <div class="mb-3">{{ $manager->FullName() }}</div>
            <div class="custom-control custom-checkbox mt-4">
                <input type="checkbox" class="custom-control-input" id="manager-sign">
                <label class="custom-control-label" for="manager-sign">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</label>
            </div>
        </div>
        <div class="col-3">
            <div class="font-weight-bold">Operation Head:</div>
            <div class="mb-3">{{ $head->FullName() }}</div>
            <div class="custom-control custom-checkbox mt-4">
                <input type="checkbox" class="custom-control-input" id="head-sign">
                <label class="custom-control-label" for="head-sign">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</label>
            </div>
        </div>
    </div>
</div>
@endsection