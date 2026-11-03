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
                'selectors' => [ '{{WRAPPER}} .awea-pricing-card' => 'background-color: {{VALUE}};' ] 
            ] 
        );

        $this->add_responsive_control( 'awea_price_style_card_radius', 
            [
                'label' => 'Border Radius', 
                'type' => Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .awea-pricing-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ]
            ]
        );

        $this->add_group_control( Group_Control_Border::get_type(), 
            [ 
                'name' => 'awea_price_style_card_border', 'selector' => '{{WRAPPER}} .awea-pricing-card' 
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
                'selectors' => [ '{{WRAPPER}} .awea-pricing-plan-tag' => 'color: {{VALUE}};' ] 
            ] 
        );

        $this->add_control( 'awea_price_header_cbg', 
            [ 
                'label' => 'Background', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .awea-pricing-plan-tag' => 'background-color: {{VALUE}};' ] 
            ] 
        );

        $this->add_group_control( Group_Control_Typography::get_type(), 
            [ 
                'name' => 'awea_price_header_typo', 
                'selector' => '{{WRAPPER}} .awea-pricing-plan-tag' 
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

        $this->add_control(
			'awea_price_symbol_options',
			[
				'label' => esc_html__( 'Symbol', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
       
        $this->add_control( 'awea_price_symbol_color', 
        [ 
            'label' => 'Color', 
            'type' => Controls_Manager::COLOR, 
            'selectors' => [ '{{WRAPPER}} .awea-pricing-currency' => 'color: {{VALUE}};' ] 
            ] 
        );

        $this->add_control(
			'awea_price_options',
			[
				'label' => esc_html__( 'Price', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control( 'awea_price_color', 
        [ 
            'label' => 'Color', 
            'type' => Controls_Manager::COLOR, 
            'selectors' => [ '{{WRAPPER}} .awea-pricing-amount' => 'color: {{VALUE}};' ] 
            ] 
        );

        $this->add_group_control( Group_Control_Typography::get_type(), 
            [ 
                'name' => 'awea_price_typo', 
                'selector' => '{{WRAPPER}} .awea-pricing-amount' 
            ] 
        );

        $this->add_control(
			'awea_price_period_options',
			[
				'label' => esc_html__( 'Period', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control( 'awea_price_period_color', 
        [ 
            'label' => 'Color', 
            'type' => Controls_Manager::COLOR, 
            'selectors' => [ '{{WRAPPER}} .awea-pricing-cycle' => 'color: {{VALUE}};' ] 
            ] 
        );

        $this->end_controls_section();

        // --- 4. FEATURES STYLE ---
        $this->start_controls_section(
            'awea_price_features_list',
            [
                'label' => __( 'Features', 'awesome-widgets-elementor' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_price_features_icon_color',
            [
                'label'     => __( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-feature-item i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_price_features_text_color',
            [
                'label'     => __( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .awea-pricing-feature-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_price_features_text_typo',
                'selector' => '{{WRAPPER}} .awea-pricing-feature-item',
            ]
        );

        $this->end_controls_section();

        // --- 5. BUTTON STYLE ---
        $this->start_controls_section(
            'awea_price_button_style',
            [
                'label' => __( 'Button', 'awesome-widgets-elementor' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'btn_tabs' );

        // Normal Tab
        $this->start_controls_tab( 'awea_price_btn_normal', 
            [ 
                'label' => __( 'Normal', 'awesome-widgets-elementor' ) 
            ] 
        );

        $this->add_control(
            'awea_price_btn_normal_color',
            [
                'label'     => __( 'Color', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-pricing-btn-cta' => 'color: {{VALUE}};' ],
            ]
        );
            
        $this->add_control(
            'awea_price_btn_normal_bg',
            [
                'label'     => __( 'Background', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-pricing-btn-cta' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name'     => 'awea_price_btn_normal_typo',
            'selector' => '{{WRAPPER}} .awea-pricing-btn-cta',
        ]
        );

        $this->add_control(
            'awea_price_btn_normal_padding',
            [
                'label'      => __( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-pricing-btn-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_price_btn_normal_radius',
            [
                'label'      => __( 'Border Radius', 'awesome-widgets-elementor' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-pricing-btn-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'awea_price_btn_hover_style', 
            [ 
                'label' => __( 'Hover', 'awesome-widgets-elementor' ) 
            ] 
        );
            
        $this->add_control(
            'awea_price_btn_hover_color',
            [
                'label'     => __( 'Color', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-pricing-btn-cta:hover' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_price_btn_hover_bg',
            [
                'label'     => __( 'Background', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-pricing-btn-cta:hover' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


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