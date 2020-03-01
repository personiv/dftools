@extends('layouts.admin')

@section('admin-content')
<div class="row">

    <!-- Here you can update existing credential -->
    <div class="col-lg">
        <div class="tb-container">
            <div class="base-text-wrapper px-4 pt-4 pb-3">
                <div class="content-title">Upload Actual Data</div>
                <div class="content-othtext"></div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="content-base-container">
                <form action="{{ action('AdminController@saveData') }}" method="post" enctype="multipart/form-data">
                        <div class="row">
                        {{ csrf_field() }}
                            <div class="col-12">
                                <div class="note-box">
                                    <div>
                                        <strong>Note:</strong> Data to be uploaded must be an Excel Workbook (<span class="badge badge-success">*.xls</span>, <span class="badge badge-success">*.xlsx</span>) file and also mustn't contain formula. To convert all formula to value, select and copy all cells then press (<code>Shift + F10 + V</code>).
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">

                                <!-- Year -->
                                <div class="line-container">
                                <label for="data-year">Year</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="number" id="data-year" name="data-year" required>
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                                <!-- Month -->
                                <div class="line-container">
                                <label for="data-month">Month</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <select class="form-control line-effect" id="data-month" name="data-month" required>
                                            <option value="JAN">January</option>
                                            <option value="FEB">February</option>
                                            <option value="MAR">March</option>
                                            <option value="APR">April</option>
                                            <option value="MAY">May</option>
                                            <option value="JUN">June</option>
                                            <option value="JUL">July</option>
                                            <option value="AUG">August</option>
                                            <option value="SEP">September</option>
                                            <option value="OCT">October</option>
                                            <option value="NOV">November</option>
                                            <option value="DEC">December</option>
                                        </select>
                                        <span class="focus-border">
                                        <i></i>
                                        </span>
                                    </div> <!-- input line animation end -->
                                </div>

                                <!-- Year -->
                                <div class="line-container">
                                <label for="data-src">Data</label>
                                    <div class="effect-container mt-1"> <!-- input line animation -->
                                        <input class="form-control line-effect" type="file" id="data-src" name="data-src" accept=".xls,.xlsx" required>
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