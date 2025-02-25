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
  <div class="card-body"> <a href="#" data-toggle="collapse" data-target="#collapse_date" aria-expanded="true" class="">
    <h5 class="card-title">Date Filter</h5>
    </a>
    <div class="filter-content collapse" id="collapse_date" style="">
      <script>
jQuery(document).ready(function(){   

jQuery('#expiry-date').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss', pickTime: false, fontAwesome: 1,  todayBtn: true, pickerPosition: "bottom-right"}); 

jQuery('#expiry-date2').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss', pickTime: false, fontAwesome: 1,  todayBtn: true, pickerPosition: "bottom-right"}); 

});


</script>
      <div class="row">
        <div class="col-md-12">
          <label class="mt-1"><?php echo __("Start Date","premiumpress") ?></label>
        </div>
        <div class="col-md-12">
          <div class="input-group date" id="expiry-date">
            <input type="text" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?> value="" class="form-control rounded-0 customfilter" data-key="orderdate1"  data-type="text">
            <span class="input-group-addon" style="top: 10px;    right: 10px;    position: absolute;    z-index: 100;"> <span class="fal fa-calendar"></span> </span> </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <label class="mt-1"><?php echo __("End Date","premiumpress") ?></label>
        </div>
        <div class="col-md-12">
          <div class="input-group date" id="expiry-date2">
            <input type="text" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?> data-type="text" data-key="orderdate2"  class="form-control rounded-0 customfilter" >
            <span class="input-group-addon" style="top: 10px;    right: 10px;    position: absolute;    z-index: 100;"> <span class="fal fa-calendar"></span> </span> </div>
        </div>
      </div>
    </div>
  </div>
</div>
