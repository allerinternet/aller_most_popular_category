<?php
/**
 *  @file
 *  Elle mat & vin widget template.
 *  http://ellematovin.se
 *
 *  @author Johannes Henrysson <johannes.henrysson@aller.se>, Aller Media AB
 *
 *  @package Wordpress 3
 *  @subpackage Aller Most Popular
 */
?>

<style>
.aller-most-popular-category a {
  font-size: 10px;
  color: #000;
}
</style>

<?php print $before_widget; ?>

<div class="aller-most-popular-category" <?php print 'style="padding: 10px; border: ' . get_option('aller_separator_width') . 'px ' . get_option('aller_separator_type') . ' ' . get_option('aller_color_separator') . '"'; ?>>
  <?php if (!empty($title)) : ?>
    <?php print $before_title . $title . $after_title; ?>
  <?php endif; ?>
  
  <?php if (empty($list)) : ?>
    Inga objekt hittades.
  <?php endif; ?>
  
  <img src="http://ellematovin.se/wp-content/uploads/10-i-topp.jpg" alt="10-i-topp" />
  
  <?php foreach($list as $nr => $l) : ?>
    <div class="widget-hr" style="margin:0; clear:both;"></div>
    <div style="height:45px; margin:4px 0; overflow:hidden;">
      <p style="float:left; font-size:45px; line-height:45px; width:48px; text-align:right;"><?php print ++$nr; ?></p>
      <?php if (!empty($l->image_url)) : ?>
        <img src="<?php print $l->image_url; ?>" alt="<?php print $l->post_title; ?>" style="height:40px;width:40px;float:left;margin:2px 10px;" />
      <?php endif; ?>
      <p style="text-transform:uppercase;">
        <a href="<?php print $l->url; ?>" title="Läs mer om <?php print $l->post_title; ?>">
          <?php
            if (strlen($l->post_title) > 50) {
              $l->post_title = substr($l->post_title, 0, 50) . '...';
            }
            print $l->post_title;
          ?> <span style="color:#52afd3;"><b>»</b></span>
        </a>
      </p>
    </div>
  <?php endforeach; ?>
</div>

<?php print $after_widget; ?>