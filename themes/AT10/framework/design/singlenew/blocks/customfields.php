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

global $CORE, $post, $userdata; 

	
$title = __("Vehicle Details","premiumpress");



// SET DEFAULTS
$fielddata = "";


ob_start();
echo do_shortcode('[FIELDS style="1"]');
$fielddata .= ob_get_clean();
 
?>

<div class=" <?php if(isset($GLOBALS['global_design3'])){ echo "border-0"; } ?>" id="block-customfields">
    
    
  <div class="card-bodyx radiusx">
    <div class="<?php if(!isset($GLOBALS['global_design3'])){ echo 'p-lg-4'; } ?>">    
      
      
      <div class="addeditmenu" data-key="customfields"></div>
      
      
      <?php if(strlen($fielddata) > 5){ ?>
      <div id="single-display-fields">
       
        
        <?php echo $fielddata; ?> 
        
        </div>
      <?php } ?>
      
      
    </div>
  </div>
  
 
</div>