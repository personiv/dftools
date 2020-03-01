@extends('layouts.admin')

@section('admin-content')
<div class="row">

    <!-- Here you can update existing credential -->
    <div class="col-lg">
        <div class="tb-container">
            <div class="base-text-wrapper px-4 pt-4 pb-3">
                <div class="content-title">Update Credential</div>
                <div class="content-othtext"></div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="content-base-container">
                <form action="{{ action('AdminController@updateCredential') }}" method="post" enctype="multipart/form-data">
                        <div class="row">
                        {{ csrf_field() }}
                            <div class="col">
                                <!-- Username / Employee ID to be updated -->
                                <div class="line-container">
                                <label for="user-id">Username to be updated</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="text" id="user-id" name="user-id" required pattern="^[a-zA-Z0-9]*$">
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                                <!-- New Password -->
                                <div class="line-container">
                                <label for="user-pass">New password</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="password" placeholder="Leave blank for no changes"  id="user-pass" name="user-pass" pattern="^[a-zA-Z0-9]*$">
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                                <!-- First Name -->
                                <div class="line-container">
                                <label for="user-first">First Name</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="text" placeholder="Leave blank for no changes" id="user-first" name="user-first">
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                                <!-- Last Name -->
                                <div class="line-container">
                                <label for="user-last">Last Name</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="text" placeholder="Leave blank for no changes" id="user-last" name="user-last">
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                                <!-- Change photo -->
                                <div class="line-container">
                                <label for="user-img">Profile Picture (No changes if no file were selected)</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="file" id="user-img" name="user-img">
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
                                            <option value="NONE" selected>No changes</option>
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
                                            <option value="NONE" selected>No changes</option>
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
                                <label for="user-hire-date">Hire Date (No changes if no date were selected)</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="date" id="user-hire-date" name="user-hire-date">
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                                <!-- Satus -->
                                <div class="line-container">
                                <label for="user-status">Status</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <select class="form-control line-effect" id="user-status" name="user-status" required>
                                            <option value="NONE" selected>No changes</option>
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