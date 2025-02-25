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

// PAGE LINKS ARRAY
$innerpagecontent = $CORE->LAYOUT("get_innerpage_blocks", array());

// GET LANGUAGES
$langs = _ppt('languages');
 

$elementorArray = $GLOBALS['elementor_page_templates'];


// GET PAGES
$args = array(
'post_type' 		=> 'page',
'posts_per_page' 	=> 50,
'orderby' 			=> 'date',
'order' 			=> 'desc'
 );
$wp_query = new WP_Query($args);
$tt = $wpdb->get_results($wp_query->request, OBJECT);
 if(!empty($tt)){  
	 $elementorArray["9999"] = "9999";
	 foreach($tt as $p){
	 
	 $title = get_the_title($p->ID);
	 
	 	if(strposa( strtolower($title), array('auto', 'blog', 'stores', 'terms', 'advertising','account','memberships','cart','checkout','about us','how it works','add listing','callback','privacy','testimonials','contact','faq') )) { continue; }
	  
	 	$elementorArray["page-".$p->ID] = $title;
	 
	 }
 
}




function strposa($haystack, $needle, $offset=0) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $query) {
        if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
    }
    return false;
}
 


// PAGE LINKS ARRAY
$pages = $CORE->LAYOUT("get_innerpage_blocks", array());
  
?>


<!-- WORDPRESS FIX ---->
<input type="hidden" name="adminArray[show_on_front]" value="1" />
<input type="hidden" name="adminArray[page_on_front]" value="0" />
<input type="hidden" name="adminArray[page_for_posts]" value="0" />
<!-- WORDPRESS FIX ---->  

<style>
.fade:not(.show) {
    opacity: 0;
    display: none;
}

 
.tabssw.nav-tabs .nav-item {
    margin-bottom: -1px;
    line-height: 50px;
}
.tabssw.nav-tabs .nav-link.active { font-weight:600; }
</style>
  
<div class="">

    <div class="row">
    <div class="col-md-4 pr-lg-4">
    
    
    <h3 class="mt-4"><?php echo __("Customize Pages","premiumpress"); ?></h3>
    
    <p class="text-muted lead"><?php echo __("Here you can customize and modify your website pages.","premiumpress"); ?></p>
    
   <a href="https://www.youtube.com/watch?v=m8Hx7Zr7DNQ" class="btn btn-danger shadow-sm btn-sm px-3 popup-yt"><i class="fa fa-video mr-1"></i> <?php echo __("watch video","premiumpress"); ?></a>
    
    
    
	<?php if(defined('ELEMENTOR_VERSION')){ ?> 
    
   
  
  <?php }else{ ?>
     <hr />
   
    <a href="admin.php?page=plugins" class="btn shadow-sm btn-system bg-warning text-light mt-4 btn-md"><i class="fab fa-elementor"></i> <?php echo __("Install Elementor","premiumpress"); ?></a>
    <?php } ?>
   
    </div>
    <div class="col-md-8">
   
   <div class="card card-admin">
  <div class="card-body">
  
  
   
  <ul class="nav nav-tabs tabssw nav-fill mb-4 bg-light" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" data-targetdiv="pagelinking">Desktop</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" data-targetdiv="pagelinking">Mobile</a>
  </li>
  
</ul>
<div id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  
 

  
  
  
<?php
   


// ADDON HOMEPAGE
$innerpagecontent['homepage'] = array( "name" => "Homepage", "link" => "", "order" => 1);

   
foreach($CORE->multisort($innerpagecontent, array('order'))  as $k => $p){ 

	// KEY
	$corekey = str_replace("page_","",$k);
	$p['id'] = $corekey;
	
	if($p['id'] == "listingpage"){	
		$p['name'] = str_replace("%s", $CORE->LAYOUT("captions","1"),"%s Page")."<br><span class='small'><a href='admin.php?page=design&lefttab=single'>use settings here</a><span>";	
	 }
	 
?>
<div class="container border-bottom py-3">
  <div class="row px-0">
    <div class="col-md-6">
      <h6 class="mb-0"><?php echo $p['name']; ?></h6>
     
     <?php if(is_array($langs) && !empty($langs) && count($langs) > 1   ){  ?>
      <a href="javascript:void(0);" onclick="jQuery('.showtranslations<?php echo $p['id']; ?>').toggle();" 
                class="mt-3 btn btn-sm btn-system"><i class="fa fa-language"></i> <?php echo __("Show translations","premiumpress"); ?> </a> 
       
       <?php } ?>  
       
       
      
                </div>
    <div class="col-md-6">
    
    <?php if(isset($p['noedit']) ){ ?>
    <h6>This page cannot be edited</h6>
    <div class="tiny">This page contains core theme code and cannot be edited just yet. We hope to add more options soon.</div>
    
    <?php }else{ ?> 
	
	
	
    
    
      <select data-placeholder="Default Page" name="admin_values[pageassign][<?php echo $p['id']; ?>]"  <?php if(is_array($elementorArray) && count($elementorArray) > 30  ){ ?> data-size="10" class="form-control selectpicker"  data-live-search="true" title="&nbsp;"<?php }else{ ?>class="form-control"  <?php } ?> >
       <option value="0" style="color:#999999;"><?php echo __("Default Design","premiumpress"); ?></option>
        <optgroup label="Elementor Templates"></optgroup>
        <?php 
				  if(is_array($elementorArray)){
				  
				  foreach ( $elementorArray as $key => $title ) {  
				  
				      if($title == "Default Kit"){ continue; }  
               
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
                    
                     <?php if($p['id'] == "homepage"){ ?>
                     
                     
                    <a href="<?php echo home_url(); ?>" target="_blank" class=" btn btn-system btn-md btn-block"><?php echo __("View","premiumpress"); ?></a>
                    
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
                           
                          
                          <?php }elseif($p['id'] == "homepage" && _ppt(array('design','slot1_style')) == "" && _ppt(array('design','slot2_style')) == ""){ // NO HOMEPAGE SET ?>
                           
                          
                            <a href="javascript:void(0);" onclick="jQuery('#editcontent_<?php echo $p['id']; ?>').toggle();" class="btn btn-system btn-md btn-block"> <?php echo __("Edit","premiumpress"); ?></a>
                          	
                            <div class="tiny mt-2 text-center">no design set</div>
                         
                          <?php }else{ ?> 
                          
                           
                          <a href="<?php echo home_url(); ?>/wp-admin/<?php if($p['id'] == "homepage"){ ?>admin.php?page=design&loadpage=home<?php }else{ ?>admin.php?page=design&loadpage=new&inner=<?php echo $p['id']; ?><?php } ?>" class="btn btn-system btn-md btn-block" target="_blank" ><i class="fab fa-elementor"></i> <?php echo __("Edit","premiumpress"); ?></a>
                          
                          <?php } ?>
                      
                      <?php }else{ ?>
                      
                       <a href="javascript:void(0);" onclick="jQuery('#editcontent_<?php echo $p['id']; ?>').toggle();" class="btn btn-system btn-md btn-block"> <?php echo __("Edit","premiumpress"); ?></a>
                      
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
					  
					  if($title == "Default Kit"){ continue; }    
               
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
     
      <?php } ?>
    </div>    
  </div>
</div>

<?php /************************* HOMEPAGE CONTENT **********************************************/ ?>
<?php if($p['id'] == "homepage"){ ?>
<div  id="editcontent_<?php echo $p['id']; ?>" style="display:none;"> 


<?php foreach( $CORE->LAYOUT("get_slots",array(1,2,3,4,5,6,7,8,9)) as $s){  ?>

<div class="text-center   position-relative py-3" style="border:5px dashed #f1f1f1;">
  <?php  if( _ppt(array('pageassign','homepage')) != ""){ ?>
  <?php if(strlen(_ppt(array('design',$s['id']))) > 1){ ?><div class="overlay-inner"></div><?php } ?>
  <?php } ?>
  <?php if(strlen(_ppt(array('design',$s['id']))) > 1){ ?>
  <div class="bg-inner"></div>
  <img src="<?php echo $CORE->LAYOUT("get_block_prewview", _ppt(array('design',$s['id'])) ); ?>" class="img-fluid "  /> <a href="<?php echo home_url(); ?>/?ppt_live_preview=1&amp;livedata=1&amp;tid=<?php echo $CORE->LAYOUT("get_block_category", _ppt(array('design',$s['id'])) ); ?>&amp;sid=<?php echo _ppt(array('design',$s['id'])); ?>" target="_blank" style="position:absolute; bottom:0; right:0;" class="bg-content bg-light small p-2 text-dark text-uppercase"> <?php echo __("preview","premiumpress"); ?>  </a>
  <?php }else{ ?>
  <div style="height:180px;">&nbsp;
    <div class="p-3" style="font-size:50px; color: #efefef;    font-weight: bold;"><?php echo $s['name']; ?></div>
  </div>
  <?php } ?>
</div>
<div class="p-lg-4 p-2 bg-light text-center my-4">
  <?php if(strlen(_ppt(array('design',$s['id']))) ==""){ ?>
  <div class="col-md-6 mx-auto">
    <button class="btn btn-system shadow-sm loaddatabox btn-block btn-md" type="button" data-id="<?php echo $s['id']; ?>" data-pagekey="home"> <i class="fa fa-tools"></i> <?php echo __("Select Design","premiumpress"); ?> </button>
  </div>
  <?php }else{ ?>
  <div class="row ">
    <div class="col-md-4">
      <?php if(strlen(_ppt(array('design',$s['id']))) !=""){ ?>
      <button data-settingid="<?php echo _ppt(array('design',$s['id'])); ?>" data-pagekey="home"
        class="loadsettingsbox btn btn-system shadow-sm btn-block btn-md" type="button"><i class="fa fa-cog"></i> <?php echo __("Settings","premiumpress"); ?></button>
      <?php } ?>
    </div>
    <div class="col-md-4">
      <button class="btn btn-system shadow-sm loaddatabox btn-block btn-md" type="button" data-id="<?php echo $s['id']; ?>" data-pagekey="home">
      <?php if(strlen(_ppt(array('design',$s['id']))) ==""){ ?>
      <i class="fa fa-tools"></i> <?php echo __("Select Design","premiumpress"); ?>
      <?php }else{ ?>
      <i class="fa fa-sync"></i> <?php echo __("Change","premiumpress"); ?>
      <?php } ?>
      </button>
    </div>
    <div class="col-md-4">
      <?php if(strlen(_ppt(array('design',$s['id']))) !=""){ ?>
      <button  class="btn btn-system shadow-sm btn-block btn-md" type="button" onClick="DeleteSetDesign('<?php echo $s['id']; ?>');"><i class="fa fa-trash"></i> <?php echo __("Delete","premiumpress"); ?></button>
      <?php } ?>
    </div>
  </div>
  <?php } ?>
</div>
<input type="hidden" name="admin_values[design][<?php echo $s['id']; ?>]" id="<?php echo $s['id']; ?>" value="<?php echo _ppt(array('design',$s['id'])); ?>" />
<?php } ?>



</div>
<?php } ?>

 <?php /************************* INNER CONTENT **********************************************/ ?>

<?php if(isset($p['blocks'])){ ?>
<div  id="editcontent_<?php echo $p['id']; ?>" style="display:none;"> 
<?php  foreach(  $p['blocks'] as $s){   ?>
      <div class="text-center  position-relative py-3" style="border:5px dashed #f1f1f1;">
        <div class="bg-inner"></div>
        <img src="<?php echo $CORE->LAYOUT("get_block_prewview", $s); ?>" class="img-fluid" alt=""  />
        
       
        <a href="<?php echo home_url(); ?>/?ppt_live_preview=1&amp;livedata=1&amp;tid=<?php echo $CORE->LAYOUT("get_block_category", $s ); ?>&amp;sid=<?php echo $s; ?>&innerpageid=<?php echo $p['id']; ?>" target="_blank" style="position:absolute; bottom:0; right:0;" class="bg-content bg-light small p-2 text-dark text-uppercase"> preview </a>
        
        
        <div class="position-absolute" style="top:0; right:0;z-index:10;">
          <div class="p-3"><strong><?php echo $s; ?></strong></div>
        </div>
      </div>
      <div class="my-3 p-4 bg-light text-center mt-4">
        <button data-pagekey="<?php echo $k; ?>" data-settingid="<?php echo $s; ?>" data-pagekey="innerpage" 
        class="loadsettingsbox btn btn-system shadow-sm btn-md" type="button">
        <i class="fa fa-tools"></i> <?php echo __("Configure","premiumpress"); ?>
        </button>
      </div>
      
<?php } ?>
</div>
<?php } ?>        
      
<?php /***********************************************************************/ ?>
            

<?php } ?>











  
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
  
  

<div class="bg-light border p-4"><?php echo __("Here you can set your own custom design that is displayed only on mobile devices. Leave blank to use the desktop design.","premiumpress"); ?></div>

<hr />


<?php
   


// ADDON HOMEPAGE
//$innerpagecontent['homepage'] = array( "name" => "Homepage", "link" => "", "order" => 1);
   
foreach($CORE->multisort($innerpagecontent, array('order'))  as $k => $p){ 

if(isset($p['noedit'])){ continue; }
	
	// KEY
	$corekey = str_replace("page_","",$k);
	$p['id'] = $corekey;
	
	if($p['id'] == "listingpage"){	
		$p['name'] = str_replace("%s", $CORE->LAYOUT("captions","1"),"%s Page")."<br><span class='small'><a href='admin.php?page=design&lefttab=single'>use settings here</a><span>";	
	 }

?>
<div class="container border-bottom py-3">
  <div class="row px-0">
    <div class="col-md-6">
      <h6 class="mb-0"><?php echo $p['name']; ?> <small>(Mobile)</small> </h6>
     
     <?php if(is_array($langs) && !empty($langs) && count($langs) > 1   ){  ?>
      <a href="javascript:void(0);" onclick="jQuery('.showtranslations<?php echo $p['id']; ?>_mobile').toggle();" 
                class="mt-3 btn btn-sm btn-system"><i class="fa fa-language"></i> <?php echo __("Show translations","premiumpress"); ?> </a> 
       
       <?php } ?>  
       
       
      
                </div>
    <div class="col-md-6">
    
   
    
      <select data-placeholder="Default Page" name="admin_values[pageassign][<?php echo $p['id']; ?>_mobile]"  <?php if(is_array($elementorArray) && count($elementorArray) > 30  ){ ?> data-size="10" class="form-control selectpicker"  data-live-search="true" title="&nbsp;"<?php }else{ ?>class="form-control"  <?php } ?> >
         <option value="0" style="color:#999999;"><?php echo __("Desktop Design","premiumpress"); ?></option>
        <optgroup label="Elementor Templates"></optgroup>
        <?php 
				  if(is_array($elementorArray)){
				  
				  foreach ( $elementorArray as $key => $title ) {  
				   if($title == "Default Kit"){ continue; }  
				     
               
			    if($key == "9999"){ ?>
        <optgroup label="Page Templates"></optgroup>
        <?php continue; }
				               
               $option = '<option value="'. $key.'"';
               if( _ppt(array('pageassign', $p['id']."_mobile" )) == $key){ $option .= " selected=selected ";   } 
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
                    
                     <?php if($p['id'] == "homepage"){ ?>
                     
                     
                    <a href="<?php echo home_url(); ?>/?mobile_view=1" target="_blank" class=" btn btn-system btn-md btn-block"><?php echo __("View","premiumpress"); ?></a>
                    
                      <?php }elseif(strlen(_ppt(array('links', $p['id']))) > 0 && strlen(_ppt(array('pageassign',$p['id']."_mobile"))) > 1 ){  ?>
                      
                      <a href="<?php echo _ppt(array('links', $p['id'])); ?>?mobile_view=1" target="_blank" class=" btn btn-system btn-md btn-block"><?php echo __("View","premiumpress"); ?></a>
                      <?php } ?>
                      
                    </div>
                    <div class="col-xl-6">
                    
                      <?php if(defined('ELEMENTOR_VERSION')){ ?>
                      
                      
						  <?php if(substr(_ppt(array('pageassign',$p['id']."_mobile")), 0, 9) == "elementor" ){  ?>
                          
                          <a href="<?php echo home_url(); ?>/wp-admin/post.php?post=<?php echo str_replace("elementor-","",_ppt(array('pageassign',$p['id']."_mobile"))); ?>&action=elementor" 
                          class="btn btn-system btn-md btn-block" target="_blank" ><i class="fab fa-elementor"></i> <?php echo __("Edit","premiumpress"); ?></a>
                          
                          
                          
                           <?php }elseif(substr(_ppt(array('pageassign',$p['id']."_mobile")), 0, 5) == "page-" ){  ?>
                           
                          
                         
                          <a href="<?php echo home_url(); ?>/wp-admin/post.php?post=<?php echo str_replace("page-","",_ppt(array('pageassign',$p['id']."_mobile"))); ?>&action=edit" 
                          class="btn btn-system btn-md btn-block" target="_blank" ><i class="fab fa-wordpress"></i> <?php echo __("Edit","premiumpress"); ?></a>
                           
                          
                          <?php }elseif($p['id']."_mobile" == "homepage" && _ppt(array('design','slot1_style')) == "" && _ppt(array('design','slot2_style')) == ""){ // NO HOMEPAGE SET ?>
                           
                         
                         
                          <?php }else{ ?> 
                          
                           
                          <a href="<?php echo home_url(); ?>/wp-admin/<?php if($p['id'] == "homepage"){ ?>admin.php?page=design&loadpage=home&mobile=1<?php }else{ ?>admin.php?page=design&loadpage=new&mobile=1&inner=<?php echo $p['id']; ?><?php } ?>" class="btn btn-system btn-md btn-block" target="_blank" ><i class="fab fa-elementor"></i> <?php echo __("Edit","premiumpress"); ?></a>
                          
                          <?php } ?>
                      
                    
                     
                      <?php } ?>
                      
                      
                           </div>
                  </div>
                </div> 
                      
                         <?php /***********************************************************************/ ?>
                 
                 
				 <?php if(is_array($langs) && !empty($langs) && count($langs) > 1 ){ ?>
                
                <div id="" class="p-3 py-2 bg-light mt-3 showtranslations<?php echo $p['id']."_mobile"; ?>" style="display:none;">
                  <?php foreach(_ppt('languages') as $lang){
			
					$icon = explode("_",$lang); 
			
					if(_ppt(array('lang','default')) == "en_US" && isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
				
				?>
                  <div class="mt-3">
                    <div class="mb-2 small">
                      <div class="flag flag-<?php if(isset($icon[1])){ echo strtolower($icon[1]); }else{ echo $icon[0]; } ?> mr-2">&nbsp;</div>
                      <?php echo $CORE->GEO("get_lang_name", $lang); ?> <?php echo $p['name']; ?> </div>
                    <select data-placeholder="Default Page" name="admin_values[pageassign][<?php echo $p['id']."_mobile"; ?>_<?php echo strtolower($lang); ?>]" <?php if(is_array($elementorArray) && count($elementorArray) > 50  ){ ?> data-size="10" class="form-control selectpicker"  data-live-search="true" title="&nbsp;"<?php }else{ ?>class="form-control"  <?php } ?>>
                      <option></option>
                      <option value=""><?php echo __("Desktop Design","premiumpress"); ?></option>
                      <?php foreach ( $elementorArray as $key => $title ) {
					  
					   if($title == "Default Kit"){ continue; }        
               
               $option = '<option value="'. $key.'"';
               if( _ppt(array('pageassign', $p['id']."_mobile"."_".strtolower($lang))) == $key){ $option .= " selected=selected "; $EditLink = substr($key,10,100); } 
               $option .= '>';
               $option .= $title;
               $option .= '</option>';
               echo $option; 
                } ?>
                    </select>
                  </div>
                  <div class="div mt-3">
                    <?php if(_ppt(array('pageassign',$p['id']."_mobile"."_".strtolower($lang))) != "" && isset($EditLink)){  ?>
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










  
  
  </div>
 
</div>


















<div class="p-4 bg-light text-center mt-4">
            <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
          </div>

  </div>
</div>
 
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>





<div class="container px-0">
  <div class="row">
    <div class="col-md-4 pr-lg-4">
      <h3 class="mt-4"><?php echo __("Website Layout","premiumpress"); ?></h3>
      <p class="text-muted lead mb-4"><?php echo __("Select the website layout for your main content and inner pages.","premiumpress"); ?></p>
    </div>
    <div class="col-md-8">
      <div class="card card-admin">
        <div class="card-body">
          <?php $ha2 = array(
	  
         0 => array("id" => "1", "name" => "Boxed Layout", "icon" => "boxed.png" ),       
	     1 => array("id" => "1a", "name" => "Boxed + Shadow", "icon" => "boxed.png" ),
		 2 => array("id" => "1b", "name" => "Boxed + Border", "icon" => "boxed.png" ),
		 
         
		 3 => array("id" => "2", "name" => "Default", "icon" => "fluid.png"),
        
		
		// 2 => array("id" => "2", "name" => "Container Layout", "icon" => "fluid.png"),
		// 3 => array("id" => "2a", "name" => "Container + shadow", "icon" => "fluid.png"),
		 
		 
        
		// 5 => array("id" => "4", "name" => "Slim Layout", "icon" => "boxed.png" ),
         //6 => array("id" => "4a", "name" => "Slim + shadow", "icon" => "boxed.png" ),
       
		
		 
         ); ?>
          <style>
         #page_layout .shadow { border:2px solid #76bd70 !important;     box-shadow: none !important; }
      </style>
          <div class="row" id="page_layout">
            <?php foreach($ha2 as $key => $h){ ?>
            <div class="col-3 text-center">
              <div class="py-4"> <img data-src="<?php echo get_template_directory_uri(); ?>/framework/admin/images/<?php echo $h['icon']; ?>" style="cursor:pointer;" class="border lazy mb-1 img-fluid <?php 
			   
			   if(_ppt(array('design','boxed_layout')) == $h['id']){ echo "shadow"; } ?>" onclick="jQuery('#page_layout img').removeClass('shadow');jQuery(this).addClass('shadow');jQuery('#p_layout').val('<?php echo $h['id']; ?>');" /> <small class="text-muted text-uppercase" style="font-size:11px;"><?php echo $h['name']; ?></small> </div>
            </div>
            <?php } ?>
            <input 
            name="admin_values[design][boxed_layout]" 
            type="hidden" 
            id="p_layout" 
            value="<?php if(_ppt(array('design','boxed_layout')) != "" && strlen( _ppt(array('design','boxed_layout')) ) < 5 ){  echo _ppt(array('design','boxed_layout')); }else{ echo 3; } ?>" />
          </div>
          
          
          
          
          

          <div class="row border-bottom border-top pb-3 pt-4 mb-3">
            <div class="col-md-8 ">
              <label class="font-weight-bold mb-2"><?php echo __("Website Preloader","premiumpress"); ?></label>
              <p class="text-muted"><?php echo __("Disable this to stop the spinning wheel when the page loads.","premiumpress"); ?></p>
            </div>
            <div class="col-md-2 mt-3 formrow">
              <div class="">
                <label class="radio off">
        <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('enable_preloader').value='0'">
        </label>
        <label class="radio on">
        <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('enable_preloader').value='1'">
        </label>
        <div class="toggle <?php  if(in_array(_ppt(array('design','preloader')), array("","1"))){  ?>on<?php } ?>">
          <div class="yes">ON</div>
          <div class="switch"></div>
          <div class="no">OFF</div>
        </div>
      </div>
      <input type="hidden" id="enable_preloader" name="admin_values[design][preloader]" value="<?php if(in_array(_ppt(array('design','preloader')), array("","1"))){ echo 1; }else{ echo 0; } ?>">
            </div>
          </div>    
          
          
          
          
          
          
          
          <div class="p-4 bg-light text-center mt-4">
            <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
