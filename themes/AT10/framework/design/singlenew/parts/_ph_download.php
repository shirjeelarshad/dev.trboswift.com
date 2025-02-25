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

global $CORE, $post, $userdata;



function calDim($number, $denominator = 1)
{

	if(!is_numeric($number)){ return $number; }
	
	if($denominator == "3quater"){
	
		$x = ($number/4) * 3;
		$x = floor($x);		
		
	}elseif($denominator == "half"){
	
		$x = ($number/4) * 2;
		$x = floor($x);		
	
	}elseif($denominator == "1quater"){
	
		$x = ($number/4);
		$x = floor($x);		
	}

    return $x;
}
 
	// LETS GET THE MEDIA DETAILS FOR THE FIRST ITEM THATS ON THE LIST
	// AND THEN WE CAN USE THAT AS OUR MAIN INFO FOR THE DISPLAY OF THE ITEM
	$files = $CORE->media_get($post->ID,'all');
 
	$ThisMediaItem = $files[0];
	 
	// GET SIZE
	if(!isset($ThisMediaItem['size'])){
	$ThisMediaItem['size'] = "100";
	}
	
	if(isset($ThisMediaItem['id']) && is_numeric($ThisMediaItem['id']) ){ }else{ $ThisMediaItem['id'] = 0; }	
	
	// GET FILE META DATA
	$meta_data  = wp_get_attachment_metadata( $ThisMediaItem['id'] );
 
	// SETUP DIP
	$dpi = "";
	if(isset($ThisMediaItem['dpi']) && $ThisMediaItem['dpi'] != ""){
	$dpi = "@ ".$ThisMediaItem['dpi']."dpi";
	}
	
	// LETS GET THE DIMENTION SIZES
	$meia_w = ""; $meia_h = ""; $DOWNLOADARRAY = array();
	if(isset($ThisMediaItem['dimentions'])){
		$DIMENTIONS =  $ThisMediaItem['dimentions'];	
				
		// FALLBACK
		if($DIMENTIONS != ""){
			$gg = explode("x",$DIMENTIONS);
			$meia_w = $gg[0];
			$meia_h = $gg[1];
		}
		
		// FULL SIZE 
		$DOWNLOADARRAY[1] = array(
			"title"		=> __("Full Size","premiumpress"),
			"uid" 		=> $userdata->ID,
			"pid" 		=> $post->ID,
			"aid" 		=> $ThisMediaItem['id'],
			"type" 		=> str_replace("image/","",$ThisMediaItem['type']),
			"width" 	=> $meia_w,
			"height" 	=> $meia_h, 
			"size"		=> $CORE->_format_bytes(preg_replace("/[^0-9,.]/", "",$ThisMediaItem['size'])),
		);
		 
		//if($meia_w > 2400 || $meia_h > 2600){}
		
		// 3 THIRDS
		if(is_numeric($meia_w)){
		$DOWNLOADARRAY[2] = array(
			"title"		=> __("Large","premiumpress"),
			"uid" 		=> $userdata->ID,
			"pid" 		=> $post->ID,
			"aid" 		=> $ThisMediaItem['id'],
			"type" 		=> str_replace("image/","",$ThisMediaItem['type']),
			"width" 	=> calDim($meia_w, "3quater"),
			"height" 	=> calDim($meia_h, "3quater"), 
			"size"		=> $CORE->_format_bytes(calDim(preg_replace("/[^0-9,.]/", "",$ThisMediaItem['size']), "3quater")),
		);
		}
		 
		
		// HALF SIZE
		if(is_numeric($meia_w)){
		$DOWNLOADARRAY[3] = array(
			"title"		=> __("Medium","premiumpress"),
			"uid" 		=> $userdata->ID,
			"pid" 		=> $post->ID,
			"aid" 		=> $ThisMediaItem['id'],
			"type" 		=> str_replace("image/","",$ThisMediaItem['type']),
			"width" 	=> calDim($meia_w, "half"),
			"height" 	=> calDim($meia_h, "half"), 
			"size"		=> $CORE->_format_bytes(calDim(preg_replace("/[^0-9,.]/", "",$ThisMediaItem['size']), "half")),
		);
 
		}
		
		// 1 THIRD
		if(calDim($meia_w, "1quater") > 400 || calDim($meia_h, "1quater") > 600){
		$DOWNLOADARRAY[4] = array(
			"title"		=> __("Small","premiumpress"),
			"uid" 		=> $userdata->ID,
			"pid" 		=> $post->ID,
			"aid" 		=> $ThisMediaItem['id'],
			"type" 		=> str_replace("image/","",$ThisMediaItem['type']),
			"width" 	=> calDim($meia_w, "1quater"),
			"height" 	=> calDim($meia_h, "1quater"), 
			"size"		=> $CORE->_format_bytes(calDim(preg_replace("/[^0-9,.]/", "",$ThisMediaItem['size']), "1quater")),
		);
		}
		
		
	}
	
	
	if(defined('WLT_DEMOMODE') && empty($DOWNLOADARRAY) ){
	
		$DOWNLOADARRAY[1] = array(
				"title"		=> __("Small","premiumpress"),
				"uid" 		=> $userdata->ID,
				"pid" 		=> $post->ID,
				"aid" 		=> 1,
				"type" 		=> "image/jpg",
				"width" 	=> 300,
				"height" 	=> 250, 
				"size"		=> $CORE->_format_bytes(3000),
				"demo" => 1,
		);
		$DOWNLOADARRAY[2] = array(
				"title"		=> __("Medium","premiumpress"),
				"uid" 		=> $userdata->ID,
				"pid" 		=> $post->ID,
				"aid" 		=> 1,
				"type" 		=> "image/jpg",
				"width" 	=> 600,
				"height" 	=> 550, 
				"size"		=> $CORE->_format_bytes(9000),
				"demo" => 1,
		);
		$DOWNLOADARRAY[3] = array(
				"title"		=> __("Large","premiumpress"),
				"uid" 		=> $userdata->ID,
				"pid" 		=> $post->ID,
				"aid" 		=> 1,
				"type" 		=> "image/jpg",
				"width" 	=> 1200,
				"height" 	=> 1050, 
				"size"		=> $CORE->_format_bytes(18000),
				"demo" => 1,
		);
	
	}
	
	
	 

?>
                   
      
     


 <script>
	
	function StartMediaDownload(val){
		
		<?php foreach($DOWNLOADARRAY as $key => $dl){ ?>
		if(val == <?php echo $key; ?>){
		
		<?php if(defined('WLT_DEMOMODE')){ ?>
		
		alert('This is a demo website - downloads are disabled.');
		
		<?php }else{ ?>
		
		jQuery('#mediaData').val('<?php echo base64_encode( json_encode( $dl ) ); ?>');
		jQuery('#Mediaform').submit();
		
		<?php } ?>
		
		}
		<?php } ?>
		 
		
		
	}
	
	</script>
    
    
    <form method="post" action="" id="Mediaform">
    <input type="hidden" name="data" value="" id="mediaData" />
    <input type="hidden" name="downloadproduct" value="1" />
     
    <div class="btn-group btn-block">
    
    
    <?php  if(!$userdata->ID && in_array(_ppt(array('design', 'display_photologin')), array("1"))  ){ ?>
    
    <a onclick="processLogin();" class="btn btn-success btn-lg btn-block dropdown-toggle py-3 rounded-0" href="javascript:void(0);"><i class="fa fa-download mr-2 hide-mobile"></i> <?php echo __( 'Download File', 'premiumpress' ); ?></a>
    
    <?php }else{ ?>
    
      <button class="btn btn-success btn-lg btn-block dropdown-toggle py-3 rounded-0" type="button" <?php if(empty($DOWNLOADARRAY)){ echo "disabled"; } ?> data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-download mr-2 hide-mobile"></i> <?php echo __( 'Download File', 'premiumpress' ); ?>
      </button>

      <div class="dropdown-menu dropdown-menu-right btn-block">
      <?php foreach($DOWNLOADARRAY as $key => $dl){ ?>
      <button class="dropdown-item" type="button" onclick="StartMediaDownload(<?php echo $key; ?>);" style="cursor:pointer;">
	  
       
	  <?php if(in_array($dl['type'], $CORE->allowed_image_types)){ ?>
      <?php echo $dl['width']; ?> x <?php echo $dl['height']; ?> 
      <?php }else{ ?>
      <?php echo $files[0]['type']; ?>
      <?php } ?>
	    <span class="float-right"><?php echo $dl['size']; ?></span> </button>
      <?php } ?>
        
      </div>
      
      <?php } ?>
      
      
    </div>
    
    </form>


 