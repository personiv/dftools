@extends('layouts.admin')

@section('admin-content')
<div class="content-title">Delete Credential</div>
<form action="{{ action('AdminController@deleteCredential') }}" method="post">
    {{ csrf_field() }}
    <label for="user-id">Username to be deleted</label>
    <input class="form-control" type="text" id="user-id" name="user-id" required pattern="^[a-zA-Z0-9]*$">
    <input type="submit" value="Submit" class="btn btn-success">
</form>
@endsection