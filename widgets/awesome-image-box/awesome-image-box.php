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
use \Elementor\Group_Control_Image_Size;
use \Elementor\Widget_Base;
use \Elementor\Utils;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

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

    protected function register_controls() {
        
        // --- CONTENT: IMAGE ---
        $this->start_controls_section(
            'awea_image_box_section_image',
            [
                'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_image_box_image_box',
            [
                'label' => esc_html__( 'Choose Image', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();

        // --- CONTENT: TEXT ---
        $this->start_controls_section(
            'awea_image_box_section_content',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_image_box_title_text',
            [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Lumina Design System', 'awesome-widgets-elementor' ),
                'placeholder' => esc_html__( 'Enter your title', 'awesome-widgets-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_image_box_description_text',
            [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Master the art of clean aesthetics with our latest component library built for speed and visual harmony.', 'awesome-widgets-elementor' ),
                'placeholder' => esc_html__( 'Enter your description', 'awesome-widgets-elementor' ),
                'rows' => 10,
            ]
        );

        $this->end_controls_section();

        // --- CONTENT: BUTTON ---
        $this->start_controls_section(
            'awea_image_box_section_button',
            [
                'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_image_box_button_text',
            [
                'label' => esc_html__( 'Button Text', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Start Creating', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_image_box_link',
            [
                'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'awesome-widgets-elementor' ),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'awea_image_box_selected_icon',
            [
                'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-arrow-right',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: LAYOUT ---
        $this->start_controls_section(
            'awea_image_box_section_style_layout',
            [
                'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_image_box_text_align',
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
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-card' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_image_box_card_padding',
            [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_image_box_card_bg_color',
            [
                'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'awea_image_box_card_border',
                'selector' => '{{WRAPPER}} .awea-image-box-card',
            ]
        );

        $this->add_responsive_control(
            'awea_image_box_card_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: CONTENT ---
        $this->start_controls_section(
            'awea_image_box_section_style_content',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_image_box_heading_title',
            [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_image_box_title_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => Global_Colors::COLOR_TEXT ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-content h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_image_box_title_typography',
                'selector' => '{{WRAPPER}} .awea-image-box-content h3',
            ]
        );

        $this->add_control(
            'awea_image_box_heading_description',
            [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'awea_image_box_description_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => Global_Colors::COLOR_TEXT ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_image_box_description_typography',
                'selector' => '{{WRAPPER}} .awea-image-box-content p',
            ]
        );

        $this->end_controls_section();

        // --- STYLE: BUTTON ---
        $this->start_controls_section(
            'awea_image_box_section_style_button',
            [
                'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'awea_image_box_tabs_button_style' );

        $this->start_controls_tab(
            'awea_image_box_tab_button_normal',
            [
                'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_image_box_button_text_color',
            [
                'label' => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => Global_Colors::COLOR_ACCENT ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-action-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_image_box_button_background_color',
            [
                'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [ 'default' => Global_Colors::COLOR_TEXT ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-action-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_image_box_button_typography',
                'selector' => '{{WRAPPER}} .awea-image-box-action-btn',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'awea_image_box_button_padding',
            [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-action-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; display: inline-block;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'awea_image_box_button_border',
                'selector' => '{{WRAPPER}} .awea-image-box-action-btn',
            ]
        );

        $this->add_responsive_control(
            'awea_image_box_button_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-action-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'awea_image_box_tab_button_hover',
            [
                'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_image_box_button_hover_text_color',
            [
                'label' => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-action-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_image_box_button_hover_background_color',
            [
                'label' => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-image-box-action-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $awea_image_box_image_box = $settings['awea_image_box_image_box']['url'];
        $awea_image_box_title_text = $settings['awea_image_box_title_text'];
        $awea_image_box_description_text  = $settings['awea_image_box_description_text'];
        
        $awea_btn_title = $settings['awea_image_box_button_text'];
        $awea_btn_icon  = $settings['awea_image_box_selected_icon']['value'];
        $awea_btn_url   = $settings['awea_image_box_link']['url'];

        ?>

        <div class="awea-image-box-card">        
            <div class="awea-image-box-img-container">
                <img src="<?php echo esc_url($awea_image_box_image_box);?>" alt="Abstract gradient">
            </div>
            <div class="awea-image-box-content">
                <h3><?php echo esc_html($awea_image_box_title_text);?></h3>
                <p><?php echo esc_html($awea_image_box_description_text);?></p>                
                <a href="<?php echo esc_url($awea_btn_url);?>" class="awea-image-box-action-btn">
                    <?php echo esc_html($awea_btn_title);?>
                    <i class="<?php echo esc_attr($awea_btn_icon);?>"></i>
                </a>
            </div>
            <div class="awea-image-box-sparkle"></div>
        </div>
        <?php 
    }
}