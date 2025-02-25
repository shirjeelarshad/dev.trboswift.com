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

global $CORE, $userdata, $post, $settings; 

 		
 
?>

<div class="card card-filter">
  <div class="card-body"> <a href="#" data-toggle="collapse" data-target="#collapse_rating" aria-expanded="true" class="">
    <h5 class="card-title"><?php echo __("Rating","premiumpress"); ?></h5>
    </a>
    <div class="filter-content collapse" id="collapse_rating">
      <div class="clearfix">
        <div class="btn-group btn-group-sm btn-group-toggle border d-flex justify-content-between align-items-center border-0 ratingswitch" data-toggle="buttons" >
          <label class="btn btn-light active" onclick="updaterating(0); jQuery(this).addClass('active');" style="font-size: 11px;">
          <input type="radio" />
          <div class="rating-score-small"><strong class='bg-primary'><?php echo __("any","premiumpress"); ?></strong></div>
          </label>
          <label class="btn btn-white" onclick="updaterating(3); jQuery(this).addClass('active');"  style="font-size: 11px;">
          <input type="radio" />
          <div class="rating-score-small"><strong class='bg-primary'>3+</strong></div>
          </label>
          <label class="btn btn-light " onclick="updaterating(4); jQuery(this).addClass('active');" style="font-size: 11px;">
          <input type="radio" />
          <div class="rating-score-small"><strong class='bg-primary'>4+</strong></div>
          </label>
          <label class="btn btn-light "  onclick="updaterating(5); jQuery(this).addClass('active');" style="font-size: 11px;">
          <input type="radio" />
          <div class="rating-score-small"><strong class='bg-primary'>5</strong></div>
          </label>
        </div>
      </div>
      <script>
function updaterating(g){	 
	jQuery('.ratingswitch label').removeClass('active');	 
	jQuery('#rating-filter').val(g);
	_filter_update();
}
</script>
      <input type="hidden" id="rating-filter" class="hidden customfilter" name="rating" data-type="text" data-key="rating" value="0">
    </div>
  </div>
</div>
