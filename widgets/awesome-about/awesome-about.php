<?php
/**
 * Awesome About Widget.
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Widget_Awesome_About extends Widget_Base {

    public function get_name() { 
        return 'awesome-about'; 
    }
    public function get_title() { 
        return esc_html__( 'About', 'awesome-widgets-elementor' ); 
    }
    public function get_icon() { 
        return 'eicon-person'; 
    }
    public function get_categories() { 
        return [ 'awesome-widgets-elementor' ]; 
    }

    protected function register_controls() {

        // --- CONTENT SECTION: IMAGES ---
        $this->start_controls_section(
            'awea_about_section_images', 
            [
                'label' => esc_html__( 'Images & Badge', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_about_main_image', 
            [
                'label'   => esc_html__( 'Main Image', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            ]
        );

        $this->add_control(
            'awea_about_floating_image', 
            [
                'label'   => esc_html__( 'Floating Circle Image', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            ]
        );

        $this->add_control(
            'awea_about_experience_badge', 
            [
                'label'       => esc_html__( 'Badge Text', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => 'e.g. 25+ Years Experience',
            ]
        );

        $this->end_controls_section();

        // --- CONTENT SECTION: TEXT ---
        $this->start_controls_section(
            'awea_about_section_content', 
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_about_sub_heading', 
            [
                'label'   => esc_html__( 'Sub Heading', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'About Our Company',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_about_main_heading', 
            [
                'label'   => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => 'The World Trusts Our Logistics.',
            ]
        );

        $this->add_control(
            'awea_about_description', 
            [
                'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
                'type'    => Controls_Manager::WYSIWYG,
                'default' => 'We deliver more than just cargo...',
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'awea_about_feature_icon', 
            [
                'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::ICONS,
                'default' => [ 'value' => 'fas fa-circle-check', 'library' => 'fa-solid' ],
            ]
        );

        $repeater->add_control(
            'awea_about_feature_text', 
            [
                'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ),
                'type'  => Controls_Manager::TEXT,
                'default' => 'Global Air Freight',
            ]
        );

        $this->add_control(
            'awea_about_features_list', 
            [
                'label'       => esc_html__( 'Features', 'awesome-widgets-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    ['awea_about_feature_text' => 'Global Air Freight'],
                    ['awea_about_feature_text' => 'Real-time Tracking'],
                ],
                'title_field' => '{{{ awea_about_feature_text }}}',
            ]
        );

        $this->end_controls_section();

        // --- CONTENT SECTION: BUTTONS ---
        $this->start_controls_section('awea_about_section_buttons', 
            [
                'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_about_contact_label', 
            [ 
                'label' => 'Contact Label', 
                'type' => Controls_Manager::TEXT, 
                'default' => 'Direct Line:', 
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_about_contact_number', 
            [ 
                'label' => 'Phone Number', 
                'type' => Controls_Manager::TEXT, 
                'default' => '148 359 505 285', 
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_about_contact_url', 
            [ 
                'label' => 'Phone Link', 
                'type' => Controls_Manager::URL 
            ]
        );

        $this->end_controls_section();

        // --- STYLE TAB: IMAGE & BADGE ---
        $this->start_controls_section('awea_about_style_images', 
            [
                'label' => esc_html__( 'Images', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'awea_about_style_images1_options',
			[
				'label' => esc_html__( 'Main Image', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'awea_about_style_images1_border',
                'selector' => '{{WRAPPER}} .awea-about-image-frame',
            ]
        );  

        $this->add_responsive_control('awea_about_style_images1_radius', 
            [
                'label' => 'Border Radius',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [ '{{WRAPPER}} .awea-about-image-frame' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
			'awea_about_style_images2_options',
			[
				'label' => esc_html__( 'Image 2', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'awea_about_style_images2_border',
                'selector' => '{{WRAPPER}} .awea-about-floating-circle',
            ]
        );  

        $this->add_responsive_control('awea_about_style_images2_radius', 
            [
                'label' => 'Border Radius',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [ '{{WRAPPER}} .awea-about-floating-circle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control('awea_about_badge_heading', 
            [ 
            'label' => 'Badge Style', 
            'type' => Controls_Manager::HEADING, 
            'separator' => 'before' 
            ]
        );

        $this->add_control('awea_about_badge_bg', 
            [ 
                'label' => 'Background', 
                'type' => Controls_Manager::COLOR, 
                'global' => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [ '{{WRAPPER}} .awea-about-ribbon' => 'background: {{VALUE}}' ]
            ]
        );

        $this->add_control('awea_about_badge_color', 
            [ 
                'label' => 'Text Color', 
                'type' => Controls_Manager::COLOR, 
                'global' => [ 'default' => Global_Colors::COLOR_TEXT ],
                'selectors' => [ '{{WRAPPER}} .awea-about-ribbon' => 'color: {{VALUE}}' ]
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), 
            [ 
                'name' => 'awea_about_badge_typo', 
                'selector' => '{{WRAPPER}} .awea-about-ribbon' 
            ]
        );

        $this->end_controls_section();

        // --- STYLE TAB: TYPOGRAPHY ---
        $this->start_controls_section('awea_about_style_content', 
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'awea_about_divider_heading',
			[
				'label' => esc_html__( 'Divider', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control('awea_about_divider_color', 
            [ 
                'label' => 'Color', 
                'type' => Controls_Manager::COLOR, 
                'global' => [ 'default' => Global_Colors::COLOR_TEXT ],
                'selectors' => [ '{{WRAPPER}} .awea-about-label-line' => 'background-color: {{VALUE}}' ]
            ]
        );

        $this->add_control(
			'awea_about_subheading_heading',
			[
				'label' => esc_html__( 'Subheading', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control('awea_about_subheading_color', 
            [ 
                'label' => 'Subheading Color', 
                'type' => Controls_Manager::COLOR, 
                'global' => [ 'default' => Global_Colors::COLOR_TEXT ],
                'selectors' => [ '{{WRAPPER}} .awea-about-label-group' => 'color: {{VALUE}}', '{{WRAPPER}}' ]
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), 
            [ 
            'name' => 'awea_about_subheading_typo', 
            'selector' => '{{WRAPPER}} .awea-about-label-group' 
            ]
        );

        $this->add_control(
			'awea_about_heading_options',
			[
				'label' => esc_html__( 'Heading', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control('awea_about_heading_color', 
            [ 
                'label' => 'Color', 
                'type' => Controls_Manager::COLOR, 
                'global' => [ 'default' => Global_Colors::COLOR_PRIMARY ],
                'selectors' => [ '{{WRAPPER}} .awea-about-heading' => 'color: {{VALUE}}' ]
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), 
            [ 
                'name' => 'awea_about_heading_typo', 
                'selector' => '{{WRAPPER}} .awea-about-heading' 
            ]
        );

        $this->add_control(
			'awea_about_desc_options',
			[
				'label' => esc_html__( 'Description', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control('awea_about_desc_color', 
            [ 
                'label' => 'Description Color', 
                'type' => Controls_Manager::COLOR, 
                'global' => [ 'default' => Global_Colors::COLOR_TEXT ],
                'selectors' => [ '{{WRAPPER}} .awea-about-main-desc' => 'color: {{VALUE}}' ]
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), 
            [ 
                'name' => 'awea_about_desc_typo', 
                'selector' => '{{WRAPPER}} .awea-about-main-desc' 
            ]
        );

        $this->end_controls_section();

        // --- STYLE TAB: FEATURES ---
        $this->start_controls_section('awea_about_style_features', 
            [
                'label' => esc_html__( 'Features', 'awesome-widgets-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control('awea_about_feature_icon_color', 
            [ 
                'label' => 'Icon Color', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .awea-about-check-item svg' => 'fill: {{VALUE}}' ]
            ]
        );

        $this->add_control('awea_about_feature_text_color', 
            [ 
                'label' => 'Text Color', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .awea-about-check-item' => 'color: {{VALUE}}' ]
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), 
            [ 
                'name' => 'awea_about_feature_typo', 
                'selector' => '{{WRAPPER}} .awea-about-check-item' 
            ]
        );

        $this->end_controls_section();

        // --- STYLE: BUTTON ---
        $this->start_controls_section(
            'awea_about_style_button',
            [
                'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );    

        $this->add_control(
			'awea_about_style_icon',
			[
				'label' => esc_html__( 'Icon', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        
        $this->add_control(
            'awea_about_icon_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-about-icon-circle i' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_about_icon_bg',
            [
                'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-about-icon-circle' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_about_icon_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [ '{{WRAPPER}} .awea-about-icon-circle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
			'awea_about_style_text',
			[
				'label' => esc_html__( 'Text', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
            'awea_about_text_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-about-cta-wrapper span' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_about_text_typography',
                'selector' => '{{WRAPPER}} .awea-about-cta-wrapper span',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <main class="awea-about-master-grid">
            <div class="awea-about-visual-container">
                <div class="awea-about-image-frame">
                    <img src="<?php echo esc_url($settings['awea_about_main_image']['url']); ?>" alt="About">
                </div>
                <div class="awea-about-floating-circle">
                    <img src="<?php echo esc_url($settings['awea_about_floating_image']['url']); ?>" alt="About Detail">
                </div>
                <?php if ( ! empty( $settings['experience_badge'] ) ) : ?>
                    <div class="awea-about-ribbon"><?php echo esc_html($settings['awea_about_experience_badge']); ?></div>
                <?php endif; ?>
            </div>

            <div class="awea-about-text-content">
                <div class="awea-about-label-group">
                    <div class="awea-about-label-line"></div>
                    <?php echo esc_html($settings['awea_about_sub_heading']); ?>
                </div>

                <h2 class="awea-about-heading"><?php echo esc_html($settings['awea_about_main_heading']); ?></h2>

                <div class="awea-about-main-desc">
                    <?php echo $settings['awea_about_description']; ?>
                </div>

                <div class="awea-about-feature-box">
                    <?php foreach ( $settings['awea_about_features_list'] as $item ) : ?>
                        <div class="awea-about-check-item">
                            <?php Icons_Manager::render_icon( $item['awea_about_feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <?php echo esc_html($item['awea_about_feature_text']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="awea-about-cta-wrapper">
                    <a href="<?php echo esc_url($settings['awea_about_contact_url']['url']); ?>" class="awea-about-phone-call">
                        <div class="awea-about-icon-circle"><i class="fas fa-phone-volume"></i></div>
                        <div>
                            <span style="display:block; font-size: 0.8rem; opacity: 0.8; font-weight: 600;"><?php echo esc_html($settings['awea_about_contact_label']); ?></span>
                            <span style="font-size: 1.1rem; font-weight: 800;"><?php echo esc_html($settings['awea_about_contact_number']); ?></span>
                        </div>
                    </a>
                </div>
            </div>
        </main>
        <?php
    }
}