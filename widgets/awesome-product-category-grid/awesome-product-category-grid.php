<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Widget Name: Awesome Product Category Grid
 * Description: Dynamic WooCommerce Category Grid with Luxury Glassmorphism and Hover Effects.
 */
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
        return [ 'awesome-widgets-elementor' ]; 
    }

    protected function register_controls() {

        // ==========================================
        // CONTENT TAB: QUERY & LAYOUT
        // ==========================================
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__( 'Category Query & Layout', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'taxonomy_filter',
            [
                'label' => esc_html__( 'Select Categories', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => $this->get_product_categories(),
                'description' => esc_html__( 'Specific categories to show. Leave empty for all.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__( 'Total Items to Show', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1 Column',
                    '2' => '2 Columns',
                    '3' => '3 Columns',
                    '4' => '4 Columns',
                ],
                'selectors' => [
                    '{{WRAPPER}} .grid-wrapper' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__( 'Order By', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'name',
                'options' => [
                    'name'  => 'Name',
                    'count' => 'Product Count',
                    'id'    => 'ID',
                    'slug'  => 'Slug',
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__( 'Order', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'ASC',
                'options' => [
                    'ASC'  => 'Ascending',
                    'DESC' => 'Descending',
                ],
            ]
        );

        $this->end_controls_section();

        // ==========================================
        // STYLE TAB: GRID & CARDS
        // ==========================================
        $this->start_controls_section(
            'section_style_grid',
            [
                'label' => esc_html__( 'Grid & Cards', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_height',
            [
                'label' => esc_html__( 'Card Height', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [ 'px' => ['min' => 200, 'max' => 1200] ],
                'default' => ['unit' => 'px', 'size' => 600],
                'selectors' => [ '{{WRAPPER}} .cat-card' => 'height: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->add_responsive_control(
            'column_gap',
            [
                'label' => esc_html__( 'Spacing (Gap)', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 30],
                'selectors' => [ '{{WRAPPER}} .grid-wrapper' => 'gap: {{SIZE}}px;' ],
            ]
        );

        $this->add_control(
            'card_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [ '{{WRAPPER}} .cat-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_shadow',
                'selector' => '{{WRAPPER}} .cat-card',
            ]
        );

        $this->end_controls_section();

        // ==========================================
        // STYLE TAB: OVERLAY & GLASS (WITH FIXED TABS)
        // ==========================================
        $this->start_controls_section(
            'section_style_overlay',
            [
                'label' => esc_html__( 'Overlay & Glass Box', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_overlay_styles' );

        // --- Normal State Tab ---
        $this->start_controls_tab(
            'tab_overlay_normal',
            [
                'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'image_overlay_bg',
                'label' => esc_html__( 'Image Overlay', 'awesome-widgets-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .cat-card::before',
            ]
        );

        $this->add_control(
            'glass_box_bg',
            [
                'label' => esc_html__( 'Glass Background', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(255, 255, 255, 0.05)',
                'selectors' => [ '{{WRAPPER}} .cat-info' => 'background: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        // --- Hover State Tab ---
        $this->start_controls_tab(
            'tab_overlay_hover',
            [
                'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'glass_box_bg_hover',
            [
                'label' => esc_html__( 'Glass Background Hover', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(255, 255, 255, 0.12)',
                'selectors' => [ '{{WRAPPER}} .cat-card:hover .cat-info' => 'background: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'glow_intensity',
            [
                'label' => esc_html__( 'Hover Glow Intensity', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [ 'px' => ['min' => 0, 'max' => 1, 'step' => 0.1] ],
                'default' => [ 'size' => 1 ],
                'selectors' => [ '{{WRAPPER}} .cat-card:hover::after' => 'opacity: {{SIZE}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'glass_blur',
            [
                'label' => esc_html__( 'Glass Blur Intensity', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 15],
                'range' => [ 'px' => ['min' => 0, 'max' => 50] ],
                'selectors' => [ '{{WRAPPER}} .cat-info' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);' ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        // ==========================================
        // STYLE TAB: TYPOGRAPHY & TEXT
        // ==========================================
        $this->start_controls_section(
            'section_style_typo',
            [
                'label' => esc_html__( 'Typography & Text', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Subtitle Styling
        $this->add_control( 'sub_head', [ 'label' => esc_html__( 'Subtitle', 'awesome-widgets-elementor' ), 'type' => Controls_Manager::HEADING ] );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [ 'name' => 'sub_typo', 'selector' => '{{WRAPPER}} .cat-info span' ]
        );
        $this->add_control( 'sub_color', [ 'label' => 'Color', 'type' => Controls_Manager::COLOR, 'default' => 'rgba(255,255,255,0.6)', 'selectors' => [ '{{WRAPPER}} .cat-info span' => 'color: {{VALUE}};' ] ] );

        // Title Styling
        $this->add_control( 'title_head', [ 'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [ 'name' => 'title_typo', 'selector' => '{{WRAPPER}} .cat-info h3' ]
        );
        $this->add_control( 'title_color', [ 'label' => 'Color', 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => [ '{{WRAPPER}} .cat-info h3' => 'color: {{VALUE}};' ] ] );

        // Button Styling
        $this->add_control( 'btn_head', [ 'label' => esc_html__( 'Button/Link', 'awesome-widgets-elementor' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [ 'name' => 'btn_typo', 'selector' => '{{WRAPPER}} .view-collection' ]
        );
        $this->add_control( 'btn_color', [ 'label' => 'Color', 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => [ '{{WRAPPER}} .view-collection' => 'color: {{VALUE}};' ] ] );

        $this->end_controls_section();
    }

    protected function get_product_categories() {
        $options = [];
        if ( taxonomy_exists( 'product_cat' ) ) {
            $terms = get_terms( ['taxonomy' => 'product_cat', 'hide_empty' => false] );
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                foreach ( $terms as $term ) { $options[ $term->term_id ] = $term->name; }
            }
        }
        return $options;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $args = [
            'taxonomy'   => 'product_cat',
            'number'     => $settings['posts_per_page'],
            'orderby'    => $settings['orderby'],
            'order'      => $settings['order'],
            'hide_empty' => false,
        ];

        if ( ! empty( $settings['taxonomy_filter'] ) ) {
            $args['include'] = $settings['taxonomy_filter'];
            if ( 'name' !== $settings['orderby'] ) { $args['orderby'] = 'include'; }
        }

        $terms = get_terms( $args );

        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div class="elementor-alert elementor-alert-warning">No product categories found.</div>';
            }
            return;
        }
        ?>

        <style>
            .grid-wrapper { display: grid; width: 100%; }
            .cat-card {
                position: relative;
                overflow: hidden;
                text-decoration: none;
                display: block;
                background: #1a1a1a;
                isolation: isolate;
                transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            }
            /* Overlay Gradient Layer */
            .cat-card::before {
                content: '';
                position: absolute;
                inset: 0;
                z-index: 1;
                pointer-events: none;
                transition: opacity 0.8s ease;
                background: linear-gradient(to bottom, transparent 30%, rgba(0,0,0,0.85) 100%);
            }
            .cat-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                filter: grayscale(40%) brightness(0.8);
                transition: transform 1.2s cubic-bezier(0.23, 1, 0.32, 1), filter 0.8s ease;
                display: block;
            }
            .cat-info {
                position: absolute;
                bottom: 25px;
                left: 20px;
                right: 20px;
                padding: 30px;
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 15px;
                z-index: 2;
                transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            }
            .cat-info span { display: block; margin-bottom: 8px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; }
            .cat-info h3 { margin: 0; font-size: 1.6rem; font-weight: 700; line-height: 1.2; }
            .view-collection {
                display: flex;
                align-items: center;
                margin-top: 20px;
                font-weight: 600;
                font-size: 0.85rem;
                opacity: 0;
                transform: translateX(-10px);
                transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
            }
            .view-collection::after { content: '→'; margin-left: 10px; transition: transform 0.3s ease; }

            /* HOVER ANIMATIONS */
            .cat-card:hover .cat-image { transform: scale(1.1) rotate(0.5deg); filter: grayscale(0%) brightness(1); }
            .cat-card:hover .cat-info { transform: translateY(-8px); border-color: rgba(255, 255, 255, 0.35); }
            .cat-card:hover .view-collection { opacity: 1; transform: translateX(0); }
            .cat-card:hover .view-collection::after { transform: translateX(5px); }

            /* Radial Glow Hover Effect */
            .cat-card::after {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at 50% 120%, rgba(255,255,255,0.15) 0%, transparent 70%);
                opacity: 0;
                transition: opacity 0.8s ease;
                pointer-events: none;
                z-index: 3;
            }
            
            @media (max-width: 1024px) { 
                .cat-info { padding: 20px; } 
                .cat-info h3 { font-size: 1.3rem; }
            }
            @media (max-width: 767px) { 
                .cat-card { height: 450px !important; } 
            }
        </style>

        <div class="grid-wrapper">
            <?php foreach ( $terms as $term ) : 
                $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                $image_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : \Elementor\Utils::get_placeholder_image_src();
                $link = get_term_link( $term );
            ?>
                <a href="<?php echo esc_url($link); ?>" class="cat-card">
                    <img src="<?php echo esc_url($image_url); ?>" class="cat-image" alt="<?php echo esc_attr($term->name); ?>" loading="lazy">
                    <div class="cat-info">
                        <span><?php echo esc_html__( 'Collection', 'awesome-widgets-elementor' ); ?></span>
                        <h3><?php echo esc_html($term->name); ?></h3>
                        <div class="view-collection">
                            <?php echo esc_html__( 'Explore Collection', 'awesome-widgets-elementor' ); ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    }
}