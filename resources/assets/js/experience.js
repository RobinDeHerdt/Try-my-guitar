$("#level-window").click(function(){
    $(this).hide();
}).animate({
    top: $(window).height() / 4,
}, 500, function() {
    $(this).animate({
        top: "-90px",
    }, 500)
}).delay(4000);

$("#exp-window").click(function(){
    $(this).hide();
}).animate({
    top: $(window).height() / 8,
}, 500, function() {
    $(this).animate({
        top: "-90px",
    }, 500)
}).delay(3000);