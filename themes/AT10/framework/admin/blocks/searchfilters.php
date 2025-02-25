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

global $wpdb, $CORE, $CORE_ADMIN;

 
?>
           
         <!-- ------------------------- -->
          <div class="container px-0 border-bottom mb-3 mt-4">
            <div class="row py-2">
              <div class="col-md-5">
                <label><?php echo __("Order By Filters","premiumpress"); ?></label>
                <p class="text-muted"><?php echo __("Select which ones to display.","premiumpress"); ?></p>
              </div>
              <div class="col-md-7">
              
    <div class="row px-0">
    
<?php 


$videopak = array(

	1 => array("key" => "latest", "name" => __("Latest","premiumpress") ),
	2 => array("key" => "pop", "name" => __("Popular","premiumpress") ),
	3 => array("key" => "featured", "name" => __("Featured","premiumpress") ),
	
);

foreach($videopak as $k => $f ){ ?>
        <div class="col-md-4">
        <label class="custom-control custom-checkbox"> 
        
        <input type="checkbox" 
        value="1" 
        class="custom-control-input" 
        id="search_<?php echo $f['key']; ?>check" 
        onchange="ChekSeF('#search_<?php echo $f['key']; ?>');"
         
		<?php if( _ppt(array('search', $f['key'])) == 1){ ?>checked=checked<?php } ?>> 
        
          <input type="hidden" name="admin_values[search][<?php echo $f['key']; ?>]" id="search_<?php echo $f['key']; ?>add" value="<?php if(_ppt(array('search', $f['key'])) == "" || _ppt(array('search', $f['key'])) == 1){ echo 1; }else{ echo 0; } ?>"> 
       
      	<span class="custom-control-label"><?php echo $f['name']; ?></span>
        </label>
        </div>
<?php  } ?>
    
    </div>
    </div></div></div>
    
        <script>
		function ChekSeF(div){
		
			if (jQuery(div+'check').is(':checked')) {			
				jQuery(div+'add').val(1);			
			}else{			
				jQuery(div+'add').val(0);
			}
		
		}
		</script>  