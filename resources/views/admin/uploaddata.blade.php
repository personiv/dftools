@extends('layouts.admin')

@section('admin-content')
<div class="content-title">Upload Actual Data</div>
<div class="note-box">
<p><span class="font-weight-bold">Note:</span> Data to be uploaded must be an Excel Workbook (*.xls, *.xlsx) file and also mustn't contain formula. To convert all formula to value, select all cells then press (Shift + F10 + V).</p>
</div>
<form action="{{ action('AdminController@saveData') }}" method="post" enctype="multipart/form-data">
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
    <label for="data-src">Data</label>
    <input class="form-control" type="file" id="data-src" name="data-src" accept=".xls,.xlsx" required>
    <input type="submit" value="Submit" class="btn btn-success">
</form>
@endsection