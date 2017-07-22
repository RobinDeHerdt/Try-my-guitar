$("#top-menu-open").click(function() {
    $(this).hide();
    $(".top-menu-collapse").show();
    $("#top-menu-close").show();

    $(".admin-authenticated").addClass("open-top-menu");
});

$("#top-menu-close").click(function() {
    $(".top-menu-collapse").hide();
    $("#top-menu-open").show();
    $(".admin-authenticated").removeClass("open-top-menu");
});