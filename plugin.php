<?php

namespace PedroEA;

use PedroEA\Widgets\Testimonial;
use PedroEA\Widgets\Timeline;
use PedroEA\Widgets\Button;
use PedroEA\Widgets\Team;
use PedroEA\Widgets\Accordion;
use PedroEA\Widgets\Testimonial_Navigation;
use PedroEA\Widgets\Custom_CSS;
use PedroEA\Widgets\Filterable_Gallery;


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

		require_once PEDROEA_PATH . 'widgets/testimonial.php';
		require_once PEDROEA_PATH . 'widgets/timeline.php';
		require_once PEDROEA_PATH . 'widgets/team.php';
		require_once PEDROEA_PATH . 'widgets/button.php';
		require_once PEDROEA_PATH . 'widgets/accordion.php';
		require_once PEDROEA_PATH . 'widgets/testimonial_navigation.php';
        require_once PEDROEA_PATH . 'widgets/custom-css.php';
	    require_once PEDROEA_PATH . 'widgets/filterable-gallery.php';

		$widgets_manager->register(new Testimonial());
		$widgets_manager->register(new Timeline());
		$widgets_manager->register(new Accordion());
		$widgets_manager->register(new Button());
		$widgets_manager->register(new Team());
		$widgets_manager->register(new Testimonial_Navigation());
		$widgets_manager->register(new Filterable_Gallery());

		// custom css
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
	public function enqueue_scripts()
	{

		wp_enqueue_style('pedroea-swiper-css', PEDROEA_URL . 'assets/css/pedroea-swiper-bundle.min.css', [], '1.0.0', 'all');
		wp_enqueue_style('pedroea-main-css',   PEDROEA_URL . 'assets/css/pedroea-main.css', [], '1.0.0', 'all');

		wp_enqueue_script('pedroea-swiper-js', PEDROEA_URL . 'assets/js/pedroea-swiper-bundle.min.js', ['jquery'], '1.0.0', true);
		wp_enqueue_script('pedroea-main-js',   PEDROEA_URL . 'assets/js/pedroea-main.js', ['jquery'], '1.0.0', true);
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
		wp_enqueue_script( 'pedroea-editor', PEDROEA_URL . 'assets/js/pedroea-editor.js', ['elementor-editor', 'jquery'], '1.0.0', true );
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
		wp_enqueue_style('pedroea-editor-css', PEDROEA_URL . 'assets/css/pedroea-editor.css', [], '1.0.0', 'all');
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

		// Enqueue scripts for widgets
		add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

		// Enqueue scripts for Elementor Editor
		add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_editor_scripts']);

		// Enqueue style for Elemetnor Editor
		add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_editor_styles']);
	}
}

PedroEA_Plugin::instance();
