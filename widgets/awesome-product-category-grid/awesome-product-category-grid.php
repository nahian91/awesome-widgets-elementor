<?php
/**
 * Awesome Product Category Grid Studio Widget.
 * Luxury Dark-Mode Glassmorphism Category Grid with Kinetic Hover Effects.
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

class Widget_Awesome_Product_Category_Grid extends Widget_Base {

    public function get_name() {
        return 'awesome-product-category-grid';
    }

    public function get_title() {
        return esc_html__( 'Product Category Grid', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-product-categories';
    }

    public function get_categories() {
        return [ 'awesome-woo' ];
    }

    public function get_keywords() {
        return [ 'awea', 'woocommerce', 'product category', 'grid', 'shop', 'glassmorphism', 'showcase' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: QUERY & LAYOUT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_query',
            [
                'label' => esc_html__( 'Category Query & Layout', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Category Options Dropdown
        $cat_options = [];
        if ( class_exists( 'WooCommerce' ) ) {
            $categories = get_terms( [
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            ] );
            if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                foreach ( $categories as $cat ) {
                    $cat_options[ $cat->term_id ] = $cat->name;
                }
            }
        }

        $this->add_control(
            'awea_taxonomy_filter',
            [
                'label'       => esc_html__( 'Select Categories', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple'    => true,
                'options'     => $cat_options,
                'description' => esc_html__( 'Specific categories to show. Leave empty for all.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_posts_per_page',
            [
                'label'   => esc_html__( 'Total Items to Show', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 3,
                'min'     => 1,
                'max'     => 50,
            ]
        );

        $this->add_responsive_control(
            'awea_columns',
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
                ],
                'selectors'      => [
                    '{{WRAPPER}} .awea-grid-wrapper' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
                ],
            ]
        );

        $this->add_control(
            'awea_orderby',
            [
                'label'   => esc_html__( 'Order By', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'name',
                'options' => [
                    'name'  => esc_html__( 'Name', 'awesome-widgets-elementor' ),
                    'count' => esc_html__( 'Product Count', 'awesome-widgets-elementor' ),
                    'id'    => esc_html__( 'ID', 'awesome-widgets-elementor' ),
                    'slug'  => esc_html__( 'Slug', 'awesome-widgets-elementor' ),
                    'rand'  => esc_html__( 'Random', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'awea_order',
            [
                'label'   => esc_html__( 'Order', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => [
                    'ASC'  => esc_html__( 'Ascending (A-Z)', 'awesome-widgets-elementor' ),
                    'DESC' => esc_html__( 'Descending (Z-A)', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'awea_kicker_text',
            [
                'label'       => esc_html__( 'Subtitle Kicker Text', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Collection', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'awea_action_text',
            [
                'label'       => esc_html__( 'Explore Link Text', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Explore Collection', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: GRID & CARDS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_grid',
            [
                'label' => esc_html__( 'Grid & Cards', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_card_height',
            [
                'label'          => esc_html__( 'Card Height', 'awesome-widgets-elementor' ),
                'type'           => Controls_Manager::SLIDER,
                'size_units'     => [ 'px', 'vh' ],
                'range'          => [ 'px' => [ 'min' => 200, 'max' => 1200 ] ],
                'default'        => [ 'unit' => 'px', 'size' => 540 ],
                'tablet_default' => [ 'unit' => 'px', 'size' => 460 ],
                'mobile_default' => [ 'unit' => 'px', 'size' => 380 ],
                'selectors'      => [
                    '{{WRAPPER}} .awea-cat-card' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_column_gap',
            [
                'label'      => esc_html__( 'Spacing (Gap)', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [ 'unit' => 'px', 'size' => 24 ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-grid-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_card_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cat-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_card_border',
                'label'    => esc_html__( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cat-card',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_card_shadow',
                'label'    => esc_html__( 'Box Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cat-card',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: OVERLAY & GLASS BOX
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_overlay',
            [
                'label' => esc_html__( 'Overlay & Glass Box', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'awea_tabs_overlay_styles' );

        // Normal State Tab
        $this->start_controls_tab(
            'awea_tab_overlay_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'awea_image_overlay_bg',
                'label'    => esc_html__( 'Image Overlay Gradient', 'awesome-widgets-elementor' ),
                'types'    => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .awea-cat-card::before',
            ]
        );

        $this->add_control(
            'awea_glass_box_bg',
            [
                'label'     => esc_html__( 'Glass Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(255, 255, 255, 0.06)',
                'selectors' => [
                    '{{WRAPPER}} .awea-cat-info' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_glass_border',
                'label'    => esc_html__( 'Glass Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cat-info',
            ]
        );

        $this->end_controls_tab();

        // Hover State Tab (Zero Lift)
        $this->start_controls_tab(
            'awea_tab_overlay_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_glass_box_bg_hover',
            [
                'label'     => esc_html__( 'Glass Background Hover', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(255, 255, 255, 0.14)',
                'selectors' => [
                    '{{WRAPPER}} .awea-cat-card:hover .awea-cat-info' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_glass_border_hover',
            [
                'label'     => esc_html__( 'Glass Border Color Hover', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(255, 255, 255, 0.35)',
                'selectors' => [
                    '{{WRAPPER}} .awea-cat-card:hover .awea-cat-info' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_glow_intensity',
            [
                'label'     => esc_html__( 'Hover Glow Opacity', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
                'default'   => [ 'size' => 1 ],
                'selectors' => [
                    '{{WRAPPER}} .awea-cat-card:hover::after' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'awea_glass_blur',
            [
                'label'      => esc_html__( 'Glass Blur Intensity', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [ 'unit' => 'px', 'size' => 16 ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cat-info' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'awea_glass_padding',
            [
                'label'      => esc_html__( 'Glass Box Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem' ],
                'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cat-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_glass_radius',
            [
                'label'      => esc_html__( 'Glass Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px', 'isLinked' => true ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cat-info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_glass_offset',
            [
                'label'      => esc_html__( 'Glass Inset Spacing', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 8, 'max' => 50 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 20 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cat-info' => 'left: {{SIZE}}{{UNIT}}; right: {{SIZE}}{{UNIT}}; bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: TYPOGRAPHY & TEXT
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_typo',
            [
                'label' => esc_html__( 'Typography & Text', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Subtitle Styling
        $this->add_control(
            'awea_heading_subtitle',
            [
                'label' => esc_html__( 'Subtitle Kicker', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'awea_sub_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(255, 255, 255, 0.65)',
                'selectors' => [
                    '{{WRAPPER}} .awea-cat-info span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_sub_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cat-info span',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_sub_margin_bottom',
            [
                'label'      => esc_html__( 'Space Below Kicker', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 6 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cat-info span' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Title Styling
        $this->add_control(
            'awea_heading_title',
            [
                'label'     => esc_html__( 'Category Title', 'awesome-widgets-elementor' ),
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
                    '{{WRAPPER}} .awea-cat-info h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_title_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-cat-info h3',
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
                'size_units' => [ 'px', 'rem' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 14 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-cat-info h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Action Link Styling
        $this->add_control(
            'awea_heading_action',
            [
                'label'     => esc_html__( 'Explore Link', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_btn_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-view-collection' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_btn_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-cat-card:hover .awea-view-collection' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_btn_typo',
                'label'    => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-view-collection',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        if ( ! class_exists( 'WooCommerce' ) ) {
            echo '<div class="awea-notice-error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Category Grid Studio widget.', 'awesome-widgets-elementor' ) . '</p></div>';
            return;
        }

        $settings = $this->get_settings_for_display();
        $limit    = ! empty( $settings['awea_posts_per_page'] ) ? absint( $settings['awea_posts_per_page'] ) : 3;
        $orderby  = $settings['awea_orderby'] ?? 'name';
        $order    = $settings['awea_order'] ?? 'ASC';
        $filter   = $settings['awea_taxonomy_filter'] ?? [];
        $kicker   = ! empty( $settings['awea_kicker_text'] ) ? $settings['awea_kicker_text'] : esc_html__( 'Collection', 'awesome-widgets-elementor' );
        $action   = ! empty( $settings['awea_action_text'] ) ? $settings['awea_action_text'] : esc_html__( 'Explore Collection', 'awesome-widgets-elementor' );

        $args = [
            'taxonomy'   => 'product_cat',
            'number'     => $limit,
            'orderby'    => $orderby,
            'order'      => $order,
            'hide_empty' => false,
        ];

        if ( ! empty( $filter ) && is_array( $filter ) ) {
            $args['include'] = array_map( 'absint', $filter );
            if ( 'name' !== $orderby ) {
                $args['orderby'] = 'include';
            }
        }

        $terms = get_terms( $args );

        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            if ( Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div class="elementor-alert elementor-alert-warning">' . esc_html__( 'No product categories found.', 'awesome-widgets-elementor' ) . '</div>';
            }
            return;
        }
        ?>
        <div class="awea-product-category-grid-wrap">
            <div class="awea-grid-wrapper">
                <?php foreach ( $terms as $term ) : 
                    $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                    $image_url    = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src() : '' );
                    $link         = get_term_link( $term );
                ?>
                    <a href="<?php echo esc_url( $link ); ?>" class="awea-cat-card">
                        <?php if ( ! empty( $image_url ) ) : ?>
                            <img src="<?php echo esc_url( $image_url ); ?>" class="awea-cat-image" alt="<?php echo esc_attr( $term->name ); ?>" loading="lazy" />
                        <?php endif; ?>

                        <div class="awea-cat-info">
                            <?php if ( ! empty( $kicker ) ) : ?>
                                <span aria-hidden="true"><?php echo esc_html( $kicker ); ?></span>
                            <?php endif; ?>
                            <h3><?php echo esc_html( $term->name ); ?></h3>
                            <?php if ( ! empty( $action ) ) : ?>
                                <div class="awea-view-collection">
                                    <?php echo esc_html( $action ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}