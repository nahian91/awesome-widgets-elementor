jQuery(window).on('elementor/frontend/init', function () {

    elementorFrontend.hooks.addAction('frontend/element_ready/awesome-slider.default', function ($scope, $) {
        var slider_carousel = $scope.find('.awea-slider');

        if (!slider_carousel.length) {
            return;
        }

        // Convert attributes to booleans/numbers with new slower defaults
        var slider_arrows = slider_carousel.attr('awea-slider-arrows') === 'true';
        var slider_dots = slider_carousel.attr('awea-slider-dots') === 'true';
        var slider_loop = slider_carousel.attr('awea-slider-loops') === 'true';
        var slider_pause = slider_carousel.attr('awea-slider-pause') === 'true';
        var slider_autoplay = slider_carousel.attr('awea-slider-autoplay') === 'true';

        var slider_autoplay_speed = parseInt(slider_carousel.attr('awea-slider-autoplay-speed')) || 8000; // delay
        var slider_autoplay_animation = parseInt(slider_carousel.attr('awea-slider-autoplay-animation')) || 1200; // transition speed

        slider_carousel.owlCarousel({
            dots: slider_dots,
            nav: slider_arrows,
            margin: 0,
            autoplay: slider_autoplay,
            autoplayTimeout: slider_autoplay_speed,      // delay between slides
            autoplaySpeed: slider_autoplay_animation,    // animation speed
            autoplayHoverPause: slider_pause,
            loop: slider_loop,
            navText: [
                "<div class='awea-carousel-arrow-border'><i class='fas fa-long-arrow-alt-left'></i></div>",
                "<div class='awea-carousel-arrow-border'><i class='fas fa-long-arrow-alt-right'></i></div>"
            ],
            responsive: {
                0: { items: 1, nav: slider_arrows },
                600: { items: 1, nav: slider_arrows },
                1000: { items: 1, nav: slider_arrows, loop: slider_loop }
            }
        });
    });

});
