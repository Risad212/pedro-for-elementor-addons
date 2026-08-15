<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if (! defined('ABSPATH')) {
    exit;
}

class Loop_Grid extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_loop_grid';
    }

    public function get_title(): string
    {
        return __('Loop Grid', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-posts-grid pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['loop', 'grid', 'posts', 'query', 'blog'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Query', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'post_type',
            [
                'label'   => __('Post Type', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $this->get_post_types(),
            ]
        );

        $this->add_control(
            'posts_count',
            [
                'label'   => __('Posts Count', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
                'min'     => 1,
                'max'     => 50,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => __('Order By', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date'       => __('Date', 'pedro-for-elementor-addons'),
                    'title'      => __('Title', 'pedro-for-elementor-addons'),
                    'modified'   => __('Modified', 'pedro-for-elementor-addons'),
                    'comment_count' => __('Comments', 'pedro-for-elementor-addons'),
                    'rand'       => __('Random', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => __('Order', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => __('Descending', 'pedro-for-elementor-addons'),
                    'ASC'  => __('Ascending', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $categories = get_categories(['hide_empty' => true]);
        $cat_options = [];
        foreach ($categories as $cat) {
            $cat_options[$cat->term_id] = $cat->name;
        }

        $this->add_control(
            'category',
            [
                'label'     => __('Category', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $cat_options,
                'multiple'  => true,
                'condition' => ['post_type' => 'post'],
            ]
        );

        $this->add_control(
            'exclude_current',
            [
                'label'   => __('Exclude Current Post', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_layout',
            [
                'label' => __('Layout', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'   => __('Columns', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
            ]
        );

        $this->add_control(
            'show_thumbnail',
            [
                'label'   => __('Show Thumbnail', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'thumbnail_size',
            [
                'label'     => __('Thumbnail Size', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::SELECT,
                'options'   => $this->get_image_sizes(),
                'default'   => 'large',
                'condition' => ['show_thumbnail' => 'yes'],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'   => __('Show Title', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label'   => __('Show Excerpt', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'     => __('Excerpt Length', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 20,
                'min'       => 5,
                'max'       => 100,
                'condition' => ['show_excerpt' => 'yes'],
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label'   => __('Show Date', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_read_more',
            [
                'label'   => __('Show Read More', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label'     => __('Read More Text', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Read More', 'pedro-for-elementor-addons'),
                'condition' => ['show_read_more' => 'yes'],
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label'   => __('Pagination', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_card',
            [
                'label' => __('Card', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-loop-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border',
                'selector' => '{{WRAPPER}} .pea-loop-card',
            ]
        );

        $this->add_responsive_control(
            'card_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-loop-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-loop-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid_gap',
            [
                'label'      => __('Gap', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 60]],
                'default'    => ['unit' => 'px', 'size' => 20],
                'selectors'  => [
                    '{{WRAPPER}} .pea-loop-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => __('Typography', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Title Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#111827',
                'selectors' => [
                    '{{WRAPPER}} .pea-loop-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .pea-loop-title a',
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'     => __('Excerpt Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6b7280',
                'selectors' => [
                    '{{WRAPPER}} .pea-loop-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .pea-loop-excerpt',
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label'     => __('Date Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#9ca3af',
                'selectors' => [
                    '{{WRAPPER}} .pea-loop-date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_color',
            [
                'label'     => __('Read More Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7c3aed',
                'selectors' => [
                    '{{WRAPPER}} .pea-loop-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $args = [
            'post_type'           => $settings['post_type'] ?? 'post',
            'posts_per_page'      => max(1, (int) ($settings['posts_count'] ?? 6)),
            'post_status'         => 'publish',
            'orderby'             => $settings['orderby'] ?? 'date',
            'order'               => $settings['order'] ?? 'DESC',
            'ignore_sticky_posts' => true,
            'paged'               => get_query_var('paged') ?: 1,
        ];

        if (! empty($settings['category']) && is_array($settings['category'])) {
            $args['category__in'] = array_map('absint', $settings['category']);
        }

        if ('yes' === ($settings['exclude_current'] ?? 'yes')) {
            global $post;
            if ($post) {
                $args['post__not_in'] = [$post->ID];
            }
        }

        if ('rand' === ($settings['orderby'] ?? '')) {
            $args['orderby'] = 'rand';
        }

        $query = new \WP_Query($args);

        if (! $query->have_posts()) {
            return;
        }

        $this->add_render_attribute('wrap', 'class', 'pea-loop-grid');
        $this->add_render_attribute('wrap', 'class', 'pea-loop-cols-' . ($settings['columns'] ?? '3'));
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php $this->render_card($settings); ?>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>

        <?php if ('yes' === ($settings['pagination'] ?? '') && $query->max_num_pages > 1) : ?>
            <nav class="pea-loop-pagination">
                <?php
                echo paginate_links([
                    'total'   => $query->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                ]);
                ?>
            </nav>
        <?php endif; ?>
        <?php
    }

    protected function render_card($settings)
    {
        ?>
        <article class="pea-loop-card">
            <?php if ('yes' === ($settings['show_thumbnail'] ?? 'yes') && has_post_thumbnail()) : ?>
                <a class="pea-loop-thumb" href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail($settings['thumbnail_size'] ?? 'large'); ?>
                </a>
            <?php endif; ?>
            <div class="pea-loop-card-body">
                <?php if ('yes' === ($settings['show_date'] ?? 'yes')) : ?>
                    <span class="pea-loop-date"><?php echo esc_html(get_the_date()); ?></span>
                <?php endif; ?>
                <?php if ('yes' === ($settings['show_title'] ?? 'yes')) : ?>
                    <h3 class="pea-loop-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <?php endif; ?>
                <?php if ('yes' === ($settings['show_excerpt'] ?? 'yes')) : ?>
                    <p class="pea-loop-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), (int) ($settings['excerpt_length'] ?? 20))); ?></p>
                <?php endif; ?>
                <?php if ('yes' === ($settings['show_read_more'] ?? 'yes')) : ?>
                    <a class="pea-loop-more" href="<?php the_permalink(); ?>"><?php echo esc_html($settings['read_more_text'] ?? __('Read More', 'pedro-for-elementor-addons')); ?></a>
                <?php endif; ?>
            </div>
        </article>
        <?php
    }

    private function get_post_types()
    {
        $types = get_post_types(['public' => true], 'objects');
        $options = [];
        foreach ($types as $type) {
            if ('attachment' === $type->name) {
                continue;
            }
            $options[$type->name] = $type->labels->singular_name;
        }
        return $options;
    }

    private function get_image_sizes()
    {
        $sizes = get_intermediate_image_sizes();
        $options = [];
        foreach ($sizes as $size) {
            $options[$size] = $size;
        }
        $options['full'] = 'full';
        return $options;
    }
}