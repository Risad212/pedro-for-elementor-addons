<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (! defined('ABSPATH')) {
    exit;
}

class Hotspot extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_hotspot';
    }

    public function get_title(): string
    {
        return __('Hotspot', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-hotspot pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['hotspot', 'image', 'marker', 'tooltip', 'map'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_image',
            [
                'label' => __('Image', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image',
            [
                'label'   => __('Choose Image', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image',
                'default'   => 'large',
                'separator' => 'none',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_hotspots',
            [
                'label' => __('Hotspots', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'x_position',
            [
                'label'      => __('X Position (%)', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range'      => ['%' => ['min' => 0, 'max' => 100]],
                'default'    => ['unit' => '%', 'size' => 50],
            ]
        );

        $repeater->add_control(
            'y_position',
            [
                'label'      => __('Y Position (%)', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range'      => ['%' => ['min' => 0, 'max' => 100]],
                'default'    => ['unit' => '%', 'size' => 50],
            ]
        );

        $repeater->add_control(
            'tooltip_text',
            [
                'label'       => __('Label', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Hotspot', 'pedro-for-elementor-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tooltip_title',
            [
                'label'       => __('Tooltip Title', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tooltip_content',
            [
                'label'       => __('Tooltip Content', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tooltip_icon',
            [
                'label' => __('Tooltip Icon', 'pedro-for-elementor-addons'),
                'type'  => Controls_Manager::ICONS,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'   => __('Link', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::URL,
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'hotspots',
            [
                'label'       => __('Hotspots', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'x_position'     => ['unit' => '%', 'size' => 30],
                        'y_position'     => ['unit' => '%', 'size' => 40],
                        'tooltip_text'   => __('Hotspot 1', 'pedro-for-elementor-addons'),
                        'tooltip_title'  => __('Feature 1', 'pedro-for-elementor-addons'),
                        'tooltip_content' => __('This is the first hotspot.', 'pedro-for-elementor-addons'),
                    ],
                    [
                        'x_position'     => ['unit' => '%', 'size' => 70],
                        'y_position'     => ['unit' => '%', 'size' => 60],
                        'tooltip_text'   => __('Hotspot 2', 'pedro-for-elementor-addons'),
                        'tooltip_title'  => __('Feature 2', 'pedro-for-elementor-addons'),
                        'tooltip_content' => __('This is the second hotspot.', 'pedro-for-elementor-addons'),
                    ],
                ],
                'title_field' => '{{{ tooltip_text }}}',
            ]
        );

        $this->add_control(
            'trigger',
            [
                'label'   => __('Trigger', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'click',
                'options' => [
                    'click' => __('Click', 'pedro-for-elementor-addons'),
                    'hover' => __('Hover', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_marker',
            [
                'label' => __('Marker', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'marker_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-hotspot-dot' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'marker_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7c3aed',
                'selectors' => [
                    '{{WRAPPER}} .pea-hotspot-dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'marker_size',
            [
                'label'      => __('Size', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 16, 'max' => 64]],
                'default'    => ['unit' => 'px', 'size' => 24],
                'selectors'  => [
                    '{{WRAPPER}} .pea-hotspot-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: calc({{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'marker_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-hotspot-dot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_tooltip',
            [
                'label' => __('Tooltip', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tooltip_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-hotspot-tooltip' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tooltip_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-hotspot-tooltip' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tooltip_width',
            [
                'label'      => __('Width', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 120, 'max' => 400]],
                'default'    => ['unit' => 'px', 'size' => 220],
                'selectors'  => [
                    '{{WRAPPER}} .pea-hotspot-tooltip' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tooltip_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-hotspot-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tooltip_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-hotspot-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'tooltip_shadow',
                'selector' => '{{WRAPPER}} .pea-hotspot-tooltip',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tooltip_typography',
                'selector' => '{{WRAPPER}} .pea-hotspot-tooltip',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['image']['url'])) {
            return;
        }

        $this->add_render_attribute('wrap', 'class', 'pea-hotspot');
        $this->add_render_attribute('wrap', 'data-trigger', $settings['trigger'] ?? 'click');

        $image_html = \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'image');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php echo $image_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php foreach ((array) $settings['hotspots'] as $index => $item) : ?>
                <?php
                $x = isset($item['x_position']['size']) ? $item['x_position']['size'] : 50;
                $y = isset($item['y_position']['size']) ? $item['y_position']['size'] : 50;

                $this->add_render_attribute('dot' . $index, 'class', 'pea-hotspot-dot');
                $this->add_render_attribute('dot' . $index, 'style', 'left:' . esc_attr($x) . '%; top:' . esc_attr($y) . '%;');
                $this->add_render_attribute('dot' . $index, 'aria-label', $item['tooltip_text'] ?? '');
                ?>
                <span <?php echo $this->get_render_attribute_string('dot' . $index); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                    <span class="pea-hotspot-dot-icon" aria-hidden="true"><?php echo \Elementor\Icons_Manager::try_render_icon($item['tooltip_icon'] ?? [], ['aria-hidden' => 'true']); ?></span>
                    <span class="pea-hotspot-tooltip">
                        <?php if (! empty($item['tooltip_title'])) : ?>
                            <span class="pea-hotspot-tooltip-title"><?php echo esc_html($item['tooltip_title']); ?></span>
                        <?php endif; ?>
                        <?php if (! empty($item['tooltip_content'])) : ?>
                            <span class="pea-hotspot-tooltip-content"><?php echo esc_html($item['tooltip_content']); ?></span>
                        <?php endif; ?>
                        <?php if (! empty($item['link']['url'])) : ?>
                            <a class="pea-hotspot-tooltip-link" href="<?php echo esc_url($item['link']['url']); ?>"><?php echo esc_html($item['link']['url']); ?></a>
                        <?php endif; ?>
                    </span>
                </span>
            <?php endforeach; ?>
        </div>
        <?php
    }
}