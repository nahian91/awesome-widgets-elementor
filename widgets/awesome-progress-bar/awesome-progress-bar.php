<?php
/**
 * Awesome Progress Bar Widget.
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
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;

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
		return [ 'awea', 'progress bar', 'skill bar', 'circle progress', 'meter', 'percentage' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. PROGRESS SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pb_section_content',
			[
				'label' => esc_html__( 'Progress Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_pb_layout_style',
			[
				'label'   => esc_html__( 'Meter Style', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'circle',
				'options' => [
					'circle' => esc_html__( 'Circular Ring', 'awesome-widgets-elementor' ),
					'line'   => esc_html__( 'Horizontal Bar', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_pb_title',
			[
				'label'       => esc_html__( 'Metric Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'System Accuracy', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_pb_percent',
			[
				'label'   => esc_html__( 'Target Percentage', 'awesome-widgets-elementor' ),
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
			'awea_pb_suffix',
			[
				'label'   => esc_html__( 'Number Symbol', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '%',
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_pb_duration',
			[
				'label'   => esc_html__( 'Animation Speed (ms)', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1800,
				'min'     => 300,
				'max'     => 8000,
				'step'    => 100,
			]
		);

		$this->add_control(
			'awea_pb_shimmer',
			[
				'label'        => esc_html__( 'Animated Bar Shimmer', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_pb_layout_style' => 'line' ],
				'prefix_class' => 'awea-pb-shimmer-',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. METER LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pb_style_layout',
			[
				'label' => esc_html__( 'Meter Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_pb_circle_dimension',
			[
				'label'      => esc_html__( 'Circle Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 100, 'max' => 500 ],
				],
				'default'    => [ 'unit' => 'px', 'size' => 200 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-radial-container' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_pb_layout_style' => 'circle' ],
			]
		);

		$this->add_responsive_control(
			'awea_pb_line_max_width',
			[
				'label'      => esc_html__( 'Maximum Bar Width', 'awesome-widgets-elementor' ),
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
				'condition'  => [ 'awea_pb_layout_style' => 'line' ],
			]
		);

		$this->add_responsive_control(
			'awea_pb_container_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
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
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-progress-wrapper' => 'display: flex; justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. METER COLORS & SIZE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pb_style_colors',
			[
				'label' => esc_html__( 'Meter Colors & Size', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_pb_accent_color',
			[
				'label'     => esc_html__( 'Progress Fill Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-progress-circle-fill' => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .awea-line-fill'           => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_pb_track_color',
			[
				'label'     => esc_html__( 'Background Track Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-progress-track' => 'stroke: {{VALUE}};',
					'{{WRAPPER}} .awea-line-track'     => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_pb_stroke_width',
			[
				'label'      => esc_html__( 'Ring Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-progress-svg circle' => 'stroke-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_pb_layout_style' => 'circle' ],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_pb_line_height',
			[
				'label'      => esc_html__( 'Bar Thickness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 36 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-line-track, {{WRAPPER}} .awea-line-fill' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_pb_layout_style' => 'line' ],
				'separator'  => 'before',
			]
		);

		$this->add_responsive_control(
			'awea_pb_line_radius',
			[
				'label'      => esc_html__( 'Bar Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '100',
					'right'    => '100',
					'bottom'   => '100',
					'left'     => '100',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'condition'  => [ 'awea_pb_layout_style' => 'line' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-line-track, {{WRAPPER}} .awea-line-fill' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TEXT & NUMBERS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_pb_style_typography',
			[
				'label' => esc_html__( 'Text & Numbers', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_pb_digit_color',
			[
				'label'     => esc_html__( 'Percentage Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-progress-percent' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pb_digit_typo',
				'selector' => '{{WRAPPER}} .awea-progress-percent',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_pb_digit_shadow',
				'selector' => '{{WRAPPER}} .awea-progress-percent',
			]
		);

		$this->add_control(
			'awea_pb_label_color',
			[
				'label'     => esc_html__( 'Metric Label Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awea-progress-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_pb_label_typo',
				'selector' => '{{WRAPPER}} .awea-progress-label',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$style     = $settings['awea_pb_layout_style'] ?? 'circle';
		$target    = isset( $settings['awea_pb_percent']['size'] ) ? min( 100, max( 0, absint( $settings['awea_pb_percent']['size'] ) ) ) : 0;
		$label     = $settings['awea_pb_title'] ?? '';
		$duration  = ! empty( $settings['awea_pb_duration'] ) ? absint( $settings['awea_pb_duration'] ) : 1800;
		$suffix    = $settings['awea_pb_suffix'] ?? '%';
		$widget_id = $this->get_id();

		$this->add_inline_editing_attributes( 'awea_pb_title', 'none' );
		$this->add_render_attribute( 'awea_pb_title', 'class', 'awea-progress-label' );
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
							<span <?php $this->print_render_attribute_string( 'awea_pb_title' ); ?>>
								<?php echo esc_html( $label ); ?>
							</span>
						<?php endif; ?>
					</div>
				</div>
			<?php else : ?>
				<div class="awea-linear-container">
					<div class="awea-linear-meta">
						<?php if ( ! empty( $label ) ) : ?>
							<span <?php $this->print_render_attribute_string( 'awea_pb_title' ); ?>>
								<?php echo esc_html( $label ); ?>
							</span>
						<?php endif; ?>
						<span class="awea-progress-percent">0<?php echo esc_html( $suffix ); ?></span>
					</div>
					<div class="awea-line-track" role="progressbar" aria-valuenow="<?php echo esc_attr( (string) $target ); ?>" aria-valuemin="0" aria-valuemax="100" aria-label="<?php echo esc_attr( $label ); ?>">
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

				var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
				var target       = parseInt(wrapper.getAttribute('data-target'), 10) || 0;
				var duration     = parseInt(wrapper.getAttribute('data-duration'), 10) || 1800;
				var suffix       = wrapper.getAttribute('data-suffix') || '%';
				var style        = wrapper.getAttribute('data-style') || 'circle';

				var percentEl  = wrapper.querySelector('.awea-progress-percent');
				var fillCircle = wrapper.querySelector('.awea-progress-circle-fill');
				var fillLine   = wrapper.querySelector('.awea-line-fill');

				var circumference = 263.89;

				function applyFinalState() {
					if (percentEl) percentEl.textContent = target + suffix;
					if (style === 'circle' && fillCircle) {
						fillCircle.style.strokeDashoffset = circumference - ((target / 100) * circumference);
					} else if (style === 'line' && fillLine) {
						fillLine.style.width = target + '%';
					}
				}

				function runProgress() {
					if (reduceMotion) {
						applyFinalState();
						return;
					}

					var startTime = null;

					function step(timestamp) {
						if (!document.body.contains(wrapper)) return;
						if (!startTime) startTime = timestamp;
						var elapsed    = timestamp - startTime;
						var progress   = Math.min(elapsed / duration, 1);
						var eased      = 1 - Math.pow(1 - progress, 3);
						var currentVal = Math.round(target * eased);

						if (percentEl) {
							percentEl.textContent = currentVal + suffix;
						}

						if (style === 'circle' && fillCircle) {
							fillCircle.style.strokeDashoffset = circumference - (eased * (target / 100) * circumference);
						} else if (style === 'line' && fillLine) {
							fillLine.style.width = (eased * target) + '%';
						}

						if (progress < 1) {
							requestAnimationFrame(step);
						} else {
							applyFinalState();
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