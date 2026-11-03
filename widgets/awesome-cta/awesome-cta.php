<?php
/**
 * Awesome CTA Widget.
 *
 * @since 1.0.0
 */
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Widget_Base;

class Widget_Awesome_CTA extends Widget_Base {

    public function get_name() { return 'awesome-cta'; }
    public function get_title() { return esc_html__( 'CTA', 'awesome-widgets-elementor' ); }
    public function get_icon() { return 'eicon-call-to-action'; }
    public function get_categories() { return [ 'awesome-widgets-elementor' ]; }
    public function get_keywords() { return [ 'cta', 'hero', 'modern', 'design' ]; }

    protected function register_controls() {

        // --- CONTENT SECTION ---
        $this->start_controls_section(
            'awea_cta_content_section',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_cta_badge_text',
            [
                'label' => esc_html__( 'Badge Text', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( '2026 Collection', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_cta_title',
            [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Elevate Your Digital Presence Today.',
            ]
        );

        $this->add_control(
            'awea_cta_description',
            [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'The ultimate all-in-one solution to build, launch, and scale your brand with architectural precision.',
            ]
        );

        $this->add_responsive_control(
            'awea_cta_align',
            [
                'label' => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .awea-cta-hero-section' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .awea-cta-hero-actions' => 'justify-content: {{VALUE == "left" ? "flex-start" : (VALUE == "right" ? "flex-end" : "center")}};',
                    '{{WRAPPER}} .awea-cta-hero-desc' => 'margin-left: {{VALUE == "center" ? "auto" : (VALUE == "right" ? "auto" : "0")}}; margin-right: {{VALUE == "center" ? "auto" : (VALUE == "left" ? "auto" : "0")}};',
                ],
            ]
        );

        $this->add_control(
            'awea_cta_primary_btn_text',
            [
                'label' => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Get Started',
            ]
        );

        $this->add_control(
            'awea_cta_primary_btn_link',
            [
                'label' => esc_html__( 'Button Link', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::URL,
                'default' => [ 'url' => '#' ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: SUB HEADING (BADGE) ---
        $this->start_controls_section(
            'awea_cta_style_badge',
            [
                'label' => esc_html__( 'Sub Heading', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_cta_badge_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-cta-hero-badge' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_cta_badge_typography',
                'selector' => '{{WRAPPER}} .awea-cta-hero-badge',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'awea_cta_badge_bg',
                'selector' => '{{WRAPPER}} .awea-cta-hero-badge',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'awea_cta_badge_border',
                'selector' => '{{WRAPPER}} .awea-cta-hero-badge',
            ]
        );

        $this->add_control(
            'awea_cta_badge_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [ '{{WRAPPER}} .awea-cta-hero-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_responsive_control(
            'awea_cta_badge_padding',
            [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [ '{{WRAPPER}} .awea-cta-hero-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: HEADING ---
        $this->start_controls_section(
            'awea_cta_style_heading',
            [
                'label' => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_cta_heading_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-cta-hero-title' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_cta_heading_typography',
                'selector' => '{{WRAPPER}} .awea-cta-hero-title',
            ]
        );

        $this->end_controls_section();

        // --- STYLE: DESCRIPTION ---
        $this->start_controls_section(
            'awea_cta_style_description',
            [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_cta_desc_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-cta-hero-desc' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_cta_desc_typography',
                'selector' => '{{WRAPPER}} .awea-cta-hero-desc',
            ]
        );

        $this->end_controls_section();

        // --- STYLE: BUTTON ---
        $this->start_controls_section(
            'awea_cta_style_button',
            [
                'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'awea_cta_btn_tabs' );

        // Normal
        $this->start_controls_tab( 'awea_cta_btn_normal', [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ] );
        
        $this->add_control(
            'awea_cta_btn_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-cta-btn' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_cta_btn_typography',
                'selector' => '{{WRAPPER}} .awea-cta-btn',
            ]
        );

        $this->add_control(
            'awea_cta_btn_bg',
            [
                'label' => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-cta-btn' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'awea_cta_btn_border',
                'selector' => '{{WRAPPER}} .awea-cta-btn',
            ]
        );

        $this->add_control(
            'awea_cta_btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [ '{{WRAPPER}} .awea-cta-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_responsive_control(
            'awea_cta_btn_padding',
            [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [ '{{WRAPPER}} .awea-cta-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab( 'awea_cta_btn_hover', [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ] );

        $this->add_control(
            'awea_cta_btn_hover_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-cta-btn:hover' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_cta_btn_hover_bg',
            [
                'label' => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-cta-btn:hover' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'awea_cta_btn_hover_border',
                'selector' => '{{WRAPPER}} .awea-cta-btn:hover',
            ]
        );

        $this->add_control(
            'awea_cta_btn_hover_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [ '{{WRAPPER}} .awea-cta-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_link_attributes( 'awea_cta_primary_link', $settings['awea_cta_primary_btn_link'] );
        ?>

        <section class="awea-cta-hero-section">
            <div class="awea-cta-hero-bg-glow"></div>
            
            <div class="awea-cta-hero-content">
                <?php if ( ! empty( $settings['awea_cta_badge_text'] ) ) : ?>
                    <div class="awea-cta-hero-badge">
                        <i class="fas fa-sparkles"></i> <?php echo esc_html( $settings['awea_cta_badge_text'] ); ?>
                    </div>
                <?php endif; ?>

                <h1 class="awea-cta-hero-title"><?php echo wp_kses_post( $settings['awea_cta_title'] ); ?></h1>
                
                <?php if ( ! empty( $settings['awea_cta_description'] ) ) : ?>
                    <p class="awea-cta-hero-desc"><?php echo esc_html( $settings['awea_cta_description'] ); ?></p>
                <?php endif; ?>

                <div class="awea-cta-hero-actions">
                    <a <?php echo wp_kses_post( $this->get_render_attribute_string( 'awea_cta_primary_link' ) ); ?> class="awea-cta-btn">
                        <?php echo esc_html( $settings['awea_cta_primary_btn_text'] ); ?> <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}