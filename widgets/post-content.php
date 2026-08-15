<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/trait-pedroea-post-data.php';

class Post_Content extends Widget_Base {

	use PedroEA_Post_Data;

	public function get_name() {
		return 'pedroea_post_content';
	}

	public function get_title(): string {
		return __( 'Post Content', 'pedro-for-elementor-addons' );
	}

	public function get_icon(): string {
		return 'eicon-post-content pedro-elementor-icon';
	}

	public function get_categories(): array {
		return [ 'pedroea' ];
	}

	public function get_keywords(): array {
		return [ 'post', 'content', 'single post', 'body' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content_settings',
			[
				'label' => __( 'Content', 'pedro-for-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->pedroea_register_preview_control();

		$this->add_control(
			'drop_cap',
			[
				'label'        => __( 'Drop Cap', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'pedro-for-elementor-addons' ),
				'label_off'    => __( 'No', 'pedro-for-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'pedro-for-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .pedroea-post-content',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => __( 'Text Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pedroea-post-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_color',
			[
				'label'     => __( 'Link Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pedroea-post-content a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'link_hover_color',
			[
				'label'     => __( 'Link Hover Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pedroea-post-content a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_align',
			[
				'label'     => __( 'Alignment', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'pedro-for-elementor-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'pedro-for-elementor-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'pedro-for-elementor-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'pedro-for-elementor-addons' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .pedroea-post-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pedroea-post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$post_id  = $this->pedroea_get_current_post_id();

		if ( ! $post_id ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="pedroea-placeholder">' . esc_html__( 'Post Content — choose a Preview Post above to see it here.', 'pedro-for-elementor-addons' ) . '</div>';
			}
			return;
		}

		$content = get_post_field( 'post_content', $post_id );
		$content = apply_filters( 'the_content', $content );

		if ( '' === trim( (string) wp_strip_all_tags( $content ) ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="pedroea-placeholder">' . esc_html__( 'This post has no content.', 'pedro-for-elementor-addons' ) . '</div>';
			}
			return;
		}

		$this->add_render_attribute( 'content', 'class', 'pedroea-post-content' );

		if ( 'yes' === $settings['drop_cap'] ) {
			$this->add_render_attribute( 'content', 'class', 'pedroea-post-content-dropcap' );
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'content' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<?php
	}
}
