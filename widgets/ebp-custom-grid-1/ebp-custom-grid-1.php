<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Grid_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_grid_1';
    }

    public function get_title()
    {
        return __('EBP Custom Grid 1', 'ebp-custom-widgets');
    }

    public function get_icon()
    {


        // Fallback to default icon if file doesn't exist
        return 'eicon-grid-view';
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
        return ['ebp-custom-grid-1-style'];
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

        // Heading part 1 control (e.g., "Our")
        $this->add_control(
            'heading_part_1',
            [
                'label' => __('Heading Part 1', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g., Our', 'ebp-custom-widgets'),
            ]
        );

        // Heading part 2 control (e.g., "Projects")
        $this->add_control(
            'heading_part_2',
            [
                'label' => __('Heading Part 2', 'ebp-custom-widgets'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g., Projects', 'ebp-custom-widgets'),
            ]
        );

        // Repeater control for selecting and ordering projects
        $repeater = new \Elementor\Repeater();

        // Project selector - using query control to filter by post type
        $repeater->add_control(
            'project_id',
            [
                'label' => __('Select Project', 'ebp-custom-widgets'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_projects_list(),
                'default' => '',
            ]
        );

        $this->add_control(
            'projects_list',
            [
                'label' => __('Projects', 'ebp-custom-widgets'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => 'Project: {{{ project_id }}}',
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

    /**
     * Get list of all published projects for the select dropdown
     * Returns an array of project ID => project title
     */
    private function get_projects_list()
    {
        $projects = [];

        // Query all published projects
        $args = [
            'post_type' => 'projects',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
        ];

        $query = new \WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $projects[get_the_ID()] = get_the_title();
            }
            wp_reset_postdata();
        }

        return $projects;
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

        // Get the projects list from repeater
        $projects_list = $settings['projects_list'] ?? [];
        ?>
<!-- Grid  -->
<div class="ebp-custom-grid-1 <?php echo esc_attr($style_class_string); ?>">
    <div class="ebp-custom-grid-1-container">
        <!-- heading -->
        <?php if (!empty($settings['heading_part_1']) || !empty($settings['heading_part_2'])): ?>
        <div class="ebp-custom-grid-1-heading">
            <h2>
                <?php if (!empty($settings['heading_part_1'])): ?>
                <span
                    class="ebp-custom-grid-1-heading-part-1"><?php echo esc_html($settings['heading_part_1']); ?></span>
                <?php endif; ?>
                <?php if (!empty($settings['heading_part_2'])): ?>
                <span
                    class="ebp-custom-grid-1-heading-part-2"><?php echo esc_html($settings['heading_part_2']); ?></span>
                <?php endif; ?>
            </h2>
        </div>
        <?php endif; ?>
        <div class="ebp-custom-grid-1-row">
            <?php if (!empty($projects_list)): ?>
            <?php foreach ($projects_list as $item): ?>
            <?php
                            $project_id = $item['project_id'] ?? '';
                            if (empty($project_id)) {
                                continue;
                            }

                            // Get project data
                            $project = get_post($project_id);
                            if (!$project || $project->post_status !== 'publish') {
                                continue;
                            }

                            $project_title = get_the_title($project_id);
                            $featured_image = get_the_post_thumbnail_url($project_id, 'full');
                            $project_link = get_permalink($project_id);
                            ?>
            <a href="<?php echo esc_url($project_link); ?>" class="ebp-custom-grid-1-col">
                <div class="ebp-custom-grid-1-item">
                    <?php if ($featured_image): ?>
                    <div class="ebp-custom-grid-1-item-image">
                        <img src="<?php echo esc_url($featured_image); ?>"
                            alt="<?php echo esc_attr($project_title); ?>">
                    </div>
                    <?php endif; ?>
                    <?php if ($project_title): ?>
                    <div class="ebp-custom-grid-1-item-title">
                        <h3><?php echo esc_html($project_title); ?></h3>
                    </div>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
    }
}