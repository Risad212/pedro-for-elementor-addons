<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<table class="p-table">
	<thead>
		<tr>
			<th><?php esc_html_e( 'Name', 'pedro-for-elementor-addons' ); ?></th>
			<th><?php esc_html_e( 'Type', 'pedro-for-elementor-addons' ); ?></th>
			<th><?php esc_html_e( 'Display', 'pedro-for-elementor-addons' ); ?></th>
			<th><?php esc_html_e( 'Status', 'pedro-for-elementor-addons' ); ?></th>
			<th><?php esc_html_e( 'Active', 'pedro-for-elementor-addons' ); ?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $templates as $template ) : ?>
			<?php
			$type          = get_post_meta( $template->ID, '_pedroea_tb_type', true ) ?: 'single';
			$is_pub        = 'publish' === get_post_status( $template->ID );
			$pub_badge     = $is_pub ? 'p-badge-active' : 'p-badge-draft';
			$pub_label     = $is_pub ? __( 'Publish', 'pedro-for-elementor-addons' ) : __( 'Draft', 'pedro-for-elementor-addons' );
			$is_active     = '1' === get_post_meta( $template->ID, '_pedroea_tb_active', true );
			$act_badge     = $is_active ? 'p-badge-active' : 'p-badge-inactive';
			$act_label     = $is_active ? __( 'Active', 'pedro-for-elementor-addons' ) : __( 'Inactive', 'pedro-for-elementor-addons' );
			$toggle_url    = wp_nonce_url( admin_url( 'admin-post.php?action=pedroea_tb_toggle&post_id=' . $template->ID ), 'pedroea_tb_toggle_' . $template->ID );
			$delete_url    = wp_nonce_url( admin_url( 'admin-post.php?action=pedroea_tb_delete&post_id=' . $template->ID ), 'pedroea_tb_delete_' . $template->ID );
			$edit_props    = admin_url( 'admin.php?page=pedroea_tb&edit=' . $template->ID );
			$edit_elementor = admin_url( 'post.php?post=' . $template->ID . '&action=elementor' );
			?>
			<tr>
				<td><strong><a href="<?php echo esc_url( $edit_props ); ?>"><?php echo esc_html( $template->post_title ); ?></a></strong></td>
				<td><span class="pedroea-type-badge pedroea-type-badge-<?php echo esc_attr( $type ); ?>"><?php echo esc_html( ucfirst( str_replace( '_', ' ', $type ) ) ); ?></span></td>
				<td><span class="pedroea-condition-badge"><?php echo esc_html( $this->display_summary( $template->ID ) ); ?></span></td>
				<td><span class="<?php echo esc_attr( $pub_badge ); ?>"><?php echo esc_html( $pub_label ); ?></span></td>
				<td><a href="<?php echo esc_url( $toggle_url ); ?>" class="p-badge-toggle" title="<?php esc_attr_e( 'Toggle active', 'pedro-for-elementor-addons' ); ?>"><span class="<?php echo esc_attr( $act_badge ); ?>"><?php echo esc_html( $act_label ); ?></span></a></td>
				<td class="p-actions">
					<a href="<?php echo esc_url( $edit_props ); ?>" class="p-btn-prop" title="<?php esc_attr_e( 'Edit properties', 'pedro-for-elementor-addons' ); ?>">
						<span class="dashicons dashicons-admin-generic"></span>
					</a>
					<a href="<?php echo esc_url( $edit_elementor ); ?>" class="p-btn-el" title="<?php esc_attr_e( 'Edit with Elementor', 'pedro-for-elementor-addons' ); ?>">
						<span class="dashicons dashicons-edit"></span>
					</a>
					<a href="<?php echo esc_url( $delete_url ); ?>" class="p-btn-prop p-btn-del" title="<?php esc_attr_e( 'Delete template', 'pedro-for-elementor-addons' ); ?>" onclick="return confirm('<?php echo esc_js( __( 'Delete this template permanently?', 'pedro-for-elementor-addons' ) ); ?>');">
						<span class="dashicons dashicons-trash"></span>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
