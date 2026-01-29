<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Scrolling_Slider_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_scrolling_slider_1';
    }

    public function get_title()
    {
        return __('EBP Custom Scrolling Slider 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-scrolling-slider';
    }

    public function get_categories()
    {
        return ['ebp-custom-widgets'];
    }

    // Enqueue widget assets – depend on Swiper (already enqueued) for 5-slide auto-scroll
    public function get_script_depends()
    {
        return ['jquery', 'ebp-swiper-bundle.min', 'ebp-custom-scrolling-slider-1-script'];
    }

    public function get_style_depends()
    {
        return ['ebp-custom-scrolling-slider-1-style'];
    }

    protected function register_controls()
    {
        // Content tab – image repeater for each slide
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'image',
            [
                'label' => __('Choose Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => ''],
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => __('Slides', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => __('Slide', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();

        // Style tab – font, heading, background, margin, padding (using global spacing vars)
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'font_color',
            [
                'label' => __('Font Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ebp-scrolling-slider-1' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => __('Heading Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ebp-scrolling-slider-1 h1, {{WRAPPER}} .ebp-scrolling-slider-1 h2, {{WRAPPER}} .ebp-scrolling-slider-1 h3, {{WRAPPER}} .ebp-scrolling-slider-1 h4, {{WRAPPER}} .ebp-scrolling-slider-1 h5, {{WRAPPER}} .ebp-scrolling-slider-1 h6' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ebp-scrolling-slider-1' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'margin_top',
            [
                'label' => __('Margin Top', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => [
                    'none' => __('None', 'ebp-custom-widgets'),
                    'small' => __('Small', 'ebp-custom-widgets'),
                    'medium' => __('Medium', 'ebp-custom-widgets'),
                    'large' => __('Large', 'ebp-custom-widgets'),
                ],
            ]
        );

        $this->add_control(
            'margin_bottom',
            [
                'label' => __('Margin Bottom', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => [
                    'none' => __('None', 'ebp-custom-widgets'),
                    'small' => __('Small', 'ebp-custom-widgets'),
                    'medium' => __('Medium', 'ebp-custom-widgets'),
                    'large' => __('Large', 'ebp-custom-widgets'),
                ],
            ]
        );

        $this->add_control(
            'padding_top',
            [
                'label' => __('Padding Top', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => [
                    'none' => __('None', 'ebp-custom-widgets'),
                    'small' => __('Small', 'ebp-custom-widgets'),
                    'medium' => __('Medium', 'ebp-custom-widgets'),
                    'large' => __('Large', 'ebp-custom-widgets'),
                ],
            ]
        );

        $this->add_control(
            'padding_bottom',
            [
                'label' => __('Padding Bottom', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => [
                    'none' => __('None', 'ebp-custom-widgets'),
                    'small' => __('Small', 'ebp-custom-widgets'),
                    'medium' => __('Medium', 'ebp-custom-widgets'),
                    'large' => __('Large', 'ebp-custom-widgets'),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $slides = $settings['slides'] ?? [];

        // Spacing classes from Style tab (use global CSS vars)
        $style_classes = [
            'margin-top-' . ($settings['margin_top'] ?? 'medium'),
            'margin-bottom-' . ($settings['margin_bottom'] ?? 'medium'),
            'padding-top-' . ($settings['padding_top'] ?? 'medium'),
            'padding-bottom-' . ($settings['padding_bottom'] ?? 'medium'),
        ];
        $style_class_string = implode(' ', $style_classes);
        ?>
<!-- Scrolling Slider – Swiper: 5 visible, auto-scroll, loop -->
<div class="ebp-scrolling-slider-1 <?php echo esc_attr($style_class_string); ?>">
    <div class="ebp-scrolling-slider-1-swiper swiper">
        <div class="swiper-wrapper">
            <?php if (!empty($slides)) : ?>
                <?php foreach ($slides as $slide) : ?>
                    <?php if (!empty($slide['image']['url'])) : ?>
                        <div class="swiper-slide">
                            <div class="ebp-scrolling-slider-1-slide-inner">
                                <img src="<?php echo esc_url($slide['image']['url']); ?>" alt="" loading="lazy" />
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
    }
}