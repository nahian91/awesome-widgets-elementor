<?php
/**
 * Awesome Product Category Grid Widget.
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
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;

class Widget_Awesome_Product_Category_Grid extends Widget_Base {

	public function get_name() {
		return 'awesome-product-category-grid';
	}

	public function get_title() {
		return esc_html__( 'Product Category Grid', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-categories';
	}

	public function get_categories() {
		return [ 'awesome-woo', 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'woocommerce', 'product category', 'grid', 'shop', 'catalog', 'collections' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. CATEGORY QUERY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pcg_section_query',
			[
				'label' => esc_html__( 'Category Query', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$cat_options = [];
		if ( class_exists( 'WooCommerce' ) && taxonomy_exists( 'product_cat' ) ) {
			$categories = get_terms(
				[
					'taxonomy'   => 'product_cat',
					'hide_empty' => false,
				]
			);
			if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
				foreach ( $categories as $cat ) {
					$cat_options[ $cat->term_id ] = $cat->name;
				}
			}
		}

		$this->add_control(
			'awea_pcg_taxonomy_filter',
			[
				'label'       => esc_html__( 'Filter by Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple'    => true,
				'options'     => $cat_options,
				'description' => esc_html__( 'Leave empty to show all product categories.', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_pcg_posts_per_page',
			[
				'label'   => esc_html__( 'Number of Categories', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 50,
			]
		);

		$this->add_control(
			'awea_pcg_orderby',
			[
				'label'   => esc_html__( 'Sort Categories By', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'name',
				'options' => [
					'name'  => esc_html__( 'Category Name', 'awesome-widgets-elementor' ),
					'count' => esc_html__( 'Product Count', 'awesome-widgets-elementor' ),
					'id'    => esc_html__( 'Category ID', 'awesome-widgets-elementor' ),
					'slug'  => esc_html__( 'Slug', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_pcg_order',
			[
				'label'   => esc_html__( 'Sort Direction', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'ASC'  => esc_html__( 'Ascending (A–Z / Low)', 'awesome-widgets-elementor' ),
					'DESC' => esc_html__( 'Descending (Z–A / High)', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_pcg_hide_empty',
			[
				'label'        => esc_html__( 'Hide Empty Categories', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. CARD ELEMENTS & GRID
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pcg_section_layout',
			[
				'label' => esc_html__( 'Card Elements & Grid', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_pcg_card_style',
			[
				'label'        => esc_html__( 'Card Layout', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'overlay',
				'options'      => [
					'overlay'   => esc_html__( 'Overlay Info Box (On Photo)', 'awesome-widgets-elementor' ),
					'editorial' => esc_html__( 'Clean Card (Text Below Photo)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-pcg-style-',
			]
		);

		$this->add_responsive_control(
			'awea_pcg_columns',
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
					'{{WRAPPER}} .awea-product-category-grid-wrap .awea-grid-wrapper' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_control(
			'awea_pcg_hover_motion',
			[
				'label'        => esc_html__( 'Card Hover Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'lift',
				'options'      => [
					'none'  => esc_html__( 'None', 'awesome-widgets-elementor' ),
					'lift'  => esc_html__( 'Move Up', 'awesome-widgets-elementor' ),
					'scale' => esc_html__( 'Zoom In', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-pcg-motion-',
			]
		);

		$this->add_control(
			'awea_pcg_kicker_text',
			[
				'label'       => esc_html__( 'Small Label Above Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Collection', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'separator'   => 'before',
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_pcg_show_count',
			[
				'label'        => esc_html__( 'Show Product Count', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_pcg_action_text',
			[
				'label'       => esc_html__( 'Link Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Explore Collection', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_pcg_title_tag',
			[
				'label'   => esc_html__( 'Category Heading Tag', 'awesome-widgets-elementor' ),
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
			'awea_pcg_style_card',
			[
				'label' => esc_html__( 'Card Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_pcg_card_height',
			[
				'label'          => esc_html__( 'Card Height', 'awesome-widgets-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px', 'vh' ],
				'range'          => [ 'px' => [ 'min' => 200, 'max' => 1200 ] ],
				'default'        => [ 'unit' => 'px', 'size' => 480 ],
				'tablet_default' => [ 'unit' => 'px', 'size' => 420 ],
				'mobile_default' => [ 'unit' => 'px', 'size' => 360 ],
				'condition'      => [ 'awea_pcg_card_style' => 'overlay' ],
				'selectors'      => [
					'{{WRAPPER}}.awea-pcg-style-overlay .awea-cat-card' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pcg_col_gap',
			[
				'label'      => esc_html__( 'Space Between Columns', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-category-grid-wrap .awea-grid-wrapper' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pcg_row_gap',
			[
				'label'      => esc_html__( 'Space Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-product-category-grid-wrap .awea-grid-wrapper' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pcg_card_radius',
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
					'{{WRAPPER}} .awea-cat-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_pcg_img_filter',
				'label'    => esc_html__( 'Photo Filters', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-cat-image',
			]
		);

		$this->start_controls_tabs( 'awea_pcg_card_tabs' );

		$this->start_controls_tab(
			'awea_pcg_card_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'awea_pcg_card_border',
				'selector'       => '{{WRAPPER}} .awea-cat-card',
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
				'name'     => 'awea_pcg_card_shadow',
				'selector' => '{{WRAPPER}} .awea-cat-card',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_pcg_card_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_pcg_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cat-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_pcg_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-cat-card:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. GLASS OVERLAY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pcg_style_overlay',
			[
				'label'     => esc_html__( 'Glass Overlay', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_pcg_card_style' => 'overlay' ],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_pcg_image_overlay_bg',
				'label'    => esc_html__( 'Photo Gradient', 'awesome-widgets-elementor' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}.awea-pcg-style-overlay .awea-cat-card::before',
			]
		);

		$this->add_control(
			'awea_pcg_glass_box_bg',
			[
				'label'     => esc_html__( 'Glass Box Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.awea-pcg-style-overlay .awea-cat-info' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_pcg_glass_padding',
			[
				'label'      => esc_html__( 'Glass Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '22',
					'right'    => '22',
					'bottom'   => '22',
					'left'     => '22',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}}.awea-pcg-style-overlay .awea-cat-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pcg_glass_radius',
			[
				'label'      => esc_html__( 'Glass Corner Roundness', 'awesome-widgets-elementor' ),
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
					'{{WRAPPER}}.awea-pcg-style-overlay .awea-cat-info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT & LINK
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pcg_style_text',
			[
				'label' => esc_html__( 'Text & Link', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_pcg_sub_color',
			[
				'label'     => esc_html__( 'Small Label Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-cat-kicker' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pcg_sub_typo',
				'selector' => '{{WRAPPER}} .awea-cat-kicker',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_pcg_title_color',
			[
				'label'     => esc_html__( 'Category Name Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-cat-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pcg_title_typo',
				'selector' => '{{WRAPPER}} .awea-cat-title',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_pcg_title_shadow',
				'selector' => '{{WRAPPER}} .awea-cat-title',
			]
		);

		$this->add_control(
			'awea_pcg_btn_color',
			[
				'label'     => esc_html__( 'Link Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-view-collection' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pcg_btn_typo',
				'selector' => '{{WRAPPER}} .awea-view-collection',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="awea-notice-error"><p>' . esc_html__( 'WooCommerce must be installed and active to use the Product Category Grid widget.', 'awesome-widgets-elementor' ) . '</p></div>';
			return;
		}

		$settings   = $this->get_settings_for_display();
		$limit      = ! empty( $settings['awea_pcg_posts_per_page'] ) ? absint( $settings['awea_pcg_posts_per_page'] ) : 3;
		$orderby    = $settings['awea_pcg_orderby'] ?? 'name';
		$order      = $settings['awea_pcg_order'] ?? 'ASC';
		$filter     = $settings['awea_pcg_taxonomy_filter'] ?? [];
		$hide_empty = 'yes' === ( $settings['awea_pcg_hide_empty'] ?? 'no' );
		$show_count = 'yes' === ( $settings['awea_pcg_show_count'] ?? 'yes' );
		$kicker     = $settings['awea_pcg_kicker_text'] ?? esc_html__( 'Collection', 'awesome-widgets-elementor' );
		$action     = $settings['awea_pcg_action_text'] ?? esc_html__( 'Explore Collection', 'awesome-widgets-elementor' );
		$title_tag  = Utils::validate_html_tag( $settings['awea_pcg_title_tag'] ?? 'h3' );

		$args = [
			'taxonomy'   => 'product_cat',
			'number'     => $limit,
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
		];

		if ( ! empty( $filter ) && is_array( $filter ) ) {
			$args['include'] = array_map( 'absint', $filter );
			if ( 'name' !== $orderby ) {
				$args['orderby'] = 'include';
			}
		}

		$terms = get_terms( $args );

		if ( is_wp_error( $terms ) || empty( $terms ) ) {
			return;
		}
		?>
		<div class="awea-product-category-grid-wrap">
			<div class="awea-grid-wrapper" role="list">
				<?php foreach ( $terms as $term ) :
					$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
					$image_url    = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'large' ) : ( function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src() : '' );
					$link         = get_term_link( $term );
					if ( is_wp_error( $link ) ) {
						continue;
					}
					?>
					<div class="awea-grid-item" role="listitem">
						<a href="<?php echo esc_url( $link ); ?>" class="awea-cat-card" aria-label="<?php echo esc_attr( $term->name ); ?>">
							<?php if ( ! empty( $image_url ) ) : ?>
								<div class="awea-cat-media">
									<img src="<?php echo esc_url( $image_url ); ?>" class="awea-cat-image" alt="<?php echo esc_attr( $term->name ); ?>" loading="lazy" />
								</div>
							<?php endif; ?>

							<div class="awea-cat-info">
								<?php if ( ! empty( $kicker ) || $show_count ) : ?>
									<span class="awea-cat-kicker">
										<?php
										echo esc_html( $kicker );
										if ( ! empty( $kicker ) && $show_count ) {
											echo ' &bull; ';
										}
										if ( $show_count ) {
											/* translators: %d: product count in category */
											echo esc_html( sprintf( _n( '%d Item', '%d Items', $term->count, 'awesome-widgets-elementor' ), $term->count ) );
										}
										?>
									</span>
								<?php endif; ?>

								<<?php Utils::print_validated_html_tag( $title_tag ); ?> class="awea-cat-title">
									<?php echo esc_html( $term->name ); ?>
								</<?php Utils::print_validated_html_tag( $title_tag ); ?>>

								<?php if ( ! empty( $action ) ) : ?>
									<div class="awea-view-collection">
										<?php echo esc_html( $action ); ?>
									</div>
								<?php endif; ?>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}