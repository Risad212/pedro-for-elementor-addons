<?php
namespace PedroEA\Widgets;

use \Elementor\Utils;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Text_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Icons_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Repeater;


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class PedroEA_Team extends Widget_Base {

    public function get_name() {
        return 'pedroea_team';
    }

    public function get_title(): string {
        return __( 'Team', 'pedro-for-elementor-addons' );
    }

    public function get_icon(): string {
        return 'pedro-elementor-icon eicon-person';
    }

    public function get_categories(): array {
        return [ 'pedroea' ];
    }

    public function get_keywords(): array {
        return [ 'team', 'member', 'crew', 'staff', 'person' ];
    }

    // Start content controls
    protected function register_controls() {

        $this->start_controls_section(
            'section_title',
            [
                'label'   => __( 'Information', 'pedro-for-elementor-addons' ),
                'tab'     => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'team_image',
			[
				'label'   => __( 'Choose Image', 'pedro-for-elementor-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'thumbnail', 
				'default' => 'large',
			]
		);

        	$this->add_control(
			 'team_name',
			[
				'label'       => __( 'Name', 'pedro-for-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
                'label_block' => true,
				'default'     => __( 'Pedro Team Member', 'pedro-for-elementor-addons' ),
				'placeholder' => __( 'Type Member Name',  'pedro-for-elementor-addons' ),
			]
		);

        $this->add_control(
			 'job_title',
			[
				'label'       => __( 'Job Title', 'pedro-for-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
                'label_block' => true,
				'default'     => __( 'Pedro Office', 'pedro-for-elementor-addons' ),
				'placeholder' => __( 'Type Member Job Title',  'pedro-for-elementor-addons' ),
			]
		);

        
		$this->add_control(
			'team_bio',
			[
				'label'       => __( 'Short Bio', 'pedro-for-elementor-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'placeholder' => __( 'A Happy Pedro Member!', 'pedro-for-elementor-addons' ),
			]
		);

        $this->add_control(
            'title_tag',
            [
                'label'    => __( 'Title HTML Tag', 'pedro-for-elementor-addons' ),
                'type'     => Controls_Manager::SELECT,
                'default'  => 'h2',
                'options'  => [
                    'h1'   => __(  'H1', 'pedro-for-elementor-addons' ),
                    'h2'   => __(  'H2', 'pedro-for-elementor-addons' ),
                    'h3'   => __(  'H3', 'pedro-for-elementor-addons' ),
                    'h4'   => __(  'H4', 'pedro-for-elementor-addons' ),
                    'h5'   => __(  'H5', 'pedro-for-elementor-addons' ),
                    'h6'   => __(  'H6', 'pedro-for-elementor-addons' ),
                    'div'  => __(  'DIV', 'pedro-for-elementor-addons' ),
                    'span' => __(  'SPAN', 'pedro-for-elementor-addons' ),
                ],
            ]
        );

        $this->add_responsive_control(
			'team_align',
			[
				'label'          => __( 'Alignment', 'pedro-for-elementor-addons' ),
				'type'           => Controls_Manager::CHOOSE,
				'options'        => [
					'left'       => [
						'title'  => __( 'Left', 'pedro-for-elementor-addons' ),
						'icon'   => 'eicon-text-align-left',
					],
					'center'     => [
						'title'  => __( 'Center', 'pedro-for-elementor-addons' ),
						'icon'   => 'eicon-text-align-center',
					],
					'right'      => [
						'title'  => __( 'Right', 'pedro-for-elementor-addons' ),
						'icon'   => 'eicon-text-align-right',
					],
					'justify'    => [
						'title'  => __( 'Justify', 'pedro-for-elementor-addons' ),
						'icon'   => 'eicon-text-align-justify',
					],
				],
				'toggle'          => true,
				'selectors'       => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();

		// social section 
		$this->start_controls_section(
			'social_section',
			[
				'label' => __( 'Social Profiles', 'pedro-for-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
        
		
	    $repeater = new Repeater();

		$repeater->add_control(
			'social_name',
			[
				'label'       => __( 'Social Name', 'pedro-for-elementor-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Facebook', 'pedro-for-elementor-addons' ),
				'placeholder' => __( 'Enter social name', 'pedro-for-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'social_icon',
			[
				'label'       => __( 'Icon', 'pedro-for-elementor-addons' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fab fa-facebook-f',
					'library' => 'fa-brands',
				],
			]
		);



		$repeater->add_control(
			'social_link',
			[
				'label'       => __( 'Link', 'pedro-for-elementor-addons' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( '#', 'pedro-for-elementor-addons' ),
				'default'     => [
					'url'     => '#',
				],
			]
		);

		$this->add_control(
			'social_list',
			[
				'label'               => __( 'Social Icons', 'pedro-for-elementor-addons' ),
				'type'                => Controls_Manager::REPEATER,
				'fields'              => $repeater->get_controls(),
				'default' => [
					[
						'social_name' => __( 'Facebook', 'pedro-for-elementor-addons' ),
						'social_icon' => [
							'value'   => 'fab fa-facebook-f',
							'library' => 'fa-brands',
						],
						'social_link' => [ 'url' => '#' ],
					]
				],
				'title_field' => '{{{ social_name }}}',
			]
		);

		$this->add_control(
			'show_social_profile',
			[
				'label'        => esc_html__( 'Show Icons', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'pedro-for-elementor-addons' ),
				'label_off'    => esc_html__( 'Hide', 'pedro-for-elementor-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();

        // Style Section
        $this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Photo', 'pedro-for-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		 );

        $this->add_responsive_control(
			'image_width',
			[
				'label'       => __( 'Width', 'pedro-for-elementor-addons' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px', '%'],
				'range'       => [
					'%'       => [
						'min' => 20,
						'max' => 100,
					],
					'px'      => [
						'min' => 100,
						'max' => 700,
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .pea-team-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'image_height',
			[
				'label'       => __( 'Height', 'pedro-for-elementor-addons' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px'      => [
						'min' => 100,
						'max' => 700,
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .pea-team-img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        	$this->add_responsive_control(
			'image_spacing',
			[
				'label'      => __( 'Bottom Spacing', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .pea-card-img' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

        $this->add_responsive_control(
			'image_padding',
			[
				'label'      => __( 'Padding', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .pea-team-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .pea-team-img',
			]
		);

        $this->add_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors'  => [
					'{{WRAPPER}} .pea-team-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .pea-team-img',
			]
		);

        	$this->add_control(
			'background_color',
			[
				'label'     => __( 'Background Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pea-team-img' => 'background: {{VALUE}}',
				],
			]
		);


        $this->start_controls_tabs('style_tabs');

        $this->start_controls_tab(
            'tab_image_opacity_normal',
            [
                'label' => __( 'Normal', 'pedro-for-elementor-addons' ),
            ]
        );

        $this->add_control(
			'image_opacity_normal',
			[
				'label'        => __( 'Opacity', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SLIDER,
				'range'        => [
					'px'       => [
						'min'  => 0.10,
						'max'  => 1,
						'step' => 0.01,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .pea-team-img' => 'opacity: {{SIZE}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_image_opacity_hover',
            [
                'label' => __( 'Hover', 'pedro-for-elementor-addons' ),
            ]
        );

        $this->add_control(
			'image_opacity_hover',
			[
				'label'        => __( 'Opacity', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SLIDER,
				'range'        => [
					'px'       => [
						'min'  => 0.10,
						'max'  => 1,
						'step' => 0.01,
					]
				],
				'selectors'    => [
					'{{WRAPPER}} .pea-team-img:hover' => 'opacity: {{SIZE}};',
				],
			]
		);

        $this->add_control(
			'img_hover_transition',
			[
				'label'        => __( 'Transition Duration', 'pedro-for-elementor-addons' ),
				'type'         => Controls_Manager::SLIDER,
				'range'        => [
					'px'       => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'default'      => [
					'size'     => .2,
				],
				'selectors'    => [
					'{{WRAPPER}} .pea-team-img' => 'transition-duration: {{SIZE}}s;',
				],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();
       
        // css filter
        $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'img_css_filters',
				'selector' => '{{WRAPPER}} .pea-team-img',
			]
		);

        $this->end_controls_section();

      // Name, Job Title, Bio
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Name, Job Title & Bio', 'pedro-for-elementor-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => __( 'Content Padding', 'pedro-for-elementor-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .pea-card-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'title_spacing',
			[
				'label'      => __( 'Name Bottom Spacing', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
                'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} .pea-team-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

       $this->add_control(
			'name_color',
			[
				'label'     => __( 'Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pea-team-title a' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'selector' => '{{WRAPPER}} .pea-team-title',
			]
		);

        
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'name_shadow',
				'selector' => '{{WRAPPER}} .pea-team-title',
                'separator' => 'before',
			]
		);

        // job title
        $this->add_responsive_control(
			'job_title_spacing',
			[
				'label'      => __( 'Job Title Bottom Spacing', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
                'separator' => 'before',
				'selectors'  => [
					'{{WRAPPER}} .pea-team-position' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

       $this->add_control(
			'job_title_color',
			[
				'label'     => __( 'Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pea-team-position' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'job_title_typography',
				'selector' => '{{WRAPPER}} .pea-team-position',
			]
		);

        
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'job_title_shadow',
				'selector' => '{{WRAPPER}} .pea-team-position',
                'separator' => 'before',
			]
		);

       $this->add_control(
			'short_bio_color',
			[
				'label'     => __( 'Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'separator'  => 'before',
				'selectors' => [
					'{{WRAPPER}} .pea-short-disc' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'short_bio_typography',
				'selector' => '{{WRAPPER}} .pea-short-disc',
			]
		);

        
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'short_bio_shadow',
				'selector' => '{{WRAPPER}} .pea-short-disc',
                'separator' => 'after',
			]
		);
        
        $this->end_controls_section();

		// social section
		$this->start_controls_section(
		'social_icon_section',
		[
			'label' => __( 'Social Icons', 'pedro-for-elementor-addons' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		]
	   );

	  $this->add_responsive_control(
			'icon_size',
			[
				'label'      => __( 'Icon Size', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .pea-social-media li > a svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'      => __( 'Left Spacing', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .pea-social-media' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing_bottom',
			[
				'label'      => __( 'Bottom Spacing', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .pea-social-media' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'      => __( 'Padding', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}} .pea-social-media li > a' => 'padding: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'links_border',
				'selector' => '{{WRAPPER}} .pea-social-media li > a',
			]
		);

		$this->add_responsive_control(
			'links_border_radius',
			[
				'label'      => __( 'Border Radius', 'pedro-for-elementor-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pea-social-media li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
	        'social_icon_color'
		);

		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => __( 'Normal', 'pedro-for-elementor-addons' ),
			]
		);

		$this->add_control(
			'icon_color_normal',
			[
				'label'     => __( 'Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pea-social-media li a svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_color_bg_normal',
			[
				'label'     => __( 'Background Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pea-social-media li a' => 'background: {{VALUE}}',
				],
			]
		);


		$this->end_controls_tab();

		// hover social icon
		$this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => __( 'Hover', 'pedro-for-elementor-addons' ),
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label'     => __( 'Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pea-social-media li a:hover svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_color_bg_hover',
			[
				'label'     => __( 'Background Color', 'pedro-for-elementor-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pea-social-media li a:hover' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

	   $this->end_controls_section();

    }

   protected function render(): void {

    $settings = $this->get_settings_for_display();

    // Team image
    $this->add_render_attribute( 'team_image_attr', 'class', 'pea-team-img' );
    $this->add_render_attribute( 'team_image_attr', 'src', esc_url( $settings['team_image']['url'] ) );
    $this->add_render_attribute( 'team_image_attr', 'alt', esc_attr__( 'Team Member', 'pedro-for-elementor-addons' ) );

    // Social item class (shared)
    $this->add_render_attribute( 'social_item_attr', 'class', 'pea-item' );

    ?>
    <div class="pea-team-card">
        <div class="pea-card-img">
            <img <?php echo wp_kses_post( $this->get_render_attribute_string( 'team_image_attr' ) ); ?>>
            <div class="pea-social-media">
			<?php if ( ! empty( $settings['show_social_profile'] ) ) : ?>
			 <ul class="pea-social-media">
               <?php foreach ( $settings['social_list'] as $item ) : ?>
               <?php
                  $icon = $item['social_icon'];
                  $link = $item['social_link']['url'] ?? '#';
               ?>

				<li <?php $this->print_render_attribute_string( 'social_item_attr' ); ?>>
					<a href="<?php echo esc_url( $link ); ?>">
					<?php Icons_Manager::render_icon(
							$icon,[ 'aria-hidden' => 'true',]
						);?>
					</a>
				</li>
            <?php endforeach; ?>
         </ul>
		<?php endif; ?>
		</div>
        </div>
        <div class="pea-card-content">
            <h4 class="pea-team-title"><a href="#"><?php echo esc_html( $settings['team_name'] ?? 'Ema Jackson' ); ?></a></h4>
            <div class="pea-team-position"><?php echo esc_html( $settings['job_title'] ?? 'Project Manager' ); ?></div>
            <p class="pea-short-disc"><?php echo esc_html( $settings['team_bio'] ?? 'A small river named Duden flows by their place and supplies it with the necessary' ); ?></p>
        </div>
    </div>
    <?php
}

}
