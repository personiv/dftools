@extends('layouts.admin')

@section('admin-content')
<div class="content-title">Update Scorecard Items</div>
<form action="{{ action('AdminController@filterScoreItemByRole') }}" method="post">
    {{ csrf_field() }}
    <label for="item-role">Select Role</label>
    <select name="item-role">
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
      <th scope="col">Weight</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php $scoreItems = session("score-items") ?>
    @for ($i = 0; $i < $scoreItems->count(); $i++)
    <?php $cid = $scoreItems[$i]->score_item_id; ?>
      <tr>
        <td class="item-cell" id="{{ $cid . '-Name' }}">{{ $scoreItems[$i]->score_item_name }}</td>
        <td class="item-cell" id="{{ $cid . '-Description' }}">{{ $scoreItems[$i]->score_item_desc }}</td>
        <td class="item-cell" id="{{ $cid . '-Goal' }}">{{ $scoreItems[$i]->score_item_goal }}</td>
        <td class="item-cell" id="{{ $cid . '-Weight' }}">{{ $scoreItems[$i]->score_item_weight }}%</td>
        <td><span class="btn btn-danger" onclick="deleteRow(this)">Delete</span></td>
      </tr>
    @endfor
    <tr id="new-row">
      <td class="new-input"><input type="text" name="new-score-item-name" id="new-score-item-name"></td>
      <td class="new-input"><input type="text" name="new-score-item-desc" id="new-score-item-desc"></td>
      <td class="new-input"><input type="text" name="new-score-item-goal" id="new-score-item-goal"></td>
      <td class="new-input"><input type="text" name="new-score-item-weight" id="new-score-item-weight"></td>
      <td class="new-input"><span class="btn btn-success" onclick="addRow()">Add</span></td>
    </tr>
  </tbody>
</table>
<span id="editBtn" class="btn btn-primary" onclick="toggleEdit()">Edit Items</span>
@endif
@endsection