<?php
/**
 * Awesome Post List Widget.
 *
 * Elementor widget that inserts a post list into the page
 *
 * @since 1.0.0
 */
namespace Elementor;
class Widget_Awesome_Post_List extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'awesome-post-list';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve affiliate products widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Post List', 'awesome-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve affiliate products widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-call-to-action';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}	

	/**
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		
		// start of the Content tab section
	   $this->start_controls_section(
	       'awea_post_list_contents',
		    [
		        'label' => esc_html__('Contents', 'awesome-widgets'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		    ]
	    );
		
		// Number of Posts
		$this->add_control(
			'awea_post_list_per_page',
			[
				'label' => esc_html__('Number of Posts', 'awesome-widgets'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 10,
				'min' => 1,
				'max' => 50,
			]
		);

		// Order By
		$this->add_control(
			'awea_post_list_orderby',
			[
				'label' => esc_html__('Order By', 'awesome-widgets'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => esc_html__('Date', 'awesome-widgets'),
					'title' => esc_html__('Title', 'awesome-widgets'),
					'rand' => esc_html__('Random', 'awesome-widgets'),
				],
			]
		);

		// Order
		$this->add_control(
			'awea_post_list_order',
			[
				'label' => esc_html__('Order', 'awesome-widgets'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC' => esc_html__('Ascending', 'awesome-widgets'),
					'DESC' => esc_html__('Descending', 'awesome-widgets'),
				],
			]
		);
		
		$this->end_controls_section();
		
		// start of the Style tab section
		$this->start_controls_section(
			'awea_post_list_layout_style',
			[
				'label' => esc_html__( 'Layouts', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// CTA Background Color
		$this->add_control(
			'awea_post_list_background_color',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-single-post-list' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// CTA Border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'awea_post_list_border',
				'selector' => '{{WRAPPER}} .awea-single-post-list',
			]
		);	

		// CTA Border Radius
		$this->add_control(
			'awea_post_list_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-single-post-list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// CTA Padding
		$this->add_control(
			'awea_post_list_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-single-post-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_post_list_image_style',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_post_list_image_width',
			[
				'label' => esc_html__('Image Width', 'awesome-widgets'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['%', 'px', 'vw'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-single-post-list img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Image Box Border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'awea_post_list_border',
				'selector' => '{{WRAPPER}} .awea-single-post-list img',
			]
		);	
		
		// Image Box Border Radius
		$this->add_control(
			'awea_post_list_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-single-post-list img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'awea_post_list_title_style',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Team Title Color
		$this->add_control(
			'awea_post_list_title_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-single-post-list-content h4 a' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Team Title Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'awea_post_list_title_typography',
				'selector' => '{{WRAPPER}} .awea-single-post-list-content h4 a',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->end_controls_section();
		
		// start of the Style tab section
		$this->start_controls_section(
			'awea_post_list_meta_style',
			[
				'label' => esc_html__( 'Meta', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('awea_post_list_meta_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'awea_post_list_meta_tab_normal',
			[
				'label' => esc_html__('Normal', 'textdomain'),
			]
		);

		// Team Title Color
		$this->add_control(
			'awea_post_list_meta_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-single-post-list-meta a' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Team Title Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'awea_post_list_meta_typography',
				'selector' => '{{WRAPPER}} .awea-single-post-list-meta a',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'cta_button_tab_hover',
			[
				'label' => esc_html__('Hover', 'textdomain'),
			]
		);

		// Team Title Color
		$this->add_control(
			'awea_post_list_meta_hover_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-single-post-list-meta a:hover' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */ 
	protected function render() {
		$settings = $this->get_settings_for_display();
		$posts_per_page = $settings['awea_post_list_per_page'];
		$orderby = $settings['awea_post_list_orderby'];
		$order = $settings['awea_post_list_order'];
		$category_filter = !empty($settings['category_filter']) ? $settings['category_filter'] : '';
	
		$args = [
			'post_type' => 'post',
			'posts_per_page' => $posts_per_page,
			'orderby' => $orderby,
			'order' => $order,
		];
	
		if (!empty($category_filter)) {
			$args['category_name'] = implode(',', $category_filter);
		}
	
		$query = new \WP_Query($args);
		
		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				?>
				<div class="awea-single-post-list">
					<img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="">
					<div class="awea-single-post-list-content">
						<h4><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h4>
						<div class="awea-single-post-list-meta">
							<?php 
								// Author
								$author_id = get_the_author_meta('ID');
								$author_name = get_the_author();
								$author_url = get_author_posts_url($author_id);
								echo '<a href="' . esc_url($author_url) . '">' . esc_html($author_name) . '</a>';
	
								// Categories
								$categories = get_the_category();
								if (!empty($categories)) {
									foreach ($categories as $category) {
										echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a> ';
									}
								}
								
								// Date
								$date_link = get_day_link(get_the_date('Y'), get_the_date('m'), get_the_date('d'));
								echo '<a href="' . esc_url($date_link) . '">' . get_the_date('jS F Y') . '</a>';
							?>
						</div>
					</div>
				</div>
				<?php 
			}
			wp_reset_postdata();
		} else {
			echo 'No posts found';
		}
	}	
}
