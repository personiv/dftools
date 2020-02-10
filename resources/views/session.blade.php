@extends('layouts.app')
@section('title', 'DFTools — Session')
@section('sidebar', 'css/sidebar.css')
@section('css', 'css/session.css')
@section('js', 'js/session.js')

@section('content')
{{ "Role: " . $role }}<br>
{{ "Type: " . $type }}<br>
{{ "Mode: " . $mode }}<br>
{{ "Agent: " . session('user') }}<br>
{{ "Week Number: " . $week }}
<table id="scorecard" class="table table-bordered" style="visibility: hidden;">
<thead class="thead-dark">
    <tr>
        <th>Classification</th>
        <th>Item</th>
        <th>Description</th>
        <th>Goal</th>
        <th>Weight</th>
        <th>Actual</th>
    </tr>
</thead>
<tbody>
@for ($i = 0; $i < count($scoreitems); $i++)
    <tr>
        <td class="align-middle">{{ $scoreitems[$i]->getAttribute('score_item_class') }}</td>
        <td class="align-middle">{{ $scoreitems[$i]->getAttribute('score_item_name') }}</td>
        <td ><pre>{{ $scoreitems[$i]->getAttribute('score_item_desc') }}</pre></td>
        <td class="align-middle">{{ $scoreitems[$i]->getAttribute('score_item_goal') }}</td>
        <td class="align-middle">{{ $scoreitems[$i]->getAttribute('score_item_weight') }}%</td>
        <td></td>
    </tr>
@endfor
</tbody>
</table>
@endsection