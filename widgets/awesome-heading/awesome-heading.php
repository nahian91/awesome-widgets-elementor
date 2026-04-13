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

        <style>
            .section-signature { 
                --primary: #6366f1; --dark: #0f172a; --gray: #64748b; --ease: cubic-bezier(0.19, 1, 0.22, 1);
                text-align: center; display: flex; flex-direction: column; align-items: center; width: 100%;
            }
            
            .tag-pill {
                background: rgba(99, 102, 241, 0.08); color: var(--primary); padding: 10px 26px;
                border-radius: 100px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;
                letter-spacing: 4px; margin-bottom: 32px; border: 1px solid rgba(99, 102, 241, 0.1);
                display: inline-block; animation: revealDown 1.2s var(--ease) both;
            }

            .hero-title {
                font-size: 4.5rem; font-weight: 800; letter-spacing: -4px; color: var(--dark);
                line-height: 0.95; margin-bottom: 40px; animation: revealUp 1.2s var(--ease) 0.15s both;
            }

            .signature-divider {
                position: relative; width: 140px; height: 2px; background: #e2e8f0;
                margin-bottom: 40px; border-radius: 4px; overflow: hidden;
            }

            .signature-divider::after {
                content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
                background: var(--primary); animation: dividerFlow 3s infinite var(--ease);
            }

            .hero-desc {
                font-size: 1.35rem; color: var(--gray); line-height: 1.6; max-width: 680px;
                margin-bottom: 55px; font-weight: 500; animation: revealUp 1.2s var(--ease) 0.45s both;
            }

            .magnetic-btn {
                text-decoration: none; background: var(--dark); color: #fff; padding: 22px 54px;
                border-radius: 100px; font-weight: 800; font-size: 1.1rem; display: inline-flex;
                align-items: center; gap: 15px; transition: all 0.5s var(--ease);
                box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.2); animation: revealUp 1.2s var(--ease) 0.6s both;
            }

            .magnetic-btn:hover { background: var(--primary); transform: translateY(-8px) scale(1.05); }

            @keyframes dividerFlow { 0% { left: -100%; } 50% { left: 0%; } 100% { left: 100%; } }
            @keyframes revealUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
            @keyframes revealDown { from { opacity: 0; transform: translateY(-40px); } to { opacity: 1; transform: translateY(0); } }

            @media (max-width: 768px) {
                .hero-title { font-size: 3.2rem; letter-spacing: -2px; }
                .magnetic-btn { width: 100%; justify-content: center; }
            }
        </style>

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