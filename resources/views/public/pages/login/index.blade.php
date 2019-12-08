@extends('public.layouts.master')
@section('title', 'AControl - Вход')
@section('bodyclass', 'full-bg no-header-controls')
@section('mainclass', 'login')
@section('content')
<form method="POST" class="login-form">
    {{ csrf_field() }}
    <div class="login-wellcome">
        Добро пожаловать<!-- , <b>войдите пожалуйста</b> -->
    </div>
    <div class="login-body">
        <div>
            <label for="login-form-email">Email</label>
            <input type="text" name="email" class="form-control" id="login-form-email">
        </div>
        <div>
            <label for="login-form-password">Пароль</label>
            <input type="password" name="password" class="form-control" id="login-form-password">
        </div>
        <div>
            {!! app('captcha')->display([], ['lang' => 'ru']) !!}
        </div>
        <div>
            <input type="submit" class="mt-2 button w-100" value="Войти">
        </div>
        @foreach($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
        @endforeach
    </div>
</form>
@endsection