@extends('layouts.app')
@section('title', 'DFTools — Session')
@section('sidebar', 'css/sidebar.css')
@section('css', 'css/session.css')
@section('js', 'js/session.js')

@section('content')
<span>Session Here</span><br>
{{ "Role: " . $role }}<br>
{{ "Type: " . $type }}<br>
{{ "Mode: " . $mode }}<br>
{{ "Agent: " . session('user') }}<br>
{{ "Week Number: " . $week }}
<table class="table table-bordered">
<thead class="thead-dark">
    <tr>
        <th>Column 1</th>
        <th>Column 2</th>
        <th>Column 3</th>
        <th>Column 4</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>Value 1</td>
        <td>Value 2</td>
        <td>Value 3</td>
        <td>Value 4</td>
    </tr>
</tbody>
</table>
@endsection