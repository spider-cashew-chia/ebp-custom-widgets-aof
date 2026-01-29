<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Project_Info_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_project_info_1';
    }

    public function get_title()
    {
        return __('EBP Custom Project Info 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-project-info';
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
        return ['ebp-custom-project-info-1-style'];
    }


    protected function register_controls()
    {
        // Content Tab – repeater with rich text in each item
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Repeater: each row has one WYSIWYG (rich text) field
        $repeater = new \Elementor\Repeater();

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
            'info_items',
            [
                'label' => __('Info Items', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => __('Info Item', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();

        // Style Tab – per-widget rules (font, heading, background, margin, padding)
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Font colour – colour picker
        $this->add_control(
            'font_color',
            [
                'label' => __('Font Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ebp-project-info-1' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Heading colour – colour picker (applies to h1–h6 in rich text)
        $this->add_control(
            'heading_color',
            [
                'label' => __('Heading Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ebp-project-info-1 h1, {{WRAPPER}} .ebp-project-info-1 h2, {{WRAPPER}} .ebp-project-info-1 h3, {{WRAPPER}} .ebp-project-info-1 h4, {{WRAPPER}} .ebp-project-info-1 h5, {{WRAPPER}} .ebp-project-info-1 h6' => 'color: {{VALUE}}',
                ],
            ]
        );

        // Background colour – colour picker
        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ebp-project-info-1' => 'background-color: {{VALUE}}',
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

        // CSS classes for margin/padding only (colours use colour picker + Elementor selectors)
        $style_classes = [
            'margin-top-' . ($settings['margin_top'] ?? 'medium'),
            'margin-bottom-' . ($settings['margin_bottom'] ?? 'medium'),
            'padding-top-' . ($settings['padding_top'] ?? 'medium'),
            'padding-bottom-' . ($settings['padding_bottom'] ?? 'medium'),
        ];
        $style_class_string = implode(' ', $style_classes);

        $info_items = $settings['info_items'] ?? [];
        ?>
<!-- Project Info -->
<div class="ebp-project-info-1 <?php echo esc_attr($style_class_string); ?>">
    <div class="ebp-project-info-1-container">
        <?php if (!empty($info_items)): ?>
            <?php foreach ($info_items as $item): ?>
                <?php
                $rich_text = $item['rich_text'] ?? '';
                if (empty($rich_text)) {
                    continue;
                }
                ?>
                <div class="ebp-project-info-1-item">
                    <div class="ebp-project-info-1-item-content">
                        <?php echo wp_kses_post($rich_text); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php
    }
}