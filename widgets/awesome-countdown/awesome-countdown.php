<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Awesome_Countdown extends Widget_Base {

    public function get_name() { return 'awea_countdown'; }
    public function get_title() { return esc_html__('Countdown', 'awesome-widgets-elementor'); }
    public function get_icon() { return 'eicon-countdown'; }
    public function get_categories() { return ['awesome-widgets-elementor']; }

    protected function register_controls() {

        // --- SECTION: TIMER SETTINGS ---
        $this->start_controls_section('awea_section_timer', [
            'label' => __( 'Countdown Settings', 'awesome-widgets-elementor' ),
        ]);

        $this->add_control('awea_due_date', [
            'label' => __( 'Due Date', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::DATE_TIME,
            'default' => gmdate('Y-m-d H:i', strtotime('+1 month')),
        ]);

        $this->add_control('awea_expire_type', [
            'label' => __('Expire Type', 'awesome-widgets-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'message'  => __('Message', 'awesome-widgets-elementor'),
                'redirect' => __('Redirect to Link', 'awesome-widgets-elementor')
            ],
            'default' => 'message'
        ]);

        $this->add_control('awea_expire_message', [
            'label' => __('Expire Message', 'awesome-widgets-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Sorry you are late!', 'awesome-widgets-elementor'),
            'condition' => ['awea_expire_type' => 'message']
        ]);

        $this->add_control('awea_expire_link', [
            'label' => __('Redirect Link', 'awesome-widgets-elementor'),
            'type' => Controls_Manager::URL,
            'condition' => ['awea_expire_type' => 'redirect']
        ]);

        $this->end_controls_section();

        // --- SECTION: LABELS ---
        $this->start_controls_section('awea_section_labels', [
            'label' => __( 'Labels', 'awesome-widgets-elementor' ),
        ]);

        $this->add_control('awea_label_days', [ 'label' => __('Days', 'awesome-widgets-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'Days' ]);
        $this->add_control('awea_label_hours', [ 'label' => __('Hours', 'awesome-widgets-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'Hours' ]);
        $this->add_control('awea_label_mins', [ 'label' => __('Minutes', 'awesome-widgets-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'Mins' ]);
        $this->add_control('awea_label_secs', [ 'label' => __('Seconds', 'awesome-widgets-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'Secs' ]);

        $this->end_controls_section();

        // --- SECTION: STYLE LAYOUT ---
        $this->start_controls_section('awea_style_layout', [
            'label' => __( 'Layout', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs( 'awea_layout_tabs' );

        // Normal Tab
        $this->start_controls_tab( 'awea_layout_normal', [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ] );

        $this->add_control(
            'awea_cell_bg_color',
            [
                'label' => 'Background Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .time-cell' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'awea_cell_border',
                'selector' => '{{WRAPPER}} .time-cell',
            ]
        );

        $this->add_responsive_control(
            'awea_cell_padding',
            [
                'label' => 'Padding',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [ '{{WRAPPER}} .time-cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_responsive_control(
            'awea_cell_radius',
            [
                'label' => 'Border Radius',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [ '{{WRAPPER}} .time-cell' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'awea_cell_gap',
            [
                'label' => 'Gap',
                'type' => Controls_Manager::SLIDER,
                'selectors' => [ '{{WRAPPER}} .timer-row' => 'gap: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'awea_layout_hover', [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ] );

        $this->add_control(
            'awea_cell_bg_color_hover',
            [
                'label' => 'Background Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .time-cell:hover' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_cell_border_hover',
            [
                'label' => 'Border Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .time-cell:hover' => 'border-color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        // --- SECTION: STYLE CONTENT ---
        $this->start_controls_section('awea_style_content', [
            'label' => __( 'Content', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control( 'awea_num_heading', [ 'label' => 'Number Settings', 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );
        $this->add_control(
            'awea_digit_color',
            [
                'label' => 'Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .digit' => 'color: {{VALUE}};' ],
            ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'awea_digit_typo', 'selector' => '{{WRAPPER}} .digit' ] );

        $this->add_control( 'awea_label_heading', [ 'label' => 'Label Settings', 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );
        $this->add_control(
            'awea_unit_color',
            [
                'label' => 'Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .unit' => 'color: {{VALUE}};' ],
            ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'awea_unit_typo', 'selector' => '{{WRAPPER}} .unit' ] );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = 'awea-monolith-' . $this->get_id();
        ?>
        <div class="monolith-wrap" id="<?php echo esc_attr($id); ?>">
            <div class="timer-row main-timer-display">
                <div class="time-cell"><span class="digit days">00</span><span class="unit"><?php echo esc_html($settings['awea_label_days']); ?></span></div>
                <div class="time-cell"><span class="digit hours">00</span><span class="unit"><?php echo esc_html($settings['awea_label_hours']); ?></span></div>
                <div class="time-cell"><span class="digit minutes">00</span><span class="unit"><?php echo esc_html($settings['awea_label_mins']); ?></span></div>
                <div class="time-cell"><span class="digit seconds">00</span><span class="unit"><?php echo esc_html($settings['awea_label_secs']); ?></span></div>
            </div>
            <div class="awea-finished"><?php echo esc_html($settings['awea_expire_message']); ?></div>
        </div>

        <script>
        (function($) {
            const runWidget = () => {
                const targetDate = new Date("<?php echo esc_js($settings['awea_due_date']); ?>").getTime();
                const $container = $('#<?php echo esc_attr($id); ?>');

                const interval = setInterval(function() {
                    const now = new Date().getTime();
                    const diff = targetDate - now;

                    if (diff <= 0) {
                        clearInterval(interval);
                        <?php if($settings['awea_expire_type'] === 'message'): ?>
                            $container.find('.main-timer-display').hide();
                            $container.find('.awea-finished').fadeIn();
                        <?php else: ?>
                            window.location.href = "<?php echo esc_url($settings['awea_expire_link']['url']); ?>";
                        <?php endif; ?>
                        return;
                    }

                    const d = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const s = Math.floor((diff % (1000 * 60)) / 1000);

                    $container.find('.days').text(d.toString().padStart(2, '0'));
                    $container.find('.hours').text(h.toString().padStart(2, '0'));
                    $container.find('.minutes').text(m.toString().padStart(2, '0'));
                    $container.find('.seconds').text(s.toString().padStart(2, '0'));
                }, 1000);
            };

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    if (entries[0].isIntersecting) {
                        runWidget();
                        observer.unobserve(entries[0].target);
                    }
                }, { threshold: 0.1 });
                observer.observe(document.getElementById('<?php echo esc_attr($id); ?>'));
            } else {
                runWidget();
            }
        })(jQuery);
        </script>

        <?php
    }
}