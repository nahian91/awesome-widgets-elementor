<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Awesome_Counter extends Widget_Base {

    public function get_name() { 
        return 'awesome-counter'; 
    }

    public function get_title() { 
        return esc_html__( 'Counter', 'awesome-widgets-elementor' ); 
    }

    public function get_icon() { 
        return 'eicon-countdown'; 
    }

    public function get_categories() { 
        return [ 'awesome-widgets-elementor' ]; 
    }

    protected function register_controls() {

        // --- CONTENT SECTION ---
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_counter_icon',
            [
                'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-rocket',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'awea_counter_number',
            [
                'label'   => esc_html__( 'Target Number', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 150,
            ]
        );

        $this->add_control(
            'awea_counter_number_suffix',
            [
                'label'   => esc_html__( 'Suffix', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '+',
            ]
        );

        $this->add_control(
            'awea_counter_title',
            [
                'label'   => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Sprints Completed', 'awesome-widgets-elementor' ),
            ]
        );

        $this->end_controls_section();

        // --- STYLE: CARD LAYOUT ---
        $this->start_controls_section(
            'section_style_layout',
            [
                'label' => esc_html__( 'Card Layout', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [ '{{WRAPPER}} .counter-card' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [ 'top' => '50', 'right' => '25', 'bottom' => '50', 'left' => '25', 'unit' => 'px' ],
                'selectors'  => [ '{{WRAPPER}} .counter-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_responsive_control(
            'card_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px' ],
                'selectors'  => [ '{{WRAPPER}} .counter-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border',
                'selector' => '{{WRAPPER}} .counter-card',
            ]
        );

        $this->add_control(
            'trace_color',
            [
                'label'     => esc_html__( 'Border Hover (Trace)', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6366f1',
                'description' => 'This color powers the trace animation and icon hover state.'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_shadow',
                'selector' => '{{WRAPPER}} .counter-card',
            ]
        );

        $this->end_controls_section();

        // --- STYLE: ICON ---
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f1f5f9',
                'selectors' => [ '{{WRAPPER}} .icon-box' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'icon_color_style',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#64748b',
                'selectors' => [ '{{WRAPPER}} .icon-box svg' => 'fill: {{VALUE}};' ],
            ]
        );

        $this->add_responsive_control(
            'icon_size_slider',
            [
                'label'     => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 10, 'max' => 100 ] ],
                'selectors' => [
                    '{{WRAPPER}} .icon-box i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .icon-box svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_box_width',
            [
                'label'     => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 30, 'max' => 200 ] ],
                'selectors' => [ '{{WRAPPER}} .icon-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: TYPOGRAPHY ---
        $this->start_controls_section(
            'section_style_typo',
            [
                'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control( 'head_num', [ 'label' => 'Number', 'type' => Controls_Manager::HEADING ] );
        $this->add_control(
            'num_color_style',
            [
                'label'     => 'Color',
                'type'      => Controls_Manager::COLOR,
                'default'   => '#0f172a',
                'selectors' => [ '{{WRAPPER}} .stat-value' => 'color: {{VALUE}}' ]
            ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'num_typo', 'selector' => '{{WRAPPER}} .stat-value' ] );

        $this->add_control( 'head_title_style', [ 'label' => 'Title', 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );
        $this->add_control(
            'title_color_style',
            [
                'label'     => 'Color',
                'type'      => Controls_Manager::COLOR,
                'default'   => '#64748b',
                'selectors' => [ '{{WRAPPER}} .label' => 'color: {{VALUE}}' ]
            ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'title_typo', 'selector' => '{{WRAPPER}} .label' ] );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $unique_id = 'awea-count-' . $this->get_id();
        $primary   = !empty($settings['trace_color']) ? $settings['trace_color'] : '#6366f1';
        ?>

        <div class="counter-card" id="<?php echo esc_attr($unique_id); ?>">
            <div class="icon-box">
                <?php Icons_Manager::render_icon( $settings['awea_counter_icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </div>
            <div class="stat-holder">
                <span class="stat-value awea-num" data-target="<?php echo esc_attr($settings['awea_counter_number']); ?>">0</span>
                <span class="symbol"><?php echo esc_html($settings['awea_counter_number_suffix']); ?></span>
            </div>
            <p class="label"><?php echo esc_html($settings['awea_counter_title']); ?></p>
        </div>

        <script>
        (function($) {
            const runCounter = ($scope) => {
                const $card = $scope.find('.counter-card');
                const $num = $scope.find('.awea-num');
                const target = parseInt($num.data('target'));
                
                if ($card.hasClass('animated')) return;

                $({ countNum: 0 }).animate({ countNum: target }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function() {
                        $num.text(Math.floor(this.countNum).toLocaleString());
                    },
                    complete: function() {
                        $num.text(target.toLocaleString());
                        $card.addClass('animated');
                    }
                });
            };

            const handler = ($scope) => {
                const el = $scope.find('.counter-card')[0];
                const observer = new IntersectionObserver((entries) => {
                    if (entries[0].isIntersecting) {
                        runCounter($scope);
                        observer.unobserve(el);
                    }
                }, { threshold: 0.2 });

                if (el) observer.observe(el);
            };

            $(window).on('elementor/frontend/init', () => {
                elementorFrontend.hooks.addAction('frontend/element_ready/awesome-counter.default', handler);
            });
        })(jQuery);
        </script>
        <?php
    }
}