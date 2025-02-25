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

global $CORE;  ?>

<div class="card card-filter">
  <div class="card-body">
  
  <a href="#" <?php if(!$CORE->isMobileDevice()){ ?>data-toggle="collapse" data-target="#collapse_keyword" aria-expanded="true" <?php } ?>>
    <h5 class="card-title"><?php echo __("Keyword Filter","premiumpress"); ?></h5>
    </a>
    <div <?php if(!$CORE->isMobileDevice()){ ?>class="filter-content collapse" id="collapse_keyword"<?php }else{ ?> class="pt-2"<?php } ?>>
      <div class="position-relative">
        <input type="text" class="form-control customfilter" name="keyword" data-type="text" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?> data-key="keyword" autocomplete="off"  placeholder="<?php echo __("Keyword..","premiumpress"); ?>" value="<?php if(isset($_GET['s'])){ echo esc_attr($_GET['s']); } ?>">
       	<?php if(!$CORE->isMobileDevice()){ ?>
        <button class="btn position-absolute text-muted prev" type="button" onclick="_filter_update()" ><i class="fal fa-search prev"></i></button>
        <?php } ?>
      </div>
    </div>
  </div>
</div>