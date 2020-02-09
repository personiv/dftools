@extends('layouts.admin')

@section('admin-content')
<div class="content-title">Update Credential</div>
<form action="{{ action('AdminController@updateCredential') }}" method="post">
    {{ csrf_field() }}
    <label for="user-id">Username to be updated</label>
    <input class="form-control" type="text" id="user-id" name="user-id" required>
    <label for="user-pass">New password</label>
    <input class="form-control" type="password" placeholder="Leave blank for no changes"  id="user-pass" name="user-pass">
    <label for="user-first">First Name</label>
    <input class="form-control" type="text" placeholder="Leave blank for no changes" id="user-first" name="user-first">
    <label for="user-last">Last Name</label>
    <input class="form-control" type="text" placeholder="Leave blank for no changes" id="user-last" name="user-last">
    <label for="user-up">Reporting To</label>
    <select class="form-control" id="user-up" name="user-up" required>
            <option value="NONE" selected>No changes</option>
        @for($i = 0; $i < $leaders->count(); $i++)
            <option value="{{ $leaders[$i]->getAttribute('credential_user') }}">{{ $leaders[$i]->getAttribute('credential_first') . ' ' . $leaders[$i]->getAttribute('credential_last') }}</option>
        @endfor
    </select>
    <label for="user-type">Type</label>
    <select class="form-control" id="user-type" name="user-type">
        <option value="NONE" selected>No changes</option>
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