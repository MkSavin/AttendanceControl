@extends('public.layouts.master')
@section('title', 'AControl - Вход')
@section('bodyclass', 'full-bg')
@section('mainclass', 'notify')
@section('content')
<div class="center">
    @if(isset($success) && $success && isset($currentUser) && isset($session))
        <h1>Сеанс <b>успешно</b> использован!</h1>
        <div class="notify-description"><span class="blue">{{ $currentUser->name_short }}</span>,   <span class="blue">{{ $session['user']['name_short'] }}</span> благодарит Вас за посещение!</div>
        <!-- <a href="#" class="button js-window-close">Закрыть</a> -->
    @elseif(isset($error) && $error && isset($msg))
        <h1>Произошла ошибка!</h1>
        <div class="notify-description">{{ $msg }}</div>
        <!-- <a href="#" class="button js-window-close">Закрыть</a> -->
    @else
        <h1>Произошла ошибка!</h1>
        <div class="notify-description">При использовании сеанса произошла неожиданная ошибка</div>
        <!-- <a href="#" class="button js-window-close">Закрыть</a> -->
    @endif
</div>
@endsection