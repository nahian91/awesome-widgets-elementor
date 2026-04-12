<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Accordion extends Widget_Base {

    public function get_name() {
        return 'awesome-accordion';
    }

    public function get_title() {
        return esc_html__('Accordion', 'awesome-widgets-elementor');
    }

    public function get_icon() {
        return 'eicon-accordion';
    }

    public function get_categories() {
        return ['awesome-widgets-elementor'];
    }

    public function get_keywords() {
        return [ 'accordion', 'Accordion', 'awesome'];
    }

    protected function register_controls() {        
        // --- Content Tab ---
        $this->start_controls_section(
           'accordion_content',
            [
                'label' => esc_html__('Content', 'awesome-widgets-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,          
            ]
        );
        
        $repeater = new Repeater();

        $repeater->add_control(
            'awea_accordion_title',
            [
                'label' => esc_html__( 'Accordion Question', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Where can I find your warranty policy?', 'awesome-widgets-elementor' ),
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'awea_accordion_content',
            [
                'label' => esc_html__( 'Accordion Answer', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_accordion_list',
            [
                'label' => esc_html__( 'Accordion Lists', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ awea_accordion_title }}}',
                'default' => [
                    [
                        'awea_accordion_title' => esc_html__( 'Do you offer gift wrapping?', 'awesome-widgets-elementor' ),
                        'awea_accordion_content' => esc_html__( 'Yes, we offer premium gift wrapping for all our products.', 'awesome-widgets-elementor' )
                    ],
                    [
                        'awea_accordion_title' => esc_html__( 'Can I track my order in real-time?', 'awesome-widgets-elementor'),
                        'awea_accordion_content' => esc_html__( 'Absolutely! Once your order ships, you will receive a tracking link.', 'awesome-widgets-elementor' )
                    ],
                ],
            ]
        );
        
        $this->end_controls_section();

        // --- Style Tab: Layout ---
        $this->start_controls_section(
            'awea_accordion_options',
            [
                'label' => esc_html__( 'General Styling', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_accordion_border_color',
            [
                'label' => esc_html__( 'Item Border Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-accordion-item' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
        
        // --- Style Tab: Title ---
        $this->start_controls_section(
            'awea_accordion_title_options',
            [
                'label' => esc_html__( 'Accordion Question', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'awea_accordion_title_color',
            [
                'label' => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_SECONDARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-accordion-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_accordion_title_typography',
                'selector' => '{{WRAPPER}} .awea-accordion-title',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
                ]
            ]
        );

        $this->end_controls_section();

        // --- Style Tab: Description ---
        $this->start_controls_section(
            'awea_accordion_desc_options',
            [
                'label' => esc_html__( 'Accordion Answer', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'awea_accordion_desc_color',
            [
                'label' => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
                'selectors' => [
                    '{{WRAPPER}} .awea-content-inner' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_accordion_desc_typography',
                'selector' => '{{WRAPPER}} .awea-content-inner',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();        
        $list = isset($settings['awea_accordion_list']) ? $settings['awea_accordion_list'] : []; 

        if ( empty( $list ) ) return;
        ?>

        <style>
            .awea-accordion-container {
                max-width: 100%;
                font-family: sans-serif;
            }
            .awea-accordion-item {
                background: #fff;
                border: 1px solid #edf2f7;
                border-radius: 12px;
                margin-bottom: 16px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                overflow: hidden;
            }
            .awea-accordion-item:hover {
                box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            }
            .awea-accordion-item.is-active {
                border-color: #3182ce;
                box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
            }
            .awea-accordion-header {
                padding: 20px 24px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                cursor: pointer;
                user-select: none;
            }
            .awea-accordion-title {
                margin: 0;
                font-size: 17px;
                font-weight: 600;
                color: #2d3748;
                transition: color 0.3s ease;
            }
            .awea-accordion-item.is-active .awea-accordion-title {
                color: #3182ce;
            }
            /* Micro-interaction Icon */
            .awea-icon-box {
                position: relative;
                width: 20px;
                height: 20px;
                flex-shrink: 0;
            }
            .awea-icon-line {
                position: absolute;
                background: currentColor;
                border-radius: 2px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .awea-icon-line.v { width: 2px; height: 100%; left: 50%; margin-left: -1px; }
            .awea-icon-line.h { width: 100%; height: 2px; top: 50%; margin-top: -1px; }
            
            .awea-accordion-item.is-active .awea-icon-line.v { transform: rotate(90deg); opacity: 0; }
            .awea-accordion-item.is-active .awea-icon-line.h { transform: rotate(180deg); background: #3182ce; }

            /* Content Transition */
            .awea-accordion-content {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.5s cubic-bezier(0, 1, 0, 1);
            }
            .awea-accordion-item.is-active .awea-accordion-content {
                max-height: 1000px;
                transition: max-height 1s ease-in-out;
            }
            .awea-content-inner {
                padding: 0 24px 24px 24px;
                color: #718096;
                line-height: 1.6;
            }
        </style>

        <div class="awea-accordion-container">
            <?php foreach ( $list as $index => $item ) : 
                $active_class = ($index === 0) ? 'is-active' : ''; 
                ?>
                <div class="awea-accordion-item <?php echo esc_attr($active_class); ?>">
                    <div class="awea-accordion-header">
                        <h4 class="awea-accordion-title">
                            <?php echo esc_html($item['awea_accordion_title']); ?>
                        </h4>
                        <div class="awea-icon-box">
                            <span class="awea-icon-line h"></span>
                            <span class="awea-icon-line v"></span>
                        </div>
                    </div>
                    <div class="awea-accordion-content">
                        <div class="awea-content-inner">
                            <?php echo wp_kses_post($item['awea_accordion_content']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <script>
            jQuery(document).ready(function($) {
                $('.awea-accordion-header').on('click', function() {
                    const $item = $(this).closest('.awea-accordion-item');
                    const $container = $(this).closest('.awea-accordion-container');
                    
                    if ($item.hasClass('is-active')) {
                        $item.removeClass('is-active');
                    } else {
                        $container.find('.awea-accordion-item').removeClass('is-active');
                        $item.addClass('is-active');
                    }
                });
            });
        </script>
        <?php
    }   
}