<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/trait-pedroea-post-data.php';

class Post_Featured_Image extends Widget_Base {

	use PedroEA_Post_Data;

	public function get_name() {
		return 'pedroea_post_featured_image';
	}

	public function get_title(): string {
		return __( 'Post Featured Image', 'pedro-for-elementor-addons' );
	}

	public function get_icon(): string {
		return 'eicon-featured-image pedro-elementor-icon';
	}

	public function get_categories(): array {
		return [ 'pedroea' ];
	}

	public function get_keywords(): array {
		return [ 'post', 'image', 'featured', 'thumbnail', 'single post' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_image_content',
			[
				'label' => __( 'Image', 'pedro-for-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->pedroea_register_preview_control();

		$this->add_control(
			'image_size',
			[
				'label'   => __( 'Image Size', 'pedro-for-elementor-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'large',
				'options' => $this->pedroea_get_image_sizes(),
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
			'section_image_style',
			[
				'label' => __( 'Image', 'pedro-for-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_align',
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
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .pedroea-post-featured-image' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'      => __( 'Width', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1200,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pedroea-post-featured-image img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'      => __( 'Height', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pedroea-post-featured-image img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .pedroea-post-featured-image img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pedroea-post-featured-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .pedroea-post-featured-image img',
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'image_css_filter',
				'selector' => '{{WRAPPER}} .pedroea-post-featured-image img',
			]
		);

		$this->add_control(
			'image_hover_heading',
			[
				'label'     => __( 'Hover', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'image_hover_css_filter',
				'selector' => '{{WRAPPER}} .pedroea-post-featured-image a:hover img',
			]
		);

		$this->add_control(
			'image_hover_scale',
			[
				'label'     => __( 'Zoom on Hover', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'pedro-for-elementor-addons' ),
				'label_off' => __( 'No', 'pedro-for-elementor-addons' ),
				'default'   => 'yes',
			]
		);

		$this->end_controls_section();
	}

	private function pedroea_get_image_sizes() {
		$sizes = get_intermediate_image_sizes();
		$options = [];

		foreach ( $sizes as $size ) {
			$options[ $size ] = ucwords( str_replace( '_', ' ', $size ) );
		}

		$options['full'] = __( 'Full', 'pedro-for-elementor-addons' );

		return $options;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$post_id  = $this->pedroea_get_current_post_id();

		if ( ! $post_id ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="pedroea-placeholder">' . esc_html__( 'Post Featured Image — choose a Preview Post above to see it here.', 'pedro-for-elementor-addons' ) . '</div>';
			}
			return;
		}

		$image_id = get_post_thumbnail_id( $post_id );

		if ( ! $image_id ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="pedroea-placeholder">' . esc_html__( 'This post has no featured image.', 'pedro-for-elementor-addons' ) . '</div>';
			}
			return;
		}

		$size  = ! empty( $settings['image_size'] ) ? $settings['image_size'] : 'large';
		$image = wp_get_attachment_image(
			$image_id,
			$size,
			false,
			[
				'class'    => 'pedroea-post-featured-img',
				'alt'      => esc_attr( get_the_title( $post_id ) ),
			]
		);

		if ( empty( $image ) ) {
			return;
		}

		$this->add_render_attribute( 'featured', 'class', 'pedroea-post-featured-image' );

		if ( 'yes' === $settings['image_hover_scale'] ) {
			$this->add_render_attribute( 'featured', 'class', 'pedroea-post-featured-zoom' );
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'featured' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php if ( 'yes' === $settings['link_to_post'] ) : ?>
				<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>"><?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			<?php else : ?>
				<?php echo $image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endif; ?>
		</div>
		<?php
	}
}
