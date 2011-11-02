<?php
/**
 * @file
 * Form for widget in Wordpress admin.
 *
 * @author Johannes Henrysson <johannes.henrysson@aller.se>, Aller Media AB
 *
 * @package Wordpress 3
 * @subpackage Aller Most Popular
 */
?>
<p>
  <label for="<?php print $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
  <input class="widefat" id="<?php print $this->get_field_id('title'); ?>" name="<?php print $this->get_field_name('title'); ?>" type="text" value="<?php print $title; ?>" />
</p>