<?php
/**
 *  @file
 *  Template for Aller Most Popular admin page.
 *  Author: Johannes Henrysson <johannes.henrysson@aller.se>, Aller Media AB
 *
 *  @package Wordpress 3
 *  @subpackage Aller Most Popular
 */
?>
<form action="" method="post" id="aller-most-popular-category">
  <?php wp_nonce_field('aller-most-popular', 'aller-most-popular-category'); ?>
  <div class="wrap">
    <h2>Aller Most Popular</h2>
    
    <?php if (!$this->check_database()) : ?>
      <?php if (isset($_POST['update-database'])) : ?>
        <!-- This should never happen! -->
        <div class="error"><h3>Något gick fel!</h3></div>
      <?php endif; ?>
      
      <div class="updated">
        <h3>Viktigt!</h3>
        <p>
          Databasen är inte anpassad för Aller Most Popular. Vill du aktivera Aller Most Popular
          och anpassa din databas nu?
          <i>
            Anpassningen av din databas bör inte påverka annan data, men Aller Media tar inget
            ansvar för ev förlorad data. <b>Skapa alltid en backup på din data</b> innan du fortsätter.
          </i>
          <input type="submit" name="update-database" value="Anpassa databasen" class="button-primary" />
        </p>
      </div>
    <?php else : ?>
      <?php if (isset($_POST['update-database']) || isset($_POST['savesettings'])) : ?>
        <div class="updated">
          <h3>Sparat!</h3>
          <p>Uppdateringarna har sparats. Ta en kopp kaffe.</p>
        </div>
      <?php endif; ?>
      
      <div class="metabox-holder">
          <div class="form-field form-required">
            <label for="category-slug">Kategorilänk</label><br />
            <?php print network_site_url(); ?>kategori/<input type="text" name="category-slug" id="category-slug" size="20" value="<?php print get_option('aller_most_popular_category'); ?>" aria-required="true" style="width:200px;" />/
          </div>
          <input type="submit" name="savesettings" value="Spara" class="button-primary" />
      </div>
    <?php endif; ?>
  </div>
</form>