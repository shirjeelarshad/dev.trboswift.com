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


// LOAD IN MAIN DEFAULTS 
$regionslist = _ppt('regions'); //get_option("core_admin_values"); 

if(!is_array($regionslist)){ $regionslist = array(); } 
 
?> 

<a href="javascript:void(0);" onClick="jQuery('.cfielditem').hide();jQuery('#ppt__regions').clone().insertAfter('#ppt__regionss');jQuery('#noaddregions').hide();" class="btn btn-light btn-md shadow-sm float-right"><i class="fal fa-plus"></i> <?php echo __("Add New","premiumpress"); ?></a>	 

<a href="#quickAdd" role="button" data-toggle="modal" class="btn btn-light btn-md shadow-sm float-right mr-3" style="float:right;margin-left:10px;"><i class="fal fa-globe"></i> <?php echo __("Popular","premiumpress"); ?></a>
  


<h4><?php echo __("Regions","premiumpress"); ?></h4>

<hr />

 


<?php if(!is_array(_ppt('regions'))){ ?>

<div class="text-center opacity-5" id="noaddregions"><?php echo __("No regions added","premiumpress"); ?></div>

<?php } ?> 
 
 
<!-- Modal -->
<div id="quickAdd" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="quickAddLabel" aria-hidden="true" style="top:30%;">

<div class="modal-dialog" role="document">
    <div class="modal-content">
 
  <div class="modal-body">

 <a href="admin.php?page=cart&add_pre_usa=1&lefttab=regions" onclick="jQuery('#ShowTab').val('regions');" class="btn btn-light btn-md float-right shadow-sm"> <?php echo __("Continue","premiumpress"); ?></a>  
     	
        <h4>USA Tax States</h4>
         
        <hr />
        <a href="admin.php?page=cart&add_pre_usa=3&lefttab=regions" onclick="jQuery('#ShowTab').val('regions');"  class="btn btn-light btn-md float-right shadow-sm"><?php echo __("Continue","premiumpress"); ?></a>
       
        <h4>Canadian Tax States</h4>
          
        <hr />
        <a href="admin.php?page=cart&add_pre_usa=2&lefttab=regions" onclick="jQuery('#ShowTab').val('regions');" class="btn btn-light btn-md float-right shadow-sm"><?php echo __("Continue","premiumpress"); ?></a> 
        <h4 class="media-heading ">EU Countries</h4>
         
              
               
  </div>
  <div class="modal-footer">
  
  <strong class="small float-left">remember to save changes.</strong>
  
    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>

  </div>
</div>
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<?php

if( isset($_GET['add_pre_usa']) && !isset($_POST['lefttab'])   ){

 
	$df = 0; $i = 0;	
	if(isset($regionslist['name']) && is_array($regionslist['name'])){
		while($i < count($regionslist['name']) ){ 		
			if($regionslist['name'][$i] !=""){ 		
				$df++;
			} 
			$i++;		
		 }
	 }
 
	 
	if($_GET['add_pre_usa'] == 1){
 
		$regionslist['name'][$df] = 'USA (0% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Alaska','Delaware','Montana','New Hampshire','Oregon');		
		$df++;
		$regionslist['name'][$df] = 'USA (2.9% Tax States Only)';  
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Colorado');
		$df++;
		$regionslist['name'][$df] = 'USA (4% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Alabama','Georgia','Guam','New York','South Dakota','Wyoming');
		$df++;
		$regionslist['name'][$df] = 'USA (4.16% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Hawaii');
		$df++;		
		
		$regionslist['name'][$df] = 'USA (4.225% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Missouri');
		$df++;			
		
		$regionslist['name'][$df] = 'USA (4.45% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Louisiana');
		$df++;	
		
		$regionslist['name'][$df] = 'USA (4.5% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Oklahoma');
		$df++;		
		
		$regionslist['name'][$df] = 'USA (4.75% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('North Carolina');
		$df++;	
		
		$regionslist['name'][$df] = 'USA (5% Tax States Only)';  
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Nebraska','North Dakota','Wisconsin');
		$df++;
		
		$regionslist['name'][$df] = 'USA (5.125% Tax States Only)';  
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('New Mexico');
		$df++;
				
		$regionslist['name'][$df] = 'USA (5.3% Tax States Only)';  
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Virginia');
		$df++;		

		$regionslist['name'][$df] = 'USA (5.5% Tax States Only)';  
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Maine','Nebraska');
		$df++;	
			
		$regionslist['name'][$df] = 'USA (5.6% Tax States Only)';  
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Arizona');
		$df++;
		
		$regionslist['name'][$df] = 'USA (5.75% Tax States Only)';  
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Utah');
		$df++;				
		
		$regionslist['name'][$df] = 'USA (5.95% Tax States Only)';  
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('District of Columbia','Ohio');
		$df++;	
 
		
		$regionslist['name'][$df] = 'USA (6% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Florida','Idaho','Iowa','Kentucky','Maryland','Michigan','Pennsylvania','South Carolina','Vermont','West Virginia');
		$df++;

		
		$regionslist['name'][$df] = 'USA (6.25% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Illinois','Massachusetts','Texas');
		$df++;
		
		
		$regionslist['name'][$df] = 'USA (6.35% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Connecticut');
		$df++;
		
		
		$regionslist['name'][$df] = 'USA (6.5% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Arkansas','Kansas','Washington');
		$df++;		
		
		$regionslist['name'][$df] = 'USA (6.625% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('New Jersey');
		$df++;
		
		$regionslist['name'][$df] = 'USA (6.85% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Nevada');
		$df++;		
		
		$regionslist['name'][$df] = 'USA (6.875% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Minnesota');
		$df++;		
		
		$regionslist['name'][$df] = 'USA (7% Tax States Only)'; 
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Indiana','Mississippi','Rhode Island','Tennessee');
		$df++;		
		
		$regionslist['name'][$df] = 'USA (7.25% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('California');
		$df++;
		
		$regionslist['name'][$df] = 'USA (10.5% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Puerto Rico');
		$df++; 		
		
		$regionslist['name'][$df] = 'USA (10.725% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Arizona');
		$df++;
		
		$regionslist['name'][$df] = 'USA (10.85% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Missouri');
		$df++;

		$regionslist['name'][$df] = 'USA (11% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Oklahoma');
		$df++;

		$regionslist['name'][$df] = 'USA (11.45% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Louisiana');
		$df++;
		
		$regionslist['name'][$df] = 'USA (11.5% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Kansas');
		$df++;
			
		$regionslist['name'][$df] = 'USA (11.625% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Arkansas');
		$df++;
			
		$regionslist['name'][$df] = 'USA (12.625% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('New Jersey');
		$df++;
		
		$regionslist['name'][$df] = 'USA (13.5% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Alabama');
		$df++;
			
	 
	}elseif($_GET['add_pre_usa'] == 2){
	
		$regionslist['name'][$df] = 'EU - European Union Countries';
		$regionslist['country'][$df] = array('AT','BE','BG','HR','CY','CZ','DE','EE','FI','FR','DE','GR','HU','IS','IT','LV','LT','LU','MT','NL','PL','PT','RO','SK','SI','SP','SE','UK');
		$regionslist['state'][$df] = array('');
		
	}elseif($_GET['add_pre_usa'] == 3){
	
		$regionslist['name'][$df] = 'CA (5% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Alberta');
		$df++;
		
		$regionslist['name'][$df] = 'CA (10% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Saskatchewan');
		$df++;	
		$regionslist['name'][$df] = 'CA (12% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('British Columbia');
		$df++;		
		$regionslist['name'][$df] = 'CA (13% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Manitoba','Ontario','New Brunswick','Newfoundland');
		$df++;	
		$regionslist['name'][$df] = 'CA (14% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Quebec','Prince Edward Island');
		$df++;			
		$regionslist['name'][$df] = 'CA (15% Tax States Only)';
		$regionslist['country'][$df] = array('');
		$regionslist['state'][$df] = array('Nova Scotia');			
	} 
}

 

 
?>

 
<ul id="ppt__regionss">
<?php 

$setKeys = array();

 
// COUNTRY LIST
$country_string1 = "";
foreach($GLOBALS['core_country_list'] as $key=>$value){
	$country_string1 .= "<option value='".$key."'>".$value."</option>";
} // end if 

// STATE LIST
$state_string1 = "";
foreach($GLOBALS['core_country_list'] as $key=>$value){
	$state_string1 .= "<optgroup label='".$value."' class='".$key."_state'>";	
	
						
	// NOW LETS CHECK FOR STATES
	if(isset($GLOBALS['core_state_list'][$key])){
		$bits = explode("|",$GLOBALS['core_state_list'][$key]);
		foreach($bits as $st){
			if(isset($selected_state) && $selected_state == $value){ $sel ="selected=selected"; }else{ $sel =""; }
			$state_string1 .= '<option value="'.$st.'">'.$st.'</option>';
		} // end if
							
	}// end if
						
	$state_string1 .= "</optgroup>";										
} // end if


  
if( is_array($regionslist) && isset($regionslist['name']) ){ $i=0; 

 


while($i < count($regionslist['name']) ){ if($regionslist['name'][$i] !=""){ 


// ADJUST KEY IF IS DUPLICATE
if(isset($regionslist['key'][$i]) && in_array($regionslist['key'][$i], $setKeys) ){  
$regionslist['key'][$i] = $regionslist['key'][$i]."".$i; 
}


// ADD TO ALREADY DONE LIST
if(isset($regionslist['key'][$i])){
$setKeys[] = $regionslist['key'][$i];	 
}
 ?>
    <li class="cfielditem" id="method_<?php echo $i; ?>">
    
     <div class="heading">
     
     
      	<div class="showhide">
            <a href="#" onclick="jQuery('#region_inside_<?php echo $i; ?>').fadeToggle();" rel="tooltip" data-original-title="Show/Hide Options" data-placement="top" class="btn btn-primary btn-sm">
            <i class="fa fa-search" aria-hidden="true"></i>
            </a>                                  
        </div>    
    
  
     
    <div class="name">
    
    
    
    <a href="#" onClick="jQuery('#method_<?php echo $i; ?>_d1').val('');jQuery('#method_<?php echo $i; ?>').hide();" rel="tooltip" data-original-title="Delete" data-placement="top" class="btn btn-primary btn-sm">
        <i class="fas fa-times" aria-hidden="true"></i>
        </a> 
    
    <span class="opacity-5 float-right small mr-3"><?php if(isset($regionslist['key']) && isset($regionslist['key'][$i]) && strlen($regionslist['key'][$i]) < 30){ echo $regionslist['key'][$i]; } ?></span>
    
 &nbsp; <span class="font-weight-bold"><?php echo $regionslist['name'][$i]; ?></span>
 
 </div>
 
 </div><!-- end heading -->
 
 
    <div class="inside" style="display:none;" id="region_inside_<?php echo $i; ?>"> 
    
    
          
    <label><span class="font-weight-bold"><?php echo __("Display Text","premiumpress"); ?></span> <small>(e.g European Region)</small></label>
    <input type="text" name="admin_values[regions][name][]" value="<?php echo $regionslist['name'][$i]; ?>"  class="form-control" id="method_<?php echo $i; ?>_d1"  /> 
     

<div class="row mt-4">
<div class="col-md-6">
 <label class="">Select region countries</label>
 
<select  class="form-control selectpicker" data-live-search="true" name="admin_values[regions][country][<?php echo $i; ?>][]" id="region_country_<?php echo $i; ?>" multiple="multiple" style="height:450px !important">
<option value="">&nbsp;</option>
<?php
$country_string = $country_string1;

// ADD ON SELECTED ITEMS
if(isset($regionslist['country'][$i]) && is_array($regionslist['country'][$i]) ){
	foreach($regionslist['country'][$i] as $selected_countries){
		if(isset($selected_countries) && strlen($selected_countries) > 1){	 
			$country_string = str_replace($selected_countries."'",$selected_countries."' selected=selected",$country_string);	
		}
	}
}

echo $country_string;
?>
</select>  


<script>
jQuery(document).ready(function(){
      jQuery("#region_country_<?php echo $i; ?>").change(function(){ 
        
		if(confirm("Would you like to add the states/provinces for this country?\n\n\n If you are applying the same tax/ship price for the entire country, you do not need to add states/provinces.")){
		
			alert('Please wait a moment while we update the state list for you. (the window may freeze for a moments)');
		    var cla = jQuery("#region_country_<?php echo $i; ?>").val();	
   			jQuery.each( cla, function( key, value ) {
				jQuery("."+value+"_state").children().attr('selected','selected');
				
				
				jQuery(".selectpicker").selectpicker('refresh')
				
			});	
		}else{
			//Cancel button pressed...
		} 
		
		 		
      });	
   
 
	  
});


</script>    

</div>
<div class="col-md-6">              

<label class="">Select region states</label>

<select data-placeholder="Select States..." class="form-control selectpicker" data-live-search="true" name="admin_values[regions][state][<?php echo $i; ?>][]" id="region_state_<?php echo $i; ?>" multiple="multiple" style="height:450px !important;">
<option value=""></option>
<?php
$state_string = $state_string1;
// ADD ON SELECTED ITEMS
if(isset($regionslist['state'][$i]) && is_array($regionslist['state'][$i]) ){
	foreach($regionslist['state'][$i] as $selected_states){
		if(isset($selected_states) && strlen($selected_states) > 1){	 
			$state_string = str_replace($selected_states.'"',$selected_states.'" selected=selected',$state_string);	
		}
	}
}
echo $state_string;
?>
</select>  

</div>
</div>
                      
       <hr />              
  
   <input type="text" name="admin_values[regions][key][]" value="<?php if(isset($regionslist['key']) && isset($regionslist['key'][$i]) && strlen($regionslist['key'][$i]) < 30){ echo $regionslist['key'][$i]; }else{ echo ""; } ?>"  class="form-control float-right" style="width:150px;" />      
   
    <button type="submit" class="btn btn-primary rounded-0" onclick="document.getElementById('ShowTab').value='regions'"><?php echo __("Save Changes","premiumpress"); ?></button>  
     
    <div class="clear"></div>
    </div>
    </li> 
<?php } $i++;  } } ?>
</ul>
 
 






 










<!-- DEFAULT BOX CODE --->
<div style="display:none"><div id="ppt__regions">
    <div class="postbox">
    
 
    <div class="inside mt-3">       
    <p> <span class="font-weight-bold"><?php echo __("Display Text","premiumpress"); ?></span> <small>(e.g European Region)</small></p>
    <input type="text" name="admin_values[regions][name][]" value="" class="form-control m-b-1"  /> 
    
     <input type="hidden" name="admin_values[regions][key][]" value="regkey-<?php echo rand(23412,32424); ?>"   />  
    
    <button type="submit" class="btn btn-primary mt-4 rounded-0" onclick="document.getElementById('ShowTab').value='regions'"><?php echo __("Save","premiumpress"); ?></button>
    </div>
    </div> 
</div>
</div>
<!-- DEFAULT BOX CODE --->