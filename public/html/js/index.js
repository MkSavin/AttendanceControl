var is_mobile = ((/Mobile|iPhone|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera) ? true : false);

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
    $('.jq-datepicker').datepicker({position: "top center"});
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
    });

    $(document).on('click',  '.popup-toggle', function(e){
        e.preventDefault();
        if ($(this).attr('popup-handler-before'))
            $("#popup").trigger($(this).attr('popup-handler-before'), this, true);

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

    $("#popup").on('popup-session-create-momental', function(e, button, when) {
        $(this).find('.js-timed').addClass('d-none');
        $(this).find('.js-momental').removeClass('d-none');
        $(this).find('.js-nonmomental').remove();

        $(this).find('.window').addClass('momental');

        $(this).find('select').first().trigger('change');
    });

    $("#popup").on('popup-session-create-timed', function(e, button, when) {
        $(this).find('.js-nontimed').remove();
        $(this).find('.js-momental').addClass('d-none');
        $(this).find('.js-timed').removeClass('d-none');

        $(this).find('.window').addClass('timed');

        $(this).find('select').first().trigger('change');
    });

    $(document).on('click', 'input[type=reset]', function(){
        $(this).parents('form').find('select').selectpicker('val', '');
        $(this).parents('form').find('select').trigger('change');
    });

    $(document).on('click', '.qr-code', function(){
        $(this).toggleClass('hidden');
    });

    $(document).on('change', '#popup .session-create select, #popup .session-create .js-active_at', function() {
        var self = $(this);
        var parent = self.parents('.session-create');

        var userTypeElement = parent.find('.js-usertype > option:selected');

        var userType = userTypeElement.length > 0;
        var group = true;

        var activeAtElement = parent.find('.js-active_at');
        var activeAt = activeAtElement.length == 0 || activeAtElement.val().length > 0;

        if (userType && userTypeElement.data("checkgroup")) {
            group = parent.find('.js-usergroup > option:selected').length > 0;
            parent.find('.js-usergroup').removeClass('disabled');
        } else {
            group = true;
            parent.find('.js-usergroup').addClass('disabled');
        }

        parent.find('.js-session-create').toggleClass('disabled', !(userType && group && activeAt));

    });

    $(document).on('click', '.js-window-close', function(){
        window.close();
    });

});