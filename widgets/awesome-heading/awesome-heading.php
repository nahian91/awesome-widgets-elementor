<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Awesome_Heading extends Widget_Base {

    public function get_name() { return 'awesome-heading'; }
    public function get_title() { return esc_html__( 'Heading', 'awesome-widgets-elementor' ); }
    public function get_icon() { return 'eicon-heading'; }
    public function get_categories() { return [ 'awesome-widgets-elementor' ]; }

    protected function register_controls() {
        
        // --- SECTION: CONTENT ---
        $this->start_controls_section('section_content', [
            'label' => esc_html__('Contents', 'awesome-widgets-elementor'),
        ]);

        $this->add_control('tag_text', [
            'label' => __('Tag Pill Text', 'awesome-widgets-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Insights • 2026', 'awesome-widgets-elementor'),
        ]);

        $this->add_control('hero_title', [
            'label' => __('Main Title', 'awesome-widgets-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('Beyond the<br>Standard Grid.', 'awesome-widgets-elementor'),
        ]);

        $this->add_control('hero_desc', [
            'label' => __('Description', 'awesome-widgets-elementor'),
            'type' => Controls_Manager::WYSIWYG,
            'default' => __('Reimaging the digital experience through the lens of architectural design and fluid motion engineering.', 'awesome-widgets-elementor'),
        ]);

        $this->add_control('btn_text', [
            'label' => __('Button Text', 'awesome-widgets-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Explore Collection', 'awesome-widgets-elementor'),
        ]);

        $this->add_control('btn_link', [
            'label' => __('Button Link', 'awesome-widgets-elementor'),
            'type' => Controls_Manager::URL,
            'placeholder' => __('https://your-link.com', 'awesome-widgets-elementor'),
        ]);

        $this->end_controls_section();

        // --- SECTION: STYLE ---
        $this->start_controls_section('section_style', [
            'label' => __( 'Appearance', 'awesome-widgets-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('primary_color', [
            'label' => __( 'Accent Color', 'awesome-widgets-elementor' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#6366f1',
            'selectors' => [ '{{WRAPPER}}' => '--primary: {{VALUE}};' ],
        ]);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __( 'Title Typography', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .hero-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>

        <section class="section-signature">
            <?php if ( ! empty( $settings['tag_text'] ) ) : ?>
                <div class="tag-pill"><?php echo esc_html( $settings['tag_text'] ); ?></div>
            <?php endif; ?>
            
            <h1 class="hero-title"><?php echo wp_kses_post( $settings['hero_title'] ); ?></h1>

            <div class="signature-divider"></div>

            <div class="hero-desc">
                <?php echo wp_kses_post( $settings['hero_desc'] ); ?>
            </div>

            <?php if ( ! empty( $settings['btn_link']['url'] ) ) : 
                $this->add_link_attributes( 'button', $settings['btn_link'] );
            ?>
                <a class="magnetic-btn" <?php echo wp_kses_post( $this->get_render_attribute_string( 'button' ) ); ?>>
                    <?php echo esc_html( $settings['btn_text'] ); ?> 
                    <i class="fas fa-arrow-up-right-from-square"></i>
                </a>
            <?php endif; ?>
        </section>

        <?php
    }
}