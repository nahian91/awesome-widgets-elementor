<?php
/**
 * Awesome Countdown Studio Widget.
 * Architectural Precision Countdown with Timezone Calibration & Kinetic Micro-Interactions.
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

class Widget_Awesome_Countdown extends Widget_Base {

	public function get_name() {
		return 'awea_countdown';
	}

	public function get_title() {
		return esc_html__( 'Countdown Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'countdown', 'timer', 'clock', 'launch', 'sale', 'urgent', 'event' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: TIMER SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_timer',
			[
				'label' => esc_html__( 'Countdown Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_due_date',
			[
				'label'       => esc_html__( 'Target Due Date (Site Timezone)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::DATE_TIME,
				'default'     => wp_date( 'Y-m-d H:i', strtotime( '+1 month' ) ),
				'description' => sprintf(
					/* translators: %s: Site current timezone string */
					esc_html__( 'Calculated according to your WordPress timezone setting: %s', 'awesome-widgets-elementor' ),
					'<strong>' . esc_html( wp_timezone_string() ) . '</strong>'
				),
			]
		);

		$this->add_control(
			'awea_expire_type',
			[
				'label'   => esc_html__( 'Action On Expiry', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'message',
				'options' => [
					'message'  => esc_html__( 'Display Custom Message', 'awesome-widgets-elementor' ),
					'redirect' => esc_html__( 'Redirect to URL', 'awesome-widgets-elementor' ),
					'none'     => esc_html__( 'Stay at Zero', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_expire_message',
			[
				'label'       => esc_html__( 'Expired Message', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => esc_html__( 'This event or offer has concluded.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_expire_type' => 'message' ],
			]
		);

		$this->add_control(
			'awea_expire_link',
			[
				'label'       => esc_html__( 'Redirect URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com/expired',
				'condition'   => [ 'awea_expire_type' => 'redirect' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: UNITS & LABELS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_units',
			[
				'label' => esc_html__( 'Display Units & Labels', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_show_days',
			[
				'label'        => esc_html__( 'Show Days', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_label_days',
			[
				'label'     => esc_html__( 'Days Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Days', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_days' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_hours',
			[
				'label'        => esc_html__( 'Show Hours', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_label_hours',
			[
				'label'     => esc_html__( 'Hours Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Hours', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_hours' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_minutes',
			[
				'label'        => esc_html__( 'Show Minutes', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_label_minutes',
			[
				'label'     => esc_html__( 'Minutes Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Mins', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_minutes' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_seconds',
			[
				'label'        => esc_html__( 'Show Seconds', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_label_seconds',
			[
				'label'     => esc_html__( 'Seconds Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Secs', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'awea_show_seconds' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_separators',
			[
				'label'        => esc_html__( 'Show Colon Dividers (:)', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TIME CELL CARDS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_cells',
			[
				'label' => esc_html__( 'Time Cells & Containers', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_cells_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center'     => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'flex-end'   => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-timer-row' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cells_gap',
			[
				'label'      => esc_html__( 'Gap Between Cells', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-timer-row' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cell_min_width',
			[
				'label'      => esc_html__( 'Min Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [ 'px' => [ 'min' => 70, 'max' => 250 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 120 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-time-cell' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cell_padding',
			[
				'label'      => esc_html__( 'Cell Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '28', 'right' => '20', 'bottom' => '24', 'left' => '20', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-time-cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cell_radius',
			[
				'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-time-cell' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_cell_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_cell_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cell_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-time-cell' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_cell_border',
				'selector' => '{{WRAPPER}} .awea-time-cell',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cell_shadow',
				'selector' => '{{WRAPPER}} .awea-time-cell',
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_cell_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cell_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-time-cell:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cell_border_hover',
			[
				'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-time-cell:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cell_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-time-cell:hover',
			]
		);

		$this->add_responsive_control(
			'awea_cell_hover_lift',
			[
				'label'      => esc_html__( 'Hover Lift (Y-Axis)', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => -25, 'max' => 0 ] ],
				'default'    => [ 'unit' => 'px', 'size' => -6 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-time-cell:hover' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: DIGITS & LABELS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_digits_labels',
			[
				'label' => esc_html__( 'Digits & Labels', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_heading_digits',
			[
				'label' => esc_html__( 'Numeric Digits', 'awesome-widgets-elementor' ),
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
					'{{WRAPPER}} .awea-digit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_digit_typography',
				'selector' => '{{WRAPPER}} .awea-digit',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'awea_heading_labels',
			[
				'label'     => esc_html__( 'Unit Labels', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_unit_color',
			[
				'label'     => esc_html__( 'Label Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-unit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_unit_typography',
				'selector' => '{{WRAPPER}} .awea-unit',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		// Separators
		$this->add_control(
			'awea_heading_separator_style',
			[
				'label'     => esc_html__( 'Divider Colons (:)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_show_separators' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_sep_color',
			[
				'label'     => esc_html__( 'Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-colon-sep' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_show_separators' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_sep_size',
			[
				'label'      => esc_html__( 'Divider Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 14, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-colon-sep' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 'awea_show_separators' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: EXPIRED MESSAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_expired',
			[
				'label'     => esc_html__( 'Expired Message', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_expire_type' => 'message' ],
			]
		);

		$this->add_control(
			'awea_expired_color',
			[
				'label'     => esc_html__( 'Message Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-countdown-expired' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_expired_typography',
				'selector' => '{{WRAPPER}} .awea-countdown-expired',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings       = $this->get_settings_for_display();
		$due_date_raw   = ! empty( $settings['awea_due_date'] ) ? $settings['awea_due_date'] : '';
		$widget_id      = $this->get_id();

		// Convert Elementor input string to target timestamp in site's timezone
		$site_timezone  = wp_timezone();
		$datetime       = date_create( $due_date_raw, $site_timezone );
		$target_time    = $datetime ? $datetime->getTimestamp() : strtotime( '+1 month' );
		$current_time   = wp_date( 'U' );
		$diff           = max( 0, $target_time - $current_time );

		// Pre-compute server-side numbers to prevent 00:00 flash
		$days    = floor( $diff / 86400 );
		$hours   = floor( ( $diff % 86400 ) / 3600 );
		$minutes = floor( ( $diff % 3600 ) / 60 );
		$seconds = floor( $diff % 60 );

		$show_days    = 'yes' === ( $settings['awea_show_days'] ?? 'no' );
		$show_hours   = 'yes' === ( $settings['awea_show_hours'] ?? 'no' );
		$show_mins    = 'yes' === ( $settings['awea_show_minutes'] ?? 'no' );
		$show_secs    = 'yes' === ( $settings['awea_show_seconds'] ?? 'no' );
		$show_seps    = 'yes' === ( $settings['awea_show_separators'] ?? 'no' );
		$expire_type  = $settings['awea_expire_type'] ?? 'message';
		$redirect_url = $settings['awea_expire_link']['url'] ?? '';

		$active_units = [];
		if ( $show_days )  $active_units[] = 'days';
		if ( $show_hours ) $active_units[] = 'hours';
		if ( $show_mins )  $active_units[] = 'minutes';
		if ( $show_secs )  $active_units[] = 'seconds';
		$last_unit = end( $active_units );
		?>
		<div class="awea-countdown-wrapper"
		     id="awea-countdown-<?php echo esc_attr( $widget_id ); ?>"
		     data-target="<?php echo esc_attr( (string) $target_time ); ?>"
		     data-server="<?php echo esc_attr( (string) $current_time ); ?>"
		     data-expire="<?php echo esc_attr( $expire_type ); ?>"
		     data-redirect="<?php echo esc_url( $redirect_url ); ?>">

			<div class="awea-timer-row <?php echo ( $diff <= 0 && 'message' === $expire_type ) ? 'awea-is-hidden' : ''; ?>">
				
				<?php if ( $show_days ) : ?>
					<div class="awea-time-cell awea-unit-days">
						<span class="awea-digit awea-val-days"><?php echo esc_html( sprintf( '%02d', $days ) ); ?></span>
						<span class="awea-unit"><?php echo esc_html( $settings['awea_label_days'] ); ?></span>
					</div>
					<?php if ( $show_seps && 'days' !== $last_unit ) : ?>
						<span class="awea-colon-sep" aria-hidden="true">:</span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $show_hours ) : ?>
					<div class="awea-time-cell awea-unit-hours">
						<span class="awea-digit awea-val-hours"><?php echo esc_html( sprintf( '%02d', $hours ) ); ?></span>
						<span class="awea-unit"><?php echo esc_html( $settings['awea_label_hours'] ); ?></span>
					</div>
					<?php if ( $show_seps && 'hours' !== $last_unit ) : ?>
						<span class="awea-colon-sep" aria-hidden="true">:</span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $show_mins ) : ?>
					<div class="awea-time-cell awea-unit-minutes">
						<span class="awea-digit awea-val-minutes"><?php echo esc_html( sprintf( '%02d', $minutes ) ); ?></span>
						<span class="awea-unit"><?php echo esc_html( $settings['awea_label_minutes'] ); ?></span>
					</div>
					<?php if ( $show_seps && 'minutes' !== $last_unit ) : ?>
						<span class="awea-colon-sep" aria-hidden="true">:</span>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ( $show_secs ) : ?>
					<div class="awea-time-cell awea-unit-seconds">
						<span class="awea-digit awea-val-seconds"><?php echo esc_html( sprintf( '%02d', $seconds ) ); ?></span>
						<span class="awea-unit"><?php echo esc_html( $settings['awea_label_seconds'] ); ?></span>
					</div>
				<?php endif; ?>

			</div>

			<?php if ( 'message' === $expire_type ) : ?>
				<div class="awea-countdown-expired <?php echo ( $diff <= 0 ) ? 'awea-is-visible' : ''; ?>" aria-live="polite">
					<?php echo esc_html( $settings['awea_expire_message'] ); ?>
				</div>
			<?php endif; ?>

		</div>
		<?php
	}
}