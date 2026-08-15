<?php

namespace PedroEA\Widgets;

use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Icons_Manager;
use \Elementor\Group_Control_Box_Shadow;

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

class Testimonial extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_testimonial';
    }

    public function get_title(): string
    {
        return __('Testimonial', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-testimonial pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['Testimonial'];
    }

    // Start content controls
    protected function register_controls()
    {

        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Testimonial', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'testimonial_list',
            [
                'label'               => esc_html__('Testimonial', 'pedro-for-elementor-addons'),
                'type'                => Controls_Manager::REPEATER,
                'fields'              => [
                    [
                        'name'        => 'discription',
                        'label'       => esc_html__('Description', 'pedro-for-elementor-addons'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard dummy text ever since the 1500s', 'pedro-for-elementor-addons'),
                        'label_block' => true,
                    ],
                    [
                        'name'        => 'image',
                        'label'       => esc_html__('Image', 'pedro-for-elementor-addons'),
                        'type'        => Controls_Manager::MEDIA,
                        'default'     => [
                            'url'     => Utils::get_placeholder_image_src(),
                        ],
                        'label_block' => true,
                    ],
                    [
                        'name'        => 'name',
                        'label'       => esc_html__('Name', 'pedro-for-elementor-addons'),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__('Ema Watson', 'pedro-for-elementor-addons'),
                        'label_block' => true,
                    ],
                    [
                        'name'        => 'designation',
                        'label'       => esc_html__('Designation', 'pedro-for-elementor-addons'),
                        'type'        => Controls_Manager::TEXT,
                        'default'     => esc_html__('Founder', 'pedro-for-elementor-addons'),
                        'label_block' => true,
                    ],
                ],
                'default'              => [
                    [
                        'discription' => esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard dummy text ever since the 1500s', 'pedro-for-elementor-addons'),
                        'image'       => ['url' => Utils::get_placeholder_image_src()],
                        'name'        => esc_html__('Ema Watson', 'pedro-for-elementor-addons'),
                        'designation' => esc_html__('Founder', 'pedro-for-elementor-addons'),
                    ],
                    [
                        'discription' => esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard dummy text ever since the 1500s', 'pedro-for-elementor-addons'),
                        'image'       => ['url' => Utils::get_placeholder_image_src()],
                        'name'        => esc_html__('Ema Watson', 'pedro-for-elementor-addons'),
                        'designation' => esc_html__('Founder', 'pedro-for-elementor-addons'),
                    ],
                    [
                        'discription' => esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard dummy text ever since the 1500s', 'pedro-for-elementor-addons'),
                        'image'       => ['url' => Utils::get_placeholder_image_src()],
                        'name'        => esc_html__('Ema Watson', 'pedro-for-elementor-addons'),
                        'designation' => esc_html__('Founder', 'pedro-for-elementor-addons'),
                    ],
                    [
                        'discription' => esc_html__('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard dummy text ever since the 1500s', 'pedro-for-elementor-addons'),
                        'image'       => ['url' => Utils::get_placeholder_image_src()],
                        'name'        => esc_html__('Ema Watson', 'pedro-for-elementor-addons'),
                        'designation' => esc_html__('Founder', 'pedro-for-elementor-addons'),
                    ],
                ],
                'title_field'  => '{{{ name }}}'
            ]
        );

        $this->add_control(
            'image_switch',
            [
                'label'        => esc_html__('Image', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'pedro-for-elementor-addons'),
                'label_off'    => esc_html__('Hide', 'pedro-for-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'name_switch',
            [
                'label'        => esc_html__('Name', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'pedro-for-elementor-addons'),
                'label_off'    => esc_html__('Hide', 'pedro-for-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'designation_switch',
            [
                'label'        => esc_html__('Designation', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'pedro-for-elementor-addons'),
                'label_off'    => esc_html__('Hide', 'pedro-for-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'discription_switch',
            [
                'label'        => esc_html__('Description', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'pedro-for-elementor-addons'),
                'label_off'    => esc_html__('Hide', 'pedro-for-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'pagination_switch',
            [
                'label'        => esc_html__('Pagination', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Show', 'pedro-for-elementor-addons'),
                'label_off'    => esc_html__('Hide', 'pedro-for-elementor-addons'),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->end_controls_section();

        // settings
         $this->start_controls_section(
            'section_settings',
            [
                'label' => __('Settings', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

         $this->add_control(
            'slider_desktop_item',
            [
                'label'        => __('Desktop Item', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SLIDER,
                'description'  => __( 'Number of items. A maximum of 6 items allowed', 'pedro-for-elementor-addons' ),
                'default'      => [
                    'size'     => 3,
                ],
                'range'        => [
					'px'       => [
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
				],
                
             ],
            ]
        );

        $this->add_control(
            'slider_small_desktop_items',
            [
                'label'        => __('Desktop Small Item', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SLIDER,
                'description'  => __( 'Number of items. A maximum of 6 items allowed', 'pedro-for-elementor-addons' ),
                'default'      => [
                    'size'     => 2,
                ],
                'range'        => [
					'px'       => [
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
				],
                
             ],
            ]
        );

          $this->add_control(
            'slider_tablet_item',
            [
                'label'        => __('Tablet Item', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SLIDER,
                'description'  => __( 'Number of items. A maximum of 6 items allowed', 'pedro-for-elementor-addons' ),
                'default'      => [
                    'size'     => 2,
                ],
                'range'        => [
					'px'       => [
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
				],
                
             ],
            ]
        );

             $this->add_control(
            'slider_mobile_item',
            [
                'label'        => __('Mobile Item', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SLIDER,
                'description'  => __( 'Number of items. A maximum of 6 items allowed', 'pedro-for-elementor-addons' ),
                'default'      => [
                    'size'     => 1,
                ],
                'range'        => [
					'px'       => [
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
				],
                
             ],
            ]
        );

        $this->add_control(
            'slider_small_mobile_items',
            [
                'label'        => __('Mobile Small Item', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SLIDER,
                'description'  => __( 'Number of items. A maximum of 6 items allowed', 'pedro-for-elementor-addons' ),
                'default'      => [
                    'size'     => 1,
                ],
                'range'        => [
					'px'       => [
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
				],
                
             ],
            ]
        );

        $this->add_control(
            'slider_spacebetween',
            [
                'label'        => __('Item Spacebetween', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SLIDER,
                'description'  => __( 'Item Spacebetween', 'pedro-for-elementor-addons' ),
                'default'      => [
                    'size'     => 15,
                ],
                'range'        => [
					'px'       => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
				],
                
             ],
            ]
        );

         $this->add_control(
            'slider_speed',
            [
                'label'        => __('Slider Speed', 'pedro-for-elementor-addons'),
                'type'         => Controls_Manager::SLIDER,
                'description'  => __( 'Slider Speed add', 'pedro-for-elementor-addons' ),
                'default'      => [
                    'size'     => 1000,
                ],
                'range'        => [
					'px'       => [
						'min'  => 0,
						'step' => 100,
                        'max'  => 10000
				],
                
             ],
            ]
        );

        $this->add_control(
			'slider_autoplay',
			[
				'label'        => __( 'AutoPlay', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'on', 'pedro-for-elementor-addons' ),
				'label_off'    => __( 'off', 'pedro-for-elementor-addons' ),
                'description'  => __( 'on off slider autoplay', 'pedro-for-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

        $this->add_control(
			'slider_loop',
			[
				'label'        => __( 'Loop', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'on', 'pedro-for-elementor-addons' ),
				'label_off'    => __( 'off', 'pedro-for-elementor-addons' ),
                'description'  => __( 'on off slide infinity', 'pedro-for-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

         $this->add_control(
			'slider_panigation_click',
			[
				'label'        => __( 'Pagination Click', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'on', 'pedro-for-elementor-addons' ),
				'label_off'    => __( 'off', 'pedro-for-elementor-addons' ),
                'description'  => __( 'on off pagination clickable', 'pedro-for-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

        $this->end_controls_section();


        // Style testimonial
        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Testimonial Card Style', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'testimonial_bg_color',
            [
                'label' => __('Background Color', 'pedro-for-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-testimonial-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonial_padding',
            [
                'label' => __('Padding', 'pedro-for-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .pea-testimonial-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonial_radius',
            [
                'label' => __('Border Radius', 'pedro-for-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pea-testimonial-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'testimonial_box_shadow',
                'label' => __('Box Shadow', 'pedro-for-elementor-addons'),
                'selector' => '{{WRAPPER}} .pea-testimonial-card',
            ]
        );

        $this->end_controls_section();

        // Style content
        $this->start_controls_section(
            'style_content',
            [
                'label' => esc_html__('Description', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'discription_color',
            [
                'label'     => esc_html__('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-testimonial-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .pea-testimonial-text',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'text_shadow',
                'selector' => '{{WRAPPER}} .pea-testimonial-text',
            ]
        );

        $this->end_controls_section();

        // Style Image
        $this->start_controls_section(
            'style_image',
            [
                'label'      => esc_html__('Image', 'pedro-for-elementor-addons'),
                'tab'        => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_width',
            [
                'label'      => esc_html__('Width', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range'      => [
                    'px'     => ['min' => 20, 'max' => 200],
                ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pea-avatar' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_height',
            [
                'label'      => esc_html__('Height', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range'      => [
                    'px'     => ['min' => 20, 'max' => 200],
                ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pea-avatar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_radius',
            [
                'label'      => esc_html__('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px'     => ['min' => 20, 'max' => 200],
                ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pea-avatar' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Name
        $this->start_controls_section(
            'style_name',
            [
                'label'      => esc_html__('Name', 'pedro-for-elementor-addons'),
                'tab'        => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label'     => esc_html__('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-meta-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'selector' => '{{WRAPPER}} .pea-meta-name',
            ]
        );

        $this->end_controls_section();

        // Style Designation
        $this->start_controls_section(
            'designation_section',
            [
                'label' => esc_html__('Designation', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'designation_color',
            [
                'label'     => esc_html__('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-meta-designation' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'designation_typography',
                'selector' => '{{WRAPPER}} .pea-meta-designation',
            ]
        );

        $this->end_controls_section();

        // Style Pagination
        $this->start_controls_section(
            'pagination_section',
            [
                'label' => esc_html__('Pagination', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label'     => esc_html__('Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_size',
            [
                'label'      => esc_html__('Size', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px'     => ['min' => 5, 'max' => 200],
                ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 12,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pea-swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'pagination_margin_top',
            [
                'label'      => esc_html__('Margin Top', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px'     => ['min' => 0]
                ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 16,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pea-swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void
    {
        $settings         = $this->get_settings_for_display();
        $testimonial_list = $settings['testimonial_list'];

    ?>
        <div class="pea-testimonial-wrapper">
            <div class="swiper pea-testimonial-slider" 
                id="pea-slider-<?php echo esc_attr( $this->get_id() ); ?>"
                data-slidestoshow="<?php echo esc_attr( $settings['slider_desktop_item'] ['size'] ); ?>"
                data-desktop-small-items="<?php echo esc_attr( $settings['slider_small_desktop_items'] ['size'] ); ?>"
                data-tablet-items="<?php echo esc_attr( $settings['slider_tablet_item'] ['size'] ); ?>"
                data-mobile-items="<?php echo esc_attr( $settings['slider_mobile_item'] ['size'] ); ?>"
                data-mobile-small-items="<?php echo esc_attr( $settings['slider_small_mobile_items'] ['size'] ); ?>"
                data-spacebetween-items="<?php echo esc_attr( $settings['slider_spacebetween'] ['size'] ); ?>"
                data-speed="<?php echo esc_attr( $settings['slider_speed'] ['size'] ); ?>"
                data-autoplay="<?php echo esc_attr( $settings['slider_autoplay']); ?>"
                data-loop="<?php echo esc_attr( $settings['slider_loop']); ?>"
                data-pagination-click="<?php echo esc_attr( $settings['slider_panigation_click']); ?>"
                >
                <div class="swiper-wrapper">
                    <?php foreach ($testimonial_list as $item) : ?>
                        <div class="swiper-slide">
                            <div class="pea-testimonial-card">

                                <?php if (! empty($settings['discription_switch'])) : ?>
                                    <p class="pea-testimonial-text">
                                        <?php echo esc_html($item['discription']); ?>
                                    </p>
                                <?php endif; ?>

                                <div class="pea-testimonial-meta">
                                    <?php if (! empty($settings['image_switch'])) : ?>
                                        <img class="pea-avatar"
                                            src="<?php echo esc_url($item['image']['url']); ?>"
                                            alt="<?php echo esc_attr($item['name']); ?>">
                                    <?php endif; ?>

                                    <div class="pea-meta-info">
                                        <?php if (! empty($settings['name_switch'])) : ?>
                                            <strong class="pea-meta-name">
                                                <?php echo esc_html($item['name']); ?>
                                            </strong>
                                        <?php endif; ?>

                                        <?php if (! empty($settings['designation_switch'])) : ?>
                                            <small class="pea-meta-designation">
                                                <?php echo esc_html($item['designation']); ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Pagination -->
            <?php if (! empty($settings['pagination_switch'])) : ?>
                <div class="pea-swiper-pagination"></div>
            <?php endif; ?>
        </div>
<?php
    }
}
