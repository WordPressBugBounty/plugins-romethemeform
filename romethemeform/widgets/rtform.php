<?php

class RForm extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'rform';
    }
    public function get_title()
    {
        return 'RTMForm';
    }
    public function get_icon()
    {
        return 'rform-widget-icon rtmicon rtmicon-form';
    }
    public function get_categories()
    {
        return ['romethemeform_form_fields'];
    }
    public function show_in_panel()
    {
        return 'romethemeform_form' != get_post_type();
    }

    public function get_style_depends()
    {
        return ['rform-style'];
    }

    public function get_keywords()
    {
        return ['rometheme form'];
    }
    protected function register_controls()
    {
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Form', 'romethemeform'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT
        ]);
        $this->add_control('form-control', [
            'label' => esc_html('Select Form'),
            'type' => 'rform_control',
        ]);
        $this->end_controls_section();

        $this->start_controls_section('success_style', [
            'label' => esc_html('Success Wrapper'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]);

        $this->add_control('success_position', [
            'label' => esc_html('Message Position'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                'absolute' => esc_html('Absolute'),
                'fixed' => esc_html('Fixed'),
                'relative' => esc_html('Relative'),
            ],
            'default' => 'fixed',
            'selectors' => [
                '{{WRAPPER}} .success-submit' => 'position : {{VALUE}}'
            ]
        ]);

        $this->add_control(
            'position_y',
            [
                'label' => esc_html__('Position Y', 'textdomain'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'textdomain'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'textdomain'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'bottom',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .success-submit' => '{{VALUE}} : 0',
                ],
                'condition' => [
                    'success_position!' => 'relative'
                ]
            ]
        );

        $this->add_control(
            'position_x',
            [
                'label' => esc_html__('Position X', 'textdomain'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Top', 'textdomain'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Bottom', 'textdomain'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'right',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .success-submit' => '{{VALUE}} : 0',
                ],
                'condition' => [
                    'success_position!' => 'relative'
                ]
            ]
        );

        $this->add_responsive_control(
            'success_width',
            [
                'label' => esc_html__('Width', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .success-submit' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'offset_x',
            [
                'label' => esc_html__('Offset X', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .success-submit' => 'margin-inline: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'success_position!' => 'relative'
                ]
            ]
        );
        $this->add_responsive_control(
            'offset_y',
            [
                'label' => esc_html__('Offset Y', 'textdomain'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .success-submit' => 'margin-block: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'success_position!' => 'relative'
                ]
            ]
        );

        $this->add_responsive_control(
			'success_padding',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .success-submit .success-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'success_radius',
			[
				'label' => esc_html__( 'Border Radius', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .success-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .success-submit',
			]
		);

        $this->add_control(
            'hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'types' => ['classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .success-submit',
            ]
        );
        $this->add_control(
            'hr_1',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'success_border',
				'selector' => '{{WRAPPER}} .success-submit',
			]
		);

        $this->add_control(
            'hr_2',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
			'success_blur',
			[
				'label' => esc_html__( 'Blur Effect', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .success-submit' => 'backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section('success_title' , [
            'label' => esc_html('Success Title'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'success_title_typography',
				'selector' => '{{WRAPPER}} .success-title',
			]
		);

        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .success-title' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .success-title',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'title_stroke',
				'selector' => '{{WRAPPER}} .success-title',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section('success_decscription' , [
            'label' => esc_html('Success Description'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'success_description_typography',
				'selector' => '{{WRAPPER}} .success-description',
			]
		);

        $this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Text Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .success-description' => 'color: {{VALUE}}',
				],
			]
		);

         $this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'description_shadow',
				'selector' => '{{WRAPPER}} .success-description',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'description_stroke',
				'selector' => '{{WRAPPER}} .success-description',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section('success_icon' , [
            'label' => esc_html('Success Icon'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]);

        $this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .success-icon' => 'color: {{VALUE}}; fill: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'icon_size',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Icon Size', 'textdomain' ),
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
                'selectors' => [
                    '{{WRAPPER}} .success-icon' => 'width: {{SIZE}}{{UNIT}}; height : {{SIZE}}{{UNIT}}; font-size : {{SIZE}}{{UNIT}}'
                ]
			]
		);

         $this->add_responsive_control(
			'icon_spacing',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Icon Spacing', 'textdomain' ),
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
					],
				],
                'selectors' => [
                    '{{WRAPPER}} .success-icon' => 'margin-right: {{SIZE}}{{UNIT}};'
                ]
			]
		);

        $this->end_controls_section();

        $this->start_controls_section('success_close' , [
            'label' => esc_html('Close Button'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]);

        $this->add_control('close_text' , [
            'label' => esc_html('Close Text'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '✖',
            'selectors' => [
                '{{WRAPPER}} .close-msg::before' => 'content : "{{VALUE}}"'
            ]
        ]);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'close_typography',
				'selector' => '{{WRAPPER}} .close-msg',
			]
		);

        $this->add_control(
			'close_radius',
			[
				'label' => esc_html__( 'Border Radius', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .close-msg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


        $this->start_controls_tabs('close_tabs');

        $this->start_controls_tab('close_tab_normal' , ['label' => esc_html('Normal')]);

        	$this->add_control(
			'close_color_normal',
			[
				'label' => esc_html__( 'Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .close-msg' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'close_background_normal',
				'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .close-msg',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'close_border_normal',
				'selector' => '{{WRAPPER}} .close-msg',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'close_box_shadow_normal',
				'selector' => '{{WRAPPER}} .close-msg',
			]
		);


        $this->end_controls_tab();

        $this->start_controls_tab('close_tab_hover' , ['label' => esc_html('Hover')]);

        	$this->add_control(
			'close_color_hover',
			[
				'label' => esc_html__( 'Color', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .close-msg:hover' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'close_background_hover',
				'types' => [ 'classic', 'gradient' ],
                'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .close-msg:hover',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'close_border_hover',
				'selector' => '{{WRAPPER}} .close-msg:hover',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'close_box_shadow_hover',
				'selector' => '{{WRAPPER}} .close-msg:hover',
			]
		);


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $form_id = $settings['form-control'];
        $shortcode = '[rform form_id=' . $form_id . ']';
        echo do_shortcode($shortcode);
    }
}
