@extends('public.layouts.master')
@section('title', 'AControl - Главная')
@section('content')
<div>
    <div class="block time js-time">
        <span class="clock">
            <span class="hours">10</span>
            <span class="minutes">20</span>
            <span class="seconds">21</span>
        </span>
        <span class="date js-date d-none d-sm-inline-block">
            15 ноября 2019
        </span>
        <span class="date js-date-mobile d-sm-none">
            15 ноября 2019
        </span>
        <span class="week-type js-weektype" data-num="Числитель" data-denum="Знаменатель">
            Числитель
        </span>
    </div>
</div>
<div class="d-none js-sessions-templates">
    @include('public.pages.index.parts.session_long', [
        'id' => '#ID#',
        'createdDateTime' => '#CREATED#',
        'createdTimestamp' => '#CREATEDTIMESTAMP#',
        'creatorAutomated' => true,
        'usersCount' => '#USERSCOUNT#',
        'target' => '#TARGET#',
        'timeLeft' => '#TIMELEFT#',
    ])
    @include('public.pages.index.parts.session_short', [
        'id' => '#ID#',
        'createdDateTime' => '#CREATED#',
        'createdTimestamp' => '#CREATEDTIMESTAMP#',
        'creatorAutomated' => true,
        'usersCount' => '#USERSCOUNT#',
        'target' => '#TARGET#',
        'timeLeft' => '#TIMELEFT#',
    ])
</div>
<div class="sessions-list js-sessions-list">
    <!-- TODO:
    <div class="block search">
        <input type="submit" class="search-icon" value="">
        <input type="text" class="form-control form-control-lg" placeholder="Поиск...">
    </div> -->
    <div class="js-sessions-list-active {{ count($sessions_active) == 0 ? 'd-none' : '' }}">
        <div class="block sessions">
            <div class="block-title">
                Активные сеансы
            </div>
            <div class="block-body js-block-body">
                @foreach($sessions_active as $session)
                    @include('public.pages.index.parts.session_long', $session->toArray())
                @endforeach
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="js-sessions-list-await {{ count($sessions_await) == 0 ? 'd-none' : '' }}">
        <div class="block sessions">
            <div class="block-title">
                Сеансы в ожидании
            </div>
            <div class="block-body js-block-body">
                @foreach($sessions_await as $session)
                    @include('public.pages.index.parts.session_long', $session)
                @endforeach
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="js-sessions-list-closed {{ count($sessions_closed) == 0 ? 'd-none' : '' }}">
        <div class="block sessions">
            <div class="block-title">
                Прошедшие сеансы <!--<span class="blue">Ноябрь 2019</span>-->
            </div>
            <div class="block-body js-block-body">
                @foreach($sessions_closed as $session)
                    @include('public.pages.index.parts.session_short', $session)
                @endforeach
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- <div class="block loadmore no-selection"><img src="public/img/animation/loading_transparent.gif" class="js-loader d-none" alt=""> Загрузить еще...</div> -->
    <!-- <div class="end-of-page">Вы достигли конца страницы</div> -->
</div>
@endsection