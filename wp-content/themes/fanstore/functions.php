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

// Supporting Feature Image for CPT : fs_product
add_theme_support('post-thumbnails', array('fs_product'));