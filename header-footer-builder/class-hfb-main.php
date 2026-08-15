<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class PedroEA_HFB_Main {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		add_action( 'init', [ $this, 'register_post_type' ] );
		add_action( 'elementor/init', [ $this, 'add_elementor_support' ] );
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
		add_action( 'admin_post_pedroea_create_template', [ $this, 'handle_create' ] );
		add_action( 'admin_post_pedroea_update_template', [ $this, 'handle_update' ] );
		add_action( 'admin_post_pedroea_toggle_active', [ $this, 'handle_toggle_active' ] );
		add_action( 'admin_post_pedroea_delete_template', [ $this, 'handle_delete' ] );
		add_action( 'add_meta_boxes', [ $this, 'add_condition_meta_box' ] );
		add_action( 'save_post_pedroea_template', [ $this, 'save_condition_meta' ] );
		add_filter( 'manage_pedroea_template_posts_columns', [ $this, 'type_column' ] );
		add_action( 'manage_pedroea_template_posts_custom_column', [ $this, 'type_column_value' ], 10, 2 );
		add_filter( 'template_include', [ $this, 'template_override' ] );
		add_action( 'template_redirect', [ $this, 'detect_and_enqueue' ] );
		add_filter( 'body_class', [ $this, 'body_class' ] );
		add_action( 'get_header', [ $this, 'render_header' ] );
		add_action( 'wp_footer', [ $this, 'render_footer' ] );
	}

	public function register_post_type() {
		register_post_type(
			'pedroea_template',
			[
				'labels'          => [
					'name'          => __( 'Templates', 'pedro-for-elementor-addons' ),
					'singular_name' => __( 'Template', 'pedro-for-elementor-addons' ),
					'add_new'       => __( 'Add Template', 'pedro-for-elementor-addons' ),
					'add_new_item'  => __( 'Add New Template', 'pedro-for-elementor-addons' ),
					'edit_item'     => __( 'Edit Template', 'pedro-for-elementor-addons' ),
					'all_items'     => __( 'All Templates', 'pedro-for-elementor-addons' ),
				],
				'public'          => true,
				'show_ui'         => true,
				'show_in_menu'    => false,
				'supports'        => [ 'title', 'editor', 'elementor' ],
				'show_in_rest'    => true,
				'rewrite'         => false,
				'capability_type' => 'post',
			]
		);
	}

	public function add_elementor_support() {
		add_post_type_support( 'pedroea_template', 'elementor' );
	}

	public function add_admin_menu() {
		add_submenu_page(
			'pedroea',
			__( 'Header Footer Builder', 'pedro-for-elementor-addons' ),
			__( 'H&F Builder', 'pedro-for-elementor-addons' ),
			'manage_options',
			'pedroea_hfb',
			[ $this, 'render_dashboard' ]
		);
	}

	public function render_dashboard() {
		$edit_id = isset( $_GET['edit'] ) ? intval( wp_unslash( $_GET['edit'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( $edit_id && 'pedroea_template' === get_post_type( $edit_id ) ) {
			$edit_post = get_post( $edit_id );
		} else {
			$edit_post = null;
		}

		$templates = get_posts(
			[
				'post_type'      => 'pedroea_template',
				'posts_per_page' => -1,
				'post_status'    => [ 'publish', 'draft' ],
				'orderby'        => 'date',
				'order'          => 'DESC',
			]
		);
		?>
		<div class="wrap pedroea-hfb-wrap">
			<div class="p-header">
				<div>
					<h1><?php esc_html_e( 'Header Footer Builder', 'pedro-for-elementor-addons' ); ?></h1>
					<p><?php esc_html_e( 'Create custom Elementor headers & footers for your entire site.', 'pedro-for-elementor-addons' ); ?></p>
				</div>
				<span class="p-badge">v<?php echo esc_html( PEDROEA_VERSION ); ?></span>
			</div>

			<?php if ( $edit_post ) : ?>
				<div class="p-form-card">
					<div class="p-form-card-header">
						<h2><span class="dashicons dashicons-edit"></span> <?php esc_html_e( 'Edit Template', 'pedro-for-elementor-addons' ); ?></h2>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=pedroea_hfb' ) ); ?>" class="p-btn-secondary p-btn-sm">&larr; <?php esc_html_e( 'Back', 'pedro-for-elementor-addons' ); ?></a>
					</div>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<input type="hidden" name="action" value="pedroea_update_template">
						<input type="hidden" name="post_id" value="<?php echo esc_attr( $edit_post->ID ); ?>">
						<?php wp_nonce_field( 'pedroea_update_template_nonce' ); ?>
						<div class="p-form-body">
							<div class="p-field">
								<label><?php esc_html_e( 'Template Name', 'pedro-for-elementor-addons' ); ?></label>
								<input type="text" name="title" value="<?php echo esc_attr( $edit_post->post_title ); ?>" required>
							</div>
							<div class="p-field">
								<label><?php esc_html_e( 'Type', 'pedro-for-elementor-addons' ); ?></label>
								<?php $edit_type = get_post_meta( $edit_post->ID, '_pedroea_template_type', true ) ?: 'header'; ?>
								<select name="type" required>
									<option value="header" <?php selected( $edit_type, 'header' ); ?>><?php esc_html_e( 'Header', 'pedro-for-elementor-addons' ); ?></option>
									<option value="footer" <?php selected( $edit_type, 'footer' ); ?>><?php esc_html_e( 'Footer', 'pedro-for-elementor-addons' ); ?></option>
								</select>
							</div>
							<div class="p-field p-field-checkbox">
								<label>
									<input type="checkbox" name="active" value="1" <?php checked( '1', get_post_meta( $edit_post->ID, '_pedroea_template_active', true ) ); ?>>
									<?php esc_html_e( 'Active', 'pedro-for-elementor-addons' ); ?>
								</label>
							</div>
							<div class="p-form-actions">
								<a href="<?php echo esc_url( admin_url( 'post.php?post=' . $edit_post->ID . '&action=elementor' ) ); ?>" class="p-btn-el">
									<span class="dashicons dashicons-edit"></span> <?php esc_html_e( 'Edit with Elementor', 'pedro-for-elementor-addons' ); ?>
								</a>
								<button type="submit" class="p-btn-primary">
									<span class="dashicons dashicons-yes"></span>
									<?php esc_html_e( 'Save Changes', 'pedro-for-elementor-addons' ); ?>
								</button>
							</div>
						</div>
					</form>
				</div>
			<?php else : ?>
				<div class="p-form-card">
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<input type="hidden" name="action" value="pedroea_create_template">
						<?php wp_nonce_field( 'pedroea_create_template_nonce' ); ?>
						<div class="p-form-body">
							<div class="p-field">
								<label><?php esc_html_e( 'Template Name', 'pedro-for-elementor-addons' ); ?></label>
								<input type="text" name="title" placeholder="<?php esc_attr_e( 'e.g. Main Header', 'pedro-for-elementor-addons' ); ?>" required>
							</div>
							<div class="p-field">
								<label><?php esc_html_e( 'Type', 'pedro-for-elementor-addons' ); ?></label>
								<select name="type" required>
									<option value="header"><?php esc_html_e( 'Header', 'pedro-for-elementor-addons' ); ?></option>
									<option value="footer"><?php esc_html_e( 'Footer', 'pedro-for-elementor-addons' ); ?></option>
								</select>
							</div>
							<button type="submit" class="p-btn-primary">
								<span class="dashicons dashicons-plus-alt2"></span>
								<?php esc_html_e( 'Create & Edit', 'pedro-for-elementor-addons' ); ?>
							</button>
						</div>
					</form>
				</div>
			<?php endif; ?>

			<div class="p-card">
				<div class="p-card-header">
					<h2><span class="dashicons dashicons-layout"></span> <?php esc_html_e( 'Templates', 'pedro-for-elementor-addons' ); ?></h2>
					<span class="p-count"><?php echo count( $templates ); ?></span>
				</div>
				<div class="p-card-body">
					<?php $this->render_template_list( $templates ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	private function render_template_list( $posts ) {
		if ( empty( $posts ) ) {
			echo '<div class="p-empty"><span class="dashicons dashicons-layout"></span><p>' . esc_html__( 'No templates yet.', 'pedro-for-elementor-addons' ) . '</p></div>';
			return;
		}

		$templates = $posts;
		include PEDROEA_PATH . 'header-footer-builder/templates/template-list.php';
	}

	public function handle_create() {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'pedroea_create_template_nonce' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		$title = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$raw_type = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '';
		$type  = in_array( $raw_type, [ 'header', 'footer' ], true ) ? $raw_type : 'header';

		if ( empty( $title ) ) {
			wp_die( esc_html__( 'Name is required', 'pedro-for-elementor-addons' ) );
		}

		$post_id = wp_insert_post(
			[
				'post_type'   => 'pedroea_template',
				'post_title'  => $title,
				'post_status' => 'publish',
				'meta_input'  => [
					'_pedroea_template_type'   => $type,
					'_pedroea_template_active' => '1',
				],
			]
		);

		if ( is_wp_error( $post_id ) ) {
			wp_die( esc_html__( 'Could not create template', 'pedro-for-elementor-addons' ) );
		}

		wp_safe_redirect( admin_url( 'post.php?post=' . $post_id . '&action=elementor' ) );
		exit;
	}

	public function handle_toggle_active() {
		$post_id = isset( $_GET['post_id'] ) ? intval( wp_unslash( $_GET['post_id'] ) ) : 0;

		if ( ! $post_id || ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'pedroea_toggle_' . $post_id ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( 'pedroea_template' !== get_post_type( $post_id ) ) {
			wp_die( esc_html__( 'Invalid template', 'pedro-for-elementor-addons' ) );
		}

		$current = get_post_meta( $post_id, '_pedroea_template_active', true );
		$new     = '1' === $current ? '0' : '1';

		update_post_meta( $post_id, '_pedroea_template_active', $new );

		wp_safe_redirect( admin_url( 'admin.php?page=pedroea_hfb' ) );
		exit;
	}

	public function handle_delete() {
		$post_id = isset( $_GET['post_id'] ) ? intval( wp_unslash( $_GET['post_id'] ) ) : 0;

		if ( ! $post_id || ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'pedroea_delete_' . $post_id ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( 'pedroea_template' !== get_post_type( $post_id ) ) {
			wp_die( esc_html__( 'Invalid template', 'pedro-for-elementor-addons' ) );
		}

		wp_delete_post( $post_id, true );

		wp_safe_redirect( admin_url( 'admin.php?page=pedroea_hfb' ) );
		exit;
	}

	public function handle_update() {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'pedroea_update_template_nonce' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		$post_id = isset( $_POST['post_id'] ) ? intval( wp_unslash( $_POST['post_id'] ) ) : 0;

		if ( ! $post_id || 'pedroea_template' !== get_post_type( $post_id ) ) {
			wp_die( esc_html__( 'Invalid template', 'pedro-for-elementor-addons' ) );
		}

		$title = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$raw_type = isset( $_POST['type'] ) ? sanitize_text_field( wp_unslash( $_POST['type'] ) ) : '';
		$type  = in_array( $raw_type, [ 'header', 'footer' ], true ) ? $raw_type : 'header';
		$active = isset( $_POST['active'] ) ? '1' : '0';

		if ( empty( $title ) ) {
			wp_die( esc_html__( 'Name is required', 'pedro-for-elementor-addons' ) );
		}

		wp_update_post(
			[
				'ID'         => $post_id,
				'post_title' => $title,
			]
		);

		update_post_meta( $post_id, '_pedroea_template_type', $type );
		update_post_meta( $post_id, '_pedroea_template_active', $active );

		wp_safe_redirect( admin_url( 'admin.php?page=pedroea_hfb' ) );
		exit;
	}

	public function type_column( $columns ) {
		$columns['pedroea_type']      = __( 'Type', 'pedro-for-elementor-addons' );
		$columns['pedroea_condition'] = __( 'Display', 'pedro-for-elementor-addons' );

		return $columns;
	}

	public function type_column_value( $column, $post_id ) {
		$type = get_post_meta( $post_id, '_pedroea_template_type', true ) ?: 'header';

		if ( 'pedroea_type' === $column ) {
			echo '<span class="pedroea-type-badge pedroea-type-badge-' . esc_attr( $type ) . '">' . esc_html( ucfirst( $type ) ) . '</span>';
		}

		if ( 'pedroea_condition' === $column ) {
			$condition = get_post_meta( $post_id, '_pedroea_template_condition', true ) ?: 'all';
			$labels    = $this->condition_labels();

			echo '<span class="pedroea-condition-badge">' . esc_html( $labels[ $condition ] ?? $condition ) . '</span>';

			$specific = get_post_meta( $post_id, '_pedroea_template_condition_specific', true );

			if ( 'specific' === $condition && $specific ) {
				echo ' <span class="pedroea-condition-sub">(' . esc_html( get_the_title( $specific ) ) . ')</span>';
			}
		}
	}

	public function add_condition_meta_box() {
		add_meta_box(
			'pedroea_template_condition',
			__( 'Display Condition', 'pedro-for-elementor-addons' ),
			[ $this, 'render_condition_meta_box' ],
			'pedroea_template',
			'side',
			'default'
		);
	}

	public function render_condition_meta_box( $post ) {
		wp_nonce_field( 'pedroea_condition_nonce', 'pedroea_condition_nonce' );

		$this->render_condition_fields( $post );
	}

	public function render_condition_fields( $post ) {
		$condition = get_post_meta( $post->ID, '_pedroea_template_condition', true ) ?: 'all';
		$specific  = get_post_meta( $post->ID, '_pedroea_template_condition_specific', true );
		$labels    = $this->condition_labels();

		include PEDROEA_PATH . 'header-footer-builder/templates/condition-meta-box.php';
	}

	public function save_condition_meta( $post_id ) {
		if ( ! isset( $_POST['pedroea_condition_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pedroea_condition_nonce'] ) ), 'pedroea_condition_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$raw_condition = isset( $_POST['pedroea_condition'] ) ? sanitize_key( wp_unslash( $_POST['pedroea_condition'] ) ) : '';
		$condition = in_array( $raw_condition, array_keys( $this->condition_labels() ), true )
			? $raw_condition
			: 'all';

		update_post_meta( $post_id, '_pedroea_template_condition', $condition );

		if ( 'specific' === $condition && ! empty( $_POST['pedroea_condition_specific'] ) ) {
			update_post_meta( $post_id, '_pedroea_template_condition_specific', intval( $_POST['pedroea_condition_specific'] ) );
		} else {
			delete_post_meta( $post_id, '_pedroea_template_condition_specific' );
		}
	}

	private function condition_labels() {
		return [
			'all'       => __( 'Entire Site', 'pedro-for-elementor-addons' ),
			'front'     => __( 'Front Page', 'pedro-for-elementor-addons' ),
			'all_pages' => __( 'All Pages', 'pedro-for-elementor-addons' ),
			'all_posts' => __( 'All Posts', 'pedro-for-elementor-addons' ),
			'singular'  => __( 'All Singular', 'pedro-for-elementor-addons' ),
			'specific'  => __( 'Specific Page', 'pedro-for-elementor-addons' ),
		];
	}

	private function check_condition( $post_id ) {
		$condition = get_post_meta( $post_id, '_pedroea_template_condition', true ) ?: 'all';

		switch ( $condition ) {
			case 'all':
				return true;

			case 'front':
				return is_front_page();

			case 'all_pages':
				return is_page();

			case 'all_posts':
				return is_singular( 'post' );

			case 'singular':
				return is_singular();

			case 'specific':
				$specific = get_post_meta( $post_id, '_pedroea_template_condition_specific', true );
				return $specific && is_singular() && get_queried_object_id() === (int) $specific;

			default:
				return false;
		}
	}

	private function get_active_id( $type ) {
		$posts = get_posts(
			[
				'post_type'      => 'pedroea_template',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
			'meta_query'     => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				[
					'key'   => '_pedroea_template_type',
					'value' => $type,
				],
				[
					'key'   => '_pedroea_template_active',
					'value' => '1',
				],
			],
				'orderby'        => 'date',
				'order'          => 'DESC',
			]
		);

		foreach ( $posts as $post ) {
			if ( $this->check_condition( $post->ID ) ) {
				return $post->ID;
			}
		}

		return null;
	}

	public function detect_and_enqueue() {
		if ( is_admin() || wp_doing_ajax() || is_singular( 'pedroea_template' ) ) {
			return;
		}

		$header_id = $this->get_active_id( 'header' );

		if ( $header_id ) {
			$GLOBALS['pedroea_header_id'] = $header_id;

			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				( new \Elementor\Core\Files\CSS\Post( $header_id ) )->enqueue();
			}

			do_action( 'elementor/post/render', $header_id ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			wp_enqueue_style( 'pedroea-header', PEDROEA_URL . 'assets/css/pedro-header.css', [], PEDROEA_VERSION );
		}

		$footer_id = $this->get_active_id( 'footer' );

		if ( $footer_id ) {
			$GLOBALS['pedroea_footer_id'] = $footer_id;

			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
				( new \Elementor\Core\Files\CSS\Post( $footer_id ) )->enqueue();
			}

			do_action( 'elementor/post/render', $footer_id ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			wp_enqueue_style( 'pedroea-footer', PEDROEA_URL . 'assets/css/pedro-footer.css', [], PEDROEA_VERSION );
		}
	}

	public function template_override( $template ) {
		if ( is_singular( 'pedroea_template' ) ) {
			return PEDROEA_PATH . 'header-footer-builder/templates/single-pedroea_template.php';
		}

		return $template;
	}

	public function body_class( $classes ) {
		if ( ! empty( $GLOBALS['pedroea_header_id'] ) ) {
			$classes[] = 'pedroea-header-active';
		}

		if ( ! empty( $GLOBALS['pedroea_footer_id'] ) ) {
			$classes[] = 'pedroea-footer-active';
		}

		return $classes;
	}

	public function render_header() {
		if ( empty( $GLOBALS['pedroea_header_id'] ) ) {
			return;
		}

		static $rendered = false;

		if ( $rendered ) {
			return;
		}

		$rendered = true;

		$content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $GLOBALS['pedroea_header_id'], true );

		if ( empty( $content ) ) {
			return;
		}

		echo '<div id="pedroea-header" class="pedroea-header-template">' . $content . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public function render_footer() {
		if ( empty( $GLOBALS['pedroea_footer_id'] ) ) {
			return;
		}

		$content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $GLOBALS['pedroea_footer_id'], true );

		if ( empty( $content ) ) {
			return;
		}

		echo '<div id="pedroea-footer" class="pedroea-footer-template">' . $content . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}