<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;

if (! defined('ABSPATH')) {
    exit;
}

class Dual_Heading extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_dual_heading';
    }

    public function get_title(): string
    {
        return __('Dual Heading', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-t-letter pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['dual', 'heading', 'split', 'title'];
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
            'first_text',
            [
                'label'   => __('First Text', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __('First', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'second_text',
            [
                'label'   => __('Second Text', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __('Heading', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'html_tag',
            [
                'label'   => __('HTML Tag', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3',
                    'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6',
                    'div' => 'div', 'span' => 'span', 'p' => 'p',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label'   => __('Link', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::URL,
                'separator' => 'before',
                'dynamic' => ['active' => true],
                'placeholder' => __('https://your-link.com', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'     => __('Alignment', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'default'   => 'center',
                'options'   => [
                    'left'   => ['title' => __('Left', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => __('Center', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'right'  => ['title' => __('Right', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pea-dual-heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_first',
            [
                'label' => __('First Text', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'first_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7c3aed',
                'selectors' => [
                    '{{WRAPPER}} .pea-dual-first' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'first_typography',
                'selector' => '{{WRAPPER}} .pea-dual-first',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'first_bg',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .pea-dual-first',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_second',
            [
                'label' => __('Second Text', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'second_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-dual-second' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'second_typography',
                'selector' => '{{WRAPPER}} .pea-dual-second',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'second_bg',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .pea-dual-second',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $tag      = Utils::validate_html_tag( $settings['html_tag'] ?? 'h2' );
        $has_link = ! empty($settings['link']['url']);

        if ($has_link) {
            $this->add_link_attributes('link', $settings['link']);
        }
        ?>
        <<?php echo esc_attr($tag); ?> class="pea-dual-heading">
            <?php if ($has_link) : ?><a <?php echo $this->get_render_attribute_string('link'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php endif; ?>
            <span class="pea-dual-first"><?php echo wp_kses_post($settings['first_text']); ?></span>
            <span class="pea-dual-second"><?php echo wp_kses_post($settings['second_text']); ?></span>
            <?php if ($has_link) : ?></a><?php endif; ?>
        </<?php echo esc_attr($tag); ?>>
        <?php
    }
}
