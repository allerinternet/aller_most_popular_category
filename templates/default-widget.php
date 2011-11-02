<?php
/**
 *  @file
 *  Default widget template.
 *
 *  @author Johannes Henrysson <johannes.henrysson@aller.se>, Aller Media AB
 *
 *  @package Wordpress 3
 *  @subpackage Aller Most Popular
 */
?>

<?php print $before_widget; ?>

<?php if (isset($title)) : ?>
  <?php print $before_title . $title . $after_title; ?>
<?php endif; ?>

<p>
  Hello world!
</p>

<?php print $after_widget; ?>