<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (! defined('ABSPATH')) {
    exit;
}

class Facebook_Button extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_facebook_button';
    }

    public function get_title(): string
    {
        return __('Facebook Button', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-facebook-like-box pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['facebook', 'like', 'button', 'share', 'social'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Facebook Button', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label'   => __('Type', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'like',
                'options' => [
                    'like'    => __('Like', 'pedro-for-elementor-addons'),
                    'recommend' => __('Recommend', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'   => __('Layout', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'standard',
                'options' => [
                    'standard'    => __('Standard', 'pedro-for-elementor-addons'),
                    'button'      => __('Button', 'pedro-for-elementor-addons'),
                    'button_count' => __('Button Count', 'pedro-for-elementor-addons'),
                    'box_count'   => __('Box Count', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_control(
            'url',
            [
                'label'       => __('URL', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::URL,
                'default'     => [
                    'url'         => '',
                    'is_external' => false,
                ],
                'dynamic'     => ['active' => true],
                'placeholder' => __('https://www.facebook.com/', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'show_share',
            [
                'label'   => __('Share Button', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_faces',
            [
                'label'     => __('Show Faces', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => '',
                'condition' => ['layout' => 'standard'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $url = ! empty($settings['url']['url']) ? $settings['url']['url'] : home_url();

        $this->add_render_attribute('wrap', 'class', 'pea-fb-wrap');
        $this->add_render_attribute('button', 'class', 'fb-like');
        $this->add_render_attribute('button', 'data-href', esc_url($url));
        $this->add_render_attribute('button', 'data-layout', $settings['layout'] ?? 'standard');
        $this->add_render_attribute('button', 'data-action', $settings['button_type'] ?? 'like');
        $this->add_render_attribute('button', 'data-show-faces', 'yes' === ($settings['show_faces'] ?? '') ? 'true' : 'false');
        $this->add_render_attribute('button', 'data-share', 'yes' === ($settings['show_share'] ?? 'yes') ? 'true' : 'false');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <div <?php echo $this->get_render_attribute_string('button'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div>
        </div>
        <?php
    }
}