<?php
/**
 * Awesome About Widget.
 * Architectural Editorial Layout with Floating Visuals & Micro-Interactions.
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
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Widget_Base;
use \Elementor\Repeater;
use \Elementor\Icons_Manager;

class Widget_Awesome_About extends Widget_Base {

    public function get_name() {
        return 'awesome-about';
    }

    public function get_title() {
        return esc_html__( 'About', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'awea', 'about', 'company', 'agency', 'story', 'profile', 'features' ];
    }

    protected function register_controls() {

        /* ==========================================================================
           CONTENT: VISUAL MEDIA & BADGE
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_about_images',
            [
                'label' => esc_html__( 'Images & Badge', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_about_main_image',
            [
                'label'   => esc_html__( 'Main Image', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [ 'active' => true ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'awea_about_floating_image',
            [
                'label'   => esc_html__( 'Floating Circle Image', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [ 'active' => true ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'awea_about_experience_badge',
            [
                'label'       => esc_html__( 'Experience Badge Text', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( '25+ Years Experience', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'e.g. 25+ Years Experience',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           CONTENT: HEADINGS & EDITORIAL COPY
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_about_content',
            [
                'label' => esc_html__( 'Editorial Content', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_about_sub_heading',
            [
                'label'       => esc_html__( 'Subheading / Kicker', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'About Our Company', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_about_main_heading',
            [
                'label'   => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXTAREA,
                'rows'    => 3,
                'default' => esc_html__( 'The World Trusts Our Modern Digital Logistics.', 'awesome-widgets-elementor' ),
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'awea_about_description',
            [
                'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'We engineer comprehensive design systems and high-throughput web applications that empower ambitious modern brands globally.', 'awesome-widgets-elementor' ),
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater_features = new Repeater();

        $repeater_features->add_control(
            'awea_feature_icon',
            [
                'label'   => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-check-circle',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater_features->add_control(
            'awea_feature_text',
            [
                'label'       => esc_html__( 'Feature Item', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Real-time Telemetry & Tracking', 'awesome-widgets-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_about_features_list',
            [
                'label'       => esc_html__( 'Key Highlights List', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_features->get_controls(),
                'default'     => [
                    [ 'awea_feature_text' => esc_html__( 'Real-time Telemetry & Tracking', 'awesome-widgets-elementor' ) ],
                    [ 'awea_feature_text' => esc_html__( 'Automated Compliance & Security', 'awesome-widgets-elementor' ) ],
                    [ 'awea_feature_text' => esc_html__( '24/7 Dedicated Support Engineering', 'awesome-widgets-elementor' ) ],
                    [ 'awea_feature_text' => esc_html__( 'Global Freight Infrastructure', 'awesome-widgets-elementor' ) ],
                ],
                'title_field' => '{{{ awea_feature_text }}}',
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           CONTENT: CALL TO ACTION BUTTONS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_about_buttons',
            [
                'label' => esc_html__( 'Call To Action', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_show_primary_btn',
            [
                'label'        => esc_html__( 'Show Primary Button', 'awesome-widgets-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
                'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'awea_primary_btn_text',
            [
                'label'     => esc_html__( 'Button Label', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Explore Services', 'awesome-widgets-elementor' ),
                'dynamic'   => [ 'active' => true ],
                'condition' => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_primary_btn_url',
            [
                'label'       => esc_html__( 'Button Link', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'https://example.com/services',
                'condition'   => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_heading_phone_cta',
            [
                'label'     => esc_html__( 'Direct Contact Line', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_about_contact_label',
            [
                'label'   => esc_html__( 'Contact Label', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Direct Inquiries:', 'awesome-widgets-elementor' ),
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'awea_about_contact_number',
            [
                'label'   => esc_html__( 'Phone Number', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '+1 (800) 234-5678',
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'awea_about_contact_url',
            [
                'label'       => esc_html__( 'Phone Link (tel:)', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'tel:+18002345678',
                'default'     => [
                    'url' => 'tel:+18002345678',
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           STYLE: VISUAL FRAMES & RIBBON
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_images',
            [
                'label' => esc_html__( 'Visual Framing & Badge', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_main_image_radius',
            [
                'label'      => esc_html__( 'Main Frame Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'rem' ],
                'default'    => [ 'top' => '80', 'right' => '24', 'bottom' => '24', 'left' => '80', 'unit' => 'px', 'isLinked' => false ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-about-image-frame' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'awea_main_image_shadow',
                'selector' => '{{WRAPPER}} .awea-about-image-frame',
            ]
        );

        $this->add_control(
            'awea_heading_floating_style',
            [
                'label'     => esc_html__( 'Floating Circle', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'awea_floating_size',
            [
                'label'      => esc_html__( 'Circle Diameter', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vw' ],
                'range'      => [ 'px' => [ 'min' => 150, 'max' => 450 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 320 ],
                'selectors'  => [
                    '{{WRAPPER}} .awea-about-floating-circle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_floating_border_color',
            [
                'label'     => esc_html__( 'Circle Border Glare', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-about-floating-circle' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_heading_badge_style',
            [
                'label'     => esc_html__( 'Experience Badge', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_badge_bg',
            [
                'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-about-ribbon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_badge_color',
            [
                'label'     => esc_html__( 'Badge Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-about-ribbon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_badge_typography',
                'selector' => '{{WRAPPER}} .awea-about-ribbon',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           STYLE: TYPOGRAPHY & TEXT COLORS
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_content',
            [
                'label' => esc_html__( 'Content Typography', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Subheading Kicker
        $this->add_control(
            'awea_heading_sub_style',
            [
                'label' => esc_html__( 'Subheading Kicker', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'awea_subheading_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-about-label-group' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-about-label-line'  => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_subheading_typography',
                'selector' => '{{WRAPPER}} .awea-about-label-group',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ],
            ]
        );

        // Main Heading
        $this->add_control(
            'awea_heading_main_style',
            [
                'label'     => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_heading_color',
            [
                'label'     => esc_html__( 'Heading Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-about-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_heading_typography',
                'selector' => '{{WRAPPER}} .awea-about-heading',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
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
                    '{{WRAPPER}} .awea-about-main-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_desc_typography',
                'selector' => '{{WRAPPER}} .awea-about-main-desc',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           STYLE: FEATURES CHECKLIST
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_features',
            [
                'label' => esc_html__( 'Feature Highlights', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_feature_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-about-check-item i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .awea-about-check-item svg' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_feature_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-about-check-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_feature_typography',
                'selector' => '{{WRAPPER}} .awea-about-check-item',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->end_controls_section();

        /* ==========================================================================
           STYLE: CTA BUTTON & CALL
           ========================================================================== */
        $this->start_controls_section(
            'awea_section_style_cta',
            [
                'label' => esc_html__( 'Action Buttons & Call Box', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_heading_prime_btn',
            [
                'label'     => esc_html__( 'Primary Action Button', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'condition' => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->start_controls_tabs( 'awea_cta_button_tabs' );

        // Normal
        $this->start_controls_tab(
            'awea_cta_tab_normal',
            [
                'label'     => esc_html__( 'Normal', 'awesome-widgets-elementor' ),
                'condition' => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_prime_btn_bg',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-about-prime-btn' => 'background-color: {{VALUE}};',
                ],
                'condition' => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_prime_btn_color',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-about-prime-btn' => 'color: {{VALUE}};',
                ],
                'condition' => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->end_controls_tab();

        // Hover (Zero Hover Zoom / Lift)
        $this->start_controls_tab(
            'awea_cta_tab_hover',
            [
                'label'     => esc_html__( 'Hover', 'awesome-widgets-elementor' ),
                'condition' => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_prime_btn_bg_hover',
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-about-prime-btn:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_prime_btn_color_hover',
            [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-about-prime-btn:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [ 'awea_show_primary_btn' => 'yes' ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Phone Circle Control
        $this->add_control(
            'awea_heading_phone_style',
            [
                'label'     => esc_html__( 'Phone Call Trigger', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_icon_circle_bg',
            [
                'label'     => esc_html__( 'Icon Circle Background', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-about-icon-circle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_icon_circle_color',
            [
                'label'     => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-about-icon-circle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings     = $this->get_settings_for_display();
        $main_img     = ! empty( $settings['awea_about_main_image']['url'] ) ? $settings['awea_about_main_image']['url'] : Utils::get_placeholder_image_src();
        $circle_img   = ! empty( $settings['awea_about_floating_image']['url'] ) ? $settings['awea_about_floating_image']['url'] : Utils::get_placeholder_image_src();
        $badge_text   = $settings['awea_about_experience_badge'] ?? '';
        $sub_heading  = $settings['awea_about_sub_heading'] ?? '';
        $main_heading = $settings['awea_about_main_heading'] ?? '';
        $description  = $settings['awea_about_description'] ?? '';
        $features     = $settings['awea_about_features_list'] ?? [];

        $show_btn     = 'yes' === ( $settings['awea_show_primary_btn'] ?? 'no' );
        $btn_text     = $settings['awea_primary_btn_text'] ?? '';
        $btn_link     = $settings['awea_primary_btn_url']['url'] ?? '';

        $phone_label  = $settings['awea_about_contact_label'] ?? '';
        $phone_num    = $settings['awea_about_contact_number'] ?? '';
        $phone_url    = $settings['awea_about_contact_url']['url'] ?? '';

        if ( $show_btn && ! empty( $btn_link ) ) {
            $this->add_link_attributes( 'awea_primary_btn', $settings['awea_primary_btn_url'] );
        }
        if ( ! empty( $phone_url ) ) {
            $this->add_link_attributes( 'awea_phone_call', $settings['awea_about_contact_url'] );
        }
        ?>
        <section class="awea-about-master-grid">
            
            <!-- Visual Framing Column -->
            <div class="awea-about-visual-container">
                <div class="awea-about-image-frame">
                    <img src="<?php echo esc_url( $main_img ); ?>" alt="<?php echo esc_attr( $main_heading ); ?>" loading="lazy" />
                </div>
                
                <?php if ( ! empty( $circle_img ) ) : ?>
                    <div class="awea-about-floating-circle">
                        <img src="<?php echo esc_url( $circle_img ); ?>" alt="<?php esc_attr_e( 'Feature Detail', 'awesome-widgets-elementor' ); ?>" loading="lazy" />
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $badge_text ) ) : ?>
                    <div class="awea-about-ribbon">
                        <span><?php echo esc_html( $badge_text ); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Editorial Content Column -->
            <div class="awea-about-text-content">
                
                <?php if ( ! empty( $sub_heading ) ) : ?>
                    <div class="awea-about-label-group">
                        <span class="awea-about-label-line" aria-hidden="true"></span>
                        <span class="awea-about-label-text"><?php echo esc_html( $sub_heading ); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $main_heading ) ) : ?>
                    <h2 class="awea-about-heading"><?php echo esc_html( $main_heading ); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty( $description ) ) : ?>
                    <div class="awea-about-main-desc">
                        <?php echo wp_kses_post( $description ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $features ) ) : ?>
                    <div class="awea-about-feature-box">
                        <?php foreach ( $features as $item ) : ?>
                            <div class="awea-about-check-item">
                                <?php Icons_Manager::render_icon( $item['awea_feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                <span><?php echo esc_html( $item['awea_feature_text'] ); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Dual Action Controls -->
                <div class="awea-about-cta-wrapper">
                    <?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
                        <a class="awea-about-prime-btn" <?php echo $this->get_render_attribute_string( 'awea_primary_btn' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                            <span><?php echo esc_html( $btn_text ); ?></span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php if ( ! empty( $phone_num ) ) : ?>
                        <a class="awea-about-phone-call" <?php echo $this->get_render_attribute_string( 'awea_phone_call' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                            <div class="awea-about-icon-circle" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <div class="awea-about-phone-meta">
                                <?php if ( ! empty( $phone_label ) ) : ?>
                                    <span class="awea-about-phone-label"><?php echo esc_html( $phone_label ); ?></span>
                                <?php endif; ?>
                                <span class="awea-about-phone-number"><?php echo esc_html( $phone_num ); ?></span>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </section>
        <?php
    }
}