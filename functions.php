<?php
function my_scripts_method() {
  $templateuri = get_template_directory_uri() . '/js/';

  $myscripts = $templateuri."my.js";
//    wp_enqueue_script( 'myscripts', $myscripts,'','',true);
}
add_action('wp_enqueue_scripts', 'my_scripts_method');

if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
}
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'name', 199, 299, true );
}

get_template_part( 'lib/post-types' );
get_template_part( 'lib/meta-boxes' );

// Deregister unneeded wp helper js
function my_deregister_scripts(){
  wp_dequeue_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Deregister block css library
add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
function wps_deregister_styles() {
  wp_dequeue_style( 'wp-block-library' );
}

/* disable that freaking admin bar */
add_filter('show_admin_bar', '__return_false');
/* turn off version in meta */
function no_generator() { return ''; }
add_filter( 'the_generator', 'no_generator' );
?>