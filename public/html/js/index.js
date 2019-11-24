var is_mobile = ((/Mobile|iPhone|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera) ? true : false);

var updateSelects;
(updateSelects = function(){
    var selects = $('main select, #popup select');
    selects.selectpicker({
        noneSelectedText: "Ничего не выбрано",
        countSelectedText: "Элементов выбрано: {0}",
        noneResultsText: "Нет результатов по запросу {0}"
    });
})();

var refreshSelects = function(){
    var selects = $('main select, #popup select');
    selects.selectpicker({
        noneSelectedText: "Ничего не выбрано",
        countSelectedText: "Элементов выбрано: {0}",
        noneResultsText: "Не найдено: {0}"
    }, 'refresh');
};

var updateDatepicks;
(updateDatepicks = function(){
    $('.jq-datepicker').datepicker({position: "top center"});
})();

var ps1 = null;

var updateScrollbars;
(updateScrollbars = function(){
    if (!is_mobile) 
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

$(function(){
    refreshSelects();
    updateScrollbars();

    /* Drop Down close */
    $(document).on('click', function(e){
        var v = $(e.target);
        var isDD = v.hasClass('dd') || v.hasClass('dd-toggle') || v.parents('.dd').length || v.parents('.dd-toggle').length;
        if(!isDD) {
            $('.dd').addClass('dd-hidden');
            $('.dd-toggle').removeClass('active');
        }
    });

    $(document).on('click', '.dd-toggle', function(){
        $($(this).attr('dd-target')).toggleClass('dd-hidden');
        $(this).toggleClass('active');
    });

    $(document).on('click',  '.overlay-close', function(){
        $('#popup').addClass('hidden');
        $('.popup-toggle').removeClass('active');
        $('body').removeClass('nooverflow');
    });

    $(document).on('click',  '.popup-toggle', function(){
        $("#popup").html("");
        $('.popup_stack ' + $(this).attr('popup-target')).clone().appendTo("#popup");
        $("#popup").removeClass("hidden");
        $(this).addClass('active');
        $('body').addClass('nooverflow');
        
        refreshSelects();
        updateDatepicks();
        updateScrollbars();
        // refreshScrollbars();
    });

    $(document).on('click', 'input[type=reset]', function(){
        setTimeout(() => {
            $('form select').selectpicker('refresh');
        }, 10);
    });

    $(document).on('click', '.qr-code', function(){
        $(this).toggleClass('hidden');
    });

});