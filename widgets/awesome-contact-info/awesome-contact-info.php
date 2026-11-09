<?php
/**
 * Awesome Contact Info Studio Widget.
 * Modern Architectural Contact Directory with Interactive Slide & Copy Triggers.
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

class Widget_Awesome_Contact_Info extends Widget_Base {

    public function get_name() {
        return 'awea-contact-info';
    }

    public function get_title() {
        return esc_html__( 'Contact Info', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-unread';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'contact', 'info', 'directory', 'phone', 'email', 'address', 'vcard' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: CONTACT DIRECTORY
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_contact_content',
            [
                'label' => esc_html__( 'Contact Directory', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_contact_title',
            [
                'label'       => esc_html__( 'Header Title', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Get In Touch', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_title_tag',
            [
                'label'   => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
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
            'awea_show_header_indicator',
            [
                'label'        => esc_html__( 'Accent Indicator Bar', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'awea_item_icon',
            [
                'label'   => esc_html__( 'Item Icon', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-envelope',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'awea_item_label',
            [
                'label'       => esc_html__( 'Field Label', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Direct Email', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_item_value',
            [
                'label'       => esc_html__( 'Field Value', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'hello@example.com', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_item_link',
            [
                'label'       => esc_html__( 'Destination URL', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'mailto:hello@example.com',
            ]
        );

        $repeater->add_control(
            'awea_item_enable_copy',
            [
                'label'        => esc_html__( 'Enable Copy-to-Clipboard', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => '',
                'description'  => esc_html__( 'Clicking copies the value text directly to clipboard.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_contact_items',
            [
                'label'       => esc_html__( 'Contact Cards', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'awea_item_label' => esc_html__( 'Direct Inquiries', 'awesome-widgets-elementor' ),
                        'awea_item_value' => 'support@devnahian.com',
                        'awea_item_icon'  => [ 'value' => 'fas fa-envelope', 'library' => 'fa-solid' ],
                        'awea_item_link'  => [ 'url' => 'mailto:support@devnahian.com' ],
                    ],
                    [
                        'awea_item_label' => esc_html__( 'Telephone Support', 'awesome-widgets-elementor' ),
                        'awea_item_value' => '+1 (800) 456-7890',
                        'awea_item_icon'  => [ 'value' => 'fas fa-phone-alt', 'library' => 'fa-solid' ],
                        'awea_item_link'  => [ 'url' => 'tel:+18004567890' ],
                    ],
                    [
                        'awea_item_label' => esc_html__( 'Main Headquarters', 'awesome-widgets-elementor' ),
                        'awea_item_value' => '100 Montgomery St, San Francisco, CA',
                        'awea_item_icon'  => [ 'value' => 'fas fa-map-marker-alt', 'library' => 'fa-solid' ],
                    ],
                ],
                'title_field' => '{{{ awea_item_label }}}: {{{ awea_item_value }}}',
            ]
        );

        $this->add_control(
            'awea_show_action_arrow',
            [
                'label'        => esc_html__( 'Show Action Arrow', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'separator'    => 'before',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: HEADER TITLE
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_header',
            [
                'label' => esc_html__( 'Header Title', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_title_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-header .awea-contact-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_title_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-contact-header .awea-contact-title',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_control(
            'awea_indicator_line_color',
            [
                'label'     => esc_html__( 'Accent Indicator Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-header' => 'border-left-color: {{VALUE}};',
                ],
                'condition' => [ 'awea_show_header_indicator' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'awea_header_margin_bottom',
            [
                'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 32 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-contact-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: CONTACT CARDS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_cards',
            [
                'label' => esc_html__( 'Contact Cards', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_row_padding',
            [
                'label'      => esc_html__( 'Card Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '20', 'right' => '24', 'bottom' => '20', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-contact-list-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_row_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-contact-list-row' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_row_spacing',
            [
                'label'      => esc_html__( 'Space Between Cards', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 14 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-contact-list-row:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_card_state_tabs' );

        // Normal Card
        $this->start_controls_tab(
            'awea_card_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_row_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-list-row' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_row_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-contact-list-row',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_row_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-contact-list-row',
            ]
        );

        $this->end_controls_tab();

        // Hover Card (No lift / No zoom)
        $this->start_controls_tab(
            'awea_card_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_row_bg_hover',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-list-row:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_row_border_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-list-row:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_row_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-contact-list-row:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: ICON & TYPOGRAPHY
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_icon_content',
            [
                'label' => esc_html__( 'Icon & Typography', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Icon Badge Subgroup
        $this->add_control(
            'awea_heading_icon_style',
            [
                'label' => esc_html__( 'Icon Badge', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'awea_icon_box_size',
            [
                'label'      => esc_html__( 'Badge Dimension', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 36, 'max' => 80 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 52 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-contact-list-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 12, 'max' => 36 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 18 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-contact-list-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .awea-contact-list-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_icon_box_radius',
            [
                'label'      => esc_html__( 'Badge Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-contact-list-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_icon_state_tabs' );

        // Normal Icon
        $this->start_controls_tab(
            'awea_icon_tab_normal',
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
                    '{{WRAPPER}} .awea-contact-list-icon'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-contact-list-icon svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_icon_bg',
            [
                'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(79, 70, 229, 0.08)',
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-list-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Icon (Zero Hover Rotation / Scale)
        $this->start_controls_tab(
            'awea_icon_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_icon_color_hover',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-list-row:hover .awea-contact-list-icon'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-contact-list-row:hover .awea-contact-list-icon svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_icon_bg_hover',
            [
                'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-list-row:hover .awea-contact-list-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Typography: Label Subgroup
        $this->add_control(
            'awea_heading_label_typo',
            [
                'label'     => esc_html__( 'Field Label', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_label_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-list-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_label_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-contact-list-label',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        // Typography: Value Subgroup
        $this->add_control(
            'awea_heading_value_typo',
            [
                'label'     => esc_html__( 'Field Value', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_value_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-list-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_value_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-list-row:hover .awea-contact-list-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_value_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-contact-list-value',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        // Arrow Styling Subgroup
        $this->add_control(
            'awea_heading_arrow_style',
            [
                'label'     => esc_html__( 'Action Arrow Style', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'awea_show_action_arrow' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_arrow_color',
            [
                'label'     => esc_html__( 'Normal Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#94a3b8',
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-list-arrow' => 'color: {{VALUE}};',
                ],
                'condition' => [ 'awea_show_action_arrow' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_arrow_color_hover',
            [
                'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-contact-list-row:hover .awea-contact-list-arrow' => 'color: {{VALUE}};',
                ],
                'condition' => [ 'awea_show_action_arrow' => 'yes' ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings       = $this->get_settings_for_display();
        $title          = $settings['awea_contact_title'] ?? '';
        $title_tag      = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h2' );
        $show_indicator = 'yes' === ( $settings['awea_show_header_indicator'] ?? 'no' );
        $items          = $settings['awea_contact_items'] ?? [];
        $show_arrow     = 'yes' === ( $settings['awea_show_action_arrow'] ?? 'no' );

        $header_classes = [ 'awea-contact-header' ];
        if ( ! $show_indicator ) {
            $header_classes[] = 'awea-no-indicator';
        }
        ?>
        <div class="awea-list-container" id="awea-contact-<?php echo esc_attr( $this->get_id() ); ?>">
            
            <?php if ( ! empty( $title ) ) : ?>
                <div class="<?php echo esc_attr( implode( ' ', $header_classes ) ); ?>">
                    <<?php echo esc_attr( $title_tag ); ?> class="awea-contact-title"><?php echo esc_html( $title ); ?></<?php echo esc_attr( $title_tag ); ?>>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $items ) ) : ?>
                <div class="awea-contact-cards-wrap">
                    <?php 
                    foreach ( $items as $index => $item ) : 
                        $label       = $item['awea_item_label'] ?? '';
                        $val         = $item['awea_item_value'] ?? '';
                        $enable_copy = 'yes' === ( $item['awea_item_enable_copy'] ?? '' );
                        $link_key    = 'awea_contact_link_' . $index;
                        $has_url     = ! empty( $item['awea_item_link']['url'] );

                        $tag = $has_url ? 'a' : 'div';

                        if ( $has_url ) {
                            $this->add_link_attributes( $link_key, $item['awea_item_link'] );
                        }

                        $this->add_render_attribute( $link_key, 'class', 'awea-contact-list-row elementor-repeater-item-' . esc_attr( $item['_id'] ) );
                        
                        if ( $enable_copy ) {
                            $this->add_render_attribute( $link_key, 'data-copy-text', esc_attr( $val ) );
                            $this->add_render_attribute( $link_key, 'class', 'awea-copy-enabled' );
                            $this->add_render_attribute( $link_key, 'title', esc_attr__( 'Click to copy to clipboard', 'awesome-widgets-elementor' ) );
                        }
                    ?>
                        <<?php echo tag_escape( $tag ); ?> <?php echo $this->get_render_attribute_string( $link_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                            <!-- Leading Badge -->
                            <div class="awea-contact-list-icon" aria-hidden="true">
                                <?php Icons_Manager::render_icon( $item['awea_item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            </div>

                            <!-- Body Content -->
                            <div class="awea-contact-list-content">
                                <?php if ( ! empty( $label ) ) : ?>
                                    <span class="awea-contact-list-label"><?php echo esc_html( $label ); ?></span>
                                <?php endif; ?>
                                
                                <?php if ( ! empty( $val ) ) : ?>
                                    <span class="awea-contact-list-value"><?php echo esc_html( $val ); ?></span>
                                <?php endif; ?>
                            </div>

                            <!-- Trailing Indicator -->
                            <?php if ( $enable_copy ) : ?>
                                <div class="awea-contact-copy-badge" aria-label="<?php esc_attr_e( 'Copy to Clipboard', 'awesome-widgets-elementor' ); ?>">
                                    <svg class="awea-copy-ready" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                    <svg class="awea-copy-done" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                            <?php elseif ( $show_arrow ) : ?>
                                <div class="awea-contact-list-arrow" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </<?php echo tag_escape( $tag ); ?>>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>

        <!-- Scoped Copy Notification Logic -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var scope = document.getElementById('awea-contact-<?php echo esc_js( $this->get_id() ); ?>');
            if (!scope) return;

            var copyItems = scope.querySelectorAll('.awea-copy-enabled');
            copyItems.forEach(function(item) {
                item.addEventListener('click', function(e) {
                    var textToCopy = this.getAttribute('data-copy-text');
                    if (!textToCopy) return;

                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(textToCopy);
                        item.classList.add('is-copied');
                        setTimeout(function() {
                            item.classList.remove('is-copied');
                        }, 1800);
                    }
                });
            });
        });
        </script>
        <?php
    }
}