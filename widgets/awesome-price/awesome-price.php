<?php
/**
 * Awesome Price Table Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.5.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Widget_Awesome_Price extends Widget_Base {

	public function get_name() {
		return 'awesome-price';
	}

	public function get_title() {
		return esc_html__( 'Price Table', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'price', 'pricing', 'table', 'grid', 'plan', 'tier', 'subscription', 'packages' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. PRICING PLANS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pt_section_items',
			[
				'label' => esc_html__( 'Pricing Plans', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_pt_tier_tabs' );

		// --- TAB 1: PLAN INFO ---
		$repeater->start_controls_tab(
			'awea_pt_tab_header',
			[ 'label' => esc_html__( 'Plan Info', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_pt_title',
			[
				'label'       => esc_html__( 'Plan Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Evolution', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_pt_desc',
			[
				'label'       => esc_html__( 'Short Summary', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => esc_html__( 'Everything you need to launch and scale faster.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_pt_featured',
			[
				'label'        => esc_html__( 'Highlight This Plan', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_pt_ribbon',
			[
				'label'     => esc_html__( 'Popular Tag Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Most Popular', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_pt_featured' => 'yes' ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: PRICE ---
		$repeater->start_controls_tab(
			'awea_pt_tab_values',
			[ 'label' => esc_html__( 'Price', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_pt_currency',
			[
				'label'   => esc_html__( 'Currency Symbol', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '$',
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_pt_original_price',
			[
				'label'       => esc_html__( 'Original Price (Strike-through)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => '99',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_pt_price',
			[
				'label'   => esc_html__( 'Current Price', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '79',
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_pt_period',
			[
				'label'   => esc_html__( 'Billing Period', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'mo',
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: FEATURES ---
		$repeater->start_controls_tab(
			'awea_pt_tab_features',
			[ 'label' => esc_html__( 'Features', 'awesome-widgets-elementor' ) ]
		);

		$feature_sub_repeater = new Repeater();

		$feature_sub_repeater->add_control(
			'awea_pt_feat_text',
			[
				'label'       => esc_html__( 'Feature Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Unlimited Projects', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$feature_sub_repeater->add_control(
			'awea_pt_feat_icon',
			[
				'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				],
			]
		);

		$feature_sub_repeater->add_control(
			'awea_pt_feat_active',
			[
				'label'        => esc_html__( 'Included in Plan', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'awea_pt_features_list',
			[
				'label'       => esc_html__( 'Feature Checklist', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $feature_sub_repeater->get_controls(),
				'default'     => [
					[ 'awea_pt_feat_text' => esc_html__( 'Unlimited Neural Projects', 'awesome-widgets-elementor' ), 'awea_pt_feat_active' => 'yes' ],
					[ 'awea_pt_feat_text' => esc_html__( 'Ultra-Low Latency API Access', 'awesome-widgets-elementor' ), 'awea_pt_feat_active' => 'yes' ],
					[ 'awea_pt_feat_text' => esc_html__( 'Real-Time Telemetry Tracking', 'awesome-widgets-elementor' ), 'awea_pt_feat_active' => 'yes' ],
					[ 'awea_pt_feat_text' => esc_html__( '24/7 Dedicated Support Engineering', 'awesome-widgets-elementor' ), 'awea_pt_feat_active' => 'yes' ],
				],
				'title_field' => '{{{ awea_pt_feat_text }}}',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 4: BUTTON ---
		$repeater->start_controls_tab(
			'awea_pt_tab_button',
			[ 'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_pt_btn_text',
			[
				'label'       => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Get Started Now', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_pt_btn_link',
			[
				'label'       => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'default'     => [ 'url' => '#' ],
				'placeholder' => 'https://example.com/checkout',
			]
		);

		$repeater->add_control(
			'awea_pt_btn_icon',
			[
				'label'   => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'awea_pt_btn_icon_pos',
			[
				'label'   => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'  => esc_html__( 'Left', 'awesome-widgets-elementor' ),
					'right' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
				],
			]
		);

		$repeater->add_control(
			'awea_pt_btn_note',
			[
				'label'       => esc_html__( 'Small Note Below Button', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'No credit card required', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 5: COLORS ---
		$repeater->start_controls_tab(
			'awea_pt_tab_highlight',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_pt_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-pt-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_pt_item_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_pt_item_border',
			[
				'label'     => esc_html__( 'Card Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_pt_pricing_tiers',
			[
				'label'       => esc_html__( 'Plans List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_pt_title }}} ({{{ awea_pt_currency }}}{{{ awea_pt_price }}})',
				'default'     => [
					[
						'awea_pt_title'    => esc_html__( 'Starter', 'awesome-widgets-elementor' ),
						'awea_pt_desc'     => esc_html__( 'Essential tools for solo creators and small launches.', 'awesome-widgets-elementor' ),
						'awea_pt_price'    => '29',
						'awea_pt_btn_text' => esc_html__( 'Start Free Trial', 'awesome-widgets-elementor' ),
					],
					[
						'awea_pt_title'          => esc_html__( 'Evolution', 'awesome-widgets-elementor' ),
						'awea_pt_desc'           => esc_html__( 'Complete growth engine for scaling teams and brands.', 'awesome-widgets-elementor' ),
						'awea_pt_original_price' => '99',
						'awea_pt_price'          => '79',
						'awea_pt_featured'       => 'yes',
						'awea_pt_ribbon'         => esc_html__( 'Most Popular', 'awesome-widgets-elementor' ),
						'awea_pt_btn_text'       => esc_html__( 'Get Started Now', 'awesome-widgets-elementor' ),
					],
					[
						'awea_pt_title'    => esc_html__( 'Enterprise', 'awesome-widgets-elementor' ),
						'awea_pt_desc'     => esc_html__( 'Custom infrastructure, SLA guarantees, and priority support.', 'awesome-widgets-elementor' ),
						'awea_pt_price'    => '199',
						'awea_pt_btn_text' => esc_html__( 'Contact Sales', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID & EFFECTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pt_section_layout',
			[
				'label' => esc_html__( 'Grid & Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_pt_columns',
			[
				'label'          => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'selectors'      => [
					'{{WRAPPER}} .awea-pricing-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pt_col_gap',
			[
				'label'      => esc_html__( 'Space Between Columns', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pt_row_gap',
			[
				'label'      => esc_html__( 'Space Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_pt_ribbon_style',
			[
				'label'        => esc_html__( 'Popular Tag Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'ribbon',
				'options'      => [
					'ribbon' => esc_html__( 'Corner Ribbon', 'awesome-widgets-elementor' ),
					'pill'   => esc_html__( 'Top Right Pill', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-pt-rib-',
			]
		);

		$this->add_control(
			'awea_pt_show_divider',
			[
				'label'        => esc_html__( 'Show Divider Below Price', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea-pt-div-',
			]
		);

		$this->add_control(
			'awea_pt_hover_motion',
			[
				'label'        => esc_html__( 'Card Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-pt-motion-',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pt_style_card',
			[
				'label' => esc_html__( 'Card Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_pt_align',
			[
				'label'                => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'              => 'left',
				'selectors_dictionary' => [
					'left'   => 'text-align: left; align-items: flex-start; --awea-pt-price-justify: flex-start;',
					'center' => 'text-align: center; align-items: center; --awea-pt-price-justify: center;',
					'right'  => 'text-align: right; align-items: flex-end; --awea-pt-price-justify: flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-pricing-card' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pt_card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top'      => '40',
					'right'    => '32',
					'bottom'   => '40',
					'left'     => '32',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pt_card_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_pt_card_state_tabs' );

		$this->start_controls_tab(
			'awea_pt_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pt_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-pricing-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_pt_card_border',
				'selector'       => '{{WRAPPER}} .awea-pricing-card',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_pt_card_shadow',
				'selector' => '{{WRAPPER}} .awea-pricing-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_pt_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pt_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-pricing-card:hover',
			]
		);

		$this->add_control(
			'awea_pt_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-card:hover' => 'border-color: var(--awea-pt-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_pt_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-pricing-card:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_pt_card_featured',
			[ 'label' => esc_html__( 'Highlighted', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pt_featured_bg',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-pricing-card.awea-is-featured',
			]
		);

		$this->add_control(
			'awea_pt_featured_border',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-card.awea-is-featured' => 'border-color: var(--awea-pt-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_pt_featured_shadow',
				'selector' => '{{WRAPPER}} .awea-pricing-card.awea-is-featured',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. PLAN HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pt_style_header',
			[
				'label' => esc_html__( 'Plan Header', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_pt_header_color',
			[
				'label'     => esc_html__( 'Plan Name Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-plan-tag' => 'color: var(--awea-pt-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_pt_header_bg',
			[
				'label'     => esc_html__( 'Plan Name Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-plan-tag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pt_header_typo',
				'selector' => '{{WRAPPER}} .awea-pricing-plan-tag',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_pt_desc_color',
			[
				'label'     => esc_html__( 'Summary Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pt_desc_typo',
				'selector' => '{{WRAPPER}} .awea-pricing-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_pt_heading_ribbon_style',
			[
				'label'     => esc_html__( 'Popular Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_pt_ribbon_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-ribbon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pt_ribbon_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-ribbon' => 'background-color: var(--awea-pt-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pt_ribbon_typo',
				'selector' => '{{WRAPPER}} .awea-pricing-ribbon',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. PRICE DISPLAY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pt_style_pricing',
			[
				'label' => esc_html__( 'Price Display', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_pt_currency_color',
			[
				'label'     => esc_html__( 'Currency Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-currency' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pt_orig_price_color',
			[
				'label'     => esc_html__( 'Original Price Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-original' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pt_price_color',
			[
				'label'     => esc_html__( 'Current Price Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-amount' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pt_price_typo',
				'selector' => '{{WRAPPER}} .awea-pricing-amount',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_pt_price_shadow',
				'selector' => '{{WRAPPER}} .awea-pricing-amount',
			]
		);

		$this->add_control(
			'awea_pt_period_color',
			[
				'label'     => esc_html__( 'Period Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-cycle' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pt_period_typo',
				'selector' => '{{WRAPPER}} .awea-pricing-cycle',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. FEATURE LIST
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pt_style_features',
			[
				'label' => esc_html__( 'Feature List', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_pt_feature_icon_color',
			[
				'label'     => esc_html__( 'Checkmark Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-feature-icon'     => 'color: var(--awea-pt-item-accent, {{VALUE}});',
					'{{WRAPPER}} .awea-feature-icon svg' => 'fill: var(--awea-pt-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_pt_feature_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-feature-item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pt_feature_text_typo',
				'selector' => '{{WRAPPER}} .awea-pricing-feature-item',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_pt_feature_spacing',
			[
				'label'      => esc_html__( 'Space Between Items', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 6, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-feature-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. ACTION BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pt_style_button',
			[
				'label' => esc_html__( 'Action Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pt_btn_typo',
				'selector' => '{{WRAPPER}} .awea-pricing-btn-cta',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_pt_btn_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top'      => '16',
					'right'    => '28',
					'bottom'   => '16',
					'left'     => '28',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-btn-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pt_btn_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-pricing-btn-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_pt_btn_state_tabs' );

		$this->start_controls_tab(
			'awea_pt_btn_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_pt_btn_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-btn-cta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pt_btn_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-pricing-btn-cta',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_pt_btn_border',
				'selector' => '{{WRAPPER}} .awea-pricing-btn-cta',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_pt_btn_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_pt_btn_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-btn-cta:hover, {{WRAPPER}} .awea-pricing-btn-cta:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pt_btn_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-pricing-btn-cta:hover, {{WRAPPER}} .awea-pricing-btn-cta:focus-visible',
			]
		);

		$this->add_control(
			'awea_pt_btn_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-btn-cta:hover, {{WRAPPER}} .awea-pricing-btn-cta:focus-visible' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'awea_pt_btn_note_color',
			[
				'label'     => esc_html__( 'Button Note Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-pricing-note' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$tiers    = $settings['awea_pt_pricing_tiers'] ?? [];

		if ( empty( $tiers ) ) {
			return;
		}
		?>
		<div class="awea-pricing-grid">
			<?php foreach ( $tiers as $index => $tier ) :
				$id          = $tier['_id'] ?? $index;
				$title       = $tier['awea_pt_title'] ?? '';
				$desc        = $tier['awea_pt_desc'] ?? '';
				$is_featured = 'yes' === ( $tier['awea_pt_featured'] ?? 'no' );
				$ribbon_text = $tier['awea_pt_ribbon'] ?? '';
				$currency    = $tier['awea_pt_currency'] ?? '$';
				$orig_price  = $tier['awea_pt_original_price'] ?? '';
				$price       = $tier['awea_pt_price'] ?? '';
				$period      = $tier['awea_pt_period'] ?? '';
				$features    = $tier['awea_pt_features_list'] ?? [];
				$btn_text    = $tier['awea_pt_btn_text'] ?? '';
				$btn_pos     = $tier['awea_pt_btn_icon_pos'] ?? 'right';
				$has_btn_ico = ! empty( $tier['awea_pt_btn_icon']['value'] );
				$btn_note    = $tier['awea_pt_btn_note'] ?? '';
				$link_key    = 'awea_pt_link_' . $id;

				$title_setting_key = $this->get_repeater_setting_key( 'awea_pt_title', 'awea_pt_pricing_tiers', $index );
				$desc_setting_key  = $this->get_repeater_setting_key( 'awea_pt_desc', 'awea_pt_pricing_tiers', $index );
				$price_setting_key = $this->get_repeater_setting_key( 'awea_pt_price', 'awea_pt_pricing_tiers', $index );
				$note_setting_key  = $this->get_repeater_setting_key( 'awea_pt_btn_note', 'awea_pt_pricing_tiers', $index );

				$this->add_inline_editing_attributes( $title_setting_key, 'none' );
				$this->add_inline_editing_attributes( $desc_setting_key, 'basic' );
				$this->add_inline_editing_attributes( $price_setting_key, 'none' );
				$this->add_inline_editing_attributes( $note_setting_key, 'none' );

				$this->add_render_attribute( $title_setting_key, 'class', 'awea-pricing-plan-tag' );
				$this->add_render_attribute( $desc_setting_key, 'class', 'awea-pricing-desc' );
				$this->add_render_attribute( $price_setting_key, 'class', 'awea-pricing-amount' );
				$this->add_render_attribute( $note_setting_key, 'class', 'awea-pricing-note' );

				$btn_url = ! empty( $tier['awea_pt_btn_link']['url'] ) ? $tier['awea_pt_btn_link'] : [ 'url' => '#' ];
				$this->add_link_attributes( $link_key, $btn_url );
				$this->add_render_attribute( $link_key, 'class', 'awea-pricing-btn-cta' );

				$card_classes = [ 'awea-pricing-card', 'elementor-repeater-item-' . esc_attr( $id ) ];
				if ( $is_featured ) {
					$card_classes[] = 'awea-is-featured';
				}
				?>
				<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

					<?php if ( $is_featured && ! empty( $ribbon_text ) ) : ?>
						<div class="awea-pricing-ribbon" aria-hidden="true">
							<span><?php echo esc_html( $ribbon_text ); ?></span>
						</div>
					<?php endif; ?>

					<!-- Header & Pricing Block -->
					<div class="awea-pricing-card-header">
						<?php if ( ! empty( $title ) ) : ?>
							<span <?php $this->print_render_attribute_string( $title_setting_key ); ?>>
								<?php echo esc_html( $title ); ?>
							</span>
						<?php endif; ?>

						<div class="awea-pricing-price-box">
							<?php if ( ! empty( $orig_price ) ) : ?>
								<del class="awea-pricing-original"><?php echo esc_html( $currency . $orig_price ); ?></del>
							<?php endif; ?>

							<?php if ( ! empty( $currency ) ) : ?>
								<span class="awea-pricing-currency"><?php echo esc_html( $currency ); ?></span>
							<?php endif; ?>

							<?php if ( ! empty( $price ) ) : ?>
								<span <?php $this->print_render_attribute_string( $price_setting_key ); ?>>
									<?php echo esc_html( $price ); ?>
								</span>
							<?php endif; ?>

							<?php if ( ! empty( $period ) ) : ?>
								<span class="awea-pricing-cycle">/<?php echo esc_html( ltrim( $period, '/' ) ); ?></span>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $desc ) ) : ?>
							<p <?php $this->print_render_attribute_string( $desc_setting_key ); ?>>
								<?php echo wp_kses_post( $desc ); ?>
							</p>
						<?php endif; ?>
					</div>

					<!-- Body Features & CTA -->
					<div class="awea-pricing-card-body">
						<?php if ( ! empty( $features ) ) : ?>
							<ul class="awea-pricing-feature-list" role="list">
								<?php foreach ( $features as $feature ) :
									$f_text   = $feature['awea_pt_feat_text'] ?? '';
									$f_active = 'yes' === ( $feature['awea_pt_feat_active'] ?? 'yes' );
									if ( empty( $f_text ) ) {
										continue;
									}
									?>
									<li class="awea-pricing-feature-item <?php echo $f_active ? '' : 'is-disabled'; ?>">
										<span class="awea-feature-icon" aria-hidden="true">
											<?php
											if ( ! empty( $feature['awea_pt_feat_icon']['value'] ) ) {
												Icons_Manager::render_icon( $feature['awea_pt_feat_icon'], [ 'aria-hidden' => 'true' ] );
											} else {
												echo '<i class="fas fa-check" aria-hidden="true"></i>';
											}
											?>
										</span>
										<span class="awea-feature-text"><?php echo esc_html( $f_text ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if ( ! empty( $btn_text ) ) : ?>
							<div class="awea-pricing-btn-wrap">
								<a <?php $this->print_render_attribute_string( $link_key ); ?>>
									<?php if ( 'left' === $btn_pos && $has_btn_ico ) : ?>
										<span class="awea-pt-btn-ico awea-pt-ico-left" aria-hidden="true">
											<?php Icons_Manager::render_icon( $tier['awea_pt_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

									<span><?php echo esc_html( $btn_text ); ?></span>

									<?php if ( 'right' === $btn_pos && $has_btn_ico ) : ?>
										<span class="awea-pt-btn-ico awea-pt-ico-right" aria-hidden="true">
											<?php Icons_Manager::render_icon( $tier['awea_pt_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>
								</a>

								<?php if ( ! empty( $btn_note ) ) : ?>
									<span <?php $this->print_render_attribute_string( $note_setting_key ); ?>>
										<?php echo esc_html( $btn_note ); ?>
									</span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>

				</article>
			<?php endforeach; ?>
		</div>
		<?php
	}
}