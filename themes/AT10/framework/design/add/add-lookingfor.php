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

global $CORE, $userdata;


$editID=0;
if(isset($_GET['eid']) && is_numeric($_GET['eid'])){
$editID = $_GET['eid'];
} 
 
?>

<div class="card shadow-sm mt-4">
  <div class="card-body">
    <div class="row">
      <div class="col-12">
        <h4><?php echo __("I'm Looking For","premiumpress"); ?></h4>
        <hr />
      </div>
      <div class="col-6">
        <label><?php echo __("Gender","premiumpress"); ?></label>
        <select  name="custom[lookinggen]" class="form-control required" >
          <?php
$count = 1;
$cats = get_terms( 'dagender', array( 'hide_empty' => 0, 'parent' => 0  ));
if(!empty($cats)){
foreach($cats as $cat){ 
if($cat->parent != 0){ continue; } 
 
?>
          <option value="<?php echo $cat->term_id; ?>" <?php selected( $CORE->get_edit_data("lookinggen", $editID), $cat->term_id ); ?>> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
          <?php $count++; } } ?>
        </select>
      </div>
      <div class="col-6">
        <label><?php echo __("Aged Between","premiumpress"); ?></label>
        <select  name="custom[lookingage]" class="form-control required" >
          <?php
 $vv = array(
 	1 => __("Any Age","premiumpress"),
	2 => __("Over 20","premiumpress"),
	3 => __("Between 20 &amp; 30","premiumpress"),
	4 => __("Between 30 &amp; 40","premiumpress"),
	5 => __("Between 40 &amp; 50","premiumpress"),
	6 => __("Over 50","premiumpress"), 
 );
foreach($vv as $vh => $v){
?>
          <option value="<?php echo $vh; ?>"  <?php selected( $CORE->get_edit_data("lookingage", $editID), $vh ); ?>> <?php echo $v; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-12 mt-4">
        <label> <?php echo __("Describe what your looking for.","premiumpress"); ?> </label>
        <div class="input-group">
          <textarea name="custom[lookingdesc]" class="form-control" style="min-height:100px;"><?php echo $CORE->get_edit_data('lookingdesc', $editID); ?></textarea>
        </div>
      </div>
    </div>
  </div>
</div>
