<?php

/**
 * Disable Emoji
 */
function disable_emojicons_tinymce($plugins) {
    if (is_array($plugins))
        return array_diff($plugins, array('wpemoji'));
    else
        return array();
}

function disable_wp_emojicons() {
    // all actions related to emojis
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');

    // filter to remove TinyMCE emojis
    add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
}

add_action('init', 'disable_wp_emojicons');


add_theme_support('post-thumbnails');

function add_file_types_to_uploads($file_types) {
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $new_filetypes['json'] = 'application/json'; // Adding .json extension
    $file_types = array_merge($file_types, $new_filetypes);
    return $file_types;
}

add_filter('upload_mimes', 'add_file_types_to_uploads');

/**
 * SEO URLS
 */
function seourl($string) {
    $string = strtolower(trim($string)); //Lower case everything
    $string = preg_replace("/\&/", "-and-", $string); //Change & to and
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string); //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[\s-]+/", " ", $string); //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s_]/", "-", $string); //Convert whitespaces and underscore to dash
    return $string;
}

add_theme_support( 'title-tag' );

register_nav_menus(
        array(
            'primary' => esc_html__('Primary menu', 'twentytwentyone'),
            'footer' => __('Secondary menu', 'twentytwentyone'),
        )
);

function wwoocommerce_support() {
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'wwoocommerce_support');