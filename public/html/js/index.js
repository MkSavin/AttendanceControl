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

$(function(){
    refreshSelects();

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
    });

    $(document).on('click', 'input[type=reset]', function(){
        setTimeout(() => {
            $('form select').selectpicker('refresh');
        }, 10);
    });

});