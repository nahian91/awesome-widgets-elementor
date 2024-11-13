<?php
/**
 * Awesome Contact Info Widget.
 *
 * Elementor widget that inserts a contact info into the page
 *
 * @since 1.0.0
 */
namespace Elementor;
class Widget_Awesome_Contact_Info extends Widget_Base {

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
		return 'awesome-contact-info';
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
		return esc_html__( 'Contact Info', 'awesome-widgets' );
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
	       'awea_contact_info_contents',
		    [
		        'label' => esc_html__('Contents', 'awesome-widgets'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,		   
		    ]
	    );

		$repeater = new \Elementor\Repeater();

		// Icon Field
		$repeater->add_control(
			'awea_contact_info_icon',
			[
				'label' => esc_html__('Icon', 'textdomain'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-envelope',
					'library' => 'fa-solid',
				],
				'show_label' => false,
			]
		);

		// Title Field
		$repeater->add_control(
			'awea_contact_info_title',
			[
				'label' => esc_html__('Title', 'textdomain'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Title', 'textdomain'),
				'show_label' => true,
				'label_block' => true
			]
		);

		// Description Field
		$repeater->add_control(
			'awea_contact_info_description',
			[
				'label' => esc_html__('Description', 'textdomain'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__('Description text', 'textdomain'),
				'show_label' => true,
				'label_block' => true
			]
		);

		// Add Repeater Control
		$this->add_control(
			'awea_contact_info_list',
			[
				'label' => esc_html__('Contact Info List', 'textdomain'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'awea_contact_info_icon' => [
							'value' => 'fas fa-map',
							'library' => 'fa-solid',
						],
						'awea_contact_info_title' => esc_html__('Address', 'textdomain'),
						'awea_contact_info_description' => esc_html__('456 Elm St, Michigan, USA', 'textdomain'),
					],
					[
						'awea_contact_info_icon' => [
							'value' => 'fas fa-email',
							'library' => 'fa-solid',
						],
						'awea_contact_info_title' => esc_html__('Email', 'textdomain'),
						'awea_contact_info_description' => esc_html__('support@devnahian.com', 'textdomain'),
					],
					[
						'awea_contact_info_icon' => [
							'value' => 'fas fa-phone',
							'library' => 'fa-solid',
						],
						'awea_contact_info_title' => esc_html__('Phone', 'textdomain'),
						'awea_contact_info_description' => esc_html__('(987) 654-3210', 'textdomain'),
					],
				],
				'title_field' => '{{{ awea_contact_info_title }}}',
			]
		);

		$this->end_controls_section();
		
		// start of the Style tab section
		$this->start_controls_section(
			'awea_contact_info_layout_style',
			[
				'label' => esc_html__( 'Layouts', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Contact Info Border
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'awea_contact_info_border',
				'selector' => '{{WRAPPER}} .single-awesome-widget-contact-info',
			]
		);	

		// Contact Info Padding
		$this->add_control(
			'awea_contact_info_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .single-awesome-widget-contact-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_contact_info_icon_style',
			[
				'label' => esc_html__( 'Icon', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Contact Info Color
		$this->add_control(
			'awea_contact_info_icon_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-awesome-widget-contact-info .icon i' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Contact Info Background Color
		$this->add_control(
			'awea_contact_info_icon_background',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-awesome-widget-contact-info .icon i' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Contact Info Border Radius
		$this->add_control(
			'awea_contact_info_icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .single-awesome-widget-contact-info .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'awea_contact_info_title_style',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Contact Info Title Color
		$this->add_control(
			'awea_contact_info_title_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-awesome-widget-contact-info h4' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Contact Info Title Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'awea_contact_info_title_typography',
				'selector' => '{{WRAPPER}} .single-awesome-widget-contact-info h4',
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'awea_contact_info_desc_style',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// Contact Info Title Color
		$this->add_control(
			'awea_contact_info_desc_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single-awesome-widget-contact-info h4' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Contact Info Title Typography
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'awea_contact_info_desc_typography',
				'selector' => '{{WRAPPER}} .single-awesome-widget-contact-info h4',
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
		$awea_contact_info_list = $settings['awea_contact_info_list'];
       ?>

	   

	   <?php foreach($awea_contact_info_list as $list) {
?>
<pre>
		<?php print_r($awea_contact_info_list);?>
	   </pre>
<?php 
	   } ?>
	   	<div class="single-awesome-widget-contact-info">
			<div class="icon">
				<i class="fa fa-phone"></i>
			</div>
			<h4>Call Us <span>info@uibundle.com</span></h4>
		</div>
	   	<div class="single-awesome-widget-contact-info">
			<div class="icon">
				<i class="fa fa-phone"></i>
			</div>
			<h4>Call Us <span>info@uibundle.com</span></h4>
		</div>
	   	<div class="single-awesome-widget-contact-info">
			<div class="icon">
				<i class="fa fa-phone"></i>
			</div>
			<h4>Call Us <span>info@uibundle.com</span></h4>
		</div>
       <?php
	}
}
