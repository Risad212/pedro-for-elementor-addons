<?php

namespace PedroEA\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared helpers for dynamic single-post widgets.
 *
 * Lets Post Title / Featured Image / Content / Info widgets pull the
 * currently viewed post on the frontend, and a selected "preview post"
 * while editing a Theme Builder template in the Elementor editor.
 */
trait PedroEA_Post_Data {

	private function pedroea_get_current_post_id() {
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$preview = (int) $this->get_settings_for_display( 'preview_post' );

			if ( $preview ) {
				return $preview;
			}
		}

		global $post;

		if ( $post && ! in_array( get_post_type( $post ), [ 'pedroea_tb_template', 'pedroea_template', 'pedroea_popup', 'elementor_library' ], true ) ) {
			return (int) $post->ID;
		}

		return 0;
	}

	private function pedroea_register_preview_control() {
		$this->add_control(
			'preview_post',
			[
				'label'       => __( 'Preview Post', 'pedro-for-elementor-addons' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'options'     => $this->pedroea_get_preview_options(),
				'default'     => '0',
				'description' => __( 'Pick a sample post to preview while editing a template. On the frontend the actual post is used automatically.', 'pedro-for-elementor-addons' ),
			]
		);
	}

	private function pedroea_get_preview_options() {
		$options = [ '0' => __( 'Current Post', 'pedro-for-elementor-addons' ) ];

		// Only needed while editing; avoid a get_posts() query on every frontend load.
		if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			return $options;
		}

		$posts = get_posts(
			[
				'post_type'      => 'post',
				'posts_per_page' => 20,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			]
		);

		foreach ( $posts as $post ) {
			$options[ $post->ID ] = $post->post_title;
		}

		return $options;
	}
}
