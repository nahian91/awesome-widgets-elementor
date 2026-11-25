<?php
/**
 * Awesome Testimonials Widget.
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
use Elementor\Utils;

class Widget_Awesome_Testimonials extends Widget_Base {

	public function get_name() {
		return 'awesome-testimonials';
	}

	public function get_title() {
		return esc_html__( 'Testimonials', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'testimonial', 'reviews', 'grid', 'rating', 'feedback', 'quote', 'social proof' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. REVIEWS (REPEATER)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ts_section_items',
			[
				'label' => esc_html__( 'Reviews', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_ts_item_tabs' );

		// --- TAB 1: REVIEW TEXT ---
		$repeater->start_controls_tab(
			'awea_ts_tab_review',
			[ 'label' => esc_html__( 'Review Text', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_ts_rating',
			[
				'label'   => esc_html__( 'Star Rating', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '5',
				'options' => [
					'0' => esc_html__( 'Hide Stars', 'awesome-widgets-elementor' ),
					'1' => '1 ★',
					'2' => '2 ★★',
					'3' => '3 ★★★',
					'4' => '4 ★★★★',
					'5' => '5 ★★★★★',
				],
			]
		);

		$repeater->add_control(
			'awea_ts_headline',
			[
				'label'       => esc_html__( 'Short Headline (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Transformed our workflow in 48 hours', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_ts_quote',
			[
				'label'       => esc_html__( 'Review Quote', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'The architectural clarity and speed of this system are world-class. It transformed our client delivery pipeline within 48 hours.', 'awesome-widgets-elementor' ),
				'placeholder' => esc_html__( 'Write customer review...', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: CUSTOMER INFO ---
		$repeater->start_controls_tab(
			'awea_ts_tab_author',
			[ 'label' => esc_html__( 'Customer Info', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_ts_photo',
			[
				'label'   => esc_html__( 'Customer Photo', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_ts_name',
			[
				'label'       => esc_html__( 'Customer Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Julian Vance', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_ts_role',
			[
				'label'       => esc_html__( 'Job Title / Company', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Design Director at Linear', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_ts_verified',
			[
				'label'        => esc_html__( 'Show Verified Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: COLORS ---
		$repeater->start_controls_tab(
			'awea_ts_tab_highlight',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_ts_item_featured',
			[
				'label'        => esc_html__( 'Highlight This Review', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_ts_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-ts-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_ts_item_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_ts_item_border',
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
			'awea_ts_items',
			[
				'label'       => esc_html__( 'Reviews List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_ts_name }}} — {{{ awea_ts_role }}}',
				'default'     => [
					[
						'awea_ts_rating'   => '5',
						'awea_ts_quote'    => esc_html__( 'The architectural clarity and speed of this system are world-class. It transformed our client delivery pipeline within 48 hours.', 'awesome-widgets-elementor' ),
						'awea_ts_name'     => esc_html__( 'Julian Vance', 'awesome-widgets-elementor' ),
						'awea_ts_role'     => esc_html__( 'Design Director at Linear', 'awesome-widgets-elementor' ),
						'awea_ts_verified' => 'yes',
					],
					[
						'awea_ts_rating'        => '5',
						'awea_ts_quote'         => esc_html__( 'Clean, shadow-free aesthetics with zero CSS bloat. Our engineering team shipped an entire redesign two weeks ahead of schedule.', 'awesome-widgets-elementor' ),
						'awea_ts_name'          => esc_html__( 'Elena Rostova', 'awesome-widgets-elementor' ),
						'awea_ts_role'          => esc_html__( 'VP of Product at Vercel', 'awesome-widgets-elementor' ),
						'awea_ts_verified'      => 'yes',
						'awea_ts_item_featured' => 'yes',
					],
					[
						'awea_ts_rating'   => '5',
						'awea_ts_quote'    => esc_html__( 'Every detail feels intentional—from typography scale to responsive spacing. Hands down the best component suite we have adopted.', 'awesome-widgets-elementor' ),
						'awea_ts_name'     => esc_html__( 'Marcus Thorne', 'awesome-widgets-elementor' ),
						'awea_ts_role'     => esc_html__( 'Founder at Studio Mono', 'awesome-widgets-elementor' ),
						'awea_ts_verified' => 'yes',
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID & EFFECTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ts_section_layout',
			[
				'label' => esc_html__( 'Grid & Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_ts_columns',
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
					'{{WRAPPER}} .awea-ts-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ts_col_gap',
			[
				'label'      => esc_html__( 'Space Between Columns', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ts-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ts_row_gap',
			[
				'label'      => esc_html__( 'Space Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ts-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ts_quote_icon',
			[
				'label'        => esc_html__( 'Show Quote Icon', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_ts_hover_motion',
			[
				'label'        => esc_html__( 'Card Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-ts-motion-',
			]
		);

		$this->add_control(
			'awea_ts_beam_enable',
			[
				'label'        => esc_html__( 'Animated Border Glow', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea-ts-beam-',
			]
		);

		$this->add_control(
			'awea_ts_name_tag',
			[
				'label'   => esc_html__( 'Name Heading Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ts_style_card',
			[
				'label' => esc_html__( 'Card Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_ts_card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '32',
					'right'    => '30',
					'bottom'   => '32',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-ts-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ts_card_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-ts-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ts_beam_color',
			[
				'label'     => esc_html__( 'Border Glow Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_ts_beam_enable' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-ts-card' => '--awea-ts-beam: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_ts_card_tabs' );

		$this->start_controls_tab(
			'awea_ts_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_ts_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-ts-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_ts_card_border',
				'selector'       => '{{WRAPPER}} .awea-ts-card',
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
				'name'     => 'awea_ts_card_shadow',
				'selector' => '{{WRAPPER}} .awea-ts-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ts_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_ts_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-ts-card:hover',
			]
		);

		$this->add_control(
			'awea_ts_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-ts-card:hover' => 'border-color: var(--awea-ts-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_ts_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-ts-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. STARS & QUOTE ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ts_style_stars',
			[
				'label' => esc_html__( 'Stars & Quote Icon', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_ts_star_size',
			[
				'label'      => esc_html__( 'Star Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ts-stars i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ts_star_color',
			[
				'label'     => esc_html__( 'Filled Star Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f59e0b',
				'selectors' => [
					'{{WRAPPER}} .awea-ts-stars .awea-star-on' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ts_star_empty',
			[
				'label'     => esc_html__( 'Empty Star Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-ts-stars .awea-star-off' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ts_quote_color',
			[
				'label'     => esc_html__( 'Quote Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_ts_quote_icon' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-ts-quote-mark' => 'color: var(--awea-ts-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. REVIEW QUOTE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ts_style_quote',
			[
				'label' => esc_html__( 'Review Quote', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_ts_headline_color',
			[
				'label'     => esc_html__( 'Headline Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-ts-headline' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ts_headline_typo',
				'label'    => esc_html__( 'Headline Font', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-ts-headline',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_control(
			'awea_ts_quote_color_text',
			[
				'label'     => esc_html__( 'Quote Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-ts-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ts_quote_typo',
				'label'    => esc_html__( 'Quote Font', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-ts-text',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_ts_quote_space',
			[
				'label'      => esc_html__( 'Space Below Quote', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ts-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. CUSTOMER DETAILS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ts_style_author',
			[
				'label' => esc_html__( 'Customer Details', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_ts_line_color',
			[
				'label'     => esc_html__( 'Divider Line Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-ts-footer' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ts_avatar_size',
			[
				'label'      => esc_html__( 'Photo Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 84 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 48 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-ts-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ts_avatar_radius',
			[
				'label'      => esc_html__( 'Photo Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '100',
					'right'    => '100',
					'bottom'   => '100',
					'left'     => '100',
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-ts-avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ts_name_color',
			[
				'label'     => esc_html__( 'Customer Name Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-ts-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ts_name_typo',
				'selector' => '{{WRAPPER}} .awea-ts-name',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_ts_name_shadow',
				'selector' => '{{WRAPPER}} .awea-ts-name',
			]
		);

		$this->add_control(
			'awea_ts_role_color',
			[
				'label'     => esc_html__( 'Job Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-ts-role' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ts_role_typo',
				'selector' => '{{WRAPPER}} .awea-ts-role',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$items     = $settings['awea_ts_items'] ?? [];
		$has_quote = 'yes' === ( $settings['awea_ts_quote_icon'] ?? 'no' );
		$name_tag  = Utils::validate_html_tag( $settings['awea_ts_name_tag'] ?? 'h4' );

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea-ts-grid">
			<?php foreach ( $items as $index => $item ) :
				$id         = $item['_id'] ?? $index;
				$rating     = absint( $item['awea_ts_rating'] ?? 5 );
				$headline   = $item['awea_ts_headline'] ?? '';
				$quote      = $item['awea_ts_quote'] ?? '';
				$avatar_url = $item['awea_ts_photo']['url'] ?? '';
				$name       = $item['awea_ts_name'] ?? '';
				$role       = $item['awea_ts_role'] ?? '';
				$verified   = 'yes' === ( $item['awea_ts_verified'] ?? 'no' );
				$featured   = 'yes' === ( $item['awea_ts_item_featured'] ?? '' );

				$headline_key = $this->get_repeater_setting_key( 'awea_ts_headline', 'awea_ts_items', $index );
				$quote_key    = $this->get_repeater_setting_key( 'awea_ts_quote', 'awea_ts_items', $index );
				$name_key     = $this->get_repeater_setting_key( 'awea_ts_name', 'awea_ts_items', $index );
				$role_key     = $this->get_repeater_setting_key( 'awea_ts_role', 'awea_ts_items', $index );

				$this->add_inline_editing_attributes( $headline_key, 'none' );
				$this->add_inline_editing_attributes( $quote_key, 'basic' );
				$this->add_inline_editing_attributes( $name_key, 'none' );
				$this->add_inline_editing_attributes( $role_key, 'none' );

				$this->add_render_attribute( $headline_key, 'class', 'awea-ts-headline' );
				$this->add_render_attribute( $quote_key, 'class', 'awea-ts-text' );
				$this->add_render_attribute( $name_key, 'class', 'awea-ts-name' );
				$this->add_render_attribute( $role_key, 'class', 'awea-ts-role' );

				$card_classes = [
					'awea-ts-card',
					'elementor-repeater-item-' . esc_attr( $id ),
				];
				if ( $featured ) {
					$card_classes[] = 'awea-ts-featured';
				}
				?>
				<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

					<?php if ( $has_quote ) : ?>
						<svg class="awea-ts-quote-mark" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
							<path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C15.4647 8 15.017 8.44772 15.017 9V12C15.017 12.5523 14.5693 13 14.017 13H13.017C12.4647 13 12.017 12.5523 12.017 12V9C12.017 6.79086 13.8079 5 16.017 5H19.017C21.2261 5 23.017 6.79086 23.017 9V15C23.017 18.866 19.883 22 16.017 22H14.017V21ZM2.01693 21L2.01693 18C2.01693 16.8954 2.91236 16 4.01693 16H7.01693C7.56921 16 8.01693 15.5523 8.01693 15V9C8.01693 8.44772 7.56921 8 7.01693 8H4.01693C3.46464 8 3.01693 8.44772 3.01693 9V12C3.01693 12.5523 2.56921 13 2.01693 13H1.01693C0.464645 13 -0.0169312 12.5523 -0.0169312 12V9C-0.0169312 6.79086 1.77393 5 4.01693 5H7.01693C9.22607 5 11.0169 6.79086 11.0169 9V15C11.0169 18.866 7.88297 22 4.01693 22H2.01693V21Z" />
						</svg>
					<?php endif; ?>

					<?php if ( $rating > 0 ) : ?>
						<?php
						/* translators: %s: rating value out of 5 */
						$rating_label = sprintf( __( 'Rated %s out of 5 stars', 'awesome-widgets-elementor' ), $rating );
						?>
						<div class="awea-ts-stars" aria-label="<?php echo esc_attr( $rating_label ); ?>">
							<?php
							for ( $i = 1; $i <= 5; $i++ ) {
								$star_class = ( $i <= $rating ) ? 'fas fa-star awea-star-on' : 'far fa-star awea-star-off';
								echo '<i class="' . esc_attr( $star_class ) . '" aria-hidden="true"></i>';
							}
							?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $headline ) ) : ?>
						<p <?php $this->print_render_attribute_string( $headline_key ); ?>>
							<?php echo esc_html( $headline ); ?>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $quote ) ) : ?>
						<blockquote <?php $this->print_render_attribute_string( $quote_key ); ?>>
							&ldquo;<?php echo wp_kses_post( $quote ); ?>&rdquo;
						</blockquote>
					<?php endif; ?>

					<footer class="awea-ts-footer">
						<?php if ( ! empty( $avatar_url ) ) : ?>
							<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="awea-ts-avatar" loading="lazy" />
						<?php endif; ?>

						<div class="awea-ts-meta">
							<?php if ( ! empty( $name ) ) : ?>
								<<?php Utils::print_validated_html_tag( $name_tag ); ?> <?php $this->print_render_attribute_string( $name_key ); ?>>
									<?php echo esc_html( $name ); ?>
								</<?php Utils::print_validated_html_tag( $name_tag ); ?>>
							<?php endif; ?>

							<?php if ( ! empty( $role ) ) : ?>
								<cite <?php $this->print_render_attribute_string( $role_key ); ?>>
									<?php echo esc_html( $role ); ?>
								</cite>
							<?php endif; ?>
						</div>

						<?php if ( $verified ) : ?>
							<span class="awea-ts-verify" title="<?php esc_attr_e( 'Verified Customer', 'awesome-widgets-elementor' ); ?>" aria-label="<?php esc_attr_e( 'Verified Customer', 'awesome-widgets-elementor' ); ?>">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
									<polyline points="20 6 9 17 4 12"></polyline>
								</svg>
							</span>
						<?php endif; ?>
					</footer>

				</article>
			<?php endforeach; ?>
		</div>
		<?php
	}
}