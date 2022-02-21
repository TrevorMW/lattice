<?php

abstract class WP_ACF_CPT
{

  /**
   * __construct function.
   *
   * @access public
   * @param mixed $id (default: null)
   * @return void
   */
  public function __construct($id = null)
  {
    if (is_int($id)) {
      $new_fields = array();

      $post   = get_post($id);
      $fields = get_field_objects($id);

      if (is_array($fields)) {
        foreach ($fields as $k => $field) {
          if ($k != '')
            $new_fields[$k] = $field['key'];
        }

        if (!empty($new_fields)) {
          foreach ($new_fields as $field_id => $key) {
            $this->$field_id = get_field($key, $post->ID);
          }
        }
      }
    }
  }
}
