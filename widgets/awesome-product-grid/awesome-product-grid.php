<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Awesome_Product_Grid extends Widget_Base {

    public function get_name() { return 'awesome-product-grid'; }
    public function get_title() { return esc_html__( 'Products Grid', 'awesome-widgets-elementor' ); }
    public function get_icon() { return 'eicon-product-categories'; }
    public function get_categories() { return [ 'awesome-widgets-elementor' ]; }

    // Helper: Fetch products for manual selection dropdown
    private function get_all_products() {
        $products = get_posts([
            'post_type' => 'product',
            'posts_per_page' => -1,
        ]);
        $options = [];
        foreach ( $products as $product ) {
            $options[ $product->ID ] = $product->post_title;
        }
        return $options;
    }

    // Helper: Fetch categories for dropdown
    private function get_all_categories() {
        $terms = get_terms( 'product_cat' );
        $options = [];
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $options[ $term->slug ] = $term->name;
            }
        }
        return $options;
    }

    protected function register_controls() {

        // --- CONTENT: QUERY ---
        $this->start_controls_section('awea_product_grid_section_query', [
            'label' => __( 'Product Query', 'awesome-widgets-elementor' ),
        ]);

        $this->add_control('awea_product_grid_query_type', [
            'label'   => __( 'Query Type', 'awesome-widgets-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'latest',
            'options' => [
                'latest'   => __( 'Latest Products', 'awesome-widgets-elementor' ),
                'manual'   => __( 'Manual Selection', 'awesome-widgets-elementor' ),
                'category' => __( 'By Category', 'awesome-widgets-elementor' ),
            ],
        ]);

        $this->add_control('awea_product_grid_manual_product_ids', [
            'label'       => __( 'Select Products', 'awesome-widgets-elementor' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple'    => true,
            'options'     => $this->get_all_products(),
            'condition'   => [ 'awea_product_grid_query_type' => 'manual' ],
        ]);

        $this->add_control('awea_product_grid_product_categories', [
            'label'       => __( 'Select Categories', 'awesome-widgets-elementor' ),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'multiple'    => true,
            'options'     => $this->get_all_categories(),
            'condition'   => [ 'awea_product_grid_query_type' => 'category' ],
        ]);

        $this->add_control('awea_product_grid_product_number', [
            'label'   => __( 'Product Count', 'awesome-widgets-elementor' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 3,
            'condition' => [ 'awea_product_grid_query_type!' => 'manual' ],
        ]);

        $this->add_control('awea_product_grid_product_orderby', [
            'label'   => __( 'Order By', 'awesome-widgets-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'date',
            'options' => [
                'date'  => 'Date',
                'title' => 'Title',
                'price' => 'Price',
                'rand'  => 'Random',
            ],
            'condition' => [ 'awea_product_grid_query_type!' => 'manual' ],
        ]);

        $this->add_control('awea_product_grid_product_order', [
            'label'   => __( 'Order', 'awesome-widgets-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'DESC',
            'options' => [
                'ASC'  => 'ASC',
                'DESC' => 'DESC',
            ],
            'condition' => [ 'awea_product_grid_query_type!' => 'manual' ],
        ]);

        $this->end_controls_section();

        // --- CONTENT: LAYOUT ---
        $this->start_controls_section('awea_product_grid_section_layout', [
            'label' => __( 'Grid Layout', 'awesome-widgets-elementor' ),
        ]);

        $this->add_responsive_control('awea_product_grid_product_column_width', [
            'label' => __( 'Column', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::SELECT,
            'default' => '4',
            'options' => [
                '12' => '1',
                '6'  => '2',
                '4'  => '3',
                '3'  => '4',
            ],
        ]);

        $this->end_controls_section();

        // --- STYLE: LAYOUT ---
        $this->start_controls_section('awea_product_grid_product_section_style_layout', [
            'label' => __( 'Layout', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('awea_product_grid_product_card_padding', [
            'label'      => __( 'Padding', 'awesome-widgets-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [ '{{WRAPPER}} .awea-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_responsive_control('awea_product_grid_product_card_radius', [
            'label'      => __( 'Border Radius', 'awesome-widgets-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'default'    => [ 'size' => 32, 'unit' => 'px' ],
            'selectors'  => [ '{{WRAPPER}} .awea-card, {{WRAPPER}} .awea-card::after' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ]);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_product_grid_product_card_border',
                'label'    => __( 'Border', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-card',
            ]
        );

        $this->add_responsive_control('awea_product_grid_product_card_alignment', [
            'label'     => __( 'Alignment', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
                'left'   => [ 'title' => __( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}} .awea-card' => 'text-align: {{VALUE}};' ],
        ]);

        $this->add_control('awea_product_grid_product_kinetic_border_color', [
            'label'     => __( 'Border Glow Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#6366f1',
            'selectors' => [
                '{{WRAPPER}} .awea-card::after' => 'background: conic-gradient(from var(--bento-angle), transparent 70%, {{VALUE}}, transparent);'
            ],
        ]);

        $this->end_controls_section();

        // --- STYLE: META PANEL ---
        $this->start_controls_section('awea_product_grid_product_section_style_meta', [
            'label' => __( 'Meta Panel', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('awea_product_grid_product_heading_sale_style', [
            'label'     => __( 'Sale Heading', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::HEADING,
        ]);

        $this->add_control('awea_product_grid_product_sale_badge_color', [
            'label'     => __( 'Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-badge-sale' => 'color: {{VALUE}};' ],
        ]);

        $this->add_control('awea_product_grid_product_sale_badge_bg', [
            'label'     => __( 'Background Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ef4444',
            'selectors' => [ '{{WRAPPER}} .awea-badge-sale' => 'background: {{VALUE}};' ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_product_grid_product_sale_typography',
                'selector' => '{{WRAPPER}} .awea-badge-sale',
            ]
        );

        $this->add_control('awea_product_grid_product_heading_category_style', [
            'label'     => __( 'Category', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_control('awea_product_grid_product_brand_color', [
            'label'     => __( 'Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#6366f1',
            'selectors' => [ '{{WRAPPER}} .awea-brand' => 'color: {{VALUE}};' ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_product_grid_product_category_typography',
                'selector' => '{{WRAPPER}} .awea-brand',
            ]
        );

        $this->end_controls_section();

        // --- STYLE: TITLE PANEL ---
        $this->start_controls_section('awea_product_grid_product_section_style_title', [
            'label' => __( 'Title Panel', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('awea_product_grid_product_title_color', [
            'label'     => __( 'Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#0f172a',
            'selectors' => [ '{{WRAPPER}} .awea-product-name' => 'color: {{VALUE}};' ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_product_grid_product_title_typography',
                'selector' => '{{WRAPPER}} .awea-product-name',
            ]
        );

        $this->end_controls_section();

        // --- STYLE: BUTTON PANEL ---
        $this->start_controls_section('awea_product_grid_product_section_style_button', [
            'label' => __( 'Button Panel', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        // Add to Cart Buttons
        $this->add_control('awea_product_grid_product_heading_atc', [
            'label' => __( 'Add to Cart', 'awesome-widgets-elementor' ),
            'type'  => Controls_Manager::HEADING,
        ]);

        $this->start_controls_tabs('awea_product_grid_product_tabs_atc_style');

        $this->start_controls_tab('awea_product_grid_product_tab_atc_normal', [ 'label' => __( 'Normal', 'awesome-widgets-elementor' ) ]);

        $this->add_control('awea_product_grid_product_atc_color', [
            'label'     => __( 'Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-buy-btn' => 'color: {{VALUE}};' ],
        ]);

        $this->add_control('awea_product_grid_product_atc_bg_color', [
            'label'     => __( 'Background Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#0f172a',
            'selectors' => [ '{{WRAPPER}} .awea-buy-btn' => 'background: {{VALUE}};' ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('awea_product_grid_product_tab_atc_hover', [ 'label' => __( 'Hover', 'awesome-widgets-elementor' ) ]);

        $this->add_control('awea_product_grid_product_atc_hover_color', [
            'label'     => __( 'Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-card:hover .awea-buy-btn' => 'color: {{VALUE}};' ],
        ]);

        $this->add_control('awea_product_grid_product_atc_hover_bg_color', [
            'label'     => __( 'Background Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#6366f1',
            'selectors' => [ '{{WRAPPER}} .awea-card:hover .awea-buy-btn' => 'background: {{VALUE}};' ],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_product_grid_product_atc_typography',
                'selector' => '{{WRAPPER}} .awea-buy-btn',
                'separator'=> 'before'
            ]
        );

        $this->add_responsive_control('awea_product_grid_product_atc_padding', [
            'label'      => __( 'Padding', 'awesome-widgets-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'selectors'  => [ '{{WRAPPER}} .awea-buy-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_responsive_control('awea_product_grid_product_atc_radius', [
            'label'      => __( 'Border Radius', 'awesome-widgets-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'selectors'  => [ '{{WRAPPER}} .awea-buy-btn' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ]);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_product_grid_product_atc_border',
                'selector' => '{{WRAPPER}} .awea-buy-btn',
            ]
        );

        // View Cart Buttons
        $this->add_control('awea_product_grid_product_heading_vc', [
            'label'     => __( 'View Cart', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->start_controls_tabs('awea_product_grid_product_tabs_vc_style');

        $this->start_controls_tab('awea_product_grid_product_tab_vc_normal', [ 'label' => __( 'Normal', 'awesome-widgets-elementor' ) ]);

        $this->add_control('awea_product_grid_product_vc_color', [
            'label'     => __( 'Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-view-cart' => 'color: {{VALUE}};' ],
        ]);

        $this->add_control('awea_product_grid_product_vc_bg_color', [
            'label'     => __( 'Background Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-view-cart' => 'background: {{VALUE}};' ],
        ]);

        $this->end_controls_tab();

        $this->start_controls_tab('awea_product_grid_product_tab_vc_hover', [ 'label' => __( 'Hover', 'awesome-widgets-elementor' ) ]);

        $this->add_control('awea_product_grid_product_vc_hover_color', [
            'label'     => __( 'Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-view-cart:hover' => 'color: {{VALUE}};' ],
        ]);

        $this->add_control('awea_product_grid_product_vc_hover_bg_color', [
            'label'     => __( 'Background Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-view-cart:hover' => 'background: {{VALUE}};' ],
        ]);

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_product_grid_product_vc_typography',
                'selector' => '{{WRAPPER}} .awea-view-cart',
                'separator'=> 'before'
            ]
        );

        $this->add_responsive_control('awea_product_grid_product_vc_padding', [
            'label'      => __( 'Padding', 'awesome-widgets-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'selectors'  => [ '{{WRAPPER}} .awea-view-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_responsive_control('awea_product_grid_product_vc_radius', [
            'label'      => __( 'Border Radius', 'awesome-widgets-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'selectors'  => [ '{{WRAPPER}} .awea-view-cart' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ]);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_product_grid_product_vc_border',
                'selector' => '{{WRAPPER}} .awea-view-cart',
            ]
        );

        $this->end_controls_section();
    }

    private function get_grid_classes($settings) {
        $desk = !empty($settings['awea_product_grid_product_column_width']) ? $settings['awea_product_grid_product_column_width'] : '4';
        $tab  = !empty($settings['awea_product_grid_product_column_width_tablet']) ? $settings['awea_product_grid_product_column_width_tablet'] : '6';
        $mob  = !empty($settings['awea_product_grid_product_column_width_mobile']) ? $settings['awea_product_grid_product_column_width_mobile'] : '12';
        return "awea-grid-item awea-grid-{$desk} awea-grid-tablet-{$tab} awea-grid-mobile-{$mob}";
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (!class_exists('woocommerce')) {
            echo '<p>' . esc_html__('WooCommerce is not active.', 'awesome-widgets-elementor') . '</p>';
            return;
        }

        // --- Build WP_Query Arguments ---
        $args = [
            'post_type'      => 'product',
            'post_status'    => 'publish',
        ];

        if ( 'manual' === $settings['awea_product_grid_query_type'] && !empty($settings['awea_product_grid_manual_product_ids']) ) {
            $args['post__in'] = $settings['awea_product_grid_manual_product_ids'];
            $args['orderby']  = 'post__in';
            $args['posts_per_page'] = -1;
        } else {
            $args['posts_per_page'] = intval($settings['awea_product_grid_product_number']);
            $args['order']          = $settings['awea_product_grid_product_order'];
            $args['orderby']        = $settings['awea_product_grid_product_orderby'];

            if ( 'category' === $settings['awea_product_grid_query_type'] && !empty($settings['awea_product_grid_product_categories']) ) {
                $args['tax_query'] = [[
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $settings['awea_product_grid_product_categories'],
                ]];
            }
        }

        $query = new \WP_Query($args);
        ?>

        <div class="awea-grid-row">
            <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); 
                $product = wc_get_product(get_the_ID());
                $in_cart = false;
                if ( WC()->cart ) {
                    foreach( WC()->cart->get_cart() as $cart_item ) {
                        if($cart_item['product_id'] == get_the_ID()) { $in_cart = true; break; }
                    }
                }
            ?>
                <div class="<?php echo esc_attr($this->get_grid_classes($settings)); ?>">
                    <article class="awea-card <?php echo $in_cart ? 'product-in-cart' : ''; ?>">
                        
                        <?php if($product->is_on_sale()) : ?>
                            <span class="awea-badge-sale"><?php esc_html_e('SALE', 'awesome-widgets-elementor'); ?></span>
                        <?php endif; ?>

                        <div class="awea-image-container">
                            <?php the_post_thumbnail('large'); ?>
                        </div>

                        <div class="awea-post-content">
                            <p class="awea-brand">
                                <?php echo esc_html( wp_strip_all_tags( wc_get_product_category_list( get_the_ID(), ', ', '', '' ) ) ); ?>
                            </p>
                            <h2 class="awea-product-name"><?php the_title(); ?></h2>
                        </div>

                        <div class="awea-footer">
                            <div class="awea-pricing">
                                <?php if($product->is_on_sale()) : ?>
                                    <span class="awea-old-price"><?php echo wp_kses_post( wc_price( $product->get_regular_price() ) ); ?></span>
                                <?php endif; ?>
                                <span class="awea-current-price"><?php echo wp_kses_post( wc_price( $product->get_price() ) ); ?></span>
                            </div>

                            <div class="awea-action-container">
                                <a href="?add-to-cart=<?php echo esc_attr(get_the_ID()); ?>" 
                                   data-product_id="<?php echo esc_attr(get_the_ID()); ?>"
                                   class="awea-buy-btn awea-add-to-cart-btn ajax_add_to_cart add_to_cart_button">
                                    <i class="fas fa-shopping-bag"></i>
                                    <span class="awea-btn-label">Add to Cart</span>
                                </a>

                                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="awea-buy-btn awea-view-cart-btn">
                                    <i class="fas fa-check" aria-hidden="true"></i>
                                    <span class="awea-btn-label"><?php echo esc_html__( 'View Cart', 'awesome-widgets-elementor' ); ?></span>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>

        <script>
        jQuery(function($){
            $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button){
                $button.closest('.awea-card').addClass('product-in-cart');
            });
        });
        </script>
        <?php
    }
}