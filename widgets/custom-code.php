<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (! defined('ABSPATH')) {
    exit;
}

class Custom_Code extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_custom_code';
    }

    public function get_title(): string
    {
        return __('Custom Code', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-code pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['code', 'custom', 'html', 'css', 'js', 'snippet'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Custom Code', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'code_id',
            [
                'label'       => __('Custom ID', 'pedro-for-elementor-addons'),
                'description' => __('A unique identifier for this snippet (CSS / JS targeting).', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('my-custom-snippet', 'pedro-for-elementor-addons'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'code_content',
            [
                'label'       => __('Code', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::CODE,
                'language'    => 'html',
                'default'     => '',
                'placeholder' => __('<div>Your custom HTML, CSS or JS here</div>', 'pedro-for-elementor-addons'),
                'rows'        => 15,
            ]
        );

        $this->add_control(
            'editor_note',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => __('<strong>Warning:</strong> The code is executed as-is. Make sure it is valid before publishing.', 'pedro-for-elementor-addons'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
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
            'show_theme_styles',
            [
                'label'     => __('Apply Editor Styling', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => '',
                'description' => __('Wraps the code in a styled container when editing.', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_responsive_control(
            'min_height',
            [
                'label'      => __('Min Height', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 1000]],
                'selectors'  => [
                    '{{WRAPPER}} .pea-custom-code' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrap', 'class', 'pea-custom-code');

        if (! empty($settings['code_id'])) {
            $this->add_render_attribute('wrap', 'id', esc_attr($settings['code_id']));
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php echo $this->parse_code($settings['code_content'] ?? ''); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>
        <?php
    }

    /**
     * Decode the code safely. The CODE control stores the raw code; on the
     * front end we need the exact markup, so we return it as-is.
     *
     * @param string $code
     * @return string
     */
    protected function parse_code($code)
    {
        if ('' === $code) {
            return '';
        }

        return $code;
    }
}