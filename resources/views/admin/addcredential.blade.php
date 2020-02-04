@extends('layouts.admin')

@section('admin-content')
<div class="content-title">Add Credential</div>
<form action="{{ action('AdminController@submitAddCredential') }}" method="post">
    {{ csrf_field() }}
    <label for="user-id">Username</label>
    <input type="text" name="user-id" required>
    <label for="user-pass">Password</label>
    <input type="password" name="user-pass" required>
    <label for="user-pass">Type</label>
    <select name="user-type">
        <option value="RSRCS" selected>Resource</option>
        <option value="SPRVR">Supervisor</option>
        <option value="MANGR">Manager</option>
        <option value="OHEAD">Head</option>
    </select>
    <input type="submit" value="Submit" class="btn btn-success">
</form>
@endsection