<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Utils;

if (! defined('ABSPATH')) {
    exit;
}

class Image_Carousel extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_image_carousel';
    }

    public function get_title(): string
    {
        return __('Image Carousel', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-slider-push pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['image', 'carousel', 'slider', 'gallery', 'swiper'];
    }

    public function get_script_depends()
    {
        return ['pedroea-swiper-js'];
    }

    public function get_style_depends()
    {
        return ['pedroea-swiper-css'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_images',
            [
                'label' => __('Images', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label'   => __('Image', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::MEDIA,
                'default' => ['url' => Utils::get_placeholder_image_src()],
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label'   => __('Title', 'pedro-for-elementor-addons'),
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
            'image_list',
            [
                'label'   => __('Image List', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                    ['image' => ['url' => Utils::get_placeholder_image_src()]],
                ],
                'title_field' => '{{{ title }}}',
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
            'slides_per_view',
            [
                'label'   => __('Slides Per View', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 3,
                'min'     => 1,
                'max'     => 10,
            ]
        );

        $this->add_control(
            'space_between',
            [
                'label'   => __('Space Between (px)', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 16,
                'min'     => 0,
                'max'     => 100,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'   => __('Autoplay', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'   => __('Autoplay Speed (ms)', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 3000,
                'min'     => 500,
                'max'     => 15000,
                'condition' => ['autoplay' => 'yes'],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'   => __('Pause on Hover', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => ['autoplay' => 'yes'],
            ]
        );

        $this->add_control(
            'loop',
            [
                'label'   => __('Loop', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label'   => __('Arrows', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'   => __('Pagination', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'pagination_type',
            [
                'label'   => __('Pagination Type', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'bullets',
                'options' => [
                    'bullets'  => __('Bullets', 'pedro-for-elementor-addons'),
                    'fraction' => __('Fraction', 'pedro-for-elementor-addons'),
                ],
                'condition' => ['show_pagination' => 'yes'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __('Image', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'      => __('Height', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range'      => [
                    'px' => ['min' => 50, 'max' => 600],
                    'vh' => ['min' => 10, 'max' => 100],
                ],
                'default'    => ['unit' => 'px', 'size' => 250],
                'selectors'  => [
                    '{{WRAPPER}} .pea-carousel-image img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_border',
                'selector' => '{{WRAPPER}} .pea-carousel-image img',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-carousel-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .pea-carousel-image img',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_nav',
            [
                'label' => __('Navigation', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'arrow_color',
            [
                'label'     => __('Arrow Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-carousel-prev, {{WRAPPER}} .pea-carousel-next' => 'color: {{VALUE}};',
                ],
                'condition' => ['show_arrows' => 'yes'],
            ]
        );

        $this->add_control(
            'arrow_bg',
            [
                'label'     => __('Arrow Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-carousel-prev, {{WRAPPER}} .pea-carousel-next' => 'background: {{VALUE}};',
                ],
                'condition' => ['show_arrows' => 'yes'],
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label'     => __('Pagination Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#d1d5db',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}};',
                ],
                'condition' => ['show_pagination' => 'yes', 'pagination_type' => 'bullets'],
            ]
        );

        $this->add_control(
            'pagination_active_color',
            [
                'label'     => __('Pagination Active Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7c3aed',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                ],
                'condition' => ['show_pagination' => 'yes', 'pagination_type' => 'bullets'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['image_list'])) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'pea-image-carousel');
        $this->add_render_attribute('carousel', 'class', 'swiper pea-carousel');
        $this->add_render_attribute('carousel', 'class', 'pea-carousel-' . $this->get_id());
        $this->add_render_attribute('container', 'class', 'swiper-wrapper');

        $slides_per_view = $settings['slides_per_view'] ?? 3;

        if (is_array($slides_per_view)) {
            $slides_desktop = (int) ($slides_per_view['desktop'] ?? 3);
            $slides_tablet  = (int) ($slides_per_view['tablet'] ?? $slides_desktop);
            $slides_mobile  = (int) ($slides_per_view['mobile'] ?? $slides_tablet);
        } else {
            $slides_desktop = (int) $slides_per_view;
            $slides_tablet  = $slides_desktop;
            $slides_mobile  = $slides_desktop;
        }

        $this->add_render_attribute('wrapper', 'data-slides-per-view', $slides_desktop);
        $this->add_render_attribute('wrapper', 'data-slides-per-view-tablet', $slides_tablet);
        $this->add_render_attribute('wrapper', 'data-slides-per-view-mobile', $slides_mobile);
        $this->add_render_attribute('wrapper', 'data-space-between', $settings['space_between'] ?? 16);
        $this->add_render_attribute('wrapper', 'data-autoplay', $settings['autoplay'] ?? 'yes');
        $this->add_render_attribute('wrapper', 'data-autoplay-speed', $settings['autoplay_speed'] ?? 3000);
        $this->add_render_attribute('wrapper', 'data-pause-hover', $settings['pause_on_hover'] ?? 'yes');
        $this->add_render_attribute('wrapper', 'data-loop', $settings['loop'] ?? 'yes');
        $this->add_render_attribute('wrapper', 'data-arrows', $settings['show_arrows'] ?? 'yes');
        $this->add_render_attribute('wrapper', 'data-pagination', $settings['show_pagination'] ?? 'yes');
        $this->add_render_attribute('wrapper', 'data-pagination-type', $settings['pagination_type'] ?? 'bullets');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <div <?php echo $this->get_render_attribute_string('carousel'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                <div <?php echo $this->get_render_attribute_string('container'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                    <?php foreach ($settings['image_list'] as $item) : ?>
                        <div class="swiper-slide">
                            <div class="pea-carousel-slide">
                                <div class="pea-carousel-image">
                                    <?php if (! empty($item['link']['url'])) : ?>
                                        <a href="<?php echo esc_url($item['link']['url']); ?>" <?php echo ! empty($item['link']['is_external']) ? 'target="_blank"' : ''; ?> <?php echo ! empty($item['link']['nofollow']) ? 'rel="nofollow"' : ''; ?>>
                                    <?php endif; ?>
                                    <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['title'] ?? ''); ?>">
                                    <?php if (! empty($item['link']['url'])) : ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <?php if ($item['title']) : ?>
                                    <div class="pea-carousel-title"><?php echo wp_kses_post($item['title']); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if ('yes' === $settings['show_arrows']) : ?>
                <div class="pea-carousel-prev"><svg viewBox="0 0 24 24" width="20" height="20"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" fill="currentColor"/></svg></div>
                <div class="pea-carousel-next"><svg viewBox="0 0 24 24" width="20" height="20"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" fill="currentColor"/></svg></div>
            <?php endif; ?>
            <?php if ('yes' === $settings['show_pagination']) : ?>
                <div class="swiper-pagination"></div>
            <?php endif; ?>
        </div>
        <?php
    }
}
