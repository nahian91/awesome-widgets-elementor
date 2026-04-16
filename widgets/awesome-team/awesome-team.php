<?php
/**
 * Awesome Team Widget.
 *
 * Elementor widget that inserts a team into the page
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

class Widget_Awesome_Team extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'awesome-team';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__( 'Team', 'awesome-widgets-elementor' );
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-user-circle-o';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    /**
     * Get widget keywords.
     */
    public function get_keywords() {
        return [ 'team', 'member', 'awesome'];
    }

    /**
     * Register widget controls.
     */
    protected function _register_controls() {
        
        // --- SECTION: IMAGE CONTENT ---
        $this->start_controls_section(
           'awea_single_team_image_content',
            [
                'label' => esc_html__('Image', 'awesome-widgets-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,      
            ]
        );

        $this->add_control(
            'awea_single_team_image_upload',
            [
                'label' => esc_html__( 'Choose Image', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        
        $this->end_controls_section();

        // --- SECTION: TEXT CONTENTS ---
        $this->start_controls_section(
            'awea_single_team_contents',
            [
                'label' => esc_html__('Contents', 'awesome-widgets-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,       
            ]
        );

        $this->add_control(
            'awea_single_team_name',
            [
                'label' => esc_html__( 'Name', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'John Doe', 'awesome-widgets-elementor' ),
                'placeholder' => esc_html__( 'Type your title here', 'awesome-widgets-elementor' ),
                'label_block' => true
            ]
        );

        $this->add_control(
            'awea_single_team_designation',
            [
                'label' => esc_html__( 'Designation', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Web Developer', 'awesome-widgets-elementor' ),
                'placeholder' => esc_html__( 'Type your title here', 'awesome-widgets-elementor' ),
                'label_block' => true
            ]
        );
        
        $this->end_controls_section();

        // --- SECTION: SOCIAL REPEATER ---
        $this->start_controls_section(
            'awea_single_team_socials',
            [
                'label' => esc_html__('Socials', 'awesome-widgets-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'awea_single_team_socials_title',
            [
                'label' => esc_html__('Title', 'awesome-widgets-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Facebook', 'awesome-widgets-elementor'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_single_team_socials_icon',
            [
                'label' => esc_html__('Icon', 'awesome-widgets-elementor'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fab fa-facebook',
                    'library' => 'fa-brands',
                ],
            ]
        );

        $repeater->add_control(
            'awea_single_team_socials_link',
            [
                'label' => esc_html__('Link', 'awesome-widgets-elementor'),
                'type' => Controls_Manager::URL,
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_single_team_socials_list',
            [
                'label' => esc_html__('Social Media Links', 'awesome-widgets-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'awea_single_team_socials_title' => esc_html__('Facebook', 'awesome-widgets-elementor'),
                        'awea_single_team_socials_icon' => ['value' => 'fab fa-facebook', 'library' => 'fa-brands'],
                        'awea_single_team_socials_link' => ['url' => 'https://facebook.com'],
                    ],
                    [
                        'awea_single_team_socials_title' => esc_html__('Twitter', 'awesome-widgets-elementor'),
                        'awea_single_team_socials_icon' => ['value' => 'fab fa-x-twitter', 'library' => 'fa-brands'],
                        'awea_single_team_socials_link' => ['url' => 'https://twitter.com'],
                    ],
                ],
                'title_field' => '{{{ awea_single_team_socials_title }}}',
            ]
        );

        $this->end_controls_section();

        // --- SECTION: PREMIUM MESSAGE ---
        $this->start_controls_section(
            'awea_single_team_pro_message',
            [
                'label' => esc_html__('Premium', 'awesome-widgets-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT        
            ]
        );

        $this->add_control( 
            'awea_single_team_pro_message_notice', 
            [
                'type'      => Controls_Manager::RAW_HTML,
                'raw'       => sprintf(
                    '<div style="text-align:center;line-height:1.6;"><p>%s</p></div>',
                    esc_html__('Awesome Widgets for Elementor Premium is coming soon.', 'awesome-widgets-elementor')
                )
            ]  
        );
        $this->end_controls_section();
        
        // --- STYLE: LAYOUTS (DETAILED) ---
        $this->start_controls_section(
            'awea_single_team_layout_style',
            [
                'label' => esc_html__( 'Layouts', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_single_team_background_color',
            [
                'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .awea-team-master-card' => 'background-color: {{VALUE}}',
                ],
                'global' => [ 
                    'default' => Global_Colors::COLOR_PRIMARY 
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'awea_single_team_border',
                'selector' => '{{WRAPPER}} .awea-team-master-card',
            ]
        );  

        $this->add_control(
            'awea_single_team_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .awea-team-master-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_single_team_padding',
            [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .awea-team-master-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: IMAGE (DETAILED) ---
        $this->start_controls_section(
            'awea_single_team_image_style',
            [
                'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'awea_single_team_image_width',
            [
                'label' => esc_html__('Image Width', 'awesome-widgets-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => ['min' => 0, 'max' => 100],
                    'px' => ['min' => 0, 'max' => 1000],
                ],
                'default' => [ 'unit' => '%', 'size' => 100 ],
                'selectors' => [
                    '{{WRAPPER}} .awea-team-img-container' => 'width: {{SIZE}}{{UNIT}}; margin: 0 auto;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'awea_single_team_image_box_border',
                'selector' => '{{WRAPPER}} .awea-team-img-container img',
            ]
        );  
        
        $this->add_control(
            'awea_image_box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .awea-team-img-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: CONTENTS (NAME & DESIGNATION) ---
        $this->start_controls_section(
            'awea_single_team_contents_style',
            [
                'label' => esc_html__( 'Contents', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_single_team_content_bg',
            [
                'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-team-info-panel' => 'background-color: {{VALUE}}' ],
                'global' => [ 'default' => Global_Colors::COLOR_PRIMARY ]
            ]
        );

        $this->add_control( 'name_heading', [ 'label' => esc_html__( 'Name', 'awesome-widgets-elementor' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );

        $this->add_control(
            'awea_single_team_name_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-team-name' => 'color: {{VALUE}}' ],
                'global' => [ 'default' => Global_Colors::COLOR_SECONDARY ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_single_team_name_typography',
                'selector' => '{{WRAPPER}} .awea-team-name',
                'global' => [ 'default' => Global_Typography::TYPOGRAPHY_SECONDARY ]
            ]
        );

        $this->add_control( 'awea_single_team_desig_heading', [ 'label' => esc_html__( 'Designation', 'awesome-widgets-elementor' ), 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );

        $this->add_control(
            'awea_single_team_desig_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-team-role' => 'color: {{VALUE}}' ],
                'global' => [ 'default' => Global_Colors::COLOR_TEXT ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_single_team_desig_typography',
                'selector' => '{{WRAPPER}} .awea-team-role',
                'global' => [ 'default' => Global_Typography::TYPOGRAPHY_TEXT ]
            ]
        );

        $this->end_controls_section();

        // --- STYLE: SOCIALS (TABS) ---
        $this->start_controls_section(
            'awea_single_team_social_style',
            [
                'label' => esc_html__( 'Socials', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('awea_single_team_social_tabs');

        $this->start_controls_tab('awea_single_team_social_normal', ['label' => esc_html__('Normal', 'awesome-widgets-elementor')]);
        
        $this->add_control(
            'awea_single_team_social_size',
            [
                'label' => esc_html__( 'Size', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [ 'px' => [ 'min' => 10, 'max' => 50 ] ],
                'selectors' => [ '{{WRAPPER}} .awea-team-social-btn i' => 'font-size: {{SIZE}}px; width: calc({{SIZE}}px + 20px); height: calc({{SIZE}}px + 20px);' ],
            ]
        );

        $this->add_control(
            'awea_single_team_social_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-team-social-btn i' => 'color: {{VALUE}}' ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('awea_single_team_social_hover', ['label' => esc_html__('Hover', 'awesome-widgets-elementor')]);

        $this->add_control(
            'awea_single_team_social_color_hover',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-team-social-btn i:hover' => 'color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Frontend Render
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $image_url = !empty($settings['awea_single_team_image_upload']['url']) ? $settings['awea_single_team_image_upload']['url'] : '';
        $awea_single_team_name = $settings['awea_single_team_name'];
        $awea_single_team_designation = $settings['awea_single_team_designation'];
        $awea_single_team_socials_list = $settings['awea_single_team_socials_list'];
        ?>
        <article class="awea-team-master-card">
        <div class="awea-team-img-container">
            <img src="<?php echo esc_url($image_url);?>" alt="<?php echo esc_attr($awea_single_team_name);?>">
        </div>

        <div class="awea-team-info-panel">
            <h3 class="awea-team-name"><?php echo esc_html($awea_single_team_name);?></h3>
            <p class="awea-team-role"><?php echo esc_html($awea_single_team_designation);?></p>
            
            <div class="awea-team-social-dock">
                <?php 
                    foreach($awea_single_team_socials_list as $social) {
                        ?>
                        <a href="<?php echo $social['awea_single_team_socials_link']['url']; ?>" class="awea-team-social-btn" target="_blank"><i class="<?php echo $social['awea_single_team_socials_icon']['value']; ?>"></i></a>
                        <?php 
                    }
                ?>
            </div>
        </div>
    </article>
        <?php
    }
}