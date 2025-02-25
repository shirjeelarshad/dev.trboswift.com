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

global $CORE, $wpdb, $settings;

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

$bannersizes = array(
"262x220" => array("name" => "Theme Sidebar Standard"),
"370x300" => array("name" => "Theme Sidebar Standard"),
"468x60" => array("name" => "Full banner"),
"234x60" => array("name" => "Half banner"),
"336x280" => array("name" => "Large rectangle"),
"180x150" => array("name" => "Rectangle"),
"300x100" => array("name" => "3:1 rectangle"),
"728x90" => array("name" => "Leaderboard"),
"720x300" => array("name" => "Pop-under"),
"120x240" => array("name" => "Vertical banner"),
"300x250" => array("name" => "Medium rectangle"),
"120x90" => array("name" => "Button 1"),
"120x60" => array("name" => "Button 2"),
"240x400" => array("name" => "Vertical rectangle"),
"250x250" => array("name" => "Square pop-up "),
"300x600" => array("name" => "Half-page ad"),
"160x600" => array("name" => "Wide skyscraper"),
"120x600" => array("name" => "Skyscraper"),
"125x125" => array("name" => "Square button"),
"350x350" => array("name" => "Large Square"),

);

if(THEME_KEY == "cp"){

unset($bannersizes['262x220']);
}else{

unset($bannersizes['370x300']);
}
 
?>

<div class="container">
<div class="row">

<div class="col-md-4 pr-lg-4">
    
    
    <h3 class="mt-4"><?php echo __("Sellspace","premiumpress"); ?></h3>
    
    <p class="text-muted lead"><?php echo __("Here you can enable/disable advertising locations on your website.","premiumpress"); ?>
	 
	 
	 </p>
     
     <p><?php echo __("You can visit the advertising page","premiumpress"); ?> <a href="<?php echo _ppt(array('links','sellspace')); ?>" target="_blank">here</a>.</p> 
   
    
  
        

</div><div class="col-md-8">
    
    
    
    <div class="card card-admin"><div class="card-body">
    
    
    
    
    
     <!-- ------------------------- -->
         <div class="container px-0 border-bottom mb-3 ">
            <div class="row py-2">
               <div class="col-md-8">
                  <label class="txt500"><?php echo __("Enable Sellspace","premiumpress"); ?></label>
                  <p class="text-muted"><?php echo __("Turn on/off the advertising system.","premiumpress"); ?></p>
               </div>
               <div class="col-md-2">
                  <div  class="mt-3 formrow">
                        <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('enable_sellspace').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('enable_sellspace').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('sellspace','enable'))  == '1'){  ?>on<?php } ?>">
               <div class="yes">ON</div>
               <div class="switch"></div>
               <div class="no">OFF</div>
            </div>
         </div>
         <input type="hidden" id="enable_sellspace" name="admin_values[sellspace][enable]" value="<?php echo _ppt(array('sellspace','enable')); ?>">
               </div>
            </div>
         </div>

    
    
    
    
    
    
     
   
    
 


 <table class="table table-bordered table-payments table-striped mb-4 small">
      <thead>
         <tr>          
            <th><?php echo __("Enable","premiumpress"); ?></th>
            
            <th><?php echo __("Location","premiumpress"); ?></th>
            <th class="text-center"><?php echo __("Price","premiumpress"); ?></th>
            
            
            <th class="text-center"><?php echo __("Actions","premiumpress"); ?></th>
            
         </tr>
      </thead> 
      
      <tbody>
     
         
   
 <?php
$i=1;
$sellspacedata = _ppt('sellspace');		


	 
foreach($CORE->ADVERTISING("get_spaces", array() ) as $key => $ban){ ?>


<tr class="row-<?php echo $key; ?>">
<td>

  <div class="small text-muted">
         <input type="hidden" name="admin_values[sellspace][<?php echo $key; ?>]" value="0" />
         <input type="checkbox" name="admin_values[sellspace][<?php echo $key; ?>]" value="1" class="ml-3" <?php if( isset($sellspacedata[$key]) && $sellspacedata[$key] == 1){ ?>checked=checked<?php } ?> /> <?php echo __("Enable Banner","premiumpress"); ?>
         </div>
                                
        <div class="small text-muted mt-2">
         <input type="hidden" name="admin_values[sellspace][<?php echo $key; ?>_sample]" value="0" />
         <input type="checkbox" name="admin_values[sellspace][<?php echo $key; ?>_sample]" value="1" class="ml-3" <?php if( isset($sellspacedata[$key."_sample"]) && $sellspacedata[$key."_sample"] == 1){ ?>checked=checked<?php } ?> /> <?php echo __("Show Sample","premiumpress"); ?>
         </div>                                


</td>            
            
<td>
<?php echo $ban['n']; ?>  
               
</td>  

<td class="text-center">
<em id="<?php echo $key; ?>pricebox"></em> 
               
</td>

<td style="width:100px;">
<a href="javascript:void(0);" onclick="jQuery('#bannerspace-<?php echo $i; ?>').modal('show');" class="btn btn-system btn-md shadow-sm"><?php echo __("Edit","premiumpress"); ?></a>
               
</td>

 
       
</tr> 

<?php $i++; } ?>  

   </tbody>
   </table> 


 <?php
$i=1;
$sellspacedata = _ppt('sellspace');		


	 
foreach($CORE->ADVERTISING("get_spaces", array() ) as $key => $ban){ ?>


		<div id="bannerspace-<?php echo $i; ?>" class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document"><div class="modal-content p-4">
					 
 
      <label class="mt-4 txt500"><?php echo __("Display Title","premiumpress"); ?></label>
      
      <input type="text" name="admin_values[sellspace][<?php echo $key; ?>_name]" 
         
         value="<?php if(isset($sellspacedata[$key."_name"]) && $sellspacedata[$key."_name"] != ""){ echo $sellspacedata[$key."_name"]; }else{ echo $ban['n']; } ?>"
         
          class="form-control" />
          
          
     <label class="mt-4 txt500"><?php echo __("Banner Size","premiumpress"); ?></label>
     
    <select name="admin_values[sellspace][<?php echo $key; ?>_size]" class="form-control mt-2">
    
    <option value="<?php echo $ban['sw']."x".$ban['sh']; ?>">Default: (<?php echo $ban['sw']."x".$ban['sh']; ?>)</option>
    
    <?php foreach($bannersizes as $bk => $size){ ?>
    <option value="<?php echo $bk; ?>" <?php if(isset($sellspacedata[$key."_size"]) && $sellspacedata[$key."_size"] == $bk ){ echo "selected=selected"; } ?>><?php echo $size['name']; ?> (<?php echo $bk; ?>)</option>
    <?php } ?>
    
    
    </select>
    
    
    <div class="btn-block mt-3"><p class="text-muted"><?php echo __("The recommended size for this location is","premiumpress"); ?>: <strong><?php echo $ban['sw']; ?> x <?php echo $ban['sh']; ?> px.</strong> </p></div>
          
          
          
      <label class="mt-2 txt500"><?php echo __("Description","premiumpress"); ?></label>
      
      <textarea name="admin_values[sellspace][<?php echo $key; ?>_desc]" class="form-control" style="height:200px !important;" /><?php if(isset($sellspacedata[$key."_desc"]) && $sellspacedata[$key."_desc"] != ""){ echo $sellspacedata[$key."_desc"]; } ?></textarea>
     
        

<script>
jQuery(document).ready(function() {
<?php if(isset($sellspacedata[$key."_price"])){ ?>
jQuery('#<?php echo $key; ?>pricebox').html('<?php echo hook_currency_symbol(''); ?><?php echo $sellspacedata[$key."_price"]; ?>');
jQuery('#<?php echo $key; ?>sizebox').html('<?php echo $sellspacedata[$key."_size"]; ?>');
<?php } ?>

});
</script>

<div class="container mt-4 px-0 mb-5">
<div class="row">

<div class="col-6">
<label class="txt500"><?php echo __("Price per Ad","premiumpress"); ?></label>      

<div class="input-group">
                  <span class="input-group-prepend input-group-text"><?php echo hook_currency_symbol(''); ?></span>
<input type="text" name="admin_values[sellspace][<?php echo $key; ?>_price]" 
         
         value="<?php if(isset($sellspacedata[$key."_price"]) && $sellspacedata[$key."_price"] != ""){ echo $sellspacedata[$key."_price"]; }else{ echo 30; } ?>" class="form-control"/>
               </div>
        
</div>

<!--
<div class="col-4">

<label class="txt500">Space</label>

         <input type="text" name="admin_values[sellspace][<?php echo $key; ?>_max]" 
         
         value="<?php if(isset($sellspacedata[$key."_max"]) && $sellspacedata[$key."_max"] != ""){ echo $sellspacedata[$key."_max"]; }else{ echo 1; } ?>"
         
         class="form-control" />

</div>
-->

<div class="col-6">

<label class="txt500"><?php echo __("Campaign Length (Days)","premiumpress"); ?></label><br />
             
             <input type="text" name="admin_values[sellspace][<?php echo $key; ?>_days]" 
         
         value="<?php if(isset($sellspacedata[$key."_days"]) && $sellspacedata[$key."_days"] != ""){ echo $sellspacedata[$key."_days"]; }else{ echo 30; } ?>"
         
          class="form-control"/>

</div>

</div>
 

<hr />
<button type="submit" class="btn btn-system btn-md"><?php echo __("Update Settings","premiumpress"); ?></button>

</div></div>
</div></div>

<?php $i++; } ?>  
 
 
  <div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    	</div>

    
   
  </div></div> 
   
   
   
    
    
    
 
	<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>  
