
$(document).ready(function () {
    $("#loading").animate({
        opacity: 0
    }, 100);
    setTimeout(function () {
        $("#loading").removeClass('isVisible');
        $("#loading").addClass('notVisible');
        $("#content").removeClass('notVisible');
        $("#content").addClass('isVisible');
        $("#content").animate({
            opacity: 1
        }, 100);
    }, 100);
});
