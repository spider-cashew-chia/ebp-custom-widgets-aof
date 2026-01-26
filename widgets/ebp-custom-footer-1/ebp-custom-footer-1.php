<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Footer_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_footer_1';
    }

    public function get_title()
    {
        return __('EBP Custom Footer 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-footer';
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
        return ['ebp-custom-footer-1-style'];
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

        // Heading part 1 control (e.g., "Contact")
        $this->add_control(
            'heading_part_1',
            [
                'label' => __('Heading Part 1', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g., Contact', 'ebp-custom-widgets'),
            ]
        );

        // Heading part 2 control (e.g., "Us")
        $this->add_control(
            'heading_part_2',
            [
                'label' => __('Heading Part 2', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g., Us', 'ebp-custom-widgets'),
            ]
        );

        // Rich text control
        $this->add_control(
            'rich_text',
            [
                'label' => __('Rich Text', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter your content', 'ebp-custom-widgets'),
            ]
        );

        // Get available contact items from ACF options for the repeater
        $contact_options = [];
        if (function_exists('have_rows') && have_rows('contact', 'option')) {
            $index = 0;
            while (have_rows('contact', 'option')) {
                the_row();
                $link = get_sub_field('link');
                if ($link && !empty($link['title'])) {
                    // Use index as key and link title as label
                    $contact_options[$index] = $link['title'];
                }
                $index++;
            }
        }

        // Contact items repeater with drag-and-drop ordering
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'contact_item',
            [
                'label' => __('Contact Item', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => $contact_options,
                'default' => '',
                'description' => __('Select a contact item to display', 'ebp-custom-widgets'),
            ]
        );

        $this->add_control(
            'contact_items',
            [
                'label' => __('Contact Items', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ contact_item }}}',
                'description' => __('Add and reorder contact items. Drag items to change their display order.', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();

        // Policies Section
        $this->start_controls_section(
            'policies_section',
            [
                'label' => __('Policies', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Policies repeater with title and rich text
        $policies_repeater = new \Elementor\Repeater();

        // Policy title/label (what will be clickable)
        $policies_repeater->add_control(
            'policy_title',
            [
                'label' => __('Policy Title', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g., Privacy Policy', 'ebp-custom-widgets'),
                'label_block' => true,
            ]
        );

        // Rich text control inside repeater for policy content
        $policies_repeater->add_control(
            'policy_content',
            [
                'label' => __('Policy Content', 'ebp-custom-widgets'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '',
                'placeholder' => __('Enter your policy content', 'ebp-custom-widgets'),
            ]
        );

        $this->add_control(
            'policies_list',
            [
                'label' => __('Policies', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $policies_repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ policy_title }}}',
                'description' => __('Add policies. Each policy will open in a popup when clicked.', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
<!-- Footer  -->
<div class="ebp-footer-1">
    <div class="ebp-footer-1-container">
        <!-- heading -->
        <?php if (!empty($settings['heading_part_1']) || !empty($settings['heading_part_2'])): ?>
        <div class="ebp-footer-1-heading">
            <h2>
                <?php if (!empty($settings['heading_part_1'])): ?>
                <span class="ebp-footer-1-heading-part-1"><?php echo esc_html($settings['heading_part_1']); ?></span>
                <?php endif; ?>
                <?php if (!empty($settings['heading_part_2'])): ?>
                <span class="ebp-footer-1-heading-part-2"><?php echo esc_html($settings['heading_part_2']); ?></span>
                <?php endif; ?>
            </h2>
        </div>
        <?php endif; ?>
        <!-- row -->
        <div class="ebp-footer-1-row">
            <div class="ebp-footer-1-row-item">
                <!-- rich text -->
                <?php if (!empty($settings['rich_text'])): ?>
                <div class="ebp-footer-1-rich-text-content">
                    <?php echo wp_kses_post($settings['rich_text']); ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="ebp-footer-1-row-item">
                <!-- contact info -->
                <?php
                        // First, collect all contact data from ACF into an array
                        $contact_data = [];
                        if (have_rows('contact', 'option')):
                            $index = 0;
                            while (have_rows('contact', 'option')):
                                the_row();
                                $link = get_sub_field('link');
                                if ($link):
                                    $contact_data[$index] = $link;
                                endif;
                                $index++;
                            endwhile;
                        endif;

                        // Display contact items in the order specified by the repeater (drag-and-drop order)
                        if (!empty($settings['contact_items']) && is_array($settings['contact_items'])):
                            foreach ($settings['contact_items'] as $item):
                                $contact_index = $item['contact_item'];

                                // Get the contact data from our array
                                if (isset($contact_data[$contact_index])):
                                    $link = $contact_data[$contact_index];
                                    ?>
                <div class="ebp-footer-1-contact-item">
                    <p>
                        <a href="<?php echo esc_url($link['url']); ?>"
                            target="<?php echo esc_attr($link['target']); ?>">
                            <?php echo esc_html($link['title']); ?> </a>
                    </p>

                </div>
                <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
            </div>
        </div>

        <!-- copyright & socials -->
        <div class="ebp-footer-1-copyright-socials ">

            <!-- socials from options ACF -->
            <div class="ebp-footer-1-socials d-none">
                <?php if (have_rows('contact', 'option')): ?>
                <?php while (have_rows('contact', 'option')):
                                the_row(); ?>
                <?php $link = get_sub_field('link'); ?>
                <?php if ($link): ?>
                <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target']); ?>">
                    <?php echo esc_html($link['title']); ?>
                </a>
                <?php endif; ?>
                <?php endwhile; ?>
                <?php else: ?>
                <?php // No rows found ?>
                <?php endif; ?>
            </div>

            <!-- policies -->
            <div class="ebp-footer-1-policies">
                <?php if (!empty($settings['policies_list']) && is_array($settings['policies_list'])): ?>
                <?php foreach ($settings['policies_list'] as $index => $policy): ?>
                <?php if (!empty($policy['policy_title'])): ?>
                <button type="button" class="ebp-footer-1-policy-trigger"
                    data-policy-index="<?php echo esc_attr($index); ?>"
                    aria-label="<?php echo esc_attr($policy['policy_title']); ?>">
                    <?php echo esc_html($policy['policy_title']); ?>
                </button>
                <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Policy Popup Modal -->
            <div class="ebp-footer-1-policy-modal" role="dialog" aria-modal="true"
                aria-labelledby="ebp-policy-modal-title">
                <div class="ebp-footer-1-policy-modal-overlay"></div>
                <div class="ebp-footer-1-policy-modal-content">
                    <button type="button" class="ebp-footer-1-policy-modal-close" aria-label="Close policy popup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="ebp-footer-1-policy-modal-header">
                        <h3 id="ebp-policy-modal-title" class="ebp-footer-1-policy-modal-title"></h3>
                    </div>
                    <div class="ebp-footer-1-policy-modal-body">
                        <!-- Policy content will be inserted here via JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Pass policy data to JavaScript -->
            <?php if (!empty($settings['policies_list']) && is_array($settings['policies_list'])): ?>
            <script type="application/json" class="ebp-footer-1-policies-data">
            <?php
                // Prepare policy data for JavaScript
                $policies_data = [];
                foreach ($settings['policies_list'] as $index => $policy) {
                    if (!empty($policy['policy_title'])) {
                        $policies_data[$index] = [
                            'title' => $policy['policy_title'],
                            'content' => !empty($policy['policy_content']) ? $policy['policy_content'] : ''
                        ];
                    }
                }
                echo wp_json_encode($policies_data);
                ?>
            </script>
            <?php endif; ?>

            <!-- copyright -->
            <div class="ebp-footer-1-rich-text">
                <p>
                    &copy;
                    <?php echo date('Y'); ?>
                    <?php echo get_bloginfo('name'); ?>. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <?php
    }
}