@extends('layouts.app')
@section('title', 'Login')
@section('css', URL::asset('css/index.css'))
@section('js', URL::asset('js/index.js'))

@section('content')
<div id="login-modal" class="container">
    <div class="row">
        <div id="login-modal-image" class="col-sm-12 col-md-6 col-lg-6"><div></div></div>
        <div id="login-modal-content" class="col-sm-12 col-md-6 col-lg-6">
            <h1>Webnotes</h1>
            @if (session("msg") != null)
                @if (session("msg-mood") != null)
                    <div class="{{ 'message-box ' . session('msg-mood') }}">
                @else
                    <div class="message-box">
                @endif
                    {{ session("msg") }}
                </div>
            @endif
            <form action="#" method="POST" autocomplete="off">
                {{ csrf_field() }}
                <label for="user-id">Username</label>
                <input type="text" name="user-id" id="user-id" required>
                <label for="user-pass">Password</label>
                <input type="password" name="user-pass" id="user-pass" required>
                <p id="login-modal-forgot"><a href="#">Forgot password?</a></p>
                <input type="submit" value="Login">
            </form>
            <p id="login-modal-new">New to Webnotes? <a href="#">Create new account</a></p>
        </div>
    </div>
</div>
@endsection