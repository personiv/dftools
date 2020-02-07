@extends('layouts.admin')

@section('admin-content')
<div class="content-title">Upload Manual Data</div>
<form action="{{ action('AdminController@saveManualData') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label for="data-year">Year</label>
    <input class="form-control" type="number" name="data-year" required>
    <label for="data-month">Month</label>
    <select class="form-control" name="data-month" required>
        <option value="JAN">January</option>
        <option value="FEB">February</option>
        <option value="MAR">March</option>
        <option value="APR">April</option>
        <option value="MAY">May</option>
        <option value="JUN">June</option>
        <option value="JUL">July</option>
        <option value="AUG">August</option>
        <option value="SEP">September</option>
        <option value="OCT">October</option>
        <option value="NOV">November</option>
        <option value="DEC">December</option>
    </select>
    <label for="data-team">Team</label>
    <input class="form-control" type="text" name="data-team" required>
    <label for="data-src">Data</label>
    <input class="form-control" type="file" name="data-src" required>
    <input type="submit" value="Submit" class="btn btn-success">
</form>
@endsection