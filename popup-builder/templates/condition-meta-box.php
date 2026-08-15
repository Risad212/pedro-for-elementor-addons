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
	<?php include PEDROEA_PATH . 'popup-builder/templates/specific-select.php'; ?>
</div>
