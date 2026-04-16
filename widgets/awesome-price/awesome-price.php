<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Awesome_Price extends Widget_Base {

    public function get_name() { 
        return 'awesome-price'; 
    }
    public function get_title() { 
        return esc_html__( 'Price', 'awesome-widgets-elementor' ); 
    }
    public function get_icon() { 
        return 'eicon-price-table'; 
    }
    public function get_categories() { 
        return [ 'awesome-widgets-elementor' ]; 
    }

    protected function register_controls() {

        $this->start_controls_section(
            'awea_price_head_content',
            [ 'label' => esc_html__( 'Header', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_price_head_label',
            [
                'label' => 'Title',
                'type' => Controls_Manager::TEXT,
                'default' => 'Evolution',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'awea_price_pricing_content',
                [   
                    'label' => esc_html__( 'Pricing', 'awesome-widgets-elementor' ) 
            ]
        );

        $this->add_control( 'awea_price_pricing_currency', 
            [ 
                'label' => 'Currency', 
                'type' => Controls_Manager::TEXT, 
                'default' => '$' 
            ] 
        );

        $this->add_control( 'awea_price_pricing_price', 
            [ 
                'label' => 'Price', 
                'type' => Controls_Manager::TEXT, 
                'default' => '79' 
            ]
        );

        $this->add_control( 'awea_price_pricing_period', 
            [ 
                'label' => 'Period', 
                'type' => Controls_Manager::TEXT, 
                'default' => '/mo' 
            ] 
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'awea_price_features_content',
            [ 
                'label' => esc_html__( 'Features List', 'awesome-widgets-elementor' ) 
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control( 'awea_price_feature_text', 
            [ 
                'label' => 'Feature', 
                'type' => Controls_Manager::TEXT, 
                'default' => 'Unlimited Projects', 
                'label_block' => true 
            ] 
        );

        $repeater->add_control( 'awea_price_feature_icon', 
            [ 
                'label' => 'Icon', 
                'type' => Controls_Manager::ICONS, 
                'default' => [ 'value' => 'fas fa-check', 
                'library' => 'solid' ] 
            ] 
        );
        
        $this->add_control(
            'awea_price_features',
            [
                'label' => 'Features',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [ 'awea_price_feature_text' => 'Unlimited Neural Projects' ],
                    [ 'awea_price_feature_text' => 'Ultra-Low Latency API' ],
                    [ 'awea_price_feature_text' => 'Dedicated Support' ],
                ],
                'title_field' => '{{{ awea_price_feature_text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'awea_price_content_button',
            [ 
                'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ) 
            ]
        );

        $this->add_control( 'awea_price_btn_text', 
            [ 
                'label' => 'Button Text', 
                'type' => Controls_Manager::TEXT, 
                'default' => 'Get Started' 
            ] 
        );

        $this->add_control( 'awea_price_btn_link', 
            [ 
                'label' => 'Link', 
                'type' => Controls_Manager::URL, 'default' => [ 'url' => '#' ] 
            ] 
        );

        $this->end_controls_section();

        // --- 1. CARD CONTAINER STYLE ---
        $this->start_controls_section( 'awea_price_style_card',     
            [ 
                'label' => 'Layout', 
                'tab' => Controls_Manager::TAB_STYLE 
            ] 
        );

        $this->add_control( 'awea_price_style_card_bg', 
            [ 
                'label' => 'Background', 
                'type' => Controls_Manager::COLOR, '
                separator' => 'before', 
                'selectors' => [ '{{WRAPPER}} .desc' => 'color: {{VALUE}};' ] 
            ] 
        );

        $this->add_responsive_control( 'awea_price_style_card_padding', 
            [
                'label' => 'Padding', 
                'type' => Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .quantum-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ]
            ]
        );

        $this->add_responsive_control( 'awea_price_style_card_radius', 
            [
                'label' => 'Border Radius', 
                'type' => Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .quantum-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ]
            ]
        );

        $this->add_group_control( Group_Control_Border::get_type(), 
            [ 
                'name' => 'awea_price_style_card_border', 'selector' => '{{WRAPPER}} .quantum-card' 
            ] 
        );

        $this->end_controls_section();

        // --- 2. HEADER TYPOGRAPHY ---
        $this->start_controls_section( 'awea_price_header_typo', 
            [ 
                'label' => 'Header', 
                'tab' => Controls_Manager::TAB_STYLE 
            ] 
        );

        $this->add_control( 'awea_price_header_color', 
            [ 
                'label' => 'Color', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .tier-label' => 'color: {{VALUE}};' ] 
            ] 
        );

        $this->add_control( 'awea_price_header_cbg', 
            [ 
                'label' => 'Background', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .tier-label' => 'color: {{VALUE}};' ] 
            ] 
        );

        $this->add_group_control( Group_Control_Typography::get_type(), 
            [ 
                'name' => 'awea_price_header_typo', 
                'selector' => '{{WRAPPER}} .desc' 
            ] 
        );

        $this->end_controls_section();

        // --- 3. PRICE TYPOGRAPHY ---
        $this->start_controls_section( 'awea_price_optons', 
            [ 
                'label' => 'Pricing', 
                'tab' => Controls_Manager::TAB_STYLE 
            ] 
        );

        $this->add_control( 'awea_price_bg', 
            [ 
                'label' => 'Background', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .price-wrap h2' => 'background-color: {{VALUE}};' ] 
            ] 
        );

        $this->add_control(
			'more_options',
			[
				'label' => esc_html__( 'Additional Options', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'p_t', 'selector' => '{{WRAPPER}} .price-wrap h2' ] );

        $this->add_control(
			'more_options',
			[
				'label' => esc_html__( 'Additional Options', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control( 'curr_color', [ 'label' => 'Currency Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .price-wrap span' => 'color: {{VALUE}};' ] ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'curr_t', 'selector' => '{{WRAPPER}} .price-wrap span' ] );

        $this->add_control(
			'more_options',
			[
				'label' => esc_html__( 'Additional Options', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

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
        $awea_price_head_label = $settings['awea_price_head_label'];
        $awea_price_pricing_currency = $settings['awea_price_pricing_currency'];
        $awea_price_pricing_price = $settings['awea_price_pricing_price'];
        $awea_price_pricing_period = $settings['awea_price_pricing_period'];
        $awea_price_features = $settings['awea_price_features'];
        $awea_price_btn_text = $settings['awea_price_btn_text'];
        $awea_price_btn_link = $settings['awea_price_btn_link']['url'];
        ?>

         <div class="awea-pricing-card">
            <div class="awea-pricing-card-header">
                <span class="awea-pricing-plan-tag"><?php echo esc_html($awea_price_head_label);?></span>
                <div class="awea-pricing-price-box">
                    <span class="awea-pricing-currency"><?php echo esc_html($awea_price_pricing_currency);?></span>
                    <span class="awea-pricing-amount"><?php echo esc_html($awea_price_pricing_price);?></span>
                    <span class="awea-pricing-cycle">/<?php echo esc_html($awea_price_pricing_period);?></span>
                </div>
            </div>
        <div class="awea-pricing-card-body">
            <ul class="awea-pricing-feature-list">
                <?php 
                    foreach($awea_price_features as $feature) {
                        ?>
                            <li class="awea-pricing-feature-item"><i class="<?php echo esc_attr($feature['awea_price_feature_icon']['value']);?>"></i> <?php echo esc_html($feature['awea_price_feature_text']);?></li>
                        <?php
                    }
                ?>
            </ul>
            <a href="<?php echo esc_attr($awea_price_btn_link);?>" class="awea-pricing-btn-cta"><?php echo esc_html($awea_price_btn_text);?></a>
        </div>
    </div>
        <?php
    }
}