<?php
/**
 * Created by PhpStorm.
 * User: Trevor
 * Date: 7/24/16
 * Time: 8:23 AM
 * lifted from http://coderrr.com/create-your-own-admin-ajax-php-type-handler
 */

define( 'DOING_AJAX', true );

$ajaxAllowed = true;

if( !isset( $_POST['action'] ) ){
  $ajaxAllowed = false;
}

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

// Typical headers
header('Content-Type: text/html');
send_nosniff_header();
header('Cache-Control: no-cache');
header('Pragma: no-cache');

$action = esc_attr( $_POST['action'] );
$nonce  = esc_attr( $_POST['_wpnonce'] );

if( $ajaxAllowed ){
  is_user_logged_in() ? do_action( 'wp_ajax_' . $action ) : do_action( 'wp_ajax_nopriv_' . $action );
} else {
  die(0);
}
