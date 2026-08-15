<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<main id="pedroea-tb-single" class="pedroea-tb-single-template" role="main">
	<?php
	if ( ! empty( $GLOBALS['pedroea_tb_template_id'] ) ) {
		$content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $GLOBALS['pedroea_tb_template_id'], true );

		if ( $content ) {
			echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
	?>
</main>
<?php
get_footer();
