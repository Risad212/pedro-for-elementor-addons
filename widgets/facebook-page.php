<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (! defined('ABSPATH')) {
    exit;
}

class Facebook_Page extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_facebook_page';
    }

    public function get_title(): string
    {
        return __('Facebook Page', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-facebook pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['facebook', 'page', 'fan', 'plugin', 'social'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Facebook Page', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'url',
            [
                'label'       => __('URL', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::URL,
                'default'     => ['url' => 'https://www.facebook.com/facebook/'],
                'dynamic'     => ['active' => true],
                'placeholder' => __('https://www.facebook.com/PAGE', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label'   => __('Tabs', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => ['timeline'],
                'options' => [
                    'timeline' => __('Timeline', 'pedro-for-elementor-addons'),
                    'events'   => __('Events', 'pedro-for-elementor-addons'),
                    'messages' => __('Messages', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_control(
            'small_header',
            [
                'label'   => __('Small Header', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'hide_cover',
            [
                'label'   => __('Hide Cover', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'show_facepile',
            [
                'label'   => __('Show Facepile', 'pedro-for-elementor-addons'),
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
                    '{{WRAPPER}} .pea-fb-wrap .fb-page' => 'width: 100%; max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $url = ! empty($settings['url']['url']) ? $settings['url']['url'] : '';

        $tabs = ! empty($settings['tabs']) && is_array($settings['tabs']) ? implode(',', $settings['tabs']) : 'timeline';

        $this->add_render_attribute('wrap', 'class', 'pea-fb-wrap');
        $this->add_render_attribute('page', 'class', 'fb-page');
        $this->add_render_attribute('page', 'data-href', esc_url($url));
        $this->add_render_attribute('page', 'data-tabs', esc_attr($tabs));
        $this->add_render_attribute('page', 'data-width', '500');
        $this->add_render_attribute('page', 'data-height', '');
        $this->add_render_attribute('page', 'data-small-header', 'yes' === ($settings['small_header'] ?? '') ? 'true' : 'false');
        $this->add_render_attribute('page', 'data-adapt-container-width', 'true');
        $this->add_render_attribute('page', 'data-hide-cover', 'yes' === ($settings['hide_cover'] ?? '') ? 'true' : 'false');
        $this->add_render_attribute('page', 'data-show-facepile', 'yes' === ($settings['show_facepile'] ?? 'yes') ? 'true' : 'false');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php if (empty($url)) : ?>
                <div class="pea-fb-error"><?php esc_html_e('Please enter a Facebook page URL.', 'pedro-for-elementor-addons'); ?></div>
            <?php else : ?>
                <div <?php echo $this->get_render_attribute_string('page'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div>
            <?php endif; ?>
        </div>
        <?php
    }
}