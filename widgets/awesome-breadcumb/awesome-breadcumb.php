<?php
/**
 * Awesome Breadcrumb Studio Widget.
 * Architectural Hero Header & Dynamic Schema-Compliant Breadcrumbs.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Breadcumb extends Widget_Base {

	public function get_name() {
		return 'awesome-breadcumb';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumb Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-breadcrumbs';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'breadcrumb', 'navigation', 'trail', 'header', 'page title', 'seo' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: TITLE & ENGINE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_breadcrumb_content',
			[
				'label' => esc_html__( 'Breadcrumb & Title', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_breadcrumb_mode',
			[
				'label'   => esc_html__( 'Trail Source', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dynamic',
				'options' => [
					'dynamic' => esc_html__( 'Automatic (WP Hierarchy & SEO)', 'awesome-widgets-elementor' ),
					'custom'  => esc_html__( 'Manual Custom Title', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_custom_title',
			[
				'label'       => esc_html__( 'Custom Page Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Our Solutions', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'condition'   => [ 'awea_breadcrumb_mode' => 'custom' ],
			]
		);

		$this->add_control(
			'awea_home_label',
			[
				'label'   => esc_html__( 'Home Root Label', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Home', 'awesome-widgets-elementor' ),
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_show_title',
			[
				'label'        => esc_html__( 'Display Page Title', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h1',
				'options'   => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'span' => 'span',
				],
				'condition' => [ 'awea_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_separator_type',
			[
				'label'     => esc_html__( 'Separator Style', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'chevron',
				'separator' => 'before',
				'options'   => [
					'chevron' => esc_html__( 'Chevron ( › )', 'awesome-widgets-elementor' ),
					'slash'   => esc_html__( 'Slash ( / )', 'awesome-widgets-elementor' ),
					'dot'     => esc_html__( 'Dot ( • )', 'awesome-widgets-elementor' ),
					'custom'  => esc_html__( 'Custom Icon', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_separator_custom_icon',
			[
				'label'     => esc_html__( 'Custom Separator Icon', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 'awea_separator_type' => 'custom' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: BACKGROUND & OVERLAY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_bg_overlay',
			[
				'label' => esc_html__( 'Hero Banner Background', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_banner_bg',
				'types'    => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .awea-breadcrumb-hero',
			]
		);

		$this->add_control(
			'awea_heading_overlay',
			[
				'label'     => esc_html__( 'Dark / Gradient Overlay', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_banner_overlay',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-breadcrumb-hero::before',
			]
		);

		$this->add_responsive_control(
			'awea_overlay_opacity',
			[
				'label'     => esc_html__( 'Overlay Opacity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ],
				],
				'default'   => [ 'size' => 0.65 ],
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-hero::before' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: BANNER LAYOUT & PADDING
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_layout',
			[
				'label' => esc_html__( 'Banner Spacing & Align', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_hero_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '80', 'right' => '24', 'bottom' => '80', 'left' => '24', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-breadcrumb-hero' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_hero_align',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-hero' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .awea-breadcrumb-nav'  => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_hero_border',
				'selector' => '{{WRAPPER}} .awea-breadcrumb-hero',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: PAGE TITLE TYPOGRAPHY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_title',
			[
				'label'     => esc_html__( 'Page Title Style', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_title' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typography',
				'selector' => '{{WRAPPER}} .awea-breadcrumb-title',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-breadcrumb-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TRAIL LINKS & SEPARATOR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_trail',
			[
				'label' => esc_html__( 'Trail Links & Separators', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_trail_typography',
				'selector' => '{{WRAPPER}} .awea-breadcrumb-nav',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->start_controls_tabs( 'awea_trail_color_tabs' );

		// Normal Link
		$this->start_controls_tab(
			'awea_trail_tab_normal',
			[ 'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_link_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.72)',
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-item a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Link
		$this->start_controls_tab(
			'awea_trail_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_link_hover_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-item a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Current / Active Item
		$this->start_controls_tab(
			'awea_trail_tab_active',
			[ 'label' => esc_html__( 'Current', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_current_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-item.is-current' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Separator Styling
		$this->add_control(
			'awea_heading_sep_style',
			[
				'label'     => esc_html__( 'Separator Style', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_sep_color',
			[
				'label'     => esc_html__( 'Separator Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.35)',
				'selectors' => [
					'{{WRAPPER}} .awea-breadcrumb-sep' => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-breadcrumb-sep svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sep_spacing',
			[
				'label'      => esc_html__( 'Separator Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-breadcrumb-sep' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Compute the dynamic breadcrumb hierarchy list.
	 *
	 * @param string $home_label Label for root home item.
	 * @return array Array of items [ 'label' => string, 'url' => string|null ]
	 */
	private function get_dynamic_breadcrumbs( $home_label ) {
		$crumbs   = [];
		$crumbs[] = [ 'label' => $home_label, 'url' => home_url( '/' ) ];

		if ( is_front_page() || is_home() ) {
			return $crumbs;
		}

		if ( is_singular() ) {
			$post = get_queried_object();

			// If it is a hierarchical post type (like Pages)
			if ( is_page() && $post->post_parent ) {
				$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
				foreach ( $ancestors as $ancestor_id ) {
					$crumbs[] = [
						'label' => get_the_title( $ancestor_id ),
						'url'   => get_permalink( $ancestor_id ),
					];
				}
			} elseif ( is_single() ) {
				// Single blog post or CPT: check for primary category
				$cats = get_the_category( $post->ID );
				if ( ! empty( $cats ) ) {
					$crumbs[] = [
						'label' => $cats[0]->name,
						'url'   => get_category_link( $cats[0]->term_id ),
					];
				}
			}

			$crumbs[] = [ 'label' => get_the_title( $post->ID ), 'url' => null ];
		} elseif ( is_category() || is_tag() || is_tax() ) {
			$term = get_queried_object();
			if ( $term && ! is_wp_error( $term ) ) {
				$crumbs[] = [ 'label' => $term->name, 'url' => null ];
			}
		} elseif ( is_search() ) {
			$crumbs[] = [ 'label' => sprintf( esc_html__( 'Search: "%s"', 'awesome-widgets-elementor' ), get_search_query() ), 'url' => null ];
		} elseif ( is_author() ) {
			$crumbs[] = [ 'label' => get_the_author_meta( 'display_name', get_query_var( 'author' ) ), 'url' => null ];
		} elseif ( is_404() ) {
			$crumbs[] = [ 'label' => esc_html__( 'Page Not Found', 'awesome-widgets-elementor' ), 'url' => null ];
		} elseif ( is_archive() ) {
			$crumbs[] = [ 'label' => get_the_archive_title(), 'url' => null ];
		}

		return $crumbs;
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$mode         = $settings['awea_breadcrumb_mode'] ?? 'dynamic';
		$home_label   = ! empty( $settings['awea_home_label'] ) ? $settings['awea_home_label'] : esc_html__( 'Home', 'awesome-widgets-elementor' );
		$show_title   = 'yes' === ( $settings['awea_show_title'] ?? 'no' );
		$title_tag    = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h1' );
		$sep_type     = $settings['awea_separator_type'] ?? 'chevron';

		// Resolve Page Title
		if ( 'custom' === $mode ) {
			$page_title = $settings['awea_custom_title'] ?? '';
			$crumbs     = [
				[ 'label' => $home_label, 'url' => home_url( '/' ) ],
				[ 'label' => $page_title, 'url' => null ],
			];
		} else {
			if ( is_404() ) {
				$page_title = esc_html__( '404 - Not Found', 'awesome-widgets-elementor' );
			} elseif ( is_search() ) {
				$page_title = sprintf( esc_html__( 'Results for "%s"', 'awesome-widgets-elementor' ), get_search_query() );
			} elseif ( is_archive() ) {
				$page_title = get_the_archive_title();
			} else {
				$page_title = get_the_title();
			}
			$crumbs = $this->get_dynamic_breadcrumbs( $home_label );
		}
		?>
		<header class="awea-breadcrumb-hero">
			<div class="awea-breadcrumb-inner">
				
				<?php if ( $show_title && ! empty( $page_title ) ) : ?>
					<<?php echo esc_attr( $title_tag ); ?> class="awea-breadcrumb-title">
						<?php echo esc_html( $page_title ); ?>
					</<?php echo esc_attr( $title_tag ); ?>>
				<?php endif; ?>

				<!-- Schema-Compliant Breadcrumb List -->
				<nav class="awea-breadcrumb-nav" aria-label="<?php esc_attr_e( 'Breadcrumb', 'awesome-widgets-elementor' ); ?>">
					<ol class="awea-breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
						<?php 
						$total_items = count( $crumbs );
						foreach ( $crumbs as $index => $crumb ) : 
							$is_last  = ( $index === $total_items - 1 );
							$position = $index + 1;
						?>
							<li class="awea-breadcrumb-item <?php echo $is_last ? 'is-current' : ''; ?>" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
								<?php if ( ! empty( $crumb['url'] ) && ! $is_last ) : ?>
									<a href="<?php echo esc_url( $crumb['url'] ); ?>" itemprop="item">
										<span itemprop="name"><?php echo esc_html( $crumb['label'] ); ?></span>
									</a>
								<?php else : ?>
									<span class="awea-breadcrumb-text" aria-current="page" itemprop="name">
										<?php echo esc_html( $crumb['label'] ); ?>
									</span>
								<?php endif; ?>
								
								<meta itemprop="position" content="<?php echo esc_attr( (string) $position ); ?>" />

								<!-- Separator -->
								<?php if ( ! $is_last ) : ?>
									<span class="awea-breadcrumb-sep" aria-hidden="true">
										<?php if ( 'chevron' === $sep_type ) : ?>
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
										<?php elseif ( 'slash' === $sep_type ) : ?>
											/
										<?php elseif ( 'dot' === $sep_type ) : ?>
											•
										<?php elseif ( 'custom' === $sep_type && ! empty( $settings['awea_separator_custom_icon']['value'] ) ) : ?>
											<?php Icons_Manager::render_icon( $settings['awea_separator_custom_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										<?php endif; ?>
									</span>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ol>
				</nav>

			</div>
		</header>
		<?php
	}
}