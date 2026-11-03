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
				$color = 'Header' === $type ? '#4f46e5' : '#0284c7';
				$bg    = 'Header' === $type ? 'rgba(79, 70, 229, 0.08)' : 'rgba(2, 132, 199, 0.08)';
				$border = 'Header' === $type ? 'rgba(79, 70, 229, 0.2)' : 'rgba(2, 132, 199, 0.2)';
				echo '<span style="display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:100px; font-weight:700; font-size:11px; letter-spacing:0.04em; text-transform:uppercase; background:' . esc_attr( $bg ) . '; color:' . esc_attr( $color ) . '; border:1px solid ' . esc_attr( $border ) . ';">' . esc_html( $type ) . '</span>';
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
				echo '<span style="display:inline-block; background:#f1f5f9; color:#334155; border:1px solid #e2e8f0; padding:2px 8px; border-radius:6px; font-size:12px; font-weight:600;">' . esc_html( isset( $labels[ $cond ] ) ? $labels[ $cond ] : $labels['entire_site'] ) . '</span>';
				break;

			case 'awea_roles':
				$roles       = get_post_meta( $post_id, '_awea_hf_visibility', true );
				$role_labels = array(
					'all'        => esc_html__( 'Public', 'awesome-widgets-elementor' ),
					'logged_in'  => esc_html__( 'Logged In', 'awesome-widgets-elementor' ),
					'logged_out' => esc_html__( 'Logged Out', 'awesome-widgets-elementor' ),
				);
				echo '<span style="font-size:12px; color:#64748b; font-weight:500;">' . esc_html( isset( $role_labels[ $roles ] ) ? $role_labels[ $roles ] : $role_labels['all'] ) . '</span>';
				break;

			case 'awea_shortcode':
				echo '<code style="background:#f8fafc; border:1px solid #e2e8f0; padding:3px 8px; border-radius:6px; font-size:11px; font-family:ui-monospace, monospace; color:#475569; user-select:all;">[awea_template id="' . esc_attr( $post_id ) . '"]</code>';
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
			return;
		}

		echo $this->get_header_markup(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Render Custom Footer for Classic Themes via wp_footer.
	 */
	public function render_footer() {
		if ( wp_is_block_theme() ) {
			return;
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
	 * Modern Studio Quick-Create Modal with Raycast/Linear UI & Micro-Interactions.
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
		<!-- AWEA Modern Studio Quick-Create Modal -->
		<div id="awea-quick-create-modal" class="awea-studio-backdrop" style="display:none;" role="dialog" aria-modal="true">
			<div class="awea-studio-card">
				
				<!-- Specular Header -->
				<div class="awea-studio-header">
					<div class="awea-studio-pill">
						<span class="awea-beacon-glow"></span>
						<?php esc_html_e( 'Canvas Studio &bull; Builder Engine', 'awesome-widgets-elementor' ); ?>
					</div>
					<button type="button" class="awea-studio-close-btn" onclick="aweaCloseQuickModal()" aria-label="<?php esc_attr_e( 'Close', 'awesome-widgets-elementor' ); ?>">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
					</button>
				</div>

				<div class="awea-studio-intro">
					<h2><?php esc_html_e( 'Create New Template', 'awesome-widgets-elementor' ); ?></h2>
					<p><?php esc_html_e( 'Configure layout architecture and launch directly into Elementor Canvas with zero bloat.', 'awesome-widgets-elementor' ); ?></p>
				</div>

				<form method="post" id="awea_quick_modal_form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'awea_quick_create_action', 'awea_quick_create_nonce' ); ?>
					<input type="hidden" name="action" value="awea_quick_create_template" />

					<!-- Segmented Visual Type Picker -->
					<div class="awea-input-block">
						<label class="awea-label-meta"><?php esc_html_e( 'Template Type', 'awesome-widgets-elementor' ); ?></label>
						<div class="awea-segmented-grid">
							
							<!-- Header Option -->
							<label class="awea-segment-item">
								<input type="radio" name="awea_new_type" value="header" checked onchange="aweaTypeSelected(this.value)" />
								<div class="awea-segment-box">
									<div class="awea-segment-icon">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
									</div>
									<div class="awea-segment-text">
										<strong><?php esc_html_e( 'Header Layout', 'awesome-widgets-elementor' ); ?></strong>
										<span><?php esc_html_e( 'Sticky navigation & hero ribbons', 'awesome-widgets-elementor' ); ?></span>
									</div>
									<div class="awea-radio-indicator"></div>
								</div>
							</label>

							<!-- Footer Option -->
							<label class="awea-segment-item">
								<input type="radio" name="awea_new_type" value="footer" onchange="aweaTypeSelected(this.value)" />
								<div class="awea-segment-box">
									<div class="awea-segment-icon">
										<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="15" x2="21" y2="15"></line></svg>
									</div>
									<div class="awea-segment-text">
										<strong><?php esc_html_e( 'Footer Layout', 'awesome-widgets-elementor' ); ?></strong>
										<span><?php esc_html_e( 'Columns, sitemaps & copyright', 'awesome-widgets-elementor' ); ?></span>
									</div>
									<div class="awea-radio-indicator"></div>
								</div>
							</label>

						</div>
					</div>

					<!-- Template Title Input -->
					<div class="awea-input-block">
						<label class="awea-label-meta" for="awea_new_title">
							<?php esc_html_e( 'Template Name', 'awesome-widgets-elementor' ); ?>
							<span class="awea-req-star">*</span>
						</label>
						<div class="awea-input-wrapper">
							<input type="text" id="awea_new_title" name="awea_new_title" required placeholder="<?php esc_attr_e( 'e.g. Master Site Header 2026', 'awesome-widgets-elementor' ); ?>" autocomplete="off" />
							<span class="awea-kbd-hint"><kbd>Tab</kbd></span>
						</div>
					</div>

					<!-- Condition & Visibility Row -->
					<div class="awea-dual-grid">
						<div class="awea-input-block">
							<label class="awea-label-meta" for="awea_new_condition"><?php esc_html_e( 'Target Rule', 'awesome-widgets-elementor' ); ?></label>
							<select id="awea_new_condition" name="awea_new_condition">
								<option value="entire_site"><?php esc_html_e( 'Entire Website', 'awesome-widgets-elementor' ); ?></option>
								<option value="front_page"><?php esc_html_e( 'Homepage Only', 'awesome-widgets-elementor' ); ?></option>
								<option value="singular_page"><?php esc_html_e( 'All Pages', 'awesome-widgets-elementor' ); ?></option>
								<option value="singular_post"><?php esc_html_e( 'All Blog Posts', 'awesome-widgets-elementor' ); ?></option>
								<option value="archive"><?php esc_html_e( 'All Archives', 'awesome-widgets-elementor' ); ?></option>
								<option value="not_found_404"><?php esc_html_e( '404 Error Page', 'awesome-widgets-elementor' ); ?></option>
							</select>
						</div>

						<div class="awea-input-block">
							<label class="awea-label-meta" for="awea_new_visibility"><?php esc_html_e( 'Audience Scope', 'awesome-widgets-elementor' ); ?></label>
							<select id="awea_new_visibility" name="awea_new_visibility">
								<option value="all"><?php esc_html_e( 'Public (All Visitors)', 'awesome-widgets-elementor' ); ?></option>
								<option value="logged_in"><?php esc_html_e( 'Logged-In Members', 'awesome-widgets-elementor' ); ?></option>
								<option value="logged_out"><?php esc_html_e( 'Logged-Out Visitors', 'awesome-widgets-elementor' ); ?></option>
							</select>
						</div>
					</div>

					<!-- Header Feature Expansion Drawer -->
					<div id="awea_modal_header_expansion" class="awea-feature-drawer">
						<div class="awea-feature-drawer-head">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
							<strong><?php esc_html_e( 'Header Physics & Docking', 'awesome-widgets-elementor' ); ?></strong>
						</div>
						<div class="awea-toggles-list">
							<label class="awea-toggle-row">
								<input type="checkbox" name="awea_header_sticky" value="1" />
								<div class="awea-toggle-switch"></div>
								<div class="awea-toggle-label">
									<strong><?php esc_html_e( 'Sticky Header Docking', 'awesome-widgets-elementor' ); ?></strong>
									<span><?php esc_html_e( 'Locks navigation seamlessly to the top of the screen on scroll', 'awesome-widgets-elementor' ); ?></span>
								</div>
							</label>
							<label class="awea-toggle-row">
								<input type="checkbox" name="awea_header_shrink" value="1" />
								<div class="awea-toggle-switch"></div>
								<div class="awea-toggle-label">
									<strong><?php esc_html_e( 'Smooth Shrink Animation', 'awesome-widgets-elementor' ); ?></strong>
									<span><?php esc_html_e( 'Compresses paddings dynamically as visitors explore your page', 'awesome-widgets-elementor' ); ?></span>
								</div>
							</label>
						</div>
					</div>

					<!-- Footer Actions -->
					<div class="awea-studio-footer">
						<div class="awea-footer-meta">
							<span class="awea-kbd-badge"><kbd>&crarr;</kbd> <?php esc_html_e( 'to confirm', 'awesome-widgets-elementor' ); ?></span>
						</div>
						<div class="awea-action-buttons">
							<button type="button" onclick="aweaCloseQuickModal()" class="awea-btn-dismiss"><?php esc_html_e( 'Cancel', 'awesome-widgets-elementor' ); ?></button>
							<button type="submit" class="awea-btn-launch">
								<?php esc_html_e( 'Create & Open Canvas', 'awesome-widgets-elementor' ); ?>
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
							</button>
						</div>
					</div>

				</form>
			</div>
		</div>

		<!-- Studio UI/UX Scoped Stylesheet -->
		<style>
			.awea-studio-backdrop {
				position: fixed;
				inset: 0;
				background: rgba(10, 15, 29, 0.72);
				backdrop-filter: blur(14px);
				-webkit-backdrop-filter: blur(14px);
				z-index: 999999;
				display: flex;
				align-items: center;
				justify-content: center;
				padding: 24px;
				animation: aweaBackdropIn 0.28s cubic-bezier(0.16, 1, 0.3, 1) forwards;
				box-sizing: border-box;
			}
			@keyframes aweaBackdropIn {
				from { opacity: 0; }
				to { opacity: 1; }
			}

			.awea-studio-card {
				background: #ffffff;
				border-radius: 28px;
				max-width: 580px;
				width: 100%;
				padding: 36px;
				box-shadow: 
					0 30px 70px -15px rgba(0, 0, 0, 0.35),
					0 0 0 1px rgba(15, 23, 42, 0.06),
					inset 0 1px 0 rgba(255, 255, 255, 0.9);
				position: relative;
				box-sizing: border-box;
				font-family: -apple-system, BlinkMacSystemFont, "SF Pro Display", "Segoe UI", Roboto, sans-serif;
				max-height: 90vh;
				overflow-y: auto;
				animation: aweaCardPop 0.32s cubic-bezier(0.16, 1, 0.3, 1) forwards;
			}
			@keyframes aweaCardPop {
				from { opacity: 0; transform: scale(0.94) translateY(12px); }
				to { opacity: 1; transform: scale(1) translateY(0); }
			}

			.awea-studio-header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 20px;
			}

			.awea-studio-pill {
				display: inline-flex;
				align-items: center;
				gap: 8px;
				font-size: 11px;
				font-weight: 700;
				letter-spacing: 0.08em;
				text-transform: uppercase;
				color: #4338ca;
				background: rgba(99, 102, 241, 0.08);
				border: 1px solid rgba(99, 102, 241, 0.2);
				padding: 5px 14px;
				border-radius: 100px;
			}

			.awea-beacon-glow {
				width: 6px;
				height: 6px;
				border-radius: 50%;
				background: #4f46e5;
				box-shadow: 0 0 8px rgba(79, 70, 229, 0.8);
			}

			.awea-studio-close-btn {
				background: #f1f5f9;
				border: none;
				width: 32px;
				height: 32px;
				border-radius: 50%;
				color: #64748b;
				cursor: pointer;
				display: flex;
				align-items: center;
				justify-content: center;
				transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
			}
			.awea-studio-close-btn svg {
				width: 15px;
				height: 15px;
			}
			.awea-studio-close-btn:hover {
				background: #e2e8f0;
				color: #0f172a;
				transform: rotate(90deg);
			}

			.awea-studio-intro h2 {
				margin: 0 0 6px 0;
				font-size: 24px;
				font-weight: 800;
				letter-spacing: -0.03em;
				color: #0f172a;
			}
			.awea-studio-intro p {
				margin: 0 0 24px 0;
				color: #64748b;
				font-size: 13.5px;
				line-height: 1.55;
			}

			.awea-input-block {
				margin-bottom: 20px;
			}

			.awea-label-meta {
				display: block;
				font-size: 12.5px;
				font-weight: 700;
				color: #334155;
				margin-bottom: 8px;
			}
			.awea-req-star {
				color: #ef4444;
				margin-left: 2px;
			}

			/* Segmented Cards */
			.awea-segmented-grid {
				display: grid;
				grid-template-columns: 1fr 1fr;
				gap: 14px;
			}
			.awea-segment-item input {
				display: none;
			}
			.awea-segment-box {
				display: flex;
				align-items: center;
				gap: 14px;
				padding: 16px 18px;
				border-radius: 16px;
				background: #f8fafc;
				border: 1.5px solid #e2e8f0;
				cursor: pointer;
				position: relative;
				transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
			}
			.awea-segment-icon {
				width: 40px;
				height: 40px;
				border-radius: 12px;
				background: #ffffff;
				border: 1px solid #e2e8f0;
				display: flex;
				align-items: center;
				justify-content: center;
				color: #64748b;
				flex-shrink: 0;
				transition: all 0.2s ease;
			}
			.awea-segment-icon svg {
				width: 20px;
				height: 20px;
			}
			.awea-segment-text {
				display: flex;
				flex-direction: column;
				gap: 2px;
			}
			.awea-segment-text strong {
				font-size: 13.5px;
				color: #0f172a;
				font-weight: 700;
			}
			.awea-segment-text span {
				font-size: 11.5px;
				color: #64748b;
				line-height: 1.3;
			}

			/* Active Selection */
			.awea-segment-item input:checked + .awea-segment-box {
				border-color: #4f46e5;
				background: #f5f3ff;
				box-shadow: 0 8px 24px -6px rgba(79, 70, 229, 0.15);
			}
			.awea-segment-item input:checked + .awea-segment-box .awea-segment-icon {
				background: #4f46e5;
				border-color: #4f46e5;
				color: #ffffff;
			}
			.awea-segment-item input:checked + .awea-segment-box .awea-segment-text strong {
				color: #4338ca;
			}

			/* Inputs & Selects */
			.awea-input-wrapper {
				position: relative;
			}
			.awea-studio-card input[type="text"],
			.awea-studio-card select {
				width: 100%;
				height: 46px;
				padding: 0 16px;
				border-radius: 12px;
				border: 1px solid #cbd5e1;
				background: #f8fafc;
				font-size: 14px;
				color: #0f172a;
				outline: none;
				box-sizing: border-box;
				transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
			}
			.awea-studio-card input[type="text"]:focus,
			.awea-studio-card select:focus {
				border-color: #4f46e5;
				background: #ffffff;
				box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.14);
			}
			.awea-kbd-hint {
				position: absolute;
				right: 12px;
				top: 50%;
				transform: translateY(-50%);
				pointer-events: none;
			}
			.awea-kbd-hint kbd,
			.awea-kbd-badge kbd {
				background: #ffffff;
				border: 1px solid #e2e8f0;
				border-radius: 4px;
				padding: 2px 6px;
				font-size: 10.5px;
				font-family: ui-monospace, monospace;
				color: #64748b;
				box-shadow: 0 1px 2px rgba(0,0,0,0.05);
			}

			.awea-dual-grid {
				display: grid;
				grid-template-columns: 1fr 1fr;
				gap: 14px;
			}

			/* Drawer Feature Panel */
			.awea-feature-drawer {
				background: #f8fafc;
				border: 1px solid #e2e8f0;
				border-radius: 16px;
				padding: 18px 20px;
				margin-bottom: 24px;
				animation: aweaDrawerReveal 0.25s cubic-bezier(0.16, 1, 0.3, 1);
			}
			@keyframes aweaDrawerReveal {
				from { opacity: 0; transform: translateY(-6px); }
				to { opacity: 1; transform: translateY(0); }
			}
			.awea-feature-drawer-head {
				display: flex;
				align-items: center;
				gap: 8px;
				margin-bottom: 14px;
				color: #334155;
				font-size: 12.5px;
			}
			.awea-feature-drawer-head svg {
				width: 16px;
				height: 16px;
				color: #4f46e5;
			}
			.awea-toggles-list {
				display: flex;
				flex-direction: column;
				gap: 12px;
			}
			.awea-toggle-row {
				display: flex;
				align-items: center;
				gap: 12px;
				cursor: pointer;
			}
			.awea-toggle-row input {
				display: none;
			}
			.awea-toggle-switch {
				width: 38px;
				height: 22px;
				border-radius: 100px;
				background: #cbd5e1;
				position: relative;
				flex-shrink: 0;
				transition: background 0.25s ease;
			}
			.awea-toggle-switch::after {
				content: "";
				position: absolute;
				width: 16px;
				height: 16px;
				border-radius: 50%;
				background: #ffffff;
				top: 3px;
				left: 3px;
				transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
				box-shadow: 0 1px 3px rgba(0,0,0,0.15);
			}
			.awea-toggle-row input:checked + .awea-toggle-switch {
				background: #4f46e5;
			}
			.awea-toggle-row input:checked + .awea-toggle-switch::after {
				transform: translateX(16px);
			}
			.awea-toggle-label {
				display: flex;
				flex-direction: column;
				gap: 1px;
			}
			.awea-toggle-label strong {
				font-size: 13px;
				color: #0f172a;
			}
			.awea-toggle-label span {
				font-size: 11.5px;
				color: #64748b;
			}

			/* Footer Controls */
			.awea-studio-footer {
				display: flex;
				justify-content: space-between;
				align-items: center;
				border-top: 1px solid #f1f5f9;
				padding-top: 22px;
				margin-top: 24px;
			}
			.awea-footer-meta {
				font-size: 12px;
				color: #94a3b8;
			}
			.awea-action-buttons {
				display: flex;
				gap: 10px;
			}
			.awea-btn-dismiss {
				background: transparent;
				border: 1px solid #e2e8f0;
				color: #475569;
				padding: 10px 18px;
				border-radius: 12px;
				font-size: 13px;
				font-weight: 600;
				cursor: pointer;
				transition: all 0.2s ease;
			}
			.awea-btn-dismiss:hover {
				background: #f8fafc;
				border-color: #cbd5e1;
				color: #0f172a;
			}
			.awea-btn-launch {
				background: #4f46e5;
				border: none;
				color: #ffffff;
				padding: 11px 22px;
				border-radius: 12px;
				font-size: 13.5px;
				font-weight: 700;
				display: inline-flex;
				align-items: center;
				gap: 8px;
				cursor: pointer;
				box-shadow: 0 4px 16px rgba(79, 70, 229, 0.3);
				transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
			}
			.awea-btn-launch svg {
				width: 16px;
				height: 16px;
				transition: transform 0.2s ease;
			}
			.awea-btn-launch:hover {
				background: #4338ca;
				transform: translateY(-1.5px);
				box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
			}
			.awea-btn-launch:hover svg {
				transform: translateX(3px);
			}
		</style>

		<!-- Controller Logic -->
		<script>
			function aweaOpenQuickModal() {
				var modal = document.getElementById('awea-quick-create-modal');
				if (modal) {
					modal.style.display = 'flex';
					var titleInput = document.getElementById('awea_new_title');
					if (titleInput) {
						setTimeout(function() {
							titleInput.focus();
						}, 120);
					}
				}
			}

			function aweaCloseQuickModal() {
				var modal = document.getElementById('awea-quick-create-modal');
				if (modal) {
					modal.style.display = 'none';
				}
			}

			function aweaTypeSelected(type) {
				var drawer = document.getElementById('awea_modal_header_expansion');
				if (drawer) {
					drawer.style.display = (type === 'header') ? 'block' : 'none';
				}
			}

			document.addEventListener('DOMContentLoaded', function() {
				// Intercept standard Add New buttons
				var addBtns = document.querySelectorAll('.page-title-action, .awea-btn-action, a[href*="post-new.php?post_type=awea_hf_template"]');
				addBtns.forEach(function(btn) {
					btn.addEventListener('click', function(e) {
						e.preventDefault();
						aweaOpenQuickModal();
					});
				});

				// Dismiss on backdrop click
				var modal = document.getElementById('awea-quick-create-modal');
				if (modal) {
					modal.addEventListener('click', function(e) {
						if (e.target === modal) {
							aweaCloseQuickModal();
						}
					});
				}

				// Keyboard controls
				document.addEventListener('keydown', function(e) {
					if (!modal || modal.style.display !== 'flex') return;

					if (e.key === 'Escape') {
						aweaCloseQuickModal();
					}
					if ((e.metaKey || e.ctrlKey) && e.key === 'Enter') {
						var form = document.getElementById('awea_quick_modal_form');
						if (form) form.submit();
					}
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

		// Header Physics Settings
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