<?php

class RFORM_ReCAPTCHA extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'rform-recaptcha';
    }

    public function get_title()
    {
        return 'reCAPTCHA';
    }

    public function get_icon()
    {
        return 'rform-widget-icon eicon-captcha';
    }

    public function show_in_panel()
    {
        return 'romethemeform_form' === get_post_type();
    }

    public function get_categories()
    {
        return ['romethemeform_form_fields'];
    }

    public function get_keywords()
    {
        return ['recaptcha', 'captcha', 'security'];
    }

    public function get_script_depends()
    {
        return ['rform-recaptcha-script', 'google-recaptcha'];
    }


    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'romethemeform'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control('captcha_theme', [
            'label' => esc_html__('reCAPTCHA Theme', 'romethemeform'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'light' => esc_html__('Light', 'romethemeform'),
                'dark' => esc_html__('Dark', 'romethemeform'),
            ],
            'default' => 'light',
            'description' => esc_html__('Choose the theme for reCAPTCHA (only applies to reCAPTCHA v2).', 'romethemeform'),
        ]);

        $this->add_control(
            'warning_message',
            [
                'label' => esc_html__('Warning Message', 'romethemeform'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Please complete the reCAPTCHA verification.', 'romethemeform'),
            ]
        );

        $this->add_control(
            'help_text',
            [
                'label' => esc_html__('Help Text', 'romethemeform'),
                'type' => \Elementor\Controls_Manager::TEXT,
                // 'default' => esc_html__('This helps us prevent spam and abuse.', 'romethemeform'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('warning_style', [
            'label' => esc_html__('Warning', 'romethemeform'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]);

        $this->add_responsive_control(
            'warning_text_align',
            [
                'label' => esc_html__('Alignment', 'romethemeform'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'romethemeform'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'romethemeform'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'romethemeform'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .rform-error' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control('warning_color', [
            'label' => esc_html__('Color', 'romethemeform'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rform-error' => 'color:{{VALUE}}'
            ]
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'warning_typography',
                'selector' => '{{WRAPPER}} .rform-error',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('help_text_style', [
            'label' => esc_html__('Help Text', 'romethemeform'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'help_text!' => ''
            ]
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'help_text_typography',
                'selector' => '{{WRAPPER}} .rform-help-text',
            ]
        );

        $this->add_control('help_text_color', [
            'label' => esc_html__('Color', 'romethemeform'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .rform-help-text' => 'color:{{VALUE}}'
            ]
        ]);

        $this->add_responsive_control('help_text_padding', [
            'label' => esc_html__('Padding', 'romethemeform'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'selectors' => [
                '{{WRAPPER}} .rform-help-text' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
            ]
        ]);


        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            $this->render_editor();
        } else {
?>
            <div class="rform-recaptcha-wrapper">
                <?php $this->render_frontend($settings); ?>
                <span role="alert" class="rform-error" id="rform-input-err-<?php echo $this->get_id_int(); ?>"><?php echo esc_html__($settings['warning_message'], 'romethemeform') ?></span>
                <div class="rform-help-text">
                    <span><?php echo esc_html__($settings['help_text'], 'romethemeform') ?></span>
                </div>
            </div>
        <?php
        }
    }

    public function render_editor()
    {
        ?>
        <div class="rform-recaptcha-placeholder">
            <span>reCAPTCHA will be displayed here on the frontend.</span>
        </div>
<?php
    }
    public function render_frontend($settings)
    {
        $captchaVersion = get_option('rform_recaptcha_version', 'v2');
        $siteKeyV2 = get_option('rform_recaptcha_site_key_v2', '');
        $secretKeyV2 = get_option('rform_recaptcha_secret_key_v2', '');
        $siteKeyV3 = get_option('rform_recaptcha_site_key_v3', '');
        $secretKeyV3 = get_option('rform_recaptcha_secret_key_v3', '');
        if ($captchaVersion === 'v2' && $siteKeyV2 && $secretKeyV2) {
            echo '<div class="rform-recaptcha-v2" data-theme="' . esc_attr($settings['captcha_theme']) . '" data-sitekey="' . esc_attr($siteKeyV2) . '" ></div>';
        } elseif ($captchaVersion === 'v3' && $siteKeyV3 && $secretKeyV3) {
            echo '<input type="hidden" class="rform-recaptcha-token" data-sitekey="' . esc_attr($siteKeyV3) . '" name="g-recaptcha-response" value="">';
        }
    }
}
