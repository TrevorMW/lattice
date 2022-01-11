<?php

/**
 * 
 */
function get_current_template($echo = false)
{
  if (!isset($GLOBALS['current_theme_template']))
    return false;

  if ($echo)
    echo $GLOBALS['current_theme_template'];
  else
    return $GLOBALS['current_theme_template'];
}

/**
 * 
 */
function get_excerpt_by_id($post_id, $length = 35)
{
  $new_post       = get_post($post_id); //Gets post ID
  $the_excerpt    = strip_tags($new_post->post_content); //Strips tags and images
  $words          = explode(' ', $the_excerpt, $length + 1);

  if (count($words) > $length) {
    array_pop($words);
    array_push($words, '…');
    $the_excerpt = implode(' ', $words);
  };

  return apply_filters('the_content', $the_excerpt);
}

/**
 * 
 */
function build_pagination($loop, $paged)
{
  global $wp;

  $args = array(
    'format'     => 'page/%#%',
    'total'      => $loop->max_num_pages,
    'current'    => max(1, $paged),
    'prev_text'  => __('<i data-previous class="fa fa-caret-left"></i>'),
    'next_text'  => __('<i data-next     class="fa fa-caret-right"></i>'),
    'type'       => 'array'
  );

  return formatted_pagination(paginate_links($args));
}

/**
 * 
 */
function formatted_pagination($data)
{
  $html = '';

  if (count($data) > 0) {
    $html .= '<ul class="pagination">';

    foreach ($data as $link) {
      $class = '';
      strpos($link, 'current') != false ? $class = 'active' : '';
      $html .= '<li class="' . $class . '">' . $link . '</li>';
    }

    $html .= '</ul>';
  }

  return $html;
}

/**
 * 
 */
function get_template_part_with_data($slug = null, $name = null, array $params = array())
{
  global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

  do_action("get_template_part_{$slug}", $slug, $name);

  $templates = array();
  if (isset($name))
    $templates[] = "/views/{$slug}-{$name}.php";

  $templates[] = "/views/{$slug}.php";

  $_template_file = locate_template($templates, false, false);

  if (is_array($wp_query->query_vars)) {
    extract($wp_query->query_vars, EXTR_SKIP);
  }
  extract($params, EXTR_SKIP);

  require($_template_file);
}

/**
 * 
 */
function __is_blog()
{
  global $post;
  $posttype = get_post_type($post);
  return (((is_archive()) || (is_home())) && ($posttype == 'post')) ? true : false;
}

/**
 * 
 */
function get_array_from_object($array = array())
{
  $result = array();

  if (is_array($array)) {
    foreach ($array as $obj) {
      $result[$obj->ID] = $obj->post_title;
    }
  }

  return $result;
}

/**
 * 
 */
function var_template_include($t)
{
  $GLOBALS['current_theme_template'] = basename($t);
  return $t;
}
add_filter('template_include', 'var_template_include', 1000);


/**
 * 
 */
// function addOptionsPage(){
//   if (function_exists('acf_add_options_page')) {
//     acf_add_options_page(array(
//       'page_title'   => 'Global Settings',
//       'menu_title'  => 'Global Settings',
//       'menu_slug'   => 'global-settings',
//       'capability'  => 'edit_posts',
//       'redirect'    => false
//     ));
//   }
// }

// add_action('admin_init', 'addOptionsPage', 20);


////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// END UTILITY FUNCTIONS /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 *
 * ENQUEUE CSS, LESS, & SCSS STYLESHEETS
 *
 */
function add_style_sheets()
{
  if (!is_admin()) {
    wp_enqueue_style('reset', get_template_directory_uri() . '/style.css', 'screen');
    wp_enqueue_style('fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', 'screen');
    wp_enqueue_style(
      'googleFonts',
      '//fonts.googleapis.com/css?family=Open Sans:400,600,700|Noto Sans:400,600|Maven Pro:400,700&ver=1.0.0',
      'screen'
    );

    // On login page only
    wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/build/core.min.css', array(), false, 'screen');
  }
}
add_action('wp_enqueue_scripts', 'add_style_sheets');


// IF ADMIN JS OR STYLES ARE NEEDED, YOU CAN USE THIS AS A TEMPLATE
function load_custom_wp_admin_style()
{
  //wp_enqueue_style( 'admin-fixes', get_template_directory_uri().'/assets/css/admin-fixes.css', 'screen'  );
}
//add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );



/**
 *
 * ENQUEUE JAVASCRIPT FILES
 *
 */
function add_javascript()
{
  $app_base = get_template_directory_uri() . '/assets/js/build';

  if (!is_admin()) {
    wp_enqueue_script(
      'jquery',
      '//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js',
      null,
      true,
      null
    );
    wp_enqueue_script(
      'coreJS',
      get_template_directory_uri() . '/assets/js/build/bundle.core.min.js',
      array('jquery'),
      true,
      null
    );

    wp_localize_script('coreJS', 'core', array(
      'ajaxUrl' => get_template_directory_uri() . '/ajax.php',
      'baseUrl' => $app_base,
      'deps'    => array($app_base . '/bundle.core.min.js')
    ));

    
  }
}
add_action('wp_enqueue_scripts', 'add_javascript');

/**
 *
 * TAKE GLOBAL DESCRIPTION OUT OF HEADER.PHP AND GENERATE IT FROM A FUNCTION
 *
 */
function site_global_description()
{
  global $page, $paged;
  wp_title('|', true, 'right');
}


/**
 * REMOVE UNWANTED CAPITAL <P> TAGS
 */
remove_filter('the_content', 'capital_P_dangit');
remove_filter('the_title', 'capital_P_dangit');
remove_filter('comment_text', 'capital_P_dangit');


/**
 * REGISTER NAV MENUS FOR HEADER FOOTER AND UTILITY
 */
register_nav_menus(array(
  'primary' => __('Primary Menu', 'themename'),
  'primary-authenticated' => __('Primary Menu (Authenticated)', 'themename'),
  'footer-left' => __('Footer Left Menu', 'themename'),
  'footer-right' => __('Footer Right Menu ', 'themename'),
));

/**
 * DEFAULT COMMENTS & RSS LINKS IN HEAD
 */
add_theme_support('automatic-feed-links');


/**
 * THEME SUPPORTS THUMBNAILS
 */
add_theme_support('post-thumbnails');

/**
 * THEME SUPPORTS THUMBNAILS
 */
add_theme_support('widgets');

/**
 * Basic Blog widgetized sidebar
 */
function themename_widgets_init() {
  register_sidebar( array(
      'name'          => __( 'Primary Sidebar', 'theme_name' ),
      'id'            => 'blog',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h5 class="widget-title">',
      'after_title'   => '</h5>',
  ) );
}
add_action( 'widgets_init', 'themename_widgets_init' );

/**
 *	THEME SUPPORTS EDITOR STYLES
 */
add_editor_style("/css/layout-style.css");

/**
 *	Disable comments entirely
 */
function filter_media_comment_status( $open, $post_id ) {
  $post = get_post( $post_id );
  if( $post->post_type == 'attachment' ) {
      return false;
  }
  return $open;
}
add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );


// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
// Disables the block editor from managing widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );

/**
 *	ADD TINY IMAGE SIZE FOR ACF FIELDS, BETTER USABILITY
 */
add_image_size('full', 2400, 2400, false);
add_image_size('desktop', 1280, 1280, true);
add_image_size('tablet', 1024, 1024, true);
add_image_size('mobile', 768, 768, true);
add_image_size('phone', 480, 480, true);
add_image_size('mini-thumbnail', 50, 50, true);


// ADDS SUPPORT FOR CUSTOM EDITOR STYLES THAT LET CLIENTS USE THE WYSIWYG EDITOR BETTER. UNCOMMENT IF YOU NEED THEM.

//add_editor_style('css/editor-style.css');

function custom_tinymce_styles($settings)
{
  $style_formats = array(
    array(
      'title' => 'Huge Blue Text',
      'selector' => 'h1,h2,h3,h4,h5,h6',
      'classes' => 'huge blue ',
    ),
    array(
      'title' => 'Blue Text',
      'selector' => 'h1,h2,h3,h4,h5,h6',
      'classes' => 'blue',
    ),
    array(
      'title' => 'Gray Text',
      'selector' => 'h1,h2,h3,h4,h5,h6',
      'classes' => 'gray',
    ),
    array(
      'title' => 'White Text',
      'selector' => 'h1,h2,h3,h4,h5,h6',
      'classes' => 'white',
    )
  );

  $settings['style_formats'] = json_encode($style_formats);

  if (!isset($settings['extended_valid_elements'])) {
    $settings['extended_valid_elements'] = '';
  } else {
    $settings['extended_valid_elements'] .= ',';
  }

  if (!isset($settings['custom_elements'])) {
    $settings['custom_elements'] = '';
  } else {
    $settings['custom_elements'] .= ',';
  }

  $settings['extended_valid_elements'] .= 'div[class|id|style|data-animation|data-fx]';
  $settings['custom_elements']         .= 'div[class|id|style|data-animation|data-fx]';

  return $settings;
}
//add_filter( 'tiny_mce_before_init', 'custom_tinymce_styles' );

function add_tinymce_styles_dropdown($buttons)
{
  array_unshift($buttons, 'styleselect');
  return $buttons;
}
//add_filter('mce_buttons_2', 'add_tinymce_styles_dropdown');

function allow_data_attributes_in_tinymce()
{
  global $allowedposttags;

  $tags = array('div');
  $new_attributes = array('contenteditable' => array(), 'data-animation' => array(), 'data-fx' => array());

  foreach ($tags as $tag) {
    if (isset($allowedposttags[$tag]) && is_array($allowedposttags[$tag]))
      $allowedposttags[$tag] = array_merge($allowedposttags[$tag], $new_attributes);
  }
}
//add_action( 'init', 'allow_data_attributes_in_tinymce' );
