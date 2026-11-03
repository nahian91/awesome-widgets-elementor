<?php
/**
 * Awesome Number Box Studio Widget.
 * Modern Process Step & Milestone Card with Adaptive Alignment and Ghost Watermarks.
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

class Widget_Awesome_Number_Box extends Widget_Base {

	public function get_name() {
		return 'awesome-number-box';
	}

	public function get_title() {
		return esc_html__( 'Number Box Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'number', 'box', 'step', 'process', 'milestone', 'counter', 'workflow' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: NUMBER & TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_number_box_content',
			[
				'label' => esc_html__( 'Step Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_number_style_mode',
			[
				'label'   => esc_html__( 'Number Style Mode', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'badge',
				'options' => [
					'badge'     => esc_html__( 'Floating Squircle Badge', 'awesome-widgets-elementor' ),
					'watermark' => esc_html__( 'Oversized Ghost Watermark', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_number_box_number',
			[
				'label'       => esc_html__( 'Step / Number', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '01',
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_number_box_title',
			[
				'label'       => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Discovery & Strategic Planning', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'awea_number_box_title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
				],
			]
		);

		$this->add_control(
			'awea_number_box_des',
			[
				'label'       => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => esc_html__( 'We conduct comprehensive discovery workshops to analyze user flows, database structures, and architecture prerequisites.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_show_button',
			[
				'label'        => esc_html__( 'Show Action Link', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'awea_button_text',
			[
				'label'       => esc_html__( 'Link Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Learn More', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_button_url',
			[
				'label'       => esc_html__( 'Destination URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com/step-1',
				'default'     => [ 'url' => '#' ],
				'condition'   => [ 'awea_show_button' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: CARD CONTAINER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_card',
			[
				'label' => esc_html__( 'Card Shell & Alignment', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'left',
				'prefix_class' => 'awea-align-',
				'selectors' => [
					'{{WRAPPER}} .awea-single-number-box' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '40', 'right' => '32', 'bottom' => '40', 'left' => '32', 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .awea-single-number-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-single-number-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .awea-single-number-box' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-single-number-box',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-single-number-box',
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
					'{{WRAPPER}} .awea-single-number-box:hover' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .awea-single-number-box:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-single-number-box:hover',
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
					'{{WRAPPER}} .awea-single-number-box:hover' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: NUMBER STYLING (BADGE OR GHOST)
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_number',
			[
				'label' => esc_html__( 'Number Styling', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Badge Configuration
		$this->add_responsive_control(
			'awea_badge_dim',
			[
				'label'      => esc_html__( 'Badge Dimension', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 40, 'max' => 110 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 64 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-number-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_number_style_mode' => 'badge' ],
			]
		);

		$this->add_responsive_control(
			'awea_badge_radius',
			[
				'label'      => esc_html__( 'Badge Border Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-number-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 'awea_number_style_mode' => 'badge' ],
			]
		);

		$this->add_control(
			'awea_number_color',
			[
				'label'     => esc_html__( 'Number Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-number-badge'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .awea-number-watermark' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_number_bg',
			[
				'label'     => esc_html__( 'Badge Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-number-badge' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'awea_number_style_mode' => 'badge' ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'awea_number_border',
				'selector'  => '{{WRAPPER}} .awea-number-badge',
				'condition' => [ 'awea_number_style_mode' => 'badge' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_number_typography',
				'selector' => '{{WRAPPER}} .awea-number-badge, {{WRAPPER}} .awea-number-watermark',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_number_margin_bottom',
			[
				'label'      => esc_html__( 'Badge Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-number-badge' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'awea_number_style_mode' => 'badge' ],
			]
		);

		// Ghost Watermark Opacity
		$this->add_responsive_control(
			'awea_watermark_opacity',
			[
				'label'     => esc_html__( 'Ghost Opacity', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [ 'min' => 0.02, 'max' => 0.35, 'step' => 0.01 ],
				],
				'default'   => [ 'size' => 0.07 ],
				'selectors' => [
					'{{WRAPPER}} .awea-number-watermark' => 'opacity: {{SIZE}};',
				],
				'condition' => [ 'awea_number_style_mode' => 'watermark' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TITLE & DESCRIPTION
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_typography',
			[
				'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Title
		$this->add_control(
			'awea_heading_title_style',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
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
					'{{WRAPPER}} .awea-number-box-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typography',
				'selector' => '{{WRAPPER}} .awea-number-box-title',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_title_margin_bottom',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-number-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Description
		$this->add_control(
			'awea_heading_desc_style',
			[
				'label'     => esc_html__( 'Description', 'awesome-widgets-elementor' ),
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
					'{{WRAPPER}} .awea-number-box-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desc_typography',
				'selector' => '{{WRAPPER}} .awea-number-box-desc',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_responsive_control(
			'awea_desc_margin_bottom',
			[
				'label'      => esc_html__( 'Bottom Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-number-box-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: LINK / BUTTON
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_button',
			[
				'label'     => esc_html__( 'Action Link', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_btn_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-number-box-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_btn_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-number-box-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_btn_typography',
				'selector' => '{{WRAPPER}} .awea-number-box-btn',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$mode       = $settings['awea_number_style_mode'] ?? 'badge';
		$number     = $settings['awea_number_box_number'] ?? '01';
		$title      = $settings['awea_number_box_title'] ?? '';
		$title_tag  = Utils::validate_html_tag( $settings['awea_number_box_title_tag'] ?? 'h3' );
		$desc       = $settings['awea_number_box_des'] ?? '';
		$show_btn   = 'yes' === ( $settings['awea_show_button'] ?? 'no' );
		$btn_text   = $settings['awea_button_text'] ?? '';
		$has_btn    = $show_btn && ! empty( $btn_text );

		if ( $has_btn && ! empty( $settings['awea_button_url']['url'] ) ) {
			$this->add_link_attributes( 'awea_action_link', $settings['awea_button_url'] );
		}
		$this->add_render_attribute( 'awea_action_link', 'class', 'awea-number-box-btn' );

		$card_classes = [ 'awea-single-number-box', 'awea-mode-' . $mode ];
		?>
		<div class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">
			
			<?php if ( 'watermark' === $mode && ! empty( $number ) ) : ?>
				<div class="awea-number-watermark" aria-hidden="true"><?php echo esc_html( $number ); ?></div>
			<?php endif; ?>

			<?php if ( 'badge' === $mode && ! empty( $number ) ) : ?>
				<div class="awea-number-badge-wrap">
					<span class="awea-number-badge"><?php echo esc_html( $number ); ?></span>
				</div>
			<?php endif; ?>

			<div class="awea-number-box-body">
				<?php if ( ! empty( $title ) ) : ?>
					<<?php echo esc_attr( $title_tag ); ?> class="awea-number-box-title">
						<?php echo esc_html( $title ); ?>
					</<?php echo esc_attr( $title_tag ); ?>>
				<?php endif; ?>

				<?php if ( ! empty( $desc ) ) : ?>
					<p class="awea-number-box-desc">
						<?php echo esc_html( $desc ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $has_btn ) : ?>
					<div class="awea-number-box-btn-wrap">
						<a <?php echo $this->get_render_attribute_string( 'awea_action_link' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<span><?php echo esc_html( $btn_text ); ?></span>
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
								<line x1="5" y1="12" x2="19" y2="12"></line>
								<polyline points="12 5 19 12 12 19"></polyline>
							</svg>
						</a>
					</div>
				<?php endif; ?>
			</div>

		</div>
		<?php
	}
}