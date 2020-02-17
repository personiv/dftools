@extends('layouts.admin')

@section('admin-content')
<div class="content-title">Upload Manual Data</div>
<div class="note-box">
<p class="mb-3"><span class="font-weight-bold">Note:</span> Data to be uploaded must follow a template. Download the template below:</p>
<a href="{{ route('downloadmanualtemplate') }}"><button class="btn btn-primary">Download Template</button></a>
</div>
<form action="{{ action('AdminController@saveManualData') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label for="data-year">Year</label>
    <input class="form-control" type="number" id="data-year" name="data-year" required>
    <label for="data-month">Month</label>
    <select class="form-control" id="data-month" name="data-month" required>
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
    <select class="form-control" id="data-team" name="data-team" required>
        @for($i = 0; $i < $supervisors->count(); $i++)
            <?php $supervisor = $supervisors[$i]; ?>
            <option value='{{ $supervisor->EmployeeID() }}'>{{ $supervisor->FirstName() }}</option>
        @endfor
    </select>
    <label for="data-src">Data</label>
    <input class="form-control" type="file" id="data-src" name="data-src" accept=".xls,.xlsx" required>
    <input type="submit" value="Submit" class="btn btn-success">
</form>
@endsection