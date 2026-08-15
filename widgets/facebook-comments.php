<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (! defined('ABSPATH')) {
    exit;
}

class Facebook_Comments extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_facebook_comments';
    }

    public function get_title(): string
    {
        return __('Facebook Comments', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-facebook-comments pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['facebook', 'comments', 'social', 'discussion'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Facebook Comments', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'url',
            [
                'label'       => __('URL', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::URL,
                'default'     => ['url' => ''],
                'dynamic'     => ['active' => true],
                'placeholder' => __('https://www.facebook.com/', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label'   => __('Sort by', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'social',
                'options' => [
                    'social'       => __('Social', 'pedro-for-elementor-addons'),
                    'reverse_time' => __('Newest', 'pedro-for-elementor-addons'),
                    'time'         => __('Oldest', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_control(
            'posts_count',
            [
                'label'      => __('Posts Count', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 5,
                'min'        => 1,
                'max'        => 100,
                'label_block'=> true,
            ]
        );

        $this->add_control(
            'lazy_load',
            [
                'label'   => __('Lazy Load', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
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

        $this->add_responsive_control(
            'width',
            [
                'label'      => __('Width', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 100, 'max' => 750]],
                'default'    => ['unit' => 'px', 'size' => 500],
                'selectors'  => [
                    '{{WRAPPER}} .pea-fb-wrap .fb-comments' => 'width: 100%; max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $url = ! empty($settings['url']['url']) ? $settings['url']['url'] : get_permalink();

        $this->add_render_attribute('wrap', 'class', 'pea-fb-wrap');
        $this->add_render_attribute('comments', 'class', 'fb-comments');
        $this->add_render_attribute('comments', 'data-href', esc_url($url));
        $this->add_render_attribute('comments', 'data-order-by', $settings['order_by'] ?? 'social');
        $this->add_render_attribute('comments', 'data-numposts', $settings['posts_count'] ?? 5);
        $this->add_render_attribute('comments', 'data-width', '100%');
        $this->add_render_attribute('comments', 'data-lazy', 'yes' === ($settings['lazy_load'] ?? 'yes') ? 'true' : 'false');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <div <?php echo $this->get_render_attribute_string('comments'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div>
        </div>
        <?php
    }
}