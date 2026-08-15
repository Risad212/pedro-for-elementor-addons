<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Utils;

if (! defined('ABSPATH')) {
    exit;
}

class Logo_Grid extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_logo_grid';
    }

    public function get_title(): string
    {
        return __('Logo Grid', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-logo pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['logo', 'grid', 'client', 'brand', 'partner'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_logos',
            [
                'label' => __('Logos', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'logo',
            [
                'label'   => __('Logo Image', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::MEDIA,
                'default' => ['url' => Utils::get_placeholder_image_src()],
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label'   => __('Name', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'   => __('Link', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => __('https://your-link.com', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'logo_list',
            [
                'label'   => __('Logos', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    ['name' => 'Logo 1'],
                    ['name' => 'Logo 2'],
                    ['name' => 'Logo 3'],
                    ['name' => 'Logo 4'],
                ],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Settings', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'     => __('Columns', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 4,
                'min'       => 1,
                'max'       => 10,
                'selectors' => [
                    '{{WRAPPER}} .pea-logo-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label'      => __('Gap', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 60]],
                'default'    => ['unit' => 'px', 'size' => 24],
                'selectors'  => [
                    '{{WRAPPER}} .pea-logo-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'grayscale',
            [
                'label'   => __('Grayscale', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'no',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'hover_effect',
            [
                'label'   => __('Hover Effect', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'      => __('None', 'pedro-for-elementor-addons'),
                    'opacity'   => __('Opacity', 'pedro-for-elementor-addons'),
                    'scale'     => __('Scale', 'pedro-for-elementor-addons'),
                    'grayscale' => __('Grayscale', 'pedro-for-elementor-addons'),
                ],
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

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'logo_border',
                'selector' => '{{WRAPPER}} .pea-logo-item',
            ]
        );

        $this->add_responsive_control(
            'logo_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-logo-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .pea-logo-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-logo-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'logo_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-logo-item' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $logos    = $settings['logo_list'] ?? [];

        if (empty($logos)) {
            return;
        }

        $this->add_render_attribute('grid', 'class', 'pea-logo-grid');
        $this->add_render_attribute('grid', 'class', 'pea-logo-effect-' . ($settings['hover_effect'] ?? 'none'));

        if ('yes' === $settings['grayscale']) {
            $this->add_render_attribute('grid', 'class', 'pea-logo-grayscale');
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('grid'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php foreach ($logos as $logo) : ?>
                <div class="pea-logo-item">
                    <?php if (! empty($logo['link']['url'])) : ?>
                        <a href="<?php echo esc_url($logo['link']['url']); ?>" <?php echo ! empty($logo['link']['is_external']) ? 'target="_blank"' : ''; ?> <?php echo ! empty($logo['link']['nofollow']) ? 'rel="nofollow"' : ''; ?>>
                    <?php endif; ?>
                    <img src="<?php echo esc_url($logo['logo']['url']); ?>" alt="<?php echo esc_attr($logo['name'] ?? ''); ?>">
                    <?php if (! empty($logo['link']['url'])) : ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
