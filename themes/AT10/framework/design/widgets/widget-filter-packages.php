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

<div class="card card-filter">
	<div class="card-body">
			<a href="#" data-toggle="collapse" data-target="#collapse_packages" aria-expanded="true" class="">
				 
				<h5 class="card-title">Listing Packages </h5>
			</a>
		 
		<div class="filter-content collapse" id="collapse_packages">
			 
            
<?php 
 
foreach(  $CORE->PACKAGE("get_packages", array() ) as $k => $n){
?>
<label class="custom-control custom-checkbox">
				  <input type="checkbox" value="<?php echo $k; ?>" name="pakid" data-key="pakid" data-value="<?php echo $k; ?>" data-type="checkbox" class="custom-control-input customfilter" onclick="_filter_update()">
				  <div class="custom-control-label"><?php echo $n['name']; ?>  </div>
</label>
 
<?php } ?>

<label class="custom-control custom-checkbox">
<input type="checkbox" value="none" name="pakid" data-key="pakid" data-value="none" data-type="checkbox" class="custom-control-input customfilter" onclick="_filter_update()">
				  <div class="custom-control-label">None Set </div>
</label>


<h6 class="title mt-4">Listing Status </h6>


<?php 
 
foreach(  $CORE->PACKAGE("get_status", array() ) as $k => $n){
?>
<label class="custom-control custom-checkbox">
				  <input type="checkbox" value="<?php echo $k; ?>" name="post_status" data-key="post_status" data-value="<?php echo $k; ?>" data-type="checkbox" class="custom-control-input customfilter" onclick="_filter_update()">
				  <div class="custom-control-label"><?php echo $n['name']; ?></div>
</label>
 
<?php } ?>            
 
	</div> 
</div>
</div>