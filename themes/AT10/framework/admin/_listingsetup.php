<?php
/* =============================================================================
   USER ACTIONS
   ========================================================================== */
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

// SETUP GLOBALS
global $wpdb, $CORE, $CORE_ADMIN;

 

// LOAD IN OPTIONS FOR ADVANCED SEARCH
wp_enqueue_script( 'jquery-ui-sortable' );
wp_enqueue_script( 'jquery-ui-draggable' );
wp_enqueue_script( 'jquery-ui-droppable' );


// LOAD IN MAIN DEFAULTS
if(function_exists('current_user_can') && current_user_can('administrator')){
   
   // SAVE CUSTOM FIELD DATE
   if(isset($_POST['updatefields'])){
   
   	if(empty($_POST['cfield'])){ $_POST['cfield'] = array(); }
   	
   	update_option("cfields", $_POST['cfield']);
   
   }
   
   // RESET DEFAULT
   
    
   if(isset($_GET['reinstalldefaults'])){
   
	   switch(THEME_KEY){
	    
		case "vt":
		case "cp":
		case "mj":
		case "jb":
		case "cm": {		
		
		 $dafelds = array();
		 update_option("cfields", $dafelds);
		
		} break;
		
		
		case "ll": {
		
		$dafelds = array('name' => array('0' => 'Price','1' => 'Level','2' => 'Language','3' => 'Course Requirements',),'help' => array('0' => '','1' => '','2' => '','3' => '',),'fieldtype' => array('0' => 'input','1' => 'taxonomy','2' => 'taxonomy','3' => 'textarea',),'dbkey' => array('0' => 'price','1' => 'level','2' => 'language','3' => 'req',),'values' => array('0' => '','1' => '','2' => '','3' => '',),'taxonomy' => array('0' => 'category','1' => 'level','2' => 'language','3' => 'category',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no',),'editonly' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no',),);
		
		update_option("cfields", $dafelds);
		 
		
		} break;
		
		
		case "ph": {
		
		$dafelds = array('name' => array('0' => 'Camera','1' => 'Camera Model','2' => 'Orientation','3' => 'License Type','4' => 'Example Field',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '',),'fieldtype' => array('0' => 'taxonomy','1' => 'input','2' => 'taxonomy','3' => 'taxonomy','4' => 'input',),'dbkey' => array('0' => 'cameratype','1' => ' camera_model','2' => 'key62809','3' => 'licensetype','4' => 'examplefield',),'values' => array('0' => '','1' => '','2' => '','3' => '','4' => '',),'taxonomy' => array('0' => 'cameratype','1' => 'category','2' => 'orientation','3' => 'license','4' => 'category',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no',),);
		
		update_option("cfields", $dafelds);
		 
		
		} break;
		
		case "so": {
		
		$dafelds = array('name' => array('0' => 'Price','1' => 'Version','2' => 'Operating System','3' => 'Example Field',),'help' => array('0' => '','1' => '','2' => '','3' => '',),'fieldtype' => array('0' => 'input','1' => 'input','2' => 'taxonomy','3' => 'input',),'dbkey' => array('0' => 'price','1' => 'version','2' => 'system','3' => 'examplefield',),'values' => array('0' => '','1' => '','2' => '','3' => '',),'taxonomy' => array('0' => 'category','1' => 'category','2' => 'system','3' => 'category',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no',),);
		
		update_option("cfields", $dafelds);
		
		} break;
	   
	   case "rt": {
	   
	   $dafelds = array('name' => array('0' => 'Asking Price','1' => 'Property Type','2' => 'Beds','3' => 'Baths','4' => 'Property Size (sqft)','5' => 'Phone Number','6' => 'Website','7' => 'My Custom Field',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '',),'fieldtype' => array('0' => 'input','1' => 'taxonomy','2' => 'taxonomy','3' => 'taxonomy','4' => 'input','5' => 'input','6' => 'input','7' => 'input',),'dbkey' => array('0' => 'price','1' => 'key75170','2' => 'key751701','3' => 'key751702','4' => 'size','5' => 'phone','6' => 'website','7' => 'customfield',),'values' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '',),'taxonomy' => array('0' => 'category','1' => 'type','2' => 'beds','3' => 'baths','4' => 'category','5' => 'category','6' => 'category','7' => 'category',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no',),'cat' => array('0' => 'Array',),);
	   
	   } break;
	   
	   case "dl": {
	   
	   $dafelds = array('name' => array('0' => 'Make','1' => 'Model','2' => 'Year','3' => 'Condition','4' => 'Body','5' => 'Fuel','6' => 'Transmission','7' => 'Exterior','8' => 'Interior','9' => 'Doors','10' => 'Engine','11' => 'Seller','12' => 'Miles','13' => 'Drive','14' => 'Owners',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '','11' => '','12' => '','13' => '','14' => '',),'fieldtype' => array('0' => 'taxonomy','1' => 'taxonomy','2' => 'input','3' => 'taxonomy','4' => 'taxonomy','5' => 'taxonomy','6' => 'taxonomy','7' => 'taxonomy','8' => 'taxonomy','9' => 'taxonomy','10' => 'taxonomy','11' => 'taxonomy','12' => 'input','13' => 'taxonomy','14' => 'taxonomy',),'dbkey' => array('0' => 'key1','1' => 'key2','2' => 'year','3' => 'key3','4' => 'key4','5' => 'key5','6' => 'key13','7' => 'key6','8' => 'key7','9' => 'key8','10' => 'key9','11' => 'key10','12' => 'miles','13' => 'key12','14' => 'key1214',),'values' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '','11' => '','12' => '','13' => '','14' => '',),'taxonomy' => array('0' => 'make','1' => 'model','2' => 'category','3' => 'condition','4' => 'body','5' => 'fuel','6' => 'transmission','7' => 'exterior','8' => 'interior','9' => 'doors','10' => 'engine','11' => 'owners','12' => 'category','13' => 'drive','14' => 'owners',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no','9' => 'no','10' => 'no','11' => 'no','12' => 'no','13' => 'no','14' => 'no',),);
	   
	   update_option("cfields", $dafelds);
	   
	   } break;
	   
	   case "ct": {
	   
	   $dafelds = array('name' => array('0' => 'Refunds','1' => 'Condition','2' => '7 Day Refunds','3' => 'Brand','4' => 'Brand','5' => 'Model Number','6' => 'Color','7' => 'Size','8' => 'Example Field',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '',),'fieldtype' => array('0' => 'title','1' => 'taxonomy','2' => 'taxonomy','3' => 'title','4' => 'taxonomy','5' => 'input','6' => 'taxonomy','7' => 'taxonomy','8' => 'input',),'dbkey' => array('0' => 'key1','1' => 'key2','2' => 'key94643','3' => 'key46827','4' => 'key90394','5' => 'modelnum','6' => 'key5411','7' => 'key91614','8' => 'examplefield',),'values' => array('0' => '','1' => '','2' => 'Yes
No','3' => '','4' => '','5' => '','6' => '','7' => 'Yes
No','8' => '',),'taxonomy' => array('0' => 'category','1' => 'condition','2' => 'refunds','3' => 'category','4' => 'brand','5' => 'category','6' => 'color','7' => 'size','8' => 'category',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no',),'cat' => array('0' => 'Array',),);

update_option("cfields", $dafelds);
	   
	   } break;
	   
	   case "mj": {
	   
	   $dafelds = array();
	   update_option("cfields", $dafelds);
	   
	   } break;
	   
	   case "dt": {
	   
	   $dafelds = array('name' => array('0' => 'Phone Number','1' => 'Website',),'help' => array('0' => '','1' => '',),'fieldtype' => array('0' => 'input','1' => 'input',),'dbkey' => array('0' => 'phone','1' => 'website',),'values' => array('0' => '','1' => '',),'taxonomy' => array('0' => 'category','1' => 'category',),'required' => array('0' => 'no','1' => 'no',),);
	   
	   update_option("cfields", $dafelds);
	   
	   } break;
	   
	   case "at": {
	   
	   $dafelds = array('name' => array('0' => 'Refunds','1' => 'Condition','2' => '7 Day Refunds','3' => 'Brand','4' => 'Brand','5' => 'Model Number','6' => 'Color','7' => 'Size',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '',),'fieldtype' => array('0' => 'title','1' => 'taxonomy','2' => 'taxonomy','3' => 'title','4' => 'taxonomy','5' => 'input','6' => 'taxonomy','7' => 'taxonomy',),'dbkey' => array('0' => 'key1','1' => 'key2','2' => 'key94643','3' => 'key46827','4' => 'key90394','5' => 'modelnum','6' => 'key5411','7' => 'key91614',),'values' => array('0' => '','1' => '','2' => 'Yes
No','3' => '','4' => '','5' => '','6' => '','7' => 'Yes
No',),'taxonomy' => array('0' => 'category','1' => 'condition','2' => 'refunds','3' => 'category','4' => 'brand','5' => 'category','6' => 'color','7' => 'size',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no',),);

update_option("cfields", $dafelds);
	   
	   } break;
		
		case "da": {		
			
			$dafelds = array('name' => array('0' => 'Age','1' => 'Ethnicity','2' => 'Sexuality','3' => 'Gender','4' => 'What do I look like?','5' => 'My Eyes','6' => 'My Hair','7' => 'My Body','8' => 'My Habbits','9' => 'Drinking','10' => 'Smoking',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '',),'cat' => array('0' => 'Array','1' => 'Array','2' => 'Array','3' => 'Array','4' => 'Array','5' => 'Array','6' => 'Array','7' => 'Array','8' => 'Array','9' => 'Array','10' => 'Array',),'fieldtype' => array('0' => 'input','1' => 'taxonomy','2' => 'taxonomy','3' => 'taxonomy','4' => 'title','5' => 'taxonomy','6' => 'taxonomy','7' => 'taxonomy','8' => 'title','9' => 'taxonomy','10' => 'taxonomy',),'dbkey' => array('0' => 'daage','1' => 'key2','2' => 'key3','3' => 'key4','4' => 'key5','5' => 'key6','6' => 'key7','7' => 'key8','8' => 'key9','9' => 'key10','10' => 'key11',),'values' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '',),'taxonomy' => array('0' => 'category','1' => 'dathnicity','2' => 'dasexuality','3' => 'dagender','4' => 'category','5' => 'daeyes','6' => 'dahair','7' => 'dabody','8' => 'category','9' => 'dadrink','10' => 'dasmoke',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no','9' => 'no','10' => 'no',),'editonly' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no','9' => 'no','10' => 'no',),);
			
			update_option("cfields", $dafelds);
		
		} break;
		
		
		case "es": {		
			
			$dafelds = array('name' => array('0' => 'Ethnicity','1' => 'Sexuality','2' => 'Gender','3' => 'Location','4' => 'What do I look like?','5' => 'My Eyes','6' => 'My Hair','7' => 'My Body','8' => 'My Height','9' => 'Dress Size','10' => 'Bust size','11' => 'My Habbits','12' => 'Drinking','13' => 'Smoking','14' => 'WhatsApp Number',),'help' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '','11' => '','12' => '','13' => '','14' => '',),'fieldtype' => array('0' => 'taxonomy','1' => 'taxonomy','2' => 'taxonomy','3' => 'input','4' => 'title','5' => 'taxonomy','6' => 'taxonomy','7' => 'taxonomy','8' => 'input','9' => 'input','10' => 'input','11' => 'title','12' => 'taxonomy','13' => 'taxonomy','14' => 'input',),'dbkey' => array('0' => 'key2','1' => 'key3','2' => 'key4','3' => 'map-city','4' => 'key5','5' => 'key6','6' => 'key7','7' => 'key8','8' => 'height','9' => 'dresssize','10' => 'bustsize','11' => 'key9','12' => 'key10','13' => 'key11','14' => 'whatsapp',),'values' => array('0' => '','1' => '','2' => '','3' => '','4' => '','5' => '','6' => '','7' => '','8' => '','9' => '','10' => '','11' => '','12' => '','13' => '','14' => '',),'taxonomy' => array('0' => 'dathnicity','1' => 'dasexuality','2' => 'dagender','3' => 'category','4' => 'category','5' => 'daeyes','6' => 'dahair','7' => 'dabody','8' => 'category','9' => 'category','10' => 'category','11' => 'category','12' => 'dadrink','13' => 'dasmoke','14' => 'category',),'required' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no','9' => 'no','10' => 'no','11' => 'no','12' => 'no','13' => 'no','14' => 'no',),'editonly' => array('0' => 'no','1' => 'no','2' => 'no','3' => 'no','4' => 'no','5' => 'no','6' => 'no','7' => 'no','8' => 'no','9' => 'no','10' => 'no','11' => 'no','12' => 'no','13' => 'no','14' => 'no',),'cat' => array('0' => 'Array',),);
			
			update_option("cfields", $dafelds);
		
		} break;
		
	   
	   }
	   
	   // LEAVE MESSAGE
		$GLOBALS['ppt_error'] = array(
			"type" 		=> "success",
			"title" 	=> "Settings Updated",
			"message"	=> "Custom field data has been reset.",
		);
	    
   }


}  
 

_ppt_template('framework/admin/header' ); 

_ppt_template('framework/admin/_form-top' ); ?>

 
<div class="tab-content">
        
        
<div class="tab-pane addjumplink active" 
        data-title="<?php echo __("Settings","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can setup listing packages for your website.","premiumpress"); ?>"
        data-icon="fa-layer-plus" 
        id="listingsetup" 
        role="tabpanel" aria-labelledby="listingsetup-tab">
<?php  _ppt_template('framework/admin/parts/listings-settings' ); ?> 
        </div>    
        
        
             <div class="tab-pane addjumplink" 
        
        
        data-title="<?php echo __("Packages","premiumpress"); ?>" 
        data-desc="<?php echo __("Here you can manage your packages","premiumpress"); ?>"
       
        data-icon="fa fa-table" 
         
        id="packages" 
        role="tabpanel" aria-labelledby="packages-tab">
        <?php  _ppt_template('framework/admin/parts/listings-packages' ); ?> 
        </div><!-- end design home tab -->
 

</div>

<?php _ppt_template('framework/admin/_form-bottom' ); ?>
<?php  _ppt_template('framework/admin/footer' );  ?>
 
  
     <!--- ----------- -->
<div style="display:none">
   <div id="customfieldlist_new">
      <li class="cfielditem">
         <div class="heading">
            <div class="name"><?php echo __("New Custom Field","premiumpress"); ?></div>
         </div>
         <div class="inside">   
            <input type="hidden" name="cfield[values][]" value=""  />
            <input type="hidden" name="cfield[cat][][]" value="0" class="customfield-cat"  />
            <input type="hidden" name="cfield[fieldtype][]" value="input"  />
            <input type="hidden" name="cfield[required][]" value="no"  />
            <input type="hidden" name="cfield[taxonomy][]" value=""  />
            <input type="hidden" name="cfield[help][]" value=""  />
            <input type="hidden" name="cfield[taxonomy_link][]" value=""  />
            
            
            <label>Display Caption</label>
            <input type="text" name="cfield[name][]" value=""  style="width:100%;" class="form-control"  />  
            <input type="hidden" id="newcfieldkey" name="cfield[dbkey][]" value="key<?php echo rand(0,100000); ?>"  />
            <button class="btn btn-primary mt-2 " type="submit"><?php echo __("Save","premiumpress"); ?></button>
         </div>
      </li>
   </div>
</div>
<!--- ----------- -->