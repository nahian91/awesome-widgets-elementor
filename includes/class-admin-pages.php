<?php
/**
 * Premium Admin Dashboard & Pages Controller.
 *
 * @package AwesomeWidgetsElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class AWEA_Admin_Pages
 */
class AWEA_Admin_Pages {

	/**
	 * Available widget slugs.
	 *
	 * @var array
	 */
	private $widgets = array();

	/**
	 * Admin page hook suffixes.
	 *
	 * @var array
	 */
	private $hook_suffixes = array();

	/**
	 * Constructor.
	 *
	 * @param array $widgets List of widget slugs.
	 */
	public function __construct( $widgets = array() ) {
		$this->widgets = is_array( $widgets ) ? $widgets : array();

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Register admin menu and submenus.
	 */
	public function add_admin_menu() {
		// Root Dashboard
		$this->hook_suffixes['main'] = add_menu_page(
			esc_html__( 'Awesome Widgets', 'awesome-widgets-elementor' ),
			esc_html__( 'Awesome Widgets', 'awesome-widgets-elementor' ),
			'manage_options',
			'awesome-widgets-elementor',
			array( $this, 'render_general_page' ),
			'dashicons-screenoptions',
			59
		);

		// Submenu 1: Dashboard
		$this->hook_suffixes['general'] = add_submenu_page(
			'awesome-widgets-elementor',
			esc_html__( 'Dashboard & Health', 'awesome-widgets-elementor' ),
			esc_html__( 'Dashboard', 'awesome-widgets-elementor' ),
			'manage_options',
			'awesome-widgets-elementor',
			array( $this, 'render_general_page' )
		);

		// Submenu 2: Widgets Manager
		$this->hook_suffixes['widgets'] = add_submenu_page(
			'awesome-widgets-elementor',
			esc_html__( 'Manage Widgets', 'awesome-widgets-elementor' ),
			esc_html__( 'Widgets Manager', 'awesome-widgets-elementor' ),
			'manage_options',
			'awesome-widgets-widgets',
			array( $this, 'render_widgets_page' )
		);

		// Submenu 3: Header & Footer Builder
		$this->hook_suffixes['header_footer'] = add_submenu_page(
			'awesome-widgets-elementor',
			esc_html__( 'Header & Footer Builder', 'awesome-widgets-elementor' ),
			esc_html__( 'Header & Footer', 'awesome-widgets-elementor' ),
			'manage_options',
			'awesome-widgets-header-footer',
			array( $this, 'render_header_footer_page' )
		);
	}

	/**
	 * Categorize widgets based on slug conventions.
	 *
	 * @param string $slug Widget slug.
	 * @return string Category group.
	 */
	private function get_widget_category( $slug ) {
		if ( strpos( $slug, 'product' ) !== false || strpos( $slug, 'price' ) !== false ) {
			return 'ecommerce';
		}
		if ( strpos( $slug, 'carousel' ) !== false || strpos( $slug, 'slider' ) !== false || strpos( $slug, 'gallery' ) !== false ) {
			return 'media';
		}
		if ( strpos( $slug, 'post' ) !== false || strpos( $slug, 'timeline' ) !== false || strpos( $slug, 'countdown' ) !== false ) {
			return 'dynamic';
		}
		return 'creative';
	}

	/**
	 * Enqueue assets on plugin screens.
	 *
	 * @param string $hook Admin hook.
	 */
	public function enqueue_admin_assets( $hook ) {
		if ( ! in_array( $hook, $this->hook_suffixes, true ) ) {
			return;
		}

		$admin_ui_css = '
			:root {
				--awea-primary: #4338ca;
				--awea-primary-hover: #3730a3;
				--awea-accent: #06b6d4;
				--awea-surface: #ffffff;
				--awea-background: #f8fafc;
				--awea-border: #e2e8f0;
				--awea-text-dark: #0f172a;
				--awea-text-muted: #64748b;
				--awea-success: #10b981;
				--awea-warning: #f59e0b;
			}

			#e-admin-top-bar-root, 
			.e-admin-top-bar--active #e-admin-top-bar-root, 
			#elementor-editor-loading { 
				display: none !important; 
			}
			body.e-admin-top-bar--active { 
				margin-top: 0 !important; 
			}

			.awea-dashboard {
				max-width: 1240px;
				margin: 25px 20px 40px 0;
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
				color: var(--awea-text-dark);
			}

			.awea-hero {
				background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
				border-radius: 16px;
				padding: 36px 40px;
				color: #ffffff;
				display: flex;
				justify-content: space-between;
				align-items: center;
				box-shadow: 0 10px 25px -5px rgba(67, 56, 202, 0.25);
				margin-bottom: 28px;
			}
			.awea-hero h1 {
				color: #ffffff;
				font-size: 28px;
				font-weight: 800;
				letter-spacing: -0.02em;
				margin: 0 0 8px 0;
			}
			.awea-hero p {
				color: #c7d2fe;
				font-size: 15px;
				margin: 0;
				max-width: 600px;
				line-height: 1.5;
			}
			.awea-pill-badge {
				background: rgba(255, 255, 255, 0.12);
				border: 1px solid rgba(255, 255, 255, 0.2);
				padding: 6px 14px;
				border-radius: 30px;
				font-size: 12px;
				font-weight: 600;
				letter-spacing: 0.05em;
				backdrop-filter: blur(8px);
			}

			.awea-card {
				background: var(--awea-surface);
				border-radius: 12px;
				border: 1px solid var(--awea-border);
				padding: 24px;
				box-shadow: 0 1px 3px rgba(0,0,0,0.02);
				margin-bottom: 24px;
			}
			.awea-card-title {
				font-size: 16px;
				font-weight: 700;
				margin: 0 0 16px 0;
				display: flex;
				align-items: center;
				gap: 8px;
			}

			.awea-stats-strip {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
				gap: 16px;
				margin-bottom: 24px;
			}
			.awea-stat-card {
				background: var(--awea-surface);
				border: 1px solid var(--awea-border);
				border-radius: 12px;
				padding: 20px;
				display: flex;
				flex-direction: column;
				gap: 6px;
			}
			.awea-stat-value {
				font-size: 28px;
				font-weight: 800;
				line-height: 1;
			}
			.awea-stat-caption {
				font-size: 13px;
				color: var(--awea-text-muted);
				font-weight: 500;
			}

			.awea-tabs {
				display: flex;
				gap: 8px;
				border-bottom: 2px solid var(--awea-border);
				margin-bottom: 20px;
			}
			.awea-tab-btn {
				background: none;
				border: none;
				padding: 10px 16px;
				font-size: 14px;
				font-weight: 600;
				color: var(--awea-text-muted);
				cursor: pointer;
				border-bottom: 2px solid transparent;
				margin-bottom: -2px;
				transition: all 0.2s ease;
			}
			.awea-tab-btn:hover,
			.awea-tab-btn.active {
				color: var(--awea-primary);
			}
			.awea-tab-btn.active {
				border-bottom-color: var(--awea-primary);
			}

			.awea-toolbar-bar {
				background: var(--awea-surface);
				border: 1px solid var(--awea-border);
				border-radius: 12px;
				padding: 16px 20px;
				display: flex;
				justify-content: space-between;
				align-items: center;
				gap: 16px;
				margin-bottom: 24px;
				flex-wrap: wrap;
			}
			.awea-search-container {
				position: relative;
				flex: 1 1 300px;
			}
			.awea-search-container input {
				width: 100%;
				padding: 10px 16px 10px 38px !important;
				border-radius: 8px !important;
				border: 1px solid var(--awea-border) !important;
				font-size: 13px !important;
				background: #f8fafc !important;
			}
			.awea-search-container .dashicons {
				position: absolute;
				left: 12px;
				top: 50%;
				transform: translateY(-50%);
				color: var(--awea-text-muted);
			}

			.awea-widgets-grid {
				display: grid;
				grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
				gap: 16px;
				margin: 0 0 28px 0;
				padding: 0;
				list-style: none;
			}
			.awea-widget-card {
				background: var(--awea-surface);
				border: 1px solid var(--awea-border);
				border-radius: 10px;
				padding: 16px 18px;
				display: flex;
				align-items: center;
				justify-content: space-between;
				transition: all 0.2s ease;
			}
			.awea-widget-card:hover {
				border-color: #cbd5e1;
				box-shadow: 0 8px 20px -4px rgba(0,0,0,0.06);
				transform: translateY(-2px);
			}
			.awea-widget-meta {
				display: flex;
				flex-direction: column;
				gap: 4px;
			}
			.awea-widget-title {
				font-size: 14px;
				font-weight: 600;
				color: var(--awea-text-dark);
			}
			.awea-tag {
				font-size: 10px;
				text-transform: uppercase;
				font-weight: 700;
				letter-spacing: 0.05em;
				color: var(--awea-text-muted);
			}

			.awea-switch {
				position: relative;
				display: inline-block;
				width: 44px;
				height: 24px;
			}
			.awea-switch input {
				opacity: 0;
				width: 0;
				height: 0;
			}
			.awea-slider {
				position: absolute;
				cursor: pointer;
				top: 0; left: 0; right: 0; bottom: 0;
				background-color: #cbd5e1;
				transition: 0.25s ease;
				border-radius: 24px;
			}
			.awea-slider:before {
				position: absolute;
				content: "";
				height: 18px;
				width: 18px;
				left: 3px;
				bottom: 3px;
				background-color: white;
				transition: 0.25s ease;
				border-radius: 50%;
				box-shadow: 0 1px 3px rgba(0,0,0,0.15);
			}
			.awea-switch input:checked + .awea-slider {
				background-color: var(--awea-primary);
			}
			.awea-switch input:checked + .awea-slider:before {
				transform: translateX(20px);
			}

			.awea-bottom-bar {
				position: sticky;
				bottom: 20px;
				background: rgba(255, 255, 255, 0.95);
				backdrop-filter: blur(10px);
				border: 1px solid var(--awea-border);
				border-radius: 12px;
				padding: 14px 24px;
				box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
				display: flex;
				justify-content: space-between;
				align-items: center;
				z-index: 100;
			}
			.awea-btn-save {
				background: var(--awea-primary) !important;
				border-color: var(--awea-primary) !important;
				color: #fff !important;
				font-weight: 600 !important;
				padding: 6px 24px !important;
				height: auto !important;
				font-size: 14px !important;
				border-radius: 8px !important;
				box-shadow: 0 4px 12px rgba(67, 56, 202, 0.3) !important;
				cursor: pointer;
			}

			.awea-health-table,
			.awea-templates-table {
				width: 100%;
				border-collapse: collapse;
			}
			.awea-health-table td,
			.awea-templates-table td,
			.awea-templates-table th {
				padding: 14px 12px;
				border-bottom: 1px solid var(--awea-border);
				font-size: 13px;
			}
			.awea-templates-table th {
				background: #f8fafc;
				font-weight: 700;
				color: var(--awea-text-dark);
				text-align: left;
			}
			.awea-health-table tr:last-child td,
			.awea-templates-table tr:last-child td {
				border-bottom: none;
			}
			.awea-health-badge {
				display: inline-block;
				padding: 2px 8px;
				border-radius: 4px;
				font-size: 11px;
				font-weight: 700;
			}
			.awea-health-pass { background: #dcfce7; color: #15803d; }
			.awea-health-warn { background: #fef3c7; color: #b45309; }

			.awea-btn-action {
				display: inline-flex;
				align-items: center;
				gap: 6px;
				background: var(--awea-primary);
				color: #ffffff !important;
				text-decoration: none;
				padding: 8px 18px;
				border-radius: 8px;
				font-size: 13px;
				font-weight: 600;
				box-shadow: 0 4px 12px rgba(67, 56, 202, 0.25);
				transition: background 0.2s ease;
			}
			.awea-btn-action:hover {
				background: var(--awea-primary-hover);
			}
		';

		wp_register_style( 'awea-admin-style', false, array(), defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0' );
		wp_enqueue_style( 'awea-admin-style' );
		wp_add_inline_style( 'awea-admin-style', $admin_ui_css );

		// Interactive Switcher Script
		if ( isset( $this->hook_suffixes['widgets'] ) && $hook === $this->hook_suffixes['widgets'] ) {
			$admin_js = "
				document.addEventListener('DOMContentLoaded', function() {
					var searchInput = document.getElementById('awea_widget_search');
					var cards = document.querySelectorAll('.awea-widget-card');
					var tabBtns = document.querySelectorAll('.awea-tab-btn');
					var toggleAll = document.getElementById('awea_toggle_all');
					var checkboxes = document.querySelectorAll('.awea-widgets-grid input[type=\"checkbox\"]');

					var activeCategory = 'all';
					tabBtns.forEach(function(btn) {
						btn.addEventListener('click', function() {
							tabBtns.forEach(function(b) { b.classList.remove('active'); });
							this.classList.add('active');
							activeCategory = this.getAttribute('data-tab');
							filterCards();
						});
					});

					if (searchInput) {
						searchInput.addEventListener('input', function() {
							filterCards();
						});
					}

					function filterCards() {
						var query = searchInput ? searchInput.value.toLowerCase().trim() : '';
						cards.forEach(function(card) {
							var name = card.getAttribute('data-name') || '';
							var cat = card.getAttribute('data-category') || '';
							var matchSearch = name.indexOf(query) !== -1;
							var matchTab = (activeCategory === 'all') || (cat === activeCategory);

							if (matchSearch && matchTab) {
								card.style.display = 'flex';
							} else {
								card.style.display = 'none';
							}
						});
					}

					if (toggleAll) {
						toggleAll.addEventListener('change', function() {
							checkboxes.forEach(function(cb) {
								cb.checked = toggleAll.checked;
							});
						});
					}
				});
			";
			wp_register_script( 'awea-admin-interactive', '', array(), defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0', true );
			wp_enqueue_script( 'awea-admin-interactive' );
			wp_add_inline_script( 'awea-admin-interactive', $admin_js );
		}
	}

	/**
	 * Render General Page.
	 */
	public function render_general_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$options        = get_option( 'awea_widgets_enabled', array() );
		$options        = is_array( $options ) ? $options : array();
		$total_widgets  = count( $this->widgets );
		$active_widgets = count( array_filter( $options ) );

		$php_version      = phpversion();
		$wp_version       = get_bloginfo( 'version' );
		$memory_limit     = ini_get( 'memory_limit' );
		$elementor_active = did_action( 'elementor/loaded' );
		?>
		<div class="wrap awea-dashboard">
			<div class="awea-hero">
				<div>
					<h1><?php esc_html_e( 'Awesome Widgets Dashboard', 'awesome-widgets-elementor' ); ?></h1>
					<p><?php esc_html_e( 'System performance overview, live module telemetry, and resources.', 'awesome-widgets-elementor' ); ?></p>
				</div>
				<div class="awea-pill-badge">
					<?php echo esc_html( 'v' . ( defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0' ) ); ?>
				</div>
			</div>

			<div class="awea-stats-strip">
				<div class="awea-stat-card">
					<span class="awea-stat-caption"><?php esc_html_e( 'Active Modules', 'awesome-widgets-elementor' ); ?></span>
					<span class="awea-stat-value" style="color: var(--awea-primary);"><?php echo esc_html( (string) $active_widgets ); ?> / <?php echo esc_html( (string) $total_widgets ); ?></span>
				</div>
				<div class="awea-stat-card">
					<span class="awea-stat-caption"><?php esc_html_e( 'Elementor Core', 'awesome-widgets-elementor' ); ?></span>
					<span class="awea-stat-value" style="color: <?php echo $elementor_active ? 'var(--awea-success)' : 'var(--awea-warning)'; ?>;">
						<?php echo $elementor_active ? esc_html__( 'Active', 'awesome-widgets-elementor' ) : esc_html__( 'Missing', 'awesome-widgets-elementor' ); ?>
					</span>
				</div>
				<div class="awea-stat-card">
					<span class="awea-stat-caption"><?php esc_html_e( 'PHP Allocation', 'awesome-widgets-elementor' ); ?></span>
					<span class="awea-stat-value"><?php echo esc_html( $memory_limit ); ?></span>
				</div>
			</div>

			<div style="display: flex; gap: 24px; flex-wrap: wrap;">
				<div style="flex: 1 1 55%; min-width: 320px;">
					<div class="awea-card">
						<h2 class="awea-card-title">
							<span class="dashicons dashicons-dashboard" style="color: var(--awea-primary);"></span>
							<?php esc_html_e( 'System Environment & Diagnostics', 'awesome-widgets-elementor' ); ?>
						</h2>
						<table class="awea-health-table">
							<tbody>
								<tr>
									<td><strong><?php esc_html_e( 'Elementor Status', 'awesome-widgets-elementor' ); ?></strong></td>
									<td style="text-align: right;">
										<?php if ( $elementor_active ) : ?>
											<span class="awea-health-badge awea-health-pass"><?php esc_html_e( 'Connected', 'awesome-widgets-elementor' ); ?></span>
										<?php else : ?>
											<span class="awea-health-badge awea-health-warn"><?php esc_html_e( 'Deactivated / Missing', 'awesome-widgets-elementor' ); ?></span>
										<?php endif; ?>
									</td>
								</tr>
								<tr>
									<td><strong><?php esc_html_e( 'PHP Version', 'awesome-widgets-elementor' ); ?></strong></td>
									<td style="text-align: right;">
										<?php echo esc_html( $php_version ); ?>
										<?php if ( version_compare( $php_version, '7.4', '>=' ) ) : ?>
											<span class="awea-health-badge awea-health-pass"><?php esc_html_e( 'Passed', 'awesome-widgets-elementor' ); ?></span>
										<?php else : ?>
											<span class="awea-health-badge awea-health-warn"><?php esc_html_e( 'Upgrade Recommended', 'awesome-widgets-elementor' ); ?></span>
										<?php endif; ?>
									</td>
								</tr>
								<tr>
									<td><strong><?php esc_html_e( 'WordPress Core', 'awesome-widgets-elementor' ); ?></strong></td>
									<td style="text-align: right;"><?php echo esc_html( $wp_version ); ?></td>
								</tr>
								<tr>
									<td><strong><?php esc_html_e( 'Max Execution Time', 'awesome-widgets-elementor' ); ?></strong></td>
									<td style="text-align: right;"><?php echo esc_html( ini_get( 'max_execution_time' ) . 's' ); ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div style="flex: 1 1 35%; min-width: 280px;">
					<div class="awea-card">
						<h2 class="awea-card-title">
							<span class="dashicons dashicons-sos" style="color: var(--awea-primary);"></span>
							<?php esc_html_e( 'Help & Documentation', 'awesome-widgets-elementor' ); ?>
						</h2>
						<ul style="list-style: none; padding: 0; margin: 0; line-height: 2.2; font-size: 13px;">
							<li><span class="dashicons dashicons-book-alt" style="margin-right: 6px; color: var(--awea-text-muted);"></span><a href="https://devnahian.com" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Read Documentation', 'awesome-widgets-elementor' ); ?></a></li>
							<li><span class="dashicons dashicons-format-video" style="margin-right: 6px; color: var(--awea-text-muted);"></span><a href="https://devnahian.com" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Video Tutorials', 'awesome-widgets-elementor' ); ?></a></li>
							<li><span class="dashicons dashicons-email" style="margin-right: 6px; color: var(--awea-text-muted);"></span><a href="mailto:nahiansylhet@gmail.com"><?php esc_html_e( 'Direct Developer Support', 'awesome-widgets-elementor' ); ?></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Widgets Page.
	 */
	public function render_widgets_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$options        = get_option( 'awea_widgets_enabled', array() );
		$options        = is_array( $options ) ? $options : array();
		$total_widgets  = count( $this->widgets );
		$active_widgets = count( array_filter( $options ) );
		?>
		<div class="wrap awea-dashboard">
			<div class="awea-hero">
				<div>
					<h1><?php esc_html_e( 'Widgets Manager', 'awesome-widgets-elementor' ); ?></h1>
					<p><?php esc_html_e( 'Activate or deactivate individual modules to reduce asset payload and optimize render speeds.', 'awesome-widgets-elementor' ); ?></p>
				</div>
				<div class="awea-pill-badge">
					<?php echo esc_html( (string) $active_widgets . ' / ' . (string) $total_widgets . ' Enabled' ); ?>
				</div>
			</div>

			<?php settings_errors( 'awesomeWidgets' ); ?>

			<div class="awea-tabs">
				<button type="button" class="awea-tab-btn active" data-tab="all"><?php esc_html_e( 'All Widgets', 'awesome-widgets-elementor' ); ?></button>
				<button type="button" class="awea-tab-btn" data-tab="creative"><?php esc_html_e( 'Creative & Content', 'awesome-widgets-elementor' ); ?></button>
				<button type="button" class="awea-tab-btn" data-tab="ecommerce"><?php esc_html_e( 'eCommerce', 'awesome-widgets-elementor' ); ?></button>
				<button type="button" class="awea-tab-btn" data-tab="media"><?php esc_html_e( 'Media & Sliders', 'awesome-widgets-elementor' ); ?></button>
				<button type="button" class="awea-tab-btn" data-tab="dynamic"><?php esc_html_e( 'Dynamic & Feed', 'awesome-widgets-elementor' ); ?></button>
			</div>

			<div class="awea-toolbar-bar">
				<div class="awea-search-container">
					<span class="dashicons dashicons-search"></span>
					<input type="text" id="awea_widget_search" placeholder="<?php esc_attr_e( 'Search widgets by name...', 'awesome-widgets-elementor' ); ?>" autocomplete="off" />
				</div>
				<div style="display: flex; align-items: center; gap: 12px;">
					<label class="awea-switch" for="awea_toggle_all">
						<input type="checkbox" id="awea_toggle_all" />
						<span class="awea-slider"></span>
					</label>
					<span style="font-weight: 600; font-size: 13px;"><?php esc_html_e( 'Toggle All', 'awesome-widgets-elementor' ); ?></span>
				</div>
			</div>

			<form action="options.php" method="post">
				<?php settings_fields( 'awesomeWidgets' ); ?>

				<ul class="awea-widgets-grid">
					<?php foreach ( $this->widgets as $widget ) : ?>
						<?php 
						$widget_slug = sanitize_key( $widget );
						$label       = ucwords( str_replace( array( '-', '_' ), ' ', $widget_slug ) );
						$category    = $this->get_widget_category( $widget_slug );
						$checked     = ! empty( $options[ $widget_slug ] );
						?>
						<li class="awea-widget-card" 
							data-name="<?php echo esc_attr( strtolower( $label ) ); ?>" 
							data-category="<?php echo esc_attr( $category ); ?>">
							<div class="awea-widget-meta">
								<span class="awea-widget-title"><?php echo esc_html( $label ); ?></span>
								<span class="awea-tag"><?php echo esc_html( $category ); ?></span>
							</div>
							<label class="awea-switch" for="awea_<?php echo esc_attr( $widget_slug ); ?>">
								<input type="checkbox"
									id="awea_<?php echo esc_attr( $widget_slug ); ?>"
									name="awea_widgets_enabled[<?php echo esc_attr( $widget_slug ); ?>]"
									value="1" 
									<?php checked( $checked, true ); ?> 
								/>
								<span class="awea-slider"></span>
							</label>
						</li>
					<?php endforeach; ?>
				</ul>

				<div class="awea-bottom-bar">
					<span style="font-size: 13px; color: var(--awea-text-muted);">
						<?php esc_html_e( 'Remember to save changes after modifying modules.', 'awesome-widgets-elementor' ); ?>
					</span>
					<?php submit_button( __( 'Save Changes', 'awesome-widgets-elementor' ), 'primary awea-btn-save', 'submit', false ); ?>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Render Header & Footer Builder Page directly.
	 */
	public function render_header_footer_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$header_count = 0;
		$footer_count = 0;

		if ( post_type_exists( 'awea_hf_template' ) ) {
			$header_count = (int) count(
				get_posts(
					array(
						'post_type'   => 'awea_hf_template',
						'meta_key'    => '_awea_hf_type',
						'meta_value'  => 'header',
						'post_status' => 'publish',
						'numberposts' => -1,
						'fields'      => 'ids',
					)
				)
			);

			$footer_count = (int) count(
				get_posts(
					array(
						'post_type'   => 'awea_hf_template',
						'meta_key'    => '_awea_hf_type',
						'meta_value'  => 'footer',
						'post_status' => 'publish',
						'numberposts' => -1,
						'fields'      => 'ids',
					)
				)
			);
		}

		$create_new_url = admin_url( 'post-new.php?post_type=awea_hf_template' );
		$view_all_url   = admin_url( 'edit.php?post_type=awea_hf_template' );
		?>
		<div class="wrap awea-dashboard">
			<div class="awea-hero">
				<div>
					<h1><?php esc_html_e( 'Header & Footer Builder', 'awesome-widgets-elementor' ); ?></h1>
					<p><?php esc_html_e( 'Build custom headers and footers with Elementor canvas and assign conditional display rules across your site.', 'awesome-widgets-elementor' ); ?></p>
				</div>
				<a href="<?php echo esc_url( $create_new_url ); ?>" class="awea-btn-action">
					<span class="dashicons dashicons-plus-alt2"></span>
					<?php esc_html_e( 'Add New Template', 'awesome-widgets-elementor' ); ?>
				</a>
			</div>

			<div class="awea-stats-strip">
				<div class="awea-stat-card">
					<span class="awea-stat-caption"><?php esc_html_e( 'Active Headers', 'awesome-widgets-elementor' ); ?></span>
					<span class="awea-stat-value" style="color: var(--awea-primary);"><?php echo esc_html( (string) $header_count ); ?></span>
				</div>
				<div class="awea-stat-card">
					<span class="awea-stat-caption"><?php esc_html_e( 'Active Footers', 'awesome-widgets-elementor' ); ?></span>
					<span class="awea-stat-value" style="color: var(--awea-accent);"><?php echo esc_html( (string) $footer_count ); ?></span>
				</div>
				<div class="awea-stat-card">
					<span class="awea-stat-caption"><?php esc_html_e( 'Theme Compatibility', 'awesome-widgets-elementor' ); ?></span>
					<span class="awea-stat-value" style="color: var(--awea-success);"><?php esc_html_e( 'Auto-Hooked', 'awesome-widgets-elementor' ); ?></span>
				</div>
			</div>

			<div class="awea-card">
				<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
					<h2 class="awea-card-title" style="margin: 0;">
						<span class="dashicons dashicons-layout" style="color: var(--awea-primary);"></span>
						<?php esc_html_e( 'Template Structure & Routing', 'awesome-widgets-elementor' ); ?>
					</h2>
					<a href="<?php echo esc_url( $view_all_url ); ?>" class="button button-secondary">
						<?php esc_html_e( 'Manage All Templates', 'awesome-widgets-elementor' ); ?>
					</a>
				</div>

				<table class="awea-templates-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Template Type', 'awesome-widgets-elementor' ); ?></th>
							<th><?php esc_html_e( 'Function', 'awesome-widgets-elementor' ); ?></th>
							<th><?php esc_html_e( 'Condition Scope', 'awesome-widgets-elementor' ); ?></th>
							<th><?php esc_html_e( 'Action', 'awesome-widgets-elementor' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><strong><?php esc_html_e( 'Header Layout', 'awesome-widgets-elementor' ); ?></strong></td>
							<td><?php esc_html_e( 'Replaces the default theme header using your custom Elementor layout.', 'awesome-widgets-elementor' ); ?></td>
							<td><span class="awea-health-badge awea-health-pass"><?php esc_html_e( 'Entire Site / Front Page / Pages', 'awesome-widgets-elementor' ); ?></span></td>
							<td><a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=awea_hf_template&type=header' ) ); ?>"><?php esc_html_e( 'Create Header', 'awesome-widgets-elementor' ); ?> &rarr;</a></td>
						</tr>
						<tr>
							<td><strong><?php esc_html_e( 'Footer Layout', 'awesome-widgets-elementor' ); ?></strong></td>
							<td><?php esc_html_e( 'Overrides theme footer template with responsive blocks, menus, and copyrights.', 'awesome-widgets-elementor' ); ?></td>
							<td><span class="awea-health-badge awea-health-pass"><?php esc_html_e( 'Entire Site / Posts / Archives', 'awesome-widgets-elementor' ); ?></span></td>
							<td><a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=awea_hf_template&type=footer' ) ); ?>"><?php esc_html_e( 'Create Footer', 'awesome-widgets-elementor' ); ?> &rarr;</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	}
}