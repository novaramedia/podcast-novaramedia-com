<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Enqueue CSS styles for the theme.
 *
 * Enqueues the main stylesheet from the theme's dist directory.
 *
 * @since 1.0.0
 * @return void
 */
function my_styles_method() {
  $template_dir = get_template_directory_uri();
  wp_enqueue_style( 'podcast-main-style', $template_dir . '/dist/style.css', array(), filemtime( get_template_directory() . '/dist/style.css' ) );
}
add_action( 'wp_enqueue_scripts', 'my_styles_method' );

if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
}

if ( function_exists( 'add_image_size' ) ) {
  add_image_size( 'name', 199, 299, true );
}

get_template_part( 'lib/post-types' );
get_template_part( 'lib/meta-boxes' );
get_template_part( 'lib/audio-url-fix' );
get_template_part( 'lib/cli-commands' );

/**
 * Deregister unneeded WordPress helper JavaScript files.
 *
 * Removes the wp-embed script from the frontend to improve performance
 * by reducing unnecessary JavaScript loading.
 *
 * @since 1.0.0
 * @return void
 */
function my_deregister_scripts() {
  wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );

/**
 * Deregister WordPress block CSS library.
 *
 * Removes the default WordPress block library CSS to prevent it from loading
 * on the frontend, which can improve performance and prevent style conflicts.
 *
 * @since 1.0.0
 * @return void
 */
function wps_deregister_styles() {
  wp_dequeue_style( 'wp-block-library' );
}

// Disable WordPress admin bar for all users
add_filter( 'show_admin_bar', '__return_false' );

/**
 * Remove WordPress version number from HTML meta tags.
 *
 * Returns an empty string to hide the WordPress version information
 * from the HTML head, which can be a security improvement.
 *
 * @since 1.0.0
 * @return string Empty string to remove version info
 */
function no_generator() {
  return '';
}
add_filter( 'the_generator', 'no_generator' );
