<?php
/**
 * Awesome Navigation Menu Studio Widget.
 * Modern Architectural Header & Footer Navigation with Zero Hover Lift.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.8.0
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

/**
 * Custom Menu Walker to natively append the indicator chevron on the server.
 */
class AWEA_Nav_Walker extends \Walker_Nav_Menu {
    private $show_indicator;

    public function __construct( $show_indicator = true ) {
        $this->show_indicator = $show_indicator;
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes   = empty( $item->classes ) ? [] : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $has_children = in_array( 'menu-item-has-children', $classes, true );

        $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= '<li' . $id . $class_names . '>';

        $atts           = [];
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        if ( '_blank' === $item->target && empty( $item->xfn ) ) {
            $atts['rel'] = 'noopener noreferrer';
        } else {
            $atts['rel'] = $item->xfn;
        }
        $atts['href']         = ! empty( $item->url ) ? $item->url : '';
        $atts['aria-current'] = $item->current ? 'page' : '';

        if ( $has_children ) {
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
        }

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output  = $args->before ?? '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= '<span class="awea-menu-label">' . ( $args->link_before ?? '' ) . $title . ( $args->link_after ?? '' ) . '</span>';

        if ( $has_children && $this->show_indicator ) {
            $item_output .= '<span class="awea-sub-indicator" aria-hidden="true">';
            $item_output .= '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>';
            $item_output .= '</span>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after ?? '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}

class Widget_Awesome_Nav_Menu extends Widget_Base {

    public function get_name() {
        return 'awesome-nav-menu';
    }

    public function get_title() {
        return esc_html__( 'Nav Menu', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_categories() {
        return [ 'awesome-header-footer' ];
    }

    public function get_keywords() {
        return [ 'awea', 'nav', 'menu', 'navigation', 'header', 'navbar', 'links', 'mobile' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: MENU CONFIGURATION
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_nav_content',
            [
                'label' => esc_html__( 'Navigation Structure', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $menus = wp_get_nav_menus();
        $menu_options = [];
        if ( ! empty( $menus ) && ! is_wp_error( $menus ) ) {
            foreach ( $menus as $menu ) {
                $menu_options[ $menu->term_id ] = $menu->name;
            }
        }

        $this->add_control(
            'awea_selected_menu',
            [
                'label'       => esc_html__( 'Select Menu', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::SELECT,
                'options'     => $menu_options,
                'default'     => ! empty( $menu_options ) ? array_key_first( $menu_options ) : '',
                'description' => empty( $menu_options ) ? esc_html__( 'No menus found in Appearance > Menus.', 'awesome-widgets-elementor' ) : '',
            ]
        );

        $this->add_responsive_control(
            'awea_menu_layout',
            [
                'label'     => esc_html__( 'Layout Direction', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'row' => [
                        'title' => esc_html__( 'Horizontal', 'awesome-widgets-elementor' ),
                        'icon'  => 'eicon-ellipsis-h',
                    ],
                    'column' => [
                        'title' => esc_html__( 'Vertical', 'awesome-widgets-elementor' ),
                        'icon'  => 'eicon-ellipsis-v',
                    ],
                ],
                'default'   => 'row',
                'selectors' => [
                    '{{WRAPPER}} .awea-nav-menu-list' => 'flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_menu_align',
            [
                'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'awesome-widgets-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__( 'End', 'awesome-widgets-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Justify', 'awesome-widgets-elementor' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'default'   => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .awea-nav-menu-list' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_show_submenu_indicator',
            [
                'label'        => esc_html__( 'Submenu Indicator', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'prefix_class' => 'awea-has-indicator-',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: MOBILE TOGGLE / RESPONSIVE
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_mobile_menu',
            [
                'label' => esc_html__( 'Mobile Responsive Toggle', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_enable_mobile_breakpoint',
            [
                'label'   => esc_html__( 'Breakpoint', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'mobile',
                'options' => [
                    'none'   => esc_html__( 'None (Always Expanded)', 'awesome-widgets-elementor' ),
                    'tablet' => esc_html__( 'Tablet & Mobile (991px)', 'awesome-widgets-elementor' ),
                    'mobile' => esc_html__( 'Mobile Only (767px)', 'awesome-widgets-elementor' ),
                ],
                'prefix_class' => 'awea-nav-breakpoint-',
            ]
        );

        $this->add_responsive_control(
            'awea_mobile_toggle_align',
            [
                'label'     => esc_html__( 'Toggle Button Align', 'awesome-widgets-elementor' ),
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
                'default'   => 'flex-end',
                'condition' => [
                    'awea_enable_mobile_breakpoint!' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-mobile-toggle-wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION 1: TOP LEVEL LINKS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_main_items',
            [
                'label' => esc_html__( 'Main Menu Items', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_menu_typography',
                'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
                'selector' => '{{WRAPPER}} .awea-nav-menu-list > li > a',
            ]
        );

        $this->add_responsive_control(
            'awea_item_padding',
            [
                'label'      => esc_html__( 'Item Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '8', 'right' => '16', 'bottom' => '8', 'left' => '16', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-nav-menu-list > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_menu_item_spacing',
            [
                'label'      => esc_html__( 'Items Gap', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 60 ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 12,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-nav-menu-list' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_item_radius',
            [
                'label'      => esc_html__( 'Item Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'rem', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-nav-menu-list > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_menu_state_tabs' );

        // Normal
        $this->start_controls_tab(
            'awea_menu_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_menu_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
                'selectors' => [
                    '{{WRAPPER}} .awea-nav-menu-list > li > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_menu_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-nav-menu-list > li > a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab(
            'awea_menu_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_menu_color_hover',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [
                    '{{WRAPPER}} .awea-nav-menu-list > li > a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-nav-menu-list > li:hover > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_menu_bg_hover',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-nav-menu-list > li > a:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .awea-nav-menu-list > li:hover > a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Active
        $this->start_controls_tab(
            'awea_menu_tab_active',
            [ 'label' => esc_html__( 'Active', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_menu_color_active',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [
                    '{{WRAPPER}} .awea-nav-menu-list > li.current-menu-item > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-nav-menu-list > li.current-menu-ancestor > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_menu_bg_active',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-nav-menu-list > li.current-menu-item > a' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .awea-nav-menu-list > li.current-menu-ancestor > a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION 2: SUBMENU DROPDOWN
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_dropdown',
            [
                'label' => esc_html__( 'Dropdown Submenu', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_submenu_width',
            [
                'label'      => esc_html__( 'Min Width', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [
                    'px' => [ 'min' => 150, 'max' => 400 ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 220,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_submenu_offset',
            [
                'label'      => esc_html__( 'Vertical Gap / Offset', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 50 ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-nav-menu-list > li > ul.sub-menu' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_submenu_bg',
            [
                'label'     => esc_html__( 'Dropdown Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_submenu_padding',
            [
                'label'      => esc_html__( 'Dropdown Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [ 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_submenu_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'rem' ],
                'default'    => [ 'top' => '14', 'right' => '14', 'bottom' => '14', 'left' => '14', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_submenu_border',
                'selector' => '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_submenu_shadow',
                'selector' => '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu',
            ]
        );

        $this->add_control(
            'awea_submenu_items_heading',
            [
                'label'     => esc_html__( 'Submenu Links', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_submenu_typography',
                'selector' => '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu li a',
            ]
        );

        $this->add_control(
            'awea_subitem_color',
            [
                'label'     => esc_html__( 'Link Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#334155',
                'selectors' => [
                    '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_subitem_hover_color',
            [
                'label'     => esc_html__( 'Link Hover Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [
                    '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_subitem_hover_bg',
            [
                'label'     => esc_html__( 'Link Hover Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f8fafc',
                'selectors' => [
                    '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu li a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION 3: MOBILE HAMBURGER BUTTON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_toggle',
            [
                'label'     => esc_html__( 'Mobile Toggle Button', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'awea_enable_mobile_breakpoint!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'awea_toggle_color',
            [
                'label'     => esc_html__( 'Bar / Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#0f172a',
                'selectors' => [
                    '{{WRAPPER}} .awea-mobile-toggle-btn svg' => 'stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_toggle_bg',
            [
                'label'     => esc_html__( 'Button Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f1f5f9',
                'selectors' => [
                    '{{WRAPPER}} .awea-mobile-toggle-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_toggle_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '8', 'right' => '8', 'bottom' => '8', 'left' => '8', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-mobile-toggle-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $menu_id  = absint( $settings['awea_selected_menu'] ?? 0 );

        if ( ! $menu_id ) {
            if ( current_user_can( 'manage_options' ) ) {
                echo '<div class="awea-nav-notice" style="padding:16px; background:#fef3c7; color:#b45309; border-radius:8px; font-size:13px; font-weight:600;">' . esc_html__( 'Please select a menu in the widget settings.', 'awesome-widgets-elementor' ) . '</div>';
            }
            return;
        }

        $unique_id      = $this->get_id();
        $show_indicator = ( 'yes' === ( $settings['awea_show_submenu_indicator'] ?? 'yes' ) );
        ?>
        <div class="awea-nav-menu-wrapper" data-nav-id="<?php echo esc_attr( $unique_id ); ?>">
            
            <?php if ( 'none' !== $settings['awea_enable_mobile_breakpoint'] ) : ?>
                <div class="awea-mobile-toggle-wrapper">
                    <button class="awea-mobile-toggle-btn" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle Navigation', 'awesome-widgets-elementor' ); ?>">
                        <svg class="awea-icon-open" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                        <svg class="awea-icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            <?php endif; ?>

            <nav class="awea-nav-menu-container" role="navigation" aria-label="<?php esc_attr_e( 'Main Menu', 'awesome-widgets-elementor' ); ?>">
                <?php
                wp_nav_menu(
                    [
                        'menu'            => $menu_id,
                        'menu_class'      => 'menu awea-nav-menu-list',
                        'container'       => false,
                        'fallback_cb'     => '__return_false',
                        'walker'          => new AWEA_Nav_Walker( $show_indicator ),
                    ]
                );
                ?>
            </nav>
        </div>

        <script>
        (function() {
            function initNavMenu() {
                var wrapper = document.querySelector('[data-nav-id="<?php echo esc_js( $unique_id ); ?>"]');
                if (!wrapper) return;

                var toggleBtn = wrapper.querySelector('.awea-mobile-toggle-btn');
                var menuContainer = wrapper.querySelector('.awea-nav-menu-container');

                if (toggleBtn && menuContainer && !toggleBtn.__aweaBound) {
                    toggleBtn.__aweaBound = true;
                    toggleBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        var expanded = this.getAttribute('aria-expanded') === 'true' || false;
                        this.setAttribute('aria-expanded', !expanded);
                        menuContainer.classList.toggle('awea-menu-open');
                    });
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initNavMenu);
            } else {
                initNavMenu();
            }

            if (window.elementorFrontend && window.elementorFrontend.hooks) {
                window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-nav-menu.default', initNavMenu);
            }
        })();
        </script>
        <?php
    }
}