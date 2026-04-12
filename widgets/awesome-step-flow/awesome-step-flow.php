<?php
/**
 * Awesome Timeline Widget.
 *
 * Elementor widget that inserts a cta into the page
 *
 * @since 1.0.0
 */
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Widget_Base;

class Widget_Awesome_Step_Flow extends Widget_Base {

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
		return 'awesome-step-flow';
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
		return esc_html__( 'Step Flow', 'awesome-widgets-elementor' );
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
		return 'eicon-flow';
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
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'step', 'awesome'];
	}

	/**
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		
		// start of the Content tab section
	   	$this->start_controls_section(
	       'awea_step_flow_contents',
		    [
		        'label' => esc_html__('Contents', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
		   
		    ]
	    );
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'awea_step_flow_image',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'awea_step_flow_number',
			[
				'label' => esc_html__( 'Number', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 1,
			]
		);

		$repeater->add_control(
			'awea_step_flow_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Step Title', 'awesome-widgets-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'awea_step_flow_desc',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Describe this step here.', 'awesome-widgets-elementor' ),
			]
		);

		$this->add_control(
			'awea_step_flow_items',
			[
				'label' => esc_html__( 'Step Flow Items', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'awea_step_flow_image' => [
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						],
						'awea_step_flow_number' => 1,
						'awea_step_flow_title'  => 'Discuss Ideas',
						'awea_step_flow_desc'   => 'We discuss for better understandings of the client’s vision',
					],
					[
						'awea_step_flow_image' => [
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						],
						'awea_step_flow_number' => 2,
						'awea_step_flow_title'  => 'Data Collection',
						'awea_step_flow_desc'   => 'We discuss for better understandings of the client’s vision',
					],
					[
						'awea_step_flow_image' => [
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						],
						'awea_step_flow_number' => 3,
						'awea_step_flow_title'  => 'Research',
						'awea_step_flow_desc'   => 'We discuss for better understandings of the client’s vision',
					],
					[
						'awea_step_flow_image' => [
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						],
						'awea_step_flow_number' => 4,
						'awea_step_flow_title'  => 'Develop',
						'awea_step_flow_desc'   => 'We discuss for better understandings of the client’s vision',
					],
					[
						'awea_step_flow_image' => [
							'url' => \Elementor\Utils::get_placeholder_image_src(),
						],
						'awea_step_flow_number' => 5,
						'awea_step_flow_title'  => 'Help to Grow',
						'awea_step_flow_desc'   => 'We discuss for better understandings of the client’s vision',
					],
				],
				'title_field' => '{{{ awea_step_flow_title }}}',
			]
		);

		$this->end_controls_section();

		// start of the Content tab section
		$this->start_controls_section(
			'awea_step_flow_pro_message',
			[
				'label' => esc_html__('Premium', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);

		$this->add_control( 
			'awea_step_flow_pro_message_notice', 
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => sprintf(
					'<div style="text-align:center;line-height:1.6;">
						<p style="margin-bottom:10px">%s</p>
					</div>',
					esc_html__('Awesome Widgets for Elementor Premium is coming soon with more widgets, features, and customization options.', 'awesome-widgets-elementor')
				)
			]  
		);
		$this->end_controls_section();
		
		// start of the Style tab section
		$this->start_controls_section(
			'awea_step_flow_image_style',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Step Flow Image Width
		$this->add_control(
			'awea_step_flow_image_width',
			[
				'label' => esc_html__( 'Width', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 120,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .awea-steps-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Step Flow Background Color
		$this->add_control(
			'awea_step_flow_image_bgcolor',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-steps-img' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				]
			]
		);

		// Step Flow Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_step_flow_img_border',
				'selector' => '{{WRAPPER}} .awea-steps-img',
			]
		);	

		// Step Flow Border Radius
		$this->add_control(
			'awea_step_flow_img_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-steps-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Step Flow Padding
		$this->add_control(
			'awea_step_flow_img_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-steps-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'awea_step_flow_content_style',
			[
				'label' => esc_html__( 'Contents', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Step Flow Year Heading
		$this->add_control(
			'awea_step_flow_number_heading',
			[
				'label' => esc_html__( 'Number', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Step Flow Number Color
		$this->add_control(
			'awea_step_flow_number_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-steps-number' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
			]
		);

		// Step Flow Number BG Color
		$this->add_control(
			'awea_step_flow_bumber_bgcolor',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-steps-number' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		// Step Flow Number Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_step_flow_number_typography',
				'selector' => '{{WRAPPER}} .awea-steps-number',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		// Step Flow Number Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_step_flow_number_border',
				'selector' => '{{WRAPPER}} .awea-steps-number',
			]
		);	

		// Step Flow Number Border Radius
		$this->add_control(
			'awea_step_flow_number_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-steps-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Step Flow Title Heading
		$this->add_control(
			'awea_step_flow_title_heading',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		// Step Flow Title Color
		$this->add_control(
			'awea_step_flow_title_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-steps-title' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		// Step Flow Year Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_step_flow_title_typography',
				'selector' => '{{WRAPPER}} .awea-steps-title',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->add_control(
			'awea_step_flow_desc_heading',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Step Flow Sub Heading Color
		$this->add_control(
			'awea_step_flow_desc_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-steps-desc' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		// Step Flow Sub Heading Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_step_flow_desc_typography',
				'selector' => '{{WRAPPER}} .awea-steps-desc',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		$this->end_controls_section();

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
		$awea_step_flow_items = $settings['awea_step_flow_items'];
       ?>
			<div class="awea-steps-list">
				<?php 
					foreach($awea_step_flow_items as $item) {
						$item_image = $item['awea_step_flow_image']['url'];
						$item_title = $item['awea_step_flow_title'];
						$item_number = $item['awea_step_flow_number'];
						$item_desc = $item['awea_step_flow_desc'];
						?>
							<div class="awea-steps-single">
								<span class="awea-steps-number"><?php echo esc_html($item_number);?></span>
								<img decoding="async" src="<?php echo esc_url($item_image);?>" class="awea-steps-img" alt="">
								<h4 class="awea-steps-title"><?php echo esc_html($item_title);?></h4>
								<p class="awea-steps-desc"><?php echo esc_html($item_desc);?></p>
							</div>
						<?php
					}
				?>
			</div>
       <?php
	}
}
