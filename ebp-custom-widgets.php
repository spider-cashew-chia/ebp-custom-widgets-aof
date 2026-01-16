<?php
/**
 * Plugin Name: EBP Custom Widgets
 * Description: Custom Elementor widgets for e-blueprint digital.
 * Version: 2.0
 * Author: e-blueprint digital
 */

if (!defined('ABSPATH'))
    exit;

// Register custom category with very early priority
function add_ebp_custom_widgets_category($elements_manager)
{
    $elements_manager->add_category(
        'ebp-custom-widgets',
        [
            'title' => __('EBP Custom Widgets', 'ebp-custom-widgets'),
            'icon' => 'fa fa-star',
        ],
        1 // Position at the top
    );
}
add_action('elementor/elements/categories_registered', 'add_ebp_custom_widgets_category', 1);

// Register menu locations
// This registers the "Primary" menu location that can be used in the header widget
function register_ebp_menu_locations()
{
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'ebp-custom-widgets'),
    ));
}
add_action('init', 'register_ebp_menu_locations');

// Automatically register all widgets from the widgets directory
// This function scans the widgets folder and registers any widget it finds
function register_all_ebp_custom_widgets($widgets_manager)
{
    // Get the widgets directory path
    $widgets_dir = __DIR__ . '/widgets';

    // Check if the directory exists
    if (!is_dir($widgets_dir)) {
        return;
    }

    // Scan the widgets directory for all widget folders
    $widget_folders = array_filter(glob($widgets_dir . '/*'), 'is_dir');

    // Loop through each widget folder
    foreach ($widget_folders as $widget_folder) {
        // Get the folder name (e.g., "ebp-custom-hero-1")
        $folder_name = basename($widget_folder);

        // Construct the PHP file path
        $widget_file = $widget_folder . '/' . $folder_name . '.php';

        // Check if the widget file exists
        if (!file_exists($widget_file)) {
            continue;
        }

        // Convert folder name to class name
        // Example: "ebp-custom-hero-1" -> "Ebp_Custom_Hero_1"
        $class_name = convert_folder_to_class_name($folder_name);

        // Require the widget file
        require_once($widget_file);

        // Check if the class exists before trying to instantiate it
        if (class_exists($class_name)) {
            // Register the widget
            $widgets_manager->register(new $class_name());
        }
    }
}
add_action('elementor/widgets/register', 'register_all_ebp_custom_widgets');

// Helper function to convert folder name to class name
// Example: "ebp-custom-hero-1" -> "Ebp_Custom_Hero_1"
function convert_folder_to_class_name($folder_name)
{
    // Remove the "ebp-custom-" prefix
    $name_without_prefix = str_replace('ebp-custom-', '', $folder_name);

    // Split by hyphens
    $parts = explode('-', $name_without_prefix);

    // Capitalize each part and join with underscores
    $capitalized_parts = array_map('ucfirst', $parts);
    $class_suffix = implode('_', $capitalized_parts);

    // Return the full class name
    return 'Ebp_Custom_' . $class_suffix;
}






// Dynamically enqueue all CSS files from assets/css directory
// This function scans the directory and automatically enqueues any CSS files found
function enqueue_dynamic_css_files()
{
    // Path to the CSS directory
    $css_dir = __DIR__ . '/assets/css';

    // Check if the directory exists
    if (!is_dir($css_dir)) {
        return;
    }

    // Get all CSS files from the directory
    // Using glob to find all .css files
    $css_files = glob($css_dir . '/*.css');

    // Loop through each CSS file and enqueue it
    foreach ($css_files as $css_file) {
        // Get just the filename (e.g., "animate.css")
        $filename = basename($css_file);

        // Skip main.css and app.min.css - these will be loaded last
        if ($filename === 'main.css' || $filename === 'app.min.css') {
            continue;
        }

        // Create a unique handle based on the filename (remove .css extension)
        $handle = 'ebp-' . str_replace('.css', '', $filename);

        // Enqueue the CSS file
        // Using filemtime() to get file modification time for cache busting
        wp_enqueue_style(
            $handle,
            plugins_url('/assets/css/' . $filename, __FILE__),
            [], // No dependencies
            file_exists($css_file) ? filemtime($css_file) : '1.0.0' // Version based on file modification time
        );
    }
}

// Dynamically enqueue all JavaScript files from assets/js directory
// This function scans the directory and automatically enqueues any JS files found
function enqueue_dynamic_js_files()
{
    // Path to the JS directory
    $js_dir = __DIR__ . '/assets/js';

    // Check if the directory exists
    if (!is_dir($js_dir)) {
        return;
    }

    // Get all JavaScript files from the directory
    // Using glob to find all .js files (excluding .map files)
    $js_files = glob($js_dir . '/*.js');

    // Loop through each JS file and enqueue it
    foreach ($js_files as $js_file) {
        // Get just the filename (e.g., "aos.js")
        $filename = basename($js_file);

        // Skip .map files (source maps)
        if (strpos($filename, '.map') !== false) {
            continue;
        }

        // Create a unique handle based on the filename (remove .js extension)
        $handle = 'ebp-' . str_replace('.js', '', $filename);

        // Determine dependencies - most scripts will need jQuery
        // You can customize this logic if certain files don't need jQuery
        $dependencies = ['jquery'];

        // Enqueue the JavaScript file
        // Using filemtime() to get file modification time for cache busting
        // Scripts load in the footer (true) for better page load performance
        wp_enqueue_script(
            $handle,
            plugins_url('/assets/js/' . $filename, __FILE__),
            $dependencies,
            file_exists($js_file) ? filemtime($js_file) : '1.0.0', // Version based on file modification time
            true // Load in footer
        );
    }
}

// Enqueue widget assets only on frontend
function my_widget_assets()
{
    // Only load on frontend, not in admin or Elementor editor
    if (is_admin() || (defined('ELEMENTOR_VERSION') && \Elementor\Plugin::$instance->editor->is_edit_mode())) {
        return;
    }

    // Dynamically enqueue all CSS files from assets/css directory
    // This will automatically include animate.css and any other CSS files
    enqueue_dynamic_css_files();

    // Dynamically enqueue all JavaScript files from assets/js directory
    // This will automatically include aos.js and any other JS files
    enqueue_dynamic_js_files();



    // Automatically enqueue assets for all widgets
    // This scans the widgets directory and enqueues CSS and JS files for each widget
    $widgets_dir = __DIR__ . '/widgets';

    // Check if the directory exists
    if (is_dir($widgets_dir)) {
        // Scan the widgets directory for all widget folders
        $widget_folders = array_filter(glob($widgets_dir . '/*'), 'is_dir');

        // Loop through each widget folder
        foreach ($widget_folders as $widget_folder) {
            // Get the folder name (e.g., "ebp-custom-hero-1")
            $folder_name = basename($widget_folder);

            // Construct asset file paths
            $style_file = $widget_folder . '/assets/style.css';
            $script_file = $widget_folder . '/assets/script.js';

            // Enqueue CSS if it exists
            if (file_exists($style_file)) {
                wp_enqueue_style(
                    $folder_name . '-style',
                    plugins_url('/widgets/' . $folder_name . '/assets/style.css', __FILE__),
                    [],
                    file_exists($style_file) ? filemtime($style_file) : '1.0.0'
                );
            }

            // Enqueue JS if it exists
            if (file_exists($script_file)) {
                wp_enqueue_script(
                    $folder_name . '-script',
                    plugins_url('/widgets/' . $folder_name . '/assets/script.js', __FILE__),
                    ['jquery'],
                    file_exists($script_file) ? filemtime($script_file) : '1.0.0',
                    true
                );
            }
        }
    }

    // Enqueue main.css and app.min.css last, after all other CSS files
    // These files need to load after everything else to override or extend other styles
    $main_css_path = __DIR__ . '/assets/css/main.css';
    $app_min_css_path = __DIR__ . '/assets/css/app.min.css';

    if (file_exists($main_css_path)) {
        wp_enqueue_style(
            'main-css',
            plugins_url('/assets/css/main.css', __FILE__),
            [], // No dependencies - WordPress will load it after previously enqueued styles
            filemtime($main_css_path)
        );
    }

    if (file_exists($app_min_css_path)) {
        wp_enqueue_style(
            'app-min-css',
            plugins_url('/assets/css/app.min.css', __FILE__),
            [], // No dependencies - WordPress will load it after previously enqueued styles
            filemtime($app_min_css_path)
        );
    }
}
add_action('wp_enqueue_scripts', 'my_widget_assets');

// Add loading animation to page head - because we need it there from the start
function add_loading_animation_to_head()
{
    // Only add on frontend, not in admin or Elementor editor
    if (is_admin() || (defined('ELEMENTOR_VERSION') && \Elementor\Plugin::$instance->editor->is_edit_mode())) {
        return;
    }
    ?>
<!-- <div id="ebp-loading-overlay">
        <div class="ebp-loading-content"></div>
    </div> -->
<?php
}
add_action('wp_head', 'add_loading_animation_to_head', 1);