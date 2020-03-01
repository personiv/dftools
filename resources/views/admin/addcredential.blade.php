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
                        {{ csrf_field() }}
                            <div class="col">
                                
                                <!-- Username / Employee ID -->
                                <div class="line-container">
                                <label for="user-id">Username/Employee ID</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="text" id="user-id" name="user-id" required pattern="^[a-zA-Z0-9]*$">
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                                <!-- Password -->
                                <div class="line-container">
                                <label for="user-pass">Password</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="password" id="user-pass" name="user-pass" required pattern="^[a-zA-Z0-9]*$">
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                                <!-- First Name -->
                                <div class="line-container">
                                <label for="user-first">First Name</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="text" id="user-first" name="user-first" required>
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                                <!-- Last Name -->
                                <div class="line-container">
                                <label for="user-last">Last Name</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="text" id="user-last" name="user-last" required>
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                            </div>

                            <div class="col">

                                <!-- Reporting to -->
                                <div class="line-container">
                                <label for="user-up">Reporting to</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <select class="form-control line-effect" id="user-up" name="user-up" required>
                                        @for($i = 0; $i < $leaders->count(); $i++)
                                            <option value="{{ $leaders[$i]->EmployeeID() }}">{{ $leaders[$i]->FullName() }}</option>
                                        @endfor
                                        </select>
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>
                                
                                <!-- Type -->
                                <div class="line-container">
                                <label for="user-type">Type</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <select class="form-control line-effect" id="user-type" name="user-type" required>
                                        @for($i = 0; $i < $employeeTypes->count(); $i++)
                                            <option value="{{ $employeeTypes[$i]->Name() }}">{{ $employeeTypes[$i]->Description() }}</option>
                                        @endfor
                                        </select>
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                                <!-- Hire Date -->
                                <div class="line-container">
                                <label for="user-hire-date">Hire Date</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="date" id="user-hire-date" name="user-hire-date" required>
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                                <!-- Status -->
                                <div class="line-container">
                                <label for="user-status">Status</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <select class="form-control line-effect" id="user-status" name="user-status" required>
                                            <option value="Regular">Regular</option>
                                            <option value="Project-based">Project-based</option>
                                        </select>
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>
                                
                            </div>
                        </div>
                    <input type="submit" value="Submit" class="admin-btn-submit">
                </form>
            </div>
        </div>
    </div>

</div>
@endsection