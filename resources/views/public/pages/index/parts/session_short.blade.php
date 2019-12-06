<a href="#" class="session red short popup-toggle js-session-short" popup-target=".session-data" data-id="{{ $id }}">
    <span class="session-hide"><img src="public/img/icons/close_white.svg" width="10" alt=""></span>
    <div class="header">
        <div class="float-left">
            <div class="date" data-timestamp="{{ $createdTimestamp }}">{{ $created }}</div>
            @if($creatorAutomated)
            <div class="creator js-creator">Расп.</div>
            @endif
        </div>
        <div class="float-right time-timer"><img src="public/img/icons/timer_little.svg" width="12" alt="" class="timer"> {{ $timeLeft }} </div>
    </div>
    <div class="body">
        <div class="users-count"><span class="count">{{ $usersCount }}</span> ч.</div>
        <div class="users-count-description">отметились</div>
        <div class="groups">{{ $target }}</div>
    </div>
</a>