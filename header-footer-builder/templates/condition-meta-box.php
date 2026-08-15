<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<select name="pedroea_condition" id="pedroea-condition-select">
	<?php foreach ( $labels as $value => $label ) : ?>
		<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $condition, $value ); ?>><?php echo esc_html( $label ); ?></option>
	<?php endforeach; ?>
</select>
<div id="pedroea-condition-specific-wrap" class="pedroea-condition-specific-wrap<?php echo 'specific' === $condition ? '' : ' pedroea-condition-hidden'; ?>">
	<label class="pedroea-condition-label" for="pedroea-condition-specific-select"><?php esc_html_e( 'Select Page / Post', 'pedro-for-elementor-addons' ); ?></label>
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
</div>
