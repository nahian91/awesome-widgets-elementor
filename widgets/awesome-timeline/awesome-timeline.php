<?php
/**
 * Awesome Timeline Widget.
 * Architectural Design with Pure CSS Scroll Animations.
 * * @since 1.0.0
 */
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Timeline extends Widget_Base {

    public function get_name() {
        return 'awesome-timeline';
    }

    public function get_title() {
        return esc_html__( 'Timeline', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-time-line';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'timeline', 'awesome', 'modern', 'architectural'];
    }

    protected function register_controls() {
        
        // --- CONTENT SECTION ---
        $this->start_controls_section(
           'awea_timeline_contents',
            [
                'label' => esc_html__('Contents', 'awesome-widgets-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $repeater = new Repeater();

        $repeater->add_control(
            'awea_timeline_year',
            [
                'label' => esc_html__( 'Sub Title', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '2024',
                'label_block' => true,
                'separator' => 'after'
            ]
        );

        $repeater->add_control(
            'awea_timeline_title',
            [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Deep Audit',
                'label_block' => true,
                'separator' => 'after'
            ]
        );

        $repeater->add_control(
            'awea_timeline_desc',
            [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'We perform a deep dive into your existing data structures to find inefficiencies.',
            ]
        );

        $this->add_control(
            'awea_timeline_items',
            [
                'label' => esc_html__( 'Timeline Items', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'awea_timeline_year'  => 'Discovery',
                        'awea_timeline_title' => 'Deep Audit',
                        'awea_timeline_desc'  => 'We perform a deep dive into your existing data structures to find inefficiencies.',
                    ],
                    [
                        'awea_timeline_year'  => 'Structure',
                        'awea_timeline_title' => 'Logic Mapping',
                        'awea_timeline_desc'  => 'Defining the backbone of your application. We map every user flow and database relationship.',
                    ],
                    [
                        'awea_timeline_year'  => 'Finalize',
                        'awea_timeline_title' => 'System Launch',
                        'awea_timeline_desc'  => 'The final transition to a high-performance environment with automated testing.',
                    ],
                ],
                'title_field' => '{{{ awea_timeline_year }}} - {{{ awea_timeline_title }}}',
            ]
        );

        $this->end_controls_section();

        // --- PREMIUM MESSAGE SECTION ---
        $this->start_controls_section(
            'awea_timeline_pro_message',
            [
                'label' => esc_html__('Premium', 'awesome-widgets-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT        
            ]
        );

        $this->add_control( 
            'awea_timeline_pro_message_notice', 
            [
                'type'      => Controls_Manager::RAW_HTML,
                'raw'       => sprintf(
                    '<div style="text-align:center;line-height:1.6;"><p style="margin-bottom:10px">%s</p></div>',
                    esc_html__('Awesome Widgets for Elementor Premium is coming soon.', 'awesome-widgets-elementor')
                )
            ]  
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'awea_timeline_layout_style',
            [
                'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_timeline_layout_bg',
            [
                'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-content' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'awea_timeline_layout_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem'],
                'default' => [ 'top' => '40', 'right' => '40', 'bottom' => '40', 'left' => '40', 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_timeline_layout_padding',
            [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem'],
                'default' => [ 'top' => '45', 'right' => '45', 'bottom' => '45', 'left' => '45', 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_timeline_border_color',
            [
                'label' => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-content:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_timeline_dot_color',
            [
                'label' => esc_html__( 'Dot Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-dot' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .awea-timeline-item:hover .timeline-dot' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_timeline_line_color',
            [
                'label' => esc_html__( 'Line Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-container::before' => 'background: linear-gradient(to bottom, transparent, {{VALUE}} 15%, {{VALUE}} 85%, transparent);',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'awea_timeline_subtitle_style',
            [
                'label' => esc_html__( 'Sub Title', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_timeline_subtitle_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-step-tag' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_timeline_subtitle_bg',
            [
                'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-step-tag' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control( 
            Group_Control_Typography::get_type(), 
            [ 
                'name' => 'awea_timeline_subtitle_typography', 
                'selector' => '{{WRAPPER}} .awea-step-tag' 
            ] 
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'awea_timeline_title_style',
            [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_timeline_title_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-content h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control( 
            Group_Control_Typography::get_type(), 
            [ 
                'name' => 'awea_timeline_title_typography', 
                'selector' => '{{WRAPPER}} .awea-timeline-content h3' 
            ] 
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'awea_timeline_desc_style',
            [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_timeline_desc_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-timeline-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control( 
            Group_Control_Typography::get_type(), 
            [ 
                'name' => 'awea_timeline_desc_typography', 
                'selector' => '{{WRAPPER}} .awea-timeline-content p' 
            ] 
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = $settings['awea_timeline_items'];

        if ( empty( $items ) ) return;
        ?>       

        <div class="awea-timeline-container">
            <?php foreach ( $items as $item ) : ?>
                <div class="awea-timeline-item">
                    <div class="awea-timeline-dot"></div>
                    <div class="awea-timeline-content">
                        <?php if ( ! empty( $item['awea_timeline_year'] ) ) : ?>
                            <div class="awea-step-tag"><?php echo esc_html( $item['awea_timeline_year'] ); ?></div>
                        <?php endif; ?>
                        
                        <h3><?php echo esc_html( $item['awea_timeline_title'] ); ?></h3>
                        <p><?php echo esc_html( $item['awea_timeline_desc'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php
    }
}