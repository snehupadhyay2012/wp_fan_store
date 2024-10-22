<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enqueue Theme Stylesheet
 * @return void
 */
function fs_enqueue_theme_scripts() {
    wp_enqueue_style('fs-theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'fs_enqueue_theme_scripts');

/**
 * Add Custom Site Logo Feature
 * @return void
 */
function fs_theme_custom_logo() {
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'fs_theme_custom_logo');

/**
 * Primary Menu option, appears on theme customize page.
 * @return void
 */
function fs_theme_register_menus() {
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'textdomain'),
    ));
}
add_action('init', 'fs_theme_register_menus');


/**
 * Register Custom Post Type (fs_product)
 * @return void
 */
function register_fs_product_cpt() {
    $labels = array(
        'name'               => __('Products', 'textdomain'),
        'singular_name'      => __('Product', 'textdomain'),
        'add_new'            => __('Add New Product', 'textdomain'),
        'add_new_item'       => __('Add New Product', 'textdomain'),
        'edit_item'          => __('Edit Product', 'textdomain'),
        'new_item'           => __('New Product', 'textdomain'),
        'view_item'          => __('View Product', 'textdomain'),
        'search_items'       => __('Search Products', 'textdomain'),
        'not_found'          => __('No products found', 'textdomain'),
        'not_found_in_trash' => __('No products found in Trash', 'textdomain'),
        'all_items'          => __('All Products', 'textdomain'),
        'menu_name'          => __('Products', 'textdomain'),
        'name_admin_bar'     => __('Product', 'textdomain'), // This affects the label in the top admin bar
    );

    $args = array(
        'label'               => __('Products', 'textdomain'),
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'supports'            => array('title', 'thumbnail'),
        'show_in_rest'        => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-products',
    );
    register_post_type('fs_product', $args);
}
add_action('init', 'register_fs_product_cpt');

/**
 * Add action hook for CF : (short description)
 * @return void
 */
function add_short_description_meta_boxes() {
    add_meta_box(
        'short_description_meta',
        'Short Description',
        'render_short_description_box',
        'fs_product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_short_description_meta_boxes');

/**
 * Render Textarea field on CPT fs_product
 * @param mixed $post
 * @return void
 */
function render_short_description_box($post) {
    $value = get_post_meta($post->ID, '_short_description', true);
    ?>
    <textarea style="width:100%" rows="5" name="short_description"><?php echo esc_textarea($value); ?></textarea>
    <?php
}

/**
 * Save Custom Fields Data
 * @param mixed $post_id
 * @return void
 */
function save_custom_meta_data($post_id) {
    if (array_key_exists('short_description', $_POST)) {
        update_post_meta($post_id, '_short_description', sanitize_text_field($_POST['short_description']));
    }
}
add_action('save_post', 'save_custom_meta_data');

// Supporting Feature Image for CPT : fs_product
add_theme_support('post-thumbnails', array('fs_product'));