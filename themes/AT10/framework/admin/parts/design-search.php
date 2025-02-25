<?php

global $settings, $CORE;

  $settings = array(
  "title" => __("Search Page Design","premiumpress"), 
  "desc" => __("Select the layout design for your search results page.","premiumpress"),
  "video" => "https://www.youtube.com/watch?v=y8wH_LyLbeM",
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?> 
        
		<div class="card card-admin"><div class="card-body">

<div class="row">
      
        <?php
		
		$snames = array(
		
			1 => "Full Page Grid",
			2 => "Full Page List",
			
			3 => "Container Grid",
			4 => "Container List",
			
			5 => "Sidebar Grid",
			6 => "Sidebar List",
		
		 
		);
		
		if( $CORE->LAYOUT('captions','maps') && _ppt(array('maps','enable')) == 1 ){ 		
		$snames[7] = "Sidebar + Maps"; 
		}
          
         
		
		$SetThis = _ppt(array('design','search_layout'));
		if($SetThis == ""){ $SetThis = 6; }
		
		
		foreach($snames as $i => $name){ ?>
        
  <div class="col-6 col-md-4">
   <div class="card-top-image mb-5 shadow-sm bg-light position-relative" style="height:200px; overflow:hidden;">
   
   <img src="<?php echo DEMO_IMG_PATH; ?><?php echo THEME_KEY; ?>/designs/search<?php echo $i; ?>.jpg" class="img-fluid" />
   <div class="text-center bg-dark text-light py-2 position-absolute w-100" style="bottom:0px;"><?php echo $name; ?></div>
   
   </div>
   </div>
   
   <?php $i++; } ?>
   
     </div>  
   
   
    <div class="col-12">
    <div class="row">
    <div class="col-3">
    <label><?php echo __("Selected Design","premiumpress"); ?></label>
    </div>
    <div class="col-6">
    <select name="admin_values[design][search_layout]" class="form-control">
    <?php foreach($snames as $i => $name){ ?>
    <option value="<?php echo $i; ?>" <?php if( $SetThis == $i){ echo "selected=selected"; }  ?>> <?php echo $name; ?> </option>
    <?php  $i++; } ?>
    </select>
    </div>
    
    </div> 
  	</div>
    
     
    

<div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"> <?php echo __("Save Settings","premiumpress"); ?></button>
    	</div>


      
        </div></div>
      
<?php _ppt_template('framework/admin/_form-wrap-bottom' );  

 $settings = array(
  "title" => __("Homepage Search Box","premiumpress"), 
  "desc" => __("This section is only used if you have a search box on your homepage.","premiumpress"),
 
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?> 
        
		<div class="card card-admin"><div class="card-body">


    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-9">
          <label><?php echo __("Enable Custom Search","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("This will turn off the default search items and use your selections below.","premiumpress"); ?></p>
        </div>
        <div class="col-md-3">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('searchbox_enable').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('searchbox_enable').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'searchbox_enable')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="searchbox_enable" name="admin_values[design][searchbox_enable]" value="<?php if(in_array(_ppt(array('design', 'searchbox_enable')), array("1"))){  echo 1; }else{ echo 0; }  ?>">
        </div>
      </div>
    </div> 
    
    
<div class="bg-light text-center font-weight-bold opacity-5 py-3 mb-4">Select the search fields to show.</div>
    
<div class="row">

    
<?php 


$videopak = array(

	1 => array("key" => "keyword", "name" => __("Keyword","premiumpress") ),
	2 => array("key" => "tax_listing", "name" => __("Category","premiumpress") ),
	3 => array("key" => "price", "name" => __("Price","premiumpress") ),
	4 => array("key" => "location", "name" => __("Location","premiumpress") ),
	
	
	
);

$taxonomies = get_taxonomies(); 
foreach ( $taxonomies as $taxonomy ) {
if(in_array($taxonomy, array('category','post_tag','nav_menu','link_category','post_format','listing','elementor_library_type','elementor_library_category', 'elementor_font_type', 
'topic-tag', 'product_type', 'product_visibility', 'product_cat', 'product_tag', 'product_shipping_class', 'pa_color', 'pa_size', 'advanced_ads_groups', 'wpbdp_category' 
))){ continue; } 

$videopak[] = array("key" => "tax_".$taxonomy, "name" => $CORE->GEO("translation_tax_key", $taxonomy) );

}

foreach($videopak as $k => $f ){ ?>
        <div class="col-md-4">
        <label class="custom-control custom-checkbox"> 
        
        <input type="checkbox" 
        value="0" 
        class="custom-control-input" 
        id="search_<?php echo $f['key']; ?>check" 
        onchange="ChekSeF('#search_<?php echo $f['key']; ?>');"
         
		<?php if( _ppt(array('customsearchbox', $f['key'])) == 1){ ?>checked=checked<?php } ?>> 
        
          <input type="hidden" name="admin_values[customsearchbox][<?php echo $f['key']; ?>]" id="search_<?php echo $f['key']; ?>add" value="<?php if(_ppt(array('customsearchbox', $f['key'])) == 1){ echo 1; }else{ echo 0; } ?>"> 
       
      	<span class="custom-control-label"><?php echo $f['name']; ?></span>
        </label>
        </div>
<?php  } ?>
    
  
 
    
        <script>
		function ChekSeF(div){
		
			if (jQuery(div+'check').is(':checked')) {			
				jQuery(div+'add').val(1);			
			}else{			
				jQuery(div+'add').val(0);
			}
		
		}
		</script>  

</div> 
    
    
    

<div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"> <?php echo __("Save Settings","premiumpress"); ?></button>
    	</div>


      
        </div></div>
      
<?php _ppt_template('framework/admin/_form-wrap-bottom' );  ?>