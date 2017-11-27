<?php

/*
  Setup keys, if you add them will enqueue styles/scripts
  **************************************************************/

$package = array(
  'dir' => "build", /* build = dev, dist = live */
  'ver' => "1.0",
  'namespace' => 'vanilla',
  'fa_key' => '',
  'gmap_key' => "", // need to create at Google API Console
  'google_fonts' => ''
);

/*
  General Housekeeping
  **************************************************************/

function my_acf_google_map_api( $api ){
  global $package;
  $api['key'] = $package['gmap_key'];
  
  return $api;
  
}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

$style_path = esc_url( get_template_directory_uri() )."/".$package['dir']."css/main.css";

/**
 * Theme setup
 */
function setup() {
  global $style_path, $package;

  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  // add_theme_support('soil-jquery-cdn');
  add_theme_support('soil-relative-urls');
  add_theme_support('soil-js-to-footer');


  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', $package['namespace']),
    'resources_navigation' => __('Resources Navigation', $package['namespace']),
    'footer_navigation' => __('Footer Navigation', $package['namespace'])
  ]);

  register_sidebar(array(
    'name' => 'Footer Widgets',
    'id'            => 'footer-widget',
    'before_widget' => '<section class = "widget">',
    'after_widget' => '</section>',
    'before_title' => '<header>',
    'after_title' => '</header>',
  ) );

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  add_image_size('news', 400, 400, true);
  add_image_size('bio', 240, 360, true);
  add_image_size('bio-mobile', 400, 400, true);

  add_image_size('map', 600, 400, true);
  add_image_size('map-mobile', 400, 400, true);

  add_image_size('banner', 1200, 600, true);
  add_image_size('banner-mobile', 600, 600, true);

  add_image_size('hero', 1200, 200, true);
  add_image_size('hero-mobile', 600, 200, true);


  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_filter( 'jpeg_quality', create_function( '', 'return 92;' ) );

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Use main stylesheet for visual editor
  add_editor_style( $style_path );

  if( function_exists('acf_add_options_page') ) {
  
    acf_add_options_page();
    acf_add_options_sub_page('Contact');
    acf_add_options_sub_page('Social');
  }

}
add_action('after_setup_theme', 'setup');

/*
  Additional Functions
  **************************************************************/

function custom_youtube_settings($code){
  if(strpos($code, 'youtu.be') !== false || strpos($code, 'youtube.com') !== false){
    $return = preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2&showinfo=0&rel=0&autohide=1", $code);
    return $return;
  }
  return $code;
}

add_filter('embed_handler_html', 'custom_youtube_settings');
add_filter('embed_oembed_html', 'custom_youtube_settings');
add_filter('oembed_result', 'custom_youtube_settings');


/*
  Enqueue Scripts and Styles
  **************************************************************/

function theme_styles() {
  global $package;

  if( $package['google_fonts'] ):
    wp_enqueue_style( 'styles', "https://fonts.googleapis.com/css?family=".$package['google_fonts'], null, null, true );
  endif;

  wp_enqueue_style( 'styles', esc_url( get_template_directory_uri() )."/".$package['dir']."/css/main.css", false, $package['ver'], false );
}

function theme_js() {
  
  global $wp_scripts, $package;
  
  if( $package['gmap_key'] ):
    wp_enqueue_script('gmaps', "https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&key=".$package['gmap_key'], false, null, true);
  endif;

  if( $package['fa_key'] ):
    wp_enqueue_script('fa', "https://use.fontawesome.com/".$package['fa_key'].".js", null, null, true);
  endif;

  wp_enqueue_script('main', esc_url( get_template_directory_uri() )."/".$package['dir']."/js/main.js", array('jquery'), $package['ver'], true);

}

if( !is_admin() && 'wp-login.php' != $pagenow ){

  add_action( 'wp_enqueue_scripts', 'theme_styles' );
  add_action( 'wp_enqueue_scripts', 'theme_js' );

}
