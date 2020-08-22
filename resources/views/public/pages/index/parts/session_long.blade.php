<a href="#" class="session long popup-toggle js-session-long" popup-target=".session-data" popup-handler-after="popup-session-data-create" popup-data="{{ $id }}">
    <!-- <span class="session-hide"><img src="public/img/icons/close_white.svg" width="10" alt=""></span> -->
    <div class="float-left">
        <div class="body">
            <div class="users-count"><span class="count">{{ $usersCount }}</span> ч.</div>
            <div class="users-count-description">отметились</div>
        </div>
        @if($creatorAutomated)
        <div class="footer js-creator">
            <span class="creator">Расписание</span>
        </div>
        @endif
    </div>
    <div class="float-right information">
        <div class="info-block">
            <div class="info" data-timestamp="{{ $createdTimestamp }}">{{ isset($createdDateTime) ? $createdDateTime : "" }}</div>
            <div class="info-name">Дата создания</div>
        </div>
        <div class="info-block">
            <div class="info"><img src="public/img/icons/timer_little.svg" width="12" alt="" class="timer"> {{ $timeLeft }} </div>
            <div class="info-name js-timer-description" timer-active="Осталось" timer-await="Длительность">Осталось</div>
        </div>
        <div class="info-block">
            <div class="info">{{ $target }}</div>
            <div class="info-name">Цель / Группы</div>
        </div>
    </div>
</a>