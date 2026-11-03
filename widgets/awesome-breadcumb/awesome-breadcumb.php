<?php
/**
 * Awesome Breadcumb Widget.
 *
 * Elementor widget that inserts a team into the page
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
class Widget_Awesome_Breadcumb extends Widget_Base {

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
		return 'awesome-breadcumb';
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
		return esc_html__( 'Breadcumb', 'awesome-widgets-elementor' );
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
		return 'eicon-info-circle-o';
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

	public function get_keywords() {
		return [ 'team', 'member', 'awesome'];
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
	       'awea_breadcumb_image_content',
		    [
		        'label' => esc_html__('Background', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,	   
		    ]
	    );

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .awea-breadcumb',
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'awea_breadcumb_overlay_content',
			[
				'label' => esc_html__('Background Overlay', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'overlay_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awea-breadcumb::before',
			]
		);

		$this->add_control(
			'overlay_opacity',
			[
				'label' => esc_html__('Overlay Opacity', 'awesome-widgets-elementor'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
				],
				'default' => [
					'size' => 0.5,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-breadcumb::before' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();

		// start of the Content tab section
		$this->start_controls_section(
			'awea_breadcumb_contents',
			[
				'label' => esc_html__('Contents', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,		
			]
		);

		$this->add_control(
			'awea_breadcumb_title',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__('Page Title' , 'awesome-widgets-elementor')
			]
		);
		
		$this->end_controls_section();

		// start of the Content tab section
		$this->start_controls_section(
			'awea_breadcumb_pro_message',
			[
				'label' => esc_html__('Premium', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT		
			]
		);

		$this->add_control( 
			'awea_breadcumb_pro_message_notice', 
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
			'awea_breadcumb_layout_style',
			[
				'label' => esc_html__( 'Layouts', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		// Breadcumb Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'awea_breadcumb_border',
				'selector' => '{{WRAPPER}} .awea-breadcumb',
			]
		);	

		// Breadcumb Padding
		$this->add_control(
			'awea_breadcumb_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-breadcumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_breadcumb_align',
			[
				'label' => esc_html__( 'Alignment', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .awea-breadcumb, {{WRAPPER}} .awea-breadcumb ul' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
		// end of the Style tab section

		// start of the Style tab section
		$this->start_controls_section(
			'awea_breadcumb_contents_style',
			[
				'label' => esc_html__( 'Contents', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_breadcumb_title_options',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Breadcumb Title Color
		$this->add_control(
			'awea_breadcumb_title_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-breadcumb h4' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				]
			]
		);

		// Breadcumb Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_breadcumb_title_typography',
				'selector' => '{{WRAPPER}} .awea-breadcumb h4',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				]
			]
		);

		$this->add_control(
			'awea_breadcumb_title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .awea-breadcumb h4' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_breadcumb_list_options',
			[
				'label' => esc_html__( 'Items', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Breadcumb Title Color
		$this->add_control(
			'awea_breadcumb_list_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-breadcumb ul li, .awea-breadcumb ul li a' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		// Breadcumb Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_breadcumb_list_typography',
				'selector' => '{{WRAPPER}} .awea-breadcumb ul li, .awea-breadcumb ul li a',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				]
			]
		);

		$this->add_control(
			'awea_breadcumb_sep_options',
			[
				'label' => esc_html__( 'Separator', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Breadcumb Title Color
		$this->add_control(
			'awea_breadcumb_sep_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-breadcumb ul li:after' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		$this->add_control(
			'awea_breadcumb_sep_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-breadcumb ul li:after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
		$awea_breadcumb_title = $settings['awea_breadcumb_title'];
        ?>
			<div class="awea-breadcumb">
				<h4><?php echo esc_html($awea_breadcumb_title);?></h4>
				<ul>
					<li><a href="<?php echo esc_url( site_url() ); ?>">Home</a></li>
					<li><?php echo esc_attr($awea_breadcumb_title);?></li>
				</ul>
			</div>
       <?php
	}
}
