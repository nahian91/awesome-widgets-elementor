<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Widget_Base;

class Widget_Awesome_Filter_Gallery extends Widget_Base {

	public function get_name() {
		return 'awesome-filter-gallery';
	}

	public function get_title() {
		return esc_html__( 'Filter Gallery Studio', 'awesome-widgets-elementor' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'awesome-widgets-elementor' ];
	}

	public function get_keywords() {
		return [ 'awea', 'filter', 'gallery', 'portfolio', 'grid', 'lightbox', 'flip', 'images' ];
	}

	protected function register_controls() {

		/* ==========================================================================
		   CONTENT: FILTER CONTROLS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_filter_bar',
			[
				'label' => esc_html__( 'Filter Bar Navigation', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'awea_show_filter_bar',
			[
				'label'        => esc_html__( 'Show Filter Bar', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Hide', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_all_label',
			[
				'label'       => esc_html__( '"All" Tab Label', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'All Works', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'awea_show_filter_bar' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_show_counter',
			[
				'label'        => esc_html__( 'Show Item Counter', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'No', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'awea_show_filter_bar' => 'yes' ],
			]
		);

		$repeater_cats = new Repeater();

		$repeater_cats->add_control(
			'awea_cat_name',
			[
				'label'       => esc_html__( 'Category Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'awea_categories',
			[
				'label'       => esc_html__( 'Categories List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater_cats->get_controls(),
				'default'     => [
					[ 'awea_cat_name' => esc_html__( 'Architecture', 'awesome-widgets-elementor' ) ],
					[ 'awea_cat_name' => esc_html__( 'Landscape', 'awesome-widgets-elementor' ) ],
					[ 'awea_cat_name' => esc_html__( 'Portraits', 'awesome-widgets-elementor' ) ],
					[ 'awea_cat_name' => esc_html__( 'Minimalism', 'awesome-widgets-elementor' ) ],
				],
				'title_field' => '{{{ awea_cat_name }}}',
				'condition'   => [ 'awea_show_filter_bar' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'awea_filter_align',
			[
				'label'     => esc_html__( 'Bar Alignment', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'flex-start' => [ 'title' => esc_html__( 'Left', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center'     => [ 'title' => esc_html__( 'Center', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'flex-end'   => [ 'title' => esc_html__( 'Right', 'awesome-widgets-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .awea-fg-nav-wrapper' => 'justify-content: {{VALUE}};',
				],
				'condition' => [ 'awea_show_filter_bar' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: GALLERY ITEMS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_gallery_items',
			[
				'label' => esc_html__( 'Gallery Items', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater_items = new Repeater();

		$repeater_items->add_control(
			'awea_item_image',
			[
				'label'   => esc_html__( 'Choose Image', 'awesome-widgets-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater_items->add_control(
			'awea_item_title',
			[
				'label'       => esc_html__( 'Project Title', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Project Showcase', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater_items->add_control(
			'awea_item_subtitle',
			[
				'label'       => esc_html__( 'Subtitle / Tag', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Design Concept', 'awesome-widgets-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater_items->add_control(
			'awea_item_category',
			[
				'label'       => esc_html__( 'Assigned Categories', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Match category names from Filter Bar. Separate multiple tags with commas (e.g. Architecture, Minimalism)', 'awesome-widgets-elementor' ),
				'label_block' => true,
			]
		);

		$repeater_items->add_control(
			'awea_item_link',
			[
				'label'       => esc_html__( 'Custom URL (Optional)', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://example.com',
			]
		);

		$this->add_control(
			'awea_gallery_items',
			[
				'label'       => esc_html__( 'Items List', 'awesome-widgets-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater_items->get_controls(),
				'default'     => [
					[
						'awea_item_title'    => esc_html__( 'Tokyo Cyberpunk', 'awesome-widgets-elementor' ),
						'awea_item_subtitle' => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
						'awea_item_category' => 'Architecture, Minimalism',
					],
					[
						'awea_item_title'    => esc_html__( 'Alpine Serenity', 'awesome-widgets-elementor' ),
						'awea_item_subtitle' => esc_html__( 'Landscape', 'awesome-widgets-elementor' ),
						'awea_item_category' => 'Landscape',
					],
					[
						'awea_item_title'    => esc_html__( 'Vogue Monolith', 'awesome-widgets-elementor' ),
						'awea_item_subtitle' => esc_html__( 'Portraits', 'awesome-widgets-elementor' ),
						'awea_item_category' => 'Portraits',
					],
					[
						'awea_item_title'    => esc_html__( 'Bauhaus Geometry', 'awesome-widgets-elementor' ),
						'awea_item_subtitle' => esc_html__( 'Architecture', 'awesome-widgets-elementor' ),
						'awea_item_category' => 'Architecture, Minimalism',
					],
					[
						'awea_item_title'    => esc_html__( 'Nordic Fjords', 'awesome-widgets-elementor' ),
						'awea_item_subtitle' => esc_html__( 'Landscape', 'awesome-widgets-elementor' ),
						'awea_item_category' => 'Landscape',
					],
					[
						'awea_item_title'    => esc_html__( 'Minimal Silhouette', 'awesome-widgets-elementor' ),
						'awea_item_subtitle' => esc_html__( 'Minimalism', 'awesome-widgets-elementor' ),
						'awea_item_category' => 'Portraits, Minimalism',
					],
				],
				'title_field' => '{{{ awea_item_title || "Gallery Item" }}}',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   CONTENT: GRID & PHYSICS
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_grid_settings',
			[
				'label' => esc_html__( 'Grid Layout & Physics', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'awea_grid_columns',
			[
				'label'           => esc_html__( 'Columns', 'awesome-widgets-elementor' ),
				'type'            => Controls_Manager::SELECT,
				'default'         => '3',
				'tablet_default'  => '2',
				'mobile_default'  => '1',
				'options'         => [
					'1' => '1 Column',
					'2' => '2 Columns',
					'3' => '3 Columns',
					'4' => '4 Columns',
					'5' => '5 Columns',
					'6' => '6 Columns',
				],
				'selectors'       => [
					'{{WRAPPER}} .awea-fg-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_responsive_control(
			'awea_grid_gap',
			[
				'label'      => esc_html__( 'Grid Gap', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .awea-fg-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'awea_aspect_ratio',
			[
				'label'     => esc_html__( 'Aspect Ratio', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4/3',
				'options'   => [
					'1/1'  => '1:1 Square',
					'4/3'  => '4:3 Standard',
					'16/9' => '16:9 Cinema',
					'3/4'  => '3:4 Editorial',
					'auto' => 'Original Aspect',
				],
				'selectors' => [
					'{{WRAPPER}} .awea-fg-thumb' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_enable_3d_tilt',
			[
				'label'        => esc_html__( '3D Parallax Tilt', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Off', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'awea_enable_spotlight',
			[
				'label'        => esc_html__( 'Cursor Spotlight Glow', 'awesome-widgets-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'awesome-widgets-elementor' ),
				'label_off'    => esc_html__( 'Off', 'awesome-widgets-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: FILTER NAVIGATION BAR
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_filter_bar',
			[
				'label'     => esc_html__( 'Filter Bar Styles', 'awesome-widgets-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'awea_show_filter_bar' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_nav_typography',
				'selector' => '{{WRAPPER}} .awea-fg-btn',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_padding',
			[
				'label'      => esc_html__( 'Button Padding', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-fg-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'awea_nav_track_margin',
			[
				'label'      => esc_html__( 'Filter Bar Margin', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .awea-fg-nav-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'awea_nav_color_tabs' );

		// Normal Tab
		$this->start_controls_tab(
			'awea_nav_tab_normal',
			[ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nav_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-fg-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_track_bg',
			[
				'label'     => esc_html__( 'Track Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.05)',
				'selectors' => [
					'{{WRAPPER}} .awea-fg-nav-track' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Active Tab
		$this->start_controls_tab(
			'awea_nav_tab_active',
			[ 'label' => esc_html__( 'Active', 'awesome-widgets-elementor' ) ]
		);

		$this->add_control(
			'awea_nav_active_text_color',
			[
				'label'     => esc_html__( 'Active Text Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-fg-btn.is-active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_nav_pill_bg_color',
			[
				'label'     => esc_html__( 'Sliding Pill Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-fg-pill-indicator' => 'background-color: {{VALUE}}; box-shadow: 0 8px 24px -4px {{VALUE}}66;',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		// Counter Pill Styling
		$this->add_control(
			'awea_heading_counter_style',
			[
				'label'     => esc_html__( 'Counter Badge', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'awea_show_counter' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_counter_bg',
			[
				'label'     => esc_html__( 'Badge Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.08)',
				'selectors' => [
					'{{WRAPPER}} .awea-fg-counter' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'awea_show_counter' => 'yes' ],
			]
		);

		$this->add_control(
			'awea_counter_active_bg',
			[
				'label'     => esc_html__( 'Active Badge Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.25)',
				'selectors' => [
					'{{WRAPPER}} .awea-fg-btn.is-active .awea-fg-counter' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'awea_show_counter' => 'yes' ],
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: CARDS & IMAGES
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_cards',
			[
				'label' => esc_html__( 'Cards & Hover Effects', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'awea_card_radius',
			[
				'label'      => esc_html__( 'Corner Radius', 'awesome-widgets-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default'    => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .awea-fg-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'awea_card_border',
				'selector' => '{{WRAPPER}} .awea-fg-card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'awea_card_shadow',
				'selector' => '{{WRAPPER}} .awea-fg-card',
			]
		);

		$this->end_controls_section();

		/* ==========================================================================
		   STYLE: OVERLAY & TYPOGRAPHY
		   ========================================================================== */
		$this->start_controls_section(
			'awea_section_style_overlay',
			[
				'label' => esc_html__( 'Captions & Overlay', 'awesome-widgets-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'awea_overlay_card_bg',
			[
				'label'     => esc_html__( 'Frosted Caption Background', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 23, 42, 0.78)',
				'selectors' => [
					'{{WRAPPER}} .awea-fg-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'awea_heading_title_style',
			[
				'label'     => esc_html__( 'Title Typography', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .awea-fg-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_title_typography',
				'selector' => '{{WRAPPER}} .awea-fg-title',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_control(
			'awea_heading_sub_style',
			[
				'label'     => esc_html__( 'Subtitle Typography', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'awea_subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'awesome-widgets-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .awea-fg-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'awea_subtitle_typography',
				'selector' => '{{WRAPPER}} .awea-fg-subtitle',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$gallery_items = ! empty( $settings['awea_gallery_items'] ) ? $settings['awea_gallery_items'] : [];
		$category_list = ! empty( $settings['awea_categories'] ) ? $settings['awea_categories'] : [];
		$show_menu     = 'yes' === ( $settings['awea_show_filter_bar'] ?? 'no' );
		$show_counts   = 'yes' === ( $settings['awea_show_counter'] ?? 'no' );
		$is_3d         = 'yes' === ( $settings['awea_enable_3d_tilt'] ?? 'no' );
		$is_spotlight  = 'yes' === ( $settings['awea_enable_spotlight'] ?? 'no' );
		$all_label     = ! empty( $settings['awea_all_label'] ) ? $settings['awea_all_label'] : esc_html__( 'All Works', 'awesome-widgets-elementor' );

		// Build Category Counts
		$cat_counts = [ '*' => count( $gallery_items ) ];
		foreach ( $gallery_items as $item ) {
			$raw_cats = explode( ',', $item['awea_item_category'] ?? '' );
			foreach ( $raw_cats as $rc ) {
				$clean = sanitize_title( trim( $rc ) );
				if ( ! empty( $clean ) ) {
					$cat_counts[ $clean ] = ( $cat_counts[ $clean ] ?? 0 ) + 1;
				}
			}
		}

		$wrapper_classes = [ 'awea-filter-gallery-studio' ];
		if ( $is_3d ) {
			$wrapper_classes[] = 'awea-has-3d-tilt';
		}
		if ( $is_spotlight ) {
			$wrapper_classes[] = 'awea-has-spotlight';
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>" id="awea-fg-<?php echo esc_attr( $this->get_id() ); ?>">

			<?php if ( $show_menu ) : ?>
				<!-- Magic Sliding Pill Navigation -->
				<div class="awea-fg-nav-wrapper">
					<div class="awea-fg-nav-track">
						<span class="awea-fg-pill-indicator"></span>

						<button type="button" class="awea-fg-btn is-active" data-filter="*">
							<span class="awea-fg-btn-text"><?php echo esc_html( $all_label ); ?></span>
							<?php if ( $show_counts ) : ?>
								<span class="awea-fg-counter"><?php echo esc_html( (string) $cat_counts['*'] ); ?></span>
							<?php endif; ?>
						</button>

						<?php foreach ( $category_list as $cat ) : 
							$cat_raw  = $cat['awea_cat_name'] ?? '';
							$cat_slug = sanitize_title( $cat_raw );
							if ( empty( $cat_slug ) ) continue;
							$count = $cat_counts[ $cat_slug ] ?? 0;
						?>
							<button type="button" class="awea-fg-btn" data-filter=".awea-cat-<?php echo esc_attr( $cat_slug ); ?>">
								<span class="awea-fg-btn-text"><?php echo esc_html( $cat_raw ); ?></span>
								<?php if ( $show_counts ) : ?>
									<span class="awea-fg-counter"><?php echo esc_html( (string) $count ); ?></span>
								<?php endif; ?>
							</button>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- FLIP Accelerated Grid -->
			<div class="awea-fg-grid">
				<?php foreach ( $gallery_items as $index => $item ) : 
					$img_url     = $item['awea_item_image']['url'] ?? Utils::get_placeholder_image_src();
					$title       = $item['awea_item_title'] ?? '';
					$subtitle    = $item['awea_item_subtitle'] ?? '';
					$custom_url  = $item['awea_item_link']['url'] ?? '';
					$target      = ! empty( $item['awea_item_link']['is_external'] ) ? '_blank' : '_self';
					$nofollow    = ! empty( $item['awea_item_link']['nofollow'] ) ? 'rel="nofollow"' : '';

					$raw_cats    = explode( ',', $item['awea_item_category'] ?? '' );
					$cat_classes = [];
					foreach ( $raw_cats as $rc ) {
						$c_slug = sanitize_title( trim( $rc ) );
						if ( ! empty( $c_slug ) ) {
							$cat_classes[] = 'awea-cat-' . $c_slug;
						}
					}
					$class_string = implode( ' ', $cat_classes );
				?>
					<div class="awea-fg-item <?php echo esc_attr( $class_string ); ?>" data-index="<?php echo esc_attr( $index ); ?>">
						<div class="awea-fg-card">
							
							<!-- Radial Spotlight Glow -->
							<div class="awea-fg-spotlight"></div>

							<!-- Image Thumbnail -->
							<div class="awea-fg-thumb" style="background-image: url('<?php echo esc_url( $img_url ); ?>');">
								<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" />
							</div>

							<!-- Frosted Bottom Glass Caption -->
							<div class="awea-fg-overlay">
								<div class="awea-fg-meta">
									<?php if ( ! empty( $subtitle ) ) : ?>
										<span class="awea-fg-subtitle"><?php echo esc_html( $subtitle ); ?></span>
									<?php endif; ?>
									
									<?php if ( ! empty( $title ) ) : ?>
										<h4 class="awea-fg-title"><?php echo esc_html( $title ); ?></h4>
									<?php endif; ?>
								</div>

								<!-- Action Glass Cluster -->
								<div class="awea-fg-actions">
									<a href="<?php echo esc_url( $img_url ); ?>" 
									   class="awea-fg-action-btn awea-fg-lightbox elementor-lightbox" 
									   data-elementor-open-lightbox="yes" 
									   data-elementor-lightbox-slideshow="awea-fg-<?php echo esc_attr( $this->get_id() ); ?>"
									   title="<?php echo esc_attr( $title ); ?>"
									   aria-label="<?php esc_attr_e( 'Zoom View', 'awesome-widgets-elementor' ); ?>">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
									</a>

									<?php if ( ! empty( $custom_url ) ) : ?>
										<a href="<?php echo esc_url( $custom_url ); ?>" 
										   target="<?php echo esc_attr( $target ); ?>" 
										   <?php echo $nofollow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> 
										   class="awea-fg-action-btn awea-fg-link" 
										   aria-label="<?php esc_attr_e( 'Open Case Study', 'awesome-widgets-elementor' ); ?>">
											<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
										</a>
									<?php endif; ?>
								</div>
							</div>

						</div>
					</div>
				<?php endforeach; ?>
			</div>

		</div>

		<!-- Scoped Inline Interaction Controller -->
		<script>
		document.addEventListener('DOMContentLoaded', function() {
			var scope = document.getElementById('awea-fg-<?php echo esc_js( $this->get_id() ); ?>');
			if (!scope) return;

			var track     = scope.querySelector('.awea-fg-nav-track');
			var indicator = scope.querySelector('.awea-fg-pill-indicator');
			var buttons   = scope.querySelectorAll('.awea-fg-btn');
			var items     = Array.from(scope.querySelectorAll('.awea-fg-item'));

			// Fluid Indicator Positioning
			function updateIndicator(activeBtn) {
				if (!indicator || !activeBtn) return;
				indicator.style.width   = activeBtn.offsetWidth + 'px';
				indicator.style.height  = activeBtn.offsetHeight + 'px';
				indicator.style.left    = activeBtn.offsetLeft + 'px';
				indicator.style.top     = activeBtn.offsetTop + 'px';
				indicator.style.opacity = '1';
			}

			var defaultActive = scope.querySelector('.awea-fg-btn.is-active');
			if (defaultActive) {
				setTimeout(function() { updateIndicator(defaultActive); }, 80);
			}

			// FLIP Animation Filter
			buttons.forEach(function(btn) {
				btn.addEventListener('click', function() {
					if (this.classList.contains('is-active')) return;

					buttons.forEach(function(b) { b.classList.remove('is-active'); });
					this.classList.add('is-active');
					updateIndicator(this);

					var filterVal = this.getAttribute('data-filter');

					// FIRST: Record positions
					var firstBounds = new Map();
					items.forEach(function(item) {
						if (item.style.display !== 'none') {
							firstBounds.set(item, item.getBoundingClientRect());
						}
					});

					// Update display states
					items.forEach(function(item) {
						var matches = (filterVal === '*' || item.matches(filterVal));
						item.style.display = matches ? '' : 'none';
					});

					// LAST, INVERT, PLAY
					items.forEach(function(item) {
						if (item.style.display === 'none') return;

						var lastBound  = item.getBoundingClientRect();
						var firstBound = firstBounds.get(item);

						if (firstBound) {
							var dX = firstBound.left - lastBound.left;
							var dY = firstBound.top - lastBound.top;

							if (dX !== 0 || dY !== 0) {
								item.style.transform  = 'translate3d(' + dX + 'px, ' + dY + 'px, 0)';
								item.style.transition = 'none';

								requestAnimationFrame(function() {
									item.style.transition = 'transform 0.45s cubic-bezier(0.16, 1, 0.3, 1)';
									item.style.transform  = 'translate3d(0, 0, 0)';
								});
							}
						} else {
							item.style.opacity    = '0';
							item.style.transform  = 'scale(0.88) translate3d(0, 16px, 0)';
							item.style.transition = 'none';

							requestAnimationFrame(function() {
								item.style.transition = 'opacity 0.4s cubic-bezier(0.16, 1, 0.3, 1), transform 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
								item.style.opacity    = '1';
								item.style.transform  = 'scale(1) translate3d(0, 0, 0)';
							});
						}
					});
				});
			});

			// 3D Parallax & Cursor Spotlight
			if (scope.classList.contains('awea-has-3d-tilt') || scope.classList.contains('awea-has-spotlight')) {
				items.forEach(function(item) {
					var card      = item.querySelector('.awea-fg-card');
					var spotlight = item.querySelector('.awea-fg-spotlight');

					card.addEventListener('mousemove', function(e) {
						var rect = card.getBoundingClientRect();
						var x = e.clientX - rect.left;
						var y = e.clientY - rect.top;

						if (spotlight) {
							spotlight.style.opacity = '1';
							spotlight.style.background = 'radial-gradient(350px circle at ' + x + 'px ' + y + 'px, rgba(255, 255, 255, 0.16), transparent 70%)';
						}

						if (scope.classList.contains('awea-has-3d-tilt')) {
							var rotX = ((y - (rect.height / 2)) / (rect.height / 2)) * -6;
							var rotY = ((x - (rect.width / 2)) / (rect.width / 2)) * 6;
							card.style.transform = 'perspective(1000px) rotateX(' + rotX + 'deg) rotateY(' + rotY + 'deg) scale3d(1.02, 1.02, 1.02)';
						}
					});

					card.addEventListener('mouseleave', function() {
						if (spotlight) spotlight.style.opacity = '0';
						card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
					});
				});
			}
		});
		</script>
		<?php
	}
}