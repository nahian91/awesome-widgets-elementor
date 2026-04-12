<?php 
/**
 * Awesome Image Box Widget.
 *
 * Premium version with Layered Depth and Smooth Micro-interactions.
 *
 * @since 1.0.0
 */
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Widget_Base;
use \Elementor\Utils;

class Widget_Awesome_Image_Box extends Widget_Base {

    public function get_name() {
        return 'awesome-image-box';
    }

    public function get_title() {
        return esc_html__( 'Image Box', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-image-box';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    protected function _register_controls() {
        
        // --- Content Section ---
        $this->start_controls_section(
           'awea_image_box_contents',
            [
                'label' => esc_html__('Contents', 'awesome-widgets-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_image_box_image',
            [
                'label' => esc_html__( 'Choose Image', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            ]
        );

        $this->add_control(
            'awea_pro_accent_color',
            [
                'label' => esc_html__( 'Accent Glow Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#6366f1',
                'selectors' => [ '{{WRAPPER}}' => '--awea-pro-accent: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_image_box_title',
            [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Interactive Design', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_image_box_des',
            [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Elevate your site with smooth transitions, glass effects, and ultra-modern UI elements.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_image_box_show_btn',
            [
                'label' => esc_html__( 'Show Button?', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'awea_image_box_btn_title',
            [
                'label' => esc_html__('Button Text', 'awesome-widgets-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('View Project', 'awesome-widgets-elementor'),
                'condition' => [ 'awea_image_box_show_btn' => 'yes' ],
            ]
        );

        $this->add_control(
            'awea_image_box_btn_link',
            [
                'label' => esc_html__( 'Button Link', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://',
                'condition' => [ 'awea_image_box_show_btn' => 'yes' ]
            ]
        );

        $this->end_controls_section();

        // --- Premium Notice ---
        $this->start_controls_section(
            'awea_image_box_pro_status',
            [ 'label' => esc_html__('Pro Status', 'awesome-widgets-elementor'), 'tab' => Controls_Manager::TAB_CONTENT ]
        );
        $this->add_control( 'pro_badge', [ 'type' => Controls_Manager::RAW_HTML, 'raw' => '<div style="background:var(--awea-pro-accent, #6366f1);color:#fff;padding:8px;border-radius:6px;text-align:center;font-size:12px;font-weight:700;">PRO INTERFACE ACTIVE</div>' ] );
        $this->end_controls_section();

        // --- STYLE: CARD CONTAINER ---
        $this->start_controls_section(
            'section_style_card',
            [
                'label' => esc_html__( 'Card Container', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [ '{{WRAPPER}} .awea-pro-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'card_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-pro-card, {{WRAPPER}} .awea-pro-card::after' => 'background: {{VALUE}};' ],
            ]
        );

        $this->add_responsive_control(
            'card_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [ '{{WRAPPER}} .awea-pro-card, {{WRAPPER}} .awea-pro-card::after' => 'border-radius: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [ 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .awea-pro-card' ]
        );

        $this->end_controls_section();

        // --- STYLE: IMAGE ---
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__( 'Image Style', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'img_height',
            [
                'label' => esc_html__( 'Height', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range' => [ 'px' => [ 'min' => 100, 'max' => 600 ] ],
                'selectors' => [ '{{WRAPPER}} .awea-pro-img-box' => 'height: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'img_radius',
            [
                'label' => esc_html__( 'Image Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [ '{{WRAPPER}} .awea-pro-img-box' => 'border-radius: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: CONTENT (TITLE & DES) ---
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__( 'Title & Description', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-pro-content h4' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [ 'name' => 'title_typo', 'label' => 'Title Typography', 'selector' => '{{WRAPPER}} .awea-pro-content h4' ]
        );

        $this->add_control(
            'des_color',
            [
                'label' => esc_html__( 'Description Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [ '{{WRAPPER}} .awea-pro-content p' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [ 'name' => 'des_typo', 'label' => 'Description Typography', 'selector' => '{{WRAPPER}} .awea-pro-content p' ]
        );

        $this->add_responsive_control(
            'content_align',
            [
                'label' => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
                    'right'  => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
                ],
                'selectors' => [ '{{WRAPPER}} .awea-pro-content' => 'text-align: {{VALUE}};' ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: BUTTON ---
        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__( 'Button Style', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [ 'awea_image_box_show_btn' => 'yes' ],
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'btn_text_color',
            [
                'label' => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-pro-btn' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'btn_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-pro-btn' => 'background: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'btn_hover_text_color',
            [
                'label' => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-pro-card:hover .awea-pro-btn' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'btn_hover_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-pro-card:hover .awea-pro-btn' => 'background: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [ 'name' => 'btn_typo', 'label' => 'Button Typography', 'selector' => '{{WRAPPER}} .awea-pro-btn', 'separator' => 'before' ]
        );

        $this->add_responsive_control(
            'btn_padding',
            [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [ '{{WRAPPER}} .awea-pro-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [ '{{WRAPPER}} .awea-pro-btn' => 'border-radius: {{SIZE}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <style>
            .awea-pro-card {
                position: relative;
                padding: 35px;
                background: #ffffff;
                border-radius: 32px;
                border: 1px solid rgba(0, 0, 0, 0.05);
                transition: all 0.7s cubic-bezier(0.15, 0.83, 0.66, 1);
                overflow: hidden;
                z-index: 1;
                box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05);
            }

            /* Animated Border Aura */
            .awea-pro-card::before {
                content: "";
                position: absolute;
                inset: -2px;
                background: conic-gradient(from 0deg, transparent, var(--awea-pro-accent, #6366f1), transparent 70%);
                animation: awea-rotate 4s linear infinite;
                z-index: -2;
                opacity: 0;
                transition: opacity 0.5s ease;
            }

            /* Card Inner Shell for Glass Effect */
            .awea-pro-card::after {
                content: "";
                position: absolute;
                inset: 1px;
                background: #ffffff;
                border-radius: 31px;
                z-index: -1;
                transition: 0.5s;
            }

            @keyframes awea-rotate {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            /* Hover States */
            .awea-pro-card:hover {
                transform: translateY(-12px) scale(1.01);
                box-shadow: 0 40px 80px -20px rgba(0,0,0,0.12);
                border-color: transparent;
            }

            .awea-pro-card:hover::before { opacity: 1; }
            .awea-pro-card:hover::after { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }

            /* Image Box Style */
            .awea-pro-img-box {
                width: 100%;
                height: 230px;
                border-radius: 20px;
                overflow: hidden;
                margin-bottom: 25px;
                position: relative;
                background: #f8fafc;
            }

            .awea-pro-img-box img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 1.2s cubic-bezier(0.15, 0.83, 0.66, 1);
            }

            .awea-pro-card:hover .awea-pro-img-box img {
                transform: scale(1.15);
            }

            /* Moving Light Shimmer */
            .awea-light-ray {
                position: absolute;
                top: 0; left: -150%;
                width: 100%; height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.7), transparent);
                transform: skewX(-25deg);
                transition: 0s;
                z-index: 2;
            }
            .awea-pro-card:hover .awea-light-ray {
                left: 150%;
                transition: 0.9s cubic-bezier(0.15, 0.83, 0.66, 1);
            }

            /* Text Styling */
            .awea-pro-content h4 {
                font-size: 24px;
                font-weight: 800;
                color: #0f172a;
                margin: 0 0 12px;
                letter-spacing: -0.5px;
                transition: color 0.3s;
            }

            .awea-pro-content p {
                color: #64748b;
                font-size: 15px;
                line-height: 1.65;
                margin-bottom: 25px;
            }

            /* Button Styling */
            .awea-pro-btn {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                padding: 14px 28px;
                background: #0f172a;
                color: #ffffff;
                border-radius: 16px;
                text-decoration: none;
                font-weight: 700;
                font-size: 14px;
                transition: all 0.4s;
                border: 1px solid transparent;
            }

            .awea-pro-btn i {
                font-size: 12px;
                transition: transform 0.4s cubic-bezier(0.15, 0.83, 0.66, 1);
            }

            .awea-pro-card:hover .awea-pro-btn {
                background: var(--awea-pro-accent, #6366f1);
                box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
            }

            .awea-pro-btn:hover {
                transform: translateY(-2px);
            }

            .awea-pro-card:hover .awea-pro-btn i {
                transform: translateX(5px);
            }
        </style>

        <div class="awea-pro-card">
            <div class="awea-light-ray"></div>
            
            <div class="awea-pro-img-box">
                <img src="<?php echo esc_url($settings['awea_image_box_image']['url']); ?>" alt="pro-image">
            </div>

            <div class="awea-pro-content">
                <h4><?php echo esc_html($settings['awea_image_box_title']); ?></h4>
                <p><?php echo esc_html($settings['awea_image_box_des']); ?></p>

                <?php if ( 'yes' === $settings['awea_image_box_show_btn'] ) : ?>
                    <a href="<?php echo esc_url($settings['awea_image_box_btn_link']['url']); ?>" class="awea-pro-btn">
                        <?php echo esc_html($settings['awea_image_box_btn_title']); ?>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}