$(document).ready(function() {
    $('nav ul li').click(function() {
        $('nav ul li').removeClass('current');
        $(this).addClass('current');
    });
    });


        var currentUrl = window.location.href;
            $('nav ul li a').each(function() {
            if ($(this).attr('href') === currentUrl) {
                $(this).parent().addClass('current');
            }
            });