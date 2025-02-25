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
   
   global $CORE, $userdata, $authorID; 
   
   
   	// GET USER UID
   	if(isset($GLOBALS['flag-account']) ){
   	$thisUserID = $userdata->ID;
   	}else{
   	$thisUserID = $authorID;
   	}
	
	// GET DESC
	$desc = get_the_author_meta( 'description', $thisUserID); 
    
   ?>
 
<div class="card card-account-sidebar mb-4">
  <div class="bg-primary" style="height:100px;"> </div>
  <div class="col-md-7 mx-auto mt-n5 pl-0 sidebar-userphoto clearfix pr-0 text-center"> 
  
  <a onclick="SwitchPage('details');" href="javascript:void(0);" class="position-relative"> <span class="ml-2">
   
  <img class="rounded-circle img-fluid mb-3" src="<?php echo $CORE->USER("get_avatar", $thisUserID ); ?>" alt="user ">
  
  </span>
   
   <?php if(_ppt(array('user','level')) == "0"){ }else{  ?> 
    <div class="levelicon active withtext position-absolute" style="bottom:20px; right:0px;">
    <span><?php echo $CORE->USER("get_level",$thisUserID); ?></span>
    <small><?php echo __("level","premiumpress"); ?></small>
    </div>
    <?php } ?>
    
    </a> </div>
  <div class="text-center"> <?php echo $CORE->USER("get_online_badge", $CORE->USER("get_online_status", $thisUserID)); ?> </div>
  <div class="card-body clearfix">
    <div class="text-center mb-4">
      <h5><?php echo $CORE->USER("get_username",$thisUserID); ?></h5>
     
     
    </div>
    <?php if(isset($GLOBALS['flag-account']) ){ ?>
    <ul class="list-group list-group-flush  border-top my-4 p-0">
      <?php   foreach($CORE->USER("get_account_links", array()) as $k => $i){ 	 
            if(isset($i['hidebox'])){ continue; }					 
            ?>
      <a <?php if($i['link'] != ""){ ?>href="<?php echo $i['link']; ?>"<?php }else{ ?>onclick="SwitchPage('<?php echo $k; ?>');" href="javascript:void(0);"<?php } ?> class="list-group-item tab-<?php echo $k; ?> text-dark <?php if($k == "dashboard"){ ?>selected<?php } ?>"> <span><?php echo $i['name'] ?></span> <i class="fa <?php echo $i['icon'] ?> float-right text-dark opacity-5"></i> </a>
      <?php  } ?>
    </ul>
    <?php } ?>
    
    
    
    
    <?php if(isset($GLOBALS['flag-account']) ){ ?>
    <div class="mt-4">
    
      <?php if(_ppt(array('user','allow_profile')) == 1){ ?>
      <a href="<?php echo $CORE->USER("get_user_profile_link",$thisUserID); ?>" class="btn btn-primary btn-block btn-sm py-2"><?php echo __("View My Profile","premiumpress"); ?></a>
      <?php } ?>
      <div class="mt-3"> <a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-dark btn-sm py-2 small text-uppercase btn-block border"><i class="fa fa-sign-out"></i> <?php echo __("Logout","premiumpress"); ?></a> </div>
    </div>
    <?php }else{  
         $user_info = get_userdata($thisUserID); ?>
         
    <?php if(_ppt(array('user','account_messages')) == 1){ ?> 
    
    <a <?php echo $CORE->USER("get_message_link", $thisUserID); ?> class="btn btn-system btn-block btn-lg mb-2 shadow-sm"  ><i class="fa fa-envelope"></i> <?php echo __("Message","premiumpress"); ?></a>
    
    <?php } ?>
    
    
    <?php if(_ppt(array('user','friends')) == 1){ ?> 
    <?php echo do_shortcode('[SUBSCRIBE class="btn btn-block btn-md btn-light" count=0 text=1 uid="'.$thisUserID.'"]'); ?>
    <?php } ?>
    

    <?php } ?>
  </div>
</div>




<div class="card card-author-extra mb-4">
  <div class="card-body">
    <h5 class="card-title"><?php  echo __("About Me","premiumpress"); ?></h5>
    
<?php if(strlen($desc) > 1){ ?>
<div class="bg-light p-3 small mb-4">
<?php echo str_replace("<p>","<p class='mb-0'>",wpautop($desc)); ?>
</div>
<?php } ?>    

 
<ul class="list-group list-group-flush">

<?php



if($CORE->USER("get_verified", $thisUserID) == "1"){
$verified = '<span class="onlinebadge online text-dark badge border px-2 bg-white"><i class="fa fa-award text-success"></i> '.__("Email Verified","premiumpress").'</span>';
}else{
$verified = '<span class="onlinebadge online text-dark badge border px-2 bg-white"><i class="fa fa-award text-danger"></i> '.__("Not Verified","premiumpress").'</span>';
}

$mydetails = array(
	
	1 => array(
		"icon" => "fal fa-user-tie",
		"title" =>  __("Joined","premiumpress"),
		"value" =>  $CORE->USER("get_joined",  $thisUserID),		
	),
	
	2 => array(
		"icon" => "fal fa-lightbulb",
		"title" =>  __("Last Online","premiumpress"),
		"value" => $CORE->USER("get_lastlogin",  $thisUserID),	
	),

	3 => array(
		"icon" => "fal fa-globe",
		"title" =>  __("Location","premiumpress"),
		"value" => $CORE->USER("get_country", $thisUserID)." ".$CORE->USER("get_country_flag", $thisUserID),	
	),
	
	4 => array(
		"icon" => "fal fa-envelope",
		"title" =>  __("User Verified","premiumpress"),
		"value" => $verified,	
	),

	5 => array(
		"icon" => "fal fa-award",
		"title" =>  __("User Level","premiumpress"),
		"value" => "<span class='badge badge-success'>".__("Level","premiumpress")." ".$CORE->USER("get_level",  $thisUserID)."</span>",	
	),
	
	
	6 => array(
		"icon" => "fal fa-sync",
		"title" =>  __("Jobs Sold","premiumpress"),
		"value" => $CORE->USER("count_offers_complete", $thisUserID),	
	),	
	
	7 => array(
		"icon" => "fal fa-clock",
		"title" =>  __("Orders in Queue","premiumpress"),
		"value" => $CORE->USER("count_offers_pending", $thisUserID),	
	),		
	  
 
);


if(_ppt(array('user','level')) == "0"){
unset($mydetails[5]);
}

if(in_array(THEME_KEY, array("pj")) && get_user_meta($thisUserID,'user_type',true) == "user_fr" ){

	$rate = get_user_meta($thisUserID,'ppt_hourlyrate',true);
	if(is_numeric($rate) && $rate != "0"){
	$rate = hook_price($rate);
	}else{
	$rate =  __("negotiable","premiumpress");
	}

	$mydetails[8] = array(
		"icon" => "fal fa-funnel-dollar",
		"title" =>  __("Hourly Rate","premiumpress"),
		"value" => $rate	
	);
}

if(!in_array(THEME_KEY, array("mj")) ){
	
	unset($mydetails[5]);
	unset($mydetails[6]);
	unset($mydetails[7]);
}else{

	if(THEME_KEY == "at"){
		$mydetails[6]['title'] = __("Auctions Sold","premiumpress");
		$mydetails[7]['title'] = __("Auctions Pending Review","premiumpress");
	}
}

foreach($mydetails as $d){
?>

<li class="list-group-item d-flex justify-content-between align-items-center px-0">

<span class="text-uppercase small"><i class="<?php echo $d['icon']; ?> mr-2"></i> <?php echo $d['title']; ?></span>

<span class="text-uppercase font-weight-bold small"><?php echo $d['value']; ?>  </span>

</li>
<?php } ?>
</ul>



</div>
</div> 


<?php if(in_array(THEME_KEY, array("mj","at","pj","ct","dl")) ){ ?>
<div class="card card-author-extra mb-4 myrating">
  <div class="card-body">
    <h5 class="card-title"><?php  echo __("My Rating","premiumpress"); ?> </h5>
    
    <div class="mb-3"> <?php echo do_shortcode('[RATING_USER uid='.$thisUserID.']'); ?></div> 

<?php

$data = $CORE->USER("feedback_score", $thisUserID); 
 
  
$ratingLabels = array(

	"1" => __('Very Poor',"premiumpress"),
	"2" =>  __('Below Average',"premiumpress"),	
	"3" =>  __('Average',"premiumpress"),
	"4" =>  __('Above Average',"premiumpress"),
	"5" =>  __('Perfect',"premiumpress"),

 );

?>

         <?php $i=5; while($i > 0){
		 
		 if(isset($data['data'][$i])){  $to = $data['data'][$i]; }else{  $to = 0; } 
		 
		 
		 ?>
            <div class="row <?php if($to > 0){ ?>mb-2<?php } ?>">
              
               <div class="col-11">
             
               
               <label class="pb-0 mb-0 small mb-2 w-100"> <span class="font-weight-bold text-uppercase text-muted"><?php echo $ratingLabels[$i]; ?></span>
               
               
                 
               <?php if($to > 0){ ?> 
               <span class="float-right small"> <a href="javascript:void(0);" onclick="showcomments('<?php echo $i; ?>','<?php echo $ratingLabels[$i]; ?>');"><?php  echo __("view comments","premiumpress"); ?></a></span>
               <?php } ?>
               </label>
               
                  <div class="progress rounded-0">
                     <div class="progress-bar bg-success" role="progressbar" style="width: <?php if($to == 0){ echo 0; }else{ echo $to/$data['votes']*100; } ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
               </div>
               <div class="col-1 px-0"> 
                  <span class="rating-result-count <?php if($to == 0){ ?>bg-light text-dark<?php } ?>"><?php echo $to; ?></span>
                  
               </div>
            </div>
            <?php $i--; } ?>   
    
</div>
</div> 


<!--comments-modal -->
<script>
function showcomments(rr, text){

	rre = rr + 1;
	 
	jQuery(".extra-modal-wrap").fadeIn(400);
	
	jQuery(".extra-modal-wrap h3").html(text);	
	
	jQuery('#ajax-comments-form').html('<div class="text-center mt-5 pt-5"><i class="fa fa-spinner fa-4x text-primary fa-spin"></i></div>');
	
	  jQuery.ajax({
			type: "POST",  
			url: ajax_site_url,	
			data: {
				action: "get_comments",
				uid: <?php echo $thisUserID; ?>,
				value1: rr,
				value2: rre,
			},
			success: function(e) {			 
				
				jQuery('#ajax-comments-form').html(e).addClass('p-4');
				 
				 
			},
			error: function(e) {
				 
			}
		});	
	 
}
</script>
<div class="extra-modal-wrap shadow hidepage" style="display:none;">
  <div class="extra-modal-wrap-overlay"></div>
  <div class="extra-modal-item">
    <div class="extra-modal-container">
    
     <div id="ajax-comments-form" style="max-height:400px; overflow:scroll;"></div>
     
      <div class="card-body">
        <h3></h3>
        <div class="payment-modal-close bg-primary text-center" onclick="jQuery('.extra-modal-wrap').fadeOut(400)"><i class="fal fa-times">&nbsp;</i></div>
      </div>
 
      </div>
 
  </div>
</div>
<!--comment end -->
<?php } ?>   