<?php

namespace PedroEA\Widgets;

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

class Accordion extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_accordion';
    }

    public function get_title(): string
    {
        return __('Accordion', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'pedro-elementor-icon eicon-accordion';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['accordion'];
    }

    // Start content controls
    protected function register_controls()
    {

        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Layout', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        // Title
        $repeater->add_control(
            'title',
            [
                'label'       => __('Title', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Title', 'pedro-for-elementor-addons'),
                'label_block' => true,
            ]
        );

        // Content
        $repeater->add_control(
            'content',
            [
                'label'      => __('Content', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::TEXTAREA,
                'default'    => __('Accordion content goes here...', 'pedro-for-elementor-addons'),
                'show_label' => true,
            ]
        );

        // Add repeater list
        $this->add_control(
            'accordion_list',
            [
                'label'           => __('Accordion Items', 'pedro-for-elementor-addons'),
                'type'            => Controls_Manager::REPEATER,
                'fields'          => $repeater->get_controls(),
                'default'         => [
                    [
                        'title'   => __('Accordion 1', 'pedro-for-elementor-addons'),
                        'content' => __('Accordion content 1', 'pedro-for-elementor-addons'),
                    ],
                    [
                        'title'   => __('Accordion 2', 'pedro-for-elementor-addons'),
                        'content' => __('Accordion content 2', 'pedro-for-elementor-addons'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        // select icon
        $this->add_control(
            'accordtion_icon',
            [
                'label'            => __('Icon', 'pedro-for-elementor-addons'),
                'type'             => Controls_Manager::ICONS,
                'separator'        => 'before',
                'fa4compatibility' => 'icon',
                'default'          => [
                    'value'        => 'fas fa-plus',
                    'library'      => 'fa-solid',
                ],

                'skin'             => 'inline',
                'label_block'      => false,
            ]
        );

        // title tag
        $this->add_control(
            'title_html_tag',
            [
                'label'     => __('Title HTML Tag', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'h1'    => 'H1',
                    'h2'    => 'H2',
                    'h3'    => 'H3',
                    'h4'    => 'H4',
                    'h5'    => 'H5',
                    'h6'    => 'H6',
                    'div'   => 'div',
                ],
                'default'   => 'div',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        // accordtion style
        $this->start_controls_section(
            'section_accordion',
            [
                'label' => __('Accordion', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Space Between Items
        $this->add_responsive_control(
            'accordion_item_gap',
            [
                'label'       => __('Space Between Items', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', 'em', 'rem', '%'],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em'      => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    'rem'     => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    '%'       => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .pea-accordion-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Distance from Content Container
        $this->add_responsive_control(
            'accordion_content_distance',
            [
                'label'       => __('Distance from Content', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', 'em', 'rem', '%'],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em'      => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    'rem'     => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    '%'       => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .pea-accordion-content-inner' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('style_tabs');

        $this->start_controls_tab(
            'accordtion_bg_normal_tab',
            [
                'label' => __('Normal', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'accordtion_bg_normal',
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .pea-accordion-item',
            ]
        );

        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'accordtion_border_normal',
                'selector' => '{{WRAPPER}} .pea-accordion-item',
            ]
        );


        $this->end_controls_tab(); // normal

        $this->start_controls_tab(
            'accordtion_bg_hover_tab',
            [
                'label' => __('Hover', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'accordtion_bg_hover',
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .pea-accordion-item:hover',
            ]
        );

        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'accordtion_border_hover',
                'selector' => '{{WRAPPER}} .pea-accordion-item:hover',
            ]
        );

        $this->end_controls_tab(); // hover

        $this->start_controls_tab(
            'accordtion_bg_active_tab',
            [
                'label' => __('Active', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'accordtion_bg_active',
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .pea-accordion-item.active',
            ]
        );

        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'accordtion_border_active',
                'selector'  => '{{WRAPPER}} .pea-accordion-item.active',
            ]
        );

        $this->end_controls_tab(); // Active

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'accordion_item_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'vw'],
                'separator'  => 'before',
                'selectors'  => [
                    '{{WRAPPER}} .pea-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Padding
        $this->add_responsive_control(
            'accordion_item_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'vw'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-accordion-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // title section
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __('Title', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .pea-accordion-title',
            ]
        );

        $this->start_controls_tabs('tabs_title_state');

        // Normal
        $this->start_controls_tab(
            'tab_title_normal',
            ['label'       => __('Normal', 'pedro-for-elementor-addons')]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Text Shadow
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'title_text_shadow',
                'selector' => '{{WRAPPER}} .pea-accordion-title',
            ]
        );

        $this->end_controls_tab(); // End Normal

        // hover
        $this->start_controls_tab(
            'tab_title_hover',
            ['label'       => __('hover', 'pedro-for-elementor-addons')]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-accordion-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Text Shadow
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'title_shadow_hover',
                'selector' => '{{WRAPPER}} .pea-accordion-title:hover',
            ]
        );

        $this->end_controls_tab(); // End Hover


        // active
        $this->start_controls_tab(
            'tab_title_active',
            ['label'       => __('Active', 'pedro-for-elementor-addons')]
        );

        $this->add_control(
            'title_color_active',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-accordion-item.active .pea-accordion-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Text Shadow
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'title_shadow_active',
                'selector' => '{{WRAPPER}} .pea-accordion-item.active .pea-accordion-title',
            ]
        );

        $this->end_controls_tab(); // End Active

        $this->end_controls_tabs();

        // icon size
        $this->add_responsive_control(
            'icon_size',
            [
                'label'       => __('Icon Size', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', 'em', 'rem', 'custom', '%', 'vw'],
                'separator'   => 'before',
                'range'       => [
                    'px'      => [
                        'max' => 100,
                    ],
                    'em'      => [
                        'max' => 1,
                    ],
                    'rem'     => [
                        'max' => 1,
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .pea-accordion-arrow-icon svg' => 'width: {{SIZE}}{{UNIT}}; 
                                                                    height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        // icon spacing
        $this->add_responsive_control(
            'icon_padding',
            [
                'label'       => __('Icon Padding', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', 'em', 'rem', 'custom'],
                'range'       => [
                    'px'      => [
                        'max' => 100,
                    ],
                    'em'      => [
                        'max' => 1,
                    ],
                    'rem'     => [
                        'max' => 1,
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .pea-accordion-arrow' => 'padding: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // icon style tabs
        $this->start_controls_tabs('icon_style_tabs');

        $this->start_controls_tab(
            'icon_color_tab',
            [
                'label' => __('Normal', 'pedro-for-elementor-addons'),
            ]
        );


        $this->add_control(
            'icon_color_normal',
            [
                'label'     => __('Icon Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-accordion-arrow-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_color_bg_normal',
            [
                'label'     => __('Background Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-accordion-arrow' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab(); // icon normal

        $this->start_controls_tab(
            'icon_hover_color_tab',
            [
                'label'    => __('Hover', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label'     => __('Icon Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-accordion-arrow-icon:hover svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_color_bg_hover',
            [
                'label'     => __('Background Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-accordion-arrow:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab(); // icon hover

        $this->start_controls_tab(
            'icon_active_color_tab',
            [
                'label' => __('Active', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'icon_color_active',
            [
                'label'     => __('Icon Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-accordion-item.active .pea-accordion-arrow-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_color_bg_active',
            [
                'label'     => __('Background Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-accordion-item.active .pea-accordion-arrow' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab(); // icon Actives
        $this->end_controls_tabs();



        $this->end_controls_section();


        // style for content
        $this->start_controls_section(
            'section_content_style',
            [
                'label' => __('Content', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        // Background
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'content_background',
                'label'    => __('Background', 'pedro-for-elementor-addons'),
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .pea-accordion-content',
            ]
        );

        // typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .pea-accordion-paragraph',
            ]
        );

        // border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'content_border',
                'label'       => __('Border', 'pedro-for-elementor-addons'),
                'placeholder' => '1px',
                'default'     => 'solid',
                'selector'    => '{{WRAPPER}} .pea-accordion-content-inner',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'content_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Padding
        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-accordion-content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render(): void
    {

        $settings        = $this->get_settings_for_display();
        $accordion_items = $settings['accordion_list'];

        $icon = $settings['accordtion_icon'];

        if (empty($accordion_items)) {
            return;
        }

        $title_tag = Utils::validate_html_tag($settings['title_html_tag']);

?>

        <div class="pea-accordion-container">

            <?php foreach ($accordion_items as $item) : ?>
                <div class="pea-accordion-item">

                    <div class="pea-accordion-trigger">

                        <div class="pea-accordion-title">
                            <?php echo esc_html("<{$title_tag}>") . esc_html($item['title']) . esc_html("</{$title_tag}>"); ?>
                        </div>

                        <div class="pea-accordion-arrow">
                            <div class="pea-accordion-arrow-icon">
                                <?php
                                Icons_Manager::render_icon(
                                    $icon,
                                    ['aria-hidden' => 'true']
                                );
                                ?>
                            </div>
                        </div>

                    </div>

                    <div class="pea-accordion-content">
                        <div class="pea-accordion-content-inner">
                            <p class="pea-accordion-paragraph">
                                <?php echo wp_kses_post($item['content']); ?>
                            </p>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>

<?php
    }
}
