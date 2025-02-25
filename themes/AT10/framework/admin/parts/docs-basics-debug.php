<?php

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

 
global $CORE, $settings;


 $settings = array("title" => "Design Code", "desc" => "Here is a list of all the design code used for your current setup.");
   _ppt_template('framework/admin/_form-wrap-top' ); ?>  
    
    
    <div class="card card-admin"><div class="card-body">
    
<textarea style="width:100%; height:600px; font-size:12px;" id="debugtt"><?php  if(isset($core_admin_values['design'])){
foreach($core_admin_values['design'] as $k=> $v){ ?>$core['design']['<?php echo $k; ?>'] = "<?php echo stripslashes(str_replace('"',"'",$v)); ?>";
<?php } }  ?>
</textarea>
 

</div> </div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>  

<?php 
 
  $settings = array("title" => "All Design Code", "desc" => "Here is a list of all design code including block data");
   _ppt_template('framework/admin/_form-wrap-top' ); ?>  
    
    
    <div class="card card-admin"><div class="card-body">
 
<textarea style="width:100%; height:600px; font-size:12px;" id="debugtt"><?php if(isset($core_admin_values['design'])){ foreach($core_admin_values['design'] as $k=> $v){ ?>$core['design']['<?php echo $k; ?>'] = "<?php echo stripslashes(str_replace('"',"'",$v)); ?>";
<?php } } ?>
<?php  if(isset($core_admin_values['home']) && is_array($core_admin_values['home'])){ foreach($core_admin_values['home'] as $k => $v){ 

	if(is_array($v)){
	
		foreach($v as $kk => $vv){
		?>$core['home']['<?php echo $k; ?>']['<?php echo $kk; ?>'] = "<?php echo stripslashes(str_replace('"',"'",$vv)); ?>";
		<?php
		}
	
	}else{
	?>$core['home']['<?php echo $k; ?>'] = "<?php echo stripslashes(str_replace('"',"'",$v)); ?>";
	<?php
	}

} } ?>
</textarea>





</div> </div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>  






<?php

  $settings = array("title" => "Everything", "desc" => "Here is a list of all the shortcodes used within this framework.");
   _ppt_template('framework/admin/_form-wrap-top' ); ?>  
    
    
    <div class="card card-admin"><div class="card-body">

 
<textarea style="width:100%; height:600px; font-size:12px;" id="debugtt"><?php 
if(isset($core_admin_values['design'])){
foreach($core_admin_values['design'] as $k=> $v){ ?>$core['design']['<?php echo $k; ?>'] = "<?php echo stripslashes(str_replace('"',"'",$v)); ?>";
<?php } } ?>
<?php foreach($core_admin_values as $k => $v){ 

	if(is_array($v)){
	
		foreach($v as $kk => $vv){
		
		if(is_array( $vv)){
		
			foreach($vv as $kkk => $vvv){
				if(!is_array($vvv)){
				?>$core['<?php echo $k; ?>']['<?php echo $kk; ?>']['<?php echo $kkk; ?>'] = "<?php echo stripslashes(str_replace('"',"'",$vvv)); ?>";
				<?php
				}
			}
		
		}else{
		
		?>$core['<?php echo $k; ?>']['<?php echo $kk; ?>'] = "<?php echo stripslashes(str_replace('"',"'",$vv)); ?>";
		<?php
		}
		
		}
	
	}else{
	?>$core['<?php echo $k; ?>'] = "<?php echo stripslashes(str_replace('"',"'",$v)); ?>";
	<?php
	}

} ?>
</textarea>
</div> </div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>  

