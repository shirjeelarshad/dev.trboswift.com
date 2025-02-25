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

global $CORE, $userdata;

?>
<div class="account_top">
<div class="card shadow-sm border-0 mb-4">


  <div class="card-body"> 
  
  
  <?php if( $CORE->LAYOUT("captions","listings") ){ ?>
  
  
  <?php if(_ppt(array('lst','onelistingonly')) == 1){ 
  
  
	$SQL = "SELECT DISTINCT ".$wpdb->posts.".ID FROM ".$wpdb->posts." WHERE post_type = 'listing_type' AND post_status = 'publish' AND post_author = ('".$userdata->ID."') LIMIT 1";				 
   	$query = $wpdb->get_results($SQL, OBJECT);
   	if(!empty($query)){
		$link =  _ppt(array('links','add'))."/?eid=".$query[0]->ID;
   	}else{
		$link = _ppt(array('links','add'));
	}
  
  ?>
  
  <a href="<?php echo $link; ?>" class="text-dark text-decoration-none arrowright"> <i class="fa fa-chevron-right"></i>
    <div class="d-flex justify-content-start y-middle">
      <div class="count-numbers border-right pr-4 pl-2"><i class="<?php echo $CORE->LAYOUT("captions","icon"); ?>"></i> </div>
      <h4><?php echo __("Edit","premiumpress"); ?> <?php echo __("My","premiumpress"); ?> <?php echo $CORE->LAYOUT("captions","1"); ?> </h4>
    </div>
    </a> 
    
  <?php }else{  ?>
  
  
  
  <?php 
  
  $e1 = _ppt(array('user', "add"));  
  
  if($CORE->USER("count_listings", $userdata->ID) == 0 && ($e1 == "" || $e1 == 1 )){ ?>
  
  <a  href="<?php echo ; ?>" class="text-dark text-decoration-none arrowright"> <i class="fa fa-chevron-right"></i>
    <div class="d-flex justify-content-start y-middle">
      <div class="count-numbers border-right pr-4 pl-2"> <i class="<?php echo $CORE->LAYOUT("captions","icon"); ?>"></i>  </div>
      <h4><?php echo ; ?> </h4>
    </div>
    </a> 
  
  <?php }else{ ?>
  
  <a onclick="SwitchPage('listings');" href="javascript:void(0);" class="text-dark text-decoration-none arrowright"> <i class="fa fa-chevron-right"></i>
    <div class="d-flex justify-content-start y-middle">
      <div class="count-numbers border-right pr-4 pl-2"><?php echo $CORE->USER("count_listings", $userdata->ID); ?></div>
      <h4><?php echo __("View","premiumpress"); ?> <?php echo __("My","premiumpress"); ?> <?php echo $CORE->LAYOUT("captions","2"); ?> </h4>
    </div>
    </a> 
  <?php } ?>
  
  
  
    
    <?php } ?>
    
    
    <?php }else{ ?>
  <a onclick="SwitchPage('orders');" href="javascript:void(0);" class="text-dark text-decoration-none arrowright"> <i class="fa fa-chevron-right"></i>
    <div class="d-flex justify-content-start y-middle">
      <div class="count-numbers border-right pr-4 pl-2"><?php echo $CORE->USER("get_ordertotal", $userdata->ID); ?></div>
      <h4><?php echo __("View","premiumpress"); ?> <?php echo __("My Orders","premiumpress"); ?></h4>
    </div>
    </a> 
    <?php } ?>
    
    </div>
    
    
</div>
<?php if(_ppt(array('lst','onelistingonly')) == 1 && THEME_KEY == "da" && isset($query[0]->ID) ){ ?>
<div class="card shadow-sm border-0 mb-4">
  <div class="card-body">
 
  
  <?php 
  
   $link = get_permalink($query[0]->ID);
  ?>
  
  <a href="<?php echo $link; ?>" class="text-dark text-decoration-none arrowright"> <i class="fa fa-chevron-right"></i>
    <div class="d-flex justify-content-start y-middle">
      <div class="count-numbers border-right pr-4 pl-2"><i class="fal fa-search"></i> </div>
      <h4><?php echo __("View","premiumpress"); ?> <?php echo __("My","premiumpress"); ?> <?php echo $CORE->LAYOUT("captions","1"); ?> </h4>
    </div>
    </a> 
 
</div>
</div>
<?php }elseif( _ppt(array('user','account_messages')) == 1){ ?>

<div class="card shadow-sm border-0 mb-4">
  <div class="card-body"> <a onclick="SwitchPage('messages');" href="javascript:void(0);" class="text-dark text-decoration-none arrowright"> <i class="fa fa-chevron-right"></i>
    <div class="d-flex justify-content-start y-middle">
      <div class="count-numbers border-right pr-4 pl-2"><?php echo $CORE->USER("count_messages", $userdata->ID); ?></div>
      <h4><?php echo __("View","premiumpress"); ?> <?php echo __("Messages","premiumpress"); ?> </h4>
    </div>
    </a>
    </div>
</div>


<?php } ?>


<div class="card shadow-sm border-0 mb-4">
  <div class="card-body">
  
  <?php if(THEME_KEY == "da"){ ?>
  
  
  <a onclick="SwitchPage('membership');" href="javascript:void(0);" class="text-dark text-decoration-none arrowright"> <i class="fa fa-chevron-right"></i>
    <div class="d-flex justify-content-start y-middle">
      <div class="count-numbers border-right pr-4 pl-2"><i class="fal fa-user"></i> </div>
      <h4><?php echo __("My Membership","premiumpress"); ?> </h4>
    </div>
    </a> 
   
  
    <?php }elseif(THEME_KEY == "vt"){ ?>
    <a  href="<?php echo get_author_posts_url( $userdata->ID ); ?>" class="text-dark text-decoration-none arrowright"> <i class="fa fa-chevron-right"></i>
    <div class="d-flex justify-content-start y-middle">
      <div class="count-numbers border-right pr-4 pl-2"><?php echo $CORE->USER("get_subscribers_count", $userdata->ID); ?></div>
      <h4><?php echo __("View","premiumpress"); ?> <?php echo __("My Subscribers","premiumpress"); ?></h4>
    </div>
    </a>
    <?php }elseif($CORE->LAYOUT("captions","offers") != ""){ ?>
    <a onclick="SwitchPage('offers');" href="javascript:void(0);" class="text-dark text-decoration-none arrowright"> <i class="fa fa-chevron-right"></i>
    <div class="d-flex justify-content-start y-middle">
      <div class="count-numbers border-right pr-4 pl-2"><?php echo $CORE->USER("count_offers", $userdata->ID); ?></div>
      <h4><?php echo __("View","premiumpress"); ?> <?php echo $CORE->LAYOUT("captions","offers"); ?></h4>
    </div>
    </a>
    <?php }else{ ?>
    
      <a onclick="SwitchPage('details');" href="javascript:void(0);" class="text-dark text-decoration-none arrowright"> <i class="fa fa-chevron-right"></i>
    <div class="d-flex justify-content-start y-middle">
      <div class="count-numbers border-right pr-4 pl-2"><i class="fal fa-user"></i></div>
      <h4><?php echo __("View","premiumpress"); ?> <?php echo __("My Details","premiumpress"); ?></h4>
    </div>
    </a> 
    
    <?php } ?>
    
  </div>
</div>
 

</div>