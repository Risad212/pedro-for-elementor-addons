<?php

namespace PedroEA\Widgets;

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

class Filterable_Gallery extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_filterable_gallery';
    }

    public function get_title(): string
    {
        return __('Filterable Gallery', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'pedro-elementor-icon eicon-gallery-grid';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['gallery', 'filterable', 'portfolio', 'filter', 'isotope'];
    }

    public function get_script_depends()
    {
        return ['isotope', 'imagesloaded'];
    }

    // Start content controls
    protected function register_controls()
    {
        // Filter Section
        $this->start_controls_section(
            'section_filters',
            [
                'label' => __('Filters', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_all_filter',
            [
                'label'        => __('Show "All" Filter', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __('Yes', 'pedro-for-elementor-addons'),
                'label_off'    => __('No', 'pedro-for-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'all_filter_label',
            [
                'label'       => __('All Filter Label', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('All', 'pedro-for-elementor-addons'),
                'label_block' => true,
                'condition'   => [
                    'show_all_filter' => 'yes',
                ],
            ]
        );

        $repeater_filters = new Repeater();

        $repeater_filters->add_control(
            'filter_label',
            [
                'label'       => __('Filter Label', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Category', 'pedro-for-elementor-addons'),
                'label_block' => true,
            ]
        );

        $repeater_filters->add_control(
            'filter_slug',
            [
                'label'       => __('Filter Slug', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('category', 'pedro-for-elementor-addons'),
                'label_block' => true,
                'description' => __('Use lowercase without spaces (e.g., print, strategy)', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'filter_list',
            [
                'label'       => __('Filters', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater_filters->get_controls(),
                'default'     => [
                    [
                        'filter_label' => __('Print', 'pedro-for-elementor-addons'),
                        'filter_slug'  => __('print', 'pedro-for-elementor-addons'),
                    ],
                    [
                        'filter_label' => __('Strategy', 'pedro-for-elementor-addons'),
                        'filter_slug'  => __('strategy', 'pedro-for-elementor-addons'),
                    ],
                ],
                'title_field' => '{{{ filter_label }}}',
            ]
        );

        $this->end_controls_section();

        // Gallery Items Section
        $this->start_controls_section(
            'section_gallery',
            [
                'label' => __('Gallery Items', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label'   => __('Choose Image', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label'       => __('Title', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Gallery Item', 'pedro-for-elementor-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'category',
            [
                'label'       => __('Category (Slug)', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('print', 'pedro-for-elementor-addons'),
                'label_block' => true,
                'description' => __('Enter category slug (e.g., print, strategy). Use same slug as in Filters section.', 'pedro-for-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'       => __('Link', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'pedro-for-elementor-addons'),
                'default'     => [
                    'url'         => '#',
                    'is_external' => false,
                    'nofollow'    => false,
                ],
            ]
        );

        $this->add_control(
            'gallery_items',
            [
                'label'       => __('Gallery Items', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'title'    => __('Vibrant Artwork', 'pedro-for-elementor-addons'),
                        'category' => __('print', 'pedro-for-elementor-addons'),
                    ],
                    [
                        'title'    => __('Living Room Floral Painting', 'pedro-for-elementor-addons'),
                        'category' => __('print', 'pedro-for-elementor-addons'),
                    ],
                    [
                        'title'    => __('Cute Bunny Oil Painting', 'pedro-for-elementor-addons'),
                        'category' => __('strategy', 'pedro-for-elementor-addons'),
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'     => __('Columns', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '3',
                'options'   => [
                    '1'     => __('1 Column', 'pedro-for-elementor-addons'),
                    '2'     => __('2 Columns', 'pedro-for-elementor-addons'),
                    '3'     => __('3 Columns', 'pedro-for-elementor-addons'),
                    '4'     => __('4 Columns', 'pedro-for-elementor-addons'),
                    '5'     => __('5 Columns', 'pedro-for-elementor-addons'),
                    '6'     => __('6 Columns', 'pedro-for-elementor-addons'),
                ],
                'selectors' => [
                 '{{WRAPPER}} .pea-gallery' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_html_tag',
            [
                'label'   => __('Title HTML Tag', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'  => 'H1',
                    'h2'  => 'H2',
                    'h3'  => 'H3',
                    'h4'  => 'H4',
                    'h5'  => 'H5',
                    'h6'  => 'H6',
                    'div' => 'div',
                    'p'   => 'p',
                ],
                'default' => 'h4',
            ]
        );

        $this->end_controls_section();

        // ==================== STYLE TAB ====================

        $this->start_controls_section(
            'section_filter_style',
            [
                'label' => __('Filters', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'filter_alignment',
            [
                'label'          => __('Alignment', 'pedro-for-elementor-addons'),
                'type'           => Controls_Manager::CHOOSE,
                'options'        => [
                    'flex-start' => [
                        'title'  => __('Left', 'pedro-for-elementor-addons'),
                        'icon'   => 'eicon-text-align-left',
                    ],
                    'center'     => [
                        'title'  => __('Center', 'pedro-for-elementor-addons'),
                        'icon'   => 'eicon-text-align-center',
                    ],
                    'flex-end'   => [
                        'title'  => __('Right', 'pedro-for-elementor-addons'),
                        'icon'   => 'eicon-text-align-right',
                    ],
                ],
                'default'        => 'center',
                'selectors'      => [
                    '{{WRAPPER}} .pea-filters' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_gap',
            [
                'label'       => __('Gap Between Items', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', 'em', 'rem'],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default'     => [
                    'size'    => 10,
                    'unit'    => 'px',
                ],
                'selectors'   => [
                    '{{WRAPPER}} .pea-filters' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_margin_bottom',
            [
                'label'       => __('Margin Bottom', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', 'em', 'rem'],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'     => [
                    'size'    => 40,
                    'unit'    => 'px',
                ],
                'selectors'   => [
                    '{{WRAPPER}} .pea-filters' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'filter_typography',
                'selector' => '{{WRAPPER}} .pea-filter',
            ]
        );

        $this->start_controls_tabs('filter_tabs');

        // Normal State
        $this->start_controls_tab(
            'filter_normal_tab',
            [
                'label' => __('Normal', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'filter_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-filter' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_bg_color',
            [
                'label'     => __('Background Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-filter' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'filter_border',
                'selector' => '{{WRAPPER}} .pea-filter',
            ]
        );

        $this->end_controls_tab();

        // Hover State
        $this->start_controls_tab(
            'filter_hover_tab',
            [
                'label' => __('Hover', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'filter_color_hover',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-filter:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_bg_color_hover',
            [
                'label'     => __('Background Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-filter:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->add_control(
            'filter_color_active',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-filter.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'filter_bg_color_active',
            [
                'label'     => __('Background Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-filter.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'filter_border_active',
                'selector' => '{{WRAPPER}} .pea-filter.active',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'filter_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'separator'  => 'before',
                'selectors'  => [
                    '{{WRAPPER}} .pea-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Gallery Item Style
        $this->start_controls_section(
            'section_gallery_item_style',
            [
                'label' => __('Gallery Items', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'gallery_gap',
            [
                'label'       => __('Gap Between Items', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', 'em', 'rem'],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'     => [
                    'size'    => 30,
                    'unit'    => 'px',
                ],
                'selectors'   => [
                    '{{WRAPPER}} .pea-gallery' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'gallery_item_bg',
            [
                'label'     => __('Background Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-gallery-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'gallery_item_border',
                'selector' => '{{WRAPPER}} .pea-gallery-item',
            ]
        );

        $this->add_responsive_control(
            'gallery_item_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-gallery-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'gallery_item_box_shadow',
                'selector' => '{{WRAPPER}} .pea-gallery-item',
            ]
        );

        $this->add_responsive_control(
            'gallery_item_padding',
            [
                'label'        => __('Padding', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%', 'em', 'rem'],
                'selectors'    => [
                    '{{WRAPPER}} .pea-gallery-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'gallery_item_hover_heading',
            [
                'label'     => __('Hover Effects', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'gallery_item_bg_hover',
            [
                'label'     => __('Background Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-gallery-item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'gallery_item_box_shadow_hover',
                'selector' => '{{WRAPPER}} .pea-gallery-item:hover',
            ]
        );

        $this->add_control(
            'gallery_item_hover_transition',
            [
                'label'      => __('Transition Duration (ms)', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 3000,
                    ],
                ],
                'default'    => [
                    'size' => 300,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pea-gallery-item' => 'transition: all {{SIZE}}ms;',
                ],
            ]
        );

        $this->end_controls_section();

        // Image Style
        $this->start_controls_section(
            'section_image_style',
            [
                'label' => __('Image', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label'       => __('Width', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['%', 'px', 'vw'],
                'range'       => [
                    '%'       => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px'      => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw'      => [
                        'min' => 1,
                        'max' => 100,
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .pea-gallery-item img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-gallery-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Title Style
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __('Title', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .pea-portfolio-name',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-portfolio-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'     => __('Hover Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-gallery-item:hover .pea-portfolio-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'title_text_shadow',
                'selector' => '{{WRAPPER}} .pea-portfolio-name',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => __('Margin', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-portfolio-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render(): void
    {
        $settings      = $this->get_settings_for_display();
        $gallery_items = $settings['gallery_items'];
        $filters       = $settings['filter_list'];

        if (empty($gallery_items)) {
            return;
        }

        $title_tag   = Utils::validate_html_tag($settings['title_html_tag']);

?>

        <div class="pea-portfolio-section">

            <div class="pea-gallery-wrap">

                <?php if (!empty($filters) || $settings['show_all_filter'] === 'yes') : ?>
                    <ul class="pea-filters">
                        <?php if ($settings['show_all_filter'] === 'yes') : ?>
                            <li>
                                <span class="pea-filter active" data-filter="*">
                                    <?php echo esc_html($settings['all_filter_label']); ?>
                                </span>
                            </li>
                        <?php endif; ?>

                        <?php foreach ($filters as $filter) : ?>
                            <li>
                                <span class="pea-filter" data-filter=".<?php echo esc_attr($filter['filter_slug']); ?>">
                                    <?php echo esc_html($filter['filter_label']); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <div class="pea-gallery">
                    <?php foreach ($gallery_items as $item) :
                        $target   = $item['link']['is_external'] ? ' target="_blank"' : '';
                        $nofollow = $item['link']['nofollow'] ? ' rel="nofollow"' : '';
                        $link_url = !empty($item['link']['url']) ? $item['link']['url'] : '#';
                    ?>
                        <a class="pea-gallery-item <?php echo esc_attr($item['category']); ?>" 
                            href="<?php echo esc_url($link_url); ?>" 
                            data-cat="<?php echo esc_attr($item['category']); ?>"
                            <?php echo $item['link']['is_external'] ? 'target="_blank"' : ''; ?>
                            <?php echo $item['link']['nofollow'] ? 'rel="nofollow"' : ''; ?>>
                                
                                <?php if (!empty($item['image']['url'])) : ?>
                                    <img src="<?php echo esc_url($item['image']['url']); ?>" 
                                        alt="<?php echo esc_attr($item['title']); ?>" />
                                <?php endif; ?>

                                <?php if (!empty($item['title'])) : ?>
                                    <<?php echo esc_html($title_tag); ?> class="pea-portfolio-name">
                                        <?php echo esc_html($item['title']); ?>
                                    </<?php echo esc_html($title_tag); ?>>
                                <?php endif; ?>
                            </a>
                    <?php endforeach; ?>
                </div>

            </div>

        </div>

<?php
    }
}