@extends('layouts.admin')

@section('admin-content')
<div class="content-title">Add Credential</div>
<form action="{{ action('AdminController@addCredential') }}" method="post">
    {{ csrf_field() }}
    <label for="user-id">Username</label>
    <input class="form-control" type="text" id="user-id" name="user-id" required>
    <label for="user-pass">Password</label>
    <input class="form-control" type="password" id="user-pass" name="user-pass" required>
    <label for="user-first">First Name</label>
    <input class="form-control" type="text" id="user-first" name="user-first" required>
    <label for="user-last">Last Name</label>
    <input class="form-control" type="text" id="user-last" name="user-last" required>
    <label for="user-up">Reporting to</label>
    <select class="form-control" id="user-up" name="user-up" required>
        @for($i = 0; $i < $leaders->count(); $i++)
            <option value="{{ $leaders[$i]->getAttribute('credential_user') }}">{{ $leaders[$i]->getAttribute('credential_first') . ' ' . $leaders[$i]->getAttribute('credential_last') }}</option>
        @endfor
    </select>
    <label for="user-type">Type</label>
    <select class="form-control" id="user-type" name="user-type" required>
        <option value="DESGN">Designer</option>
        <option value="WML">WML</option>
        <option value="CUSTM">Custom</option>
        <option value="VQA">VQA</option>
        <option value="PR">PR</option>
        <option value="SPRVR">Supervisor</option>
        <option value="MANGR">Manager</option>
        <option value="HEAD">Head</option>
    </select>
    <input type="submit" value="Submit" class="btn btn-success">
</form>
@endsection