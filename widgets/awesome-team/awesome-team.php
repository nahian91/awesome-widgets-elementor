<?php
/**
 * Awesome Team Widget.
 * Modern Glassmorphic Team Member Card with Smooth Dock Hover Mechanics.
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
use \Elementor\Group_Control_Image_Size;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Team extends Widget_Base {

	public function get_name() {
		return 'awesome-team';
	}

	public function get_title() {
		return esc_html__( 'Team Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-user-circle-o';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'team', 'member', 'profile', 'avatar', 'staff', 'card' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: MEMBER PROFILE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_member_profile',
			[
				'label' => esc_html__( 'Member Profile', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_member_image',
			[
				'label'   => esc_html__( 'Profile Photo', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'awea_member_image_size',
				'default'   => 'large',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'awea_member_name',
			[
				'label'       => esc_html__( 'Full Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Alexander Vance', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'awea_member_role',
			[
				'label'       => esc_html__( 'Role / Position', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Lead Design Architect', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_member_bio',
			[
				'label'       => esc_html__( 'Short Bio (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Enter a brief 1-2 sentence introduction...', 'awesome-widgets-elementor' ),
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: SOCIAL CONNECT CHANNELS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_member_socials',
			[
				'label' => esc_html__( 'Social Dock', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater_socials = new Repeater();

		$repeater_socials->add_control(
			'awea_social_title',
			[
				'label'       => esc_html__( 'Platform Name', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'LinkedIn', 'awesome-widgets-elementor' ),
				'label_block' => true,
			]
		);

		$repeater_socials->add_control(
			'awea_social_icon',
			[
				'label'   => esc_html__( 'Platform Icon', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fab fa-linkedin-in',
					'library' => 'fa-brands',
				],
			]
		);

		$repeater_socials->add_control(
			'awea_social_url',
			[
				'label'       => esc_html__( 'Profile Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://linkedin.com/in/username',
				'default'     => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$repeater_socials->add_control(
			'awea_social_brand_color',
			[
				'label'     => esc_html__( 'Accent Glow Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0a66c2',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--awea-social-brand: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_social_list',
			[
				'label'       => esc_html__( 'Social Channels', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater_socials->get_controls(),
				'default'     => [
					[
						'awea_social_title'       => esc_html__( 'LinkedIn', 'awesome-widgets-elementor' ),
						'awea_social_icon'        => [ 'value' => 'fab fa-linkedin-in', 'library' => 'fa-brands' ],
						'awea_social_brand_color' => '#0a66c2',
					],
					[
						'awea_social_title'       => esc_html__( 'X (Twitter)', 'awesome-widgets-elementor' ),
						'awea_social_icon'        => [ 'value' => 'fab fa-x-twitter', 'library' => 'fa-brands' ],
						'awea_social_brand_color' => '#000000',
					],
					[
						'awea_social_title'       => esc_html__( 'GitHub', 'awesome-widgets-elementor' ),
						'awea_social_icon'        => [ 'value' => 'fab fa-github', 'library' => 'fa-brands' ],
						'awea_social_brand_color' => '#24292f',
					],
				],
				'title_field' => '{{{ awea_social_title }}}',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: CARD CONTAINER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_card',
			[
				'label' => esc_html__( 'Card Shell', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_aspect_ratio',
			[
				'label'     => esc_html__( 'Photo Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4/5',
				'options'   => [
					'1/1'  => '1:1 Square',
					'4/5'  => '4:5 Classic Portrait',
					'3/4'  => '3:4 Editorial',
					'16/9' => '16:9 Landscape',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-team-img-container' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default'    => [ 'top' => '32', 'right' => '32', 'bottom' => '32', 'left' => '32', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-team-master-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Outer Shell Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '12', 'right' => '12', 'bottom' => '12', 'left' => '12', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-team-master-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_card_state_tabs' );

		// Normal Tab
		$this->start_controls_tab(
			'awea_card_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg_color',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#090d16',
				'selectors' => [
					'{{WRAPPER}} .awea-team-master-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-team-master-card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-team-master-card',
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'awea_card_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_card_bg_color_hover',
			[
				'label'     => esc_html__( 'Card Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#090d16',
				'selectors' => [
					'{{WRAPPER}} .awea-team-master-card:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow_hover',
				'selector' => '{{WRAPPER}} .awea-team-master-card:hover',
			]
		);

		$this->add_responsive_control(
			'awea_card_hover_lift',
			[
				'label'      => esc_html__( 'Hover Lift (Y-Axis)', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => -30, 'max' => 0 ] ],
				'default'    => [ 'unit' => 'px', 'size' => -10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-team-master-card:hover' => 'transform: translateY({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: FROSTED GLASS INFO PANEL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_panel',
			[
				'label' => esc_html__( 'Frosted Info Dock', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_panel_bg',
			[
				'label'     => esc_html__( 'Glass Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.72)',
				'selectors' => [
					'{{WRAPPER}} .awea-team-info-panel' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_panel_radius',
			[
				'label'      => esc_html__( 'Dock Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default'    => [ 'top' => '22', 'right' => '22', 'bottom' => '22', 'left' => '22', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-team-info-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_panel_padding',
			[
				'label'      => esc_html__( 'Internal Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-team-info-panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_panel_border',
				'selector' => '{{WRAPPER}} .awea-team-info-panel',
			]
		);

		// Typography: Name
		$this->add_control(
			'awea_heading_name_style',
			[
				'label'     => esc_html__( 'Name Typography', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_name_color',
			[
				'label'     => esc_html__( 'Name Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-team-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_name_typo',
				'selector' => '{{WRAPPER}} .awea-team-name',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Typography: Role
		$this->add_control(
			'awea_heading_role_style',
			[
				'label'     => esc_html__( 'Role Typography', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_role_color',
			[
				'label'     => esc_html__( 'Role Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-team-role' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_role_typo',
				'selector' => '{{WRAPPER}} .awea-team-role',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		// Typography: Bio
		$this->add_control(
			'awea_heading_bio_style',
			[
				'label'     => esc_html__( 'Bio Typography', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_bio_color',
			[
				'label'     => esc_html__( 'Bio Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#94a3b8',
				'selectors' => [
					'{{WRAPPER}} .awea-team-bio' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_bio_typo',
				'selector' => '{{WRAPPER}} .awea-team-bio',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: SOCIAL BUTTONS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_socials',
			[
				'label' => esc_html__( 'Social Buttons', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_social_btn_size',
			[
				'label'      => esc_html__( 'Button Dimensions', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 28, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 38 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-team-social-btn' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_social_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-team-social-btn i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .awea-team-social-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_social_state_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_social_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_social_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-team-social-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_social_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.1)',
				'selectors' => [
					'{{WRAPPER}} .awea-team-social-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_social_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_social_hover_color',
			[
				'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-team-social-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_social_hover_bg',
			[
				'label'     => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-team-social-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$name         = $settings['awea_member_name'] ?? '';
		$role         = $settings['awea_member_role'] ?? '';
		$bio          = $settings['awea_member_bio'] ?? '';
		$social_list  = $settings['awea_social_list'] ?? [];
		$img_url      = ! empty( $settings['awea_member_image']['url'] ) ? $settings['awea_member_image']['url'] : Utils::get_placeholder_image_src();
		?>
		<article class="awea-team-master-card">
			<!-- Image Canvas -->
			<div class="awea-team-img-container">
				<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'awea_member_image_size', 'awea_member_image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<div class="awea-team-scrim"></div>
			</div>

			<!-- Floating Frosted Glass Dock -->
			<div class="awea-team-info-panel">
				<?php if ( ! empty( $name ) ) : ?>
					<h3 class="awea-team-name"><?php echo esc_html( $name ); ?></h3>
				<?php endif; ?>

				<?php if ( ! empty( $role ) ) : ?>
					<span class="awea-team-role"><?php echo esc_html( $role ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $bio ) ) : ?>
					<p class="awea-team-bio"><?php echo esc_html( $bio ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $social_list ) ) : ?>
					<div class="awea-team-social-dock">
						<?php
						foreach ( $social_list as $index => $social ) :
							$link_key = 'awea_social_link_' . $index;
							$title    = $social['awea_social_title'] ?? '';

							if ( ! empty( $social['awea_social_url']['url'] ) ) {
								$this->add_link_attributes( $link_key, $social['awea_social_url'] );
							} else {
								$this->add_render_attribute( $link_key, 'href', '#' );
							}

							$this->add_render_attribute( $link_key, 'class', 'awea-team-social-btn elementor-repeater-item-' . esc_attr( $social['_id'] ) );
							$this->add_render_attribute( $link_key, 'aria-label', esc_attr( $title ) );
							$this->add_render_attribute( $link_key, 'title', esc_attr( $title ) );
							?>
							<a <?php echo $this->get_render_attribute_string( $link_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
								<?php Icons_Manager::render_icon( $social['awea_social_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</article>
		<?php
	}
}