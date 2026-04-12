<?php
/**
 * Awesome Progress Bar Widget.
 *
 * @since 1.0.0
 */
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Progress_Bar extends Widget_Base {

    public function get_name() {
        return 'awesome-progress-bar';
    }

    public function get_title() {
        return esc_html__( 'Progress Bar', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-skill-bar';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'step', 'awesome', 'progress', 'circle' ];
    }

    protected function register_controls() {

        // --- Content Section ---
        $this->start_controls_section(
            'awea_progress_section_content',
            [
                'label' => esc_html__( 'Progress Settings', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_progress_layout_style',
            [
                'label' => esc_html__( 'Style', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'circle',
                'options' => [
                    'circle' => esc_html__( 'Premium Circle', 'awesome-widgets-elementor' ),
                    'line'   => esc_html__( 'Horizontal Bar', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'awea_progress_title',
            [
                'label' => esc_html__( 'Label', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Accuracy', 'awesome-widgets-elementor' ),
                'placeholder' => esc_html__( 'Enter your title', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_progress_percent',
            [
                'label' => esc_html__( 'Percentage', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 75,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        // --- Style Section ---
        $this->start_controls_section(
            'awea_progress_section_style',
            [
                'label' => esc_html__( 'Visual Style', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_progress_accent_color',
            [
                'label' => esc_html__( 'Progress Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .progress-circle' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .line-fill' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_progress_track_color',
            [
                'label' => esc_html__( 'Track Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f2f2f7',
                'selectors' => [
                    '{{WRAPPER}} .track' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .line-track' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_progress_title_typography',
                'label' => esc_html__( 'Label Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .label',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $target_percent = $settings['awea_progress_percent']['size'];
        $id = $this->get_id();
        ?>

        <style>
            .awesome-canvas-<?php echo esc_attr( $id ); ?> {
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .awesome-canvas-<?php echo esc_attr( $id ); ?> svg {
                transform: rotate(-90deg);
                width: 100%;
                height: 100%;
            }
            .awesome-canvas-<?php echo esc_attr( $id ); ?> circle {
                fill: none;
                stroke-width: 8;
                stroke-linecap: round;
            }
            .awesome-canvas-<?php echo esc_attr( $id ); ?> .progress-circle {
                stroke-dasharray: 283;
                stroke-dashoffset: 283;
                transition: stroke-dashoffset 2s cubic-bezier(0.19, 1, 0.22, 1);
            }
            .awesome-canvas-<?php echo esc_attr( $id ); ?> .content {
                position: absolute;
                text-align: center;
                display: flex;
                flex-direction: column;
            }
            .awesome-canvas-<?php echo esc_attr( $id ); ?> .percent {
                font-family: 'JetBrains Mono', monospace;
                font-size: 2.2rem;
                font-weight: 500;
                color: #1c1c1e;
            }
            .awesome-canvas-<?php echo esc_attr( $id ); ?> .label {
                font-size: 0.7rem;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: #8e8e93;
            }

            /* Line Style */
            .line-container { width: 100%; padding: 10px 0; }
            .line-track { height: 10px; background: #eee; border-radius: 10px; overflow: hidden; position: relative; }
            .line-fill { height: 100%; width: 0; transition: width 2s cubic-bezier(0.19, 1, 0.22, 1); border-radius: 10px; }
            .line-meta { display: flex; justify-content: space-between; margin-bottom: 8px; }
        </style>

        <?php if ( 'circle' === $settings['awea_progress_layout_style'] ) : ?>
            <div class="awesome-canvas-<?php echo esc_attr( $id ); ?>" id="trigger-<?php echo esc_attr( $id ); ?>">
                <svg viewBox="0 0 100 100">
                    <circle class="track" cx="50" cy="50" r="45"></circle>
                    <circle class="progress-circle" id="circle-<?php echo esc_attr( $id ); ?>" cx="50" cy="50" r="45"></circle>
                </svg>
                <div class="content">
                    <span class="percent" id="count-<?php echo esc_attr( $id ); ?>">0%</span>
                    <span class="label"><?php echo esc_html( $settings['awea_progress_title'] ); ?></span>
                </div>
            </div>
        <?php else : ?>
            <div class="line-container" id="trigger-<?php echo esc_attr( $id ); ?>">
                <div class="line-meta">
                    <span class="label"><?php echo esc_html( $settings['awea_progress_title'] ); ?></span>
                    <span class="percent" id="count-<?php echo esc_attr( $id ); ?>" style="font-weight: bold;">0%</span>
                </div>
                <div class="line-track">
                    <div class="line-fill" id="fill-<?php echo esc_attr( $id ); ?>"></div>
                </div>
            </div>
        <?php endif; ?>

        <script>
        jQuery(document).ready(function($) {
            const target = <?php echo (int) $target_percent; ?>;
            const id = "<?php echo esc_js( $id ); ?>";
            const type = "<?php echo esc_js( $settings['awea_progress_layout_style'] ); ?>";
            
            // Intersection Observer to start animation when visible
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateWidget();
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            const triggerEl = document.getElementById('trigger-' + id);
            if (triggerEl) {
                observer.observe(triggerEl);
            }

            function animateWidget() {
                if (type === 'circle') {
                    const circle = document.getElementById('circle-' + id);
                    if (circle) {
                        const circumference = 283;
                        const offset = circumference - (target / 100) * circumference;
                        circle.style.strokeDashoffset = offset;
                    }
                } else {
                    const fill = document.getElementById('fill-' + id);
                    if (fill) {
                        fill.style.width = target + '%';
                    }
                }

                const countEl = document.getElementById('count-' + id);
                if (!countEl) return;

                let current = 0;
                const duration = 2000;
                const startTime = performance.now();

                function update(timestamp) {
                    const elapsed = timestamp - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const easedProgress = 1 - Math.pow(1 - progress, 3);
                    current = Math.floor(easedProgress * target);
                    countEl.innerText = current + '%';
                    if (progress < 1) requestAnimationFrame(update);
                }
                requestAnimationFrame(update);
            }
        });
        </script>
        <?php
    }
}