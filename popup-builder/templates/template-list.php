<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<div class="pedroea-popup-list">
	<?php foreach ( $popups as $popup ) : ?>
		<?php
		$trigger        = get_post_meta( $popup->ID, '_pedroea_popup_trigger', true ) ?: 'load';
		$trigger_option = $trigger_options[ $trigger ] ?? $trigger_options['load'];
		$condition      = get_post_meta( $popup->ID, '_pedroea_popup_condition', true ) ?: 'all';
		$is_active      = '1' === get_post_meta( $popup->ID, '_pedroea_popup_active', true );
		$is_draft       = 'draft' === get_post_status( $popup->ID );
		$toggle_url     = wp_nonce_url( admin_url( 'admin-post.php?action=pedroea_popup_toggle&post_id=' . $popup->ID ), 'pedroea_popup_toggle_' . $popup->ID );
		$delete_url     = wp_nonce_url( admin_url( 'admin-post.php?action=pedroea_popup_delete&post_id=' . $popup->ID ), 'pedroea_popup_delete_' . $popup->ID );
		$edit_props     = admin_url( 'admin.php?page=pedroea_popup&edit=' . $popup->ID );
		$edit_elementor = admin_url( 'post.php?post=' . $popup->ID . '&action=elementor' );
		?>
		<div class="pedroea-popup-card">
			<div class="pedroea-popup-card-top">
				<div class="pedroea-popup-card-icon">
					<span class="dashicons <?php echo esc_attr( $trigger_option['icon'] ); ?>"></span>
				</div>
				<div class="pedroea-popup-card-info">
					<a href="<?php echo esc_url( $edit_props ); ?>" class="pedroea-popup-card-title"><?php echo esc_html( $popup->post_title ); ?></a>
					<div class="pedroea-popup-card-meta">
						<span class="pedroea-popup-type-badge pedroea-popup-trigger-<?php echo esc_attr( $trigger ); ?>"><?php echo esc_html( $trigger_option['label'] ); ?></span>
						<span class="pedroea-condition-badge"><?php echo esc_html( $condition_labels[ $condition ] ?? $condition ); ?></span>
						<?php if ( $is_draft ) : ?>
							<span class="p-badge-draft"><?php esc_html_e( 'Draft', 'pedro-for-elementor-addons' ); ?></span>
						<?php endif; ?>
					</div>
				</div>
				<label class="pedroea-switch" title="<?php esc_attr_e( 'Toggle active', 'pedro-for-elementor-addons' ); ?>">
					<input type="checkbox" class="pedroea-popup-toggle" data-url="<?php echo esc_url( $toggle_url ); ?>" <?php checked( $is_active ); ?>>
					<span class="pedroea-switch-slider"></span>
				</label>
			</div>
			<div class="pedroea-popup-card-actions">
				<a href="<?php echo esc_url( $edit_elementor ); ?>" class="p-btn-el">
					<span class="dashicons dashicons-edit"></span> <?php esc_html_e( 'Edit with Elementor', 'pedro-for-elementor-addons' ); ?>
				</a>
				<a href="<?php echo esc_url( $edit_props ); ?>" class="p-btn-secondary p-btn-sm"><?php esc_html_e( 'Settings', 'pedro-for-elementor-addons' ); ?></a>
				<a href="<?php echo esc_url( $delete_url ); ?>" class="pedroea-popup-delete" title="<?php esc_attr_e( 'Delete popup', 'pedro-for-elementor-addons' ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Delete this popup permanently?', 'pedro-for-elementor-addons' ) ); ?>');">
					<span class="dashicons dashicons-trash"></span>
				</a>
			</div>
		</div>
	<?php endforeach; ?>
</div>
