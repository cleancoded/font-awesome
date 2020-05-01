<?php
/*
Plugin Name: Cleancoded Font Awesome Icons
Plugin URI: http://www.cleancoded.com
Description: Use the Font Awesome icon set within WordPress.
Version: 1.0
Author: Cleancoded
Author URI: https://github.com/cleancoded/font-awesome
 */

define('FONTAWESOME_VERSION', '4.7.0');

function cleaancoded_register_plugin_styles()
{
    global $wp_styles;

    wp_enqueue_style('font-awesome-styles', plugins_url('assets/css/font-awesome.css', __FILE__), array(), FONTAWESOME_VERSION, 'all');
}
add_action('wp_enqueue_scripts', 'cleaancoded_register_plugin_styles');
add_action('admin_enqueue_scripts', 'cleaancoded_register_plugin_styles');

function cleaancoded_setup_shortcode($params)
{
    return '<i class="fa fa-' . esc_attr($params['name']) . '">&nbsp;</i>';
}
add_shortcode('icon', 'cleaancoded_setup_shortcode');

add_filter('widget_text', 'do_shortcode');

function cleaancoded_add_tinymce_hooks()
{
    if ((current_user_can('edit_posts') || current_user_can('edit_pages')) && get_user_option('rich_editing')) {
        add_filter('mce_external_plugins', 'cleaancoded_register_tinymce_plugin');
        add_filter('mce_buttons', 'cleaancoded_add_tinymce_buttons');
        add_filter('teeny_mce_buttons', 'cleaancoded_add_tinymce_buttons');
        add_filter('mce_css', 'cleaancoded_add_tinymce_editor_sytle');
    }
}
add_action('admin_init', 'cleaancoded_add_tinymce_hooks');

function cleaancoded_register_tinymce_plugin($plugin_array = array())
{
    $plugin_array['font_awesome_glyphs'] = plugins_url('assets/js/font-awesome.js', __FILE__);

    return $plugin_array;
}

function cleaancoded_add_tinymce_buttons($buttons = array())
{
    $buttons = (array) $buttons;
    array_push($buttons, '|', 'font_awesome_glyphs');

    return $buttons;
}

function cleaancoded_add_tinymce_editor_sytle($mce_css)
{
    $mce_css .= ', ' . plugins_url('assets/css/font-awesome.min.css', __FILE__);

    return $mce_css;
}
