<?php 
/**
 * Awesome Icon Box Widget.
 *
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Widget_Awesome_Icon_Box extends Widget_Base {

    public function get_name() { 
        return 'awesome-icon-box'; 
    }

    public function get_title() { 
        return esc_html__( 'Icon Box', 'awesome-widgets-elementor' ); 
    }

    public function get_icon() { 
        return 'eicon-icon-box'; 
    }

    public function get_categories() { 
        return [ 'awesome-widgets-elementor' ]; 
    }

    public function get_keywords() {
        return [ 'icon', 'box', 'awesome', 'feature' ];
    }

    protected function register_controls() {

        // --- CONTENT: ICON ---
        $this->start_controls_section(
            'awea_icon_box_icon_title', 
            [
                'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_icon_box_icon', 
            [
                'label' => esc_html__( 'Choose Icon', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::ICONS,
                'default' => [ 
                    'value' => 'fas fa-bolt', 
                    'library' => 'fa-solid' 
                ],
            ]
        );

        $this->end_controls_section();


        // --- CONTENT: TEXT ---
        $this->start_controls_section(
            'awea_icon_box_content', 
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_icon_box_title', 
            [
                'label'   => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Lightning Fast', 'awesome-widgets-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_icon_box_desc', 
            [
                'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Optimized for speed with built-in caching and asset minification right out of the box.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->end_controls_section();

        // --- CONTENT: Button ---
        $this->start_controls_section(
            'awea_icon_box_button', 
            [
                'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_icon_box_button_icon', 
            [
                'label'       => esc_html__( 'Button Icon', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'     => [
                    'value'   => 'fas fa-arrow-right',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
			'awea_icon_box_button_title',
			[
				'label' => esc_html__( 'Title', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Default title', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your title here', 'textdomain' ),
			]
		);

        $this->add_control(
			'awea_icon_box_button_link',
			[
				'label' => esc_html__( 'Link', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

        $this->end_controls_section();

        // --- STYLE: LAYOUT ---
        $this->start_controls_section(
            'awea_icon_box_layout', 
                [
                'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_icon_box_align', 
                [
                'label' => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
                    'right'  => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
                ],
                'selectors' => [ 
                    '{{WRAPPER}} .awea-icon-box' => 'text-align: {{VALUE}}; align-items: {{VALUE}};' 
                ],
            ]
        );

        $this->start_controls_tabs('awea_icon_box_style_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'awea_icon_box_normal', 
                [ 
                'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) 
            ]
        );
            
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'awea_icon_box_border',
                'selector' => '{{WRAPPER}} .awea-icon-box',
            ]
        );

        $this->add_responsive_control(
            'awea_icon_box_padding', 
                [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [ '{{WRAPPER}} .awea-icon-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_responsive_control(
                'awea_icon_box_radius', 
                [
                    'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors' => [ '{{WRAPPER}} .awea-icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
                ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab('awea_icon_box_hover', [ 
            'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) 
        ]);
            
        $this->add_control(
            'awea_icon_box_border_hover', 
            [
                'label' => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-icon-box:hover' => 'border-color: {{VALUE}}' ],
            ]
        );

        $this->add_responsive_control(
            'awea_icon_box_radius_hover', 
                [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [ '{{WRAPPER}} .awea-icon-box:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->end_controls_section();

        // --- STYLE: ICON ---
        $this->start_controls_section(
            'awea_icon_box_icon_style', 
            [
                'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_icon_box_icon_size',
            [
                'label' => esc_html__( 'Size', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range' => [
                    'px' => [ 'min' => 6, 'max' => 300 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-wrapper i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .awea-icon-wrapper svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('awea_icon_box_icon_style_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'awea_icon_box_icon_normal', 
            [ 
                'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) 
            ]
        );
            
        $this->add_control(
            'awea_icon_box_icon_color', 
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [ '{{WRAPPER}} .awea-icon-wrapper' => 'color: {{VALUE}}; fill: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_icon_box_icon_bgcolor', 
            [
                'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
                'selectors' => [ '{{WRAPPER}} .awea-icon-wrapper' => 'background-color: {{VALUE}}' ],
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'awea_icon_box_icon_hover', 
            [ 
                'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) 
            ]
        );
            
        $this->add_control(
            'awea_icon_box_icon_hcolor', 
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-icon-box:hover .awea-icon-wrapper' => 'color: {{VALUE}}; fill: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_icon_box_icon_hbgcolor', 
            [
                'label' => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-icon-box:hover .awea-icon-wrapper' => 'background-color: {{VALUE}}' ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'awea_icon_box_icon_margin',
            [
                'label' => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-icon-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        
        $this->end_controls_section();

        // --- STYLE: CONTENT ---
        $this->start_controls_section(
            'awea_icon_box_style_content', 
                [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_icon_box_style_title_heading', 
                [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Title
        $this->add_control(
            'awea_icon_box_title_color', 
            [
                'label' => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [ '{{WRAPPER}} h3' => 'color: {{VALUE}}' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_icon_box_title_typo',
                'global' => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
                'selector' => '{{WRAPPER}} h3',
            ]
        );

        $this->add_control(
            'awea_icon_box_style_desc_heading', 
                [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Description
        $this->add_control(
            'awea_icon_box_desc_color', 
                [
                'label' => esc_html__( 'Description Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => Global_Colors::COLOR_TEXT ],
                'selectors' => [ '{{WRAPPER}} p' => 'color: {{VALUE}}' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_icon_box_desc_typo',
                'global' => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ],
                'selector' => '{{WRAPPER}} p',
            ]
        );
        

        $this->end_controls_section();

        // --- STYLE: CONTENT ---
        $this->start_controls_section(
            'awea_icon_box_style_content_btn', 
                [
                'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Typography - Outside tabs as it usually applies to both
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_icon_box_btn_typography',
                'global'   => [ 'default' => Global_Typography::TYPOGRAPHY_ACCENT ],
                'selector' => '{{WRAPPER}} .awea-btn-link',
            ]
        );

        $this->start_controls_tabs('awea_icon_box_btn_style_tabs');

        // --- NORMAL TAB ---
        $this->start_controls_tab('awea_icon_box_btn_normal', [ 
            'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) 
        ]);

        $this->add_control(
            'awea_icon_box_btn_text_color', 
                [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [ '{{WRAPPER}} .awea-btn-link' => 'color: {{VALUE}}' ],
            ]
        );

        $this->add_control(
            'awea_icon_box_btn_bg_color', 
                [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [ 'default' => Global_Colors::COLOR_ACCENT ],
                'selectors' => [ '{{WRAPPER}} .awea-btn-link' => 'background-color: {{VALUE}}' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'awea_icon_box_btn_border',
                'selector' => '{{WRAPPER}} .awea-btn-link',
            ]
        );

        $this->add_responsive_control(
            'awea_icon_box_btn_radius', 
                [
                'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [ '{{WRAPPER}} .awea-btn-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_responsive_control(
            'awea_icon_box_btn_padding', 
                [
                'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [ '{{WRAPPER}} .awea-btn-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_tab();

        // --- HOVER TAB ---
        $this->start_controls_tab(
            'awea_icon_box_btn_hover', 
                [ 
                'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) 
            ]
        );

        $this->add_control(
            'awea_icon_box_btn_text_color_hover', 
                [
                'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-btn-link:hover' => 'color: {{VALUE}}' ],
            ]
        );

        $this->add_control(
            'awea_icon_box_btn_bg_color_hover', 
            [
                'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'global'    => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [ '{{WRAPPER}} .awea-btn-link:hover' => 'background-color: {{VALUE}}' ],
            ]
        );

        $this->add_control(
            'awea_icon_box_btn_border_color_hover', 
                [
                'label'     => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-btn-link:hover' => 'border-color: {{VALUE}}' ],
            ]
        );

        $this->add_responsive_control(
            'awea_icon_box_btn_radius_hover', 
            [
                'label'      => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [ '{{WRAPPER}} .awea-btn-link:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_responsive_control(
            'awea_icon_box_btn_padding_hover', 
            [
                'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [ '{{WRAPPER}} .awea-btn-link:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $awea_icon_box_icon = $settings['awea_icon_box_icon']['value'];
        $awea_icon_box_title = $settings['awea_icon_box_title'];
        $awea_icon_box_desc = $settings['awea_icon_box_desc'];
        $awea_icon_box_button_icon = $settings['awea_icon_box_button_icon']['value'];
        $awea_icon_box_button_title = $settings['awea_icon_box_button_title'];
        $awea_icon_box_button_link = $settings['awea_icon_box_button_link']['url'];

        ?>
        <div class="awea-icon-box">
            <div class="awea-icon-wrapper">
                <i class="<?php echo esc_attr($awea_icon_box_icon);?>"></i>
            </div>
            <h3><?php echo $awea_icon_box_title;?></h3>
            <p><?php echo $awea_icon_box_desc;?></p>
            <a href="<?php echo $awea_icon_box_button_link;?>" class="awea-btn-link"><?php echo $awea_icon_box_button_title;?> <i class="<?php echo esc_attr($awea_icon_box_button_icon);?>"></i></a>
        </div>
        <?php 
    }
}