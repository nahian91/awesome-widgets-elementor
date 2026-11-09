jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/awesome-product-carousel.default', function ($scope, $) {
        var $carousel = $scope.find('.awea-product-carousel');

        if (!$carousel.length) {
            return;
        }

        var itemsDesktop = parseInt($carousel.data('items-desktop'), 10) || 3;
        var itemsTablet  = parseInt($carousel.data('items-tablet'), 10) || 2;
        var itemsMobile  = parseInt($carousel.data('items-mobile'), 10) || 1;

        var gapDesktop   = parseInt($carousel.data('gap-desktop'), 10);
        var gapTablet    = parseInt($carousel.data('gap-tablet'), 10);
        var gapMobile    = parseInt($carousel.data('gap-mobile'), 10);

        if (isNaN(gapDesktop)) gapDesktop = 24;
        if (isNaN(gapTablet)) gapTablet = 20;
        if (isNaN(gapMobile)) gapMobile = 16;

        var showArrows  = $carousel.data('arrows') === 'yes';
        var showDots    = $carousel.data('dots') === 'yes';
        var loop        = $carousel.data('loop') === 'yes';
        var autoplay    = $carousel.data('autoplay') === 'yes';
        var pauseHover  = $carousel.data('pause') === 'yes';
        var autoDelay   = parseInt($carousel.data('timeout'), 10) || 5000;
        var animSpeed   = parseInt($carousel.data('speed'), 10) || 450;

        $carousel.owlCarousel({
            nav: showArrows,
            dots: showDots,
            loop: loop,
            autoplay: autoplay,
            autoplayTimeout: autoDelay,
            smartSpeed: animSpeed,
            autoplayHoverPause: pauseHover,
            navText: [
                '<div class="awea-carousel-arrow-border" aria-label="Previous"><i class="fas fa-chevron-left"></i></div>',
                '<div class="awea-carousel-arrow-border" aria-label="Next"><i class="fas fa-chevron-right"></i></div>'
            ],
            responsive: {
                0: {
                    items: itemsMobile,
                    margin: gapMobile
                },
                768: {
                    items: itemsTablet,
                    margin: gapTablet
                },
                1025: {
                    items: itemsDesktop,
                    margin: gapDesktop
                }
            }
        });
    });
});