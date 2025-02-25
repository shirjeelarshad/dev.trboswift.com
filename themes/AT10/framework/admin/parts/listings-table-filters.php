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

global $CORE;
 
 
?>

<div class="py-4">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-lg-3 border-right">
        <label><?php echo __("Keyword","premiumpress"); ?></label>
        <div class="position-relative">
          <input type="text" class="form-control customfilter" name="keyword" data-type="text" onchange="_filter_update()" data-key="keyword" autocomplete="off" placeholder="Keyword.." value="">
          <button class="btn position-absolute text-muted" style="top:5px; right:0px;" type="button" onclick="_filter_update()"><i class="fal fa-search"></i></button>
        </div>
        <label class="custom-control custom-checkbox mt-4">
        <input type="checkbox"  class="custom-control-input customfilter"  data-type="checkbox" data-key="featured" data-value="1" onclick="_filter_update()">
        <span class="custom-control-label font-weight-normal"></span>
        <?php if(THEME_KEY == "cp"){ ?>
        <?php echo __("Staff Picks","premiumpress") ?>
        <?php }else{ ?>
        <?php echo __("Featured","premiumpress") ?>
        <?php } ?>
        </label>
        <label class="custom-control custom-checkbox">
        <input type="checkbox"  class="custom-control-input customfilter"  data-type="checkbox" data-key="sponsored" data-value="1" onclick="_filter_update()">
        <span class="custom-control-label font-weight-normal"></span> <?php echo __("Sponsored","premiumpress") ?> </label>
        <label class="custom-control custom-checkbox">
        <input type="checkbox"  class="custom-control-input customfilter"  data-type="checkbox" data-key="homepage" data-value="1" onclick="_filter_update()">
        <span class="custom-control-label font-weight-normal"></span> <?php echo __("Homepage","premiumpress") ?> </label>
      </div>
      <div class="col-md-4 col-lg-3 border-right">
        <label><?php echo __("Category","premiumpress"); ?></label>
        <?php      
$cats = get_terms( 'listing', array( 'hide_empty' => 1, 'parent' => 0  ));
if(!empty($cats)){
?>
        <select class="form-control customfilter" onchange="_filter_update()" name="catid" name="catid[]" data-type="select"  data-key="catid">
        <option value="">------</option>
        <?php
$count = 1;

foreach($cats as $cat){ 

if($cat->parent != 0){ continue; } 
 
?>
        <option value="<?php echo $cat->term_id; ?>"><?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
        <?php $count++; }  ?>
        </select>
        <?php } ?>
      </div>
      <div class="col-md-4 col-lg-3 border-right">
        <label><?php echo __("Status","premiumpress"); ?></label>
        <select class="form-control customfilter" id="poststatusop" data-type="select" onchange="_filter_update()" data-key="post_status">
          <option value="pending,pending_approval,publish,payment,expired">----</option>
          <option value="publish"><?php echo __("Live","premiumpress"); ?></option>
          <option value="pending"><?php echo __("Pending","premiumpress"); ?></option>
          <option value="pending_approval"><?php echo __("Pending Approval","premiumpress"); ?></option>          
          <option value="payment"><?php echo __("Waiting Payment","premiumpress"); ?></option>
           <option value="expired"><?php echo __("Expired","premiumpress"); ?></option>         
          <option value="trash"><?php echo __("Delete","premiumpress"); ?></option>
        </select>
      </div>
      <div class="col-md-4 col-lg-3 ">
        <?php
			$addons = $CORE->PACKAGE("get_packages", array() );  ?>
        <?php if(!empty($addons)){ ?>
        <label><?php echo __("Package","premiumpress"); ?></label>
        <select class="form-control customfilter" data-type="select" onchange="_filter_update()" data-key="pakid">
          <option value="">----</option>
          <?php 
			 
			foreach($addons as $a){    ?>
          <option value="<?php echo $a['key']; ?>"><?php echo $a['name']; ?></option>
          <?php } ?>
        </select>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
