var is_mobile = ((/Mobile|iPhone|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera) ? true : false);

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

var customJQFunctions = function() {
    jQuery.fn.extend({
        serializeSelect: function() {
            var result = [];
            this.find('option:selected').each(function(){
                result.push($(this).val());
            });
            return result.join(',');
        }
    });
};

function throttle(f, delay){
    var timer = null;
    return function(){
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = window.setTimeout(function(){
            f.apply(context, args);
        },
        delay || 500);
    };
}

var setMomentalInterval = function(fn, timeout = 1000) {
    fn();
    return setInterval(fn, timeout);
};

var setMomentalTimeout = function(fn, timeout = 1000) {
    fn();
    return setTimeout(fn, timeout);
};

var selectpicker_data = {
    noneSelectedText: "Ничего не выбрано",
    countSelectedText: "Элементов выбрано: {0}",
    noneResultsText: "Не найдено: {0}",
    selectedTextFormat: "count > 3"
};

var api_links = {
    sessions: {
        all: '/api/sessions/all'
    },
    session: {
        one: '/api/session',
        usecode: '/api/session/usecode',
        create: '/api/session/create',
        suitable: '/api/session/suitable'
    },
    attendance: {
        get: '/api/attendance/',
        add: '/api/attendance/add'
    },
    users: {
        full: '/api/users',
        aside: '/api/users/aside',
        asideForSession: '/api/users/aside/forsession',
    },
    user: {
        one: '/api/user'
    },
    groups: {
        all: '/api/groups'
    },
    group: {
        one: '/api/group'
    },
};

var links = {
    redeem: '/redeem',
};

var updateSelects;
(updateSelects = function(){
    $('main select, #popup select').selectpicker(selectpicker_data);
})();

var refreshSelects = function(){
    $('main select, #popup select').selectpicker(selectpicker_data, 'refresh').selectpicker('refresh');
};

var updateDatepicks;
(updateDatepicks = function(){
    $('.jq-datepicker').datepicker({
        position: "top center", 
        dateFormat: "yyyy.mm.dd",
        onSelect: function(formattedDate, date, inst) {
            inst.$el.trigger('change');
        }
    });
})();

var ps1 = null;

var updateScrollbars;
(updateScrollbars = function(){
    if (!is_mobile && $('.ps').length) {
        ps1 = new PerfectScrollbar('.ps', {
            wheelSpeed: 0.4,
            wheelPropagation: true,
            minScrollbarLength: 20
        });
    }
})();

var refreshScrollbars;
(refreshScrollbars = function(){
    if (ps1 != null) 
        ps1.update();
})();

var closeDD = function() {
    $('.dd').addClass('dd-hidden');
    $('.dd-toggle').removeClass('active');
};

var openPopup = function(target, handler = false, data = false) {
    var popup = $('<a href="#" class="popup-toggle" popup-target=".' + target + '" ' + (handler != "" ? 'popup-handler-after="' + handler + '"' : '') + (data != "" ? 'popup-data=\'' + JSON.stringify(data) + '\'' : '') + '></a>');
    $('.js-popup-openers').append(popup);
    popup.trigger('click');
};

setMomentalInterval(function(){
    var date = new Date();
    var clock = $('main .js-time');
    fillClock(clock, date);
    fillDate($('.js-date'), date);
    fillDateShort($('.js-date-mobile'), date);

    var weekType = (new Date()).getWeekType();
    var weekTypeElement = $('.js-weektype');
    weekTypeElement.html(weekType ? weekTypeElement.data('num') : weekTypeElement.data('denum'));
}, 1000);

if ($('.js-sessions-list').length) {
    var sessionsAjax = function(sessionType = 'active', data){
        var sessionElement = $('.js-sessions-list-' + sessionType);
        sessionElement.find('.js-block-body').html("");

        var session;
        var clonableBlock = 'long';

        if (sessionType == 'active') {
            session = data.sessions_active;
        } else if(sessionType == 'await') {
            session = data.sessions_await;
        } else if(sessionType == 'closed') {
            session = data.sessions_closed;
            clonableBlock = 'short';
        }

        sessionElement.toggleClass('d-none', session.length == 0);

        session.forEach(function(session){
            var element = $('.js-session-' + clonableBlock)[0].outerHTML;
            element = element
                .replace('#ID#', session.id)
                .replace('#USERSCOUNT#', session.usersCount)
                .replace('#CREATED#', session.createdDateTime)
                .replace('#CREATEDTIMESTAMP#', session.createdTimestamp)
                .replace('#TIMELEFT#', session.timeLeft)
                .replace('#TARGET#', session.target);
            var element = $(element).appendTo('.js-sessions-list-' + sessionType + ' .js-block-body');
            if (!session.creatorAutomated) {
                element.find('.js-creator').remove();
            }
            if (sessionType == 'await') {
                element.find('.js-timer-description').html(element.find('.js-timer-description').attr('timer-await'));
            } else {
                element.find('.js-timer-description').html(element.find('.js-timer-description').attr('timer-active'));
            }
        });
    };
    setMomentalInterval(function(){
        $.ajax({
            url: api_links.sessions.all,
            data: {
                api_token: user.api_token
            },
            success: function(data) {
                sessionsAjax('active', data);
                sessionsAjax('await', data);
                sessionsAjax('closed', data);
            }
        });
    }, 5000);
}

var popupInterval, popupInterval2;
var popupTimer;

var popupHandlers = function(){

    var sessionCreateAction = function(self, button, when, type) {
        var dateStart;
        var dateEnd;
        var timeAdd;
        var timePow;

        var types = self.find('.js-user-type').serializeSelect();
        var groups = self.find('.js-user-group').serializeSelect();
        
        $.ajax({
            url: api_links.users.asideForSession,
            data: {
                api_token: user.api_token
            },
            success: function(data) {
                if (data.types.length > 0) {
                    self.find('.js-user-type select').html("");
                    var typesSelected = types.split(',');
                    var xmp = self.find('.js-session-create-select-option').html();

                    data.types.forEach(function(type){
                        var element = $(xmp)[0].outerHTML;

                        element = element
                            .replaceAll('#ID#', type.id)
                            .replaceAll('#USERS_COUNT#', type.count)
                            .replaceAll('#NAME_FULL#', type.name)
                            .replaceAll('#CHECKGROUP#', type.countGroups > 0);

                        var element = $(element).appendTo('#popup .session-create .js-user-type select');

                        if (typesSelected.includes(type.id+"")) {
                            element.attr('selected', true);
                        }
                    });
                }

                if (data.groups.length > 0) {
                    self.find('.js-user-group select').html("");
                    var groupsSelected = groups.split(',');
                    var xmp = self.find('.js-session-create-select-option').html();

                    data.groups.forEach(function(group){
                        var element = $(xmp)[0].outerHTML;
                        element = element
                            .replaceAll('#ID#', group.id)
                            .replaceAll('#USERS_COUNT#', group.count)
                            .replaceAll('#NAME_FULL#', group.name_full)
                            .replaceAll('#CHECKGROUP#', 'false');

                        var element = $(element).appendTo('#popup .session-create .js-user-group select');
                        if (groupsSelected.includes(group.id+"")) {
                            element.attr('selected', true);
                        }
                    });
                }

                self.find('select').first().trigger('change');

                refreshSelects();
            }
        });

        popupInterval = setMomentalInterval(function(){
            dateStart = new Date();
            
            if (type == 'timed') {
                dateStart = self.find('.js-active_at').val();
                if (dateStart != '') {
                    dateStart = parseDate(dateStart);
                } else {
                    dateStart = new Date();
                }
            }

            timePow = parseInt(self.find('.js-active_time-pow').find('option:selected').val());

            timeAdd = self.find('.js-active_time').val();
            dateEnd = new Date(dateStart.getTime() + parseInt(timeAdd == '' ? 20 : timeAdd) * Math.pow(60, timePow - 1) * 1000);

            fillClock(self.find('.js-session-info-clock-start'), dateStart);
            fillDate(self.find('.js-session-info-date-start'), dateStart);

            fillClock(self.find('.js-session-info-clock-end'), dateEnd);
            fillDate(self.find('.js-session-info-date-end'), dateEnd);
        }, 1000);

    }

    $("#popup").on('popup-session-create-momental', function(e, button, when) {
        $(this).find('.js-timed').addClass('d-none');
        $(this).find('.js-momental').removeClass('d-none');
        $(this).find('.js-nonmomental').remove();

        $(this).find('.window').addClass('momental');

        $(this).find('.js-session-create').attr('session-type', 'momental');

        sessionCreateAction($(this), button, when, 'momental');
    });

    $("#popup").on('popup-session-create-timed', function(e, button, when) {
        $(this).find('.js-nontimed').remove();
        $(this).find('.js-momental').addClass('d-none');
        $(this).find('.js-timed').removeClass('d-none');

        $(this).find('.window').addClass('timed');

        $(this).find('.js-session-create').attr('session-type', 'timed');

        sessionCreateAction($(this), button, when, 'timed');
    });

    var sessionDataAttendanceUpdateAction = function(self, button, sessionData) {
        $.ajax({
            url: api_links.attendance.get,
            data: {
                session_id: sessionData.id,
                api_token: user.api_token
            },
            success: function(data) {
                self.find('.js-loader').fadeOut(200);
                self.find('.js-session-data-users-count').html(data.length);
                
                if (data.length > 0) {
                    self.find('.js-noted-table').fadeIn(200);
                    self.find('.js-no-results').fadeOut(200);
                    $('.js-session-data-attendance-full').removeClass('disabled');
                    
                    self.find('.js-attendance-list').html("");
                    var xmp = $('.js-attendance-list-row-templates').html();

                    data.forEach(function(attendance){
                        var element = $(xmp)[0].outerHTML;

                        element = element
                            .replaceAll('#TIME#', attendance.differance)
                            .replaceAll('#USER_ID#', attendance.user.id)
                            .replaceAll('#USER_NAME_SHORT#', attendance.user.name_short);

                        if (attendance.user.group) {
                            element = element
                                .replaceAll('#GROUP_ID#', attendance.user.group.id)
                                .replaceAll('#GROUP_NAME_FULL#', attendance.user.group.name_full);
                        } else {
                            element = element
                                .replaceAll('#GROUP_ID#', 0)
                                .replaceAll('#GROUP_NAME_FULL#', "");
                        }

                        var element = $(element).appendTo('#popup .js-attendance-list');
                    });
                } else {
                    self.find('.js-no-results').fadeIn(200);
                    self.find('.js-noted-table').fadeOut(200);
                    $('.js-session-data-attendance-full').addClass('disabled');
                }
            }
        });
    };

    var sessionDataAction = function(self, button, sessionData) {
        if (sessionData.error) {
            openPopup('text', 'popup-text-create', {
                type: "warning",
                title: "Ошибка",
                text: sessionData.msg
            });
            return;
        }

        if (!sessionData.editRight) {
            self.find('.js-session-data-attendance-add').remove();
        }

        self.find('.js-session-data-qrcode').attr('src', sessionData.qrImage);

        var sessionType = sessionData.status;

        var dateStart = new Date(sessionData.activeTimestamp * 1000);
        var timezoneOffset = dateStart.getTimezoneOffset() * 60*1000;

        var statusBar = self.find('.title .js-session-data-status');

        $('.js-session-data-attendance-full').attr('popup-data', JSON.stringify({
            id: sessionData.id,
            editRight: sessionData.editRight
        }));
        $('.js-session-data-attendance-add').attr('popup-data', sessionData.id);

        if (sessionType == 'active') {
            self.find('.qr-code').removeClass('hidden');
            self.find('.js-session-data-timed_only').addClass('d-none');
            // TODO: При подключении заменить правильно dateStart. Это дата старта сеанса
        } else if (sessionType == 'await') {
            statusBar.removeClass('blue').removeClass('red').addClass('yellow');
            statusBar.html(statusBar.data('await'));
        }


        var dateClose = new Date(dateStart.getTime() + sessionData.activetime * 1000);
        var deltaDate;

        if (sessionType != 'closed') {
            
            self.find('.js-loader').fadeIn(200);
            self.find('.js-noted-table').fadeOut(200);
            self.find('.js-no-results').fadeOut(200);

            popupInterval = setMomentalInterval(function(){
                var date = new Date();
                
                if (sessionType == 'await') {
                    deltaDate = new Date(dateStart.getTime() - date.getTime() + timezoneOffset);
                    if (deltaDate.getTime() <= timezoneOffset) {
                        deltaDate = new Date(timezoneOffset);
                        
                        self.find('.js-session-data-clock-start').addClass('red');

                        statusBar.removeClass('yellow').removeClass('red').addClass('blue');
                        statusBar.html(statusBar.data('active'));

                        self.find('.qr-code').removeClass('hidden');
                    }

                    var clock = self.find('.js-session-data-clock-start');
                    if (deltaDate.getDate() > 1 && !clock.find('.days').length) {
                        clock.html('<span class="days">00</span>'  + clock.html().trim());
                    }
                    fillClock(clock, deltaDate, true);
                }

                deltaDate = new Date(dateClose.getTime() - date.getTime() + timezoneOffset);

                if (deltaDate.getTime() <= timezoneOffset) {
                    deltaDate = new Date(timezoneOffset);

                    self.find('.js-session-data-clock-end').addClass('red');

                    statusBar.removeClass('blue').removeClass('yellow').addClass('red');
                    statusBar.html(statusBar.data('closed'));

                    self.find('.qr-code').addClass('hidden');

                    clearInterval(popupInterval);

                    return;
                }

                var clock = self.find('.js-session-data-clock-end');
                if (deltaDate.getDate() > 1 && !clock.find('.days').length) {
                    clock.html('<span class="days">00</span>'  + clock.html().trim());
                }
                fillClock(clock, deltaDate, true);
            });
            popupInterval2 = setMomentalInterval(function(){
                sessionDataAttendanceUpdateAction(self, button, sessionData);
            }, 2500);
        } else {
            statusBar.removeClass('blue').removeClass('yellow').addClass('red');
            statusBar.html(statusBar.data('closed'));

            self.find('.js-session-data-timed_only').addClass('d-none');
            self.find('.js-session-data-clock-end').removeClass('blue').addClass('red');

            sessionDataAttendanceUpdateAction(self, button, sessionData);
        }

    };

    $("#popup").on('popup-session-data-create', function(e, button, when) {
        var self = $(this);
        var button = $(button);

        if (button.attr('popup-data') == 'undefined' || !button.attr('popup-data')) {
            return;
        }

        if (parseInt(button.attr('popup-data'))) {

            $.ajax({
                url: api_links.session.one,
                data: {
                    id: button.attr('popup-data'),
                    api_token: user.api_token
                }, 
                success: function(data) {
                    sessionDataAction(self, button, data);
                }
            });

            return;
        }

        sessionDataAction(self, button, JSON.parse(button.attr('popup-data')));

    });

    $("#popup").on('popup-session-users-update', function(e, id) {
        var self = $(this);

        self.find('.js-loader').fadeIn(200);
        self.find('.js-noted-table').fadeOut(200);
        self.find('.js-no-results').fadeOut(200);

        var groups = self.find('.js-user-group').serializeSelect();
        var search = self.find('.js-search').val();

        $.ajax({
            url: api_links.attendance.get,
            data: {
                session_id: id,
                api_token: user.api_token,
                groups: groups,
                search: search
            },
            success: function(data) {
                self.find('.js-loader').fadeOut(200);

                self.find('.js-attendance-count').html(data.length);

                if(data.length > 0) {
                    self.find('.js-noted-table').fadeIn(200);

                    self.find('.js-attendance-list').html("");
                    var xmp = $('.js-attendance-list-row-templates').html();

                    data.forEach(function(attendance){
                        var element = $(xmp)[0].outerHTML;
                        var createdTime = attendance.createdTime.split(':');

                        element = element
                            .replaceAll('#ID#', attendance.id)
                            .replaceAll('#DATE#', attendance.createdDate)
                            .replaceAll('#TIME_HOURS#', createdTime[0])
                            .replaceAll('#TIME_MINUTES#', createdTime[1])
                            .replaceAll('#TIME_SECONDS#', createdTime[2])
                            .replaceAll('#TIME#', attendance.differance)
                            .replaceAll('#USER_ID#', attendance.user.id)
                            .replaceAll('#USER_NAME_SHORT#', attendance.user.name_short);
                        
                        if (attendance.user.group) {
                            element = element
                                .replaceAll('#GROUP_ID#', attendance.user.group.id)
                                .replaceAll('#GROUP_NAME_FULL#', attendance.user.group.name_full);
                        } else {
                            element = element
                                .replaceAll('#GROUP_ID#', 0)
                                .replaceAll('#GROUP_NAME_FULL#', "");
                        }

                        var element = $(element).appendTo('#popup .js-attendance-list');
                    });
                } else {
                    self.find('.js-no-results').fadeIn(200);
                }

                refreshSelects();
            }
        });

    });

    $("#popup").on('popup-session-users-create', function(e, button, when) {
        var self = $(this);
        var button = $(button);

        var data = JSON.parse(button.attr('popup-data'));

        self.find('.js-session-users-back').attr('popup-data', data.id);
        self.find('.js-session-users-add').attr('popup-data', data.id);

        if (!data.editRight) {
            self.find('.js-session-users-add').remove();
        }

        $.ajax({
            url: api_links.groups.all,
            success: function(data) {
                if(data.length > 0) {
                    self.find('.js-users-groups select').html("");
                    var xmp = $('.js-session-users-select-option').html();

                    data.forEach(function(group){
                        var element = $(xmp)[0].outerHTML;
                        element = element
                            .replaceAll('#ID#', group.id)
                            .replaceAll('#NAME_FULL#', group.name_full)
                            .replaceAll('#USERS_COUNT#', group.count);

                        var element = $(element).appendTo('#popup .js-users-groups select');
                    });
                }

                refreshSelects();
            }
        });

        $("#popup").trigger('popup-session-users-update', data.id);
    });

    $("#popup").on('popup-session-users-add-update', function(e, id) {
        var self = $(this);

        var groups = self.find('.js-users-groups').serializeSelect();

        if (self.find('.js-users-groups').length != 0 && groups == "") {
            self.find('.js-users-users').attr('disabled', true);
            return;
        }

        $.ajax({
            url: api_links.session.suitable,
            data: {
                id: id,
                api_token: user.api_token,
                groups: groups
            }, 
            success: function(data) {
                if (data.length) {
                    self.find('.js-users-users').attr('disabled', false);

                    self.find('.js-users-users select').html("");
                    var xmp = self.find('.js-session-users-add-select-user-option').html();
                    
                    data.forEach(function(user){
                        var element = $(xmp)[0].outerHTML;
                        var target = user.user_type.name;
                        if (user.group) {
                            target = user.group.name_full;
                        }
                        element = element
                            .replaceAll('#ID#', user.id)
                            .replaceAll('#NAME_SHORT#', user.name_short)
                            .replaceAll('#TARGET#', target);

                        var element = $(element).appendTo('#popup .js-users-users select');
                    });
                } else {
                    self.find('.js-users-users').attr('disabled', true);
                    self.find('.js-users-users select').html("");
                }

                refreshSelects();
            }
        });
    });

    $("#popup").on('popup-session-users-add-create', function(e, button, when) {
        var self = $(this);
        var button = $(button);

        var id = button.attr('popup-data');

        self.find('.js-session-data').attr('popup-data', id);
        self.find('.js-session-users').attr('popup-data', id);
        self.find('.js-session-users-add-add').attr('popup-data', id);

        $.ajax({
            url: api_links.session.one,
            data: {
                id: id,
                api_token: user.api_token
            }, 
            success: function(data) {
                if (!data.attendance.length) {
                    self.find('.js-session-users').addClass('disabled');
                }

                if (data.session_group.length) {
                    self.find('.js-users-groups select').html("");
                    var xmp = self.find('.js-session-users-add-select-group-option').html();
                    
                    data.session_group.forEach(function(session_group){
                        var group = session_group.group;
                        var element = $(xmp)[0].outerHTML;
                        element = element
                            .replaceAll('#ID#', group.id)
                            .replaceAll('#NAME_FULL#', group.name_full)
                            .replaceAll('#USERS_COUNT#', group.count_suitable != undefined ? group.count_suitable : 0);

                        var element = $(element).appendTo('#popup .js-users-groups select');
                    });
                } else {
                    self.find('.js-step').html('1');
                    self.find('.js-users-groups-form-control-group').remove();
                    self.find('.js-users-users').attr('disabled', false);
                    
                    self.trigger('popup-session-users-add-update', id);
                }

                refreshSelects();
            }
        });

    });

    $('#popup').on('popup-user-list-create', function(e, button, when){
        var self = $(this);

        var type = self.find('.js-user-type').serializeSelect();
        var group = self.find('.js-user-group').serializeSelect();

        self.find('.js-loader').fadeIn(200);
        self.find('.js-noted-table').fadeOut(200);
        self.find('.js-no-results').fadeOut(200);

        $.ajax({
            url: api_links.users.full,
            data: {
                type: type,
                group: group,
                search: self.find('.js-user-search').val()
            },
            success: function(data) {
                self.find('.js-loader').fadeOut(200);
                if(data.users.length > 0) {
                    self.find('.js-noted-table').fadeIn(200);
                    
                    self.find('.js-users-list').html("");
                    var xmp = self.find('.js-user-list-row-templates').html();

                    data.users.forEach(function(user){
                        var element = $(xmp)[0].outerHTML;
                        element = element
                            .replaceAll('#ID#', user.id)
                            .replaceAll('#TYPE#', user.user_type.name)
                            .replaceAll('#NAMESHORT#', user.name_short)
                            .replaceAll('#GROUP_ID#', user.group != null ? user.group.id : "")
                            .replaceAll('#GROUP_NAME#', user.group != null ? user.group.name_full : "");

                        var element = $(element).appendTo('#popup .js-users-list');
                    });
                } else {
                    self.find('.js-no-results').fadeIn(200);
                }
                
                if (data.types.length > 0) {
                    self.find('.js-user-type select').html("");
                    var typesSelected = type.split(',');
                    var xmp = self.find('.js-user-list-select-option').html();

                    data.types.forEach(function(type){
                        var element = $(xmp)[0].outerHTML;

                        element = element
                            .replaceAll('#ID#', type.id)
                            .replaceAll('#USERS_COUNT#', type.count)
                            .replaceAll('#NAME_FULL#', type.name);

                        var element = $(element).appendTo('#popup .user-list .js-user-type select');

                        if (typesSelected.includes(type.id+"")) {
                            element.attr('selected', true);
                        }
                    });
                }

                if (data.groups.length > 0) {
                    self.find('.js-user-group select').html("");
                    var groupsSelected = group.split(',');
                    var xmp = self.find('.js-user-list-select-option').html();

                    data.groups.forEach(function(group){                        
                        var element = $(xmp)[0].outerHTML;
                        element = element
                            .replaceAll('#ID#', group.id)
                            .replaceAll('#USERS_COUNT#', group.count)
                            .replaceAll('#NAME_FULL#', group.name_full);

                        var element = $(element).appendTo('#popup .user-list .js-user-group select');
                        if (groupsSelected.includes(group.id+"")) {
                            element.attr('selected', true);
                        }
                    });
                }

                refreshSelects();
            }
        });
    });

    $('#popup').on('popup-group-list-create', function(e, button, when){
        var self = $(this);

        self.find('.js-loader').fadeIn(200);
        self.find('.js-noted-table').fadeOut(200);
        self.find('.js-no-results').fadeOut(200);

        $.ajax({
            url: api_links.groups.all,
            data: {
                search: self.find('.js-group-search').val()
            },
            success: function(data) {
                self.find('.js-loader').fadeOut(200);
                if(data.length > 0) {
                    self.find('.js-noted-table').fadeIn(200);

                    self.find('.js-group-list').html("");
                    var xmp = $('.js-group-list-row-templates').html();

                    data.forEach(function(group){
                        var element = $(xmp)[0].outerHTML;
                        element = element
                            .replaceAll('#ID#', group.id)
                            .replaceAll('#NAME#', group.name)
                            .replaceAll('#YEAR#', group.year);

                        var element = $(element).appendTo('#popup .js-group-list');
                    });
                } else {
                    self.find('.js-no-results').fadeIn(200);
                }
                refreshSelects();
            }
        });
    });

    $('#popup').on('popup-user-data-create', function(e, button, when){
        var self = $(this);
        var button = $(button);
        var userId = button.attr('popup-data');

        self.find('.js-loader').fadeIn(200);
        self.find('.js-noted-table').fadeOut(200);
        self.find('.js-no-results').fadeOut(200);

        $.ajax({
            url: api_links.user.one,
            data: {
                id: userId,
                api_token: user.api_token
            },
            success: function(data) {
                if (data.error) {
                    openPopup('text', 'popup-text-create', {
                        type: "warning",
                        title: "Ошибка",
                        text: data.msg
                    });
                    return;
                }

                self.find('.js-loader').fadeOut(200);

                self.find('.js-user-data-edit').attr('popup-data', data.id);
                self.find('.js-user-data-delete').attr('popup-data', data.id);

                self.find('.js-user-data-name_short').html(data.name_short);
                self.find('.js-user-data-name').val(data.name);

                if (data.group != null) {
                    self.find('.js-user-data-group-id').attr('popup-data', data.group.id);
                    self.find('.js-user-data-group-name').val(data.group.name_full);
                } else {
                    self.find('.js-user-data-group').remove();
                    self.find('.js-user-data-type').removeClass('mt-3');
                }

                self.find('.js-user-data-type-id').attr('popup-data', data.user_type.id);
                self.find('.js-user-data-type-name').val(data.user_type.name);

                if(data.attendance.length > 0) {
                    self.find('.js-noted-table').fadeIn(200);

                    self.find('.js-attendance-list').html("");
                    var xmp = $('.js-attendance-list-row-templates').html();

                    data.attendance.forEach(function(attendance){
                        var createdTime = attendance.createdTime.split(':');
                        var element = $(xmp)[0].outerHTML;
                        element = element
                            .replaceAll('#ID#', attendance.id)
                            .replaceAll('#DATE#', attendance.createdDate)
                            .replaceAll('#TIME_HOURS#', createdTime[0])
                            .replaceAll('#TIME_MINUTES#', createdTime[1])
                            .replaceAll('#TIME_SECONDS#', createdTime[2])
                            .replaceAll('#SESSION_ID#', attendance.session.id)
                            .replaceAll('#SESSION_CODE#', attendance.session.code)
                            .replaceAll('#CREATOR_ID#', attendance.session.user.id)
                            .replaceAll('#CREATOR_NAME_SHORT#', attendance.session.user.name_short);

                        var element = $(element).appendTo('#popup .js-attendance-list');
                    });
                } else {
                    self.find('.js-no-results').fadeIn(200);
                }
                refreshSelects();
            }
        });
    });

    $('#popup').on('popup-group-data-create', function(e, button, when){
        var self = $(this);
        var button = $(button);
        var groupId = button.attr('popup-data');

        self.find('.js-loader').fadeIn(200);
        self.find('.js-noted-table').fadeOut(200);
        self.find('.js-no-results').fadeOut(200);

        $.ajax({
            url: api_links.group.one,
            data: {
                id: groupId,
                api_token: user.api_token
            },
            success: function(data) {
                if (data.error) {
                    openPopup('text', 'popup-text-create', {
                        type: "warning",
                        title: "Ошибка",
                        text: data.msg
                    });
                    return;
                }

                self.find('.js-loader').fadeOut(200);

                self.find('.js-group-data-edit').attr('popup-data', data.id);
                self.find('.js-group-data-delete').attr('popup-data', data.id);

                self.find('.js-group-data-name').val(data.name);
                self.find('.js-group-data-name-full').html(data.name_full);
                self.find('.js-group-data-year').val(data.year);

                if(data.user.length > 0) {
                    self.find('.js-noted-table').fadeIn(200);

                    self.find('.js-user-list').html("");
                    var xmp = $('.js-user-list-row-templates').html();

                    data.user.forEach(function(user){
                        var element = $(xmp)[0].outerHTML;
                        element = element
                            .replaceAll('#ID#', user.id)
                            .replaceAll('#NAME#', user.name);

                        var element = $(element).appendTo('#popup .js-user-list');
                    });
                } else {
                    self.find('.js-no-results').fadeIn(200);
                }
                refreshSelects();
            }
        });
    });

    $('#popup').on('popup-text-create', function(e, button, when){
        var self = $(this);
        var button = $(button);
        var text = JSON.parse(button.attr('popup-data'));

        self.find('.js-type').removeClass('bigicon-*').addClass('bigicon-' + text.type);
        self.find('.js-title').html(text.title);
        self.find('.js-text').html(text.text);
    });

};

var popupAdditionalActions = function(){
    
    $(document).on('change', '#popup .session-create select, #popup .session-create .js-active_at', function() {
        var self = $(this);
        var parent = self.parents('.session-create');

        var userTypeElement = parent.find('.js-user-type > option:selected');

        var userType = userTypeElement.length > 0;
        var group = true;

        var activeAtElement = parent.find('.js-active_at');
        var activeAt = activeAtElement.length == 0 || activeAtElement.val().length > 0;

        var usersCountElement = parent.find('.js-session-info-users-count');
        var usersCount = 0;
        
        if (userType && userTypeElement.data("checkgroup")) {
            group = parent
            .find('.js-user-group > option:selected')
            .each(function(){
                usersCount += parseInt($(this).data('users-count'));
            })
            .length > 0;

            parent.find('.js-user-group').removeClass('disabled');
        } else {
            group = true;
            parent.find('.js-user-group').addClass('disabled');
            usersCount = parseInt(userTypeElement.data('users-count'));
        }

        usersCountElement.toggleClass('red', usersCount == 0);
        usersCountElement.html(usersCount);
        
        parent.find('.js-session-create').toggleClass('disabled', !(userType && group && activeAt));

    });
    
    $(document).on('change', '#popup .user-list select', function() {
        $('#popup').trigger('popup-user-list-create');
    });

    $(document).on('keyup', '#popup .user-list .js-user-search', throttle(function() {
        $('#popup').trigger('popup-user-list-create');
    }));

    $(document).on('keyup', '#popup .group-list .js-group-search', throttle(function() {
        $('#popup').trigger('popup-group-list-create');
    }));

    $(document).on('click', '#popup .js-session-redeem-submit', function() {
        var parent = $(this).parents('#popup');
        var qrCode = parent.find('.js-session-redeem-code').val();

        parent.find('.js-session-redeem-submit').addClass('loading pevs-none');

        $.ajax({
            headers: {
                Accept: 'application/json'
            },
            url: links.redeem,
            data: {
                code: qrCode
            },
            success: function(data) {
                var type, title, text = data.msg;

                if (data.error) {
                    type = "warning";
                    title = "Ошибка!";
                } else {
                    type = "annotation";
                    title = "Сеанс использован";
                    text = 'Сеанс успешно использован.<br><span class="blue">' + data.session.user.name_short + '</span> благодарит Вас за посещение';
                }

                openPopup('text', 'popup-text-create', {
                    type: type,
                    title: title,
                    text: text
                });
            }
        });
    });
    
    $(document).on('click', '#popup .session-create .js-session-create', function() {
        var self = $(this);
        var parent = self.parents('.window');

        var userType = parent.find('.js-user-type').serializeSelect();
        var groups = parent.find('.js-user-group').serializeSelect();

        var activeTime = parent.find('.js-active_time').val();
        activeTime = activeTime ? activeTime : 20;

        var activeTimePow = parseInt(parent.find('.js-active_time-pow').serializeSelect());

        activeTime = activeTime * Math.pow(60, activeTimePow - 1);

        var activeAt = parent.find('.js-active_at').val();

        $.ajax({
            url: api_links.session.create,
            data: {
                userType: userType,
                groups: groups,
                activeTime: activeTime,
                activeAt: activeAt,
                api_token: user.api_token
            },
            success: function(data) {
                if (!data.error) {
                    if (data.session.status == 'active') {
                        openPopup('session-data', 'popup-session-data-create', data.session);
                    } else {
                        openPopup('text', 'popup-text-create', {
                            type: "annotation",
                            title: "Сеанс создан!",
                            text: "Ваш сеанс создан! Ожидайте начала сеанса. Начало сеанса: " + data.session.activeDateTime
                        });
                    }
                } else {
                    openPopup('text', 'popup-text-create', {
                        type: "warning",
                        title: "Ошибка!",
                        text: data.msg
                    });
                }
            }
        });
    });
    
    $(document).on('change', '#popup .session-users select', function() {
        $("#popup").trigger('popup-session-users-update', $("#popup").find('.js-session-users-add').attr('popup-data').id);
    });
    $(document).on('keyup', '#popup .session-users input', throttle(function() {
        $("#popup").trigger('popup-session-users-update', $("#popup").find('.js-session-users-add').attr('popup-data').id);
    }));

    $(document).on('change', '#popup .session-users-add .js-users-groups', throttle(function() {
        $("#popup").trigger('popup-session-users-add-update', $('#popup').find('.js-session-data').attr('popup-data'));
        refreshSelects();
    }, 300));
    $(document).on('change', '#popup .session-users-add .js-users-users', function() {
        $("#popup").find('.js-users-count').html($('#popup .session-users-add .js-users-users option:selected').length);
    });
    
    $(document).on('click', '#popup .session-users-add .js-session-users-add-add', function() {
        var self = $(this);
        var parent = self.parents('.window');
        var id = parent.find('.js-session-users-add-add').attr('popup-data');

        var users = parent.find('.js-users-users').serializeSelect();

        $.ajax({
            url: api_links.attendance.add,
            data: {
                session_id: id,
                users: users,
                api_token: user.api_token
            },
            success: function(data) {
                if (!data.error) {
                    if (data.session.status != 'await') {
                        openPopup('session-users', 'popup-session-users-create', data.session.id);
                    } else {
                        openPopup('text', 'popup-text-create', {
                            type: "annotation",
                            title: "Пользователи успешно отмечены!",
                            text: "Пользователи успешно отмечены в сеансе <span class=\"blue\">" + data.session.code + "</span>"
                        });
                    }
                } else {
                    openPopup('text', 'popup-text-create', {
                        type: "warning",
                        title: "Ошибка!",
                        text: data.msg
                    });
                }
            }
        });
    });
};

$(function(){
    customJQFunctions();

    refreshSelects();
    updateScrollbars();

    /* Drop Down close */
    $(document).on('click', function(e){
        var v = $(e.target);
        if (
            v.prop('nodeName').toLowerCase() == "a" && v.attr("href") != "#" ||
            v.prop('nodeName').toLowerCase() == "input" && v.attr("type") == "submit" ||
            v.prop('nodeName').toLowerCase() == "button"
        ) {
            return;
        }

        e.preventDefault();
        var isDD = v.hasClass('dd') || v.hasClass('dd-toggle') || v.parents('.dd').length || v.parents('.dd-toggle').length;
        if(!isDD) {
            closeDD();
        }
    });

    $(document).on('click', '.dd-toggle', function(e){
        e.preventDefault();
        $($(this).attr('dd-target')).toggleClass('dd-hidden');
        $(this).toggleClass('active');
    });

    $(document).on('click',  '.overlay-close', function(e){
        e.preventDefault();
        $('#popup').addClass('hidden');
        $('.popup-toggle').removeClass('active');
        $('body').removeClass('nooverflow');
        
        clearInterval(popupInterval);
        clearInterval(popupInterval2);
        clearTimeout(popupTimer);
    });

    $(document).on('click',  '.popup-toggle', function(e){
        e.preventDefault();
        if ($(this).attr('popup-handler-before'))
            $("#popup").trigger($(this).attr('popup-handler-before'), this, true);

        clearInterval(popupInterval);
        clearInterval(popupInterval2);
        clearTimeout(popupTimer);

        $("#popup").html("");
        $('.popup_stack > ' + $(this).attr('popup-target')).clone().appendTo("#popup");

        if ($(this).attr('popup-handler')) {
            $("#popup").trigger($(this).attr('popup-handler'), this, null);
        }

        $("#popup").removeClass("hidden");
        $(this).addClass('active');
        $('body').addClass('nooverflow');
        
        closeDD();

        refreshSelects();
        updateDatepicks();
        updateScrollbars();
        // refreshScrollbars();
        
        if ($(this).attr('popup-handler-after'))
            $("#popup").trigger($(this).attr('popup-handler-after'), this, false);
    });

    $(document).on('click', 'input[type=reset]', function(){
        var form = $(this).parents('form');
        form.find('select').selectpicker('val', '');
        form.find('select').trigger('change');
        form.find('select').find('option[default-selected]').each(function(){
            $(this).parents('select').selectpicker('val', $(this).val());
        })
    });

    $(document).on('click', '.qr-code', function(){
        $(this).toggleClass('hidden');
    });

    $(document).on('click', '.js-window-close', function(){
        window.close();
    });

    $(document).on('click', '.js-menu-popup-close', function(){
        $('.js-menu-popup').addClass('d-none');
    });

    $(document).on('click', '.js-menu-popup-open', function(){
        $('.js-menu-popup').removeClass('d-none');
    });

    popupHandlers();
    popupAdditionalActions();

});