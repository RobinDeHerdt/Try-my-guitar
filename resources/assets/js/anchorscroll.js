if(location.hash.slice(1)) {
    $('html,body').animate({
        scrollTop: $("#" + location.hash.slice(1)).offset().top - 70
    }, 1000 );
}