<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if (! defined('ABSPATH')) {
    exit;
}

class Animated_Headline extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_animated_headline';
    }

    public function get_title(): string
    {
        return __('Animated Headline', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-animated-headline pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['headline', 'animated', 'rotating', 'text', 'typing'];
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
            'headline_style',
            [
                'label'   => __('Animation Style', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'rotate',
                'options' => [
                    'rotate' => __('Rotate', 'pedro-for-elementor-addons'),
                    'typed'  => __('Typing', 'pedro-for-elementor-addons'),
                    'blink'  => __('Highlight Rotate', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_control(
            'prefix_text',
            [
                'label'   => __('Prefix Text', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('We create', 'pedro-for-elementor-addons'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text',
            [
                'label'       => __('Word', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Amazing', 'pedro-for-elementor-addons'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'rotated_words',
            [
                'label'       => __('Rotated Words', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    ['text' => __('Amazing', 'pedro-for-elementor-addons')],
                    ['text' => __('Stunning', 'pedro-for-elementor-addons')],
                    ['text' => __('Beautiful', 'pedro-for-elementor-addons')],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->add_control(
            'suffix_text',
            [
                'label'   => __('Suffix Text', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('websites', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'rotate_speed',
            [
                'label'     => __('Rotation Speed (ms)', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 2500,
                'min'       => 500,
                'step'      => 100,
                'condition' => ['headline_style!' => 'typed'],
            ]
        );

        $this->add_control(
            'typing_speed',
            [
                'label'     => __('Typing Speed (ms/char)', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 80,
                'min'       => 20,
                'step'      => 10,
                'condition' => ['headline_style' => 'typed'],
            ]
        );

        $this->add_control(
            'link',
            [
                'label'   => __('Link', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::URL,
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'html_tag',
            [
                'label'   => __('HTML Tag', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'p'  => 'p',
                ],
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

        $this->add_control(
            'text_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-ah-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'rotated_color',
            [
                'label'     => __('Rotated Word Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7c3aed',
                'selectors' => [
                    '{{WRAPPER}} .pea-ah-rotated' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'highlight_background',
            [
                'label'     => __('Highlight Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(124,58,237,0.15)',
                'selectors' => [
                    '{{WRAPPER}} .pea-ah-rotated' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .pea-ah-rotated .pea-ah-rotated-word' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'     => __('Alignment', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'pedro-for-elementor-addons'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'pedro-for-elementor-addons'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'pedro-for-elementor-addons'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .pea-animated-headline' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .pea-ah-text',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'rotated_typography',
                'selector' => '{{WRAPPER}} .pea-ah-rotated',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $words = [];
        if (! empty($settings['rotated_words']) && is_array($settings['rotated_words'])) {
            foreach ($settings['rotated_words'] as $item) {
                if (! empty($item['text'])) {
                    $words[] = $item['text'];
                }
            }
        }

        if (empty($words)) {
            $words = [__('Amazing', 'pedro-for-elementor-addons')];
        }

        $tag = $settings['html_tag'] ?? 'h2';

        $this->add_render_attribute('wrap', 'class', 'pea-animated-headline');
        $this->add_render_attribute('wrap', 'data-style', $settings['headline_style']);
        $this->add_render_attribute('wrap', 'data-speed', $settings['rotate_speed'] ?? 2500);
        $this->add_render_attribute('wrap', 'data-typed-speed', $settings['typing_speed'] ?? 80);
        $this->add_render_attribute('wrap', 'data-words', wp_json_encode($words));

        $html = '';
        if (! empty($settings['prefix_text'])) {
            $html .= '<span class="pea-ah-text pea-ah-prefix">' . esc_html($settings['prefix_text']) . '&nbsp;</span>';
        }

        $html .= '<span class="pea-ah-rotated" aria-live="polite"><span class="pea-ah-rotated-word">' . esc_html($words[0]) . '</span></span>';

        if (! empty($settings['suffix_text'])) {
            $html .= '<span class="pea-ah-text pea-ah-suffix">&nbsp;' . esc_html($settings['suffix_text']) . '</span>';
        }

        if (! empty($settings['link']['url'])) {
            $this->add_link_attributes('ah_link', $settings['link']);
            $html = '<a ' . $this->get_render_attribute_string('ah_link') . '>' . $html . '</a>';
        }
        ?>
        <<?php echo esc_attr($tag); ?> <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </<?php echo esc_attr($tag); ?>>
        <?php
    }
}