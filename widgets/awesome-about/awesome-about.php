<?php
/**
 * Awesome About Widget.
 *
 * Elementor widget that inserts an about section into the page.
 *
 * @since 1.0.0
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Repeater;

class Widget_Awesome_About extends Widget_Base {

	public function get_name() {
		return 'awesome-about';
	}

	public function get_title() {
		return esc_html__( 'About', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'about', 'awesome' ];
	}

	protected function _register_controls() {
		
		// About Image
		$this->start_controls_section(
			'awea_about_image_content',
			[
				'label' => esc_html__('Image', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		// About Image Field
		$this->add_control(
			'awea_about_image_upload',
			[
				'label' => esc_html__( 'Choose Image', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		// About Text Contents
		$this->start_controls_section(
			'awea_about_text_content',
			[
				'label' => esc_html__('Content', 'awesome-widgets-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		// About Subheading
		$this->add_control(
			'awea_about_subheading',
			[
				'label' => esc_html__( 'Sub Heading', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'About Our Company', 'awesome-widgets-elementor' ),
			]
		);

		// About Heading
		$this->add_control(
			'awea_about_heading',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Transforming Ideas Into Digital Success', 'awesome-widgets-elementor' ),
			]
		);

		// About Description
		$this->add_control(
			'awea_about_desc',
			[
				'label' => esc_html__('Description', 'awesome-widgets-elementor'),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'default' => wp_kses_post(
					'We are a passionate team of innovators, problem-solvers, and creators. 
					For over <strong>10+ years</strong>, we’ve been helping brands worldwide turn bold ideas into reality.'
				),
			]
		);

		$this->end_controls_section();

		// About Features
		$this->start_controls_section(
			'awea_about_features',
			[
				'label' => esc_html__('Features', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		// About Feature Title
		$repeater->add_control(
			'awea_about_feature_title',
			[
				'label' => esc_html__('Title', 'awesome-widgets-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Facebook', 'awesome-widgets-elementor'),
				'label_block' => true,
			]
		);

		// About Feature Icon
		$repeater->add_control(
			'awea_about_feature_icon',
			[
				'label' => esc_html__('Icon', 'awesome-widgets-elementor'),
				'type' => Controls_Manager::ICONS,
				'show_label' => false,
			]
		);

		// About Feature List
		$this->add_control(
			'awea_about_features_list',
			[
				'label' => esc_html__('Features List', 'awesome-widgets-elementor'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'awea_about_feature_title' => esc_html__('Over 10 Years of Experience', 'awesome-widgets-elementor'),
						'awea_about_feature_icon'  => ['value' => 'fas fa-award', 'library' => 'fa-solid'],
					],
					[
						'awea_about_feature_title' => esc_html__('Certified and Skilled Team', 'awesome-widgets-elementor'),
						'awea_about_feature_icon'  => ['value' => 'fas fa-user-tie', 'library' => 'fa-solid'],
					],
					[
						'awea_about_feature_title' => esc_html__('Customer-Centric Approach', 'awesome-widgets-elementor'),
						'awea_about_feature_icon'  => ['value' => 'fas fa-handshake', 'library' => 'fa-solid'],
					],
					[
						'awea_about_feature_title' => esc_html__('Innovative Solutions', 'awesome-widgets-elementor'),
						'awea_about_feature_icon'  => ['value' => 'fas fa-lightbulb', 'library' => 'fa-solid'],
					],
					[
						'awea_about_feature_title' => esc_html__('Global Clientele', 'awesome-widgets-elementor'),
						'awea_about_feature_icon'  => ['value' => 'fas fa-globe', 'library' => 'fa-solid'],
					],
				],
				'title_field' => '{{{ awea_about_feature_title }}}',
			]
		);

		$this->end_controls_section();

		// About Button
		$this->start_controls_section(
			'awea_about_btn_content',
			[
				'label' => esc_html__('Button', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
		
			]
		);

		// About Button Text
		$this->add_control(
			'awea_about_button',
			[
				'label' => esc_html__( 'Button', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'Read More', 'awesome-widgets-elementor' ),
			]
		);

		// About Button Link
		$this->add_control(
			'awea_about_button_url',
			[
				'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
					// 'custom_attributes' => '',
				],
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		// Premium Message Section
		$this->start_controls_section(
			'awea_about_pro_message',
			[
				'label' => esc_html__('Premium', 'awesome-widgets-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_about_pro_message_notice',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf(
					'<div style="text-align:center;line-height:1.6;">
						<p style="margin-bottom:10px">%s</p>
					</div>',
					esc_html__('Awesome Widgets for Elementor Premium is coming soon with more widgets, features, and customization options.', 'awesome-widgets-elementor')
				),
			]
		);

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'awea_about_image_style',
			[
				'label' => esc_html__( 'Image', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'awea_about_image_border',
				'selector' => '{{WRAPPER}} .awea-about-img img',
			]
		);

		$this->add_control(
			'awea_about_image_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-about-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'awea_about_content_style',
			[
				'label' => esc_html__( 'Contents', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_about_subtitle_options',
			[
				'label' => esc_html__( 'Sub Title', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_about_subtitle_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-content span' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_about_subtitle_typography',
				'selector' => '{{WRAPPER}} .awea-about-content span',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->add_control(
			'awea_about_itle_options',
			[
				'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_about_title_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-content h4' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		// CTA Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_about_title_typography',
				'selector' => '{{WRAPPER}} .awea-about-content h4',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->add_control(
			'awea_about_desc_options',
			[
				'label' => esc_html__( 'Description', 'awesome-widgets-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_about_desc_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-content-desc' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		// CTA Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_about_desc_typography',
				'selector' => '{{WRAPPER}} .awea-about-content-desc',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'awea_about_features_style',
			[
				'label' => esc_html__( 'Features', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_about_features_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-list li' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		$this->add_control(
			'awea_about_features_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-list li i' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_about_features_typography',
				'selector' => '{{WRAPPER}} .awea-about-list li',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				]
			]
		);

		$this->end_controls_section();

		// start of the Style tab section
		$this->start_controls_section(
			'awea_about_btns_style',
			[
				'label' => esc_html__( 'Buttons', 'awesome-widgets-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_about_contents_btn1_options',
			[
				'label' => esc_html__( 'Buttons', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Start of Tabs
		$this->start_controls_tabs('about_button1_tabs');

		// Normal Tab
		$this->start_controls_tab(
			'about_button_tab_normal',
			[
				'label' => esc_html__('Normal', 'awesome-widgets-elementor'),
			]
		);

		// about Title Color
		$this->add_control(
			'awea_about_btn_color',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				]
			]
		);

		// about Title Color
		$this->add_control(
			'awea_about_btn_bgcolor',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		// about Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'awea_about_btn_typography',
				'selector' => '{{WRAPPER}} .awea-about-btn',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				]
			]
		);

		// about Border Radius
		$this->add_control(
			'awea_about_btn_padding',
			[
				'label' => esc_html__( 'Padding', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// about Border Radius
		$this->add_control(
			'awea_about_btn_radius',
			[
				'label' => esc_html__( 'Border Radius', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'about_button_tab_hover',
			[
				'label' => esc_html__('Hover', 'awesome-widgets-elementor'),
			]
		);

		$this->add_control(
			'awea_about_btn_hovercolor',
			[
				'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn:hover' => 'color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				]
			]
		);

		$this->add_control(
			'awea_about_btn_hover_bg',
			[
				'label' => esc_html__( 'Background', 'awesome-widgets-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awea-about-btn:hover' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		// end of the Style tab section

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$image_url = ! empty( $settings['awea_about_image_upload']['url'] ) ? $settings['awea_about_image_upload']['url'] : Utils::get_placeholder_image_src();
		$subheading = $settings['awea_about_subheading'];
		$heading = $settings['awea_about_heading'];
		$desc = $settings['awea_about_desc'];
		$awea_about_button = $settings['awea_about_button'];
		$awea_about_button_url = $settings['awea_about_button'];
		$features = $settings['awea_about_features_list'];

		?>
		<div class="awea-grid-row">
			<div class="awea-grid-desktop-7 awea-grid-tablet-6 awea-grid-mobile-12">
				<div class="awea-about-content">
					<span><?php echo esc_html( $subheading ); ?></span>
					<h4><?php echo esc_html( $heading ); ?></h4>
					<div class="awea-about-content-desc">
						<?php echo wp_kses_post( $desc ); ?>
					</div>				

					<?php if ( ! empty( $features ) ) : ?>
						<ul class="awea-about-list">
							<?php foreach ( $features as $feature ) :
								$icon_html = '';
								if ( ! empty( $feature['awea_about_feature_icon'] ) && ! empty( $feature['awea_about_feature_icon']['value'] ) ) {
									$icon_class = esc_attr( $feature['awea_about_feature_icon']['value'] );
									$icon_html = '<i class="' . $icon_class . '"></i> ';
								}
							?>
								<li>
									<?php echo esc_html($icon_html); ?>
									<?php echo esc_html( $feature['awea_about_feature_title'] ); ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<a href="<?php echo esc_url($awea_about_button_url); ?>" class="awea-about-btn"><?php echo esc_html($awea_about_button); ?></a>
				</div>
			</div>
			<div class="awea-grid-desktop-5 awea-grid-tablet-6 awea-grid-mobile-12">
				<div class="awea-about-img">
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $heading ); ?>">
				</div>
			</div>
		</div>
		<?php
	}
}
