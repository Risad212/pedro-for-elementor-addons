<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) {
    exit;
}

class Badge extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_badge';
    }

    public function get_title(): string
    {
        return __('Badge', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-star pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['badge', 'ribbon', 'tag', 'label', 'sale'];
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
            'badge_text',
            [
                'label'       => __('Badge Text', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('New', 'pedro-for-elementor-addons'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'badge_icon',
            [
                'label'   => __('Icon', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'position',
            [
                'label'   => __('Position', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'top-left',
                'options' => [
                    'top-left'     => __('Top Left', 'pedro-for-elementor-addons'),
                    'top-right'    => __('Top Right', 'pedro-for-elementor-addons'),
                    'bottom-left'  => __('Bottom Left', 'pedro-for-elementor-addons'),
                    'bottom-right' => __('Bottom Right', 'pedro-for-elementor-addons'),
                    'custom'       => __('Custom', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_responsive_control(
            'offset_x',
            [
                'label'      => __('Horizontal Offset', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => -200, 'max' => 200],
                    '%'  => ['min' => -50, 'max' => 150],
                ],
                'default'   => ['unit' => 'px', 'size' => 0],
                'condition' => ['position' => 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pea-badge' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                ],
            ]
        );

        $this->add_responsive_control(
            'offset_y',
            [
                'label'      => __('Vertical Offset', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => ['min' => -200, 'max' => 200],
                    '%'  => ['min' => -50, 'max' => 150],
                ],
                'default'   => ['unit' => 'px', 'size' => 0],
                'condition' => ['position' => 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .pea-badge' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label'   => __('Link', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::URL,
                'dynamic' => ['active' => true],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Style', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-badge' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7c3aed',
                'selectors' => [
                    '{{WRAPPER}} .pea-badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => __('Icon Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-badge-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
                'condition' => ['badge_icon[value]!' => ''],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_gap',
            [
                'label'      => __('Icon Gap', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 30]],
                'default'    => ['unit' => 'px', 'size' => 6],
                'selectors'  => [
                    '{{WRAPPER}} .pea-badge' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'badge_typography',
                'selector' => '{{WRAPPER}} .pea-badge',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrap', 'class', 'pea-badge');
        $this->add_render_attribute('wrap', 'class', 'pea-badge-' . ($settings['position'] ?? 'top-left'));

        $icon_markup = '';
        if (! empty($settings['badge_icon']['value'])) {
            $icon_markup = '<span class="pea-badge-icon">' . \Elementor\Icons_Manager::render_icon($settings['badge_icon'], ['aria-hidden' => 'true']) . '</span>';
        }

        $content = $icon_markup . '<span class="pea-badge-text">' . esc_html($settings['badge_text'] ?? '') . '</span>';

        if (! empty($settings['link']['url'])) {
            $this->add_link_attributes('badge_link', $settings['link']);
            $output = '<a ' . $this->get_render_attribute_string('badge_link') . '>' . $content . '</a>';
        } else {
            $output = $content;
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>
        <?php
    }
}