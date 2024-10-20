<?php
/**
 * Awesome List Group
 *
 * Elementor widget that inserts a list into the page
 *
 * @since 1.0.0
 */
namespace Elementor;
class Widget_Awesome_List_Group extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve brand widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'awesome-list-group';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve brand widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'List Group', 'awesome-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-bullet-list';
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
	       'awea_list_group_contents',
		    [
		        'label' => esc_html__('Contents', 'awesome-widgets'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,		   
		    ]
	    );
		
		// List Group Repeater 
		$repeater = new \Elementor\Repeater();

		// List Group Title 
		$repeater->add_control(
			'awea_list_group_title',
			[
				'label' => esc_html__( 'List Title', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('List Item', 'awesome-widgets')
			]
		);

		// List Group Icon
		$repeater->add_control(
        	'awea_list_group_icon',
			[
				'label'         => esc_html__('List Icon', 'awesome-widgets'),
				'type'          => \Elementor\Controls_Manager::ICON,
				'label_block'   => true,
				'default' => 'fa fa-star',
			]
        );

		// List Group List
		$this->add_control(
			'awea_list_group',
			[
				'label' => esc_html__( 'List Group List', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'awea_list_group_title' => __( 'List Item 1', 'awesome-widgets' )
					],
					[
						'awea_list_group_title' => __( 'List Item 2', 'awesome-widgets' )
					],
					[
						'awea_list_group_title' => __( 'List Item 3', 'awesome-widgets' )
					],
				],
				'title_field' => '{{{ awea_list_group_title }}}',
			]
		);		
		
		$this->end_controls_section();
		// end of the Content tab section
		
		// start of the Style tab section
		$this->start_controls_section(
			'awea_list_group_style',
			[
				'label' => esc_html__( 'Contents', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);	

		// List Group Layout Options
		$this->add_control(
			'wb_brand_sep_options',
			[
				'label' => esc_html__( 'Layouts', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		// List Group Background Color
		$this->add_control(
			'awea_list_group_background_color',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .list-item' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// List Group Border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'awea_list_group_border',
				'selector' => '{{WRAPPER}} .list-item',
			]
		);	

		// List Group Border Radius
		$this->add_control(
			'awea_list_group_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// List Group Padding
		$this->add_control(
			'awea_list_group_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// List Group Icon Options
		$this->add_control(
			'awea_list_group_icon_options',
			[
				'label' => esc_html__( 'Icon', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);
		
		// List Group Icon Color
		$this->add_control(
			'awea_list_group_icon_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .list-item i' => 'color: {{VALUE}}',
				],
			]
		);

		// List Group Icon Border Color
		$this->add_control(
			'awea_list_group_icon_border_color',
			[
				'label' => esc_html__( 'Border Color', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .list-item i' => 'border-color: {{VALUE}}',
				],
			]
		);

		// List Group Title Options
		$this->add_control(
			'awea_list_group_title_options',
			[
				'label' => esc_html__( 'Heading', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		// List Group Title Color
		$this->add_control(
			'awea_list_group_title_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .list-item h4' => 'color: {{VALUE}}',
				],
			]
		);

		// List Group Title Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'awea_list_group_title_typography',
				'selector' => '{{WRAPPER}} .list-item h4',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);	

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
		// get our input from the widget settings.
		$settings = $this->get_settings_for_display();

		if ( $settings['awea_list_group'] ) {  ?>			
			<?php 
			foreach (  $settings['awea_list_group'] as $item ) { 
				$awea_group_list_title = $item['awea_list_group_title'];
				$awea_group_list_icon =  $item['awea_list_group_icon'];
			?>
				<div class="list-group">
					<div class="list-item">
						<i class="<?php echo esc_attr($awea_group_list_icon);?>"></i> <h4><?php echo esc_html($awea_group_list_title);?></h4>
					</div>
				</div>
			<?php } ?>
		<?php } 
	}
}