<?php
 
class ppt_admin_design { 
 

 

/*
	this function sets up all of the custom boxes for pages
	within the admin area
*/
function _custom_metabox(){ 

	global $CORE;
  
 
	 
	// PAGE ACCESS
	if( $CORE->LAYOUT("captions","memberships") ){
	add_meta_box( 'box_pageaccess',"Page Access", array($this, '_box_pageaccess' ), array('gallery','page', 'post','event','video'), 'side', 'low' );		
 	}
	
	add_meta_box( 'box_pageaccess',"Comment Rating", array($this, '_box_comments' ), 'comment', 'normal' );
	
	add_filter('comment_save_pre', 'save_mycomment_data' );
 	 
  	
}

function _box_comments($comment){ global $post, $CORE; 

	$rd = $CORE->LAYOUT("captions","rating");
	 
?>

<table class="form-table editcomment">
  <tbody>
    <?php
	 
	if(is_array($rd)){
		foreach($rd as $k => $r){		
		?>
    <tr>
      <td class="first"><label for="name"><?php echo $r; ?></label></td>
      <td><select class="input" name="custom[<?php echo $k; ?>]" style="width:300px; font-size:18px;">
          <option value="5" <?php selected( get_comment_meta($comment->comment_ID, $k, true), 5 ); ?>>5 - Excellent</option>
          <option value="4" <?php selected( get_comment_meta($comment->comment_ID, $k, true), 4 ); ?>>4 </option>
          <option value="3" <?php selected( get_comment_meta($comment->comment_ID, $k, true), 3 ); ?>>3 </option>
          <option value="2" <?php selected( get_comment_meta($comment->comment_ID, $k, true), 2 ); ?>>2 </option>
          <option value="1" <?php selected( get_comment_meta($comment->comment_ID, $k, true), 1 ); ?>>1 - Bad</option>
        </select>
      </td>
    </tr>
    <?php
		}
		?>
        <tr>
      <td colspan="2"><hr />
      </td>
    </tr>
        <?php
	}
	
	$total = get_comment_meta($comment->comment_ID, "ratingtotal", true);
?>
    
    <?php if(THEME_KEY == "mj"){ ?>
    <tr>
      <td class="first"><label for="name">User ID</label></td>
      <td><input type="text" name="custom[feedback_for]" size="30" value="<?php if(isset($comment->comment_ID)){ echo get_comment_meta($comment->comment_ID, "feedback_for", true); } ?>" />
      </td>
    </tr>
    
      <tr>
      <td class="first"><label for="name">Type</label></td>
      <td>
      <select name="custom[feedback]">
      <option value="0">Comment Type</option>
      <option value="1" <?php if(isset($comment->comment_ID) && get_comment_meta($comment->comment_ID, "feedback", true) == "1"){ echo "selected=selected"; } ?>>Feedback Type</option>
      
      </select>
       
      </td>
    </tr>
    
    <?php } ?>
    
    <tr>
      <td class="first"><label for="name">Rating Total</label></td>
      <td><input type="text" name="custom[ratingtotal]" size="30" value="<?php if($total == ""){ echo 5; }else{ echo $total; } ?>" /></td>
    </tr>
    <tr>
      <td class="first"><label for="name">Post ID</label></td>
      <td><input type="text" name="custom[ratingpid]" size="30" value="<?php $gi = get_comment_meta($comment->comment_ID, "ratingpid", true); if($gi == ""){ echo $comment->comment_post_ID; }else{ echo $gi; } ?>" />
     
      
      
        <?php if( get_comment_meta($comment->comment_ID, "ratingpid", true) != ""){ ?>
        <div style="margin-top:15px;"> <a href="<?php echo get_permalink(get_comment_meta($comment->comment_ID, "ratingpid", true)); ?>" target="_blank"><?php echo get_the_title(get_comment_meta($comment->comment_ID, "ratingpid", true)); ?></a></div>
        <?php } ?>
      </td>
    </tr>
  </tbody>
</table>
<?php
	
}
 
 
 

/*
	this function saves all the admin
	custom data
*/
function _custom_metabox_save($post_id){ global $pagename, $wpdb, $CORE;
 
	if(!is_numeric($post_id)){ return; }
	
	 
	if(isset($_POST['custom']) && is_array($_POST['custom'])){	
		foreach($_POST['custom'] as $k=>$v){		 	
			if($k == ""){ continue; }			
			update_post_meta($post_id, $k, $v);			
		}		 
	}// end if
	
	// ATTRIBUTES
	if( isset($_POST['attributes']) ){  
		update_post_meta($post_id,"attributes", $_POST['attributes'] );  		
	}
 
}
 
 

 

 
function _box_pageaccess(){ global $post, $CORE; 

 
	if(strpos(get_page_template_slug(), "tpl-") !== false){
	
		if( get_page_template_slug() != "_dating/tpl-chatroom.php"){	
		
		update_post_meta($post->ID,'pageaccess','');
		
		echo __("This page cannot be restricted.","premiumpress");
		
		return;
		
		}
	
	}

	$status = array(
		"" 		=> __("Everyone","premiumpress"),
		"loggedin" 	=> __("Members Only","premiumpress"),		
		"subs" 	=> __("Members With Subscriptions","premiumpress"),
	);
	
	
	// GET ALL MEMBERSHIPS
	$all_memberships = $CORE->USER("get_memberships", array());
	foreach($all_memberships  as $key => $m){
				
			$status[$m['key']] = $m['name'];
				
	} 
	
	
	
	$value = get_post_meta($post->ID,'pageaccess',true);
	if(!is_array($value)){
		$value = array("");
	} 
	 
	?>
    
<p><?php echo __("Select which membership packages have access to this page.","premiumpress"); ?></p>
<select name="custom[pageaccess][]" style="width:100%; height:200px !important;" multiple="multiple">
  <?php foreach($status as $key => $club){ ?>
  <option value="<?php echo $key; ?>" <?php if(in_array($key, $value)){  echo "selected=selected"; } ?>><?php echo $club; ?></option>
  <?php } ?>
</select>
<?php
}

 	

	
	
	
	
function LoadCongifField($item, $key, $dbkey){ global $CORE, $CORE_ADMIN; 

if(!isset($item['type'])){
$item['type'] = "";
}


if( isset($item['seperator']) ){

echo "<div class='col-12'><hr></div>";
return;
}

 
$colspan1 = "col-md-3";
$colspan2 = "col-md-9";

if( isset($item['col4']) ){

$colspan1 = "col-md-4";
$colspan2 = "col-md-8";

}

if( isset($item['col8']) ){

$colspan1 = "col-md-9";
$colspan2 = "col-md-3";

}

if( isset($item['col6']) ){

$colspan1 = "col-md-12 py-2";
$colspan2 = "col-md-12";

?>
<div class="col-md-6">
<?php }elseif( isset($item['col12']) ){

$colspan1 = "col-md-12 py-2";
$colspan2 = "col-md-12";

?>
<div class="col-md-12">
<?php }else{ ?>
<div class="col-12 border-bottom py-3">
  <?php } ?>
  <div class="row">
  
    <?php if($item['type'] != "custom"){ ?>
    <div class="<?php echo $colspan1; ?>">
      <?php  if(isset($item['name'])){ ?>
      <label class="w-100">
      <?php  if(isset($item['icon'])){ ?>
      <i class="<?php echo $item['icon'] ?> float-right mt-1 text-muted opacity-5"></i>
      <?php } ?>
      <?php echo $item['name']; ?></label>
      <?php } ?>
      
      <?php if( isset($item['col8']) ){ ?>
      <p class="text-muted"> <?php echo $item['desc']; ?></p>
      <?php } ?>
    </div>
    <?php } ?>
    
    
    <div class="<?php echo $colspan2; ?>">
      <?php  
			 
			 switch($item['type']){
			 
				 case "custom": {
				 
				 _ppt_template('framework/admin/blocks/'.$item['path'] ); 
				 
				 
				 } break; 
			 
			 
				 case "select": {
				 ob_start();
				   ?>
      <div class="input-group mb-2">
        <select name="admin_values[<?php echo $dbkey; ?>][<?php echo $key; ?>]" class="form-control">
          <?php if(isset($item['values']) && is_array($item['values']) ){ 
				 foreach($item['values'] as $k => $v){ ?>
          <option value="<?php echo $v['id']; ?>" <?php if(_ppt(array($dbkey, $key)) == $v['id']){ echo "selected=selected"; } ?>> <?php echo $v['name']; ?> </option>
          <?php } } ?>
        </select>
      </div>
      <?php if(isset($item['pagelinks']) && _ppt(array('links',$key)) != ""){ ?>
      <a href="<?php echo _ppt(array('links',$key)); ?>" target="_blank" class="small link text-uppercase"><i class="fa fa-link"></i> <?php echo __("view page","premiumpress"); ?></a>
      <?php } ?>
      <?php
				  echo ob_get_clean();
				 
				 } break;
				 
				 
				 
  case "yesno": {
               
               ob_start();
               ?>
      <div class="input-group mb-2">
        <div class="formrow">
          <div class="">
            <label class="radio off">
            <input type="radio" name="toggle" 
                     value="off" onchange="document.getElementById('<?php echo $dbkey.$key; ?>_onoff').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                     value="on" onchange="document.getElementById('<?php echo $dbkey.$key; ?>_onoff').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array($dbkey, $key)) == 1 || _ppt(array($dbkey, $key)) == "" && $item['d'] == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
        </div>
        <input type="hidden" id="<?php echo $dbkey.$key; ?>_onoff" name="admin_values[<?php echo $dbkey; ?>][<?php echo $key; ?>]"  value="<?php 
			
			if(_ppt(array($dbkey, $key)) == 1){ echo 1; }elseif( _ppt(array($dbkey, $key)) == "" && isset($item['d']) && $item['d'] != ""){ echo $item['d']; }else{ echo _ppt(array($dbkey, $key)); } ?>">
      </div>
      <?php 
             
			 echo ob_get_clean();
               
               } break;
               
               
               case "textarea": { 
               
               ob_start();
               
               ?>
      <div class="input-group mb-2">
        <textarea name="admin_values[<?php echo $dbkey; ?>][<?php echo $key; ?>]" 
            style="height:150px !important; width:100%;" 
            class="form-control"/><?php 
			   
			   if( _ppt(array($dbkey, $key)) == "" && $item['d'] !=""){ 
			   
			   echo $item['d'];
			   
			   }else{ echo _ppt(array($dbkey, $key)); } 
			   
			   ?></textarea>
      </div>
      <?php 
              
			  echo ob_get_clean();
               
               } break;  
				 
				 
				 
 case "upload": { 
               
               ob_start();
               
               ?>
      <div class="input-group mb-2">
        <input type="hidden" 
               id="up_<?php echo $key."".$key1; ?>_<?php echo $key; ?>_aid" 
               name="admin_values[<?php echo $key; ?>][<?php echo $key; ?>][<?php echo $key1; ?>_aid]" 
               class="form-control"
               <?php $HDATA = _ppt('<?php echo $key; ?>'); ?>
               data-en_us="<?php if(!isset($HDATA[$key][$key1]) || isset($HDATA[$key][$key1]) && $HDATA[$key][$key1] == ""){ echo $item['d']; }else{ echo stripslashes($HDATA[$key][$key1]); } ?>"  
               <?php if(is_array(_ppt('languages') )){ foreach(_ppt('languages') as $lang){ $icon = explode("_",$lang); if(isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } ?>
               <?php $HDATA = _ppt('hdata_'.strtolower($lang)); ?>
               data-<?php echo strtolower($lang); ?>="<?php if(!isset($HDATA[$key][$key1]) || isset($HDATA[$key][$key1]) && $HDATA[$key][$key1] == ""){ echo $item['d']; }else{ echo stripslashes($HDATA[$key][$key1]); } ?>"
               <?php } } ?>
               value=""  />
        <input 
               name="admin_values[<?php echo $key; ?>][<?php echo $key; ?>][<?php echo $key1; ?>]" 
               type="hidden" 
               id="up_<?php echo $key."".$key1; ?>_<?php echo $key; ?>" 
               value=""
               class="form-control form-image-data" />
        <div class="pptselectbox mb-3 bg-dark p-1 text-center" style="padding:5px;"> <img src="<?php echo $CORE->homeCotent($key, $key1); ?>" style="max-width:100%; max-height:300px;" class="form-image" id="<?php echo $key."".$key1; ?>_preview_<?php echo $key; ?>" /> </div>
        <div class="pptselectbtns mb-5 bg-light text-center py-2"> <a href="<?php if(isset($HDATA[$key][$key1])){ echo $HDATA[$key][$key1]; } ?>" target="_blank" class="btn btn-sm rounded-0 btn-secondary ml-2">View </a> <a href="javascript:void(0);"id="editImg<?php echo $key."".$key1; ?>_<?php echo $key; ?>" class="btn btn-sm rounded-0 btn-info mr-3">Edit </a> <a href="javascript:void(0);" id="upload_<?php echo $key."".$key1; ?>_<?php echo $key; ?>" class="btn btn-sm rounded-0 btn-warning">Change </a> <a href="javascript:void(0);" onclick="jQuery('#up_<?php echo $key."".$key1; ?>_<?php echo $key; ?>').val('');document.admin_save_form.submit();" class="btn btn-sm rounded-0 btn-danger">Delete</a> </div>
        <script >
               jQuery(document).ready(function () {
               
                   jQuery('#editImg<?php echo $key."".$key1; ?>_<?php echo $key; ?>').click(function() {           
                                
                       tb_show('', 'media.php?attachment_id=<?php if(isset($HDATA[$key][$key1."_aid"])){ echo $HDATA[$key][$key1."_aid"]; } ?>&action=edit&amp;TB_iframe=true');
                                    
                       return false;
                   });
                   
                   jQuery('#upload_<?php echo $key."".$key1; ?>_<?php echo $key; ?>').click(function() {           
                   
                       ChangeAIDBlock('up_<?php echo $key."".$key1; ?>_<?php echo $key; ?>_aid');
                       ChangeImgBlock('up_<?php echo $key."".$key1; ?>_<?php echo $key; ?>');		
                       ChangeImgPreviewBlock('<?php echo $key."".$key1; ?>_preview_<?php echo $key; ?>')
                       
                       formfield = jQuery('#up_<?php echo $key."".$key1; ?>_<?php echo $key; ?>').attr('name');
                    
                       tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
                           return false;
                   });
                                   
               });	
            </script>
      </div>
      <?php 
           
		   echo ob_get_clean();
			    
               
               } break;  
               
			  default: {
               
               ob_start();
                ?>
      <div class="input-group mb-2">
        <input type="text" name="admin_values[<?php echo $dbkey; ?>][<?php echo $key; ?>]" value="<?php 
			   
			   if( _ppt(array($dbkey, $key)) == "" && $item['d'] !=""){ 
			   
			   echo $item['d'];
			   
			   }else{ echo _ppt(array($dbkey, $key)); } 
			   
			   ?>" class="form-control">
      </div>
      <?php 
            
			echo ob_get_clean();
               
               }  
				 
				 
				 
				 
				 
				 
			
			}?>  
      <?php if(isset($item['desc']) && !isset($item['col8']) ){  ?>
      <p class="pb-0 btn-block text-muted mb-0 mt-3"><?php echo $item['desc']; ?></p>
      <?php  } ?>
    </div>
  </div>
</div>
<?php
}
	
	
	
	

	
	
	
	
	
	
} // END CORE ADMIN CLASS

?>