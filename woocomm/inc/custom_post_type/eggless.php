<?php
function eggless_post_type() {
    $labels = array(
        'name' => _x('Eggless', 'Post Type General Name', 'elite cake'),
        'singular_name' => _x('Eggless', 'Post Type Singular Name', 'elite cake'),
        'menu_name' => __('Eggless', 'elite cake'),
        'parent_item_colon' => __('Parent Eggless', 'elite cake'),
        'all_items' => __('All Eggless', 'elite cake'),
        'view_item' => __('View Eggless', 'elite cake'),
        'add_new_item' => __('Add New Eggless', 'elite cake'),
        'add_new' => __('Add New', 'elite cake'),
        'edit_item' => __('Edit Eggless', 'elite cake'),
        'update_item' => __('Update Eggless', 'elite cake'),
        'search_items' => __('Search Eggless', 'elite cake'),
        'not_found' => __('Not Found', 'elite cake'),
        'not_found_in_trash' => __('Not found in Trash', 'elite cake'),
    );

    $args = array(
        'label' => __('Eggless', 'elite cake'),
        'description' => __('Eggless', 'elite cake'),
        'labels' => $labels,
        'supports' => array('title', 'revisions', 'editor', 'author', 'page-attributes', 'thumbnail','excerpt'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-welcome-write-blog',
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',  	
    );

    register_post_type('Eggless', $args);
}

add_action('init', 'eggless_post_type', 0);

function eggless_category_taxonomy() {

    $taxonomy = 'eggless-category';
    $object_type = 'eggless';
    $labels = array(
        'name' => 'Category',
        'singular_name' => 'Category',
        'search_items' => 'Search Category',
        'all_items' => 'All Category',
        'parent_item' => 'Parent Category',
        'parent_item_colon' => 'Parent Category:',
        'update_item' => 'Update Category',
        'edit_item' => 'Edit Category',
        'add_new_item' => 'Add New Category',
        'new_item_name' => 'New Category Name',
        'menu_name' => 'Category'
    ); 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'how_in_nav_menus' => true,
        'public' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'eggless-category')
    );
    register_taxonomy($taxonomy, $object_type, $args);
}

add_action('init', 'eggless_category_taxonomy');