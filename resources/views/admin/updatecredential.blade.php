@extends('layouts.admin')

@section('admin-content')
<div class="content-title">Update Credential</div>
<form action="{{ action('AdminController@updateCredential') }}" method="post">
    {{ csrf_field() }}
    <label for="user-id">Username to be updated</label>
    <input class="form-control" type="text" name="user-id" required>
    <label for="user-pass">Updated password</label>
    <input class="form-control" type="password" placeholder="Leave blank for no changes" name="user-pass">
    <label for="user-pass">Type</label>
    <select class="form-control" name="user-type">
        <option value="RSRCS" selected>Resource</option>
        <option value="SPRVR">Supervisor</option>
        <option value="MANGR">Manager</option>
        <option value="OHEAD">Head</option>
    </select>
    <input type="submit" value="Submit" class="btn btn-success">
</form>
@endsection