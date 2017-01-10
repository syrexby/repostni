$(function () {
    var element = $("#menu__popup"), display;
    $(window).scroll(function () {
        display = $(this).scrollTop() >= 250;
        if($(this).scrollTop() <= 250){
            $("#menu__popup").removeClass('menu__fixed');
        }
        else {
            $("#menu__popup").addClass('menu__fixed');
        }
        display != element.css('opacity') && element.stop().animate({ 'opacity': display }, 0);
    });
});

