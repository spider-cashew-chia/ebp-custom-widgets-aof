<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Hero_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_hero_1';
    }

    public function get_title()
    {
        return __('EBP Custom Hero 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-hero';
    }

    public function get_categories()
    {
        return ['ebp-custom-widgets'];
    }

    // Enqueue widget assets
    public function get_script_depends()
    {
        return ['jquery'];
    }

    public function get_style_depends()
    {
        return ['ebp-custom-hero-1-style'];
    }


    protected function register_controls()
    {
        // Content Tab
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Heading control
        $this->add_control(
            'heading',
            [
                'label' => __('Heading', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Enter your heading', 'ebp-custom-widgets'),
            ]
        );

        // Media type selector
        $this->add_control(
            'media_type',
            [
                'label' => __('Media Type', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image' => __('Image', 'ebp-custom-widgets'),
                    'video' => __('Video', 'ebp-custom-widgets'),
                ],
            ]
        );

        // Image upload control
        $this->add_control(
            'background_image',
            [
                'label' => __('Background Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'condition' => [
                    'media_type' => 'image',
                ],
            ]
        );

        // Video upload control
        $this->add_control(
            'background_video',
            [
                'label' => __('Background Video', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'default' => [
                    'url' => '',
                ],
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        // Overlay control
        $this->add_control(
            'overlay',
            [
                'label' => __('Overlay', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'ebp-custom-widgets'),
                'label_off' => __('No', 'ebp-custom-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Font color
        $this->add_control(
            'font_color',
            [
                'label' => __('Font Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => [
                    'small' => __('Small', 'ebp-custom-widgets'),
                    'medium' => __('Medium', 'ebp-custom-widgets'),
                    'large' => __('Large', 'ebp-custom-widgets'),
                ],
            ]
        );

        // Heading color
        $this->add_control(
            'heading_color',
            [
                'label' => __('Heading Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => [
                    'small' => __('Small', 'ebp-custom-widgets'),
                    'medium' => __('Medium', 'ebp-custom-widgets'),
                    'large' => __('Large', 'ebp-custom-widgets'),
                ],
            ]
        );

        // Background color
        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => [
                    'small' => __('Small', 'ebp-custom-widgets'),
                    'medium' => __('Medium', 'ebp-custom-widgets'),
                    'large' => __('Large', 'ebp-custom-widgets'),
                ],
            ]
        );

        // Margin top
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

        // Margin bottom
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

        // Padding top
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

        // Padding bottom
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

        // Get media type
        $media_type = $settings['media_type'] ?? 'image';

        // Get media URLs
        $image_url = '';
        $video_url = '';

        if ($media_type === 'image' && !empty($settings['background_image']['url'])) {
            $image_url = $settings['background_image']['url'];
        } elseif ($media_type === 'video' && !empty($settings['background_video']['url'])) {
            $video_url = $settings['background_video']['url'];
        }

        // Get overlay setting
        $overlay = $settings['overlay'] === 'yes' ? 'has-overlay' : '';

        // Build CSS classes for styling options
        $style_classes = [
            'font-color-' . ($settings['font_color'] ?? 'medium'),
            'heading-color-' . ($settings['heading_color'] ?? 'medium'),
            'background-color-' . ($settings['background_color'] ?? 'medium'),
            'margin-top-' . ($settings['margin_top'] ?? 'medium'),
            'margin-bottom-' . ($settings['margin_bottom'] ?? 'medium'),
            'padding-top-' . ($settings['padding_top'] ?? 'medium'),
            'padding-bottom-' . ($settings['padding_bottom'] ?? 'medium'),
        ];

        $style_class_string = implode(' ', $style_classes);
        ?>
<!-- Hero  -->
<section class="ebp-hero-1 <?php echo esc_attr($style_class_string); ?>">
    <div class="ebp-hero-1-container">
        <?php if ($media_type === 'video' && $video_url): ?>
        <!-- Background video -->
        <video class="ebp-hero-1-background-video" autoplay muted loop playsinline>
            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
        </video>
        <?php elseif ($media_type === 'image' && $image_url): ?>
        <!-- Background image -->
        <div class="ebp-hero-1-background-image" style="background-image: url('<?php echo esc_url($image_url); ?>');">
        </div>
        <?php endif; ?>

        <?php if ($overlay): ?>
        <div class="ebp-hero-1-overlay"></div>
        <?php endif; ?>

        <div class="ebp-hero-1-content">
            <?php if (!empty($settings['heading'])): ?>
            <h1 class="ebp-hero-1-heading">
                <?php echo esc_html($settings['heading']); ?>
            </h1>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
    }
}