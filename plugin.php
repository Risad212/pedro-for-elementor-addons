<?php

namespace PedroEA;

use PedroEA\Admin\Widget_Manager;
use PedroEA\Widgets\Custom_CSS;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}

class PedroEA_Plugin
{

	/**
	 * store instance of plugin
	 * 
	 * @since 1.0.0
	 * 
	 * @var null
	 */
	private static $_instance = null;

	/**
	 * Whether any PedroEA widget rendered on the current request.
	 *
	 * @since 1.0.7
	 *
	 * @var bool
	 */
	protected $pedroea_rendered = false;

	/**
	 * instance of plugin
	 * 
	 * @since 1.0.0
	 * 
	 * @return instance
	 */
	public static function instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Register Widgets
	 * 
	 * @since 1.0.0
	 * 
	 * @access public
	 */
	public function register_widgets($widgets_manager)
	{
		foreach (Widget_Manager::get_registry() as $file => $class) {
			require_once PEDROEA_PATH . 'widgets/' . $file;
		}

		$disabled = (array) get_option(Widget_Manager::OPTION, []);

		foreach (Widget_Manager::get_registry() as $file => $class) {
			$class   = '\\PedroEA\\Widgets\\' . $class;
			$widget  = new $class();

			if (in_array($widget->get_name(), $disabled, true)) {
				continue;
			}

			$widgets_manager->register($widget);
		}

		// custom css
		require_once PEDROEA_PATH . 'widgets/custom-css.php';
		new Custom_CSS();
	}

	/**
	 * Register Widgets categories
	 * 
	 * @since 1.0.0
	 * 
	 * @access public
	 */
	public function register_widget_categories($elements_manager)
	{
		$elements_manager->add_category(
			'pedroea',
			[
				'title' => __('Pedro', 'pedro-for-elementor-addons'),
			]
		);
	}

	/**
	 * Register Widgets categories
	 * 
	 * @since 1.0.0
	 * 
	 * @access public
	 */
	public function register_frontend_assets()
	{
		wp_register_style('pedroea-swiper-css', PEDROEA_URL . 'assets/css/pedroea-swiper-bundle.min.css', [], PEDROEA_VERSION, 'all');
		wp_register_style('pedroea-main-css',   PEDROEA_URL . 'assets/css/pedroea-main.css', [], PEDROEA_VERSION, 'all');

		wp_register_script('pedroea-swiper-js', PEDROEA_URL . 'assets/js/pedroea-swiper-bundle.min.js', ['jquery'], PEDROEA_VERSION, true);
		wp_register_script('pedroea-main-js',   PEDROEA_URL . 'assets/js/pedroea-main.js', ['jquery'], PEDROEA_VERSION, true);

		wp_localize_script('pedroea-main-js', 'pedroea_form_data', [
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce'   => wp_create_nonce('pedroea_form_nonce'),
		]);
	}

	/**
	 * Handle the Form widget AJAX submission.
	 *
	 * Validates the nonce + honeypot, sanitizes each submitted field and
	 * emails the results to the configured recipients.
	 *
	 * @access public
	 */
	public function handle_form_submit()
	{
		check_ajax_referer('pedroea_form_nonce', 'nonce');

		// Honeypot: silently succeed but drop the submission.
		if (! empty($_POST['pea_hp'])) {
			wp_send_json_success(['message' => 'ok']);
		}

		$raw_fields  = isset($_POST['fields']) && is_array($_POST['fields']) ? wp_unslash($_POST['fields']) : [];
		$to          = isset($_POST['to']) ? sanitize_email(wp_unslash($_POST['to'])) : '';
		$subject     = isset($_POST['subject']) ? sanitize_text_field(wp_unslash($_POST['subject'])) : '';
		$form_id     = isset($_POST['form_id']) ? sanitize_key(wp_unslash($_POST['form_id'])) : '';

		if (empty($to) || empty($raw_fields)) {
			wp_send_json_error(['message' => 'invalid']);
		}

		$lines = [];
		foreach ($raw_fields as $field) {
			$label = isset($field['label']) ? sanitize_text_field(wp_unslash($field['label'])) : '';
			$value = isset($field['value']) ? sanitize_textarea_field(wp_unslash($field['value'])) : '';
			$lines[] = ($label ? $label . ': ' : '') . $value;
		}

		$body = implode("\n\n", $lines) . "\n\n---\n" . sprintf(__('Form: %s', 'pedro-for-elementor-addons'), $form_id) . "\n" . sprintf(__('Submitted: %s', 'pedro-for-elementor-addons'), current_time('mysql'));

		$headers = ['Content-Type: text/plain; charset=UTF-8'];

		$recipients = array_filter(array_map('sanitize_email', array_map('trim', explode(',', $to))));

		$sent = false;
		if (! empty($recipients)) {
			$sent = wp_mail($recipients, $subject ?: __('New form submission', 'pedro-for-elementor-addons'), $body, $headers);
		}

		if ($sent) {
			wp_send_json_success(['message' => 'sent']);
		}

		wp_send_json_error(['message' => 'mail_failed']);
	}

	/**
	 * Flag a frontend render of one of our widgets so assets
	 * are only loaded when actually needed.
	 *
	 * @access public
	 */
	public function track_widget_render( $element )
	{
		if ( $element instanceof \Elementor\Widget_Base && 0 === strpos( $element->get_name(), 'pedroea_' ) ) {
			$this->pedroea_rendered = true;
		}
	}

	/**
	 * Enqueue frontend assets only when a PedroEA widget was rendered.
	 *
	 * Fires on `wp_footer` (priority 15), after the page body and all
	 * priority-10 renders (main content, HFB footer, popups) have
	 * completed, and before the footer script printer.
	 *
	 * @access public
	 */
	public function enqueue_scripts()
	{
		if ( empty( $this->pedroea_rendered ) ) {
			return;
		}

		wp_enqueue_style('pedroea-swiper-css');
		wp_enqueue_style('pedroea-main-css');

		wp_enqueue_script('pedroea-swiper-js');
		wp_enqueue_script('pedroea-main-js');
	}

	/**
	 * Elementor Editor Js Files
	 * 
	 * @since 1.0.0
	 * 
	 * @access public
	 */
	public function enqueue_editor_scripts()
	{
		wp_enqueue_script( 'pedroea-editor', PEDROEA_URL . 'assets/js/pedroea-editor.js', ['elementor-editor', 'jquery'], PEDROEA_VERSION, true );
	}

	/**
	 * Elementor CSS Files
	 * 
	 * @since 1.0.0
	 * 
	 * @access public 
	 */
	public function enqueue_editor_styles()
	{
		wp_enqueue_style('pedroea-editor-css', PEDROEA_URL . 'assets/css/pedroea-editor.css', [], PEDROEA_VERSION, 'all');
	}


	/**
	 * Register the top-level admin menu.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function add_admin_menu()
	{
		add_menu_page(
			__('Pedro', 'pedro-for-elementor-addons'),
			__('Pedro', 'pedro-for-elementor-addons'),
			'manage_options',
			'pedroea',
			[Widget_Manager::class, 'render_landing_page'],
			'dashicons-building',
			21
		);

		remove_submenu_page('pedroea', 'pedroea');
	}

	/**
	 * Enqueue admin CSS and JS for HFB screens.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function enqueue_admin_scripts()
	{
		$screen          = get_current_screen();
		$page            = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$is_hfb_page     = 'pedroea_hfb' === $page;
		$is_popup_page   = 'pedroea_popup' === $page;
		$is_tb_page      = 'pedroea_tb' === $page;
		$is_hfb_screen   = $screen && ( 'edit-pedroea_template' === $screen->id || 'pedroea_template' === $screen->id );
		$is_popup_screen = $screen && ( 'edit-pedroea_popup' === $screen->id || 'pedroea_popup' === $screen->id );
		$is_tb_screen    = $screen && ( 'edit-pedroea_tb_template' === $screen->id || 'pedroea_tb_template' === $screen->id );

		if ( $is_hfb_page || $is_popup_page || $is_tb_page || $is_hfb_screen || $is_popup_screen || $is_tb_screen ) {
			wp_enqueue_style( 'pedroea-hfb-admin', PEDROEA_URL . 'assets/css/pedroea-hfb-admin.css', [], PEDROEA_VERSION );
		}

		if ( $is_tb_page || $is_tb_screen ) {
			wp_enqueue_style( 'pedroea-theme-builder-admin', PEDROEA_URL . 'assets/css/pedroea-theme-builder-admin.css', [], PEDROEA_VERSION );
			wp_enqueue_script( 'pedroea-theme-builder-admin', PEDROEA_URL . 'assets/js/pedroea-theme-builder-admin.js', [], PEDROEA_VERSION, true );
		}

		if ( $is_popup_page || $is_popup_screen ) {
			wp_enqueue_style( 'pedroea-popup-admin', PEDROEA_URL . 'assets/css/pedroea-popup-admin.css', [], PEDROEA_VERSION );
			wp_enqueue_script( 'pedroea-popup-admin', PEDROEA_URL . 'assets/js/pedroea-popup-admin.js', [], PEDROEA_VERSION, true );
		}

		if ( $screen && 'pedroea_template' === $screen->id ) {
			wp_enqueue_script( 'pedroea-hfb-admin', PEDROEA_URL . 'assets/js/pedroea-hfb-admin.js', [], PEDROEA_VERSION, true );
		}
	}

	/**
	 * Bootstrap Header Footer Builder module.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function bootstrap_header_footer_builder()
	{
		require_once PEDROEA_PATH . 'header-footer-builder/class-hfb-main.php';
		\PedroEA_HFB_Main::instance();
	}

	/**
	 * Bootstrap Popup Builder module.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function bootstrap_popup_builder()
	{
		require_once PEDROEA_PATH . 'popup-builder/class-pedroea-popup-main.php';
		\PedroEA_Popup_Main::instance();
	}

	/**
	 * Bootstrap Theme Builder module.
	 *
	 * @since 1.0.7
	 *
	 * @access public
	 */
	public function bootstrap_theme_builder()
	{
		require_once PEDROEA_PATH . 'theme-builder/class-pedroea-theme-builder.php';
		\PedroEA_Theme_Builder::instance();
	}

	/**
	 * Bootstrap Widget Manager module.
	 *
	 * @since 1.0.8
	 *
	 * @access public
	 */
	public function bootstrap_widget_manager()
	{
		require_once PEDROEA_PATH . 'admin/class-widget-manager.php';
		new Widget_Manager();
	}

	/**
	 *  Plugin class constructor
	 * 
	 * @since 1.0.0
	 * 
	 * @access public
	 */
	public function __construct()
	{

		// Register widgets
		add_action('elementor/widgets/register', [$this, 'register_widgets']);

		// Register widget categories
		add_action('elementor/elements/categories_registered', [$this, 'register_widget_categories']);

		// Register frontend assets (enqueued conditionally on widget render)
		add_action('wp_enqueue_scripts', [$this, 'register_frontend_assets']);

		// Track when one of our widgets actually renders on the frontend.
		add_action('elementor/frontend/before_render', [$this, 'track_widget_render']);

		// Enqueue frontend assets only if a widget was rendered.
		// Runs after all priority-10 renders (main content, HFB footer, popups)
		// and before the footer script printer (priority 20), so widgets rendered
		// inside popups or HFB templates are always covered. WP dedupes by handle.
		add_action('wp_footer', [$this, 'enqueue_scripts'], 15);

		// Enqueue scripts for Elementor Editor
		add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_editor_scripts']);

		// Enqueue style for Elemetnor Editor
		add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_styles']);

		// Register admin menu
		add_action('admin_menu', [$this, 'add_admin_menu']);

		// Enqueue admin scripts for HFB
		add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_scripts']);

		// Bootstrap Widget Manager module (registers first so the widget
		// dashboard appears as the first item under the Pedro menu).
		$this->bootstrap_widget_manager();

		// Bootstrap Header Footer Builder module.
		$this->bootstrap_header_footer_builder();

		// Bootstrap Popup Builder module.
		$this->bootstrap_popup_builder();

		// Bootstrap Theme Builder module.
		$this->bootstrap_theme_builder();

		// Form widget AJAX submission.
		add_action('wp_ajax_pedroea_form_submit', [$this, 'handle_form_submit']);
		add_action('wp_ajax_nopriv_pedroea_form_submit', [$this, 'handle_form_submit']);
	}
}

PedroEA_Plugin::instance();
