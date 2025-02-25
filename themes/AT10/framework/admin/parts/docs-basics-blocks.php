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

global $CORE, $settings;

?>

<div class="row">
  <div class="col-md-4 pr-lg-4">
    <h3 class="mt-4 count-all">All Blocks <span></span> </h3>
    <p class="text-muted lead">Here you can view all the design blocks integrated into this theme.</p>
    <ul class="list-group list-group-flush">
      <?php foreach($CORE->LAYOUT("get_block_types",array()) as $type){ ?>
      <li class=" mb-2 d-flex justify-content-between align-items-center border-bottom pb-2"> <a href="#" onclick="jQuery('.blocklist').hide(); jQuery('#blocklist-<?php echo $type['id']; ?>').show();jQuery('.lazy').trigger('appear');" class="text-dark"> <?php echo $type['name']; ?> </a> <span class="badge badge-primary badge-pill count-<?php echo $type['id']; ?>">0</span> </li>
      <?php } ?>
    </ul>
    <script>
               jQuery(document).ready(function(){ 
               
               jQuery('.count-all span').html( '('+jQuery('.blocktype').length+')');
			    
			   <?php foreach($CORE->LAYOUT("get_block_types",array()) as $type){ ?>
               jQuery('.count-<?php echo $type['id']; ?>').html( jQuery('.<?php echo $type['id']; ?>').length); 
               <?php } ?>
               
               
               });
       </script>
  </div>
  <div class="col-md-8">
    <div class="card card-admin">
      <div class="card-body">
        <?php foreach($CORE->LAYOUT("get_block_types",array()) as $type){ ?>
        <div id="blocklist-<?php echo $type['id']; ?>" class="blocklist"  <?php if($type['id'] != "header"){ ?>style="display:none;"<?php } ?>> <a href="<?php echo home_url(); ?>/?ppt_live_preview=1&tid=<?php echo $type['id']; ?>" target="_blank" class="btn btn-primary float-right">Preview All</a>
          <h4><?php echo $type['name']; ?></h4>
          <hr />
          <?php foreach($CORE->LAYOUT("load_all_by_cat", $type['id'] ) as $tid => $g){ ?>
          <div class="position-relative border blocktype <?php echo $type['id']; ?>" style="min-height:100px;"> <a href="<?php echo home_url(); ?>/?ppt_live_preview=1&tid=<?php echo $type['id']; ?>&sid=<?php echo $tid; ?>" target="_blank"> <img data-src="<?php echo $CORE->LAYOUT("get_block_prewview", $tid  ); ?>" class="img-fluid lazy" /> </a> </div>
          <div class="text-center small mt-2 font-weight-bold text-muted"><?php echo $tid; ?></div>
          <hr />
          <?php } ?>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
