<?php
/**
 * Awesome List Group
 *
 * Elementor widget that inserts a dynamic list into the page
 *
 * @since 1.0.0
 */
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;
use \Elementor\Repeater;

class Widget_Awesome_List_Group extends Widget_Base {

    public function get_name() {
        return 'awesome-list-group';
    }

    public function get_title() {
        return esc_html__( 'List Group', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-bullet-list';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'list', 'item', 'awesome'];
    }

    protected function register_controls() {

        // --- CONTENT SECTION ---
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'list_title', [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'List Title' , 'awesome-widgets-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'list_content', [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'List description goes here.' , 'awesome-widgets-elementor' ),
                'show_label' => true,
            ]
        );

        $repeater->add_control(
            'list_icon', [
                'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'list_items',
            [
                'label' => esc_html__( 'Repeater List', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => esc_html__( 'Sourced from Trusted Farm', 'awesome-widgets-elementor' ),
                        'list_icon' => ['value' => 'fa-solid fa-earth-americas', 'library' => 'solid'],
                    ],
                ],
                'title_field' => '{{{ list_title }}}',
            ]
        );

        $this->end_controls_section();

        // --- STYLE: LAYOUT ---
        $this->start_controls_section(
            'section_style_layout',
            [
                'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_spacing',
            [
                'label' => esc_html__( 'Spacing Between Items', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .awea-icon-list-item',
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_background',
            [
                'label' => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-list-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: ICON ---
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'icon_colors' );

        $this->start_controls_tab(
            'icon_colors_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-icon-list-icon-wrap i' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'icon_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-icon-list-icon-wrap' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_colors_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'icon_bg_color_hover',
            [
                'label' => esc_html__( 'Background Hover', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-icon-list-item:hover .awea-icon-list-icon-wrap' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Size', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [ '{{WRAPPER}} .awea-icon-list-icon-wrap i' => 'font-size: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'icon_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [ '{{WRAPPER}} .awea-icon-list-icon-wrap' => 'border-radius: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: CONTENT ---
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_title',
            [ 'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ), 'type' => Controls_Manager::HEADING ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-icon-list-text h3' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .awea-icon-list-text h3',
            ]
        );

        $this->add_control(
            'heading_description',
            [ 
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ), 
                'type' => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-icon-list-text p' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'selector' => '{{WRAPPER}} .awea-icon-list-text p',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['list_items'] ) ) {
            return;
        }
        ?>
        <div class="awea-icon-list-card">
            <?php foreach ( $settings['list_items'] as $item ) : 
                $item_id = $item['_id'];
                ?>
                <article class="awea-icon-list-item elementor-repeater-item-<?php echo esc_attr( $item_id ); ?>">
                    <div class="awea-icon-list-icon-wrap">
                        <?php \Elementor\Icons_Manager::render_icon( $item['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </div>
                    <div class="awea-icon-list-text">
                        <?php if ( ! empty( $item['list_title'] ) ) : ?>
                            <h3><?php echo esc_html( $item['list_title'] ); ?></h3>
                        <?php endif; ?>
                        
                        <?php if ( ! empty( $item['list_content'] ) ) : ?>
                            <p><?php echo esc_html( $item['list_content'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <?php 
    }
}