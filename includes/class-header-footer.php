<?php
/**
 * Professional Header & Footer Builder Engine.
 *
 * @package AwesomeWidgetsElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class AWEA_Header_Footer
 */
class AWEA_Header_Footer {

	/**
	 * Post type slug.
	 */
	const POST_TYPE = 'awea_hf_template';

	/**
	 * Active header template ID.
	 *
	 * @var int|null
	 */
	private static $active_header_id = null;

	/**
	 * Active footer template ID.
	 *
	 * @var int|null
	 */
	private static $active_footer_id = null;

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Post type registration & Elementor compatibility
		add_action( 'init', array( $this, 'register_post_type' ), 5 );
		add_action( 'elementor/init', array( $this, 'add_elementor_support' ) );

		// Canvas template loader for Elementor editor preview
		add_filter( 'template_include', array( $this, 'template_include_canvas' ), 99 );

		// Admin UI & Quick Create Modal
		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_action( 'save_post_' . self::POST_TYPE, array( $this, 'save_meta_boxes' ) );
		add_action( 'admin_footer', array( $this, 'render_admin_quick_create_modal' ) );
		add_action( 'admin_init', array( $this, 'handle_quick_create_submission' ) );

		// Custom admin columns
		add_filter( 'manage_' . self::POST_TYPE . '_posts_columns', array( $this, 'register_admin_columns' ) );
		add_action( 'manage_' . self::POST_TYPE . '_posts_custom_column', array( $this, 'render_admin_column_content' ), 10, 2 );

		// Shortcode support: [awea_template id="123"]
		add_shortcode( 'awea_template', array( $this, 'render_template_shortcode' ) );

		// Frontend template detection
		add_action( 'wp', array( $this, 'setup_active_templates' ) );

		// Block Theme (FSE) Compatibility: Replace core/template-part blocks
		add_filter( 'render_block', array( $this, 'filter_block_template_parts' ), 10, 2 );

		// Classic Theme Replacement Hooks
		add_action( 'wp_body_open', array( $this, 'render_header' ), 1 );
		add_action( 'wp_footer', array( $this, 'render_footer' ), 50 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_assets' ) );
	}

	/**
	 * Register the Custom Post Type.
	 */
	public function register_post_type() {
		$labels = array(
			'name'               => esc_html__( 'Header & Footer Templates', 'awesome-widgets-elementor' ),
			'singular_name'      => esc_html__( 'Template', 'awesome-widgets-elementor' ),
			'add_new'            => esc_html__( 'Add New Template', 'awesome-widgets-elementor' ),
			'add_new_item'       => esc_html__( 'Add New Template', 'awesome-widgets-elementor' ),
			'edit_item'          => esc_html__( 'Edit Template', 'awesome-widgets-elementor' ),
			'new_item'           => esc_html__( 'New Template', 'awesome-widgets-elementor' ),
			'view_item'          => esc_html__( 'View Template', 'awesome-widgets-elementor' ),
			'search_items'       => esc_html__( 'Search Templates', 'awesome-widgets-elementor' ),
			'not_found'          => esc_html__( 'No templates found', 'awesome-widgets-elementor' ),
			'not_found_in_trash' => esc_html__( 'No templates found in Trash', 'awesome-widgets-elementor' ),
			'menu_name'          => esc_html__( 'AWEA Templates', 'awesome-widgets-elementor' ),
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'hierarchical'        => false,
			'query_var'           => true,
			'has_archive'         => false,
			'rewrite'             => array(
				'slug'       => 'awea-template',
				'with_front' => false,
			),
			'supports'            => array( 'title', 'elementor' ),
		);

		register_post_type( self::POST_TYPE, $args );
	}

	/**
	 * Explicitly add Elementor builder support to the post type.
	 */
	public function add_elementor_support() {
		add_post_type_support( self::POST_TYPE, 'elementor' );
	}

	/**
	 * Force Elementor canvas template when previewing/editing the template directly.
	 *
	 * @param string $template Current template file.
	 * @return string
	 */
	public function template_include_canvas( $template ) {
		if ( is_singular( self::POST_TYPE ) ) {
			if ( defined( 'ELEMENTOR_PATH' ) && file_exists( ELEMENTOR_PATH . 'modules/page-templates/templates/canvas.php' ) ) {
				return ELEMENTOR_PATH . 'modules/page-templates/templates/canvas.php';
			}
		}
		return $template;
	}

	/**
	 * Register Custom Admin Columns.
	 *
	 * @param array $columns Existing columns.
	 * @return array
	 */
	public function register_admin_columns( $columns ) {
		return array(
			'cb'              => $columns['cb'],
			'title'           => $columns['title'],
			'awea_type'       => esc_html__( 'Type', 'awesome-widgets-elementor' ),
			'awea_conditions' => esc_html__( 'Display Rule', 'awesome-widgets-elementor' ),
			'awea_roles'      => esc_html__( 'Visibility', 'awesome-widgets-elementor' ),
			'awea_shortcode'  => esc_html__( 'Shortcode', 'awesome-widgets-elementor' ),
			'date'            => $columns['date'],
		);
	}

	/**
	 * Output Admin Column Content.
	 *
	 * @param string $column  Column key.
	 * @param int    $post_id Post ID.
	 */
	public function render_admin_column_content( $column, $post_id ) {
		switch ( $column ) {
			case 'awea_type':
				$type  = get_post_meta( $post_id, '_awea_hf_type', true );
				$type  = ! empty( $type ) ? ucfirst( $type ) : esc_html__( 'Header', 'awesome-widgets-elementor' );
				$color = 'Header' === $type ? '#4338ca' : '#0284c7';
				$bg    = 'Header' === $type ? '#e0e7ff' : '#e0f2fe';
				echo '<span style="display:inline-block; padding:3px 10px; border-radius:12px; font-weight:700; font-size:11px; background:' . esc_attr( $bg ) . '; color:' . esc_attr( $color ) . ';">' . esc_html( $type ) . '</span>';
				break;

			case 'awea_conditions':
				$cond   = get_post_meta( $post_id, '_awea_hf_condition', true );
				$labels = array(
					'entire_site'   => esc_html__( 'Entire Website', 'awesome-widgets-elementor' ),
					'front_page'    => esc_html__( 'Homepage Only', 'awesome-widgets-elementor' ),
					'singular_page' => esc_html__( 'All Pages', 'awesome-widgets-elementor' ),
					'singular_post' => esc_html__( 'All Posts', 'awesome-widgets-elementor' ),
					'archive'       => esc_html__( 'All Archives', 'awesome-widgets-elementor' ),
					'not_found_404' => esc_html__( '404 Page', 'awesome-widgets-elementor' ),
				);
				echo esc_html( isset( $labels[ $cond ] ) ? $labels[ $cond ] : $labels['entire_site'] );
				break;

			case 'awea_roles':
				$roles       = get_post_meta( $post_id, '_awea_hf_visibility', true );
				$role_labels = array(
					'all'        => esc_html__( 'All Users', 'awesome-widgets-elementor' ),
					'logged_in'  => esc_html__( 'Logged In', 'awesome-widgets-elementor' ),
					'logged_out' => esc_html__( 'Logged Out', 'awesome-widgets-elementor' ),
				);
				echo esc_html( isset( $role_labels[ $roles ] ) ? $role_labels[ $roles ] : $role_labels['all'] );
				break;

			case 'awea_shortcode':
				echo '<code style="background:#f1f5f9; padding:4px 8px; border-radius:6px; user-select:all;">[awea_template id="' . esc_attr( $post_id ) . '"]</code>';
				break;
		}
	}

	/**
	 * Register Meta Boxes for Single Post Editor.
	 */
	public function register_meta_boxes() {
		add_meta_box(
			'awea_hf_settings',
			esc_html__( 'Layout Rules & Target Conditions', 'awesome-widgets-elementor' ),
			array( $this, 'render_meta_box' ),
			self::POST_TYPE,
			'normal',
			'high'
		);
	}

	/**
	 * Render Meta Box Fields.
	 *
	 * @param \WP_Post $post Current post object.
	 */
	public function render_meta_box( $post ) {
		wp_nonce_field( 'awea_hf_meta_nonce', 'awea_hf_nonce' );

		$type          = get_post_meta( $post->ID, '_awea_hf_type', true );
		$condition     = get_post_meta( $post->ID, '_awea_hf_condition', true );
		$visibility    = get_post_meta( $post->ID, '_awea_hf_visibility', true );
		$sticky_header = get_post_meta( $post->ID, '_awea_header_sticky', true );
		$shrink_header = get_post_meta( $post->ID, '_awea_header_shrink', true );

		$type          = ! empty( $type ) ? $type : 'header';
		$condition     = ! empty( $condition ) ? $condition : 'entire_site';
		$visibility    = ! empty( $visibility ) ? $visibility : 'all';
		?>
		<div class="awea-metabox-wrapper" style="padding:10px 0;">
			<table class="form-table">
				<tr>
					<th scope="row"><label for="awea_hf_type"><strong><?php esc_html_e( 'Template Type', 'awesome-widgets-elementor' ); ?></strong></label></th>
					<td>
						<select name="awea_hf_type" id="awea_hf_type" style="min-width: 280px; font-weight:600;" onchange="aweaUpdateMetaPanels(this.value)">
							<option value="header" <?php selected( $type, 'header' ); ?>><?php esc_html_e( 'Header Layout', 'awesome-widgets-elementor' ); ?></option>
							<option value="footer" <?php selected( $type, 'footer' ); ?>><?php esc_html_e( 'Footer Layout', 'awesome-widgets-elementor' ); ?></option>
						</select>
					</td>
				</tr>

				<tr>
					<th scope="row"><label for="awea_hf_condition"><strong><?php esc_html_e( 'Display Condition', 'awesome-widgets-elementor' ); ?></strong></label></th>
					<td>
						<select name="awea_hf_condition" id="awea_hf_condition" style="min-width: 280px;">
							<option value="entire_site" <?php selected( $condition, 'entire_site' ); ?>><?php esc_html_e( 'Entire Website', 'awesome-widgets-elementor' ); ?></option>
							<option value="front_page" <?php selected( $condition, 'front_page' ); ?>><?php esc_html_e( 'Homepage Only', 'awesome-widgets-elementor' ); ?></option>
							<option value="singular_page" <?php selected( $condition, 'singular_page' ); ?>><?php esc_html_e( 'All Pages', 'awesome-widgets-elementor' ); ?></option>
							<option value="singular_post" <?php selected( $condition, 'singular_post' ); ?>><?php esc_html_e( 'All Blog Posts', 'awesome-widgets-elementor' ); ?></option>
							<option value="archive" <?php selected( $condition, 'archive' ); ?>><?php esc_html_e( 'Archives / Categories', 'awesome-widgets-elementor' ); ?></option>
							<option value="not_found_404" <?php selected( $condition, 'not_found_404' ); ?>><?php esc_html_e( '404 Page Only', 'awesome-widgets-elementor' ); ?></option>
						</select>
					</td>
				</tr>

				<tr>
					<th scope="row"><label for="awea_hf_visibility"><strong><?php esc_html_e( 'User Roles / Visibility', 'awesome-widgets-elementor' ); ?></strong></label></th>
					<td>
						<select name="awea_hf_visibility" id="awea_hf_visibility" style="min-width: 280px;">
							<option value="all" <?php selected( $visibility, 'all' ); ?>><?php esc_html_e( 'All Users (Public)', 'awesome-widgets-elementor' ); ?></option>
							<option value="logged_in" <?php selected( $visibility, 'logged_in' ); ?>><?php esc_html_e( 'Logged-In Users Only', 'awesome-widgets-elementor' ); ?></option>
							<option value="logged_out" <?php selected( $visibility, 'logged_out' ); ?>><?php esc_html_e( 'Logged-Out Visitors Only', 'awesome-widgets-elementor' ); ?></option>
						</select>
					</td>
				</tr>

				<!-- Header Specifics -->
				<tbody id="awea_header_settings_group" style="<?php echo 'header' === $type ? '' : 'display:none;'; ?>">
					<tr style="border-top: 1px solid #e2e8f0;">
						<th scope="row"><?php esc_html_e( 'Sticky Header Effects', 'awesome-widgets-elementor' ); ?></th>
						<td>
							<label style="display:block; margin-bottom:8px;">
								<input type="checkbox" name="awea_header_sticky" value="1" <?php checked( $sticky_header, '1' ); ?> />
								<strong><?php esc_html_e( 'Enable Sticky Header on Scroll', 'awesome-widgets-elementor' ); ?></strong>
							</label>
							<label style="display:block;">
								<input type="checkbox" name="awea_header_shrink" value="1" <?php checked( $shrink_header, '1' ); ?> />
								<?php esc_html_e( 'Enable Shrink Animation on Scroll', 'awesome-widgets-elementor' ); ?>
							</label>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<script>
			function aweaUpdateMetaPanels(val) {
				var headerGroup = document.getElementById('awea_header_settings_group');
				if (headerGroup) headerGroup.style.display = (val === 'header') ? '' : 'none';
			}
		</script>
		<?php
	}

	/**
	 * Save Meta Box Settings.
	 *
	 * @param int $post_id Post ID.
	 */
	public function save_meta_boxes( $post_id ) {
		if ( ! isset( $_POST['awea_hf_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['awea_hf_nonce'] ), 'awea_hf_meta_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['awea_hf_type'] ) ) {
			$allowed = array( 'header', 'footer' );
			$type    = sanitize_key( $_POST['awea_hf_type'] );
			if ( in_array( $type, $allowed, true ) ) {
				update_post_meta( $post_id, '_awea_hf_type', $type );
			}
		}

		if ( isset( $_POST['awea_hf_condition'] ) ) {
			$allowed_conds = array( 'entire_site', 'front_page', 'singular_page', 'singular_post', 'archive', 'not_found_404' );
			$condition     = sanitize_key( $_POST['awea_hf_condition'] );
			if ( in_array( $condition, $allowed_conds, true ) ) {
				update_post_meta( $post_id, '_awea_hf_condition', $condition );
			}
		}

		if ( isset( $_POST['awea_hf_visibility'] ) ) {
			update_post_meta( $post_id, '_awea_hf_visibility', sanitize_key( $_POST['awea_hf_visibility'] ) );
		}

		update_post_meta( $post_id, '_awea_header_sticky', isset( $_POST['awea_header_sticky'] ) ? '1' : '0' );
		update_post_meta( $post_id, '_awea_header_shrink', isset( $_POST['awea_header_shrink'] ) ? '1' : '0' );
	}

	/**
	 * Setup Active Template IDs based on conditions and user roles.
	 */
	public function setup_active_templates() {
		if ( is_admin() || is_singular( self::POST_TYPE ) ) {
			return;
		}

		self::$active_header_id = $this->resolve_template_id( 'header' );
		self::$active_footer_id = $this->resolve_template_id( 'footer' );

		// Remove header/footer actions on standard themes that support action hooks
		if ( self::$active_header_id ) {
			add_action( 'astra_header', '__return_empty_string', 1 );
			add_action( 'generate_header', '__return_empty_string', 1 );
			add_action( 'ocean_header', '__return_empty_string', 1 );
			add_action( 'hello_elementor_header', '__return_empty_string', 1 );
		}

		if ( self::$active_footer_id ) {
			add_action( 'astra_footer', '__return_empty_string', 1 );
			add_action( 'generate_footer', '__return_empty_string', 1 );
			add_action( 'ocean_footer', '__return_empty_string', 1 );
			add_action( 'hello_elementor_footer', '__return_empty_string', 1 );
		}
	}

	/**
	 * Block Theme (FSE) Support: Replace header and footer block template parts.
	 *
	 * @param string $block_content Rendered block HTML.
	 * @param array  $block         Parsed block array.
	 * @return string
	 */
	public function filter_block_template_parts( $block_content, $block ) {
		if ( is_singular( self::POST_TYPE ) || is_admin() ) {
			return $block_content;
		}

		if ( isset( $block['blockName'] ) && 'core/template-part' === $block['blockName'] ) {
			$slug = isset( $block['attrs']['slug'] ) ? $block['attrs']['slug'] : '';

			if ( 'header' === $slug && self::$active_header_id && class_exists( '\Elementor\Plugin' ) ) {
				return $this->get_header_markup();
			}

			if ( 'footer' === $slug && self::$active_footer_id && class_exists( '\Elementor\Plugin' ) ) {
				return $this->get_footer_markup();
			}
		}

		return $block_content;
	}

	/**
	 * Get Header HTML Markup.
	 *
	 * @return string
	 */
	private function get_header_markup() {
		if ( ! self::$active_header_id || ! class_exists( '\Elementor\Plugin' ) ) {
			return '';
		}

		$is_sticky = '1' === get_post_meta( self::$active_header_id, '_awea_header_sticky', true );
		$is_shrink = '1' === get_post_meta( self::$active_header_id, '_awea_header_shrink', true );

		$classes = array( 'awea-site-header' );
		if ( $is_sticky ) {
			$classes[] = 'awea-header-sticky';
		}
		if ( $is_shrink ) {
			$classes[] = 'awea-header-shrink';
		}

		$output  = '<header id="awea-site-header" class="' . esc_attr( implode( ' ', $classes ) ) . '">';
		$output .= \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( self::$active_header_id );
		$output .= '</header>';

		return $output;
	}

	/**
	 * Get Footer HTML Markup.
	 *
	 * @return string
	 */
	private function get_footer_markup() {
		if ( ! self::$active_footer_id || ! class_exists( '\Elementor\Plugin' ) ) {
			return '';
		}

		$output  = '<footer id="awea-site-footer" class="awea-site-footer">';
		$output .= \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( self::$active_footer_id );
		$output .= '</footer>';

		return $output;
	}

	/**
	 * Render Custom Header for Classic Themes via wp_body_open.
	 */
	public function render_header() {
		if ( wp_is_block_theme() ) {
			return; // Managed cleanly via filter_block_template_parts
		}

		echo $this->get_header_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Render Custom Footer for Classic Themes via wp_footer.
	 */
	public function render_footer() {
		if ( wp_is_block_theme() ) {
			return; // Managed cleanly via filter_block_template_parts
		}

		echo $this->get_footer_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Resolve template ID matching display rules and visibility.
	 *
	 * @param string $type Template type.
	 * @return int Template ID or 0.
	 */
	private function resolve_template_id( $type ) {
		$posts = get_posts(
			array(
				'post_type'   => self::POST_TYPE,
				'post_status' => 'publish',
				'numberposts' => -1,
				'meta_query'  => array(
					array(
						'key'   => '_awea_hf_type',
						'value' => $type,
					),
				),
			)
		);

		if ( empty( $posts ) ) {
			return 0;
		}

		foreach ( $posts as $post ) {
			$visibility = get_post_meta( $post->ID, '_awea_hf_visibility', true );

			if ( 'logged_in' === $visibility && ! is_user_logged_in() ) {
				continue;
			}
			if ( 'logged_out' === $visibility && is_user_logged_in() ) {
				continue;
			}

			$cond = get_post_meta( $post->ID, '_awea_hf_condition', true );

			if ( 'front_page' === $cond && is_front_page() ) {
				return $post->ID;
			}
			if ( 'singular_page' === $cond && is_page() ) {
				return $post->ID;
			}
			if ( 'singular_post' === $cond && is_single() ) {
				return $post->ID;
			}
			if ( 'archive' === $cond && ( is_archive() || is_category() || is_tag() ) ) {
				return $post->ID;
			}
			if ( 'not_found_404' === $cond && is_404() ) {
				return $post->ID;
			}
			if ( 'entire_site' === $cond ) {
				return $post->ID;
			}
		}

		return 0;
	}

	/**
	 * Enqueue Styles and Scripts for Frontend Overrides.
	 */
	public function enqueue_frontend_assets() {
		if ( is_singular( self::POST_TYPE ) ) {
			return;
		}

		$css = '
			.awea-site-header { width: 100%; position: relative; z-index: 999; }
			.awea-site-footer { width: 100%; position: relative; z-index: 998; }

			.awea-header-sticky {
				position: sticky;
				top: 0;
				transition: transform 0.3s ease, background 0.3s ease, padding 0.3s ease;
			}
			.awea-header-shrink.is-scrolled {
				padding-top: 6px !important;
				padding-bottom: 6px !important;
				box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
			}
		';

		// Hide classic theme headers/footers when an AWEA template is active
		if ( ! wp_is_block_theme() ) {
			if ( self::$active_header_id ) {
				$css .= '
					body header.site-header,
					body #site-header:not(#awea-site-header),
					body .site-header:not(#awea-site-header),
					body #masthead:not(#awea-site-header),
					body .main-header-bar-wrap {
						display: none !important;
					}
				';
			}
			if ( self::$active_footer_id ) {
				$css .= '
					body footer.site-footer,
					body #site-footer:not(#awea-site-footer),
					body .site-footer:not(#awea-site-footer),
					body #colophon:not(#awea-site-footer) {
						display: none !important;
					}
				';
			}
		}

		wp_register_style( 'awea-hf-style', false, array(), defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0' );
		wp_enqueue_style( 'awea-hf-style' );
		wp_add_inline_style( 'awea-hf-style', $css );

		$js = "
			window.addEventListener('scroll', function() {
				var header = document.querySelector('.awea-header-shrink');
				if (header) {
					if (window.scrollY > 80) {
						header.classList.add('is-scrolled');
					} else {
						header.classList.remove('is-scrolled');
					}
				}
			});
		";
		wp_register_script( 'awea-hf-script', '', array(), defined( 'AWEA_VERSION' ) ? AWEA_VERSION : '1.0.0', true );
		wp_enqueue_script( 'awea-hf-script' );
		wp_add_inline_script( 'awea-hf-script', $js );
	}

	/**
	 * Shortcode Handler: [awea_template id="123"]
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string HTML output.
	 */
	public function render_template_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'id' => 0,
			),
			$atts,
			'awea_template'
		);

		$template_id = absint( $atts['id'] );
		if ( ! $template_id || ! class_exists( '\Elementor\Plugin' ) ) {
			return '';
		}

		return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id );
	}

	/**
	 * Admin Quick-Create Template Modal.
	 */
	public function render_admin_quick_create_modal() {
		$screen = get_current_screen();
		if ( ! $screen ) {
			return;
		}

		$is_template_screen = self::POST_TYPE === $screen->post_type;
		$is_plugin_screen   = strpos( $screen->id, 'awesome-widgets' ) !== false;

		if ( ! $is_template_screen && ! $is_plugin_screen ) {
			return;
		}
		?>
		<!-- AWEA Quick-Create Template Modal -->
		<div id="awea-quick-create-modal" class="awea-modal-overlay" style="display:none;">
			<div class="awea-modal-container">
				<div class="awea-modal-header">
					<div class="awea-modal-title-wrap">
						<span class="awea-modal-tag"><?php esc_html_e( 'Canvas Studio', 'awesome-widgets-elementor' ); ?></span>
						<h2><?php esc_html_e( 'Create New Template', 'awesome-widgets-elementor' ); ?></h2>
						<p><?php esc_html_e( 'Configure layout architecture and launch directly into Elementor Canvas.', 'awesome-widgets-elementor' ); ?></p>
					</div>
					<button type="button" class="awea-modal-close-trigger" onclick="aweaCloseQuickModal()">&times;</button>
				</div>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'awea_quick_create_action', 'awea_quick_create_nonce' ); ?>
					<input type="hidden" name="action" value="awea_quick_create_template" />

					<!-- Template Title -->
					<div class="awea-modal-field">
						<label for="awea_new_title"><?php esc_html_e( 'Template Name', 'awesome-widgets-elementor' ); ?> <span style="color:#ef4444;">*</span></label>
						<input type="text" id="awea_new_title" name="awea_new_title" required placeholder="<?php esc_attr_e( 'e.g. Primary Header Navigation', 'awesome-widgets-elementor' ); ?>" autocomplete="off" />
					</div>

					<!-- Visual Type Selection Cards -->
					<div class="awea-modal-field">
						<label><?php esc_html_e( 'Select Template Type', 'awesome-widgets-elementor' ); ?></label>
						<div class="awea-type-selector">
							<label class="awea-type-option">
								<input type="radio" name="awea_new_type" value="header" checked onchange="aweaModalTypeChange(this.value)" />
								<span class="awea-type-card">
									<span class="dashicons dashicons-heading"></span>
									<strong><?php esc_html_e( 'Header', 'awesome-widgets-elementor' ); ?></strong>
								</span>
							</label>
							<label class="awea-type-option">
								<input type="radio" name="awea_new_type" value="footer" onchange="aweaModalTypeChange(this.value)" />
								<span class="awea-type-card">
									<span class="dashicons dashicons-embed-generic"></span>
									<strong><?php esc_html_e( 'Footer', 'awesome-widgets-elementor' ); ?></strong>
								</span>
							</label>
						</div>
					</div>

					<!-- Target Condition & Visibility Row -->
					<div class="awea-modal-grid-2">
						<div class="awea-modal-field">
							<label for="awea_new_condition"><?php esc_html_e( 'Display Condition', 'awesome-widgets-elementor' ); ?></label>
							<select id="awea_new_condition" name="awea_new_condition">
								<option value="entire_site"><?php esc_html_e( 'Entire Website', 'awesome-widgets-elementor' ); ?></option>
								<option value="front_page"><?php esc_html_e( 'Homepage Only', 'awesome-widgets-elementor' ); ?></option>
								<option value="singular_page"><?php esc_html_e( 'All Pages', 'awesome-widgets-elementor' ); ?></option>
								<option value="singular_post"><?php esc_html_e( 'All Blog Posts', 'awesome-widgets-elementor' ); ?></option>
								<option value="archive"><?php esc_html_e( 'All Archives', 'awesome-widgets-elementor' ); ?></option>
								<option value="not_found_404"><?php esc_html_e( '404 Error Page', 'awesome-widgets-elementor' ); ?></option>
							</select>
						</div>

						<div class="awea-modal-field">
							<label for="awea_new_visibility"><?php esc_html_e( 'User Visibility', 'awesome-widgets-elementor' ); ?></label>
							<select id="awea_new_visibility" name="awea_new_visibility">
								<option value="all"><?php esc_html_e( 'All Users (Public)', 'awesome-widgets-elementor' ); ?></option>
								<option value="logged_in"><?php esc_html_e( 'Logged-In Users Only', 'awesome-widgets-elementor' ); ?></option>
								<option value="logged_out"><?php esc_html_e( 'Logged-Out Visitors Only', 'awesome-widgets-elementor' ); ?></option>
							</select>
						</div>
					</div>

					<!-- Header Feature Toggles -->
					<div id="awea_modal_header_options" class="awea-modal-subbox">
						<label class="awea-checkbox-label">
							<input type="checkbox" name="awea_header_sticky" value="1" />
							<span><strong><?php esc_html_e( 'Enable Sticky Header', 'awesome-widgets-elementor' ); ?></strong> - <?php esc_html_e( 'Dock navigation to the top during scroll', 'awesome-widgets-elementor' ); ?></span>
						</label>
						<label class="awea-checkbox-label" style="margin-top:8px;">
							<input type="checkbox" name="awea_header_shrink" value="1" />
							<span><strong><?php esc_html_e( 'Enable Shrink Animation', 'awesome-widgets-elementor' ); ?></strong> - <?php esc_html_e( 'Compress height dynamically when scrolled', 'awesome-widgets-elementor' ); ?></span>
						</label>
					</div>

					<div class="awea-modal-footer">
						<button type="button" onclick="aweaCloseQuickModal()" class="awea-modal-btn-cancel"><?php esc_html_e( 'Cancel', 'awesome-widgets-elementor' ); ?></button>
						<button type="submit" class="awea-modal-btn-submit">
							<span class="dashicons dashicons-art"></span>
							<?php esc_html_e( 'Create & Open Elementor', 'awesome-widgets-elementor' ); ?>
						</button>
					</div>
				</form>
			</div>
		</div>

		<!-- Modal Styles -->
		<style>
			.awea-modal-overlay {
				position: fixed;
				inset: 0;
				background: rgba(15, 23, 42, 0.72);
				backdrop-filter: blur(8px);
				-webkit-backdrop-filter: blur(8px);
				z-index: 999999;
				display: flex;
				align-items: center;
				justify-content: center;
				padding: 20px;
				animation: aweaModalFadeIn 0.25s cubic-bezier(0.16, 1, 0.3, 1);
			}
			@keyframes aweaModalFadeIn {
				from { opacity: 0; transform: scale(0.98); }
				to { opacity: 1; transform: scale(1); }
			}
			.awea-modal-container {
				background: #ffffff;
				border-radius: 20px;
				max-width: 540px;
				width: 100%;
				padding: 32px;
				box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.35);
				position: relative;
				box-sizing: border-box;
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
				max-height: 90vh;
				overflow-y: auto;
			}
			.awea-modal-header {
				display: flex;
				justify-content: space-between;
				align-items: flex-start;
				margin-bottom: 22px;
			}
			.awea-modal-tag {
				font-size: 11px;
				font-weight: 700;
				text-transform: uppercase;
				letter-spacing: 0.08em;
				color: #4338ca;
				background: #e0e7ff;
				padding: 3px 10px;
				border-radius: 100px;
				display: inline-block;
				margin-bottom: 8px;
			}
			.awea-modal-title-wrap h2 {
				margin: 0 0 6px 0;
				font-size: 22px;
				font-weight: 800;
				color: #0f172a;
				letter-spacing: -0.02em;
			}
			.awea-modal-title-wrap p {
				margin: 0;
				color: #64748b;
				font-size: 13px;
				line-height: 1.5;
			}
			.awea-modal-close-trigger {
				background: #f1f5f9;
				border: none;
				width: 32px;
				height: 32px;
				border-radius: 50%;
				font-size: 20px;
				line-height: 1;
				color: #64748b;
				cursor: pointer;
				display: flex;
				align-items: center;
				justify-content: center;
				transition: all 0.2s;
			}
			.awea-modal-close-trigger:hover {
				background: #e2e8f0;
				color: #0f172a;
			}
			.awea-type-selector {
				display: grid;
				grid-template-columns: repeat(2, 1fr);
				gap: 12px;
				margin-top: 6px;
			}
			.awea-type-option input {
				display: none;
			}
			.awea-type-card {
				display: flex;
				flex-direction: column;
				align-items: center;
				gap: 6px;
				padding: 16px;
				border: 1.5px solid #e2e8f0;
				border-radius: 12px;
				background: #f8fafc;
				cursor: pointer;
				transition: all 0.2s;
			}
			.awea-type-card .dashicons {
				font-size: 22px;
				width: 22px;
				height: 22px;
				color: #64748b;
			}
			.awea-type-card strong {
				font-size: 13px;
				color: #334155;
			}
			.awea-type-option input:checked + .awea-type-card {
				border-color: #4338ca;
				background: #eef2ff;
			}
			.awea-type-option input:checked + .awea-type-card .dashicons,
			.awea-type-option input:checked + .awea-type-card strong {
				color: #4338ca;
			}
			.awea-modal-field {
				margin-bottom: 16px;
			}
			.awea-modal-field label {
				display: block;
				font-size: 13px;
				font-weight: 700;
				color: #334155;
				margin-bottom: 6px;
			}
			.awea-modal-field input[type="text"],
			.awea-modal-field select {
				width: 100%;
				height: 42px;
				padding: 0 14px;
				border-radius: 10px;
				border: 1px solid #cbd5e1;
				background: #f8fafc;
				font-size: 14px;
				color: #0f172a;
				outline: none;
				box-sizing: border-box;
				transition: border-color 0.2s, background 0.2s;
			}
			.awea-modal-field input:focus,
			.awea-modal-field select:focus {
				border-color: #4338ca;
				background: #ffffff;
				box-shadow: 0 0 0 3px rgba(67, 56, 202, 0.15);
			}
			.awea-modal-grid-2 {
				display: grid;
				grid-template-columns: 1fr 1fr;
				gap: 14px;
			}
			.awea-modal-subbox {
				background: #f8fafc;
				border: 1px solid #e2e8f0;
				border-radius: 12px;
				padding: 16px;
				margin-bottom: 18px;
			}
			.awea-checkbox-label {
				display: flex;
				align-items: center;
				gap: 8px;
				font-size: 13px;
				color: #475569;
				cursor: pointer;
			}
			.awea-modal-footer {
				display: flex;
				justify-content: flex-end;
				gap: 12px;
				margin-top: 20px;
				border-top: 1px solid #f1f5f9;
				padding-top: 20px;
			}
			.awea-modal-btn-cancel {
				background: transparent;
				border: 1px solid #cbd5e1;
				color: #475569;
				padding: 10px 18px;
				border-radius: 10px;
				font-size: 13px;
				font-weight: 600;
				cursor: pointer;
			}
			.awea-modal-btn-submit {
				background: #4338ca;
				border: none;
				color: #ffffff;
				padding: 10px 22px;
				border-radius: 10px;
				font-size: 13px;
				font-weight: 700;
				display: inline-flex;
				align-items: center;
				gap: 8px;
				cursor: pointer;
				box-shadow: 0 4px 14px rgba(67, 56, 202, 0.3);
			}
			.awea-modal-btn-submit:hover {
				background: #3730a3;
			}
		</style>

		<!-- Modal Controller Logic -->
		<script>
			function aweaOpenQuickModal() {
				var modal = document.getElementById('awea-quick-create-modal');
				if (modal) {
					modal.style.display = 'flex';
					var titleInput = document.getElementById('awea_new_title');
					if (titleInput) setTimeout(function() { titleInput.focus(); }, 100);
				}
			}

			function aweaCloseQuickModal() {
				var modal = document.getElementById('awea-quick-create-modal');
				if (modal) modal.style.display = 'none';
			}

			function aweaModalTypeChange(type) {
				var headerBox = document.getElementById('awea_modal_header_options');
				if (headerBox) headerBox.style.display = (type === 'header') ? 'block' : 'none';
			}

			document.addEventListener('DOMContentLoaded', function() {
				var addBtns = document.querySelectorAll('.page-title-action, .awea-btn-action, a[href*="post-new.php?post_type=awea_hf_template"]');
				addBtns.forEach(function(btn) {
					btn.addEventListener('click', function(e) {
						e.preventDefault();
						aweaOpenQuickModal();
					});
				});

				var modal = document.getElementById('awea-quick-create-modal');
				if (modal) {
					modal.addEventListener('click', function(e) {
						if (e.target === modal) aweaCloseQuickModal();
					});
				}

				document.addEventListener('keydown', function(e) {
					if (e.key === 'Escape') aweaCloseQuickModal();
				});
			});
		</script>
		<?php
	}

	/**
	 * Handle Quick-Create Form Submission and Redirect to Elementor Editor.
	 */
	public function handle_quick_create_submission() {
		if ( ! isset( $_POST['action'] ) || 'awea_quick_create_template' !== $_POST['action'] ) {
			return;
		}

		if ( ! isset( $_POST['awea_quick_create_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['awea_quick_create_nonce'] ), 'awea_quick_create_action' ) ) {
			wp_die( esc_html__( 'Security check failed.', 'awesome-widgets-elementor' ) );
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_die( esc_html__( 'Unauthorized access.', 'awesome-widgets-elementor' ) );
		}

		$title      = ! empty( $_POST['awea_new_title'] ) ? sanitize_text_field( $_POST['awea_new_title'] ) : esc_html__( 'New Template', 'awesome-widgets-elementor' );
		$type       = ! empty( $_POST['awea_new_type'] ) ? sanitize_key( $_POST['awea_new_type'] ) : 'header';
		$condition  = ! empty( $_POST['awea_new_condition'] ) ? sanitize_key( $_POST['awea_new_condition'] ) : 'entire_site';
		$visibility = ! empty( $_POST['awea_new_visibility'] ) ? sanitize_key( $_POST['awea_new_visibility'] ) : 'all';

		$post_id = wp_insert_post(
			array(
				'post_title'  => $title,
				'post_type'   => self::POST_TYPE,
				'post_status' => 'publish',
			)
		);

		if ( is_wp_error( $post_id ) ) {
			wp_die( esc_html( $post_id->get_error_message() ) );
		}

		// Core Meta
		update_post_meta( $post_id, '_awea_hf_type', $type );
		update_post_meta( $post_id, '_awea_hf_condition', $condition );
		update_post_meta( $post_id, '_awea_hf_visibility', $visibility );

		// Header Settings
		update_post_meta( $post_id, '_awea_header_sticky', isset( $_POST['awea_header_sticky'] ) ? '1' : '0' );
		update_post_meta( $post_id, '_awea_header_shrink', isset( $_POST['awea_header_shrink'] ) ? '1' : '0' );

		// Prime Elementor Canvas Mode
		update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
		update_post_meta( $post_id, '_wp_page_template', 'elementor_canvas' );

		// Flush rewrites once for the new post
		flush_rewrite_rules( false );

		// Direct redirect to Elementor Editor
		$elementor_url = admin_url( 'post.php?post=' . $post_id . '&action=elementor' );
		wp_safe_redirect( $elementor_url );
		exit;
	}
}