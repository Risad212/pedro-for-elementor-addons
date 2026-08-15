<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if (! defined('ABSPATH')) {
    exit;
}

class Search_Bar extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_search_bar';
    }

    public function get_title(): string
    {
        return __('Search Bar', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-search pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['search', 'bar', 'form', 'ajax'];
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
            'placeholder',
            [
                'label'   => __('Placeholder', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Search...', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'search_post_types',
            [
                'label'   => __('Search In', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT2,
                'options' => $this->get_post_types(),
                'default' => ['post', 'page'],
                'multiple' => true,
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label'   => __('Show Search Icon', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label'   => __('Icon Position', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left'  => __('Left', 'pedro-for-elementor-addons'),
                    'right' => __('Right', 'pedro-for-elementor-addons'),
                ],
                'condition' => ['show_icon' => 'yes'],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'   => __('Button Text', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => '',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_input',
            [
                'label' => __('Input', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-search-input' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f9fafb',
                'selectors' => [
                    '{{WRAPPER}} .pea-search-form' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_placeholder_color',
            [
                'label'     => __('Placeholder Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#9ca3af',
                'selectors' => [
                    '{{WRAPPER}} .pea-search-input::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'input_typography',
                'selector' => '{{WRAPPER}} .pea-search-input',
            ]
        );

        $this->add_responsive_control(
            'input_height',
            [
                'label'      => __('Height', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 30, 'max' => 80]],
                'default'    => ['unit' => 'px', 'size' => 50],
                'selectors'  => [
                    '{{WRAPPER}} .pea-search-form' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'input_border',
                'selector' => '{{WRAPPER}} .pea-search-form',
            ]
        );

        $this->add_responsive_control(
            'input_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-search-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label'     => __('Icon', 'pedro-for-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['show_icon' => 'yes'],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#9ca3af',
                'selectors' => [
                    '{{WRAPPER}} .pea-search-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'      => __('Size', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 14, 'max' => 40]],
                'default'    => ['unit' => 'px', 'size' => 18],
                'selectors'  => [
                    '{{WRAPPER}} .pea-search-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pea-search-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $post_types = ! empty($settings['search_post_types']) ? implode(',', $settings['search_post_types']) : 'post,page';
        ?>
        <div class="pea-search-bar">
            <form class="pea-search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="hidden" name="post_type" value="<?php echo esc_attr($post_types); ?>">
                <?php if ('left' === $settings['icon_position'] && 'yes' === $settings['show_icon'] && ! $settings['button_text']) : ?>
                    <button type="submit" class="pea-search-icon" aria-label="<?php esc_attr_e('Search', 'pedro-for-elementor-addons'); ?>">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    </button>
                <?php elseif ('left' === $settings['icon_position'] && 'yes' === $settings['show_icon']) : ?>
                    <span class="pea-search-icon">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    </span>
                <?php endif; ?>
                <input class="pea-search-input" type="search" placeholder="<?php echo esc_attr($settings['placeholder']); ?>" name="s">
                <?php if ('right' === $settings['icon_position'] && 'yes' === $settings['show_icon'] && ! $settings['button_text']) : ?>
                    <button type="submit" class="pea-search-icon" aria-label="<?php esc_attr_e('Search', 'pedro-for-elementor-addons'); ?>">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    </button>
                <?php endif; ?>
                <?php if ($settings['button_text']) : ?>
                    <button class="pea-search-btn" type="submit"><?php echo esc_html($settings['button_text']); ?></button>
                <?php endif; ?>
            </form>
        </div>
        <?php
    }

    private function get_post_types(): array
    {
        $types = [];
        foreach (get_post_types(['public' => true], 'objects') as $pt) {
            $types[$pt->name] = $pt->label;
        }
        return $types;
    }
}
