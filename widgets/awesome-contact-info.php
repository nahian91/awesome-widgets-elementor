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

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_contact_info_contents_style',
			[
				'label' => esc_html__( 'Contents', 'awesome-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
		// $awea_cta_sub_title = $settings['awea_cta_sub_title'];
		// $awea_cta_title = $settings['awea_cta_title'];
		// $awea_cta_desc = $settings['awea_cta_desc'];
		// $awea_cta_button1 = $settings['awea_cta_button1'];
		// $awea_cta_button2 = $settings['awea_cta_button2'];
       ?>
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
