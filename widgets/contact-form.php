<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit;

class Contact_Form extends Widget_Base {

    public function get_name()
    {
        return 'pedroea_contact_form';
    }


    public function get_title(): string
    {
        return __( 'Contact Form 7', 'pedro-for-elementor-addons' );
    }


    public function get_icon(): string
    {
        return 'eicon-form-horizontal pedro-elementor-icon';
    }


    public function get_categories(): array
    {
        return [ 'pedroea' ];
    }


    public function get_keywords(): array
    {
        return [ 'contact form', 'cf7', 'form', 'wpcf7' ];
    }

    private function get_cf7_forms(): array {
        $list = [ '' => __( '— Select a Form —', 'pedro-for-elementor-addons' ) ];

        if ( ! function_exists( 'wpcf7_contact_form' ) ) {
            return $list;
        }

        $forms = get_posts( [
            'post_type'      => 'wpcf7_contact_form',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ] );

        foreach ( $forms as $form ) {
            $list[ $form->ID ] = $form->post_title;
        }

        return $list;
    }

    protected function register_controls(): void {

        $this->start_controls_section( 'section_form', [
            'label'       => __( 'Form', 'pedro-for-elementor-addons' ),
            'tab'         => Controls_Manager::TAB_CONTENT,
        ] );

            $this->add_control( 'form_id', [
                'label'   => __( 'Select Form', 'pedro-for-elementor-addons' ),
                'type'    => Controls_Manager::SELECT,
                'options' => $this->get_cf7_forms(),
                'default' => '',
            ] );

        $this->end_controls_section();


        $this->start_controls_section( 'section_style_wrapper', [
            'label'         => __( 'Wrapper', 'pedro-for-elementor-addons' ),
            'tab'           => Controls_Manager::TAB_STYLE,
            'condition'     => [ 'form_id!' => '' ],
        ] );

            $this->add_control( 'wrapper_bg', [
                'label'     => __( 'Background', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .cf7-wrap' => 'background-color: {{VALUE}};' ],
            ] );

            $this->add_responsive_control( 'wrapper_padding', [
                'label'      => __( 'Padding', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [ '{{WRAPPER}} .cf7-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ] );

            $this->add_group_control( Group_Control_Border::get_type(), [
                'name'       => 'wrapper_border',
                'selector'   => '{{WRAPPER}} .cf7-wrap',
            ] );

            $this->add_control( 'wrapper_radius', [
                'label'      => __( 'Border Radius', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [ '{{WRAPPER}} .cf7-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ] );

            $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
                'name'      => 'wrapper_shadow',
                'selector'  => '{{WRAPPER}} .cf7-wrap',
            ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_style_labels', [
            'label'        => __( 'Labels', 'pedro-for-elementor-addons' ),
            'tab'          => Controls_Manager::TAB_STYLE,
            'condition'    => [ 'form_id!' => '' ],
        ] );

            $this->add_control( 'label_color', [
                'label'     => __( 'Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .cf7-wrap label' => 'color: {{VALUE}};' ],
            ] );

            $this->add_group_control( Group_Control_Typography::get_type(), [
                'name'      => 'label_typography',
                'selector'  => '{{WRAPPER}} .cf7-wrap label',
            ] );

            $this->add_responsive_control( 'label_spacing', [
                'label'      => __( 'Bottom Spacing', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
                'selectors'  => [ '{{WRAPPER}} .wpcf7-form-control-wrap' => 'margin-top: {{SIZE}}{{UNIT}}; display: block;' ],
            ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_style_inputs', [
            'label'     => __( 'Input Fields', 'pedro-for-elementor-addons' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'form_id!' => '' ],
        ] );

            $this->add_responsive_control( 'input_width', [
                'label'      => __( 'Width', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px'     => [ 'min' => 80,  'max' => 1200 ],
                    '%'      => [ 'min' => 10,  'max' => 100  ],
                ],
                'default'    => [ 'unit' => '%', 'size' => 100 ],
                'selectors'  => [
                    '{{WRAPPER}} .cf7-wrap .wpcf7-form-control-wrap input' => 'display: block; width: {{SIZE}}{{UNIT}}; box-sizing: border-box;',
                ],
            ] );

            $this->add_control( 'input_bg', [
                'label'     => __( 'Background', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .cf7-wrap input:not([type=submit])' => 'background-color: {{VALUE}};' ],
            ] );

            $this->add_control( 'input_color', [
                'label'     => __( 'Text Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .cf7-wrap input:not([type=submit])' => 'color: {{VALUE}};' ],
            ] );

            $this->add_control( 'input_placeholder_color', [
                'label'     => __( 'Placeholder Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .cf7-wrap input:not([type=submit])::placeholder' => 'color: {{VALUE}};' ],
            ] );

            $this->add_group_control( Group_Control_Typography::get_type(), [
                'name'      => 'input_typography',
                'selector'  => '{{WRAPPER}} .cf7-wrap input:not([type=submit])',
            ] );

            $this->add_group_control( Group_Control_Border::get_type(), [
                'name'      => 'input_border',
                'selector'  => '{{WRAPPER}} .cf7-wrap input:not([type=submit])',
                'separator' => 'before',
            ] );

            $this->add_control( 'input_radius', [
                'label'      => __( 'Border Radius', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [ '{{WRAPPER}} .cf7-wrap input:not([type=submit])' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ] );

            $this->add_responsive_control( 'input_padding', [
                'label'      => __( 'Padding', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors'  => [ '{{WRAPPER}} .cf7-wrap input:not([type=submit])' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ] );

            $this->add_responsive_control( 'input_gap', [
                'label'      => __( 'Gap Between Fields', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
                'selectors'  => [ '{{WRAPPER}} .cf7-wrap .wpcf7-form-control-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}}; display: block;' ],
            ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_style_textarea', [
            'label'     => __( 'Textarea', 'pedro-for-elementor-addons' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [ 'form_id!' => '' ],
        ] );

            $this->add_responsive_control( 'textarea_width', [
                'label'      => __( 'Width', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [ 'min' => 80,  'max' => 1200 ],
                    '%'  => [ 'min' => 10,  'max' => 100  ],
                ],
                'default'    => [ 'unit' => '%', 'size' => 100 ],
                'selectors'  => [ '{{WRAPPER}} .cf7-wrap textarea' => 'display: block; width: {{SIZE}}{{UNIT}}; box-sizing: border-box;' ],
            ] );

            $this->add_control( 'textarea_bg', [
                'label'     => __( 'Background', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .cf7-wrap textarea' => 'background-color: {{VALUE}};' ],
            ] );

            $this->add_control( 'textarea_color', [
                'label'     => __( 'Text Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .cf7-wrap textarea' => 'color: {{VALUE}};' ],
            ] );

            $this->add_control( 'textarea_placeholder_color', [
                'label'     => __( 'Placeholder Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .cf7-wrap textarea::placeholder' => 'color: {{VALUE}};' ],
            ] );

            $this->add_group_control( Group_Control_Typography::get_type(), [
                'name'      => 'textarea_typography',
                'selector'  => '{{WRAPPER}} .cf7-wrap textarea',
            ] );

            $this->add_group_control( Group_Control_Border::get_type(), [
                'name'      => 'textarea_border',
                'selector'  => '{{WRAPPER}} .cf7-wrap textarea',
                'separator' => 'before',
            ] );

            $this->add_control( 'textarea_radius', [
                'label'      => __( 'Border Radius', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [ '{{WRAPPER}} .cf7-wrap textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ] );

            $this->add_responsive_control( 'textarea_padding', [
                'label'      => __( 'Padding', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors'  => [ '{{WRAPPER}} .cf7-wrap textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ] );

            $this->add_responsive_control( 'textarea_height', [
                'label'      => __( 'Height', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 60, 'max' => 600 ] ],
                'selectors'  => [ '{{WRAPPER}} .cf7-wrap textarea' => 'height: {{SIZE}}{{UNIT}};' ],
            ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_style_button', [
            'label'        => __( 'Submit Button', 'pedro-for-elementor-addons' ),
            'tab'          => Controls_Manager::TAB_STYLE,
            'condition'    => [ 'form_id!' => '' ],
        ] );

            $this->start_controls_tabs( 'button_tabs' );

            $this->start_controls_tab( 'button_normal', [
                'label'         => __( 'Normal', 'pedro-for-elementor-addons' ),
            ] );

                $this->add_control( 'btn_bg', [
                    'label'     => __( 'Background', 'pedro-for-elementor-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [ '{{WRAPPER}} .cf7-wrap input[type=submit]' => 'background-color: {{VALUE}};' ],
                ] );

                $this->add_control( 'btn_color', [
                    'label'     => __( 'Text Color', 'pedro-for-elementor-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [ '{{WRAPPER}} .cf7-wrap input[type=submit]' => 'color: {{VALUE}};' ],
                ] );

                $this->add_group_control( Group_Control_Border::get_type(), [
                    'name'      => 'btn_border',
                    'selector'  => '{{WRAPPER}} .cf7-wrap input[type=submit]',
                ] );

            $this->end_controls_tab();

            $this->start_controls_tab( 'button_hover', [
                'label' => __( 'Hover', 'pedro-for-elementor-addons' ),
            ] );

                $this->add_control( 'btn_bg_hover', [
                    'label'     => __( 'Background', 'pedro-for-elementor-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [ '{{WRAPPER}} .cf7-wrap input[type=submit]:hover' => 'background-color: {{VALUE}};' ],
                ] );

                $this->add_control( 'btn_color_hover', [
                    'label'     => __( 'Text Color', 'pedro-for-elementor-addons' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [ '{{WRAPPER}} .cf7-wrap input[type=submit]:hover' => 'color: {{VALUE}};' ],
                ] );

            $this->end_controls_tab();

            $this->end_controls_tabs();

            $this->add_group_control( Group_Control_Typography::get_type(), [
                'name'      => 'btn_typography',
                'selector'  => '{{WRAPPER}} .cf7-wrap input[type=submit]',
                'separator' => 'before',
            ] );

            $this->add_control( 'btn_radius', [
                'label'      => __( 'Border Radius', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [ '{{WRAPPER}} .cf7-wrap input[type=submit]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ] );

            $this->add_responsive_control( 'btn_padding', [
                'label'      => __( 'Padding', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors'  => [ '{{WRAPPER}} .cf7-wrap input[type=submit]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ] );

            $this->add_responsive_control( 'btn_width', [
                'label'      => __( 'Width', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px'     => [ 'min' => 80,  'max' => 600 ],
                    '%'      => [ 'min' => 10,  'max' => 100 ],
                ],
                'selectors'  => [ '{{WRAPPER}} .cf7-wrap input[type=submit]' => 'width: {{SIZE}}{{UNIT}};' ],
            ] );

            $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
                'name'      => 'btn_shadow',
                'selector'  => '{{WRAPPER}} .cf7-wrap input[type=submit]',
            ] );

        $this->end_controls_section();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $form_id  = absint( $settings['form_id'] ?? 0 );

        if ( ! $form_id ) {
            if ( Plugin::$instance->editor->is_edit_mode() ) {
                echo esc_html__( 'Select a Contact Form 7 form from the panel.', 'pedro-for-elementor-addons' );
            }
            return;
        }

        if ( ! function_exists( 'wpcf7_contact_form' ) ) {
            echo '<p>' . esc_html__( 'Contact Form 7 is not active.', 'pedro-for-elementor-addons' ) . '</p>';
            return;
        }

        echo '<div class="cf7-wrap">';
           echo do_shortcode( '[contact-form-7 id="' . $form_id . '"]' );
        echo '</div>';
    }
}