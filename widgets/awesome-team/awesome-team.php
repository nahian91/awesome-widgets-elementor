<?php
/**
 * Awesome Team Widget.
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
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Widget_Awesome_Team extends Widget_Base {

	public function get_name() {
		return 'awesome-team';
	}

	public function get_title() {
		return esc_html__( 'Team', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-user-circle-o';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'team', 'members', 'grid', 'profile', 'staff', 'card', 'people' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. TEAM MEMBERS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tm_section_members',
			[
				'label' => esc_html__( 'Team Members', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_tm_member_tabs' );

		// --- TAB 1: PROFILE ---
		$repeater->start_controls_tab(
			'awea_tm_tab_profile',
			[ 'label' => esc_html__( 'Profile', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_tm_photo',
			[
				'label'   => esc_html__( 'Profile Photo', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_tm_badge',
			[
				'label'       => esc_html__( 'Department Tag', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Leadership', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_tm_name',
			[
				'label'       => esc_html__( 'Full Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_tm_role',
			[
				'label'       => esc_html__( 'Job Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_tm_bio',
			[
				'label'   => esc_html__( 'Short Bio', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'Pioneering clean architectural design systems and responsive user interfaces.', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->add_control(
			'awea_tm_profile_url',
			[
				'label'       => esc_html__( 'Profile Link URL (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com/team/member',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 2: SOCIAL LINKS ---
		$repeater->start_controls_tab(
			'awea_tm_tab_socials',
			[ 'label' => esc_html__( 'Social Links', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_tm_soc1_icon',
			[
				'label'   => esc_html__( 'Social Icon 1', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [ 'value' => 'fab fa-linkedin-in', 'library' => 'fa-brands' ],
			]
		);

		$repeater->add_control(
			'awea_tm_soc1_url',
			[
				'label'       => esc_html__( 'Social Link 1', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://linkedin.com',
				'default'     => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_tm_soc2_icon',
			[
				'label'     => esc_html__( 'Social Icon 2', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'separator' => 'before',
				'default'   => [ 'value' => 'fab fa-x-twitter', 'library' => 'fa-brands' ],
			]
		);

		$repeater->add_control(
			'awea_tm_soc2_url',
			[
				'label'       => esc_html__( 'Social Link 2', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://x.com',
				'default'     => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_tm_soc3_icon',
			[
				'label'     => esc_html__( 'Social Icon 3', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'separator' => 'before',
				'default'   => [ 'value' => 'fab fa-github', 'library' => 'fa-brands' ],
			]
		);

		$repeater->add_control(
			'awea_tm_soc3_url',
			[
				'label'       => esc_html__( 'Social Link 3', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://github.com',
				'default'     => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_tm_soc4_icon',
			[
				'label'     => esc_html__( 'Social Icon 4', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'awea_tm_soc4_url',
			[
				'label'       => esc_html__( 'Social Link 4', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: COLORS ---
		$repeater->start_controls_tab(
			'awea_tm_tab_colors',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_tm_item_featured',
			[
				'label'        => esc_html__( 'Highlight This Member', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$repeater->add_control(
			'awea_tm_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-tm-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_tm_item_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_tm_item_border',
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
			'awea_tm_members',
			[
				'label'       => esc_html__( 'Members List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_tm_name }}} — {{{ awea_tm_role }}}',
				'default'     => [
					[
						'awea_tm_badge' => esc_html__( 'Design', 'awesome-widgets-elementor' ),
						'awea_tm_name'  => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
						'awea_tm_role'  => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
						'awea_tm_bio'   => esc_html__( 'Pioneering clean architectural design systems and responsive user interfaces.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_tm_badge'         => esc_html__( 'Engineering', 'awesome-widgets-elementor' ),
						'awea_tm_name'          => esc_html__( 'Elena Rostova', 'awesome-widgets-elementor' ),
						'awea_tm_role'          => esc_html__( 'Principal Systems Engineer', 'awesome-widgets-elementor' ),
						'awea_tm_bio'           => esc_html__( 'Building sub-millisecond frontend architectures and scalable cloud workflows.', 'awesome-widgets-elementor' ),
						'awea_tm_item_featured' => 'yes',
					],
					[
						'awea_tm_badge' => esc_html__( 'Product', 'awesome-widgets-elementor' ),
						'awea_tm_name'  => esc_html__( 'Marcus Thorne', 'awesome-widgets-elementor' ),
						'awea_tm_role'  => esc_html__( 'Head of Product Strategy', 'awesome-widgets-elementor' ),
						'awea_tm_bio'   => esc_html__( 'Turning complex customer problems into intuitive, high-impact digital products.', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. GRID & EFFECTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tm_section_layout',
			[
				'label' => esc_html__( 'Grid & Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_tm_card_style',
			[
				'label'        => esc_html__( 'Card Layout', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'overlay',
				'options'      => [
					'overlay'   => esc_html__( 'Overlay Info Box (On Photo)', 'awesome-widgets-elementor' ),
					'editorial' => esc_html__( 'Clean Card (Text Below Photo)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-tm-style-',
			]
		);

		$this->add_responsive_control(
			'awea_tm_columns',
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
					'{{WRAPPER}} .awea-tm-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tm_col_gap',
			[
				'label'      => esc_html__( 'Space Between Columns', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tm_row_gap',
			[
				'label'      => esc_html__( 'Space Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_tm_img_size',
				'default' => 'large',
			]
		);

		$this->add_responsive_control(
			'awea_tm_img_ratio',
			[
				'label'     => esc_html__( 'Photo Shape Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4/5',
				'options'   => [
					'1/1'  => '1:1 (Square)',
					'4/5'  => '4:5 (Portrait)',
					'3/4'  => '3:4 (Classic)',
					'16/9' => '16:9 (Widescreen)',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-tm-media' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tm_hover_motion',
			[
				'label'        => esc_html__( 'Card Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-tm-motion-',
			]
		);

		$this->add_control(
			'awea_tm_dock_visible',
			[
				'label'        => esc_html__( 'Always Show Social Icons', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [ 'awea_tm_card_style' => 'overlay' ],
				'prefix_class' => 'awea-tm-dock-open-',
			]
		);

		$this->add_control(
			'awea_tm_name_tag',
			[
				'label'   => esc_html__( 'Name Heading Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
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
			'awea_tm_style_card',
			[
				'label' => esc_html__( 'Card Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_tm_card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tm_card_radius',
			[
				'label'      => esc_html__( 'Card Corner Roundness', 'awesome-widgets-elementor' ),
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
					'{{WRAPPER}} .awea-tm-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tm_photo_radius',
			[
				'label'      => esc_html__( 'Photo Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '14',
					'right'    => '14',
					'bottom'   => '14',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_tm_photo_filter',
				'label'    => esc_html__( 'Photo Filters', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-tm-media img',
			]
		);

		$this->start_controls_tabs( 'awea_tm_card_tabs' );

		$this->start_controls_tab(
			'awea_tm_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_tm_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-tm-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_tm_card_border',
				'selector'       => '{{WRAPPER}} .awea-tm-card',
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
				'name'     => 'awea_tm_card_shadow',
				'selector' => '{{WRAPPER}} .awea-tm-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_tm_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_tm_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-tm-card:hover',
			]
		);

		$this->add_control(
			'awea_tm_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-tm-card:hover' => 'border-color: var(--awea-tm-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_tm_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-tm-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. OVERLAY INFO BOX (OVERLAY MODE)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tm_style_panel',
			[
				'label'     => esc_html__( 'Overlay Info Box', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_tm_card_style' => 'overlay' ],
			]
		);

		$this->add_control(
			'awea_tm_dock_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea-tm-style-overlay .awea-tm-panel' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tm_dock_border',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea-tm-style-overlay .awea-tm-panel' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tm_dock_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'      => '18',
					'right'    => '18',
					'bottom'   => '18',
					'left'     => '18',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea-tm-style-overlay .awea-tm-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tm_dock_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '14',
					'right'    => '14',
					'bottom'   => '14',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea-tm-style-overlay .awea-tm-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT & TAG
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tm_style_text',
			[
				'label' => esc_html__( 'Text & Tag', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_tm_badge_heading',
			[
				'label' => esc_html__( 'Department Tag', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tm_badge_typo',
				'selector' => '{{WRAPPER}} .awea-tm-badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_tm_badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tm_badge_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tm_name_heading',
			[
				'label'     => esc_html__( 'Full Name', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_tm_name_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-name, {{WRAPPER}} .awea-tm-name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tm_name_typo',
				'selector' => '{{WRAPPER}} .awea-tm-name',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_tm_name_shadow',
				'selector' => '{{WRAPPER}} .awea-tm-name',
			]
		);

		$this->add_control(
			'awea_tm_role_heading',
			[
				'label'     => esc_html__( 'Job Title', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_tm_role_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-role' => 'color: var(--awea-tm-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tm_role_typo',
				'selector' => '{{WRAPPER}} .awea-tm-role',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_tm_bio_heading',
			[
				'label'     => esc_html__( 'Short Bio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_tm_bio_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-bio' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tm_bio_typo',
				'selector' => '{{WRAPPER}} .awea-tm-bio',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. SOCIAL BUTTONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tm_style_socials',
			[
				'label' => esc_html__( 'Social Buttons', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_tm_soc_size',
			[
				'label'      => esc_html__( 'Button Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 28, 'max' => 54 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 36 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-soc-btn' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tm_soc_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 26 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-soc-btn i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-tm-soc-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tm_soc_gap',
			[
				'label'      => esc_html__( 'Space Between Icons', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 20 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-tm-socials' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tm_soc_radius',
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
					'{{WRAPPER}} .awea-tm-soc-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_tm_soc_tabs' );

		$this->start_controls_tab(
			'awea_tm_soc_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_tm_soc_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-soc-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tm_soc_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-soc-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_tm_soc_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_tm_soc_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-tm-soc-btn:hover, {{WRAPPER}} .awea-tm-soc-btn:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tm_soc_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-tm-soc-btn:hover, {{WRAPPER}} .awea-tm-soc-btn:focus-visible' => 'background-color: var(--awea-tm-item-accent, {{VALUE}}); border-color: var(--awea-tm-item-accent, {{VALUE}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$members  = $settings['awea_tm_members'] ?? [];
		$name_tag = Utils::validate_html_tag( $settings['awea_tm_name_tag'] ?? 'h3' );

		if ( empty( $members ) ) {
			return;
		}
		?>
		<div class="awea-tm-grid">
			<?php foreach ( $members as $index => $member ) :
				$id          = $member['_id'] ?? $index;
				$badge       = $member['awea_tm_badge'] ?? '';
				$name        = $member['awea_tm_name'] ?? '';
				$role        = $member['awea_tm_role'] ?? '';
				$bio         = $member['awea_tm_bio'] ?? '';
				$featured    = 'yes' === ( $member['awea_tm_item_featured'] ?? '' );
				$has_profile = ! empty( $member['awea_tm_profile_url']['url'] );
				$prof_key    = 'awea_tm_prof_' . $id;

				$name_setting_key = $this->get_repeater_setting_key( 'awea_tm_name', 'awea_tm_members', $index );
				$role_setting_key = $this->get_repeater_setting_key( 'awea_tm_role', 'awea_tm_members', $index );
				$bio_setting_key  = $this->get_repeater_setting_key( 'awea_tm_bio', 'awea_tm_members', $index );

				$this->add_inline_editing_attributes( $name_setting_key, 'none' );
				$this->add_inline_editing_attributes( $role_setting_key, 'none' );
				$this->add_inline_editing_attributes( $bio_setting_key, 'basic' );

				$this->add_render_attribute( $name_setting_key, 'class', 'awea-tm-name' );
				$this->add_render_attribute( $role_setting_key, 'class', 'awea-tm-role' );
				$this->add_render_attribute( $bio_setting_key, 'class', 'awea-tm-bio' );

				if ( $has_profile ) {
					$this->add_link_attributes( $prof_key, $member['awea_tm_profile_url'] );
				}

				$card_classes = [
					'awea-tm-card',
					'elementor-repeater-item-' . esc_attr( $id ),
				];
				if ( $featured ) {
					$card_classes[] = 'awea-tm-featured';
				}

				$img_data = [
					'awea_tm_photo'                     => $member['awea_tm_photo'] ?? [],
					'awea_tm_img_size_size'             => $settings['awea_tm_img_size_size'] ?? 'large',
					'awea_tm_img_size_custom_dimension' => $settings['awea_tm_img_size_custom_dimension'] ?? [],
				];

				// Collect active social links (1..4)
				$socials = [];
				for ( $s = 1; $s <= 4; $s++ ) {
					$ico = $member[ "awea_tm_soc{$s}_icon" ] ?? [];
					$url = $member[ "awea_tm_soc{$s}_url" ] ?? [];
					if ( ! empty( $ico['value'] ) && ! empty( $url['url'] ) ) {
						$socials[] = [
							'icon' => $ico,
							'url'  => $url,
							'key'  => "awea_tm_soc_{$id}_{$s}",
						];
					}
				}
				?>
				<article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

					<div class="awea-tm-media">
						<?php echo Group_Control_Image_Size::get_attachment_image_html( $img_data, 'awea_tm_img_size', 'awea_tm_photo' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<div class="awea-tm-scrim" aria-hidden="true"></div>

						<?php if ( ! empty( $badge ) ) : ?>
							<span class="awea-tm-badge"><?php echo esc_html( $badge ); ?></span>
						<?php endif; ?>
					</div>

					<div class="awea-tm-panel">
						<?php if ( ! empty( $name ) ) : ?>
							<<?php Utils::print_validated_html_tag( $name_tag ); ?> <?php $this->print_render_attribute_string( $name_setting_key ); ?>>
								<?php if ( $has_profile ) : ?>
									<a <?php $this->print_render_attribute_string( $prof_key ); ?>>
										<?php echo esc_html( $name ); ?>
									</a>
								<?php else : ?>
									<?php echo esc_html( $name ); ?>
								<?php endif; ?>
							</<?php Utils::print_validated_html_tag( $name_tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $role ) ) : ?>
							<span <?php $this->print_render_attribute_string( $role_setting_key ); ?>>
								<?php echo esc_html( $role ); ?>
							</span>
						<?php endif; ?>

						<?php if ( ! empty( $bio ) ) : ?>
							<p <?php $this->print_render_attribute_string( $bio_setting_key ); ?>>
								<?php echo wp_kses_post( $bio ); ?>
							</p>
						<?php endif; ?>

						<?php if ( ! empty( $socials ) ) : ?>
							<div class="awea-tm-socials">
								<?php foreach ( $socials as $soc ) :
									$this->add_link_attributes( $soc['key'], $soc['url'] );
									$this->add_render_attribute( $soc['key'], 'class', 'awea-tm-soc-btn' );
									$this->add_render_attribute( $soc['key'], 'aria-label', esc_attr( ! empty( $name ) ? $name : esc_html__( 'Social link', 'awesome-widgets-elementor' ) ) );
									?>
									<a <?php $this->print_render_attribute_string( $soc['key'] ); ?>>
										<?php Icons_Manager::render_icon( $soc['icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>

				</article>
			<?php endforeach; ?>
		</div>
		<?php
	}
}