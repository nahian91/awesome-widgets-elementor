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

			.awea-card {
				background: var(--awea-surface);
				border-radius: 16px;
				border: 1px solid var(--awea-border);
				padding: 28px;
				box-shadow: 0 1px 3px rgba(0,0,0,0.02);
				margin-bottom: 24px;
			}

			.awea-stats-strip {
				display: grid;
				grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
				gap: 16px;
				margin-bottom: 28px;
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

			/* Table */
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

			/* Table Toggle Switch */
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

			/* Badges & Buttons */
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
	}

	/**
	 * Render General / Health Page.
	 */
	public function render_general_page() {
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
					<h1><?php esc_html_e( 'Awesome Widgets Dashboard', 'awesome-widgets-elementor' ); ?></h1>
					<p><?php esc_html_e( 'System performance overview, live module telemetry, and resources.', 'awesome-widgets-elementor' ); ?></p>
				</div>
			</div>
			<div class="awea-stats-strip">
				<div class="awea-stat-card">
					<span class="awea-stat-caption"><?php esc_html_e( 'Active Modules', 'awesome-widgets-elementor' ); ?></span>
					<span class="awea-stat-value" style="color: var(--awea-primary);"><?php echo esc_html( (string) $active_widgets ); ?> / <?php echo esc_html( (string) $total_widgets ); ?></span>
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
		// Renders Widgets Manager
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
				<div>
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
					<span class="awea-stat-caption"><?php esc_html_e( 'Headers', 'awesome-widgets-elementor' ); ?></span>
					<span class="awea-stat-value" style="color: var(--awea-primary);"><?php echo esc_html( (string) $headers_count ); ?></span>
				</div>
				<div class="awea-stat-card">
					<span class="awea-stat-caption"><?php esc_html_e( 'Footers', 'awesome-widgets-elementor' ); ?></span>
					<span class="awea-stat-value" style="color: var(--awea-accent);"><?php echo esc_html( (string) $footers_count ); ?></span>
				</div>
				<div class="awea-stat-card">
					<span class="awea-stat-caption"><?php esc_html_e( 'Total Templates', 'awesome-widgets-elementor' ); ?></span>
					<span class="awea-stat-value" style="color: var(--awea-success);"><?php echo esc_html( (string) $total_count ); ?></span>
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

								// Status switch: defaults to active (1) unless explicitly disabled (0)
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
									<!-- Enable/Disable Switch -->
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