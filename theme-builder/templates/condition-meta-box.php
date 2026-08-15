<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<select name="pedroea_tb_condition" id="pedroea-condition-select">
	<?php foreach ( $labels as $value => $label ) : ?>
		<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $condition, $value ); ?>><?php echo esc_html( $label ); ?></option>
	<?php endforeach; ?>
</select>

<div id="pedroea-condition-type-wrap" class="pedroea-condition-sub<?php echo in_array( $condition, [ 'post_type', 'specific' ], true ) ? '' : ' pedroea-condition-hidden'; ?>">
	<label class="pedroea-condition-label" for="pedroea-tb-post-type"><?php esc_html_e( 'Post Type', 'pedro-for-elementor-addons' ); ?></label>
	<select name="pedroea_tb_condition_type" id="pedroea-tb-post-type">
		<?php foreach ( $post_types as $value => $label ) : ?>
			<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $condition_type, $value ); ?>><?php echo esc_html( $label ); ?></option>
		<?php endforeach; ?>
	</select>
</div>

<div id="pedroea-condition-specific-wrap" class="pedroea-condition-sub<?php echo 'specific' === $condition ? '' : ' pedroea-condition-hidden'; ?>">
	<label class="pedroea-condition-label" for="pedroea-specific-search"><?php esc_html_e( 'Specific Post', 'pedro-for-elementor-addons' ); ?></label>
	<div class="pedroea-specific-picker" data-nonce="<?php echo esc_attr( wp_create_nonce( 'pedroea_tb_search_nonce' ) ); ?>">
		<input type="text" id="pedroea-specific-search" class="pedroea-specific-search" placeholder="<?php esc_attr_e( 'Type to search posts…', 'pedro-for-elementor-addons' ); ?>" autocomplete="off">
		<input type="hidden" name="pedroea_tb_condition_specific" class="pedroea-specific-id" value="<?php echo esc_attr( $specific ); ?>">
		<div class="pedroea-specific-selected">
			<?php if ( $specific && get_the_title( $specific ) ) : ?>
				<span class="pedroea-specific-chip"><?php echo esc_html( get_the_title( $specific ) ); ?><a href="#" class="pedroea-specific-remove" title="<?php esc_attr_e( 'Remove', 'pedro-for-elementor-addons' ); ?>">&times;</a></span>
			<?php endif; ?>
		</div>
		<div class="pedroea-specific-results" style="display:none;"></div>
	</div>
</div>
