<?php
namespace PedroEA\Widgets;

use \Elementor\Controls_Manager;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Custom_CSS {

    public function __construct() {
        add_action( 'elementor/element/after_section_end', [ $this, 'add_custom_css_controls' ], 10, 3 );
        add_action( 'elementor/element/parse_css', [ $this, 'add_custom_css' ], 10, 2 ); 

    }

    public function add_custom_css_controls( $element, $section_id, $args ) {
        
        if ( '_section_responsive' === $section_id ) {
            
            $element->start_controls_section(
                'section_custom_css',
                [
                    'label'      => __( 'Pedro Custom CSS', 'pedro-for-elementor-addons' ),
                    'tab'        => Controls_Manager::TAB_ADVANCED,
                ]
            );

            $element->add_control(
                'custom_css',
                [
                    'type'        => Controls_Manager::CODE,
                    'label'       => __( 'Pedro Custom CSS', 'pedro-for-elementor-addons' ),
                    'language'    => 'css',
                    'render_type' => 'ui',
                    'show_label'  => false,
                    'separator'   => 'none',
                ]
            );

            $element->end_controls_section();
        }
    }

    public function add_custom_css( $post_css, $element ) {
        $element_settings = $element->get_settings();

        if ( empty( $element_settings['custom_css'] ) ) {
            return;
        }

        $css = trim( $element_settings['custom_css'] );

        if ( empty( $css ) ) {
            return;
        }

        $css = str_replace( 'selector', $post_css->get_element_unique_selector( $element ), $css );

        $post_css->get_stylesheet()->add_raw_css( $css );
    }
}

