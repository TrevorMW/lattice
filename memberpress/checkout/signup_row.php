<?php if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');} ?>

<?php 

$class = '';

if($line->field_key === 'mepr-address-city'){
    $class = 'half';
}

if($line->field_key === 'mepr-address-country'){
    $class = 'half last';
}

if($line->field_key === 'mepr-address-state'){
    $class = 'half';
}

if($line->field_key === 'mepr-address-zip'){
    $class = 'half last';
}

?>


<div class="formControl mepr_custom_field <?php echo $class; ?> mepr_<?php echo $line->field_key; ?>">
  <?php if($line->field_type != 'checkbox'): ?>
    <div class="mp-form-label">
      <label for="<?php echo $line->field_key . $unique_suffix; ?>"><?php printf( '%1$s:%2$s', _x(stripslashes($line->field_name), 'ui', 'memberpress'), $required ); ?></label>
      <span class="cc-error"><?php ($line->required) /*here for email custom fields that are not required*/ ? printf(_x('%s is Required', 'ui', 'memberpress'), stripslashes($line->field_name)) : printf(_x('%s is not valid', 'ui', 'memberpress'), stripslashes($line->field_name)); ?></span>
    </div>
  <?php endif; ?>
  <?php echo MeprUsersHelper::render_custom_field($line,$value,array(),$unique_suffix); ?>
</div>
