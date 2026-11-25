<?php
/**
 * Awesome Accordion Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.5.0
 */

namespace Elementor;

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Widget_Awesome_Accordion extends Widget_Base {

	public function get_name() {
		return 'awesome-accordion';
	}

	public function get_title() {
		return esc_html__( 'Accordion', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-accordion';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'accordion', 'faq', 'toggle', 'collapse', 'qna', 'answers' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. FAQ & ACCORDION ITEMS (REPEATER)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ac_section_items',
			[
				'label' => esc_html__( 'FAQ & Accordion Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_ac_item_tabs' );

		// --- TAB 1: QUESTION & ANSWER ---
		$repeater->start_controls_tab(
			'awea_ac_tab_content',
			[
				'label' => esc_html__( 'Question & Answer', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->add_control(
			'awea_ac_title',
			[
				'label'       => esc_html__( 'Question Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Where can I find your warranty policy?', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_ac_content',
			[
				'label'   => esc_html__( 'Answer Text', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Our standard commercial warranty covers all manufacturing defects and operational failures for 24 months from the purchase date.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: OPEN SETTINGS ---
		$repeater->start_controls_tab(
			'awea_ac_tab_settings',
			[
				'label' => esc_html__( 'Open Settings', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->add_control(
			'awea_ac_active',
			[
				'label'        => esc_html__( 'Open Initially', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_ac_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-ac-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_ac_items',
			[
				'label'       => esc_html__( 'Items List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_ac_title }}}',
				'default'     => [
					[
						'awea_ac_title'   => esc_html__( 'Where can I find your warranty policy?', 'awesome-widgets-elementor' ),
						'awea_ac_content' => esc_html__( 'Our standard commercial warranty covers all manufacturing defects and operational failures for 24 months from the purchase date.', 'awesome-widgets-elementor' ),
						'awea_ac_active'  => 'yes',
					],
					[
						'awea_ac_title'   => esc_html__( 'Do you support automated custom integrations?', 'awesome-widgets-elementor' ),
						'awea_ac_content' => esc_html__( 'Yes, our platform provides comprehensive REST API endpoints and webhooks for seamless custom pipeline synchronization.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_ac_title'   => esc_html__( 'What is your average response turnaround?', 'awesome-widgets-elementor' ),
						'awea_ac_content' => esc_html__( 'Priority support queries are reviewed and answered within 2 to 4 business hours by our lead technical team.', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. ACCORDION OPTIONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ac_section_settings',
			[
				'label' => esc_html__( 'Accordion Options', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_ac_box_style',
			[
				'label'        => esc_html__( 'List Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'cards',
				'options'      => [
					'cards'     => esc_html__( 'Separate Boxes', 'awesome-widgets-elementor' ),
					'connected' => esc_html__( 'Single Grouped Box', 'awesome-widgets-elementor' ),
					'minimal'   => esc_html__( 'Clean Underline Rows', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-ac-style-',
			]
		);

		$this->add_control(
			'awea_ac_multiple_open',
			[
				'label'        => esc_html__( 'Allow Multiple Open', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'awea_ac_show_index',
			[
				'label'        => esc_html__( 'Show Numbers (01, 02)', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'awea_ac_title_tag',
			[
				'label'   => esc_html__( 'Question Heading Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
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
			]
		);

		$this->add_control(
			'awea_ac_icon_style',
			[
				'label'     => esc_html__( 'Toggle Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'plus-minus',
				'separator' => 'before',
				'options'   => [
					'plus-minus' => esc_html__( 'Plus / Minus', 'awesome-widgets-elementor' ),
					'chevron'    => esc_html__( 'Chevron Arrow', 'awesome-widgets-elementor' ),
					'none'       => esc_html__( 'None', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_ac_icon_align',
			[
				'label'     => esc_html__( 'Icon Side', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'  => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'right',
				'condition' => [ 'awea_ac_icon_style!' => 'none' ],
			]
		);

		$this->add_control(
			'awea_ac_accent_bar',
			[
				'label'        => esc_html__( 'Active Color Line', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none' => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'left' => esc_html__( 'Left Line', 'awesome-widgets-elementor' ),
					'top'  => esc_html__( 'Top Line', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-ac-bar-',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_ac_faq_schema',
			[
				'label'        => esc_html__( 'Add Google FAQ Schema', 'awesome-widgets-elementor' ),
				'description'  => esc_html__( 'Outputs FAQPage JSON-LD data for search engine rich results.', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. ITEM BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ac_style_card',
			[
				'label' => esc_html__( 'Item Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_ac_item_gap',
			[
				'label'      => esc_html__( 'Space Between Items', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 48 ],
					'rem' => [ 'min' => 0, 'max' => 3 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'condition'  => [ 'awea_ac_box_style!' => 'connected' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-accordion-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ac_card_radius',
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
				'condition'  => [ 'awea_ac_box_style!' => 'minimal' ],
				'selectors'  => [
					'{{WRAPPER}}.awea-ac-style-cards .awea-accordion-item, {{WRAPPER}}.awea-ac-style-connected .awea-accordion-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_ac_accent_bar_color',
			[
				'label'     => esc_html__( 'Color Line', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_ac_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-ac-accent-bar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_ac_card_tabs' );

		$this->start_controls_tab(
			'awea_ac_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_ac_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}.awea-ac-style-cards .awea-accordion-item, {{WRAPPER}}.awea-ac-style-connected .awea-accordion-wrap',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_ac_card_border',
				'selector' => '{{WRAPPER}}.awea-ac-style-cards .awea-accordion-item, {{WRAPPER}}.awea-ac-style-connected .awea-accordion-wrap',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ac_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_ac_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}.awea-ac-style-cards .awea-accordion-item:hover, {{WRAPPER}}.awea-ac-style-connected .awea-accordion-item:hover',
			]
		);

		$this->add_control(
			'awea_ac_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}}.awea-ac-style-cards .awea-accordion-item:hover' => 'border-color: var(--awea-ac-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ac_card_active',
			[ 'label' => esc_html__( 'Open', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_ac_card_bg_active_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-accordion-item.is-active',
			]
		);

		$this->add_control(
			'awea_ac_card_border_active',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}}.awea-ac-style-cards .awea-accordion-item.is-active' => 'border-color: var(--awea-ac-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'awea_ac_card_shadow',
				'selector'  => '{{WRAPPER}}.awea-ac-style-cards .awea-accordion-item, {{WRAPPER}}.awea-ac-style-connected .awea-accordion-wrap',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. QUESTION HEADER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ac_style_header',
			[
				'label' => esc_html__( 'Question Header', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_ac_header_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '20',
					'right'    => '24',
					'bottom'   => '20',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-accordion-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ac_header_gap',
			[
				'label'      => esc_html__( 'Space Next to Icon', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-accordion-header' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ac_title_typo',
				'selector' => '{{WRAPPER}} .awea-accordion-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->start_controls_tabs( 'awea_ac_title_tabs' );

		$this->start_controls_tab(
			'awea_ac_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ac_title_color',
			[
				'label'     => esc_html__( 'Question Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-accordion-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ac_header_bg',
			[
				'label'     => esc_html__( 'Header Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-accordion-header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ac_title_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ac_title_color_hover',
			[
				'label'     => esc_html__( 'Question Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-accordion-header:hover .awea-accordion-title' => 'color: var(--awea-ac-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_ac_header_bg_hover',
			[
				'label'     => esc_html__( 'Header Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-accordion-header:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ac_title_active',
			[ 'label' => esc_html__( 'Open', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ac_title_color_active',
			[
				'label'     => esc_html__( 'Question Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-accordion-item.is-active .awea-accordion-title' => 'color: var(--awea-ac-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_ac_header_bg_active',
			[
				'label'     => esc_html__( 'Header Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-accordion-item.is-active .awea-accordion-header' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		/* Item Number Styling */
		$this->add_control(
			'awea_ac_index_heading',
			[
				'label'     => esc_html__( 'Item Number', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_ac_show_index' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_ac_index_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-accordion-index' => 'color: var(--awea-ac-item-accent, {{VALUE}});',
				],
				'condition' => [ 'awea_ac_show_index' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_ac_index_typo',
				'selector'  => '{{WRAPPER}} .awea-accordion-index',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
				'condition' => [ 'awea_ac_show_index' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TOGGLE ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ac_style_icon',
			[
				'label'     => esc_html__( 'Toggle Icon', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_ac_icon_style!' => 'none' ],
			]
		);

		$this->add_responsive_control(
			'awea_ac_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 15 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icon-line.h'  => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-icon-line.v'  => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-icon-chevron' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ac_icon_box_size',
			[
				'label'      => esc_html__( 'Circle Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 20, 'max' => 56 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 32 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icon-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_ac_icon_box_radius',
			[
				'label'      => esc_html__( 'Circle Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_ac_icon_tabs' );

		$this->start_controls_tab(
			'awea_ac_icon_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ac_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-icon-line'    => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .awea-icon-chevron' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ac_icon_box_bg',
			[
				'label'     => esc_html__( 'Circle Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-icon-box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_ac_icon_active',
			[ 'label' => esc_html__( 'Open', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_ac_icon_color_active',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-accordion-item.is-active .awea-icon-line'    => 'background-color: var(--awea-ac-item-accent, {{VALUE}});',
					'{{WRAPPER}} .awea-accordion-item.is-active .awea-icon-chevron' => 'stroke: var(--awea-ac-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_ac_icon_box_bg_active',
			[
				'label'     => esc_html__( 'Circle Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-accordion-item.is-active .awea-icon-box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. ANSWER BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_ac_style_content',
			[
				'label' => esc_html__( 'Answer Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_ac_content_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '0',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_ac_content_typo',
				'selector' => '{{WRAPPER}} .awea-content-inner',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_control(
			'awea_ac_content_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-content-inner' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_ac_content_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-content-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'awea_ac_content_top_border',
				'label'     => esc_html__( 'Divider Line', 'awesome-widgets-elementor' ),
				'selector'  => '{{WRAPPER}} .awea-content-inner',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$items       = $settings['awea_ac_items'] ?? [];
		$is_multiple = 'yes' === ( $settings['awea_ac_multiple_open'] ?? 'no' );
		$show_index  = 'yes' === ( $settings['awea_ac_show_index'] ?? 'no' );
		$icon_style  = $settings['awea_ac_icon_style'] ?? 'plus-minus';
		$icon_align  = $settings['awea_ac_icon_align'] ?? 'right';
		$title_tag   = Utils::validate_html_tag( $settings['awea_ac_title_tag'] ?? 'h4' );
		$faq_schema  = 'yes' === ( $settings['awea_ac_faq_schema'] ?? 'no' );
		$widget_id   = $this->get_id();

		if ( empty( $items ) ) {
			return;
		}

		$container_classes = [ 'awea-accordion-wrap' ];
		if ( 'left' === $icon_align ) {
			$container_classes[] = 'awea-icon-pos-left';
		}

		$has_opened_one  = false;
		$schema_entities = [];
		?>
		<div class="<?php echo esc_attr( implode( ' ', $container_classes ) ); ?>"
			 id="awea-acc-<?php echo esc_attr( $widget_id ); ?>"
			 data-multiple="<?php echo $is_multiple ? 'true' : 'false'; ?>">

			<?php foreach ( $items as $index => $item ) :
				$id        = $item['_id'] ?? $index;
				$title     = $item['awea_ac_title'] ?? '';
				$content   = $item['awea_ac_content'] ?? '';
				$want_open = 'yes' === ( $item['awea_ac_active'] ?? '' );

				if ( $want_open && ( $is_multiple || ! $has_opened_one ) ) {
					$is_active      = true;
					$has_opened_one = true;
				} else {
					$is_active = false;
				}

				if ( $faq_schema && ! empty( $title ) && ! empty( $content ) ) {
					$schema_entities[] = [
						'@type'          => 'Question',
						'name'           => wp_strip_all_tags( $title ),
						'acceptedAnswer' => [
							'@type' => 'Answer',
							'text'  => wp_kses_post( $content ),
						],
					];
				}

				$head_id  = 'acc-head-' . $widget_id . '-' . $index;
				$panel_id = 'acc-panel-' . $widget_id . '-' . $index;

				$item_classes = [ 'awea-accordion-item', 'elementor-repeater-item-' . esc_attr( $id ) ];
				if ( $is_active ) {
					$item_classes[] = 'is-active';
				}
				?>
				<div class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>">
					<span class="awea-ac-accent-bar" aria-hidden="true"></span>

					<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-accordion-heading-wrap">
						<button type="button"
								class="awea-accordion-header"
								id="<?php echo esc_attr( $head_id ); ?>"
								aria-expanded="<?php echo $is_active ? 'true' : 'false'; ?>"
								aria-controls="<?php echo esc_attr( $panel_id ); ?>">

							<span class="awea-accordion-title-group">
								<?php if ( $show_index ) : ?>
									<span class="awea-accordion-index"><?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
								<?php endif; ?>
								<span class="awea-accordion-title"><?php echo esc_html( $title ); ?></span>
							</span>

							<?php if ( 'plus-minus' === $icon_style ) : ?>
								<span class="awea-icon-box" aria-hidden="true">
									<span class="awea-icon-line h"></span>
									<span class="awea-icon-line v"></span>
								</span>
							<?php elseif ( 'chevron' === $icon_style ) : ?>
								<span class="awea-icon-box" aria-hidden="true">
									<svg class="awea-icon-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
										<polyline points="6 9 12 15 18 9"></polyline>
									</svg>
								</span>
							<?php endif; ?>
						</button>
					</<?php Utils::print_validated_html_tag( $title_tag ); ?>>

					<div class="awea-accordion-collapse"
						 id="<?php echo esc_attr( $panel_id ); ?>"
						 role="region"
						 aria-labelledby="<?php echo esc_attr( $head_id ); ?>"
						 aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>">
						<div class="awea-accordion-overflow">
							<div class="awea-content-inner">
								<?php echo wp_kses_post( $content ); ?>
							</div>
						</div>
					</div>

				</div>
			<?php endforeach; ?>

		</div>

		<?php if ( $faq_schema && ! empty( $schema_entities ) ) :
			$schema_data = [
				'@context'   => 'https://schema.org',
				'@type'      => 'FAQPage',
				'mainEntity' => $schema_entities,
			];
			?>
			<script type="application/ld+json"><?php echo wp_json_encode( $schema_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?></script>
		<?php endif; ?>

		<script>
		(function() {
			function initAccordion() {
				var root = document.getElementById('awea-acc-<?php echo esc_js( $widget_id ); ?>');
				if (!root || root.dataset.aweaBound === '1') return;
				root.dataset.aweaBound = '1';

				var isMultiple = root.getAttribute('data-multiple') === 'true';
				var headers = Array.from(root.querySelectorAll('.awea-accordion-header'));

				headers.forEach(function(header, idx) {
					header.addEventListener('click', function() {
						var item = header.closest('.awea-accordion-item');
						var panel = item ? item.querySelector('.awea-accordion-collapse') : null;
						var isActive = item.classList.contains('is-active');

						if (isActive) {
							item.classList.remove('is-active');
							header.setAttribute('aria-expanded', 'false');
							if (panel) panel.setAttribute('aria-hidden', 'true');
						} else {
							if (!isMultiple) {
								root.querySelectorAll('.awea-accordion-item').forEach(function(other) {
									other.classList.remove('is-active');
									var otherBtn = other.querySelector('.awea-accordion-header');
									var otherPanel = other.querySelector('.awea-accordion-collapse');
									if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
									if (otherPanel) otherPanel.setAttribute('aria-hidden', 'true');
								});
							}
							item.classList.add('is-active');
							header.setAttribute('aria-expanded', 'true');
							if (panel) panel.setAttribute('aria-hidden', 'false');
						}
					});

					header.addEventListener('keydown', function(e) {
						var targetIdx = -1;
						if (e.key === 'ArrowDown') {
							targetIdx = (idx + 1) % headers.length;
						} else if (e.key === 'ArrowUp') {
							targetIdx = (idx - 1 + headers.length) % headers.length;
						} else if (e.key === 'Home') {
							targetIdx = 0;
						} else if (e.key === 'End') {
							targetIdx = headers.length - 1;
						}
						if (targetIdx !== -1) {
							e.preventDefault();
							headers[targetIdx].focus();
						}
					});
				});
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initAccordion);
			} else {
				initAccordion();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-accordion.default', initAccordion);
			}
		})();
		</script>
		<?php
	}
}