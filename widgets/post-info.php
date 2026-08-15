<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/trait-pedroea-post-data.php';

class Post_Info extends Widget_Base {

	use PedroEA_Post_Data;

	public function get_name() {
		return 'pedroea_post_info';
	}

	public function get_title(): string {
		return __( 'Post Info', 'pedro-for-elementor-addons' );
	}

	public function get_icon(): string {
		return 'eicon-post-info pedro-elementor-icon';
	}

	public function get_categories(): array {
		return [ 'pedroea' ];
	}

	public function get_keywords(): array {
		return [ 'post', 'meta', 'author', 'date', 'category', 'tags', 'comments' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_info_content',
			[
				'label' => __( 'Meta Items', 'pedro-for-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->pedroea_register_preview_control();

		$this->add_control(
			'show_author',
			[
				'label'        => __( 'Author', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'pedro-for-elementor-addons' ),
				'label_off'    => __( 'Hide', 'pedro-for-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'author_icon',
			[
				'label'     => __( 'Author Icon', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'eicon-user-circle-o',
					'library' => 'eicons',
				],
				'condition' => [ 'show_author' => 'yes' ],
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'        => __( 'Date', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'pedro-for-elementor-addons' ),
				'label_off'    => __( 'Hide', 'pedro-for-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'date_format',
			[
				'label'     => __( 'Date Format', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'F j, Y',
				'options'   => [
					'F j, Y'    => gmdate( 'F j, Y' ),
					'Y-m-d'     => gmdate( 'Y-m-d' ),
					'm/d/Y'     => gmdate( 'm/d/Y' ),
					'd/m/Y'     => gmdate( 'd/m/Y' ),
					'j F Y'     => gmdate( 'j F Y' ),
					'human'     => __( 'Human Readable', 'pedro-for-elementor-addons' ),
				],
				'condition' => [ 'show_date' => 'yes' ],
			]
		);

		$this->add_control(
			'date_icon',
			[
				'label'     => __( 'Date Icon', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'eicon-calendar',
					'library' => 'eicons',
				],
				'condition' => [ 'show_date' => 'yes' ],
			]
		);

		$this->add_control(
			'show_categories',
			[
				'label'        => __( 'Categories', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'pedro-for-elementor-addons' ),
				'label_off'    => __( 'Hide', 'pedro-for-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'categories_icon',
			[
				'label'     => __( 'Categories Icon', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'eicon-folder-o',
					'library' => 'eicons',
				],
				'condition' => [ 'show_categories' => 'yes' ],
			]
		);

		$this->add_control(
			'show_tags',
			[
				'label'        => __( 'Tags', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'pedro-for-elementor-addons' ),
				'label_off'    => __( 'Hide', 'pedro-for-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'tags_icon',
			[
				'label'     => __( 'Tags Icon', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'eicon-tags',
					'library' => 'eicons',
				],
				'condition' => [ 'show_tags' => 'yes' ],
			]
		);

		$this->add_control(
			'show_comments',
			[
				'label'        => __( 'Comments Count', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'pedro-for-elementor-addons' ),
				'label_off'    => __( 'Hide', 'pedro-for-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->add_control(
			'comments_icon',
			[
				'label'     => __( 'Comments Icon', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'eicon-commenting-o',
					'library' => 'eicons',
				],
				'condition' => [ 'show_comments' => 'yes' ],
			]
		);

		$this->add_control(
			'separator',
			[
				'label'     => __( 'Separator', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'dot',
				'options'   => [
					'none'  => __( 'None', 'pedro-for-elementor-addons' ),
					'comma' => __( 'Comma', 'pedro-for-elementor-addons' ),
					'dot'   => __( 'Dot', 'pedro-for-elementor-addons' ),
					'slash' => __( 'Slash', 'pedro-for-elementor-addons' ),
					'pipe'  => __( 'Pipe', 'pedro-for-elementor-addons' ),
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_info_style',
			[
				'label' => __( 'Post Info', 'pedro-for-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'info_typography',
				'selector' => '{{WRAPPER}} .pedroea-post-info',
			]
		);

		$this->add_control(
			'info_color',
			[
				'label'     => __( 'Text Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pedroea-post-info'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_link_color',
			[
				'label'     => __( 'Link Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pedroea-post-info a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_link_hover_color',
			[
				'label'     => __( 'Link Hover Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pedroea-post-info a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_icon_color',
			[
				'label'     => __( 'Icon Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pedroea-post-info .pedroea-post-info-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'info_icon_size',
			[
				'label'      => __( 'Icon Size', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 8,
						'max' => 60,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pedroea-post-info .pedroea-post-info-icon i, {{WRAPPER}} .pedroea-post-info .pedroea-post-info-icon svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'info_align',
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
					'{{WRAPPER}} .pedroea-post-info' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'info_gap',
			[
				'label'      => __( 'Spacing Between Items', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .pedroea-post-info' => 'column-gap: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_section();
	}

	private function render_info_item( $icon, $label, $url = '', $is_html = false ) {
		ob_start();
		?>
		<span class="pedroea-post-info-item">
			<?php if ( ! empty( $icon['value'] ) ) : ?>
				<span class="pedroea-post-info-icon"><?php Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?></span>
			<?php endif; ?>
			<?php if ( $url ) : ?>
				<a href="<?php echo esc_url( $url ); ?>"><?php echo $is_html ? $label : esc_html( $label ); // phpcs:ignore WordPress.Security.EscapeOutput ?></a>
			<?php else : ?>
				<span class="pedroea-post-info-text"><?php echo $is_html ? $label : esc_html( $label ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
			<?php endif; ?>
		</span>
		<?php
		return ob_get_clean();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$post_id  = $this->pedroea_get_current_post_id();

		if ( ! $post_id ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="pedroea-placeholder">' . esc_html__( 'Post Info — choose a Preview Post above to see it here.', 'pedro-for-elementor-addons' ) . '</div>';
			}
			return;
		}

		$items = [];

		if ( 'yes' === $settings['show_author'] ) {
			$author_id   = (int) get_post_field( 'post_author', $post_id );
			$author_name = get_the_author_meta( 'display_name', $author_id );

			if ( $author_name ) {
				$items[] = $this->render_info_item( $settings['author_icon'], $author_name, get_author_posts_url( $author_id ) );
			}
		}

		if ( 'yes' === $settings['show_date'] ) {
			if ( 'human' === $settings['date_format'] ) {
				$date = sprintf(
					/* translators: %s: human time diff. */
					__( '%s ago', 'pedro-for-elementor-addons' ),
					human_time_diff( get_post_time( 'U', true, $post_id ), current_time( 'timestamp', true ) )
				);
			} else {
				$date = get_the_date( $settings['date_format'], $post_id );
			}

			if ( $date ) {
				$items[] = $this->render_info_item( $settings['date_icon'], $date, get_permalink( $post_id ) );
			}
		}

		if ( 'yes' === $settings['show_categories'] ) {
			$cats = get_the_category_list( ', ', '', $post_id );

			if ( $cats ) {
				$items[] = $this->render_info_item( $settings['categories_icon'], $cats, '', true );
			}
		}

		if ( 'yes' === $settings['show_tags'] ) {
			$tags = get_the_tag_list( '', ', ', '', $post_id );

			if ( $tags ) {
				$items[] = $this->render_info_item( $settings['tags_icon'], $tags, '', true );
			}
		}

		if ( 'yes' === $settings['show_comments'] ) {
			$count = get_comments_number( $post_id );

			$label = sprintf(
				/* translators: %s: comment count. */
				_n( '%s Comment', '%s Comments', $count, 'pedro-for-elementor-addons' ),
				number_format_i18n( $count )
			);

			$items[] = $this->render_info_item( $settings['comments_icon'], $label, get_comments_link( $post_id ) );
		}

		if ( empty( $items ) ) {
			return;
		}

		$separator = '';
		$sep_map   = [
			'comma' => ', ',
			'dot'   => '&middot;',
			'slash' => '/',
			'pipe'  => '|',
		];

		if ( 'none' !== $settings['separator'] && isset( $sep_map[ $settings['separator'] ] ) ) {
			$separator = '<span class="pedroea-post-info-sep" aria-hidden="true">' . $sep_map[ $settings['separator'] ] . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput
		}

		$this->add_render_attribute( 'info', 'class', 'pedroea-post-info' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'info' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php echo implode( $separator, $items ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php
	}
}
