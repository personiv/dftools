@extends('layouts.app')
@section('title', 'Admin Control Panel')
@section('sidebar', 'css/sidebar.css')
@section('css', URL::asset('css/admin.css'))
@section('js', URL::asset('js/admin.js'))

@section('content')
<div class=" container-fluid">
    <div class="row">
        <div class="col">
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
@endsection