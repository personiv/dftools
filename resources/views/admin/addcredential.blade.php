@extends('layouts.admin')

@section('admin-content')

<!-- Add credential page -->
<div class="row">

    <!-- Here you can add credential -->
    <div class="col-lg">
        <div class="tb-container">
            <div class="base-text-wrapper px-4 pt-4 pb-3">
                <div class="content-title">Add Credential</div>
                <div class="content-othtext"></div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="content-base-container">
                <form action="{{ action('AdminController@addCredential') }}" method="post">
                        <div class="row">
                            <div class="col">
                                {{ csrf_field() }}
                                <label for="user-id">Username</label>
                                <input class="form-control" type="text" id="user-id" name="user-id" required pattern="^[a-zA-Z0-9]*$">
                                <label for="user-pass">Password</label>
                                <input class="form-control" type="password" id="user-pass" name="user-pass" required pattern="^[a-zA-Z0-9]*$">
                                <label for="user-first">First Name</label>
                                <input class="form-control" type="text" id="user-first" name="user-first" required>
                                <label for="user-last">Last Name</label>
                                <input class="form-control" type="text" id="user-last" name="user-last" required>
                            </div>
                            <div class="col">
                                <label for="user-up">Reporting to</label>
                                <select class="form-control" id="user-up" name="user-up" required>
                                    @for($i = 0; $i < $leaders->count(); $i++)
                                        <option value="{{ $leaders[$i]->EmployeeID() }}">{{ $leaders[$i]->FullName() }}</option>
                                    @endfor
                                </select>
                                <label for="user-type">Type</label>
                                <select class="form-control" id="user-type" name="user-type" required>
                                    @for($i = 0; $i < $employeeTypes->count(); $i++)
                                        <option value="{{ $employeeTypes[$i]->Name() }}">{{ $employeeTypes[$i]->Description() }}</option>
                                    @endfor
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
                    <input type="submit" value="Submit" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>

</div>
@endsection