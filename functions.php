<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Enqueue CSS styles for the theme.
 *
 * Enqueues the main stylesheet from the theme's dist directory.
 *
 * @since 1.2.0
 * @return void
 */
function my_styles_method() {
  $template_dir = get_template_directory_uri();
  $theme_version = wp_get_theme()->get( 'Version' );
  wp_enqueue_style( 'podcast-main-style', $template_dir . '/dist/style.css', array(), $theme_version );
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
 * Allow cross-domain redirects to novaramedia.com.
 *
 * Single post redirects stored in _cmb_redirect meta target novaramedia.com.
 * This filter adds that host to the list of allowed redirect destinations so
 * wp_safe_redirect() permits the redirect rather than falling back to
 * admin_url() via wp_validate_redirect().
 *
 * @since 1.3.0
 * @param string[] $hosts Allowed redirect hostnames.
 * @return string[] Modified list of allowed redirect hostnames.
 */
function nm_allowed_redirect_hosts( $hosts ) {
  $hosts[] = 'novaramedia.com';
  $hosts[] = 'www.novaramedia.com';
  return $hosts;
}
add_filter( 'allowed_redirect_hosts', 'nm_allowed_redirect_hosts' );

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

// Resolve the "Novara Audio Main Feed" wrapper category ID by slug at runtime.
// Returns null if the term doesn't exist, so callers can skip parent-preference logic safely.
function nm_audio_cat_id() {
  static $id = false;
  if ( false === $id ) {
    $term = get_term_by( 'slug', 'audio', 'category' );
    $id   = $term ? (int) $term->term_id : null;
  }
  return $id;
}

// Resolve the show prefix for a post from its category name.
function nm_get_show_prefix( $post_id ) {
  $show_cat = null;

  foreach ( get_the_category( $post_id ) as $cat ) {
    if ( in_array( $cat->slug, array( 'audio', 'uncategorized' ), true ) ) {
      continue;
    }
    // Prefer children of the audio wrapper; fall back to any non-skipped category.
    $audio_id = nm_audio_cat_id();
    if ( null === $show_cat || ( null !== $audio_id && (int) $cat->parent === $audio_id ) ) {
      $show_cat = $cat;
    }
  }

  return $show_cat ? $show_cat->name : null;
}

// Auto-prefix "<Show Name>: " on the true main feed and the audio wrapper category feed.
function nm_autoprefix_title_on_main_feeds( $title ) {
  if ( ! is_feed( 'podcast' ) ) {
    return $title;
  }

  $is_true_main = ! is_category() && ! is_tax() && ! is_tag() && ! is_author() && ! is_date() && ! is_search();
  $is_audio_cat = is_category( nm_audio_cat_id() );

  if ( ! $is_true_main && ! $is_audio_cat ) {
    return $title;
  }

  $prefix = nm_get_show_prefix( get_the_ID() );
  if ( ! $prefix ) {
    return $title;
  }

  // Already prefixed (historical content has it baked into the post title).
  if ( 0 === strpos( $title, $prefix . ': ' ) ) {
    return $title;
  }

  return $prefix . ': ' . $title;
}
add_filter( 'the_title_rss', 'nm_autoprefix_title_on_main_feeds', 11 );

// Strip "<Show Name>: " prefix from episode titles on single-show feeds.
// Skips the audio wrapper feed — that one needs the prefixes.
// Only strips when the title actually starts with the post's own show prefix.
function nm_strip_show_prefix_on_category_feeds( $title ) {
  if ( ! is_feed( 'podcast' ) ) {
    return $title;
  }
  if ( is_category( nm_audio_cat_id() ) ) {
    return $title;
  }
  if ( is_category() ) {
    $prefix = nm_get_show_prefix( get_the_ID() );
    if ( $prefix && 0 === strpos( $title, $prefix . ': ' ) ) {
      $title = substr( $title, strlen( $prefix ) + 2 );
    }
  }
  return $title;
}
add_filter( 'the_title_rss', 'nm_strip_show_prefix_on_category_feeds', 12 );
