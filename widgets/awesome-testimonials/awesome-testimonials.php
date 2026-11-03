<?php
/**
 * Awesome Testimonials Widget.
 * Architectural Design with Kinetic Physics & Dynamic Rating.
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
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Testimonials extends Widget_Base {

	public function get_name() {
		return 'awesome-testimonials';
	}

	public function get_title() {
		return esc_html__( 'Testimonials Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'testimonial', 'review', 'rating', 'feedback', 'quote', 'client' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: TESTIMONIAL CONTENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_testi_content',
			[
				'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_rating_val',
			[
				'label'   => esc_html__( 'Star Rating', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '5',
				'dynamic' => [ 'active' => true ],
				'options' => [
					'0' => esc_html__( '0 Stars (None)', 'awesome-widgets-elementor' ),
					'1' => esc_html__( '1 Star', 'awesome-widgets-elementor' ),
					'2' => esc_html__( '2 Stars', 'awesome-widgets-elementor' ),
					'3' => esc_html__( '3 Stars', 'awesome-widgets-elementor' ),
					'4' => esc_html__( '4 Stars', 'awesome-widgets-elementor' ),
					'5' => esc_html__( '5 Stars (Full)', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_testi_speech',
			[
				'label'       => esc_html__( 'Testimonial Speech', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 6,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'The architectural depth and kinetic physics of this UI is purely world-class. It transformed our client delivery pipeline within 48 hours.', 'awesome-widgets-elementor' ),
				'placeholder' => esc_html__( 'Enter client testimonial text...', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_testi_image',
			[
				'label'   => esc_html__( 'Author Avatar', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'awea_testi_name',
			[
				'label'       => esc_html__( 'Author Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Julian Vance', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_testi_desg',
			[
				'label'       => esc_html__( 'Designation / Role', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Design Director at Linear', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_show_verified_badge',
			[
				'label'        => esc_html__( 'Verified Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_show_quote_icon',
			[
				'label'        => esc_html__( 'Quote Watermark', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: CARD CONTAINER & KINETIC BEAM
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
				'label'      => esc_html__( 'Card Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '36', 'right' => '36', 'bottom' => '36', 'left' => '36', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .awea-testimonial-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_card_state_tabs' );

		// Normal Card State
		$this->start_controls_tab(
			'awea_card_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg_color',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-testimonial-card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-testimonial-card',
			]
		);

		$this->end_controls_tab();

		// Hover Card State
		$this->start_controls_tab(
			'awea_card_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg_hover_color',
			[
				'label'     => esc_html__( 'Hover Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-testimonial-card:hover',
			]
		);

		$this->add_control(
			'awea_card_hover_lift',
			[
				'label'      => esc_html__( 'Hover Lift (Y-Axis)', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => -30, 'max' => 0 ] ],
				'default'    => [ 'unit' => 'px', 'size' => -8 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-card:hover' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Kinetic Beam Header
		$this->add_control(
			'awea_beam_heading',
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
					'{{WRAPPER}} .awea-testimonial-card' => '--awea-beam-color: {{VALUE}};',
				],
				'condition' => [ 'awea_enable_beam' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_beam_speed',
			[
				'label'      => esc_html__( 'Beam Spin Speed (s)', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range'      => [ 's' => [ 'min' => 1, 'max' => 10, 'step' => 0.5 ] ],
				'default'    => [ 'unit' => 's', 'size' => 3.5 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-card' => '--awea-beam-speed: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 'awea_enable_beam' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: RATING STARS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_stars',
			[
				'label' => esc_html__( 'Rating Stars', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_star_size',
			[
				'label'      => esc_html__( 'Star Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 36 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-stars i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_star_gap',
			[
				'label'      => esc_html__( 'Gap Between Stars', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 2, 'max' => 16 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 5 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-stars' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_star_filled_color',
			[
				'label'     => esc_html__( 'Filled Star Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f59e0b',
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-stars .awea-star-filled' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_star_empty_color',
			[
				'label'     => esc_html__( 'Empty Star Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-stars .awea-star-empty' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TESTIMONIAL TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_speech',
			[
				'label' => esc_html__( 'Review Speech', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_speech_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_speech_typography',
				'selector' => '{{WRAPPER}} .awea-testimonial-text',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_responsive_control(
			'awea_speech_margin_bottom',
			[
				'label'      => esc_html__( 'Bottom Margin', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: AUTHOR FOOTER & AVATAR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_author',
			[
				'label' => esc_html__( 'Author & Meta', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Avatar Heading
		$this->add_control(
			'awea_heading_avatar',
			[
				'label' => esc_html__( 'Avatar', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'awea_avatar_size',
			[
				'label'      => esc_html__( 'Avatar Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 30, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 52 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_avatar_radius',
			[
				'label'      => esc_html__( 'Avatar Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '100', 'right' => '100', 'bottom' => '100', 'left' => '100', 'unit' => '%', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-testimonial-avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_avatar_border',
				'selector' => '{{WRAPPER}} .awea-testimonial-avatar',
			]
		);

		// Author Name & Role
		$this->add_control(
			'awea_heading_author_text',
			[
				'label'     => esc_html__( 'Author Typography', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_name_color',
			[
				'label'     => esc_html__( 'Name Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_name_typography',
				'selector' => '{{WRAPPER}} .awea-testimonial-name',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'awea_desg_color',
			[
				'label'     => esc_html__( 'Designation Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-desg' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_desg_typography',
				'selector' => '{{WRAPPER}} .awea-testimonial-desg',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		// Verified Badge
		$this->add_control(
			'awea_heading_verified_style',
			[
				'label'     => esc_html__( 'Verified Badge', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_show_verified_badge' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_verified_bg_color',
			[
				'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#dcfce7',
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-verify' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'awea_show_verified_badge' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_verified_icon_color',
			[
				'label'     => esc_html__( 'Badge Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#15803d',
				'selectors' => [
					'{{WRAPPER}} .awea-testimonial-verify svg' => 'color: {{VALUE}};',
				],
				'condition' => [ 'awea_show_verified_badge' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings_for_display();
		$rating     = absint( $settings['awea_rating_val'] );
		$has_beam   = 'yes' === ( $settings['awea_enable_beam'] ?? 'no' );
		$has_quote  = 'yes' === ( $settings['awea_show_quote_icon'] ?? 'no' );
		$has_verify = 'yes' === ( $settings['awea_show_verified_badge'] ?? 'no' );
		$avatar_url = $settings['awea_testi_image']['url'] ?? '';

		$card_classes = [ 'awea-testimonial-card' ];
		if ( $has_beam ) {
			$card_classes[] = 'awea-has-beam';
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">

			<?php if ( $has_quote ) : ?>
				<svg class="awea-testimonial-quote-brand" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
					<path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C15.4647 8 15.017 8.44772 15.017 9V12C15.017 12.5523 14.5693 13 14.017 13H13.017C12.4647 13 12.017 12.5523 12.017 12V9C12.017 6.79086 13.8079 5 16.017 5H19.017C21.2261 5 23.017 6.79086 23.017 9V15C23.017 18.866 19.883 22 16.017 22H14.017V21ZM2.01693 21L2.01693 18C2.01693 16.8954 2.91236 16 4.01693 16H7.01693C7.56921 16 8.01693 15.5523 8.01693 15V9C8.01693 8.44772 7.56921 8 7.01693 8H4.01693C3.46464 8 3.01693 8.44772 3.01693 9V12C3.01693 12.5523 2.56921 13 2.01693 13H1.01693C0.464645 13 -0.0169312 12.5523 -0.0169312 12V9C-0.0169312 6.79086 1.77393 5 4.01693 5H7.01693C9.22607 5 11.0169 6.79086 11.0169 9V15C11.0169 18.866 7.88297 22 4.01693 22H2.01693V21Z" />
				</svg>
			<?php endif; ?>

			<!-- Star Rating Strip -->
			<?php if ( $rating > 0 ) : ?>
				<div class="awea-testimonial-stars" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %s out of 5 stars', 'awesome-widgets-elementor' ), $rating ) ); ?>">
					<?php 
					for ( $i = 1; $i <= 5; $i++ ) {
						$star_class = ( $i <= $rating ) ? 'fas fa-star awea-star-filled' : 'far fa-star awea-star-empty';
						echo '<i class="' . esc_attr( $star_class ) . '" aria-hidden="true"></i>';
					}
					?>
				</div>
			<?php endif; ?>

			<!-- Testimonial Quote Speech -->
			<blockquote class="awea-testimonial-text">
				&ldquo;<?php echo esc_html( $settings['awea_testi_speech'] ); ?>&rdquo;
			</blockquote>

			<!-- Author Footer Lockup -->
			<div class="awea-testimonial-footer">
				<?php if ( ! empty( $avatar_url ) ) : ?>
					<img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $settings['awea_testi_name'] ); ?>" class="awea-testimonial-avatar" loading="lazy" />
				<?php endif; ?>
				
				<div class="awea-testimonial-meta">
					<h4 class="awea-testimonial-name"><?php echo esc_html( $settings['awea_testi_name'] ); ?></h4>
					<cite class="awea-testimonial-desg"><?php echo esc_html( $settings['awea_testi_desg'] ); ?></cite>
				</div>

				<?php if ( $has_verify ) : ?>
					<div class="awea-testimonial-verify" title="<?php esc_attr_e( 'Verified Customer', 'awesome-widgets-elementor' ); ?>">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
							<polyline points="20 6 9 17 4 12"></polyline>
						</svg>
					</div>
				<?php endif; ?>
			</div>

		</div>
		<?php
	}
}