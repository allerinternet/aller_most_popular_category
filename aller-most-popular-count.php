<?php
/**
 *  Simple file that just do the math (+1 to db).
 *  Author: Johannes Henrysson <johannes.henrysson@aller.se>, Aller Media AB
 *
 *  @package Wordpress 3
 *  @subpackage Aller Most Popular
 */

// Works for default installation
$wp_path = "../../../";
require($wp_path . "wp-load.php");

$url = isset($_GET['url']) && !empty($_GET['url']) ? mysql_real_escape_string($_GET['url']) : exit;
$cat = isset($_GET['cat']) && !empty($_GET['cat']) ? mysql_real_escape_string($_GET['cat']) : exit;

$sql = "SELECT id
  FROM {$wpdb->prefix}aller_most_popular
  WHERE category_slug='{$cat}' AND url='{$url}'";
$result = $wpdb->get_results($sql);
if ($wpdb->num_rows > 0) {
  $sql = "UPDATE {$wpdb->prefix}aller_most_popular
    SET views=views+1
    WHERE url='{$url}'";
} else {
  $sql = "INSERT INTO {$wpdb->prefix}aller_most_popular
    SET views=1, url='{$url}', category_slug='{$cat}'";
}
$wpdb->query($sql);