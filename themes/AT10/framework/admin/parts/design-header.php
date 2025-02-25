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

global $CORE, $settings; 


 // GET LANGUAGES
$langs = _ppt('languages');

  
  $settings = array(
  
  "title" => __("Header &amp; Footer"), 
  "desc" => __("Here you can select a header/footer design for your website."), 
  "video" => "https://www.youtube.com/watch?v=FWs4WQNyIrY"
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>

<div class="card card-admin">
  <div class="card-body">
    <?php foreach( $CORE->LAYOUT("get_slots",array("header","footer")) as $s){ ?>
    
        <?php if(strlen(_ppt(array("pageassign", str_replace("_style","",$s['id'])))) > 1){ ?>
   
   <div class="text-center my-3 p-4 bg-light text-center mt-4"><i class="fa fa-engine-warning"></i>  <?php echo str_replace("_style","",$s['id']); ?> <?php echo __("disabled - custom design set below. ","premiumpress"); ?> </div>
   <?php }else{ ?>
    
    <div class="text-center position-relative" style="border:5px dashed #f1f1f1;">
      <?php if(strlen(_ppt(array('design',$s['id']))) > 1){ ?>
      <?php //echo _ppt(array('design',$s['id'])); ?>
      <img src="<?php echo $CORE->LAYOUT("get_block_prewview", _ppt(array('design',$s['id'])) ); ?>" class="img-fluid"  />
      <?php }else{ ?>
      <div style="height:180px;">&nbsp;
        <div class="p-3" style="font-size:50px; color: #efefef;    font-weight: bold;"><?php echo $s['name']; ?></div>
      </div>
      <?php } ?>
    </div>
    <div class="my-3 p-4 bg-light text-center mt-4">
    
    

    
    
      <button class="btn btn-system shadow-sm btn-md loaddatabox" type="button" data-id="<?php echo $s['id']; ?>" data-pagekey="<?php echo str_replace("_style","",$s['id']); ?>">
      <?php if(strlen(_ppt(array('design',$s['id']))) ==""){ ?>
      <i class="fa fa-tools"></i> <?php echo __("Select Design","premiumpress"); ?>
      <?php }else{ ?>
      <i class="fa fa-sync"></i> <?php echo __("Change","premiumpress"); ?>
      <?php } ?>
      </button>
      <?php if(strlen(_ppt(array('design',$s['id']))) ==""){ ?>
      <?php }else{ ?>
      <button data-settingid="<?php echo _ppt(array('design',$s['id'])); ?>" 
        data-pagekey="<?php echo str_replace("_style","",$s['id']); ?>"  
        class="loadsettingsbox btn btn-system btn-md  shadow-sm" type="button"> <i class="fa fa-cog"></i> <?php echo __("Settings","premiumpress"); ?> </button>
      <?php } ?>
      <?php if(strlen(_ppt(array('design',$s['id']))) !=""){ ?>
      <button class="btn btn-system shadow-sm btn-md " type="button" onclick="DeleteSetDesign('<?php echo $s['id']; ?>');"><i class="fa fa-trash"></i> <?php echo __("Delete","premiumpress"); ?></button>
      <?php } ?>
      
      
      
     
      
    </div>
    
     <?php } ?>
    
    <input type="hidden" name="admin_values[design][<?php echo $s['id']; ?>]" id="<?php echo $s['id']; ?>" value="<?php echo _ppt(array('design',$s['id'])); ?>" />
    <?php } ?>
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); 


  $settings = array(
  
  "title" => __("Custom Header &amp; Footer"), 
  "desc" => __("Here you can set your own header/footer designs."), 
  
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
$newarray['header'] = array( "name" => "Header", "link" => "", "order" => 1);
$newarray['footer'] = array( "name" => "Footer", "link" => "", "order" => 2);
    
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
                    <select data-placeholder="Default Page" name="admin_values[pageassign][<?php echo $p['id']; ?>_<?php echo strtolower($lang); ?>]" <?php if(is_array($elementorArray) && count($elementorArray) > 50  ){ ?> data-size="10" class="form-control selectpicker"  data-live-search="true" title="&nbsp;"<?php }else{ ?>class="form-control"  <?php } ?>>
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
