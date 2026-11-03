// Initialize when Elementor frontend is ready
jQuery(window).on('elementor/frontend/init', function () {

    // Products Carousel Widget
    elementorFrontend.hooks.addAction('frontend/element_ready/awesome-product-carousel.default', function ($scope, $) {
        var products_carousel = $scope.find('.awea-products-carousel');

        var products_arrows = products_carousel.attr('awea-products-arrows') === 'yes';
        var products_dots = products_carousel.attr('awea-products-dots') === 'yes';
        var products_autoplay = products_carousel.attr('awea-products-autoplay') === 'yes';
        var products_pause = products_carousel.attr('awea-products-pause') === 'yes';
        var products_scroll = parseInt(products_carousel.attr('awea-products-scroll')) || 3;
        var products_loop = products_carousel.attr('awea-products-loop') === 'yes';
        var autoplay_speed = parseInt(products_carousel.attr('awea-products-autoplay-speed')) || 3000;
        var autoplay_animation = parseInt(products_carousel.attr('awea-products-autoplay-animation')) || 5000;

    
        products_carousel.owlCarousel({
            nav: products_arrows,
            dots: products_dots,
            loop: products_loop,
            autoplay: products_autoplay,
            autoplayHoverPause: products_pause,
            autoplaySpeed: autoplay_speed,
            margin: 20,
            autoHeight: true,
            autoplayTimeout: autoplay_animation,
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
                    items: 2,
                    nav: false
                },
                1000: {
                    items: products_carousel.attr('awea-products-scroll'),
                    nav: products_carousel.attr('awea-products-arrows'),
                    loop: products_carousel.attr('awea-products-loop'),
                }
            },
            onInitialized: function (event) {
                equalizeProductHeightsByRow(event);
            },
            onTranslated: function (event) {
                equalizeProductHeightsByRow(event);
            }
        });
    
        function equalizeProductHeightsByRow(event) {
            var $currentSlide = $(event.target).find('.owl-item.active');
            var $products = $currentSlide.find('.awea-single-product');
    
            // Reset heights
            $products.css('height', 'auto');
    
            var rowHeights = [];
    
            $products.each(function () {
                var $product = $(this);
                var productTop = $product.position().top;
    
                if (typeof rowHeights[productTop] === 'undefined') {
                    rowHeights[productTop] = 0;
                }
    
                rowHeights[productTop] = Math.max(rowHeights[productTop], $product.outerHeight());
            });
    
            $products.each(function () {
                var $product = $(this);
                var productTop = $product.position().top;
    
                $product.outerHeight(rowHeights[productTop]);
            });
        }
    });   


    // Filter Gallery Widget
elementorFrontend.hooks.addAction('frontend/element_ready/webbricks-filter-gallery-widget.default', function ($scope, $) {
    function equalizeImageHeights() {
        var maxHeight = 0;

        $(".awea-grid-active .awea-single-filter-gallery img").each(function() {
            $(this).height('auto'); // Reset height to auto
            var currentHeight = $(this).height();
            maxHeight = currentHeight > maxHeight ? currentHeight : maxHeight;
        });

        $(".awea-grid-active .awea-single-filter-gallery img").height(maxHeight);
    }

    // Initialize Isotope
    var grid = $(".awea-grid-active").isotope({
        itemSelector: ".awea-grid-item",
        percentPosition: true,
        masonry: {
            columnWidth: ".awea-grid-item"
        }
    });

    // Ensure images are loaded before initializing Isotope and calculating heights
    $(".awea-grid-item img").imagesLoaded(function () {
        grid.isotope(); // Re-layout after loading images
        equalizeImageHeights(); // Equalize heights after images are loaded
    });

    // Filter Gallery Menu Click
    $(".awea-filter-gallery-menu").on("click", "button", function () {
        var filterValue = $(this).attr("data-filter");
        grid.isotope({ filter: filterValue });

        // Equalize image heights after filtering
        setTimeout(function() {
            equalizeImageHeights();
        }, 300); // Adjust the timeout as needed

        // Isotope Menu Active
        $(this).addClass("active").siblings().removeClass("active");
    });

    // Ensure images are loaded before recalculating heights after filtering
    grid.on('arrangeComplete', function() {
        $(".awea-grid-item img").imagesLoaded(function () {
            equalizeImageHeights();
        });
    });
});


});