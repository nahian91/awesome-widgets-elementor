<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Awesome Business Hours Widget
 * * Custom Elementor widget with Glassmorphism and Real-time Status.
 */
class Widget_Awesome_Business_Hours extends Widget_Base {

    public function get_name() { 
        return 'awesome-business-hours'; 
    }
    
    public function get_title() { 
        return esc_html__( 'Business Hours', 'awesome-widgets-elementor' ); 
    }
    
    public function get_icon() { 
        return 'eicon-clock-o'; 
    }
    
    public function get_categories() { 
        return [ 'awesome-widgets-elementor' ]; 
    }

    protected function register_controls() {

        // --- CONTENT SECTION ---
        $this->start_controls_section(
            'awea_business_hours_content', 
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_business_hours_heading', 
            [
                'label' => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( "We're ready to create.", 'awesome-widgets-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_business_hours_desc', 
            [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Visit our studio or give us a call during our operational hours. Our engineering team is always on standby for your logistics.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_business_hours_phone_label', 
            [
                'label' => esc_html__( 'Phone Label', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Support Line',
            ]
        );

        $this->add_control(
            'awea_business_hours_phone_number', 
            [
                'label' => esc_html__( 'Phone Number', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '+1 (555) 000-8888',
            ]
        );

        $this->end_controls_section();

        // --- REPEATER SECTION ---
        $this->start_controls_section(
            'awea_business_hours_hours_section', 
            [
                'label' => esc_html__( 'Weekly Schedule', 'awesome-widgets-elementor' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control('awea_business_day_name', 
            [
                'label' => esc_html__( 'Day Name', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Monday',
            ]
        );

        $repeater->add_control('awea_business_day_hours', 
            [
                'label' => esc_html__( 'Display Hours', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => '09:00 AM — 06:00 PM',
            ]
        );

        $repeater->add_control('awea_business_is_closed', 
        [
            'label' => esc_html__( 'Mark as Closed', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
            'label_off' => esc_html__( 'No', 'awesome-widgets-elementor' ),
            'return_value' => 'yes',
            'default' => '',
        ]);

        $this->add_control('awea_business_hours_list', 
        [
            'label' => esc_html__( 'Schedule Rows', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                ['awea_business_day_name' => 'Monday', 'awea_business_day_hours' => '09:00 AM — 06:00 PM'],
                ['awea_business_day_name' => 'Tuesday', 'awea_business_day_hours' => '09:00 AM — 06:00 PM'],
                ['awea_business_day_name' => 'Wednesday', 'awea_business_day_hours' => '09:00 AM — 06:00 PM'],
                ['awea_business_day_name' => 'Thursday', 'awea_business_day_hours' => '09:00 AM — 06:00 PM'],
                ['awea_business_day_name' => 'Friday', 'awea_business_day_hours' => '09:00 AM — 06:00 PM'],
                ['awea_business_day_name' => 'Saturday', 'awea_business_day_hours' => '10:00 AM — 04:00 PM'],
                ['awea_business_day_name' => 'Sunday', 'awea_business_day_hours' => 'CLOSED', 'awea_business_is_closed' => 'yes'],
            ],
            'title_field' => '{{{ awea_business_day_name }}}',
        ]);

        $this->end_controls_section();

        // --- STYLE SECTION: CONTAINER ---
        $this->start_controls_section('awea_business_hours_layout_style', 
        [
            'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('awea_business_hours_layout_bg', 
        [
            'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::COLOR,
            'default' => 'rgba(255, 255, 255, 0.05)',
            'selectors' => [
                '{{WRAPPER}} .awea-business-hours-root' => 'background: {{VALUE}};',
            ],
        ]);

        $this->add_control(
			'awea_business_hours_layout_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .awea-business-hours-status-side, {{WRAPPER}} .awea-business-hours-schedule-side' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'awea_business_hours_layout_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .awea-business-hours-root' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section('awea_business_hours_content_style', 
        [
            'label' => esc_html__( 'Contents', 'awesome-widgets-elementor' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control(
			'awea_business_hours_content_subusiness-hourseading',
			[
				'label' => esc_html__( 'Sub Heading', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control('awea_business_hours_content_subusiness-hourseading_color', 
        [
            'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .awea-business-hours-badge' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_business_hours_content_subusiness-hourseading_typography',
                'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-business-hours-badge',
            ]
        );

        $this->add_control(
			'awea_business_hours_content_heading',
			[
				'label' => esc_html__( 'Heading', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control('awea_business_hours_content_heading_color', 
        [
            'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .awea-business-hours-status-side h2' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_business_hours_content_heading_typography',
                'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-business-hours-status-side h2',
            ]
        );

        $this->add_control(
			'awea_business_hours_content_desc',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control('awea_business_hours_content_desc_color', 
        [
            'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .awea-business-hours-status-side p' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_business_hours_content_desc_typography',
                'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-business-hours-status-side p',
            ]
        );

        $this->add_control(
			'awea_business_hours_content_info',
			[
				'label' => esc_html__( 'Info', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);      
        
        $this->add_control('awea_business_hours_content_info_label_color', 
        [
            'label' => esc_html__( 'Label Color', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .awea-business-hours-support-label' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_business_hours_content_info_label_typography',
                'label' => esc_html__( 'Label Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-business-hours-support-label',
                'separator' => 'after'
            ]
        );

        $this->add_control('awea_business_hours_content_info_desc_color', 
        [
            'label' => esc_html__( 'Hours Color', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .awea-business-hours-support-num' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_business_hours_content_info_desc_typography',
                'label' => esc_html__( 'Hours Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-business-hours-support-num',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('awea_business_hours_schedule', 
        [
            'label' => esc_html__( 'Schedule Hours', 'awesome-widgets-elementor' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control(
			'awea_business_hours_days_label',
			[
				'label' => esc_html__( 'Days Label', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control('awea_business_hours_days_label_color', 
        [
            'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .awea-business-hours-day' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_business_hours_days_label_typography',
                'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-business-hours-day',
            ]
        );

        $this->add_control(
			'awea_business_hours_item_label',
			[
				'label' => esc_html__( 'Hours Label', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control('awea_business_hours_item_label_color', 
        [
            'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .awea-business-hours-time' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_business_hours_item_label_typography',
                'label' => esc_html__( 'Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-business-hours-time',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $current_day_name = gmdate('l'); 
        $is_currently_open = true;

        // Corrected logical check for "Open Now"
        if ( ! empty( $settings['awea_business_hours_list'] ) ) {
            foreach ($settings['awea_business_hours_list'] as $item) {
                if ( trim($item['awea_business_day_name']) === $current_day_name && $item['awea_business_is_closed'] === 'yes' ) {
                    $is_currently_open = false;
                }
            }
        }
        ?>

        <div class="awea-business-hours-root">
            <div class="awea-business-hours-grid">
                
                <div class="awea-business-hours-status-side">
                    <div class="awea-business-hours-badge <?php echo $is_currently_open ? '' : 'closed'; ?>">
                        <div class="awea-business-hours-pulse"></div> 
                        <span><?php echo $is_currently_open ? esc_html__('Open Now', 'awesome-widgets-elementor') : esc_html__('Closed', 'awesome-widgets-elementor'); ?></span>
                    </div>
                    
                    <h2><?php echo esc_html($settings['awea_business_hours_heading']); ?></h2>
                    <p><?php echo esc_html($settings['awea_business_hours_desc']); ?></p>
                    
                    <div style="margin-top: auto; padding-top: 20px;">
                        <div class="awea-business-hours-support-label"><?php echo esc_html($settings['awea_business_hours_phone_label']); ?></div>
                        <div class="awea-business-hours-support-num"><?php echo esc_html($settings['awea_business_hours_phone_number']); ?></div>
                    </div>
                </div>

                <div class="awea-business-hours-schedule-side">
                    <?php 
                    if ( ! empty( $settings['awea_business_hours_list'] ) ) :
                        foreach ( $settings['awea_business_hours_list'] as $item ) : 
                            $is_today = ( trim($item['awea_business_day_name']) === $current_day_name ) ? 'active' : '';
                            $is_closed = ( $item['awea_business_is_closed'] === 'yes' );
                            ?>
                            <div class="awea-business-hours-row <?php echo esc_attr($is_today); ?>">
                                <span class="awea-business-hours-day" <?php echo $is_closed ? 'style="opacity:0.5;"' : ''; ?>>
                                    <?php echo esc_html($item['awea_business_day_name']); ?>
                                </span>
                                <span class="awea-business-hours-time <?php echo $is_closed ? 'is-closed-text' : ''; ?>" <?php echo $is_closed ? 'style="font-weight:700;"' : ''; ?>>
                                    <?php echo esc_html($item['awea_business_day_hours']); ?>
                                </span>
                            </div>
                        <?php endforeach; 
                    endif; ?>
                </div>

            </div>
        </div>
        <?php
    }
}