<?php
/**
 * Awesome Team Carousel Widget.
 *
 * @package AwesomeWidgetsElementor
 * @since   2.5.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Widget_Awesome_Team_Carousel extends Widget_Base {

	public function get_name() {
		return 'awesome-team-carousel';
	}

	public function get_title() {
		return esc_html__( 'Team Carousel', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'awea-icon eicon-carousel';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'team', 'carousel', 'slider', 'member', 'profile', 'staff' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. TEAM MEMBERS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tc_section_items',
			[
				'label' => esc_html__( 'Team Members', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'awea_tc_member_tabs' );

		// --- TAB 1: PROFILE ---
		$repeater->start_controls_tab(
			'awea_tc_tab_profile',
			[ 'label' => esc_html__( 'Profile', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_tc_image',
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
			'awea_tc_badge',
			[
				'label'       => esc_html__( 'Department Tag', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Leadership', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_tc_name',
			[
				'label'       => esc_html__( 'Full Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_tc_role',
			[
				'label'       => esc_html__( 'Job Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_tc_bio',
			[
				'label'   => esc_html__( 'Short Bio', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( 'Pioneering clean architectural design systems and kinetic user interfaces.', 'awesome-widgets-elementor' ),
			]
		);

		$repeater->add_control(
			'awea_tc_profile_url',
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
			'awea_tc_tab_socials',
			[ 'label' => esc_html__( 'Social Links', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_tc_ln_url',
			[
				'label'       => esc_html__( 'LinkedIn URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://linkedin.com/in/username',
				'default'     => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_tc_tw_url',
			[
				'label'       => esc_html__( 'X (Twitter) URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://x.com/username',
				'default'     => [ 'url' => '#' ],
			]
		);

		$repeater->add_control(
			'awea_tc_fb_url',
			[
				'label'       => esc_html__( 'Facebook URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://facebook.com/username',
			]
		);

		$repeater->add_control(
			'awea_tc_insta_url',
			[
				'label'       => esc_html__( 'Instagram URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://instagram.com/username',
			]
		);

		$repeater->end_controls_tab();

		// --- TAB 3: COLORS ---
		$repeater->start_controls_tab(
			'awea_tc_tab_colors',
			[ 'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ) ]
		);

		$repeater->add_control(
			'awea_tc_item_accent',
			[
				'label'     => esc_html__( 'Main Theme Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-tc-item-accent: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_tc_item_bg',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'awea_tc_item_border',
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
			'awea_tc_members',
			[
				'label'       => esc_html__( 'Members List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_tc_name }}} — {{{ awea_tc_role }}}',
				'default'     => [
					[
						'awea_tc_badge' => esc_html__( 'Design', 'awesome-widgets-elementor' ),
						'awea_tc_name'  => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
						'awea_tc_role'  => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
						'awea_tc_bio'   => esc_html__( 'Pioneering clean architectural design systems and kinetic interfaces.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_tc_badge' => esc_html__( 'Product', 'awesome-widgets-elementor' ),
						'awea_tc_name'  => esc_html__( 'Elena Rostova', 'awesome-widgets-elementor' ),
						'awea_tc_role'  => esc_html__( 'Senior Product Designer', 'awesome-widgets-elementor' ),
						'awea_tc_bio'   => esc_html__( 'Specializing in design tokens, accessible color theory, and user journeys.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_tc_badge' => esc_html__( 'Engineering', 'awesome-widgets-elementor' ),
						'awea_tc_name'  => esc_html__( 'Julian Szekeres', 'awesome-widgets-elementor' ),
						'awea_tc_role'  => esc_html__( 'Core Systems Engineer', 'awesome-widgets-elementor' ),
						'awea_tc_bio'   => esc_html__( 'Optimizing micro-service pipelines and real-time state hydration routines.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_tc_badge' => esc_html__( 'Strategy', 'awesome-widgets-elementor' ),
						'awea_tc_name'  => esc_html__( 'Marcus Thorne', 'awesome-widgets-elementor' ),
						'awea_tc_role'  => esc_html__( 'Head of Product Strategy', 'awesome-widgets-elementor' ),
						'awea_tc_bio'   => esc_html__( 'Turning complex customer problems into intuitive, high-impact digital products.', 'awesome-widgets-elementor' ),
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. CARD LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tc_section_settings',
			[
				'label' => esc_html__( 'Card Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_tc_card_style',
			[
				'label'        => esc_html__( 'Card Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'overlay',
				'options'      => [
					'overlay'   => esc_html__( 'Overlay Info Box (On Photo)', 'awesome-widgets-elementor' ),
					'editorial' => esc_html__( 'Clean Card (Text Below Photo)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-tc-style-',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_tc_img_size',
				'default' => 'large',
			]
		);

		$this->add_control(
			'awea_tc_name_tag',
			[
				'label'   => esc_html__( 'Name Heading Tag', 'awesome-widgets-elementor' ),
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

		$this->add_control(
			'awea_tc_social_always_visible',
			[
				'label'        => esc_html__( 'Always Show Social Icons', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [ 'awea_tc_card_style' => 'overlay' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. CAROUSEL SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tc_section_slider',
			[
				'label' => esc_html__( 'Carousel Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_tc_slides_to_show',
			[
				'label'          => esc_html__( 'Slides to Show', 'awesome-widgets-elementor' ),
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
				],
			]
		);

		$this->add_responsive_control(
			'awea_tc_slide_gap',
			[
				'label'      => esc_html__( 'Space Between Slides', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
			]
		);

		$this->add_control(
			'awea_tc_show_arrows',
			[
				'label'        => esc_html__( 'Show Navigation Arrows', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_tc_show_dots',
			[
				'label'        => esc_html__( 'Show Pagination Dots', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_tc_loop',
			[
				'label'        => esc_html__( 'Infinite Loop', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_tc_autoplay',
			[
				'label'        => esc_html__( 'Autoplay Slides', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_tc_pause_on_hover',
			[
				'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_tc_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_tc_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'max'       => 15000,
				'condition' => [ 'awea_tc_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_tc_animation_speed',
			[
				'label'   => esc_html__( 'Slide Speed (ms)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 450,
				'min'     => 150,
				'max'     => 2000,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tc_style_card',
			[
				'label' => esc_html__( 'Card Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_tc_aspect_ratio',
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
					'{{WRAPPER}} .awea-team-img-container' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tc_card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-team-master-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tc_card_radius',
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
					'{{WRAPPER}} .awea-team-master-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tc_photo_radius',
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
					'{{WRAPPER}} .awea-team-img-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_tc_photo_filter',
				'label'    => esc_html__( 'Photo Filters', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-team-img-container img',
			]
		);

		$this->start_controls_tabs( 'awea_tc_card_tabs' );

		$this->start_controls_tab(
			'awea_tc_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_tc_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-team-master-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_tc_card_border',
				'selector'       => '{{WRAPPER}} .awea-team-master-card',
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
				'name'     => 'awea_tc_card_shadow',
				'selector' => '{{WRAPPER}} .awea-team-master-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_tc_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_tc_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-team-master-card:hover',
			]
		);

		$this->add_control(
			'awea_tc_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-team-master-card:hover' => 'border-color: var(--awea-tc-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_tc_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-team-master-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. OVERLAY INFO BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tc_style_dock',
			[
				'label'     => esc_html__( 'Overlay Info Box', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_tc_card_style' => 'overlay' ],
			]
		);

		$this->add_control(
			'awea_tc_dock_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea-tc-style-overlay .awea-team-info-panel' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_tc_dock_border',
				'selector' => '{{WRAPPER}}.awea-tc-style-overlay .awea-team-info-panel',
			]
		);

		$this->add_responsive_control(
			'awea_tc_dock_padding',
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
					'{{WRAPPER}}.awea-tc-style-overlay .awea-team-info-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_tc_dock_radius',
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
					'{{WRAPPER}}.awea-tc-style-overlay .awea-team-info-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT & TAG
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tc_style_text',
			[
				'label' => esc_html__( 'Text & Tag', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_tc_name_color',
			[
				'label'     => esc_html__( 'Full Name Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-team-name, {{WRAPPER}} .awea-team-name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tc_name_typo',
				'selector' => '{{WRAPPER}} .awea-team-name',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_tc_name_shadow',
				'selector' => '{{WRAPPER}} .awea-team-name',
			]
		);

		$this->add_control(
			'awea_tc_role_color',
			[
				'label'     => esc_html__( 'Job Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-team-role' => 'color: var(--awea-tc-item-accent, {{VALUE}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tc_role_typo',
				'selector' => '{{WRAPPER}} .awea-team-role',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_tc_bio_color',
			[
				'label'     => esc_html__( 'Short Bio Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-team-bio' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_tc_bio_typo',
				'selector' => '{{WRAPPER}} .awea-team-bio',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. ARROWS & DOTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_tc_style_arrows',
			[
				'label' => esc_html__( 'Arrows & Dots', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_tc_arrow_size',
			[
				'label'      => esc_html__( 'Arrow Button Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 42 ],
				'condition'  => [ 'awea_tc_show_arrows' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-carousel-arrow-border' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_tc_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_tc_show_arrows' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tc_arrow_bg',
			[
				'label'     => esc_html__( 'Arrow Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_tc_show_arrows' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'awea_tc_arrow_border',
				'selector'  => '{{WRAPPER}} .awea-carousel-arrow-border',
				'condition' => [ 'awea_tc_show_arrows' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_tc_dots_color',
			[
				'label'     => esc_html__( 'Dot Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'condition' => [ 'awea_tc_show_dots' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-team-carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_tc_dots_active_color',
			[
				'label'     => esc_html__( 'Active Dot Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_tc_show_dots' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-team-carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings      = $this->get_settings_for_display();
		$members       = $settings['awea_tc_members'] ?? [];
		$items_desktop = ! empty( $settings['awea_tc_slides_to_show'] ) ? (int) $settings['awea_tc_slides_to_show'] : 3;
		$items_tablet  = ! empty( $settings['awea_tc_slides_to_show_tablet'] ) ? (int) $settings['awea_tc_slides_to_show_tablet'] : 2;
		$items_mobile  = ! empty( $settings['awea_tc_slides_to_show_mobile'] ) ? (int) $settings['awea_tc_slides_to_show_mobile'] : 1;

		$gap_desktop = isset( $settings['awea_tc_slide_gap']['size'] ) ? (int) $settings['awea_tc_slide_gap']['size'] : 24;
		$gap_tablet  = isset( $settings['awea_tc_slide_gap_tablet']['size'] ) ? (int) $settings['awea_tc_slide_gap_tablet']['size'] : 20;
		$gap_mobile  = isset( $settings['awea_tc_slide_gap_mobile']['size'] ) ? (int) $settings['awea_tc_slide_gap_mobile']['size'] : 16;

		$show_arrows = ( 'yes' === ( $settings['awea_tc_show_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
		$show_dots   = ( 'yes' === ( $settings['awea_tc_show_dots'] ?? 'no' ) ) ? 'yes' : 'no';
		$loop        = ( 'yes' === ( $settings['awea_tc_loop'] ?? 'no' ) ) ? 'yes' : 'no';
		$autoplay    = ( 'yes' === ( $settings['awea_tc_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
		$pause       = ( 'yes' === ( $settings['awea_tc_pause_on_hover'] ?? 'yes' ) ) ? 'yes' : 'no';
		$auto_speed  = ! empty( $settings['awea_tc_autoplay_speed'] ) ? (int) $settings['awea_tc_autoplay_speed'] : 5000;
		$anim_speed  = ! empty( $settings['awea_tc_animation_speed'] ) ? (int) $settings['awea_tc_animation_speed'] : 450;

		$always_visible = ( 'yes' === ( $settings['awea_tc_social_always_visible'] ?? 'no' ) );
		$name_tag       = Utils::validate_html_tag( $settings['awea_tc_name_tag'] ?? 'h3' );
		$widget_id      = $this->get_id();

		if ( empty( $members ) ) {
			return;
		}

		$card_classes = [ 'awea-team-master-card' ];
		if ( $always_visible ) {
			$card_classes[] = 'awea-social-always-visible';
		}
		?>
		<div class="awea-team-carousel-wrapper" id="awea-tc-<?php echo esc_attr( $widget_id ); ?>">
			<div class="awea-team-carousel owl-carousel"
				 data-items-desktop="<?php echo esc_attr( $items_desktop ); ?>"
				 data-items-tablet="<?php echo esc_attr( $items_tablet ); ?>"
				 data-items-mobile="<?php echo esc_attr( $items_mobile ); ?>"
				 data-gap-desktop="<?php echo esc_attr( $gap_desktop ); ?>"
				 data-gap-tablet="<?php echo esc_attr( $gap_tablet ); ?>"
				 data-gap-mobile="<?php echo esc_attr( $gap_mobile ); ?>"
				 data-arrows="<?php echo esc_attr( $show_arrows ); ?>"
				 data-dots="<?php echo esc_attr( $show_dots ); ?>"
				 data-loop="<?php echo esc_attr( $loop ); ?>"
				 data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
				 data-pause="<?php echo esc_attr( $pause ); ?>"
				 data-speed="<?php echo esc_attr( $anim_speed ); ?>"
				 data-timeout="<?php echo esc_attr( $auto_speed ); ?>">

				<?php foreach ( $members as $index => $member ) :
					$id          = $member['_id'] ?? $index;
					$badge       = $member['awea_tc_badge'] ?? '';
					$name        = $member['awea_tc_name'] ?? '';
					$role        = $member['awea_tc_role'] ?? '';
					$bio         = $member['awea_tc_bio'] ?? '';
					$has_profile = ! empty( $member['awea_tc_profile_url']['url'] );
					$prof_key    = 'awea_tc_prof_' . $id;

					if ( $has_profile ) {
						$this->add_link_attributes( $prof_key, $member['awea_tc_profile_url'] );
					}

					$img_data = [
						'awea_tc_image'                     => $member['awea_tc_image'] ?? [],
						'awea_tc_img_size_size'             => $settings['awea_tc_img_size_size'] ?? 'large',
						'awea_tc_img_size_custom_dimension' => $settings['awea_tc_img_size_custom_dimension'] ?? [],
					];

					$socials = [];
					foreach ( [ 'ln', 'tw', 'fb', 'insta' ] as $soc_key ) {
						$url_data = $member[ 'awea_tc_' . $soc_key . '_url' ] ?? [];
						if ( ! empty( $url_data['url'] ) ) {
							$brands = [
								'ln'    => [ 'icon' => 'fab fa-linkedin-in', 'title' => 'LinkedIn', 'brand' => '#0a66c2' ],
								'tw'    => [ 'icon' => 'fab fa-x-twitter', 'title' => 'X (Twitter)', 'brand' => '#000000' ],
								'fb'    => [ 'icon' => 'fab fa-facebook-f', 'title' => 'Facebook', 'brand' => '#1877f2' ],
								'insta' => [ 'icon' => 'fab fa-instagram', 'title' => 'Instagram', 'brand' => '#e4405f' ],
							];
							$socials[] = [
								'url'   => $url_data,
								'icon'  => $brands[ $soc_key ]['icon'],
								'title' => $brands[ $soc_key ]['title'],
								'brand' => $brands[ $soc_key ]['brand'],
								'key'   => 'awea_tc_soc_' . $id . '_' . $soc_key,
							];
						}
					}

					$item_card_classes   = $card_classes;
					$item_card_classes[] = 'elementor-repeater-item-' . esc_attr( $id );
					?>
					<article class="<?php echo esc_attr( implode( ' ', $item_card_classes ) ); ?>">
						<div class="awea-team-img-container">
							<?php echo Group_Control_Image_Size::get_attachment_image_html( $img_data, 'awea_tc_img_size', 'awea_tc_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<div class="awea-team-scrim" aria-hidden="true"></div>

							<?php if ( ! empty( $badge ) ) : ?>
								<span class="awea-team-badge"><?php echo esc_html( $badge ); ?></span>
							<?php endif; ?>
						</div>

						<div class="awea-team-info-panel">
							<?php if ( ! empty( $name ) ) : ?>
								<<?php Utils::print_validated_html_tag( $name_tag ); ?> class="awea-team-name">
									<?php if ( $has_profile ) : ?>
										<a <?php $this->print_render_attribute_string( $prof_key ); ?>><?php echo esc_html( $name ); ?></a>
									<?php else : ?>
										<?php echo esc_html( $name ); ?>
									<?php endif; ?>
								</<?php Utils::print_validated_html_tag( $name_tag ); ?>>
							<?php endif; ?>

							<?php if ( ! empty( $role ) ) : ?>
								<span class="awea-team-role"><?php echo esc_html( $role ); ?></span>
							<?php endif; ?>

							<?php if ( ! empty( $bio ) ) : ?>
								<p class="awea-team-bio"><?php echo wp_kses_post( $bio ); ?></p>
							<?php endif; ?>

							<?php if ( ! empty( $socials ) ) : ?>
								<div class="awea-team-social-dock">
									<?php foreach ( $socials as $soc ) :
										$this->add_link_attributes( $soc['key'], $soc['url'] );
										$this->add_render_attribute( $soc['key'], 'class', 'awea-team-social-btn' );
										$this->add_render_attribute( $soc['key'], 'aria-label', esc_attr( $soc['title'] ) );
										$this->add_render_attribute( $soc['key'], 'style', '--awea-social-brand: ' . esc_attr( $soc['brand'] ) . ';' );
										?>
										<a <?php $this->print_render_attribute_string( $soc['key'] ); ?>>
											<i class="<?php echo esc_attr( $soc['icon'] ); ?>" aria-hidden="true"></i>
										</a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>

			</div>
		</div>

		<script>
		jQuery(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction('frontend/element_ready/awesome-team-carousel.default', function ($scope) {
				var $carousel = $scope.find('.awea-team-carousel');
				if (!$carousel.length || typeof $carousel.owlCarousel !== 'function') return;

				var itemsDesktop = parseInt($carousel.data('items-desktop'), 10) || 3;
				var itemsTablet  = parseInt($carousel.data('items-tablet'), 10) || 2;
				var itemsMobile  = parseInt($carousel.data('items-mobile'), 10) || 1;
				var gapDesktop   = parseInt($carousel.data('gap-desktop'), 10) || 24;
				var gapTablet    = parseInt($carousel.data('gap-tablet'), 10) || 20;
				var gapMobile    = parseInt($carousel.data('gap-mobile'), 10) || 16;
				var isRtl        = document.dir === 'rtl' || document.documentElement.dir === 'rtl';

				$carousel.owlCarousel({
					rtl: isRtl,
					nav: $carousel.data('arrows') === 'yes',
					dots: $carousel.data('dots') === 'yes',
					loop: $carousel.data('loop') === 'yes',
					autoplay: $carousel.data('autoplay') === 'yes',
					autoplayTimeout: parseInt($carousel.data('timeout'), 10) || 5000,
					smartSpeed: parseInt($carousel.data('speed'), 10) || 450,
					autoplayHoverPause: $carousel.data('pause') === 'yes',
					navText: [
						'<div class="awea-carousel-arrow-border" aria-label="Previous"><i class="fas fa-chevron-left"></i></div>',
						'<div class="awea-carousel-arrow-border" aria-label="Next"><i class="fas fa-chevron-right"></i></div>'
					],
					responsive: {
						0: { items: itemsMobile, margin: gapMobile },
						768: { items: itemsTablet, margin: gapTablet },
						1025: { items: itemsDesktop, margin: gapDesktop }
					}
				});
			});
		});
		</script>
		<?php
	}
}