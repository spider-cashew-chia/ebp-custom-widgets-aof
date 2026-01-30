<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Beliefs_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_beliefs_1';
    }

    public function get_title()
    {
            return __('EBP Custom Beliefs 1', 'ebp-custom-widgets');
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
        return ['ebp-custom-beliefs-1-style'];
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

        // Heading part 1 control (first span)
        $this->add_control(
            'heading_part_1',
            [
                'label' => __('Heading Part 1', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g., Our', 'ebp-custom-widgets'),
            ]
        );

        // Heading part 2 control (second span)
        $this->add_control(
            'heading_part_2',
            [
                'label' => __('Heading Part 2', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g., Beliefs', 'ebp-custom-widgets'),
            ]
        );

        // Repeater control for beliefs items with rich text
        $repeater = new \Elementor\Repeater();

        // Rich text control inside repeater
        $repeater->add_control(
            'rich_text',
            [
                'label' => __('Rich Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter your rich text content', 'ebp-custom-widgets'),
            ]
        );

        $this->add_control(
            'beliefs_list',
            [
                'label' => __('Beliefs', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => __('Belief Item', 'ebp-custom-widgets'),
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

        // Get the beliefs list from repeater
        $beliefs_list = $settings['beliefs_list'] ?? [];
        ?>
<!-- Beliefs  -->
<div class="ebp-beliefs-1 <?php echo esc_attr($style_class_string); ?>">
    <div class="ebp-beliefs-1-container">
        <!-- heading -->
        <?php if (!empty($settings['heading_part_1']) || !empty($settings['heading_part_2'])): ?>
        <div class="ebp-beliefs-1-heading">
            <h2>
                <?php if (!empty($settings['heading_part_1'])): ?>
                <span class="ebp-beliefs-1-heading-part-1"><?php echo esc_html($settings['heading_part_1']); ?></span>
                <?php endif; ?>
                <?php if (!empty($settings['heading_part_2'])): ?>
                <span class="ebp-beliefs-1-heading-part-2"><?php echo esc_html($settings['heading_part_2']); ?></span>
                <?php endif; ?>
            </h2>
        </div>
        <?php endif; ?>

        <!-- beliefs list: one scratch zone, items absolute (3 + 2), single canvas on top -->
        <?php if (!empty($beliefs_list)): ?>
        <div class="ebp-beliefs-1-list">
            <div class="ebp-beliefs-1-scratch-zone">
                <?php foreach ($beliefs_list as $item): ?>
                <?php
                    $rich_text = $item['rich_text'] ?? '';
                    if (empty($rich_text)) {
                        continue;
                    }
                    ?>
                <div class="ebp-beliefs-1-item">
                    <div class="ebp-beliefs-1-item-content">
                        <?php echo wp_kses_post($rich_text); ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <!-- Single overlay so user can scratch across multiple items at once -->
                <div class="ebp-beliefs-1-scratch-overlay">
                    <canvas class="ebp-beliefs-1-scratch-canvas"></canvas>
                    <div class="ebp-beliefs-1-item-tooltip">Scratch me</div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
    }
}