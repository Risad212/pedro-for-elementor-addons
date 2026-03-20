<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit;

class Post extends Widget_Base {

    public function get_name(): string {
        return 'pedroea_post';
    }

    public function get_title(): string {
        return __( 'Post', 'pedro-for-elementor-addons' );
    }

    public function get_icon(): string {
        return 'eicon-post-list pedro-elementor-icon';
    }

    public function get_categories(): array {
        return [ 'pedroea' ];
    }

    public function get_keywords(): array {
        return [ 'post', 'blog', 'post grid', 'articles', 'news' ];
    }

    protected function register_controls(): void {

        $this->start_controls_section(
            'section_query',
            [
                'label' => __( 'Query Settings', 'pedro-for-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'   => __( 'Posts Per Page', 'pedro-for-elementor-addons' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 3,
                'min'     => 1,
                'max'     => 12,
            ]
        );

        $this->add_control(
            'post_category',
            [
                'label'       => __( 'Category', 'pedro-for-elementor-addons' ),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'options'     => $this->get_post_categories(),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'             => __( 'Order By', 'pedro-for-elementor-addons' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'date',
                'options'           => [
                    'date'          => __( 'Date', 'pedro-for-elementor-addons' ),
                    'title'         => __( 'Title', 'pedro-for-elementor-addons' ),
                    'modified'      => __( 'Last Modified', 'pedro-for-elementor-addons' ),
                    'comment_count' => __( 'Comment Count', 'pedro-for-elementor-addons' ),
                    'rand'          => __( 'Random', 'pedro-for-elementor-addons' ),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'    => __( 'Order', 'pedro-for-elementor-addons' ),
                'type'     => Controls_Manager::SELECT,
                'default'  => 'DESC',
                'options'  => [
                    'DESC' => __( 'Descending', 'pedro-for-elementor-addons' ),
                    'ASC'  => __( 'Ascending', 'pedro-for-elementor-addons' ),
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_layout',
            [
                'label' => __( 'Layout', 'pedro-for-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'          => __( 'Columns', 'pedro-for-elementor-addons' ),
                'type'           => Controls_Manager::NUMBER,
                'default'        => 3,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'min'            => 1,
                'max'            => 6,
                'step'           => 1,
                'selectors'      => [
                    '{{WRAPPER}} .pedroea-post-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label'        => __( 'Show Featured Image', 'pedro-for-elementor-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'pedro-for-elementor-addons' ),
                'label_off'    => __( 'No', 'pedro-for-elementor-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label'        => __( 'Show Author', 'pedro-for-elementor-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'pedro-for-elementor-addons' ),
                'label_off'    => __( 'No', 'pedro-for-elementor-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label'        => __( 'Show Date', 'pedro-for-elementor-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'pedro-for-elementor-addons' ),
                'label_off'    => __( 'No', 'pedro-for-elementor-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label'        => __( 'Show Excerpt', 'pedro-for-elementor-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'pedro-for-elementor-addons' ),
                'label_off'    => __( 'No', 'pedro-for-elementor-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'            => __( 'Excerpt Length (words)', 'pedro-for-elementor-addons' ),
                'type'             => Controls_Manager::NUMBER,
                'default'          => 20,
                'min'              => 5,
                'max'              => 100,
                'condition'        => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label'        => __( 'Show Read More Button', 'pedro-for-elementor-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'pedro-for-elementor-addons' ),
                'label_off'    => __( 'No', 'pedro-for-elementor-addons' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'              => __( 'Read More Text', 'pedro-for-elementor-addons' ),
                'type'               => Controls_Manager::TEXT,
                'default'            => __( 'Read More', 'pedro-for-elementor-addons' ),
                'condition'          => [
                    'show_read_more' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_image_settings',
            [
                'label'          => __( 'Image', 'pedro-for-elementor-addons' ),
                'tab'            => Controls_Manager::TAB_CONTENT,
                'condition'      => [
                    'show_image' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'image_height',
            [
                'label'        => __( 'Image Height', 'pedro-for-elementor-addons' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'range'        => [
                    'px'       => [
                        'min'  => 100,
                        'max'  => 600,
                        'step' => 10,
                    ],
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 260,
                ],
                'selectors'    => [
                    '{{WRAPPER}} .pedroea-post-thumbnail' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => __( 'Image Border Radius', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-post-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_hover_effect',
            [
                'label'     => __( 'Hover Effect', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'zoom',
                'options'   => [
                    'none'  => __( 'None', 'pedro-for-elementor-addons' ),
                    'zoom'  => __( 'Zoom In', 'pedro-for-elementor-addons' ),
                    'fade'  => __( 'Fade', 'pedro-for-elementor-addons' ),
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_card',
            [
                'label' => __( 'Card', 'pedro-for-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background_color',
            [
                'label'     => __( 'Background Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pedroea-post-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'card_gap',
            [
                'label'        => __( 'Column Gap', 'pedro-for-elementor-addons' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 60,
                        'step' => 2,
                    ],
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 24,
                ],
                'selectors'    => [
                    '{{WRAPPER}} .pedroea-post-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'card_padding',
            [
                'label'      => __( 'Content Padding', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [
                    'top'    => 20,
                    'right'  => 24,
                    'bottom' => 28,
                    'left'   => 24,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border',
                'label'    => __( 'Border', 'pedro-for-elementor-addons' ),
                'selector' => '{{WRAPPER}} .pedroea-post-card',
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label'      => __( 'Border Radius', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => 12,
                    'right'  => 12,
                    'bottom' => 12,
                    'left'   => 12,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-post-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_box_shadow',
                'label'    => __( 'Box Shadow', 'pedro-for-elementor-addons' ),
                'selector' => '{{WRAPPER}} .pedroea-post-card',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_meta',
            [
                'label' => __( 'Meta (Author & Date)', 'pedro-for-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label'     => __( 'Text Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6b7280',
                'selectors' => [
                    '{{WRAPPER}} .pedroea-post-meta'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pedroea-post-meta svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'meta_typography',
                'label'    => __( 'Typography', 'pedro-for-elementor-addons' ),
                'selector' => '{{WRAPPER}} .pedroea-post-meta',
            ]
        );

        $this->add_control(
            'meta_spacing',
            [
                'label'      => __( 'Bottom Spacing', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px'     => [ 'min' => 0, 'max' => 40 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 10 ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-post-meta-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'style_title',
            [
                'label' => __( 'Title', 'pedro-for-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __( 'Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pedroea-post-title'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .pedroea-post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => __( 'Hover Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .pedroea-post-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => __( 'Typography', 'pedro-for-elementor-addons' ),
                'selector' => '{{WRAPPER}} .pedroea-post-title',
            ]
        );

        $this->add_control(
            'title_spacing',
            [
                'label'      => __( 'Bottom Spacing', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px'     => [ 'min' => 0, 'max' => 40 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 12 ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-post-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'   => __( 'HTML Tag', 'pedro-for-elementor-addons' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h2'  => 'H2',
                    'h3'  => 'H3',
                    'h4'  => 'H4',
                    'h5'  => 'H5',
                    'h6'  => 'H6',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_excerpt',
            [
                'label'     => __( 'Excerpt', 'pedro-for-elementor-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_excerpt' => 'yes' ],
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'     => __( 'Color', 'pedro-for-elementor-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6b7280',
                'selectors' => [
                    '{{WRAPPER}} .pedroea-post-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'excerpt_typography',
                'label'    => __( 'Typography', 'pedro-for-elementor-addons' ),
                'selector' => '{{WRAPPER}} .pedroea-post-excerpt',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_read_more',
            [
                'label'     => __( 'Read More Button', 'pedro-for-elementor-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_read_more' => 'yes' ],
            ]
        );

        $this->start_controls_tabs( 'read_more_tabs' );

            $this->start_controls_tab(
                'read_more_normal',
                [ 'label' => __( 'Normal', 'pedro-for-elementor-addons' ) ]
            );

                $this->add_group_control(
                    Group_Control_Typography::get_type(),
                    [
                        'name'     => 'read_more_typography',
                        'label'    => __( 'Typography', 'pedro-for-elementor-addons' ),
                        'selector' => '{{WRAPPER}} .pedroea-read-more',
                    ]
                );

                $this->add_control(
                    'read_more_color',
                    [
                        'label'     => __( 'Text Color', 'pedro-for-elementor-addons' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .pedroea-read-more' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'read_more_bg',
                    [
                        'label'     => __( 'Background Color', 'pedro-for-elementor-addons' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#000000',
                        'selectors' => [
                            '{{WRAPPER}} .pedroea-read-more' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab(
                'read_more_hover',
                [ 'label' => __( 'Hover', 'pedro-for-elementor-addons' ) ]
            );

                $this->add_control(
                    'read_more_hover_color',
                    [
                        'label'     => __( 'Text Color', 'pedro-for-elementor-addons' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .pedroea-read-more:hover' => 'color: {{VALUE}};',
                        ],
                    ]
                );

                $this->add_control(
                    'read_more_hover_bg',
                    [
                        'label'     => __( 'Background Color', 'pedro-for-elementor-addons' ),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '#333333',
                        'selectors' => [
                            '{{WRAPPER}} .pedroea-read-more:hover' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'read_more_margin_top',
            [
                'label'      => __( 'Margin Top', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                        'px' => [ 'min' => 0, 'max' => 60 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 0 ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-read-more' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_control(
            'read_more_padding',
            [
                'label'      => __( 'Padding', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [
                    'top'    => 10,
                    'right'  => 20,
                    'bottom' => 10,
                    'left'   => 20,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_control(
            'read_more_border_radius',
            [
                'label'      => __( 'Border Radius', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => 6,
                    'right'  => 6,
                    'bottom' => 6,
                    'left'   => 6,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .pedroea-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_transition',
            [
                'label'        => __( 'Transition Duration (s)', 'pedro-for-elementor-addons' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 's' ],
                'range'        => [
                    's'        => [
                        'min'  => 0,
                        'max'  => 2,
                        'step' => 0.1,
                    ],
                ],
                'default'      => [
                    'unit'     => 's',
                    'size'     => 0.2,
                ],
                'selectors'    => [
                    '{{WRAPPER}} .pedroea-read-more' => 'transition: background {{SIZE}}{{UNIT}} ease, color {{SIZE}}{{UNIT}} ease;',
                ],
                'separator'    => 'before',
            ]
        );

        $this->end_controls_section();
    }

    /**
     *  helper function post categories
     */
    private function get_post_categories(): array {
        $categories = get_terms( [ 'taxonomy' => 'category', 'hide_empty' => false ] );
        $options    = [];
        if ( ! is_wp_error( $categories ) ) {
            foreach ( $categories as $category ) {
                $options[ $category->term_id ] = $category->name;
            }
        }
        return $options;
    }

    /**
     *  helper function post excerpt
     */
    private function get_trimmed_excerpt( int $post_id, int $length ): string {
        $post    = get_post( $post_id );
        $excerpt = $post->post_excerpt ?: $post->post_content;
        $excerpt = strip_shortcodes( $excerpt );
        $excerpt = wp_strip_all_tags( $excerpt );
        return wp_trim_words( $excerpt, $length, '...' );
    }


    protected function render(): void {
        $settings = $this->get_settings_for_display();

        $query_args = [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => (int) $settings['posts_per_page'],
            'orderby'        => $settings['orderby'],
            'order'          => $settings['order'],
        ];

        if ( ! empty( $settings['post_category'] ) ) {
            $query_args['category__in'] = array_map( 'intval', (array) $settings['post_category'] );
        }

        $query = new \WP_Query( $query_args );

        if ( ! $query->have_posts() ) {
            echo '<p class="pedroea-no-posts">' . esc_html__( 'No posts found.', 'pedro-for-elementor-addons' ) . '</p>';
            return;
        }

        $title_tag    = ! empty( $settings['title_tag'] ) ? $settings['title_tag'] : 'h3';
        $allowed_tags = [ 'h2', 'h3', 'h4', 'h5', 'h6' ];
        if ( ! in_array( $title_tag, $allowed_tags, true ) ) {
            $title_tag = 'h3';
        }

        $hover_class = ! empty( $settings['image_hover_effect'] ) ? 'pedroea-img-hover-' . $settings['image_hover_effect'] : '';

        ?>

        <div class="pedroea-post-grid <?php echo esc_attr( $hover_class ); ?>">
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>

            <article class="pedroea-post-card">

                <?php if ( 'yes' === $settings['show_image'] && has_post_thumbnail() ) : ?>
                    <div class="pedroea-thumbnail-wrap">
                        <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                            <?php the_post_thumbnail( 'large', [ 'class' => 'pedroea-post-thumbnail', 'alt' => get_the_title() ] ); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="pedroea-post-content">

                    <?php if ( 'yes' === $settings['show_author'] || 'yes' === $settings['show_date'] ) : ?>
                        <div class="pedroea-post-meta-wrap">

                            <?php if ( 'yes' === $settings['show_author'] ) : ?>
                                <span class="pedroea-post-meta pedroea-post-author">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                                    <?php echo esc_html__( 'By', 'pedro-for-elementor-addons' ) . ' ' . esc_html( get_the_author() ); ?>
                                </span>
                            <?php endif; ?>

                            <?php if ( 'yes' === $settings['show_date'] ) : ?>
                                <span class="pedroea-post-meta pedroea-post-date">
                                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 4h-1V2h-2v2H8V2H6v2H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/></svg>
                                    <?php echo esc_html( get_the_date( 'M, d Y' ) ); ?>
                                </span>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                    <<?php echo esc_attr( $title_tag ); ?> class="pedroea-post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </<?php echo esc_attr( $title_tag ); ?>>

                    <?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
                        <p class="pedroea-post-excerpt">
                            <?php echo esc_html( $this->get_trimmed_excerpt( get_the_ID(), (int) $settings['excerpt_length'] ) ); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ( 'yes' === $settings['show_read_more'] && ! empty( $settings['read_more_text'] ) ) : ?>
                        <a href="<?php the_permalink(); ?>" class="pedroea-read-more">
                            <?php echo esc_html( $settings['read_more_text'] ); ?>
                        </a>
                    <?php endif; ?>

                </div>

            </article>

        <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <?php
    }
}