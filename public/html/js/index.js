var is_mobile = ((/Mobile|iPhone|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera) ? true : false);

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

var updateSelects;
(updateSelects = function(){
    $('main select, #popup select').selectpicker(selectpicker_data);
})();

var refreshSelects = function(){
    $('main select, #popup select').selectpicker(selectpicker_data, 'refresh');
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
    if (!is_mobile && $('.ps').length)
        ps1 = new PerfectScrollbar('.ps', {
            wheelSpeed: 0.4,
            wheelPropagation: true,
            minScrollbarLength: 20
        });
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

setMomentalInterval(function(){
    var date = new Date();
    var clock = $('main .js-time');
    fillClock(clock, date);
    fillDate($('.js-date'), date);

    var weekType = (new Date()).getWeekType();
    var weekTypeElement = $('.js-weektype');
    weekTypeElement.html(weekType ? weekTypeElement.data('num') : weekTypeElement.data('denum'));
}, 1000);

var popupInterval;
var popupTimer;

var popupHandlers = function(){

    var sessionCreateAction = function(self, button, when, type) {
        self.find('select').first().trigger('change');

        var dateStart;
        var dateEnd;
        var timeAdd;
        var timePow;

        popupInterval = setMomentalInterval(function(){
            if (type == 'timed') {
                dateStart = self.find('.js-active_at').val();
                if (dateStart != '')
                    dateStart = parseDate(dateStart);
                else 
                    dateStart = new Date();
            } else if (type == 'momental') {
                dateStart = new Date();
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

    $("#popup").on('popup-session-data', function(e, button, when) {
        var self = $(this);
        var button = $(button);

        // TODO: При подключении данные (тип) брать из Ajax
        var sessionType = button.attr('session-type') == "momental";

        var timeToClose = 20;
        // TODO: При подключении заменить Date, если сеанс уже была начата (моментальная, но окно открыто заново)
        var dateStart = new Date();
        var timezoneOffset = dateStart.getTimezoneOffset()*60*1000;

        var statusBar = self.find('.title .js-session-data-status');

        if (sessionType) {
            self.find('.qr-code').removeClass('hidden');
            self.find('.js-session-data-timed_only').addClass('d-none');
            // TODO: При подключении заменить правильно dateStart. Это дата старта сеанса
        } else {
            dateStart = new Date(dateStart.getTime() + 20 * 1000);
            statusBar.removeClass('blue').removeClass('red').addClass('yellow');
            statusBar.html(statusBar.data('await'));
        }

        var dateClose = new Date(dateStart.getTime() + timeToClose * 1000);
        var deltaDate;

        popupInterval = setMomentalInterval(function(){
            var date = new Date();
            if (!sessionType) {
                deltaDate = new Date(dateStart.getTime() - date.getTime() + timezoneOffset);

                if (deltaDate.getTime() <= timezoneOffset) {
                    deltaDate = new Date(timezoneOffset);
                    
                    self.find('.js-session-data-clock-start').addClass('red');

                    statusBar.removeClass('yellow').removeClass('red').addClass('blue');
                    statusBar.html(statusBar.data('active'));

                    self.find('.qr-code').removeClass('hidden');
                }

                fillClock(self.find('.js-session-data-clock-start'), deltaDate);
            }

            deltaDate = new Date(dateClose.getTime() - date.getTime() + timezoneOffset);

            if (deltaDate.getTime() <= timezoneOffset) {
                deltaDate = new Date(timezoneOffset);

                self.find('.js-session-data-clock-end').addClass('red');

                statusBar.removeClass('blue').removeClass('yellow').addClass('red');
                statusBar.html(statusBar.data('notactive'));

                self.find('.qr-code').addClass('hidden');

                clearInterval(popupInterval);

                return;
            }

            fillClock(self.find('.js-session-data-clock-end'), deltaDate);

        });
    });

};

var popupAdditionalActions = function(){
    
    $(document).on('change', '#popup .session-create select, #popup .session-create .js-active_at', function() {
        var self = $(this);
        var parent = self.parents('.session-create');

        var userTypeElement = parent.find('.js-usertype > option:selected, .js-usertype > option');

        var userType = userTypeElement.length > 0;
        var group = true;

        var activeAtElement = parent.find('.js-active_at');
        var activeAt = activeAtElement.length == 0 || activeAtElement.val().length > 0;

        var usersCountElement = parent.find('.js-session-info-users-count');
        var usersCount = 0;

        if (userType && userTypeElement.data("checkgroup")) {

            group = parent
            .find('.js-usergroup > option:selected, .js-usergroup > option')
            .each(function(){
                usersCount += parseInt($(this).data('users-count'));
            })
            .length > 0;

            parent.find('.js-usergroup').removeClass('disabled');
        } else {
            group = true;
            parent.find('.js-usergroup').addClass('disabled');
            usersCount = parseInt(userTypeElement.data('users-count'));
        }

        usersCountElement.toggleClass('red', usersCount == 0);
        usersCountElement.html(usersCount);
        
        parent.find('.js-session-create').toggleClass('disabled', !(userType && group && activeAt));

    });
    
};

$(function(){
    refreshSelects();
    updateScrollbars();

    /* Drop Down close */
    $(document).on('click', function(e){
        e.preventDefault();
        var v = $(e.target);
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
        clearTimeout(popupTimer);
    });

    $(document).on('click',  '.popup-toggle', function(e){
        e.preventDefault();
        if ($(this).attr('popup-handler-before'))
            $("#popup").trigger($(this).attr('popup-handler-before'), this, true);

        clearInterval(popupInterval);
        clearTimeout(popupTimer);

        $("#popup").html("");
        $('.popup_stack > ' + $(this).attr('popup-target')).clone().appendTo("#popup");

        if ($(this).attr('popup-handler'))
            $("#popup").trigger($(this).attr('popup-handler'), this, null);

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

    popupHandlers();
    popupAdditionalActions();

});