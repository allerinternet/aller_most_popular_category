<?php
/**
 *  @file
 *  Plugin Name: Aller Most Popular
 *  Description: Enables most popular data for a specific category, even when using Varnish and such.
 *  Version: 0.1a
 *  Author: Johannes Henrysson <johannes.henrysson@aller.se>, Aller Media AB
 *
 *  @package Wordpress 3
 *  @subpackage Aller Most Popular
 */

/**
 *  Basic functions for Aller Most Popular, as well as render admin page etc.
 */
class AllerMostPopularCategory
{  
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
    // To avoid issues with calling certain function before Wordpress loads.
    if (isset($_POST['update-database']))
      $this->update_database($_POST);
    if (isset($_POST['savesettings']))
      $this->save_settings($_POST);
    
    require(dirname(__FILE__) . "/templates/admin-page.php");
  }
  
  /**
   *  Check if table exists in database.
   *
   *  @return boolean
   *    TRUE/FALSE for yes/no
   */
  public function check_database() {
    global $wpdb;
    
    $sql = "SHOW TABLES LIKE '{$wpdb->prefix}aller_most_popular'";
    $result = $wpdb->get_results($sql);
    if ($wpdb->num_rows < 1)
      return FALSE;
    else
      return TRUE;
  }
  
  private function _validate($input) {
    if (!wp_verify_nonce($input['aller-most-popular-category'], 'aller-most-popular'))
      wp_die('Your nonce did not verify.');
  }
  
  /**
   *  Create table for Aller Most Popular in database. (only if it doesn't exists)
   */
  public function update_database($input) {
    global $wpdb;
    
    $this->_validate($input);
    
    if ($this->check_database())
      wp_die('Database table already exists!');
    
    $sql = "CREATE TABLE `{$wpdb->prefix}aller_most_popular` (
        `id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `post_id` MEDIUMINT UNSIGNED NOT NULL,
        `url` VARCHAR( 255 ) NOT NULL,
        `views` SMALLINT UNSIGNED NOT NULL,
        `category_slug` VARCHAR( 255 ) NOT NULL,
        INDEX (`category_slug`),
        UNIQUE (`url`, `post_id`))
      ENGINE = INNODB;";
    if (!$wpdb->query($sql))
      wp_die('Database error! Something went wrong.');
  }
  
  /**
   *  Save settings for Aller Most Popular.
   *
   *  @param array $input
   *    Input from POST.
   */
  public function save_settings($input) {
    $this->_validate($input);
    
    if (get_option('aller_most_popular_category') !== NULL)
      update_option('aller_most_popular_category', $input['category-slug']);
    else
      add_option('aller_most_popular_category', $input['category-slug']);
  }
  
  /**
   *  First we check if we should run counter. Then we add javascript to foot with add_action.
   */
  public function run_counter() {
    add_action('wp_footer', array($this, 'add_javascript'));
  }
  
  /**
   *  Add javascript, if correct category.
   */
  public function add_javascript() {
    $category_slug = get_option('aller_most_popular_category');
    if (empty($category_slug))
      return;
    
    $category = get_the_category();
    foreach($category as $cat) {
      if ($cat->slug == $category_slug)
        require(dirname(__FILE__) . "/templates/script.php");
    }
  }
}

/**
 *  Create Aller Most Popular Category widget to show our flashy stuff.
 */
class AllerMostPopularCategoryWidget extends WP_Widget
{
  var $id = 'aller_most_popular_category_widget';
  var $name = 'Aller Most Popular';
  var $description = 'Show most popular from one category (set in Posts -> Aller Most Popular).';
  
  /**
   *  Widget actual processes
   */
  function __construct() {
    parent::WP_Widget($this->id, $this->name, array('description' => $this->description));
  }
  
  /**
   *  Outputs the content of the widget
   *
   *  @param array $args
   *  @param $instance
   */
  function widget($args, $instance) {
    extract($args);
    $title = apply_filters('widget_title', $instance['title']);
    
    $list = $this->_get_list(get_option('aller_most_popular_category'));
    var_dump($list);
    // Load template, use of custom templates is possible.
    preg_match('%http://(?:www.)?([^/$]+)%', home_url(), $url);
    if (isset($url[1]) && file_exists(dirname(__FILE__) . "/templates/{$url[1]}-widget.php"))
      require(dirname(__FILE__) . "/templates/{$url[1]}-widget.php");
    else
      require(dirname(__FILE__) . "/templates/default-widget.php");
  }
  
  /**
   *  Outputs the options form on admin
   *
   *  @param $instance
   */
  function form($instance) {
    $title = ($instance) ? esc_attr($instance['title']) : '';
    
    require(dirname(__FILE__) . "/templates/admin-widget.php");
  }
  
  /**
   *  Processes widget options to be saved
   *
   *  @param array $new_instance
   *    New data.
   *  @param array $old_instance
   *    Old data.
   *  @return array
   *    Updated data to save.
   */
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    
    return $instance;
  }
  
  /**
   *  Fetch most popular list from database.
   *
   *  @param string $category_slug
   *  @return object
   *    Result from database.
   */
  private function _get_list($category_slug) {
    global $wpdb;
    
    $sql = "SELECT url
      FROM {$wpdb->prefix}aller_most_popular
      WHERE category_slug='{$category_slug}'
      ORDER BY views
      LIMIT 10";
    $result = $wpdb->get_results($sql);
    
    return $result;
  }
}

// Instanciate object to start application.
$allerMostPopularCategory = new AllerMostPopularCategory($wpdb);
if (is_admin()) {
  add_action('admin_menu', array($allerMostPopularCategory, 'add_admin_page'));
}
$allerMostPopularCategory->run_counter();
add_action('widgets_init', create_function('', 'register_widget("AllerMostPopularCategoryWidget");'));