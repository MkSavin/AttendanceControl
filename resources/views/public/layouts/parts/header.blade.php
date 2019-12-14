<div class="float-left left">
    <div class="title"><a href="/">AControl</a></div>
    @if(isset($currentUser))
    <div class="menu header-control d-none d-sm-inline-block">
        <a href="#" class="popup-toggle" popup-target=".user-list" popup-handler-after="popup-user-list-create">Пользователи</a>
        <a href="#" class="popup-toggle" popup-target=".group-list" popup-handler-after="popup-group-list-create">Группы</a>
    </div>
    @endif
</div>
@if(isset($currentUser))
<div class="float-right right header-control d-none d-sm-inline-block">
    <div class="menu">
        <!-- <a href="#">Меню 3</a> -->
        @if($currentUser->hasRight('session.use'))
        <a href="#" class="button white short popup-toggle" popup-target=".session-redeem">Использовать сеанс</a>
        @endif
        @if($currentUser->hasRight('session.create'))
        <a href="#" class="button white short popup-toggle" popup-target=".session-type">Создать сеанс</a>
        @endif
    </div>
    <div class="user no-selection dd-toggle" dd-target=".dd-user">
        <div>{{ $currentUser->name_short }}</div>
        <span class="additional">{{ $currentUser->user_type->name }}</span>
    </div>
</div>
<div class="float-right right header-control d-sm-none">
    <a href="#" class="js-menu-popup-open button white short">Меню</a>
</div>
<div class="dd-hidden dd dd-user">
    <a href="#" class="popup-toggle" popup-target=".user-data" popup-handler-after="popup-user-data-create" popup-data="{{ $currentUser->id }}">Профиль</a>
    <!-- <a href="#">Пункт меню 2</a> -->
    <a href="/logout">Выйти</a>
</div>
@endif
<div class="menu-popup js-menu-popup d-sm-none d-none">
    <div class="title">
        <a href="/">AControl</a>
        <div class="float-right">
            <a href="#" class="menu-popup-close js-menu-popup-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="menu-popup-container">
        @if(isset($currentUser))
        <div class="header-control">
            <a href="#" class="popup-toggle" popup-target=".user-list" popup-handler-after="popup-user-list-create">Пользователи</a><br>
            <a href="#" class="popup-toggle" popup-target=".group-list" popup-handler-after="popup-group-list-create">Группы</a>
            @if($currentUser->hasRight('session.use'))
            <a href="#" class="popup-toggle" popup-target=".session-redeem">Использовать сеанс</a><br>
            @endif
            @if($currentUser->hasRight('session.create'))
            <a href="#" class="popup-toggle" popup-target=".session-type">Создать сеанс</a>
            @endif
        </div>
        <div class="user">
            <span>{{ $currentUser->name_short }}</span>
            <span class="additional blue">{{ $currentUser->user_type->name }}</span>
        </div>
        <div class="header-control">
            <a href="#" class="popup-toggle" popup-target=".user-data" popup-handler-after="popup-user-data-create" popup-data="{{ $currentUser->id }}">Профиль</a>
            <a href="/logout">Выйти</a>
        </div>
        @endif
    </div>
</div>
<div class="clearfix"></div>