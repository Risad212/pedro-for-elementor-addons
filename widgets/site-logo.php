<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Plugin;
use Elementor\Utils;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

class Site_Logo extends Widget_Base
{


    public function get_name()
    {
        return 'pedroea_site_logo';
    }


    public function get_title(): string
    {
        return __('Site Logo', 'pedro-for-elementor-addons');
    }


    public function get_icon(): string
    {
        return 'eicon-site-logo pedro-elementor-icon';
    }


    public function get_categories(): array
    {
        return ['pedroea'];
    }


    public function get_keywords(): array
    {
        return ['Logo', 'site Logo'];
    }


    // Start content controls
    protected function register_controls()
    {
        $this->start_controls_section(
            'section_logo_content',
            [
                'label' => __('Logo', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'logo_type',
            [
                'label'   => __('Logo Type', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'site_logo',
                'options' => [
                    'site_logo'   => __('Site Logo', 'pedro-for-elementor-addons'),
                    'custom_logo' => __('Custom Logo', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_control(
            'custom_logo',
            [
                'label'         => __('Custom Logo', 'pedro-for-elementor-addons'),
                'type'          => Controls_Manager::MEDIA,
                'default'       => [
                    'url'       => Utils::get_placeholder_image_src(),
                ],
                'condition'     => [
                    'logo_type' => 'custom_logo',
                ],
            ]
        );

        $this->add_control(
            'logo_link_to',
            [
                'label'      => __('Link', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'home',
                'options'    => [
                    'home'   => __('Home URL', 'pedro-for-elementor-addons'),
                    'custom' => __('Custom URL', 'pedro-for-elementor-addons'),
                    'none'   => __('None', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_control(
            'logo_custom_link',
            [
                'label'            => __('Custom URL', 'pedro-for-elementor-addons'),
                'type'             => Controls_Manager::URL,
                'placeholder'      => __('https://your-link.com', 'pedro-for-elementor-addons'),
                'condition'        => [
                    'logo_link_to' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'open_in_new_tab',
            [
                'label'             => __('Open in New Tab', 'pedro-for-elementor-addons'),
                'type'              => Controls_Manager::SWITCHER,
                'label_on'          => __('Yes', 'pedro-for-elementor-addons'),
                'label_off'         => __('No', 'pedro-for-elementor-addons'),
                'return_value'      => 'yes',
                'default'           => '',
                'condition'         => [
                    'logo_link_to!' => 'none',
                ],
            ]
        );

        $this->end_controls_section();


        // =====================
        // SECTION: Logo Style
        // =====================
        $this->start_controls_section(
            'section_logo_style',
            [
                'label' => __('Logo', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'logo_width',
            [
                'label'       => __('Width', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%', 'vw'],
                'range'       => [
                    'px'      => [
                        'min' => 10,
                        'max' => 500,
                    ],
                    '%'       => [
                        'min' => 5,
                        'max' => 100,
                    ],
                ],
                'selectors'   => [
                    '{{WRAPPER}} .pedroea-site-logo img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_max_width',
            [
                'label'       => __('Max Width', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', '%'],
                'range'       => [
                    'px'      => [
                        'min' => 10,
                        'max' => 800,
                    ],
                    '%'       => [
                        'min' => 5,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-site-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_align',
            [
                'label'         => __('Alignment', 'pedro-for-elementor-addons'),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title' => __('Left', 'pedro-for-elementor-addons'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'    => [
                        'title' => __('Center', 'pedro-for-elementor-addons'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'     => [
                        'title' => __('Right', 'pedro-for-elementor-addons'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'       => 'left',
                'selectors'     => [
                    '{{WRAPPER}} .pedroea-site-logo' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'logo_border',
                'selector' => '{{WRAPPER}} .pedroea-site-logo img',
            ]
        );

        $this->add_responsive_control(
            'logo_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-site-logo img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'logo_box_shadow',
                'selector' => '{{WRAPPER}} .pedroea-site-logo img',
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'logo_css_filter',
                'selector' => '{{WRAPPER}} .pedroea-site-logo img',
            ]
        );

        $this->add_control(
            'logo_opacity',
            [
                'label'        => __('Opacity', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 1,
                        'step' => 0.1,
                    ],
                ],
                'selectors'    => [
                    '{{WRAPPER}} .pedroea-site-logo img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'logo_hover_heading',
            [
                'label'     => __('Hover', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'logo_hover_css_filter',
                'selector' => '{{WRAPPER}} .pedroea-site-logo a:hover img',
            ]
        );

        $this->add_control(
            'logo_hover_opacity',
            [
                'label'        => __('Opacity', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 1,
                        'step' => 0.1,
                    ],
                ],
                'selectors'    => [
                    '{{WRAPPER}} .pedroea-site-logo a:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'logo_transition_duration',
            [
                'label'        => __('Transition Duration (ms)', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 3000,
                        'step' => 100,
                    ],
                ], 
                'selectors'    => [
                    '{{WRAPPER}} .pedroea-site-logo img' => 'transition-duration: {{SIZE}}ms;',
                ]
            ]
        );

        $this->end_controls_section();

    }


    protected function render(): void
    {
        $settings = $this->get_settings_for_display();

        // Resolve logo source
        if ('custom_logo' === $settings['logo_type']) {
            $logo_url = ! empty($settings['custom_logo']['url']) ? $settings['custom_logo']['url'] : '';
            $logo_alt = ! empty($settings['custom_logo']['alt']) ? $settings['custom_logo']['alt'] : get_bloginfo('name');
        } else {
            $custom_logo_id = get_theme_mod('custom_logo');
            if ($custom_logo_id) {
                $logo_image = wp_get_attachment_image_src($custom_logo_id, 'full');
                $logo_url   = $logo_image ? $logo_image[0] : '';
                $logo_alt   = get_post_meta($custom_logo_id, '_wp_attachment_image_alt', true) ?: get_bloginfo('name');
            } else {
                $logo_url = '';
                $logo_alt = get_bloginfo('name');
            }
        }

        if (empty($logo_url)) {
            if (Plugin::$instance->editor->is_edit_mode()) {
                echo '<div class="pedroea-site-logo"><p>' . esc_html__('No logo found. Please set a site logo or choose a custom one.', 'pedro-for-elementor-addons') . '</p></div>';
            }
            return;
        }

        // Resolve link
        $target = ('yes' === $settings['open_in_new_tab']) ? '_blank' : '_self';

        if ('home' === $settings['logo_link_to']) {
            $link_url = esc_url(home_url('/'));
        } elseif ('custom' === $settings['logo_link_to'] && ! empty($settings['logo_custom_link']['url'])) {
            $link_url = esc_url($settings['logo_custom_link']['url']);
        } else {
            $link_url = '';
        }

        ?>
        <div class="pedroea-site-logo">
            <?php if ($link_url) : ?>
                <a href="<?php echo $link_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>" target="<?php echo esc_attr($target); ?>"<?php echo ('_blank' === $target) ? ' rel="noopener noreferrer"' : ''; ?>>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>">
                </a>
            <?php else : ?>
                <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>">
            <?php endif; ?>
        </div>
        <?php
    }
}