<?php
/**
 * Awesome Accordion Widget.
 * Modern Architectural Layout with Fluid Grid Micro-Transitions.
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

class Widget_Awesome_Accordion extends Widget_Base {

    public function get_name() {
        return 'awesome-accordion';
    }

    public function get_title() {
        return esc_html__( 'Accordion', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'accordion', 'faq', 'toggle', 'collapse', 'tabs', 'qna' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           CONTENT: ACCORDION LIST
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_accordion_content',
            [
                'label' => esc_html__( 'Accordion Items', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'awea_item_title',
            [
                'label'       => esc_html__( 'Question / Title', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Where can I find your warranty policy?', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_item_content',
            [
                'label'   => esc_html__( 'Answer / Description', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Our standard commercial warranty covers all manufacturing defects and operational failures for 24 months from the purchase date.', 'awesome-widgets-elementor' ),
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'awea_item_is_default_active',
            [
                'label'        => esc_html__( 'Open by Default', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_control(
            'awea_accordion_items',
            [
                'label'       => esc_html__( 'Accordion Items', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'awea_item_title'             => esc_html__( 'Where can I find your warranty policy?', 'awesome-widgets-elementor' ),
                        'awea_item_content'           => esc_html__( 'Our standard commercial warranty covers all manufacturing defects and operational failures for 24 months from the purchase date.', 'awesome-widgets-elementor' ),
                        'awea_item_is_default_active' => 'yes',
                    ],
                    [
                        'awea_item_title'             => esc_html__( 'Do you support automated custom integrations?', 'awesome-widgets-elementor' ),
                        'awea_item_content'           => esc_html__( 'Yes, our platform provides comprehensive REST API endpoints and webhooks for seamless custom pipeline synchronization.', 'awesome-widgets-elementor' ),
                    ],
                    [
                        'awea_item_title'             => esc_html__( 'What is your average response turnaround?', 'awesome-widgets-elementor' ),
                        'awea_item_content'           => esc_html__( 'Priority support queries are reviewed and answered within 2 to 4 business hours by our lead technical team.', 'awesome-widgets-elementor' ),
                    ],
                ],
                'title_field' => '{{{ awea_item_title }}}',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           CONTENT: INTERACTION SETTINGS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_accordion_settings',
            [
                'label' => esc_html__( 'Settings & Behavior', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_multiple_open',
            [
                'label'        => esc_html__( 'Allow Multiple Open Items', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'description'  => esc_html__( 'If disabled, opening an item will automatically close all other open items.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_icon_style',
            [
                'label'   => esc_html__( 'Indicator Icon Style', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'plus-minus',
                'options' => [
                    'plus-minus' => esc_html__( 'Morphing Plus / Minus (+ / -)', 'awesome-widgets-elementor' ),
                    'chevron'    => esc_html__( 'Rotating Chevron (v)', 'awesome-widgets-elementor' ),
                    'none'       => esc_html__( 'No Icon', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'awea_icon_align',
            [
                'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'  => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-h-align-left' ],
                    'right' => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-h-align-right' ],
                ],
                'default'   => 'right',
                'condition' => [ 'awea_icon_style!' => 'none' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           STYLE: ACCORDION ITEM CARDS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_items',
            [
                'label' => esc_html__( 'Item Cards & Spacing', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_item_gap',
            [
                'label'      => esc_html__( 'Gap Between Items', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 16 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-accordion-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_card_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_card_style_tabs' );

        // Normal State
        $this->start_controls_tab(
            'awea_card_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_card_bg',
            [
                'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-accordion-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_card_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-accordion-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-accordion-item',
            ]
        );

        $this->end_controls_tab();

        // Active State (Zero Hover Lift)
        $this->start_controls_tab(
            'awea_card_tab_active',
            [ 'label' => esc_html__( 'Active / Open', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_card_active_bg',
            [
                'label'     => esc_html__( 'Active Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-accordion-item.is-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_card_active_border_color',
            [
                'label'     => esc_html__( 'Active Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-accordion-item.is-active' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_active_shadow',
                'selector' => '{{WRAPPER}} .awea-accordion-item.is-active',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           STYLE: QUESTION TITLE HEADER
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_header',
            [
                'label' => esc_html__( 'Question Header', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_header_padding',
            [
                'label'      => esc_html__( 'Header Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '22', 'right' => '24', 'bottom' => '22', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-accordion-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_title_typography',
                'selector' => '{{WRAPPER}} .awea-accordion-title',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_title_color_tabs' );

        // Normal Title
        $this->start_controls_tab(
            'awea_title_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_title_color',
            [
                'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Active Title
        $this->start_controls_tab(
            'awea_title_tab_active',
            [ 'label' => esc_html__( 'Active', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_title_active_color',
            [
                'label'     => esc_html__( 'Active Title Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-accordion-item.is-active .awea-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Indicator Icon Colors
        $this->add_control(
            'awea_heading_icon_style',
            [
                'label'     => esc_html__( 'Icon Indicator Style', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'awea_icon_style!' => 'none' ],
            ]
        );

        $this->add_control(
            'awea_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#64748b',
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-line'     => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .awea-icon-chevron'  => 'stroke: {{VALUE}};',
                ],
                'condition' => [ 'awea_icon_style!' => 'none' ],
            ]
        );

        $this->add_control(
            'awea_icon_active_color',
            [
                'label'     => esc_html__( 'Active Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-accordion-item.is-active .awea-icon-line'    => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .awea-accordion-item.is-active .awea-icon-chevron' => 'stroke: {{VALUE}};',
                ],
                'condition' => [ 'awea_icon_style!' => 'none' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           STYLE: ANSWER CONTENT INNER
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_content_inner',
            [
                'label' => esc_html__( 'Answer Content', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_content_padding',
            [
                'label'      => esc_html__( 'Content Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '0', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_content_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-content-inner' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_content_typography',
                'selector' => '{{WRAPPER}} .awea-content-inner',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings       = $this->get_settings_for_display();
        $items          = $settings['awea_accordion_items'] ?? [];
        $allow_multiple = 'yes' === ( $settings['awea_multiple_open'] ?? 'no' );
        $icon_style     = $settings['awea_icon_style'] ?? 'plus-minus';
        $icon_align     = $settings['awea_icon_align'] ?? 'right';
        $widget_id      = $this->get_id();

        if ( empty( $items ) ) {
            return;
        }

        $container_classes = [ 'awea-accordion-container' ];
        if ( 'left' === $icon_align ) {
            $container_classes[] = 'awea-icon-pos-left';
        }
        ?>
        <div class="<?php echo esc_attr( implode( ' ', $container_classes ) ); ?>" 
             id="awea-accordion-<?php echo esc_attr( $widget_id ); ?>" 
             data-multiple="<?php echo $allow_multiple ? 'true' : 'false'; ?>">

            <?php foreach ( $items as $index => $item ) :
                $title     = $item['awea_item_title'] ?? '';
                $content   = $item['awea_item_content'] ?? '';
                $is_active = 'yes' === ( $item['awea_item_is_default_active'] ?? '' );
                $header_id = 'awea-acc-head-' . $widget_id . '-' . $index;
                $panel_id  = 'awea-acc-panel-' . $widget_id . '-' . $index;

                $item_classes = [ 'awea-accordion-item', 'elementor-repeater-item-' . esc_attr( $item['_id'] ) ];
                if ( $is_active ) {
                    $item_classes[] = 'is-active';
                }
            ?>
                <div class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>">
                    <!-- Question Trigger Header -->
                    <div class="awea-accordion-header" 
                         role="button" 
                         tabindex="0"
                         id="<?php echo esc_attr( $header_id ); ?>" 
                         aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>" 
                         aria-controls="<?php echo esc_attr( $panel_id ); ?>">
                        
                        <<?php echo esc_attr( $settings['awea_title_tag'] ?? 'h4' ); ?> class="awea-accordion-title"><?php echo esc_html( $title ); ?></<?php echo esc_attr( $settings['awea_title_tag'] ?? 'h4' ); ?>>

                        <?php if ( 'plus-minus' === $icon_style ) : ?>
                            <div class="awea-icon-box awea-icon-morph" aria-hidden="true">
                                <span class="awea-icon-line h"></span>
                                <span class="awea-icon-line v"></span>
                            </div>
                        <?php elseif ( 'chevron' === $icon_style ) : ?>
                            <div class="awea-icon-box awea-icon-rotate" aria-hidden="true">
                                <svg class="awea-icon-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Hardware-Accelerated Grid Collapse Body -->
                    <div class="awea-accordion-collapse" 
                         id="<?php echo esc_attr( $panel_id ); ?>" 
                         role="region" 
                         aria-labelledby="<?php echo esc_attr( $header_id ); ?>">
                        <div class="awea-accordion-overflow">
                            <div class="awea-content-inner">
                                <?php echo wp_kses_post( $content ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

        <!-- Scoped Zero-Jitter Accordion Controller -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var container = document.getElementById('awea-accordion-<?php echo esc_js( $widget_id ); ?>');
            if (!container) return;

            var isMultiple = container.getAttribute('data-multiple') === 'true';
            var headers    = container.querySelectorAll('.awea-accordion-header');

            headers.forEach(function(header) {
                function toggleAccordion(e) {
                    if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') return;
                    if (e.type === 'keydown') e.preventDefault();

                    var item     = header.closest('.awea-accordion-item');
                    var isActive = item.classList.contains('is-active');

                    if (isActive) {
                        item.classList.remove('is-active');
                        header.setAttribute('aria-expanded', 'false');
                    } else {
                        if (!isMultiple) {
                            var allItems = container.querySelectorAll('.awea-accordion-item');
                            allItems.forEach(function(other) {
                                other.classList.remove('is-active');
                                var otherHeader = other.querySelector('.awea-accordion-header');
                                if (otherHeader) otherHeader.setAttribute('aria-expanded', 'false');
                            });
                        }
                        item.classList.add('is-active');
                        header.setAttribute('aria-expanded', 'true');
                    }
                }

                header.addEventListener('click', toggleAccordion);
                header.addEventListener('keydown', toggleAccordion);
            });
        });
        </script>
        <?php
    }
}