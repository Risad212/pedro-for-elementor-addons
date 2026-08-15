<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit;

class Content_Switcher extends Widget_Base {

	public function get_name()
	{
		return 'pedroea_content_switcher';
	}

	public function get_title(): string
	{
		return __( 'Content Switcher', 'pedro-for-elementor-addons' );
	}

	public function get_icon(): string
	{
		return 'eicon-toggle pedro-elementor-icon';
	}

	public function get_categories(): array
	{
		return [ 'pedroea' ];
	}

	public function get_keywords(): array
	{
		return [ 'content switcher', 'toggle', 'pricing', 'template' ];
	}

	private function get_elementor_templates(): array {
		$list = [ '' => '— Select a Template —' ];

		if ( ! post_type_exists( 'elementor_library' ) ) {
			return $list;
		}

		$templates = get_posts( [
			'post_type'              => 'elementor_library',
			'post_status'            => 'publish',
			'posts_per_page'         => -1,
			'orderby'                => 'title',
			'order'                  => 'ASC',
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		] );

		foreach ( $templates as $template ) {
			if ( 'kit' === get_post_meta( $template->ID, '_elementor_template_type', true ) ) {
				continue;
			}
			$list[ $template->ID ] = $template->post_title;
		}

		return $list;
	}

	protected function register_controls(): void {

		$this->start_controls_section( 'section_content', [
			'label' => __( 'Content Switcher', 'pedro-for-elementor-addons' ),
			'tab'   => Controls_Manager::TAB_CONTENT,
		] );

			$repeater = new Repeater();

			$repeater->add_control( 'item_title', [
				'label'   => __( 'Title', 'pedro-for-elementor-addons' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Monthly',
				'dynamic' => [ 'active' => true ],
			] );

			$repeater->add_control( 'item_type', [
				'label'        => __( 'Type', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'text',
				'options'      => [
					'text'     => __( 'Plain / HTML Text', 'pedro-for-elementor-addons' ),
					'template' => __( 'Saved Template', 'pedro-for-elementor-addons' ),
				],
			] );

			$repeater->add_control( 'item_text', [
				'label'     => __( 'Plain / HTML Text', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::TEXTAREA,
				'default'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
				'dynamic'   => [ 'active' => true ],
				'condition' => [ 'item_type' => 'text' ],
				'rows'      => 6,
			] );

			$repeater->add_control( 'item_template', [
				'label'       => __( 'Template', 'pedro-for-elementor-addons' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => $this->get_elementor_templates(),
				'default'     => '',
				'condition'   => [ 'item_type' => 'template' ],
			] );

			$this->add_control( 'items', [
				'label'              => __( 'Contents', 'pedro-for-elementor-addons' ),
				'type'               => Controls_Manager::REPEATER,
				'fields'             => $repeater->get_controls(),
				'default'            => [
					[
						'item_title' => 'Monthly',
						'item_type'  => 'text',
						'item_text'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
					],
					[
						'item_title' => 'Yearly',
						'item_type'  => 'text',
						'item_text'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris. Duis aute irure dolor in reprehenderit in voluptate. Excepteur sint occaecat cupidatat non proident. Sunt in culpa qui officia deserunt mollit anim id est laborum.',
					],
				],
				'title_field'        => '{{{ item_title }}}',
			] );

			$this->add_control( 'toggle_note', [
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => '<strong>Note:</strong> Only the first two items will be used.',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_bar', [
			'label' => __( 'Switcher Bar', 'pedro-for-elementor-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

			$this->add_responsive_control( 'bar_alignment', [
				'label'          => __( 'Alignment', 'pedro-for-elementor-addons' ),
				'type'           => Controls_Manager::CHOOSE,
				'options'        => [
					'flex-start' => [ 'title' => __( 'Left', 'pedro-for-elementor-addons' ),   'icon' => 'eicon-text-align-left' ],
					'center'     => [ 'title' => __( 'Center', 'pedro-for-elementor-addons' ), 'icon' => 'eicon-text-align-center' ],
					'flex-end'   => [ 'title' => __( 'Right', 'pedro-for-elementor-addons' ),  'icon' => 'eicon-text-align-right' ],
				],
				'default'        => 'center',
				'selectors'      => [ '{{WRAPPER}} .pedroea-switcher-bar' => 'justify-content: {{VALUE}};' ],
			] );

			$this->add_responsive_control( 'bar_gap', [
				'label'      => __( 'Gap', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [ '{{WRAPPER}} .pedroea-switcher-bar' => 'gap: {{SIZE}}{{UNIT}};' ],
			] );

			$this->add_responsive_control( 'bar_spacing', [
				'label'      => __( 'Bottom Spacing', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'default'    => [ 'unit' => 'px', 'size' => 30 ],
				'selectors'  => [ '{{WRAPPER}} .pedroea-switcher-bar' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
			] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_labels', [
			'label' => __( 'Labels', 'pedro-for-elementor-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

			$this->add_group_control( Group_Control_Typography::get_type(), [
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .pedroea-switcher-bar .pedroea-label',
			] );

			$this->start_controls_tabs( 'tabs_label' );

				$this->start_controls_tab( 'tab_label_normal', [ 'label' => __( 'Normal', 'pedro-for-elementor-addons' ) ] );

					$this->add_control( 'label_color', [
						'label'     => __( 'Color', 'pedro-for-elementor-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#aaaaaa',
						'selectors' => [ '{{WRAPPER}} .pedroea-switcher-bar .pedroea-label' => 'color: {{VALUE}};' ],
					] );

				$this->end_controls_tab();

				$this->start_controls_tab( 'tab_label_active', [ 'label' => __( 'Active', 'pedro-for-elementor-addons' ) ] );

					$this->add_control( 'label_active_color', [
						'label'     => __( 'Color', 'pedro-for-elementor-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [ '{{WRAPPER}} .pedroea-switcher-bar .pedroea-label.active' => 'color: {{VALUE}};' ],
					] );

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_toggle', [
			'label' => __( 'Toggle', 'pedro-for-elementor-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

			$this->add_responsive_control( 'toggle_width', [
				'label'      => __( 'Width', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 40, 'max' => 120 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 64 ],
				'selectors'  => [ '{{WRAPPER}} .pedroea-toggle-track' => 'width: {{SIZE}}{{UNIT}};' ],
			] );

			$this->add_responsive_control( 'toggle_height', [
				'label'      => __( 'Height', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 34, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 34 ],
				'selectors'  => [
					'{{WRAPPER}} .pedroea-toggle-track' => 'height: {{SIZE}}{{UNIT}}; border-radius: {{SIZE}}{{UNIT}}; --pea-toggle-knob-size: calc({{SIZE}}{{UNIT}} - 6px);',
					'{{WRAPPER}} .pedroea-toggle-knob'  => 'width: calc({{SIZE}}{{UNIT}} - 6px); height: calc({{SIZE}}{{UNIT}} - 6px);',
				],
			] );

			$this->add_control( 'toggle_color_off', [
				'label'     => __( 'Track Color (Off)', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cccccc',
				'selectors' => [ '{{WRAPPER}} .pedroea-toggle-track' => 'background-color: {{VALUE}};' ],
			] );

			$this->add_control( 'toggle_color_on', [
				'label'     => __( 'Track Color (On)', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#4f35d2',
				'selectors' => [ '{{WRAPPER}} .pedroea-toggle-track.active' => 'background-color: {{VALUE}};' ],
			] );

			$this->add_control( 'toggle_knob_color', [
				'label'     => __( 'Knob Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [ '{{WRAPPER}} .pedroea-toggle-knob' => 'background-color: {{VALUE}};' ],
			] );

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings     = $this->get_settings_for_display();
		$items = array_slice( $settings['items'] ?? [], 0, 2 );

		if ( empty( $items ) ) return;

		$item_0    = $items[0];
		$item_1    = $items[1] ?? null;
		$uid       = $this->get_id();
		$toggle_id = 'pedroea-toggle-' . $uid;
		?>

		<div id="pedroea-cs-<?php echo esc_attr( $uid ); ?>" class="pedroea-content-switcher">

			<div class="pedroea-switcher-bar">

				<span class="pedroea-label active" data-index="0">
					<?php echo wp_kses_post( $item_0['item_title'] ); ?>
				</span>

				<label class="pedroea-toggle-track" for="<?php echo esc_attr( $toggle_id ); ?>">
					<input type="checkbox" id="<?php echo esc_attr( $toggle_id ); ?>" class="pedroea-toggle-input">
					<span class="pedroea-toggle-knob"></span>
				</label>

				<?php if ( $item_1 ) : ?>
				<span class="pedroea-label" data-index="1">
					<?php echo wp_kses_post( $item_1['item_title'] ); ?>
				</span>
				<?php endif; ?>

			</div>

			<div class="pedroea-panels">

				<div class="pedroea-panel active" data-index="0">
					<?php $this->render_panel( $item_0 ); ?>
				</div>

				<?php if ( $item_1 ) : ?>
				<div class="pedroea-panel" data-index="1">
					<?php $this->render_panel( $item_1 ); ?>
				</div>
				<?php endif; ?>

			</div>

		</div>
		<?php
	}

	private function render_panel( array $item ): void {
		if ( 'template' === ( $item['item_type'] ?? 'text' ) ) {
			$id = (int) ( $item['item_template'] ?? 0 );
			if ( $id ) {
				Plugin::$instance->frontend->enqueue_scripts();
				echo Plugin::$instance->frontend->get_builder_content_for_display( $id, true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		} else {
			$text = $item['item_text'] ?? '';
			if ( $text ) {
				echo '<div class="pedroea-panel-text">' . wp_kses_post( nl2br( $text ) ) . '</div>';
			}
		}
	}
}