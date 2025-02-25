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

<div class="row">
  <div class="col-md-7"> <a href="javascript:void(0);" class="btn  hide-mobile" onclick="showfilersbar();"> <i class="fa fa-filter"></i> <?php echo __("Show Filters","premiumpress"); ?> </a> </div>
  <div class="col-md-5">
    <div class="row">
      <div class="col-md-6">
        <div class="dropdown filter_sortby_list">
          <button class="btn  btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php echo __("Show Status","premiumpress"); ?> </button>
          <div class="dropdown-menu btn-block" aria-labelledby="dropdownMenuButton">
            <?php 


$s =  $CORE->PACKAGE("get_status",  array() ); 

foreach($s as $status){
?>
            <a href="javascript:void(0);" class="dropdown-item" onclick="UpdateStatusT('<?php echo $status['key']; ?>')"> <span class="inline-flex items-center font-weight-bold order-status-icon <?php echo $status['css']; ?> mr-2"> <span class="dot mr-2"></span> <span class="pr-2px leading-relaxed whitespace-no-wrap"><?php echo $status['name']; ?></span> </span> </a>
            <?php
 
}


?>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-3">

        <div class="dropdown filter_sortby_list">
          <button class="btn  btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php echo __("Sort Results By","premiumpress"); ?> </button>
          <div class="dropdown-menu btn-block" aria-labelledby="dropdownMenuButton"> <a href="javascript:void(0);" class="dropdown-item active" data-key="id"><span><?php echo __("Added","premiumpress"); ?><i class="ml-2 fa fa-sort-amount-up-alt"></i></span></a> <a href="javascript:void(0);" class="dropdown-item"  data-key="modified"><span><?php echo __("Updated","premiumpress"); ?></a>
            <?php if(!in_array(THEME_KEY, array("sp"))){ ?>
            <a href="javascript:void(0);" class="dropdown-item" data-key="expiry"><span><?php echo __("Expiry Date","premiumpress"); ?><i></i></span></a>
            <?php } ?>
            <a href="javascript:void(0);" class="dropdown-item" data-key="hits"><span><?php echo __("Views","premiumpress"); ?><i></i></span></a>
            
            <?php if(in_array(THEME_KEY, array("dt"))){ ?>
             <a href="javascript:void(0);" class="dropdown-item" data-key="leads"><span><?php echo __("Leads","premiumpress"); ?><i></i></span></a>
            <?php } ?>
            
            <?php if(in_array(THEME_KEY, array("dt")) && _ppt(array('design', 'single-offers'))  == '1'){ ?>
            <a href="javascript:void(0);" class="dropdown-item" data-key="claimed"><span><?php echo __("Claimed","premiumpress"); ?><i></i></span></a>
           
           <?php }elseif(in_array(THEME_KEY, array("da"))){ ?>
           
            <a href="javascript:void(0);" class="dropdown-item" data-key="age"><span><?php echo __("Age","premiumpress"); ?><i></i></span></a>
           
            <?php }elseif(in_array(THEME_KEY, array("vt","da","dt","cp"))){ ?>
            <?php }else{ ?>
            <a href="javascript:void(0);" class="dropdown-item" data-key="price"><span><?php echo __("Price","premiumpress"); ?><i></i></span></a>
            <?php } ?>
            <a href="javascript:void(0);" class="dropdown-item" data-key="title"><span><?php echo __("Title","premiumpress"); ?><i></i></span></a> <a href="javascript:void(0);" class="dropdown-item" data-key="id"><span><?php echo __("ID","premiumpress"); ?><i></i></span></a> </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function UpdateStatusT(v){

	jQuery("#poststatusop").val(v);
	
	_filter_update();

}

</script>