<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

if (! defined('ABSPATH')) {
    exit;
}

class Progress_Bar extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_progress_bar';
    }

    public function get_title(): string
    {
        return __('Progress Bar', 'pedro-for-elementor-addons');
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
        return ['progress', 'bar', 'skill', 'percentage', 'animated'];
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
            'title',
            [
                'label'   => __('Title', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Web Design', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'percentage',
            [
                'label'   => __('Percentage', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 85,
                'min'     => 0,
                'max'     => 100,
            ]
        );

        $this->add_control(
            'display_percentage',
            [
                'label'   => __('Show Percentage', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'percentage_position',
            [
                'label'   => __('Percentage Position', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'inside',
                'options' => [
                    'inside'  => __('Inside Bar', 'pedro-for-elementor-addons'),
                    'outside' => __('Outside Bar', 'pedro-for-elementor-addons'),
                ],
                'condition' => ['display_percentage' => 'yes'],
            ]
        );

        $this->add_control(
            'animation_duration',
            [
                'label'   => __('Animation Duration (ms)', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1500,
                'min'     => 200,
                'max'     => 5000,
                'step'    => 100,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_bar',
            [
                'label' => __('Bar', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'bar_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .pea-progress-fill',
            ]
        );

        $this->add_control(
            'bar_empty_color',
            [
                'label'     => __('Empty Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e5e7eb',
                'selectors' => [
                    '{{WRAPPER}} .pea-progress-track' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bar_height',
            [
                'label'      => __('Height', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 6, 'max' => 80]],
                'default'    => ['unit' => 'px', 'size' => 28],
                'selectors'  => [
                    '{{WRAPPER}} .pea-progress-track' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bar_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => ['px' => ['min' => 0, 'max' => 50]],
                'default'    => ['unit' => 'px', 'size' => 14],
                'selectors'  => [
                    '{{WRAPPER}} .pea-progress-track' => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pea-progress-fill'  => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'bar_border',
                'selector' => '{{WRAPPER}} .pea-progress-track',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __('Title', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-progress-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .pea-progress-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => __('Margin Bottom', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 40]],
                'default'    => ['unit' => 'px', 'size' => 8],
                'selectors'  => [
                    '{{WRAPPER}} .pea-progress-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_percentage',
            [
                'label'     => __('Percentage', 'pedro-for-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['display_percentage' => 'yes'],
            ]
        );

        $this->add_control(
            'percentage_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-progress-percentage' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'percentage_typography',
                'selector' => '{{WRAPPER}} .pea-progress-percentage',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $percent  = min(100, max(0, (int) ($settings['percentage'] ?? 85)));
        $duration = $settings['animation_duration'] ?? 1500;

        $this->add_render_attribute('wrapper', 'class', 'pea-progress-bar');
        $this->add_render_attribute('wrapper', 'data-percent', $percent);
        $this->add_render_attribute('wrapper', 'data-duration', $duration);
        $this->add_render_attribute('wrapper', 'class', 'pea-progress-' . ($settings['percentage_position'] ?? 'inside'));
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php if ($settings['title']) : ?>
                <div class="pea-progress-title"><?php echo esc_html($settings['title']); ?></div>
            <?php endif; ?>
            <div class="pea-progress-track">
                <div class="pea-progress-fill" style="width: 0%;">
                    <?php if ('yes' === $settings['display_percentage'] && 'inside' === $settings['percentage_position']) : ?>
                        <span class="pea-progress-percentage"><?php echo esc_html($percent); ?>%</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ('yes' === $settings['display_percentage'] && 'outside' === $settings['percentage_position']) : ?>
                <span class="pea-progress-percentage pea-progress-percentage-outside"><?php echo esc_html($percent); ?>%</span>
            <?php endif; ?>
        </div>
        <?php
    }
}
