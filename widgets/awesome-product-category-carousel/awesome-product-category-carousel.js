// Initialize when Elementor frontend is ready
jQuery(window).on('elementor/frontend/init', function () {

    // Products Category Carousel Widget
    elementorFrontend.hooks.addAction('frontend/element_ready/awesome-product-category-carousel.default', function ($scope, $) {
        var product_category_carousel = $scope.find('.awea-product-category-carousel');
        var product_category_carousel_items = product_category_carousel.attr('awea-product-category-carousel-items');
        var product_category_carousel_arrows = product_category_carousel.attr('awea-product-category-carousel-arrows');
        var product_category_carousel_dots = product_category_carousel.attr('awea-product-category-carousel-dots');
        var product_category_carousel_loops = product_category_carousel.attr('awea-product-category-carousel-loops');
        var product_category_carousel_pause = product_category_carousel.attr('awea-product-category-carousel-pause');
        var product_category_carousel_autoplay = product_category_carousel.attr('awea-product-category-carousel-autoplay');
        var product_category_carousel_autoplay_speed = product_category_carousel.attr('awea-product-category-carousel-autoplay-speed');
        var product_category_carousel_autoplay_animation = product_category_carousel.attr('awea-product-category-carousel-autoplay-animation');

        // Initialize Owl Carousel for Product Category Carousel Widget
        product_category_carousel.owlCarousel({
            nav: product_category_carousel_arrows,
            dots: product_category_carousel_dots,
            margin: 30,
            autoplay: product_category_carousel_autoplay,
            autoplayTimeout: product_category_carousel_autoplay_animation,
            autoplaySpeed: product_category_carousel_autoplay_speed,
            autoplayHoverPause: product_category_carousel_pause,
            navText: [
                "<div class='awea-carousel-arrow-border'><i class='fas fa-long-arrow-alt-left'></i></div>",
                "<div class='awea-carousel-arrow-border'><i class='fas fa-long-arrow-alt-right'></i></div>"
            ], 
            responsive: {
                0: {
                    items: 1,
                    nav: false
                },
                600: {
                    items: 1,
                    nav: false
                },
                1000: {
                    items: product_category_carousel_items,
                    nav: product_category_carousel_arrows,
                    loop: product_category_carousel_loops,
                }
            }
        });

        function setEqualHeight() {
            var maxItemHeight = 0;
            // Reset the height of all product-category items to auto
            $('.awea-product-category-carousel .awea-product-category').css('height', 'auto');
            
            // Loop through each product-category item to find the tallest one
            $('.awea-product-category-carousel .awea-product-category').each(function() {
                var currentItemHeight = $(this).outerHeight();
                // Update the maximum item height if necessary
                if (currentItemHeight > maxItemHeight) {
                    maxItemHeight = currentItemHeight;
                }
            });
            
            // Set the height of all product-category items to the maximum item height
            $('.awea-product-category-carousel .awea-product-category').css('height', maxItemHeight);
        }
    
        // Call setEqualHeight on window load and resize
        $(window).on('load resize', function() {
            setEqualHeight();
        });
    });
});