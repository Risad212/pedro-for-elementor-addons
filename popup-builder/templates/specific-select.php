<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<select name="pedroea_condition_specific" id="pedroea-condition-specific-select">
	<option value=""><?php esc_html_e( '— Select —', 'pedro-for-elementor-addons' ); ?></option>
	<optgroup label="<?php esc_attr_e( 'Pages', 'pedro-for-elementor-addons' ); ?>">
		<?php foreach ( get_posts( [ 'post_type' => 'page', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'title', 'order' => 'ASC' ] ) as $p ) : ?>
			<option value="<?php echo esc_attr( $p->ID ); ?>" <?php selected( $specific, $p->ID ); ?>><?php echo esc_html( $p->post_title ); ?></option>
		<?php endforeach; ?>
	</optgroup>
	<optgroup label="<?php esc_attr_e( 'Posts', 'pedro-for-elementor-addons' ); ?>">
		<?php foreach ( get_posts( [ 'post_type' => 'post', 'posts_per_page' => 50, 'post_status' => 'publish' ] ) as $p ) : ?>
			<option value="<?php echo esc_attr( $p->ID ); ?>" <?php selected( $specific, $p->ID ); ?>><?php echo esc_html( $p->post_title ); ?></option>
		<?php endforeach; ?>
	</optgroup>
</select>
