<?php
/**
 * Widget Manager dashboard view.
 *
 * Provides $widgets, $disabled, $total_count, $enabled_count and
 * $disabled_count via Widget_Manager::render_page().
 *
 * @package pedro-for-elementor-addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<div class="wrap pedroea-wm-wrap">
	<div class="pedroea-wm-hero">
		<div class="pedroea-wm-hero-title">
			<span class="dashicons dashicons-building"></span>
			<div>
				<h1><?php esc_html_e( 'Pedro for Elementor Addons', 'pedro-for-elementor-addons' ); ?></h1>
				<p><?php esc_html_e( 'Enable or disable any widget. Disabled widgets stay hidden from the Elementor editor and never load on the front end.', 'pedro-for-elementor-addons' ); ?></p>
			</div>
		</div>
		<span class="pedroea-wm-hero-badge"><?php echo esc_html( PEDROEA_VERSION ); ?></span>
	</div>

	<div class="pedroea-wm-stats">
		<div class="pedroea-wm-stat">
			<div class="pedroea-wm-stat-num"><?php echo esc_html( $total_count ); ?></div>
			<div class="pedroea-wm-stat-label"><?php esc_html_e( 'Total Widgets', 'pedro-for-elementor-addons' ); ?></div>
		</div>
		<div class="pedroea-wm-stat pedroea-wm-stat-enabled">
			<div class="pedroea-wm-stat-num"><?php echo esc_html( $enabled_count ); ?></div>
			<div class="pedroea-wm-stat-label"><?php esc_html_e( 'Enabled', 'pedro-for-elementor-addons' ); ?></div>
		</div>
		<div class="pedroea-wm-stat pedroea-wm-stat-disabled">
			<div class="pedroea-wm-stat-num"><?php echo esc_html( $disabled_count ); ?></div>
			<div class="pedroea-wm-stat-label"><?php esc_html_e( 'Disabled', 'pedro-for-elementor-addons' ); ?></div>
		</div>
	</div>

	<?php if ( isset( $_GET['saved'] ) ) : // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
		<div class="notice notice-success is-dismissible">
			<p><?php esc_html_e( 'Widget settings saved.', 'pedro-for-elementor-addons' ); ?></p>
		</div>
	<?php endif; ?>

	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="pedroea-wm-form">
		<input type="hidden" name="action" value="pedroea_widget_manager">
		<?php wp_nonce_field( 'pedroea_widget_manager_nonce' ); ?>

		<div class="pedroea-wm-toolbar">
			<input type="search" id="pedroea-wm-search" class="pedroea-wm-search" placeholder="<?php esc_attr_e( 'Search widgets…', 'pedro-for-elementor-addons' ); ?>">
			<span class="pedroea-wm-result-count" id="pedroea-wm-count"></span>
			<span class="pedroea-wm-spacer"></span>
			<button type="button" class="button" id="pedroea-wm-enable-all"><?php esc_html_e( 'Enable All', 'pedro-for-elementor-addons' ); ?></button>
			<button type="button" class="button" id="pedroea-wm-disable-all"><?php esc_html_e( 'Disable All', 'pedro-for-elementor-addons' ); ?></button>
		</div>

		<div class="pedroea-wm-grid">
			<?php foreach ( $widgets as $widget_name => $widget_instance ) : ?>
				<?php
				$title      = method_exists( $widget_instance, 'get_title' ) ? $widget_instance->get_title() : $widget_name;
				$icon_class = method_exists( $widget_instance, 'get_icon' ) ? $widget_instance->get_icon() : 'eicon-code';
				$is_enabled = ! in_array( $widget_name, $disabled, true );
				?>
				<label class="pedroea-wm-card<?php echo $is_enabled ? '' : ' pedroea-wm-card-disabled'; ?>" data-name="<?php echo esc_attr( $widget_name ); ?>" data-title="<?php echo esc_attr( strtolower( $title ) ); ?>">
					<input type="checkbox" name="enabled_widgets[]" value="<?php echo esc_attr( $widget_name ); ?>" <?php checked( $is_enabled ); ?>>
					<span class="pedroea-wm-card-icon"><i class="<?php echo esc_attr( $icon_class ); ?>"></i></span>
					<span class="pedroea-wm-card-title"><?php echo esc_html( $title ); ?></span>
					<span class="pedroea-wm-switch"><span class="pedroea-wm-switch-knob"></span></span>
				</label>
			<?php endforeach; ?>
		</div>

		<div class="pedroea-wm-footer">
			<p class="submit">
				<button type="submit" class="button button-primary button-hero"><?php esc_html_e( 'Save Changes', 'pedro-for-elementor-addons' ); ?></button>
			</p>
		</div>
	</form>
</div>
