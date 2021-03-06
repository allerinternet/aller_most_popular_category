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

<?php if (empty($list)) : ?>
  Inga objekt hittades.
<?php endif; ?>

<?php foreach($list as $nr => $l) : ?>
  <div class="widget-hr" style="margin:0; clear:both;"></div>
  <div style="height:45px; margin:4px 5px; overflow:hidden;">
    <p style="float:left; font-size:45px; line-height:45px; width:48px; text-align:right;"><?php print ++$nr; ?></p>
    <?php if (!empty($l->image_url)) : ?>
      <img src="<?php print $l->image_url; ?>" alt="<?php print $l->post_title; ?>" style="height:40px;width:40px;float:left;margin:2px 10px;" />
    <?php endif; ?>
    <p style="text-transform:uppercase;">
      <a href="<?php print $l->url; ?>" title="Läs mer om <?php print $l->post_title; ?>">
        <?php
          if (strlen($l->post_title) > 30) {
            $l->post_title = substr($l->post_title, 0, 30) . '...';
          }
          print $l->post_title;
        ?> &gt;&gt;
      </a>
    </p>
  </div>
<?php endforeach; ?>

<?php print $after_widget; ?>