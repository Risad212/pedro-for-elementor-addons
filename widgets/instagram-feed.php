<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (! defined('ABSPATH')) {
    exit;
}

class Instagram_Feed extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_instagram_feed';
    }

    public function get_title(): string
    {
        return __('Instagram Feed', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-instagram-gallery pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['instagram', 'feed', 'social', 'photos', 'gallery'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Instagram Feed', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'access_token',
            [
                'label'       => __('Access Token', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'description' => __('A valid Instagram Graph API access token with user_media permission.', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'instagram_link_text',
            [
                'label'       => __('Instagram Link Text', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('@ Follow Us', 'pedro-for-elementor-addons'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'instagram_username',
            [
                'label'       => __('Instagram Username', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'label_block' => true,
                'description' => __('Used for the follow link. Leave empty to hide it.', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'posts_count',
            [
                'label'   => __('Images Count', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
                'min'     => 1,
                'max'     => 30,
            ]
        );

        $this->add_control(
            'columns',
            [
                'label'   => __('Columns', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
            ]
        );

        $this->add_control(
            'caption',
            [
                'label'   => __('Show Caption', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'cache_hours',
            [
                'label'      => __('Cache Duration (hours)', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::NUMBER,
                'default'    => 12,
                'min'        => 0,
                'step'       => 1,
                'label_block'=> true,
                'description' => __('How long to cache the feed before refetching.', 'pedro-for-elementor-addons'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Style', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label'      => __('Gap', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 0, 'max' => 40]],
                'default'    => ['unit' => 'px', 'size' => 10],
                'selectors'  => [
                    '{{WRAPPER}} .pea-ig-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-ig-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label'     => __('Link Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7c3aed',
                'selectors' => [
                    '{{WRAPPER}} .pea-ig-follow' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $token = trim((string) ($settings['access_token'] ?? ''));

        $this->add_render_attribute('wrap', 'class', 'pea-instagram');
        $this->add_render_attribute('grid', 'class', 'pea-ig-grid');
        $this->add_render_attribute('grid', 'class', 'pea-ig-cols-' . ($settings['columns'] ?? '3'));
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <?php
            if (empty($token)) {
                if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                    echo '<div class="pea-fb-error">' . esc_html__('Enter an Instagram access token to display your feed.', 'pedro-for-elementor-addons') . '</div>';
                }
            } else {
                $media = $this->fetch_media($token, (int) ($settings['posts_count'] ?? 6), (int) ($settings['cache_hours'] ?? 12));

                if (is_wp_error($media)) {
                    echo '<div class="pea-fb-error">' . esc_html($media->get_error_message()) . '</div>';
                } else {
                    echo '<div ' . $this->get_render_attribute_string('grid') . '>';
                    foreach ($media as $item) {
                        $this->render_item($item, $settings);
                    }
                    echo '</div>';
                }
            }

            if (! empty($settings['instagram_username']) && ! empty($settings['instagram_link_text'])) {
                echo '<a class="pea-ig-follow" href="https://www.instagram.com/' . esc_attr($settings['instagram_username']) . '/" target="_blank" rel="noopener noreferrer">' . esc_html($settings['instagram_link_text']) . '</a>';
            }
            ?>
        </div>
        <?php
    }

    protected function render_item($item, $settings)
    {
        $img   = $item['media_url'] ?? '';
        $link  = $item['permalink'] ?? '';
        $caption = $item['caption'] ?? '';
        ?>
        <a class="pea-ig-item" href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer">
            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr(wp_strip_all_tags($caption)); ?>" loading="lazy">
            <?php if ('yes' === ($settings['caption'] ?? 'yes') && ! empty($caption)) : ?>
                <span class="pea-ig-caption"><?php echo esc_html(wp_trim_words(wp_strip_all_tags($caption), 14)); ?></span>
            <?php endif; ?>
        </a>
        <?php
    }

    /**
     * Fetch recent media from the Instagram Graph API with transient caching.
     *
     * @param string $token
     * @param int    $count
     * @param int    $cache_hours
     * @return array|\WP_Error
     */
    protected function fetch_media($token, $count, $cache_hours)
    {
        $transient_key = 'pedroea_ig_' . md5($token . $count);

        $cached = get_transient($transient_key);
        if (false !== $cached) {
            return $cached;
        }

        $url = add_query_arg(
            [
                'fields'       => 'media_type,media_url,permalink,caption,thumbnail_url',
                'limit'        => max(1, $count),
                'access_token' => $token,
            ],
            'https://graph.instagram.com/me/media'
        );

        $response = wp_remote_get($url, ['timeout' => 15]);

        if (is_wp_error($response)) {
            return new \WP_Error('pedroea_ig_error', __('Instagram feed could not be fetched. Check your connection.', 'pedro-for-elementor-addons'));
        }

        $code = wp_remote_retrieve_response_code($response);
        $body = json_decode(wp_remote_retrieve_body($response), true);

        if (200 !== $code) {
            $msg = isset($body['error']['message']) ? $body['error']['message'] : __('Invalid access token.', 'pedro-for-elementor-addons');
            return new \WP_Error('pedroea_ig_error', sanitize_text_field($msg));
        }

        $media = [];
        foreach ((array) ($body['data'] ?? []) as $item) {
            $media[] = [
                'media_url' => sanitize_url($item['thumbnail_url'] ?? $item['media_url'] ?? ''),
                'permalink' => esc_url_raw($item['permalink'] ?? ''),
                'caption'   => sanitize_text_field($item['caption'] ?? ''),
            ];
        }

        if ($cache_hours > 0) {
            set_transient($transient_key, $media, $cache_hours * HOUR_IN_SECONDS);
        }

        return $media;
    }
}