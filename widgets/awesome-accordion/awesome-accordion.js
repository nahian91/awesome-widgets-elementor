(function ($) {
    'use strict';

    $(window).on('elementor/frontend/init', function () {

        // accordion Widget
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/awesome-accordion.default',
            function ($scope) {

                var $accordion = $scope.find('.awea-accordion');

                if (!$accordion.length) return;

                // Open first accordion item
                $accordion.find('> li:eq(0) span').addClass('active').next().slideDown();

                // Handle click
                $accordion.find('span').on('click', function (e) {
                    var $this = $(this);
                    var dropDown = $this.closest('li').find('p');

                    // Close others
                    $accordion.find('p').not(dropDown).slideUp();

                    if ($this.hasClass('active')) {
                        $this.removeClass('active');
                    } else {
                        $accordion.find('span.active').removeClass('active');
                        $this.addClass('active');
                    }

                    dropDown.stop(true, true).slideToggle();
                    e.preventDefault();
                });
            }
        );

    });

})(jQuery);
