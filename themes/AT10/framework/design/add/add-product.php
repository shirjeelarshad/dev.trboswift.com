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

global $CORE;


?>

 <div class="row">
 
 <?php if(THEME_KEY != "so" ){ ?> 

 
<div class="col-6">
<div class="form-group">
	 <label><?php echo __("Price","premiumpress"); ?></label>
    <div class="input-group position-relative">    
	<input class="form-control numericonly" placeholder="0" name="custom[price]" value="<?php if( isset($_GET['eid']) ){  echo get_post_meta($_GET['eid'], "price", true); } ?>" style="padding-left:30px !important;"/>
   
    <div class="position-absolute" style="bottom: 8px;    left: 10px;"><?php echo hook_currency_symbol(''); ?></div>
    
    <div class="position-absolute text-muted" style="bottom: 8px;    right: 10px;"><?php echo hook_currency_code(''); ?></div>
     
    
    </div>
</div>
</div>
<div class="col-6">
<div class="form-group">
	<label><?php echo __("Old Price","premiumpress"); ?></label>
    <div class="input-group">   
	<input class="form-control numericonly" placeholder="0" name="custom[old_price]" value="<?php if( isset($_GET['eid']) ){  echo get_post_meta($_GET['eid'], "old_price", true); } ?>" style="padding-left:30px !important;"/>
    
    <div class="position-absolute" style="bottom: 8px;    left: 10px;"><?php echo hook_currency_symbol(''); ?></div>
    
    <div class="position-absolute text-muted" style="bottom: 8px;    right: 10px;"><?php echo hook_currency_code(''); ?></div>

    </div>
</div>
</div>




 <div class="col-12">
<hr />
</div>

 <?php if(!isset($_POST['ajaxedit'])){ ?>
<div class="col-3">

<label><?php echo __("Subtrack Stock","premiumpress"); ?></label>
     <div class="formrow mb-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('enable_stock_remove').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('enable_stock_remove').value='1'">
            </label>
            <div class="toggle <?php if(isset($_GET['eid']) &&  $CORE->get_edit_data('stock_remove', $_GET['eid']) == '1'){  ?>on<?php } ?>">
               <div class="yes">ON</div>
               <div class="switch"></div>
               <div class="no">OFF</div>
            </div>
         </div>
         <input type="hidden" id="enable_stock_remove" class="form-control" name="custom[stock_remove]" value="<?php if(isset($_GET['eid'])){  echo $CORE->get_edit_data('stock_remove', $_GET['eid']); } ?>">
        
</div>
<?php } ?>

<div class="col-3">
<div class="form-group">

<label><?php echo __("Quantity","premiumpress"); ?></label>
	 
      <div class="input-group position-relative"> 
      
        <input type="input" name="custom[qty]" class="form-control" value="<?php if(isset($_GET['eid'])){
	 	
		$g =  $CORE->get_edit_data('qty', $_GET['eid']); if($g == ""){ echo 10; }else{ echo $g; } }else{ echo 1; } ?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
       
       <div class="position-absolute text-muted small" style="bottom: 8px;    right: 10px;">in stock</div>

       
        </div>
        
            
  
</div>
</div>


<div class="col-6">
<div class="form-group">
	<label><?php echo __("Out of stock message","premiumpress"); ?></label>
    <div class="input-group">
	<input type="input" name="custom[stock_outofmsg]" class="form-control" value="<?php if(isset($_GET['eid'])){ echo $CORE->get_edit_data('stock_outofmsg', $_GET['eid']); } ?>" placeholder="<?php echo __("Sorry, we're out of stock!","premiumpress"); ?>">
    </div>
</div>
</div>



<?php } ?>


<div class="col-12">
<hr />
</div>



<?php if(THEME_KEY == "so" ){ ?>


<div class="col-6">
<div class="form-group">
	<label><?php echo __("Product Website","premiumpress"); ?></label>
    <div class="input-group">
	<input type="input" name="custom[url]" class="form-control" value="<?php if(isset($_GET['eid'])){ echo $CORE->get_edit_data('url', $_GET['eid']); } ?>" placeholder="http://...">
    </div>
</div>
</div>


<div class="col-6">
<div class="form-group">
	<label><?php echo __("Product Demo Website","premiumpress"); ?></label>
    <div class="input-group">
	<input type="input" name="custom[url_demo]" class="form-control" value="<?php if(isset($_GET['eid'])){ echo $CORE->get_edit_data('url_demo', $_GET['eid']); } ?>" placeholder="http://...">
    </div>
</div>
</div>


<div class="col-12">
<hr />
</div>
<?php } ?>


<div class="col-6">

<label><?php echo __("Identifier (SKU, UPC or Model ID)","premiumpress"); ?></label> 

 <div class="form-group">

        <div class="input-group">
        <input class="form-control" name="custom[sku]" value="<?php if( isset($_GET['eid']) ){  echo get_post_meta($_GET['eid'], "sku", true); } ?>" />
        </div>
    </div>

  </div>
<div class="col-6">

	<label><?php echo __("Product Type","premiumpress"); ?></label>
    <div class="input-group">
    
<select name="custom[type]" class="form-control" id="ptypeb" style="width:100%;" onchange="checkaddlink();">
 


<?php if(THEME_KEY == "so"){ ?>

<option value="3" <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'type', true) == 3){ echo "selected=selected"; } ?>><?php echo __("Digital Download","premiumpress"); ?></option>

<option value="2" <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'type', true) == 2){ echo "selected=selected"; } ?>><?php echo __("Affiliate Product","premiumpress"); ?></option>


<?php }else{ ?>

<option value="0" <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'type', true) == 0){ echo "selected=selected"; } ?>><?php echo __("Normal Product","premiumpress"); ?></option>

<option value="2" <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'type', true) == 2){ echo "selected=selected"; } ?>><?php echo __("Affiliate Product","premiumpress"); ?></option>
<option value="3" <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'type', true) == 3){ echo "selected=selected"; } ?>><?php echo __("Digital Download","premiumpress"); ?></option>

<?php } ?>
 
</select>    
    </div>
    


 
 

<script>
<?php if(THEME_KEY == "so" && !isset($_GET['eid']) ){ ?>
checkaddlink(3);
<?php } ?>

function checkaddlink(){

	if(jQuery('#ptypeb').val() == 2){
		
	jQuery('#afflinkbox').show();
	jQuery('#filebox').hide();
	
	}else if(jQuery('#ptypeb').val() == 3){
		
	jQuery('#filebox').show();
	jQuery('#afflinkbox').hide();
	
	}else{
	jQuery('#afflinkbox').hide();
	jQuery('#filebox').hide();
	}
}
jQuery(document).ready(function(){ 
checkaddlink();
}); 

</script>

</div>   

 



<div class="col-12" style="display:none;" id="afflinkbox">
	<label class="mt-3"><?php echo __("Affiliate Link","premiumpress"); ?></label>
    <div class="input-group"> 
	<input class="form-control" name="custom[buy_link]" value="<?php if( isset($_GET['eid']) ){  echo get_post_meta($_GET['eid'], "buy_link", true); } ?>" />
    </div>
</div>

 

<div class="col-12" style="display:none;" id="filebox">
	<label class="mt-3"><?php echo __("Download Path","premiumpress"); ?></label>
    <div class="input-group position-relative"> 
    
    <?php if(is_admin()){ ?>
    <button type="button" id="download_path_select" class="position-absolute" style="right:10px; top:10px; z-index: 1; font-size: 11px; background:none !important;"><?php echo __("Select File","premiumpress"); ?></button>
    
    <?php } ?>
	<input class="form-control w-100" id="download_path" name="custom[download_path]" value="<?php if( isset($_GET['eid']) ){  echo get_post_meta($_GET['eid'], "download_path", true); } ?>" />
    
    </div>
     <div class="small mt-2 clearfix text-muted">copy and paste the file URL into the box above.</div>
   
</div>

<input type="hidden" value="download_path" name='attachments[28133][post_title]' id="imgIdblock" />
<script>

jQuery(document).ready(function() {

var my_original_editor = window.send_to_editor;


 	jQuery('#download_path_select').click(function() {           
           
		   tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		   
			window.send_to_editor = function(html) {	
			
			console.log(html);
			 		
				var regex = /src="(.+?)"/;
				var rslt =html.match(regex);
				 
				var imgrex = /wp-image-(.+?)"/;
				var imgid = html.match(imgrex);
			 
				var imgurl = rslt[1];
				var imgaid = imgid[1];
				
				jQuery('#download_path').val(imgurl); 
				
				tb_remove();
				
				window.send_to_editor = my_original_editor;
			 
			 
			}		   
		   
		   
           return false;
    });
               		
 

}); 
</script>

</div>