<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Project_Grid_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_project_grid_1';
    }

    public function get_title()
    {
        return __('EBP Custom Project Grid 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-project-grid';
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
        return ['ebp-custom-project-grid-1-style'];
    }


    protected function register_controls()
    {
        // Content Tab – repeater: each item is either an image or a card (color + text)
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        // Type choice: image or card
        $repeater->add_control(
            'item_type',
            [
                'label' => __('Type', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image' => __('Image', 'ebp-custom-widgets'),
                    'card' => __('Card', 'ebp-custom-widgets'),
                ],
            ]
        );

        // Image – shown when type is image
        $repeater->add_control(
            'image',
            [
                'label' => __('Choose Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => ['url' => ''],
                'condition' => [
                    'item_type' => 'image',
                ],
            ]
        );

        // Card colour – shown when type is card
        $repeater->add_control(
            'card_color',
            [
                'label' => __('Card Colour', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f5f5f5',
                'condition' => [
                    'item_type' => 'card',
                ],
            ]
        );

        // Card text – shown when type is card
        $repeater->add_control(
            'card_text',
            [
                'label' => __('Card Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => '',
                'placeholder' => __('Enter text for this card', 'ebp-custom-widgets'),
                'condition' => [
                    'item_type' => 'card',
                ],
            ]
        );

        $this->add_control(
            'grid_items',
            [
                'label' => __('Grid Items', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => __('Item', 'ebp-custom-widgets') . ' ({{{ item_type }}})',
            ]
        );

        $this->end_controls_section();

        // Style Tab – font, heading, background, margin, padding (using global spacing vars)
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
                    '{{WRAPPER}} .ebp-project-grid-1' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .ebp-project-grid-1 h1, {{WRAPPER}} .ebp-project-grid-1 h2, {{WRAPPER}} .ebp-project-grid-1 h3, {{WRAPPER}} .ebp-project-grid-1 h4, {{WRAPPER}} .ebp-project-grid-1 h5, {{WRAPPER}} .ebp-project-grid-1 h6' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .ebp-project-grid-1' => 'background-color: {{VALUE}}',
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
        $items = $settings['grid_items'] ?? [];

        // Spacing classes from Style tab (use global CSS vars)
        $style_classes = [
            'margin-top-' . ($settings['margin_top'] ?? 'medium'),
            'margin-bottom-' . ($settings['margin_bottom'] ?? 'medium'),
            'padding-top-' . ($settings['padding_top'] ?? 'medium'),
            'padding-bottom-' . ($settings['padding_bottom'] ?? 'medium'),
        ];
        $style_class_string = implode(' ', $style_classes);
        ?>
<!-- Project Grid – each item is either an image or a card (colour + text) -->
<div class="ebp-project-grid-1 <?php echo esc_attr($style_class_string); ?>">
    <div class="ebp-project-grid-1-container">
        <?php if (!empty($items)) : ?>
            <?php foreach ($items as $item) : ?>
                <?php
                $type = $item['item_type'] ?? 'image';
                $is_image = ($type === 'image');
                $is_card = ($type === 'card');
                ?>
                <div class="ebp-project-grid-1-item ebp-project-grid-1-item--<?php echo esc_attr($type); ?>">
                    <?php if ($is_image && !empty($item['image']['url'])) : ?>
                        <div class="ebp-project-grid-1-item-inner ebp-project-grid-1-item-inner--image">
                            <img src="<?php echo esc_url($item['image']['url']); ?>" alt="" loading="lazy" />
                        </div>
                    <?php elseif ($is_card) : ?>
                        <div class="ebp-project-grid-1-item-inner ebp-project-grid-1-item-inner--card" style="background-color: <?php echo esc_attr($item['card_color'] ?? '#f5f5f5'); ?>;">
                            <?php if (!empty($item['card_text'])) : ?>
                                <div class="ebp-project-grid-1-card-text"><?php echo wp_kses_post(nl2br(esc_html($item['card_text']))); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php
    }
}