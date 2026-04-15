<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

class Widget_Awesome_Post_Grid extends Widget_Base {

    public function get_name() { 
        return 'awesome-post-grid'; 
    }
    public function get_title() { 
        return esc_html__( 'Post Grid', 'awesome-widgets-elementor' ); 
    }
    public function get_icon() { 
        return 'eicon-post'; 
    }
    public function get_categories() { 
        return [ 'awesome-widgets-elementor' ]; 
    }

    protected function register_controls() {

        // --- SECTION: QUERY SETTINGS ---
        $this->start_controls_section(
            'section_query', 
            [
                'label' => esc_html__( 'Query Settings', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'post_count', 
                [
                    'label' => esc_html__( 'Post Count', 'awesome-widgets-elementor' ),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 3,
            ]
        );

        $this->add_control(
            'columns', 
            [
                'label' => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => '1 Column',
                    '2' => '2 Columns',
                    '3' => '3 Columns',
                    '4' => '4 Columns',
                ],
            ]
        );

        $this->add_control(
            'category_select', 
            [
                'label' => esc_html__( 'Category Select', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => $this->get_post_categories(),
            ]
        );

        $this->add_control(
            'orderby', 
            [
                'label' => esc_html__( 'Order By', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => 'Date',
                    'title' => 'Title',
                    'rand' => 'Random',
                ],
            ]
        );

        $this->add_control(
            'order', 
            [
                'label' => esc_html__( 'Order', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'ASC' => 'ASC',
                    'DESC' => 'DESC',
                ],
            ]
        );

        $this->end_controls_section();

        // --- SECTION: CARD ELEMENTS ---
        $this->start_controls_section(
            'section_elements', 
            [
                'label' => esc_html__( 'Card Elements', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'show_category', 
            [
                'label' => esc_html__( 'Show Category?', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_excerpt', 
            [
                'label' => esc_html__( 'Show Excerpt?', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_button', 
            [
                'label' => esc_html__( 'Show Button?', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // --- STYLE: LAYOUT PANEL ---
        $this->start_controls_section(
            'style_layout', 
            [
                'label' => esc_html__( 'Layout Panel', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('layout_tabs');

        $this->start_controls_tab(
            'layout_normal', 
            [
                'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' )
            ]
        );
        $this->add_responsive_control(
            'card_padding', 
            [
                'label' => 'Padding',
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [ '{{WRAPPER}} .awea-blog-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'card_bg', 
            [
                'label' => 'Background Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-blog-card' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_responsive_control(
            'card_radius', 
            [
            'label' => 'Border Radius',
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [ '{{WRAPPER}} .awea-blog-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
        ]
        );
        $this->add_group_control(Group_Control_Border::get_type(), [
            'name' => 'card_border',
            'selector' => '{{WRAPPER}} .awea-blog-card',
        ]);
        $this->end_controls_tab();

        $this->start_controls_tab(
            'layout_hover', 
            [
                'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' )
            ]
        );
        $this->add_control(
            'card_hover_border_color', 
            [
                'label' => 'Border Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-blog-card:hover' => 'border-color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(Group_Control_Box_Shadow::get_type(), 
            [
                'name' => 'card_shadow_hover',
                'selector' => '{{WRAPPER}} .awea-blog-card:hover',
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // --- STYLE: CATEGORY PANEL ---
        $this->start_controls_section(
            'style_category', 
            [
                'label' => esc_html__( 'Category Panel', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show_category' => 'yes'],
            ]
        );

        $this->add_control(
            'cat_color', 
            [ 
                'label' => 'Color', 'type' => Controls_Manager::COLOR, 'selectors' => [ '{{WRAPPER}} .awea-blog-badge' => 'color: {{VALUE}};' ]
            ]
        );

        $this->add_control(
            'cat_bg', 
            [ 
                'label' => 'Background Color', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .awea-blog-badge' => 'background-color: {{VALUE}};' ] 
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), 
            [ 
                'name' => 'cat_typo', 
                'selector' => '{{WRAPPER}} .awea-blog-badge' 
            ]
        );

        $this->add_responsive_control(
            'cat_padding', 
            [ 
                'label' => 'Padding', 
                'type' => Controls_Manager::DIMENSIONS, 
                'selectors' => [ '{{WRAPPER}} .awea-blog-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] 
            ]
        );

        $this->add_control(
            'cat_radius_single', 
            [ 
                'label' => 'Border Radius', 
                'type' => Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .awea-blog-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] 
            ]
        );

        $this->end_controls_section();

        // --- STYLE: META PANEL ---
        $this->start_controls_section(
            'style_meta', 
            [
                'label' => esc_html__( 'Meta Panel', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'meta_color', 
            [ 
            'label' => 'Color', 
            'type' => Controls_Manager::COLOR, 
            'selectors' => [ '{{WRAPPER}} .awea-blog-meta' => 'color: {{VALUE}};' ] 
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), 
            [ 
            'name' => 'meta_typo', 
            'selector' => '{{WRAPPER}} .awea-blog-meta' 
            ]
        );
        $this->end_controls_section();

        // --- STYLE: TITLE PANEL ---
        $this->start_controls_section(
            'style_title', 
            [
                'label' => esc_html__( 'Title Panel', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('title_style_tabs');

        $this->start_controls_tab(
            't_norm', 
            [
                'label' => 'Normal'
            ]
        );

        $this->add_control(
            'title_color', 
            [ 
                'label' => 'Color', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .awea-blog-title' => 'color: {{VALUE}};' ] 
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), 
            [ 
            'name' => 'title_typo', 
            'selector' => '{{WRAPPER}} .awea-blog-title' 
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            't_hov', 
            [
                'label' => 'Hover'
            ]
        );

        $this->add_control(
            'title_color_hover', 
            [ 
                'label' => 'Color', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .awea-blog-card:hover .awea-blog-title' => 'color: {{VALUE}};' ] 
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // --- STYLE: EXCERPT PANEL ---
        $this->start_controls_section(
            'style_excerpt', 
            [
                'label' => esc_html__( 'Excerpt Panel', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show_excerpt' => 'yes'],
            ]
        );

        $this->add_control(
            'exc_color', 
            [ 
                'label' => 'Color', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .awea-blog-desc' => 'color: {{VALUE}};' ] 
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), 
            [ 
                'name' => 'exc_typo', 
                'selector' => '{{WRAPPER}} .awea-blog-desc' 
            ]
        );
        $this->end_controls_section();

        // --- STYLE: BUTTON PANEL ---
        $this->start_controls_section(
            'style_button', 
            [
                'label' => esc_html__( 'Button Panel', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['show_button' => 'yes'],
            ]
        );
        $this->start_controls_tabs('btn_tabs');

        $this->start_controls_tab(
            'btn_n', 
            [
                'label' => 'Normal'
            ]
        );

        $this->add_control(
            'btn_color', 
            [ 
                'label' => 'Color', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .awea-blog-link' => 'color: {{VALUE}};' ] 
            ]
        );

        $this->add_control(
            'btn_bg', 
            [ 
                'label' => 'Background', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .awea-blog-link' => 'background-color: {{VALUE}};' ] 
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), 
            [ 
                'name' => 'btn_typo', 
                'selector' => '{{WRAPPER}} .awea-blog-link' 
            ]
        );

        $this->add_responsive_control(
            'btn_padding', 
            [ 
                'label' => 'Padding', 
                'type' => Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .awea-blog-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] 
            ]
        );

        $this->add_control(
            'btn_radius_single', 
            [ 
                'label' => 'Radius', 
                'type' => Controls_Manager::DIMENSIONS, 'selectors' => [ '{{WRAPPER}} .awea-blog-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ] 
            ]
        );

        $this->add_group_control(Group_Control_Border::get_type(), 
            [ 
                'name' => 'btn_border', 
                'selector' => '{{WRAPPER}} .awea-blog-link' 
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'btn_h', 
            [
                'label' => 'Hover'
            ]
        );

        $this->add_control(
            'btn_color_h', 
            [ 
                'label' => 'Color', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .awea-blog-card:hover .awea-blog-link' => 'color: {{VALUE}};' ] 
            ]
        );

        $this->add_control(
            'btn_bg_h', 
            [ 
                'label' => 'Background', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .awea-blog-card:hover .awea-blog-link' => 'background-color: {{VALUE}};' ] 
            ]
        );

        $this->add_control(
            'btn_border_h', 
            [ 
                'label' => 'Border Color', 
                'type' => Controls_Manager::COLOR, 
                'selectors' => [ '{{WRAPPER}} .awea-blog-card:hover .awea-blog-link' => 'border-color: {{VALUE}};' ] 
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $args = [
            'post_type' => 'post',
            'posts_per_page' => $settings['post_count'],
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'post_status' => 'publish',
        ];

        if ( !empty($settings['category_select']) ) {
            $args['category__in'] = $settings['category_select'];
        }

        $query = new \WP_Query($args);
        $col_class = 'awea-col-' . $settings['columns'];

        if ( $query->have_posts() ) : ?>

            <div class="awea-grid-row">
                <?php 
                $counter = 1;
                while ( $query->have_posts() ) : $query->the_post(); 
                    $cats = get_the_category();
                ?>
                    <div class="awea-grid-item <?php echo esc_attr($col_class); ?>">
                        <article class="awea-blog-card">
                            <div class="awea-blog-img-wrap">
                                <?php if ( 'yes' === $settings['show_category'] && !empty($cats) ) : ?>
                                    <span class="awea-blog-badge"><?php echo esc_html($cats[0]->name); ?></span>
                                <?php endif; ?>
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail('large'); ?>
                                <?php endif; ?>
                            </div>

                            <div class="awea-blog-body">
                                <span class="awea-blog-meta">
                                    <?php echo esc_html( get_the_date( 'M d, Y' ) ); ?> • <?php echo esc_html( $this->get_read_time( get_the_content() ) ); ?> <?php echo esc_html__( 'MIN READ', 'awesome-widgets-elementor' ); ?>
                                </span>
                                <h2 class="awea-blog-title"><?php the_title(); ?></h2>
                                <?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
                                    <p class="awea-blog-desc"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?></p>
                                <?php endif; ?>
                            </div>

                            <?php if ( 'yes' === $settings['show_button'] ) : ?>
                                <div class="awea-blog-footer">
                                    <a href="<?php the_permalink(); ?>" class="awea-blog-link">
                                        Read Insight <i class="fas fa-arrow-right"></i>
                                    </a>
                                    <span class="awea-post-num"><?php echo esc_html( str_pad( $counter, 2, '0', STR_PAD_LEFT ) ); ?></span>
                                </div>
                            <?php endif; ?>
                        </article>
                    </div>
                <?php $counter++; endwhile; wp_reset_postdata(); ?>
            </div>
        <?php endif;
    }

    private function get_post_categories() {
        $categories = get_categories();
        $options = [];
        foreach ( $categories as $category ) {
            $options[ $category->term_id ] = $category->name;
        }
        return $options;
    }

    private function get_read_time($content) {
        $word_count = str_word_count( wp_strip_all_tags( $content ) );
        $readingtime = ceil($word_count / 200);
        return $readingtime > 0 ? $readingtime : 1;
    }
}