<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (! defined('ABSPATH')) {
    exit;
}

class Facebook_Embed extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_facebook_embed';
    }

    public function get_title(): string
    {
        return __('Facebook Embed', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-fb-embed pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['facebook', 'embed', 'post', 'social'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Facebook Embed', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'url',
            [
                'label'       => __('URL', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::URL,
                'default'     => ['url' => 'https://www.facebook.com/elementor/posts/'],
                'dynamic'     => ['active' => true],
                'placeholder' => __('https://www.facebook.com/PAGE/posts/ID', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'show_text',
            [
                'label'   => __('Show Text', 'pedro-for-elementor-addons'),
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
                    '{{WRAPPER}} .pea-fb-wrap .fb-post' => 'width: 100%; max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'min_height',
            [
                'label'      => __('Min Height', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 200, 'max' => 1000]],
                'default'    => ['unit' => 'px', 'size' => 400],
                'selectors'  => [
                    '{{WRAPPER}} .pea-fb-wrap .fb-post' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $url = ! empty($settings['url']['url']) ? $settings['url']['url'] : '';

        $this->add_render_attribute('wrap', 'class', 'pea-fb-wrap');
        $this->add_render_attribute('post', 'class', 'fb-post');
        $this->add_render_attribute('post', 'data-href', esc_url($url));
        $this->add_render_attribute('post', 'data-width', '500');
        $this->add_render_attribute('post', 'data-show-text', 'yes' === ($settings['show_text'] ?? 'yes') ? 'true' : 'false');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php if (empty($url)) : ?>
                <div class="pea-fb-error"><?php esc_html_e('Please enter a Facebook post URL.', 'pedro-for-elementor-addons'); ?></div>
            <?php else : ?>
                <div <?php echo $this->get_render_attribute_string('post'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div>
            <?php endif; ?>
        </div>
        <?php
    }
}