<?php
/**
 * Awesome Progress Bar Studio Widget.
 * Architectural Circular & Linear Progress Meters with Kinetic Counters.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
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
        return [ 'awea', 'progress bar', 'skill bar', 'circle progress', 'meter', 'percentage', 'counter' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: PROGRESS METRICS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_progress_content',
            [
                'label' => esc_html__( 'Progress Metrics', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_layout_style',
            [
                'label'   => esc_html__( 'Meter Layout Style', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'circle',
                'options' => [
                    'circle' => esc_html__( 'Radial Circle Meter', 'awesome-widgets-elementor' ),
                    'line'   => esc_html__( 'Horizontal Linear Bar', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'awea_title',
            [
                'label'       => esc_html__( 'Label Text', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'System Accuracy', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_percent',
            [
                'label'   => esc_html__( 'Target Percentage', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                    'size' => 85,
                ],
                'range'   => [
                    '%' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
            ]
        );

        $this->add_control(
            'awea_duration',
            [
                'label'       => esc_html__( 'Counter Animation Duration (ms)', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 1800,
                'min'         => 300,
                'max'         => 8000,
                'step'        => 100,
                'description' => esc_html__( 'Duration of the kinetic fill and number counter in milliseconds.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_suffix',
            [
                'label'       => esc_html__( 'Percentage Suffix', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '%',
                'dynamic'     => [ 'active' => true ],
                'description' => esc_html__( 'Optional character appended after the counter number (e.g., %, k, x).', 'awesome-widgets-elementor' ),
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: LAYOUT & SIZING
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_layout',
            [
                'label' => esc_html__( 'Layout & Sizing', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_circle_dimension',
            [
                'label'      => esc_html__( 'Circle Diameter', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vw' ],
                'range'      => [
                    'px' => [ 'min' => 100, 'max' => 500 ],
                    'vw' => [ 'min' => 10, 'max' => 60 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 200 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-radial-container' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'awea_layout_style' => 'circle' ],
            ]
        );

        $this->add_responsive_control(
            'awea_line_max_width',
            [
                'label'      => esc_html__( 'Bar Maximum Width', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range'      => [
                    'px' => [ 'min' => 150, 'max' => 1200 ],
                    '%'  => [ 'min' => 10, 'max' => 100 ],
                ],
                'default'    => [ 'unit' => '%', 'size' => 100 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-linear-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'awea_layout_style' => 'line' ],
            ]
        );

        $this->add_responsive_control(
            'awea_container_alignment',
            [
                'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .awea-progress-wrapper' => 'display: flex; justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_wrapper_padding',
            [
                'label'      => esc_html__( 'Container Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-progress-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: TRACK & FILL
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_colors',
            [
                'label' => esc_html__( 'Track & Fill Visuals', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_heading_fill',
            [
                'label' => esc_html__( 'Active Progress Fill', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'awea_accent_color',
            [
                'label'     => esc_html__( 'Fill Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-progress-circle-fill' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .awea-line-fill'           => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_fill_glow',
            [
                'label'     => esc_html__( 'Ambient Glow Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(79, 70, 229, 0.25)',
                'selectors' => [
                    '{{WRAPPER}} .awea-progress-circle-fill' => 'filter: drop-shadow(0 0 6px {{VALUE}});',
                    '{{WRAPPER}} .awea-line-fill'           => 'box-shadow: 0 0 12px {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_heading_track',
            [
                'label'     => esc_html__( 'Background Track', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_track_color',
            [
                'label'     => esc_html__( 'Track Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(15, 23, 42, 0.08)',
                'selectors' => [
                    '{{WRAPPER}} .awea-progress-track' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .awea-line-track'     => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_stroke_width',
            [
                'label'      => esc_html__( 'Circle Stroke Width', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 2, 'max' => 24 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 8 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-progress-svg circle' => 'stroke-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'awea_layout_style' => 'circle' ],
                'separator'  => 'before',
            ]
        );

        $this->add_control(
            'awea_stroke_cap',
            [
                'label'     => esc_html__( 'Circle Stroke Cap', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'round',
                'options'   => [
                    'round'  => esc_html__( 'Round (Smooth End)', 'awesome-widgets-elementor' ),
                    'butt'   => esc_html__( 'Flat (Square End)', 'awesome-widgets-elementor' ),
                    'square' => esc_html__( 'Protruding Square', 'awesome-widgets-elementor' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-progress-svg circle' => 'stroke-linecap: {{VALUE}};',
                ],
                'condition' => [ 'awea_layout_style' => 'circle' ],
            ]
        );

        $this->add_responsive_control(
            'awea_line_height',
            [
                'label'      => esc_html__( 'Bar Height', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 4, 'max' => 36 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 10 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-line-track, {{WRAPPER}} .awea-line-fill' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'awea_layout_style' => 'line' ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'awea_line_radius',
            [
                'label'      => esc_html__( 'Bar Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-line-track, {{WRAPPER}} .awea-line-fill' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [ 'awea_layout_style' => 'line' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: TYPOGRAPHY & LABELS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_typography',
            [
                'label' => esc_html__( 'Typography & Labels', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Digits Typography
        $this->add_control(
            'awea_heading_digits',
            [
                'label' => esc_html__( 'Percentage Digits', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'awea_digit_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-progress-percent' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_digit_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-progress-percent',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_digit_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Digits', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 4 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-radial-content .awea-progress-percent' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'awea_layout_style' => 'circle' ],
            ]
        );

        // Label Typography
        $this->add_control(
            'awea_heading_label',
            [
                'label'     => esc_html__( 'Description Label', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_label_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-progress-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_label_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-progress-label',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_linear_meta_margin_bottom',
            [
                'label'      => esc_html__( 'Space Between Header & Linear Bar', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 4, 'max' => 40 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 10 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-linear-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'awea_layout_style' => 'line' ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings  = $this->get_settings_for_display();
        $style     = $settings['awea_layout_style'] ?? 'circle';
        $target    = ! empty( $settings['awea_percent']['size'] ) ? absint( $settings['awea_percent']['size'] ) : 0;
        $label     = $settings['awea_title'] ?? '';
        $duration  = ! empty( $settings['awea_duration'] ) ? absint( $settings['awea_duration'] ) : 1800;
        $suffix    = $settings['awea_suffix'] ?? '%';
        $widget_id = $this->get_id();
        ?>
        <div class="awea-progress-wrapper awea-style-<?php echo esc_attr( $style ); ?>"
             id="awea-progress-<?php echo esc_attr( $widget_id ); ?>"
             data-target="<?php echo esc_attr( (string) $target ); ?>"
             data-duration="<?php echo esc_attr( (string) $duration ); ?>"
             data-suffix="<?php echo esc_attr( $suffix ); ?>"
             data-style="<?php echo esc_attr( $style ); ?>">

            <?php if ( 'circle' === $style ) : ?>
                <div class="awea-radial-container">
                    <svg class="awea-progress-svg" viewBox="0 0 100 100" aria-hidden="true">
                        <circle class="awea-progress-track" cx="50" cy="50" r="42"></circle>
                        <circle class="awea-progress-circle-fill" cx="50" cy="50" r="42" data-circumference="263.89"></circle>
                    </svg>
                    <div class="awea-radial-content">
                        <span class="awea-progress-percent">0<?php echo esc_html( $suffix ); ?></span>
                        <?php if ( ! empty( $label ) ) : ?>
                            <span class="awea-progress-label"><?php echo esc_html( $label ); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="awea-linear-container">
                    <div class="awea-linear-meta">
                        <?php if ( ! empty( $label ) ) : ?>
                            <span class="awea-progress-label"><?php echo esc_html( $label ); ?></span>
                        <?php endif; ?>
                        <span class="awea-progress-percent">0<?php echo esc_html( $suffix ); ?></span>
                    </div>
                    <div class="awea-line-track">
                        <div class="awea-line-fill" style="width: 0%;"></div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
        <?php
    }
}