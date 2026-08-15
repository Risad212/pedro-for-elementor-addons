<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit;

class Threesixty_Rotation extends Widget_Base {

    public function get_name(): string {
        return 'pedroea_threesixty_rotation';
    }

    public function get_title(): string {
        return __( '360 Rotation', 'pedro-for-elementor-addons' );
    }

    public function get_icon(): string {
        return 'eicon-exchange pedro-elementor-icon';
    }

    public function get_categories(): array {
        return [ 'pedroea' ];
    }

    public function get_keywords(): array {
        return [ '360', 'rotation', 'rotate', 'product', 'viewer', 'image' ];
    }

    protected function register_controls(): void {

        $this->start_controls_section(
            'section_gallery',
            [
                'label' => __( 'Gallery', 'pedro-for-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image_gallery',
            [
                'label'      => __( 'Add Images', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::GALLERY,
                'show_label' => false,
                'dynamic'    => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'viewer_height',
            [
                'label'      => __( 'Height', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh' ],
                'range'      => [
                    'px' => [ 'min' => 100, 'max' => 800 ],
                    'vh' => [ 'min' => 10, 'max' => 100 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 400 ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-360-viewer' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
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
                    '{{WRAPPER}} .pedroea-360-wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            [
                'label' => __( 'Settings', 'pedro-for-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'   => __( 'Autoplay', 'pedro-for-elementor-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'    => __( 'None', 'pedro-for-elementor-addons' ),
                    'autoplay' => __( 'Autoplay', 'pedro-for-elementor-addons' ),
                    'button'  => __( 'Button Play', 'pedro-for-elementor-addons' ),
                ],
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => __( 'Autoplay Speed (ms)', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 2000,
                'min'       => 200,
                'max'       => 10000,
                'step'      => 100,
                'condition' => [ 'autoplay!' => 'none' ],
            ]
        );

        $this->add_control(
            'enable_magnify',
            [
                'label'        => __( 'Magnify', 'pedro-for-elementor-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'pedro-for-elementor-addons' ),
                'label_off'    => __( 'Hide', 'pedro-for-elementor-addons' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'magnify_amount',
            [
                'label'     => __( 'Magnify Amount', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [ 'px' => [ 'min' => 100, 'max' => 300 ] ],
                'default'   => [ 'size' => 200 ],
                'condition' => [ 'enable_magnify' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => __( 'Wrapper', 'pedro-for-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'wrapper_background',
                'selector' => '{{WRAPPER}} .pedroea-360-viewer',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wrapper_border',
                'selector' => '{{WRAPPER}} .pedroea-360-viewer',
            ]
        );

        $this->add_responsive_control(
            'wrapper_border_radius',
            [
                'label'      => __( 'Border Radius', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-360-viewer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'wrapper_box_shadow',
                'selector' => '{{WRAPPER}} .pedroea-360-viewer',
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => __( 'Padding', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-360-viewer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_magnify',
            [
                'label'     => __( 'Magnify', 'pedro-for-elementor-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'enable_magnify' => 'yes' ],
            ]
        );

        $this->add_control(
            'magnify_icon_color',
            [
                'label'     => __( 'Icon Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pedroea-360-magnify-btn svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'magnify_bg_color',
            [
                'label'     => __( 'Background Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(0,0,0,0.5)',
                'selectors' => [
                    '{{WRAPPER}} .pedroea-360-magnify-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label'     => __( 'Autoplay Button', 'pedro-for-elementor-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'autoplay' => 'button' ],
            ]
        );

        $this->add_control(
            'button_icon_color',
            [
                'label'     => __( 'Icon Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pedroea-360-play-btn svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label'     => __( 'Background Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .pedroea-360-play-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_hover_color',
            [
                'label'     => __( 'Hover Background', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .pedroea-360-play-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => __( 'Padding', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-360-play-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $images   = $settings['image_gallery'] ?? [];

        if ( empty( $images ) ) {
            echo '<div class="pedroea-360-empty">' . esc_html__( 'No images selected for 360 rotation.', 'pedro-for-elementor-addons' ) . '</div>';
            return;
        }

        $autoplay       = $settings['autoplay'] ?? 'none';
        $autoplay_speed = ! empty( $settings['autoplay_speed'] ) ? intval( $settings['autoplay_speed'] ) : 2000;
        $enable_magnify = $settings['enable_magnify'] ?? 'no';
        $magnify_amount = ! empty( $settings['magnify_amount']['size'] ) ? intval( $settings['magnify_amount']['size'] ) : 200;

        $frame_urls = [];
        foreach ( $images as $img ) {
            $frame_urls[] = wp_get_attachment_url( $img['id'] );
        }
        $frame_urls = array_values( array_filter( $frame_urls ) );

        if ( empty( $frame_urls ) ) {
            echo '<div class="pedroea-360-empty">' . esc_html__( 'No valid images found.', 'pedro-for-elementor-addons' ) . '</div>';
            return;
        }

        if ( count( $frame_urls ) < 2 ) {
            echo '<div class="pedroea-360-empty">' . esc_html__( 'Select at least 2 images for the 360 rotation.', 'pedro-for-elementor-addons' ) . '</div>';
            return;
        }

        $total_frames = count( $frame_urls );
        $first_image  = esc_url( $frame_urls[0] );

        $uid = 'pea-360-' . $this->get_id();

        $this->add_render_attribute( 'viewer', [
            'class'                => 'pedroea-360-viewer',
            'id'                   => $uid,
            'data-frames'          => wp_json_encode( $frame_urls ),
            'data-total'           => $total_frames,
            'data-autoplay'        => $autoplay,
            'data-autoplay-speed'  => $autoplay_speed,
            'data-magnify'         => $enable_magnify,
            'data-magnify-amount'  => $magnify_amount,
        ] );

        ?>
        <div class="pedroea-360-wrap">
            <div <?php echo $this->get_render_attribute_string( 'viewer' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                <img class="pedroea-360-frame" src="<?php echo $first_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" alt="<?php echo esc_attr__('360-degree product view', 'pedro-for-elementor-addons'); ?>">
                <?php if ( $enable_magnify === 'yes' ) : ?>
                    <button class="pedroea-360-magnify-btn" type="button">
                        <svg viewBox="0 0 24 24" width="20" height="20"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14zM7 9h5v1H7z"/><path d="M9 7h1v5H9z"/></svg>
                    </button>
                <?php endif; ?>
            </div>
            <?php if ( $autoplay === 'button' ) : ?>
                <button class="pedroea-360-play-btn" type="button">
                    <svg class="pedroea-360-play-icon" viewBox="0 0 24 24" width="18" height="18"><path d="M8 5v14l11-7z"/></svg>
                    <svg class="pedroea-360-pause-icon" viewBox="0 0 24 24" width="18" height="18" style="display:none"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                </button>
            <?php endif; ?>
        </div>
        <?php
    }
}
