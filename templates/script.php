<script type="text/javascript">
  jQuery.ajax({
    url: "<?php print plugins_url('aller-most-popular-count.php', dirname(__FILE__)); ?>",
    data: "url=" + jQuery(location).attr('href') + "&cat=<?php print get_option('aller_most_popular_category') ?>",
  });
</script>