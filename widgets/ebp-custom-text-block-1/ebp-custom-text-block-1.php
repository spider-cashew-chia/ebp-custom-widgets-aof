<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Text_Block_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_text_block_1';
    }

    public function get_title()
    {
        return __('EBP Custom Text Block 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-text-block';
    }

    public function get_categories()
    {
        return ['ebp-custom-widgets'];
    }

    // Enqueue widget assets
    public function get_script_depends()
    {
        return ['jquery', 'ebp-gsap.min', 'ebp-ScrollTrigger.min'];
    }

    public function get_style_depends()
    {
        return ['ebp-custom-text-block-1-style'];
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

        // Rich text control
        $this->add_control(
            'rich_text',
            [
                'label' => __('Rich Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter your rich text content', 'ebp-custom-widgets'),
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

        // Query team CPT posts
        $team_args = [
            'post_type' => 'team',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ];

        $team_query = new \WP_Query($team_args);

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
<!-- Text Block  -->
<section class="ebp-text-block-1 <?php echo esc_attr($style_class_string); ?>"
    data-widget-id="<?php echo esc_attr($this->get_id()); ?>">
    <div class="ebp-text-block-1-container">
        <?php if (!empty($settings['heading'])): ?>
        <div class="ebp-text-block-1-heading">
            <h2><?php echo esc_html($settings['heading']); ?></h2>
        </div>
        <?php endif; ?>
        <div class="ebp-text-block-1-content">
            <!-- left -->
            <div class="ebp-text-block-1-left">
                <?php if (!empty($settings['rich_text'])): ?>
                <div class="ebp-text-block-1-rich-text">
                    <?php echo wp_kses_post($settings['rich_text']); ?>
                </div>
                <?php endif; ?>
            </div>
            <!-- right -->
            <div class="ebp-text-block-1-right">
                <?php if ($team_query->have_posts()): ?>
                <div class="ebp-text-block-1-team-wrapper">
                    <!-- Dynamic counter showing current position (e.g., "01 - 04") -->
                    <div class="ebp-text-block-1-team-counter">
                        <span class="ebp-text-block-1-counter-current">01</span>
                        <span class="ebp-text-block-1-counter-separator"> - </span>
                        <span
                            class="ebp-text-block-1-counter-total"><?php echo str_pad($team_query->post_count, 2, '0', STR_PAD_LEFT); ?></span>
                    </div>
                    <div class="ebp-text-block-1-team-list"
                        data-team-count="<?php echo esc_attr($team_query->post_count); ?>">
                        <?php
                                    $index = 0;
                                    while ($team_query->have_posts()):
                                        $team_query->the_post();
                                        $post_id = get_the_ID();
                                        $title = get_the_title();
                                        $role = get_field('role'); // ACF field
                                        $featured_image = get_the_post_thumbnail_url($post_id, 'full');
                                        ?>
                        <div class="ebp-text-block-1-team-member" data-index="<?php echo esc_attr($index); ?>"
                            data-image="<?php echo esc_url($featured_image); ?>">
                            <div class="ebp-text-block-1-team-member-content">
                                <?php if ($role): ?>
                                <div class="ebp-text-block-1-team-role"><?php echo esc_html($role); ?></div>
                                <?php endif; ?>
                                <?php if ($title): ?>
                                <div class="ebp-text-block-1-team-name"><?php echo esc_html($title); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                                        $index++;
                                    endwhile;
                                    wp_reset_postdata();
                                    ?>
                    </div>
                    <!-- Featured image container (shown on hover) -->
                    <div class="ebp-text-block-1-team-image">
                        <img src="" alt="" class="ebp-text-block-1-team-image-img">
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
    }
}