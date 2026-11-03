<?php
/**
 * Awesome Counter Studio Widget.
 * Modern Kinetic Metrics Card with 60FPS Micro-Animations.
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

class Widget_Awesome_Counter extends Widget_Base {

	public function get_name() {
		return 'awesome-counter';
	}

	public function get_title() {
		return esc_html__( 'Counter Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'counter', 'stats', 'number', 'metrics', 'odometer', 'timer' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: METRICS & ICON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_counter_content',
			[
				'label' => esc_html__( 'Counter Data', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_counter_icon',
			[
				'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-rocket',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'awea_start_number',
			[
				'label'   => esc_html__( 'Starting Value', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_target_number',
			[
				'label'   => esc_html__( 'Target Number', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 150,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_decimal_places',
			[
				'label'   => esc_html__( 'Decimal Places', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 3,
				'step'    => 1,
				'default' => 0,
			]
		);

		$this->add_control(
			'awea_number_prefix',
			[
				'label'       => esc_html__( 'Number Prefix', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'dynamic'     => [ 'active' => true ],
				'placeholder' => '$',
			]
		);

		$this->add_control(
			'awea_number_suffix',
			[
				'label'       => esc_html__( 'Number Suffix', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '+',
				'dynamic'     => [ 'active' => true ],
				'placeholder' => '+',
			]
		);

		$this->add_control(
			'awea_counter_title',
			[
				'label'       => esc_html__( 'Title / Description', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Sprints Completed', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'awea_duration',
			[
				'label'       => esc_html__( 'Animation Duration (ms)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 500,
				'max'         => 8000,
				'step'        => 100,
				'default'     => 2200,
				'description' => esc_html__( 'Duration of smooth counting curve in milliseconds.', 'awesome-widgets-elementor' ),
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: CARD CONTAINER & BEAM
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_card',
			[
				'label' => esc_html__( 'Card & Kinetic Beam', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '44', 'right' => '32', 'bottom' => '44', 'left' => '32', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default'    => [ 'top' => '28', 'right' => '28', 'bottom' => '28', 'left' => '28', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-counter-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-counter-card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-counter-card',
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
					'{{WRAPPER}} .awea-counter-card:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .awea-counter-card:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-counter-card:hover',
			]
		);

		$this->add_responsive_control(
			'awea_card_hover_lift',
			[
				'label'      => esc_html__( 'Hover Lift (Y-Axis)', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => -30, 'max' => 0 ] ],
				'default'    => [ 'unit' => 'px', 'size' => -8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-card:hover' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Kinetic Beam Header
		$this->add_control(
			'awea_heading_beam',
			[
				'label'     => esc_html__( 'Kinetic Beam Border', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_enable_beam',
			[
				'label'        => esc_html__( 'Enable Beam Effect', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_beam_color',
			[
				'label'     => esc_html__( 'Beam Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-counter-card' => '--awea-beam-color: {{VALUE}};',
				],
				'condition' => [ 'awea_enable_beam' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: ICON BADGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_icon',
			[
				'label' => esc_html__( 'Icon Badge', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_size',
			[
				'label'      => esc_html__( 'Badge Dimension', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 40, 'max' => 120 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 64 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-icon-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 14, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-icon-box i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-counter-icon-box svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_icon_box_radius',
			[
				'label'      => esc_html__( 'Badge Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-counter-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_icon_state_tabs' );

		// Normal Icon
		$this->start_controls_tab(
			'awea_icon_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-counter-icon-box'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-counter-icon-box svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_bg',
			[
				'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(79, 70, 229, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea-counter-icon-box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Icon
		$this->start_controls_tab(
			'awea_icon_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-counter-card:hover .awea-counter-icon-box'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-counter-card:hover .awea-counter-icon-box svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_icon_bg_hover',
			[
				'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-counter-card:hover .awea-counter-icon-box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: NUMBER & TYPOGRAPHY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_number',
			[
				'label' => esc_html__( 'Metrics & Typography', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Number Digits
		$this->add_control(
			'awea_heading_number_style',
			[
				'label' => esc_html__( 'Numeric Digits', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_number_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-counter-val' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_number_typography',
				'selector' => '{{WRAPPER}} .awea-counter-val',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Prefix & Suffix
		$this->add_control(
			'awea_heading_affixes',
			[
				'label'     => esc_html__( 'Prefix & Suffix Symbol', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_affix_color',
			[
				'label'     => esc_html__( 'Affix Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-counter-prefix, {{WRAPPER}} .awea-counter-suffix' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_affix_typography',
				'selector' => '{{WRAPPER}} .awea-counter-prefix, {{WRAPPER}} .awea-counter-suffix',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		// Title / Label
		$this->add_control(
			'awea_heading_title_style',
			[
				'label'     => esc_html__( 'Title / Description', 'awesome-widgets-elementor' ),
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
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-counter-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typography',
				'selector' => '{{WRAPPER}} .awea-counter-label',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$start      = ! empty( $settings['awea_start_number'] ) ? floatval( $settings['awea_start_number'] ) : 0;
		$target     = ! empty( $settings['awea_target_number'] ) ? floatval( $settings['awea_target_number'] ) : 0;
		$decimals   = ! empty( $settings['awea_decimal_places'] ) ? absint( $settings['awea_decimal_places'] ) : 0;
		$duration   = ! empty( $settings['awea_duration'] ) ? absint( $settings['awea_duration'] ) : 2200;
		$prefix     = $settings['awea_number_prefix'] ?? '';
		$suffix     = $settings['awea_number_suffix'] ?? '';
		$title      = $settings['awea_counter_title'] ?? '';
		$has_beam   = 'yes' === ( $settings['awea_enable_beam'] ?? 'no' );
		$widget_id  = $this->get_id();

		$card_classes = [ 'awea-counter-card' ];
		if ( $has_beam ) {
			$card_classes[] = 'awea-has-beam';
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>"
		     id="awea-counter-<?php echo esc_attr( $widget_id ); ?>"
		     data-start="<?php echo esc_attr( (string) $start ); ?>"
		     data-target="<?php echo esc_attr( (string) $target ); ?>"
		     data-decimals="<?php echo esc_attr( (string) $decimals ); ?>"
		     data-duration="<?php echo esc_attr( (string) $duration ); ?>">

			<?php if ( ! empty( $settings['awea_counter_icon']['value'] ) ) : ?>
				<div class="awea-counter-icon-box" aria-hidden="true">
					<?php Icons_Manager::render_icon( $settings['awea_counter_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
			<?php endif; ?>

			<div class="awea-counter-stat-holder">
				<?php if ( ! empty( $prefix ) ) : ?>
					<span class="awea-counter-prefix"><?php echo esc_html( $prefix ); ?></span>
				<?php endif; ?>

				<!-- Pre-render starting value to prevent empty flicker -->
				<span class="awea-counter-val"><?php echo esc_html( number_format( $start, $decimals ) ); ?></span>

				<?php if ( ! empty( $suffix ) ) : ?>
					<span class="awea-counter-suffix"><?php echo esc_html( $suffix ); ?></span>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $title ) ) : ?>
				<p class="awea-counter-label"><?php echo esc_html( $title ); ?></p>
			<?php endif; ?>

		</div>
		<?php
	}
}