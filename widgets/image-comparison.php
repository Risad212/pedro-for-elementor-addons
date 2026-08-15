<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

if (! defined('ABSPATH')) {
    exit;
}

class Image_Comparison extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_image_comparison';
    }

    public function get_title(): string
    {
        return __('Image Comparison', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-image-before-after pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['image', 'comparison', 'before', 'after', 'slider'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Images', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'before_image',
            [
                'label'   => __('Before Image', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::MEDIA,
                'default' => ['url' => ''],
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'after_image',
            [
                'label'   => __('After Image', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::MEDIA,
                'default' => ['url' => ''],
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'before_label',
            [
                'label'   => __('Before Label', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Before', 'pedro-for-elementor-addons'),
                'separator' => 'before',
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'after_label',
            [
                'label'   => __('After Label', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('After', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'orientation',
            [
                'label'   => __('Orientation', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => __('Horizontal', 'pedro-for-elementor-addons'),
                    'vertical'   => __('Vertical', 'pedro-for-elementor-addons'),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'default_offset',
            [
                'label'   => __('Default Position (%)', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SLIDER,
                'range'   => ['min' => 0, 'max' => 100],
                'default' => ['size' => 50],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_handle',
            [
                'label' => __('Handle', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'handle_color',
            [
                'label'   => __('Handle Color', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-ic-handle' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .pea-ic-handle::before, {{WRAPPER}} .pea-ic-handle::after' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'handle_circle_color',
            [
                'label'   => __('Handle Circle Color', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-ic-handle' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'handle_size',
            [
                'label'   => __('Handle Size', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SLIDER,
                'range'   => ['min' => 20, 'max' => 80],
                'default' => ['size' => 40],
                'selectors' => [
                    '{{WRAPPER}} .pea-ic-handle' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_labels',
            [
                'label' => __('Labels', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-ic-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'label_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(0,0,0,0.6)',
                'selectors' => [
                    '{{WRAPPER}} .pea-ic-label' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['before_image']['url']) || empty($settings['after_image']['url'])) {
            return;
        }

        $orientation = $settings['orientation'] ?? 'horizontal';

        $this->add_render_attribute('wrap', [
            'class'           => 'pea-image-comparison' . ( 'vertical' === $orientation ? ' is-vertical' : '' ),
            'data-orientation' => $orientation,
            'data-offset'     => $settings['default_offset']['size'] ?? 50,
        ]);
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <div class="pea-ic-before">
                <img src="<?php echo esc_url($settings['before_image']['url']); ?>" alt="<?php echo esc_attr($settings['before_label']); ?>" />
                <?php if ($settings['before_label']) : ?>
                    <span class="pea-ic-label"><?php echo esc_html($settings['before_label']); ?></span>
                <?php endif; ?>
            </div>
            <div class="pea-ic-after">
                <img src="<?php echo esc_url($settings['after_image']['url']); ?>" alt="<?php echo esc_attr($settings['after_label']); ?>" />
                <?php if ($settings['after_label']) : ?>
                    <span class="pea-ic-label"><?php echo esc_html($settings['after_label']); ?></span>
                <?php endif; ?>
            </div>
            <div class="pea-ic-handle"><span class="pea-ic-arrow"></span></div>
        </div>
        <?php
    }
}
