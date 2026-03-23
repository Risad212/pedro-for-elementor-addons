<?php

/**
 * Plugin Name:       Pedro For Elementor Addons
 * Plugin URI: 
 * Description:       Elementor Addon For The Elementor Themes.
 * Version:           1.0.5
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Author:            Hafez Risad
 * Author URI:        
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl.html
 * Text Domain:       pedro-for-elementor-addons
 * Domain Path: /languages
 * Requires Plugins:  elementor
 * Requires Elementor: 3.5.0
 */


// Exit if accessed directly.
if (! defined('ABSPATH')) {
	exit;
}


/**
 * Main Pedro Elementor Addon Class.
 */
final class PedroEa_Main
{

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor version required to run the plugin.
	 *
	 * @var string
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.5.0';

	/**
	 * Minimum PHP version required to run the plugin.
	 *
	 * @var string
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		add_action('plugins_loaded', array($this, 'plugin_init'));
	}

	/**
	 * Initialize the plugin.
	 */
	public function plugin_init()
	{

		// Check if Elementor is installed and activated.
		if (! did_action('elementor/loaded')) {
			add_action('admin_notices', array($this, 'admin_notice_missing_elementor'));
			return;
		}

		// Check for minimum Elementor version.
		if (! version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
			add_action('admin_notices', array($this, 'admin_notice_minimum_elementor_version'));
			return;
		}

		// Check for minimum PHP version.
		if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', array($this, 'admin_notice_minimum_php_version'));
			return;
		}

		// Define constants.
		$this->define_constants();

		// Include main plugin file.
		require_once PEDROEA_PATH . 'plugin.php';
	}

	/**
	 * Define plugin constants.
	 */
	private function define_constants()
	{
		define('PEDROEA_URL', plugins_url('/', __FILE__));
		define('PEDROEA_PATH', plugin_dir_path(__FILE__));
	}

	/**
	 * Admin notice: Elementor is missing.
	 */
	public function admin_notice_missing_elementor()
	{
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			__('"%1$s" requires "%2$s" to be installed and activated.', 'pedro-for-elementor-addons'),
			'<strong>' . esc_html__('Pedro Elementor Addon', 'pedro-for-elementor-addons') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'pedro-for-elementor-addons') . '</strong>'
		);

		printf(
			'<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
			wp_kses_post($message)
		);
	}

	/**
	 * Admin notice: Minimum Elementor version not met.
	 */
	public function admin_notice_minimum_elementor_version()
	{
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			__('"%1$s" requires "%2$s" version %3$s or greater.', 'pedro-for-elementor-addons'),
			'<strong>' . esc_html__('Pedro Elementor Addon', 'pedro-for-elementor-addons') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'pedro-for-elementor-addons') . '</strong>',
			esc_html(self::MINIMUM_ELEMENTOR_VERSION)
		);

		printf(
			'<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
			wp_kses_post($message)
		);
	}

	/**
	 * Admin notice: Minimum PHP version not met.
	 */
	public function admin_notice_minimum_php_version()
	{
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			__('"%1$s" requires "%2$s" version %3$s or greater.', 'pedro-for-elementor-addons'),
			'<strong>' . esc_html__('Pedro Elementor Addon', 'pedro-for-elementor-addons') . '</strong>',
			'<strong>' . esc_html__('PHP', 'pedro-for-elementor-addons') . '</strong>',
			esc_html(self::MINIMUM_PHP_VERSION)
		);

		printf(
			'<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
			wp_kses_post($message)
		);
	}
}

// Instantiate the plugin.
new PedroEa_Main();
