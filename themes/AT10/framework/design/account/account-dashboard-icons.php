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
$user_roles = wp_get_current_user()->roles;	

$showmembership = 0;
$showlistings = 0;
$allowmultiple = 0;
$showadminonly = 0;
 
if(_ppt(array('mem','enable')) == "1" ){
$showmembership = 1;
}

if(_ppt(array('lst','websitepackages')) == "1" ){
$showlistings = 1;
}

if(_ppt(array('lst','adminonly')) == "1"){
$showadminonly = 1;
}
 
if(in_array(THEME_KEY, array("cp","vt"))){
$showlistings = 0;
}



if(in_array(THEME_KEY, array("es"))){
		
		// HIDE ADD-LISTINGS FOR MEMBER TYPE
		$ut = get_user_meta($userdata->ID, "user_type", true);
	
		if(!is_numeric($ut)){
			$showlistings = 0;
			
		}elseif($ut == 1){
			$showlistings = 0;
				
		}elseif($ut == 3){ // AGENCY
			$showlistings = 1;	
			$allowmultiple = 1;
							
		}else{		
			$showmembership = 0;
		}
		
}elseif(in_array(THEME_KEY, array("jb","mj","ll"))){
		
		// HIDE ADD-LISTINGS FOR MEMBER TYPE
		$ut = get_user_meta($userdata->ID, "user_type", true);
		
		 
		if($ut == "user_fr"){
		
			//$showlistings = 0;
			$showadminonly = 1;
			
			
		}

}


if($showmembership){

		$mymem = $CORE->USER("get_user_membership", $userdata->ID);
		 
	 	if(isset($mymem['expired']) && $mymem['expired'] == 0){
		
			$mb = __("Active","premiumpress");
			$bgcss = "bg-primary";
			$txtcss = "text-primary";
			$duration_days = _ppt('mem'.$mymem['key'].'_duration');
			
			if(!is_numeric($duration_days)){
			$duration_days = 30;
			}
			
			
			if( !isset($hh['days-left']) || ( isset($hh['days-left']) && !is_numeric($hh['days-left']) ) ){
			$hh['days-left'] = 1;
			}
			 
			$hh = $CORE->date_timediff($mymem['date_expires']);	
			
			if($duration_days == 0){ 
			
			$duration  = 0;
			
			}else{
					
			$duration = $hh['days-left']/$duration_days*100;			 
			
			}
		
		}elseif(isset($mymem['expired']) && $mymem['expired'] == 1){
		
			$mb = __("Expired","premiumpress");
			$bgcss = "bg-danger";
			$txtcss = "text-danger";
			$duration = 0;
		
		}else{ 
			
			$mb = "-"; 
			$bgcss = "bg-danger";
			$txtcss = "text-danger"; 	
			$duration = 0;	
		}
		
		
		if($showlistings && $mb != "-"){
			$bgcss = "bg-secondary";
			$txtcss = "text-secondary"; 
		} 
	 

?>

<div class="col-lg-4 mb-4">
    <div class="radiusx box-effect">
        <div class="card-content">
            <div class="card-body">
                <div class="media d-flex">
                    <div class="align-self-center "> <i
                            class="p-3 ml-2 mr-2 alert-info radiusx fal fa-shield-check fa-1x"></i> </div>
                    <div class="media-body text-left">
                        <h6>
                            <?php if( $CORE->LAYOUT("captions","memberships") && _ppt(array('mem','enable')) != 0 ){ 
			
			$mymem = $CORE->USER("get_user_membership", $userdata->ID);
			 
			 ?>
                            <?php if($mymem == 0){ echo __("None","premiumpress"); }else{ echo $mymem['name']; } ?>
                            <?php } ?>
                        </h6>



                        <?php 
	  
  if( isset($mymem['user_approved']) && $mymem['user_approved'] == "0"){
  
 ?>
                        <span class="inline-flex items-center font-weight-bold order-status-icon status-4"
                            onclick="SwitchPage('membership');" style="cursor:pointer;"> <span class="dot mr-2"></span>
                            <span
                                class="pr-2px leading-relaxed whitespace-no-wrap"><?php echo __("Pending Approval","premiumpress"); ?>
                            </span> </span>


                        <?php }else{ ?>

                        <span>



                            <a href="javascript:void(0)" class="text-dark"
                                onclick="SwitchPage('membership');"><?php echo __("My Membership","premiumpress"); ?>
                            </a></span>

                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-4 mb-4"> <a href="javascript:void(0);" onclick="processUpgrade();"
        class="text-dark text-decoration-none">
        <div class="radiusx box-effect">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center "> <i
                                class="p-3 ml-2 mr-2 alert-info radiusx fal fa-rocket fa-1x"></i> </div>

                        <div class="media-body text-left">
                            <h6 class="mb-0"><?php echo __("Upgrade","premiumpress"); ?></h6>
                            <?php if(isset($mymem['expired']) && $mymem['expired'] == 0){ ?>
                            <span class="tiny"><?php echo $hh['days-left']." ". __("days left","premiumpress");  ?>
                            </span>
                            <?php }else{ ?>
                            <span class="tiny"><?php echo __("expired","premiumpress");  ?></span>
                            <?php } ?>
                            <div class="progress mt-1 mb-0" style="height: 7px;">
                                <div class="progress-bar <?php echo $bgcss; ?>" role="progressbar"
                                    style="width: <?php echo $duration; ?>%" aria-valuenow="<?php echo $duration; ?>"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a> </div>
<?php } ?>


<style>
.box-effect {
    box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;

}

.box-effect:hover {
    box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
}
</style>


<div class="col-lg-4 mb-4 d-none"> <a href="javascript:void(0);" onclick="SwitchPage('details');"
        class="text-dark text-decoration-none">
        <div class="radiusx box-effect bg-white">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center "> <i
                                class="p-3 ml-2 mr-2 alert-info radiusx fas fa-user-circle fa-1x "></i> </div>
                        <div class="media-body text-left">
                            <h6><?php echo __("Account info","premiumpress"); ?></h6>

                            <span
                                class="small opacity-5"><?php echo __("Your account details.","premiumpress"); ?></span>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="col-lg-4 mb-4 d-none"> <a href="javascript:void(0);" onclick="showdetails('password');"
        class="text-dark text-decoration-none">
        <div class="radiusx box-effect bg-white">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center "> <i
                                class="p-3 ml-2 mr-2 alert-info radiusx fas fa-lock fa-1x"></i> </div>
                        <div class="media-body text-left">
                            <h6><?php echo __("Security","premiumpress"); ?></h6>

                            <span class="small opacity-5"><?php echo __("Your credentials","premiumpress"); ?></span>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="col-lg-4 mb-4 d-none"> <a href="javascript:void(0);" onclick="showdetails('username');"
        class="text-dark text-decoration-none">
        <div class="radiusx box-effect bg-white">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center "> <i
                                class="p-3 ml-2 mr-2 alert-info radiusx fas fa-user-shield "></i> </div>
                        <div class="media-body text-left">
                            <h6><?php echo __("Login details","premiumpress"); ?></h6>

                            <span class="small opacity-5"><?php echo __("Your username","premiumpress"); ?></span>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a>
</div>


<div class="col-lg-4 mb-4"> <a href="javascript:void(0);" onclick="showdetails('payment');"
        class="text-dark text-decoration-none">
        <div class="radiusx box-effect bg-white">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center "> <i
                                class="p-3 ml-2 mr-2 alert-info radiusx fas fa-dollar-sign"></i> </div>
                        <div class="media-body text-left">
                            <h6><?php echo __("Billing","premiumpress"); ?></h6>

                            <span
                                class="small opacity-5"><?php echo __("Setup payment methods","premiumpress"); ?></span>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a>
</div>


<div class="col-lg-4 mb-4 d-none"> <a href="javascript:void(0);" onclick="showdetails('notifications');"
        class="text-dark text-decoration-none">
        <div class="radiusx box-effect bg-white">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center "> <i class="p-3 ml-2 mr-2 alert-info radiusx fas fa-bell"></i>
                        </div>
                        <div class="media-body text-left">
                            <h6><?php echo __("Notifications","premiumpress"); ?></h6>

                            <span
                                class="small opacity-5"><?php echo __("Your email notifications","premiumpress"); ?></span>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a>
</div>



<div class="col-lg-4 mb-4 d-none"> <a href="javascript:void(0);" onclick="showdetails('address');"
        class="text-dark text-decoration-none">
        <div class="radiusx box-effect bg-white">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center "> <i class="p-3 ml-2 mr-2 alert-info radiusx fas fa-map"></i>
                        </div>
                        <div class="media-body text-left">
                            <h6><?php echo __("Address","premiumpress"); ?></h6>

                            <span class="small opacity-5"><?php echo __("Your Address","premiumpress"); ?></span>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="col-lg-4 mb-4"> <a href="javascript:void(0);" onclick="SwitchPage('messages');"
        class="text-dark text-decoration-none">
        <div class="radiusx box-effect bg-white">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center "> <i class="p-3 ml-2 mr-2 alert-info radiusx fas fa-comment"></i>
                        </div>
                        <div class="media-body text-left">
                            <h6><?php echo __("Messenger","premiumpress"); ?></h6>

                            <span class="small opacity-5"><?php echo __("Your Messages","premiumpress"); ?></span>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="col-lg-4 mb-4"> <a href="javascript:void(0);" onclick="SwitchPage('orders');"
        class="text-dark text-decoration-none">
        <div class="radiusx box-effect bg-white">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center "> <i
                                class="p-3 ml-2 mr-2 alert-info radiusx fas fa-file-invoice"></i> </div>
                        <div class="media-body text-left">
                            <h6><?php echo __("Invoices","premiumpress"); ?></h6>

                            <span
                                class="small opacity-5"><?php echo __("Your All Transactions","premiumpress"); ?></span>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a>
</div>



<?php if($showlistings && !in_array(THEME_KEY, array("da")) ){ ?>


<?php if($CORE->LAYOUT("captions","offers") != ""){ ?>
<div class="col-lg-4 mb-4"><a href="javascript:void(0);" onclick="SwitchPage('offers');"
        class="text-dark text-decoration-none">
        <div class="radiusx box-effect bg-white">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">

                        <div class="align-self-center "> <i
                                class="p-3 ml-2 mr-2 alert-info radiusx fal <?php echo $CORE->LAYOUT("captions","icon-offer"); ?> fa-1x"></i>
                        </div>

                        <div class="media-body text-left">
                            <h6><?php
			
			 
	switch(THEME_KEY){
	  	 
		
		case "mj":
	  	case "at": {
				
		echo __("My Bids","premiumpress"); 
		
		} break;
		
		default: {
		
		echo $CORE->LAYOUT("captions","offers");
		 
		
		} break;
		
	}
	
	 ?></h6>

                            <?php if(in_array(THEME_KEY, array("mj","at","ct","dl"))){ ?>

                            <span class="badge badge-light" id="icons-count-all-offers"> <span
                                    class="count-all-offers"></span> <span
                                    class="tt"><?php echo __("items","premiumpress");   ?></span></span>

                            <?php if(  in_array('subscriber', $user_roles) || in_array('customer', $user_roles)  ){}else{ ?>
                            <span class=" badge-success badge" id="icons-count-all-my-offers" style="display:none;">
                                <span class="count-all-my-offers">0</span>
                                <?php  echo __("selling","premiumpress");  ?></span> </span>
                            <?php } ?>

                            <?php }else{ ?>
                            <span class="badge badge-primary" id="icons-count-all-offers"> <span
                                    class="count-all-offers"></span> <?php echo __("items","premiumpress");   ?></span>

                            <?php } ?>



                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
<?php } ?>

<?php if( $showadminonly || in_array(_ppt(array('user','favs')), array("","1"))){  ?>

<div class="col-lg-4 mb-4"> <a href="<?php echo home_url()."/?s=&favs=1"; ?>" class="text-dark text-decoration-none">
        <div class="radiusx box-effect bg-white">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center "> <i
                                class="p-3 ml-2 mr-2 alert-info radiusx fal fa-heart fa-1x"></i> </div>

                        <div class="media-body text-left">
                            <h6> <?php
			
			 
	switch(THEME_KEY){
	  
	  	case "at": {
		
		echo __("Watchlist","premiumpress"); 
		
		} break;
		
		default: {
		
		echo __("MY FAVORITES","premiumpress"); 
		
		} break;
		
	}
	
	 ?> </h6>


                            <span
                                class="badge badge-default"><?php echo number_format($CORE->USER("favs_count", $userdata->ID)); ?>
                                <?php echo __("items","premiumpress"); ?></span>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a> </div>

<?php }   ?>

<div class="col-lg-4 mb-4 none"> <a href="javascript:void(0);" onclick="SwitchPage('details');"
        class="text-dark text-decoration-none">
        <div class="radiusx bg-white box-effect">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center "> <i
                                class="p-3 ml-2 mr-2 alert-info radiusx fal fa-user fa-1x"></i> </div>
                        <div class="media-body text-left">
                            <h6><?php echo __("My Setting","premiumpress"); ?></h6>

                            <span
                                class="small opacity-5"><?php echo __("Edit your account details.","premiumpress"); ?></span>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a>
</div>



<?php  ?>



<?php if(  in_array('subscriber', $user_roles) || in_array('customer', $user_roles)  ){ ?>
<div class="col-lg-4 mb-4"></div>



<?php
}else{ ?>

<div class="col-lg-4 mb-4"> <a href="javascript:void(0);" onclick="SwitchPage('listings');"
        class="text-dark text-decoration-none" id="listingsswitchbtn">
        <div class="radiusx box-effect bg-white">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center "> <i
                                class="p-3 ml-2 mr-2 alert-info radiusx fal <?php echo $CORE->LAYOUT("captions","icon"); ?> fa-1x"></i>
                        </div>
                        <div class="media-body text-left">
                            <h6><?php
			
			 
	switch(THEME_KEY){
	   
		
		default: {
		
		echo __("Dealer Inventory","premiumpress");
		
		} break;
		
	}
	
	 ?></h6>


                            <span class="badge badge-light"><span class="count-status-all mr-2">0</span>
                                <?php echo __("items","premiumpress"); ?></span>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </a>

    <script>
    function showoffersslow(type) {

        jQuery('.showoffers-' + type + '-btn').trigger('click');

    }
    </script>


</div>

<?php } ?>

<?php } ?>





<?php 

 
 
if( $showadminonly){
 
// SINGLE LISTING
$singleListingLink = "";
$data = array();
if(_ppt(array('lst','onelistingonly')) == 1 && $allowmultiple == 0 ){  //&& !$CORE->USER("membership_hasaccess", "listings_multiple")  
  
	$SQL = "SELECT DISTINCT ".$wpdb->posts.".ID FROM ".$wpdb->posts." WHERE post_type = 'listing_type' AND post_status = 'publish' AND post_author = ('".$userdata->ID."') LIMIT 1";				 
   	$query = $wpdb->get_results($SQL, OBJECT);
   	if(!empty($query)){		
		
		$singleListingLink = get_permalink($query[0]->ID);
		
		
		$ggl = _ppt(array('links','add'))."/?eid=".$query[0]->ID;
		
		if(_ppt(array('user','edit_listing_link')) == "2"){
		$ggl = $singleListingLink;
		}
	 
	
		$data[1] = array(	 		
			"key" 	=> "listings",
			"link" => $ggl, 
			"title" => __("Edit My","premiumpress")." ".$CORE->LAYOUT("captions","1"),			
			"desc" 	=> str_replace("%s", $CORE->LAYOUT("captions","1") , __("Here you can edit your existing %s.","premiumpress")),			
			"icon" 	=> $CORE->LAYOUT("captions","icon"),	
		);
		
		/*
			$data[2] = array(	 		
			"key" 	=> "view",
			"link" => $singleListingLink,
			"title" => __("View My","premiumpress")." ".$CORE->LAYOUT("captions","1"),			
			"desc" 	=> str_replace("%s", $CORE->LAYOUT("captions","1") , __("Here you can view your website %s.","premiumpress")),			
			"icon" 	=> "fal fa-search",	
		);
		*/	
		
	}else{
	
		$singleListingLink = _ppt(array('links','add'));
	
		$data[1] = array(	 		
			"key" 	=> "listings",
			"link" => _ppt(array('links','add')),
			"title" => __("Edit My","premiumpress")." ".$CORE->LAYOUT("captions","2"),			
			"desc" 	=> str_replace("%s", $CORE->LAYOUT("captions","1") , __("Here you can edit your existing %s.","premiumpress")),			
			"icon" 	=> $CORE->LAYOUT("captions","icon"),	
		);
		 
	
	
	}
}else{

$singleListingLink = _ppt(array('links','add'));
	
		$data[1] = array(	 		
			"key" 	=> "listings",
			"link" => "",
			"title" => __("Edit My","premiumpress")." ".$CORE->LAYOUT("captions","2"),			
			"desc" 	=> str_replace("%s", $CORE->LAYOUT("captions","1") , __("Here you can edit your existing %s.","premiumpress")),			
			"icon" 	=> $CORE->LAYOUT("captions","icon"),	
		);

}
 
?>
<div class="col-sm-12 mb-4 ">
    <div class="card mb-4 bg-primary">
        <div class="card-body"> <a <?php if($data[1]['link'] == ""){ ?>href="javascript:void(0)"
                onclick="SwitchPage('<?php echo $data[1]['key']; ?>');" <?php }else{ ?>
                href="<?php echo $data[1]['link']; ?>" <?php } ?> class="text-white text-decoration-none">
                <div class="media align-items-center">
                    <div class="media-body mr-3 "> <i
                            class="fal fa-pencil fa-3x mt-2 pb-2 float-left mr-3 pr-3 ml-3 hide-mobile"></i>
                        <h3 class="num-text"><?php echo $data[1]['title']; ?></h3>
                        <span class="fs-14"> <?php echo $data[1]['desc']; ?> </span>
                    </div>
                    <?php if($CORE->GEO("is_right_to_left", array() )){  }else{ ?>
                    <i class="fal fa-chevron-right fa-3x"></i>
                    <?php } ?>

                </div>
        </div>
        </a>
    </div>
    <?php if($data[1]['link'] == ""){ }else{ ?>
    <script>
    jQuery(document).ready(function() {

        jQuery("#listingsswitchbtn").prop("onclick", null).off("click");

        jQuery("#listingsswitchbtn").attr('href', "<?php echo $data[1]['link']; ?>");
        jQuery("#listingsswitchbtn .count-status-all").removeClass('count-status-all').html("1");


    });
    </script>
    <?php } ?>

</div>
<?php 
 
} 


?>