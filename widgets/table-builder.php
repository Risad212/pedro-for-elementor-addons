<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

if (! defined('ABSPATH')) {
    exit;
}

class Table_Builder extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_table_builder';
    }

    public function get_title(): string
    {
        return __('Table Builder', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-table pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['table', 'builder', 'grid', 'rows', 'columns'];
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
            'header',
            [
                'label'     => __('Header Row', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'separator' => 'after',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'header_text',
            [
                'label'   => __('Header Text', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Column', 'pedro-for-elementor-addons'),
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'header_icon',
            [
                'label' => __('Icon', 'pedro-for-elementor-addons'),
                'type'  => Controls_Manager::ICONS,
            ]
        );

        $repeater->add_control(
            'header_width',
            [
                'label'   => __('Column Width', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'auto',
                'options' => [
                    'auto'  => __('Auto', 'pedro-for-elementor-addons'),
                    '10%'   => '10%',
                    '15%'   => '15%',
                    '20%'   => '20%',
                    '25%'   => '25%',
                    '30%'   => '30%',
                    '40%'   => '40%',
                    '50%'   => '50%',
                    '60%'   => '60%',
                    '70%'   => '70%',
                    '80%'   => '80%',
                    '100px' => '100px',
                    '200px' => '200px',
                ],
            ]
        );

        $rows_repeater = new Repeater();

        $rows_repeater->add_control(
            'cells',
            [
                'label'  => __('Cells (comma-separated)', 'pedro-for-elementor-addons'),
                'type'   => Controls_Manager::TEXTAREA,
                'default' => 'Cell 1, Cell 2, Cell 3',
                'rows'    => 2,
                'dynamic' => ['active' => true],
            ]
        );

        $rows_repeater->add_control(
            'row_color',
            [
                'label'   => __('Row Color', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-tb-body tr{{CURRENT_ITEM}}' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'columns',
            [
                'label'       => __('Columns', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    ['header_text' => __('Name', 'pedro-for-elementor-addons')],
                    ['header_text' => __('Price', 'pedro-for-elementor-addons')],
                    ['header_text' => __('Quantity', 'pedro-for-elementor-addons')],
                ],
                'title_field' => '{{{ header_text }}}',
            ]
        );

        $this->add_control(
            'rows',
            [
                'label'       => __('Rows', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $rows_repeater->get_controls(),
                'default'     => [
                    ['cells' => 'Item A, $10, 5'],
                    ['cells' => 'Item B, $20, 3'],
                    ['cells' => 'Item C, $15, 7'],
                ],
                'title_field' => '{{{ cells }}}',
                'separator'   => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_header',
            [
                'label'     => __('Header', 'pedro-for-elementor-addons'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => ['header' => 'yes'],
            ]
        );

        $this->add_control(
            'header_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-tb-header th' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'header_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-tb-header th' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'header_typography',
                'selector' => '{{WRAPPER}} .pea-tb-header th',
            ]
        );

        $this->add_responsive_control(
            'header_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-tb-header th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_body',
            [
                'label' => __('Body', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'body_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-tb-body td' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'body_bg_odd',
            [
                'label'     => __('Odd Row Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-tb-body tr:nth-child(odd)' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'body_bg_even',
            [
                'label'     => __('Even Row Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f9fafb',
                'selectors' => [
                    '{{WRAPPER}} .pea-tb-body tr:nth-child(even)' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'body_typography',
                'selector' => '{{WRAPPER}} .pea-tb-body td',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'table_border',
                'selector' => '{{WRAPPER}} .pea-table',
            ]
        );

        $this->add_responsive_control(
            'cell_padding',
            [
                'label'      => __('Cell Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-table td, {{WRAPPER}} .pea-table th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['columns'])) {
            return;
        }
        ?>
        <table class="pea-table">
            <?php if ('yes' === $settings['header']) : ?>
                <thead class="pea-tb-header">
                    <tr>
                        <?php foreach ($settings['columns'] as $col) : ?>
                            <th style="width:<?php echo esc_attr($col['header_width']); ?>">
                                <?php if (! empty($col['header_icon']['value'])) : ?>
                                    <?php \Elementor\Icons_Manager::render_icon($col['header_icon'], ['aria-hidden' => 'true']); ?>
                                <?php endif; ?>
                                <?php echo esc_html($col['header_text']); ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
            <?php endif; ?>
            <?php if (! empty($settings['rows'])) : ?>
                <tbody class="pea-tb-body">
                    <?php foreach ($settings['rows'] as $index => $row) :
                        $cells_str = (string) $row['cells'];
                        $delimiter = (false !== strpos($cells_str, '|')) ? '|' : ',';
                        $cells = array_map('trim', explode($delimiter, $cells_str));
                        $item_id = 'elementor-repeater-item-' . $row['_id'];
                        ?>
                        <tr class="<?php echo esc_attr($item_id); ?>">
                            <?php foreach ($cells as $cell) : ?>
                                <td><?php echo esc_html($cell); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            <?php endif; ?>
        </table>
        <?php
    }
}
