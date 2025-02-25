<?php

global $settings, $CORE;

// GET LANGUAGES
$langs = _ppt('languages');

   $settings = array(
  "title" => __("Default Layout","premiumpress"), 
  "desc" => __("Here you can select the design you want to use for your my account.","premiumpress"),
  //"video" => "https://www.youtube.com/watch?v=y8wH_LyLbeM",
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>



<div class="card card-admin" id="carousel-myaccount" >
  <div class="card-body">
  
  
         <div  class="owl-carousel owl-theme">
         
         <?php 
         
		$i=1; while($i < 3){ ?> 
       
        <div class="card-top-image mb-5 shadow-sm bg-light position-relative" style="overflow:hidden;"> <img src="<?php echo DEMO_IMG_PATH; ?>myaccount/style<?php echo $i; ?>.jpg" class="img-fluid" />
          <div class="text-center bg-dark text-light py-2 position-absolute w-100" style="bottom:0px;">Style <?php echo $i; ?></div>
        </div> 
      
      <?php $i++; } ?>
      
      </div>
      
    <script> 
jQuery(document).ready(function(){ 
		 
	var owl = jQuery("#carousel-myaccount .owl-carousel").owlCarousel({
        loop: false,
        margin: 20,
        nav: false,
        dots: false,		
        responsive: {
            0: {
                items: 2
            },
			 
            600: {
                items: 2
            },
			
			 
			
            1000: {
                items: 2
            }
        },        
    }); 
	
	owl.owlCarousel();
	
	// REFRESH	
	setTimeout(function(){	
   		owl.trigger('refresh.owl.carousel');
	}, 2000);  
	
	
});
	 
</script>
    
    
    <div class="row">

    <div class="col-12">
    
      <div class="row">
      
        <div class="col-4">
          <label><?php echo __("Selected Design","premiumpress"); ?></label>
        </div>
        
        
        
        
        <div class="col-6">
          <select name="admin_values[design][myaccount_layout]" class="form-control">
            
            <?php 
			 
			
			
			$i=1; while($i < 3){  ?>
            <option value="<?php echo $i; ?>" <?php if(_ppt(array('design','myaccount_layout')) == $i){ echo "selected=selected"; }  ?>> <?php echo __("Style","premiumpress"); ?> <?php echo $i; ?> </option>
            <?php   $i++; } ?> 
            
            
          </select>
          
          
            
     
          
        </div>
        
      </div>
      
       
      <div class="p-4 bg-light text-center mt-4">
        <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
      </div>
      
      
      
      </div>
      </div>  
  
  
  
  
  
   
   
      
    
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); 


   $settings = array(
  "title" => __("Custom Layout","premiumpress"), 
  "desc" => __("Here you can set your own design for parts of the user account page.","premiumpress"),
  //"video" => "https://www.youtube.com/watch?v=y8wH_LyLbeM",
  );

   _ppt_template('framework/admin/_form-wrap-top' ); ?>
   
   

<div class="card card-admin">
  <div class="card-body">


<?php


 
// GET ELEMENT PAGES
$elementorArray = array();
$args = array(
                   'post_type' 			=> 'elementor_library',
                   'posts_per_page' 	=> 50,
                    'orderby' 	=> 'date',
					'order' => 'desc'
               );
$wp_query = new WP_Query($args);
$tt = $wpdb->get_results($wp_query->request, OBJECT);
if(!empty($tt)){ foreach($tt as $p){ 
 $elementorArray["elementor-".$p->ID] = get_the_title($p->ID); 
} } 

 


// PAGE LINKS ARRAY
$pages = $CORE->LAYOUT("get_innerpage_blocks", array());
  
 

// ADDON HOMEPAGE
$newarray = array();
$newarray['account'] = array( "name" => "My Account (dashboard)", "link" => "", "order" => 1);
 
    
foreach($CORE->multisort($newarray, array('order'))  as $k => $p){ 
	
	// KEY
	$corekey = str_replace("page_","",$k);
	$p['id'] = $corekey;

?>
<div class="container border-bottom py-3">
  <div class="row px-0">
    <div class="col-6">
      <h6 class="mb-0"><?php echo $p['name']; ?></h6>
      
       <?php if(is_array($langs) && !empty($langs) && count($langs) > 1   ){  ?>
      <a href="javascript:void(0);" onclick="jQuery('.showtranslations<?php echo $p['id']; ?>').toggle();" 
                class="mt-3 btn btn-sm btn-system"><i class="fa fa-language"></i> <?php echo __("Show translations","premiumpress"); ?> </a> 
       
       <?php } ?>  
                
       </div>
    <div class="col-6">
      <select data-placeholder="Default Page" name="admin_values[pageassign][<?php echo $p['id']; ?>]"   class="form-control">
       <option value="0" style="color:#999999;"><?php echo __("Default Design","premiumpress"); ?></option>
        <optgroup label="Elementor Templates"></optgroup>
        <?php 
				  if(is_array($elementorArray)){
				  
				  foreach ( $elementorArray as $key => $title ) {  
				  
				     if(in_array($title, array('Default Kit'))){ continue; }
               
			    if($key == "9999"){ ?>
        <optgroup label="Page Templates"></optgroup>
        <?php continue; }
				               
               $option = '<option value="'. $key.'"';
               if( _ppt(array('pageassign', $p['id'] )) == $key){ $option .= " selected=selected ";   } 
               $option .= '>';
               $option .= $title;
               $option .= '</option>';
               echo $option; 
                } } ?>
      </select>
      
      
      <?php /***********************************************************************/ ?>
      
         <div class="div mt-3">
                
                  <div class="row px-0">
                    <div class="col-xl-6">
                    	
                        
                     <?php if(substr(_ppt(array('pageassign',$p['id'])), 0, 9) == "elementor" ){  ?>
                     
                       <a href="<?php echo get_permalink(str_replace("elementor-","",_ppt(array('pageassign',$p['id'])))); ?>" target="_blank" class=" btn btn-system btn-md btn-block"><?php echo __("View","premiumpress"); ?></a>
                       
                     <?php }elseif(strlen(_ppt(array('links', $p['id']))) > 0 ){ ?>
                      
                      <a href="<?php echo _ppt(array('links', $p['id'])); ?>" target="_blank" class=" btn btn-system btn-md btn-block"><?php echo __("View","premiumpress"); ?></a>
                      
                      <?php } ?>
                      
                    </div>
                    <div class="col-xl-6">
                    
                      <?php if(defined('ELEMENTOR_VERSION')){ ?>
                      
                      
						  <?php if(substr(_ppt(array('pageassign',$p['id'])), 0, 9) == "elementor" ){  ?>
                          
                          <a href="<?php echo home_url(); ?>/wp-admin/post.php?post=<?php echo str_replace("elementor-","",_ppt(array('pageassign',$p['id']))); ?>&action=elementor" 
                          class="btn btn-system btn-md btn-block" target="_blank" ><i class="fab fa-elementor"></i> <?php echo __("Edit","premiumpress"); ?></a>
                          
                           
                           <?php }elseif(substr(_ppt(array('pageassign',$p['id'])), 0, 5) == "page-" ){  ?>
                         
                          <a href="<?php echo home_url(); ?>/wp-admin/post.php?post=<?php echo str_replace("page-","",_ppt(array('pageassign',$p['id']))); ?>&action=edit" 
                          class="btn btn-system btn-md btn-block" target="_blank" ><i class="fab fa-wordpress"></i> <?php echo __("Edit","premiumpress"); ?></a>
                           
                          
                          <?php }else{ ?>
                           
                          
                          
                          <a href="<?php echo home_url(); ?>/wp-admin/<?php if($p['id'] == "homepage"){ ?>admin.php?page=design&loadpage=home<?php }else{ ?>admin.php?page=design&loadpage=new&inner=<?php echo $p['id']; ?><?php } ?>" class="btn btn-system btn-md btn-block" target="_blank" ><i class="fab fa-elementor"></i> <?php echo __("Edit","premiumpress"); ?></a>
                          
                          <?php } ?>
                      
                       
                      <?php } ?>
                      
                      
                           </div>
                  </div>
                </div> 
                
                
                                      <?php /***********************************************************************/ ?>
                 
                 
				 <?php if(is_array($langs) && !empty($langs) && count($langs) > 1 ){ ?>
                
                <div id="" class="p-3 py-2 bg-light mt-3 showtranslations<?php echo $p['id']; ?>" style="display:none;">
                  <?php foreach(_ppt('languages') as $lang){
			
					$icon = explode("_",$lang); 
			
					if(_ppt(array('lang','default')) == "en_US" && isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
				
				?>
                  <div class="mt-3">
                    <div class="mb-2 small">
                      <div class="flag flag-<?php if(isset($icon[1])){ echo strtolower($icon[1]); }else{ echo $icon[0]; } ?> mr-2">&nbsp;</div>
                      <?php echo $CORE->GEO("get_lang_name", $lang); ?> <?php echo $p['name']; ?> </div>
                    <select data-placeholder="Default Page" name="admin_values[pageassign][<?php echo $p['id']; ?>_<?php echo strtolower($lang); ?>]" <?php if(is_array($elementorArray) && count($elementorArray) > 30  ){ ?> data-size="10" class="form-control selectpicker"  data-live-search="true" title="&nbsp;"<?php }else{ ?>class="form-control"  <?php } ?>>
                      <option></option>
                       <option value="" style="color:#999999;"><?php echo __("Default Design","premiumpress"); ?></option>
                      <?php foreach ( $elementorArray as $key => $title ) {      
               
               $option = '<option value="'. $key.'"';
               if( _ppt(array('pageassign', $p['id']."_".strtolower($lang))) == $key){ $option .= " selected=selected "; $EditLink = substr($key,10,100); } 
               $option .= '>';
               $option .= $title;
               $option .= '</option>';
               echo $option; 
                } ?>
                    </select>
                  </div>
                  <div class="div mt-3">
                    <?php if(_ppt(array('pageassign',$p['id']."_".strtolower($lang))) != "" && isset($EditLink)){  ?>
                    <a href="<?php echo home_url(); ?>/wp-admin/post.php?post=<?php echo $EditLink; ?>&action=elementor" class="btn btn-system btn-md" target="_blank" > <i class="fa fa-pencil"></i> <?php echo __("Edit Design","premiumpress"); ?></a>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
                <?php } ?>
                
                   <?php /***********************************************************************/ ?>
                       
	  
	  
       <?php /***********************************************************************/ ?>
     
      
    </div>    
  </div>
</div>

<?php } ?> 
  
  
  <div class="p-4 bg-light text-center mt-4">
            <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
          </div>
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>

 