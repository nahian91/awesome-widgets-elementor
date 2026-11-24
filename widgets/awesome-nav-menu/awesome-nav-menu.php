<?php
/**
 * Awesome Navigation Menu Widget.
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
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;

if ( ! class_exists( __NAMESPACE__ . '\AWEA_Nav_Walker' ) ) {
	/**
	 * Custom Menu Walker to natively append submenu indicators and ARIA attributes.
	 */
	class AWEA_Nav_Walker extends \Walker_Nav_Menu {
		private $show_indicator;

		public function __construct( $show_indicator = true ) {
			$this->show_indicator = (bool) $show_indicator;
		}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$classes   = empty( $item->classes ) ? [] : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$has_children = in_array( 'menu-item-has-children', $classes, true );

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			$item_id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$item_id = $item_id ? ' id="' . esc_attr( $item_id ) . '"' : '';

			$output .= '<li' . $item_id . $class_names . '>';

			$atts           = [];
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			if ( '_blank' === $item->target && empty( $item->xfn ) ) {
				$atts['rel'] = 'noopener noreferrer';
			} else {
				$atts['rel'] = $item->xfn;
			}
			$atts['href']         = ! empty( $item->url ) ? $item->url : '';
			$atts['aria-current'] = $item->current ? 'page' : '';

			if ( $has_children ) {
				$atts['aria-haspopup'] = 'true';
				$atts['aria-expanded'] = 'false';
			}

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			$title = apply_filters( 'the_title', $item->title, $item->ID );
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

			$item_output  = $args->before ?? '';
			$item_output .= '<a' . $attributes . '>';
			$item_output .= '<span class="awea-menu-label">' . ( $args->link_before ?? '' ) . wp_kses_post( $title ) . ( $args->link_after ?? '' ) . '</span>';

			if ( $has_children && $this->show_indicator ) {
				$item_output .= '<span class="awea-sub-indicator" aria-hidden="true">';
				$item_output .= '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>';
				$item_output .= '</span>';
			}

			$item_output .= '</a>';
			$item_output .= $args->after ?? '';

			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}

class Widget_Awesome_Nav_Menu extends Widget_Base {

	public function get_name() {
		return 'awesome-nav-menu';
	}

	public function get_title() {
		return esc_html__( 'Nav Menu', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_categories() {
		return [ 'awesome-header-footer' ];
	}

	public function get_keywords() {
		return [ 'awea', 'nav', 'menu', 'navigation', 'header', 'navbar', 'links', 'mobile', 'drawer' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT TAB: 1. MENU SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nm_section_content',
			[
				'label' => esc_html__( 'Menu Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$menus        = wp_get_nav_menus();
		$menu_options = [];
		if ( ! empty( $menus ) && ! is_wp_error( $menus ) ) {
			foreach ( $menus as $menu ) {
				$menu_options[ $menu->term_id ] = $menu->name;
			}
		}

		$this->add_control(
			'awea_nm_selected_menu',
			[
				'label'       => esc_html__( 'Choose WordPress Menu', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => $menu_options,
				'default'     => ! empty( $menu_options ) ? array_key_first( $menu_options ) : '',
				'description' => empty( $menu_options ) ? esc_html__( 'Create a menu first in Appearance > Menus.', 'awesome-widgets-elementor' ) : '',
			]
		);

		$this->add_responsive_control(
			'awea_nm_menu_layout',
			[
				'label'                => esc_html__( 'Menu Direction', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'row'    => [
						'title' => esc_html__( 'Horizontal', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-ellipsis-h',
					],
					'column' => [
						'title' => esc_html__( 'Vertical', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-ellipsis-v',
					],
				],
				'default'              => 'row',
				'prefix_class'         => 'awea-nav-layout-',
				'selectors_dictionary' => [
					'row'    => 'flex-direction: row; align-items: center;',
					'column' => 'flex-direction: column; align-items: stretch;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-nav-menu-list' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_menu_align',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start'    => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'        => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'      => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
					'space-between' => [
						'title' => esc_html__( 'Spread Apart', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nm_hover_style',
			[
				'label'        => esc_html__( 'Link Hover Style', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'pill',
				'options'      => [
					'none'      => esc_html__( 'Clean Color Only', 'awesome-widgets-elementor' ),
					'pill'      => esc_html__( 'Soft Tinted Pill', 'awesome-widgets-elementor' ),
					'underline' => esc_html__( 'Animated Bottom Line', 'awesome-widgets-elementor' ),
					'overline'  => esc_html__( 'Animated Top Line', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-nav-hover-',
			]
		);

		$this->add_control(
			'awea_nm_show_submenu_indicator',
			[
				'label'        => esc_html__( 'Show Dropdown Arrow', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'awea-has-indicator-',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT TAB: 2. MOBILE MENU
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nm_section_mobile_menu',
			[
				'label' => esc_html__( 'Mobile Menu', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_nm_enable_mobile_breakpoint',
			[
				'label'        => esc_html__( 'Switch to Mobile Menu At', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'mobile',
				'options'      => [
					'none'   => esc_html__( 'Never (Always Show Links)', 'awesome-widgets-elementor' ),
					'tablet' => esc_html__( 'Tablet & Mobile (991px)', 'awesome-widgets-elementor' ),
					'mobile' => esc_html__( 'Mobile Only (767px)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-nav-breakpoint-',
			]
		);

		$this->add_responsive_control(
			'awea_nm_mobile_toggle_align',
			[
				'label'     => esc_html__( 'Menu Button Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'flex-end',
				'condition' => [
					'awea_nm_enable_mobile_breakpoint!' => 'none',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-mobile-toggle-wrapper' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 1. TOP LINKS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nm_section_style_main_items',
			[
				'label' => esc_html__( 'Top Links', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_nm_menu_typography',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
				'selector' => '{{WRAPPER}} .awea-nav-menu-list > li > a',
			]
		);

		$this->add_responsive_control(
			'awea_nm_menu_item_spacing',
			[
				'label'      => esc_html__( 'Space Between Links', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 60 ],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-nav-menu-list' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_item_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [
					'top'      => '8',
					'right'    => '16',
					'bottom'   => '8',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-nav-menu-list > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_item_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '10',
					'right'    => '10',
					'bottom'   => '10',
					'left'     => '10',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-nav-menu-list > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_nm_menu_state_tabs' );

		$this->start_controls_tab(
			'awea_nm_menu_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nm_menu_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list > li > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nm_menu_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list > li > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_nm_menu_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nm_menu_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list > li > a:hover, {{WRAPPER}} .awea-nav-menu-list > li:hover > a, {{WRAPPER}} .awea-nav-menu-list > li > a:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nm_menu_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list > li > a:hover, {{WRAPPER}} .awea-nav-menu-list > li:hover > a, {{WRAPPER}} .awea-nav-menu-list > li > a:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_nm_menu_tab_active',
			[ 'label' => esc_html__( 'Active Page', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nm_menu_color_active',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list > li.current-menu-item > a, {{WRAPPER}} .awea-nav-menu-list > li.current-menu-ancestor > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nm_menu_bg_active',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list > li.current-menu-item > a, {{WRAPPER}} .awea-nav-menu-list > li.current-menu-ancestor > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 2. DROPDOWN ARROW
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nm_section_style_indicator',
			[
				'label'     => esc_html__( 'Dropdown Arrow', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_nm_show_submenu_indicator' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_indicator_size',
			[
				'label'      => esc_html__( 'Arrow Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 8, 'max' => 24 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-sub-indicator' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_indicator_gap',
			[
				'label'      => esc_html__( 'Space Next to Text', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 20 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nav-menu-list > li > a' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nm_indicator_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-sub-indicator' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 3. DROPDOWN BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nm_section_style_dropdown',
			[
				'label' => esc_html__( 'Dropdown Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_nm_submenu_width',
			[
				'label'      => esc_html__( 'Minimum Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px' => [ 'min' => 150, 'max' => 400 ],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 220,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-nav-menu-list ul.sub-menu' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_submenu_offset',
			[
				'label'      => esc_html__( 'Distance from Link', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 50 ],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea-nav-layout-row .awea-nav-menu-list > li > ul.sub-menu'    => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.awea-nav-layout-column .awea-nav-menu-list > li > ul.sub-menu' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_nm_submenu_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu',
			]
		);

		$this->add_responsive_control(
			'awea_nm_submenu_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '8',
					'right'    => '8',
					'bottom'   => '8',
					'left'     => '8',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-nav-menu-list ul.sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_submenu_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '14',
					'right'    => '14',
					'bottom'   => '14',
					'left'     => '14',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-nav-menu-list ul.sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_nm_submenu_border',
				'selector' => '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_nm_submenu_shadow',
				'selector' => '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu',
			]
		);

		$this->add_control(
			'awea_nm_submenu_items_heading',
			[
				'label'     => esc_html__( 'Dropdown Links', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_nm_submenu_typography',
				'selector' => '{{WRAPPER}} .awea-nav-menu-list ul.sub-menu li a',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->add_responsive_control(
			'awea_nm_subitem_padding',
			[
				'label'      => esc_html__( 'Link Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '10',
					'right'    => '16',
					'bottom'   => '10',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-nav-menu-list ul.sub-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_nm_subitem_tabs' );

		$this->start_controls_tab(
			'awea_nm_subitem_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nm_subitem_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list ul.sub-menu li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nm_subitem_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list ul.sub-menu li a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_nm_subitem_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nm_subitem_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list ul.sub-menu li a:hover, {{WRAPPER}} .awea-nav-menu-list ul.sub-menu li a:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nm_subitem_hover_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list ul.sub-menu li a:hover, {{WRAPPER}} .awea-nav-menu-list ul.sub-menu li a:focus-visible' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_nm_subitem_tab_active',
			[ 'label' => esc_html__( 'Active Page', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nm_subitem_active_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list ul.sub-menu li.current-menu-item > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nm_subitem_active_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-list ul.sub-menu li.current-menu-item > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 4. MENU BUTTON (MOBILE)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nm_section_style_toggle',
			[
				'label'     => esc_html__( 'Menu Button (Mobile)', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_nm_enable_mobile_breakpoint!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_toggle_box_size',
			[
				'label'      => esc_html__( 'Button Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 32, 'max' => 64 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 44 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-mobile-toggle-btn' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_toggle_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 14, 'max' => 36 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 22 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-mobile-toggle-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_toggle_radius',
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
					'{{WRAPPER}} .awea-mobile-toggle-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_nm_toggle_state_tabs' );

		$this->start_controls_tab(
			'awea_nm_toggle_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nm_toggle_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-mobile-toggle-btn svg' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nm_toggle_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-mobile-toggle-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_nm_toggle_tab_active',
			[ 'label' => esc_html__( 'Open', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nm_toggle_active_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-mobile-toggle-btn[aria-expanded="true"] svg' => 'stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nm_toggle_active_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-mobile-toggle-btn[aria-expanded="true"]' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE TAB: 5. MOBILE PANEL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_nm_section_style_mobile_drawer',
			[
				'label'     => esc_html__( 'Mobile Panel', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_nm_enable_mobile_breakpoint!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_drawer_offset',
			[
				'label'      => esc_html__( 'Space Below Button', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [ 'min' => 0, 'max' => 40 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-nav-menu-wrapper' => '--awea-nm-drawer-offset: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nm_drawer_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-wrapper' => '--awea-nm-drawer-bg: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_drawer_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '12',
					'right'    => '12',
					'bottom'   => '12',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-nav-menu-wrapper' => '--awea-nm-drawer-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nm_drawer_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem' ],
				'default'    => [
					'top'      => '16',
					'right'    => '16',
					'bottom'   => '16',
					'left'     => '16',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-nav-menu-wrapper' => '--awea-nm-drawer-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_nm_drawer_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-nav-menu-wrapper' => '--awea-nm-drawer-border: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$menu_id  = absint( $settings['awea_nm_selected_menu'] ?? 0 );

		if ( ! $menu_id ) {
			if ( current_user_can( 'manage_options' ) ) {
				echo '<div class="awea-nav-notice" style="padding:16px; background:#fef3c7; color:#b45309; border-radius:8px; font-size:13px; font-weight:600;">' . esc_html__( 'Please select a menu in the widget settings.', 'awesome-widgets-elementor' ) . '</div>';
			}
			return;
		}

		$unique_id      = $this->get_id();
		$show_indicator = ( 'yes' === ( $settings['awea_nm_show_submenu_indicator'] ?? 'yes' ) );
		?>
		<div class="awea-nav-menu-wrapper" data-nav-id="<?php echo esc_attr( $unique_id ); ?>">

			<?php if ( 'none' !== ( $settings['awea_nm_enable_mobile_breakpoint'] ?? 'mobile' ) ) : ?>
				<div class="awea-mobile-toggle-wrapper">
					<button type="button" class="awea-mobile-toggle-btn" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle Navigation', 'awesome-widgets-elementor' ); ?>">
						<svg class="awea-icon-open" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<line x1="3" y1="12" x2="21" y2="12"></line>
							<line x1="3" y1="6" x2="21" y2="6"></line>
							<line x1="3" y1="18" x2="21" y2="18"></line>
						</svg>
						<svg class="awea-icon-close" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
							<line x1="18" y1="6" x2="6" y2="18"></line>
							<line x1="6" y1="6" x2="18" y2="18"></line>
						</svg>
					</button>
				</div>
			<?php endif; ?>

			<nav class="awea-nav-menu-container" role="navigation" aria-label="<?php esc_attr_e( 'Main Menu', 'awesome-widgets-elementor' ); ?>">
				<?php
				wp_nav_menu(
					[
						'menu'        => $menu_id,
						'menu_class'  => 'menu awea-nav-menu-list',
						'container'   => false,
						'fallback_cb' => '__return_false',
						'walker'      => new AWEA_Nav_Walker( $show_indicator ),
					]
				);
				?>
			</nav>
		</div>

		<script>
		(function() {
			function initNavMenu() {
				var wrapper = document.querySelector('[data-nav-id="<?php echo esc_js( $unique_id ); ?>"]');
				if (!wrapper || wrapper.dataset.aweaBound === '1') return;
				wrapper.dataset.aweaBound = '1';

				var toggleBtn     = wrapper.querySelector('.awea-mobile-toggle-btn');
				var menuContainer = wrapper.querySelector('.awea-nav-menu-container');

				function closeDrawer() {
					if (!toggleBtn || !menuContainer) return;
					toggleBtn.setAttribute('aria-expanded', 'false');
					menuContainer.classList.remove('awea-menu-open');
				}

				if (toggleBtn && menuContainer) {
					toggleBtn.addEventListener('click', function(e) {
						e.preventDefault();
						var expanded = this.getAttribute('aria-expanded') === 'true';
						this.setAttribute('aria-expanded', String(!expanded));
						menuContainer.classList.toggle('awea-menu-open');
					});

					document.addEventListener('click', function(e) {
						if (!document.body.contains(wrapper)) return;
						if (!wrapper.contains(e.target) && menuContainer.classList.contains('awea-menu-open')) {
							closeDrawer();
						}
					});

					document.addEventListener('keydown', function(e) {
						if (!document.body.contains(wrapper)) return;
						if (e.key === 'Escape' && menuContainer.classList.contains('awea-menu-open')) {
							closeDrawer();
							toggleBtn.focus();
						}
					});
				}

				wrapper.querySelectorAll('.menu-item-has-children > a').forEach(function(link) {
					link.addEventListener('click', function(e) {
						var toggleVisible = toggleBtn && window.getComputedStyle(toggleBtn.parentElement).display !== 'none';
						if (!toggleVisible) return;

						var parentLi = this.parentElement;
						var subMenu  = parentLi ? parentLi.querySelector(':scope > ul.sub-menu') : null;
						if (!subMenu) return;

						if (!parentLi.classList.contains('awea-sub-open')) {
							e.preventDefault();
							parentLi.classList.add('awea-sub-open');
							this.setAttribute('aria-expanded', 'true');
						}
					});
				});
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initNavMenu);
			} else {
				initNavMenu();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-nav-menu.default', initNavMenu);
			}
		})();
		</script>
		<?php
	}
}