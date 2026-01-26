<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Header_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_header_1';
    }

    public function get_title()
    {
        return __('EBP Custom Header 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-header';
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
        return ['ebp-custom-header-1-style'];
    }


    protected function register_controls()
    {
        // Content Tab - Tagline
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Tagline field
        $this->add_control(
            'tagline',
            [
                'label' => __('Tagline', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Enter your tagline', 'ebp-custom-widgets'),
            ]
        );

        // Logo field
        $this->add_control(
            'logo',
            [
                'label' => __('Logo', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        // Location Repeater
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'location_name',
            [
                'label' => __('Location Name', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g., Liverpool', 'ebp-custom-widgets'),
            ]
        );

        $repeater->add_control(
            'country',
            [
                'label' => __('Country', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g., UK', 'ebp-custom-widgets'),
            ]
        );

        $repeater->add_control(
            'timezone',
            [
                'label' => __('Timezone', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'default' => 'America/New_York',
                'options' => [
                    'America/New_York' => 'Eastern Time (ET)',
                    'America/Chicago' => 'Central Time (CT)',
                    'America/Denver' => 'Mountain Time (MT)',
                    'America/Los_Angeles' => 'Pacific Time (PT)',
                    'Europe/London' => 'London (GMT)',
                    'Europe/Paris' => 'Paris (CET)',
                    'Asia/Tokyo' => 'Tokyo (JST)',
                    'Australia/Sydney' => 'Sydney (AEST)',
                ],
            ]
        );

        $this->add_control(
            'locations',
            [
                'label' => __('Locations', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ location_name }}}',
            ]
        );

        // Get available contact items from ACF options for the repeaters
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
        $contact_repeater = new \Elementor\Repeater();

        $contact_repeater->add_control(
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
                'fields' => $contact_repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ contact_item }}}',
                'description' => __('Add and reorder contact items. Drag items to change their display order.', 'ebp-custom-widgets'),
            ]
        );

        // Newsletter items repeater with drag-and-drop ordering
        $newsletter_repeater = new \Elementor\Repeater();

        $newsletter_repeater->add_control(
            'newsletter_item',
            [
                'label' => __('Newsletter Item', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => $contact_options,
                'default' => '',
                'description' => __('Select a contact item to display as newsletter link', 'ebp-custom-widgets'),
            ]
        );

        $this->add_control(
            'newsletter_items',
            [
                'label' => __('Newsletter Items', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $newsletter_repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ newsletter_item }}}',
                'description' => __('Add and reorder newsletter items. Drag items to change their display order.', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();

        // Home Page Load Animation Tab
        $this->start_controls_section(
            'home_page_load_section',
            [
                'label' => __('Home Page Load Animation', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Background image for home page load animation
        $this->add_control(
            'home_bg_image',
            [
                'label' => __('Background Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'description' => __('Background image for the home page load animation', 'ebp-custom-widgets'),
            ]
        );

        // Logo image for home page load animation
        $this->add_control(
            'home_logo_image',
            [
                'label' => __('Logo Image', 'ebp-custom-widgets'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'description' => __('Logo image that fades in after the text animation', 'ebp-custom-widgets'),
            ]
        );

        // First text field (Global)
        $this->add_control(
            'home_text_1',
            [
                'label' => __('Text 1 (Global)', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => __('First text field with character flicker animation', 'ebp-custom-widgets'),
            ]
        );

        // Second text field (Reach)
        $this->add_control(
            'home_text_2',
            [
                'label' => __('Text 2 (Reach)', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => __('Second text field with character flicker animation', 'ebp-custom-widgets'),
            ]
        );

        // Third text field (Local)
        $this->add_control(
            'home_text_3',
            [
                'label' => __('Text 3 (Local)', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => __('Third text field with character flicker animation', 'ebp-custom-widgets'),
            ]
        );

        // Fourth text field (Feel)
        $this->add_control(
            'home_text_4',
            [
                'label' => __('Text 4 (Feel)', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'description' => __('Fourth text field with character flicker animation', 'ebp-custom-widgets'),
            ]
        );

        $this->end_controls_section();

        // Style Tab
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Styles', 'ebp-custom-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Font color
        $this->add_control(
            'font_color',
            [
                'label' => __('Font Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ebp-header-1' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Heading color
        $this->add_control(
            'heading_color',
            [
                'label' => __('Heading Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ebp-header-1-tagline' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background color
        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'ebp-custom-widgets'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .ebp-header-1' => 'background-color: {{VALUE}};',
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

        // Get spacing classes from settings (only add if not "none")
        // Color controls are now handled by Elementor's selectors, so no classes needed
        $style_classes = [];

        if (!empty($settings['margin_top']) && $settings['margin_top'] !== 'none') {
            $style_classes[] = 'margin-top-' . $settings['margin_top'];
        }

        if (!empty($settings['margin_bottom']) && $settings['margin_bottom'] !== 'none') {
            $style_classes[] = 'margin-bottom-' . $settings['margin_bottom'];
        }

        if (!empty($settings['padding_top']) && $settings['padding_top'] !== 'none') {
            $style_classes[] = 'padding-top-' . $settings['padding_top'];
        }

        if (!empty($settings['padding_bottom']) && $settings['padding_bottom'] !== 'none') {
            $style_classes[] = 'padding-bottom-' . $settings['padding_bottom'];
        }

        $style_class_string = !empty($style_classes) ? implode(' ', $style_classes) : '';
        ?>
<!-- Custom Header 1 -->
<div class="ebp-header-1 <?php echo esc_attr($style_class_string); ?>">
    <div class="ebp-header-1-container">

        <!-- tagline -->
        <?php if (!empty($settings['tagline'])): ?>
        <div class="ebp-header-1-tagline" data-original-text="<?php echo esc_attr($settings['tagline']); ?>">
            <?php echo esc_html($settings['tagline']); ?>
        </div>
        <?php endif; ?>

        <!-- logo -->
        <?php if (!empty($settings['logo']['url'])): ?>
        <div class="ebp-header-1-logo">
            <img src="<?php echo esc_url($settings['logo']['url']); ?>"
                alt="<?php echo esc_attr($settings['logo']['alt'] ?? 'Logo'); ?>">
        </div>
        <?php endif; ?>



        <!-- locations & menu wrapper -->
        <div class="ebp-header-1-locations-menu-wrapper">

            <!-- locations -->
            <?php if (!empty($settings['locations'])): ?>
            <div class="ebp-header-1-locations">
                <?php foreach ($settings['locations'] as $index => $location): ?>
                <div class="ebp-header-1-location <?php echo $index === 0 ? 'ebp-header-1-location-primary' : 'ebp-header-1-location-secondary'; ?>"
                    data-timezone="<?php echo esc_attr($location['timezone']); ?>">
                    <span class="ebp-header-1-location-label" data-original-text="<?php
                                    $location_parts = array_filter([$location['location_name'], $location['country']]);
                                    echo esc_attr(strtoupper(implode(', ', $location_parts)));
                                    ?>">
                        <?php
                                        $location_parts = array_filter([$location['location_name'], $location['country']]);
                                        echo esc_html(strtoupper(implode(', ', $location_parts)));
                                        ?>
                    </span>
                    <span class="ebp-header-1-location-time"
                        data-timezone="<?php echo esc_attr($location['timezone']); ?>"></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- menu -->
            <div class="ebp-header-1-menu">
                <!-- menu toggle button -->
                <button class="ebp-header-1-menu-toggle">
                    <span class="ebp-header-1-menu-toggle-span">Menu</span>
                    <span class="ebp-header-1-menu-toggle--menu-bg"></span>
                </button>

                <!-- wp menu primary -->
                <?php
                        // Filter to add featured image data attribute to menu links
                        // This allows the JavaScript to display featured images on hover
                        // The filter only applies to the primary menu location, so it won't affect other menus
                        add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
                            // Only apply to the primary menu in this widget
                            if (isset($args->theme_location) && $args->theme_location === 'primary') {
                                // Get the object ID (post/page ID) from the menu item
                                $object_id = get_post_meta($item->ID, '_menu_item_object_id', true);
                                $object_type = get_post_meta($item->ID, '_menu_item_type', true);

                                // If this menu item links to a post or page, get its featured image
                                if ($object_type === 'post_type' && $object_id) {
                                    $featured_image_id = get_post_thumbnail_id($object_id);
                                    if ($featured_image_id) {
                                        // Get the full-size image URL
                                        $featured_image_url = wp_get_attachment_image_url($featured_image_id, 'full');
                                        if ($featured_image_url) {
                                            $atts['data-featured-image'] = esc_url($featured_image_url);
                                        }
                                    }
                                }
                            }
                            return $atts;
                        }, 10, 3);

                        wp_nav_menu([
                            'theme_location' => 'primary',
                            'menu_id' => 'ebp-header-1-menu-primary',
                        ]);
                        ?>
            </div>
        </div>


        <!-- Contact links and newsletter -->
        <div class="ebp-header-1-contact-newsletter">
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
                    ?>

            <!-- Contact items -->
            <div class="ebp-header-1-contact">
                <?php
                        // Display contact items in the order specified by the repeater (drag-and-drop order)
                        if (!empty($settings['contact_items']) && is_array($settings['contact_items'])):
                            foreach ($settings['contact_items'] as $item):
                                $contact_index = $item['contact_item'];

                                // Get the contact data from our array
                                if (isset($contact_data[$contact_index])):
                                    $contact_link = $contact_data[$contact_index];
                                    ?>
                <a href="<?php echo esc_url($contact_link['url']); ?>"
                    target="<?php echo esc_attr($contact_link['target']); ?>" class="ebp-header-1-contact-link">
                    <?php echo esc_html($contact_link['title']); ?>
                </a>
                <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
            </div>

            <!-- Newsletter items -->
            <div class="ebp-header-1-newsletter">
                <?php
                        // Display newsletter items in the order specified by the repeater (drag-and-drop order)
                        if (!empty($settings['newsletter_items']) && is_array($settings['newsletter_items'])):
                            foreach ($settings['newsletter_items'] as $item):
                                $newsletter_index = $item['newsletter_item'];

                                // Get the contact data from our array
                                if (isset($contact_data[$newsletter_index])):
                                    $newsletter_link = $contact_data[$newsletter_index];
                                    ?>
                <a href="<?php echo esc_url($newsletter_link['url']); ?>"
                    target="<?php echo esc_attr($newsletter_link['target']); ?>" class="ebp-header-1-newsletter-link">
                    <?php echo esc_html($newsletter_link['title']); ?>
                </a>
                <?php
                                endif;
                            endforeach;
                        endif;
                        ?>
            </div>
        </div>
    </div>

    <!-- home page load animation -->
    <?php
        $home_mask_id = 'ebp-home-mask-' . $this->get_id();
        $home_bg_image_url = !empty($settings['home_bg_image']['url']) ? $settings['home_bg_image']['url'] : '';
    ?>
    <?php if (is_front_page() && (!empty($home_bg_image_url) || !empty($settings['home_text_1']) || !empty($settings['home_text_2']) || !empty($settings['home_text_3']) || !empty($settings['home_text_4']))): ?>
    <div class="ebp-header-1-home-page-load-animation">
        <?php if (!empty($home_bg_image_url)): ?>
        <!-- background image with logo cut-out mask -->
        <div class="ebp-header-1-home-bg-image">
            <svg class="ebp-header-1-home-bg-svg" viewBox="0 0 1000 1000" preserveAspectRatio="xMidYMid slice"
                aria-hidden="true">
                <defs>
                    <mask id="<?php echo esc_attr($home_mask_id); ?>" maskUnits="userSpaceOnUse" x="0" y="0"
                        width="1000" height="1000">
                        <rect width="1000" height="1000" fill="#fff" />
                        <!-- The logo is black here so it becomes a transparent hole -->
                        <g class="ebp-header-1-home-mask-logo">
                            <path class="ebp-home-mask-solid" fill="#fff"
                                d="M444.36.38c357.42-14.06,600.31,365.44,420.64,680.89-172.08,302.13-616.97,308.63-797.71,11.53C-116.04,391.43,96.91,14.04,444.36.38ZM234.03,159.16c-27.96,3.05-85.29,68.22-102.28,91.46-22.93,31.35-68.56,106.34-53.3,145.05,7.1,18.02,37.22,22.29,51.37,10.38,8.23-40.21,14.74-88.5,33.65-125.22,2.43-4.73,8.72-17.94,13.28-7.95-13.85,21.05-21.96,48.71-28.18,73.23-3.06,12.07-11.54,44.06-8.5,54.53,1.62,5.56,6.4,10.85,12.19,12.01,7.06,1.42,31.34,1.21,38.99.35,23.55-2.64,35.8-39.58,37.13-59.7.81-12.27-.22-25.88-5.35-37.16-1.91-4.2-7.56-7.84-6.57-12.47.41-1.91,5.09-7.32,6.58-10.18,10.44-20.09,36.48-68.22,38.54-88.56,1.92-18.95-2.46-48.51-27.55-45.78ZM210.15,413h97.59c3.51,0,12.07-5.16,15.09-7.61,21.55-17.49,24.27-56.25-3.39-69.15-14.59-6.8-26.17-3.39-41.2-1.93-3.22-3.28,12.76-20.65,15.47-24.62,17.94-26.31,52.28-83.98,52.73-115.31.34-23.72-14.36-33.57-35.96-23.77-44.37,20.13-60.01,93.52-84.54,131.91-2.31,5.33,2.86,8.75,4.63,13.65,11.93,33.07,2.22,70.82-20.41,96.83ZM701.9,411.49h64.31c5.14,0,10.33-9.83,9.53-15.48-1.85-13.09-24.27-37.22-29.32-51.03,2.35-6.35,3.7-5.47,7.28-1.18,12.06,14.43,28.98,57.87,46.11,64.34,7.88,2.98,30.87,2.07,36.62-3.59,11.26-11.09,1.69-34.06-6.66-44.53-20.67-25.91-53.11-28-77.14-48.45-2.75-2.34-16.06-12.79-8.43-15.79,1.75-.69,11.13,1.46,16.76-.01,21.54-5.65,10.87-39.03,4.75-53.26-12.87-29.96-50.9-74.78-85.68-76.21-6.79-.28-19.41.68-21.75,8.72-3.04,10.44,13.61,19.95,9.61,26.18-2.13,3.31-12.24-4.48-16.37-1.24-16.52,9.93,3.11,15.52,9.82,25.87,10.65,16.42,7.63,38.42,20.85,53.29,6.88,7.73,16.57,13.37,23.36,22.03,23.78,30.36,25.32,82.57-3.66,110.33ZM326.66,413h105.16c2.93,0,10.91-5.58,12.87-8.31,12.04-16.77-.16-39.83-16.19-48.89-15.28-8.63-28.14-6.66-44.85-4.76-1.27-.32-2.11-3-2.12-4.11-.02-3.51,12.77-21.06,15.51-26.19,10.2-19.06,33.06-69.17,28.8-89.39-1.91-9.08-10.29-21.5-19.4-24.47-21-6.85-30.86,8.71-40.48,23.78-6.99,10.94-48.73,92.84-45.17,98.9,35.17,16.53,31.31,59.55,5.86,83.46ZM525.99,213.64c-17.7,2.98-27.95,27.07-29.71,42.92-4.89,44.1,1.82,148.49,61.11,154.94,7.19.78,39.25,1.17,45.04-.37,7.27-1.93,17.65-14.65,21.05-21.32,12.4-24.31,6.93-54.52-6.61-77.13-12.03-20.09-34.95-28.56-44.32-49.49-5.12-11.44-7.15-29.47-15.92-38.55-6.7-6.94-20.96-12.62-30.65-10.99ZM615.65,411.49h70.36c3.93,0,15.51-10.13,18.19-13.58,19.2-24.62,14.65-64.31-1.68-89.18-8.94-13.61-26.44-21.84-33.23-36.38-7.08-15.18-5.73-34.25-17.56-47.51-7.51-8.42-26.54-16.28-35.61-6.57-11.34,12.15,4.88,20.41,11.6,29.07,5.98,7.7,27.4,48.02,29.61,56.66,2.03,7.91-3.07,7.43-7.18,1.09-15.07-23.2-27.53-74.75-62.72-76.17-22.3-.9-14.98,15.17-9.26,28.61,9.17,21.53,22.8,24.56,36.56,40.61,26.55,30.97,32.51,83.69.91,113.33ZM303.6,460.3c-9.51,1.39-34.44,16.02-30.69,26.75,1.04,2.99,9.95,13.55,12.61,17.77,5.88,9.32,1.67,12.6,16.19,14.07,22.77,2.29,52.96-12,44.95-38.9-5.09-17.1-27.44-21.99-43.06-19.7ZM794.72,472.55c-1.28,1.21-4.95,6.29-5.12,7.85-.47,4.22,10.7,15.85,3.81,17.33-2.45.53-13.14-15.01-16.59-18.18-24.44-22.5-72.16-27.43-88.82,6.57-10.74,21.92.61,31.55,7.86,51.7,3.22,8.97,4.26,19.48,8.31,28.01,11.32,23.88,48.26,30.62,46,67.11-1.28,20.64-20.24,41.33-36.1,53.25-1.7,1.28-2.74,2.79-5.34,2.2-1.81-1.66-2.94-1.9-1.57-4.56,2.93-5.68,20.34-18.92,25.77-25.68,11.74-14.61,17.34-42.58-6.74-47.76-7.03-1.51-18.8-.8-23.66,5.26-3.12,3.89-7.91,26.01-11.45,33.95-13.2,29.67-40.5,57.3-73.86,61.55,3.35,55.48,59.02,53.2,98.83,36.04,64.47-27.78,137.16-112.75,77.4-179.86-15.6-17.52-45.67-28.95-46.16-55.96,4.11-4.22,11.24,14.26,13.61,17.39,16.43,21.7,47.28,36.7,73.65,23.72,27.12-13.35,24.07-51.84,5.62-71.23-10.64-11.18-32.53-20.91-45.46-8.71ZM393.24,521.95c19.23,3.84,32.16,11.77,52.25,4.58,32.98-11.8,16.93-43.1-6.8-55.34-48.69-25.13-92.77,5.84-82.83,60.14,1.34,7.33,4.63,14.34,5.42,21.82,1.81,17.31-4.01,30.27,7.13,45.83,17.05,23.82,32.79,33.25,29.36,67.45-.72,7.18-7.03,18.06-4.93,23.04,8.17,19.31,57.6,20.28,71.37,7.09,26.29-25.19,8.41-108.73-30.99-115.47-7.45-1.28-21.63,1.27-26.88-.37-2.4-.75-2.99-2.8-2.52-5.02.5-2.32,17.82-2.21,21.28-2.98,13.86-3.05,34.74-16.06,29.5-32.69-3.54-11.25-16.07-3.89-25.8-3.8-12.28.11-24.26-3.47-35.29-8.47l-.26-5.79ZM104.24,553.71c-.44-3.63.04-5.38,3.78-6.05,12.66-2.27,30.9,2.87,45.37,1.49,45.46-4.33,45.71-61.86,10.34-79.89-26.56-13.54-89.39-1.15-94.16,33.9-8.81,64.77,57.13,175.13,98.26,223.76,20.74,24.52,71.77,83.31,102,40.04,14.97-21.43-.12-44.15-17.43-58.03-31.78-25.48-74.85-45.09-102.02-78.03-2.53-3.06-10.78-12.76-8.18-16.53,4.09-1.61,8.72-1.53,12.83-3.06,26.87-10,24.25-52.2-6.32-55.91-5.87-.71-42.82-.06-44.46-1.69ZM512.77,549.19c-11.86,37.03-21.22,74.85-13.21,113.81,13.92,67.74,86.99,53.49,81.1-5.45-2.56-25.57-17.78-33.81-25.8-52.88-9.79-23.29,11.2-30.18,22.09-48.05,27.42-44.99,7.34-107.64-48.39-68.01,12.7,25.55,19.35,52.62,9.59,80.65-1.28,3.68-6.08,15.98-10.99,14.7-4.55-3.64,2.13-10.9,3.79-15.85,6.48-19.31,6.11-36.66,0-56.04-10-31.69-41.12-62.15-74.15-38.53,3.22,7.35,9.82,12.08,12.17,20.33,4.15,14.54.51,26.79-12.06,35.03,11.78,17.96,3.16,36.81-15.81,44.38l-.94,3.11c42.86,16.33,55.12,89.01,30.26,124.08,8.48.52,16.25-2.86,20.94-10.07,9.43-14.51-.16-27.72-1.32-43.57-2.39-32.4,3.45-70.59,18.95-99.07l3.81,1.43ZM202.66,488.6c-3.63-13.53-15.76-24.44-30.34-22.63,31.18,22.13,34.08,73.95-6.05,87.76,12.12,9.61,16.05,24.75,13.25,39.72-1.14,6.12-8.11,13.1-8.72,17.13-2.01,13.33,10.76,38.38,20.39,47.57,27.79,26.51,70.44,37.78,88.51,73.44l3.47.43c8.56-3.13,16.74-17.05,12.47-25.52-1.12-2.22-15.83-7.62-20.03-10.22-15.33-9.49-32.56-32.11-41.53-47.74-2.28-3.97-14.4-27.14-11.84-29.76,2.73-.34,4.29.06,6.11,2.19,2.81,3.29,7.64,17.06,10.82,22.47,16.23,27.6,47.4,66.43,83.78,54.11,21.85-7.4,17.02-32.3,6.74-47.8-10.41-15.71-52.69-33.11-71.02-45.48-3.88-2.62-26.58-16.47-21.31-21.8,64.32,12.91,61.59-61.19,27.08-94.42-14.3-13.77-41.68-26.44-58.38-10.78l2.46,8.93-5.88,2.4ZM570.26,706.54h34.04c104.8,0,121.91-182.6,38.78-232.45-15.58-9.34-40.23-14.74-48.9,5.94-5.06,12.05.69,16.44,1.79,27.55,1.58,15.91-2.67,33.5-9.84,47.63-2.82,5.56-9.52,12.54-10.99,17.76-1,3.54-5.27,37.85-4.88,40.4.74,4.86,11.27,20.01,13.68,27.3,4.98,15.08,5.83,33.09-.82,47.71-3.42,7.52-9.92,10.99-12.86,18.16ZM338.76,695.93c49.83,13.25,66.42-32.97,42.07-71.56-10.86-17.21-23.56-21.1-25.41-44.2-1.81-22.66,2.87-45.65-19.15-61.02-13.89,7.07-27.52,8.81-42.9,5.82,1.51,8.78,2.4,19.04,1.49,27.97-2.05,20.16-14.85,18.71-8.32,44.66,7.31,29,19.45,21.21,37.79,36.35,18.12,14.95,27.84,40.63,14.42,61.97Z"
                                fill="#fdf7ed" stroke-width="0" />
                            <path
                                d="M794.72,472.55c12.93-12.21,34.82-2.47,45.46,8.71,18.45,19.39,21.5,57.88-5.62,71.23-26.37,12.98-57.23-2.02-73.65-23.72-2.37-3.13-9.5-21.61-13.61-17.39.49,27.01,30.56,38.44,46.16,55.96,59.76,67.11-12.93,152.07-77.4,179.86-39.81,17.16-95.48,19.44-98.83-36.04,33.37-4.25,60.67-31.88,73.86-61.55,3.53-7.94,8.32-30.05,11.45-33.95,4.86-6.06,16.63-6.77,23.66-5.26,24.07,5.18,18.47,33.15,6.74,47.76-5.43,6.76-22.84,20.01-25.77,25.68-1.37,2.66-.24,2.9,1.57,4.56,2.6.59,3.64-.92,5.34-2.2,15.87-11.92,34.83-32.61,36.1-53.25,2.25-36.49-34.68-43.24-46-67.11-4.04-8.52-5.08-19.04-8.31-28.01-7.24-20.14-18.6-29.78-7.86-51.7,16.66-34,64.38-29.08,88.82-6.57,3.45,3.17,14.14,18.71,16.59,18.18,6.89-1.48-4.28-13.12-3.81-17.33.17-1.56,3.84-6.64,5.12-7.85Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M234.03,159.16c25.09-2.73,29.47,26.83,27.55,45.78-2.06,20.34-28.1,68.47-38.54,88.56-1.48,2.85-6.17,8.27-6.58,10.18-.99,4.63,4.66,8.28,6.57,12.47,5.13,11.27,6.16,24.89,5.35,37.16-1.33,20.12-13.59,57.06-37.13,59.7-7.66.86-31.94,1.07-38.99-.35-5.78-1.17-10.57-6.46-12.19-12.01-3.05-10.47,5.43-42.46,8.5-54.53,6.23-24.53,14.33-52.18,28.18-73.23-4.56-9.99-10.84,3.22-13.28,7.95-18.91,36.72-25.43,85.01-33.65,125.22-14.14,11.91-44.26,7.64-51.37-10.38-15.26-38.71,30.37-113.69,53.3-145.05,16.99-23.23,74.32-88.41,102.28-91.46ZM214.23,204.45c-5.3,1.49-17.33,22.55-17.4,28.03-.04,3.84,4.33,7.65,7.37,1.32,4.79-9.98,6.05-18.7,16.53-25.85-.21-3.73-3.33-4.4-6.5-3.5Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M104.24,553.71c1.64,1.63,38.6.98,44.46,1.69,30.57,3.71,33.19,45.91,6.32,55.91-4.12,1.53-8.74,1.45-12.83,3.06-2.6,3.78,5.65,13.47,8.18,16.53,27.17,32.94,70.24,52.55,102.02,78.03,17.32,13.88,32.4,36.6,17.43,58.03-30.23,43.26-81.26-15.52-102-40.04-41.13-48.63-107.07-159-98.26-223.76,4.77-35.06,67.6-47.45,94.16-33.9,35.36,18.03,35.12,75.56-10.34,79.89-14.46,1.38-32.71-3.75-45.37-1.49-3.74.67-4.21,2.42-3.78,6.05Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M202.66,488.6l5.88-2.4-2.46-8.93c16.7-15.66,44.08-2.99,58.38,10.78,34.51,33.23,37.24,107.33-27.08,94.42-5.27,5.34,17.43,19.19,21.31,21.8,18.34,12.37,60.62,29.77,71.02,45.48,10.27,15.5,15.11,40.4-6.74,47.8-36.38,12.32-67.55-26.51-83.78-54.11-3.18-5.41-8-19.18-10.82-22.47-1.82-2.14-3.39-2.53-6.11-2.19-2.56,2.61,9.56,25.79,11.84,29.76,8.97,15.63,26.2,38.25,41.53,47.74,4.2,2.6,18.91,8.01,20.03,10.22,4.27,8.47-3.92,22.39-12.47,25.52l-3.47-.43c-18.07-35.66-60.72-46.93-88.51-73.44-9.63-9.19-22.39-34.25-20.39-47.57.61-4.02,7.57-11.01,8.72-17.13,2.8-14.97-1.14-30.11-13.25-39.72,40.13-13.82,37.23-65.63,6.05-87.76,14.57-1.81,26.7,9.1,30.34,22.63ZM232.86,535.56c5.21,3.45,7.28-7.22,7.14-10.94-.17-4.55-6.72-23.56-12.43-22.33-6.32,1.36,4.31,14.89,4.96,19.3.45,3.06-1.42,12.82.33,13.98Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M570.26,706.54c2.94-7.17,9.44-10.64,12.86-18.16,6.65-14.62,5.8-32.64.82-47.71-2.41-7.28-12.93-22.43-13.68-27.3-.39-2.55,3.88-36.85,4.88-40.4,1.47-5.21,8.17-12.2,10.99-17.76,7.17-14.13,11.42-31.72,9.84-47.63-1.1-11.11-6.85-15.5-1.79-27.55,8.68-20.68,33.32-15.28,48.9-5.94,83.13,49.85,66.02,232.45-38.78,232.45h-34.04ZM628.53,600.64c-2.31.51-.61,12.71-1.45,16.72-1.8,8.65-6.64,12.1-12.74,17.54l2.1,5.07c11.76-3.84,19.81-18.88,18.8-30.83-.29-3.42-1.83-9.59-6.71-8.5Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M512.77,549.19l-3.81-1.43c-15.5,28.49-21.34,66.67-18.95,99.07,1.17,15.85,10.76,29.06,1.32,43.57-4.68,7.2-12.45,10.58-20.94,10.07,24.86-35.06,12.6-107.75-30.26-124.08l.94-3.11c18.97-7.57,27.59-26.42,15.81-44.38,12.57-8.24,16.21-20.49,12.06-35.03-2.35-8.25-8.95-12.97-12.17-20.33,33.04-23.61,64.15,6.84,74.15,38.53,6.12,19.38,6.49,36.72,0,56.04-1.66,4.94-8.34,12.21-3.79,15.85,4.9,1.28,9.71-11.02,10.99-14.7,9.76-28.03,3.12-55.1-9.59-80.65,55.73-39.63,75.81,23.02,48.39,68.01-10.89,17.86-31.88,24.75-22.09,48.05,8.02,19.07,23.25,27.3,25.8,52.88,5.89,58.94-67.18,73.19-81.1,5.45-8.01-38.97,1.35-76.79,13.21-113.81Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M701.9,411.49c28.98-27.76,27.43-79.97,3.66-110.33-6.78-8.66-16.48-14.31-23.36-22.03-13.23-14.87-10.2-36.87-20.85-53.29-6.71-10.35-26.34-15.94-9.82-25.87,4.12-3.24,14.24,4.55,16.37,1.24,4-6.22-12.65-15.73-9.61-26.18,2.34-8.04,14.96-9,21.75-8.72,34.78,1.43,72.82,46.26,85.68,76.21,6.11,14.23,16.78,47.61-4.75,53.26-5.63,1.48-15.01-.67-16.76.01-7.62,2.99,5.68,13.45,8.43,15.79,24.03,20.45,56.47,22.54,77.14,48.45,8.35,10.47,17.92,33.43,6.66,44.53-5.75,5.66-28.74,6.57-36.62,3.59-17.13-6.48-34.05-49.92-46.11-64.34-3.59-4.29-4.93-5.17-7.28,1.18,5.05,13.81,27.47,37.94,29.32,51.03.8,5.65-4.39,15.48-9.53,15.48h-64.31ZM726.1,245.04c4.8-8.87-14.64-32.14-21.86-30.24-7.34,1.93,6.38,10.68,8.87,13.73,2.68,3.28,9.1,20.47,12.99,16.5Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M393.24,521.95l.26,5.79c11.02,5,23.01,8.58,35.29,8.47,9.73-.09,22.26-7.45,25.8,3.8,5.24,16.63-15.64,29.64-29.5,32.69-3.46.76-20.78.66-21.28,2.98-.48,2.22.11,4.27,2.52,5.02,5.25,1.64,19.43-.9,26.88.37,39.4,6.75,57.28,90.28,30.99,115.47-13.77,13.19-63.2,12.22-71.37-7.09-2.11-4.98,4.21-15.85,4.93-23.04,3.43-34.2-12.31-43.63-29.36-67.45-11.14-15.56-5.31-28.52-7.13-45.83-.78-7.48-4.07-14.49-5.42-21.82-9.94-54.3,34.15-85.27,82.83-60.14,23.73,12.25,39.78,43.55,6.8,55.34-20.09,7.18-33.02-.74-52.25-4.58Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M210.15,413c22.63-26.01,32.34-63.75,20.41-96.83-1.76-4.89-6.94-8.31-4.63-13.65,24.54-38.39,40.17-111.78,84.54-131.91,21.6-9.8,36.3.05,35.96,23.77-.45,31.33-34.79,89-52.73,115.31-2.71,3.97-18.68,21.35-15.47,24.62,15.03-1.46,26.61-4.87,41.2,1.93,27.66,12.9,24.95,51.67,3.39,69.15-3.02,2.45-11.58,7.61-15.09,7.61h-97.59Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M525.99,213.64c9.69-1.63,23.95,4.05,30.65,10.99,8.77,9.08,10.8,27.11,15.92,38.55,9.37,20.93,32.29,29.41,44.32,49.49,13.54,22.61,19.01,52.81,6.61,77.13-3.4,6.67-13.78,19.39-21.05,21.32-5.79,1.54-37.85,1.15-45.04.37-59.29-6.45-66-110.84-61.11-154.94,1.76-15.85,12-39.94,29.71-42.92ZM535.43,255.69c-.12-.16-3.59-1.2-3.79-1.18-7.76.74-5.67,37.5,3.04,37.51,7.26-1.44-.11-11.21-.73-17.44-.43-4.32,2.06-18.14,1.48-18.89Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M326.66,413c25.46-23.9,29.31-66.92-5.86-83.46-3.56-6.06,38.17-87.96,45.17-98.9,9.63-15.07,19.48-30.63,40.48-23.78,9.11,2.97,17.49,15.4,19.4,24.47,4.26,20.22-18.6,70.33-28.8,89.39-2.74,5.13-15.53,22.68-15.51,26.19,0,1.1.84,3.78,2.12,4.11,16.7-1.9,29.57-3.86,44.85,4.76,16.04,9.06,28.23,32.12,16.19,48.89-1.96,2.73-9.95,8.31-12.87,8.31h-105.16Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M615.65,411.49c31.61-29.63,25.64-82.36-.91-113.33-13.76-16.05-27.39-19.07-36.56-40.61-5.72-13.44-13.04-29.51,9.26-28.61,35.19,1.42,47.65,52.97,62.72,76.17,4.11,6.33,9.21,6.81,7.18-1.09-2.22-8.64-23.64-48.96-29.61-56.66-6.72-8.66-22.93-16.92-11.6-29.07,9.07-9.72,28.1-1.85,35.61,6.57,11.82,13.26,10.48,32.33,17.56,47.51,6.78,14.54,24.29,22.77,33.23,36.38,16.33,24.86,20.88,64.55,1.68,89.18-2.69,3.45-14.26,13.58-18.19,13.58h-70.36Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M338.76,695.93c13.42-21.35,3.7-47.02-14.42-61.97-18.34-15.13-30.49-7.34-37.79-36.35-6.54-25.96,6.26-24.5,8.32-44.66.91-8.92.02-19.19-1.49-27.97,15.38,2.99,29.01,1.24,42.9-5.82,22.02,15.37,17.34,38.36,19.15,61.02,1.85,23.1,14.54,26.98,25.41,44.2,24.35,38.59,7.76,84.81-42.07,71.56Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M303.6,460.3c15.62-2.29,37.96,2.59,43.06,19.7,8.01,26.89-22.17,41.19-44.95,38.9-14.53-1.46-10.32-4.74-16.19-14.07-2.67-4.23-11.57-14.78-12.61-17.77-3.75-10.74,21.18-25.36,30.69-26.75Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M214.23,204.45c3.18-.9,6.29-.22,6.5,3.5-10.48,7.15-11.74,15.87-16.53,25.85-3.04,6.33-7.41,2.52-7.37-1.32.06-5.48,12.1-26.54,17.4-28.03Z"
                                fill="#f7f7f7" stroke-width="0" />
                            <path
                                d="M232.86,535.56c-1.75-1.16.12-10.92-.33-13.98-.65-4.41-11.28-17.94-4.96-19.3,5.71-1.23,12.27,17.78,12.43,22.33.14,3.72-1.94,14.39-7.14,10.94Z"
                                fill="#f7f7f7" stroke-width="0" />
                            <path
                                d="M628.53,600.64c4.88-1.08,6.43,5.09,6.71,8.5,1,11.95-7.05,26.99-18.8,30.83l-2.1-5.07c6.1-5.43,10.94-8.89,12.74-17.54.83-4.01-.86-16.21,1.45-16.72Z"
                                fill="#f7f7f7" stroke-width="0" />
                            <path
                                d="M726.1,245.04c-3.89,3.97-10.31-13.22-12.99-16.5-2.49-3.05-16.21-11.8-8.87-13.73,7.22-1.9,26.65,21.37,21.86,30.24Z"
                                fill="#f7f7f7" stroke-width="0" />
                            <path
                                d="M535.43,255.69c.58.75-1.91,14.57-1.48,18.89.62,6.23,7.99,16.01.73,17.44-8.7-.01-10.8-36.77-3.04-37.51.2-.02,3.67,1.03,3.79,1.18Z"
                                fill="#f7f7f7" stroke-width="0" />
                        </g>
                    </mask>
                </defs>
                <image href="<?php echo esc_url($home_bg_image_url); ?>" width="1000" height="1000"
                    preserveAspectRatio="xMidYMid slice" mask="url(#<?php echo esc_attr($home_mask_id); ?>)" />
            </svg>
        </div>
        <?php endif; ?>

        <!-- text fields in 2x2 grid -->
        <div class="ebp-header-1-home-text-wrapper">
            <!-- Row 1: Global | Reach -->
            <div class="ebp-header-1-home-text-row">
                <?php if (!empty($settings['home_text_1'])): ?>
                <div class="ebp-header-1-home-text-1"
                    data-original-text="<?php echo esc_attr($settings['home_text_1']); ?>">
                    <?php echo esc_html($settings['home_text_1']); ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($settings['home_text_2'])): ?>
                <div class="ebp-header-1-home-text-2"
                    data-original-text="<?php echo esc_attr($settings['home_text_2']); ?>">
                    <?php echo esc_html($settings['home_text_2']); ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- logo that fades in after animation -->
            <div class="ebp-header-1-home-logo">
                <svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 925.67 911.8">
                    <g id="Layer_1-2" data-name="Layer 1-2">
                    <g>
                        <path class="ebp-home-logo-solid"
                                d="M444.36.38c357.42-14.06,600.31,365.44,420.64,680.89-172.08,302.13-616.97,308.63-797.71,11.53C-116.04,391.43,96.91,14.04,444.36.38ZM234.03,159.16c-27.96,3.05-85.29,68.22-102.28,91.46-22.93,31.35-68.56,106.34-53.3,145.05,7.1,18.02,37.22,22.29,51.37,10.38,8.23-40.21,14.74-88.5,33.65-125.22,2.43-4.73,8.72-17.94,13.28-7.95-13.85,21.05-21.96,48.71-28.18,73.23-3.06,12.07-11.54,44.06-8.5,54.53,1.62,5.56,6.4,10.85,12.19,12.01,7.06,1.42,31.34,1.21,38.99.35,23.55-2.64,35.8-39.58,37.13-59.7.81-12.27-.22-25.88-5.35-37.16-1.91-4.2-7.56-7.84-6.57-12.47.41-1.91,5.09-7.32,6.58-10.18,10.44-20.09,36.48-68.22,38.54-88.56,1.92-18.95-2.46-48.51-27.55-45.78h0ZM210.15,413h97.59c3.51,0,12.07-5.16,15.09-7.61,21.55-17.49,24.27-56.25-3.39-69.15-14.59-6.8-26.17-3.39-41.2-1.93-3.22-3.28,12.76-20.65,15.47-24.62,17.94-26.31,52.28-83.98,52.73-115.31.34-23.72-14.36-33.57-35.96-23.77-44.37,20.13-60.01,93.52-84.54,131.91-2.31,5.33,2.86,8.75,4.63,13.65,11.93,33.07,2.22,70.82-20.41,96.83h0ZM701.9,411.49h64.31c5.14,0,10.33-9.83,9.53-15.48-1.85-13.09-24.27-37.22-29.32-51.03,2.35-6.35,3.7-5.47,7.28-1.18,12.06,14.43,28.98,57.87,46.11,64.34,7.88,2.98,30.87,2.07,36.62-3.59,11.26-11.09,1.69-34.06-6.66-44.53-20.67-25.91-53.11-28-77.14-48.45-2.75-2.34-16.06-12.79-8.43-15.79,1.75-.69,11.13,1.46,16.76-.01,21.54-5.65,10.87-39.03,4.75-53.26-12.87-29.96-50.9-74.78-85.68-76.21-6.79-.28-19.41.68-21.75,8.72-3.04,10.44,13.61,19.95,9.61,26.18-2.13,3.31-12.24-4.48-16.37-1.24-16.52,9.93,3.11,15.52,9.82,25.87,10.65,16.42,7.63,38.42,20.85,53.29,6.88,7.73,16.57,13.37,23.36,22.03,23.78,30.36,25.32,82.57-3.66,110.33h0ZM326.66,413h105.16c2.93,0,10.91-5.58,12.87-8.31,12.04-16.77-.16-39.83-16.19-48.89-15.28-8.63-28.14-6.66-44.85-4.76-1.27-.32-2.11-3-2.12-4.11-.02-3.51,12.77-21.06,15.51-26.19,10.2-19.06,33.06-69.17,28.8-89.39-1.91-9.08-10.29-21.5-19.4-24.47-21-6.85-30.86,8.71-40.48,23.78-6.99,10.94-48.73,92.84-45.17,98.9,35.17,16.53,31.31,59.55,5.86,83.46v-.02ZM525.99,213.64c-17.7,2.98-27.95,27.07-29.71,42.92-4.89,44.1,1.82,148.49,61.11,154.94,7.19.78,39.25,1.17,45.04-.37,7.27-1.93,17.65-14.65,21.05-21.32,12.4-24.31,6.93-54.52-6.61-77.13-12.03-20.09-34.95-28.56-44.32-49.49-5.12-11.44-7.15-29.47-15.92-38.55-6.7-6.94-20.96-12.62-30.65-10.99h.01ZM615.65,411.49h70.36c3.93,0,15.51-10.13,18.19-13.58,19.2-24.62,14.65-64.31-1.68-89.18-8.94-13.61-26.44-21.84-33.23-36.38-7.08-15.18-5.73-34.25-17.56-47.51-7.51-8.42-26.54-16.28-35.61-6.57-11.34,12.15,4.88,20.41,11.6,29.07,5.98,7.7,27.4,48.02,29.61,56.66,2.03,7.91-3.07,7.43-7.18,1.09-15.07-23.2-27.53-74.75-62.72-76.17-22.3-.9-14.98,15.17-9.26,28.61,9.17,21.53,22.8,24.56,36.56,40.61,26.55,30.97,32.51,83.69.91,113.33v.02ZM303.6,460.3c-9.51,1.39-34.44,16.02-30.69,26.75,1.04,2.99,9.95,13.55,12.61,17.77,5.88,9.32,1.67,12.6,16.19,14.07,22.77,2.29,52.96-12,44.95-38.9-5.09-17.1-27.44-21.99-43.06-19.7h0ZM794.72,472.55c-1.28,1.21-4.95,6.29-5.12,7.85-.47,4.22,10.7,15.85,3.81,17.33-2.45.53-13.14-15.01-16.59-18.18-24.44-22.5-72.16-27.43-88.82,6.57-10.74,21.92.61,31.55,7.86,51.7,3.22,8.97,4.26,19.48,8.31,28.01,11.32,23.88,48.26,30.62,46,67.11-1.28,20.64-20.24,41.33-36.1,53.25-1.7,1.28-2.74,2.79-5.34,2.2-1.81-1.66-2.94-1.9-1.57-4.56,2.93-5.68,20.34-18.92,25.77-25.68,11.74-14.61,17.34-42.58-6.74-47.76-7.03-1.51-18.8-.8-23.66,5.26-3.12,3.89-7.91,26.01-11.45,33.95-13.2,29.67-40.5,57.3-73.86,61.55,3.35,55.48,59.02,53.2,98.83,36.04,64.47-27.78,137.16-112.75,77.4-179.86-15.6-17.52-45.67-28.95-46.16-55.96,4.11-4.22,11.24,14.26,13.61,17.39,16.43,21.7,47.28,36.7,73.65,23.72,27.12-13.35,24.07-51.84,5.62-71.23-10.64-11.18-32.53-20.91-45.46-8.71h0ZM393.24,521.95c19.23,3.84,32.16,11.77,52.25,4.58,32.98-11.8,16.93-43.1-6.8-55.34-48.69-25.13-92.77,5.84-82.83,60.14,1.34,7.33,4.63,14.34,5.42,21.82,1.81,17.31-4.01,30.27,7.13,45.83,17.05,23.82,32.79,33.25,29.36,67.45-.72,7.18-7.03,18.06-4.93,23.04,8.17,19.31,57.6,20.28,71.37,7.09,26.29-25.19,8.41-108.73-30.99-115.47-7.45-1.28-21.63,1.27-26.88-.37-2.4-.75-2.99-2.8-2.52-5.02.5-2.32,17.82-2.21,21.28-2.98,13.86-3.05,34.74-16.06,29.5-32.69-3.54-11.25-16.07-3.89-25.8-3.8-12.28.11-24.26-3.47-35.29-8.47l-.26-5.79v-.02ZM104.24,553.71c-.44-3.63.04-5.38,3.78-6.05,12.66-2.27,30.9,2.87,45.37,1.49,45.46-4.33,45.71-61.86,10.34-79.89-26.56-13.54-89.39-1.15-94.16,33.9-8.81,64.77,57.13,175.13,98.26,223.76,20.74,24.52,71.77,83.31,102,40.04,14.97-21.43-.12-44.15-17.43-58.03-31.78-25.48-74.85-45.09-102.02-78.03-2.53-3.06-10.78-12.76-8.18-16.53,4.09-1.61,8.72-1.53,12.83-3.06,26.87-10,24.25-52.2-6.32-55.91-5.87-.71-42.82-.06-44.46-1.69h-.01ZM512.77,549.19c-11.86,37.03-21.22,74.85-13.21,113.81,13.92,67.74,86.99,53.49,81.1-5.45-2.56-25.57-17.78-33.81-25.8-52.88-9.79-23.29,11.2-30.18,22.09-48.05,27.42-44.99,7.34-107.64-48.39-68.01,12.7,25.55,19.35,52.62,9.59,80.65-1.28,3.68-6.08,15.98-10.99,14.7-4.55-3.64,2.13-10.9,3.79-15.85,6.48-19.31,6.11-36.66,0-56.04-10-31.69-41.12-62.15-74.15-38.53,3.22,7.35,9.82,12.08,12.17,20.33,4.15,14.54.51,26.79-12.06,35.03,11.78,17.96,3.16,36.81-15.81,44.38l-.94,3.11c42.86,16.33,55.12,89.01,30.26,124.08,8.48.52,16.25-2.86,20.94-10.07,9.43-14.51-.16-27.72-1.32-43.57-2.39-32.4,3.45-70.59,18.95-99.07l3.81,1.43h-.03ZM202.66,488.6c-3.63-13.53-15.76-24.44-30.34-22.63,31.18,22.13,34.08,73.95-6.05,87.76,12.12,9.61,16.05,24.75,13.25,39.72-1.14,6.12-8.11,13.1-8.72,17.13-2.01,13.33,10.76,38.38,20.39,47.57,27.79,26.51,70.44,37.78,88.51,73.44l3.47.43c8.56-3.13,16.74-17.05,12.47-25.52-1.12-2.22-15.83-7.62-20.03-10.22-15.33-9.49-32.56-32.11-41.53-47.74-2.28-3.97-14.4-27.14-11.84-29.76,2.73-.34,4.29.06,6.11,2.19,2.81,3.29,7.64,17.06,10.82,22.47,16.23,27.6,47.4,66.43,83.78,54.11,21.85-7.4,17.02-32.3,6.74-47.8-10.41-15.71-52.69-33.11-71.02-45.48-3.88-2.62-26.58-16.47-21.31-21.8,64.32,12.91,61.59-61.19,27.08-94.42-14.3-13.77-41.68-26.44-58.38-10.78l2.46,8.93-5.88,2.4h.02ZM570.26,706.54h34.04c104.8,0,121.91-182.6,38.78-232.45-15.58-9.34-40.23-14.74-48.9,5.94-5.06,12.05.69,16.44,1.79,27.55,1.58,15.91-2.67,33.5-9.84,47.63-2.82,5.56-9.52,12.54-10.99,17.76-1,3.54-5.27,37.85-4.88,40.4.74,4.86,11.27,20.01,13.68,27.3,4.98,15.08,5.83,33.09-.82,47.71-3.42,7.52-9.92,10.99-12.86,18.16h0ZM338.76,695.93c49.83,13.25,66.42-32.97,42.07-71.56-10.86-17.21-23.56-21.1-25.41-44.2-1.81-22.66,2.87-45.65-19.15-61.02-13.89,7.07-27.52,8.81-42.9,5.82,1.51,8.78,2.4,19.04,1.49,27.97-2.05,20.16-14.85,18.71-8.32,44.66,7.31,29,19.45,21.21,37.79,36.35,18.12,14.95,27.84,40.63,14.42,61.97h0Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M214.23,204.45c-5.3,1.49-17.33,22.55-17.4,28.03-.04,3.84,4.33,7.65,7.37,1.32,4.79-9.98,6.05-18.7,16.53-25.85-.21-3.73-3.33-4.4-6.5-3.5Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M628.53,600.64c-2.31.51-.61,12.71-1.45,16.72-1.8,8.65-6.64,12.1-12.74,17.54l2.1,5.07c11.76-3.84,19.81-18.88,18.8-30.83-.29-3.42-1.83-9.59-6.71-8.5h0Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M726.1,245.04c4.8-8.87-14.64-32.14-21.86-30.24-7.34,1.93,6.38,10.68,8.87,13.73,2.68,3.28,9.1,20.47,12.99,16.5h0Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M535.43,255.69c-.12-.16-3.59-1.2-3.79-1.18-7.76.74-5.67,37.5,3.04,37.51,7.26-1.44-.11-11.21-.73-17.44-.43-4.32,2.06-18.14,1.48-18.89h0Z"
                                fill="#fff" stroke-width="0" />
                            <path
                                d="M214.23,204.45c3.18-.9,6.29-.22,6.5,3.5-10.48,7.15-11.74,15.87-16.53,25.85-3.04,6.33-7.41,2.52-7.37-1.32.06-5.48,12.1-26.54,17.4-28.03Z"
                                fill="#f7f7f7" stroke-width="0" />
                            <path
                                d="M232.86,535.56c-1.75-1.16.12-10.92-.33-13.98-.65-4.41-11.28-17.94-4.96-19.3,5.71-1.23,12.27,17.78,12.43,22.33.14,3.72-1.94,14.39-7.14,10.94h0Z"
                                fill="#f7f7f7" stroke-width="0" />
                            <path
                                d="M628.53,600.64c4.88-1.08,6.43,5.09,6.71,8.5,1,11.95-7.05,26.99-18.8,30.83l-2.1-5.07c6.1-5.43,10.94-8.89,12.74-17.54.83-4.01-.86-16.21,1.45-16.72h0Z"
                                fill="#f7f7f7" stroke-width="0" />
                            <path
                                d="M726.1,245.04c-3.89,3.97-10.31-13.22-12.99-16.5-2.49-3.05-16.21-11.8-8.87-13.73,7.22-1.9,26.65,21.37,21.86,30.24h0Z"
                                fill="#f7f7f7" stroke-width="0" />
                            <path
                                d="M535.43,255.69c.58.75-1.91,14.57-1.48,18.89.62,6.23,7.99,16.01.73,17.44-8.7-.01-10.8-36.77-3.04-37.51.2-.02,3.67,1.03,3.79,1.18h0Z"
                                fill="#f7f7f7" stroke-width="0" />
                        </g>
                    </g>
                </svg>
            </div>

            <!-- Row 2: Local | Feel -->
            <div class="ebp-header-1-home-text-row">
                <?php if (!empty($settings['home_text_3'])): ?>
                <div class="ebp-header-1-home-text-3"
                    data-original-text="<?php echo esc_attr($settings['home_text_3']); ?>">
                    <?php echo esc_html($settings['home_text_3']); ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($settings['home_text_4'])): ?>
                <div class="ebp-header-1-home-text-4"
                    data-original-text="<?php echo esc_attr($settings['home_text_4']); ?>">
                    <?php echo esc_html($settings['home_text_4']); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>


    </div>
    <?php endif; ?>

    <?php
    }

}