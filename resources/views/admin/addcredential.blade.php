@extends('layouts.admin')

@section('admin-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="content-title">Add Credential</div>
            <form action="{{ action('AdminController@addCredential') }}" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            {{ csrf_field() }}
                            <label for="user-id">Username</label>
                            <input class="form-control" type="text" id="user-id" name="user-id" required>
                            <label for="user-pass">Password</label>
                            <input class="form-control" type="password" id="user-pass" name="user-pass" required>
                            <label for="user-first">First Name</label>
                            <input class="form-control" type="text" id="user-first" name="user-first" required>
                            <label for="user-last">Last Name</label>
                            <input class="form-control" type="text" id="user-last" name="user-last" required>
                        </div>
                        <div class="col-6">
                            <label for="user-up">Reporting to</label>
                            <select class="form-control" id="user-up" name="user-up" required>
                                @for($i = 0; $i < $leaders->count(); $i++)
                                    <option value="{{ $leaders[$i]->getAttribute('credential_user') }}">{{ $leaders[$i]->getAttribute('credential_first') . ' ' . $leaders[$i]->getAttribute('credential_last') }}</option>
                                @endfor
                            </select>
                            <label for="user-type">Type</label>
                            <select class="form-control" id="user-type" name="user-type" required>
                                <option value="DESGN">Web Designer</option>
                                <option value="WML">Web Mods Line</option>
                                <option value="CUSTM">Senior Web Designer</option>
                                <option value="VQA">Voice Quality Assurance</option>
                                <option value="PR">Website Proofreader</option>
                                <option value="SPRVR">Supervisor</option>
                                <option value="MANGR">Operation Manager</option>
                                <option value="HEAD">Operation Head</option>
                            </select>
                            <label for="user-hire-date">Hire Date</label>
                            <input class="form-control" type="date" id="user-hire-date" name="user-hire-date" required>
                            <label for="user-status">Status</label>
                            <select class="form-control" id="user-status" name="user-status" required>
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