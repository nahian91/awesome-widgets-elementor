jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/awesome-post-carousel.default', function ($scope, $) {
        
        var post_carousel = $scope.find('.awea-post-carousel');
        if (!post_carousel.length) return;

        // Convert HTML attribute values to proper types
        var post_items = parseInt(post_carousel.attr('awea-post-items')) || 3;
        var post_arrows = post_carousel.attr('awea-post-arrows') === 'yes';
        var post_dots = post_carousel.attr('awea-post-dots') === 'yes';
        var post_loops = post_carousel.attr('awea-post-loops') === 'yes';
        var post_pause = post_carousel.attr('awea-post-pause') === 'yes';
        var post_autoplay = post_carousel.attr('awea-post-autoplay') === 'yes';
        var post_autoplay_speed = parseInt(post_carousel.attr('awea-post-autoplay-speed')) || 5000;
        var post_autoplay_animation = parseInt(post_carousel.attr('awea-post-autoplay-animation')) || 600; // default slide animation speed

        // Initialize Owl Carousel
        post_carousel.owlCarousel({
            dots: post_dots,
            loop: post_loops,
            autoplay: post_autoplay,
            margin: 30,
            nav: post_arrows,
            autoplayTimeout: post_autoplay_speed,
            autoplaySpeed: post_autoplay_animation,
            autoplayHoverPause: post_pause,
            items: post_items,
            navText: [
                "<div class='awea-carousel-arrow-border'><i class='fas fa-long-arrow-alt-left'></i></div>",
                "<div class='awea-carousel-arrow-border'><i class='fas fa-long-arrow-alt-right'></i></div>"
            ],
            responsive: {
                0: { items: 1, nav: false },
                600: { items: 2, nav: false },
                1000: { items: post_items, nav: post_arrows, loop: post_loops }
            },
            onInitialized: equalizeHeights,
            onResized: equalizeHeights,
            onChanged: equalizeHeights
        });

        function equalizeHeights() {
            var maxHeight = 0;
            var items = post_carousel.find('.awea-single-post-carousel');
            
            items.css('height', 'auto'); // reset height first
            items.each(function () {
                var currentHeight = $(this).outerHeight();
                if (currentHeight > maxHeight) {
                    maxHeight = currentHeight;
                }
            });
            items.css('height', maxHeight + 'px');
        }

    });
});
