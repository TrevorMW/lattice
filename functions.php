<?php 

// increment with every push to github to bust CSS and JS cache
define('THEME_VERSION', '1.0.1.2');

/**
 * @package WordPress
 * @subpackage themename
 */

// LOAD CLASSES JIT
spl_autoload_register(function ($className) {
  $classDir  = get_template_directory() . '/assets/classes/';
  $classFile = 'class-' . str_replace('_', '-', strtolower($className)) . '.php';

  if (file_exists($classDir . $classFile)) {
    require_once $classDir . $classFile;
  }
});

////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// START UTILITY FUNCTIONS ///////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
new Aenea_User();
new Quiz();
new Curriculum();
new Homepage();

/**
 * Load any needed body classes
 */
function addBodyClass($classes)
{
  global $post; 
  $classes[] = 'page-' . $post->post_name;
  return $classes;
}
add_filter('body_class', 'addBodyClass');

require_once('utility-functions.php');


////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// END UTILITY FUNCTIONS /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// START THEME FUNCTIONS /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Register and define a page_for_settings option to allow for a normal page with ACF to replace options page.
 */
function extendReadingSettings(){

  // register our setting
  register_setting( 
    'reading', // option group "reading", default WP group
    'page_for_settings', // option name
    array(
      'type' => 'string', 
      'sanitize_callback' => 'sanitize_text_field',
      'default' => NULL
    )
  );

  register_setting( 
    'reading', // option group "reading", default WP group
    'page_for_quiz', // option name
    array(
      'type' => 'string', 
      'sanitize_callback' => 'sanitize_text_field',
      'default' => NULL
    )
  );

  // register our setting
  register_setting( 
    'reading', // option group "reading", default WP group
    'page_for_curriculum', // option name
    array(
      'type' => 'string', 
      'sanitize_callback' => 'sanitize_text_field',
      'default' => NULL
    )
  );

  // add our new setting
  add_settings_field(
      'page_for_settings', // ID
      __('Theme Settings Page', 'textdomain'), // Title
      'page_for_settings_callback_function', // Callback
      'reading', // page
      'default', // section
      array( 'label_for' => 'page_for_settings' )
  );

  // add our new setting
  add_settings_field(
    'page_for_quiz', // ID
    __('Quiz Page', 'textdomain'), // Title
    'page_for_quiz_callback_function', // Callback
    'reading', // page
    'default', // section
    array( 'label_for' => 'page_for_quiz' )
  );

  // add our new setting
  add_settings_field(
    'page_for_curriculum', // ID
    __('Curriculum Page', 'textdomain'), // Title
    'page_for_curriculum_callback_function', // Callback
    'reading', // page
    'default', // section
    array( 'label_for' => 'page_for_curriculum' )
);
}
add_action('admin_init', 'extendReadingSettings');

function page_for_settings_callback_function(){
  // get saved project page ID
  $project_page_id = get_option('page_for_settings');

  // get all pages
  $args = array(
      'posts_per_page'   => -1,
      'orderby'          => 'name',
      'order'            => 'ASC',
      'post_type'        => 'page',
  );
  
  $items = get_posts( $args );

  echo '<select id="settingsPageSelect" name="page_for_settings">';
  // empty option as default
  echo '<option value="0">'.__('— Select —', 'wordpress').'</option>';

  // foreach page we create an option element, with the post-ID as value
  foreach($items as $item) {

      // add selected to the option if value is the same as $project_page_id
      $selected = ($project_page_id == $item->ID) ? 'selected="selected"' : '';

      echo '<option value="'.$item->ID.'" '.$selected.'>'.$item->post_title.'</option>';
  }

  echo '</select>';
}

function page_for_quiz_callback_function(){
  // get saved project page ID
  $project_page_id = get_option('page_for_quiz');

  // get all pages
  $args = array(
      'posts_per_page'   => -1,
      'orderby'          => 'name',
      'order'            => 'ASC',
      'post_type'        => 'page',
  );
  
  $items = get_posts( $args );

  echo '<select id="quizPageSelect" name="page_for_quiz">';
  // empty option as default
  echo '<option value="0">'.__('— Select —', 'wordpress').'</option>';

  // foreach page we create an option element, with the post-ID as value
  foreach($items as $item) {

      // add selected to the option if value is the same as $project_page_id
      $selected = ($project_page_id == $item->ID) ? 'selected="selected"' : '';

      echo '<option value="'.$item->ID.'" '.$selected.'>'.$item->post_title.'</option>';
  }

  echo '</select>';
}

function page_for_curriculum_callback_function(){
  // get saved project page ID
  $project_page_id = get_option('page_for_curriculum');

  // get all pages
  $args = array(
      'posts_per_page'   => -1,
      'orderby'          => 'name',
      'order'            => 'ASC',
      'post_type'        => 'page',
  );
  
  $items = get_posts( $args );

  echo '<select id="curriculumPageSelect" name="page_for_curriculum">';
  // empty option as default
  echo '<option value="0">'.__('— Select —', 'wordpress').'</option>';

  // foreach page we create an option element, with the post-ID as value
  foreach($items as $item) {

      // add selected to the option if value is the same as $project_page_id
      $selected = ($project_page_id == $item->ID) ? 'selected="selected"' : '';

      echo '<option value="'.$item->ID.'" '.$selected.'>'.$item->post_title.'</option>';
  }

  echo '</select>';
}

function prfx_add_custom_post_states($states) {
    global $post;

    // get saved project page ID
    $project_page_id = get_option('page_for_settings');

    // add our custom state after the post title only,
    // if post-type is "page",
    // "$post->ID" matches the "$project_page_id",
    // and "$project_page_id" is not "0"
    if( 'page' == get_post_type($post->ID) && $post->ID == $project_page_id && $project_page_id != '0') {
        $states[] = __('Global Settings Page', 'textdomain');
    }

    // get saved project page ID
    $id = get_option('page_for_quiz');

    // add our custom state after the post title only,
    // if post-type is "page",
    // "$post->ID" matches the "$project_page_id",
    // and "$project_page_id" is not "0"
    if( 'page' == get_post_type($post->ID) && $post->ID == $id && $id != '0') {
        $states[] = __('Quiz Page', 'textdomain');
    }

    return $states;
}
add_filter('display_post_states', 'prfx_add_custom_post_states');




/**
 * Register Theme Custom Post Types
 */
function create_posttype() {
 
  register_post_type( 'question', 
    array(
      'label'                 => __( 'Quiz Questions', 'text_domain' ),
      'description'           => __( 'Custom Post Types for all Questions based details', 'text_domain' ),
      'labels'                => array(
        'name'                  => _x( 'Questions', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Question', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Questions', 'text_domain' ),
        'name_admin_bar'        => __( 'Questions', 'text_domain' ),
        'archives'              => __( 'Question Archives', 'text_domain' ),
        'attributes'            => __( 'Question Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Question:', 'text_domain' ),
        'all_items'             => __( 'All Questions', 'text_domain' ),
        'add_new_item'          => __( 'Add New Question', 'text_domain' ),
        'add_new'               => __( 'Add New Question', 'text_domain' ),
        'new_item'              => __( 'New Question', 'text_domain' ),
        'edit_item'             => __( 'Edit Question', 'text_domain' ),
        'update_item'           => __( 'Update Question', 'text_domain' ),
        'view_item'             => __( 'View Question', 'text_domain' ),
        'view_items'            => __( 'View Question', 'text_domain' ),
        'search_items'          => __( 'Search Questions', 'text_domain' ),
        'not_found'             => __( 'Question Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Question Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into Question', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Question', 'text_domain' ),
        'items_list'            => __( 'Questions list', 'text_domain' ),
        'items_list_navigation' => __( 'Questions list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter Questions list', 'text_domain' ),
      ),
      'supports'              => array( 'title', 'editor', 'thumbnail' ),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 10,
      'menu_icon'             => 'dashicons-help',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => true,
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'capability_type'       => 'page',
    )
  );

  register_post_type( 'podcast', 
    array(
      'label'                 => __( 'Podcasts', 'text_domain' ),
      'description'           => __( 'Custom Post Types for all Questions based details', 'text_domain' ),
      'labels'                => array(
        'name'                  => _x( 'Podcasts', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Podcast', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Podcasts', 'text_domain' ),
        'name_admin_bar'        => __( 'Podcasts', 'text_domain' ),
        'archives'              => __( 'Podcast Archives', 'text_domain' ),
        'attributes'            => __( 'Podcast Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Podcast:', 'text_domain' ),
        'all_items'             => __( 'All Podcasts', 'text_domain' ),
        'add_new_item'          => __( 'Add New Podcast', 'text_domain' ),
        'add_new'               => __( 'Add New Podcast', 'text_domain' ),
        'new_item'              => __( 'New Podcast', 'text_domain' ),
        'edit_item'             => __( 'Edit Podcast', 'text_domain' ),
        'update_item'           => __( 'Update Podcast', 'text_domain' ),
        'view_item'             => __( 'View Podcast', 'text_domain' ),
        'view_items'            => __( 'View Podcast', 'text_domain' ),
        'search_items'          => __( 'Search Podcasts', 'text_domain' ),
        'not_found'             => __( 'Podcast Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Podcast Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into Podcast', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Podcast', 'text_domain' ),
        'items_list'            => __( 'Podcasts list', 'text_domain' ),
        'items_list_navigation' => __( 'Podcasts list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter Podcasts list', 'text_domain' ),
      ),
      'supports'              => array( 'title', 'editor', 'thumbnail' ),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 10,
      'menu_icon'             => 'dashicons-audio',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => true,
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'capability_type'       => 'page',
    )
  );

  register_post_type( 'team', 
    array(
      'label'                 => __( 'Team Members', 'text_domain' ),
      'description'           => __( 'Custom Post Types for all Team Members based details', 'text_domain' ),
      'labels'                => array(
        'name'                  => _x( 'Team Members', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Team Member', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Team Members', 'text_domain' ),
        'name_admin_bar'        => __( 'Team Members', 'text_domain' ),
        'archives'              => __( 'Team Member Archives', 'text_domain' ),
        'attributes'            => __( 'Team Member Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Team Member:', 'text_domain' ),
        'all_items'             => __( 'All Team Members', 'text_domain' ),
        'add_new_item'          => __( 'Add New Team Member', 'text_domain' ),
        'add_new'               => __( 'Add New Team Member', 'text_domain' ),
        'new_item'              => __( 'New Team Member', 'text_domain' ),
        'edit_item'             => __( 'Edit Team Member', 'text_domain' ),
        'update_item'           => __( 'Update Team Member', 'text_domain' ),
        'view_item'             => __( 'View Team Member', 'text_domain' ),
        'view_items'            => __( 'View Team Member', 'text_domain' ),
        'search_items'          => __( 'Search Team Members', 'text_domain' ),
        'not_found'             => __( 'Team Member Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Team Member Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into Team Member', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Team Member', 'text_domain' ),
        'items_list'            => __( 'Team Members list', 'text_domain' ),
        'items_list_navigation' => __( 'Team Members list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter Team Members list', 'text_domain' ),
      ),
      'supports'              => array( 'title', 'editor', 'thumbnail' ),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 10,
      'menu_icon'             => 'dashicons-user',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => true,
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'capability_type'       => 'page',
    )
  );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );



//////////////////////////////////// THEME AJAX /////////////////////////////////////////

/**
 * load Sign Up Form
 */
function getSignInForm() {
  echo Template_Helper::loadView('signin-form');

  die(0);
}
add_action( 'wp_ajax_nopriv_signin_form', 'getSignInForm' );
add_action( 'wp_ajax_signin_form',        'getSignInForm' );

 
/**
 * Log Out User
 */
function signUserOut() {
  $post = $_REQUEST;
  $resp = new Ajax_Response($post['action']);

  session_destroy();
  wp_logout();
  //wp_redirect( home_url() );

  $resp->redirectURL = home_url();
  $resp->status      = true;
  $resp->pageRefresh = true;

  echo $resp->encodeResponse();

  die(0);
}
add_action( 'wp_ajax_nopriv_signout', 'signUserOut' );
add_action( 'wp_ajax_signout',        'signUserOut' );

/**
 * Log User In
 */
function logUserIn() {
  $post = $_REQUEST;
  
  $continueLogin = true;
  $username      = $post['username'];
  $password      = $post['password'];
  $resp          = new Ajax_Response($post['action']);

  // Check email
  // $email = test_input($username);
  // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  //   $continueLogin = false;
  // }

  if(!$continueLogin){
    $resp->message = 'There was a problem logging you in. Try Again.';
  } else {
    $user = wp_signon( array( 
      'user_login'    => $username, 
      'user_password' => $password ) 
    );

    if ( is_a( $user, 'WP_User' ) ) {
      wp_set_current_user( $user->ID, $user->user_login );

      if ( is_user_logged_in() ) {
        $resp->status      = true;
        $resp->pageRefresh = true;
        $resp->redirectURL = home_url();
        
        $user = wp_get_current_user();

        if( in_array( Aenea_User::AENEA_ROLE_NAME, (array) $user->roles ) ){
          $resp->redirectURL = get_permalink(get_option('page_for_curriculum'));
        }
        
        $resp->message = 'Login Successful!';
      } else {
        $resp->message = 'Username or Password invalid. Try Again.';
      }
    } else {
      $resp->message = 'Username or Password invalid. Try Again.';
    }
  }

  echo $resp->encodeResponse();

  die(0);
}
add_action( 'wp_ajax_nopriv_user_login', 'logUserIn' );
add_action( 'wp_ajax_user_login',        'logUserIn' );


function homepageQuizSignup(){
  echo Template_Helper::loadView('quiz-register', '/assets/views/pages/quiz/');

  die(0);
}
add_action( 'wp_ajax_nopriv_homepage_quiz_signup', 'homepageQuizSignup' );
add_action( 'wp_ajax_homepage_quiz_signup',        'homepageQuizSignup' );


////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// END THEME FUNCTIONS /////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////


