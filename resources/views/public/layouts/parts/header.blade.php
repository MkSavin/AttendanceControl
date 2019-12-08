<div class="float-left left">
    <div class="title"><a href="/">AControl</a></div>
    <div class="menu header-control">
        <a href="#" class="popup-toggle" popup-target=".user-list" popup-handler-after="popup-user-list-create">Пользователи</a>
        <a href="#" class="popup-toggle" popup-target=".group-list" popup-handler-after="popup-group-list-create">Группы</a>
    </div>
</div>
@if(isset($currentUser))
<div class="float-right right header-control">
    <div class="menu">
        <!-- <a href="#">Меню 3</a> -->
        <a href="#" class="button white short mr-3 popup-toggle" popup-target=".session-redeem">Использовать сеанс</a> 
        <a href="#" class="button white short popup-toggle" popup-target=".session-type">Создать сеанс</a>
    </div>
    <div class="user no-selection dd-toggle" dd-target=".dd-user">
        <div>{{ $currentUser->name_short }}</div>
        <span class="additional">{{ $currentUser->user_type->name }}</span>
    </div>
</div>
<div class="dd-hidden dd dd-user">
    <a href="#" class="popup-toggle" popup-target=".user-data" popup-handler-after="popup-user-data-create" popup-data="{{ $currentUser->id }}">Профиль</a>
    <!-- <a href="#">Пункт меню 2</a> -->
    <a href="/logout">Выйти</a>
</div>
@endif
<div class="clearfix"></div>