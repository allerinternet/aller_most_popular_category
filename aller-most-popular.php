<?php
/**
 *  Plugin Name: Aller Most Popular
 *  Description: Enables most popular data for a specific category, even when using Varnish and such.
 *  Version: 0.1a
 *  Author: Johannes Henrysson <johannes.henrysson@aller.se>, Aller Media AB
 *
 *  @package Wordpress 3
 *  @subpackage Aller Most Popular
 */
class AllerMostPopularCategory
{
  private $wpdb;
  
  /**
   *  Initialize Aller Most Popular. Kickstart important stuff!
   */
  function __construct($wpdb) {
    if (!is_object($wpdb))
      wp_die('Couldn\'t find database.');
    else
      $this->wpdb = $wpdb;
    
    if (is_admin())
      add_action('admin_menu', array($this, 'add_admin_page'));
  }
  
  /**
   *  Add admin page.
   */
  public function add_admin_page() {
    add_posts_page('Aller Most Popular', 'Aller Most Popular', 'manage_categories', 'aller-most-popular', array($this, 'render_admin_page'));
  }
  
  /**
   *  Render admin page.
   */
  public function render_admin_page() {
    require_once(dirname(__FILE__) . "/templates/admin-page.php");
  }
  
  /**
   *  Check if table exists in database.
   *
   *  @return boolean
   *    TRUE/FALSE for yes/no
   */
  public function check_database() {
    $sql = "SHOW TABLES LIKE '{$this->wpdb->prefix}aller_most_popular'";
    $result = $this->wpdb->get_results($sql, ARRAY_A);
    if ($this->wpdb->num_rows < 1)
      return FALSE;
    else
      return TRUE;
  }
}

// Instanciate object to start application.
$allerMostPopularCategory = new AllerMostPopularCategory($wpdb);