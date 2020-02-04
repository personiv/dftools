@extends('layouts.admin')

@section('admin-content')
<div class="content-title">Delete Credential</div>
<form action="{{ action('AdminController@submitDeleteCredential') }}" method="post">
    {{ csrf_field() }}

    <label for="user-id">Username to be deleted</label>
    <input type="text" name="user-id" required>
    <input type="submit" value="Submit" class="btn btn-success">
</form>
@endsection