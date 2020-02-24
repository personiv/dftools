<?php
    $user = session("user");
    $agent = $session->Agent();
    $data = $session->Data();
    $scorecard = $data["scorecard"] ?? [];
    $scorecardGoal = $data["scorecardGoal"] ?? [];
    $fields = $data["fields"] ?? [];
    $signees = $data["signatures"] ?? [];
    $pendingLevel = $session->PendingLevel();
    $s = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="cache-control" content="private, max-age=0, no-cache, must-revalidate">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <title>Print Session</title>
    
    <!-- Global Style -->
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

    <!-- Page Style and Script -->
    <link rel="stylesheet" href="{{ URL::asset('css/print.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/session.css') }}">
    <script type="text/javascript" src="{{ URL::asset('js/session.js') }}"></script>
    
    <!-- Plugins -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-datepicker3.min.css') }}">
</head>
<body>

<!-- Document Header section -->
<div class="container-fluid">

    <!-- 1st row / Company logo and company tower with session form -->
    <div class="row">
        <div class="col d-flex justify-content-start align-items-center">
            <div class="comp-logo-container">
                <img class="company-logo" src="{{ URL::asset('images/personiv-logo.png') }}" alt="Personiv">
            </div>
        </div>
        <div class="col d-flex justify-content-end align-items-center">
            <div class="comp-tower-form">
                <div class="comp-df">
                    Digital Fulfillment Tower
                </div>
                <div class="comp-form">
                    Coaching Form
                </div>
            </div>
        </div>
    </div>

    <!-- 2nd row / Session type -->
    <div class="row">
        <div class="col">
            <div class="session-type-container d-flex justify-content-center">
                <div class="session-styling">
                    Coaching Session
                </div>
            </div>
        </div>
    </div>

    <!-- 3rd row / Field items -->
    <div class="row field-container">

        <div class="col">
            <div class="fields-name">
                <span class="mr-2">Shift Date:</span> <!-- Field type -->
                <span>{{ $session->DateCreated()->format('Y-m-d') }}</span>
            </div>

            <div class="fields-name">
                <span class="mr-2">Time:</span> <!-- Field type -->
                <span>{{ $session->DateCreated()->format('h:i A') }}</span>
            </div>

            <div class="fields-name">
                <span class="mr-2">Venue:</span> <!-- Field type -->
                <span>Digital Fulfillment Production Area</span>
            </div>
        </div> 

        <div class="col">
            <div class="fields-name">
                <span class="mr-2">Facilitator:</span> <!-- Field type -->
                <span></span>
            </div>
            <div class="fields-name">
                <span class="mr-2">Participant/s:</span> <!-- Field type -->
                <span>{{ $agent->FullName() . " & " . $agent->TeamLeader()->FullName() }} </span>
            </div>
        </div>
    </div>

</div>

<!-- Tables Section -->
@if (!empty($scorecard))
<div class="container-fluid mb-4">
    <div class="row">
        <div class="col-lg">
            <div class="table-responsive session-container">
                <table id="scorecard" class="table table-bordered" style="visibility: hidden;">
                    <thead class="thead-custom">
                        <tr>
                            <th scope="col">Measure Classification</th>
                            <th scope="col">Item</th>
                            <th scope="col">Description</th>
                            <th scope="col">Goal</th>
                            <th scope="col">Weight</th>
                            <th scope="col">Actual</th>
                            <th scope="col">Overall Score</th>
                        </tr>
                    </thead>
                    <tbody>
                    @for ($i = 0; $i < count($scorecard); $i++)
                        <tr>
                            <td>{{ $scorecard[$i]['score_item_class'] }}</td>
                            <td>{{ $scorecard[$i]['score_item_name'] }}</td>
                            <td>{{ $scorecard[$i]['score_item_desc'] }}</td>
                            <td>{{ $scorecard[$i]['score_item_goal'] }}</td>
                            <td>{{ $scorecard[$i]['score_item_weight'] }}%</td>
                            <td>{{ $scorecard[$i]['score_item_actual'] }}%</td>
                            <td>{{ $scorecard[$i]['score_item_overall'] }}%</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@elseif (!empty($scorecardGoal))
<div class="container-fluid mb-4">
    <div class="row">
        <div class="col-lg">
            <div class="table-responsive session-container">
                <table id="scorecard" class="table table-bordered" style="visibility: hidden;">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Measure Classification</th>
                            <th scope="col">Item</th>
                            <th scope="col">Description</th>
                            <th scope="col">Goal</th>
                            <th scope="col">Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                    @for ($i = 0; $i < count($scorecardGoal); $i++)
                        <tr>
                            <td>{{ $scorecardGoal[$i]['score_item_class'] }}</td>
                            <td>{{ $scorecardGoal[$i]['score_item_name'] }}</td>
                            <td>{{ $scorecardGoal[$i]['score_item_desc'] }}</td>
                            <td>{{ $scorecardGoal[$i]['score_item_goal'] }}</td>
                            <td>{{ $scorecardGoal[$i]['score_item_weight'] }}%</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Additional Table Section -->
@if (!empty($scorecard) || !empty($scorecardGoal))
<div class="container-fluid mb-4">
    <div class="row">
        <div class="col">

        <!-- For 1st Assistant bonus score -->
            <div class="extra-score-wrapper">
                <div class="extra-heading">Adming Task Assignment (For 1st Assistant Only)</div>
                <div class="table-responsive session-tiering-container">
                    <table class="table table-bordered">
                        <thead class="">
                            <tr>
                                <th scope="col">Actual</th>
                                <th scope="col">Percentage Equivalent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>4.01 to 5</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>3.01 to 4</td>
                                <td>80%</td>
                            </tr>
                            <tr>
                                <td>2.01 to 3</td>
                                <td>60%</td>
                            </tr>
                            <tr>
                                <td>1.01 to 2</td>
                                <td>40%</td>
                            </tr>
                            <tr>
                                <td>< 1</td>
                                <td>0%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="extra-footer">* Agreed scoring for both OS and Designer</div>
            </div>
        </div>
        <div class="col">

            <!-- Churn Tiering -->
            <div class="extra-score-wrapper">
                <div class="extra-heading">Design Churn Tiering</div>
                <div class="table-responsive session-tiering-container">
                    <table class="table table-bordered">
                        <thead class="">
                            <tr>
                                <th scope="col">Actual</th>
                                <th scope="col">Percentage Equivalent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0%-4.99%</td>
                                <td>100%</td>
                            </tr>
                            <tr>
                                <td>5%-14.99%</td>
                                <td>90%</td>
                            </tr>
                            <tr>
                                <td>15%-24.99%</td>
                                <td>80%</td>
                            </tr>
                            <tr>
                                <td>25%-29.99%</td>
                                <td>70%</td>
                            </tr>
                            <tr>
                                <td>> = 30% </td>
                                <td>0%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
        <div class="col"></div>
    </div>
</div>
@endif

<!-- Field Section -->
<div class="container-fluid mb-4">
    <div class="row">
@foreach ($fields as $fieldName => $fieldProperties)
    <?php
        $field_title = $fieldProperties["title"];
        $field_size = $fieldProperties["size"];
        $field_value = $fieldProperties["value"];
        $field_for = $fieldProperties["for"];
        $field_pending = $fieldProperties["pending"];
        if (!array_key_exists("height", $fieldProperties)) {
            $customHeight = "";
        } else {
            $field_height = $fieldProperties['height'];
            $customHeight = "style='height: " . $field_height . "px;'";
        }
    ?>
        <div class="col-{{ $field_size }}">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">{{ $field_title }}</div>
                <div class="card-body">
                    <div class="session-field" <?= $customHeight ?>>{{ $field_value }}</div>
                </div>
            </div>
        </div>
@endforeach
    </div>
</div>

<!-- Signee Section -->
<div class="container-fluid">
    <div class="row">
        @foreach ($signees as $employeeID => $signed)
            <?php $employee = App\Credential::where("credential_user", $employeeID)->first() ?>
            <div class="col">
                <div class="signi-container">
                <div class="font-weight-bold" style="color: var(--dark-color);">{{ $employee->JobPosition() }}</div>
                <div class="mb-3" style="color: var(--dark-color);">{{ $employee->FullName() }}</div>
                    @if ($signed)
                        <label>{{ $session::SIGNEDVERBIAGE }}</label>
                    @else
                        <label>{{ $session::UNSIGNEDVERBIAGE }}</label>
                    @endif
                </div>
            </div>
            <?php $s++ ?>
        @endforeach
    </div>
</div>

<!-- Plugins -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<!-- Global Script -->
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

</body>
</html>