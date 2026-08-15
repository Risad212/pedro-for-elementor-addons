<?php

namespace PedroEA\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (! defined('ABSPATH')) {
    exit;
}

class Login extends Widget_Base
{

    public function get_name()
    {
        return 'pedroea_login';
    }

    public function get_title(): string
    {
        return __('Login', 'pedro-for-elementor-addons');
    }

    public function get_icon(): string
    {
        return 'eicon-lock-user pedro-elementor-icon';
    }

    public function get_categories(): array
    {
        return ['pedroea'];
    }

    public function get_keywords(): array
    {
        return ['login', 'register', 'form', 'user', 'member'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Form', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_labels',
            [
                'label'   => __('Show Labels', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'username_label',
            [
                'label'     => __('Username Label', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Username or Email Address', 'pedro-for-elementor-addons'),
                'condition' => ['show_labels' => 'yes'],
            ]
        );

        $this->add_control(
            'password_label',
            [
                'label'     => __('Password Label', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Password', 'pedro-for-elementor-addons'),
                'condition' => ['show_labels' => 'yes'],
            ]
        );

        $this->add_control(
            'username_placeholder',
            [
                'label'       => __('Username Placeholder', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Enter your username', 'pedro-for-elementor-addons'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'password_placeholder',
            [
                'label'       => __('Password Placeholder', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Enter your password', 'pedro-for-elementor-addons'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'   => __('Button Text', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Log In', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'redirect_url',
            [
                'label'       => __('Redirect After Login', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => ['active' => true],
                'placeholder' => home_url(),
            ]
        );

        $this->add_control(
            'logged_in_message',
            [
                'label'       => __('Logged In Message', 'pedro-for-elementor-addons'),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 2,
                'default'     => __('You are logged in.', 'pedro-for-elementor-addons'),
            ]
        );

        $this->add_control(
            'show_remember',
            [
                'label'   => __('Remember Me', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_lost_password',
            [
                'label'   => __('Lost Password Link', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'lost_password_text',
            [
                'label'     => __('Lost Password Text', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Lost your password?', 'pedro-for-elementor-addons'),
                'condition' => ['show_lost_password' => 'yes'],
            ]
        );

        $this->add_control(
            'show_register',
            [
                'label'   => __('Register Link', 'pedro-for-elementor-addons'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );

        $this->add_control(
            'register_text',
            [
                'label'     => __('Register Text', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Register', 'pedro-for-elementor-addons'),
                'condition' => ['show_register' => 'yes'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_form',
            [
                'label' => __('Form', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'form_width',
            [
                'label'      => __('Width', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => ['px' => ['min' => 200, 'max' => 600]],
                'default'    => ['unit' => 'px', 'size' => 400],
                'selectors'  => [
                    '{{WRAPPER}} .pea-login' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-login' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'form_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-login' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'form_border',
                'selector' => '{{WRAPPER}} .pea-login',
            ]
        );

        $this->add_responsive_control(
            'form_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-login' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'form_shadow',
                'selector' => '{{WRAPPER}} .pea-login',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_inputs',
            [
                'label' => __('Inputs', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-login input[type="text"], {{WRAPPER}} .pea-login input[type="password"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-login input[type="text"], {{WRAPPER}} .pea-login input[type="password"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'input_border',
                'selector' => '{{WRAPPER}} .pea-login input[type="text"], {{WRAPPER}} .pea-login input[type="password"]',
            ]
        );

        $this->add_responsive_control(
            'input_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-login input[type="text"], {{WRAPPER}} .pea-login input[type="password"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-login input[type="text"], {{WRAPPER}} .pea-login input[type="password"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => __('Button', 'pedro-for-elementor-addons'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_bg',
            [
                'label'     => __('Background', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#7c3aed',
                'selectors' => [
                    '{{WRAPPER}} .pea-login-submit' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => __('Text Color', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pea-login-submit' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_hover',
            [
                'label'     => __('Background Hover', 'pedro-for-elementor-addons'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pea-login-submit:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .pea-login-submit',
            ]
        );

        $this->add_responsive_control(
            'button_radius',
            [
                'label'      => __('Border Radius', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-login-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => __('Padding', 'pedro-for-elementor-addons'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .pea-login-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrap', 'class', 'pea-login');

        if (is_user_logged_in()) {
            ?>
            <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
                <p class="pea-login-logged-in"><?php echo esc_html($settings['logged_in_message'] ?? __('You are logged in.', 'pedro-for-elementor-addons')); ?></p>
                <a class="pea-login-logout" href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php esc_html_e('Log out', 'pedro-for-elementor-addons'); ?></a>
            </div>
            <?php
            return;
        }

        $redirect = ! empty($settings['redirect_url']['url']) ? esc_url_raw($settings['redirect_url']['url']) : home_url();
        if (empty($redirect)) {
            $redirect = home_url();
        }

        $form = new \stdClass();

        $show_labels      = 'yes' === ($settings['show_labels'] ?? 'yes');
        $show_remember    = 'yes' === ($settings['show_remember'] ?? 'yes');
        $show_lost        = 'yes' === ($settings['show_lost_password'] ?? 'yes');
        $show_register    = 'yes' === ($settings['show_register'] ?? 'yes');
        $remember_checked = ! empty($_POST['rememberme']);
        ?>
        <div <?php echo $this->get_render_attribute_string('wrap'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
            <form class="pea-login-form" action="<?php echo esc_url(wp_login_url()); ?>" method="post">
                <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect); ?>">

                <div class="pea-login-field">
                    <?php if ($show_labels) : ?>
                        <label class="pea-form-label" for="pea-login-user"><?php echo esc_html($settings['username_label'] ?? __('Username or Email Address', 'pedro-for-elementor-addons')); ?></label>
                    <?php endif; ?>
                    <input class="pea-form-control" type="text" name="log" id="pea-login-user" placeholder="<?php echo esc_attr($settings['username_placeholder'] ?? ''); ?>" required>
                </div>

                <div class="pea-login-field">
                    <?php if ($show_labels) : ?>
                        <label class="pea-form-label" for="pea-login-pass"><?php echo esc_html($settings['password_label'] ?? __('Password', 'pedro-for-elementor-addons')); ?></label>
                    <?php endif; ?>
                    <input class="pea-form-control" type="password" name="pwd" id="pea-login-pass" placeholder="<?php echo esc_attr($settings['password_placeholder'] ?? ''); ?>" required>
                </div>

                <?php if ($show_remember) : ?>
                    <div class="pea-login-options">
                        <label class="pea-form-option">
                            <input type="checkbox" name="rememberme" value="forever" <?php checked($remember_checked); ?>>
                            <span><?php esc_html_e('Remember Me', 'pedro-for-elementor-addons'); ?></span>
                        </label>
                    </div>
                <?php endif; ?>

                <button type="submit" name="wp-submit" class="pea-form-submit pea-login-submit"><?php echo esc_html($settings['button_text'] ?? __('Log In', 'pedro-for-elementor-addons')); ?></button>

                <div class="pea-login-links">
                    <?php if ($show_lost) : ?>
                        <a href="<?php echo esc_url(wp_lostpassword_url($redirect)); ?>"><?php echo esc_html($settings['lost_password_text'] ?? __('Lost your password?', 'pedro-for-elementor-addons')); ?></a>
                    <?php endif; ?>
                    <?php if ($show_lost && $show_register) : ?>
                        <span class="pea-login-sep" aria-hidden="true">|</span>
                    <?php endif; ?>
                    <?php if ($show_register) : ?>
                        <a href="<?php echo esc_url(wp_registration_url()); ?>"><?php echo esc_html($settings['register_text'] ?? __('Register', 'pedro-for-elementor-addons')); ?></a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <?php
    }
}