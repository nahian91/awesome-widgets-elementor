<?php
/**
 * Awesome Site Logo Widget.
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
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;

class Widget_Awesome_Site_Logo extends Widget_Base {

	public function get_name() {
		return 'awesome-site-logo';
	}

	public function get_title() {
		return esc_html__( 'Site Logo', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-site-logo';
	}

	public function get_categories() {
		return [ 'awesome-header-footer', 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'logo', 'site logo', 'brand', 'image', 'header', 'identity' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. LOGO SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_sl_section_logo',
			[
				'label' => esc_html__( 'Logo Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_sl_logo_type',
			[
				'label'   => esc_html__( 'Logo Type', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'image' => esc_html__( 'Image / SVG', 'awesome-widgets-elementor' ),
					'text'  => esc_html__( 'Brand Text', 'awesome-widgets-elementor' ),
				],
			]
		);

		// IMAGE CONTROLS
		$this->add_control(
			'awea_sl_logo_source',
			[
				'label'     => esc_html__( 'Image Source', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'custom',
				'options'   => [
					'custom'    => esc_html__( 'Custom Upload', 'awesome-widgets-elementor' ),
					'site_logo' => esc_html__( 'WordPress Site Logo', 'awesome-widgets-elementor' ),
				],
				'condition' => [
					'awea_sl_logo_type' => 'image',
				],
			]
		);

		$this->add_control(
			'awea_sl_custom_logo',
			[
				'label'     => esc_html__( 'Choose Image', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'awea_sl_logo_type'   => 'image',
					'awea_sl_logo_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'awea_sl_enable_hover_logo',
			[
				'label'        => esc_html__( 'Swap Image on Hover', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'awea_sl_logo_type'   => 'image',
					'awea_sl_logo_source' => 'custom',
				],
			]
		);

		$this->add_control(
			'awea_sl_custom_hover_logo',
			[
				'label'     => esc_html__( 'Hover Image', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'awea_sl_logo_type'            => 'image',
					'awea_sl_logo_source'          => 'custom',
					'awea_sl_enable_hover_logo' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'awea_sl_logo_image_size',
				'default'   => 'full',
				'condition' => [
					'awea_sl_logo_type'   => 'image',
					'awea_sl_logo_source' => 'custom',
				],
			]
		);

		// TEXT CONTROLS
		$this->add_control(
			'awea_sl_text_logo_title',
			[
				'label'     => esc_html__( 'Brand Name', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => get_bloginfo( 'name' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'awea_sl_logo_type' => 'text',
				],
			]
		);

		$this->add_control(
			'awea_sl_show_tagline',
			[
				'label'        => esc_html__( 'Show Tagline', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'awea_sl_logo_type' => 'text',
				],
			]
		);

		$this->add_control(
			'awea_sl_text_logo_tagline',
			[
				'label'     => esc_html__( 'Tagline Text', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => get_bloginfo( 'description' ),
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'awea_sl_logo_type'       => 'text',
					'awea_sl_show_tagline' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. LINK & ALIGNMENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_sl_section_layout',
			[
				'label' => esc_html__( 'Link & Alignment', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_sl_link_type',
			[
				'label'   => esc_html__( 'Link Destination', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'home',
				'options' => [
					'none'   => esc_html__( 'No Link', 'awesome-widgets-elementor' ),
					'home'   => esc_html__( 'Homepage', 'awesome-widgets-elementor' ),
					'custom' => esc_html__( 'Custom URL', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_sl_custom_link',
			[
				'label'       => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'dynamic'     => [ 'active' => true ],
				'condition'   => [
					'awea_sl_link_type' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sl_alignment',
			[
				'label'                => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'              => 'left',
				'selectors_dictionary' => [
					'left'   => 'text-align: left; --awea-sl-align: flex-start;',
					'center' => 'text-align: center; --awea-sl-align: center;',
					'right'  => 'text-align: right; --awea-sl-align: flex-end;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-site-logo-outer' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. LOGO IMAGE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_sl_style_image',
			[
				'label'     => esc_html__( 'Logo Image', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_sl_logo_type' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sl_logo_width',
			[
				'label'      => esc_html__( 'Logo Width', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [ 'min' => 20, 'max' => 600 ],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 160,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-site-logo-wrap img' => 'width: {{SIZE}}{{UNIT}}; max-width: 100%; height: auto;',
					'{{WRAPPER}} .awea-site-logo-wrap svg' => 'width: {{SIZE}}{{UNIT}}; max-width: 100%; height: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sl_logo_max_height',
			[
				'label'      => esc_html__( 'Maximum Height', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 15, 'max' => 250 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-site-logo-wrap img' => 'max-height: {{SIZE}}{{UNIT}}; object-fit: contain;',
					'{{WRAPPER}} .awea-site-logo-wrap svg' => 'max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sl_logo_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-site-logo-wrap img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_sl_logo_border',
				'selector' => '{{WRAPPER}} .awea-site-logo-wrap img',
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'awea_sl_logo_filter',
				'label'    => esc_html__( 'Image Filters', 'awesome-widgets-elementor' ),
				'selector' => '{{WRAPPER}} .awea-site-logo-wrap img',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. BRAND TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_sl_style_title',
			[
				'label'     => esc_html__( 'Brand Text', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_sl_logo_type' => 'text',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_sl_title_typo',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
				'selector' => '{{WRAPPER}} .awe-logo-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'awea_sl_title_shadow',
				'selector' => '{{WRAPPER}} .awe-logo-title',
			]
		);

		$this->start_controls_tabs( 'awea_sl_title_tabs' );

		$this->start_controls_tab(
			'awea_sl_title_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_sl_title_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awe-logo-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_sl_title_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_sl_title_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awe-logo-link:hover .awe-logo-title, {{WRAPPER}} .awe-logo-link:focus-visible .awe-logo-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. TAGLINE TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_sl_style_tagline',
			[
				'label'     => esc_html__( 'Tagline Text', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'awea_sl_logo_type'       => 'text',
					'awea_sl_show_tagline' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_sl_tagline_typo',
				'selector' => '{{WRAPPER}} .awe-logo-tagline',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_sl_tagline_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awe-logo-tagline' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_sl_tagline_space',
			[
				'label'      => esc_html__( 'Space Above Tagline', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 4 ],
				'selectors'  => [
					'{{WRAPPER}} .awe-logo-tagline' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$logo_type = $settings['awea_sl_logo_type'] ?? 'image';
		$link_type = $settings['awea_sl_link_type'] ?? 'home';
		$site_name = get_bloginfo( 'name' );

		$has_link = false;
		if ( 'home' === $link_type ) {
			$this->add_render_attribute( 'awea_sl_link', 'href', esc_url( home_url( '/' ) ) );
			$this->add_render_attribute( 'awea_sl_link', 'rel', 'home' );
			$has_link = true;
		} elseif ( 'custom' === $link_type && ! empty( $settings['awea_sl_custom_link']['url'] ) ) {
			$this->add_link_attributes( 'awea_sl_link', $settings['awea_sl_custom_link'] );
			$has_link = true;
		}

		if ( $has_link ) {
			$this->add_render_attribute( 'awea_sl_link', 'class', 'awea-logo-link' );
			if ( 'text' !== $logo_type && ! empty( $site_name ) ) {
				$this->add_render_attribute( 'awea_sl_link', 'aria-label', esc_attr( $site_name ) );
			}
		}

		$this->add_inline_editing_attributes( 'awea_sl_text_logo_title', 'none' );
		$this->add_inline_editing_attributes( 'awea_sl_text_logo_tagline', 'none' );
		$this->add_render_attribute( 'awea_sl_text_logo_title', 'class', 'awe-logo-title' );
		$this->add_render_attribute( 'awea_sl_text_logo_tagline', 'class', 'awe-logo-tagline' );
		?>
		<div class="awea-site-logo-outer">
			<div class="awea-site-logo-wrap">
				<?php if ( $has_link ) : ?>
					<a <?php $this->print_render_attribute_string( 'awea_sl_link' ); ?>>
				<?php else : ?>
					<div class="awea-logo-link">
				<?php endif; ?>

					<?php if ( 'text' === $logo_type ) : ?>
						<div class="awea-text-logo-group">
							<span <?php $this->print_render_attribute_string( 'awea_sl_text_logo_title' ); ?>>
								<?php echo esc_html( $settings['awea_sl_text_logo_title'] ?? '' ); ?>
							</span>
							<?php if ( 'yes' === ( $settings['awea_sl_show_tagline'] ?? 'no' ) && ! empty( $settings['awea_sl_text_logo_tagline'] ) ) : ?>
								<span <?php $this->print_render_attribute_string( 'awea_sl_text_logo_tagline' ); ?>>
									<?php echo esc_html( $settings['awea_sl_text_logo_tagline'] ); ?>
								</span>
							<?php endif; ?>
						</div>
					<?php else : ?>
						<?php
						$source         = $settings['awea_sl_logo_source'] ?? 'custom';
						$has_hover_logo = ( 'yes' === ( $settings['awea_sl_enable_hover_logo'] ?? 'no' ) ) && ! empty( $settings['awea_sl_custom_hover_logo']['url'] );
						$primary_html   = '';
						$hover_html     = '';

						if ( 'site_logo' === $source && function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$primary_html   = wp_get_attachment_image( $custom_logo_id, 'full', false, [ 'class' => 'awe-primary-logo awe-logo-image' ] );
						} elseif ( ! empty( $settings['awea_sl_custom_logo']['url'] ) ) {
							$image_html   = Group_Control_Image_Size::get_attachment_image_html( $settings, 'awea_sl_logo_image_size', 'awea_sl_custom_logo' );
							$primary_html = ! empty( $image_html ) ? $image_html : '<img src="' . esc_url( $settings['awea_sl_custom_logo']['url'] ) . '" alt="' . esc_attr( $site_name ) . '" class="awe-primary-logo" />';
						} else {
							$primary_html = '<span class="awe-logo-title">' . esc_html( $site_name ) . '</span>';
						}

						if ( $has_hover_logo ) {
							$hover_html = '<img src="' . esc_url( $settings['awea_sl_custom_hover_logo']['url'] ) . '" alt="' . esc_attr( $site_name ) . '" class="awe-hover-logo" />';
						}
						?>
						<div class="awe-image-logo-group <?php echo $has_hover_logo ? 'has-hover-logo' : ''; ?>">
							<?php echo $primary_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php if ( $has_hover_logo ) : ?>
								<?php echo $hover_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>

				<?php if ( $has_link ) : ?>
					</a>
				<?php else : ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}