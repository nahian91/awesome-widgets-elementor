jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/awesome-slider.default', function ($scope, $) {
        var $slider = $scope.find('.awea-slider');

        if (!$slider.length) {
            return;
        }

        var showArrows  = $slider.data('arrows') === true || $slider.data('arrows') === 'true';
        var showDots    = $slider.data('dots') === true || $slider.data('dots') === 'true';
        var loop        = $slider.data('loop') === true || $slider.data('loop') === 'true';
        var pauseHover  = $slider.data('pause') === true || $slider.data('pause') === 'true';
        var autoplay    = $slider.data('autoplay') === true || $slider.data('autoplay') === 'true';
        var autoDelay   = parseInt($slider.data('delay'), 10) || 8000;
        var animSpeed   = parseInt($slider.data('speed'), 10) || 1000;

        $slider.owlCarousel({
            items: 1,
            nav: showArrows,
            dots: showDots,
            loop: loop,
            autoplay: autoplay,
            autoplayTimeout: autoDelay,
            smartSpeed: animSpeed,
            autoplayHoverPause: pauseHover,
            margin: 0,
            navText: [
                '<i class="fas fa-chevron-left" aria-label="Previous"></i>',
                '<i class="fas fa-chevron-right" aria-label="Next"></i>'
            ],
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                769: {
                    items: 1,
                    nav: showArrows
                }
            }
        });
    });
});