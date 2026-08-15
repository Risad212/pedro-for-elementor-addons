<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) {
    exit;
}

class Progress_Ring extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_progress_ring';
    }

    public function get_title(): string
    {
        return __('Progress Ring', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-skill-bar pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['progress', 'ring', 'circle', 'pie', 'chart'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'percent',
            [
                'label'   => __('Percentage', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SLIDER,
                'range'   => ['px' => ['min' => 0, 'max' => 100]],
                'default' => ['size' => 75],
            ]
        );

        $this->add_control(
            'text',
            [
                'label'   => __('Inner Text', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('75%', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'animation_duration',
            [
                'label'   => __('Animation Duration (ms)', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1200,
                'min'     => 0,
                'step'    => 100,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_ring',
            [
                'label' => __('Ring', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bar_color',
            [
                'label'   => __('Bar Color', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::COLOR,
                'default' => '#2563eb',
            ]
        );

        $this->add_control(
            'track_color',
            [
                'label'   => __('Track Color', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::COLOR,
                'default' => '#e5e7eb',
            ]
        );

        $this->add_control(
            'size',
            [
                'label'   => __('Size (px)', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SLIDER,
                'range'   => ['px' => ['min' => 50, 'max' => 500]],
                'default' => ['size' => 180],
            ]
        );

        $this->add_control(
            'stroke_width',
            [
                'label'   => __('Stroke Width', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SLIDER,
                'range'   => ['px' => ['min' => 2, 'max' => 50]],
                'default' => ['size' => 8],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => __('Inner Text', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'inner_text_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-pr-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'inner_text_typography',
                'selector' => '{{WRAPPER}} .pea-pr-text',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $percent   = $settings['percent']['size'] ?? 75;
        $size      = $settings['size']['size'] ?? 180;
        $stroke    = $settings['stroke_width']['size'] ?? 8;
        $radius    = ($size / 2) - ($stroke / 2);
        $circ      = 2 * M_PI * $radius;
        $offset    = $circ - ($percent / 100) * $circ;
        $duration  = $settings['animation_duration'] ?: 1200;

        $this->add_render_attribute('svg', [
            'data-percent'     => $percent,
            'data-offset'      => $offset,
            'data-circ'        => $circ,
            'data-duration'    => $duration,
            'class'            => 'pea-pr-svg',
            'width'            => $size,
            'height'           => $size,
            'viewBox'          => sprintf('0 0 %d %d', $size, $size),
        ]);
        ?>
        <div class="pea-progress-ring" style="width:<?php echo (int) $size; ?>px;height:<?php echo (int) $size; ?>px;">
            <svg <?php echo $this->get_render_attribute_string('svg'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                <circle class="pea-pr-track" cx="<?php echo esc_attr( $size / 2 ); ?>" cy="<?php echo esc_attr( $size / 2 ); ?>" r="<?php echo esc_attr( $radius ); ?>" fill="none" stroke="<?php echo esc_attr($settings['track_color']); ?>" stroke-width="<?php echo (int) $stroke; ?>"/>
                <circle class="pea-pr-bar" cx="<?php echo esc_attr( $size / 2 ); ?>" cy="<?php echo esc_attr( $size / 2 ); ?>" r="<?php echo esc_attr( $radius ); ?>" fill="none" stroke="<?php echo esc_attr($settings['bar_color']); ?>" stroke-width="<?php echo (int) $stroke; ?>" stroke-linecap="round" stroke-dasharray="<?php echo esc_attr( $circ ); ?>" stroke-dashoffset="<?php echo esc_attr( $circ ); ?>" transform="rotate(-90 <?php echo esc_attr( $size / 2 ); ?> <?php echo esc_attr( $size / 2 ); ?>)"/>
            </svg>
            <div class="pea-pr-text"><?php echo esc_html($settings['text']); ?></div>
        </div>
        <?php
    }
}
