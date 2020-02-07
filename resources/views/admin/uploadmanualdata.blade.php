@extends('layouts.admin')

@section('admin-content')
<div class="content-title">Upload Manual Data</div>
<form action="{{ action('AdminController@saveManualData') }}" method="post">
    {{ csrf_field() }}
    <label for="user-id">Year</label>
    <input class="form-control" type="text" name="data-year" required>
    <label for="user-pass">Month</label>
    <input class="form-control" type="text" name="data-month" required>
    <label for="user-pass">Team</label>
    <input class="form-control" type="text" name="data-month" required>
    <label for="user-pass">Data</label>
    <input class="form-control" type="file" name="data-src" required>
    <input type="submit" value="Submit" class="btn btn-success">
</form>
@endsection