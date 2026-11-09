<?php
/**
 * Awesome Business Hours Studio Widget.
 * Modern Glassmorphic Operations HUD with Real-Time Local Timezone Detection.
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
use \Elementor\Group_Control_Background;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;
use \Elementor\Repeater;

class Widget_Awesome_Business_Hours extends Widget_Base {

    public function get_name() {
        return 'awesome-business-hours';
    }

    public function get_title() {
        return esc_html__( 'Business Hours', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-clock-o';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'business hours', 'schedule', 'opening hours', 'timetable', 'clock', 'open now' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: STATUS SIDE & INFO
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_status_content',
            [
                'label' => esc_html__( 'Status & Information', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_badge_open_text',
            [
                'label'       => esc_html__( '"Open Now" Badge Label', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Open Now', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_badge_closed_text',
            [
                'label'       => esc_html__( '"Closed" Badge Label', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Closed Today', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_heading',
            [
                'label'       => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( "We're ready to create.", 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'awea_title_tag',
            [
                'label'   => esc_html__( 'Heading HTML Tag', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
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
            ]
        );

        $this->add_control(
            'awea_description',
            [
                'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 4,
                'default'     => esc_html__( 'Visit our studio or connect directly with our engineering team during operational business hours.', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'awea_phone_label',
            [
                'label'       => esc_html__( 'Contact Label', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Direct Support Line:', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'awea_phone_number',
            [
                'label'       => esc_html__( 'Phone Number', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '+1 (800) 456-7890',
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_phone_url',
            [
                'label'       => esc_html__( 'Phone Link (tel:)', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'tel:+18004567890',
                'default'     => [
                    'url' => 'tel:+18004567890',
                ],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: WEEKLY SCHEDULE REPEATER
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_schedule_hours',
            [
                'label' => esc_html__( 'Weekly Schedule', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'awea_day_name',
            [
                'label'   => esc_html__( 'Day of Week', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'Monday',
                'options' => [
                    'Monday'    => esc_html__( 'Monday', 'awesome-widgets-elementor' ),
                    'Tuesday'   => esc_html__( 'Tuesday', 'awesome-widgets-elementor' ),
                    'Wednesday' => esc_html__( 'Wednesday', 'awesome-widgets-elementor' ),
                    'Thursday'  => esc_html__( 'Thursday', 'awesome-widgets-elementor' ),
                    'Friday'    => esc_html__( 'Friday', 'awesome-widgets-elementor' ),
                    'Saturday'  => esc_html__( 'Saturday', 'awesome-widgets-elementor' ),
                    'Sunday'    => esc_html__( 'Sunday', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $repeater->add_control(
            'awea_is_closed',
            [
                'label'        => esc_html__( 'Mark as Closed', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Closed', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Open', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $repeater->add_control(
            'awea_display_hours',
            [
                'label'       => esc_html__( 'Display Time String', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '09:00 AM — 06:00 PM',
                'dynamic'     => [ 'active' => true ],
                'condition'   => [ 'awea_is_closed!' => 'yes' ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_closed_label',
            [
                'label'       => esc_html__( 'Closed Notice', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'CLOSED', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'condition'   => [ 'awea_is_closed' => 'yes' ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_open_time_24',
            [
                'label'       => esc_html__( 'Opening Time (24h format HH:MM)', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '09:00',
                'description' => esc_html__( 'Used for real-time calculation (e.g. 09:00)', 'awesome-widgets-elementor' ),
                'condition'   => [ 'awea_is_closed!' => 'yes' ],
            ]
        );

        $repeater->add_control(
            'awea_close_time_24',
            [
                'label'       => esc_html__( 'Closing Time (24h format HH:MM)', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '18:00',
                'description' => esc_html__( 'Used for real-time calculation (e.g. 18:00)', 'awesome-widgets-elementor' ),
                'condition'   => [ 'awea_is_closed!' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_schedule_list',
            [
                'label'       => esc_html__( 'Operating Schedule', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [ 'awea_day_name' => 'Monday', 'awea_display_hours' => '09:00 AM — 06:00 PM', 'awea_open_time_24' => '09:00', 'awea_close_time_24' => '18:00' ],
                    [ 'awea_day_name' => 'Tuesday', 'awea_display_hours' => '09:00 AM — 06:00 PM', 'awea_open_time_24' => '09:00', 'awea_close_time_24' => '18:00' ],
                    [ 'awea_day_name' => 'Wednesday', 'awea_display_hours' => '09:00 AM — 06:00 PM', 'awea_open_time_24' => '09:00', 'awea_close_time_24' => '18:00' ],
                    [ 'awea_day_name' => 'Thursday', 'awea_display_hours' => '09:00 AM — 06:00 PM', 'awea_open_time_24' => '09:00', 'awea_close_time_24' => '18:00' ],
                    [ 'awea_day_name' => 'Friday', 'awea_display_hours' => '09:00 AM — 06:00 PM', 'awea_open_time_24' => '09:00', 'awea_close_time_24' => '18:00' ],
                    [ 'awea_day_name' => 'Saturday', 'awea_display_hours' => '10:00 AM — 04:00 PM', 'awea_open_time_24' => '10:00', 'awea_close_time_24' => '16:00' ],
                    [ 'awea_day_name' => 'Sunday', 'awea_is_closed' => 'yes', 'awea_closed_label' => 'CLOSED' ],
                ],
                'title_field' => '{{{ awea_day_name }}} - {{{ awea_is_closed === "yes" ? "CLOSED" : awea_display_hours }}}',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: CONTAINER & LAYOUT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_layout',
            [
                'label' => esc_html__( 'Card Shell & Background', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_shell_bg',
            [
                'label'     => esc_html__( 'Card Shell Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#090d16',
                'selectors' => [
                    '{{WRAPPER}} .awea-business-hours-grid' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_shell_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '32', 'right' => '32', 'bottom' => '32', 'left' => '32', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-business-hours-grid' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_shell_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-business-hours-grid',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_shell_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-business-hours-grid',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: STATUS SIDE
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_status_side',
            [
                'label' => esc_html__( 'Status Side & Call', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_status_padding',
            [
                'label'      => esc_html__( 'Internal Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '54', 'right' => '54', 'bottom' => '54', 'left' => '54', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-business-hours-status-side' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_heading_title_style',
            [
                'label'     => esc_html__( 'Heading Typography', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_heading_color',
            [
                'label'     => esc_html__( 'Heading Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-business-hours-status-side h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_heading_typography',
                'selector' => '{{WRAPPER}} .awea-business-hours-status-side h2',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_control(
            'awea_heading_desc_style',
            [
                'label'     => esc_html__( 'Description Typography', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_desc_color',
            [
                'label'     => esc_html__( 'Description Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-business-hours-status-side p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_desc_typography',
                'selector' => '{{WRAPPER}} .awea-business-hours-status-side p',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        // Phone Call Block
        $this->add_control(
            'awea_heading_phone_style',
            [
                'label'     => esc_html__( 'Phone Trigger', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_phone_label_color',
            [
                'label'     => esc_html__( 'Label Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-business-hours-support-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_phone_number_color',
            [
                'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-business-hours-support-num' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_phone_number_typography',
                'selector' => '{{WRAPPER}} .awea-business-hours-support-num',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: SCHEDULE ROWS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_schedule',
            [
                'label' => esc_html__( 'Schedule Rows & Active Day', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_schedule_padding',
            [
                'label'      => esc_html__( 'Schedule Panel Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '54', 'right' => '54', 'bottom' => '54', 'left' => '54', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-business-hours-schedule-side' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_schedule_bg',
            [
                'label'     => esc_html__( 'Schedule Panel Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(0, 0, 0, 0.28)',
                'selectors' => [
                    '{{WRAPPER}} .awea-business-hours-schedule-side' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_day_color',
            [
                'label'     => esc_html__( 'Day Label Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e2e8f0',
                'selectors' => [
                    '{{WRAPPER}} .awea-business-hours-day' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_day_typography',
                'selector' => '{{WRAPPER}} .awea-business-hours-day',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_control(
            'awea_time_color',
            [
                'label'     => esc_html__( 'Hours Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#94a3b8',
                'selectors' => [
                    '{{WRAPPER}} .awea-business-hours-time' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_time_typography',
                'selector' => '{{WRAPPER}} .awea-business-hours-time',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_control(
            'awea_heading_today_accent',
            [
                'label'     => esc_html__( 'Active Day Accent Glow', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_today_accent_color',
            [
                'label'     => esc_html__( 'Today Highlight Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-business-hours-row.is-today' => 'border-bottom-color: {{VALUE}};',
                    '{{WRAPPER}} .awea-business-hours-row.is-today .awea-business-hours-day' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-business-hours-row.is-today .awea-today-indicator' => 'background-color: {{VALUE}}; box-shadow: 0 0 10px {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function calculate_is_open_now( $schedule_list ) {
        if ( empty( $schedule_list ) ) {
            return false;
        }

        $current_day  = wp_date( 'l' );
        $current_time = wp_date( 'H:i' );

        foreach ( $schedule_list as $item ) {
            $day_name = trim( $item['awea_day_name'] ?? '' );
            if ( strcasecmp( $day_name, $current_day ) === 0 ) {
                if ( 'yes' === ( $item['awea_is_closed'] ?? '' ) ) {
                    return false;
                }

                $open_time  = trim( $item['awea_open_time_24'] ?? '' );
                $close_time = trim( $item['awea_close_time_24'] ?? '' );

                if ( empty( $open_time ) || empty( $close_time ) ) {
                    return true;
                }

                return ( $current_time >= $open_time && $current_time <= $close_time );
            }
        }

        return false;
    }

    protected function render() {
        $settings     = $this->get_settings_for_display();
        $schedule     = $settings['awea_schedule_list'] ?? [];
        $current_day  = wp_date( 'l' );
        $is_open_now  = $this->calculate_is_open_now( $schedule );
        $open_label   = ! empty( $settings['awea_badge_open_text'] ) ? $settings['awea_badge_open_text'] : esc_html__( 'Open Now', 'awesome-widgets-elementor' );
        $closed_label = ! empty( $settings['awea_badge_closed_text'] ) ? $settings['awea_badge_closed_text'] : esc_html__( 'Closed', 'awesome-widgets-elementor' );
        $phone_url    = $settings['awea_phone_url']['url'] ?? '';
        $title_tag    = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h2' );

        if ( ! empty( $phone_url ) ) {
            $this->add_link_attributes( 'awea_phone_call', $settings['awea_phone_url'] );
        }
        ?>
        <div class="awea-business-hours-root">
            <div class="awea-business-hours-grid">
                
                <!-- Left Status HUD -->
                <div class="awea-business-hours-status-side">
                    
                    <!-- Live Status Beacon Badge -->
                    <div class="awea-business-hours-badge <?php echo $is_open_now ? 'is-open' : 'is-closed'; ?>">
                        <span class="awea-business-hours-pulse" aria-hidden="true"></span>
                        <span class="awea-badge-text"><?php echo esc_html( $is_open_now ? $open_label : $closed_label ); ?></span>
                    </div>

                    <?php if ( ! empty( $settings['awea_heading'] ) ) : ?>
                        <<?php echo esc_attr( $title_tag ); ?>><?php echo esc_html( $settings['awea_heading'] ); ?></<?php echo esc_attr( $title_tag ); ?>>
                    <?php endif; ?>

                    <?php if ( ! empty( $settings['awea_description'] ) ) : ?>
                        <p><?php echo esc_html( $settings['awea_description'] ); ?></p>
                    <?php endif; ?>

                    <!-- Direct Phone Action Link -->
                    <?php if ( ! empty( $settings['awea_phone_number'] ) ) : ?>
                        <div class="awea-business-hours-support-box">
                            <?php if ( ! empty( $settings['awea_phone_label'] ) ) : ?>
                                <span class="awea-business-hours-support-label"><?php echo esc_html( $settings['awea_phone_label'] ); ?></span>
                            <?php endif; ?>
                            
                            <a class="awea-business-hours-support-link" <?php echo $this->get_render_attribute_string( 'awea_phone_call' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                                <div class="awea-support-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                </div>
                                <span class="awea-business-hours-support-num"><?php echo esc_html( $settings['awea_phone_number'] ); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Right Weekly Schedule -->
                <div class="awea-business-hours-schedule-side">
                    <?php if ( ! empty( $schedule ) ) : ?>
                        <div class="awea-schedule-list">
                            <?php foreach ( $schedule as $item ) : 
                                $day_name  = trim( $item['awea_day_name'] ?? '' );
                                $is_closed = 'yes' === ( $item['awea_is_closed'] ?? '' );
                                $is_today  = ( strcasecmp( $day_name, $current_day ) === 0 );
                                $time_str  = $is_closed ? ( $item['awea_closed_label'] ?? esc_html__( 'CLOSED', 'awesome-widgets-elementor' ) ) : ( $item['awea_display_hours'] ?? '' );

                                $row_classes = [ 'awea-business-hours-row', 'elementor-repeater-item-' . $item['_id'] ];
                                if ( $is_today ) {
                                    $row_classes[] = 'is-today';
                                }
                                if ( $is_closed ) {
                                    $row_classes[] = 'is-closed-row';
                                }
                            ?>
                                <div class="<?php echo esc_attr( implode( ' ', $row_classes ) ); ?>">
                                    <div class="awea-day-meta">
                                        <?php if ( $is_today ) : ?>
                                            <span class="awea-today-indicator" title="<?php esc_attr_e( 'Today', 'awesome-widgets-elementor' ); ?>" aria-hidden="true"></span>
                                        <?php endif; ?>
                                        <span class="awea-business-hours-day"><?php echo esc_html( $day_name ); ?></span>
                                    </div>
                                    <span class="awea-business-hours-time"><?php echo esc_html( $time_str ); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        <?php
    }
}