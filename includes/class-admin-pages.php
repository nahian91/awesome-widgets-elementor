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
		add_action( 'admin_init', array( $this, 'handle_template_deletion' ) );
	}

	/**
	 * Register admin menu and submenus.
	 */
	public function add_admin_menu() {
		$this->hook_suffixes['main'] = add_menu_page(
			esc_html__( 'Awesome Widgets', 'awesome-widgets-elementor' ),
			esc_html__( 'Awesome Widgets', 'awesome-widgets-elementor' ),
			'manage_options',
			'awesome-widgets-elementor',
			array( $this, 'render_general_page' ),
			'dashicons-screenoptions',
			59
		);

		$this->hook_suffixes['general'] = add_submenu_page(
			'awesome-widgets-elementor',
			esc_html__( 'Dashboard & Health', 'awesome-widgets-elementor' ),
			esc_html__( 'Dashboard', 'awesome-widgets-elementor' ),
			'manage_options',
			'awesome-widgets-elementor',
			array( $this, 'render_general_page' )
		);

		$this->hook_suffixes['widgets'] = add_submenu_page(
			'awesome-widgets-elementor',
			esc_html__( 'Manage Widgets', 'awesome-widgets-elementor' ),
			esc_html__( 'Widgets Manager', 'awesome-widgets-elementor' ),
			'manage_options',
			'awesome-widgets-widgets',
			array( $this, 'render_widgets_page' )
		);

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
	 * Handle direct template deletion.
	 */
	public function handle_template_deletion() {
		if ( ! isset( $_GET['action'] ) || 'awea_delete_template' !== $_GET['action'] ) {
			return;
		}

		if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( $_GET['_wpnonce'] ), 'awea_delete_template_nonce' ) ) {
			wp_die( esc_html__( 'Security check failed.', 'awesome-widgets-elementor' ) );
		}

		if ( ! current_user_can( 'delete_posts' ) ) {
			wp_die( esc_html__( 'Unauthorized access.', 'awesome-widgets-elementor' ) );
		}

		$post_id = isset( $_GET['post_id'] ) ? absint( $_GET['post_id'] ) : 0;
		if ( $post_id && 'awea_hf_template' === get_post_type( $post_id ) ) {
			wp_delete_post( $post_id, true );
		}

		wp_safe_redirect( admin_url( 'admin.php?page=awesome-widgets-header-footer&deleted=1' ) );
		exit;
	}

	/**
	 * Enqueue assets on plugin screens.
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_admin_assets( $hook ) {
		if ( ! in_array( $hook, $this->hook_suffixes, true ) ) {
			return;
		}

		$admin_ui_css = '
			:root {
				--awea-primary: #4f46e5;
				--awea-primary-hover: #4338ca;
				--awea-accent: #0284c7;
				--awea-surface: #ffffff;
				--awea-background: #f8fafc;
				--awea-border: #e2e8f0;
				--awea-text-dark: #0f172a;
				--awea-text-muted: #64748b;
				--awea-success: #10b981;
				--awea-warning: #f59e0b;
				--awea-danger: #ef4444;
				--awea-whatsapp: #25d366;
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
				font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Segoe UI", Roboto, sans-serif;
				color: var(--awea-text-dark);
				-webkit-font-smoothing: antialiased;
			}

			/* Luxury Gradient Hero */
			.awea-hero {
				background: linear-gradient(135deg, #090d16 0%, #0f172a 50%, #1e1b4b 100%);
				border-radius: 24px;
				padding: 40px 44px;
				color: #ffffff;
				display: flex;
				justify-content: space-between;
				align-items: center;
				box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.1);
				margin-bottom: 28px;
				position: relative;
				overflow: hidden;
				border: 1px solid rgba(255, 255, 255, 0.08);
			}
			.awea-hero::before {
				content: "";
				position: absolute;
				top: -50%;
				right: -10%;
				width: 400px;
				height: 400px;
				background: radial-gradient(circle, rgba(79, 70, 229, 0.25) 0%, transparent 70%);
				pointer-events: none;
			}
			.awea-hero-content {
				position: relative;
				z-index: 2;
			}
			.awea-hero h1 {
				color: #ffffff;
				font-size: 30px;
				font-weight: 800;
				letter-spacing: -0.03em;
				margin: 0 0 8px 0;
				line-height: 1.2;
			}
			.awea-hero p {
				color: #94a3b8;
				font-size: 15px;
				margin: 0;
				max-width: 620px;
				line-height: 1.6;
			}
			.awea-hero-badge-wrap {
				display: flex;
				flex-direction: column;
				align-items: flex-end;
				gap: 10px;
				position: relative;
				z-index: 2;
			}
			.awea-pill-badge {
				background: rgba(255, 255, 255, 0.08);
				border: 1px solid rgba(255, 255, 255, 0.18);
				padding: 7px 18px;
				border-radius: 100px;
				font-size: 12px;
				font-weight: 700;
				letter-spacing: 0.06em;
				backdrop-filter: blur(12px);
				-webkit-backdrop-filter: blur(12px);
				color: #e2e8f0;
				display: inline-flex;
				align-items: center;
				gap: 8px;
			}
			.awea-pill-dot {
				width: 7px;
				height: 7px;
				border-radius: 50%;
				background: #22c55e;
				box-shadow: 0 0 10px rgba(34, 197, 94, 0.8);
			}

			/* Stat & Telemetry Strips */
			.awea-stats-strip {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
				gap: 18px;
				margin-bottom: 28px;
			}
			.awea-stat-card {
				background: var(--awea-surface);
				border: 1px solid var(--awea-border);
				border-radius: 18px;
				padding: 24px;
				display: flex;
				flex-direction: column;
				justify-content: space-between;
				box-shadow: 0 2px 4px rgba(0,0,0,0.02);
				transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s ease, border-color 0.25s ease;
				position: relative;
				overflow: hidden;
			}
			.awea-stat-card:hover {
				transform: translateY(-3px);
				border-color: #cbd5e1;
				box-shadow: 0 12px 25px -8px rgba(0, 0, 0, 0.08);
			}
			.awea-stat-head {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 12px;
			}
			.awea-stat-caption {
				font-size: 13px;
				color: var(--awea-text-muted);
				font-weight: 700;
				letter-spacing: 0.02em;
			}
			.awea-stat-icon-wrap {
				width: 36px;
				height: 36px;
				border-radius: 10px;
				display: flex;
				align-items: center;
				justify-content: center;
				background: #f8fafc;
				border: 1px solid var(--awea-border);
				color: var(--awea-primary);
			}
			.awea-stat-icon-wrap svg {
				width: 18px;
				height: 18px;
			}
			.awea-stat-value {
				font-size: 32px;
				font-weight: 800;
				line-height: 1.1;
				letter-spacing: -0.03em;
				margin-bottom: 12px;
			}
			.awea-progress-track {
				width: 100%;
				height: 5px;
				background: #f1f5f9;
				border-radius: 10px;
				overflow: hidden;
			}
			.awea-progress-fill {
				height: 100%;
				background: linear-gradient(90deg, var(--awea-primary), var(--awea-accent));
				border-radius: 10px;
				transition: width 0.5s ease;
			}

			/* Studio Quick Shortcuts Grid */
			.awea-shortcuts-grid {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
				gap: 16px;
				margin-bottom: 28px;
			}
			.awea-shortcut-card {
				background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
				border: 1px solid var(--awea-border);
				border-radius: 16px;
				padding: 22px;
				text-decoration: none;
				color: inherit;
				display: flex;
				align-items: center;
				gap: 16px;
				transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
			}
			.awea-shortcut-card:hover {
				border-color: var(--awea-primary);
				transform: translateY(-2px);
				box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.12);
			}
			.awea-shortcut-icon {
				width: 48px;
				height: 48px;
				border-radius: 14px;
				background: #ffffff;
				border: 1px solid var(--awea-border);
				display: flex;
				align-items: center;
				justify-content: center;
				color: var(--awea-primary);
				flex-shrink: 0;
				box-shadow: 0 4px 10px rgba(0,0,0,0.03);
			}
			.awea-shortcut-icon svg {
				width: 22px;
				height: 22px;
			}
			.awea-shortcut-text strong {
				display: block;
				font-size: 14.5px;
				font-weight: 700;
				color: var(--awea-text-dark);
				margin-bottom: 3px;
			}
			.awea-shortcut-text span {
				font-size: 12.5px;
				color: var(--awea-text-muted);
			}

			/* Luxury Cards */
			.awea-card {
				background: var(--awea-surface);
				border-radius: 20px;
				border: 1px solid var(--awea-border);
				padding: 30px;
				box-shadow: 0 1px 3px rgba(0,0,0,0.02);
				margin-bottom: 24px;
			}
			.awea-card-title {
				font-size: 17px;
				font-weight: 800;
				letter-spacing: -0.01em;
				margin: 0 0 20px 0;
				display: flex;
				align-items: center;
				gap: 10px;
			}

			/* Diagnostics List */
			.awea-diagnostics-table {
				width: 100%;
				border-collapse: collapse;
			}
			.awea-diagnostics-table tr {
				border-bottom: 1px solid var(--awea-border);
			}
			.awea-diagnostics-table tr:last-child {
				border-bottom: none;
			}
			.awea-diagnostics-table td {
				padding: 15px 0;
				font-size: 13.5px;
			}
			.awea-diag-label {
				font-weight: 700;
				color: #334155;
			}
			.awea-diag-val {
				text-align: right;
				font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
				font-size: 13px;
				color: #475569;
			}
			.awea-status-tag {
				display: inline-flex;
				align-items: center;
				gap: 5px;
				padding: 3px 10px;
				border-radius: 100px;
				font-size: 11px;
				font-weight: 700;
				letter-spacing: 0.03em;
				text-transform: uppercase;
			}
			.awea-status-pass {
				background: #dcfce7;
				color: #15803d;
				border: 1px solid #bbf7d0;
			}
			.awea-status-warn {
				background: #fef3c7;
				color: #b45309;
				border: 1px solid #fde68a;
			}

			/* Author / Support Contact Cards */
			.awea-contact-grid {
				display: flex;
				flex-direction: column;
				gap: 10px;
				margin-bottom: 20px;
			}
			.awea-contact-item {
				display: flex;
				align-items: center;
				justify-content: space-between;
				padding: 12px 16px;
				border-radius: 12px;
				border: 1px solid var(--awea-border);
				background: #f8fafc;
				text-decoration: none;
				color: #334155;
				font-size: 13px;
				font-weight: 600;
				transition: all 0.2s ease;
			}
			.awea-contact-item:hover {
				background: #ffffff;
				border-color: var(--awea-primary);
				color: var(--awea-primary);
				transform: translateX(3px);
				box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
			}
			.awea-contact-item.whatsapp:hover {
				border-color: var(--awea-whatsapp);
				color: #16a34a;
			}
			.awea-contact-left {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			.awea-contact-icon {
				width: 32px;
				height: 32px;
				border-radius: 8px;
				display: flex;
				align-items: center;
				justify-content: center;
				background: #ffffff;
				border: 1px solid var(--awea-border);
			}
			.awea-contact-icon svg {
				width: 16px;
				height: 16px;
			}

			/* Tabs */
			.awea-tabs {
				display: flex;
				gap: 10px;
				border-bottom: 2px solid var(--awea-border);
				margin-bottom: 24px;
			}
			.awea-tab-btn {
				background: none;
				border: none;
				padding: 12px 18px;
				font-size: 14px;
				font-weight: 700;
				color: var(--awea-text-muted);
				cursor: pointer;
				border-bottom: 2px solid transparent;
				margin-bottom: -2px;
				display: inline-flex;
				align-items: center;
				gap: 8px;
				transition: all 0.2s ease;
			}
			.awea-tab-btn:hover {
				color: var(--awea-primary);
			}
			.awea-tab-btn.active {
				color: var(--awea-primary);
				border-bottom-color: var(--awea-primary);
			}
			.awea-tab-count {
				background: #f1f5f9;
				color: #475569;
				font-size: 11px;
				font-weight: 800;
				padding: 2px 8px;
				border-radius: 100px;
			}
			.awea-tab-btn.active .awea-tab-count {
				background: #e0e7ff;
				color: #4338ca;
			}

			/* Toolbar & Search */
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
				outline: none;
				box-sizing: border-box;
			}
			.awea-search-container input:focus {
				border-color: var(--awea-primary) !important;
				background: #ffffff !important;
			}
			.awea-search-container .dashicons {
				position: absolute;
				left: 12px;
				top: 50%;
				transform: translateY(-50%);
				color: var(--awea-text-muted);
			}

			/* Widgets Grid */
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
				border-radius: 12px;
				padding: 18px 20px;
				display: flex;
				align-items: center;
				justify-content: space-between;
				transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
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
				font-weight: 700;
				color: var(--awea-text-dark);
			}
			.awea-tag {
				font-size: 10px;
				text-transform: uppercase;
				font-weight: 700;
				letter-spacing: 0.05em;
				color: var(--awea-text-muted);
			}

			/* Switch Component */
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
				font-weight: 700 !important;
				padding: 8px 24px !important;
				height: auto !important;
				font-size: 14px !important;
				border-radius: 8px !important;
				box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3) !important;
				cursor: pointer;
			}

			/* Table UI */
			.awea-templates-table {
				width: 100%;
				border-collapse: collapse;
			}
			.awea-templates-table th {
				background: #f8fafc;
				padding: 14px 16px;
				font-size: 12px;
				font-weight: 800;
				text-transform: uppercase;
				letter-spacing: 0.05em;
				color: #64748b;
				border-bottom: 1px solid var(--awea-border);
				text-align: left;
			}
			.awea-templates-table td {
				padding: 16px;
				border-bottom: 1px solid var(--awea-border);
				font-size: 14px;
				vertical-align: middle;
				transition: opacity 0.2s ease;
			}
			.awea-template-row.is-disabled td:not(.awea-col-switch) {
				opacity: 0.55;
			}

			.awea-table-switch {
				position: relative;
				display: inline-block;
				width: 40px;
				height: 22px;
			}
			.awea-table-switch input {
				opacity: 0;
				width: 0;
				height: 0;
			}
			.awea-table-slider {
				position: absolute;
				cursor: pointer;
				top: 0; left: 0; right: 0; bottom: 0;
				background-color: #cbd5e1;
				transition: 0.25s ease;
				border-radius: 22px;
			}
			.awea-table-slider:before {
				position: absolute;
				content: "";
				height: 16px;
				width: 16px;
				left: 3px;
				bottom: 3px;
				background-color: white;
				transition: 0.25s ease;
				border-radius: 50%;
				box-shadow: 0 1px 3px rgba(0,0,0,0.15);
			}
			.awea-table-switch input:checked + .awea-table-slider {
				background-color: var(--awea-primary);
			}
			.awea-table-switch input:checked + .awea-table-slider:before {
				transform: translateX(18px);
			}

			.awea-type-pill {
				display: inline-block;
				padding: 4px 10px;
				border-radius: 100px;
				font-size: 11px;
				font-weight: 800;
				text-transform: uppercase;
			}
			.awea-type-pill.header { background: #e0e7ff; color: #4338ca; }
			.awea-type-pill.footer { background: #e0f2fe; color: #0284c7; }

			.awea-rule-badge {
				display: inline-block;
				background: #f1f5f9;
				color: #334155;
				border: 1px solid #e2e8f0;
				padding: 3px 10px;
				border-radius: 6px;
				font-size: 12px;
				font-weight: 600;
			}

			.awea-code-tag {
				background: #f8fafc;
				border: 1px solid #e2e8f0;
				padding: 4px 8px;
				border-radius: 6px;
				font-size: 12px;
				font-family: monospace;
				color: #475569;
				user-select: all;
			}

			.awea-row-actions {
				display: flex;
				align-items: center;
				gap: 8px;
			}
			.awea-btn-edit {
				display: inline-flex;
				align-items: center;
				gap: 6px;
				background: var(--awea-primary);
				color: #ffffff !important;
				text-decoration: none;
				padding: 6px 14px;
				border-radius: 8px;
				font-size: 12px;
				font-weight: 700;
				transition: background 0.2s;
			}
			.awea-btn-edit:hover {
				background: var(--awea-primary-hover);
			}
			.awea-btn-del {
				color: #ef4444 !important;
				text-decoration: none;
				padding: 6px 10px;
				font-size: 12px;
				font-weight: 600;
				border-radius: 6px;
				transition: background 0.2s;
			}
			.awea-btn-del:hover {
				background: #fee2e2;
			}

			.awea-btn-action {
				display: inline-flex;
				align-items: center;
				gap: 6px;
				background: var(--awea-primary);
				color: #ffffff !important;
				text-decoration: none;
				padding: 10px 20px;
				border-radius: 10px;
				font-size: 13px;
				font-weight: 700;
				box-shadow: 0 4px 14px rgba(67, 56, 202, 0.3);
				cursor: pointer;
				border: none;
			}
		';

		wp_register_style( 'awea-admin-style', false, array(), defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0' );
		wp_enqueue_style( 'awea-admin-style' );
		wp_add_inline_style( 'awea-admin-style', $admin_ui_css );

		// Interactive client script for widgets manager
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
	 * Render General / Health Page (Dashboard).
	 */
	public function render_general_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$options        = get_option( 'awea_widgets_enabled', array() );
		$options        = is_array( $options ) ? $options : array();
		$total_widgets  = count( $this->widgets );
		$active_widgets = count( array_filter( $options ) );
		$percent_active = $total_widgets > 0 ? round( ( $active_widgets / $total_widgets ) * 100 ) : 0;

		$php_version      = phpversion();
		$wp_version       = get_bloginfo( 'version' );
		$memory_limit     = ini_get( 'memory_limit' );
		$elementor_active = did_action( 'elementor/loaded' );

		// Header / Footer telemetry
		$headers_count = 0;
		$footers_count = 0;
		if ( post_type_exists( 'awea_hf_template' ) ) {
			$headers_count = (int) count( get_posts( array( 'post_type' => 'awea_hf_template', 'meta_key' => '_awea_hf_type', 'meta_value' => 'header', 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids' ) ) );
			$footers_count = (int) count( get_posts( array( 'post_type' => 'awea_hf_template', 'meta_key' => '_awea_hf_type', 'meta_value' => 'footer', 'post_status' => 'publish', 'numberposts' => -1, 'fields' => 'ids' ) ) );
		}
		?>
		<div class="wrap awea-dashboard">
			
			<!-- Hero Header -->
			<div class="awea-hero">
				<div class="awea-hero-content">
					<h1><?php esc_html_e( 'Awesome Widgets Studio', 'awesome-widgets-elementor' ); ?></h1>
					<p><?php esc_html_e( 'High-performance design architecture, modular widgets manager, and full-site layout orchestration.', 'awesome-widgets-elementor' ); ?></p>
				</div>
				<div class="awea-hero-badge-wrap">
					<div class="awea-pill-badge">
						<span class="awea-pill-dot"></span>
						<?php echo esc_html( 'v' . ( defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0' ) ); ?>
					</div>
				</div>
			</div>

			<!-- Quick Studio Shortcuts -->
			<div class="awea-shortcuts-grid">
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=awesome-widgets-header-footer' ) ); ?>" class="awea-shortcut-card">
					<div class="awea-shortcut-icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="3" y1="15" x2="21" y2="15"></line></svg>
					</div>
					<div class="awea-shortcut-text">
						<strong><?php esc_html_e( 'Header & Footer Builder', 'awesome-widgets-elementor' ); ?></strong>
						<span><?php echo esc_html( (string) ( $headers_count + $footers_count ) . ' Templates Configured' ); ?></span>
					</div>
				</a>

				<a href="<?php echo esc_url( admin_url( 'admin.php?page=awesome-widgets-widgets' ) ); ?>" class="awea-shortcut-card">
					<div class="awea-shortcut-icon" style="color: var(--awea-accent);">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
					</div>
					<div class="awea-shortcut-text">
						<strong><?php esc_html_e( 'Widgets Manager', 'awesome-widgets-elementor' ); ?></strong>
						<span><?php echo esc_html( (string) $active_widgets . ' of ' . (string) $total_widgets . ' Modules Active' ); ?></span>
					</div>
				</a>

				<div class="awea-shortcut-card" style="cursor: default;">
					<div class="awea-shortcut-icon" style="color: var(--awea-success);">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
					</div>
					<div class="awea-shortcut-text">
						<strong><?php esc_html_e( 'System Engine Status', 'awesome-widgets-elementor' ); ?></strong>
						<span><?php echo $elementor_active ? esc_html__( 'All Systems Operational', 'awesome-widgets-elementor' ) : esc_html__( 'Elementor Core Required', 'awesome-widgets-elementor' ); ?></span>
					</div>
				</div>
			</div>

			<!-- Telemetry Strips -->
			<div class="awea-stats-strip">
				<div class="awea-stat-card">
					<div class="awea-stat-head">
						<span class="awea-stat-caption"><?php esc_html_e( 'MODULES ACTIVE', 'awesome-widgets-elementor' ); ?></span>
						<div class="awea-stat-icon-wrap">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
						</div>
					</div>
					<div class="awea-stat-value" style="color: var(--awea-primary);">
						<?php echo esc_html( (string) $active_widgets ); ?> <span style="font-size: 18px; color: var(--awea-text-muted); font-weight: 600;">/ <?php echo esc_html( (string) $total_widgets ); ?></span>
					</div>
					<div class="awea-progress-track">
						<div class="awea-progress-fill" style="width: <?php echo esc_attr( (string) $percent_active ); ?>%;"></div>
					</div>
				</div>

				<div class="awea-stat-card">
					<div class="awea-stat-head">
						<span class="awea-stat-caption"><?php esc_html_e( 'BUILDER CORE', 'awesome-widgets-elementor' ); ?></span>
						<div class="awea-stat-icon-wrap" style="color: var(--awea-accent);">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1 4-10z"></path></svg>
						</div>
					</div>
					<div class="awea-stat-value" style="color: <?php echo $elementor_active ? 'var(--awea-success)' : 'var(--awea-danger)'; ?>;">
						<?php echo $elementor_active ? esc_html__( 'Connected', 'awesome-widgets-elementor' ) : esc_html__( 'Missing', 'awesome-widgets-elementor' ); ?>
					</div>
					<div style="font-size: 13px; color: var(--awea-text-muted);">
						<?php echo $elementor_active ? esc_html__( 'Visual Canvas Engine Hooked', 'awesome-widgets-elementor' ) : esc_html__( 'Please activate Elementor plugin', 'awesome-widgets-elementor' ); ?>
					</div>
				</div>

				<div class="awea-stat-card">
					<div class="awea-stat-head">
						<span class="awea-stat-caption"><?php esc_html_e( 'PHP MEMORY LIMIT', 'awesome-widgets-elementor' ); ?></span>
						<div class="awea-stat-icon-wrap" style="color: var(--awea-warning);">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
						</div>
					</div>
					<div class="awea-stat-value">
						<?php echo esc_html( $memory_limit ); ?>
					</div>
					<div style="font-size: 13px; color: var(--awea-text-muted);">
						<?php esc_html_e( 'Recommended: 256M or higher', 'awesome-widgets-elementor' ); ?>
					</div>
				</div>
			</div>

			<!-- Environment Diagnostics & Developer Contacts -->
			<div style="display: flex; gap: 24px; flex-wrap: wrap;">
				
				<!-- Left Column: Health Checks -->
				<div style="flex: 1 1 58%; min-width: 320px;">
					<div class="awea-card">
						<h2 class="awea-card-title">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px; height:20px; color:var(--awea-primary);"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
							<?php esc_html_e( 'System Diagnostics & Server Health', 'awesome-widgets-elementor' ); ?>
						</h2>
						<table class="awea-diagnostics-table">
							<tbody>
								<tr>
									<td class="awea-diag-label"><?php esc_html_e( 'Elementor Page Builder', 'awesome-widgets-elementor' ); ?></td>
									<td class="awea-diag-val">
										<?php if ( $elementor_active ) : ?>
											<span class="awea-status-tag awea-status-pass"><?php esc_html_e( 'Connected', 'awesome-widgets-elementor' ); ?></span>
										<?php else : ?>
											<span class="awea-status-tag awea-status-warn"><?php esc_html_e( 'Deactivated', 'awesome-widgets-elementor' ); ?></span>
										<?php endif; ?>
									</td>
								</tr>
								<tr>
									<td class="awea-diag-label"><?php esc_html_e( 'PHP Environment Version', 'awesome-widgets-elementor' ); ?></td>
									<td class="awea-diag-val">
										<?php echo esc_html( $php_version ); ?>
										<?php if ( version_compare( $php_version, '7.4', '>=' ) ) : ?>
											<span class="awea-status-tag awea-status-pass" style="margin-left:6px;"><?php esc_html_e( 'Passed', 'awesome-widgets-elementor' ); ?></span>
										<?php else : ?>
											<span class="awea-status-tag awea-status-warn" style="margin-left:6px;"><?php esc_html_e( 'Upgrade Advised', 'awesome-widgets-elementor' ); ?></span>
										<?php endif; ?>
									</td>
								</tr>
								<tr>
									<td class="awea-diag-label"><?php esc_html_e( 'WordPress Core Version', 'awesome-widgets-elementor' ); ?></td>
									<td class="awea-diag-val"><?php echo esc_html( $wp_version ); ?></td>
								</tr>
								<tr>
									<td class="awea-diag-label"><?php esc_html_e( 'Max Execution Time', 'awesome-widgets-elementor' ); ?></td>
									<td class="awea-diag-val"><?php echo esc_html( ini_get( 'max_execution_time' ) . 's' ); ?></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="awea-card">
						<h2 class="awea-card-title">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px; height:20px; color:var(--awea-accent);"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
							<?php esc_html_e( 'Visual Canvas Workflow Guide', 'awesome-widgets-elementor' ); ?>
						</h2>
						<p style="color: var(--awea-text-muted); line-height: 1.65; font-size: 14px; margin: 0 0 12px 0;">
							<?php esc_html_e( 'All active modules are directly injected into Elementor visual canvas. Open any page or template, search for "Awesome" inside the widget panel, and drag your selected widgets directly onto your design.', 'awesome-widgets-elementor' ); ?>
						</p>
						<p style="color: var(--awea-text-muted); line-height: 1.65; font-size: 14px; margin: 0;">
							<?php esc_html_e( 'Unneeded widgets can be toggled off inside the Widgets Manager to strip unused CSS and JS payloads from rendering on frontend requests.', 'awesome-widgets-elementor' ); ?>
						</p>
					</div>
				</div>

				<!-- Right Column: Developer Info & Contacts -->
				<div style="flex: 1 1 34%; min-width: 280px;">
					<div class="awea-card">
						<h2 class="awea-card-title">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:20px; height:20px; color:var(--awea-primary);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
							<?php esc_html_e( 'Developer & Direct Support', 'awesome-widgets-elementor' ); ?>
						</h2>

						<div class="awea-contact-grid">
							<!-- Website -->
							<a href="https://devnahian.com" target="_blank" rel="noopener noreferrer" class="awea-contact-item">
								<div class="awea-contact-left">
									<div class="awea-contact-icon" style="color: #4f46e5;">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
									</div>
									<div>
										<strong style="display:block; font-size:13.5px;"><?php esc_html_e( 'Official Website', 'awesome-widgets-elementor' ); ?></strong>
										<span style="font-size:12px; color:#64748b;">devnahian.com</span>
									</div>
								</div>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px; height:14px; color:#94a3b8;"><polyline points="9 18 15 12 9 6"></polyline></svg>
							</a>

							<!-- Email -->
							<a href="mailto:nahiansylhet@gmail.com" class="awea-contact-item">
								<div class="awea-contact-left">
									<div class="awea-contact-icon" style="color: #ea4335;">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
									</div>
									<div>
										<strong style="display:block; font-size:13.5px;"><?php esc_html_e( 'Email Support', 'awesome-widgets-elementor' ); ?></strong>
										<span style="font-size:12px; color:#64748b;">nahiansylhet@gmail.com</span>
									</div>
								</div>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px; height:14px; color:#94a3b8;"><polyline points="9 18 15 12 9 6"></polyline></svg>
							</a>

							<!-- WhatsApp -->
							<a href="https://wa.me/8801700000000" target="_blank" rel="noopener noreferrer" class="awea-contact-item whatsapp">
								<div class="awea-contact-left">
									<div class="awea-contact-icon" style="color: #25d366;">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
									</div>
									<div>
										<strong style="display:block; font-size:13.5px;"><?php esc_html_e( 'Direct WhatsApp', 'awesome-widgets-elementor' ); ?></strong>
										<span style="font-size:12px; color:#64748b;"><?php esc_html_e( 'Instant Chat Support', 'awesome-widgets-elementor' ); ?></span>
									</div>
								</div>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px; height:14px; color:#94a3b8;"><polyline points="9 18 15 12 9 6"></polyline></svg>
							</a>
						</div>

						<p style="font-size:12px; color:#94a3b8; line-height:1.5; margin:0; text-align:center;">
							<?php esc_html_e( 'Need custom widgets or agency solutions? Feel free to reach out directly.', 'awesome-widgets-elementor' ); ?>
						</p>
					</div>
				</div>

			</div>
		</div>
		<?php
	}

	/**
	 * Render Widgets Management Page.
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
				<div class="awea-hero-content">
					<h1><?php esc_html_e( 'Widgets Manager', 'awesome-widgets-elementor' ); ?></h1>
					<p><?php esc_html_e( 'Activate or deactivate individual modules to reduce asset payload and optimize render speeds.', 'awesome-widgets-elementor' ); ?></p>
				</div>
				<div class="awea-hero-badge-wrap">
					<div class="awea-pill-badge">
						<?php echo esc_html( (string) $active_widgets . ' / ' . (string) $total_widgets . ' Enabled' ); ?>
					</div>
				</div>
			</div>

			<?php settings_errors( 'awesomeWidgets' ); ?>

			<!-- Category Tabs -->
			<div class="awea-tabs">
				<button type="button" class="awea-tab-btn active" data-tab="all"><?php esc_html_e( 'All Widgets', 'awesome-widgets-elementor' ); ?></button>
				<button type="button" class="awea-tab-btn" data-tab="creative"><?php esc_html_e( 'Creative & Content', 'awesome-widgets-elementor' ); ?></button>
				<button type="button" class="awea-tab-btn" data-tab="ecommerce"><?php esc_html_e( 'eCommerce', 'awesome-widgets-elementor' ); ?></button>
				<button type="button" class="awea-tab-btn" data-tab="media"><?php esc_html_e( 'Media & Sliders', 'awesome-widgets-elementor' ); ?></button>
				<button type="button" class="awea-tab-btn" data-tab="dynamic"><?php esc_html_e( 'Dynamic & Feed', 'awesome-widgets-elementor' ); ?></button>
			</div>

			<!-- Search & Global Toggle Bar -->
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
					<span style="font-weight: 700; font-size: 13px;"><?php esc_html_e( 'Toggle All', 'awesome-widgets-elementor' ); ?></span>
				</div>
			</div>

			<!-- Main Submission Form -->
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

				<!-- Floating Bottom Action Bar -->
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
	 * Render Header & Footer Builder Page with Active Status Switches.
	 */
	public function render_header_footer_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$templates = get_posts(
			array(
				'post_type'      => 'awea_hf_template',
				'post_status'    => array( 'publish', 'draft' ),
				'posts_per_page' => -1,
				'orderby'        => 'date',
				'order'          => 'DESC',
			)
		);

		$headers_count = 0;
		$footers_count = 0;

		foreach ( $templates as $t ) {
			$type = get_post_meta( $t->ID, '_awea_hf_type', true );
			if ( 'footer' === $type ) {
				$footers_count++;
			} else {
				$headers_count++;
			}
		}

		$total_count = count( $templates );
		$ajax_nonce  = wp_create_nonce( 'awea_template_toggle_nonce' );
		?>
		<div class="wrap awea-dashboard">
			<div class="awea-hero">
				<div class="awea-hero-content">
					<h1><?php esc_html_e( 'Header & Footer Builder', 'awesome-widgets-elementor' ); ?></h1>
					<p><?php esc_html_e( 'Design custom headers and footers with Elementor canvas and toggle them active/inactive instantly.', 'awesome-widgets-elementor' ); ?></p>
				</div>
				<button type="button" class="awea-btn-action" onclick="aweaOpenQuickModal()">
					<span class="dashicons dashicons-plus-alt2"></span>
					<?php esc_html_e( 'Add New Template', 'awesome-widgets-elementor' ); ?>
				</button>
			</div>

			<!-- Counters -->
			<div class="awea-stats-strip">
				<div class="awea-stat-card">
					<div class="awea-stat-head">
						<span class="awea-stat-caption"><?php esc_html_e( 'HEADERS', 'awesome-widgets-elementor' ); ?></span>
					</div>
					<div class="awea-stat-value" style="color: var(--awea-primary);"><?php echo esc_html( (string) $headers_count ); ?></div>
				</div>
				<div class="awea-stat-card">
					<div class="awea-stat-head">
						<span class="awea-stat-caption"><?php esc_html_e( 'FOOTERS', 'awesome-widgets-elementor' ); ?></span>
					</div>
					<div class="awea-stat-value" style="color: var(--awea-accent);"><?php echo esc_html( (string) $footers_count ); ?></div>
				</div>
				<div class="awea-stat-card">
					<div class="awea-stat-head">
						<span class="awea-stat-caption"><?php esc_html_e( 'TOTAL TEMPLATES', 'awesome-widgets-elementor' ); ?></span>
					</div>
					<div class="awea-stat-value" style="color: var(--awea-success);"><?php echo esc_html( (string) $total_count ); ?></div>
				</div>
			</div>

			<!-- Template Table with Switch Column -->
			<div class="awea-card">
				<div class="awea-tabs">
					<button type="button" class="awea-tab-btn active" onclick="aweaFilterTemplates('all', this)">
						<?php esc_html_e( 'All Templates', 'awesome-widgets-elementor' ); ?>
						<span class="awea-tab-count"><?php echo esc_html( (string) $total_count ); ?></span>
					</button>
					<button type="button" class="awea-tab-btn" onclick="aweaFilterTemplates('header', this)">
						<?php esc_html_e( 'Headers', 'awesome-widgets-elementor' ); ?>
						<span class="awea-tab-count"><?php echo esc_html( (string) $headers_count ); ?></span>
					</button>
					<button type="button" class="awea-tab-btn" onclick="aweaFilterTemplates('footer', this)">
						<?php esc_html_e( 'Footers', 'awesome-widgets-elementor' ); ?>
						<span class="awea-tab-count"><?php echo esc_html( (string) $footers_count ); ?></span>
					</button>
				</div>

				<?php if ( ! empty( $templates ) ) : ?>
					<table class="awea-templates-table">
						<thead>
							<tr>
								<th style="width: 70px;"><?php esc_html_e( 'Status', 'awesome-widgets-elementor' ); ?></th>
								<th><?php esc_html_e( 'Template Title', 'awesome-widgets-elementor' ); ?></th>
								<th><?php esc_html_e( 'Type', 'awesome-widgets-elementor' ); ?></th>
								<th><?php esc_html_e( 'Display Rule', 'awesome-widgets-elementor' ); ?></th>
								<th><?php esc_html_e( 'Shortcode', 'awesome-widgets-elementor' ); ?></th>
								<th style="text-align: right;"><?php esc_html_e( 'Actions', 'awesome-widgets-elementor' ); ?></th>
							</tr>
						</thead>
						<tbody id="awea_templates_rows">
							<?php foreach ( $templates as $template ) : ?>
								<?php
								$type      = get_post_meta( $template->ID, '_awea_hf_type', true );
								$type      = ! empty( $type ) ? $type : 'header';
								$condition = get_post_meta( $template->ID, '_awea_hf_condition', true );

								$status_meta = get_post_meta( $template->ID, '_awea_template_status', true );
								$is_active   = '0' !== $status_meta;

								$condition_labels = array(
									'entire_site'   => esc_html__( 'Entire Website', 'awesome-widgets-elementor' ),
									'front_page'    => esc_html__( 'Homepage Only', 'awesome-widgets-elementor' ),
									'singular_page' => esc_html__( 'All Pages', 'awesome-widgets-elementor' ),
									'singular_post' => esc_html__( 'All Blog Posts', 'awesome-widgets-elementor' ),
									'archive'       => esc_html__( 'All Archives', 'awesome-widgets-elementor' ),
									'not_found_404' => esc_html__( '404 Error Page', 'awesome-widgets-elementor' ),
								);

								$edit_url   = admin_url( 'post.php?post=' . $template->ID . '&action=elementor' );
								$delete_url = wp_nonce_url(
									admin_url( 'admin.php?page=awesome-widgets-header-footer&action=awea_delete_template&post_id=' . $template->ID ),
									'awea_delete_template_nonce'
								);
								?>
								<tr class="awea-template-row <?php echo $is_active ? '' : 'is-disabled'; ?>" data-type="<?php echo esc_attr( $type ); ?>" id="awea-row-<?php echo esc_attr( (string) $template->ID ); ?>">
									<td class="awea-col-switch">
										<label class="awea-table-switch" title="<?php esc_attr_e( 'Enable or Disable this template', 'awesome-widgets-elementor' ); ?>">
											<input type="checkbox" 
												onchange="aweaToggleStatus(<?php echo esc_attr( (string) $template->ID ); ?>, this)" 
												<?php checked( $is_active, true ); ?> 
											/>
											<span class="awea-table-slider"></span>
										</label>
									</td>

									<td>
										<strong><a href="<?php echo esc_url( $edit_url ); ?>"><?php echo esc_html( $template->post_title ); ?></a></strong>
										<?php if ( 'draft' === $template->post_status ) : ?>
											<span style="color:#eab308; font-size:11px; margin-left:6px;">— <?php esc_html_e( 'Draft', 'awesome-widgets-elementor' ); ?></span>
										<?php endif; ?>
									</td>

									<td>
										<span class="awea-type-pill <?php echo esc_attr( $type ); ?>">
											<?php echo esc_html( ucfirst( $type ) ); ?>
										</span>
									</td>

									<td>
										<span class="awea-rule-badge">
											<?php echo esc_html( isset( $condition_labels[ $condition ] ) ? $condition_labels[ $condition ] : $condition_labels['entire_site'] ); ?>
										</span>
									</td>

									<td>
										<span class="awea-code-tag">[awea_template id="<?php echo esc_attr( (string) $template->ID ); ?>"]</span>
									</td>

									<td style="text-align: right;">
										<div class="awea-row-actions" style="justify-content: flex-end;">
											<a href="<?php echo esc_url( $edit_url ); ?>" class="awea-btn-edit">
												<span class="dashicons dashicons-edit"></span>
												<?php esc_html_e( 'Edit', 'awesome-widgets-elementor' ); ?>
											</a>
											<a href="<?php echo esc_url( $delete_url ); ?>" class="awea-btn-del" onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to delete this template?', 'awesome-widgets-elementor' ); ?>')">
												<?php esc_html_e( 'Delete', 'awesome-widgets-elementor' ); ?>
											</a>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else : ?>
					<p><?php esc_html_e( 'No templates found.', 'awesome-widgets-elementor' ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		<!-- Live AJAX Switch Script -->
		<script>
			function aweaFilterTemplates(type, btn) {
				var tabs = document.querySelectorAll('.awea-tab-btn');
				tabs.forEach(function(b) { b.classList.remove('active'); });
				btn.classList.add('active');

				var rows = document.querySelectorAll('.awea-template-row');
				rows.forEach(function(row) {
					var rowType = row.getAttribute('data-type');
					row.style.display = (type === 'all' || rowType === type) ? '' : 'none';
				});
			}

			function aweaToggleStatus(postId, checkbox) {
				var row = document.getElementById('awea-row-' + postId);
				var isChecked = checkbox.checked ? '1' : '0';

				if (row) {
					if (checkbox.checked) {
						row.classList.remove('is-disabled');
					} else {
						row.classList.add('is-disabled');
					}
				}

				var data = new FormData();
				data.append('action', 'awea_toggle_template_status');
				data.append('post_id', postId);
				data.append('status', isChecked);
				data.append('security', '<?php echo esc_js( $ajax_nonce ); ?>');

				fetch(ajaxurl, {
					method: 'POST',
					body: data
				})
				.then(function(res) { return res.json(); })
				.then(function(res) {
					if (!res.success) {
						alert(res.data && res.data.message ? res.data.message : 'Error updating status.');
						checkbox.checked = !checkbox.checked;
					}
				})
				.catch(function(err) {
					alert('Network error while updating status.');
					checkbox.checked = !checkbox.checked;
				});
			}
		</script>
		<?php
	}
}