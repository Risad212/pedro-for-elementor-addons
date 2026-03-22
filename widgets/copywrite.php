<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) {
    exit;
}

class CopyWrite extends Widget_Base
{

    public function get_name(): string
    {
        return 'pedroea_copywrite';
    }

    public function get_title(): string
    {
        return __('CopyWrite', 'pedro-for-elementor-addons');
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
        return ['copywrite', 'copyright', 'footer', 'year'];
    }

    private function get_keywords_map( string $year ): array
    {
        return [
            '{current_year}' => $year,
        ];
    }

    protected function register_controls(): void
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Copyright Text', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'copyright_text',
            [
                'label'       => __('Copyright Text', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => '© {current_year} My Company. All Rights Reserved.',
                'placeholder' => '© {current_year} My Company. All Rights Reserved.',
                'rows'        => 4,
                'description' => __('Use <code>{current_year}</code> to output the year.', 'pedro-for-elementor-addons'),
                'dynamic'     => ['active' => true],
            ]
        );

        $this->add_control(
            'year',
            [
                'label'       => __('Year', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => date('Y'),
                'placeholder' => date('Y'),
                'label_block' => false,
                'dynamic'     => ['active' => true],
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label'      => __('Alignment', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::CHOOSE,
                'options'    => [
                    'left'   => ['title' => __('Left', 'pedro-for-elementor-addons'),   'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => __('Center', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'right'  => ['title' => __('Right', 'pedro-for-elementor-addons'),  'icon' => 'eicon-text-align-right'],
                ],
                'default'    => 'center',
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-copywrite' => 'text-align: {{VALUE}};',
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

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'selector' => '{{WRAPPER}} .pedroea-copywrite',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pedroea-copywrite'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pedroea-copywrite a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        $year     = ! empty( $settings['year'] ) ? sanitize_text_field( $settings['year'] ) : date('Y');

        $text = str_replace(
            array_keys( $this->get_keywords_map( $year ) ),
            array_values( $this->get_keywords_map( $year ) ),
            $settings['copyright_text']
        );

        $this->add_render_attribute('wrapper', 'class', 'pedroea-copywrite');
        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <?php echo wp_kses_post($text); ?>
        </div>
        <?php
    }
}