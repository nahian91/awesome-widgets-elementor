<?php
/**
 * Awesome Post Carousel Studio Widget.
 * Architectural Editorial Post Feed with Dynamic Slider & Reading Time Metrics.
 *
 * @package AwesomeWidgetsElementor
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Post_Carousel extends Widget_Base {

	public function get_name() {
		return 'awesome-post-carousel';
	}

	public function get_title() {
		return esc_html__( 'Post Carousel Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'post', 'carousel', 'slider', 'blog', 'articles', 'feed', 'query' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: QUERY & SOURCE
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_query',
			[
				'label' => esc_html__( 'Query & Source', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_posts_per_page',
			[
				'label'   => esc_html__( 'Number of Posts', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
				'min'     => 1,
				'max'     => 50,
			]
		);

		$this->add_control(
			'awea_post_order',
			[
				'label'   => esc_html__( 'Order', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending (DESC)', 'awesome-widgets-elementor' ),
					'ASC'  => esc_html__( 'Ascending (ASC)', 'awesome-widgets-elementor' ),
				],
			]
		);

		$this->add_control(
			'awea_post_orderby',
			[
				'label'   => esc_html__( 'Order By', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'          => esc_html__( 'Date', 'awesome-widgets-elementor' ),
					'title'         => esc_html__( 'Title', 'awesome-widgets-elementor' ),
					'modified'      => esc_html__( 'Last Modified', 'awesome-widgets-elementor' ),
					'comment_count' => esc_html__( 'Comment Count', 'awesome-widgets-elementor' ),
					'rand'          => esc_html__( 'Random', 'awesome-widgets-elementor' ),
					'ID'            => esc_html__( 'Post ID', 'awesome-widgets-elementor' ),
				],
			]
		);

		// Fetch Categories with safe dropdown options
		$cat_options = [];
		$categories  = get_categories( [ 'hide_empty' => false ] );
		if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
			foreach ( $categories as $cat ) {
				$cat_options[ $cat->term_id ] = $cat->name;
			}
		}

		$this->add_control(
			'awea_include_categories',
			[
				'label'    => esc_html__( 'Filter Categories', 'awesome-widgets-elementor' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'options'  => $cat_options,
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: META & ELEMENTS VISIBILITY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_meta_visibility',
			[
				'label' => esc_html__( 'Card Elements', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_show_category',
			[
				'label'        => esc_html__( 'Category Badge', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_show_date',
			[
				'label'        => esc_html__( 'Publish Date', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_show_reading_time',
			[
				'label'        => esc_html__( 'Reading Time Estimate', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_show_excerpt',
			[
				'label'        => esc_html__( 'Excerpt', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_excerpt_length',
			[
				'label'     => esc_html__( 'Excerpt Length (Words)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 14,
				'condition' => [ 'awea_show_excerpt' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_button',
			[
				'label'        => esc_html__( 'Action Link', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_button_text',
			[
				'label'     => esc_html__( 'Button Label', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read Article', 'awesome-widgets-elementor' ),
				'condition' => [ 'awea_show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_title_tag',
			[
				'label'     => esc_html__( 'Title HTML Tag', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h3',
				'options'   => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: CAROUSEL SETTINGS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_slides_per_view',
			[
				'label'              => esc_html__( 'Items Per View', 'awesome-widgets-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => '3',
				'options'            => [
					'1' => '1 Item',
					'2' => '2 Items',
					'3' => '3 Items',
					'4' => '4 Items',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'awea_carousel_arrows',
			[
				'label'        => esc_html__( 'Navigation Arrows', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_carousel_dots',
			[
				'label'        => esc_html__( 'Pagination Dots', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_carousel_loop',
			[
				'label'        => esc_html__( 'Infinite Loop', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_carousel_autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed (ms)', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [ 'awea_carousel_autoplay' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: CARD SHELL
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_card',
			[
				'label' => esc_html__( 'Card Shell', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_card_padding',
			[
				'label'      => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_card_bg',
			[
				'label'     => esc_html__( 'Background Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-blog-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-blog-card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-blog-card',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: IMAGE FRAME
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_image',
			[
				'label' => esc_html__( 'Featured Image', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_image_aspect_ratio',
			[
				'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '16/10',
				'options'   => [
					'16/9' => '16:9 Widescreen',
					'4/3'  => '4:3 Standard',
					'1/1'  => '1:1 Square',
					'auto' => 'Original',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-img-wrap' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_image_radius',
			[
				'label'      => esc_html__( 'Image Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => '18', 'right' => '18', 'bottom' => '18', 'left' => '18', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-blog-img-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: TYPOGRAPHY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_typo',
			[
				'label' => esc_html__( 'Typography & Meta', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Title
		$this->add_control(
			'awea_heading_title',
			[
				'label' => esc_html__( 'Post Title', 'awesome-widgets-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typography',
				'selector' => '{{WRAPPER}} .awea-blog-title a',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		// Excerpt
		$this->add_control(
			'awea_heading_excerpt',
			[
				'label'     => esc_html__( 'Excerpt', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_excerpt_color',
			[
				'label'     => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-blog-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_excerpt_typography',
				'selector' => '{{WRAPPER}} .awea-blog-desc',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$num_posts    = ! empty( $settings['awea_posts_per_page'] ) ? absint( $settings['awea_posts_per_page'] ) : 6;
		$order        = $settings['awea_post_order'] ?? 'DESC';
		$orderby      = $settings['awea_post_orderby'] ?? 'date';
		$categories   = $settings['awea_include_categories'] ?? [];
		$show_cat     = 'yes' === ( $settings['awea_show_category'] ?? 'no' );
		$show_date    = 'yes' === ( $settings['awea_show_date'] ?? 'no' );
		$show_read    = 'yes' === ( $settings['awea_show_reading_time'] ?? 'no' );
		$show_exc     = 'yes' === ( $settings['awea_show_excerpt'] ?? 'no' );
		$exc_len      = ! empty( $settings['awea_excerpt_length'] ) ? absint( $settings['awea_excerpt_length'] ) : 14;
		$show_btn     = 'yes' === ( $settings['awea_show_button'] ?? 'no' );
		$btn_text     = $settings['awea_button_text'] ?? esc_html__( 'Read Article', 'awesome-widgets-elementor' );
		$title_tag    = Utils::validate_html_tag( $settings['awea_title_tag'] ?? 'h3' );
		$slides_view  = $settings['awea_slides_per_view'] ?? '3';
		$arrows       = 'yes' === ( $settings['awea_carousel_arrows'] ?? 'no' );
		$dots         = 'yes' === ( $settings['awea_carousel_dots'] ?? 'no' );
		$loop         = 'yes' === ( $settings['awea_carousel_loop'] ?? 'no' );
		$autoplay     = 'yes' === ( $settings['awea_carousel_autoplay'] ?? 'no' );
		$auto_speed   = ! empty( $settings['awea_carousel_autoplay_speed'] ) ? absint( $settings['awea_carousel_autoplay_speed'] ) : 5000;
		$widget_id    = $this->get_id();

		$args = [
			'posts_per_page'      => $num_posts,
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'order'               => $order,
			'orderby'             => $orderby,
			'ignore_sticky_posts' => 1,
		];

		if ( ! empty( $categories ) && is_array( $categories ) ) {
			$args['category__in'] = array_map( 'absint', $categories );
		}

		$query = new \WP_Query( $args );
		?>
		<div class="awea-post-carousel owl-carousel"
		     id="awea-carousel-<?php echo esc_attr( $widget_id ); ?>"
		     data-items="<?php echo esc_attr( $slides_view ); ?>"
		     data-arrows="<?php echo esc_attr( $arrows ? 'true' : 'false' ); ?>"
		     data-dots="<?php echo esc_attr( $dots ? 'true' : 'false' ); ?>"
		     data-loop="<?php echo esc_attr( $loop ? 'true' : 'false' ); ?>"
		     data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>"
		     data-speed="<?php echo esc_attr( (string) $auto_speed ); ?>">

			<?php if ( $query->have_posts() ) : 
				$counter = 1;
				while ( $query->have_posts() ) : $query->the_post();
					$content      = get_post_field( 'post_content', get_the_ID() );
					$word_count   = str_word_count( wp_strip_all_tags( $content ) );
					$reading_time = max( 1, ceil( $word_count / 200 ) );
					$post_cats    = get_the_category();
			?>
				<article class="awea-blog-card">
					
					<!-- Featured Image Frame -->
					<div class="awea-blog-img-wrap">
						<?php if ( $show_cat && ! empty( $post_cats ) ) : ?>
							<span class="awea-blog-badge"><?php echo esc_html( $post_cats[0]->name ); ?></span>
						<?php endif; ?>

						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'large', [ 'class' => 'awea-blog-img', 'loading' => 'lazy' ] ); ?>
						<?php else : ?>
							<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" class="awea-blog-img" alt="<?php the_title_attribute(); ?>" loading="lazy" />
						<?php endif; ?>
					</div>

					<!-- Body Content -->
					<div class="awea-blog-body">
						<div class="awea-blog-meta">
							<?php if ( $show_date ) : ?>
								<span><?php echo esc_html( get_the_date( 'M d, Y' ) ); ?></span>
							<?php endif; ?>

							<?php if ( $show_date && $show_read ) : ?>
								<span class="awea-meta-dot">•</span>
							<?php endif; ?>

							<?php if ( $show_read ) : ?>
								<span><?php echo esc_html( sprintf( __( '%d MIN READ', 'awesome-widgets-elementor' ), $reading_time ) ); ?></span>
							<?php endif; ?>
						</div>

						<<?php echo esc_attr( $title_tag ); ?> class="awea-blog-title">
							<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
						</<?php echo esc_attr( $title_tag ); ?>>

						<?php if ( $show_exc ) : ?>
							<p class="awea-blog-desc">
								<?php echo esc_html( wp_trim_words( get_the_excerpt(), $exc_len, '...' ) ); ?>
							</p>
						<?php endif; ?>
					</div>

					<!-- Card Footer Lockup -->
					<div class="awea-blog-footer">
						<?php if ( $show_btn && ! empty( $btn_text ) ) : ?>
							<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="awea-blog-link">
								<span><?php echo esc_html( $btn_text ); ?></span>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
							</a>
						<?php endif; ?>

						<span class="awea-blog-num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $counter ) ); ?></span>
					</div>

				</article>
			<?php 
					$counter++;
				endwhile;
				wp_reset_postdata();
			else :
			?>
				<p class="awea-no-posts"><?php esc_html_e( 'No posts found matching your criteria.', 'awesome-widgets-elementor' ); ?></p>
			<?php endif; ?>

		</div>
		<?php
	}
}