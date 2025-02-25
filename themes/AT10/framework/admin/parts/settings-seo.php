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
 
 
global $settings, $CORE, $CORE_ADMIN;

 
  $settings = array(
  
  "title" => __("Meta Tags","premiumpress"), 
  "desc" => __("Here you can change the meta tags for your website pages.","premiumpress")."<br><br><br><span class='badge badge-success'>Beta Test</span> This section is currently under beta testing. More options to come in future updates.",
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
 
 
   <div class="card card-admin">
        <div class="card-body">        
        
           <div class="row border-bottom pb-3 mb-3">
            <div class="col-md-8 ">
              <label class="font-weight-bold mb-2"><?php echo __("Enable Built-in SEO Tools","premiumpress"); ?></label>
              <p class="text-muted"><?php echo __("Turn on/off to use built-in theme options.","premiumpress"); ?></p>
            </div>
            <div class="col-md-2 mt-3 formrow">
              <div class="">
                <label class="radio off">
                <input type="radio" name="toggle" 
                     value="off" onchange="document.getElementById('enableseo').value='0'">
                </label>
                <label class="radio on">
                <input type="radio" name="toggle"
                     value="on" onchange="document.getElementById('enableseo').value='1'">
                </label>
                <div class="toggle <?php if( _ppt(array('seo','enable')) == '1'){  ?>on<?php } ?>">
                  <div class="yes">ON</div>
                  <div class="switch"></div>
                  <div class="no">OFF</div>
                </div>
              </div>
              <input type="hidden" id="enableseo" name="admin_values[seo][enable]" value="<?php echo _ppt(array('seo','enable')); ?>">
            </div>
          </div>
             
        
        
        
        
        
<?php if( _ppt(array('seo','enable')) == '1'){  ?>
        
          
          <div class="accordion border mt-4" id="accPackages">
          
          
            <?php  $i=1; foreach($CORE->multisort(_ppt_metapages(), array('order'))  as $k => $page){ ?>
            
            <div class="card-header p-0 mb-0 bg-white" id="heading<?php echo $i; ?>">
            
              <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" 
              aria-expanded="true" aria-controls="collapse<?php echo $i; ?>" onclick="titleStrength('<?php echo $k; ?>');">
       
              <h5 class="mb-0">
                <div class="title" style="font-size:16px;">
                  <?php echo $page['name']; ?>  
                  
                                   
                  </div>
                  
                  <span id="<?php echo $k; ?>_smile_top" class="position-absolute" style="right:10%; top:15px;"></span>
                  
              </h5>
              
              </button>
              
            </div> 
            
            
            <div id="collapse<?php echo $i; ?>" class="collapse <?php if($i == 0){ echo "show"; } ?>" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accPackages">
              <div class="card-body bg-light border mb-4 pb-4" style="margin: -1px;">
              
              <div class="mb-1">
              
              <?php if($k == "category"){ ?>
              <label>Global Page Title</label>
              <?php }else{ ?>
              <label>Page Title</label>
              <?php } ?>
             
             <div class="position-relative">
              <input class="form-control" style="width:90%" onkeyup="titleStrength('<?php echo $k; ?>', 0);" name="admin_values[seo][<?php echo $k; ?>_title]" id="<?php echo $k; ?>_title" value="<?php if(_ppt(array('seo', $k.'_title')) == ""){  echo $page['default']; }else{ echo _ppt(array('seo', $k.'_title')); } ?>" />
              
              <span id="<?php echo $k; ?>_smile" class="position-absolute" style="right:0px; top:5px;"></span>
              <span id="<?php echo $k; ?>_count" class="position-absolute" style="right:12%; top:8px;">0</span>
              
              </div>
              <script>
jQuery(document).ready(function(){ titleStrength('<?php echo $k; ?>', 0); });
</script>

                   
        <?php if(isset($page['tags']) && is_array($page['tags']) && !empty($page['tags']) ){ ?>
        <div class="mt-2">
			<?php foreach($page['tags'] as $tag){ ?>
            
            <span class="mr-2 badge border font-weight-normal bg-white" style="cursor:pointer;" onclick="addToTitle('<?php echo $k; ?>_title','<?php echo strtoupper($tag); ?>');"><?php echo $tag; ?></span>
            
            <?php } ?>
        </div>
        
        <?php } ?>
              
              </div>
              
              
              
              
              
              
              
              
 <?php if(in_array($k, array("pages")) ){ ?>
             
<label class="mt-4">Custom Page Titles</label>
               
<?php foreach($CORE->LAYOUT("get_innerpage_blocks", array()) as $pageinnerkey => $d){ 

if($pageinnerkey == "page_listingpage"){ continue; }  ?>

<div class="position-relative">
              <input class="form-control" style="width:90%"
              placeholder= "<?php echo $d['name']; ?>"
               onkeyup="titleStrength('<?php echo $pageinnerkey; ?>', 1);" 
               name="admin_values[seo][<?php echo $pageinnerkey; ?>_title]" 
               id="<?php echo $pageinnerkey; ?>_title" 
               value="<?php if(_ppt(array('seo', $pageinnerkey.'_title')) == ""){  echo ""; }else{ echo _ppt(array('seo', $pageinnerkey.'_title')); } ?>" />
              
              <span class="position-absolute" style="right:22%; top:10px;"><a href="<?php echo $d['link']; ?>" target="_blank" class="text-dark"><i class="fal fa-external-link"></i></a></span>
             
              <span class="position-absolute" style="right:17%; top:10px;"><a href="wp-admin/post.php?post=<?php echo $pageinnerkey; ?>&action=edit" target="_blank" class="text-dark"><i class="fal fa-cog"></i></a></span>
              <span id="<?php echo $pageinnerkey; ?>_smile" class="position-absolute" style="right:0px; top:5px;"></span>
              <span id="<?php echo $pageinnerkey; ?>_count" class="position-absolute" style="right:12%; top:8px;">0</span>
              
              </div>
              
<script>
jQuery(document).ready(function(){ titleStrength('<?php echo $pageinnerkey; ?>', 1); });
</script>
<?php } ?>


<?php }elseif(in_array($k, array("category","store")) ){ ?>
             
              <label class="mt-4">Custom Page Titles</label>
              
              
<?php

if($k == "category"){
$taxonomy = "listing";
}elseif($k == "store"){
$taxonomy = "store";
}


$count = 1;
$cats = get_terms( $taxonomy , array( 'hide_empty' => 0  ));
if(!empty($cats)){

	foreach($cats as $cat){ 
	//if($cat->parent != 0){ continue; } 

?>


<div class="position-relative">
              <input class="form-control" style="width:90%"
              placeholder= "<?php echo $cat->name; ?>"
               onkeyup="titleStrength('<?php echo $cat->term_id; ?>', 1);" 
               name="admin_values[seo][<?php echo $cat->term_id; ?>_title]" 
               id="<?php echo $cat->term_id; ?>_title" 
               value="<?php if(_ppt(array('seo', $cat->term_id.'_title')) == ""){  echo ""; }else{ echo _ppt(array('seo', $cat->term_id.'_title')); } ?>" />
              
              <span class="position-absolute" style="right:22%; top:10px;"><a href="<?php echo get_term_link($cat); ?>" target="_blank" class="text-dark"><i class="fal fa-external-link"></i></a></span>
             
              <span class="position-absolute" style="right:17%; top:10px;"><a href="wp-admin/term.php?taxonomy=<?php echo $taxonomy; ?>&tag_ID=<?php echo $cat->term_id; ?>" target="_blank" class="text-dark"><i class="fal fa-cog"></i></a></span>
              <span id="<?php echo $cat->term_id; ?>_smile" class="position-absolute" style="right:0px; top:5px;"></span>
              <span id="<?php echo $cat->term_id; ?>_count" class="position-absolute" style="right:12%; top:8px;">0</span>
              
              </div>
              
<script>
jQuery(document).ready(function(){ titleStrength('<?php echo $cat->term_id; ?>', 1); });
</script>

<?php $count++; } } ?>
              

              <?php } ?> 
              
              
              
              
              
              
              
              
              <div class="small mb-4 mt-3">
              
              <span class="opacity-8">Recommended between <strong>50-60</strong> characters. - <a href="javascript:void(0);" onclick="jQuery('#<?php echo $k; ?>_extra').toggle();">show keywords/ description</a></span> 
              
              
              </div>
                
              
              
              
              <div id="<?php echo $k; ?>_extra" style="display:none;">
                  <div class="mb-4">
                  <label>Keywords</label>
                  <input class="form-control" name="admin_values[seo][<?php echo $k; ?>_keywords]" value="<?php echo _ppt(array('seo', $k.'_keywords')); ?>" />
                  </div>
                  
                  <div class="">
                  <label>Description</label>
                  <textarea class="form-control" style="height:200px !important;" name="admin_values[seo][<?php echo $k; ?>_desc]"><?php echo _ppt(array('seo', $k.'_desc')); ?></textarea>
                  <div class="small my-3">Meta descriptions can be any length, but Google truncates snippets to 155 - 160 characters.</div>
                  </div>
              
              </div>
               
              
          <div class="small border-top pt-3 position-relative"> 
         
      
         
                
         <label class="custom-control custom-checkbox "> 
            
            <input type="checkbox" 
            value="1" 
           
            class="custom-control-input"  id="force_<?php echo $k; ?>check" onchange="ChekME('#force_<?php echo $k; ?>');"
             
            <?php if( _ppt(array('seo', $k.'_force')) == 1){ ?>checked=checked<?php } ?>> 
            
              <input type="hidden" name="admin_values[seo][<?php echo $k; ?>_force]" id="force_<?php echo $k; ?>add" value="<?php if(_ppt(array('seo', $k.'_force')) == 1){ echo 1; }else{ echo 0; } ?>"> 
           
            <span class="custom-control-label">&nbsp;</span>
            </label>
        
        <div style="left:30px; top: 18px;" class="opacity-5 position-absolute"> <strong>Force display </strong> -  This will overwrite any plugins you might be using. </div>
      
         
        </div>  
   
              
              
              </div>
            </div> 

 <script>
jQuery(document).ready(function(){ titleStrength('<?php echo $k; ?>', 0); });
</script>



 <?php $i++; } ?>
 </div>
 
    <script>
	
	
 
function titleStrength(div, inner) {
 
	var len = jQuery('#'+div+'_title').val().length;
	
	// SMILE
	if(len == 0){
	
	jQuery('#'+div+'_smile').html('<i class="fal fa-meh fa-2x text-grey opacity-5"></i>');	
	
	jQuery('#'+div+'_count').html( '<span  class="badge badge-dark">'+ len +'</span>' );
	
	}else if(len < 20){
	
	jQuery('#'+div+'_smile').html('<i class="fal fa-frown fa-2x text-danger"></i>');	
	
	jQuery('#'+div+'_count').html( '<span  class="badge badge-danger">'+ len +'</span>' );
	
	}else if(len < 40){
	
	jQuery('#'+div+'_smile').html('<i class="fal fa-grin text-warning fa-2x"></i>');
	
	jQuery('#'+div+'_count').html( '<span  class="badge badge-warning">'+ len +'</span>' );
 
	}else if( len < 62){
	
	jQuery('#'+div+'_smile').html('<i class="fal fa-smile-beam text-success fa-2x"></i>');	
	
	jQuery('#'+div+'_count').html( '<span  class="badge badge-success">'+ len +'</span>' );
	
	}else {
	
	jQuery('#'+div+'_smile').html('<i class="fal fa-frown-open text-danger fa-2x"></i>');	
	
	jQuery('#'+div+'_count').html( '<span  class="badge badge-danger">'+ len +'</span>' );
	
	} 
	 
	// SMILE TOP
	if(inner != 1){
	jQuery('#'+div+'_smile_top').html(jQuery('#'+div+'_smile').html()).find('i').removeClass('fa-2x');	
	}
 
}
	
	
	
		function ChekME(div){
		
			if (jQuery(div+'check').is(':checked')) {			
				jQuery(div+'add').val(1);			
			}else{			
				jQuery(div+'add').val(0);
			}
		
		}
		function addToTitle(div, key){
			
			jQuery('#'+div).val(jQuery('#'+div).val()+' ['+key+']');
			
		}
		</script> 
        
        
        
<?php } ?>       
        
        
        
 

      <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
    
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); 




  $settings = array(
  
  "title" => __("SEO Plugins","premiumpress"), 
  "desc" => __("Here are some of our recommended SEO plugins.","premiumpress"),
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
  
   
<div class="card card-admin">
  <div class="card-body">
  
  
  
 <div class="col-12 border-bottom py-3 px-0">
  <div class="row">
    <div class="col-md-8">
      <label>Yoast SEO Plugin</label>
      <p class="pb-0 btn-block text-muted mb-0 mt-2">Since 2008, Yoast SEO has helped millions of websites worldwide to rank higher in search engines.</p>
    </div>
    <div class="col-md-4">
      <div class="input-group mb-2">
      
         <a href="<?php echo home_url(); ?>/wp-admin/plugin-install.php?tab=plugin-information&plugin=wordpress-seo" class="btn btn-admin color2"><?php echo __("Install Plugin","premiumpress"); ?></a>
         
      </div>
    </div>
  </div>
</div>

<div class="text-center text-muted border-bottom py-3">

<strong>note</strong> - you don't need both!

</div>
 
 
 <div class="col-12 border-bottom py-3 px-0">
  <div class="row">
    <div class="col-md-8">
      <label>Rank Math SEO Plugin</label>
      <p class="pb-0 btn-block text-muted mb-0 mt-2">SEO is the most consistent source of traffic for any website.</p>
    </div>
    <div class="col-md-4">
      <div class="input-group mb-2">
      
         <a href="<?php echo home_url(); ?>/wp-admin/plugin-install.php?tab=plugin-information&plugin=seo-by-rank-math" class="btn btn-admin color2"><?php echo __("Install Plugin","premiumpress"); ?></a>
         
      </div>
    </div>
  </div>
</div>  
    
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' );


  $settings = array(
  
  "title" => __("Open Graph Meta Tag","premiumpress"), 
  "desc" => __("Here you can set the default OG meta data for your website.","premiumpress"),
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
   
   
<div class="card card-admin">
  <div class="card-body">
  

    <div class="mb-4">
    <label><?php echo __("Title","premiumpress"); ?></label>
    <input class="form-control" name="admin_values[ogdata][title]" value="<?php echo _ppt(array('ogdata', 'title')); ?>" />
    </div>     
     
    <div class="mb-4">
    <label><?php echo __("Description","premiumpress"); ?></label>
    <input class="form-control" name="admin_values[ogdata][desc]" value="<?php echo _ppt(array('ogdata', 'desc')); ?>" />
    </div>
    
    <div class="mb-4">
    <label class="w-100"><?php echo __("Image","premiumpress"); ?> <span class="badge badge-success">(700px X 700px)</span> </label>
    <input class="form-control" name="admin_values[ogdata][image]" value="<?php echo _ppt(array('ogdata', 'image')); ?>" placeholder="https://.." />
    </div> 
 

      <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
    
  </div>
</div>
<!-- end admin card -->

<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>


 