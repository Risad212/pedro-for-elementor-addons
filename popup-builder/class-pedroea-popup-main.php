<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class PedroEA_Popup_Main {

	private static $_instance = null;

	private $shortcode_ids = [];

	private $shortcode_overrides = [];

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
		add_action( 'admin_post_pedroea_popup_create', [ $this, 'handle_create' ] );
		add_action( 'admin_post_pedroea_popup_update', [ $this, 'handle_update' ] );
		add_action( 'admin_post_pedroea_popup_toggle', [ $this, 'handle_toggle' ] );
		add_action( 'admin_post_pedroea_popup_delete', [ $this, 'handle_delete' ] );
		add_action( 'add_meta_boxes', [ $this, 'add_condition_meta_box' ] );
		add_action( 'save_post_pedroea_popup', [ $this, 'save_condition_meta' ] );
		add_filter( 'manage_pedroea_popup_posts_columns', [ $this, 'type_column' ] );
		add_action( 'manage_pedroea_popup_posts_custom_column', [ $this, 'type_column_value' ], 10, 2 );
		add_action( 'template_redirect', [ $this, 'detect_and_enqueue' ] );
		add_filter( 'template_include', [ $this, 'template_override' ] );
		add_action( 'wp_footer', [ $this, 'render_popups' ] );
		add_shortcode( 'pedroea_popup', [ $this, 'render_shortcode' ] );
	}

	public function register_post_type() {
		register_post_type(
			'pedroea_popup',
			[
				'labels'          => [
					'name'          => __( 'Popups', 'pedro-for-elementor-addons' ),
					'singular_name' => __( 'Popup', 'pedro-for-elementor-addons' ),
					'add_new'       => __( 'Add Popup', 'pedro-for-elementor-addons' ),
					'add_new_item'  => __( 'Add New Popup', 'pedro-for-elementor-addons' ),
					'edit_item'     => __( 'Edit Popup', 'pedro-for-elementor-addons' ),
					'all_items'     => __( 'All Popups', 'pedro-for-elementor-addons' ),
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
		add_post_type_support( 'pedroea_popup', 'elementor' );
	}

	public function add_admin_menu() {
		add_submenu_page(
			'pedroea',
			__( 'Popup Builder', 'pedro-for-elementor-addons' ),
			__( 'Popup Builder', 'pedro-for-elementor-addons' ),
			'manage_options',
			'pedroea_popup',
			[ $this, 'render_dashboard' ]
		);
	}

	public function render_dashboard() {
		$edit_id = isset( $_GET['edit'] ) ? intval( wp_unslash( $_GET['edit'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( $edit_id && 'pedroea_popup' === get_post_type( $edit_id ) ) {
			$edit_post = get_post( $edit_id );
		} else {
			$edit_post = null;
		}

		$popups = get_posts(
			[
				'post_type'      => 'pedroea_popup',
				'posts_per_page' => -1,
				'post_status'    => [ 'publish', 'draft' ],
				'orderby'        => 'date',
				'order'          => 'DESC',
			]
		);

		$triggers = $this->trigger_labels();
		$new_url  = $edit_post ? admin_url( 'admin.php?page=pedroea_popup' ) : '#pedroea-new-popup';
		?>
		<div class="wrap pedroea-hfb-wrap pedroea-popup-wrap">
			<div class="p-header">
				<div>
					<h1><span class="dashicons dashicons-welcome-widgets-menus"></span> <?php esc_html_e( 'Popup Builder', 'pedro-for-elementor-addons' ); ?></h1>
					<p><?php esc_html_e( 'Create custom Elementor popups with smart triggers for your entire site.', 'pedro-for-elementor-addons' ); ?></p>
				</div>
				<div class="p-header-actions">
					<span class="p-badge">v<?php echo esc_html( PEDROEA_VERSION ); ?></span>
					<a href="<?php echo esc_url( $new_url ); ?>" class="p-btn-gradient">
						<span class="dashicons dashicons-plus-alt2"></span>
						<?php echo $edit_post ? esc_html__( 'All Popups', 'pedro-for-elementor-addons' ) : esc_html__( 'New Popup', 'pedro-for-elementor-addons' ); ?>
					</a>
				</div>
			</div>

			<div class="pedroea-shortcode-hint">
				<span class="dashicons dashicons-shortcode"></span>
				<p style="margin: 0; font-size: 13px; color: #374151;">
					<strong><?php esc_html_e( 'Shortcode:', 'pedro-for-elementor-addons' ); ?></strong>
					<code>[pedroea_popup id="POPUP_ID" trigger="click" text="Open Popup"]</code>
					<?php esc_html_e( '— place it in any page to show a trigger button, or use', 'pedro-for-elementor-addons' ); ?>
					<code>[pedroea_popup id="POPUP_ID" trigger="load" delay="2"]</code>
					<?php esc_html_e( 'to auto-open that popup on the page.', 'pedro-for-elementor-addons' ); ?>
				</p>
			</div>

			<?php if ( $edit_post ) : ?>
				<div class="p-form-card">
					<div class="p-form-card-header">
						<h2><span class="dashicons dashicons-edit"></span> <?php esc_html_e( 'Edit Popup', 'pedro-for-elementor-addons' ); ?></h2>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=pedroea_popup' ) ); ?>" class="p-btn-secondary p-btn-sm">&larr; <?php esc_html_e( 'Back', 'pedro-for-elementor-addons' ); ?></a>
					</div>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<input type="hidden" name="action" value="pedroea_popup_update">
						<input type="hidden" name="post_id" value="<?php echo esc_attr( $edit_post->ID ); ?>">
						<?php wp_nonce_field( 'pedroea_popup_update_nonce' ); ?>
						<div class="p-form-body pedroea-form">
							<div class="pedroea-section-title"><?php esc_html_e( 'Trigger & Behavior', 'pedro-for-elementor-addons' ); ?></div>
							<div class="pedroea-grid">
								<div class="pedroea-field pedroea-field--full">
									<label><?php esc_html_e( 'Popup Name', 'pedro-for-elementor-addons' ); ?></label>
									<input type="text" name="title" value="<?php echo esc_attr( $edit_post->post_title ); ?>" required>
								</div>
								<div class="pedroea-field pedroea-field--full">
									<label><?php esc_html_e( 'Trigger', 'pedro-for-elementor-addons' ); ?></label>
									<?php $edit_trigger = get_post_meta( $edit_post->ID, '_pedroea_popup_trigger', true ) ?: 'load'; ?>
									<div class="pedroea-trigger-pills" id="pedroea-trigger-pills">
										<?php $this->render_trigger_pills( $edit_trigger ); ?>
									</div>
									<div class="pedroea-trigger-note" id="pedroea-trigger-note"></div>
								</div>
								<div class="pedroea-field" data-trigger-fields="load"<?php echo 'load' !== $edit_trigger ? ' style="display:none;"' : ''; ?>>
									<label><?php esc_html_e( 'Delay (seconds)', 'pedro-for-elementor-addons' ); ?></label>
									<input type="number" min="0" step="1" name="trigger_delay" value="<?php echo esc_attr( get_post_meta( $edit_post->ID, '_pedroea_popup_trigger_delay', true ) ?: '0' ); ?>">
								</div>
								<div class="pedroea-field" data-trigger-fields="scroll"<?php echo 'scroll' !== $edit_trigger ? ' style="display:none;"' : ''; ?>>
									<label><?php esc_html_e( 'Scroll Percentage (%)', 'pedro-for-elementor-addons' ); ?></label>
									<input type="number" min="1" max="100" step="1" name="trigger_percent" value="<?php echo esc_attr( get_post_meta( $edit_post->ID, '_pedroea_popup_trigger_percent', true ) ?: '25' ); ?>">
								</div>
								<div class="pedroea-field" data-trigger-fields="click"<?php echo 'click' !== $edit_trigger ? ' style="display:none;"' : ''; ?>>
									<label><?php esc_html_e( 'Click Selector', 'pedro-for-elementor-addons' ); ?></label>
									<input type="text" name="trigger_selector" placeholder="<?php esc_attr_e( '.btn-open-popup', 'pedro-for-elementor-addons' ); ?>" value="<?php echo esc_attr( get_post_meta( $edit_post->ID, '_pedroea_popup_trigger_selector', true ) ); ?>">
								</div>
								<div class="pedroea-field">
									<label><?php esc_html_e( 'Width (px)', 'pedro-for-elementor-addons' ); ?></label>
									<input type="number" min="200" step="10" name="width" value="<?php echo esc_attr( get_post_meta( $edit_post->ID, '_pedroea_popup_width', true ) ?: '600' ); ?>">
								</div>
							</div>

							<div class="pedroea-section-title"><?php esc_html_e( 'Display', 'pedro-for-elementor-addons' ); ?></div>
							<div class="pedroea-grid">
								<div class="pedroea-field">
									<label for="pedroea-condition-select"><?php esc_html_e( 'Where to display', 'pedro-for-elementor-addons' ); ?></label>
									<?php $edit_condition = get_post_meta( $edit_post->ID, '_pedroea_popup_condition', true ) ?: 'all'; ?>
									<select name="pedroea_condition" id="pedroea-condition-select">
										<?php foreach ( $this->condition_labels() as $value => $label ) : ?>
											<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $edit_condition, $value ); ?>><?php echo esc_html( $label ); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="pedroea-field" id="pedroea-condition-specific-wrap"<?php echo 'specific' === $edit_condition ? '' : ' style="display:none;"'; ?>>
									<label for="pedroea-condition-specific-select"><?php esc_html_e( 'Specific Page / Post', 'pedro-for-elementor-addons' ); ?></label>
									<?php $specific = get_post_meta( $edit_post->ID, '_pedroea_popup_condition_specific', true ); ?>
									<?php include PEDROEA_PATH . 'popup-builder/templates/specific-select.php'; ?>
								</div>
							</div>

							<div class="pedroea-grid">
								<div class="pedroea-switch-row">
									<div class="pedroea-switch-label">
										<strong><?php esc_html_e( 'Once per visitor', 'pedro-for-elementor-addons' ); ?></strong>
										<span><?php esc_html_e( 'Show the popup only once per visitor.', 'pedro-for-elementor-addons' ); ?></span>
									</div>
									<label class="pedroea-switch">
										<input type="checkbox" name="once" value="1" <?php checked( '1', get_post_meta( $edit_post->ID, '_pedroea_popup_once', true ) ); ?>>
										<span class="pedroea-switch-slider"></span>
									</label>
								</div>
								<div class="pedroea-switch-row">
									<div class="pedroea-switch-label">
										<strong><?php esc_html_e( 'Active', 'pedro-for-elementor-addons' ); ?></strong>
										<span><?php esc_html_e( 'Enable this popup on the frontend.', 'pedro-for-elementor-addons' ); ?></span>
									</div>
									<label class="pedroea-switch">
										<input type="checkbox" name="active" value="1" <?php checked( '1', get_post_meta( $edit_post->ID, '_pedroea_popup_active', true ) ); ?>>
										<span class="pedroea-switch-slider"></span>
									</label>
								</div>
							</div>

							<div class="pedroea-form-actions">
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
				<div class="p-form-card" id="pedroea-new-popup">
					<div class="p-form-card-header">
						<h2><span class="dashicons dashicons-plus-alt2"></span> <?php esc_html_e( 'Create a New Popup', 'pedro-for-elementor-addons' ); ?></h2>
					</div>
					<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<input type="hidden" name="action" value="pedroea_popup_create">
						<?php wp_nonce_field( 'pedroea_popup_create_nonce' ); ?>
						<div class="p-form-body pedroea-form">
							<div class="pedroea-grid">
								<div class="pedroea-field">
									<label><?php esc_html_e( 'Popup Name', 'pedro-for-elementor-addons' ); ?></label>
									<input type="text" name="title" placeholder="<?php esc_attr_e( 'e.g. Newsletter Signup', 'pedro-for-elementor-addons' ); ?>" required>
								</div>
								<div class="pedroea-field">
									<label><?php esc_html_e( 'Trigger', 'pedro-for-elementor-addons' ); ?></label>
									<select name="trigger" required>
										<?php foreach ( $triggers as $value => $label ) : ?>
											<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="pedroea-form-actions">
								<button type="submit" class="p-btn-primary">
									<span class="dashicons dashicons-plus-alt2"></span>
									<?php esc_html_e( 'Create & Edit', 'pedro-for-elementor-addons' ); ?>
								</button>
							</div>
						</div>
					</form>
				</div>
			<?php endif; ?>

			<div class="p-card">
				<div class="p-card-header">
					<h2><span class="dashicons dashicons-welcome-widgets-menus"></span> <?php esc_html_e( 'Popups', 'pedro-for-elementor-addons' ); ?></h2>
					<span class="p-count"><?php echo count( $popups ); ?></span>
				</div>
				<div class="p-card-body">
					<?php $this->render_popup_list( $popups ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	private function render_popup_list( $posts ) {
		if ( empty( $posts ) ) {
			echo '<div class="p-empty"><span class="dashicons dashicons-welcome-widgets-menus"></span><p>' . esc_html__( 'No popups yet.', 'pedro-for-elementor-addons' ) . '</p></div>';
			return;
		}

		$popups          = $posts;
		$trigger_options = $this->trigger_options();
		$condition_labels = $this->condition_labels();

		include PEDROEA_PATH . 'popup-builder/templates/template-list.php';
	}

	public function handle_create() {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'pedroea_popup_create_nonce' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		$title   = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
		$raw_trigger = isset( $_POST['trigger'] ) ? sanitize_key( wp_unslash( $_POST['trigger'] ) ) : '';
		$trigger = array_key_exists( $raw_trigger, $this->trigger_labels() ) ? $raw_trigger : 'load';

		if ( empty( $title ) ) {
			wp_die( esc_html__( 'Name is required', 'pedro-for-elementor-addons' ) );
		}

		$post_id = wp_insert_post(
			[
				'post_type'   => 'pedroea_popup',
				'post_title'  => $title,
				'post_status' => 'publish',
				'meta_input'  => [
					'_pedroea_popup_trigger'       => $trigger,
					'_pedroea_popup_width'         => '600',
					'_pedroea_popup_trigger_delay' => '0',
					'_pedroea_popup_active'        => '1',
				],
			]
		);

		if ( is_wp_error( $post_id ) ) {
			wp_die( esc_html__( 'Could not create popup', 'pedro-for-elementor-addons' ) );
		}

		wp_safe_redirect( admin_url( 'post.php?post=' . $post_id . '&action=elementor' ) );
		exit;
	}

	public function handle_toggle() {
		$post_id = isset( $_GET['post_id'] ) ? intval( wp_unslash( $_GET['post_id'] ) ) : 0;

		if ( ! $post_id || ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'pedroea_popup_toggle_' . $post_id ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( 'pedroea_popup' !== get_post_type( $post_id ) ) {
			wp_die( esc_html__( 'Invalid popup', 'pedro-for-elementor-addons' ) );
		}

		$current = get_post_meta( $post_id, '_pedroea_popup_active', true );
		$new     = '1' === $current ? '0' : '1';

		update_post_meta( $post_id, '_pedroea_popup_active', $new );

		wp_safe_redirect( admin_url( 'admin.php?page=pedroea_popup' ) );
		exit;
	}

	public function handle_delete() {
		$post_id = isset( $_GET['post_id'] ) ? intval( wp_unslash( $_GET['post_id'] ) ) : 0;

		if ( ! $post_id || ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'pedroea_popup_delete_' . $post_id ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( 'pedroea_popup' !== get_post_type( $post_id ) ) {
			wp_die( esc_html__( 'Invalid popup', 'pedro-for-elementor-addons' ) );
		}

		wp_delete_post( $post_id, true );

		wp_safe_redirect( admin_url( 'admin.php?page=pedroea_popup' ) );
		exit;
	}

	public function handle_update() {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'pedroea_popup_update_nonce' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		$post_id = isset( $_POST['post_id'] ) ? intval( wp_unslash( $_POST['post_id'] ) ) : 0;

		if ( ! $post_id || 'pedroea_popup' !== get_post_type( $post_id ) ) {
			wp_die( esc_html__( 'Invalid popup', 'pedro-for-elementor-addons' ) );
		}

		$title = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';

		if ( empty( $title ) ) {
			wp_die( esc_html__( 'Name is required', 'pedro-for-elementor-addons' ) );
		}

		$raw_trigger = isset( $_POST['trigger'] ) ? sanitize_key( wp_unslash( $_POST['trigger'] ) ) : '';
		$trigger = array_key_exists( $raw_trigger, $this->trigger_labels() ) ? $raw_trigger : 'load';

		wp_update_post(
			[
				'ID'         => $post_id,
				'post_title' => $title,
			]
		);

		update_post_meta( $post_id, '_pedroea_popup_trigger', $trigger );
		update_post_meta( $post_id, '_pedroea_popup_trigger_delay', isset( $_POST['trigger_delay'] ) ? intval( $_POST['trigger_delay'] ) : 0 );
		update_post_meta( $post_id, '_pedroea_popup_trigger_percent', isset( $_POST['trigger_percent'] ) ? intval( $_POST['trigger_percent'] ) : 25 );
		update_post_meta( $post_id, '_pedroea_popup_trigger_selector', isset( $_POST['trigger_selector'] ) ? sanitize_text_field( wp_unslash( $_POST['trigger_selector'] ) ) : '' );
		update_post_meta( $post_id, '_pedroea_popup_width', isset( $_POST['width'] ) ? intval( wp_unslash( $_POST['width'] ) ) : 600 );
		update_post_meta( $post_id, '_pedroea_popup_once', isset( $_POST['once'] ) ? '1' : '0' );
		update_post_meta( $post_id, '_pedroea_popup_active', isset( $_POST['active'] ) ? '1' : '0' );

		$raw_condition = isset( $_POST['pedroea_condition'] ) ? sanitize_key( wp_unslash( $_POST['pedroea_condition'] ) ) : '';
		$condition = in_array( $raw_condition, array_keys( $this->condition_labels() ), true )
			? $raw_condition
			: 'all';

		update_post_meta( $post_id, '_pedroea_popup_condition', $condition );

		if ( 'specific' === $condition && ! empty( $_POST['pedroea_condition_specific'] ) ) {
			update_post_meta( $post_id, '_pedroea_popup_condition_specific', intval( $_POST['pedroea_condition_specific'] ) );
		} else {
			delete_post_meta( $post_id, '_pedroea_popup_condition_specific' );
		}

		wp_safe_redirect( admin_url( 'admin.php?page=pedroea_popup' ) );
		exit;
	}

	public function type_column( $columns ) {
		$columns['pedroea_trigger']   = __( 'Trigger', 'pedro-for-elementor-addons' );
		$columns['pedroea_condition'] = __( 'Display', 'pedro-for-elementor-addons' );

		return $columns;
	}

	public function type_column_value( $column, $post_id ) {
		if ( 'pedroea_trigger' === $column ) {
			$trigger = get_post_meta( $post_id, '_pedroea_popup_trigger', true ) ?: 'load';
			$labels  = $this->trigger_labels();

			echo '<span class="pedroea-popup-type-badge pedroea-popup-trigger-' . esc_attr( $trigger ) . '">' . esc_html( $labels[ $trigger ] ?? $trigger ) . '</span>';
		}

		if ( 'pedroea_condition' === $column ) {
			$condition = get_post_meta( $post_id, '_pedroea_popup_condition', true ) ?: 'all';
			$labels    = $this->condition_labels();

			echo '<span class="pedroea-condition-badge">' . esc_html( $labels[ $condition ] ?? $condition ) . '</span>';

			$specific = get_post_meta( $post_id, '_pedroea_popup_condition_specific', true );

			if ( 'specific' === $condition && $specific ) {
				echo ' <span class="pedroea-condition-sub">(' . esc_html( get_the_title( $specific ) ) . ')</span>';
			}
		}
	}

	public function add_condition_meta_box() {
		add_meta_box(
			'pedroea_popup_condition',
			__( 'Display Condition', 'pedro-for-elementor-addons' ),
			[ $this, 'render_condition_meta_box' ],
			'pedroea_popup',
			'side',
			'default'
		);
	}

	public function render_condition_meta_box( $post ) {
		wp_nonce_field( 'pedroea_popup_condition_nonce', 'pedroea_popup_condition_nonce' );

		$this->render_condition_fields( $post );
	}

	public function render_condition_fields( $post ) {
		$condition = get_post_meta( $post->ID, '_pedroea_popup_condition', true ) ?: 'all';
		$specific  = get_post_meta( $post->ID, '_pedroea_popup_condition_specific', true );
		$labels    = $this->condition_labels();

		include PEDROEA_PATH . 'popup-builder/templates/condition-meta-box.php';
	}

	public function save_condition_meta( $post_id ) {
		if ( ! isset( $_POST['pedroea_popup_condition_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pedroea_popup_condition_nonce'] ) ), 'pedroea_popup_condition_nonce' ) ) {
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

		update_post_meta( $post_id, '_pedroea_popup_condition', $condition );

		if ( 'specific' === $condition && ! empty( $_POST['pedroea_condition_specific'] ) ) {
			update_post_meta( $post_id, '_pedroea_popup_condition_specific', intval( $_POST['pedroea_condition_specific'] ) );
		} else {
			delete_post_meta( $post_id, '_pedroea_popup_condition_specific' );
		}
	}

	private function trigger_options() {
		return [
			'load'   => [
				'label' => __( 'Page Load', 'pedro-for-elementor-addons' ),
				'icon'  => 'dashicons-desktop',
				'desc'  => __( 'Opens automatically when the page loads, after an optional delay.', 'pedro-for-elementor-addons' ),
			],
			'scroll' => [
				'label' => __( 'On Scroll', 'pedro-for-elementor-addons' ),
				'icon'  => 'dashicons-arrow-down-alt',
				'desc'  => __( 'Opens after the visitor scrolls through a percentage of the page.', 'pedro-for-elementor-addons' ),
			],
			'click'  => [
				'label' => __( 'On Click', 'pedro-for-elementor-addons' ),
				'icon'  => 'dashicons-button',
				'desc'  => __( 'Opens when a matching element is clicked. Add the CSS selector below.', 'pedro-for-elementor-addons' ),
			],
			'exit'   => [
				'label' => __( 'Exit Intent', 'pedro-for-elementor-addons' ),
				'icon'  => 'dashicons-external',
				'desc'  => __( 'Opens when the mouse leaves the top of the viewport (exit intent).', 'pedro-for-elementor-addons' ),
			],
		];
	}

	private function trigger_labels() {
		$labels = [];

		foreach ( $this->trigger_options() as $key => $option ) {
			$labels[ $key ] = $option['label'];
		}

		return $labels;
	}

	private function render_trigger_pills( $selected = 'load', $name = 'trigger' ) {
		foreach ( $this->trigger_options() as $value => $option ) {
			?>
			<label class="pedroea-trigger-pill<?php echo $selected === $value ? ' is-selected' : ''; ?>">
				<input type="radio" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php checked( $selected, $value ); ?> data-desc="<?php echo esc_attr( $option['desc'] ); ?>">
				<span class="dashicons <?php echo esc_attr( $option['icon'] ); ?>"></span>
				<span class="pedroea-trigger-pill-label"><?php echo esc_html( $option['label'] ); ?></span>
			</label>
			<?php
		}
	}

	private function condition_labels() {
		return [
			'all'       => __( 'Entire Site', 'pedro-for-elementor-addons' ),
			'front'     => __( 'Front Page', 'pedro-for-elementor-addons' ),
			'all_pages' => __( 'All Pages', 'pedro-for-elementor-addons' ),
			'all_posts' => __( 'All Posts', 'pedro-for-elementor-addons' ),
			'singular'  => __( 'All Singular', 'pedro-for-elementor-addons' ),
			'specific'  => __( 'Specific Page / Post', 'pedro-for-elementor-addons' ),
		];
	}

	private function check_condition( $post_id ) {
		$condition = get_post_meta( $post_id, '_pedroea_popup_condition', true ) ?: 'all';

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
				$specific = get_post_meta( $post_id, '_pedroea_popup_condition_specific', true );
				return $specific && is_singular() && get_queried_object_id() === (int) $specific;

			default:
				return false;
		}
	}

	private function get_active_popups() {
		$posts = get_posts(
			[
				'post_type'      => 'pedroea_popup',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
			'meta_key'       => '_pedroea_popup_active', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'     => '1', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'orderby'        => 'date',
				'order'          => 'DESC',
			]
		);

		$ids = [];

		foreach ( $posts as $post ) {
			if ( $this->check_condition( $post->ID ) ) {
				$ids[] = $post->ID;
			}
		}

		return $ids;
	}

	public function detect_and_enqueue() {
		if ( is_admin() || wp_doing_ajax() || is_singular( 'pedroea_popup' ) ) {
			return;
		}

		$ids = $this->get_active_popups();

		if ( empty( $ids ) ) {
			return;
		}

		$GLOBALS['pedroea_popups'] = $ids;

		foreach ( $ids as $id ) {
			$this->enqueue_popup_assets( $id );
		}
	}

	public function template_override( $template ) {
		if ( is_singular( 'pedroea_popup' ) ) {
			return PEDROEA_PATH . 'popup-builder/templates/single-pedroea_popup.php';
		}

		return $template;
	}

	/**
	 * Enqueue popup CSS/JS and the Elementor CSS for a given popup.
	 *
	 * @param int $popup_id
	 */
	private function enqueue_popup_assets( $popup_id = 0 ) {
		if ( $popup_id && class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
			( new \Elementor\Core\Files\CSS\Post( $popup_id ) )->enqueue();
		}

		static $done = false;

		if ( $done ) {
			return;
		}

		$done = true;

		wp_enqueue_style( 'pedroea-popup', PEDROEA_URL . 'assets/css/pedroea-popup.css', [], PEDROEA_VERSION );
		wp_enqueue_script( 'pedroea-popup', PEDROEA_URL . 'assets/js/pedroea-popup.js', [ 'jquery' ], PEDROEA_VERSION, true );
	}

	/**
	 * Build the popup overlay markup for a popup.
	 *
	 * @param int   $popup_id
	 * @param array $overrides Optional override of trigger/delay/width etc. used by the shortcode.
	 *
	 * @return string
	 */
	private function get_popup_markup( $popup_id, $overrides = [] ) {
		$content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $popup_id, true );

		if ( empty( $content ) ) {
			return '';
		}

		$trigger = isset( $overrides['trigger'] ) ? $overrides['trigger'] : ( get_post_meta( $popup_id, '_pedroea_popup_trigger', true ) ?: 'load' );
		$width   = isset( $overrides['width'] ) ? $overrides['width'] : (int) ( get_post_meta( $popup_id, '_pedroea_popup_width', true ) ?: 600 );
		$delay   = isset( $overrides['delay'] ) ? $overrides['delay'] : (int) get_post_meta( $popup_id, '_pedroea_popup_trigger_delay', true );

		$attrs = [
			'data-popup-id' => $popup_id,
			'data-trigger'  => $trigger,
			'data-once'     => '1' === get_post_meta( $popup_id, '_pedroea_popup_once', true ) ? '1' : '0',
		];

		if ( 'load' === $trigger ) {
			$attrs['data-delay'] = $delay;
		}

		if ( 'scroll' === $trigger ) {
			$attrs['data-percent'] = (int) get_post_meta( $popup_id, '_pedroea_popup_trigger_percent', true );
		}

		if ( 'click' === $trigger ) {
			$selector = isset( $overrides['selector'] ) ? $overrides['selector'] : get_post_meta( $popup_id, '_pedroea_popup_trigger_selector', true );

			if ( $selector ) {
				$attrs['data-selector'] = $selector;
			}
		}

		$attr_string = '';

		foreach ( $attrs as $key => $value ) {
			$attr_string .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}

		ob_start();
		?>
		<div class="pedroea-popup-overlay"<?php echo $attr_string; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
			<div class="pedroea-popup-inner" style="max-width: <?php echo esc_attr( (int) $width ); ?>px;">
				<button type="button" class="pedroea-popup-close" aria-label="<?php esc_attr_e( 'Close', 'pedro-for-elementor-addons' ); ?>">&times;</button>
				<div class="pedroea-popup-content"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Shortcode: [pedroea_popup id="123" trigger="click|load" text="Open" delay="0"]
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public function render_shortcode( $atts ) {
		$atts = shortcode_atts(
			[
				'id'      => 0,
				'trigger' => 'click',
				'text'    => '',
				'delay'   => 0,
				'width'   => 0,
			],
			$atts,
			'pedroea_popup'
		);

		$id = absint( $atts['id'] );

		if ( ! $id || 'pedroea_popup' !== get_post_type( $id ) ) {
			return '';
		}

		$trigger = in_array( $atts['trigger'], [ 'load', 'click' ], true ) ? $atts['trigger'] : 'click';

		$this->shortcode_ids[] = $id;
		$this->enqueue_popup_assets( $id );

		if ( 'load' === $trigger ) {
			$overrides = [ 'trigger' => 'load', 'delay' => absint( $atts['delay'] ) ];

			if ( absint( $atts['width'] ) ) {
				$overrides['width'] = absint( $atts['width'] );
			}

			$this->shortcode_overrides[ $id ] = $overrides;

			return '';
		}

		$this->shortcode_overrides[ $id ] = [ 'trigger' => 'click' ];

		$text = $atts['text'] ?: __( 'Open Popup', 'pedro-for-elementor-addons' );

		return '<button type="button" class="pedroea-popup-trigger" data-popup-trigger="' . esc_attr( $id ) . '">' . esc_html( $text ) . '</button>';
	}

	public function render_popups() {
		$ids = [];

		if ( ! empty( $GLOBALS['pedroea_popups'] ) && is_array( $GLOBALS['pedroea_popups'] ) ) {
			$ids = $GLOBALS['pedroea_popups'];
		}

		foreach ( $this->shortcode_ids as $id ) {
			if ( ! in_array( $id, $ids, true ) ) {
				$ids[] = $id;
			}
		}

		if ( empty( $ids ) ) {
			return;
		}

		foreach ( $ids as $popup_id ) {
			$overrides = isset( $this->shortcode_overrides[ $popup_id ] ) ? $this->shortcode_overrides[ $popup_id ] : [];

			echo $this->get_popup_markup( $popup_id, $overrides ); // phpcs:ignore WordPress.Security.EscapeOutput
		}
	}
}
