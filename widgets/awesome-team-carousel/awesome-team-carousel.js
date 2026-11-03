// Initialize when Elementor frontend is ready
jQuery(window).on('elementor/frontend/init', function () {

    // Team Carousel Widget
    elementorFrontend.hooks.addAction('frontend/element_ready/awesome-team-carousel.default', function ($scope, $) {
        var team_carousel = $scope.find('.awea-team-carousel');
        var team_items = team_carousel.attr('awea-team-items');
        var team_arrows = team_carousel.attr('awea-team-arrows');
        var team_dots = team_carousel.attr('awea-team-dots');
        var team_loops = team_carousel.attr('awea-team-loops');
        var team_pause = team_carousel.attr('awea-team-pause');
        var team_autoplay = team_carousel.attr('awea-team-autoplay');
        var team_autoplay_speed = team_carousel.attr('awea-team-autoplay-speed');
        var team_autoplay_animation = team_carousel.attr('awea-team-autoplay-animation');

        // Initialize Owl Carousel for Team Carousel
        team_carousel.owlCarousel({
            dots: team_dots,
            nav: team_arrows,
            margin: 30,
            autoplay: team_autoplay,
            autoplayTimeout: team_autoplay_animation,
            autoplaySpeed: team_autoplay_speed,
            autoplayHoverPause: team_pause,
            loop: team_loops,
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
                    items: team_items,
                    nav: team_arrows,
                    loop: team_loops,
                }
            }
        });
    });

});