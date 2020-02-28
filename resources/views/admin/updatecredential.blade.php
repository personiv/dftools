@extends('layouts.admin')

@section('admin-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="content-title">Update Credential</div>
            <form action="{{ action('AdminController@updateCredential') }}" method="post" enctype="multipart/form-data">
                <div class="container">
                    <div class="row">
                    {{ csrf_field() }}
                        <div class="col-6">
                            <label for="user-id">Username to be updated</label>
                            <input class="form-control" type="text" id="user-id" name="user-id" required pattern="^[a-zA-Z0-9]*$">
                            <label for="user-pass">New password</label>
                            <input class="form-control" type="password" placeholder="Leave blank for no changes"  id="user-pass" name="user-pass" pattern="^[a-zA-Z0-9]*$">
                            <label for="user-first">First Name</label>
                            <input class="form-control" type="text" placeholder="Leave blank for no changes" id="user-first" name="user-first">
                            <label for="user-last">Last Name</label>
                            <input class="form-control" type="text" placeholder="Leave blank for no changes" id="user-last" name="user-last">
                            <label for="user-img">Profile Picture (No changes if no file were selected)</label>
                            <input class="form-control" type="file" id="user-img" name="user-img">
                        </div>
                        <div class="col-6">
                            <label for="user-up">Reporting to</label>
                            <select class="form-control" id="user-up" name="user-up" required>
                                <option value="NONE" selected>No changes</option>
                                @for($i = 0; $i < $leaders->count(); $i++)
                                    <option value="{{ $leaders[$i]->EmployeeID() }}">{{ $leaders[$i]->FullName() }}</option>
                                @endfor
                            </select>
                            <label for="user-type">Type</label>
                            <select class="form-control" id="user-type" name="user-type" required>
                                <option value="NONE" selected>No changes</option>
                                @for($i = 0; $i < $employeeTypes->count(); $i++)
                                    <option value="{{ $employeeTypes[$i]->Name() }}">{{ $employeeTypes[$i]->Description() }}</option>
                                @endfor
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