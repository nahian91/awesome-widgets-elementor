<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Awesome_Heading extends Widget_Base {

    public function get_name() { 
        return 'awesome-heading'; 
    }
    public function get_title() { return esc_html__( 'Heading', 'awesome-widgets-elementor' ); }
    public function get_icon() { return 'eicon-t-letter'; }
    public function get_categories() { return [ 'awesome-widgets-elementor' ]; }

    protected function register_controls() {

        // --- CONTENT SECTION ---
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'sub_heading',
            [
                'label' => esc_html__( 'Sub Heading', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Insights • 2026', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'heading',
            [
                'label' => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Beyond the Standard Grid.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Reimagining the digital experience through the lens of architectural design and fluid motion engineering.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Explore Collection', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::URL,
                'default' => [ 'url' => '#' ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: LAYOUT ---
        $this->start_controls_section(
            'section_style_layout',
            [
                'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
                    'right' => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
                ],
                'selectors' => [ '{{WRAPPER}} .awea-section-signature' => 'text-align: {{VALUE}};' ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: SUB HEADING ---
        $this->start_controls_section(
            'section_style_subheading',
            [
                'label' => esc_html__( 'Sub Heading', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sub_heading_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-tag' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_heading_typography',
                'selector' => '{{WRAPPER}} .awea-section-signature-tag',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sub_heading_background',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .awea-section-signature-tag',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sub_heading_border',
                'selector' => '{{WRAPPER}} .awea-section-signature-tag',
            ]
        );

        $this->add_control(
            'sub_heading_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-tag' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'sub_heading_padding',
            [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: HEADING ---
        $this->start_controls_section(
            'section_style_heading',
            [
                'label' => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-title' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY ],
                'selector' => '{{WRAPPER}} .awea-section-signature-title',
            ]
        );

        $this->add_control(
			'heading_separator',
			[
				'label' => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'heading_separator_color1',
            [
                'label' => esc_html__( 'Color 1', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-divider' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'heading_separator_color2',
            [
                'label' => esc_html__( 'Color 2', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY ],
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-divider::after' => 'background-color: {{VALUE}};' ],
            ]
        );


        $this->end_controls_section();

        // --- STYLE: DESCRIPTION ---
        $this->start_controls_section(
            'section_style_desc',
            [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT ],
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-desc' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT ],
                'selector' => '{{WRAPPER}} .awea-section-signature-desc',
            ]
        );

        $this->end_controls_section();

        // --- STYLE: BUTTON ---
        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .awea-section-signature-btn',
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-btn' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'btn_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_ACCENT ],
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-btn' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'btn_hover_color',
            [
                'label' => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-btn:hover' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'btn_hover_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-btn:hover' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'btn_border',
                'selector' => '{{WRAPPER}} .awea-section-signature-btn',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'btn_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'btn_padding',
            [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [ '{{WRAPPER}} .awea-section-signature-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute( 'button_attr', 'class', 'awea-section-signature-btn' );
        if ( ! empty( $settings['button_link']['url'] ) ) {
            $this->add_link_attributes( 'button_attr', $settings['button_link'] );
        }
        ?>
        <section class="awea-section-signature">
            <?php if ( ! empty( $settings['sub_heading'] ) ) : ?>
                <div class="awea-section-signature-tag"><?php echo esc_html( $settings['sub_heading'] ); ?></div>
            <?php endif; ?>

            <?php if ( ! empty( $settings['heading'] ) ) : ?>
                <h1 class="awea-section-signature-title"><?php echo wp_kses_post( $settings['heading'] ); ?></h1>
            <?php endif; ?>

            <div class="awea-section-signature-divider"></div>

            <?php if ( ! empty( $settings['description'] ) ) : ?>
                <div class="awea-section-signature-desc"><?php echo wp_kses_post( $settings['description'] ); ?></div>
            <?php endif; ?>

            <?php if ( ! empty( $settings['button_text'] ) ) : ?>
                <div class="awea-section-signature-btn-wrap">
                    <a <?php $this->print_render_attribute_string( 'button_attr' ); ?>>
                        <?php echo esc_html( $settings['button_text'] ); ?>
                        <i class="fas fa-arrow-up-right-from-square"></i> 
                    </a>
                </div>
            <?php endif; ?>
        </section>
        <?php
    }
}