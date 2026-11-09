<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Widget_Base;
use \Elementor\Repeater;

class Widget_Awesome_Filter_Gallery extends Widget_Base {

    public function get_name() {
        return 'awesome-filter-gallery';
    }

    public function get_title() {
        return esc_html__( 'Filter Gallery', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'filter', 'gallery', 'portfolio', 'grid', 'lightbox', 'masonry', 'images' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: FILTER BAR NAVIGATION
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_filter_bar',
            [
                'label' => esc_html__( 'Filter Navigation', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_show_filter_bar',
            [
                'label'        => esc_html__( 'Show Filter Bar', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_all_label',
            [
                'label'       => esc_html__( 'All Tab Label', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'All Works', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'condition'   => [ 'awea_show_filter_bar' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_show_counter',
            [
                'label'        => esc_html__( 'Show Item Counter', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [ 'awea_show_filter_bar' => 'yes' ],
            ]
        );

        $repeater_cats = new Repeater();

        $repeater_cats->add_control(
            'awea_cat_name',
            [
                'label'       => esc_html__( 'Category Name', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_categories',
            [
                'label'       => esc_html__( 'Categories List', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_cats->get_controls(),
                'default'     => [
                    [ 'awea_cat_name' => esc_html__( 'Architecture', 'awesome-widgets-elementor' ) ],
                    [ 'awea_cat_name' => esc_html__( 'Landscape', 'awesome-widgets-elementor' ) ],
                    [ 'awea_cat_name' => esc_html__( 'Portraits', 'awesome-widgets-elementor' ) ],
                    [ 'awea_cat_name' => esc_html__( 'Minimalism', 'awesome-widgets-elementor' ) ],
                ],
                'title_field' => '{{{ awea_cat_name }}}',
                'condition'   => [ 'awea_show_filter_bar' => 'yes' ],
            ]
        );

        $this->add_responsive_control(
            'awea_filter_align',
            [
                'label'     => esc_html__( 'Bar Alignment', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
                    'center'     => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
                    'flex-end'   => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-nav-wrapper' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [ 'awea_show_filter_bar' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: CONTENT -> SECTION: GALLERY ITEMS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_gallery_items',
            [
                'label' => esc_html__( 'Gallery Items', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater_items = new Repeater();

        $repeater_items->add_control(
            'awea_item_image',
            [
                'label'   => esc_html__( 'Image Media', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [ 'active' => true ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater_items->add_control(
            'awea_item_title',
            [
                'label'       => esc_html__( 'Project Title', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Project Showcase', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater_items->add_control(
            'awea_item_subtitle',
            [
                'label'       => esc_html__( 'Category / Subtitle', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Design Concept', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $repeater_items->add_control(
            'awea_item_category',
            [
                'label'       => esc_html__( 'Assigned Categories', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'description' => esc_html__( 'Separate multiple categories with commas (e.g. Architecture, Minimalism).', 'awesome-widgets-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater_items->add_control(
            'awea_item_link',
            [
                'label'       => esc_html__( 'Case Study Link (Optional)', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'https://example.com',
            ]
        );

        $this->add_control(
            'awea_gallery_items',
            [
                'label'       => esc_html__( 'Items List', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_items->get_controls(),
                'default'     => [
                    [
                        'awea_item_title'    => esc_html__( 'Tokyo Cyberpunk', 'awesome-widgets-elementor' ),
                        'awea_item_subtitle' => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
                        'awea_item_category' => 'Architecture, Minimalism',
                    ],
                    [
                        'awea_item_title'    => esc_html__( 'Alpine Serenity', 'awesome-widgets-elementor' ),
                        'awea_item_subtitle' => esc_html__( 'Landscape', 'awesome-widgets-elementor' ),
                        'awea_item_category' => 'Landscape',
                    ],
                    [
                        'awea_item_title'    => esc_html__( 'Vogue Monolith', 'awesome-widgets-elementor' ),
                        'awea_item_subtitle' => esc_html__( 'Portraits', 'awesome-widgets-elementor' ),
                        'awea_item_category' => 'Portraits',
                    ],
                    [
                        'awea_item_title'    => esc_html__( 'Bauhaus Geometry', 'awesome-widgets-elementor' ),
                        'awea_item_subtitle' => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
                        'awea_item_category' => 'Architecture, Minimalism',
                    ],
                    [
                        'awea_item_title'    => esc_html__( 'Nordic Fjords', 'awesome-widgets-elementor' ),
                        'awea_item_subtitle' => esc_html__( 'Landscape', 'awesome-widgets-elementor' ),
                        'awea_item_category' => 'Landscape',
                    ],
                    [
                        'awea_item_title'    => esc_html__( 'Minimal Silhouette', 'awesome-widgets-elementor' ),
                        'awea_item_subtitle' => esc_html__( 'Minimalism', 'awesome-widgets-elementor' ),
                        'awea_item_category' => 'Portraits, Minimalism',
                    ],
                ],
                'title_field' => '{{{ awea_item_title || "Gallery Item" }}}',
            ]
        );

        $this->add_control(
            'awea_title_tag',
            [
                'label'     => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'h4',
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
           TAB: CONTENT -> SECTION: GRID LAYOUT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_grid_settings',
            [
                'label' => esc_html__( 'Grid Layout', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'awea_grid_columns',
            [
                'label'          => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options'        => [
                    '1' => '1 Column',
                    '2' => '2 Columns',
                    '3' => '3 Columns',
                    '4' => '4 Columns',
                    '5' => '5 Columns',
                    '6' => '6 Columns',
                ],
                'selectors'      => [
                    '{{WRAPPER}} .awea-fg-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_grid_gap',
            [
                'label'      => esc_html__( 'Space Between Cards', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 24 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-fg-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_aspect_ratio',
            [
                'label'     => esc_html__( 'Photo Aspect Ratio', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '4/3',
                'options'   => [
                    '1/1'  => '1:1 Square',
                    '4/3'  => '4:3 Standard',
                    '16/9' => '16:9 Cinema',
                    '3/4'  => '3:4 Editorial',
                    'auto' => 'Original Aspect',
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-thumb' => 'aspect-ratio: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: FILTER NAVIGATION BAR
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_filter_bar',
            [
                'label'     => esc_html__( 'Filter Bar Navigation', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_show_filter_bar' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_nav_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-fg-btn',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_nav_padding',
            [
                'label'      => esc_html__( 'Button Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '9', 'right' => '20', 'bottom' => '9', 'left' => '20', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-fg-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_nav_track_margin',
            [
                'label'      => esc_html__( 'Filter Bar Margin', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '0', 'right' => '0', 'bottom' => '36', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-fg-nav-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_nav_track_bg',
            [
                'label'     => esc_html__( 'Track Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(15, 23, 42, 0.05)',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-nav-track' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_nav_color_tabs' );

        // Normal State
        $this->start_controls_tab(
            'awea_nav_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_nav_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover State
        $this->start_controls_tab(
            'awea_nav_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_nav_hover_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Active State
        $this->start_controls_tab(
            'awea_nav_tab_active',
            [ 'label' => esc_html__( 'Active', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_nav_active_text_color',
            [
                'label'     => esc_html__( 'Active Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-btn.is-active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_nav_pill_bg_color',
            [
                'label'     => esc_html__( 'Active Pill Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-pill-indicator' => 'background-color: {{VALUE}}; box-shadow: 0 4px 14px {{VALUE}}55;',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Counter Pill Subgroup
        $this->add_control(
            'awea_heading_counter_style',
            [
                'label'     => esc_html__( 'Counter Badge', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'awea_show_counter' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_counter_bg',
            [
                'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(15, 23, 42, 0.08)',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-counter' => 'background-color: {{VALUE}};',
                ],
                'condition' => [ 'awea_show_counter' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_counter_active_bg',
            [
                'label'     => esc_html__( 'Active Badge Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(255, 255, 255, 0.25)',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-btn.is-active .awea-fg-counter' => 'background-color: {{VALUE}};',
                ],
                'condition' => [ 'awea_show_counter' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: CARD SHELL
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_cards',
            [
                'label' => esc_html__( 'Card Shell', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_card_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-fg-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'awea_card_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#090d16',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_card_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-fg-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-fg-card',
            ]
        );

        $this->end_controls_tab();

        // Hover Card (No transform / lift / zoom)
        $this->start_controls_tab(
            'awea_card_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_card_border_hover',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-card:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow_hover',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-fg-card:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: CAPTIONS & OVERLAY
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_overlay',
            [
                'label' => esc_html__( 'Captions & Overlay', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_overlay_card_bg',
            [
                'label'     => esc_html__( 'Frosted Dock Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(15, 23, 42, 0.85)',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_dock_padding',
            [
                'label'      => esc_html__( 'Dock Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '14', 'right' => '18', 'bottom' => '14', 'left' => '18', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-fg-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_dock_radius',
            [
                'label'      => esc_html__( 'Dock Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [ 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-fg-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Title Styling
        $this->add_control(
            'awea_heading_title_style',
            [
                'label'     => esc_html__( 'Project Title', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_title_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_title_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-fg-title',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        // Subtitle Styling
        $this->add_control(
            'awea_heading_sub_style',
            [
                'label'     => esc_html__( 'Category / Subtitle', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_subtitle_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_subtitle_typography',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-fg-subtitle',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        // Action Buttons Subgroup
        $this->add_control(
            'awea_heading_action_btn_style',
            [
                'label'     => esc_html__( 'Action Circle Buttons', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs( 'awea_action_btn_tabs' );

        // Normal Action
        $this->start_controls_tab(
            'awea_act_btn_tab_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_act_btn_color',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-action-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_act_btn_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(255, 255, 255, 0.12)',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-action-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_act_btn_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-fg-action-btn',
            ]
        );

        $this->end_controls_tab();

        // Hover Action (Zero Zoom/Scale)
        $this->start_controls_tab(
            'awea_act_btn_tab_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_act_btn_hover_color',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#0f172a',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-action-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_act_btn_hover_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-action-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_act_btn_hover_border',
            [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-fg-action-btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $gallery_items = ! empty( $settings['awea_gallery_items'] ) ? $settings['awea_gallery_items'] : [];
        $category_list = ! empty( $settings['awea_categories'] ) ? $settings['awea_categories'] : [];
        $show_menu     = 'yes' === ( $settings['awea_show_filter_bar'] ?? 'no' );
        $show_counts   = 'yes' === ( $settings['awea_show_counter'] ?? 'no' );
        $all_label     = ! empty( $settings['awea_all_label'] ) ? $settings['awea_all_label'] : esc_html__( 'All Works', 'awesome-widgets-elementor' );
        $title_tag     = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h4' );

        // Build Category Counts
        $cat_counts = [ '*' => count( $gallery_items ) ];
        foreach ( $gallery_items as $item ) {
            $raw_cats = explode( ',', $item['awea_item_category'] ?? '' );
            foreach ( $raw_cats as $rc ) {
                $clean = sanitize_title( trim( $rc ) );
                if ( ! empty( $clean ) ) {
                    $cat_counts[ $clean ] = ( $cat_counts[ $clean ] ?? 0 ) + 1;
                }
            }
        }
        ?>
        <div class="awea-filter-gallery-studio" id="awea-fg-<?php echo esc_attr( $this->get_id() ); ?>">

            <?php if ( $show_menu ) : ?>
                <!-- Sliding Pill Navigation -->
                <div class="awea-fg-nav-wrapper">
                    <div class="awea-fg-nav-track" role="tablist">
                        <span class="awea-fg-pill-indicator" aria-hidden="true"></span>

                        <button type="button" class="awea-fg-btn is-active" data-filter="*" role="tab" aria-selected="true">
                            <span class="awea-fg-btn-text"><?php echo esc_html( $all_label ); ?></span>
                            <?php if ( $show_counts ) : ?>
                                <span class="awea-fg-counter"><?php echo esc_html( (string) $cat_counts['*'] ); ?></span>
                            <?php endif; ?>
                        </button>

                        <?php foreach ( $category_list as $cat ) : 
                            $cat_raw  = $cat['awea_cat_name'] ?? '';
                            $cat_slug = sanitize_title( $cat_raw );
                            if ( empty( $cat_slug ) ) continue;
                            $count = $cat_counts[ $cat_slug ] ?? 0;
                        ?>
                            <button type="button" class="awea-fg-btn" data-filter=".awea-cat-<?php echo esc_attr( $cat_slug ); ?>" role="tab" aria-selected="false">
                                <span class="awea-fg-btn-text"><?php echo esc_html( $cat_raw ); ?></span>
                                <?php if ( $show_counts ) : ?>
                                    <span class="awea-fg-counter"><?php echo esc_html( (string) $count ); ?></span>
                                <?php endif; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Filtered Grid -->
            <div class="awea-fg-grid">
                <?php foreach ( $gallery_items as $index => $item ) : 
                    $img_url     = $item['awea_item_image']['url'] ?? Utils::get_placeholder_image_src();
                    $title       = $item['awea_item_title'] ?? '';
                    $subtitle    = $item['awea_item_subtitle'] ?? '';
                    $custom_url  = $item['awea_item_link']['url'] ?? '';
                    $target      = ! empty( $item['awea_item_link']['is_external'] ) ? '_blank' : '_self';
                    $nofollow    = ! empty( $item['awea_item_link']['nofollow'] ) ? 'rel="nofollow"' : '';

                    $raw_cats    = explode( ',', $item['awea_item_category'] ?? '' );
                    $cat_classes = [];
                    foreach ( $raw_cats as $rc ) {
                        $c_slug = sanitize_title( trim( $rc ) );
                        if ( ! empty( $c_slug ) ) {
                            $cat_classes[] = 'awea-cat-' . $c_slug;
                        }
                    }
                    $class_string = implode( ' ', $cat_classes );
                ?>
                    <div class="awea-fg-item <?php echo esc_attr( $class_string ); ?>" data-index="<?php echo esc_attr( $index ); ?>">
                        <article class="awea-fg-card">
                            
                            <!-- Thumbnail Canvas -->
                            <div class="awea-fg-thumb" style="background-image: url('<?php echo esc_url( $img_url ); ?>');">
                                <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" />
                            </div>

                            <!-- Frosted Glass Caption Dock -->
                            <div class="awea-fg-overlay">
                                <div class="awea-fg-meta">
                                    <?php if ( ! empty( $subtitle ) ) : ?>
                                        <span class="awea-fg-subtitle"><?php echo esc_html( $subtitle ); ?></span>
                                    <?php endif; ?>
                                    
                                    <?php if ( ! empty( $title ) ) : ?>
                                        <<?php echo esc_attr( $title_tag ); ?> class="awea-fg-title"><?php echo esc_html( $title ); ?></<?php echo esc_attr( $title_tag ); ?>>
                                    <?php endif; ?>
                                </div>

                                <!-- Action Button Cluster -->
                                <div class="awea-fg-actions">
                                    <a href="<?php echo esc_url( $img_url ); ?>" 
                                       class="awea-fg-action-btn awea-fg-lightbox elementor-lightbox" 
                                       data-elementor-open-lightbox="yes" 
                                       data-elementor-lightbox-slideshow="awea-fg-<?php echo esc_attr( $this->get_id() ); ?>"
                                       title="<?php echo esc_attr( $title ); ?>"
                                       aria-label="<?php esc_attr_e( 'View Full Image', 'awesome-widgets-elementor' ); ?>">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                                    </a>

                                    <?php if ( ! empty( $custom_url ) ) : ?>
                                        <a href="<?php echo esc_url( $custom_url ); ?>" 
                                           target="<?php echo esc_attr( $target ); ?>" 
                                           <?php echo $nofollow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> 
                                           class="awea-fg-action-btn awea-fg-link" 
                                           aria-label="<?php esc_attr_e( 'Open Project Case Study', 'awesome-widgets-elementor' ); ?>">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- Scoped Smooth Filter Navigation Script -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var scope = document.getElementById('awea-fg-<?php echo esc_js( $this->get_id() ); ?>');
            if (!scope) return;

            var indicator = scope.querySelector('.awea-fg-pill-indicator');
            var buttons   = scope.querySelectorAll('.awea-fg-btn');
            var items     = Array.from(scope.querySelectorAll('.awea-fg-item'));

            function updateIndicator(activeBtn) {
                if (!indicator || !activeBtn) return;
                indicator.style.width   = activeBtn.offsetWidth + 'px';
                indicator.style.height  = activeBtn.offsetHeight + 'px';
                indicator.style.left    = activeBtn.offsetLeft + 'px';
                indicator.style.top     = activeBtn.offsetTop + 'px';
                indicator.style.opacity = '1';
            }

            var defaultActive = scope.querySelector('.awea-fg-btn.is-active');
            if (defaultActive) {
                setTimeout(function() { updateIndicator(defaultActive); }, 80);
            }

            buttons.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (this.classList.contains('is-active')) return;

                    buttons.forEach(function(b) { 
                        b.classList.remove('is-active');
                        b.setAttribute('aria-selected', 'false');
                    });
                    this.classList.add('is-active');
                    this.setAttribute('aria-selected', 'true');
                    updateIndicator(this);

                    var filterVal = this.getAttribute('data-filter');

                    items.forEach(function(item) {
                        var matches = (filterVal === '*' || item.matches(filterVal));
                        item.style.display = matches ? '' : 'none';
                    });
                });
            });

            window.addEventListener('resize', function() {
                var currentActive = scope.querySelector('.awea-fg-btn.is-active');
                if (currentActive) updateIndicator(currentActive);
            });
        });
        </script>
        <?php
    }
}