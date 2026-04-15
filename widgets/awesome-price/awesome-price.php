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

         <div class="awea-pricing-card">
        <div class="awea-pricing-card-header">
            <span class="awea-pricing-plan-tag">Professional</span>
            <div class="awea-pricing-price-box">
                <span class="awea-pricing-currency">$</span>
                <span class="awea-pricing-amount">299</span>
                <span class="awea-pricing-cycle">/mo</span>
            </div>
        </div>
        <div class="awea-pricing-card-body">
            <ul class="awea-pricing-feature-list">
                <li class="awea-pricing-feature-item"><i class="fas fa-check-circle"></i> Priority manufacturing</li>
                <li class="awea-pricing-feature-item"><i class="fas fa-check-circle"></i> Global logistics support</li>
                <li class="awea-pricing-feature-item"><i class="fas fa-check-circle"></i> Sustainable options</li>
                <li class="awea-pricing-feature-item"><i class="fas fa-check-circle"></i> Dedicated Manager</li>
            </ul>
            <a href="#" class="awea-pricing-btn-cta">Select Pro Plan</a>
        </div>
    </div>
        <?php
    }
}