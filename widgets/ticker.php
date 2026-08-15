<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) exit;

class Ticker extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_ticker';
    }

    public function get_title()
    {
        return __('Ticker', 'pedro-for-elementor-addons');
    }

    public function get_icon()
    {
        return 'eicon-post-slider pedro-elementor-icon';
    }

    public function get_categories()
    {
        return ['pedroea'];
    }

    public function get_keywords()
    {
        return ['ticker', 'news ticker', 'scrolling text', 'marquee'];
    }

    protected function register_controls()
    {

        $this->start_controls_section('section_content', [
            'label' => __('Ticker Items', 'pedro-for-elementor-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $repeater = new Repeater();

        $repeater->add_control('item_icon', [
            'label' => __('Icon', 'pedro-for-elementor-addons'),
            'type'  => Controls_Manager::ICONS,
        ]);

        $repeater->add_control('item_text', [
            'label'   => __('Text', 'pedro-for-elementor-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('Breaking News', 'pedro-for-elementor-addons'),
            'dynamic' => ['active' => true],
        ]);

        $this->add_control('items', [
            'label'       => __('Items', 'pedro-for-elementor-addons'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                ['item_text' => __('Breaking News: Major update released today', 'pedro-for-elementor-addons')],
                ['item_text' => __('Weather alert: Heavy rain expected tomorrow', 'pedro-for-elementor-addons')],
                ['item_text' => __('Sports: Home team wins championship', 'pedro-for-elementor-addons')],
                ['item_text' => __('Technology: New AI breakthrough announced', 'pedro-for-elementor-addons')],
            ],
            'title_field' => '{{{ item_text }}}',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_separator', [
            'label' => __('Separator', 'pedro-for-elementor-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('separator_icon', [
            'label' => __('Separator Icon', 'pedro-for-elementor-addons'),
            'type'  => Controls_Manager::ICONS,
            'default' => [
                'value'   => 'fas fa-star',
                'library' => 'fa-solid',
            ],
        ]);

        $this->add_control('separator_text', [
            'label'   => __('Separator Text', 'pedro-for-elementor-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => '',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_settings', [
            'label' => __('Settings', 'pedro-for-elementor-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('speed', [
            'label'   => __('Speed (px/s)', 'pedro-for-elementor-addons'),
            'type'    => Controls_Manager::NUMBER,
            'default' => 50,
            'min'     => 10,
            'max'     => 500,
        ]);

        $this->add_control('direction', [
            'label'   => __('Direction', 'pedro-for-elementor-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'left',
            'options' => [
                'left'  => __('Left', 'pedro-for-elementor-addons'),
                'right' => __('Right', 'pedro-for-elementor-addons'),
            ],
        ]);

        $this->add_control('pause_on_hover', [
            'label'   => __('Pause on Hover', 'pedro-for-elementor-addons'),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_style_items', [
            'label' => __('Items', 'pedro-for-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'text_typography',
            'selector' => '{{WRAPPER}} .pea-ticker-text',
        ]);

        $this->add_control('text_color', [
            'label'     => __('Text Color', 'pedro-for-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#333333',
            'selectors' => ['{{WRAPPER}} .pea-ticker-text' => 'color: {{VALUE}};'],
        ]);

        $this->add_control('icon_color', [
            'label'     => __('Icon Color', 'pedro-for-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#333333',
            'selectors' => ['{{WRAPPER}} .pea-ticker-item-icon' => 'color: {{VALUE}}; fill: {{VALUE}};'],
        ]);

        $this->add_responsive_control('icon_size', [
            'label'      => __('Icon Size', 'pedro-for-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 10, 'max' => 60]],
            'default'    => ['unit' => 'px', 'size' => 16],
            'selectors'  => ['{{WRAPPER}} .pea-ticker-item-icon' => 'font-size: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('item_gap', [
            'label'      => __('Gap between Items', 'pedro-for-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 10, 'max' => 80]],
            'default'    => ['unit' => 'px', 'size' => 40],
            'selectors'  => ['{{WRAPPER}} .pea-ticker-item' => 'padding-right: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_style_separator', [
            'label' => __('Separator', 'pedro-for-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('separator_color', [
            'label'     => __('Separator Color', 'pedro-for-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ff0000',
            'selectors' => [
                '{{WRAPPER}} .pea-ticker-separator' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ],
        ]);

        $this->add_responsive_control('separator_size', [
            'label'      => __('Separator Size', 'pedro-for-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 10, 'max' => 60]],
            'default'    => ['unit' => 'px', 'size' => 18],
            'selectors'  => ['{{WRAPPER}} .pea-ticker-separator' => 'font-size: {{SIZE}}{{UNIT}};'],
        ]);

        $this->add_responsive_control('separator_gap', [
            'label'      => __('Gap around Separator', 'pedro-for-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range'      => ['px' => ['min' => 0, 'max' => 60]],
            'default'    => ['unit' => 'px', 'size' => 15],
            'selectors'  => ['{{WRAPPER}} .pea-ticker-separator' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};'],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_style_background', [
            'label' => __('Background', 'pedro-for-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('ticker_background', [
            'label'     => __('Background Color', 'pedro-for-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f5f5f5',
            'selectors' => ['{{WRAPPER}} .pea-ticker-wrap' => 'background-color: {{VALUE}};'],
        ]);

        $this->add_group_control(Group_Control_Border::get_type(), [
            'name'     => 'ticker_border',
            'selector' => '{{WRAPPER}} .pea-ticker-wrap',
        ]);

        $this->add_responsive_control('ticker_padding', [
            'label'      => __('Padding', 'pedro-for-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'default'    => ['top' => '10', 'right' => '0', 'bottom' => '10', 'left' => '0', 'unit' => 'px'],
            'selectors'  => ['{{WRAPPER}} .pea-ticker-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
        ]);

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $items    = $settings['items'] ?? [];

        if (empty($items)) return;

        $this->add_render_attribute('wrap', [
            'class'          => 'pea-ticker-wrap',
            'data-speed'     => esc_attr($settings['speed']),
            'data-direction' => esc_attr($settings['direction']),
            'data-pause'     => esc_attr($settings['pause_on_hover']),
        ]);

?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <div class="pea-ticker-track">
                <div class="pea-ticker-content">
                    <?php
                    $has_separator = ! empty( $settings['separator_icon']['value'] ) || ! empty( $settings['separator_text'] );
                    $i             = 0;
                    foreach ( $items as $item ) :
                        $i++;
                        ?>
                        <span class="pea-ticker-item">
                            <?php if (!empty($item['item_icon']['value'])) : ?>
                                <span class="pea-ticker-item-icon">
                                    <?php Icons_Manager::render_icon($item['item_icon'], ['aria-hidden' => 'true']); ?>
                                </span>
                            <?php endif; ?>
                            <span class="pea-ticker-text"><?php echo esc_html($item['item_text']); ?></span>
                        </span>
                        <?php if ( $has_separator ) : ?>
                        <span class="pea-ticker-separator">
                            <?php if (!empty($settings['separator_icon']['value'])) : ?>
                                <?php Icons_Manager::render_icon($settings['separator_icon'], ['aria-hidden' => 'true']); ?>
                            <?php endif; ?>
                            <?php if (!empty($settings['separator_text'])) : ?>
                                <span class="pea-ticker-sep-text"><?php echo esc_html($settings['separator_text']); ?></span>
                            <?php endif; ?>
                        </span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
<?php
    }
}
