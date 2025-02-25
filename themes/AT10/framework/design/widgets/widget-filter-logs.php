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
			<a href="#" data-toggle="collapse" data-target="#collapse_otype" aria-expanded="true" class="">
				 
				<h5 class="card-title">Log Type</h5>
			</a>
	 
		<div class="filter-content collapse show" id="collapse_otype" style="">
	 
            
            
 
 
<?php
 
foreach(  $CORE->FUNC("get_logtype", array() ) as $k => $n){
?>


<label class="custom-control custom-checkbox " >
<input type="checkbox"  value="<?php echo $k; ?>" name="catid[]" class="custom-control-input customfilter" onclick="_filter_update()"

  data-divid="ordertype-<?php echo $k; ?>" data-key="ordertype" data-value="<?php echo $k; ?>" data-old-value="" data-type="checkbox" >
 

</label>
 
 
<?php } ?>
</select>
 
            
 
			</div> 
		</div>
</div>
    