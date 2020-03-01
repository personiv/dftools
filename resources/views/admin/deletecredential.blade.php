@extends('layouts.admin')

@section('admin-content')
<div class="row">

    <!-- Here you can update existing credential -->
    <div class="col-lg">
        <div class="tb-container">
            <div class="base-text-wrapper px-4 pt-4 pb-3">
                <div class="content-title">Delete Credential</div>
                <div class="content-othtext"></div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="content-base-container">
                <form action="{{ action('AdminController@deleteCredential') }}" method="post">
                        <div class="row">
                        {{ csrf_field() }}
                            <div class="col">

                                <!-- Username / Employee ID to be deleted -->
                                <div class="line-container">
                                <label for="user-id">Username to be deleted</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="text" id="user-id" name="user-id" required pattern="^[a-zA-Z0-9]*$">
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