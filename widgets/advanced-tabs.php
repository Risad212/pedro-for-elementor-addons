<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Repeater;

if (! defined('ABSPATH')) {
    exit;
}

class Advanced_Tabs extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_advanced_tabs';
    }

    public function get_title(): string
    {
        return __('Advanced Tabs', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-tabs pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['tabs', 'tab', 'advanced', 'toggle'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_tabs',
            [
                'label' => __('Tabs', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label'   => __('Title', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Tab Title', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'tab_icon',
            [
                'label' => __('Icon', 'pedro-for-elementor-addons'),
                'type'  => Controls_Manager::ICONS,
            ]
        );

        $repeater->add_control(
            'tab_content',
            [
                'label'   => __('Content', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::WYSIWYG,
                'default' => __('Tab content goes here.', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'tabs_list',
            [
                'label'   => __('Tabs', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    ['tab_title' => __('Tab 1', 'pedro-for-elementor-addons')],
                    ['tab_title' => __('Tab 2', 'pedro-for-elementor-addons')],
                    ['tab_title' => __('Tab 3', 'pedro-for-elementor-addons')],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->add_control(
            'active_tab',
            [
                'label'   => __('Active Tab Index', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 0,
                'min'     => 0,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_tabs',
            [
                'label' => __('Tabs Bar', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tabs_alignment',
            [
                'label'     => __('Alignment', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'flex-start',
                'options'   => [
                    'flex-start' => ['title' => __('Left', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center'     => ['title' => __('Center', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'flex-end'   => ['title' => __('Right', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pea-tabs-nav' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_gap',
            [
                'label'      => __('Gap', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 30]],
                'default'    => ['unit' => 'px', 'size' => 4],
                'selectors'  => [
                    '{{WRAPPER}} .pea-tabs-nav' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_padding',
            [
                'label'      => __('Tab Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-tab-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'tabs_border',
                'selector' => '{{WRAPPER}} .pea-tab-btn',
            ]
        );

        $this->add_responsive_control(
            'tabs_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-tab-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tab_style_tabs');

        $this->start_controls_tab(
            'tab_normal',
            ['label' => __('Normal', 'pedro-for-elementor-addons')]
        );

        $this->add_control(
            'tab_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6b7280',
                'selectors' => [
                    '{{WRAPPER}} .pea-tab-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'tab_bg',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .pea-tab-btn',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_active',
            ['label' => __('Active', 'pedro-for-elementor-addons')]
        );

        $this->add_control(
            'tab_active_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-tab-btn.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'tab_active_bg',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .pea-tab-btn.active',
            ]
        );

        $this->add_control(
            'tab_active_border_color',
            [
                'label'     => __('Border Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-tab-btn.active' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tab_typography',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .pea-tab-btn',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __('Content', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'content_bg',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .pea-tab-content',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'content_border',
                'selector' => '{{WRAPPER}} .pea-tab-content',
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'separator'  => 'before',
                'selectors'  => [
                    '{{WRAPPER}} .pea-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label'      => __('Margin Top', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 60]],
                'default'    => ['unit' => 'px', 'size' => 16],
                'selectors'  => [
                    '{{WRAPPER}} .pea-tab-content' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $tabs     = $settings['tabs_list'] ?? [];
        $active   = (int) ($settings['active_tab'] ?? 0);

        if (empty($tabs)) {
            return;
        }
        ?>
        <div class="pea-advanced-tabs">
            <div class="pea-tabs-nav" role="tablist">
                <?php foreach ($tabs as $i => $tab) : ?>
                    <button class="pea-tab-btn <?php echo $i === $active ? 'active' : ''; ?>" data-tab="<?php echo esc_attr($i); ?>" role="tab">
                        <?php if (! empty($tab['tab_icon']['value'])) : ?>
                            <span class="pea-tab-icon"><?php Icons_Manager::render_icon($tab['tab_icon'], ['aria-hidden' => 'true']); ?></span>
                        <?php endif; ?>
                        <?php echo esc_html($tab['tab_title']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <?php foreach ($tabs as $i => $tab) : ?>
                <div class="pea-tab-content <?php echo $i === $active ? 'active' : ''; ?>" data-tab="<?php echo esc_attr($i); ?>" role="tabpanel">
                    <?php echo wp_kses_post($tab['tab_content']); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
