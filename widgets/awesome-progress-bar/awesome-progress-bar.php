<?php
/**
 * Awesome Progress Bar Studio Widget (Zero-Shadow Architectural Edition).
 *
 * @package AwesomeWidgetsElementor
 * @since 2.0.0
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

class Widget_Awesome_Progress_Bar extends Widget_Base {

	public function get_name() {
		return 'awesome-progress-bar';
	}

	public function get_title() {
		return esc_html__( 'Progress Bar', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-skill-bar';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'progress bar', 'skill bar', 'circle progress', 'meter' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_layout_style',
			[
				'label'   => esc_html__( 'Style', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'circle',
				'options' => [
					'circle' => esc_html__( 'Radial Circle', 'awesome-widgets-elementor' ),
					'line'   => esc_html__( 'Linear Bar', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'System Accuracy', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_percent',
			[
				'label'   => esc_html__( 'Percentage', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
					'size' => 85,
				],
				'range'   => [
					'%' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'awea_duration',
			[
				'label'   => esc_html__( 'Duration', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1800,
				'min'     => 300,
				'max'     => 8000,
				'step'    => 100,
			]
		);

		$this->add_control(
			'awea_suffix',
			[
				'label'   => esc_html__( 'Suffix', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '%',
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_circle_dimension',
			[
				'label'      => esc_html__( 'Diameter', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 100, 'max' => 500 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 200 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-radial-container' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_layout_style' => 'circle' ],
			]
		);

		$this->add_responsive_control(
			'awea_line_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 150, 'max' => 1200 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 100 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-linear-container' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_layout_style' => 'line' ],
			]
		);

		$this->add_responsive_control(
			'awea_container_alignment',
			[
				'label'     => esc_html__( 'Align', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center'     => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'flex-end'   => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-progress-wrapper' => 'display: flex; justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. COLORS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_colors',
			[
				'label' => esc_html__( 'Colors', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_accent_color',
			[
				'label'     => esc_html__( 'Fill Color', 'awesome-widgets-elementor' ),
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
				'label'     => esc_html__( 'Track Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'selectors' => [
					'{{WRAPPER}} .awea-progress-track' => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .awea-line-track'     => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_stroke_width',
			[
				'label'      => esc_html__( 'Stroke Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 24 ] ],
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
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 36 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-line-track, {{WRAPPER}} .awea-line-fill' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_layout_style' => 'line' ],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TYPOGRAPHY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_style_typography',
			[
				'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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
				'name'     => 'awea_digit_typo',
				'selector' => '{{WRAPPER}} .awea-progress-percent',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
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
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-progress-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_label_typo',
				'selector' => '{{WRAPPER}} .awea-progress-label',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$style     = $settings['awea_layout_style'] ?? 'circle';
		$target    = ! empty( $settings['awea_percent']['size'] ) ? absint( $settings['awea_percent']['size'] ) : 0;
		$label     = $settings['awea_title'] ?? '';
		$duration  = ! empty( $settings['awea_duration'] ) ? absint( $settings['awea_duration'] ) : 1800;
		$suffix    = $settings['awea_suffix'] ?? '%';
		$widget_id = $this->get_id();
		?>
		<div class="awea-progress-wrapper awea-style-<?php echo esc_attr( $style ); ?>"
			 id="awea-progress-<?php echo esc_attr( $widget_id ); ?>"
			 data-target="<?php echo esc_attr( (string) $target ); ?>"
			 data-duration="<?php echo esc_attr( (string) $duration ); ?>"
			 data-suffix="<?php echo esc_attr( $suffix ); ?>"
			 data-style="<?php echo esc_attr( $style ); ?>">

			<?php if ( 'circle' === $style ) : ?>
				<div class="awea-radial-container">
					<svg class="awea-progress-svg" viewBox="0 0 100 100" aria-hidden="true">
						<circle class="awea-progress-track" cx="50" cy="50" r="42"></circle>
						<circle class="awea-progress-circle-fill" cx="50" cy="50" r="42" data-circumference="263.89"></circle>
					</svg>
					<div class="awea-radial-content">
						<span class="awea-progress-percent">0<?php echo esc_html( $suffix ); ?></span>
						<?php if ( ! empty( $label ) ) : ?>
							<span class="awea-progress-label"><?php echo esc_html( $label ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			<?php else : ?>
				<div class="awea-linear-container">
					<div class="awea-linear-meta">
						<?php if ( ! empty( $label ) ) : ?>
							<span class="awea-progress-label"><?php echo esc_html( $label ); ?></span>
						<?php endif; ?>
						<span class="awea-progress-percent">0<?php echo esc_html( $suffix ); ?></span>
					</div>
					<div class="awea-line-track">
						<div class="awea-line-fill" style="width: 0%;"></div>
					</div>
				</div>
			<?php endif; ?>

		</div>

		<script>
		(function() {
			function initProgressBar() {
				var wrapper = document.getElementById('awea-progress-<?php echo esc_js( $widget_id ); ?>');
				if (!wrapper || wrapper.__aweaBound) return;
				wrapper.__aweaBound = true;

				var target   = parseInt(wrapper.getAttribute('data-target'), 10) || 0;
				var duration = parseInt(wrapper.getAttribute('data-duration'), 10) || 1800;
				var suffix   = wrapper.getAttribute('data-suffix') || '%';
				var style    = wrapper.getAttribute('data-style') || 'circle';

				var percentEl = wrapper.querySelector('.awea-progress-percent');
				var fillCircle = wrapper.querySelector('.awea-progress-circle-fill');
				var fillLine   = wrapper.querySelector('.awea-line-fill');

				var circumference = 263.89;

				function runProgress() {
					var startTime = null;

					function step(timestamp) {
						if (!startTime) startTime = timestamp;
						var elapsed  = timestamp - startTime;
						var progress = Math.min(elapsed / duration, 1);
						var eased    = 1 - Math.pow(1 - progress, 3);
						var currentVal = Math.round(target * eased);

						if (percentEl) {
							percentEl.textContent = currentVal + suffix;
						}

						if (style === 'circle' && fillCircle) {
							var offset = circumference - (progress * (target / 100) * circumference);
							fillCircle.style.strokeDashoffset = offset;
						} else if (style === 'line' && fillLine) {
							fillLine.style.width = (progress * target) + '%';
						}

						if (progress < 1) {
							requestAnimationFrame(step);
						} else {
							if (percentEl) percentEl.textContent = target + suffix;
							if (style === 'circle' && fillCircle) {
								fillCircle.style.strokeDashoffset = circumference - ((target / 100) * circumference);
							} else if (style === 'line' && fillLine) {
								fillLine.style.width = target + '%';
							}
						}
					}

					requestAnimationFrame(step);
				}

				if ('IntersectionObserver' in window) {
					var observer = new IntersectionObserver(function(entries) {
						entries.forEach(function(entry) {
							if (entry.isIntersecting) {
								runProgress();
								observer.disconnect();
							}
						});
					}, { threshold: 0.2 });
					observer.observe(wrapper);
				} else {
					runProgress();
				}
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initProgressBar);
			} else {
				initProgressBar();
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				window.elementorFrontend.hooks.addAction('frontend/element_ready/awesome-progress-bar.default', initProgressBar);
			}
		})();
		</script>
		<?php
	}
}