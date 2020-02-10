@extends('layouts.app')
@section('title', 'DFTools — Session')
@section('sidebar', 'css/sidebar.css')
@section('css', 'css/session.css')
@section('js', 'js/session.js')

@section('content')
{{ "Lead: " . $lead }}<br>
{{ "Agent: " . $agent }}<br>
{{ "Role: " . $role }}<br>
{{ "Type: " . $type }}<br>
{{ "Mode: " . $mode }}<br>
{{ "Week Number: " . $week }}
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
@for ($i = 0; $i < count($scoreitems); $i++)
    <tr>
        <td class="align-middle">{{ $scoreitems[$i]->getAttribute('score_item_class') }}</td>
        <td class="align-middle">{{ $scoreitems[$i]->getAttribute('score_item_name') }}</td>
        <td><pre>{{ $scoreitems[$i]->getAttribute('score_item_desc') }}</pre></td>
        <td class="align-middle">{{ $scoreitems[$i]->getAttribute('score_item_goal') }}</td>
        <td class="align-middle">{{ $scoreitems[$i]->getAttribute('score_item_weight') }}%</td>
        @if ($scorevalues != null)
            <td class="align-middle">{{ $scorevalues[$columnindex + 1][$i + 1] }}%</td>
            @if ($i == 0)
                <td class="align-middle" rowspan="{{ count($scoreitems) }}">{{ $scorevalues[$columnindex + 1][count($scoreitems) + 1] }}%</td>
            @endif
        @else
            <td class="align-middle">NaN</td>
            @if ($i == 0)
                <td class="align-middle" rowspan="{{ count($scoreitems) }}">NaN</td>
            @endif
        @endif
    </tr>
@endfor
</tbody>
</table>
</div>
@endsection