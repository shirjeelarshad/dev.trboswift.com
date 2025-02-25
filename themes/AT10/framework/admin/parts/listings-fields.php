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
   
   global $wpdb, $CORE, $settings;
  
   
	// GET LANGUAGES
	$langs = _ppt('languages');

   // GET FIELDS
   $cfields = get_option("cfields");  
   
     
   // GET LIST OF CATEGORIES FOR SELECTION
   $categorylist = $CORE->CategoryList(array(0,false,0,THEME_TAXONOMY,0,0,true));
   $categorylistarray = get_terms(THEME_TAXONOMY,"orderby=count&order=desc&get=all");
   $new_categorylistarray = array();
   foreach($categorylistarray as $cad){
   $new_categorylistarray[$cad->term_id] = $cad;
   }

   
      
   ?>


    <div class="tabheader "> 
    
    <?php if(!isset($_GET['reinstalldefaults'])){ ?>
    <a href="javascript:void(0);" onClick="jQuery('#customfieldlist li').hide();jQuery('#customfieldlist_new').clone().appendTo('#customfieldlist');addUpdateFieldKey();jQuery(this).hide();" class="btn btn-system float-right shadow-sm"><i class="fal fa-plus"></i> <?php echo __("Add Field","premiumpress"); ?></a>
   
   
    <?php } ?>
      <h6><span><?php echo __("Custom Fields","premiumpress"); ?></span></h6>
      <p class="text-muted"><?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions","1")),__("Create your own %s fields.","premiumpress"));  ?> </p>
      
    </div>
    <div><span id="catlistboxright">&nbsp;</span></div>
    <div class="clear"></div>
    <div  class=" meta-box-sortables ui-sortable">
      <ul id="customfieldlist">
        <?php
                  if(is_array($cfields) && !empty($cfields) ){ $i=0; $setKeys = array(); $selectedcatlist = array();
                  
                  foreach($cfields['name'] as $data){ 
                  
                  	if($cfields['dbkey'][$i] !="" && $cfields['name'][$i] != "" ){ 
                  	
                  	// ADJUST KEY IF IS DUPLICATE
                  	if(in_array($cfields['dbkey'][$i], $setKeys) ){  $cfields['dbkey'][$i] = $cfields['dbkey'][$i]."".$i; }
                  	
                  	// ADD TO ALREADY DONE LIST
                  	$setKeys[] = $cfields['dbkey'][$i];	
                  	
                  	// WORK OUT CATEGORY LIST
                  	$displaycategorylist = $categorylist;
                  	$cat_class_list = ""; $dname = "";
                  	if(isset($cfields['cat'][$i]) && is_array($cfields['cat'][$i])){
                  		foreach($cfields['cat'][$i] as $c){
                  			$selectedcatlist[] = $c;
                  			$displaycategorylist = str_replace('"'.$c.'"', '"'.$c.'" selected=selected', $displaycategorylist);
                  			$cat_class_list .= " catid-".$c;
                  			//$dname .= $new_categorylistarray[$c]->name." ";
                  		}
                  	}
                  	
                  	
                  	?>
        <li class="closed <?php echo $cat_class_list; ?>" id="field<?php echo $i; ?>">
          <div class="cfielditem">
            <div class="heading">
              <div class="showhide"> <a href="javascript:void(0);" onclick="addUpdateFieldKey();jQuery('.cf-<?php echo $i; ?>').toggle();" rel="tooltip" data-original-title="Show/Hide Options" data-placement="top" class="btn btn-primary btn-sm"> <i class="fa fa-search ml-0" aria-hidden="true"></i> </a> </div>
              <div class="name"> <a href="javascript:void(0);" onClick="addUpdateFieldKey();jQuery('#dbkey-<?php echo $i; ?>').val('');jQuery('#field<?php echo $i; ?>').html('');" rel="tooltip" data-original-title="Delete" data-placement="top" class="btn <?php if(isset($cfields['fieldtype'][$i]) && $cfields['fieldtype'][$i] == "title"){ ?>btn-success<?php }else{ ?>btn-danger<?php } ?> btn-sm"> <i class="fas fa-times ml-0" aria-hidden="true"></i> </a> &nbsp; <strong><?php echo $cfields['name'][$i]; ?></strong> <small> <?php echo $cfields['dbkey'][$i]; ?></small> </div>
            </div>
            <div class="inside cf-<?php echo $i; ?>">
              <div class="row">
              
                <div class="col-md-6">
                 
                 
                  <label><?php echo __("Display Text","premiumpress"); ?> <span class="required">*</span></label>
                  <input type="text" name="cfield[name][]" id="ftitle-<?php echo $i; ?>" value="<?php echo $cfields['name'][$i]; ?>" class="form-control"  />
               
                
                
               <?php /***********************************************************************/ ?>
                 
                 
				 <?php if(is_array($langs) && !empty($langs) && count($langs) > 1 ){ ?>
                
                
                  <?php foreach(_ppt('languages') as $lang){
			
					$icon = explode("_",$lang); 
			
					if(_ppt(array('lang','default')) == "en_US" && isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
				
				?>
                  <div class="mt-3">
                    <div class="mb-2 small">
                    
                      <div class="flag flag-<?php if(isset($icon[1])){ echo strtolower($icon[1]); }else{ echo $icon[0]; } ?> mr-2">&nbsp;</div>
                      
                      <?php echo $CORE->GEO("get_lang_name", $lang); ?> </div>
                      
                      
                       <input type="text" name="cfield[name_<?php echo strtolower($lang); ?>][]"  value="<?php if(isset($cfields['name_'.strtolower($lang)][$i])){ echo $cfields['name_'.strtolower($lang)][$i]; } ?>" class="form-control">       
                      
                       
                  </div>
                  
                  <?php } ?>
                  
                  
                 
                <?php } ?>
               
                   <?php /***********************************************************************/ ?>
                   
                   <div class="helpbox">
                   <label class="mt-4"><?php echo __("Help Text/ Description","premiumpress"); ?></label>
                  <p class="text-muted"><?php echo __("This is displayed under the field.","premiumpress"); ?></p>
                  <input type="text"  name="cfield[help][]" class="form-control stopclean" value="<?php if(isset($cfields['help'][$i])){ echo stripslashes($cfields['help'][$i]); } ?>">
               
               
               
               
               				 <?php if(is_array($langs) && !empty($langs) && count($langs) > 1 ){ ?>
                
                
                  <?php foreach(_ppt('languages') as $lang){
			
					$icon = explode("_",$lang); 
			
					if(_ppt(array('lang','default')) == "en_US" && isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
				
				?>
                  <div class="mt-3">
                    <div class="mb-2 small">
                    
                      <div class="flag flag-<?php if(isset($icon[1])){ echo strtolower($icon[1]); }else{ echo $icon[0]; } ?> mr-2">&nbsp;</div>
                      
                      <?php echo $CORE->GEO("get_lang_name", $lang); ?> </div>
                      
                      
                       <input type="text" name="cfield[help_<?php echo strtolower($lang); ?>][]"  value="<?php if(isset($cfields['help_'.strtolower($lang)][$i])){ echo $cfields['help_'.strtolower($lang)][$i]; } ?>" class="form-control">       
                      
                       
                  </div>
                  
                  <?php } ?>
                  
                  
                 
                <?php } ?>
               
               
               
                </div>
                   
                
               </div>
              
                <div class="col-md-6">
                  <label><?php echo __("Display Category","premiumpress"); ?> <span class="required">*</span></label>
                 
                  <div class="clearfix">
                 
                  
                    <select name="cfield[cat][<?php echo $i; ?>][]" multiple="multiple" style="height:300px !important; width:100%; overflow:scroll; padding:10px !important" class="form-control customfield-cat">
                      <option value="0" <?php if(!isset($cfields['cat'][$i][0]) || ( isset($cfields['cat'][$i][0]) && in_array($cfields['cat'][$i][0], array("","0")))){ echo "selected=selected"; } ?>><?php echo __("Display For All Categories","premiumpress"); ?></option>
                      <?php echo $displaycategorylist; ?>
                    </select>
                  </div>
                   <p class="text-muted mt-2"><?php echo __("Here you can choose which listing assigned to which cateogies should display this field.","premiumpress"); ?></p>
                </div>
                
              </div>
 
              
                <div class="col-md-12 mb-3">
                  
                <hr />
                </div>
             
              <div class="row mt-3">
              
                <div class="col-md-6">
                  <label class="bold"><?php echo __("Field Type","premiumpress"); ?><span class="required">*</span></label>
                  <p class="text-muted">Select the type of field to display to the user.</p>
               
                  <select name="cfield[fieldtype][]" class="field_type form-control"   onchange="showhideextrafield('field<?php echo $i; ?>')">
                    <option value="input" <?php  if(isset($cfields['fieldtype'][$i]) && $cfields['fieldtype'][$i] == "input"){echo "selected=selected"; } ?>>Input Field</option>
                    <option value="textarea" <?php  if(isset($cfields['fieldtype'][$i]) && $cfields['fieldtype'][$i] == "textarea"){echo "selected=selected"; } ?>>Text Area</option>
                    <option value="checkbox" <?php  if(isset($cfields['fieldtype'][$i]) && $cfields['fieldtype'][$i] == "checkbox"){echo "selected=selected"; } ?>>Checkbox</option>
                    <option value="radio" <?php  if(isset($cfields['fieldtype'][$i]) && $cfields['fieldtype'][$i] == "radio"){echo "selected=selected"; } ?>>Radio Button</option>
                    <option value="select" <?php  if(isset($cfields['fieldtype'][$i]) && $cfields['fieldtype'][$i] == "select"){echo "selected=selected"; } ?>>Selection</option>
                   <option value="taxonomy" <?php  if(isset($cfields['fieldtype'][$i]) && $cfields['fieldtype'][$i] == "taxonomy"){echo "selected=selected"; } ?>>Taxonomy</option>
                    <option value="date" <?php  if(isset($cfields['fieldtype'][$i]) && $cfields['fieldtype'][$i] == "date"){echo "selected=selected"; } ?>>Date</option>
                    
                    
                    <option value="title" <?php  if(isset($cfields['fieldtype'][$i]) && $cfields['fieldtype'][$i] == "title"){echo "selected=selected"; } ?>>Display Caption (Title Only)</option>
                  </select>
                </div>
                
                 <div class="col-md-6">
                  <label><?php echo __("Database Key","premiumpress"); ?> <span class="required">*</span></label>
                  
                   <p class="text-muted"><?php echo __("Refernce only. Only change if necessary.","premiumpress"); ?></p>
                  <input type="text"  name="cfield[dbkey][]" id="dbkey-<?php echo $i; ?>"  onchange="removeWhitespace('dbkey-<?php echo $i; ?>');" class="form-control bg-light" value="<?php echo $cfields['dbkey'][$i]; ?>">
                </div>
                
                
                
              </div>
              <div class="extra_values" style="display:none">
                <label class="mt-3"><?php echo __("Field Values","premiumpress"); ?> <span class="required">*</span></label>
                <textarea class="form-control stopclean"  name="cfield[values][]" placeholder="One value per line" style="border:1px solid orange;height:100px !important;"><?php if(isset($cfields['values'][$i])){ echo stripslashes($cfields['values'][$i]); } ?>
</textarea>
              </div>
              <div class="tax_values" style="display:none">
                <div class="row mt-3">
                  <div class="col-md-6">
                    <label class="mt-1"><?php echo __("Taxonomy","premiumpress"); ?> <span class="required">*</span></label>
                    <select name="cfield[taxonomy][]" class="form-control">
                      <?php
                                    $select_tax = "";
                                    if(isset($cfields['taxonomy'][$i])){
                                    $select_tax = $cfields['taxonomy'][$i];
                                    }
                                    
                                    $taxs = get_taxonomies();
                                    $not_wanted = array('nav_menu','post_tag','post_format');
                                                      foreach ($taxs as $tax) {
                                    	if(in_array($tax,$not_wanted)){ continue; }
                                    	if($tax == "category"){ $display_text = "Blog Category"; }elseif($tax == "listing"){ $display_text = "Listing Categories"; }else{ $display_text = $tax; }
                                    	
                                                          printf( '<option value="%1$s"%2$s>%3$s</option>', $tax, selected( $select_tax , $tax, false ), $display_text );
                                                      }
                                     
                                                      ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                  <?php /*
                    <label class="mt-1"><?php echo __("Linked With","premiumpress"); ?>: <span class="required">*</span></label>
                    <select name="cfield[taxonomy_link][]" class="form-control">
                      <option value="0"><?php echo __("Not Linked","premiumpress"); ?></option>
                      <?php
                                       $select_tax = "";
                                       if(isset($cfields['taxonomy_link'][$i])){
                                       $select_tax = $cfields['taxonomy_link'][$i];
                                       }
                                       
                                       $taxs = get_taxonomies();
                                       $not_wanted = array('nav_menu','post_tag','post_format');
                                                        foreach ($taxs as $tax) {
                                       if(in_array($tax,$not_wanted)){ continue; }
                                       if($tax == "category"){ $display_text = "Blog Category"; }elseif($tax == "listing"){ $display_text = "Listing Categories"; }else{ $display_text = $tax; }
                                       
                                                            printf( '<option value="%1$s"%2$s>%3$s</option>', $tax, selected( $select_tax , $tax, false ), $display_text );
                                                        }
                                                        ?>
                    </select>
					*/ ?>
                  </div>
                </div>
                <!-- end row -->

                
                
                
              </div>
              <!-- end well -->
              <script> jQuery(document).ready(function() { showhideextrafield('field<?php echo $i; ?>'); }); </script>
              <div class="clear"></div>
              
              
                              <hr />
                <div class="extrafields">
                  <label class="checkbox">
                
                
                  <input type="checkbox" onchange="ChangeTickValue1(<?php echo $i; ?>);" <?php if(isset($cfields['required'][$i]) && $cfields['required'][$i] == "yes"){echo "checked=checked"; } ?>>
                  <b><?php echo __("Required Field","premiumpress"); ?></b> - <small> <?php echo __("The user will be prompted to select/enter a value.","premiumpress"); ?></small> </label>
                  
                  
                  <input type="hidden" name="cfield[required][]" class="checkvalue<?php echo $i; ?>" value="<?php if(isset($cfields['required'][$i]) && $cfields['required'][$i] == "yes"){echo "yes"; }else{ echo "no";}?>" />
                
                
                
                  <label class="checkbox mt-4">
                
                
                  <input type="checkbox" onchange="ChangeTickValue2(<?php echo $i; ?>);" <?php if(isset($cfields['editonly'][$i]) && $cfields['editonly'][$i] == "yes"){echo "checked=checked"; } ?>>
                  <b><?php echo __("Edit Only","premiumpress"); ?></b> - <small> <?php echo __("This field will not be visible on their listing page.","premiumpress"); ?></small> </label>
                  
                  
                  <input type="hidden" name="cfield[editonly][]" class="checkvalue2<?php echo $i; ?>" value="<?php if(isset($cfields['editonly'][$i]) && $cfields['editonly'][$i] == "yes"){echo "yes"; }else{ echo "no";}?>" />
                
                
                
                </div>
                <!-- end extra field -->
              
              
              
              
              
              
            </div>
            
            
            
            
            
            
            
          </div>
        </li>
        <?php }  $i++; } }else{ ?>
        <div class="p-4 bg-light text-center txt500"><?php echo __("No Fields Created","premiumpress"); ?></div>
        <?php } ?>
      </ul>
    </div>
    <?php if(!empty($selectedcatlist)){ ?>
    <hr />
    <div id="filterbycatbox" class="px-0">
      <select onchange="FilterByCategory(this.value);" class="form-control mb-4">
        <option value="0"><?php echo __("Show All Categories","premiumpress"); ?></option>
        <?php 
                  foreach(array_unique($selectedcatlist) as $ck){
                  
                  	foreach($categorylistarray as $cad){
                  	
                  		if($ck == $cad->term_id){
                  		?>
        <option value="catid-<?php echo $cad->term_id; ?>"><?php echo $cad->name; ?></option>
        <?php
                  }	
                  }
                  }
                  ?>
      </select>
    </div>
    <?php } ?>
    <script>


function resetcatfieldids(){

	i = 0;
	jQuery('.customfield-cat').each(function(i, obj) {
			 
		//catfieldid = jQuery(obj).attr('name');	 	 
		//console.log(catfieldid);	
		jQuery(obj).attr('name', 'cfield[cat]['+i+'][]');	   
		i++;
	});	

}

function addUpdateFieldKey(){

	// ADD NEW
   jQuery('<input>').attr({
	   type: 'hidden',            			
	   name: 'updatefields',
	   value: 1,
   }).appendTo('#customfieldlist');
}

jQuery(document).ready(function() {	

	// reload cat ids
	resetcatfieldids();

	jQuery( "#customfieldlist" ).sortable({
                   revert       : true,
                   connectWith  : ".sortable",
                   stop         : function(event,ui){ 	
				   
				   
				   
				   jQuery('<input>').attr({
                        			type: 'hidden',            			
                        			name: 'updatefields',
                        			value: 1,
                        		}).appendTo('#customfieldlist'); 
								
								// reload ids
								resetcatfieldids();
					}
                }); 
            
	});
   
   jQuery('#catlistboxright').html(jQuery('#filterbycatbox').html());
   jQuery('#filterbycatbox').html('');
            
            function showhideextrafield(div){
            			
            	val = jQuery('#'+div+' .field_type').val();
             
            			
            	if(val == "title" ){
					jQuery('#'+div+' .helpbox').hide();
				 
            	 
            	}else if(val == "checkbox" || val =="radio" || val =="select" ){
            		jQuery('#'+div+' .extra_values').show();
            		jQuery('#'+div+' .tax_values').hide();
            		jQuery('#'+div+' .tax_link').hide(); 
            	}else if(val == "taxonomy" ){
            		jQuery('#'+div+' .extra_values').hide();
            		jQuery('#'+div+' .tax_values').show();
            		jQuery('#'+div+' .tax_link').show();
            	}else{
            		jQuery('#'+div+' .extra_values').hide();
            		jQuery('#'+div+' .tax_values').hide();
            		jQuery('#'+div+' .tax_link').hide();	
            	}	
            }
            
            function FilterByCategory(catid){
            
            	if(catid == 0){
            	jQuery('#customfieldlist li').show();
            	}else{
            	jQuery('#customfieldlist li').hide();
            	jQuery('#customfieldlist li.'+catid+'').show();
            	}
            }
            function ChangeTickValue1(id){ 
             
            	 if(jQuery('.checkvalue'+id+'').val() == "no"){
            	 jQuery('.checkvalue'+id+'').val("yes");
            	 }else{
            	 jQuery('.checkvalue'+id+'').val("no");
            	 } 
            } 
			 function ChangeTickValue2(id){ 
             
            	 if(jQuery('.checkvalue2'+id+'').val() == "no"){
            	 jQuery('.checkvalue2'+id+'').val("yes");
            	 }else{
            	 jQuery('.checkvalue2'+id+'').val("no");
            	 } 
            } 
            function changeboxme(id){
            
             var v = jQuery("#"+id).val();
             if(v == 1){
             jQuery("#"+id).val('0');
             }else{
             jQuery("#"+id).val('1');
             }
             
            }
         </script>
         
         
 <?php /*        
<hr />

    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Layout Style","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Choose a layout for your custom field box.","premiumpress"); ?></p>
       
        </div>
        <div class="col-md-5">
    <?php $g = _ppt(array('lst','fieldslayout')); ?>
          <select name="admin_values[lst][fieldslayout]" class="mt-2 form-control" style="width:100%">
            <option value="0" <?php if( $g  == "0"){ echo "selected=selected"; } ?>><?php echo __("Default","premiumpress"); ?></option>
            <option value="1" <?php if( $g  == "1"){ echo "selected=selected"; } ?>><?php echo __("Style","premiumpress"); ?> 1</option>
             <option value="2" <?php if( $g  == "2" || $g == ""){ echo "selected=selected"; } ?>><?php echo __("Style","premiumpress"); ?> 2</option>
          </select>
        </div>
      </div>
    </div>   
         
*/ ?>

<?php


/*

 $theme_single_layouts =_ppt_single_layouts();

if(!empty($theme_single_layouts['elements'])){
?>
<hr />

    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-6">
          <label><?php echo __("Default Fields","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Here you can turn on/off the default theme fields.","premiumpress"); ?></p>
          
        
        </div>
        <div class="col-md-6">
     
     
     <?php
	 
	 
		 foreach($theme_single_layouts['elements'] as $k => $name){ ?>
        <div class="col-12 px-0 my-4">
          <div class="row">
            <div class="col-6">
              <label><?php echo $name; ?></label>
            </div>
            <div class="col-6">
              <div class="float-right">
                <label class="radio off">
                <input type="radio" name="toggle" value="off" onchange="document.getElementById('extra_<?php echo $k; ?>').value='0'">
                </label>
                <label class="radio on">
                <input type="radio" name="toggle" value="on" onchange="document.getElementById('extra_<?php echo $k; ?>').value='1'">
                </label>
                <div class="toggle <?php if(_ppt(array('themefield', $k))  == '1' || _ppt(array('themefield', $k)) == "" ){  ?>on<?php } ?>">
                  <div class="yes">ON</div>
                  <div class="switch"></div>
                  <div class="no">OFF</div>
                </div>
              </div>
              <input type="hidden" id="extra_<?php echo $k; ?>" name="admin_values[themefield][<?php echo $k; ?>]" value="<?php if(in_array(_ppt(array('themefield', $k)),array("", 1))){ echo 1; }else{  echo 0; } ?>">
            </div>
          </div>
        </div>
        <?php } ?>
     
     
     
        </div>
      </div>
    </div> 
         

<?php } */ ?>         
         
       
          <a href="admin.php?page=settings&lefttab=taxonomies" class="float-right mt-1 btn btn-sm btn-system"><i class="fal fa-heading"></i> <?php echo __("Manage Taxonomies","premiumpress"); ?></a>
       
          <a href="admin.php?page=listingsetup&reinstalldefaults=1" class="mt-1 btn-system btn-sm confirm"><i class="fal fa-sync"></i> <?php echo __("reset all fields","premiumpress"); ?></a>
   
           <hr />


<?php /* if(defined('WLT_DEMOMODE') && strpos($_SERVER['HTTP_HOST'],"premiummod.com") !== true ){ ?>
<textarea style="height:400px; width:100%;"><?php
echo "dafelds = array(";
foreach($cfields as $k => $v){

	if(is_array($v)){
		$i=0;
		echo "'".$k."' => array(";
		foreach($v as $k1 => $v1){
			echo "'".$i."' => '".$v1."',";
			$i++;
		}
		echo "),";	
	}
	 
} echo ");"; ?></textarea>
<?php } */ ?>