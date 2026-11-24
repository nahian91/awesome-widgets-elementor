<?php
/**
 * Awesome Icon Box Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.5.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Widget_Awesome_Icon_Box extends Widget_Base {

	public function get_name() {
		return 'awesome-icon-box';
	}

	public function get_title() {
		return esc_html__( 'Icon Box', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-icon-box';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'icon', 'box', 'grid', 'feature', 'card', 'service', 'shape', 'bento', 'pricing' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icb_section_items',
			[
				'label' => esc_html__( 'Cards', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_icb_item_tabs' );

		// --- TAB 1: ICON ---
		$repeater->start_controls_tab(
			'awea_icb_tab_media',
			[ 'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_icb_media_type',
			[
				'label'   => esc_html__( 'Type', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'icon',
				'toggle'  => false,
				'options' => [
					'icon'  => [
						'title' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-star',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-image',
					],
					'text'  => [
						'title' => esc_html__( 'Number / Text', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-number-field',
					],
					'none'  => [
						'title' => esc_html__( 'None', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-ban',
					],
				],
			]
		);

		$repeater->add_control(
			'awea_icb_icon',
			[
				'label'     => esc_html__( 'Choose Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-bolt',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_icb_media_type' => 'icon' ],
			]
		);

		$repeater->add_control(
			'awea_icb_image',
			[
				'label'     => esc_html__( 'Choose Image', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [ 'url' => Utils::get_placeholder_image_src() ],
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_icb_media_type' => 'image' ],
			]
		);

		$repeater->add_control(
			'awea_icb_media_text',
			[
				'label'       => esc_html__( 'Number or Short Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '01',
				'placeholder' => '01',
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_icb_media_type' => 'text' ],
			]
		);

		$repeater->add_control(
			'awea_icb_badge',
			[
				'label'       => esc_html__( 'Corner Tag', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Popular', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: TEXT ---
		$repeater->start_controls_tab(
			'awea_icb_tab_text',
			[ 'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_icb_subtitle',
			[
				'label'       => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'SPEED', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_icb_title',
			[
				'label'       => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Lightning Architecture', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_icb_desc',
			[
				'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Engineered for optimal rendering speeds with zero unnecessary overhead straight out of the box.', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_icb_features',
			[
				'label'       => esc_html__( 'Bullet Points (One per line)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => '',
				'placeholder' => esc_html__( "Fast loading speed\nClean code structure\nMobile ready", 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: BUTTON ---
		$repeater->start_controls_tab(
			'awea_icb_tab_link',
			[ 'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_icb_btn_link',
			[
				'label'   => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::URL,
				'dynamic' => [ 'active' => true ],
				'default' => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_icb_btn_show',
			[
				'label'        => esc_html__( 'Show Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'awea_icb_btn_text',
			[
				'label'     => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Explore Module', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_icb_btn_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_icb_btn_icon',
			[
				'label'     => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_icb_btn_show' => 'yes' ],
			]
		);

		$repeater->add_control(
			'awea_icb_btn_icon_pos',
			[
				'label'     => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Left', 'awesome-widgets-elementor' ),
					'right' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
				],
				'condition' => [ 'awea_icb_btn_show' => 'yes' ],
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 4: COLORS ---
		$repeater->start_controls_tab(
			'awea_icb_tab_highlight',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_icb_item_featured',
			[
				'label'        => esc_html__( 'Highlight This Card', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_icb_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-icb-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_icb_item_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-icb-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-icb-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_icb_item_icon_bg',
			[
				'label'     => esc_html__( 'Icon Box Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea-icb-view-stacked {{CURRENT_ITEM}} .awea-icb-icon'                       => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.awea-icb-view-framed {{CURRENT_ITEM}} .awea-icb-icon'                        => 'border-color: {{VALUE}};',
					'{{WRAPPER}}.awea-icb-view-framed.awea-icb-shape-hexagon {{CURRENT_ITEM}} .awea-icb-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_icb_item_card_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}; --awea-icb-card-bg: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_icb_item_border_color',
			[
				'label'     => esc_html__( 'Card Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_icb_item_badge_bg',
			[
				'label'     => esc_html__( 'Tag Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-icb-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_icb_item_badge_color',
			[
				'label'     => esc_html__( 'Tag Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .awea-icb-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'awea_icb_items',
			[
				'label'       => esc_html__( 'Card List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_icb_title }}}',
				'default'     => [
					[
						'awea_icb_icon'     => [ 'value' => 'fas fa-bolt', 'library' => 'fa-solid' ],
						'awea_icb_subtitle' => esc_html__( 'SPEED', 'awesome-widgets-elementor' ),
						'awea_icb_title'    => esc_html__( 'Lightning Architecture', 'awesome-widgets-elementor' ),
						'awea_icb_desc'     => esc_html__( 'Engineered for optimal rendering speeds with zero unnecessary overhead straight out of the box.', 'awesome-widgets-elementor' ),
						'awea_icb_btn_text' => esc_html__( 'Explore Module', 'awesome-widgets-elementor' ),
					],
					[
						'awea_icb_icon'          => [ 'value' => 'fas fa-layer-group', 'library' => 'fa-solid' ],
						'awea_icb_badge'         => esc_html__( 'Core', 'awesome-widgets-elementor' ),
						'awea_icb_subtitle'      => esc_html__( 'SYSTEM', 'awesome-widgets-elementor' ),
						'awea_icb_title'         => esc_html__( 'Modular Precision', 'awesome-widgets-elementor' ),
						'awea_icb_desc'          => esc_html__( 'Clean component primitives built to stay aligned across desktop, tablet, and mobile viewports.', 'awesome-widgets-elementor' ),
						'awea_icb_btn_text'      => esc_html__( 'View System', 'awesome-widgets-elementor' ),
						'awea_icb_item_featured' => 'yes',
					],
					[
						'awea_icb_icon'     => [ 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ],
						'awea_icb_subtitle' => esc_html__( 'SECURITY', 'awesome-widgets-elementor' ),
						'awea_icb_title'    => esc_html__( 'Hardened Security', 'awesome-widgets-elementor' ),
						'awea_icb_desc'     => esc_html__( 'Strict escaping, sanitized attributes, and resilient markup designed for enterprise production.', 'awesome-widgets-elementor' ),
						'awea_icb_btn_text' => esc_html__( 'Read Specs', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID & LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icb_section_layout',
			[
				'label' => esc_html__( 'Grid & Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_icb_columns',
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
					'5' => '5',
					'6' => '6',
				],
				'selectors'      => [
					'{{WRAPPER}} .awea-icb-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_col_gap',
			[
				'label'      => esc_html__( 'Space Between Columns', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 80 ],
					'rem' => [ 'min' => 0, 'max' => 5 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_row_gap',
			[
				'label'      => esc_html__( 'Space Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px'  => [ 'min' => 0, 'max' => 80 ],
					'rem' => [ 'min' => 0, 'max' => 5 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_icb_equal_height',
			[
				'label'        => esc_html__( 'Same Height Cards', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'stretch',
				'default'      => 'stretch',
				'selectors'    => [
					'{{WRAPPER}} .awea-icb-grid' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_icon_pos',
			[
				'label'                => esc_html__( 'Icon Position', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => 'top',
				'toggle'               => false,
				'options'              => [
					'left'  => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-left',
					],
					'top'   => [
						'title' => esc_html__( 'Top', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'top'   => 'flex-direction: column;',
					'left'  => 'flex-direction: row;',
					'right' => 'flex-direction: row-reverse;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-icb-card' => '{{VALUE}}',
				],
				'prefix_class'         => 'awea-icb-pos%s-',
			]
		);

		$this->add_control(
			'awea_icb_icon_view',
			[
				'label'        => esc_html__( 'Icon Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'stacked',
				'options'      => [
					'default' => esc_html__( 'Plain Icon', 'awesome-widgets-elementor' ),
					'stacked' => esc_html__( 'Filled Box', 'awesome-widgets-elementor' ),
					'framed'  => esc_html__( 'Outlined Box', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-icb-view-',
			]
		);

		$this->add_control(
			'awea_icb_icon_shape',
			[
				'label'        => esc_html__( 'Icon Box Shape', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'rounded',
				'options'      => [
					'rounded'  => esc_html__( 'Rounded', 'awesome-widgets-elementor' ),
					'circle'   => esc_html__( 'Circle', 'awesome-widgets-elementor' ),
					'square'   => esc_html__( 'Square', 'awesome-widgets-elementor' ),
					'hexagon'  => esc_html__( 'Hexagon', 'awesome-widgets-elementor' ),
					'squircle' => esc_html__( 'Blob', 'awesome-widgets-elementor' ),
				],
				'condition'    => [ 'awea_icb_icon_view!' => 'default' ],
				'prefix_class' => 'awea-icb-shape-',
			]
		);

		$this->add_control(
			'awea_icb_feature_icon',
			[
				'label'     => esc_html__( 'Bullet Point Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-check-circle',
					'library' => 'fa-solid',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_icb_link_mode',
			[
				'label'   => esc_html__( 'Clickable Area', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'button',
				'options' => [
					'button' => esc_html__( 'Button Only', 'awesome-widgets-elementor' ),
					'title'  => esc_html__( 'Heading & Button', 'awesome-widgets-elementor' ),
					'card'   => esc_html__( 'Whole Card', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_icb_title_tag',
			[
				'label'   => esc_html__( 'Heading Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
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

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. HOVER EFFECTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icb_section_effects',
			[
				'label' => esc_html__( 'Hover Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_icb_hover_motion',
			[
				'label'        => esc_html__( 'Card Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-icb-motion-',
			]
		);

		$this->add_control(
			'awea_icb_icon_hover_anim',
			[
				'label'        => esc_html__( 'Icon Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'scale',
				'options'      => [
					'none'   => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'scale'  => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
					'rotate' => esc_html__( 'Tilt', 'awesome-widgets-elementor' ),
					'float'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'pulse'  => esc_html__( 'Glow Ring', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-icb-ianim-',
			]
		);

		$this->add_control(
			'awea_icb_accent_bar',
			[
				'label'        => esc_html__( 'Color Line', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'top-hover',
				'options'      => [
					'none'         => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'top-hover'    => esc_html__( 'Top Line (On Hover)', 'awesome-widgets-elementor' ),
					'top-always'   => esc_html__( 'Top Line (Always Show)', 'awesome-widgets-elementor' ),
					'bottom-hover' => esc_html__( 'Bottom Line (On Hover)', 'awesome-widgets-elementor' ),
					'left-hover'   => esc_html__( 'Left Line (On Hover)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-icb-bar-',
			]
		);

		$this->add_control(
			'awea_icb_watermark_icon',
			[
				'label'        => esc_html__( 'Background Watermark Icon', 'awesome-widgets-elementor' ),
				'description'  => esc_html__( 'Shows a large faded icon in the bottom-right corner.', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'awea_icb_stagger_offset',
			[
				'label'        => esc_html__( 'Offset Even Cards (Desktop)', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'awea-icb-stagger-',
			]
		);

		$this->add_responsive_control(
			'awea_icb_stagger_amount',
			[
				'label'      => esc_html__( 'Offset Distance', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'condition'  => [ 'awea_icb_stagger_offset' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--awea-icb-stagger: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icb_style_card',
			[
				'label' => esc_html__( 'Card', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_icb_align',
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
					'left'   => 'text-align: left; align-items: flex-start; --awea-icb-btn-align: flex-start;',
					'center' => 'text-align: center; align-items: center; --awea-icb-btn-align: center;',
					'right'  => 'text-align: right; align-items: flex-end; --awea-icb-btn-align: flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-icb-card' => '{{VALUE}}',
					'{{WRAPPER}} .awea-icb-body' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '32',
					'right'    => '28',
					'bottom'   => '32',
					'left'     => '28',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_card_radius',
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
					'{{WRAPPER}} .awea-icb-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_icb_card_backdrop_blur',
			[
				'label'      => esc_html__( 'Background Blur', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 0 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-card' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'awea_icb_accent_bar_color',
			[
				'label'     => esc_html__( 'Color Line Start', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_icb_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-accent-bar' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icb_accent_bar_color_2',
			[
				'label'     => esc_html__( 'Color Line End', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_icb_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-accent-bar' => 'background: linear-gradient(90deg, var(--awea-icb-item-accent, {{awea_icb_accent_bar_color.VALUE}}), {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_icb_accent_bar_thickness',
			[
				'label'      => esc_html__( 'Line Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 10 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'condition'  => [ 'awea_icb_accent_bar!' => 'none' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--awea-icb-bar-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_icb_card_tabs' );

		$this->start_controls_tab(
			'awea_icb_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_icb_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-icb-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_icb_card_border',
				'selector'       => '{{WRAPPER}} .awea-icb-card',
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
				'name'     => 'awea_icb_card_shadow',
				'selector' => '{{WRAPPER}} .awea-icb-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_icb_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_icb_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-icb-card:hover',
			]
		);

		$this->add_control(
			'awea_icb_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-card:hover' => 'border-color: var(--awea-icb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_icb_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-icb-card:hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_icb_card_featured',
			[ 'label' => esc_html__( 'Highlighted', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_icb_card_bg_featured',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-icb-card.awea-icb-featured',
			]
		);

		$this->add_control(
			'awea_icb_card_border_featured',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-card.awea-icb-featured' => 'border-color: var(--awea-icb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_icb_card_shadow_featured',
				'selector' => '{{WRAPPER}} .awea-icb-card.awea-icb-featured',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. ICON BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icb_style_icon',
			[
				'label' => esc_html__( 'Icon Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_icb_icon_box_size',
			[
				'label'      => esc_html__( 'Box Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 36, 'max' => 140 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 60 ],
				'condition'  => [ 'awea_icb_icon_view!' => 'default' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_icon_size',
			[
				'label'      => esc_html__( 'Icon / Image Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 96 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-icb-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-icb-icon img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_icb_media_text_typo',
				'label'    => esc_html__( 'Number / Text Font', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-icb-media-text',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_responsive_control(
			'awea_icb_icon_gap',
			[
				'label'      => esc_html__( 'Space Below Icon', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-card' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_icon_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition'  => [
					'awea_icb_icon_view!' => 'default',
					'awea_icb_icon_shape' => 'rounded',
				],
				'default'    => [
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea-icb-shape-rounded .awea-icb-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_icon_border_width',
			[
				'label'      => esc_html__( 'Border Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 6 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 1.5 ],
				'condition'  => [
					'awea_icb_icon_view'   => 'framed',
					'awea_icb_icon_shape!' => 'hexagon',
				],
				'selectors'  => [
					'{{WRAPPER}}.awea-icb-view-framed .awea-icb-icon' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_icb_icon_tabs' );

		$this->start_controls_tab(
			'awea_icb_icon_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icb_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-icon'     => 'color: var(--awea-icb-item-accent, {{VALUE}});',
					'{{WRAPPER}} .awea-icb-icon svg' => 'fill: var(--awea-icb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'awea_icb_icon_bg_group',
				'types'     => [ 'classic', 'gradient' ],
				'condition' => [ 'awea_icb_icon_view' => 'stacked' ],
				'selector'  => '{{WRAPPER}}.awea-icb-view-stacked .awea-icb-icon',
			]
		);

		$this->add_control(
			'awea_icb_icon_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_icb_icon_view' => 'framed' ],
				'selectors' => [
					'{{WRAPPER}}.awea-icb-view-framed .awea-icb-icon'                        => 'border-color: var(--awea-icb-item-accent, {{VALUE}});',
					'{{WRAPPER}}.awea-icb-view-framed.awea-icb-shape-hexagon .awea-icb-icon' => 'background-color: var(--awea-icb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'awea_icb_icon_shadow',
				'condition' => [ 'awea_icb_icon_view!' => 'default' ],
				'selector'  => '{{WRAPPER}} .awea-icb-icon',
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_icb_img_filter',
				'label'    => esc_html__( 'Image Filters', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-icb-icon img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_icb_icon_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icb_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-icb-card:hover .awea-icb-icon'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-icb-card:hover .awea-icb-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'awea_icb_icon_bg_hover_group',
				'types'     => [ 'classic', 'gradient' ],
				'condition' => [ 'awea_icb_icon_view!' => 'default' ],
				'selector'  => '{{WRAPPER}}.awea-icb-view-stacked .awea-icb-card:hover .awea-icb-icon, {{WRAPPER}}.awea-icb-view-framed .awea-icb-card:hover .awea-icb-icon, {{WRAPPER}}.awea-icb-view-framed.awea-icb-shape-hexagon .awea-icb-card:hover .awea-icb-icon::before',
			]
		);

		$this->add_control(
			'awea_icb_icon_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [
					'awea_icb_icon_view'   => 'framed',
					'awea_icb_icon_shape!' => 'hexagon',
				],
				'selectors' => [
					'{{WRAPPER}}.awea-icb-view-framed .awea-icb-card:hover .awea-icb-icon' => 'border-color: var(--awea-icb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'awea_icb_icon_shadow_hover',
				'condition' => [ 'awea_icb_icon_view!' => 'default' ],
				'selector'  => '{{WRAPPER}} .awea-icb-card:hover .awea-icb-icon',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. CORNER TAG
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icb_style_badge',
			[
				'label' => esc_html__( 'Corner Tag', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_icb_badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-badge' => 'color: var(--awea-icb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_icb_badge_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-icb-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_icb_badge_typo',
				'selector' => '{{WRAPPER}} .awea-icb-badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_icb_badge_border',
				'selector' => '{{WRAPPER}} .awea-icb-badge',
			]
		);

		$this->add_responsive_control(
			'awea_icb_badge_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '4',
					'right'    => '10',
					'bottom'   => '4',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_badge_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '100',
					'right'    => '100',
					'bottom'   => '100',
					'left'     => '100',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_badge_offset_top',
			[
				'label'      => esc_html__( 'Top Position', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-badge' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_badge_offset_side',
			[
				'label'      => esc_html__( 'Side Position', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-badge'                    => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.awea-icb-pos-right .awea-icb-badge' => 'right: auto; left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. HEADINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icb_style_title',
			[
				'label' => esc_html__( 'Headings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_icb_heading_subtitle_style',
			[
				'label' => esc_html__( 'Small Heading', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_icb_subtitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-subtitle' => 'color: var(--awea-icb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_icb_subtitle_typo',
				'selector' => '{{WRAPPER}} .awea-icb-subtitle',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_responsive_control(
			'awea_icb_subtitle_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_icb_heading_title_style',
			[
				'label'     => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_icb_title_typo',
				'selector' => '{{WRAPPER}} .awea-icb-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_icb_title_shadow',
				'selector' => '{{WRAPPER}} .awea-icb-title',
			]
		);

		$this->add_responsive_control(
			'awea_icb_title_space',
			[
				'label'      => esc_html__( 'Space Below', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_icb_title_tabs' );

		$this->start_controls_tab(
			'awea_icb_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icb_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-title, {{WRAPPER}} .awea-icb-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_icb_title_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icb_title_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-card:hover .awea-icb-title, {{WRAPPER}} .awea-icb-card:hover .awea-icb-title a' => 'color: var(--awea-icb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. TEXT & BULLETS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icb_style_desc',
			[
				'label' => esc_html__( 'Text & Bullets', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_icb_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_icb_desc_typo',
				'selector' => '{{WRAPPER}} .awea-icb-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_icb_desc_space',
			[
				'label'      => esc_html__( 'Space Below Text', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_icb_heading_features_style',
			[
				'label'     => esc_html__( 'Bullet Points', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_icb_feat_icon_color',
			[
				'label'     => esc_html__( 'Bullet Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-feat-ico'     => 'color: var(--awea-icb-item-accent, {{VALUE}});',
					'{{WRAPPER}} .awea-icb-feat-ico svg' => 'fill: var(--awea-icb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_icb_feat_text_color',
			[
				'label'     => esc_html__( 'Bullet Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-features li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_icb_feat_typo',
				'selector' => '{{WRAPPER}} .awea-icb-features li',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_icb_feat_gap',
			[
				'label'      => esc_html__( 'Space Between Bullets', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-features' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_feat_bottom_space',
			[
				'label'      => esc_html__( 'Space Below Bullets', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-features' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_icb_style_button',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_icb_btn_full_width',
			[
				'label'        => esc_html__( 'Full Width Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => '100%',
				'default'      => '',
				'selectors'    => [
					'{{WRAPPER}} .awea-icb-btn' => 'width: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_icb_btn_typo',
				'selector' => '{{WRAPPER}} .awea-icb-btn',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->add_responsive_control(
			'awea_icb_btn_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 8, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-ico i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-icb-ico svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_btn_icon_gap',
			[
				'label'      => esc_html__( 'Space Between Text & Icon', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-btn' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_btn_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '11',
					'right'    => '20',
					'bottom'   => '11',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icb_btn_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '10',
					'right'    => '10',
					'bottom'   => '10',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-icb-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_icb_btn_tabs' );

		$this->start_controls_tab(
			'awea_icb_btn_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icb_btn_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-icb-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icb_btn_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_icb_btn_border',
				'selector' => '{{WRAPPER}} .awea-icb-btn',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_icb_btn_shadow',
				'selector' => '{{WRAPPER}} .awea-icb-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_icb_btn_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icb_btn_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-icb-btn:hover, {{WRAPPER}} .awea-icb-card:hover .awea-icb-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icb_btn_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-btn:hover, {{WRAPPER}} .awea-icb-card:hover .awea-icb-btn' => 'background-color: var(--awea-icb-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_control(
			'awea_icb_btn_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-icb-btn:hover, {{WRAPPER}} .awea-icb-card:hover .awea-icb-btn' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_icb_btn_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-icb-btn:hover, {{WRAPPER}} .awea-icb-card:hover .awea-icb-btn',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings       = $this->get_settings_for_display();
		$items          = $settings['awea_icb_items'] ?? [];
		$title_tag      = Utils::validate_html_tag( $settings['awea_icb_title_tag'] ?? 'h3' );
		$link_mode      = $settings['awea_icb_link_mode'] ?? 'button';
		$show_watermark = 'yes' === ( $settings['awea_icb_watermark_icon'] ?? '' );
		$feat_icon      = $settings['awea_icb_feature_icon'] ?? [];

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea-icb-grid">
			<?php foreach ( $items as $index => $item ) :
				$id         = $item['_id'] ?? $index;
				$card_key   = 'awea_icb_card_' . $id;
				$link_key   = 'awea_icb_link_' . $id;
				$media_type = $item['awea_icb_media_type'] ?? 'icon';

				$subtitle = $item['awea_icb_subtitle'] ?? '';
				$title    = $item['awea_icb_title'] ?? '';
				$desc     = $item['awea_icb_desc'] ?? '';
				$badge    = $item['awea_icb_badge'] ?? '';
				$featured = 'yes' === ( $item['awea_icb_item_featured'] ?? '' );

				$raw_features = trim( $item['awea_icb_features'] ?? '' );
				$features     = '' !== $raw_features ? array_filter( array_map( 'trim', explode( "\n", $raw_features ) ) ) : [];

				$has_icon  = ( 'icon' === $media_type && ! empty( $item['awea_icb_icon']['value'] ) );
				$has_image = ( 'image' === $media_type && ! empty( $item['awea_icb_image']['url'] ) );
				$has_text  = ( 'text' === $media_type && '' !== trim( $item['awea_icb_media_text'] ?? '' ) );
				$has_media = ( $has_icon || $has_image || $has_text );

				$url_data = ! empty( $item['awea_icb_btn_link']['url'] ) ? $item['awea_icb_btn_link'] : [ 'url' => '#' ];
				$has_url  = ! empty( $item['awea_icb_btn_link']['url'] );

				$btn_show    = 'yes' === ( $item['awea_icb_btn_show'] ?? 'no' );
				$btn_text    = $item['awea_icb_btn_text'] ?? '';
				$btn_pos     = $item['awea_icb_btn_icon_pos'] ?? 'right';
				$has_btn_ico = ! empty( $item['awea_icb_btn_icon']['value'] );

				$is_card_link  = ( 'card' === $link_mode && $has_url );
				$is_title_link = ( 'title' === $link_mode && $has_url );

				$aria_label = ! empty( $title ) ? $title : ( ! empty( $btn_text ) ? $btn_text : esc_html__( 'Card link', 'awesome-widgets-elementor' ) );

				$subtitle_setting_key = $this->get_repeater_setting_key( 'awea_icb_subtitle', 'awea_icb_items', $index );
				$title_setting_key    = $this->get_repeater_setting_key( 'awea_icb_title', 'awea_icb_items', $index );
				$desc_setting_key     = $this->get_repeater_setting_key( 'awea_icb_desc', 'awea_icb_items', $index );

				$this->add_inline_editing_attributes( $subtitle_setting_key, 'none' );
				$this->add_inline_editing_attributes( $title_setting_key, 'none' );
				$this->add_inline_editing_attributes( $desc_setting_key, 'basic' );

				$this->add_render_attribute( $subtitle_setting_key, 'class', 'awea-icb-subtitle' );
				$this->add_render_attribute( $title_setting_key, 'class', 'awea-icb-title' );
				$this->add_render_attribute( $desc_setting_key, 'class', 'awea-icb-desc' );

				$card_classes = [
					'awea-icb-card',
					'elementor-repeater-item-' . esc_attr( $id ),
				];
				if ( $is_card_link ) {
					$card_classes[] = 'awea-icb-card-clickable';
				}
				if ( $featured ) {
					$card_classes[] = 'awea-icb-featured';
				}

				$this->add_render_attribute( $card_key, 'class', $card_classes );
				$this->add_link_attributes( $link_key, $url_data );
				?>
				<article <?php $this->print_render_attribute_string( $card_key ); ?>>

					<span class="awea-icb-accent-bar" aria-hidden="true"></span>

					<?php if ( $show_watermark && $has_icon ) : ?>
						<div class="awea-icb-watermark" aria-hidden="true">
							<?php Icons_Manager::render_icon( $item['awea_icb_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $is_card_link ) : ?>
						<a <?php $this->print_render_attribute_string( $link_key ); ?> class="awea-icb-cover-link" aria-label="<?php echo esc_attr( $aria_label ); ?>"></a>
					<?php endif; ?>

					<?php if ( ! empty( $badge ) ) : ?>
						<span class="awea-icb-badge"><?php echo esc_html( $badge ); ?></span>
					<?php endif; ?>

					<?php if ( $has_media ) : ?>
						<div class="awea-icb-icon" aria-hidden="true">
							<?php
							if ( $has_icon ) {
								Icons_Manager::render_icon( $item['awea_icb_icon'], [ 'aria-hidden' => 'true' ] );
							} elseif ( $has_image ) {
								echo '<img src="' . esc_url( $item['awea_icb_image']['url'] ) . '" alt="' . esc_attr( $title ) . '" loading="lazy" />';
							} elseif ( $has_text ) {
								echo '<span class="awea-icb-media-text">' . esc_html( $item['awea_icb_media_text'] ) . '</span>';
							}
							?>
						</div>
					<?php endif; ?>

					<div class="awea-icb-body">
						<?php if ( ! empty( $subtitle ) ) : ?>
							<span <?php $this->print_render_attribute_string( $subtitle_setting_key ); ?>>
								<?php echo esc_html( $subtitle ); ?>
							</span>
						<?php endif; ?>

						<?php if ( ! empty( $title ) ) : ?>
							<<?php Utils::print_validated_html_tag( $title_tag ); ?> <?php $this->print_render_attribute_string( $title_setting_key ); ?>>
								<?php if ( $is_title_link ) : ?>
									<a <?php $this->print_render_attribute_string( $link_key ); ?>>
										<?php echo esc_html( $title ); ?>
									</a>
								<?php else : ?>
									<?php echo esc_html( $title ); ?>
								<?php endif; ?>
							</<?php Utils::print_validated_html_tag( $title_tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $desc ) ) : ?>
							<p <?php $this->print_render_attribute_string( $desc_setting_key ); ?>>
								<?php echo wp_kses_post( $desc ); ?>
							</p>
						<?php endif; ?>

						<?php if ( ! empty( $features ) ) : ?>
							<ul class="awea-icb-features">
								<?php foreach ( $features as $feat ) : ?>
									<li>
										<?php if ( ! empty( $feat_icon['value'] ) ) : ?>
											<span class="awea-icb-feat-ico" aria-hidden="true">
												<?php Icons_Manager::render_icon( $feat_icon, [ 'aria-hidden' => 'true' ] ); ?>
											</span>
										<?php endif; ?>
										<span><?php echo wp_kses_post( $feat ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<?php if ( $btn_show && ! empty( $btn_text ) ) : ?>
							<div class="awea-icb-btn-wrap">
								<?php if ( $is_card_link ) : ?>
									<span class="awea-icb-btn">
								<?php else : ?>
									<a <?php $this->print_render_attribute_string( $link_key ); ?> class="awea-icb-btn">
								<?php endif; ?>

									<?php if ( 'left' === $btn_pos && $has_btn_ico ) : ?>
										<span class="awea-icb-ico awea-icb-ico-left" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_icb_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

									<span><?php echo esc_html( $btn_text ); ?></span>

									<?php if ( 'right' === $btn_pos && $has_btn_ico ) : ?>
										<span class="awea-icb-ico awea-icb-ico-right" aria-hidden="true">
											<?php Icons_Manager::render_icon( $item['awea_icb_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

								<?php echo $is_card_link ? '</span>' : '</a>'; ?>
							</div>
						<?php endif; ?>
					</div>

				</article>
			<?php endforeach; ?>
		</div>
		<?php
	}
}