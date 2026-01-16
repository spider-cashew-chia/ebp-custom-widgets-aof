<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit;



class Ebp_Custom_Default_1 extends Widget_Base
{

    public function get_name()
    {
        return 'ebp_custom_default_1';
    }

    public function get_title()
    {
        return __('EBP Custom Default 1', 'ebp-custom-widgets');
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
        return ['ebp-custom-default-1-style'];
    }


    protected function register_controls()
    {

    }


    protected function render()
    {
        ?>
<!-- Default  -->


<?php
    }
}