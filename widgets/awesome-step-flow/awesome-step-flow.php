<?php
/**
 * Awesome Step Flow Studio Widget.
 * Architectural Process Flow with Animated Connecting Beams & Dynamic Tags.
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
use \Elementor\Repeater;
use \Elementor\Icons_Manager;

class Widget_Awesome_Step_Flow extends Widget_Base {

    public function get_name() {
        return 'awesome-step-flow';
    }

    public function get_title() {
        return esc_html__( 'Step Flow', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-flow';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'step', 'flow', 'process', 'timeline', 'roadmap', 'workflow' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: STEP FLOW REPEATER
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_content',
            [
                'label' => esc_html__( 'Flow Steps', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'awea_step_icon',
            [
                'label'   => esc_html__( 'Step Icon', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-cube',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'awea_step_number',
            [
                'label'       => esc_html__( 'Step Number / Badge', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '01',
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_step_title',
            [
                'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Abstraction & Discovery', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_step_description',
            [
                'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'default'     => esc_html__( 'Analyze core objectives and map user pathways across your application architecture.', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'awea_steps_list',
            [
                'label'       => esc_html__( 'Steps List', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'awea_step_title'       => esc_html__( 'Discovery', 'awesome-widgets-elementor' ),
                        'awea_step_number'      => '01',
                        'awea_step_description' => esc_html__( 'Analyze core objectives and map user pathways across your product.', 'awesome-widgets-elementor' ),
                        'awea_step_icon'        => [ 'value' => 'fas fa-cube', 'library' => 'fa-solid' ],
                    ],
                    [
                        'awea_step_title'       => esc_html__( 'Processing', 'awesome-widgets-elementor' ),
                        'awea_step_number'      => '02',
                        'awea_step_description' => esc_html__( 'Execute backend workflows, state pipelines, and relational databases.', 'awesome-widgets-elementor' ),
                        'awea_step_icon'        => [ 'value' => 'fas fa-cogs', 'library' => 'fa-solid' ],
                    ],
                    [
                        'awea_step_title'       => esc_html__( 'Deployment', 'awesome-widgets-elementor' ),
                        'awea_step_number'      => '03',
                        'awea_step_description' => esc_html__( 'Push live with automated testing, CI/CD, and real-time observability.', 'awesome-widgets-elementor' ),
                        'awea_step_icon'        => [ 'value' => 'fas fa-rocket', 'library' => 'fa-solid' ],
                    ],
                ],
                'title_field' => '{{{ awea_step_number }}} - {{{ awea_step_title }}}',
            ]
        );

        $this->add_control(
            'awea_title_tag',
            [
                'label'     => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'h3',
                'options'   => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: LAYOUT & CONNECTOR BEAMS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_separator',
            [
                'label' => esc_html__( 'Connectors & Beams', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_max_width',
            [
                'label'      => esc_html__( 'Container Max Width', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range'      => [
                    'px' => [ 'min' => 300, 'max' => 1400 ],
                    '%'  => [ 'min' => 40, 'max' => 100 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 1100 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-step-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_enable_beam',
            [
                'label'        => esc_html__( 'Animated Light Beam', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_separator_color',
            [
                'label'     => esc_html__( 'Connector Track Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e2e8f0',
                'selectors' => [
                    '{{WRAPPER}} .awea-flow-connector' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_separator_hover_color',
            [
                'label'     => esc_html__( 'Light Beam Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-flow-beam' => 'background-color: {{VALUE}}; box-shadow: 0 0 10px {{VALUE}};',
                ],
                'condition' => [ 'awea_enable_beam' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'awea_connector_height',
            [
                'label'      => esc_html__( 'Connector Thickness', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 1, 'max' => 8 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 2 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-flow-connector' => 'height: {{SIZE}}{{UNIT}};',
                    '@media (max-width: 850px) { {{WRAPPER}} .awea-flow-connector { width: {{SIZE}}{{UNIT}}; } }',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_connector_speed',
            [
                'label'      => esc_html__( 'Beam Animation Speed (s)', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 's' ],
                'range'      => [ 's' => [ 'min' => 1, 'max' => 8, 'step' => 0.5 ] ],
                'default'    => [ 'unit' => 's', 'size' => 3 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-flow-beam' => 'animation-duration: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [ 'awea_enable_beam' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: SQUIRCLE ICON BOX
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_icon_badge',
            [
                'label' => esc_html__( 'Icon Box & Badge', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_box_size',
            [
                'label'      => esc_html__( 'Box Dimension', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 50, 'max' => 140 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 84 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-step-box'       => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .awea-flow-connector' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_box_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '26', 'right' => '26', 'bottom' => '26', 'left' => '26', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-step-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 14, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 28 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-step-box i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .awea-step-box svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_icon_state_tabs' );

        // Normal Box State
        $this->start_controls_tab(
            'awea_tab_icon_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-step-box i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-step-box svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_icon_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-step-box' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_box_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-step-box',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_box_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-step-box',
            ]
        );

        $this->end_controls_tab();

        // Hover Box State (No scale / No transform lift)
        $this->start_controls_tab(
            'awea_tab_icon_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_icon_hover_color',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-step-item:hover .awea-step-box i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-step-item:hover .awea-step-box svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_icon_bg_hover_color',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-step-item:hover .awea-step-box' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_icon_border_hover_color',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-step-item:hover .awea-step-box' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_box_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-step-item:hover .awea-step-box',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Number Badge Styling Subgroup
        $this->add_control(
            'awea_heading_num_style',
            [
                'label'     => esc_html__( 'Step Number Badge', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'awea_num_badge_size',
            [
                'label'      => esc_html__( 'Badge Dimension', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 20, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 32 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-step-number' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_num_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-step-number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_num_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-step-number' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_num_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-step-number',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_num_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-step-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: STEP TEXT CONTENT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_content',
            [
                'label' => esc_html__( 'Step Typography & Spacing', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_content_margin_top',
            [
                'label'      => esc_html__( 'Distance from Icon Box', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 22 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-step-content' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Title
        $this->add_control(
            'awea_heading_title_style',
            [
                'label'     => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_title_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-step-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_title_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-step-title',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_title_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Title', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 8 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-step-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Description
        $this->add_control(
            'awea_heading_desc_style',
            [
                'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_desc_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-step-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_desc_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-step-desc',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings  = $this->get_settings_for_display();
        $steps     = $settings['awea_steps_list'] ?? [];
        $title_tag = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );
        $has_beam  = ( 'yes' === ( $settings['awea_enable_beam'] ?? 'no' ) );

        if ( empty( $steps ) ) {
            return;
        }

        $total_steps = count( $steps );
        ?>
        <div class="awea-step-container">
            <?php foreach ( $steps as $index => $item ) : 
                $title  = $item['awea_step_title'] ?? '';
                $number = $item['awea_step_number'] ?? '';
                $desc   = $item['awea_step_description'] ?? '';

                $repeater_key = $this->get_repeater_setting_key( 'awea_step_title', 'awea_steps_list', $index );
                $this->add_inline_editing_attributes( $repeater_key, 'none' );
            ?>
                <div class="awea-step-item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
                    <div class="awea-step-box">
                        <?php 
                        if ( ! empty( $item['awea_step_icon']['value'] ) ) {
                            Icons_Manager::render_icon( $item['awea_step_icon'], [ 'aria-hidden' => 'true' ] );
                        }
                        ?>
                        <?php if ( ! empty( $number ) ) : ?>
                            <span class="awea-step-number"><?php echo esc_html( $number ); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="awea-step-content">
                        <?php if ( ! empty( $title ) ) : ?>
                            <<?php echo esc_attr( $title_tag ); ?> class="awea-step-title <?php echo esc_attr( $this->get_render_attribute_string( $repeater_key ) ); ?>">
                                <?php echo esc_html( $title ); ?>
                            </<?php echo esc_attr( $title_tag ); ?>>
                        <?php endif; ?>

                        <?php if ( ! empty( $desc ) ) : ?>
                            <p class="awea-step-desc">
                                <?php echo esc_html( $desc ); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ( $index !== $total_steps - 1 ) : ?>
                    <div class="awea-flow-connector" aria-hidden="true">
                        <?php if ( $has_beam ) : ?>
                            <div class="awea-flow-beam"></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
        <?php
    }
}