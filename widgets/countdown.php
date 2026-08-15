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

class Countdown extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_countdown';
    }

    public function get_title(): string
    {
        return __('Countdown', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-countdown pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['countdown', 'timer', 'clock', 'date'];
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
            'target_date',
            [
                'label'   => __('Target Date', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::DATE_TIME,
                'default' => wp_date('Y-m-d H:i', current_time('timestamp') + 30 * DAY_IN_SECONDS),
            ]
        );

        $this->add_control(
            'show_days',
            [
                'label'   => __('Show Days', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_hours',
            [
                'label'   => __('Show Hours', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_minutes',
            [
                'label'   => __('Show Minutes', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_seconds',
            [
                'label'   => __('Show Seconds', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'labels',
            [
                'label'   => __('Show Labels', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'day_label',
            [
                'label'     => __('Day Label', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Days', 'pedro-for-elementor-addons'),
                'condition' => ['show_days' => 'yes', 'labels' => 'yes'],
            ]
        );

        $this->add_control(
            'hour_label',
            [
                'label'     => __('Hour Label', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Hours', 'pedro-for-elementor-addons'),
                'condition' => ['show_hours' => 'yes', 'labels' => 'yes'],
            ]
        );

        $this->add_control(
            'minute_label',
            [
                'label'     => __('Minute Label', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Minutes', 'pedro-for-elementor-addons'),
                'condition' => ['show_minutes' => 'yes', 'labels' => 'yes'],
            ]
        );

        $this->add_control(
            'second_label',
            [
                'label'     => __('Second Label', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Seconds', 'pedro-for-elementor-addons'),
                'condition' => ['show_seconds' => 'yes', 'labels' => 'yes'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_digits',
            [
                'label' => __('Digits', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'digit_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-cd-digit' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'digit_typography',
                'selector' => '{{WRAPPER}} .pea-cd-digit',
            ]
        );

        $this->add_control(
            'digit_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-cd-item' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'digit_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-cd-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'digit_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-cd-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'digit_border',
                'selector' => '{{WRAPPER}} .pea-cd-item',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_labels',
            [
                'label'     => __('Labels', 'pedro-for-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['labels' => 'yes'],
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6b7280',
                'selectors' => [
                    '{{WRAPPER}} .pea-cd-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'label_typography',
                'selector' => '{{WRAPPER}} .pea-cd-label',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrap', 'class', 'pea-countdown');
        $this->add_render_attribute('wrap', 'data-target', $settings['target_date']);
        $this->add_render_attribute('wrap', 'data-days', $settings['show_days'] ?? 'yes');
        $this->add_render_attribute('wrap', 'data-hours', $settings['show_hours'] ?? 'yes');
        $this->add_render_attribute('wrap', 'data-minutes', $settings['show_minutes'] ?? 'yes');
        $this->add_render_attribute('wrap', 'data-seconds', $settings['show_seconds'] ?? 'yes');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php if ('yes' === $settings['show_days']) : ?>
                <div class="pea-cd-item" data-unit="days">
                    <span class="pea-cd-digit">00</span>
                    <?php if ('yes' === $settings['labels']) : ?>
                        <span class="pea-cd-label"><?php echo esc_html($settings['day_label'] ?: __('Days', 'pedro-for-elementor-addons')); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ('yes' === $settings['show_hours']) : ?>
                <div class="pea-cd-item" data-unit="hours">
                    <span class="pea-cd-digit">00</span>
                    <?php if ('yes' === $settings['labels']) : ?>
                        <span class="pea-cd-label"><?php echo esc_html($settings['hour_label'] ?: __('Hours', 'pedro-for-elementor-addons')); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ('yes' === $settings['show_minutes']) : ?>
                <div class="pea-cd-item" data-unit="minutes">
                    <span class="pea-cd-digit">00</span>
                    <?php if ('yes' === $settings['labels']) : ?>
                        <span class="pea-cd-label"><?php echo esc_html($settings['minute_label'] ?: __('Minutes', 'pedro-for-elementor-addons')); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ('yes' === $settings['show_seconds']) : ?>
                <div class="pea-cd-item" data-unit="seconds">
                    <span class="pea-cd-digit">00</span>
                    <?php if ('yes' === $settings['labels']) : ?>
                        <span class="pea-cd-label"><?php echo esc_html($settings['second_label'] ?: __('Seconds', 'pedro-for-elementor-addons')); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
