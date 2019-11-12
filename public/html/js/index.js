$(function(){
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
});