<?php
/**
 * Awesome Site Logo Studio Widget.
 * Modern Architectural Logo Component with Custom Branding & Zero Hover Lift.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.8.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

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
        return [ 'awea', 'logo', 'site logo', 'brand', 'image', 'header', 'home', 'retina' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           TAB: CONTENT -> SECTION: LOGO CONFIGURATION
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_logo_content',
            [
                'label' => esc_html__( 'Logo Configuration', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_logo_type',
            [
                'label'   => esc_html__( 'Logo Type', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image' => esc_html__( 'Image / SVG Logo', 'awesome-widgets-elementor' ),
                    'text'  => esc_html__( 'Text / Site Title', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        // IMAGE LOGO CONTROLS
        $this->add_control(
            'awea_logo_source',
            [
                'label'     => esc_html__( 'Image Source', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'custom',
                'options'   => [
                    'custom'    => esc_html__( 'Custom Upload', 'awesome-widgets-elementor' ),
                    'site_logo' => esc_html__( 'WordPress Site Logo', 'awesome-widgets-elementor' ),
                ],
                'condition' => [
                    'awea_logo_type' => 'image',
                ],
            ]
        );

        $this->add_control(
            'awea_custom_logo',
            [
                'label'     => esc_html__( 'Primary Logo', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'awea_logo_type'   => 'image',
                    'awea_logo_source' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'awea_enable_hover_logo',
            [
                'label'        => esc_html__( 'Secondary / Hover Logo', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => [
                    'awea_logo_type'   => 'image',
                    'awea_logo_source' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'awea_custom_hover_logo',
            [
                'label'     => esc_html__( 'Choose Hover/Sticky Logo', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::MEDIA,
                'condition' => [
                    'awea_logo_type'         => 'image',
                    'awea_logo_source'       => 'custom',
                    'awea_enable_hover_logo' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'awea_logo_image_size',
                'default'   => 'full',
                'condition' => [
                    'awea_logo_type'   => 'image',
                    'awea_logo_source' => 'custom',
                ],
            ]
        );

        // TEXT LOGO CONTROLS
        $this->add_control(
            'awea_text_logo_title',
            [
                'label'       => esc_html__( 'Brand Title', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => get_bloginfo( 'name' ),
                'dynamic'     => [ 'active' => true ],
                'condition'   => [
                    'awea_logo_type' => 'text',
                ],
            ]
        );

        $this->add_control(
            'awea_show_tagline',
            [
                'label'        => esc_html__( 'Show Site Tagline', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => [
                    'awea_logo_type' => 'text',
                ],
            ]
        );

        $this->add_control(
            'awea_text_logo_tagline',
            [
                'label'     => esc_html__( 'Tagline Text', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => get_bloginfo( 'description' ),
                'dynamic'   => [ 'active' => true ],
                'condition' => [
                    'awea_logo_type'    => 'text',
                    'awea_show_tagline' => 'yes',
                ],
            ]
        );

        // LINK & ALIGNMENT
        $this->add_control(
            'awea_logo_link_type',
            [
                'label'     => esc_html__( 'Link Action', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'home',
                'separator' => 'before',
                'options'   => [
                    'none'   => esc_html__( 'None', 'awesome-widgets-elementor' ),
                    'home'   => esc_html__( 'Default Homepage', 'awesome-widgets-elementor' ),
                    'custom' => esc_html__( 'Custom URL', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'awea_logo_custom_link',
            [
                'label'       => esc_html__( 'Custom Link', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://yourwebsite.com', 'awesome-widgets-elementor' ),
                'condition'   => [
                    'awea_logo_link_type' => 'custom',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_logo_alignment',
            [
                'label'     => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
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
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .awea-site-logo-outer' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: LOGO IMAGE STYLING
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_image',
            [
                'label'     => esc_html__( 'Image Sizing & Style', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'awea_logo_type' => 'image',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_logo_width',
            [
                'label'      => esc_html__( 'Width', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range'      => [
                    'px' => [ 'min' => 20, 'max' => 600 ],
                    '%'  => [ 'min' => 5, 'max' => 100 ],
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
            'awea_logo_max_height',
            [
                'label'      => esc_html__( 'Max Height', 'awesome-widgets-elementor' ),
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
            'awea_logo_radius',
            [
                'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-site-logo-wrap img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'awea_logo_image_tabs' );

        // Normal Image Tab
        $this->start_controls_tab(
            'awea_tab_image_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_image_opacity',
            [
                'label'     => esc_html__( 'Opacity', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [ 'min' => 0.1, 'max' => 1, 'step' => 0.05 ],
                ],
                'default'   => [ 'size' => 1 ],
                'selectors' => [
                    '{{WRAPPER}} .awea-site-logo-wrap img' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .awea-site-logo-wrap svg' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'awea_image_filters',
                'selector' => '{{WRAPPER}} .awea-site-logo-wrap img, {{WRAPPER}} .awea-site-logo-wrap svg',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_logo_shadow',
                'selector' => '{{WRAPPER}} .awea-site-logo-wrap img',
            ]
        );

        $this->end_controls_tab();

        // Hover Image Tab
        $this->start_controls_tab(
            'awea_tab_image_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_image_opacity_hover',
            [
                'label'     => esc_html__( 'Opacity', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [ 'min' => 0.1, 'max' => 1, 'step' => 0.05 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-site-logo-wrap:hover img' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .awea-site-logo-wrap:hover svg' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'awea_image_filters_hover',
                'selector' => '{{WRAPPER}} .awea-site-logo-wrap:hover img, {{WRAPPER}} .awea-site-logo-wrap:hover svg',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_logo_shadow_hover',
                'selector' => '{{WRAPPER}} .awea-site-logo-wrap:hover img',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        /* ==========================================================================
           TAB: STYLE -> SECTION: TEXT LOGO STYLING
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_text',
            [
                'label'     => esc_html__( 'Text / Typography', 'awesome-widgets-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'awea_logo_type' => 'text',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_title_typography',
                'label'    => esc_html__( 'Title Typography', 'awesome-widgets-elementor' ),
                'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
                'selector' => '{{WRAPPER}} .awe-logo-title',
            ]
        );

        $this->add_control(
            'awea_title_color',
            [
                'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [
                    '{{WRAPPER}} .awe-logo-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_title_color_hover',
            [
                'label'     => esc_html__( 'Title Hover Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-site-logo-wrap:hover .awe-logo-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_tagline_heading',
            [
                'label'     => esc_html__( 'Tagline Style', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [ 'awea_show_tagline' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'awea_tagline_typography',
                'label'     => esc_html__( 'Tagline Typography', 'awesome-widgets-elementor' ),
                'selector'  => '{{WRAPPER}} .awe-logo-tagline',
                'condition' => [ 'awea_show_tagline' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_tagline_color',
            [
                'label'     => esc_html__( 'Tagline Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#64748b',
                'selectors' => [
                    '{{WRAPPER}} .awe-logo-tagline' => 'color: {{VALUE}};',
                ],
                'condition' => [ 'awea_show_tagline' => 'yes' ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings  = $this->get_settings_for_display();
        $logo_type = $settings['awea_logo_type'] ?? 'image';
        $link_type = $settings['awea_logo_link_type'] ?? 'home';

        // Compute destination link URL
        $link_url = '';
        $target   = '';
        $rel      = '';

        if ( 'home' === $link_type ) {
            $link_url = esc_url( home_url( '/' ) );
            $rel      = 'home';
        } elseif ( 'custom' === $link_type && ! empty( $settings['awea_logo_custom_link']['url'] ) ) {
            $link_url = esc_url( $settings['awea_logo_custom_link']['url'] );
            $target   = ! empty( $settings['awea_logo_custom_link']['is_external'] ) ? ' target="_blank"' : '';
            $rel      = ! empty( $settings['awea_logo_custom_link']['nofollow'] ) ? 'nofollow' : '';
        }

        $has_link = ! empty( $link_url );
        ?>
        <div class="awea-site-logo-outer">
            <div class="awea-site-logo-wrap">
                <?php if ( $has_link ) : ?>
                    <a href="<?php echo $link_url; ?>" <?php echo $target; ?> <?php echo $rel ? 'rel="' . esc_attr( $rel ) . '"' : ''; ?> class="awe-logo-link">
                <?php else : ?>
                    <div class="awe-logo-link">
                <?php endif; ?>

                    <?php if ( 'text' === $logo_type ) : ?>
                        <div class="awe-text-logo-group">
                            <span class="awe-logo-title"><?php echo esc_html( $settings['awea_text_logo_title'] ); ?></span>
                            <?php if ( 'yes' === ( $settings['awea_show_tagline'] ?? 'no' ) && ! empty( $settings['awea_text_logo_tagline'] ) ) : ?>
                                <span class="awe-logo-tagline"><?php echo esc_html( $settings['awea_text_logo_tagline'] ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <?php
                        $source          = $settings['awea_logo_source'] ?? 'custom';
                        $has_hover_logo  = ( 'yes' === ( $settings['awea_enable_hover_logo'] ?? 'no' ) ) && ! empty( $settings['awea_custom_hover_logo']['url'] );
                        $primary_html    = '';
                        $hover_html      = '';

                        if ( 'site_logo' === $source && function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
                            $custom_logo_id = get_theme_mod( 'custom_logo' );
                            $primary_html   = wp_get_attachment_image( $custom_logo_id, 'full', false, [ 'class' => 'awe-primary-logo awe-logo-image' ] );
                        } elseif ( ! empty( $settings['awea_custom_logo']['url'] ) ) {
                            $image_html   = Group_Control_Image_Size::get_attachment_image_html( $settings, 'awea_logo_image_size', 'awea_custom_logo' );
                            $primary_html = ! empty( $image_html ) ? $image_html : '<img src="' . esc_url( $settings['awea_custom_logo']['url'] ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="awe-primary-logo" />';
                        } else {
                            $primary_html = '<span class="awe-logo-title">' . esc_html( get_bloginfo( 'name' ) ) . '</span>';
                        }

                        if ( $has_hover_logo ) {
                            $hover_html = '<img src="' . esc_url( $settings['awea_custom_hover_logo']['url'] ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="awe-hover-logo" />';
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