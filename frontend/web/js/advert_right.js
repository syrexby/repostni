$( document ).ready(function() {
    var height = $('.qweqwe .owl-wrapper-outer');
    var button = $('.show__more');

    height.css("height", "1040px");
    button.on('click',function(){
        height.css("height", "100%");
        button.css("display", "none");
    });
});
