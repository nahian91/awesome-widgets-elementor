<?php
/**
 * Awesome Testimonials Widget.
 * Architectural Design with Kinetic Physics & Dynamic Rating.
 * * @since 1.0.0
 */
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Testimonials extends Widget_Base {

    public function get_name() {
        return 'awesome-testimonials';
    }

    public function get_title() {
        return esc_html__( 'Testimonials', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'testimonial', 'review', 'awesome', 'modern', 'kinetic', 'rating'];
    }

    protected function register_controls() {
        
        $this->start_controls_section(
           'awea_testi_content_section',
            [
                'label' => esc_html__('Contents', 'awesome-widgets-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_rating_val',
            [
                'label' => esc_html__( 'Star Rating', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '0' => esc_html__( '0 Stars', 'awesome-widgets-elementor' ),
                    '1' => esc_html__( '1 Star', 'awesome-widgets-elementor' ),
                    '2' => esc_html__( '2 Stars', 'awesome-widgets-elementor' ),
                    '3' => esc_html__( '3 Stars', 'awesome-widgets-elementor' ),
                    '4' => esc_html__( '4 Stars', 'awesome-widgets-elementor' ),
                    '5' => esc_html__( '5 Stars', 'awesome-widgets-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'awea_testi_speech',
            [
                'label' => esc_html__( 'Testimonial Text', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => esc_html__( 'The architectural depth and kinetic physics of this UI is purely world-class. It transformed our entire workflow overnight.', 'awesome-widgets-elementor' ),
                'placeholder' => esc_html__( 'Enter review here...', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_testi_image',
            [
                'label' => __('Author Avatar', 'awesome-widgets-elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://i.pravatar.cc/150?u=12',
                ],
            ]
        );

        $this->add_control(
            'awea_testi_name',
            [
                'label' => esc_html__( 'Author Name', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Julian Vance', 'awesome-widgets-elementor' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'awea_testi_desg',
            [
                'label' => esc_html__( 'Designation', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Lead Design at Linear', 'awesome-widgets-elementor' ),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'awea_testi_layout_style',
            [
                'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_testi_layout_bg_color',
            [
                'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-card' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'awea_testi_layout_shadow',
                'label' => esc_html__( 'Shadow', 'awesome-widgets-elementor' ),
                'selector' => '{{WRAPPER}} .awea-testimonial-card',
            ]
        );

        $this->add_control(
            'awea_testi_layout_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem'],
                'default' => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_testi_layout_padding',
            [
                'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [ 'top' => '40', 'right' => '40', 'bottom' => '40', 'left' => '40', 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'awea_testi_layout_beam_color',
            [
                'label' => esc_html__( 'Beam Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#6366f1',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-card' => '--awea-accent: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'awea_testi_star_style',
            [
                'label' => esc_html__( 'Star Rating', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_testi_star_primary_color',
            [
                'label' => esc_html__( 'Active Star Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f59e0b',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-stars i.fas' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'awea_testi_star_empty_color',
            [
                'label' => esc_html__( 'Empty Star Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#e2e8f0',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-stars i.far' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'awea_testi_star_size',
            [
                'label' => esc_html__( 'Star Size', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'rem' ],
                'range' => [ 'px' => [ 'min' => 8, 'max' => 30 ] ],
                'default' => [ 'unit' => 'px', 'size' => 12 ],
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-stars i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- STYLE: TEXT & TYPOGRAPHY ---
        $this->start_controls_section(
            'awea_testi_typo_section',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // --- Review Text (Speech) ---
        $this->add_control(
            'awea_testi_head_speech',
            [
                'label'     => esc_html__( 'Review Text', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_testi_speech_typo',
                'selector' => '{{WRAPPER}} .awea-testimonial-text',
            ]
        );

        $this->add_control(
            'awea_testi_speech_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#334155',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        // --- Author Name ---
        $this->add_control(
            'awea_testi_head_name',
            [
                'label'     => esc_html__( 'Author Name', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_testi_name_typo',
                'selector' => '{{WRAPPER}} .awea-testimonial-meta h4',
            ]
        );

        $this->add_control(
            'awea_testi_name_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#0f172a',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-meta h4' => 'color: {{VALUE}}',
                ],
            ]
        );

        // --- Designation ---
        $this->add_control(
            'awea_testi_head_desg',
            [
                'label'     => esc_html__( 'Designation', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'awea_testi_desg_typo',
                'selector' => '{{WRAPPER}} .awea-testimonial-meta cite',
            ]
        );

        $this->add_control(
            'awea_testi_desg_color',
            [
                'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#64748b',
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-meta cite' => 'color: {{VALUE}}',
                ],
            ]
        );

        // --- Designation ---
        $this->add_control(
            'awea_testi_head_img',
            [
                'label'     => esc_html__( 'Image', 'awesome-widgets-elementor' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'awea_testi_head_img_border',
				'selector' => '{{WRAPPER}} .awea-testimonial-avatar',
			]
		);

        $this->add_control(
            'awea_testi_head_img_radius',
            [
                'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem'],
                'default' => [ 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .awea-testimonial-avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $rating   = (int) $settings['awea_rating_val'];
        ?>

        <div class="awea-testimonial-card">
            <svg class="awea-testimonial-quote-brand" viewBox="0 0 24 24" fill="currentColor">
                <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C15.4647 8 15.017 8.44772 15.017 9V12C15.017 12.5523 14.5693 13 14.017 13H13.017C12.4647 13 12.017 12.5523 12.017 12V9C12.017 6.79086 13.8079 5 16.017 5H19.017C21.2261 5 23.017 6.79086 23.017 9V15C23.017 18.866 19.883 22 16.017 22H14.017V21ZM2.01693 21L2.01693 18C2.01693 16.8954 2.91236 16 4.01693 16H7.01693C7.56921 16 8.01693 15.5523 8.01693 15V9C8.01693 8.44772 7.56921 8 7.01693 8H4.01693C3.46464 8 3.01693 8.44772 3.01693 9V12C3.01693 12.5523 2.56921 13 2.01693 13H1.01693C0.464645 13 -0.0169312 12.5523 -0.0169312 12V9C-0.0169312 6.79086 1.77393 5 4.01693 5H7.01693C9.22607 5 11.0169 6.79086 11.0169 9V15C11.0169 18.866 7.88297 22 4.01693 22H2.01693V21Z" />
            </svg>

            <div class="awea-testimonial-stars">
                <?php 
                // Render Dynamic Stars Logic
                for ( $i = 1; $i <= 5; $i++ ) {
                    $star_type = ( $i <= $rating ) ? 'fas' : 'far'; // fas = solid, far = regular/outline
                    echo '<i class="' . esc_attr( $star_type ) . ' fa-star"></i>';
                }
                ?>
            </div>

            <blockquote class="awea-testimonial-text">
                "<?php echo esc_html( $settings['awea_testi_speech'] ); ?>"
            </blockquote>

            <div class="awea-testimonial-footer">
                <?php if ( ! empty( $settings['awea_testi_image']['url'] ) ) : ?>
                    <img src="<?php echo esc_url( $settings['awea_testi_image']['url'] ); ?>" alt="Reviewer" class="awea-testimonial-avatar">
                <?php endif; ?>
                
                <div class="awea-testimonial-meta">
                    <h4><?php echo esc_html( $settings['awea_testi_name'] ); ?></h4>
                    <cite><?php echo esc_html( $settings['awea_testi_desg'] ); ?></cite>
                </div>

                <div class="awea-testimonial-verify" title="Verified Customer">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>

        <?php
    }
}