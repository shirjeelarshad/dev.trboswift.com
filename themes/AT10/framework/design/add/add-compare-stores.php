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

 
$data = array();
$content = "";
$for = "";
$against = "";
$rating = "5";
if(isset($_GET['eid'])){
	$data 		= get_post_meta($_GET['eid'],'comparedata',true);
	$content 	= get_post_meta($_GET['eid'],'cm_verdict',true);
	$for 		= get_post_meta($_GET['eid'],'cm_for',true);
	$against 	= get_post_meta($_GET['eid'],'cm_against',true);
	$rating 	= get_post_meta($_GET['eid'],'cm_rating',true);

}
 
?>
 

<div class="card shadow-sm <?php if(!isset($_POST['ajaxedit'])){ ?>mt-5<?php } ?>">
  <div class="card-body">
  
  <?php if(!isset($_POST['ajaxedit'])){ ?>
   <a href="javascript:void(0);" onclick="jQuery('#showstoresdrop').slideToggle();" style="float:right; font-size:30px;"><i class="fa fa-chevron-down f-3x"></i></a>
 <?php } ?>
 
 <?php if(is_admin()){ ?>
  <a href="edit-tags.php?taxonomy=store&post_type=listing_type" class="float-right small mr-4" target="_blank"><u><?php echo __("Manage Stores","premiumpress"); ?></u></a>
  <?php } ?>
  
    <h4><?php echo __("Price Comparison","premiumpress"); ?></h4>
    <p class="text-muted"><?php echo __("Here you can add your own affiliate links to compared products.","premiumpress"); ?></p>
    
    
    <div id="showstoresdrop"  <?php if(!isset($_POST['ajaxedit'])){ ?>style="display:none;"<?php } ?>>
    <hr />
   
    <ul id="comparelist" class="list-unstyled"" >
      <?php $i=0; if(is_array($data) && !empty($data) ){ foreach($data['price'] as $d){ if($data['price'][$i] == ""){ $i++; continue; } ?>
      <li class="row-<?php echo $i; ?>" style="margin-bottom:40px;">
        <div class="compare_row clearfix border p-4">
          <div class="container">
            <div class="row mb-4 mt-3">
              <div class="col-md-4">
                <label><?php echo __("Store","premiumpress"); ?></label>
              </div>
              <div class="col position-relative">
                  
            <select name="comparedata[store][]" class="form-control rounded-0 bg-white">
               <option value=""><?php echo __("None Selected","premiumpress"); ?></option>
               <?php
                  $count = 1;
                  $cats = get_terms( 'store', array( 'hide_empty' => 0, 'parent' => 0  ));
                  if(!empty($cats)){
                  foreach($cats as $cat){ 
                  if($cat->parent != 0){ continue; } 
                   
                  ?>
               <option value="<?php echo $cat->term_id; ?>" <?php if( isset($data['store'][$i]) && $data['store'][$i] == $cat->term_id ){ echo "selected=selected"; }  ?>> <?php echo $cat->name; ?></option>
               <?php $count++; } } ?> 
            </select>
            </div>
            </div>
 
            <div class="row mb-4">
              <div class="col-md-4">
                <label><?php echo __("Price","premiumpress"); ?></label>
              </div>
              <div class="col position-relative">
                <input class="form-control hasaddon"  type="text" name="comparedata[price][]" value="<?php if( isset($data['price'][$i]) ){ echo $data['price'][$i]; } ?>" />
                <span class="input-group-addon" style="top: 10px;    right: 30px;    position: absolute;    z-index: 100;"> <?php echo hook_currency_symbol(''); ?></span> </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label><?php echo __("Buy Link","premiumpress"); ?></label>
              </div>
              <div class="col position-relative">
                <input class="form-control" type="text" placeholder="https://.." name="comparedata[link][]" value="<?php if( isset($data['link'][$i]) ){ echo $data['link'][$i]; } ?>" />
                <span class="input-group-addon" style="top: 10px;    right: 30px;    position: absolute;    z-index: 100;"> <i class="fa fa-link"></i> </span> </div>
            </div>
            <div class="clear"></div>
          </div>
        </div>
        <hr />
        <button type="button" onclick="remove_compare('row-<?php echo $i; ?>');" class="float-right btn btn-system btn-md"><?php echo __("Remove","premiumpress"); ?></button>
      </li>
      <?php $i++; } } ?>
    </ul>
    <button type="button" class="button" onclick="add_compare_row();"><?php echo __("Add New","premiumpress"); ?></button>
    
    </div>
    <div id="master-compare-row" style="display:none;">
    
    
      <li class="row-0" style="margin-bottom:40px;">
        <div class="compare_row clearfix border p-4">
          <div class="container">
            <div class="row mb-4 mt-3">
              <div class="col-md-4">
                <label><?php echo __("Store Logo","premiumpress"); ?></label>
              </div>
              <div class="col position-relative">
                <input class="hasaddon compare_image_url form-control"  type="text" name="comparedata[logo][]"  />
                <span class="input-group-addon" style="top: 10px;    right: 30px;    position: absolute;    z-index: 100;"> <a href="javascript:void(0);" onclick="add_compare_image(this)" class="text-dark"><span class="fal fa-camera"></span></a></span> </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-4">
                <label><?php echo __("Name","premiumpress"); ?></label>
              </div>
              <div class="col position-relative">
                <input class="form-control" type="text" name="comparedata[name][]" value="<?php if( isset($data['name'][$i]) ){ echo $data['name'][$i]; } ?>" />
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-4">
                <label><?php echo __("Price","premiumpress"); ?></label>
              </div>
              <div class="col position-relative">
                <input class="form-control hasaddon"  type="text" name="comparedata[price][]" />
                <span class="input-group-addon" style="top: 10px;    right: 30px;    position: absolute;    z-index: 100;"> <?php echo hook_currency_symbol(''); ?></span> </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label><?php echo __("Buy Link","premiumpress"); ?></label>
              </div>
              <div class="col position-relative">
                <input class="form-control" type="text" placeholder="https://.." name="comparedata[link][]"  />
                <span class="input-group-addon" style="top: 10px;    right: 30px;    position: absolute;    z-index: 100;"> <i class="fa fa-link"></i> </span> </div>
            </div>
            <div class="clear"></div>
          </div>
        </div>
        <hr />
      </li>
    </div>
  </div>
</div>
<script>


  		function remove_compare(h) {
            jQuery('#comparelist .'+h).html('');
        }

        function add_compare_row() {
            var row = jQuery('#master-compare-row').html();
            jQuery(row).appendTo('#comparelist');
        }

	jQuery(document).ready(function(){ 	
	
	jQuery('#comparelist').sortable();
	
	});	
 
	
        function add_compare_image(obj) {
		 	
            var parent = jQuery(obj).parent().parent().parent().parent('div.compare_row');
		 	 
            var inputField = jQuery(parent).find(".compare_image_url");

            tb_show('', 'media-upload.php?TB_iframe=true');

            window.send_to_editor = function(html) {
		   
				if(typeof jQuery(html).attr('rel') === "undefined"){
				 
				var url = jQuery(html).attr('src');	 				 
				var imageid = jQuery(html).attr('class').replace(/\D/g,'');					 
                inputField.val(url);				
                jQuery(parent).find("div.image_wrap").html('<img src="'+url+'" height="48" style="float:left; max-width:50px;" /><input type="hidden" name="gallery[image_aid][]" value="' + imageid +'">');

				
				} else {
			 
				$thisimage = jQuery(html).find("img");		 	
				var url 		= $thisimage[0]['src'];	 				 
				var imageid 	= $thisimage[0]['className'].replace(/\D/g,'');								 
                inputField.val(url);				
                jQuery(parent).find("div.image_wrap").html('<img src="'+url+'" height="48" style="float:left; max-width:50px;" /><input type="hidden" name="gallery[image_aid][]" value="' + imageid +'">');

				
				}
			  
				
                // inputField.closest('p').prev('.awdMetaImage').html('<img height=120 width=120 src="'+url+'"/><p>URL: '+ url + '</p>'); 

                tb_remove();
            };

            return false;  
        }

        function remove_field(obj) {
            var parent=jQuery(obj).parent().parent();
            //console.log(parent)
            parent.remove();
        }

        function add_field_row() {
            var row = jQuery('#master-row').html();
            jQuery(row).appendTo('#mediaelements');
        }
    </script>
