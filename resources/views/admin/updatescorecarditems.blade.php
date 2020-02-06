@extends('layouts.admin')

@section('admin-content')
<div class="content-title">Update Scorecard Items</div>
<form action="{{ action('AdminController@filterScoreItemByRole') }}" method="post">
    {{ csrf_field() }}
    <label for="item-role">Select Role</label>
    <select id="item-role" name="item-role">
        <option value="Designer" selected>Designer</option>
        <option value="WML">WML</option>
        <option value="Custom">Custom</option>
        <option value="VQA">VQA</option>
        <option value="PR">PR</option>
    </select>
    <input type="submit" value="Submit" class="btn btn-success">
</form>
@if (session("score-items") != null)
<table class="table table-hover table-striped">
  <thead>
    <tr>
      <th scope="col">Item</th>
      <th scope="col">Description</th>
      <th scope="col">Goal</th>
      <th scope="col">Weight (%)</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php $scoreItems = session("score-items") ?>
    @for ($i = 0; $i < $scoreItems->count(); $i++)
    <?php $cid = $scoreItems[$i]->score_item_id; ?>
      <tr>
        <td><input disabled type="text" class="item-cell" id="{{ $cid . '-score_item_name' }}" value="{{ $scoreItems[$i]->score_item_name }}"></td>
        <td><textarea disabled class="item-cell" id="{{ $cid . '-score_item_desc' }}">{{ $scoreItems[$i]->score_item_desc }}</textarea></td>
        <td><input disabled type="text" class="item-cell" id="{{ $cid . '-score_item_goal' }}" value="{{ $scoreItems[$i]->score_item_goal }}"></td>
        <td><input disabled type="number" class="item-cell" id="{{ $cid . '-score_item_weight' }}" value="{{ $scoreItems[$i]->score_item_weight }}" min="0" max="100"></td>
        <td><span class="btn btn-danger" onclick="deleteRow(this)"><i class="fa fa-trash"></i>Delete</span></td>
      </tr>
    @endfor
    <tr id="new-row">
      <td><input type="text" id="new-score-item-name"></td>
      <td><textarea class="input-desc" id="new-score-item-desc"></textarea></td>
      <td><input type="text" id="new-score-item-goal"></td>
      <td><input type="number" min="0" max="100" id="new-score-item-weight"></td>
      <td><span class="btn btn-success" onclick="addRow()"><i class="fa fa-plus"></i>Add</span></td>
    </tr>
  </tbody>
</table>
<span id="editBtn" class="btn btn-primary" onclick="toggleEdit()"><i class="fa fa-edit"></i>Edit Items</span>
@endif
@endsection