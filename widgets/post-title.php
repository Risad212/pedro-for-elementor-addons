<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/trait-pedroea-post-data.php';

class Post_Title extends Widget_Base {

	use PedroEA_Post_Data;

	public function get_name() {
		return 'pedroea_post_title';
	}

	public function get_title(): string {
		return __( 'Post Title', 'pedro-for-elementor-addons' );
	}

	public function get_icon(): string {
		return 'eicon-post-title pedro-elementor-icon';
	}

	public function get_categories(): array {
		return [ 'pedroea' ];
	}

	public function get_keywords(): array {
		return [ 'post', 'title', 'single post', 'dynamic' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_title_content',
			[
				'label' => __( 'Title', 'pedro-for-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->pedroea_register_preview_control();

		$this->add_control(
			'html_tag',
			[
				'label'   => __( 'HTML Tag', 'pedro-for-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h1',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'p'    => 'p',
					'div'  => 'div',
					'span' => 'span',
				],
			]
		);

		$this->add_control(
			'link_to_post',
			[
				'label'        => __( 'Link to Post', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'pedro-for-elementor-addons' ),
				'label_off'    => __( 'No', 'pedro-for-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __( 'Title', 'pedro-for-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .pedroea-post-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pedroea-post-title'       => 'color: {{VALUE}};',
					'{{WRAPPER}} .pedroea-post-title a'     => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => __( 'Link Hover Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pedroea-post-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_align',
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
				],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .pedroea-post-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .pedroea-post-title',
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => __( 'Margin', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pedroea-post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				echo '<div class="pedroea-placeholder pedroea-post-title-placeholder">' . esc_html__( 'Post Title — choose a Preview Post above to see it here.', 'pedro-for-elementor-addons' ) . '</div>';
			}
			return;
		}

		$title = get_the_title( $post_id );

		if ( '' === $title ) {
			return;
		}

		if ( 'yes' === $settings['link_to_post'] ) {
			$title = '<a href="' . esc_url( get_permalink( $post_id ) ) . '">' . esc_html( $title ) . '</a>';
		} else {
			$title = esc_html( $title );
		}

		$tag = ! empty( $settings['html_tag'] ) ? $settings['html_tag'] : 'h1';

		$this->add_render_attribute( 'title', 'class', 'pedroea-post-title' );
		?>
		<<?php echo esc_attr( $tag ); ?> <?php echo $this->get_render_attribute_string( 'title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></<?php echo esc_attr( $tag ); ?>>
		<?php
	}
}
