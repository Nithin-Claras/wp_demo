$(function () {
    /** ALL CLICKS **/


    /** ONE TIME INIT **/
    root.setup(1);

    $(window).resize(function () {
        root.setup(0);
    });

    $(window).scroll(root.scrollEvent);
});

$(window).on('load', function () {
    root.scrollEvent();
});

$('body').on('click', '.filter_button ', function (e) {
    e.preventDefault();
    var take = $("option:selected").val();
    if (take != '') {
        $(this).attr("href", "?g=" + take);
        window.location.replace(this.href);
    }
});

$('body').ready(function () {
    $('html, body').animate({
        scrollTop: $('#filter_artist_scroll').offset().top
    }, 'slow');
    SetClass();
});

$('body') .on('click', '.ftr', function (e) {
    e.preventDefault();
    var take = $(this).attr('href');
    console.log(take);
    if (take != '') {
        $(this).attr("href", "?g=" + take);
        window.location.replace(this.href);
    }
});

// $('body').on('click', '.reset_btn ', function (e) {
//     e.preventDefault();
//     var take = $("option:selected").val();
//     if (take != '') {
//         $(this).attr("href", "?all=1" + took);
//         window.location.replace(this.href);
//     }
// });


