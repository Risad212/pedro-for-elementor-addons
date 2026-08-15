<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class PedroEA_Theme_Builder {

	const CPT = 'pedroea_tb_template';

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
		add_action( 'admin_post_pedroea_tb_create', [ $this, 'handle_create' ] );
		add_action( 'admin_post_pedroea_tb_update', [ $this, 'handle_update' ] );
		add_action( 'admin_post_pedroea_tb_toggle', [ $this, 'handle_toggle' ] );
		add_action( 'admin_post_pedroea_tb_delete', [ $this, 'handle_delete' ] );
		add_action( 'wp_ajax_pedroea_tb_search_posts', [ $this, 'ajax_search_posts' ] );
		add_action( 'add_meta_boxes', [ $this, 'add_condition_meta_box' ] );
		add_action( 'save_post_' . self::CPT, [ $this, 'save_condition_meta' ] );
		add_filter( 'manage_' . self::CPT . '_posts_columns', [ $this, 'type_column' ] );
		add_action( 'manage_' . self::CPT . '_posts_custom_column', [ $this, 'type_column_value' ], 10, 2 );
		add_action( 'template_redirect', [ $this, 'detect_and_enqueue' ] );
		add_filter( 'template_include', [ $this, 'template_override' ] );
		add_filter( 'body_class', [ $this, 'body_class' ] );
	}

	public function register_post_type() {
		register_post_type(
			self::CPT,
			[
				'labels'          => [
					'name'          => __( 'Theme Templates', 'pedro-for-elementor-addons' ),
					'singular_name' => __( 'Theme Template', 'pedro-for-elementor-addons' ),
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
		add_post_type_support( self::CPT, 'elementor' );
	}

	public function add_admin_menu() {
		add_submenu_page(
			'pedroea',
			__( 'Theme Builder', 'pedro-for-elementor-addons' ),
			__( 'Theme Builder', 'pedro-for-elementor-addons' ),
			'manage_options',
			'pedroea_tb',
			[ $this, 'render_dashboard' ]
		);
	}

	public function render_dashboard() {
		$edit_id = isset( $_GET['edit'] ) ? intval( wp_unslash( $_GET['edit'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( $edit_id && self::CPT === get_post_type( $edit_id ) ) {
			$edit_post = get_post( $edit_id );
		} else {
			$edit_post = null;
		}

		$templates = get_posts(
			[
				'post_type'      => self::CPT,
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
					<h1><span class="dashicons dashicons-admin-customizer"></span> <?php esc_html_e( 'Theme Builder', 'pedro-for-elementor-addons' ); ?></h1>
					<p><?php esc_html_e( 'Design single posts, pages and any post type with Elementor.', 'pedro-for-elementor-addons' ); ?></p>
				</div>
				<span class="p-badge">v<?php echo esc_html( PEDROEA_VERSION ); ?></span>
			</div>

			<?php if ( $edit_post ) : ?>
				<div class="p-form-card">
					<div class="p-form-card-header">
						<h2><span class="dashicons dashicons-edit"></span> <?php esc_html_e( 'Edit Template', 'pedro-for-elementor-addons' ); ?></h2>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=pedroea_tb' ) ); ?>" class="p-btn-secondary p-btn-sm">&larr; <?php esc_html_e( 'Back', 'pedro-for-elementor-addons' ); ?></a>
					</div>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<input type="hidden" name="action" value="pedroea_tb_update">
						<input type="hidden" name="post_id" value="<?php echo esc_attr( $edit_post->ID ); ?>">
						<?php wp_nonce_field( 'pedroea_tb_update_nonce' ); ?>
						<div class="p-form-body">
							<div class="p-field">
								<label><?php esc_html_e( 'Template Name', 'pedro-for-elementor-addons' ); ?></label>
								<input type="text" name="title" value="<?php echo esc_attr( $edit_post->post_title ); ?>" required>
							</div>
							<div class="p-field">
								<label><?php esc_html_e( 'Type', 'pedro-for-elementor-addons' ); ?></label>
								<?php $edit_type = get_post_meta( $edit_post->ID, '_pedroea_tb_type', true ) ?: 'single'; ?>
								<select name="type" required>
									<option value="single" <?php selected( $edit_type, 'single' ); ?>><?php esc_html_e( 'Single Post', 'pedro-for-elementor-addons' ); ?></option>
								</select>
							</div>

							<div class="p-field p-field-checkbox">
								<label>
									<input type="checkbox" name="active" value="1" <?php checked( '1', get_post_meta( $edit_post->ID, '_pedroea_tb_active', true ) ); ?>>
									<?php esc_html_e( 'Active', 'pedro-for-elementor-addons' ); ?>
								</label>
							</div>

							<?php $this->render_condition_fields( $edit_post ); ?>

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
						<input type="hidden" name="action" value="pedroea_tb_create">
						<?php wp_nonce_field( 'pedroea_tb_create_nonce' ); ?>
						<div class="p-form-body">
							<div class="p-field">
								<label><?php esc_html_e( 'Template Name', 'pedro-for-elementor-addons' ); ?></label>
								<input type="text" name="title" placeholder="<?php esc_attr_e( 'e.g. Blog Post Design', 'pedro-for-elementor-addons' ); ?>" required>
							</div>
							<div class="p-field">
								<label><?php esc_html_e( 'Type', 'pedro-for-elementor-addons' ); ?></label>
								<select name="type" required>
									<option value="single"><?php esc_html_e( 'Single Post', 'pedro-for-elementor-addons' ); ?></option>
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
					<h2><span class="dashicons dashicons-admin-customizer"></span> <?php esc_html_e( 'Templates', 'pedro-for-elementor-addons' ); ?></h2>
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
			echo '<div class="p-empty"><span class="dashicons dashicons-admin-customizer"></span><p>' . esc_html__( 'No templates yet.', 'pedro-for-elementor-addons' ) . '</p></div>';
			return;
		}

		$templates = $posts;
		include PEDROEA_PATH . 'theme-builder/templates/template-list.php';
	}

	public function handle_create() {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'pedroea_tb_create_nonce' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		$title = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';

		if ( empty( $title ) ) {
			wp_die( esc_html__( 'Name is required', 'pedro-for-elementor-addons' ) );
		}

		$post_id = wp_insert_post(
			[
				'post_type'   => self::CPT,
				'post_title'  => $title,
				'post_status' => 'publish',
				'meta_input'  => [
					'_pedroea_tb_type'   => 'single',
					'_pedroea_tb_active' => '1',
					'_pedroea_tb_condition' => 'all',
				],
			]
		);

		if ( is_wp_error( $post_id ) ) {
			wp_die( esc_html__( 'Could not create template', 'pedro-for-elementor-addons' ) );
		}

		wp_safe_redirect( admin_url( 'post.php?post=' . $post_id . '&action=elementor' ) );
		exit;
	}

	public function handle_toggle() {
		$post_id = isset( $_GET['post_id'] ) ? intval( wp_unslash( $_GET['post_id'] ) ) : 0;

		if ( ! $post_id || ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'pedroea_tb_toggle_' . $post_id ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( self::CPT !== get_post_type( $post_id ) ) {
			wp_die( esc_html__( 'Invalid template', 'pedro-for-elementor-addons' ) );
		}

		$current = get_post_meta( $post_id, '_pedroea_tb_active', true );
		$new     = '1' === $current ? '0' : '1';

		update_post_meta( $post_id, '_pedroea_tb_active', $new );

		wp_safe_redirect( admin_url( 'admin.php?page=pedroea_tb' ) );
		exit;
	}

	public function handle_delete() {
		$post_id = isset( $_GET['post_id'] ) ? intval( wp_unslash( $_GET['post_id'] ) ) : 0;

		if ( ! $post_id || ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'pedroea_tb_delete_' . $post_id ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( self::CPT !== get_post_type( $post_id ) ) {
			wp_die( esc_html__( 'Invalid template', 'pedro-for-elementor-addons' ) );
		}

		wp_delete_post( $post_id, true );

		wp_safe_redirect( admin_url( 'admin.php?page=pedroea_tb' ) );
		exit;
	}

	public function handle_update() {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'pedroea_tb_update_nonce' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		$post_id = isset( $_POST['post_id'] ) ? intval( wp_unslash( $_POST['post_id'] ) ) : 0;

		if ( ! $post_id || self::CPT !== get_post_type( $post_id ) ) {
			wp_die( esc_html__( 'Invalid template', 'pedro-for-elementor-addons' ) );
		}

		$title = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';

		if ( empty( $title ) ) {
			wp_die( esc_html__( 'Name is required', 'pedro-for-elementor-addons' ) );
		}

		wp_update_post(
			[
				'ID'         => $post_id,
				'post_title' => $title,
			]
		);

		$raw_type = isset( $_POST['type'] ) ? sanitize_key( wp_unslash( $_POST['type'] ) ) : '';
		update_post_meta( $post_id, '_pedroea_tb_type', in_array( $raw_type, [ 'single' ], true ) ? $raw_type : 'single' );
		update_post_meta( $post_id, '_pedroea_tb_active', isset( $_POST['active'] ) ? '1' : '0' );
		$this->save_condition_fields( $post_id );

		wp_safe_redirect( admin_url( 'admin.php?page=pedroea_tb' ) );
		exit;
	}

	public function ajax_search_posts() {
		check_ajax_referer( 'pedroea_tb_search_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		$q    = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
		$type = isset( $_GET['post_type'] ) ? sanitize_key( wp_unslash( $_GET['post_type'] ) ) : '';

		if ( ! array_key_exists( $type, $this->get_public_post_types() ) ) {
			$type = 'post';
		}

		$args = [
			'post_type'      => $type,
			'post_status'    => 'publish',
			'posts_per_page' => 20,
			'orderby'        => 'title',
			'order'          => 'ASC',
		];

		if ( '' !== $q ) {
			$args['s'] = $q;
		}

		$results = [];

		foreach ( get_posts( $args ) as $post ) {
			$results[] = [
				'id'    => $post->ID,
				'title' => $post->post_title,
			];
		}

		wp_send_json_success( $results );
	}

	public function type_column( $columns ) {
		$columns['pedroea_type']      = __( 'Type', 'pedro-for-elementor-addons' );
		$columns['pedroea_condition'] = __( 'Display', 'pedro-for-elementor-addons' );

		return $columns;
	}

	public function type_column_value( $column, $post_id ) {
		if ( 'pedroea_type' === $column ) {
			$type = get_post_meta( $post_id, '_pedroea_tb_type', true ) ?: 'single';

			echo '<span class="pedroea-type-badge pedroea-type-badge-' . esc_attr( $type ) . '">' . esc_html( ucfirst( str_replace( '_', ' ', $type ) ) ) . '</span>';
		}

		if ( 'pedroea_condition' === $column ) {
			echo '<span class="pedroea-condition-badge">' . esc_html( $this->display_summary( $post_id ) ) . '</span>';
		}
	}

	public function add_condition_meta_box() {
		add_meta_box(
			'pedroea_tb_condition',
			__( 'Display Condition', 'pedro-for-elementor-addons' ),
			[ $this, 'render_condition_meta_box' ],
			self::CPT,
			'side',
			'default'
		);
	}

	public function render_condition_meta_box( $post ) {
		wp_nonce_field( 'pedroea_tb_condition_nonce', 'pedroea_tb_condition_nonce' );

		$this->render_condition_fields( $post );
	}

	public function render_condition_fields( $post ) {
		$condition = get_post_meta( $post->ID, '_pedroea_tb_condition', true ) ?: 'all';
		$condition_type = get_post_meta( $post->ID, '_pedroea_tb_condition_type', true ) ?: 'post';
		$specific = get_post_meta( $post->ID, '_pedroea_tb_condition_specific', true );
		$labels = $this->condition_labels();
		$post_types = $this->get_public_post_types();

		include PEDROEA_PATH . 'theme-builder/templates/condition-meta-box.php';
	}

	public function save_condition_meta( $post_id ) {
		if ( ! isset( $_POST['pedroea_tb_condition_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pedroea_tb_condition_nonce'] ) ), 'pedroea_tb_condition_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$this->save_condition_fields( $post_id );
	}

	private function save_condition_fields( $post_id ) {
		$raw_condition = isset( $_POST['pedroea_tb_condition'] ) ? sanitize_key( wp_unslash( $_POST['pedroea_tb_condition'] ) ) : '';
		$condition = in_array( $raw_condition, array_keys( $this->condition_labels() ), true )
			? $raw_condition
			: 'all';

		update_post_meta( $post_id, '_pedroea_tb_condition', $condition );

		$raw_type = isset( $_POST['pedroea_tb_condition_type'] ) ? sanitize_key( wp_unslash( $_POST['pedroea_tb_condition_type'] ) ) : '';
		$condition_type = array_key_exists( $raw_type, $this->get_public_post_types() ) ? $raw_type : 'post';

		update_post_meta( $post_id, '_pedroea_tb_condition_type', $condition_type );

		if ( 'specific' === $condition && ! empty( $_POST['pedroea_tb_condition_specific'] ) ) {
			update_post_meta( $post_id, '_pedroea_tb_condition_specific', intval( $_POST['pedroea_tb_condition_specific'] ) );
		} else {
			delete_post_meta( $post_id, '_pedroea_tb_condition_specific' );
		}
	}

	private function condition_labels() {
		return [
			'all'       => __( 'All Singular Content', 'pedro-for-elementor-addons' ),
			'post_type' => __( 'All Posts of a Type', 'pedro-for-elementor-addons' ),
			'specific'  => __( 'Specific Post', 'pedro-for-elementor-addons' ),
		];
	}

	private function get_public_post_types() {
		$types   = get_post_types( [ 'public' => true ], 'objects' );
		$exclude = [ 'attachment', 'elementor_library', self::CPT, 'pedroea_template', 'pedroea_popup' ];
		$list    = [];

		foreach ( $types as $type ) {
			if ( in_array( $type->name, $exclude, true ) ) {
				continue;
			}

			$list[ $type->name ] = $type->labels->singular_name;
		}

		return $list;
	}

	private function display_summary( $post_id ) {
		$condition = get_post_meta( $post_id, '_pedroea_tb_condition', true ) ?: 'all';
		$labels    = $this->condition_labels();
		$label     = isset( $labels[ $condition ] ) ? $labels[ $condition ] : $condition;

		if ( 'post_type' === $condition ) {
			$type  = get_post_meta( $post_id, '_pedroea_tb_condition_type', true );
			$names = $this->get_public_post_types();

			$label .= ' (' . ( isset( $names[ $type ] ) ? $names[ $type ] : $type ) . ')';
		}

		if ( 'specific' === $condition ) {
			$specific = get_post_meta( $post_id, '_pedroea_tb_condition_specific', true );

			if ( $specific ) {
				$label .= ' (' . get_the_title( $specific ) . ')';
			}
		}

		return $label;
	}

	private function get_matching_single_id() {
		$post_id = get_queried_object_id();
		$type    = get_post_type( $post_id );

		if ( ! $type ) {
			return null;
		}

		$templates = get_posts(
			[
				'post_type'      => self::CPT,
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'meta_query'     => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
					'relation' => 'AND',
					[
						'key'   => '_pedroea_tb_type',
						'value' => 'single',
					],
					[
						'key'   => '_pedroea_tb_active',
						'value' => '1',
					],
				],
				'orderby'        => 'modified',
				'order'          => 'DESC',
			]
		);

		$best       = null;
		$best_score = -1;

		foreach ( $templates as $template ) {
			$score = $this->match_score( $template->ID, $post_id, $type );

			if ( $score > $best_score ) {
				$best_score = $score;
				$best       = $template->ID;
			}
		}

		return $best;
	}

	private function match_score( $template_id, $post_id, $post_type ) {
		$condition = get_post_meta( $template_id, '_pedroea_tb_condition', true ) ?: 'all';

		switch ( $condition ) {
			case 'all':
				return 0;

			case 'post_type':
				$type = get_post_meta( $template_id, '_pedroea_tb_condition_type', true );
				return ( $type && $type === $post_type ) ? 1 : -1;

			case 'specific':
				$specific = get_post_meta( $template_id, '_pedroea_tb_condition_specific', true );
				return ( $specific && (int) $specific === (int) $post_id ) ? 2 : -1;

			default:
				return -1;
		}
	}

	public function detect_and_enqueue() {
		if ( is_admin() || wp_doing_ajax() || is_singular( self::CPT ) || $this->is_elementor_preview() ) {
			return;
		}

		if ( ! is_singular() ) {
			return;
		}

		$template_id = $this->get_matching_single_id();

		if ( ! $template_id ) {
			return;
		}

		$GLOBALS['pedroea_tb_template_id'] = $template_id;

		if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
			( new \Elementor\Core\Files\CSS\Post( $template_id ) )->enqueue();
		}

		do_action( 'elementor/post/render', $template_id ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
	}

	public function template_override( $template ) {
		if ( $this->is_elementor_preview() ) {
			return $template;
		}

		if ( is_singular( self::CPT ) ) {
			return PEDROEA_PATH . 'theme-builder/templates/single-pedroea_tb_template.php';
		}

		if ( is_singular() && ! empty( $GLOBALS['pedroea_tb_template_id'] ) ) {
			return PEDROEA_PATH . 'theme-builder/templates/single-page.php';
		}

		return $template;
	}

	private function is_elementor_preview() {
		return class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode();
	}

	public function body_class( $classes ) {
		if ( ! empty( $GLOBALS['pedroea_tb_template_id'] ) ) {
			$classes[] = 'pedroea-tb-single-active';
		}

		return $classes;
	}
}
