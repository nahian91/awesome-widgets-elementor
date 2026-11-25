<?php
/**
 * Awesome Post Carousel Widget.
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
use Elementor\Utils;

class Widget_Awesome_Post_Carousel extends Widget_Base {

	public function get_name() {
		return 'awesome-post-carousel';
	}

	public function get_title() {
		return esc_html__( 'Post Carousel', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'post', 'carousel', 'slider', 'blog', 'articles', 'feed', 'news' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. POST QUERY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pc_section_query',
			[
				'label' => esc_html__( 'Post Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_pc_posts_per_page',
			[
				'label'   => esc_html__( 'Number of Posts', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 50,
			]
		);

		$cat_options = [];
		$categories  = get_categories( [ 'hide_empty' => false ] );
		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			foreach ( $categories as $cat ) {
				$cat_options[ $cat->term_id ] = $cat->name;
			}
		}

		$this->add_control(
			'awea_pc_include_categories',
			[
				'label'       => esc_html__( 'Filter by Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
			]
		);

		$this->add_control(
			'awea_pc_post_orderby',
			[
				'label'   => esc_html__( 'Sort By', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'          => esc_html__( 'Publish Date', 'awesome-widgets-elementor' ),
					'title'         => esc_html__( 'Post Title', 'awesome-widgets-elementor' ),
					'modified'      => esc_html__( 'Last Updated', 'awesome-widgets-elementor' ),
					'comment_count' => esc_html__( 'Comment Count', 'awesome-widgets-elementor' ),
					'rand'          => esc_html__( 'Random Order', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_pc_post_order',
			[
				'label'   => esc_html__( 'Sort Direction', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Newest First (Descending)', 'awesome-widgets-elementor' ),
					'ASC'  => esc_html__( 'Oldest First (Ascending)', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_pc_post_offset',
			[
				'label'   => esc_html__( 'Skip Posts (Offset)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => 0,
				'max'     => 50,
			]
		);

		$this->add_control(
			'awea_pc_exclude_current',
			[
				'label'        => esc_html__( 'Hide Current Post', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. CARD ELEMENTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pc_section_elements',
			[
				'label' => esc_html__( 'Card Elements', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_pc_show_image',
			[
				'label'        => esc_html__( 'Show Featured Image', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_pc_show_category',
			[
				'label'        => esc_html__( 'Show Category Tag', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_pc_show_image' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pc_show_author',
			[
				'label'        => esc_html__( 'Show Author Name', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_pc_show_date',
			[
				'label'        => esc_html__( 'Show Publish Date', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_pc_show_reading_time',
			[
				'label'        => esc_html__( 'Show Read Time', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_pc_show_excerpt',
			[
				'label'        => esc_html__( 'Show Summary', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_pc_excerpt_length',
			[
				'label'     => esc_html__( 'Summary Word Limit', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 14,
				'min'       => 5,
				'max'       => 100,
				'condition' => [ 'awea_pc_show_excerpt' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pc_show_button',
			[
				'label'        => esc_html__( 'Show Read Button', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_pc_button_text',
			[
				'label'     => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read Article', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_pc_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pc_show_counter',
			[
				'label'        => esc_html__( 'Show Post Number (01, 02)', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_pc_title_tag',
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

		$this->add_control(
			'awea_pc_accent_bar',
			[
				'label'        => esc_html__( 'Color Line', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'none',
				'options'      => [
					'none'         => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'top-hover'    => esc_html__( 'Top Line (On Hover)', 'awesome-widgets-elementor' ),
					'top-always'   => esc_html__( 'Top Line (Always Show)', 'awesome-widgets-elementor' ),
					'bottom-hover' => esc_html__( 'Bottom Line (On Hover)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-pc-bar-',
				'separator'    => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. CAROUSEL SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pc_section_carousel',
			[
				'label' => esc_html__( 'Carousel Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_pc_slides_per_view',
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
				],
			]
		);

		$this->add_responsive_control(
			'awea_pc_slide_gap',
			[
				'label'      => esc_html__( 'Space Between Slides', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
			]
		);

		$this->add_control(
			'awea_pc_carousel_arrows',
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
			'awea_pc_carousel_dots',
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
			'awea_pc_carousel_loop',
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
			'awea_pc_carousel_autoplay',
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
			'awea_pc_pause_on_hover',
			[
				'label'        => esc_html__( 'Pause on Hover', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_pc_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pc_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'min'       => 1000,
				'max'       => 15000,
				'step'      => 500,
				'condition' => [ 'awea_pc_carousel_autoplay' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pc_animation_speed',
			[
				'label'   => esc_html__( 'Slide Speed (ms)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 450,
				'min'     => 100,
				'max'     => 2000,
				'step'    => 50,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. CARD BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pc_style_card',
			[
				'label' => esc_html__( 'Card Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_pc_card_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '24',
					'right'    => '24',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pc_card_radius',
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
					'{{WRAPPER}} .awea-blog-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_pc_accent_bar_color',
			[
				'label'     => esc_html__( 'Color Line', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_pc_accent_bar!' => 'none' ],
				'selectors' => [
					'{{WRAPPER}} .awea-pc-accent-bar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_pc_card_tabs' );

		$this->start_controls_tab(
			'awea_pc_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pc_card_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-blog-card',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_pc_card_border',
				'selector'       => '{{WRAPPER}} .awea-blog-card',
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
				'name'     => 'awea_pc_card_shadow',
				'selector' => '{{WRAPPER}} .awea-blog-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_pc_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pc_card_bg_hover_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-blog-card:hover',
			]
		);

		$this->add_control(
			'awea_pc_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_pc_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-blog-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. POST IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pc_style_image',
			[
				'label'     => esc_html__( 'Post Image', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_pc_show_image' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'awea_pc_image_size',
				'default' => 'large',
			]
		);

		$this->add_responsive_control(
			'awea_pc_img_ratio',
			[
				'label'     => esc_html__( 'Image Shape Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '16/10',
				'options'   => [
					'16/10' => '16:10 (Standard)',
					'16/9'  => '16:9 (Widescreen)',
					'4/3'   => '4:3 (Classic)',
					'1/1'   => '1:1 (Square)',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-img-wrap' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pc_img_radius',
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
					'{{WRAPPER}} .awea-blog-img-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pc_img_space',
			[
				'label'      => esc_html__( 'Space Below Image', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-img-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_pc_img_filter',
				'label'    => esc_html__( 'Image Filters', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-blog-img',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. CATEGORY TAG
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pc_style_badge',
			[
				'label'     => esc_html__( 'Category Tag', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_pc_show_image'    => 'yes',
					'awea_pc_show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'awea_pc_badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-blog-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pc_badge_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pc_badge_typo',
				'selector' => '{{WRAPPER}} .awea-blog-badge',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. TEXT & META
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pc_style_text',
			[
				'label' => esc_html__( 'Text & Meta', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_pc_meta_color',
			[
				'label'     => esc_html__( 'Date & Author Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pc_meta_typo',
				'label'    => esc_html__( 'Date & Author Font', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-blog-meta',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_pc_title_color',
			[
				'label'     => esc_html__( 'Heading Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-blog-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pc_title_hover',
			[
				'label'     => esc_html__( 'Heading Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-card:hover .awea-blog-title a, {{WRAPPER}} .awea-blog-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pc_title_typo',
				'label'    => esc_html__( 'Heading Font', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-blog-title a',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_pc_title_shadow',
				'selector' => '{{WRAPPER}} .awea-blog-title',
			]
		);

		$this->add_control(
			'awea_pc_desc_color',
			[
				'label'     => esc_html__( 'Summary Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-blog-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pc_desc_typo',
				'label'    => esc_html__( 'Summary Font', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-blog-desc',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 5. BUTTON & NUMBER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pc_style_button',
			[
				'label' => esc_html__( 'Button & Number', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_pc_btn_typo',
				'selector'  => '{{WRAPPER}} .awea-blog-link',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
				'condition' => [ 'awea_pc_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pc_btn_color',
			[
				'label'     => esc_html__( 'Button Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-link' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_pc_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pc_btn_bg',
			[
				'label'     => esc_html__( 'Button Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-blog-link' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'awea_pc_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pc_btn_hover_color',
			[
				'label'     => esc_html__( 'Button Hover Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-blog-card:hover .awea-blog-link, {{WRAPPER}} .awea-blog-link:hover' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_pc_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pc_btn_hover_bg',
			[
				'label'     => esc_html__( 'Button Hover Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-card:hover .awea-blog-link, {{WRAPPER}} .awea-blog-link:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'awea_pc_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pc_counter_color',
			[
				'label'     => esc_html__( 'Post Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-blog-num' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_pc_show_counter' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'awea_pc_counter_typo',
				'label'     => esc_html__( 'Post Number Font', 'awesome-widgets-elementor' ),
				'selector'  => '{{WRAPPER}} .awea-blog-num',
				'global'    => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
				'condition' => [ 'awea_pc_show_counter' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 6. ARROWS & DOTS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pc_style_arrows',
			[
				'label' => esc_html__( 'Arrows & Dots', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_pc_arrow_size',
			[
				'label'      => esc_html__( 'Arrow Button Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 42 ],
				'condition'  => [ 'awea_pc_carousel_arrows' => 'yes' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-carousel-arrow-border' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_pc_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'condition' => [ 'awea_pc_carousel_arrows' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pc_arrow_bg',
			[
				'label'     => esc_html__( 'Arrow Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 'awea_pc_carousel_arrows' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-carousel-arrow-border' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'awea_pc_arrow_border',
				'selector'  => '{{WRAPPER}} .awea-carousel-arrow-border',
				'condition' => [ 'awea_pc_carousel_arrows' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_pc_dots_color',
			[
				'label'     => esc_html__( 'Dot Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'condition' => [ 'awea_pc_carousel_dots' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel .owl-dots button.owl-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pc_dots_active_color',
			[
				'label'     => esc_html__( 'Active Dot Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'condition' => [ 'awea_pc_carousel_dots' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .awea-post-carousel .owl-dots button.owl-dot.active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$num_posts    = ! empty( $settings['awea_pc_posts_per_page'] ) ? absint( $settings['awea_pc_posts_per_page'] ) : 6;
		$order        = $settings['awea_pc_post_order'] ?? 'DESC';
		$orderby      = $settings['awea_pc_post_orderby'] ?? 'date';
		$categories   = $settings['awea_pc_include_categories'] ?? [];
		$offset       = absint( $settings['awea_pc_post_offset'] ?? 0 );
		$exclude_curr = 'yes' === ( $settings['awea_pc_exclude_current'] ?? 'no' );
		$show_img     = 'yes' === ( $settings['awea_pc_show_image'] ?? 'yes' );
		$show_cat     = 'yes' === ( $settings['awea_pc_show_category'] ?? 'no' );
		$show_author  = 'yes' === ( $settings['awea_pc_show_author'] ?? 'no' );
		$show_date    = 'yes' === ( $settings['awea_pc_show_date'] ?? 'no' );
		$show_read    = 'yes' === ( $settings['awea_pc_show_reading_time'] ?? 'no' );
		$show_exc     = 'yes' === ( $settings['awea_pc_show_excerpt'] ?? 'no' );
		$exc_len      = ! empty( $settings['awea_pc_excerpt_length'] ) ? absint( $settings['awea_pc_excerpt_length'] ) : 14;
		$show_btn     = 'yes' === ( $settings['awea_pc_show_button'] ?? 'no' );
		$btn_text     = $settings['awea_pc_button_text'] ?? esc_html__( 'Read Article', 'awesome-widgets-elementor' );
		$show_counter = 'yes' === ( $settings['awea_pc_show_counter'] ?? 'no' );
		$title_tag    = Utils::validate_html_tag( $settings['awea_pc_title_tag'] ?? 'h3' );
		$thumb_size   = $settings['awea_pc_image_size_size'] ?? 'large';

		$items_desktop = ! empty( $settings['awea_pc_slides_per_view'] ) ? (int) $settings['awea_pc_slides_per_view'] : 3;
		$items_tablet  = ! empty( $settings['awea_pc_slides_per_view_tablet'] ) ? (int) $settings['awea_pc_slides_per_view_tablet'] : 2;
		$items_mobile  = ! empty( $settings['awea_pc_slides_per_view_mobile'] ) ? (int) $settings['awea_pc_slides_per_view_mobile'] : 1;

		$gap_desktop = isset( $settings['awea_pc_slide_gap']['size'] ) ? (int) $settings['awea_pc_slide_gap']['size'] : 24;
		$gap_tablet  = isset( $settings['awea_pc_slide_gap_tablet']['size'] ) ? (int) $settings['awea_pc_slide_gap_tablet']['size'] : 20;
		$gap_mobile  = isset( $settings['awea_pc_slide_gap_mobile']['size'] ) ? (int) $settings['awea_pc_slide_gap_mobile']['size'] : 16;

		$arrows     = ( 'yes' === ( $settings['awea_pc_carousel_arrows'] ?? 'no' ) ) ? 'yes' : 'no';
		$dots       = ( 'yes' === ( $settings['awea_pc_carousel_dots'] ?? 'no' ) ) ? 'yes' : 'no';
		$loop       = ( 'yes' === ( $settings['awea_pc_carousel_loop'] ?? 'no' ) ) ? 'yes' : 'no';
		$autoplay   = ( 'yes' === ( $settings['awea_pc_carousel_autoplay'] ?? 'no' ) ) ? 'yes' : 'no';
		$pause      = ( 'yes' === ( $settings['awea_pc_pause_on_hover'] ?? 'yes' ) ) ? 'yes' : 'no';
		$auto_speed = ! empty( $settings['awea_pc_carousel_autoplay_speed'] ) ? absint( $settings['awea_pc_carousel_autoplay_speed'] ) : 5000;
		$anim_speed = ! empty( $settings['awea_pc_animation_speed'] ) ? absint( $settings['awea_pc_animation_speed'] ) : 450;
		$widget_id  = $this->get_id();

		$args = [
			'posts_per_page'      => $num_posts,
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'order'               => $order,
			'orderby'             => $orderby,
			'ignore_sticky_posts' => 1,
			'no_found_rows'       => true,
		];

		if ( $offset > 0 ) {
			$args['offset'] = $offset;
		}

		if ( $exclude_curr && is_singular() ) {
			// phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in
			$args['post__not_in'] = [ get_queried_object_id() ];
		}

		if ( ! empty( $categories ) && is_array( $categories ) ) {
			$args['category__in'] = array_map( 'absint', $categories );
		}

		$query = new \WP_Query( $args );
		?>
		<div class="awea-post-carousel-wrap">
			<div class="awea-post-carousel owl-carousel"
				 id="awea-carousel-<?php echo esc_attr( $widget_id ); ?>"
				 data-items-desktop="<?php echo esc_attr( $items_desktop ); ?>"
				 data-items-tablet="<?php echo esc_attr( $items_tablet ); ?>"
				 data-items-mobile="<?php echo esc_attr( $items_mobile ); ?>"
				 data-gap-desktop="<?php echo esc_attr( $gap_desktop ); ?>"
				 data-gap-tablet="<?php echo esc_attr( $gap_tablet ); ?>"
				 data-gap-mobile="<?php echo esc_attr( $gap_mobile ); ?>"
				 data-arrows="<?php echo esc_attr( $arrows ); ?>"
				 data-dots="<?php echo esc_attr( $dots ); ?>"
				 data-loop="<?php echo esc_attr( $loop ); ?>"
				 data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
				 data-pause="<?php echo esc_attr( $pause ); ?>"
				 data-speed="<?php echo esc_attr( (string) $anim_speed ); ?>"
				 data-timeout="<?php echo esc_attr( (string) $auto_speed ); ?>">

				<?php
				if ( $query->have_posts() ) :
					$counter = 1;
					while ( $query->have_posts() ) :
						$query->the_post();
						$plain_text   = trim( wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) ) );
						$words        = '' !== $plain_text ? preg_split( '/\s+/u', $plain_text, -1, PREG_SPLIT_NO_EMPTY ) : [];
						$word_count   = is_array( $words ) ? count( $words ) : 0;
						$reading_time = max( 1, (int) ceil( $word_count / 200 ) );
						$post_cats    = get_the_category();
						?>
						<div class="awea-post-slide">
							<article class="awea-blog-card">
								<span class="awea-pc-accent-bar" aria-hidden="true"></span>

								<?php if ( $show_img ) : ?>
									<div class="awea-blog-img-wrap">
										<?php if ( $show_cat && ! empty( $post_cats ) ) : ?>
											<a href="<?php echo esc_url( get_category_link( $post_cats[0]->term_id ) ); ?>" class="awea-blog-badge">
												<?php echo esc_html( $post_cats[0]->name ); ?>
											</a>
										<?php endif; ?>

										<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="awea-blog-img-link" aria-label="<?php the_title_attribute(); ?>">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( $thumb_size, [ 'class' => 'awea-blog-img', 'loading' => 'lazy' ] ); ?>
											<?php else : ?>
												<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" class="awea-blog-img" alt="<?php the_title_attribute(); ?>" loading="lazy" />
											<?php endif; ?>
										</a>
									</div>
								<?php endif; ?>

								<div class="awea-blog-body">
									<?php if ( $show_author || $show_date || $show_read ) : ?>
										<div class="awea-blog-meta">
											<?php if ( $show_author ) : ?>
												<span><?php echo esc_html( get_the_author() ); ?></span>
											<?php endif; ?>

											<?php if ( $show_author && ( $show_date || $show_read ) ) : ?>
												<span class="awea-meta-dot" aria-hidden="true">•</span>
											<?php endif; ?>

											<?php if ( $show_date ) : ?>
												<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
											<?php endif; ?>

											<?php if ( $show_date && $show_read ) : ?>
												<span class="awea-meta-dot" aria-hidden="true">•</span>
											<?php endif; ?>

											<?php if ( $show_read ) : ?>
												<span>
													<?php
													/* translators: %d: estimated reading time in minutes */
													echo esc_html( sprintf( __( '%d MIN READ', 'awesome-widgets-elementor' ), $reading_time ) );
													?>
												</span>
											<?php endif; ?>
										</div>
									<?php endif; ?>

									<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-blog-title">
										<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
									</<?php Utils::print_validated_html_tag( $title_tag ); ?>>

									<?php if ( $show_exc ) : ?>
										<p class="awea-blog-desc">
											<?php echo esc_html( wp_trim_words( get_the_excerpt(), $exc_len, '...' ) ); ?>
										</p>
									<?php endif; ?>
								</div>

								<?php if ( ( $show_btn && ! empty( $btn_text ) ) || $show_counter ) : ?>
									<div class="awea-blog-footer">
										<?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
											<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="awea-blog-link">
												<span><?php echo esc_html( $btn_text ); ?></span>
												<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
											</a>
										<?php endif; ?>

										<?php if ( $show_counter ) : ?>
											<span class="awea-blog-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $counter ) ); ?></span>
										<?php endif; ?>
									</div>
								<?php endif; ?>

							</article>
						</div>
						<?php
						$counter++;
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<p class="awea-no-posts"><?php esc_html_e( 'No posts found matching your criteria.', 'awesome-widgets-elementor' ); ?></p>
				<?php endif; ?>

			</div>
		</div>

		<script>
		jQuery(window).on('elementor/frontend/init', function () {
			elementorFrontend.hooks.addAction('frontend/element_ready/awesome-post-carousel.default', function ($scope) {
				var $carousel = $scope.find('.awea-post-carousel');
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
					},
					onInitialized: equalizeHeights,
					onResized: equalizeHeights,
					onRefreshed: equalizeHeights
				});

				function equalizeHeights() {
					setTimeout(function() {
						var maxHeight = 0;
						var items = $carousel.find('.awea-blog-card');
						items.css('height', 'auto');
						items.each(function () {
							var h = $(this).outerHeight();
							if (h > maxHeight) maxHeight = h;
						});
						if (maxHeight > 0) items.css('height', maxHeight + 'px');
					}, 100);
				}
			});
		});
		</script>
		<?php
	}
}