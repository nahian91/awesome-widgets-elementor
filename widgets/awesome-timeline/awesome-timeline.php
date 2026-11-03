<?php
/**
 * Awesome Timeline Widget.
 * Modern Kinetic Architecture with Progressive Scroll Animations.
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
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Timeline extends Widget_Base {

	public function get_name() {
		return 'awesome-timeline';
	}

	public function get_title() {
		return esc_html__( 'Timeline Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'timeline', 'roadmap', 'history', 'steps', 'process', 'kinetic' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: TIMELINE ITEMS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_timeline_content',
			[
				'label' => esc_html__( 'Timeline Milestones', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_item_badge',
			[
				'label'       => esc_html__( 'Step / Date Tag', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Phase 01',
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_item_title',
			[
				'label'       => esc_html__( 'Milestone Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Architectural Audit',
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_item_desc',
			[
				'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => 'We perform an exhaustive deep dive across existing database architectures and frontend rendering pipelines.',
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'awea_item_icon',
			[
				'label'       => esc_html__( 'Node Icon (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => '',
					'library' => '',
				],
			]
		);

		$this->add_control(
			'awea_timeline_items',
			[
				'label'       => esc_html__( 'Timeline Milestones', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'awea_item_badge' => 'Phase 01',
						'awea_item_title' => 'Discovery & Deep Audit',
						'awea_item_desc'  => 'We perform an exhaustive deep dive across existing database architectures and frontend rendering pipelines.',
					],
					[
						'awea_item_badge' => 'Phase 02',
						'awea_item_title' => 'Structural Logic Mapping',
						'awea_item_desc'  => 'Defining application foundations, relational schemas, user journey nodes, and micro-service connectivity.',
					],
					[
						'awea_item_badge' => 'Phase 03',
						'awea_item_title' => 'System Deployment & QA',
						'awea_item_desc'  => 'Zero-downtime transition to production infrastructure backed by automated stress and security audits.',
					],
				],
				'title_field' => '{{{ awea_item_badge }}} - {{{ awea_item_title }}}',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: CENTRAL SPINE & NODES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_spine',
			[
				'label' => esc_html__( 'Central Spine & Nodes', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_spine_color',
			[
				'label'     => esc_html__( 'Spine Line Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-timeline-container::before' => 'background: linear-gradient(to bottom, transparent, {{VALUE}} 12%, {{VALUE}} 88%, transparent);',
				],
			]
		);

		$this->add_responsive_control(
			'awea_spine_width',
			[
				'label'      => esc_html__( 'Spine Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 8 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 2 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-timeline-container::before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_dot',
			[
				'label'     => esc_html__( 'Node Indicators', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_node_size',
			[
				'label'      => esc_html__( 'Node Diameter', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 14, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-timeline-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_dot_border_color',
			[
				'label'     => esc_html__( 'Node Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-timeline-dot' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .awea-timeline-item:hover .awea-timeline-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_dot_bg_color',
			[
				'label'     => esc_html__( 'Node Inner Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-timeline-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_dot_halo_color',
			[
				'label'     => esc_html__( 'Halo Ring Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.15)',
				'selectors' => [
					'{{WRAPPER}} .awea-timeline-dot' => 'box-shadow: 0 0 0 8px {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: MILESTONE CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_cards',
			[
				'label' => esc_html__( 'Milestone Cards', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Card Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '36', 'right' => '36', 'bottom' => '36', 'left' => '36', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-timeline-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-timeline-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_card_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_card_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-timeline-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-timeline-content',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-timeline-content',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_card_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-timeline-item:hover .awea-timeline-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_card_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-timeline-item:hover .awea-timeline-content' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-timeline-item:hover .awea-timeline-content',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TYPOGRAPHY & BADGES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_typo',
			[
				'label' => esc_html__( 'Typography & Badges', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Step Tag Badge
		$this->add_control(
			'awea_heading_badge',
			[
				'label' => esc_html__( 'Step Tag Badge', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-step-tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_badge_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea-step-tag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_badge_typography',
				'selector' => '{{WRAPPER}} .awea-step-tag',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		// Milestone Title
		$this->add_control(
			'awea_heading_title',
			[
				'label'     => esc_html__( 'Milestone Title', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-timeline-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typography',
				'selector' => '{{WRAPPER}} .awea-timeline-title',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Milestone Description
		$this->add_control(
			'awea_heading_desc',
			[
				'label'     => esc_html__( 'Milestone Description', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-timeline-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desc_typography',
				'selector' => '{{WRAPPER}} .awea-timeline-desc',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$items    = $settings['awea_timeline_items'] ?? [];

		if ( empty( $items ) ) {
			return;
		}
		?>
		<div class="awea-timeline-container">
			<?php foreach ( $items as $index => $item ) : 
				$badge    = $item['awea_item_badge'] ?? '';
				$title    = $item['awea_item_title'] ?? '';
				$desc     = $item['awea_item_desc'] ?? '';
				$has_icon = ! empty( $item['awea_item_icon']['value'] );
			?>
				<div class="awea-timeline-item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
					<!-- Center Node Indicator -->
					<div class="awea-timeline-dot" aria-hidden="true">
						<?php if ( $has_icon ) : ?>
							<span class="awea-dot-icon">
								<?php Icons_Manager::render_icon( $item['awea_item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</span>
						<?php endif; ?>
					</div>

					<!-- Content Card -->
					<div class="awea-timeline-content">
						<?php if ( ! empty( $badge ) ) : ?>
							<span class="awea-step-tag"><?php echo esc_html( $badge ); ?></span>
						<?php endif; ?>
						
						<?php if ( ! empty( $title ) ) : ?>
							<h3 class="awea-timeline-title"><?php echo esc_html( $title ); ?></h3>
						<?php endif; ?>

						<?php if ( ! empty( $desc ) ) : ?>
							<p class="awea-timeline-desc"><?php echo esc_html( $desc ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}