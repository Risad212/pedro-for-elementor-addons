<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

if (! defined('ABSPATH')) {
    exit;
}

class Video_Popup extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_video_popup';
    }

    public function get_title(): string
    {
        return __('Video Popup', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-youtube pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['video', 'popup', 'youtube', 'vimeo', 'lightbox', 'play'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Video', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'video_type',
            [
                'label'   => __('Video Type', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => __('YouTube', 'pedro-for-elementor-addons'),
                    'vimeo'   => __('Vimeo', 'pedro-for-elementor-addons'),
                    'self'    => __('Self Hosted', 'pedro-for-elementor-addons'),
                ],
            ]
        );

        $this->add_control(
            'youtube_url',
            [
                'label'       => __('YouTube URL', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'placeholder' => __('https://www.youtube.com/watch?v=...', 'pedro-for-elementor-addons'),
                'condition'   => ['video_type' => 'youtube'],
                'dynamic'     => ['active' => true],
            ]
        );

        $this->add_control(
            'vimeo_url',
            [
                'label'       => __('Vimeo URL', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('https://vimeo.com/...', 'pedro-for-elementor-addons'),
                'condition'   => ['video_type' => 'vimeo'],
                'dynamic'     => ['active' => true],
            ]
        );

        $this->add_control(
            'self_url',
            [
                'label'       => __('Video File URL', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::MEDIA,
                'media_type'  => 'video',
                'condition'   => ['video_type' => 'self'],
                'dynamic'     => ['active' => true],
            ]
        );

        $this->add_control(
            'self_poster',
            [
                'label'     => __('Poster Image', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::MEDIA,
                'condition' => ['video_type' => 'self'],
                'dynamic'   => ['active' => true],
            ]
        );

        $this->add_control(
            'thumbnail',
            [
                'label'   => __('Custom Thumbnail', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::MEDIA,
                'separator' => 'before',
                'dynamic'   => ['active' => true],
            ]
        );

        $this->add_control(
            'title',
            [
                'label'   => __('Title', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'separator' => 'before',
                'dynamic'   => ['active' => true],
            ]
        );

        $this->add_control(
            'play_icon',
            [
                'label'   => __('Custom Play Icon', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => ['active' => true],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_thumb',
            [
                'label' => __('Thumbnail', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'thumb_height',
            [
                'label'      => __('Height', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range'      => [
                    'px' => ['min' => 100, 'max' => 700],
                    'vh' => ['min' => 10, 'max' => 100],
                ],
                'default'    => ['unit' => 'px', 'size' => 400],
                'selectors'  => [
                    '{{WRAPPER}} .pea-video-thumb' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'thumb_border',
                'selector' => '{{WRAPPER}} .pea-video-wrap',
            ]
        );

        $this->add_responsive_control(
            'thumb_border_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-video-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .pea-video-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label'     => __('Overlay Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(0,0,0,0.4)',
                'selectors' => [
                    '{{WRAPPER}} .pea-video-overlay' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_play',
            [
                'label' => __('Play Button', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'play_btn_color',
            [
                'label'     => __('Icon Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-video-play-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'play_btn_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(0,0,0,0.7)',
                'selectors' => [
                    '{{WRAPPER}} .pea-video-play-btn' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'play_btn_size',
            [
                'label'      => __('Size', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => ['px' => ['min' => 30, 'max' => 120]],
                'default'    => ['unit' => 'px', 'size' => 70],
                'selectors'  => [
                    '{{WRAPPER}} .pea-video-play-btn' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'play_btn_hover_bg',
            [
                'label'     => __('Hover Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-video-play-btn:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrap', 'class', 'pea-video-wrap');
        $this->add_render_attribute('wrap', 'class', 'pea-video-type-' . $settings['video_type']);

        $video_url = '';
        $id       = '';
        if ('youtube' === $settings['video_type'] && $settings['youtube_url']) {
            preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $settings['youtube_url'], $m);
            $id = $m[1] ?? '';
            if ('' === $id) {
                echo '<div class="pedroea-placeholder">' . esc_html__('Invalid YouTube URL.', 'pedro-for-elementor-addons') . '</div>';
                return;
            }
            $video_url = 'https://www.youtube.com/embed/' . $id . '?autoplay=1';
        } elseif ('vimeo' === $settings['video_type'] && $settings['vimeo_url']) {
            preg_match('/vimeo\.com\/(\d+)/', $settings['vimeo_url'], $m);
            $id = $m[1] ?? '';
            if ('' === $id) {
                echo '<div class="pedroea-placeholder">' . esc_html__('Invalid Vimeo URL.', 'pedro-for-elementor-addons') . '</div>';
                return;
            }
            $video_url = 'https://player.vimeo.com/video/' . $id . '?autoplay=1';
        } elseif ('self' === $settings['video_type'] && ! empty($settings['self_url']['url'])) {
            $video_url = $settings['self_url']['url'];
        }

        $this->add_render_attribute('wrap', 'data-video', $video_url);
        $thumb_url = '';

        if (! empty($settings['thumbnail']['url'])) {
            $thumb_url = $settings['thumbnail']['url'];
        } elseif ('self' === $settings['video_type'] && ! empty($settings['self_poster']['url'])) {
            $thumb_url = $settings['self_poster']['url'];
        } elseif ('youtube' === $settings['video_type'] && ! empty($id)) {
            $thumb_url = 'https://img.youtube.com/vi/' . $id . '/maxresdefault.jpg';
        } else {
            $thumb_url = '';
        }
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <div class="pea-video-thumb"<?php echo $thumb_url ? ' style="background-image: url(\'' . esc_url($thumb_url) . '\');"' : ''; ?>>
                <div class="pea-video-overlay"></div>
                <div class="pea-video-play-btn">
                    <?php if (! empty($settings['play_icon']['url'])) : ?>
                        <img src="<?php echo esc_url($settings['play_icon']['url']); ?>" alt="" class="pea-video-play-icon">
                    <?php else : ?>
                        <svg class="pea-video-play-icon" viewBox="0 0 24 24" width="28" height="28" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    <?php endif; ?>
                </div>
                <?php if ($settings['title']) : ?>
                    <div class="pea-video-title"><?php echo esc_html($settings['title']); ?></div>
                <?php endif; ?>
            </div>
            <div class="pea-video-modal">
                <div class="pea-video-modal-content">
                    <span class="pea-video-close">&times;</span>
                    <div class="pea-video-iframe-wrap">
                        <?php if ('self' === $settings['video_type']) : ?>
                            <video controls preload="none" style="width:100%;height:100%;object-fit:contain;">
                                <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                            </video>
                        <?php else : ?>
                            <iframe src="" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
