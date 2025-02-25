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

global $CORE, $userdata, $post;

$hasAccess = 0; $ratingset =0;


$mydesc = do_shortcode('[EXCERPT]'); 

// CHECK AGAINST MEMBERSHIPS
if($userdata->ID == $post->post_author){
$hasAccess = 3;
}elseif($CORE->USER("membership_hasaccess", "view_photos") == 1){ 
$hasAccess = 3;
}
 

// CHECK ACCESS
if($hasAccess != 3){
$hasAccess = $CORE->USER("get_offer_status", $post->ID);
}
 
// CHECK REQUEST ACCESS
$showRequest = false;
/*
if($CORE->USER("get_offer", $post->ID) == 0){	
	if($userdata->ID){
		$showRequest = true;
	}
}
*/
 
 		
// CHECK IF WE HAVE ALREADY RATED		
$divID = str_replace("+","",round(microtime(true) * 440)).$post->ID;
if($userdata->ID){ 
		$user_ip = $CORE->get_client_ip();
		$rated_user_ips = get_option('rated_user_ips');
		 
		$ratedup = false;
		$rateddown = false;
		$ratingset = false;
		if(!is_array($rated_user_ips)){ $rated_user_ips = array(); }
		
		if(!isset($rated_user_ips[$post->ID])){ $rated_user_ips[$post->ID] = array(); }
		
	 	
			if(isset($rated_user_ips[$post->ID]) && isset($rated_user_ips[$post->ID]['ip-'.$user_ip]) && in_array($user_ip, $rated_user_ips[$post->ID]['ip-'.$user_ip])  ){			
				
				$ratingset = true;
				if( $rated_user_ips[$post->ID]['ip-'.$user_ip]['rating'] == 1){
					$ratedup = true;
				}else{
					$rateddown = true;
				}			
			}
} 

$title = __("Contact","premiumpress");

?>

<div class="sidebar-fixed-content">
  <div class="card card-listing" data-title="<?php echo $title; ?>"  id="sec-sidebar">
    <div class="filter-content collapse show nocolapse" id="collapse-sec-sidebar">
      <div class="card-body"> 
      
      <?php if(in_array(_ppt(array('user','account_messages')), array("","1")) ){ ?>
      <a <?php echo $CORE->USER("get_message_link", $post->post_author); ?> class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2 mb-3"><i class="fal fa-comments-alt mr-2 text-primary"></i> <?php echo __("Message","premiumpress") ?></a>
      <?php } ?>
       
       
        <?php if( in_array(_ppt(array('design', 'display_gifts')), array("", "1")) ){ ?>
        <a 
      <?php if(!$CORE->USER("membership_hasaccess", "gifts")){ ?>
       
       href="javascript:void(0);"  onclick="processUpgrade();"
       
       <?php }elseif(!$userdata->ID){ ?>
       
        href="javascript:void(0);" onclick="processLogin();" 
         
       <?php }elseif($userdata->ID && $CORE->USER("membership_hasaccess", "gifts")){ ?>
       
       href="javascript:void(0);"  onclick="giftshow();"
         
       <?php }else{ ?>
       
      href="javascript:void(0);"  onclick="ProcessUpgrade();"
      <?php } ?>
      
     class="btn btn-block btn-system shadow-sm btn-xl btn-icon icon-before mt-2"><i class="fal fa-heart mr-2 text-primary"></i> <?php echo __("Send Gift","premiumpress") ?></a>
        <?php } ?>
        
        
        <div class="divider-or"><span class="mt-n1"><?php echo __("Or","premiumpress") ?></span></div>
      
      <?php if(in_array(_ppt(array('user','likes')), array("","1"))){ ?>
        <?php if(!$ratingset){ ?>
        <div id="<?php echo $divID; ?>"> <a <?php if(!$userdata->ID){ ?> href="javascript:void(0);" onclick="processLogin();" <?php }else{ ?> href="javascript:void(0);" onclick="doratebutton('<?php echo $divID; ?>', '<?php echo $post->ID; ?>', 'up');" <?php } ?>  class="btn btn-block btn-light mt-2"> <?php echo __("Like","premiumpress") ?> <i class="fal mx-2 fa-heart"></i> <?php echo do_shortcode('[TITLE]'); ?> </a> </div>
        <?php }else{ ?>
        <a href="javascript:void(0);" class="btn btn-block btn-danger btn-xl mt-2"><?php echo __("Thanks!","premiumpress") ?></a>
        <?php } ?>
        <?php } ?>
        
        <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
    <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin();" class="btn btn-block btn-light mt-2"> <?php echo __("Add Favorites","premiumpress") ?></a>
      <?php }else{ ?>
      <?php echo do_shortcode('[FAVS class="btn btn-block btn-light mt-2" text=1 icon=0 icon_name="fal fa-heart"]'); ?>
      <?php } ?>
      <?php } ?>
        
        
          <?php if(_ppt(array('user','friends')) == 1){ ?> 
    <?php echo do_shortcode('[SUBSCRIBE class="btn btn-block btn-light mt-2" icon=0 count=0 text=1 uid="'.$post->post_author.'"]'); ?>
    <?php } ?>
        
        <?php if( $userdata->ID == $post->post_author && $CORE->USER("get_likes_count", $post->ID) > 0){ ?>
        <div class="text-center pt-3 small"><a <?php if($CORE->USER("membership_hasaccess", "liked") == 1){  ?>href="javascript:void(0);" onclick="jQuery('#showmylikedusers').toggle();" <?php }else{ ?> href="<?php echo _ppt(array('links','memberships')); ?>" <?php } ?> class="text-dark text-underline">
          <?php if($CORE->USER("membership_hasaccess", "liked") == 0){?>
          <i class="fa fa-lock"></i>
          <?php } ?>
          <?php echo __("See who's liked my profile.","premiumpress") ?></a></div>
        <?php
	  if($CORE->USER("membership_hasaccess", "liked") == 1){ 
	  $f = get_post_meta($post->ID, 'likes_array', true);
	  if(is_array($f) && !empty($f) ){
	  ?>
        <div class="pt-3" id="showmylikedusers" style="display:none;">
          <?php
	  foreach( $f as $u){
	  if(!isset($u['userid'])){ continue; }
	  
	       $day 	= date("d", strtotime($u['date']));
		   $month 	= date("M", strtotime($u['date']));
		   $year 	= date("Y", strtotime($u['date']));
	  ?>
          <div class="border-bottom mb-2 pb-2">
            <div class="row">
              <div class="col-md-8"> <a href="<?php echo $CORE->USER("get_user_profile_link", $u['userid']); ?>"> <img src="<?php echo $CORE->USER("get_avatar", $u['userid']); ?>" width="26" height="26" class="mr-2" alt="user" /> <small><?php echo $CORE->USER("get_username", $u['userid']); ?></small> </a> </div>
              <div class="col-md-4 small">
                <time datetime="<?php echo $u['date']; ?>"><?php echo $month; ?> <?php echo $day ; ?></time>
              </div>
            </div>
          </div>
          <?php } } ?>
        </div>
        <?php }  } ?>
      </div>
    </div>
  </div>
</div>
<!--gift modal -->
<div class="extra-modal-wrap shadow hidepage" style="display:none;">
  <div class="extra-modal-wrap-overlay"></div>
  <div class="extra-modal-item">
    <div class="extra-modal-container">
      <?php if(!$CORE->USER("membership_hasaccess", "gifts")){ ?>
      <div class="alert p-3 my-4 alert-warning m-4" id="giftsent"> <i class="float-left pb-2 fa-3x fa fa-lock mr-3"></i>
        <div class="lead font-weight-bold"><?php echo __("No Access","premiumpress"); ?></div>
        <p class="mb-0 pb-0"><?php echo __("Please upgrade your membership to access this feature.","premiumpress"); ?></p>
      </div>
      <div class="extra-modal-close bg-dark text-center" onclick="jQuery('.extra-modal-wrap').fadeOut(400)" style="top: 30px;"><i class="fal fa-times">&nbsp;</i></div>
      <?php }else{ ?>
      <div class="alert p-3 my-4 alert-success m-4" id="giftsent" style="display:none;"> <i class="float-left pb-2 fa-3x fa fa-check mr-3"></i>
        <div class="lead font-weight-bold"><?php echo __("Gift Sent!","premiumpress"); ?></div>
        <p class="mb-0 pb-0"><?php echo __("Your gift is on it's way, the user will be notified shortly.","premiumpress"); ?></p>
        <div class="extra-modal-close bg-dark text-center" onclick="jQuery('.extra-modal-wrap').fadeOut(400)" style="top: 30px;"><i class="fal fa-times">&nbsp;</i></div>
      </div>
      <div class="alert p-3 my-4 alert-danger m-4" id="toomnaygifts" style="display:none;"> <i class="float-left pb-2 fa-3x fa fa-heart-broken mr-3"></i>
        <div class="lead font-weight-bold"><?php echo __("Too Many Gifts","premiumpress"); ?></div>
        <p class="mb-0 pb-0"><?php echo __("It looks like you've already sent this user a gift.","premiumpress"); ?></p>
        <div class="extra-modal-close bg-dark text-center" onclick="jQuery('.extra-modal-wrap').fadeOut(400)" style="top: 30px;"><i class="fal fa-times">&nbsp;</i></div>
      </div>
      <div class="card-body" id="giftselect">
        <h3><?php echo __("Click any gift icon below to send to","premiumpress") ?> <?php echo $CORE->USER("get_username",$post->post_author); ?></h3>
        <div class="container p-5">
          <div class="row" id="gifticons">
            <?php $i=1; while($i < 9){ 
			
			
			$defaultimg = get_template_directory_uri()."/_dating/icons/".$i.".png";
			if( _ppt(array('bgimg', "gift".$i)) == ""){			
			}else{				
				$defaultimg = _ppt(array('bgimg', "gift".$i));				
			}
			
			?>
            <div class="col-md-3 gifti<?php echo $i; ?>"> <a href="javascript:void(0);" <?php if($userdata->ID == $post->post_author){ ?>onclick="alert('<?php echo __("You cannot send yourself a gift.","premiumpress") ?>');"<?php }else{ ?>onclick="SendGiftItem('<?php echo $i; ?>');"<?php } ?>> <img src="<?php echo $defaultimg; ?>" alt="gif" class="img-fluid" /></a> </div>
            <?php $i++; } ?>
          </div>
        </div>
        <div class="extra-modal-close bg-primary text-center" onclick="jQuery('.extra-modal-wrap').fadeOut(400)"><i class="fal fa-times">&nbsp;</i></div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<!--gift end -->
<?php /* $e1 = _ppt(array('design', "element_stats")); if($e1 == "" || $e1 == 1){ ?>
<div class="row mt-n2">

<div class="col-12 col-xl-4 mb-4 mb-xl-0">

	<div class="shadow-sm text-center bg-white py-2 rounded">
    	
        <div class="h4"><i class="fal fa-users"></i></div>
        <div class="font-weight-bold"><?php echo do_shortcode('[HITS]'); ?></div>
        <div class="small text-uppercase"><?php echo __("Views","premiumpress"); ?></div>
    
    </div>

</div>


<div class="col-12 col-xl-4 mb-4 mb-xl-0">

	<div class="shadow-sm text-center bg-white py-2 rounded">
    	
        <div class="h4"><i class="fal fa-heart"></i></div>
        <div class="font-weight-bold" id="statslikec"><?php echo $CORE->USER("get_likes_count", $post->ID); ?></div>
        <div class="small text-uppercase"><?php echo __("Likes","premiumpress"); ?></div>
    
    </div>

</div>


<div class="col-12 col-xl-4 mb-4 mb-xl-0">

	<div class="shadow-sm text-center bg-white py-2 rounded">
    	<?php $lasto = $CORE->USER("get_lastlogin",  $post->post_author); ?>
        <div class="h4"><i class="fal fa-lightbulb"></i></div>
        <div class="font-weight-bold <?php if(strlen($lasto) > 8){ echo "small"; } ?>"><?php echo $lasto;  ?></div>
        <div class="small text-uppercase small"><?php echo __("Last Online","premiumpress"); ?></div>
    
    </div>

</div>

</div>
<?php } */ ?>
<script>

 
jQuery(document).ready(function(){ 
   
  
		jQuery(".sidebar-fixed-content").scrollToFixed({
			minWidth: 1064,
			zIndex: 12,
			marginTop: 100,
			removeOffsets: true,
			limit: function () {
				var a = jQuery(".limit-box").offset().top - jQuery(".sidebar-fixed-content").outerHeight(true) - 48;
				return a;
			}
		});  
   
});



<?php if($CORE->USER("membership_hasaccess", "gifts")){ ?>
function SendGiftItem(tid){


jQuery('#gifticons').html("<div class='col-12 text-center'><i class='fas fa-spinner fa-spin fa-3x'></i></div>");

jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "add_gift",
			pid: <?php echo $post->ID; ?>,
			uid: <?php echo $userdata->ID; ?>,
			rid: <?php echo $post->post_author; ?>,
			gift: tid,			 			
        },
        success: function(response) {
 
			if(response.status == "ok"){ 
			
			
				jQuery.ajax({
						type: "POST",
						url: '<?php echo home_url(); ?>/',	
						dataType: 'json',	
						data: {
							action: "send_chat_msg",
							uid: <?php echo $userdata->ID; ?>,
							rid: <?php echo $post->post_author; ?>,
							gift: tid,
							msg: 'gift',			
						},
						success: function(response) {
				 
							if(response.status == "ok"){
							
									jQuery("#giftsent").show();
									jQuery("#giftselect").hide();
							
							}else{			
								
										
							}			
						},
						error: function(e) {
							console.log(e)
						}
				});
							
			
			}else if(response.status == "found"){ 	 		 
  		 	
			jQuery("#toomnaygifts").show();
			jQuery("#giftselect").hide();
			
			}else{			
				alert("asd");		
			}			
        },
        error: function(e) {
            console.log(e)
        }
});


}

function giftshow(){

	jQuery(".extra-modal-wrap").fadeIn(400);	

}
<?php } ?> 

function doratebutton(div, id, type){

 	jQuery('#'+div+' a').html("<i class='fas fa-spinner fa-spin'></i>");
	ajax_saverating(id ,type, div+''+type);  
	
	setTimeout(function(){  
		jQuery('#'+div+' a').html("<i class='fa fa-check'></i>");   
	}, 1000); 
 
}

  
function ajax_saverating(pid, rr, div){
	
  jQuery.ajax({
        type: "POST",  
		url: ajax_site_url,	
        data: {
            action: "rating_likes",
			pid: pid,
            value: rr,
        },
        success: function(e) {
			
			if(e == "none"){
				
			}else if(rr == "up"){
				jQuery('#'+div +' .count').html(e);
			}else{
				jQuery('#'+div +' .count').html(e);
			}
			
			jQuery('#statslikec').html(e);
			 
			 
        },
        error: function(e) {
             
        }
    });	
}
 
</script>
