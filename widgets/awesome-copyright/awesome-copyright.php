<?php
/**
 * Awesome Copyright Widget.
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
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Utils;

class Widget_Awesome_Copyright extends Widget_Base {

	public function get_name() {
		return 'awesome-copyright';
	}

	public function get_title() {
		return esc_html__( 'Copyright', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-library-copy';
	}

	public function get_categories() {
		return [ 'awesome-header-footer' ];
	}

	public function get_keywords() {
		return [ 'awea', 'copyright', 'footer', 'year', 'legal', 'notice', 'credits' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: 1. COPYRIGHT NOTICE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cp_section_copyright',
			[
				'label' => esc_html__( 'Copyright Notice', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cp_text',
			[
				'label'       => esc_html__( 'Main Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => esc_html__( 'Copyright {copy} {year} {site_title}. All rights reserved.', 'awesome-widgets-elementor' ),
				'description' => esc_html__( 'Smart tags: {copy}, {reg}, {tm}, {year}, {year_range}, {site_title}, {site_link}, {author_name}', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'awea_cp_start_year',
			[
				'label'       => esc_html__( 'Start Year (for {year_range})', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => '2020',
				'description' => esc_html__( 'Shows e.g. 2020–2026 when {year_range} is used.', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_cp_author_name',
			[
				'label'     => esc_html__( 'Credit / Author Name', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Studio Nahian', 'awesome-widgets-elementor' ),
				'dynamic'   => [ 'active' => true ],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_cp_author_url',
			[
				'label'       => esc_html__( 'Credit Link URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
				'condition'   => [ 'awea_cp_author_name!' => '' ],
			]
		);

		$this->add_control(
			'awea_cp_html_tag',
			[
				'label'     => esc_html__( 'HTML Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'div',
				'separator' => 'before',
				'options'   => [
					'div'    => 'div',
					'p'      => 'p',
					'span'   => 'span',
					'footer' => 'footer',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 2. EXTRA TEXT & LEGAL LINKS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cp_section_secondary',
			[
				'label' => esc_html__( 'Extra Text & Links', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cp_enable_secondary',
			[
				'label'        => esc_html__( 'Show Extra Text', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'awea_cp_secondary_text',
			[
				'label'       => esc_html__( 'Extra Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Crafted with precision.', 'awesome-widgets-elementor' ),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_cp_enable_secondary' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_cp_secondary_link',
			[
				'label'       => esc_html__( 'Extra Text Link', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_cp_enable_secondary' => 'yes' ],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'awea_cp_legal_label',
			[
				'label'       => esc_html__( 'Link Text', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Privacy Policy', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_cp_legal_url',
			[
				'label'       => esc_html__( 'Link URL', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'default'     => [ 'url' => '#' ],
				'placeholder' => 'https://example.com/privacy',
			]
		);

		$this->add_control(
			'awea_cp_legal_links',
			[
				'label'       => esc_html__( 'Quick Footer Links', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ awea_cp_legal_label }}}',
				'separator'   => 'before',
				'default'     => [],
			]
		);

		$this->add_control(
			'awea_cp_separator_symbol',
			[
				'label'     => esc_html__( 'Divider Symbol', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '•',
				'separator' => 'before',
				'options'   => [
					'•' => esc_html__( 'Bullet ( • )', 'awesome-widgets-elementor' ),
					'|' => esc_html__( 'Pipe ( | )', 'awesome-widgets-elementor' ),
					'/' => esc_html__( 'Slash ( / )', 'awesome-widgets-elementor' ),
					'—' => esc_html__( 'Dash ( — )', 'awesome-widgets-elementor' ),
					''  => esc_html__( 'None', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: 3. LAYOUT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cp_section_layout',
			[
				'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_cp_layout_mode',
			[
				'label'        => esc_html__( 'Arrangement', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'inline',
				'options'      => [
					'inline' => esc_html__( 'Side by Side (Inline)', 'awesome-widgets-elementor' ),
					'stack'  => esc_html__( 'Stacked (One Below Another)', 'awesome-widgets-elementor' ),
				],
				'prefix_class' => 'awea-cp-dir-',
			]
		);

		$this->add_responsive_control(
			'awea_cp_align',
			[
				'label'                => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'    => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Spread Apart (Left & Right)', 'awesome-widgets-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'              => 'center',
				'selectors_dictionary' => [
					'left'    => 'justify-content: flex-start; text-align: left;',
					'center'  => 'justify-content: center; text-align: center;',
					'right'   => 'justify-content: flex-end; text-align: right;',
					'justify' => 'justify-content: space-between; text-align: left;',
				],
				'selectors'            => [
					'{{WRAPPER}} .awea-cp-wrap' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cp_items_gap',
			[
				'label'      => esc_html__( 'Space Between Items', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 36 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cp-wrap, {{WRAPPER}} .awea-cp-meta-group' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 1. OUTER BOX
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cp_style_container',
			[
				'label' => esc_html__( 'Outer Box', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_cp_padding',
			[
				'label'      => esc_html__( 'Inner Spacing', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'rem', '%' ],
				'default'    => [
					'top'      => '16',
					'right'    => '24',
					'bottom'   => '16',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .awea-cp-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_cp_radius',
			[
				'label'      => esc_html__( 'Corner Roundness', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-cp-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'awea_cp_bg_group',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-cp-wrap',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_cp_border',
				'selector' => '{{WRAPPER}} .awea-cp-wrap',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_cp_shadow',
				'selector' => '{{WRAPPER}} .awea-cp-wrap',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 2. MAIN TEXT
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cp_style_text',
			[
				'label' => esc_html__( 'Main Text', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_cp_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cp-primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cp_text_typo',
				'selector' => '{{WRAPPER}} .awea-cp-primary',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 3. EXTRA TEXT & DIVIDER
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cp_style_secondary',
			[
				'label' => esc_html__( 'Extra Text & Divider', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_cp_secondary_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_SECONDARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-cp-secondary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_cp_secondary_typo',
				'selector' => '{{WRAPPER}} .awea-cp-secondary',
				'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ],
			]
		);

		$this->add_control(
			'awea_cp_sep_heading',
			[
				'label'     => esc_html__( 'Divider Symbol', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_cp_separator_symbol!' => '' ],
			]
		);

		$this->add_control(
			'awea_cp_sep_color',
			[
				'label'     => esc_html__( 'Divider Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cp-sep' => 'color: {{VALUE}}; opacity: 1;',
				],
				'condition' => [ 'awea_cp_separator_symbol!' => '' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: 4. LINKS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_cp_style_links',
			[
				'label' => esc_html__( 'Links', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_cp_link_weight',
			[
				'label'     => esc_html__( 'Font Weight', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''    => esc_html__( 'Default', 'awesome-widgets-elementor' ),
					'400' => '400 (Regular)',
					'500' => '500 (Medium)',
					'600' => '600 (Semi Bold)',
					'700' => '700 (Bold)',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-cp-wrap a' => 'font-weight: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cp_link_underline',
			[
				'label'     => esc_html__( 'Underline Style', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'underline',
				'options'   => [
					'underline' => esc_html__( 'Always Underlined', 'awesome-widgets-elementor' ),
					'none'      => esc_html__( 'No Underline', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea-cp-wrap a' => 'text-decoration: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_cp_link_tabs' );

		$this->start_controls_tab(
			'awea_cp_link_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cp_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
				'selectors' => [
					'{{WRAPPER}} .awea-cp-wrap a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'awea_cp_link_hover',
			[ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_cp_link_color_hover',
			[
				'label'     => esc_html__( 'Link Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
				'selectors' => [
					'{{WRAPPER}} .awea-cp-wrap a:hover, {{WRAPPER}} .awea-cp-wrap a:focus-visible' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_cp_link_hover_underline',
			[
				'label'     => esc_html__( 'Hover Underline', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''          => esc_html__( 'Default', 'awesome-widgets-elementor' ),
					'underline' => esc_html__( 'Show Underline', 'awesome-widgets-elementor' ),
					'none'      => esc_html__( 'Hide Underline', 'awesome-widgets-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awea-cp-wrap a:hover, {{WRAPPER}} .awea-cp-wrap a:focus-visible' => 'text-decoration: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$raw_text    = $settings['awea_cp_text'] ?? '';
		$start_year  = trim( $settings['awea_cp_start_year'] ?? '' );
		$tag         = Utils::validate_html_tag( $settings['awea_cp_html_tag'] ?? 'div' );
		$show_extra  = 'yes' === ( $settings['awea_cp_enable_secondary'] ?? '' );
		$extra_text  = $settings['awea_cp_secondary_text'] ?? '';
		$extra_link  = $settings['awea_cp_secondary_link'] ?? [];
		$legal_links = $settings['awea_cp_legal_links'] ?? [];
		$separator   = $settings['awea_cp_separator_symbol'] ?? '•';
		$author_name = $settings['awea_cp_author_name'] ?? '';
		$author_data = $settings['awea_cp_author_url'] ?? [];

		$current_year = date_i18n( 'Y' );
		$year_range   = ( ! empty( $start_year ) && $start_year !== $current_year )
			? $start_year . '–' . $current_year
			: $current_year;

		$site_title = get_bloginfo( 'name' );
		$site_url   = home_url( '/' );

		$site_link = sprintf(
			'<a href="%s">%s</a>',
			esc_url( $site_url ),
			esc_html( $site_title )
		);

		$author_link = '';
		if ( ! empty( $author_name ) ) {
			if ( ! empty( $author_data['url'] ) ) {
				$this->add_link_attributes( 'awea_cp_author_url', $author_data );
				$author_link = sprintf(
					'<a %s>%s</a>',
					$this->get_render_attribute_string( 'awea_cp_author_url' ),
					esc_html( $author_name )
				);
			} else {
				$author_link = esc_html( $author_name );
			}
		}

		$tokens = [
			'{year}'         => esc_html( $current_year ),
			'{current_year}' => esc_html( $current_year ),
			'{year_range}'   => esc_html( $year_range ),
			'{site_title}'   => esc_html( $site_title ),
			'{site_link}'    => $site_link,
			'{author_name}'  => $author_link,
			'{copy}'         => '&copy;',
			'{reg}'          => '&reg;',
			'{tm}'           => '&trade;',
		];

		$output = str_replace( array_keys( $tokens ), array_values( $tokens ), $raw_text );

		$has_extra_link = ! empty( $extra_link['url'] );
		if ( $has_extra_link ) {
			$this->add_link_attributes( 'awea_cp_secondary_url', $extra_link );
		}

		$valid_legals = array_filter( $legal_links, static function( $item ) {
			return ! empty( $item['awea_cp_legal_label'] );
		} );

		$has_meta_group = ( $show_extra && ! empty( $extra_text ) ) || ! empty( $valid_legals );
		?>
		<<?php Utils::print_validated_html_tag( $tag ); ?> class="awea-cp-wrap">
			<?php if ( ! empty( $output ) ) : ?>
				<span class="awea-cp-primary"><?php echo wp_kses_post( $output ); ?></span>
			<?php endif; ?>

			<?php if ( $has_meta_group ) : ?>
				<div class="awea-cp-meta-group">
					<?php if ( $show_extra && ! empty( $extra_text ) ) : ?>
						<?php if ( ! empty( $output ) && '' !== $separator ) : ?>
							<span class="awea-cp-sep awea-cp-sep-lead" aria-hidden="true"><?php echo esc_html( $separator ); ?></span>
						<?php endif; ?>

						<span class="awea-cp-secondary">
							<?php if ( $has_extra_link ) : ?>
								<a <?php $this->print_render_attribute_string( 'awea_cp_secondary_url' ); ?>><?php echo esc_html( $extra_text ); ?></a>
							<?php else : ?>
								<?php echo esc_html( $extra_text ); ?>
							<?php endif; ?>
						</span>
					<?php endif; ?>

					<?php if ( ! empty( $valid_legals ) ) : ?>
						<?php foreach ( $valid_legals as $idx => $legal ) :
							$l_key = 'awea_cp_legal_' . ( $legal['_id'] ?? $idx );
							$l_url = ! empty( $legal['awea_cp_legal_url']['url'] ) ? $legal['awea_cp_legal_url'] : [ 'url' => '#' ];
							$this->add_link_attributes( $l_key, $l_url );
							?>
							<?php if ( ( ! empty( $output ) || ( $show_extra && ! empty( $extra_text ) ) ) && '' !== $separator ) : ?>
								<span class="awea-cp-sep" aria-hidden="true"><?php echo esc_html( $separator ); ?></span>
							<?php endif; ?>
							<a <?php $this->print_render_attribute_string( $l_key ); ?> class="awea-cp-legal-link">
								<?php echo esc_html( $legal['awea_cp_legal_label'] ); ?>
							</a>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</<?php Utils::print_validated_html_tag( $tag ); ?>>
		<?php
	}

	/**
	 * Instant Live Editor Preview (Backbone.js Template).
	 */
	protected function content_template() {
		?>
		<#
		var tag        = elementor.helpers.validateHTMLTag( settings.awea_cp_html_tag || 'div' );
		var rawText    = _.escape( settings.awea_cp_text || '' );
		var startYear  = ( settings.awea_cp_start_year || '' ).trim();
		var currYear   = String( new Date().getFullYear() );
		var yearRange  = ( startYear && startYear !== currYear ) ? _.escape( startYear ) + '–' + currYear : currYear;
		var siteTitle  = _.escape( ( elementor.config.document && elementor.config.document.site_title ) || document.title || 'Site Title' );
		var siteLink   = '<a href="#">' + siteTitle + '</a>';
		var authorName = _.escape( settings.awea_cp_author_name || '' );
		var authorLink = authorName;

		if ( authorName && settings.awea_cp_author_url && settings.awea_cp_author_url.url ) {
			authorLink = '<a href="' + _.escape( settings.awea_cp_author_url.url ) + '">' + authorName + '</a>';
		}

		var output = rawText
			.replace( /\{year\}/g, currYear )
			.replace( /\{current_year\}/g, currYear )
			.replace( /\{year_range\}/g, yearRange )
			.replace( /\{site_title\}/g, siteTitle )
			.replace( /\{site_link\}/g, siteLink )
			.replace( /\{author_name\}/g, authorLink )
			.replace( /\{copy\}/g, '&copy;' )
			.replace( /\{reg\}/g, '&reg;' )
			.replace( /\{tm\}/g, '&trade;' );

		var showExtra  = 'yes' === settings.awea_cp_enable_secondary && settings.awea_cp_secondary_text;
		var legals     = _.filter( settings.awea_cp_legal_links || [], function( item ) { return item.awea_cp_legal_label; } );
		var sep        = settings.awea_cp_separator_symbol || '';
		var hasMeta    = showExtra || legals.length > 0;
		#>
		<{{{ tag }}} class="awea-cp-wrap">
			<# if ( output ) { #>
				<span class="awea-cp-primary">{{{ output }}}</span>
			<# } #>

			<# if ( hasMeta ) { #>
				<div class="awea-cp-meta-group">
					<# if ( showExtra ) { #>
						<# if ( output && sep ) { #>
							<span class="awea-cp-sep awea-cp-sep-lead" aria-hidden="true">{{ sep }}</span>
						<# } #>
						<span class="awea-cp-secondary">
							<# if ( settings.awea_cp_secondary_link && settings.awea_cp_secondary_link.url ) { #>
								<a href="{{ settings.awea_cp_secondary_link.url }}">{{ _.escape( settings.awea_cp_secondary_text ) }}</a>
							<# } else { #>
								{{ _.escape( settings.awea_cp_secondary_text ) }}
							<# } #>
						</span>
					<# } #>

					<# _.each( legals, function( legal ) { #>
						<# if ( ( output || showExtra ) && sep ) { #>
							<span class="awea-cp-sep" aria-hidden="true">{{ sep }}</span>
						<# } #>
						<a href="{{ ( legal.awea_cp_legal_url && legal.awea_cp_legal_url.url ) || '#' }}" class="awea-cp-legal-link">
							{{ _.escape( legal.awea_cp_legal_label ) }}
						</a>
					<# } ); #>
				</div>
			<# } #>
		</{{{ tag }}}>
		<?php
	}
}