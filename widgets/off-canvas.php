<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;

if (! defined('ABSPATH')) {
    exit;
}

class Off_Canvas extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_off_canvas';
    }

    public function get_title(): string
    {
        return __('Off-Canvas Menu', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-menu-bar pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['off-canvas', 'menu', 'panel', 'slide', 'drawer'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_trigger',
            [
                'label' => __('Trigger', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'trigger_type',
            [
                'label'   => __('Trigger Type', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon'   => __('Icon', 'pedro-for-elementor-addons'),
                    'button' => __('Button', 'pedro-for-elementor-addons'),
                    'text'   => __('Text', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_control(
            'trigger_icon',
            [
                'label'     => __('Icon', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::ICONS,
                'default'   => ['value' => 'fas fa-bars', 'library' => 'fa-solid'],
                'condition' => ['trigger_type' => 'icon'],
            ]
        );

        $this->add_control(
            'trigger_text',
            [
                'label'     => __('Text', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Menu', 'pedro-for-elementor-addons'),
                'condition' => ['trigger_type' => 'text'],
                'dynamic'   => ['active' => true],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'     => __('Button Text', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Open Menu', 'pedro-for-elementor-addons'),
                'condition' => ['trigger_type' => 'button'],
                'dynamic'   => ['active' => true],
            ]
        );

        $this->add_control(
            'trigger_align',
            [
                'label'     => __('Alignment', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'left',
                'separator' => 'before',
                'options'   => [
                    'left'   => ['title' => __('Left', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => __('Center', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'right'  => ['title' => __('Right', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pea-oc-trigger-wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_panel',
            [
                'label' => __('Panel', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'panel_position',
            [
                'label'   => __('Panel Position', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'right',
                'options' => [
                    'left'   => ['title' => __('Left', 'pedro-for-elementor-addons'), 'icon' => 'eicon-arrow-left'],
                    'right'  => ['title' => __('Right', 'pedro-for-elementor-addons'), 'icon' => 'eicon-arrow-right'],
                    'top'    => ['title' => __('Top', 'pedro-for-elementor-addons'), 'icon' => 'eicon-arrow-up'],
                    'bottom' => ['title' => __('Bottom', 'pedro-for-elementor-addons'), 'icon' => 'eicon-arrow-down'],
                ],
            ]
        );

        $this->add_control(
            'panel_content',
            [
                'label'   => __('Content', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::WYSIWYG,
                'default' => __('Your off-canvas content goes here.', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'show_close',
            [
                'label'   => __('Show Close Button', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'close_icon',
            [
                'label'     => __('Close Icon', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::ICONS,
                'default'   => ['value' => 'fas fa-times', 'library' => 'fa-solid'],
                'condition' => ['show_close' => 'yes'],
            ]
        );

        $this->add_control(
            'close_on_overlay',
            [
                'label'   => __('Close on Overlay Click', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'close_on_esc',
            [
                'label'   => __('Close on ESC', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_trigger',
            [
                'label' => __('Trigger', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'trigger_typography',
                'selector' => '{{WRAPPER}} .pea-oc-trigger',
            ]
        );

        $this->add_control(
            'trigger_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-oc-trigger' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'trigger_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-oc-trigger' => 'background: {{VALUE}};',
                ],
                'condition' => ['trigger_type' => 'button'],
            ]
        );

        $this->add_responsive_control(
            'trigger_icon_size',
            [
                'label'      => __('Icon Size', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 14, 'max' => 60]],
                'default'    => ['unit' => 'px', 'size' => 28],
                'selectors'  => [
                    '{{WRAPPER}} .pea-oc-trigger-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pea-oc-trigger-icon'     => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => ['trigger_type' => 'icon'],
            ]
        );

        $this->add_responsive_control(
            'trigger_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-oc-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => ['trigger_type' => 'button'],
            ]
        );

        $this->add_responsive_control(
            'trigger_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-oc-trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => ['trigger_type' => 'button'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_panel',
            [
                'label' => __('Panel', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'panel_bg',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .pea-oc-panel',
            ]
        );

        $this->add_responsive_control(
            'panel_width',
            [
                'label'      => __('Width', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range'      => [
                    'px' => ['min' => 200, 'max' => 800],
                    '%'  => ['min' => 10, 'max' => 100],
                    'vw' => ['min' => 10, 'max' => 100],
                ],
                'default'    => ['unit' => 'px', 'size' => 320],
                'selectors'  => [
                    '{{WRAPPER}} .pea-oc-panel' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'panel_height',
            [
                'label'      => __('Height', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range'      => [
                    'px' => ['min' => 100, 'max' => 800],
                    '%'  => ['min' => 10, 'max' => 100],
                    'vh' => ['min' => 10, 'max' => 100],
                ],
                'default'    => ['unit' => '%', 'size' => 100],
                'selectors'  => [
                    '{{WRAPPER}} .pea-oc-panel' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'panel_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-oc-panel-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'panel_border',
                'selector' => '{{WRAPPER}} .pea-oc-panel',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'panel_typography',
                'selector' => '{{WRAPPER}} .pea-oc-panel-inner',
            ]
        );

        $this->add_control(
            'panel_text_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-oc-panel-inner' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_overlay',
            [
                'label' => __('Overlay', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label'   => __('Overlay Color', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.5)',
                'selectors' => [
                    '{{WRAPPER}} .pea-oc-overlay' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_close',
            [
                'label'     => __('Close Button', 'pedro-for-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['show_close' => 'yes'],
            ]
        );

        $this->add_control(
            'close_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6b7280',
                'selectors' => [
                    '{{WRAPPER}} .pea-oc-close' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'close_size',
            [
                'label'      => __('Size', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 12, 'max' => 48]],
                'default'    => ['unit' => 'px', 'size' => 24],
                'selectors'  => [
                    '{{WRAPPER}} .pea-oc-close svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pea-oc-close'     => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'close_position_top',
            [
                'label'      => __('Top', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 100],
                    '%'  => ['min' => 0, 'max' => 50],
                ],
                'default'    => ['unit' => 'px', 'size' => 20],
                'selectors'  => [
                    '{{WRAPPER}} .pea-oc-close' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'close_position_right',
            [
                'label'      => __('Right', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => 0, 'max' => 100],
                    '%'  => ['min' => 0, 'max' => 50],
                ],
                'default'    => ['unit' => 'px', 'size' => 20],
                'selectors'  => [
                    '{{WRAPPER}} .pea-oc-close' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();

        $this->add_render_attribute('trigger', 'class', 'pea-oc-trigger');
        $this->add_render_attribute('trigger', 'data-panel', 'pea-oc-' . $id);

        $this->add_render_attribute('overlay', 'class', 'pea-oc-overlay');
        $this->add_render_attribute('overlay', 'data-panel', 'pea-oc-' . $id);

        $this->add_render_attribute('panel', 'class', 'pea-oc-panel');
        $this->add_render_attribute('panel', 'id', 'pea-oc-' . $id);
        $this->add_render_attribute('panel', 'data-position', $settings['panel_position'] ?? 'right');

        if ('yes' !== $settings['close_on_overlay']) {
            $this->add_render_attribute('overlay', 'data-close-overlay', 'false');
        }
        if ('yes' !== $settings['close_on_esc']) {
            $this->add_render_attribute('overlay', 'data-close-esc', 'false');
        }
        ?>
        <div class="pea-off-canvas">
            <div class="pea-oc-trigger-wrap">
                <?php if ('icon' === $settings['trigger_type']) : ?>
                    <button <?php echo $this->get_render_attribute_string('trigger'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                        <span class="pea-oc-trigger-icon"><?php Icons_Manager::render_icon($settings['trigger_icon'], ['aria-hidden' => 'true']); ?></span>
                    </button>
                <?php elseif ('text' === $settings['trigger_type']) : ?>
                    <button <?php echo $this->get_render_attribute_string('trigger'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                        <?php echo esc_html($settings['trigger_text']); ?>
                    </button>
                <?php else : ?>
                    <button <?php echo $this->get_render_attribute_string('trigger'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                        <?php echo esc_html($settings['button_text']); ?>
                    </button>
                <?php endif; ?>
            </div>

            <div <?php echo $this->get_render_attribute_string('overlay'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div>

            <div <?php echo $this->get_render_attribute_string('panel'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                <div class="pea-oc-panel-inner">
                    <?php if ('yes' === $settings['show_close']) : ?>
                        <button class="pea-oc-close" data-panel="pea-oc-<?php echo esc_attr($id); ?>">
                            <?php if (! empty($settings['close_icon']['value'])) : ?>
                                <?php Icons_Manager::render_icon($settings['close_icon'], ['aria-hidden' => 'true']); ?>
                            <?php else : ?>
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>
                    <?php echo wp_kses_post($settings['panel_content']); ?>
                </div>
            </div>
        </div>
        <?php
    }
}
