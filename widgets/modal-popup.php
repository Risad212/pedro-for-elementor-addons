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

class Modal_Popup extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_modal_popup';
    }

    public function get_title(): string
    {
        return __('Modal Popup', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-frame-expand pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['modal', 'popup', 'lightbox', 'dialog'];
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
                'default' => 'button',
                'options' => [
                    'button' => __('Button', 'pedro-for-elementor-addons'),
                    'icon'   => __('Icon', 'pedro-for-elementor-addons'),
                    'text'   => __('Text', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'     => __('Button Text', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Open Modal', 'pedro-for-elementor-addons'),
                'condition' => ['trigger_type' => 'button'],
                'dynamic'   => ['active' => true],
            ]
        );

        $this->add_control(
            'trigger_icon',
            [
                'label'     => __('Icon', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::ICONS,
                'condition' => ['trigger_type' => 'icon'],
            ]
        );

        $this->add_control(
            'trigger_text',
            [
                'label'     => __('Text', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Open', 'pedro-for-elementor-addons'),
                'condition' => ['trigger_type' => 'text'],
                'dynamic'   => ['active' => true],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Modal Content', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'modal_title',
            [
                'label'   => __('Title', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Modal Title', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'modal_content',
            [
                'label'   => __('Content', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::WYSIWYG,
                'default' => __('Modal content goes here.', 'pedro-for-elementor-addons'),
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
            'close_on_overlay',
            [
                'label'   => __('Close on Overlay Click', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
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
                'selector' => '{{WRAPPER}} .pea-modal-trigger',
            ]
        );

        $this->add_control(
            'trigger_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-modal-trigger' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'trigger_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7c3aed',
                'selectors' => [
                    '{{WRAPPER}} .pea-modal-trigger' => 'background: {{VALUE}};',
                ],
                'condition' => ['trigger_type' => 'button'],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'trigger_border',
                'selector' => '{{WRAPPER}} .pea-modal-trigger',
                'condition' => ['trigger_type' => 'button'],
            ]
        );

        $this->add_responsive_control(
            'trigger_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-modal-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => ['trigger_type' => 'button'],
            ]
        );

        $this->add_responsive_control(
            'trigger_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-modal-trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'range'      => ['px' => ['min' => 14, 'max' => 80]],
                'default'    => ['unit' => 'px', 'size' => 24],
                'selectors'  => [
                    '{{WRAPPER}} .pea-modal-trigger .pea-trigger-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pea-modal-trigger .pea-trigger-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => ['trigger_type' => 'icon'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_modal',
            [
                'label' => __('Modal', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'modal_width',
            [
                'label'      => __('Width', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => 200, 'max' => 1200],
                    '%'  => ['min' => 10, 'max' => 100],
                ],
                'default'    => ['unit' => 'px', 'size' => 600],
                'selectors'  => [
                    '{{WRAPPER}} .pea-modal-box' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'modal_bg',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .pea-modal-box',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'modal_border',
                'selector' => '{{WRAPPER}} .pea-modal-box',
            ]
        );

        $this->add_responsive_control(
            'modal_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-modal-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'modal_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-modal-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label'     => __('Overlay Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'default'   => 'rgba(0,0,0,0.7)',
                'selectors' => [
                    '{{WRAPPER}} .pea-modal-overlay' => 'background: {{VALUE}};',
                ],
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
            'modal_title_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-modal-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'modal_title_typography',
                'selector' => '{{WRAPPER}} .pea-modal-title',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();
        $this->add_render_attribute('trigger', 'class', 'pea-modal-trigger');
        $this->add_render_attribute('trigger', 'data-modal', 'pea-modal-' . $id);

        $this->add_render_attribute('overlay', 'class', 'pea-modal-overlay');
        $this->add_render_attribute('overlay', 'id', 'pea-modal-' . $id);

        if ('yes' !== $settings['close_on_overlay']) {
            $this->add_render_attribute('overlay', 'data-close-overlay', 'false');
        }
        if ('yes' !== $settings['close_on_esc']) {
            $this->add_render_attribute('overlay', 'data-close-esc', 'false');
        }
        ?>
        <div class="pea-modal-wrap">
            <button <?php echo $this->get_render_attribute_string('trigger'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                <?php if ('icon' === $settings['trigger_type'] && ! empty($settings['trigger_icon']['value'])) : ?>
                    <span class="pea-trigger-icon"><?php Icons_Manager::render_icon($settings['trigger_icon'], ['aria-hidden' => 'true']); ?></span>
                <?php elseif ('text' === $settings['trigger_type']) : ?>
                    <?php echo esc_html($settings['trigger_text']); ?>
                <?php else : ?>
                    <?php echo esc_html($settings['button_text']); ?>
                <?php endif; ?>
            </button>

            <div <?php echo $this->get_render_attribute_string('overlay'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                <div class="pea-modal-box">
                    <?php if ('yes' === $settings['show_close']) : ?>
                        <span class="pea-modal-close">&times;</span>
                    <?php endif; ?>
                    <?php if ($settings['modal_title']) : ?>
                        <div class="pea-modal-title"><?php echo esc_html($settings['modal_title']); ?></div>
                    <?php endif; ?>
                    <div class="pea-modal-body"><?php echo wp_kses_post($settings['modal_content']); ?></div>
                </div>
            </div>
        </div>
        <?php
    }
}
