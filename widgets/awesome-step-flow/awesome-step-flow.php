<?php
/**
 * Awesome Timeline Widget.
 *
 * Elementor widget that inserts a step flow process into the page.
 *
 * @since 1.0.0
 */
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;
use \Elementor\Repeater;

class Widget_Awesome_Step_Flow extends Widget_Base {

    public function get_name() {
        return 'awesome-step-flow';
    }

    public function get_title() {
        return esc_html__( 'Step Flow', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-flow';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'step', 'awesome', 'flow', 'process' ];
    }

    protected function register_controls() {

        // --- CONTENT SECTION ---
        $this->start_controls_section(
            'awea_section_content',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'awea_step_icon',
            [
                'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-cube',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'awea_step_number',
            [
                'label' => esc_html__( 'Step Number', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( '01', 'awesome-widgets-elementor' ),
            ]
        );

        $repeater->add_control(
            'awea_step_title',
            [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Step Title', 'awesome-widgets-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_step_description',
            [
                'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Enter your step description here.', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_steps_list',
            [
                'label' => esc_html__( 'Flow Steps', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'awea_step_title' => esc_html__( 'Abstraction', 'awesome-widgets-elementor' ),
                        'awea_step_number' => '01',
                    ],
                    [
                        'awea_step_title' => esc_html__( 'Processing', 'awesome-widgets-elementor' ),
                        'awea_step_number' => '02',
                    ],
                ],
                'title_field' => '{{{ awea_step_title }}}',
            ]
        );

        $this->end_controls_section();

        // --- STYLE SECTION: LAYOUT ---
        $this->start_controls_section(
            'awea_section_style_layout',
            [
                'label' => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_separator_color',
            [
                'label' => esc_html__( 'Separator Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
				'global' => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [
                    '{{WRAPPER}} .awea-flow-beam' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_separator_hover_color',
            [
                'label' => esc_html__( 'Separator Hover Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
				'global' => [ 'default' => Global_Colors::COLOR_ACCENT ],
                'selectors' => [
                    '{{WRAPPER}} .awea-step-container:hover .awea-flow-beam' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE SECTION: ICON & NUMBER ---
        $this->start_controls_section(
            'awea_section_style_icon',
            [
                'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'awea_tabs_icon_style' );

        // Normal Tab
        $this->start_controls_tab(
            'awea_tab_icon_normal',
            [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
        );

		$this->add_control(
			'awea_icon_heading',
			[
				'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'awea_icon_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
				'global' => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [ '{{WRAPPER}} .awea-step-box i' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_icon_bg_color',
            [
                'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
				'global' => [ 'default' => Global_Colors::COLOR_TEXT ],
                'selectors' => [ '{{WRAPPER}} .awea-step-box' => 'background-color: {{VALUE}};' ],
            ]
        );

		$this->add_control(
			'awea_number_heading',
			[
				'label' => esc_html__( 'Number', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'awea_num_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
				'global' => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [ '{{WRAPPER}} .awea-step-number' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_num_bg_color',
            [
                'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'global' => [ 'default' => Global_Colors::COLOR_ACCENT ],
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-step-number' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'awea_tab_icon_hover',
            [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ]
        );

        $this->add_control(
            'awea_icon_hover_color',
            [
                'label' => esc_html__( 'Icon Color (Hover)', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-step-item:hover .awea-step-box i' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_icon_bg_hover_color',
            [
                'label' => esc_html__( 'Background Color (Hover)', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-step-item:hover .awea-step-box' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        // --- STYLE SECTION: CONTENT ---
        $this->start_controls_section(
            'awea_section_style_content',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'awea_title_heading',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'awea_title_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
				'global' => [ 'default' => Global_Colors::COLOR_TEXT ],
                'selectors' => [ '{{WRAPPER}} .awea-step-title' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_title_typography',
                'selector' => '{{WRAPPER}} .awea-step-title',
            ]
        );

		$this->add_control(
			'awea_desc_heading',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'awea_desc_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
				'global' => [ 'default' => Global_Colors::COLOR_TEXT ],
                'selectors' => [ '{{WRAPPER}} .awea-step-desc' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_desc_typography',
                'selector' => '{{WRAPPER}} .awea-step-desc',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $steps = $settings['awea_steps_list'];

        if ( empty( $steps ) ) {
            return;
        }
        ?>
        <div class="awea-step-container">
            <?php 
            foreach ( $steps as $index => $item ) : 
                $repeater_setting_key = $this->get_repeater_setting_key( 'awea_step_title', 'awea_steps_list', $index );
                $this->add_inline_editing_attributes( $repeater_setting_key, 'none' );
            ?>
                <div class="awea-step-item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
                    <div class="awea-step-box">
                        <?php Icons_Manager::render_icon( $item['awea_step_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php if ( ! empty( $item['awea_step_number'] ) ) : ?>
                            <div class="awea-step-number"><?php echo esc_html( $item['awea_step_number'] ); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="awea-step-content">
                        <h3 class="awea-step-title <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>">
                            <?php echo esc_html( $item['awea_step_title'] ); ?>
                        </h3>
                        <p class="awea-step-desc">
                            <?php echo esc_html( $item['awea_step_description'] ); ?>
                        </p>
                    </div>
                </div>

                <?php if ( $index !== count( $steps ) - 1 ) : ?>
                    <div class="awea-flow-connector">
                        <div class="awea-flow-beam"></div>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
        <?php
    }
}