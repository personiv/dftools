@extends('layouts.admin')

@section('admin-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="content-title">Update Credential</div>
            <form action="{{ action('AdminController@updateCredential') }}" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            {{ csrf_field() }}
                            <label for="user-id">Username to be updated</label>
                            <input class="form-control" type="text" id="user-id" name="user-id" required pattern="^[a-zA-Z0-9]*$">
                            <label for="user-pass">New password</label>
                            <input class="form-control" type="password" placeholder="Leave blank for no changes"  id="user-pass" name="user-pass" pattern="^[a-zA-Z0-9]*$">
                            <label for="user-first">First Name</label>
                            <input class="form-control" type="text" placeholder="Leave blank for no changes" id="user-first" name="user-first">
                            <label for="user-last">Last Name</label>
                            <input class="form-control" type="text" placeholder="Leave blank for no changes" id="user-last" name="user-last">
                        </div>
                        <div class="col-6">
                            <label for="user-up">Reporting to</label>
                            <select class="form-control" id="user-up" name="user-up" required>
                                <option value="NONE" selected>No changes</option>
                                @for($i = 0; $i < $leaders->count(); $i++)
                                    <option value="{{ $leaders[$i]->getAttribute('credential_user') }}">{{ $leaders[$i]->getAttribute('credential_first') . ' ' . $leaders[$i]->getAttribute('credential_last') }}</option>
                                @endfor
                            </select>
                            <label for="user-type">Type</label>
                            <select class="form-control" id="user-type" name="user-type" required>
                                <option value="NONE" selected>No changes</option>
                                <option value="DESGN">Web Designer</option>
                                <option value="WML">Web Mods Line</option>
                                <option value="CUSTM">Senior Web Designer</option>
                                <option value="VQA">Voice Quality Assurance</option>
                                <option value="PR">Website Proofreader</option>
                                <option value="SPRVR">Supervisor</option>
                                <option value="MANGR">Operation Manager</option>
                                <option value="HEAD">Operation Head</option>
                            </select>
                            <label for="user-hire-date">Hire Date (No changes if no date were selected)</label>
                            <input class="form-control" type="date" id="user-hire-date" name="user-hire-date">
                            <label for="user-status">Status</label>
                            <select class="form-control" id="user-status" name="user-status" required>
                                <option value="NONE" selected>No changes</option>
                                <option value="Regular">Regular</option>
                                <option value="Project-based">Project-based</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Submit" class="btn btn-success">
            </form>
        </div>
    </div>
</div>
@endsection