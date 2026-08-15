<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if (! defined('ABSPATH')) {
    exit;
}

class Flixbox extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_flixbox';
    }

    public function get_title(): string
    {
        return __('Flixbox', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-flip-box pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['flip', 'box', 'flipbox', 'flixbox', 'card'];
    }

    protected function register_controls()
    {

        // ==================== Front Side ====================
        $this->start_controls_section(
            'section_front',
            [
                'label' => __('Front', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'front_icon_type',
            [
                'label'   => __('Icon Type', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'icon',
                'options' => [
                    'icon'  => [
                        'title' => __('Icon', 'pedro-for-elementor-addons'),
                        'icon'  => 'eicon-star',
                    ],
                    'image' => [
                        'title' => __('Image', 'pedro-for-elementor-addons'),
                        'icon'  => 'eicon-image-bold',
                    ],
                ],
            ]
        );

        $this->add_control(
            'front_icon',
            [
                'label'     => __('Icon', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => ['front_icon_type' => 'icon'],
            ]
        );

        $this->add_control(
            'front_image',
            [
                'label'     => __('Image', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => '',
                ],
                'condition' => ['front_icon_type' => 'image'],
            ]
        );

        $this->add_control(
            'front_title',
            [
                'label'   => __('Title', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Front Title', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'front_description',
            [
                'label'   => __('Description', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'pedro-for-elementor-addons'),
                'rows'    => 5,
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'front_button_text',
            [
                'label'   => __('Button Text', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Learn More', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'front_button_link',
            [
                'label'       => __('Button Link', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'pedro-for-elementor-addons'),
                'default'     => [
                    'url' => '#',
                ],
                'dynamic' => ['active' => true],
            ]
        );

        $this->end_controls_section();

        // ==================== Back Side ====================
        $this->start_controls_section(
            'section_back',
            [
                'label' => __('Back', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'back_icon_type',
            [
                'label'   => __('Icon Type', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'icon',
                'options' => [
                    'icon'  => [
                        'title' => __('Icon', 'pedro-for-elementor-addons'),
                        'icon'  => 'eicon-star',
                    ],
                    'image' => [
                        'title' => __('Image', 'pedro-for-elementor-addons'),
                        'icon'  => 'eicon-image-bold',
                    ],
                ],
            ]
        );

        $this->add_control(
            'back_icon',
            [
                'label'     => __('Icon', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => ['back_icon_type' => 'icon'],
            ]
        );

        $this->add_control(
            'back_image',
            [
                'label'     => __('Image', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => '',
                ],
                'condition' => ['back_icon_type' => 'image'],
            ]
        );

        $this->add_control(
            'back_title',
            [
                'label'   => __('Title', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Back Title', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'back_description',
            [
                'label'   => __('Description', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'pedro-for-elementor-addons'),
                'rows'    => 5,
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'back_button_text',
            [
                'label'   => __('Button Text', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Learn More', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'back_button_link',
            [
                'label'       => __('Button Link', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'pedro-for-elementor-addons'),
                'default'     => [
                    'url' => '#',
                ],
                'dynamic' => ['active' => true],
            ]
        );

        $this->end_controls_section();

        // ==================== Settings ====================
        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Settings', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'flip_direction',
            [
                'label'   => __('Flip Direction', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'  => __('Left', 'pedro-for-elementor-addons'),
                    'right' => __('Right', 'pedro-for-elementor-addons'),
                    'up'    => __('Up', 'pedro-for-elementor-addons'),
                    'down'  => __('Down', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_responsive_control(
            'box_height',
            [
                'label'      => __('Height', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range'      => [
                    'px' => ['min' => 100, 'max' => 600],
                    'vh' => ['min' => 10, 'max' => 100],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pea-flixbox-inner' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==================== Style: Box ====================
        $this->start_controls_section(
            'section_style_box',
            [
                'label' => __('Box', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-flixbox-front, {{WRAPPER}} .pea-flixbox-back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'box_border',
                'selector' => '{{WRAPPER}} .pea-flixbox-inner',
            ]
        );

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-flixbox-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .pea-flixbox-front' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .pea-flixbox-back'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow',
                'selector' => '{{WRAPPER}} .pea-flixbox-inner',
            ]
        );

        $this->end_controls_section();

        // ==================== Style: Front ====================
        $this->start_controls_section(
            'section_style_front',
            [
                'label' => __('Front', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'front_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .pea-flixbox-front',
            ]
        );

        $this->add_control(
            'front_icon_color',
            [
                'label'     => __('Icon Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-flixbox-front .pea-flixbox-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pea-flixbox-front .pea-flixbox-icon svg' => 'fill: {{VALUE}};',
                ],
                'condition' => ['front_icon_type' => 'icon'],
            ]
        );

        $this->add_responsive_control(
            'front_icon_size',
            [
                'label'      => __('Icon Size', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => ['px' => ['min' => 10, 'max' => 120]],
                'default'    => ['unit' => 'px', 'size' => 40],
                'selectors'  => [
                    '{{WRAPPER}} .pea-flixbox-front .pea-flixbox-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pea-flixbox-front .pea-flixbox-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => ['front_icon_type' => 'icon'],
            ]
        );

        $this->add_control(
            'front_title_color',
            [
                'label'     => __('Title Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-flixbox-front .pea-flixbox-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'front_title_typography',
                'selector' => '{{WRAPPER}} .pea-flixbox-front .pea-flixbox-title',
            ]
        );

        $this->add_control(
            'front_description_color',
            [
                'label'     => __('Description Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-flixbox-front .pea-flixbox-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'front_description_typography',
                'selector' => '{{WRAPPER}} .pea-flixbox-front .pea-flixbox-description',
            ]
        );

        $this->end_controls_section();

        // ==================== Style: Back ====================
        $this->start_controls_section(
            'section_style_back',
            [
                'label' => __('Back', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'back_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .pea-flixbox-back',
            ]
        );

        $this->add_control(
            'back_icon_color',
            [
                'label'     => __('Icon Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-flixbox-back .pea-flixbox-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pea-flixbox-back .pea-flixbox-icon svg' => 'fill: {{VALUE}};',
                ],
                'condition' => ['back_icon_type' => 'icon'],
            ]
        );

        $this->add_responsive_control(
            'back_icon_size',
            [
                'label'      => __('Icon Size', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range'      => ['px' => ['min' => 10, 'max' => 120]],
                'default'    => ['unit' => 'px', 'size' => 40],
                'selectors'  => [
                    '{{WRAPPER}} .pea-flixbox-back .pea-flixbox-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pea-flixbox-back .pea-flixbox-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => ['back_icon_type' => 'icon'],
            ]
        );

        $this->add_control(
            'back_title_color',
            [
                'label'     => __('Title Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-flixbox-back .pea-flixbox-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'back_title_typography',
                'selector' => '{{WRAPPER}} .pea-flixbox-back .pea-flixbox-title',
            ]
        );

        $this->add_control(
            'back_description_color',
            [
                'label'     => __('Description Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-flixbox-back .pea-flixbox-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'back_description_typography',
                'selector' => '{{WRAPPER}} .pea-flixbox-back .pea-flixbox-description',
            ]
        );

        $this->end_controls_section();

        // ==================== Style: Button ====================
        $this->start_controls_section(
            'section_style_button',
            [
                'label' => __('Button', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .pea-flixbox-button',
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab(
            'button_normal',
            ['label' => __('Normal', 'pedro-for-elementor-addons')]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-flixbox-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .pea-flixbox-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'button_border',
                'selector' => '{{WRAPPER}} .pea-flixbox-button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover',
            ['label' => __('Hover', 'pedro-for-elementor-addons')]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-flixbox-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_hover_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .pea-flixbox-button:hover',
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => __('Border Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-flixbox-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'separator'  => 'before',
                'selectors'  => [
                    '{{WRAPPER}} .pea-flixbox-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-flixbox-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $direction = $settings['flip_direction'] ?? 'left';

        $this->add_render_attribute('wrapper', 'class', 'pea-flixbox');
        $this->add_render_attribute('wrapper', 'class', 'pea-flip-' . $direction);

        $this->add_render_attribute('back_button', 'class', 'pea-flixbox-button');
        if (! empty($settings['back_button_link']['url'])) {
            $this->add_link_attributes('back_button', $settings['back_button_link']);
        }

        $this->add_render_attribute('front_button', 'class', 'pea-flixbox-button');
        if (! empty($settings['front_button_link']['url'])) {
            $this->add_link_attributes('front_button', $settings['front_button_link']);
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <div class="pea-flixbox-inner">
                <div class="pea-flixbox-front">
                    <div class="pea-flixbox-content">
                        <?php $this->render_icon('front', $settings); ?>
                        <?php if ($settings['front_title']) : ?>
                            <div class="pea-flixbox-title"><?php echo wp_kses_post($settings['front_title']); ?></div>
                        <?php endif; ?>
                        <?php if ($settings['front_description']) : ?>
                            <div class="pea-flixbox-description"><?php echo wp_kses_post($settings['front_description']); ?></div>
                        <?php endif; ?>
                        <?php if ($settings['front_button_text']) : ?>
                            <?php if (! empty($settings['front_button_link']['url'])) : ?>
                                <a <?php echo $this->get_render_attribute_string('front_button'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                                    <?php echo esc_html($settings['front_button_text']); ?>
                                </a>
                            <?php else : ?>
                                <span class="pea-flixbox-button"><?php echo esc_html($settings['front_button_text']); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="pea-flixbox-back">
                    <div class="pea-flixbox-content">
                        <?php $this->render_icon('back', $settings); ?>
                        <?php if ($settings['back_title']) : ?>
                            <div class="pea-flixbox-title"><?php echo wp_kses_post($settings['back_title']); ?></div>
                        <?php endif; ?>
                        <?php if ($settings['back_description']) : ?>
                            <div class="pea-flixbox-description"><?php echo wp_kses_post($settings['back_description']); ?></div>
                        <?php endif; ?>
                        <?php if ($settings['back_button_text']) : ?>
                            <?php if (! empty($settings['back_button_link']['url'])) : ?>
                                <a <?php echo $this->get_render_attribute_string('back_button'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                                    <?php echo esc_html($settings['back_button_text']); ?>
                                </a>
                            <?php else : ?>
                                <span class="pea-flixbox-button"><?php echo esc_html($settings['back_button_text']); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function render_icon($side, $settings)
    {
        $type = $settings[$side . '_icon_type'] ?? 'icon';

        if ('icon' === $type && ! empty($settings[$side . '_icon']['value'])) {
            echo '<div class="pea-flixbox-icon">';
            Icons_Manager::render_icon($settings[$side . '_icon'], ['aria-hidden' => 'true']);
            echo '</div>';
        } elseif ('image' === $type && ! empty($settings[$side . '_image']['url'])) {
            echo '<div class="pea-flixbox-image">';
            echo '<img src="' . esc_url($settings[$side . '_image']['url']) . '" alt="' . esc_attr($settings[$side . '_title'] ?? '') . '">';
            echo '</div>';
        }
    }
}
