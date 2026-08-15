<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (! defined('ABSPATH')) {
    exit;
}

class Form extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_form';
    }

    public function get_title(): string
    {
        return __('Form', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-form-horizontal pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['form', 'contact', 'email', 'builder', 'input'];
    }

    public function get_script_depends(): array
    {
        return ['jquery'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_fields',
            [
                'label' => __('Fields', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'field_type',
            [
                'label'   => __('Type', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text'     => __('Text', 'pedro-for-elementor-addons'),
                    'email'    => __('Email', 'pedro-for-elementor-addons'),
                    'textarea' => __('Textarea', 'pedro-for-elementor-addons'),
                    'select'   => __('Select', 'pedro-for-elementor-addons'),
                    'radio'    => __('Radio', 'pedro-for-elementor-addons'),
                    'checkbox' => __('Checkbox', 'pedro-for-elementor-addons'),
                    'number'   => __('Number', 'pedro-for-elementor-addons'),
                    'url'      => __('URL', 'pedro-for-elementor-addons'),
                    'tel'      => __('Phone', 'pedro-for-elementor-addons'),
                    'date'     => __('Date', 'pedro-for-elementor-addons'),
                    'time'     => __('Time', 'pedro-for-elementor-addons'),
                    'accept'   => __('Acceptance', 'pedro-for-elementor-addons'),
                    'hidden'   => __('Hidden', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $repeater->add_control(
            'field_label',
            [
                'label'       => __('Label', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Field', 'pedro-for-elementor-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'placeholder',
            [
                'label'       => __('Placeholder', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'condition'   => ['field_type' => ['text', 'email', 'textarea', 'number', 'url', 'tel', 'date', 'time']],
            ]
        );

        $repeater->add_control(
            'field_options',
            [
                'label'       => __('Options', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXTAREA,
                'description' => __('One option per line. Use value|label to set a custom value.', 'pedro-for-elementor-addons'),
                'default'     => '',
                'condition'   => ['field_type' => ['select', 'radio', 'checkbox']],
            ]
        );

        $repeater->add_control(
            'default_value',
            [
                'label'       => __('Default Value', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'condition'   => ['field_type' => ['text', 'email', 'textarea', 'number', 'url', 'tel', 'date', 'time', 'hidden']],
            ]
        );

        $repeater->add_control(
            'required',
            [
                'label'   => __('Required', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => '',
                'condition' => ['field_type!' => ['hidden']],
            ]
        );

        $repeater->add_control(
            'acceptance_text',
            [
                'label'       => __('Acceptance Text', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('I agree to the terms', 'pedro-for-elementor-addons'),
                'label_block' => true,
                'condition'   => ['field_type' => 'accept'],
            ]
        );

        $repeater->add_control(
            'field_width',
            [
                'label'   => __('Width', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => '100',
                'options' => [
                    '100' => __('Full Width', 'pedro-for-elementor-addons'),
                    '50'  => __('Half Width', 'pedro-for-elementor-addons'),
                    '33'  => __('One Third', 'pedro-for-elementor-addons'),
                    '25'  => __('One Quarter', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_control(
            'fields',
            [
                'label'       => __('Form Fields', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'field_type'  => 'text',
                        'field_label' => __('Name', 'pedro-for-elementor-addons'),
                        'required'    => 'yes',
                    ],
                    [
                        'field_type'  => 'email',
                        'field_label' => __('Email', 'pedro-for-elementor-addons'),
                        'required'    => 'yes',
                    ],
                    [
                        'field_type'  => 'textarea',
                        'field_label' => __('Message', 'pedro-for-elementor-addons'),
                        'required'    => 'yes',
                    ],
                ],
                'title_field' => '{{{ field_label }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_submit',
            [
                'label' => __('Submit', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'submit_text',
            [
                'label'   => __('Button Text', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Send', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'show_labels',
            [
                'label'   => __('Show Labels', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_actions',
            [
                'label' => __('Actions', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'send_email',
            [
                'label'   => __('Send to Email', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'email_to',
            [
                'label'       => __('Send To', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => get_option('admin_email'),
                'condition'   => ['send_email' => 'yes'],
                'description' => __('Separate multiple recipients with a comma.', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'email_subject',
            [
                'label'       => __('Subject', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => sprintf(__('New form submission — %s', 'pedro-for-elementor-addons'), get_bloginfo('name')),
                'condition'   => ['send_email' => 'yes'],
            ]
        );

        $this->add_control(
            'redirect_url',
            [
                'label'       => __('Redirect URL', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => ['active' => true],
                'placeholder' => __('https://your-site.com/thanks/', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'success_message',
            [
                'label'       => __('Success Message', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'default'     => __('Your message has been sent successfully.', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'error_message',
            [
                'label'   => __('Error Message', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Something went wrong. Please check the form and try again.', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'honeypot',
            [
                'label'   => __('Enable Honeypot', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_form',
            [
                'label' => __('Form', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'column_gap',
            [
                'label'      => __('Columns Gap', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 60]],
                'default'    => ['unit' => 'px', 'size' => 15],
                'selectors'  => [
                    '{{WRAPPER}} .pea-form-row' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'row_gap',
            [
                'label'      => __('Rows Gap', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 60]],
                'default'    => ['unit' => 'px', 'size' => 15],
                'selectors'  => [
                    '{{WRAPPER}} .pea-form-row' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_labels',
            [
                'label' => __('Labels', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => __('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-form-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'marker_color',
            [
                'label'     => __('Required Marker', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ef4444',
                'selectors' => [
                    '{{WRAPPER}} .pea-form-required' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'label_typography',
                'selector' => '{{WRAPPER}} .pea-form-label',
            ]
        );

        $this->add_responsive_control(
            'label_spacing',
            [
                'label'      => __('Bottom Spacing', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 30]],
                'default'    => ['unit' => 'px', 'size' => 6],
                'selectors'  => [
                    '{{WRAPPER}} .pea-form-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_inputs',
            [
                'label' => __('Inputs', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-form-control' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-form-control' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_placeholder_color',
            [
                'label'     => __('Placeholder Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-form-control::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'input_typography',
                'selector' => '{{WRAPPER}} .pea-form-control',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'input_border',
                'selector' => '{{WRAPPER}} .pea-form-control',
                'fields_options' => [
                    'border' => ['default' => 'solid'],
                ],
            ]
        );

        $this->add_responsive_control(
            'input_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-form-control' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-form-control' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'input_shadow',
                'selector' => '{{WRAPPER}} .pea-form-control',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => __('Submit Button', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab('button_normal', ['label' => __('Normal', 'pedro-for-elementor-addons')]);

        $this->add_control(
            'btn_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7c3aed',
                'selectors' => [
                    '{{WRAPPER}} .pea-form-submit' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-form-submit' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('button_hover', ['label' => __('Hover', 'pedro-for-elementor-addons')]);

        $this->add_control(
            'btn_bg_hover',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-form-submit:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_color_hover',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-form-submit:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'btn_typography',
                'selector' => '{{WRAPPER}} .pea-form-submit',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'btn_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-form-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-form-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'btn_align',
            [
                'label'     => __('Alignment', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => ['title' => __('Left', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-left'],
                    'center' => ['title' => __('Center', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-center'],
                    'right'  => ['title' => __('Right', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-right'],
                    'stretch' => ['title' => __('Stretch', 'pedro-for-elementor-addons'), 'icon' => 'eicon-text-align-justify'],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .pea-form-footer' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .pea-form-submit' => 'width: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'btn_shadow',
                'selector' => '{{WRAPPER}} .pea-form-submit',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Build the option list for select / radio / checkbox fields.
     *
     * @param string $raw
     * @return array<int,array{value:string,label:string}>
     */
    private function parse_options($raw)
    {
        $options = [];
        $raw     = (string) $raw;

        foreach (preg_split('/\r\n|\r|\n/', $raw) as $line) {
            $line = trim($line);
            if ('' === $line) {
                continue;
            }

            if (false !== strpos($line, '|')) {
                [$value, $label] = array_map('trim', explode('|', $line, 2));
            } else {
                $value = $label = $line;
            }

            $options[] = ['value' => $value, 'label' => $label];
        }

        return $options;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $form_id = ! empty($settings['_element_id']) ? sanitize_title($settings['_element_id']) : '';
        if (empty($form_id)) {
            $form_id = 'pea-form-' . $this->get_id();
        }

        $this->add_render_attribute('form', 'class', 'pea-form');
        $this->add_render_attribute('form', 'id', $form_id);
        $this->add_render_attribute('form', 'data-form-id', $form_id);
        $this->add_render_attribute('form', 'data-success', $settings['success_message'] ?? '');
        $this->add_render_attribute('form', 'data-error', $settings['error_message'] ?? '');
        $this->add_render_attribute('form', 'data-email-to', $settings['email_to'] ?? '');
        $this->add_render_attribute('form', 'data-email-subject', $settings['email_subject'] ?? '');

        if (! empty($settings['redirect_url']['url'])) {
            $this->add_render_attribute('form', 'data-redirect', esc_url($settings['redirect_url']['url']));
        }
        ?>
        <form <?php echo $this->get_render_attribute_string('form'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php if ('yes' === ($settings['honeypot'] ?? 'yes')) : ?>
                <input type="text" name="pea_hp" class="pea-form-hp" tabindex="-1" autocomplete="off" aria-hidden="true">
            <?php endif; ?>

            <?php foreach ((array) $settings['fields'] as $index => $item) : ?>
                <?php $this->render_field($item, $index); ?>
            <?php endforeach; ?>

            <div class="pea-form-footer">
                <button type="submit" class="pea-form-submit">
                    <span class="pea-form-submit-text"><?php echo esc_html($settings['submit_text'] ?? __('Send', 'pedro-for-elementor-addons')); ?></span>
                    <span class="pea-form-submit-spinner" aria-hidden="true"></span>
                </button>
            </div>
        </form>
        <div class="pea-form-message" role="alert" hidden></div>
        <?php
    }

    protected function render_field($item, $index)
    {
        $type     = $item['field_type'] ?? 'text';
        $label    = $item['field_label'] ?? '';
        $required = 'yes' === ($item['required'] ?? '');
        $width    = $item['field_width'] ?? '100';
        $name     = 'pea_field_' . $index;

        $this->add_render_attribute('field', 'class', 'pea-form-col');
        $this->add_render_attribute('field', 'class', 'pea-form-col-' . $width);
        ?>
        <div <?php echo $this->get_render_attribute_string('field'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php
            if (! empty($label) && 'hidden' !== $type && 'yes' === ($this->get_settings_for_display('show_labels') ?? 'yes')) :
                ?>
                <label class="pea-form-label" for="<?php echo esc_attr($name); ?>">
                    <?php echo esc_html($label); ?>
                    <?php if ($required) : ?>
                        <span class="pea-form-required" aria-hidden="true">*</span>
                    <?php endif; ?>
                </label>
            <?php endif; ?>

            <?php
            $attrs = 'name="' . esc_attr($name) . '" id="' . esc_attr($name) . '" class="pea-form-control" data-type="' . esc_attr($type) . '"';
            if ($required) {
                $attrs .= ' required';
            }
            $placeholder = $item['placeholder'] ?? '';
            $default     = $item['default_value'] ?? '';

            switch ($type) {
                case 'textarea':
                    echo '<textarea ' . $attrs . ' rows="5" placeholder="' . esc_attr($placeholder) . '">' . esc_textarea($default) . '</textarea>';
                    break;

                case 'select':
                    echo '<select ' . $attrs . '>';
                    echo '<option value="">' . esc_html__('Select…', 'pedro-for-elementor-addons') . '</option>';
                    foreach ($this->parse_options($item['field_options'] ?? '') as $option) {
                        $selected = ($default === $option['value']) ? ' selected' : '';
                        echo '<option value="' . esc_attr($option['value']) . '"' . $selected . '>' . esc_html($option['label']) . '</option>';
                    }
                    echo '</select>';
                    break;

                case 'radio':
                    $options = $this->parse_options($item['field_options'] ?? '');
                    if (! empty($options)) {
                        echo '<div class="pea-form-options">';
                        foreach ($options as $option) {
                            $checked = ($default === $option['value']) ? ' checked' : '';
                            echo '<label class="pea-form-option">';
                            echo '<input type="radio" name="' . esc_attr($name) . '" value="' . esc_attr($option['value']) . '"' . $checked . ($required ? ' required' : '') . '>';
                            echo '<span>' . esc_html($option['label']) . '</span>';
                            echo '</label>';
                        }
                        echo '</div>';
                    }
                    break;

                case 'checkbox':
                    $options = $this->parse_options($item['field_options'] ?? '');
                    if (! empty($options)) {
                        echo '<div class="pea-form-options">';
                        foreach ($options as $option) {
                            echo '<label class="pea-form-option">';
                            echo '<input type="checkbox" name="' . esc_attr($name) . '[]" value="' . esc_attr($option['value']) . '">';
                            echo '<span>' . esc_html($option['label']) . '</span>';
                            echo '</label>';
                        }
                        echo '</div>';
                    }
                    break;

                case 'accept':
                    echo '<label class="pea-form-option pea-form-accept">';
                    echo '<input type="checkbox" name="' . esc_attr($name) . '" value="yes"' . ($required ? ' required' : '') . '>';
                    echo '<span>' . esc_html($item['acceptance_text'] ?? __('I agree', 'pedro-for-elementor-addons')) . '</span>';
                    echo '</label>';
                    break;

                case 'hidden':
                    echo '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($default) . '">';
                    break;

                default:
                    echo '<input type="' . esc_attr($type) . '" ' . $attrs . ' value="' . esc_attr($default) . '" placeholder="' . esc_attr($placeholder) . '">';
                    break;
            }
            ?>
        </div>
        <?php
    }
}