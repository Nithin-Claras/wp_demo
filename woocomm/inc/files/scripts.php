<?php

/**
 * Enqueue scripts and styles.
 */
function load_css_js() {
    // CSS
    $cssFiles = [
        'main.css', 'font-awesome-5.css', 'fonts.css', 'stylesheet.css', 'responsive.css','swiper.min.css','simple-lightbox.css',
    ];

    foreach ($cssFiles as $key => $cssFile)
        wp_enqueue_style('custom-css-' . $key, get_template_directory_uri() . '/assets/css/' . $cssFile, false, filemtime(get_stylesheet_directory() . '/assets/css/' . $cssFile));

    //JS 
    $jsFiles = [
        'libs/swiper.min.js',
        'libs/jquery.matchHeight.js',
        'utils/main.js', 
        'script.js',
    ];

    //Enqueue custom jquery file
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/libs/jquery.min.js', false, filemtime(get_stylesheet_directory() . '/assets/js/libs/jquery.min.js'), false);

    //Enqueue other files
    foreach ($jsFiles as $key => $jsFile)
        wp_enqueue_script('custom-js-' . $key, get_template_directory_uri() . '/assets/js/' . $jsFile, false, filemtime(get_stylesheet_directory() . '/assets/js/' . $jsFile), true);
        
}

add_action('wp_enqueue_scripts', 'load_css_js');
