<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit;

class Counter extends Widget_Base {

    public function get_name(): string {
        return 'pedroea_counter';
    }

    public function get_title(): string {
        return __( 'Counter', 'pedro-for-elementor-addons' );
    }

    public function get_icon(): string {
        return 'eicon-counter pedro-elementor-icon';
    }

    public function get_categories(): array {
        return [ 'pedroea' ];
    }

    public function get_keywords(): array {
        return [ 'counter', 'number', 'count up', 'stat', 'statistics' ];
    }

    protected function register_controls(): void {

        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'pedro-for-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'starting_number',
            [
                'label'   => __( 'Starting Number', 'pedro-for-elementor-addons' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 0,
                'min'     => 0,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'ending_number',
            [
                'label'   => __( 'Ending Number', 'pedro-for-elementor-addons' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 100,
                'min'     => 1,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'number_prefix',
            [
                'label'       => __( 'Number Prefix', 'pedro-for-elementor-addons' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __( '$', 'pedro-for-elementor-addons' ),
            ]
        );

        $this->add_control(
            'number_suffix',
            [
                'label'       => __( 'Number Suffix', 'pedro-for-elementor-addons' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __( '+', 'pedro-for-elementor-addons' ),
            ]
        );

        $this->add_control(
            'duration',
            [
                'label'   => __( 'Animation Duration (ms)', 'pedro-for-elementor-addons' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 2000,
                'min'     => 100,
                'max'     => 10000,
                'step'    => 100,
            ]
        );

        $this->add_control(
            'thousand_separator',
            [
                'label'        => __( 'Thousand Separator', 'pedro-for-elementor-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'pedro-for-elementor-addons' ),
                'label_off'    => __( 'Hide', 'pedro-for-elementor-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'content_alignment',
            [
                'label'     => __( 'Alignment', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __( 'Left', 'pedro-for-elementor-addons' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'pedro-for-elementor-addons' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'pedro-for-elementor-addons' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .pedroea-counter' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_number',
            [
                'label' => __( 'Number', 'pedro-for-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label'     => __( 'Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pedroea-counter-number-wrap' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'number_typography',
                'label'    => __( 'Typography', 'pedro-for-elementor-addons' ),
                'selector' => '{{WRAPPER}} .pedroea-counter-number-wrap',
            ]
        );

        $this->end_controls_section();

    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();

        $starting   = ! empty( $settings['starting_number'] ) ? intval( $settings['starting_number'] ) : 0;
        $ending     = ! empty( $settings['ending_number'] ) ? intval( $settings['ending_number'] ) : 100;
        $duration   = ! empty( $settings['duration'] ) ? intval( $settings['duration'] ) : 2000;
        $prefix     = $settings['number_prefix'] ?? '';
        $suffix     = $settings['number_suffix'] ?? '';
        $separator  = ( $settings['thousand_separator'] ?? 'yes' ) === 'yes';

        $uid = 'pea-c-' . $this->get_id();

        $this->add_render_attribute( 'counter', [
            'class'           => 'pedroea-counter-number',
            'id'              => $uid,
            'data-start'      => $starting,
            'data-end'        => $ending,
            'data-duration'   => $duration,
            'data-separator'  => $separator ? 'yes' : 'no',
        ] );

        ?>
        <div class="pedroea-counter">
            <div class="pedroea-counter-number-wrap">
                <?php if ( $prefix ) : ?>
                    <span class="pedroea-counter-prefix"><?php echo esc_html( $prefix ); ?></span>
                <?php endif; ?>
                <span <?php echo $this->get_render_attribute_string( 'counter' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>0</span>
                <?php if ( $suffix ) : ?>
                    <span class="pedroea-counter-suffix"><?php echo esc_html( $suffix ); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <?php
    }
}
