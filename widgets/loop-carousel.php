<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if (! defined('ABSPATH')) {
    exit;
}

class Loop_Carousel extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_loop_carousel';
    }

    public function get_title(): string
    {
        return __('Loop Carousel', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-posts-carousel pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['loop', 'carousel', 'posts', 'query', 'slider'];
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
                    'date'         => __('Date', 'pedro-for-elementor-addons'),
                    'title'        => __('Title', 'pedro-for-elementor-addons'),
                    'modified'     => __('Modified', 'pedro-for-elementor-addons'),
                    'comment_count'=> __('Comments', 'pedro-for-elementor-addons'),
                    'rand'         => __('Random', 'pedro-for-elementor-addons'),
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
            'slides_per_view',
            [
                'label'   => __('Slides Per View', 'pedro-for-elementor-addons'),
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

        $this->add_responsive_control(
            'space_between',
            [
                'label'      => __('Space Between', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 60]],
                'default'    => ['unit' => 'px', 'size' => 16],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'   => __('Autoplay', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => __('Autoplay Speed (ms)', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 3000,
                'min'       => 500,
                'condition' => ['autoplay' => 'yes'],
            ]
        );

        $this->add_control(
            'loop',
            [
                'label'   => __('Loop', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label'   => __('Arrows', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label'   => __('Pagination', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
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
                'default' => '',
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

        $slides    = (int) ($settings['slides_per_view'] ?? 3);
        $tablet    = (int) ($settings['slides_per_view_tablet'] ?? min(2, $slides));
        $mobile    = (int) ($settings['slides_per_view_mobile'] ?? 1);
        $space     = (int) ($settings['space_between']['size'] ?? 16);
        $tablet_sp = (int) ($settings['space_between_tablet']['size'] ?? $space);
        $mobile_sp = (int) ($settings['space_between_mobile']['size'] ?? $space);

        $wrapper = [
            'data-slides-per-view'        => $slides,
            'data-slides-per-view-tablet' => $tablet,
            'data-slides-per-view-mobile' => $mobile,
            'data-space-between'          => $space,
            'data-space-between-tablet'   => $tablet_sp,
            'data-space-between-mobile'   => $mobile_sp,
            'data-autoplay'               => 'yes' === ($settings['autoplay'] ?? '') ? 'yes' : 'no',
            'data-autoplay-speed'         => (int) ($settings['autoplay_speed'] ?? 3000),
            'data-loop'                   => 'yes' === ($settings['loop'] ?? '') ? 'yes' : 'no',
            'data-arrows'                 => 'yes' === ($settings['show_arrows'] ?? '') ? 'yes' : 'no',
            'data-pagination'             => 'yes' === ($settings['show_pagination'] ?? '') ? 'yes' : 'no',
        ];

        $this->add_render_attribute('wrap', 'class', 'pea-loop-carousel');
        foreach ($wrapper as $key => $value) {
            $this->add_render_attribute('wrap', $key, $value);
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="swiper-slide">
                            <?php $this->render_card($settings); ?>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
            <?php if ('yes' === ($settings['show_arrows'] ?? '')) : ?>
                <div class="pea-carousel-nav">
                    <button class="pea-carousel-prev" aria-label="<?php esc_attr_e('Previous', 'pedro-for-elementor-addons'); ?>"><?php echo $this->get_arrow_icon(); ?></button>
                    <button class="pea-carousel-next" aria-label="<?php esc_attr_e('Next', 'pedro-for-elementor-addons'); ?>"><?php echo $this->get_arrow_icon(); ?></button>
                </div>
            <?php endif; ?>
            <?php if ('yes' === ($settings['show_pagination'] ?? '')) : ?>
                <div class="swiper-pagination"></div>
            <?php endif; ?>
        </div>
        <?php
    }

    protected function render_card($settings)
    {
        ?>
        <article class="pea-loop-card">
            <?php if ('yes' === ($settings['show_thumbnail'] ?? 'yes') && has_post_thumbnail()) : ?>
                <a class="pea-loop-thumb" href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('medium_large'); ?>
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
                    <p class="pea-loop-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
                <?php endif; ?>
            </div>
        </article>
        <?php
    }

    private function get_arrow_icon()
    {
        return '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>';
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
}