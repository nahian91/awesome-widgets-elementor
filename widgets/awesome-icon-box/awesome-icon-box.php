<?php 
/**
 * Awesome Icon Box Widget Pro.
 * Version: 2.5 - Ultra Premium Edition with Full Style Controls
 */
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Awesome_Icon_Box extends Widget_Base {

    public function get_name() { return 'awesome-icon-box'; }
    public function get_title() { return esc_html__( 'Icon Box', 'awesome-widgets-elementor' ); }
    public function get_icon() { return 'eicon-icon-box'; }
    public function get_categories() { return [ 'awesome-widgets-elementor' ]; }

    protected function register_controls() {
        
        // --- CONTENT SECTION ---
        $this->start_controls_section(
           'awea_content',
            [ 'label' => esc_html__('Design Content', 'awesome-widgets-elementor') ]
        );

        $this->add_control(
            'awea_icon',
            [
                'label' => esc_html__( 'Feature Icon', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [ 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ],
            ]
        );

        $this->add_control(
            'awea_title',
            [
                'label' => esc_html__( 'Headline', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Military Encryption', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_des',
            [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Secure your data with the most advanced protocols available in the industry today.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_btn_text',
            [
                'label' => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Get Started', 'awesome-widgets-elementor' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_btn_link',
            [
                'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'awesome-widgets-elementor' ),
                'default' => [ 'url' => '#', 'is_external' => true, 'nofollow' => true ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: CARD CONTAINER ---
        $this->start_controls_section('section_style_container', [
            'label' => __( 'Card Container', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('card_alignment', [
            'label'     => __( 'Alignment', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
                'left'   => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
            ],
            'selectors' => [ '{{WRAPPER}{{  }}ltra-card' => 'text-align: {{VALUE}};' ],
        ]);

        $this->add_responsive_control('card_padding', [
            'label'      => __( 'Padding', 'awesome-widgets-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [ '{{WRAPPER}} .awea-ultra-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_responsive_control('card_radius', [
            'label'      => __( 'Border Radius', 'awesome-widgets-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [ '{{WRAPPER}} .awea-ultra-card' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ]);

        $this->start_controls_tabs('tabs_card_style');

        $this->start_controls_tab('tab_card_normal', [ 'label' => __( 'Normal', 'awesome-widgets-elementor' ) ]);
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [ 'name' => 'card_bg', 'selector' => '{{WRAPPER}} .awea-ultra-card' ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [ 'name' => 'card_border', 'selector' => '{{WRAPPER}} .awea-ultra-card' ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab('tab_card_hover', [ 'label' => __( 'Hover', 'awesome-widgets-elementor' ) ]);
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [ 'name' => 'card_bg_hover', 'selector' => '{{WRAPPER}} .awea-ultra-card:hover' ]
        );
        $this->add_control('card_border_hover', [
            'label' => 'Border Color',
            'type' => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-ultra-card:hover' => 'border-color: {{VALUE}};' ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [ 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .awea-ultra-card', 'separator' => 'before' ]
        );

        $this->end_controls_section();

        // --- STYLE: ICON ISLAND ---
        $this->start_controls_section('section_style_icon', [
            'label' => __( 'Icon Island', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('awea_accent', [
            'label'     => __( 'Accent Color', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#7c3aed',
            'selectors' => [ '{{WRAPPER}}' => '--awea-accent: {{VALUE}};' ],
        ]);

        $this->add_responsive_control('icon_size', [
            'label'     => __( 'Icon Size', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'selectors' => [ '{{WRAPPER}} .awea-icon-island i' => 'font-size: {{SIZE}}{{UNIT}};' ],
        ]);

        $this->add_responsive_control('island_size', [
            'label'     => __( 'Island Size', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'selectors' => [ '{{WRAPPER}} .awea-icon-island' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
        ]);

        $this->add_control('island_radius', [
            'label'     => __( 'Border Radius', 'awesome-widgets-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'selectors' => [ '{{WRAPPER}} .awea-icon-island' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();

        // --- STYLE: TYPOGRAPHY ---
        $this->start_controls_section('section_style_typo', [
            'label' => __( 'Typography', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('title_head', [ 'label' => 'Title', 'type' => Controls_Manager::HEADING ]);
        $this->add_control('title_color', [
            'label'     => 'Color',
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-text-content h4' => 'color: {{VALUE}};' ],
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [ 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .awea-text-content h4' ]
        );

        $this->add_control('des_head', [ 'label' => 'Description', 'type' => Controls_Manager::HEADING, 'separator' => 'before' ]);
        $this->add_control('des_color', [
            'label'     => 'Color',
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-text-content p' => 'color: {{VALUE}};' ],
        ]);
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [ 'name' => 'des_typography', 'selector' => '{{WRAPPER}} .awea-text-content p' ]
        );

        $this->end_controls_section();

        // --- STYLE: BUTTON ---
        $this->start_controls_section('section_style_button', [
            'label' => __( 'Button Style', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->start_controls_tabs('tabs_btn_style');

        $this->start_controls_tab('tab_btn_normal', [ 'label' => 'Normal' ]);
        $this->add_control('btn_color', [
            'label'     => 'Color',
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-btn' => 'color: {{VALUE}};' ],
        ]);
        $this->add_control('btn_bg', [
            'label'     => 'Background',
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-btn' => 'background: {{VALUE}};' ],
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab('tab_btn_hover', [ 'label' => 'Hover' ]);
        $this->add_control('btn_color_hover', [
            'label'     => 'Color',
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-btn:hover' => 'color: {{VALUE}};' ],
        ]);
        $this->add_control('btn_bg_hover', [
            'label'     => 'Background',
            'type'      => Controls_Manager::COLOR,
            'selectors' => [ '{{WRAPPER}} .awea-btn:hover' => 'background: {{VALUE}};' ],
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [ 'name' => 'btn_typo', 'selector' => '{{WRAPPER}} .awea-btn', 'separator' => 'before' ]
        );

        $this->add_responsive_control('btn_padding', [
            'label'      => 'Padding',
            'type'       => Controls_Manager::DIMENSIONS,
            'selectors'  => [ '{{WRAPPER}} .awea-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_control('btn_radius', [
            'label'     => 'Border Radius',
            'type'      => Controls_Manager::SLIDER,
            'selectors' => [ '{{WRAPPER}} .awea-btn' => 'border-radius: {{SIZE}}{{UNIT}};' ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_link_attributes( 'button_attr', $settings['awea_btn_link'] );
        ?>

        <style>
            .awea-ultra-card {
                position: relative;
                background: #fff;
                padding: 40px;
                border-radius: 20px;
                overflow: hidden;
                transition: all 0.4s ease;
                z-index: 1;
                border: 1px solid #f0f0f0;
            }
            .awea-ultra-card:hover {
                transform: translateY(-10px);
            }
            .awea-icon-island {
                width: 70px;
                height: 70px;
                background: var(--awea-accent);
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                margin-bottom: 25px;
                position: relative;
            }
            .awea-icon-island i { font-size: 30px; }
            .awea-text-content h4 { margin: 0 0 15px; font-weight: 700; font-size: 22px; }
            .awea-text-content p { margin: 0 0 25px; line-height: 1.6; color: #666; }
            .awea-btn {
                display: inline-block;
                padding: 12px 28px;
                background: var(--awea-accent);
                color: #fff !important;
                text-decoration: none;
                border-radius: 50px;
                font-weight: 600;
                transition: opacity 0.3s;
            }
            .awea-btn:hover { opacity: 0.9; }
            .awea-watermark {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 10px;
                font-weight: 900;
                opacity: 0.1;
                letter-spacing: 2px;
            }
        </style>

        <div class="awea-ultra-card">
            <div class="awea-watermark">PRO</div>
            
            <div class="awea-icon-island">
                <?php Icons_Manager::render_icon( $settings['awea_icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </div>

            <div class="awea-text-content">
                <h4><?php echo esc_html($settings['awea_title']); ?></h4>
                <p><?php echo esc_html($settings['awea_des']); ?></p>
            </div>

            <?php if ( ! empty( $settings['awea_btn_text'] ) ) : ?>
                <a class="awea-btn" <?php echo wp_kses_post( $this->get_render_attribute_string( 'button_attr' ) ); ?>>
                    <?php echo esc_html($settings['awea_btn_text']); ?>
                </a>
            <?php endif; ?>
        </div>
        <?php
    }
}