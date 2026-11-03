<?php
/**
 * Awesome Progress Bar Studio Widget.
 * Architectural Circular & Linear Progress Meters with Kinetic Counters.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Progress_Bar extends Widget_Base {

	public function get_name() {
		return 'awesome-progress-bar';
	}

	public function get_title() {
		return esc_html__( 'Progress Bar Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-skill-bar';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'progress bar', 'skill bar', 'circle progress', 'meter', 'percentage', 'counter' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: PROGRESS SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_progress_content',
			[
				'label' => esc_html__( 'Progress Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_layout_style',
			[
				'label'   => esc_html__( 'Meter Layout Style', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'circle',
				'options' => [
					'circle' => esc_html__( 'Premium Radial Circle', 'awesome-widgets-elementor' ),
					'line'   => esc_html__( 'Horizontal Linear Bar', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_title',
			[
				'label'       => esc_html__( 'Label Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'System Accuracy', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_percent',
			[
				'label'   => esc_html__( 'Percentage Target', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 85,
				],
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: VISUAL COLORS & TRACKS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_colors',
			[
				'label' => esc_html__( 'Colors & Tracks', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_accent_color',
			[
				'label'     => esc_html__( 'Progress Fill Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-progress-circle-fill' => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .awea-line-fill'           => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_track_color',
			[
				'label'     => esc_html__( 'Track Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.06)',
				'selectors' => [
					'{{WRAPPER}} .awea-progress-track' => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .awea-line-track'     => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_stroke_width',
			[
				'label'      => esc_html__( 'Circle Stroke Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 20 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-progress-svg circle' => 'stroke-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_layout_style' => 'circle' ],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_line_height',
			[
				'label'      => esc_html__( 'Bar Height', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-line-track, {{WRAPPER}} .awea-line-fill' => 'height: {{SIZE}}{{UNIT}}; border-radius: {{SIZE}}px;',
				],
				'condition'  => [ 'awea_layout_style' => 'line' ],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TYPOGRAPHY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_typography',
			[
				'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Number Digits
		$this->add_control(
			'awea_heading_digits',
			[
				'label' => esc_html__( 'Percentage Digits', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_digit_color',
			[
				'label'     => esc_html__( 'Digit Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-progress-percent' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_digit_typography',
				'selector' => '{{WRAPPER}} .awea-progress-percent',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Label Text
		$this->add_control(
			'awea_heading_label',
			[
				'label'     => esc_html__( 'Label Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-progress-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_label_typography',
				'selector' => '{{WRAPPER}} .awea-progress-label',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();$style    = $settings['awea_layout_style'] ?? 'circle';$target   = ! empty( $settings['awea_percent']['size'] ) ? absint( $settings['awea_percent']['size'] ) : 0;
		$label    =$settings['awea_title'] ?? '';
		$widget_id =$this->get_id();
		?>
		<div class="awea-progress-wrapper awea-style-<?php echo esc_attr( $style ); ?>"
		     id="awea-progress-<?php echo esc_attr( $widget_id ); ?>"
		     data-target="<?php echo esc_attr( (string) $target ); ?>"
		     data-style="<?php echo esc_attr( $style ); ?>">

			<?php if ( 'circle' === $style ) : ?>
				<div class="awea-radial-container">
					<svg class="awea-progress-svg" viewBox="0 0 100 100">
						<circle class="awea-progress-track" cx="50" cy="50" r="42"></circle>
						<circle class="awea-progress-circle-fill" cx="50" cy="50" r="42" data-circumference="263.89"></circle>
					</svg>
					<div class="awea-radial-content">
						<span class="awea-progress-percent">0%</span>
						<?php if ( ! empty( $label ) ) : ?>
							<span class="awea-progress-label"><?php echo esc_html( $label ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			<?php else : ?>
				<div class="awea-linear-container">
					<?php if ( ! empty( $label ) ) : ?>
						<div class="awea-linear-meta">
							<span class="awea-progress-label"><?php echo esc_html( $label ); ?></span>
							<span class="awea-progress-percent">0%</span>
						</div>
					<?php endif; ?>
					<div class="awea-line-track">
						<div class="awea-line-fill" style="width: 0%;"></div>
					</div>
				</div>
			<?php endif; ?>

		</div>
		<?php
	}
}