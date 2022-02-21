<?php
/**
 * @package     TemplateHelper
 * @author      Trevor Wagner
 * @copyright   Trevor Wagner
 * @license     GPL-2.0+
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Template_Helper
 *
 * Generic helper class that searches for a file in the 'views' directory, and
 * renders it with any passed data. Similar in functionality to get_template_part, but with output
 * buffering to capture errant html
 *
 */
class Template_Helper
{
  const BASE_URL = '/assets/views/';

  public static function fileName( $name ){

    $realName = $name;

    if( $name != '' && strpos( $name, 'template') === false ){
      $realName = 'template-' . $realName;
    }

    if( $name != '' && strpos( $name, '.php') === false ){
      $realName = $realName . '.php';
    }

    return $realName;
  }

  /**
   * loadPluginView
   *
   * static Method that will try/catch to load any reference passed to a template from the views directory
   * so it will fail silently if there is no template.
   *
   * @param $name
   * @param null $params
   * @return string
   */
  public static function loadView( $name, $altUrl = null, $params = null )
  {
    $html = '';
    $url  = self::BASE_URL;

    if( $altUrl !== null){
      $url = $altUrl;
    }

    $file = get_template_directory() . $url . self::fileName( $name );

    $params != null ? extract( $params, EXTR_SKIP ) : '' ;

    if( file_exists( $file ) )
    {
      ob_start();

      try
      {
        include( $file );
      }
      catch( Exception $e ){}

      $html .= ob_get_contents();

      ob_get_clean();
    }

    return $html;
  }
}