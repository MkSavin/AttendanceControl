<div class="window session-type">
    <div class="header">
        <span class="float-left title">Выберите тип сеанса</span>
        <div class="float-right menu">
            <a href="#" class="overlay-more dd-toggle" dd-target=".dd-more"></a>
            <div class="dd-hidden dd dd-more">
                <a href="#" class="popup-toggle" popup-target=".loading">Popup: Загрузка</a>
                <a href="#" class="popup-toggle" popup-target=".text">Popup: Текст</a>
                <a href="#" class="popup-toggle" popup-target=".question-box">Popup: Вопрос</a>
            </div>
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <div class="popup-session-type no-selection">
            <a href="#" class="deffered popup-toggle" popup-target=".session-create" popup-handler-after="popup-session-create-timed">
                <div class="image"></div>
                <div class="title">
                    Отложенный сеанс
                </div>
                <div class="description">
                    Сеанс создается только после наступления момента активации
                </div>
            </a>
            <a href="#" class="momental popup-toggle" popup-target=".session-create" popup-handler-after="popup-session-create-momental">
                <div class="image"></div>
                <div class="title">
                    Моментальный сеанс
                </div>
                <div class="description">
                    Сеанс создается сразу после нажатия на кнопку <i>Создать сеанс</i>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="window session-create">
    <div class="header">
        <span class="float-left title">Создание <span class="d-none js-momental">моментального</span><span class="d-none js-timed">отложенного</span> сеанса</span>
        <div class="float-right menu">
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <form method="POST">
            <div class="input-line row">
                <div class="col-sm">
                    <label for="popup-session-create-user-type">1. Выберите тип пользователя</label>
                    <select data-live-search="true" name="k" class="form-control js-user-type" id="popup-session-create-user-type">
                        <option value="1" data-checkgroup="false" data-users-count="20" data-subtext="20 чел." selected default-selected>Спец. по кадрам</option>
                        <option value="2" data-checkgroup="false" data-users-count="120" data-subtext="120 чел.">Преподаватель</option>
                        <option value="3" data-checkgroup="true" data-users-count="1420" data-subtext="1420 чел.">Студент</option>
                    </select>
                </div>
                <div class="col-sm">
                    <label for="popup-session-create-user-group">2. Выберите группы пользователей</label>
                    <select data-live-search="true" name="n" multiple class="form-control js-user-group" id="popup-session-create-user-group">
                        <option value="1" data-users-count="20" data-subtext="20 чел.">ПРИ-117</option>
                        <option value="2" data-users-count="20" data-subtext="20 чел.">ИСТ-117</option>
                        <option value="3" data-users-count="20" data-subtext="20 чел.">ИСБ-117</option>
                    </select>
                </div>
            </div>
            <div class="input-line row">
                <div class="col-sm">
                    <label for="popup-session-create-active-time">3. Введите время активности</label>
                    <div class="row">
                        <div class="col-sm">
                            <input type="text" class="form-control js-active_time" id="popup-session-create-active-time" placeholder="20">
                        </div>
                        <div class="col-sm">
                            <select name="d" class="form-control js-active_time-pow" id="popup-session-create-active-time-pow">
                                <option value="1" selected default-selected>СЕК</option>
                                <option value="2">МИН</option>
                                <option value="3">ЧАС</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="warning">
                        <div class="title">Внимание!</div>
                        <div class="body">
                            Время активности напрямую влияет на результативную точность сеанса
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-line row js-nonmomental">
                <div class="col-sm">
                    <label for="popup-session-create-start-time">4. Введите дату начала активности</label>
                    <input type="text" class="form-control jq-datepicker js-active_at" data-timepicker="true" id="popup-session-create-start-time">
                </div>
                <div class="col-sm">
                    <div class="annotation">
                        <div class="title">Примечание!</div>
                        <div class="body">
                            В момент наступления активности, сеанс можно будет открыть из списка активных сеансов
                        </div>
                    </div>
                </div>
            </div>
            <div class="session-info">
                <div class="title">Информация о сеансе</div>
                <div class="row info-row">
                    <div class="col-sm row">
                        <div class="col-md-3 info-row-name">Запуск:</div>
                        <div class="col-md info-row-data"><span class="js-session-info-date-start">15 ноября 2019</span>, <span class="blue js-session-info-clock-start"><span class="hours">10</span>:<span class="minutes">21</span></span></div>
                    </div>
                    <div class="col-sm row">
                        <div class="col-md-3 info-row-name">Конец:</div>
                        <div class="col-md info-row-data"><span class="js-session-info-date-end">15 ноября 2019</span>, <span class="blue js-session-info-clock-end"><span class="hours">10</span>:<span class="minutes">22</span></span></div>
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-sm row">
                        <div class="col-md-3 info-row-name">Предп. нагрузка:</div>
                        <div class="col-md info-row-data"><span class="blue js-session-info-users-count">20</span> человек</div>
                    </div>
                </div>
                <div>
                    <a href="#" class="button float-right disabled popup-toggle js-session-create" popup-target=".session-data" popup-handler-after="popup-session-data">Создать сеанс</a>
                    <input type="reset" value="Очистить" class="button mr-3 white float-right">
                    <div class="clearfix"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="window session-data">
    <div class="header">
        <span class="float-left title">Сеанс <span class="blue js-session-data-status" data-await="В ожидании" data-active="Активен" data-notactive="Закрыт">Активен</span></span>
        <div class="float-right menu">
            <a href="#" class="overlay-more dd-toggle" dd-target=".dd-more"></a>
            <div class="dd-hidden dd dd-more">
                <a href="#">Удалить сеанс</a>
                <a href="#">Остановить сеанс</a>
                <a href="#">Изменить сеанс</a>
            </div>
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <div class="row">
            <div class="col-sm qr-code hidden no-selection">
                <div class="data">
                    <div class="unhide">Нажмите, чтобы показать</div>
                </div>
                <img src="public/img/qr/elerance.gif" width="100%" height="100%" alt="">
            </div>
            <div class="col-sm qr-data">
                <div class="row info-row">
                    <div class="col-md w-33 px-0 js-session-data-timed_only">
                        <label for="popup-session-data-clock-start">До старта</label><br>
                        <span class="blue clock js-session-data-clock-start" id="popup-session-data-clock-start">
                            <span class="hours">20</span><span class="minutes">31</span><span class="seconds">20</span>
                        </span>
                    </div>
                    <div class="col-md w-33 px-0">
                        <label for="popup-session-data-clock-end">До конца</label><br>
                        <span class="blue clock js-session-data-clock-end" id="popup-session-data-clock-end">
                            <span class="hours">20</span><span class="minutes">31</span><span class="seconds">20</span>
                        </span>
                    </div>
                    <div class="col-md w-33 px-0">
                        <label for="popup-session-data-users-count">Отметилось</label><br>
                        <div id="popup-session-data-users-count"><span class="blue js-session-data-users-count">1420</span></div>
                    </div>
                </div>
                <div class="noted-table ps">
                    <table>
                        <thead>
                            <tr>
                                <th>ВРЕМЯ</th>
                                <th>ФИО</th>
                                <th>ГРУППА</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>4 c.</td>
                                <td><a href="#" class="popup-toggle" popup-target=".user-data">Савин М.К</a></td>
                                <td><a href="#" class="popup-toggle" popup-target=".group-data">ПРИ-117</a></td>
                            </tr>
                            <tr>
                                <td>3 c.</td>
                                <td><a href="#" class="popup-toggle" popup-target=".user-data">Куппе Р.О</a></td>
                                <td><a href="#" class="popup-toggle" popup-target=".group-data">ПРИ-117</a></td>
                            </tr>
                            <tr>
                                <td>2 c.</td>
                                <td><a href="#" class="popup-toggle" popup-target=".user-data">Козловский А.Г</a></td>
                                <td><a href="#" class="popup-toggle" popup-target=".group-data">ИДБ-117</a></td>
                            </tr>
                            <tr>
                                <td>1 c.</td>
                                <td><a href="#" class="popup-toggle" popup-target=".user-data">Информационовский Е.К</a></td>
                                <td><a href="#" class="popup-toggle" popup-target=".group-data">ЖБ-117</a></td>
                            </tr>
                            <tr>
                                <td>1 c.</td>
                                <td><a href="#" class="popup-toggle" popup-target=".user-data">Уппе Р.О</a></td>
                                <td><a href="#" class="popup-toggle" popup-target=".group-data">ИРП-117</a></td>
                            </tr>
                            <tr>
                                <td>1 c.</td>
                                <td><a href="#" class="popup-toggle" popup-target=".user-data">Уппе Р.О</a></td>
                                <td><a href="#" class="popup-toggle" popup-target=".group-data">ИРП-117</a></td>
                            </tr>
                            <tr>
                                <td>1 c.</td>
                                <td><a href="#" class="popup-toggle" popup-target=".user-data">Уппе Р.О</a></td>
                                <td><a href="#" class="popup-toggle" popup-target=".group-data">ИРП-117</a></td>
                            </tr>
                            <tr>
                                <td>1 c.</td>
                                <td><a href="#" class="popup-toggle" popup-target=".user-data">Уппе Р.О</a></td>
                                <td><a href="#" class="popup-toggle" popup-target=".group-data">ИРП-117</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="session-buttons">
                    <a href="#" class="button float-right popup-toggle" popup-target=".session-users">Просмотреть всех</a>
                    <a href="#" class="button mr-3 white float-right popup-toggle icon icon-plus" popup-target=".session-users-add">Добавить</a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="window session-users">
    <div class="header">
        <span class="float-left title">Пользователи сеанса</span>
        <div class="float-right menu">
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body nopadding">
        <div class="header">
            <a href="#" class="button short white popup-toggle icon icon-back" popup-target=".session-data">Назад к сеансу</a>
            <a href="#" class="button short white float-right popup-toggle icon icon-plus" popup-target=".session-users-add">Добавить</a>
            <div class="clearfix"></div>
        </div>
        <div class="body">
            <div class="filters row">
                <div class="col-sm">
                    <label for="popup-session-users-user-group">Группы пользователей</label>
                    <select data-live-search="true" name="n" multiple class="form-control" id="popup-session-users-user-group">
                        <option value="1" data-subtext="20 чел.">ПРИ-117</option>
                        <option value="2" data-subtext="18 чел.">ИСТ-117</option>
                        <option value="3" data-subtext="20 чел.">ИСБ-117</option>
                        <option value="3" data-subtext="20 чел.">ИСБ-117</option>
                        <option value="3" data-subtext="20 чел.">ИСБ-117</option>
                        <option value="3" data-subtext="20 чел.">ИСБ-117</option>
                    </select>
                </div>
                <div class="col-sm">
                    <label for="popup-session-users-user-group">Поиск</label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="noted-table ps">
                <table>
                    <thead>
                        <tr>
                            <th>ДАТА И ВРЕМЯ</th>
                            <th>ФИО</th>
                            <th>ГРУППА</th>
                            <th width="120"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Сегодня, в <span class="blue">20:17<span class="sub">:20</span></span><span class="blue">-19 с.</span></td>
                            <td><a href="#" class="popup-toggle" popup-target=".user-data">Савин М.К</a></td>
                            <td><b><a href="#" class="popup-toggle" popup-target=".group-data">ПРИ-117</a></b></td>
                            <td><a href="#" class="button short red">Удалить</a></td>
                        </tr>
                        <tr>
                            <td>Сегодня, в <span class="blue">20:17<span class="sub">:21</span></span><span class="blue">-20 с.</span></td>
                            <td><a href="#" class="popup-toggle" popup-target=".user-data">Куппе Р.О</a></td>
                            <td><b><a href="#" class="popup-toggle" popup-target=".group-data">ПРИ-117</a></b></td>
                            <td><a href="#" class="button short red">Удалить</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="footer">
            <label class="mb-0">Пользователей в таблице: <span class="blue">20</span></label>
        </div>
    </div>
</div>
<div class="window session-users-add">
    <div class="header">
        <span class="float-left title">Добавить пользователей</span>
        <div class="float-right menu">
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body nopadding">
        <div class="header">
            <a href="#" class="button short white popup-toggle icon icon-back" popup-target=".session-data">Назад к сеансу</a>
            <div class="clearfix"></div>
        </div>
        <form method="POST">
            <div class="body">
                <div class="input-line row">
                    <div class="col-sm w-50">
                        <label for="popup-session-create-user-group">1. Выберите группы пользователей</label>
                        <select data-live-search="true" name="n" multiple class="form-control" id="popup-session-create-user-group">
                            <option value="1">ПРИ-117</option>
                            <option value="2">ИСТ-117</option>
                            <option value="3">ИСБ-117</option>
                            <option value="4">ЖБ-117</option>
                        </select>
                    </div>
                    <div class="col-sm w-50">
                        <label for="popup-session-create-user-group">2. Выберите пользователей</label>
                        <select data-live-search="true" name="n" multiple class="form-control" id="popup-session-create-user-group">
                            <option value="1" data-subtext="ПРИ-117">Савин М.К</option>
                            <option value="2" data-subtext="ПРИ-117">Куппе Р.О</option>
                            <option value="3" data-subtext="ИДБ-117">Козловский А.Г</option>
                            <option value="4" data-subtext="ЖБ-117">Информационовский Е.К</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="footer">
                <label class="mb-0">Пользователей будет добавлено: <span class="blue">20</span></label>
                <a href="#" class="button short float-right popup-toggle icon icon-plus" popup-target=".session-data">Добавить</a>
                <input type="reset" class="button short white mr-3 float-right" value="Очистить">
            </div>
        </form>
    </div>
</div>
<div class="window loading">
    <div class="header">
        <span class="float-left title">Загрузка...</span>
        <div class="float-right menu">
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <div class="center no-selection"><img src="public/img/animation/loading_transparent.gif" class="pevs-none" width="60" alt=""></div>
    </div>
</div>
<div class="window text">
    <div class="header">
        <span class="float-left title js-title">Текст</span>
        <div class="float-right menu">
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <div class="center">
            <div class="bigicon js-type bigicon-warning"></div>
            <div class="title js-title">Какое-то нативное сообщение. Ошибка</div>
            <div class="js-text">Произошла какая-то ошибка дадададададада тада дадафвыафы авыафыв афвы</div>
        </div>
    </div>
</div>
<div class="window question-box">
    <div class="header">
        <span class="float-left title">Вопрос</span>
        <div class="float-right menu">
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <div class="mb-3">
            Вы действительно хотите сделать это?
        </div>
        <div>
            <a href="#" class="button popup-toggle" popup-target=".user-data">Да, хочу</a>
            <a href="#" class="button white ml-3 popup-toggle" popup-target=".user-data">Нет, не хочу</a>
        </div>
    </div>
</div>
<div class="window user-data">
    <div class="header">
        <span class="float-left title">Пользователь <i class="js-user-data-name_short">Савин М.К</i></span>
        <div class="float-right menu">
            <!-- <a href="#" class="overlay-more dd-toggle" dd-target=".dd-more"></a>
            <div class="dd-hidden dd dd-more">
                <a href="#" class="js-user-data-edit popup-toggle" popup-target=".user-edit" popup-data="0">Редактировать пользователя</a>
                <a href="#" class="js-user-data-delete popup-toggle" popup-target=".user-edit" popup-data="0">Удалить пользователя</a>
            </div> -->
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <div class="mb-3">
            <label for="popup-user-data-user-name">ФИО</label>
            <input type="text" class="js-user-data-name form-control" id="popup-user-data-user-name" disabled value="Савин Максим Константинович">
        </div>
        <div class="row mb-3">
            <div class="js-user-data-group col-md">
                <label for="popup-user-data-user-group">Группа <a href="#" class="js-user-data-group-id ml-2 popup-toggle" popup-handler-after="popup-group-data-create" popup-target=".group-data">Открыть</a></label>
                <input type="text" class="js-user-data-group-name form-control" id="popup-user-data-user-group" disabled value="ПРИ-117">
            </div>
            <div class="col-md">
                <label for="popup-user-data-user-type">Тип пользователя <!-- <a href="#" class="js-user-data-type-id ml-2 popup-toggle" popup-handler-after="popup-type-data-create" popup-target=".type-data">Открыть</a> --></label>
                <input type="text" class="js-user-data-type-name form-control" id="popup-user-data-user-type" disabled value="Студент">
            </div>
        </div>
        <xmp class="d-none js-attendance-list-row-templates">
            @include('public.layouts.parts.popupStackParts.userData.attendanceRow')
        </xmp>
        <label for="popup-user-data-noted-table">Посещаемость</label>
        <div class="updatable-table" id="popup-user-data-noted-table">
            <div class="no-results js-no-results" style="display:none">Сеансов, в которых пользователь отметился, нет</div>
            <div class="center no-selection loader js-loader">
                <img src="public/img/animation/loading_transparent.gif" class="pevs-none" width="60" alt="">
            </div>
            <div class="noted-table noted-table-wide no-th-top-padding js-noted-table ps" style="display:none">
                <table>
                    <thead>
                        <tr>
                            <th>ДАТА И ВРЕМЯ</th>
                            <th>СЕАНС</th>
                            <th>ВЕДУЩИЙ</th>
                            <!-- <th width="120"></th> -->
                        </tr>
                    </thead>
                    <tbody class="js-attendance-list"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="window user-edit">
    <div class="header">
        <span class="float-left title">Редактирование пользователя <i>Савин М.К</i></span>
        <div class="float-right menu">
            <a href="#" class="overlay-more dd-toggle" dd-target=".dd-more"></a>
            <div class="dd-hidden dd dd-more">
                <a href="#">Удалить пользователя</a>
            </div>
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <form method="POST">
            <div class="mb-3">
                <label for="popup-user-data-user-name">ФИО</label>
                <input type="text" class="form-control" id="popup-user-data-user-name" value="Савин Максим Константинович">
            </div>
            <div class="row mb-3">
                <div class="col-md">
                    <label for="popup-user-data-user-group">Группа</label>
                    <select data-live-search="true" name="n" class="form-control js-user-group" id="popup-user-data-user-group">
                        <option value="1" data-subtext="20 чел." selected>ПРИ-117</option>
                        <option value="2" data-subtext="20 чел.">ИСТ-117</option>
                        <option value="3" data-subtext="20 чел.">ИСБ-117</option>
                    </select>
                </div>
                <div class="col-md">
                    <label for="popup-user-data-user-type">Тип пользователя</label>
                    <select data-live-search="true" name="n" class="form-control js-user-group" id="popup-user-data-user-type">
                        <option value="1" data-subtext="20 чел.">Спец. по кадрам</option>
                        <option value="2" data-subtext="20 чел.">Преподаватель</option>
                        <option value="3" data-subtext="20 чел." selected>Студент</option>
                    </select>
                </div>
            </div>
            <div>
                <input type="submit" value="Сохранить" class="button float-right">
                <a href="#" class="button white mr-3 float-right popup-toggle" popup-target=".user-data">Отменить</a>
                <div class="clearfix"></div>
            </div>
        </form>
    </div>
</div>
<div class="window user-list">
    <div class="header">
        <span class="float-left title">Список пользователей</span>
        <div class="float-right menu">
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <div class="row mb-3">
            <div class="col-md w-33">
                <label for="popup-user-list-user-type">Тип пользователя</label>
                <select data-live-search="true" name="n" multiple class="form-control js-user-type" id="popup-user-list-user-type">
                    <option value="1" data-subtext="20 чел.">Спец. по кадрам</option>
                    <option value="2" data-subtext="20 чел.">Преподаватель</option>
                    <option value="3" data-subtext="20 чел.">Студент</option>
                </select>
            </div>
            <div class="col-md w-33">
                <label for="popup-user-list-user-group">Группа</label>
                <select data-live-search="true" name="n" multiple class="form-control js-user-group" id="popup-user-list-user-group">
                    <option value="1" data-subtext="20 чел.">ПРИ-117</option>
                    <option value="2" data-subtext="20 чел.">ИСТ-117</option>
                    <option value="3" data-subtext="20 чел.">ИСБ-117</option>
                    <option value="4" data-subtext="20 чел.">ИРП-117</option>
                </select>
            </div>
            <div class="col-md w-33">
                <label for="popup-user-list-search">Поиск</label>
                <input type="text" class="js-user-search form-control" id="popup-user-list-search">
            </div>
        </div>
        <xmp class="d-none js-user-list-row-templates">
            @include('public.layouts.parts.popupStackParts.usersList.userRow', [
                'id' => '#ID#',
                'type' => '#TYPE#',
                'name_short' => '#NAMESHORT#',
                'group' => [
                    'id' => '#GROUP_ID#',
                    'name' => '#GROUP_NAME#',
                ],
            ])
        </xmp>
        <label for="popup-user-list-noted-table">Пользователи</label>
        <div class="updatable-table" id="popup-user-list-noted-table">
            <div class="no-results js-no-results" style="display:none">Пользователей, подходящих под Ваш набор фильтров, нет</div>
            <div class="center no-selection loader js-loader">
                <img src="public/img/animation/loading_transparent.gif" class="pevs-none" width="60" alt="">
            </div>
            <div class="noted-table noted-table-wide no-th-top-padding js-noted-table ps" style="display:none">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ТИП</th>
                            <th>ФИО</th>
                            <th>ГРУППА</th>
                        </tr>
                    </thead>
                    <tbody class="js-users-list">
                        <tr>
                            <td>1</td>
                            <td>Студент</td>
                            <td><a href="#" class="popup-toggle" popup-target=".user-data">Алексеев И.И</a></td>
                            <td><a href="#" class="popup-toggle" popup-target=".group-data">ПРИ-117</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Студент</td>
                            <td><a href="#" class="popup-toggle" popup-target=".user-data">Куппе Р.О</a></td>
                            <td><a href="#" class="popup-toggle" popup-target=".group-data">ПРИ-117</a></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Спец. по кадрам</td>
                            <td><a href="#" class="popup-toggle" popup-target=".user-data">Уппе О.Р</a></td>
                            <td><a href="#" class="popup-toggle" popup-target=".group-data">ИРП-117</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="window group-data">
    <div class="header">
        <span class="float-left title">Группа <i class="js-group-data-name-full">ПРИ-117</i></span>
        <div class="float-right menu">
            <!-- <a href="#" class="overlay-more dd-toggle" dd-target=".dd-more"></a>
            <div class="dd-hidden dd dd-more">
                <a href="#" class="js-group-data-edit popup-toggle" popup-target=".group-edit" popup-data="0">Редактировать группу</a>
                <a href="#" class="js-group-data-delete popup-toggle" popup-target=".group-edit" popup-data="0">Удалить группу</a>
            </div> -->
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <div class="row mb-3">
            <div class="col-md">
                <label for="popup-group-data-group-name">Название</label>
                <input type="text" class="js-group-data-name form-control" id="popup-group-data-group-name" disabled value="ПРИ-1">
            </div>
            <div class="col-md">
                <label for="popup-group-data-group-year">Год</label>
                <input type="text" class="js-group-data-year form-control" id="popup-group-data-group-year" disabled value="17">
            </div>
        </div>
        <xmp class="d-none js-user-list-row-templates">
            @include('public.layouts.parts.popupStackParts.groupData.userRow')
        </xmp>
        <label for="popup-group-data-noted-table">Пользователи</label>
        <div class="updatable-table" id="popup-group-data-noted-table">
            <div class="no-results js-no-results" style="display:none">Пользователей, принадлежащих этой группе, нет</div>
            <div class="center no-selection loader js-loader">
                <img src="public/img/animation/loading_transparent.gif" class="pevs-none" width="60" alt="">
            </div>
            <div class="noted-table noted-table-wide no-th-top-padding js-noted-table ps" style="display:none">
                <table>
                    <thead>
                        <tr>
                            <th width="40">#</th>
                            <th>ФИО</th>
                            <!-- <th width="120"></th> -->
                        </tr>
                    </thead>
                    <tbody class="js-user-list"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="window group-edit">
    <div class="header">
        <span class="float-left title">Редактирование группы <i>ПРИ-117</i></span>
        <div class="float-right menu">
            <a href="#" class="overlay-more dd-toggle" dd-target=".dd-more"></a>
            <div class="dd-hidden dd dd-more">
                <a href="#">Удалить группу</a>
            </div>
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <div class="row mb-3">
            <div class="col-md">
                <label for="popup-group-data-group-name">Название</label>
                <input type="text" class="form-control" id="popup-group-data-group-name" value="ПРИ-1">
            </div>
            <div class="col-md">
                <label for="popup-group-data-group-year">Год</label>
                <input type="text" class="form-control" id="popup-group-data-group-year" value="17">
            </div>
        </div>
        <div>
            <input type="submit" value="Сохранить" class="button float-right">
            <a href="#" class="button white mr-3 float-right popup-toggle" popup-target=".group-data">Отменить</a>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="window group-list">
    <div class="header">
        <span class="float-left title">Список групп</span>
        <div class="float-right menu">
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <div class="row mb-3">
            <div class="col-md">
                <label for="popup-group-list-search">Поиск</label>
                <input type="text" class="form-control js-group-search" id="popup-group-list-search">
            </div>
        </div>
        <xmp class="d-none js-group-list-row-templates">
            @include('public.layouts.parts.popupStackParts.groupsList.groupRow', [
                'id' => '#ID#',
                'name' => '#NAME#',
                'year' => '#YEAR#',
            ])
        </xmp>
        <label for="popup-group-list-noted-table">Группы</label>
        <div class="updatable-table" id="popup-group-list-noted-table">
            <div class="no-results js-no-results" style="display:none">Групп, подходящих под Ваш набор фильтров, нет</div>
            <div class="center no-selection loader js-loader">
                <img src="public/img/animation/loading_transparent.gif" class="pevs-none" width="60" alt="">
            </div>
            <div class="noted-table noted-table-wide no-th-top-padding js-noted-table ps" style="display:none">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ГРУППА</th>
                            <th>ГОД</th>
                        </tr>
                    </thead>
                    <tbody class="js-group-list">
                        <tr>
                            <td>1</td>
                            <td><a href="#" class="popup-toggle" popup-target=".group-data">ПРИ-1</a></td>
                            <td>17</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><a href="#" class="popup-toggle" popup-target=".group-data">ИСТ-1</a></td>
                            <td>17</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><a href="#" class="popup-toggle" popup-target=".group-data">ИРП-1</a></td>
                            <td>17</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="window session-redeem">
    <div class="header">
        <span class="float-left title">Использование сеанса</span>
        <div class="float-right menu">
            <a href="#" class="overlay-close"></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="body">
        <form method="POST">
            <div>
                <label for="popup-session-redeem-code">1. Введите URL или код сеанса</label>
                <input type="text" class="js-session-redeem-code form-control" id="popup-session-redeem-code" placeholder="{{ route('redeem') }}?code=RSEU-EGHJ-3VCW">
            </div>
            <div class="mt-3">
                <label for="popup-session-redeem-redeem" class="redeem-label">2. Нажмите кнопку <i>Использовать</i></label>
                <a href="#" class="js-session-redeem-submit button float-right" id="popup-session-redeem-redeem">Использовать</a>
                <div class="clearfix"></div>
            </div>
        </form>
    </div>
</div>