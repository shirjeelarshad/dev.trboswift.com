<?php
/* 
* Theme: TURBOBID CORE FRAMEWORK FILE
* Url: www.turbobid.ca
* Author: Md Nuralam
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $CORE, $LAYOUT, $wpdb, $wp_query; 
 
$term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
 
if($term->taxonomy != "store" && strlen($term->description) > 5  ){
?>

<div class="bg-white p-4  mb-4 border">
  <div class="row">
    <div class="col">
      <h1 class="h4"><?php echo $CORE->GEO("translation_tax_with_termdata", $term); ?></h1>
      <div class="mt-4 text-muted">
        <?php echo wpautop($CORE->GEO("translation_tax_desc_with_termdata", $term)); ?>
      </div>
      <?php if($term->taxonomy == "store" && strlen(_ppt('storelinkaff_'.$term->term_id)) > 0){ ?>
      <a href="<?php echo _ppt('storelinkaff_'.$term->term_id); ?>" rel="nofollow" target="_blank" class="btn btn-primary btn-icon icon-after mt-4"><?php echo __("Visit Store","premiumpress"); ?> <i class="fa fa-angle-right"></i> </a>
      <?php } ?>
    </div>
    <?php if($term->taxonomy == "store" && strlen(_ppt('storelink_'.$term->term_id)) > 0){ ?>
    <div class="col-md-4"> <?php echo do_shortcode('[SCREENSHOT url="'._ppt('storelink_'.$term->term_id).'"]'); ?> </div>
    <?php } ?>
  </div>
</div>
<?php }  ?>
<input type="hidden" name="taxonomy"  class="customfilter" data-type="text" data-key="taxonomy" value="<?php echo $term->taxonomy."-".$term->term_id; ?>" >
<script>
jQuery(document).ready(function(){ 
jQuery('.f-<?php echo $term->taxonomy."-".$term->term_id; ?>').find('input').prop( "checked", true );
});
</script>