@extends('layouts.app')
@section('title', 'Admin Control')
@section('css', URL::asset('css/admin.css'))
@section('js', URL::asset('js/admin.js'))

@section('content')
<div class=" container-fluid admin-wrapper">
    <div class="row">
        <div class="col-md-4">
            <div id="title">Admin Control Panel</div>
            <div class="subtitle">Accounts</div>
            <ul>
                <li><a href="{{ route('addcredential') }}"><div class="btn btn-primary">Add Credential</div></a></li>
                <li><a href="{{ route('updatecredential') }}"><div class="btn btn-primary">Update Credential</div></a></li>
                <li><a href="{{ route('deletecredential') }}"><div class="btn btn-primary">Delete Credential</div></a></li>
            </ul>
            <div class="subtitle">Data</div>
            <ul>
                <li><a href="{{ route('uploaddata') }}"><div class="btn btn-primary">Upload Data</div></a></li>
                <li><a href="{{ route('uploadmanualdata') }}"><div class="btn btn-primary">Upload Manual Data</div></a></li>
            </ul>
            <div class="subtitle">Values</div>
            <ul>
                <li><a href="{{ route('updatescorecarditems') }}"><div class="btn btn-primary">Update Score Card Items</div></a></li>
            </ul>
        </div>
        <div class="col-md-8">
            <div id="admin-content" class="content">
                @yield('admin-content')
                @if (session('msg') != null)
                    @if (session('msg-mood') != null)
                        <div class="message-box good">{{ session('msg') }}</div>
                    @else
                        <div class="message-box">{{ session('msg') }}</div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection