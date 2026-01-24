<?php

namespace PedroEA\Widgets;

use \Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;


// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

class Testimonial_Navigation extends Widget_Base {

    public function get_name()
    {
        return 'pedroea_testimonial_navigation';
    }

    public function get_title(): string
    {
        return __('Testimonial Navigation', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-link pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['Testimonial', 'Navigation'];
    }

    // Start content controls
    protected function register_controls(): void {

        $this->start_controls_section(
            'section_nav',
            [
                'label' => __('Navigation Settings', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'target_id',
            [
                'label'       => __('Target Slider ID', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => 'testimonial-slider-1',
            ]
        );

        $this->add_control(
            'arrow_prev_icon',
            [
                'label'   => __('Previous Icon', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::ICONS,
                'default' => ['value' => 'fas fa-chevron-left', 'library' => 'fa-solid'],
            ]
        );

        $this->add_control(
            'arrow_next_icon',
            [
                'label'   => __('Next Icon', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::ICONS,
                'default' => ['value' => 'fas fa-chevron-right', 'library' => 'fa-solid'],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'section_style_nav',
            [
                'label' => __('Navigation Style', 'pedro-for-elementor-addons'),
                'tab'   =>  Controls_Manager::TAB_STYLE,
            ]
        );

        // button aligment
        $this->add_responsive_control(
            'button_alignment',
            [
                'label'             => __( 'Button Alignment', 'pea' ),
                'type'              => Controls_Manager::CHOOSE,
                'options'           => [
                    'flex-start'    => [
                        'title'     => __( 'Left', 'pea' ),
                        'icon'      => 'eicon-text-align-left',
                    ],
                    'center'        => [
                        'title'     => __( 'Center', 'pea' ),
                        'icon'      => 'eicon-text-align-center',
                    ],
                    'flex-end'      => [
                        'title'     => __( 'Right', 'pea' ),
                        'icon'      => 'eicon-text-align-right',
                    ],
                    'space-between' => [
                        'title'     => __( 'Space Between', 'pea' ),
                        'icon'      => 'eicon-h-align-stretch',
                    ],
                ],
                'default'           => 'center',
                'selectors'         => [
                    '{{WRAPPER}} .pea-testimonial-nav' => 'justify-content: {{VALUE}};',
                ],
            ]
        );


        // Button background color
        $this->add_control(
            'nav_bg',
            [
                'label'     => __('Button Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .navigation-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Icon color
        $this->add_control(
            'nav_icon_color',
            [
                'label'     => __('Icon Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-nav-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        // Button size
        $this->add_control(
            'nav_btn_size',
            [
                'label' => __('Button Size', 'pedro-for-elementor-addons'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                    ],
                ],
                'default' => ['unit' => 'px', 'size' => 40],
                'selectors' => [
                    '{{WRAPPER}} .navigation-button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Icon size
        $this->add_control(
            'nav_icon_size',
            [
                'label' => __('Icon Size', 'pedro-for-elementor-addons'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'default' => ['unit' => 'px', 'size' => 16],
                'selectors' => [
                    '{{WRAPPER}} .pea-nav-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Button border radius
        $this->add_control(
            'nav_radius',
            [
                'label' => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 50],
                ],
                'default' => ['unit' => 'px', 'size' => 6],
                'selectors' => [
                    '{{WRAPPER}} .navigation-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Button spacing
        $this->add_control(
            'nav_spacing',
            [
                'label' => __('Button Spacing', 'pedro-for-elementor-addons'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 50],
                ],
                'default' => ['unit' => 'px', 'size' => 10],
                'selectors' => [
                    '{{WRAPPER}} .navigation-button + .navigation-button' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render(): void {
       $settings = $this->get_settings_for_display();
       $target_id = $settings['target_id'];
    ?>

        <?php if ( ! empty( $target_id ) ) : ?>
            <div class="pea-testimonial-nav" id="<?php echo esc_attr($target_id); ?>">

                <div class="navigation-button pea-button-prev" aria-label="Previous slide">
                    <span class="pea-icon-prev pea-nav-icon">
                        <?php Icons_Manager::render_icon($settings['arrow_prev_icon'], ['aria-hidden' => 'true']); ?>
                    </span>
                </div>

                <div class="navigation-button pea-button-next" aria-label="Next slide">
                    <span class="pea-icon-next pea-nav-icon">
                        <?php Icons_Manager::render_icon($settings['arrow_next_icon'], ['aria-hidden' => 'true']); ?>
                    </span>
                </div>

            </div>
        <?php else : ?>
            <p>Navigation ID not set. Buttons will not be displayed.</p>
        <?php endif; ?>
        <?php
    }

}
