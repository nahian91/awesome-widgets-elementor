<?php
/**
 * Awesome Price Menu Studio Widget.
 * Modern Architectural Restaurant & Service Menu with Dotted Leaders & Dynamic Tags.
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
use \Elementor\Group_Control_Image_Size;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Price_Menu extends Widget_Base {

	public function get_name() {
		return 'awesome-price-menu';
	}

	public function get_title() {
		return esc_html__( 'Price Menu Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-menu-card';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'price menu', 'restaurant', 'catalog', 'pricing', 'food menu', 'services' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: MENU ITEMS REPEATER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_price_menu_content',
			[
				'label' => esc_html__( 'Menu Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_item_image',
			[
				'label'   => esc_html__( 'Item Thumbnail', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_item_title',
			[
				'label'       => esc_html__( 'Item Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Signature Truffle Burger', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_item_price',
			[
				'label'       => esc_html__( 'Price', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '$28.00',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_item_description',
			[
				'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => esc_html__( 'Wagyu beef patty, aged Gruyère, caramelized shallots, and house black truffle aioli.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_price_menu_items',
			[
				'label'       => esc_html__( 'Menu List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'awea_item_title'       => esc_html__( 'Signature Truffle Burger', 'awesome-widgets-elementor' ),
						'awea_item_price'       => '$28.00',
						'awea_item_description' => esc_html__( 'Wagyu beef patty, aged Gruyère, caramelized shallots, and house black truffle aioli.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_item_title'       => esc_html__( 'Pan-Seared Chilean Sea Bass', 'awesome-widgets-elementor' ),
						'awea_item_price'       => '$42.00',
						'awea_item_description' => esc_html__( 'Served over saffron risotto with charred asparagus and lemon-herb beurre blanc.', 'awesome-widgets-elementor' ),
					],
					[
						'awea_item_title'       => esc_html__( 'Artisanal Burrata & Heirloom', 'awesome-widgets-elementor' ),
						'awea_item_price'       => '$22.00',
						'awea_item_description' => esc_html__( 'Fresh creamy burrata, organic heirloom tomatoes, basil oil, and 25-year aged balsamic.', 'awesome-widgets-elementor' ),
					],
				],
				'title_field' => '{{{ awea_item_title }}} — {{{ awea_item_price }}}',
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h4',
				'options'   => [
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: CONTAINER SHELL & LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_layout',
			[
				'label' => esc_html__( 'Container Shell', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_container_padding',
			[
				'label'      => esc_html__( 'Container Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '40', 'right' => '40', 'bottom' => '40', 'left' => '40', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_container_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default'    => [ 'top' => '32', 'right' => '32', 'bottom' => '32', 'left' => '32', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_container_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-list' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_container_border',
				'selector' => '{{WRAPPER}} .awea-price-menu-list',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_container_shadow',
				'selector' => '{{WRAPPER}} .awea-price-menu-list',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: THUMBNAIL IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_image',
			[
				'label' => esc_html__( 'Thumbnail Image', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'awea_thumbnail_size',
				'default'   => 'thumbnail',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'awea_thumb_size',
			[
				'label'      => esc_html__( 'Thumbnail Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 50, 'max' => 140 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 76 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-thumb' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_thumb_radius',
			[
				'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '16', 'right' => '16', 'bottom' => '16', 'left' => '16', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_thumb_border',
				'selector' => '{{WRAPPER}} .awea-price-menu-thumb',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TYPOGRAPHY (TITLE, PRICE, DESCRIPTION)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_typography',
			[
				'label' => esc_html__( 'Typography & Leaders', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Item Title
		$this->add_control(
			'awea_heading_title',
			[
				'label' => esc_html__( 'Item Title', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typography',
				'selector' => '{{WRAPPER}} .awea-price-menu-title',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Price Amount
		$this->add_control(
			'awea_heading_price',
			[
				'label'     => esc_html__( 'Price Amount', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_price_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_price_typography',
				'selector' => '{{WRAPPER}} .awea-price',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Dotted Leader Line
		$this->add_control(
			'awea_heading_leader',
			[
				'label'     => esc_html__( 'Leader Line', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_leader_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-price-menu-header' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		// Description
		$this->add_control(
			'awea_heading_desc',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_desc_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desc_typography',
				'selector' => '{{WRAPPER}} .awea-description',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_responsive_control(
			'awea_row_gap',
			[
				'label'      => esc_html__( 'Gap Between Rows', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-price-menu' => 'margin-bottom: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  =$this->get_settings_for_display();
		$items     =$settings['awea_price_menu_items'] ?? [];
		$title_tag = Utils::validate_html_tag($settings['awea_title_tag'] ?? 'h4' );

		if ( empty( $items ) ) {
			return;
		}
		?>
		<ul class="awea-price-menu-list" role="list">
			<?php foreach ( $items as$item ) : 
				$title =$item['awea_item_title'] ?? '';
				$price =$item['awea_item_price'] ?? '';
				$desc  =$item['awea_item_description'] ?? '';
			?>
				<li class="awea-price-menu">
					
					<!-- Thumbnail Image -->
					<?php if ( ! empty( $item['awea_item_image']['url'] ) ) : ?>
						<div class="awea-price-menu-thumb">
							<?php 
							if ( ! empty( $item['awea_item_image']['id'] ) ) {
								echo wp_get_attachment_image( $item['awea_item_image']['id'],$settings['awea_thumbnail_size_size'], false, [ 'loading' => 'lazy' ] );
							} else {
								echo '<img src="' . esc_url( $item['awea_item_image']['url'] ) . '" alt="' . esc_attr( $title ) . '" loading="lazy" />';
							}
							?>
						</div>
					<?php endif; ?>

					<!-- Item Details -->
					<div class="awea-price-menu-details">
						<div class="awea-price-menu-header">
							<?php if ( ! empty( $title ) ) : ?>
								<<?php echo esc_attr( $title_tag ); ?> class="awea-price-menu-title">
									<?php echo esc_html( $title ); ?>
								</<?php echo esc_attr( $title_tag ); ?>>
							<?php endif; ?>

							<?php if ( ! empty( $price ) ) : ?>
								<span class="awea-price"><?php echo esc_html( $price ); ?></span>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $desc ) ) : ?>
							<p class="awea-description">
								<?php echo esc_html( $desc ); ?>
							</p>
						<?php endif; ?>
					</div>

				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}