@extends('layouts.admin')

<?php
  $roles = App\Tag::AgentTypes();
?>

@section('bladescript')
<script type="text/javascript">
  @if (session("selected-role") != null)
    document.querySelector("#item-role").value = '{{ session("selected-role") }}';
  @endif
</script>
@endsection

@section('admin-content')
<div class="content-title">Update Scorecard Items</div>
<form action="{{ action('AdminController@filterScoreItemByRole') }}" method="post">
    {{ csrf_field() }}
    <label for="item-role">Select Role</label>
    <select class="form-control" id="item-role" name="item-role" onchange="this.form.submit()" required>
      <option value="NONE">Click to select</option>
      @foreach ($roles as $role)
        <option value="{{ $role->Name() }}">{{ $role->Description() }}</option>
      @endforeach
    </select>
</form>
@if (session("score-items") != null && session("selected-role") != "NONE")
<div class="table-responsive text-nowrap">
<table class="table table-hover table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col" class="w-15">Class</th>
      <th scope="col" class="w-15">Item</th>
      <th scope="col" class="w-40">Description</th>
      <th scope="col" class="w-10">Goal</th>
      <th scope="col" class="w-5">Weight (%)</th>
      <th scope="col" class="w-5">Title</th>
      <th scope="col" class="w-5">Cell Name</th>
      <th scope="col" class="w-5">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php $scoreItems = session("score-items") ?>
    @for ($i = 0; $i < $scoreItems->count(); $i++)
    <?php $cid = $scoreItems[$i]->score_item_id; ?>
      <tr>
      <td><input disabled type="text" class="form-control item-cell" id="{{ $cid . '-score_item_class' }}" value="{{ $scoreItems[$i]->score_item_class }}"></td>
        <td><input disabled type="text" class="form-control item-cell" id="{{ $cid . '-score_item_name' }}" value="{{ $scoreItems[$i]->score_item_name }}"></td>
        <td><textarea disabled class="form-control item-cell" id="{{ $cid . '-score_item_desc' }}">{{ $scoreItems[$i]->score_item_desc }}</textarea></td>
        <td><input disabled type="text" class="form-control item-cell" id="{{ $cid . '-score_item_goal' }}" value="{{ $scoreItems[$i]->score_item_goal }}"></td>
        <td><input disabled type="number" class="form-control item-cell" id="{{ $cid . '-score_item_weight' }}" value="{{ $scoreItems[$i]->score_item_weight }}" min="0" max="100"></td>
        <td><input disabled type="text" class="form-control item-cell" id="{{ $cid . '-score_item_title' }}" value="{{ $scoreItems[$i]->score_item_title }}"></td>
        <td><input disabled type="text" class="form-control item-cell" id="{{ $cid . '-score_item_cell' }}" value="{{ $scoreItems[$i]->score_item_cell }}"></td>
        <td><span class="btn btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash"></i>Delete</span></td>
      </tr>
    @endfor
    <tr id="new-row">
      <td><input class="form-control" type="text" id="new-score-item-class"></td>
      <td><input class="form-control" type="text" id="new-score-item-name"></td>
      <td><textarea class="input-desc form-control" id="new-score-item-desc"></textarea></td>
      <td><input class="form-control" type="text" id="new-score-item-goal"></td>
      <td><input class="form-control" type="number" min="0" max="100" id="new-score-item-weight"></td>
      <td><input class="form-control" type="text" id="new-score-item-title"></td>
      <td><input class="form-control" type="text" id="new-score-item-cell"></td>
      <td><span class="btn btn-success" onclick="addRow()"><i class="fa fa-plus"></i>Add</span></td>
    </tr>
  </tbody>
</table>
</div>
<span id="editBtn" class="btn btn-primary" onclick="toggleEdit()"><i class="fa fa-edit"></i>Edit Items</span>
@endif
@endsection