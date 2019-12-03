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
        <span class="date js-date">
            15 ноября 2019
        </span>
        <span class="week-type js-weektype" data-num="Числитель" data-denum="Знаменатель">
            Числитель
        </span>
    </div>
</div>
<div class="sessions-list">
    <div class="block search">
        <input type="submit" class="search-icon" value="">
        <input type="text" class="form-control form-control-lg" placeholder="Поиск...">
    </div>
    <div>
        <div class="block sessions">
            <div class="block-title">
                Активные сеансы
            </div>
            <div class="block-body">
                <a href="#" class="session red short popup-toggle" popup-target=".session-data">
                    <span class="session-hide"><img src="public/img/icons/close_white.svg" width="10" alt=""></span>
                    <div class="header">
                        <div class="float-left">
                            <div class="date">Сегодня, 10:20</div>
                            <div class="creator">Расп.</div>
                        </div>
                        <div class="float-right time-timer"><img src="public/img/icons/timer_little.svg" width="12" alt="" class="timer"> 12 c</div>
                    </div>
                    <div class="body">
                        <div class="users-count"><span class="count">12</span> ч.</div>
                        <div class="users-count-description">отметились</div>
                        <div class="groups">ПРИ-117, ИСТ-117</div>
                    </div>
                </a>
                <a href="#" class="session long popup-toggle" popup-target=".session-data">
                    <span class="session-hide"><img src="public/img/icons/close_white.svg" width="10" alt=""></span>
                    <div class="float-left">
                        <div class="body">
                            <div class="users-count"><span class="count">12</span> ч.</div>
                            <div class="users-count-description">отметились</div>
                        </div>
                        <div class="footer">
                            <span class="creator">Расписание</span>
                        </div>
                    </div>
                    <div class="float-right information">
                        <div class="info-block">
                            <div class="info">Сегодня, 10:20</div>
                            <div class="info-name">Дата создания</div>
                        </div>
                        <div class="info-block">
                            <div class="info"><img src="public/img/icons/timer_little.svg" width="12" alt="" class="timer"> 12 c</div>
                            <div class="info-name">Осталось</div>
                        </div>
                        <div class="info-block">
                            <div class="info">ПРИ-117, ИСТ-117</div>
                            <div class="info-name">Цель / Группы</div>
                        </div>
                    </div>
                </a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div>
        <div class="block sessions">
            <div class="block-title">
                Прошедшие сеансы <span class="blue">Ноябрь 2019</span>
            </div>
            <div class="block-body">
                <a href="#" class="session red short popup-toggle" popup-target=".session-data">
                    <span class="session-hide"><img src="public/img/icons/close_white.svg" width="10" alt=""></span>
                    <div class="header">
                        <div class="float-left">
                            <div class="date">Сегодня, 10:20</div>
                            <div class="creator">Расп.</div>
                        </div>
                        <div class="float-right time-timer"><img src="public/img/icons/timer_little.svg" width="12" alt="" class="timer"> 12 c</div>
                    </div>
                    <div class="body">
                        <div class="users-count"><span class="count">12</span> ч.</div>
                        <div class="users-count-description">отметились</div>
                        <div class="groups">ПРИ-117, ИСТ-117</div>
                    </div>
                </a>
                <a href="#" class="session long popup-toggle" popup-target=".session-data">
                    <span class="session-hide"><img src="public/img/icons/close_white.svg" width="10" alt=""></span>
                    <div class="float-left">
                        <div class="body">
                            <div class="users-count"><span class="count">12</span> ч.</div>
                            <div class="users-count-description">отметились</div>
                        </div>
                        <div class="footer">
                            <span class="creator">Расписание</span>
                        </div>
                    </div>
                    <div class="float-right information">
                        <div class="info-block">
                            <div class="info">Сегодня, 10:20</div>
                            <div class="info-name">Дата создания</div>
                        </div>
                        <div class="info-block">
                            <div class="info"><img src="public/img/icons/timer_little.svg" width="12" alt="" class="timer"> 12 c</div>
                            <div class="info-name">Осталось</div>
                        </div>
                        <div class="info-block">
                            <div class="info">ПРИ-117, ИСТ-117</div>
                            <div class="info-name">Цель / Группы</div>
                        </div>
                    </div>
                </a>
                <a href="#" class="session long popup-toggle" popup-target=".session-data">
                    <span class="session-hide"><img src="public/img/icons/close_white.svg" width="10" alt=""></span>
                    <div class="float-left">
                        <div class="body">
                            <div class="users-count"><span class="count">12</span> ч.</div>
                            <div class="users-count-description">отметились</div>
                        </div>
                        <div class="footer">
                            <span class="creator">Расписание</span>
                        </div>
                    </div>
                    <div class="float-right information">
                        <div class="info-block">
                            <div class="info">Сегодня, 10:20</div>
                            <div class="info-name">Дата создания</div>
                        </div>
                        <div class="info-block">
                            <div class="info"><img src="public/img/icons/timer_little.svg" width="12" alt="" class="timer"> 12 c</div>
                            <div class="info-name">Осталось</div>
                        </div>
                        <div class="info-block">
                            <div class="info">ПРИ-117, ИСТ-117</div>
                            <div class="info-name">Цель / Группы</div>
                        </div>
                    </div>
                </a>
                <a href="#" class="session long popup-toggle" popup-target=".session-data">
                    <span class="session-hide"><img src="public/img/icons/close_white.svg" width="10" alt=""></span>
                    <div class="float-left">
                        <div class="body">
                            <div class="users-count"><span class="count">12</span> ч.</div>
                            <div class="users-count-description">отметились</div>
                        </div>
                        <div class="footer">
                            <span class="creator">Расписание</span>
                        </div>
                    </div>
                    <div class="float-right information">
                        <div class="info-block">
                            <div class="info">Сегодня, 10:20</div>
                            <div class="info-name">Дата создания</div>
                        </div>
                        <div class="info-block">
                            <div class="info"><img src="public/img/icons/timer_little.svg" width="12" alt="" class="timer"> 12 c</div>
                            <div class="info-name">Осталось</div>
                        </div>
                        <div class="info-block">
                            <div class="info">ПРИ-117, ИСТ-117</div>
                            <div class="info-name">Цель / Группы</div>
                        </div>
                    </div>
                </a>
                <a href="#" class="session long popup-toggle" popup-target=".session-data">
                    <span class="session-hide"><img src="public/img/icons/close_white.svg" width="10" alt=""></span>
                    <div class="float-left">
                        <div class="body">
                            <div class="users-count"><span class="count">12</span> ч.</div>
                            <div class="users-count-description">отметились</div>
                        </div>
                        <div class="footer">
                            <span class="creator">Расписание</span>
                        </div>
                    </div>
                    <div class="float-right information">
                        <div class="info-block">
                            <div class="info">Сегодня, 10:20</div>
                            <div class="info-name">Дата создания</div>
                        </div>
                        <div class="info-block">
                            <div class="info"><img src="public/img/icons/timer_little.svg" width="12" alt="" class="timer"> 12 c</div>
                            <div class="info-name">Осталось</div>
                        </div>
                        <div class="info-block">
                            <div class="info">ПРИ-117, ИСТ-117</div>
                            <div class="info-name">Цель / Группы</div>
                        </div>
                    </div>
                </a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="block loadmore no-selection"><img src="public/img/animation/loading_transparent.gif" class="js-loader d-none" alt=""> Загрузить еще...</div>
    <div class="end-of-page">Вы достигли конца страницы</div>
</div>
@endsection