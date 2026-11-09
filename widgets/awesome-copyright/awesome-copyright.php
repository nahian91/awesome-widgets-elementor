<?php
/**
 * Awesome Copyright Studio Widget.
 * Clean, automated copyright notice with dynamic year & site title tokens.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.7.0
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

class Widget_Awesome_Copyright extends Widget_Base {

	public function get_name() {
		return 'awesome-copyright';
	}

	public function get_title() {
		return esc_html__( 'Copyright Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-library-copy';
	}

	public function get_categories() {
		return [ 'awesome-header-footer', 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'copyright', 'footer', 'year', 'legal', 'credits', 'notice' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: COPYRIGHT NOTICE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_copyright_content',
			[
				'label' => esc_html__( 'Copyright Notice', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_copyright_text',
			[
				'label'       => esc_html__( 'Notice Template', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => esc_html__( 'Copyright {copy} {year} {site_title}. All rights reserved.', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Available tokens: {year}, {site_title}, {copy}', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_affiliate_notice',
			[
				'label'       => esc_html__( 'Additional Secondary Notice (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'Crafted with precision.', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TEXT & ALIGNMENT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_text',
			[
				'label' => esc_html__( 'Text & Links', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_align',
			[
				'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-copyright-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-copyright-wrap' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_text_typography',
				'selector' => '{{WRAPPER}} .awea-copyright-wrap',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		// Link Colors
		$this->add_control(
			'awea_heading_link_style',
			[
				'label'     => esc_html__( 'Links Inside Notice', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'awea_link_tabs' );

		// Normal
		$this->start_controls_tab(
			'awea_link_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-copyright-wrap a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab(
			'awea_link_tab_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_link_hover_color',
			[
				'label'     => esc_html__( 'Link Hover Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-copyright-wrap a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'awea_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-copyright-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$raw_text = $settings['awea_copyright_text'] ?? '';
		$extra    = $settings['awea_affiliate_notice'] ?? '';

		$current_year = date_i18n( 'Y' );
		$site_title   = get_bloginfo( 'name' );

		// Dynamic Token Replacements
		$replacements = [
			'{year}'         => esc_html( $current_year ),
			'{current_year}' => esc_html( $current_year ),
			'{site_title}'   => esc_html( $site_title ),
			'{copy}'         => '&copy;',
		];

		$output = str_replace( array_keys( $replacements ), array_values( $replacements ), $raw_text );
		?>
		<div class="awea-copyright-wrap">
			<span class="awea-copyright-text"><?php echo wp_kses_post( $output ); ?></span>
			<?php if ( ! empty( $extra ) ) : ?>
				<span class="awea-copyright-divider" aria-hidden="true">•</span>
				<span class="awea-copyright-extra"><?php echo esc_html( $extra ); ?></span>
			<?php endif; ?>
		</div>
		<?php
	}
}