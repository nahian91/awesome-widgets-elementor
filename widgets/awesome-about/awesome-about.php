<?php
/**
 * Awesome About Widget.
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Awesome_About extends Widget_Base {

    public function get_name() { return 'awesome-about'; }
    public function get_title() { return esc_html__( 'About', 'awesome-widgets-elementor' ); }
    public function get_icon() { return 'eicon-person'; }
    public function get_categories() { return [ 'awesome-widgets-elementor' ]; }

    protected function register_controls() {

        // --- CONTENT SECTION: IMAGES ---
        $this->start_controls_section('section_images', [
            'label' => esc_html__( 'Images & Badge', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('main_image', [
            'label'   => esc_html__( 'Main Image', 'awesome-widgets-elementor' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [ 'url' => Utils::get_placeholder_image_src() ],
        ]);

        $this->add_control('floating_image', [
            'label'   => esc_html__( 'Floating Circle Image', 'awesome-widgets-elementor' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [ 'url' => Utils::get_placeholder_image_src() ],
        ]);

        $this->add_control('experience_badge', [
            'label'       => esc_html__( 'Badge Text', 'awesome-widgets-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '25+ Years Experience',
            'placeholder' => 'e.g. 25+ Years Experience',
        ]);

        $this->end_controls_section();

        // --- CONTENT SECTION: TEXT ---
        $this->start_controls_section('section_content', [
            'label' => esc_html__( 'Content Details', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('sub_heading', [
            'label'   => esc_html__( 'Sub Heading', 'awesome-widgets-elementor' ),
            'type'    => Controls_Manager::TEXT,
            'default' => 'About Our Company',
        ]);

        $this->add_control('main_heading', [
            'label'   => esc_html__( 'Main Heading', 'awesome-widgets-elementor' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => 'The World Trusts Our Logistics.',
        ]);

        $this->add_control('description', [
            'label'   => esc_html__( 'Description', 'awesome-widgets-elementor' ),
            'type'    => Controls_Manager::WYSIWYG,
            'default' => 'We deliver more than just cargo...',
        ]);

        $repeater = new Repeater();
        $repeater->add_control('feature_icon', [
            'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
            'type'  => Controls_Manager::ICONS,
            'default' => [ 'value' => 'fas fa-circle-check', 'library' => 'fa-solid' ],
        ]);
        $repeater->add_control('feature_text', [
            'label' => esc_html__( 'Text', 'awesome-widgets-elementor' ),
            'type'  => Controls_Manager::TEXT,
            'default' => 'Global Air Freight',
        ]);

        $this->add_control('features_list', [
            'label'       => esc_html__( 'Features', 'awesome-widgets-elementor' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['feature_text' => 'Global Air Freight'],
                ['feature_text' => 'Real-time Tracking'],
            ],
            'title_field' => '{{{ feature_text }}}',
        ]);

        $this->end_controls_section();

        // --- CONTENT SECTION: BUTTONS ---
        $this->start_controls_section('section_buttons', [
            'label' => esc_html__( 'Buttons & Contact', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('btn_1_text', [ 'label' => 'Button 1 Text', 'type' => Controls_Manager::TEXT, 'default' => 'Explore Solutions' ]);
        $this->add_control('btn_1_url', [ 'label' => 'Button 1 URL', 'type' => Controls_Manager::URL ]);
        $this->add_control('btn_1_icon', [ 'label' => 'Button 1 Icon', 'type' => Controls_Manager::ICONS ]);

        $this->add_control('hr', [ 'type' => Controls_Manager::DIVIDER ]);

        $this->add_control('contact_label', [ 'label' => 'Contact Label', 'type' => Controls_Manager::TEXT, 'default' => 'Direct Line:' ]);
        $this->add_control('contact_number', [ 'label' => 'Phone Number', 'type' => Controls_Manager::TEXT, 'default' => '148 359 505 285' ]);
        $this->add_control('contact_url', [ 'label' => 'Phone Link', 'type' => Controls_Manager::URL ]);

        $this->end_controls_section();

        // --- STYLE TAB: IMAGE & BADGE ---
        $this->start_controls_section('style_images', [
            'label' => esc_html__( 'Image Style', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control('main_img_radius', [
            'label' => 'Main Image Radius',
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [ '{{WRAPPER}} .awea-about-image-frame' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]);

        $this->add_control('badge_heading', [ 'label' => 'Badge Style', 'type' => Controls_Manager::HEADING, 'separator' => 'before' ]);
        $this->add_control('badge_bg', [ 'label' => 'Background', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .awea-about-ribbon' => 'background: {{VALUE}}' ]]);
        $this->add_control('badge_color', [ 'label' => 'Text Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .awea-about-ribbon' => 'color: {{VALUE}}' ]]);
        $this->add_group_control(Group_Control_Typography::get_type(), [ 'name' => 'badge_typo', 'selector' => '{{WRAPPER}} .awea-about-ribbon' ]);

        $this->end_controls_section();

        // --- STYLE TAB: TYPOGRAPHY ---
        $this->start_controls_section('style_content', [
            'label' => esc_html__( 'Content Style', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('subheading_color', [ 'label' => 'Sub-Heading Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .awea-about-label-group' => 'color: {{VALUE}}', '{{WRAPPER}} .awea-about-label-line' => 'background: {{VALUE}}' ]]);
        $this->add_group_control(Group_Control_Typography::get_type(), [ 'name' => 'subheading_typo', 'selector' => '{{WRAPPER}} .awea-about-label-group' ]);

        $this->add_control('heading_color', [ 'label' => 'Heading Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .awea-about-heading' => 'color: {{VALUE}}' ]]);
        $this->add_group_control(Group_Control_Typography::get_type(), [ 'name' => 'heading_typo', 'selector' => '{{WRAPPER}} .awea-about-heading' ]);

        $this->add_control('desc_color', [ 'label' => 'Description Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .awea-about-main-desc' => 'color: {{VALUE}}' ]]);
        $this->add_group_control(Group_Control_Typography::get_type(), [ 'name' => 'desc_typo', 'selector' => '{{WRAPPER}} .awea-about-main-desc' ]);

        $this->end_controls_section();

        // --- STYLE TAB: FEATURES ---
        $this->start_controls_section('style_features', [
            'label' => esc_html__( 'Features Style', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('feature_icon_color', [ 'label' => 'Icon Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .awea-about-check-item i' => 'color: {{VALUE}}' ]]);
        $this->add_control('feature_text_color', [ 'label' => 'Text Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .awea-about-check-item' => 'color: {{VALUE}}' ]]);
        $this->add_group_control(Group_Control_Typography::get_type(), [ 'name' => 'feature_typo', 'selector' => '{{WRAPPER}} .awea-about-check-item' ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <main class="awea-about-master-grid">
            <div class="awea-about-visual-container">
                <div class="awea-about-image-frame">
                    <img src="<?php echo esc_url($settings['main_image']['url']); ?>" alt="About">
                </div>
                <div class="awea-about-floating-circle">
                    <img src="<?php echo esc_url($settings['floating_image']['url']); ?>" alt="About Detail">
                </div>
                <?php if ( ! empty( $settings['experience_badge'] ) ) : ?>
                    <div class="awea-about-ribbon"><?php echo esc_html($settings['experience_badge']); ?></div>
                <?php endif; ?>
            </div>

            <div class="awea-about-text-content">
                <div class="awea-about-label-group">
                    <div class="awea-about-label-line"></div>
                    <?php echo esc_html($settings['sub_heading']); ?>
                </div>

                <h2 class="awea-about-heading"><?php echo esc_html($settings['main_heading']); ?></h2>

                <div class="awea-about-main-desc">
                    <?php echo $settings['description']; ?>
                </div>

                <div class="awea-about-feature-box">
                    <?php foreach ( $settings['features_list'] as $item ) : ?>
                        <div class="awea-about-check-item">
                            <?php Icons_Manager::render_icon( $item['feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <?php echo esc_html($item['feature_text']); ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="awea-about-cta-wrapper">
                    <?php if ( ! empty( $settings['btn_1_url']['url'] ) ) : ?>
                        <a href="<?php echo esc_url($settings['btn_1_url']['url']); ?>" class="awea-about-prime-btn">
                            <?php echo esc_html($settings['btn_1_text']); ?>
                            <?php Icons_Manager::render_icon( $settings['btn_1_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url($settings['contact_url']['url']); ?>" class="awea-about-phone-call">
                        <div class="awea-about-icon-circle"><i class="fas fa-phone-volume"></i></div>
                        <div>
                            <span style="display:block; font-size: 0.8rem; opacity: 0.8; font-weight: 600;"><?php echo esc_html($settings['contact_label']); ?></span>
                            <span style="font-size: 1.1rem; font-weight: 800;"><?php echo esc_html($settings['contact_number']); ?></span>
                        </div>
                    </a>
                </div>
            </div>
        </main>
        <?php
    }
}