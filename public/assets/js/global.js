$(document).ready(function() {

    $('a[href*="#content-"]').click(function(e) {
        e.preventDefault();
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 500);
                return false;
            }
        }
    });

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

    $('#product-carousel').find('.item').first().addClass('active');

    var caption = $('#product-carousel div.item');
    $('.car_left .carousel-title').html(caption.first().find('h1').html());
    $('.car_left .carousel-subtitle').html(caption.first().find('p').html());
    caption.css('display', 'none');

    $('#product-carousel').on('slide.bs.carousel', function(ev) {
        var caption = $('#product-carousel .item:nth-child(' + ($(ev.relatedTarget).index() + 1) + ') .carousel-caption');
        console.log($(ev.relatedTarget).index());

        $('.car_left .carousel-title').html(caption.find('h1').html());
        $('.car_left .carousel-subtitle').html(caption.find('p').html());
        caption.css('display', 'none');
    });
});