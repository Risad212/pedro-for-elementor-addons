<?php

namespace PedroEA\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Widget Manager.
 *
 * Lets admins disable unused widgets so the Elementor editor stays clean and
 * lightweight. Disabled widgets are skipped during registration, so they are
 * hidden from the editor panel and no longer render on the front end.
 */
class Widget_Manager {

	/**
	 * Option key storing the list of disabled widget names.
	 */
	const OPTION = 'pedroea_disabled_widgets';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_post_pedroea_widget_manager', [ $this, 'handle_save' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );
	}

	/**
	 * Renders the Widget Manager dashboard as the top-level Pedro landing page.
	 *
	 * The callback is used by `add_menu_page` (page=pedroea), so clicking the
	 * top-level "Pedro" menu opens the widget dashboard.
	 *
	 * @return void
	 */
	public static function render_landing_page() {
		static $manager = null;

		if ( null === $manager ) {
			$manager = new self();
		}

		$manager->render_page();
	}

	/**
	 * Canonical registry of all Pedro widgets: file name => class name.
	 *
	 * Used both for registration (plugin.php) and for rendering the manager
	 * page, so the two can never drift apart.
	 *
	 * @return array<string,string>
	 */
	public static function get_registry() {
		return [
			'accordion.php'            => 'Accordion',
			'advanced-tabs.php'        => 'Advanced_Tabs',
			'animated-headline.php'    => 'Animated_Headline',
			'badge.php'                => 'Badge',
			'button.php'               => 'Button',
			'contact-form.php'         => 'Contact_Form',
			'content-switcher.php'     => 'Content_Switcher',
			'copywrite.php'            => 'CopyWrite',
			'countdown.php'            => 'Countdown',
			'counter.php'              => 'Counter',
			'custom-code.php'          => 'Custom_Code',
			'dual-heading.php'         => 'Dual_Heading',
			'facebook-button.php'      => 'Facebook_Button',
			'facebook-comments.php'    => 'Facebook_Comments',
			'facebook-embed.php'       => 'Facebook_Embed',
			'facebook-page.php'        => 'Facebook_Page',
			'filterable-gallery.php'   => 'Filterable_Gallery',
			'flixbox.php'              => 'Flixbox',
			'form.php'                 => 'Form',
			'hotspot.php'              => 'Hotspot',
			'image-carousel.php'       => 'Image_Carousel',
			'image-comparison.php'     => 'Image_Comparison',
			'instagram-feed.php'       => 'Instagram_Feed',
			'logo-grid.php'            => 'Logo_Grid',
			'login.php'                => 'Login',
			'loop-carousel.php'        => 'Loop_Carousel',
			'loop-grid.php'            => 'Loop_Grid',
			'modal-popup.php'          => 'Modal_Popup',
			'off-canvas.php'           => 'Off_Canvas',
			'post.php'                 => 'Post',
			'post-content.php'         => 'Post_Content',
			'post-featured-image.php'  => 'Post_Featured_Image',
			'post-info.php'            => 'Post_Info',
			'post-title.php'           => 'Post_Title',
			'progress-bar.php'         => 'Progress_Bar',
			'progress-ring.php'        => 'Progress_Ring',
			'search-bar.php'           => 'Search_Bar',
			'site-logo.php'            => 'Site_Logo',
			'table-builder.php'        => 'Table_Builder',
			'team.php'                 => 'Team',
			'testimonial.php'          => 'Testimonial',
			'testimonial-navigation.php' => 'Testimonial_Navigation',
			'threesixty-rotation.php'  => 'Threesixty_Rotation',
			'ticker.php'               => 'Ticker',
			'timeline.php'             => 'Timeline',
			'video-popup.php'          => 'Video_Popup',
		];
	}

	/**
	 * Renders the Widget Manager dashboard.
	 */
	public function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$disabled = (array) get_option( self::OPTION, [] );
		$widgets  = $this->get_widgets();

		$total = 0;
		$on    = 0;

		foreach ( $widgets as $name => $widget ) {
			$total++;
			if ( ! in_array( $name, $disabled, true ) ) {
				$on++;
			}
		}

		$total_count    = $total;
		$enabled_count  = $on;
		$disabled_count = $total - $on;

		require PEDROEA_PATH . 'admin/views/widget-manager.php';
	}

	/**
	 * Saves the enabled/disabled widget selection.
	 */
	public function handle_save() {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'pedroea_widget_manager_nonce' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'Permission denied', 'pedro-for-elementor-addons' ) );
		}

		$allowed   = array_keys( $this->get_widgets() );
		$submitted = isset( $_POST['enabled_widgets'] ) && is_array( $_POST['enabled_widgets'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['enabled_widgets'] ) ) : [];

		if ( empty( $allowed ) ) {
			wp_safe_redirect( admin_url( 'admin.php?page=pedroea' ) );
			exit;
		}

		$enabled   = array_values( array_intersect( $submitted, $allowed ) );
		$disabled  = array_values( array_diff( $allowed, $enabled ) );

		update_option( self::OPTION, $disabled );

		wp_safe_redirect( admin_url( 'admin.php?page=pedroea&saved=1' ) );
		exit;
	}

	/**
	 * Enqueues dashboard styles and Elementor's icon font so widget icons
	 * render on the Widget Manager dashboard.
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( 'pedroea' !== $page && 'pedroea_widget_manager' !== $page ) {
			return;
		}

		wp_enqueue_style( 'pedroea-widget-manager-admin', PEDROEA_URL . 'assets/css/pedroea-widget-manager.css', [], PEDROEA_VERSION );
		wp_enqueue_script( 'pedroea-widget-manager-admin', PEDROEA_URL . 'assets/js/pedroea-widget-manager.js', [], PEDROEA_VERSION, true );

		if ( defined( 'ELEMENTOR_ASSETS_URL' ) && defined( 'ELEMENTOR_VERSION' ) ) {
			wp_enqueue_style( 'pedroea-eicons', ELEMENTOR_ASSETS_URL . 'lib/eicons/css/elementor-icons.min.css', [], ELEMENTOR_VERSION );
		}
	}

	/**
	 * Instantiates every Pedro widget (enabled or not) so the manager always
	 * shows the full list, allowing disabled widgets to be re-enabled.
	 *
	 * @return array<string,\Elementor\Widget_Base>
	 */
	private function get_widgets() {
		$widgets = [];

		foreach ( self::get_registry() as $file => $class ) {
			require_once PEDROEA_PATH . 'widgets/' . $file;

			$class    = '\\PedroEA\\Widgets\\' . $class;
			$instance = new $class();

			$widgets[ $instance->get_name() ] = $instance;
		}

		return $widgets;
	}
}
