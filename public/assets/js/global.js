$(document).ready(function() {

    $('#masuk').click(function(e) {
        e.preventDefault();
        $('#masuk-sistem').modal('show');

        $('.modal-open').attr('style', '');
    });

    $(window).scroll(function() {
        if ($(window).scrollTop() > 0) {
            $('.navbar')
                .css('height', '60px')
                .css('background-color', 'rgba(26,188,156,0.9)');
        } else {
            $('.navbar')
                .css('height', '100px')
                .css('background-color', 'rgba(26,188,156,1)');
        }
    });
});