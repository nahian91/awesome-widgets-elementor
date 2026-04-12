<?php
/**
 * Quantum Price Pro - The Ultra Premium Edition
 * Features: Advanced Alignment, Typography, Glassmorphism, and Pro Hover States.
 */
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Awesome_Price extends Widget_Base {

    public function get_name() { return 'awesome-price-pro'; }
    public function get_title() { return esc_html__( 'Price', 'awesome-widgets-elementor' ); }
    public function get_icon() { return 'eicon-price-table'; }
    public function get_categories() { return [ 'awesome-widgets-elementor' ]; }

    protected function register_controls() {

        // ==========================================
        //               CONTENT TAB
        // ==========================================

        $this->start_controls_section(
            'section_content_main',
            [ 'label' => esc_html__( 'Header & Layout', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'is_featured',
            [
                'label' => esc_html__( 'Featured/Popular Plan?', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'featured',
                'default' => '',
            ]
        );

        $this->add_control(
            'badge_text',
            [
                'label' => 'Badge Ribbon Text',
                'type' => Controls_Manager::TEXT,
                'default' => 'MOST POPULAR',
                'condition' => [ 'is_featured' => 'featured' ],
            ]
        );

        $this->add_control(
            'tier_label',
            [
                'label' => 'Tier Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Evolution',
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => 'Description Text',
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Engineered for professionals requiring high-velocity automation.',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_pricing',
            [ 'label' => esc_html__( 'Pricing Details', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control( 'currency', [ 'label' => 'Currency', 'type' => Controls_Manager::TEXT, 'default' => '$' ] );
        $this->add_control( 'price', [ 'label' => 'Price', 'type' => Controls_Manager::TEXT, 'default' => '79' ] );
        $this->add_control( 'period', [ 'label' => 'Period', 'type' => Controls_Manager::TEXT, 'default' => '/mo' ] );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_features',
            [ 'label' => esc_html__( 'Features List', 'awesome-widgets-elementor' ) ]
        );

        $repeater = new Repeater();
        $repeater->add_control( 'feature_text', [ 'label' => 'Feature', 'type' => Controls_Manager::TEXT, 'default' => 'Unlimited Projects', 'label_block' => true ] );
        $repeater->add_control( 'feature_icon', [ 'label' => 'Icon', 'type' => Controls_Manager::ICONS, 'default' => [ 'value' => 'fas fa-check', 'library' => 'solid' ] ] );
        
        $this->add_control(
            'features',
            [
                'label' => 'Features',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [ 'feature_text' => 'Unlimited Neural Projects' ],
                    [ 'feature_text' => 'Ultra-Low Latency API' ],
                    [ 'feature_text' => 'Dedicated Support' ],
                ],
                'title_field' => '{{{ feature_text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_button',
            [ 'label' => esc_html__( 'Action Button', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control( 'btn_text', [ 'label' => 'Button Text', 'type' => Controls_Manager::TEXT, 'default' => 'Get Started' ] );
        $this->add_control( 'btn_link', [ 'label' => 'Link', 'type' => Controls_Manager::URL, 'default' => [ 'url' => '#' ] ] );

        $this->end_controls_section();

        // ==========================================
        //                STYLE TAB
        // ==========================================

        // --- 1. CARD CONTAINER STYLE ---
        $this->start_controls_section( 'style_card', [ 'label' => 'Card Container', 'tab' => Controls_Manager::TAB_STYLE ] );

        $this->add_responsive_control( 'card_align', [
            'label' => 'Global Alignment',
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left'   => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ 
                '{{WRAPPER}} .quantum-card' => 'text-align: {{VALUE}};',
                '{{WRAPPER}} .price-wrap' => 'justify-content: {{VALUE}} === "center" ? "center" : ({{VALUE}} === "right" ? "flex-end" : "flex-start");',
                '{{WRAPPER}} .feature-item' => 'justify-content: {{VALUE}} === "center" ? "center" : ({{VALUE}} === "right" ? "flex-end" : "flex-start");',
            ],
        ]);

        $this->add_control( 'accent_color', [
            'label' => 'Primary Accent Color', 'type' => Controls_Manager::COLOR, 'default' => '#6366f1',
            'selectors' => [ '{{WRAPPER}}' => '--primary: {{VALUE}}; --primary-glow: {{VALUE}}66;' ]
        ]);

        $this->add_group_control( Group_Control_Background::get_type(), [ 'name' => 'card_bg', 'selector' => '{{WRAPPER}} .quantum-card' ] );

        $this->add_control( 'blur_intensity', [
            'label' => 'Glass Blur', 'type' => Controls_Manager::SLIDER, 'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
            'selectors' => [ '{{WRAPPER}} .quantum-card' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);' ]
        ]);

        $this->add_responsive_control( 'card_padding', [
            'label' => 'Padding', 'type' => Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .quantum-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ]
        ]);

        $this->add_responsive_control( 'card_radius', [
            'label' => 'Border Radius', 'type' => Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .quantum-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ]
        ]);

        $this->add_group_control( Group_Control_Border::get_type(), [ 'name' => 'card_border', 'selector' => '{{WRAPPER}} .quantum-card' ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [ 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .quantum-card' ] );

        $this->end_controls_section();

        // --- 2. HEADER TYPOGRAPHY ---
        $this->start_controls_section( 'style_header_typo', [ 'label' => 'Header Typography', 'tab' => Controls_Manager::TAB_STYLE ] );

        $this->add_control( 'label_color', [ 'label' => 'Tier Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .tier-label' => 'color: {{VALUE}};' ] ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'label_t', 'selector' => '{{WRAPPER}} .tier-label' ] );
        $this->add_responsive_control( 'label_spacing', [ 'label' => 'Spacing', 'type' => Controls_Manager::SLIDER, 'selectors' => [ '{{WRAPPER}} .tier-label' => 'margin-bottom: {{SIZE}}{{UNIT}};' ] ] );

        $this->add_control( 'desc_color', [ 'label' => 'Description Color', 'type' => Controls_Manager::COLOR, 'separator' => 'before', 'selectors' => [ '{{WRAPPER}} .desc' => 'color: {{VALUE}};' ] ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'desc_t', 'selector' => '{{WRAPPER}} .desc' ] );

        $this->end_controls_section();

        // --- 3. PRICE TYPOGRAPHY ---
        $this->start_controls_section( 'style_price_typo', [ 'label' => 'Pricing Typography', 'tab' => Controls_Manager::TAB_STYLE ] );

        $this->add_control( 'p_color', [ 'label' => 'Price Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .price-wrap h2' => 'color: {{VALUE}};' ] ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'p_t', 'selector' => '{{WRAPPER}} .price-wrap h2' ] );
        
        $this->add_control( 'curr_color', [ 'label' => 'Currency Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .price-wrap span' => 'color: {{VALUE}};' ] ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'curr_t', 'selector' => '{{WRAPPER}} .price-wrap span' ] );

        $this->end_controls_section();

        // --- 4. FEATURES STYLE ---
        $this->start_controls_section( 'style_features_list', [ 'label' => 'Features Styling', 'tab' => Controls_Manager::TAB_STYLE ] );

        $this->add_control( 'f_icon_color', [ 'label' => 'Icon Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .icon-box i' => 'color: {{VALUE}};' ] ] );
        $this->add_control( 'f_icon_bg', [ 'label' => 'Icon BG', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .icon-box' => 'background: {{VALUE}};' ] ] );
        
        $this->add_control( 'f_text_color', [ 'label' => 'Text Color', 'type' => Controls_Manager::COLOR, 'separator' => 'before', 'selectors' => [ '{{WRAPPER}} .feature-item' => 'color: {{VALUE}};' ] ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'f_text_t', 'selector' => '{{WRAPPER}} .feature-item' ] );
        $this->add_responsive_control( 'f_item_spacing', [ 'label' => 'Spacing', 'type' => Controls_Manager::SLIDER, 'selectors' => [ '{{WRAPPER}} .feature-item' => 'margin-bottom: {{SIZE}}{{UNIT}};' ] ] );

        $this->end_controls_section();

        // --- 5. BUTTON STYLE ---
        $this->start_controls_section( 'style_button_pro', [ 'label' => 'Button Style', 'tab' => Controls_Manager::TAB_STYLE ] );

        $this->add_responsive_control( 'btn_align', [
            'label' => 'Alignment',
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
                'right' => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
                'justify' => [ 'title' => 'Full Width', 'icon' => 'eicon-text-align-justify' ],
            ],
            'selectors' => [ 
                '{{WRAPPER}} .btn-container' => 'text-align: {{VALUE}};',
                '{{WRAPPER}} .action-btn' => 'display: {{VALUE}} === "justify" ? "block" : "inline-block"; width: {{VALUE}} === "justify" ? "100%" : "auto";',
            ],
        ]);

        $this->start_controls_tabs( 'btn_tabs' );
        $this->start_controls_tab( 'btn_n', [ 'label' => 'Normal' ] );
        $this->add_control( 'btn_bg_n', [ 'label' => 'Background', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .action-btn' => 'background: {{VALUE}};' ] ] );
        $this->add_control( 'btn_c_n', [ 'label' => 'Text Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .action-btn' => 'color: {{VALUE}};' ] ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'btn_h', [ 'label' => 'Hover' ] );
        $this->add_control( 'btn_bg_h', [ 'label' => 'Background Hover', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .action-btn:hover' => 'background: {{VALUE}};' ] ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'btn_t', 'selector' => '{{WRAPPER}} .action-btn' ] );
        $this->add_responsive_control( 'btn_p', [ 'label' => 'Padding', 'type' => Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .action-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] ] );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_link_attributes( 'button', $settings['btn_link'] );
        ?>

        <style>
            {{WRAPPER}} .quantum-card {
                --primary: #6366f1; --primary-glow: rgba(99, 102, 241, 0.4);
                background: rgba(17, 24, 39, 0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 32px; padding: 48px;
                position: relative; transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
                display: flex; flex-direction: column; overflow: hidden; color: #fff;
            }
            {{WRAPPER}} .quantum-card:hover { transform: translateY(-15px); border-color: var(--primary); }
            {{WRAPPER}} .tier-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; color: var(--primary); margin-bottom: 12px; display: block; }
            {{WRAPPER}} .price-wrap { display: flex; align-items: baseline; gap: 8px; margin-bottom: 24px; }
            {{WRAPPER}} .price-wrap h2 { font-size: 3.5rem; font-weight: 800; letter-spacing: -2px; margin: 0; color: #fff; }
            {{WRAPPER}} .desc { color: #94a3b8; font-size: 0.95rem; line-height: 1.6; margin-bottom: 32px; }
            {{WRAPPER}} .feature-list { list-style: none; margin: 0 0 40px 0; padding: 0; flex-grow: 1; }
            {{WRAPPER}} .feature-item { display: flex; align-items: center; gap: 14px; margin-bottom: 18px; }
            {{WRAPPER}} .icon-box { width: 24px; height: 24px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
            {{WRAPPER}} .action-btn { padding: 18px 30px; border-radius: 16px; font-weight: 700; text-decoration: none; transition: 0.3s; background: rgba(255, 255, 255, 0.05); color: #fff; border: 1px solid rgba(255, 255, 255, 0.1); }
            {{WRAPPER}} .quantum-card.featured { border: 1px solid rgba(99, 102, 241, 0.3); background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.15), rgba(17, 24, 39, 0.7)); }
            {{WRAPPER}} .featured .action-btn { background: var(--primary); box-shadow: 0 10px 20px -5px var(--primary-glow); border: none; }
            {{WRAPPER}} .best-value { position: absolute; top: 24px; right: -35px; background: var(--primary); padding: 8px 40px; font-size: 0.65rem; font-weight: 900; transform: rotate(45deg); box-shadow: 0 5px 15px rgba(0,0,0,0.3); z-index: 10; }
        </style>

        <div class="quantum-card <?php echo esc_attr($settings['is_featured']); ?>">
            <?php if ( 'featured' === $settings['is_featured'] ) : ?>
                <div class="best-value"><?php echo esc_html($settings['badge_text']); ?></div>
            <?php endif; ?>

            <span class="tier-label"><?php echo esc_html($settings['tier_label']); ?></span>
            
            <div class="price-wrap">
                <h2><?php echo esc_html($settings['currency'] . $settings['price']); ?></h2>
                <span><?php echo esc_html($settings['period']); ?></span>
            </div>

            <p class="desc"><?php echo esc_html($settings['description']); ?></p>

            <ul class="feature-list">
                <?php foreach ( $settings['features'] as $item ) : ?>
                    <li class="feature-item">
                        <div class="icon-box">
                            <?php Icons_Manager::render_icon( $item['feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </div>
                        <?php echo esc_html($item['feature_text']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="btn-container">
                <a <?php echo wp_kses_post( $this->get_render_attribute_string( 'button' ) ); ?> class="action-btn">
                    <?php echo esc_html( $settings['btn_text'] ); ?>
                </a>
            </div>
        </div>
        <?php
    }
}