<?php

define('THEME_NAME','Auction Theme');
define('THEME_FOLDER','_auction');
define('THEME_KEY','at');
 
$CORE_AUCTION	= new auctiontheme;

// start shoppig cart class
class auctiontheme  { 

	function __construct(){ global $CORE;
 	
 
		// REGISTER TAXONOMIES	
		$tax = array("condition","features","color","size","brand","refunds");
		
		foreach($tax as $t){
		
			register_taxonomy( $t, THEME_TAXONOMY.'_type', array( 'hierarchical' => true, 'labels' => array('name' => $t) , 
			'query_var' => true, 'rewrite' => true, 'rewrite' => array('slug' => $t) ) ); 
			
		}	
		
		// USER END FIELDS
		add_action('hook_add_fieldlist',  array($this, '_hook_customfields' ) );
		 
		// SHORTCODES 
		add_shortcode( 'BIDS', array($this,'shortcode_bids') );
		add_shortcode( 'PRICE', array($this,'shortcode_auction_price') );
		add_shortcode( 'TIMER', array($this,'shortcode_auction_timer') );
		add_shortcode( 'STATUS', array($this,'shortcode_auction_status') );
		add_shortcode( 'USER-ITEMSOLD',  array($this, 'ppt_shortcode_itemsold' ) );
		
		add_shortcode( 'REFUNDS', array($this,'shortcode_refunds') );
	  	add_shortcode( 'CONDITION', array($this,'shortcode_condition') );
		add_shortcode( 'SHIPPING', array($this,'shortcode_shipping') );
		add_shortcode( 'RESERVE', array($this,'shortcode_reserve') ); 
		
		// handle form actions
		add_action('wp_head', array($this,'_wp_head'));
 	 	add_action('init', array($this,'ajax_actions'));
 		
	}  
	
	function shortcode_shipping( $atts, $content = null ) {
	
		global $post;  
		 
		$r = get_post_meta($post->ID, 'price_shipping', true);
		
		if(is_numeric($r) && $r > 0){ 
		
			return  hook_price($r); 
		
		}else{ 
		
			return __( 'Free Shipping', 'premiumpress' ); 
		
		}			 
		
	}	
	
	function shortcode_reserve( $atts, $content = null ) {
	
		global $post;  
		 
		$r = get_post_meta($post->ID, 'price_reserve', true);
		
		if(is_numeric($r) && $r > 0){ 
		
			return  __( 'Has Reserve', 'premiumpress' ); 
		
		}else{ 
		
			return __( 'No Reserve', 'premiumpress' ); 
		
		}			 
		
	}	
	function shortcode_refunds( $atts, $content = null ) {
	
		global $post;  
		 
		$r = get_post_meta($post->ID, 'refunds', true);
		
		if($r == 1){ 
		
			return  __( 'Yes', 'premiumpress' ); 
		
		}else{ 
		
			return __( 'No', 'premiumpress' ); 
		
		}			 
		
	}	
	function shortcode_condition( $atts, $content = null ) {
	
		global $post, $CORE;
		 
		$t = "";
		$cl = $CORE->_language_current();
		
		$cats = get_the_terms( $post->ID, 'condition');
		  
		if(_ppt(array('lang','switch')) == 1 && $cl != "en_US"){
		 		
			if(isset($cats[0])){
			 
				$t = $CORE->GEO("translation_tax", array($cats[0]->term_id, $cats[0]->name));		 
				
			}else{
			
				$t = get_the_term_list( $post->ID, 'condition', "", ', ', '' );
			}
			
		
		}elseif(is_array($cats)){
		
			 foreach($cats as $c){
			 
			 	$t = $c->name;
			 }
		
		}
		 
		return $t;
		 		 
		
	}	
	
	
	
	
	function ppt_shortcode_itemsold ( $atts = "", $content = null ) { global $userdata, $CORE, $wpdb, $post; $STRING = "";  
 	
	   	extract( shortcode_atts( array(  'xxxxxxxx' => ''), $atts ) );		
		
		if(!$userdata->ID){ return 0; }
		
		$SQL = "SELECT count(*) AS total FROM ".$wpdb->prefix."posts 
		INNER JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id AND mt2.meta_key='status' AND mt2.meta_value='1') 
		WHERE ".$wpdb->prefix."posts.post_type = '".THEME_TAXONOMY."_type' 
		AND ".$wpdb->prefix."posts.post_status = 'publish' 
		AND ".$wpdb->prefix."posts.post_author = '".$userdata->ID."'
		GROUP BY ".$wpdb->prefix."posts.ID";		
		 
		$tt = $wpdb->get_results($SQL);
		
		 
		if(empty($tt)){
			return 0;
		}
		
		return $tt[0]->total;
		
	
	}	
	
	
	
	
	/*
		shortcode to display bids
	*/
	function shortcode_bids(){ global $CORE, $post, $wpdb;
	
		$bidding_history = get_post_meta($post->ID,'current_bid_data',true);
		if(is_array($bidding_history) && !empty($bidding_history) ){
			return count($bidding_history);
		}else{
			return 0;
		}	
	
	}
	
	
	
function account_status_show($postid){ global $CORE, $CORE_AUCTION;

	$text = "";
	
	//1. GET EXPIRY DATE	 
	$expiry_date = get_post_meta($postid, 'listing_expiry_date', true);

if (!empty($expiry_date)) {
  $expiry_date = strtotime($expiry_date);
  $new_expiry_date = date('Y-m-d H:i:s', $expiry_date + 30);
  
  $vv = $CORE->date_timediff($new_expiry_date);
}
	if($vv['expired'] == 1){
	
		$hbid = $CORE_AUCTION->_get_winner($postid); 
		if($hbid['reserve_met'] == "yes"){ 
				
			$text = "<span class='badge badge-success'>".__("Item Sold","premiumpress")."</span>";
		
		}elseif($hbid['reserve_met'] != "yes"){ 
		
			$text = "<span class='badge badge-info'>".__("Reserve Not Me","premiumpress")."</span>";
		
		}else{
		
			$text = "<span class='badge badge-warning'>".__("Not Sold","premiumpress")."</span>";			
		}  
	
	
	}else{
	
	$text = do_shortcode('[TIMELEFT postid="'.$postid.'" layout="1" text_before="" text_ended="Not Set" key="listing_expiry_date"]');
	
	}
	
	return $text;


}


function account_can_repost($postid){ global $CORE, $CORE_AUCTION;

	$text = "";
	
	//1. GET EXPIRY DATE	 
	$expiry_date = get_post_meta($postid, 'listing_expiry_date', true);

if (!empty($expiry_date)) {
  $expiry_date = strtotime($expiry_date);
  $new_expiry_date = date('Y-m-d H:i:s', $expiry_date + 30);
  
  $vv = $CORE->date_timediff($new_expiry_date);
}

	if($vv['expired'] == 1){
	
		$hbid = $CORE_AUCTION->_get_winner($postid); 
		if($hbid['reserve_met'] == "yes"){ 
				
			return 0;
		
		}elseif($hbid['reserve_met'] != "yes"){ 
		
			return 1;
		
		}else{
		
			return 1;		
		}  
	
	
	}else{
	
	return 0;
	
	}
	
	return $text;


}
	
	
	
	
	/*
		shortcode to display timer
	*/
	function shortcode_auction_status( $atts, $content = null ) { global $userdata, $CORE_AUCTION, $wpdb, $CORE, $post;

	extract( shortcode_atts( array( 'post_id' => $post->ID ), $atts ) );
	
	//1. GET EXPIRY DATE
	$expiry_date = get_post_meta($post_id,'listing_expiry_date',true);
	$new_expiry_date = date("Y-m-d H:i:s", strtotime($expiry_date . " +30 seconds") );
	
	$vv = $CORE->date_timediff($new_expiry_date);
	 
	ob_start();
	if($vv['expired'] == 1){ 
	$hbid = $CORE_AUCTION->_get_winner($post_id); 
	if($hbid['userid'] == $userdata->ID && $hbid['reserve_met'] == "yes"){ 
	?><span class="badge badge-success"><?php echo __("You Won","premiumpress") ?></span><?php 
	
	}elseif($hbid['reserve_met'] != "yes"){ ?><span class="badge badge-info"><?php echo __("Reserve Not Me","premiumpress") ?></span><?php 
	
	}else{ ?><span class="badge badge-secondary"><?php echo __("Ended","premiumpress") ?></span><?php } 
	
	}else{ echo __("Active ","premiumpress"); } 
	
	return ob_get_clean();
	
	}
	/*
		shortcode to display timer
	*/
	function shortcode_auction_timer( $atts, $content = null ) { global $userdata, $CORE_AUCTION, $wpdb, $CORE, $post;

	extract( shortcode_atts( array( 'layout' => "", "pid" => $post->ID, "finished_class" => ""  ), $atts ) );
	
	$auction_ended = false; 
	$eclass = "";
	// elementor preview
	if( isset($_REQUEST['action']) || isset($_REQUEST['preview_id']) || isset($_REQUEST['elementor_library']) ){
		
		return '10 hrs';
	 
	}else{
	
		//1. GET EXPIRY DATE
		$expiry_date = get_post_meta($pid,'listing_expiry_date',true);
		$new_expiry_date = date("Y-m-d H:i:s", strtotime($expiry_date . " +30 seconds") );
		
		$vv = $CORE->date_timediff($new_expiry_date);
		
		if(   $new_expiry_date == "" || $vv['expired'] == 1 ){
			$auction_ended = true; 
			$eclass = "auction-sold";	
			// GET WINNER
			$hbid = $CORE_AUCTION->_get_winner($pid);
	
		}
	 
	}
	
	if(!$auction_ended){  ?>
      <div class="countdowntimer">
      <span 
         data-ppt-countdown="<?php echo $new_expiry_date; ?>" 
         data-postid="<?php echo $pid; ?>" 
         data-expire="ajax_expire_auction" 
         data-timezone="<?php echo get_option('gmt_offset'); ?>" 
         <?php if($layout != ""){ ?>
         data-layout="<?php echo $layout; ?>"
         <?php } ?>
         data-ontick="ajax_ontick_auction"></span>
          </div>
      <?php }elseif($hbid['reserve_met'] == "no" ){ ?>
      <span class="finished didnotsell <?php echo $finished_class; ?>"><?php echo __("Did Not Sell","premiumpress"); ?></span>
      <?php }elseif($hbid['user'] != "nowinner" && $hbid['reserve_met'] == "yes" ){ ?>
      <span class="finished itemsold <?php echo $finished_class; ?>"><?php echo __("Item Sold","premiumpress"); ?></span>
      <?php }else{ ?>
      <span class="finished auctionend <?php echo $finished_class; ?>"><?php echo __("Auction Ended","premiumpress"); ?></span>
      <?php } ?>		
<?php 
	
	}
	
	/*
		shortcode to display price
	*/
	function shortcode_auction_price(){ global $CORE, $post, $wpdb;
	
		$price = get_post_meta($post->ID,'price_current',true);
		
		if($price == "" || $price == 0){
			
			$price_bin = get_post_meta($post->ID,'price_bin',true);
			if($price_bin != ""){
			$price  = $price_bin;
			}
			
		}
		
		return hook_price($price);
	
	}
	
	/*
		this function adds new fields
		to the submission form
	*/
	function _hook_customfields($c){ global $CORE;

		$o = 50;
		
		$canEditPrice = true;
		if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ 
		
			// CHECK FOR BIDDING SO WE CAN DISABLE FIELDS
			$current_bidding_data = get_post_meta($_GET['eid'],'current_bid_data',true); 
			if(is_array($current_bidding_data) && !empty($current_bidding_data) ){ $canEditPrice = false; }
			  
		}
		
		if(is_admin()){		
		$canEditPrice = true;
		}
		
		 
		
		if($canEditPrice){ 
		
		
		if(_ppt(array('lst', 'at_buynow' )) == '0'){
		
			$c[$o]['title'] 	= __("Auction Type","premiumpress");
			$c[$o]['name'] 		= "offertype";
			$c[$o]['type'] 		= "hidden";
			$c[$o]['class'] 	= "form-control";
			$c[$o]['values'] 	= 1;
			$o++;
			
		}else{
		 
		
			$c[$o]['title'] 	= __("Auction Type","premiumpress");
			$c[$o]['name'] 		= "auction_type";
			$c[$o]['type'] 		= "select";
			$c[$o]['class'] 	= "form-control";
			$c[$o]['listvalues'] 	= array(
			"1" => __("Normal Auction","premiumpress"), 
			"2" => __("Classifieds (Buy Now Only)","premiumpress"), 
			);
			$c[$o]['help'] 		= __("Here you can choose the format of your auction.","premiumpress")." <script> 
			function ChangeAuctionDisplayFields(){ 
		 
				if(jQuery('#field-auction_type').val() == '2'){ 
					jQuery('#form-row-rapper-price_current').hide(); 
					jQuery('#form-row-rapper-price_reserve').hide(); 
					jQuery('#field-price_current').val('0');
				} else { 
					jQuery('#form-row-rapper-price_reserve').show();  
					jQuery('#form-row-rapper-price_current').show(); 
				}
			}
			
			jQuery(document).ready(function(){ jQuery('#field-auction_type').change(function(e) { ChangeAuctionDisplayFields(); }); ChangeAuctionDisplayFields();  });
			</script> ";
		 
			//$c[$o]['required'] 	= true;
			$c[$o]['defaultvalue'] 	= "0";		
			
			}
		
		$o++;
		}
		
		
		if(_ppt(array('lst','auction_time')) != '1' && $canEditPrice && !isset($_GET['eid']) ){ 
		
		
		$att = array(
		
		"0.5" => __("30 Minutes","premiumpress"),
		"0.1" => __("1 Hour","premiumpress"),
		"1" => "1 ".__("Day","premiumpress"), 
		"3" => "3 ".__("Days","premiumpress"), 
		"5" => "5 ".__("Days","premiumpress"), 
		"7" => "7 ".__("Days","premiumpress"), 
		"14" => "14 ".__("Days","premiumpress"), 
		"21" => "21 ".__("Days","premiumpress"), 
		"30" => "30 ".__("Days","premiumpress"),
		"60" => "60 ".__("Days","premiumpress"),
		"90" => "90 ".__("Days","premiumpress"),
		"120" => "120 ".__("Days","premiumpress"),
		"150" => "150 ".__("Days","premiumpress"),
		"180" => "180 ".__("Days","premiumpress"),
		
		
		);
		
		$newa = array();
		foreach($att as $k => $f ){ 
		
			if(in_array(_ppt("auctiontime_".str_replace(".","",$k)) , array("","1")) ){
			
				$newa[$k] = $f;
			
			}
		}
		
		$c[$o]['title'] 	= __("Auction Length","premiumpress");
		$c[$o]['name'] 		= "listing_expiry_days";
		$c[$o]['type'] 		= "select";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['listvalues'] 	= $newa;
		
		$c[$o]['help'] 		= __("Select the number of days you would like the auction to run for.","premiumpress");
		$c[$o]['required'] 	= true;
		$o++;
		
		}

		
		if($canEditPrice){
		$c[$o]['title'] 	= __("Starting Price","premiumpress");
		$c[$o]['name'] 		= "price_current";
		$c[$o]['type'] 		= "price";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['help'] 		= __("This is the price the bidding will start at.","premiumpress");
		$c[$o]['required'] 	= true;	
		$c[$o]['defaultvalue'] 	= "0";	
		$o++;
		}
 
		
		if($canEditPrice){
		$c[$o]['title'] 	= __("Buy Now Price","premiumpress");
		$c[$o]['name'] 		= "price_bin";
		$c[$o]['type'] 		= "price";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['help'] 		= __("Here you can set a price for the user to buy this item outright.","premiumpress");
		//$c[$o]['required'] 	= true;
		$c[$o]['defaultvalue'] 	= "0";
		$o++;
		}
		
		if(_ppt(array('design','display_reserve')) == '1' && $canEditPrice){
		
		$c[$o]['title'] 	= __("Reserve Price","premiumpress");
		$c[$o]['name'] 		= "price_reserve";
		$c[$o]['type'] 		= "price";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['help'] 		= __("Here you can set the lowest price your willing to sell this item for.","premiumpress");
		$c[$o]['defaultvalue'] 	= "0";	
		$o++;
		
		}
		
		 
		if(_ppt(array('design','display_shipping')) == '1' && $canEditPrice){ 
		
		$c[$o]['title'] 	= __("Shipping Price","premiumpress");
		$c[$o]['name'] 		= "price_shipping";
		$c[$o]['type'] 		= "price";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['help'] 		= __("Here you enter an amount for shipping this item.","premiumpress");
		//$c[$o]['required'] 	= true;	
		$c[$o]['defaultvalue'] 	= "0";	
		$o++; 
		
		} 
		
		if(_ppt(array('design','display_delivery')) == '1' && $canEditPrice){ 
		
		$c[$o]['title'] 	= __("Delivery","premiumpress");
		$c[$o]['name'] 		= "delivery";
		$c[$o]['type'] 		= "select";
		$c[$o]['class'] 	= "form-control";		
		$c[$o]['listvalues'] = array(0 => __( 'Shipping from my location', 'premiumpress' ), 1 => __( 'Pickup Only', 'premiumpress' ) );
		$o++;
		
		}
		 
 
		
		return $c;
		
	}
	














function get_highest_bidder($postid){

		// GET CURRENY BID HISTORY
		$history = get_post_meta($postid,'current_bid_data',true);
		
		if(!is_array($history)){ 		
		return false;
		}
		
		// SORT BY DATE
		uksort($history,  array($this, "order_bidhiustory_bykey") );
		$history = array_reverse($history, true);
		
		$i=1;
		foreach($history as $maxbid => $data){ 						 	
						
			if($i == 1 && $data['amount'] > 0 ){ // this is the current highest bidder			
				return $data;				
			}
		
		}				

}





	/*
	This function refreshes bids to see if new ones
	have been entered set by the max bid and not updated
	*/
	function refresh_bids($postid){
	 		
		//1. GET USER META		
		$maxbid = get_post_meta($postid,'user_maxbid_data',true);
		$maxbid_backup = $maxbid;
		if(!is_array($maxbid)){ return; }
		
		// REVERSE ORDER BY MAX AMOUNT
		usort($maxbid, array($this, 'sortByOrder') );		
		$maxbid = array_reverse($maxbid);
		
		// WORK OUT DIFFERNECE IN PRICE
		if(isset($maxbid['1']['max_amount']) && ( $maxbid['0']['max_amount'] > $maxbid['1']['max_amount'] ) ){
		
			if(_ppt(array('lst','at_bidinc')) == ""){
			$MXT = $maxbid['1']['max_amount']+10;	
			}else{
			$MXT = ($maxbid['1']['max_amount']) + _ppt(array('lst','at_bidinc'));
			}
			 
			
					 
		}else{
		return; // stop since there is no competative bid
		} 
		 
		//2. GET CURRENT PRICE
		$current_price = get_post_meta($postid,'price_current',true);
		if($current_price == "" || !is_numeric($current_price)  ){ return; }		
		if($MXT < $current_price || $current_price == $MXT){ return; }
		
		foreach($maxbid_backup as $userid => $mb){
		 	
			// THE ARRAY KEYS ARE BROKEN FROM THE USORT
			// SO MATCH BY PRICE ONLY
			if($mb['max_amount'] !=  $maxbid['0']['max_amount']){ continue; }
			 
				//1. ADD BID
				$outbid = $this->_add_bid($postid, $userid, $MXT, "final",  "maxbid2"); 
				
				update_post_meta($postid,'price_current', hook_price_save($MXT)); 
				 
								
				// EMAIL THE OLD BIDDER TO LET THEM KNOW
				// THERE IS A NEW BID
				$this->_email_bidders($postid,"newbid");
								
				// INCREASE TIMER BY 30 SECONDS
				$expiry_date = get_post_meta($postid,'listing_expiry_date',true);					
				$expiry_date = date("Y-m-d H:i:s", strtotime( $expiry_date . " +30 seconds") );					
				update_post_meta($postid,'listing_expiry_date', $expiry_date );
			 
		}		 
		
		return false;	
	
	
	}

	/*
		this function gets the bidding history
		for an auction
	*/
	function bidding_history($postid, $jason = false){

			// GET HIGEST BIDDER
					$hname = "";$hid = "";
					$hbid = $this->_get_winner($postid); $hphoto = "";
			 					
					if(is_array($hbid) && isset($hbid['userid']) ){
					
					$hname = $hbid['user']; $hid = $hbid['userid']; 
					$hphoto = get_avatar( $hbid['userid'], 20 );
					
					}else{
					
					$hname = "nobidders";
					$hphoto = "nobidders";
					}
					
					// GET BID HISTORY
					$bidding_history = get_post_meta($postid,'current_bid_data',true);					
					if(!is_array($bidding_history)){ $bidding_history = array(); }
					
					// START OUTPUT
					ob_start();
						
					// LOOP LIST		 
					if(is_array($bidding_history) && !empty($bidding_history) ){ 
					
						// SORT BY DATE
						uksort($bidding_history,  array($this, "order_bidhiustory_bykey") );
				 
						$bidding_history = array_reverse($bidding_history, true);					
					
						if(is_admin()){
						?> 
						
					   <table class="table">
						  
							<?php  foreach($bidding_history as $date => $bhistory){  ?>
								
						<tbody id="deletebid<?php echo $date; ?>">
						<tr>
						 
						  <td><a href="<?php echo get_author_posts_url( $bhistory['userid'] ); ?>"><?php echo $bhistory['user']; ?> (<?php echo $bhistory['userid']; ?>) </a> </td>
						  <td><?php echo hook_price($bhistory['amount']); ?></td>
						  <td><?php echo $bhistory['bid_type']; ?> </td>
                          
                          <?php if( current_user_can('administrator') ){ ?>
                          <td><a href="javascript:void(0);" onclick="auction_deletebid('<?php echo $date; ?>');"><i class="fa fa-times"></i> </td>
                          
                          <?php } ?>
                          
						</tr>
						</tbody>
						
                        <?php   } ?>
								
							</table>
                            
                        <?php }else{ ?>						
						
							<?php $c=1; foreach($bidding_history as $date => $bhistory){  ?>
                            <div class="row small">
                            <div class="col-1">
                            <span class="badge badge-primary"><?php echo $c; ?></span>
                            </div>
                            <div class="col-5">
                            <a href="<?php echo get_author_posts_url( $bhistory['userid'] ); ?>"><?php echo $bhistory['user']; ?></a>
                            </div>
                            <div class="col-5 text-right">
                            <?php echo hook_price($bhistory['amount']); ?>
                            </div>
                            </div>
                            <?php $c++; } ?>
                        
                        <?php } ?>
                        
                        
							
					 <?php }else{ ?>
						
						 <!-- No bidding history recorded -->
						
				   <?php } 
				   	
					// END OUTPUT
					$SavedContent = ob_get_clean(); 
 			 
					// BUILD ARRAY 
					$NARRAY = array("total" => count($bidding_history), "data" => trim($SavedContent), "bidder_high_link" => get_author_posts_url($hid), "bidder_high_id" => $hid, "bidder_high_name" => $hname, "bidder_high_photo" => $hphoto );
					
					if($jason){
					return json_encode($NARRAY);
					}else{
					return $NARRAY;
					}
	
}
	
	
	/*
		this functon handles the ajax
		actions
	*/
	function order_bidhiustory_bykey($a, $b) {    if ($a == $b) $r = 0;    else $r = ($a > $b) ? 1: -1; return $r;}

	 
	
	/*
		This function deals with the auction when its finished
	*/
	function _end_auction($postid){ global $CORE, $post; $item_status = "";
	  
		
		// CHECK WE HAVE BIDDERS
		$hbid = $this->_get_winner($postid);		
		
		// ADD LOG
		$CORE->FUNC("add_log",
			array(				 
				"type" 			=> "at_auction_ended",								
				"postid"		=> $postid,							
				"to" 			=> get_post_field( 'post_author', $postid ), 						
				"from" 			=> 0,							
				"alert_uid1" 	=> get_post_field( 'post_author', $postid ),								
						
			)
		);
		
		// UPDATE POST STATUS
		$my_post = array();
		$my_post['ID'] 					= $postid;
		$my_post['post_status']			= "expired";
		wp_update_post( $my_post );	
	 		
	 	
		//1. NO BIDDERS AT ALL
		//------------------------
		if($hbid['user'] == "nobidders"){	
			
			// ITEM STATUS
			$item_status = __("Unsold","premiumpress");	
		  
			// ADD LOG			 
			//$CORE->ADDLOG("Auction Ended", 0, $postid, 'no bidders', "auctionend", get_the_title($postid) );
		 	 
			// CHECK FOR AUTO RELIST SO WE CAN RESET THEME DATA			
			if( _ppt('autolist') == 1){
			
				$this->_relist_auction($postid);
			 
			}else{
				
				// COMPLETELY END AUCTION
				// Get the current listing expiry date
$expiry_date = get_post_meta($postid, 'listing_expiry_date', true);

// Check if the expiry date is set
if (!empty($expiry_date)) {
  // Calculate the new expiry date by adding 30 seconds
  $new_expiry_date = date('Y-m-d H:i:s', strtotime($expiry_date) + 30);

  // Update the listing_expiry_date meta value
  update_post_meta($postid, 'listing_expiry_date', $new_expiry_date);

  // Update the auction_ended meta value
  update_post_meta($postid, 'auction_ended', current_time('mysql'));
}

				 
				
			}
 	
		//2. HAS BIDDERS BUT NOT MET RESERVE
		//------------------------------------
		}elseif($hbid['user'] != "nobidders" && $hbid['reserve_met'] == "no"){	


			// ITEM STATUS
			$item_status = __("Reserve not met","premiumpress");	
		
			// ADD LOG			 
			//$CORE->ADDLOG("Auction Ended", 0, $postid, 'reserve not met', "auctionend", get_the_title($postid) );
			
			// CHECK IF WE HAVE A USER THAT HAS A MAX BID
			// THAT REACHES THE RESERVE PRICE
			$has_maxbid = $this->_user_has_maxbid($postid);
			if(isset($has_maxbid['max_amount'])){
				
				// CHECK AGAIN
				$reserve_price = get_post_meta($postid,'price_reserve',true);
		 		if($reserve_price > 0 && $has_maxbid['max_amount'] >= $reserve_price){
				
					$this->_add_bid($postid, $has_maxbid['userid'], $reserve_price, "final",  "maxbid-end");					
				 	
					// redo end AUCTION
					$this->_end_auction($postid);
				}
			 
			}
			
			// SEND EMAIL
			 
			// CHECK FOR AUTO RELIST SO WE CAN RESET THEME DATA			
			if( _ppt('autolist') == 1){
			
				$this->_relist_auction($postid);
			
			}else{
			
				// SET PRICE BACK TO STARTING PRICE
				//$price_starting = get_post_meta($postid,'price_starting', true);
				//if($price_starting == ""){ $price_starting = 0; }				
				//update_post_meta($postid,'price_current', hook_price_save($price_starting));
				
				// COMPLETELY END AUCTION
				// Get the current listing expiry date
$expiry_date = get_post_meta($postid, 'listing_expiry_date', true);

// Check if the expiry date is set
if (!empty($expiry_date)) {
  // Calculate the new expiry date by adding 30 seconds
  $new_expiry_date = date('Y-m-d H:i:s', strtotime($expiry_date) + 30);

  // Update the listing_expiry_date meta value
  update_post_meta($postid, 'listing_expiry_date', $new_expiry_date);

  // Update the auction_ended meta value
  update_post_meta($postid, 'auction_ended', current_time('mysql'));
}

			}
			
					
		
		// 3. ITEM HAS WINNER
		//--------------------
		}elseif($hbid['reserve_met'] == "yes"){
			
			
			// ITEM STATUS
			$item_status = __("Item Sold","premiumpress");	
			
			// UPDATE POST WITH A LIST OF WINNERS
			update_post_meta($postid,'bidwinnerstring', get_post_meta($postid,'bidwinnerstring', true)."-".$hbid['userid']."-");
			 
			// GET CURRENT PRICE 
			$current_price = get_post_meta($postid,'price_current',true);
			if($current_price == ""){ $current_price = 0; }		
			 
			// ADD LOG ENTRY			
			if(isset($_POST['auction_action']) && $_POST['auction_action'] == "buynow"){			
			
				// ADD LOG			 
				//$CORE->ADDLOG("Auction Won!", 0, $postid, 'buy now', "auctionwon", get_the_title($postid) );	
		 				
			}else{
			
				// ADD LOG			 
				//$CORE->ADDLOG("Auction Won!", 0, $postid, 'auction finished', "auctionwon", get_the_title($postid) );
				 
				
			}			
			
			// ADD NEW PAYMENT FORM
			$this->_add_paymentform($postid, $hbid['userid']);					 
			 
			// CHECK FOR QTY AND ONLY EXPIRE THE LISTING
			// IF THE TIMER HAS RUN OUT
			$qty = get_post_meta($postid,'qty', true);
			if($qty == ""){ $qty = 0; }		
			 
			$expires = get_post_meta($postid, 'listing_expiry_date',true);
			
			
			$new_expires_time = date("Y-m-d H:i:s", strtotime( $expires . " +30 seconds") );	
			
			if( $qty > 0 ){
				
				// REDUCE QTY BY ONE
				update_post_meta($postid,'qty', get_post_meta($postid,'qty', true) - 1 );
				
			}
		
			if( $qty > 0 && ( strtotime($new_expires_time) > strtotime(current_time( 'mysql' )) ) ){
				
				// DO NOT CONTINUE AUCTION
				
			}else{
			
				// COMPLETELY END AUCTION
				// Get the current listing expiry date
$expiry_date = get_post_meta($postid, 'listing_expiry_date', true);

// Check if the expiry date is set
if (!empty($expiry_date)) {
  // Calculate the new expiry date by adding 30 seconds
  $new_expiry_date = date('Y-m-d H:i:s', strtotime($expiry_date) + 30);

  // Update the listing_expiry_date meta value
  update_post_meta($postid, 'listing_expiry_date', $new_expiry_date);

  // Update the auction_ended meta value
  update_post_meta($postid, 'auction_ended', current_time('mysql'));
}

				 
			}
		
			// SEND EMAIL	
			/*$data1 = array(		
					"username" => $post->post_author,	
					"item_title" => get_the_title($postid),
					"item_link" => get_permalink($postid),									
					"item_price" => get_post_meta($postid,'price_current',true),									 
			); 
								
			$CORE->email_system($hbid['userid'], 'auction_winner', $data1);
			 */
		
		
		// 4. ERROR (should not be any!)
		//---------------------
		}else{
				
		// ADD LOG			 
		//$CORE->ADDLOG("Auction Ended", 0, $postid, '', "auctionend", get_the_title($postid) );	
		
			
		
		}
		
		
		// SEND EMAIL TO ITEM WONER
		$data1 = array(		
			"username" => $post->post_author,	
			"item_title" => get_the_title($postid),
			"item_link" => get_permalink($postid),									
			"item_price" => get_post_meta($postid,'price_current',true),
			"item_status" =>  $item_status,									 
		); 
	 							
		$CORE->email_system(get_post_field( 'post_author', $postid ), 'auction_finished', $data1);
		 
		return; 	
	
	}
	
	/*
		this function will relist the auction
	*/
	
	function _relist_auction($postid, $force = false){ global $CORE, $wpdb;
	 
		// CHECK THE LISTING HAS EXPIRED
		$expiry_date = get_post_meta($postid,'listing_expiry_date',true);
		$new_expiry_date = date("Y-m-d H:i:s", strtotime( $expiry_date . " +30 seconds") );
		
		$ff = $CORE->date_timediff($new_expiry_date,'');
 
 		if( ( $ff['expired'] == 1 && get_post_meta($postid, 'auction_ended', true) == "" )  || $force  == 1)  {
	 	  
			// PASS BACK TO CORE TO HANDLE EXPIRY DATE
			$CORE->reset_listing_expirydate($postid);
 	
			// RESET BID STRINGS
			update_post_meta($postid,	'bidstring', '');				
			update_post_meta($postid,	'user_maxbid_data', '');								
			update_post_meta($postid,	'relisted', current_time( 'mysql' ) );	
			update_post_meta($postid,	'status', '0');			
			
			// UPDATE POST STATUS
			$my_post = array();
			$my_post['ID'] 					= $postid;
			$my_post['post_status']			= "publish";
			wp_update_post( $my_post );		 
			
			
			// EMAIL OLD BIGGERS AND INFORM THEM THE NEW ITEM HAS BEEN
			// RELISTED AND IS NOW AVAILABLE FOR SALE
			//$this->_email_bidders($postid);
			
			// NOW CLEAR BIDDING HISTORY
			update_post_meta($postid, 	'current_bid_data', '');			
			
			// DELETE ALL ORDERS AND OFFERS
			// LOOP ALL OFFERS WITH THIS LISTING ID
			$SQL = "SELECT * FROM ".$wpdb->prefix."posts 
			INNER JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id AND mt2.meta_key='post_id' AND mt2.meta_value='".$postid."') 
			WHERE ".$wpdb->prefix."posts.post_type = 'ppt_offer' 
			AND ".$wpdb->prefix."posts.post_status = 'publish' 	
			GROUP BY ".$wpdb->prefix."posts.ID";		
			 
			$tt = $wpdb->get_results($SQL);
			 
			foreach($tt as $t){
			 
			wp_delete_post( $t->ID, true);
			
			}
		
			 		 	
		
		}
			
	}
	
	/*
		this function will email existing bidders to let them know
		the auction has finished
	*/
	function _email_bidders($postid, $email_type = ""){ global $userdata, $CORE;
	 	
		// GET CURRENY BID HISTORY
		$history = get_post_meta($postid,'current_bid_data',true);
		if(!is_array($history)){ $history = array(); }
		 
	
	
		// SEND WHICH EMAIL
		switch($email_type){
		
		
			case "newbid": {
			 
				// LOOP BIDDERS	
				krsort($history); // order data
				if(is_array($history) && !empty($history)){
						$sent_to_array = array();	
					 
						$i = 1;
						foreach($history as $maxbid => $data){ 
						 	
							if(!is_numeric($data['userid']) ){
								continue;
							}
							
							
							if($i == 1  ){ // this is the current highest bidder 
							
								$WINNERID = $data['userid'];
								
							}else{ // and these are the loooooooosers
							 	
								 
								if($data['userid'] != $WINNERID && !in_array($data['userid'],$sent_to_array) ){
									 
										// OUT BID MESSAGE									 
										$CORE->FUNC("add_log",
											array(				 
												"type" 			=> "offer_rejected",								
												"postid"		=> $postid,													
												
												"to" 			=> $data['userid'], 						
												"from" 			=> $WINNERID,													
												
												"alert_uid1" 	=> $data['userid'],
											 
											)
										);
										
										// DONT RESEND
										array_push($sent_to_array,$data['userid']);
										
								} // end if	 
								 	
								
							 	
								
							}// end else
							$i++;
						}
							
				}// end if is array	
			
			} break;
			case "sold": { 
			
			
				// LOOP BIDDERS	
				krsort($history); // order data
				if(is_array($history) && !empty($history)){
						$sent_to_array = array();	
				 
						$i = 1;
						foreach($history as $maxbid => $data){
						
							if($i == 1 && $data['amount'] > 0 ){ // this is the current highest bidder
									 
								 	// AUCTION WINNER
									 
								
							}else{ // and these are the loooooooosers
							 	
								if(is_numeric($data['userid']) && !in_array($data['userid'],$sent_to_array)){
								 
									
									// OUT BID MESSAGE									 
									$CORE->FUNC("add_log",
										array(				 
											"type" 			=> "offer_rejected",								
											"postid"		=> $postid,													
											
											"to" 			=> $data['userid'], 						
											"from" 			=> $data['userid'],													
											
											"alert_uid1" 	=> $data['userid'],
										 
										)
									);
									
									
									// DONT RESEND
									array_push($sent_to_array,$data['userid']);
									
									// ADD NEW PAYMENT FORM
									$this->_add_paymentform($postid, 0);
		
									
								} // end if
								
							}// end else
							$i++;
						}
							
				}// end if is array	
			
			
			
			
			} break;
			default: { };		
		}
		
			
	}
	
	function _add_paymentform($postid, $winnerid){ global $wpdb, $CORE, $userdata;
	 
	
		// LOOP ALL OFFERS WITH THIS LISTING ID
		$SQL = "SELECT * FROM ".$wpdb->prefix."posts 
		INNER JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id AND mt2.meta_key='post_id' AND mt2.meta_value='".$postid."') 
		WHERE ".$wpdb->prefix."posts.post_type = 'ppt_offer' 
		AND ".$wpdb->prefix."posts.post_status = 'publish' 	
		GROUP BY ".$wpdb->prefix."posts.ID";		
		 
		$tt = $wpdb->get_results($SQL);
		 
		foreach($tt as $t){
			
			
			// SET STATUS TO LOST
			update_post_meta($t->ID, "offer_status", 2); // lost
			
			// WE SHOULD SEND ALERT		
		 	 
			// NOW CHECK FOR WINNER
			if($winnerid == get_post_meta($t->ID,'buyer_id',true)){	
			  
				// CHECK WE HAVENT ALREADY ADDED A PAYMENT INVOICE
				if(get_post_meta($t->ID,'payment_id',true) == ""  ){  
			 	 
					// TOTAL AMOUNT
					$totalamount = get_post_meta($postid,'price_current',true);				
					$price_shipping = get_post_meta($postid,'price_shipping',true);
					if($price_shipping == "" || !is_numeric($price_shipping)){$price_shipping = 0; }				
					$totalamount += $price_shipping;	
					
					// 3. ADD NEW ORDER/INVOICE
					
					$payment_id = $CORE->ORDER("check_exists", "OFFER-".$t->ID );
					if( !is_numeric($payment_id) ){
					
						$o = $CORE->ORDER("add", array( 
							"order_id" => "OFFER-".$t->ID,
							"order_status" 		=> 2, // pending
							"order_total" 		=> $totalamount,
							"order_userid" 		=> $winnerid,								
						) );
						
						$payment_id = $o['orderid'];	
					
					} 	 
					
					$gg = get_post($postid);  
		
					update_post_meta($payment_id, 'seller_id', $gg->post_author);	
					update_post_meta($payment_id, 'buyer_id', $winnerid);	
					update_post_meta($payment_id, 'offer_id', $t->ID );	
					
					// UPDATE BID WITH PAYMENT ID
					update_post_meta($t->ID, 'payment_id', $payment_id );
				}
			 	
				// UPDATE
				update_post_meta($t->ID, "offer_status", 3);	// won	
	
				//SET ITEM TO SOLD STATUS		
				update_post_meta($t->ID,'status',1); 				
				
				// ADD LOG
				$CORE->FUNC("add_log",
					array(				 
						"type" 			=> "offer_accepted",								
						"postid"		=> $postid,													
						"to" 			=> $winnerid, 						
						"from" 			=> $gg->post_author,													
						"alert_uid1" 	=> $winnerid,
						"alert_uid2" 	=> $gg->post_author,				
						"offerid" 		=> $payment_id,	
					)
				);
				 
					
			} 		 
  
		}
		
		
	 
   			
			
			
	}
	
	function _add_user_bidhistory($postid, $userid, $price, $type){ global $userdata, $CORE, $post, $wpdb;

		//4. UPDATE USER META TO INDICATE THEY BID ON THIS ITEM				
		$user_bidding_data = get_user_meta($userid,'user_bidding_data',true);
		if(!is_array($user_bidding_data)){ $user_bidding_data = array(); }
		
		$user_bidding_data[] = array('postid' => $postid, 'date' => current_time( 'mysql' ), 'bid_type' => $type, "amount" => $price );
		
		// SAVE
		update_user_meta($userid,'user_bidding_data',$user_bidding_data);
		
		// NEW BIDDING DATA SYSTEM ADDED IN 10.2.3+		
		$gg = get_post($postid);		
		
		// CHECK IF THE OFFER ALREADY EXISTS
		$SQL = "SELECT ID FROM ".$wpdb->prefix."posts 
		INNER JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id AND mt2.meta_key='post_id' AND mt2.meta_value='".$postid."') 
		INNER JOIN ".$wpdb->prefix."postmeta AS mt3 ON (".$wpdb->prefix."posts.ID = mt3.post_id AND mt3.meta_key='buyer_id' AND mt3.meta_value='".$userid."') 
		INNER JOIN ".$wpdb->prefix."postmeta AS mt4 ON (".$wpdb->prefix."posts.ID = mt4.post_id AND mt4.meta_key='seller_id' AND mt4.meta_value='".$gg->post_author."') 		
		WHERE ".$wpdb->prefix."posts.post_type = 'ppt_offer' 
		AND ".$wpdb->prefix."posts.post_status = 'publish' 
		GROUP BY ".$wpdb->prefix."posts.ID";		
		 
		$tt = $wpdb->get_results($SQL);
		if(empty($tt)){
		 	
			$my_post = array();
			$my_post['post_title'] 		= hook_price($price)." bid on ". get_the_title( $postid )." (".$type.")";
			$my_post['post_content'] 	= "";
			$my_post['post_excerpt'] 	= "";
			$my_post['post_status'] 	= "publish";
			$my_post['post_type'] 		= "ppt_offer";
			$my_post['post_author'] 	= 1;
			$POSTID 					= wp_insert_post( $my_post );
		 		
			// STORE POST ID
			add_post_meta($POSTID, "post_id", $postid );			 
			
			// SAVE THE BUYERS ID
			add_post_meta($POSTID, "buyer_id", $userid ); 
				
			// SAVE THE BUYERS ID
			add_post_meta($POSTID, "seller_id", $gg->post_author ); 
				
			// ADD STATUS
			add_post_meta($POSTID, "price", $price);	
			
			// bid type
			add_post_meta($POSTID, "bid_type", $type);		
				
			// ADD STATUS
			add_post_meta($POSTID, "offer_status", 1);
			 
		
		}else{	
		 			 
			// ADD STATUS
			update_post_meta($tt[0]->ID, "price", $price);	
	 	
		}
		
		
	
	}
	
	/*
		This function ads a new history element
		to the auction
	*/
	function _add_bidhistory($postid, $userid, $amount, $type = "buynow"){
	
		if(!is_numeric($postid)){ return; }
	
		// GET CURRENY BID HISTORY
		$history = get_post_meta($postid,'current_bid_data',true);
		if(!is_array($history)){ $history = array(); }
	 	
		// ADD NEW HISTORY
		$user_info = get_userdata($userid);
		$history[strtotime(current_time( 'mysql' ))] = array( 'amount' => $amount, 'userid' => $userid, 'user' => $user_info->display_name, 'bid_type' => $type, "date" => current_time( 'mysql' )   );
		
		// SAVE HISTORY
		update_post_meta($postid,'current_bid_data', $history);
		
		// SET FLAG SO SYSTEM KNOWS WHO THE CURRENT WINNING BIGGER IS
		update_post_meta($postid, 'bidstring', get_post_meta($postid,'bidstring', true)."-".$userid."-");
	
		
	}
	
	/*
		This function will add a new bid
		for the user	
	*/
	function _add_bid($postid, $userid, $amount, $ic ="add", $type = ""){ global $CORE, $post, $userdata;
 		
		$result = "";
		
		// UPDATE PRICE
		if($ic == "add"){
		
			$current_price = get_post_meta($postid,'price_current',true);
			if($current_price == ""){ $current_price = 0; }	
			
			// CHECK IF WE HAVE ANY BID HISTORY
			$history = get_post_meta($postid,'current_bid_data',true);
			if( (!is_array($history) || is_array($history) && empty($history) ) && $amount >= $current_price){
			
			$newamount = $amount; 			
			
			}else{
						
			$newamount = $current_price + $amount; 
			
			}	
			 		
			 
		}elseif($ic == "final"){
			$newamount = $amount;
		}		 
		
		// CHECK FOR START PRICE AND IF NOT FOUND
		// SET IT SO WE KNOW WHAT THE START PRICE
		// WAS FOR LATER LISTINGS
		$start_price = get_post_meta($postid,'price_starting', true);
		if($start_price == ""){
			$current_price = get_post_meta($postid,'price_current',true);
			update_post_meta($postid,'price_starting', hook_price_save($current_price));
		}
	 
		update_post_meta($postid,'price_current', hook_price_save($newamount)); 			
		
		// ADD BID HISTORY
		$this->_add_bidhistory($postid, $userid, $amount, $type);
		
		// ADD USER BID HISTORY
		$this->_add_user_bidhistory($postid, $userid, $amount, $type);		
	 
	 	// NOW CHECK FOR USER MAX BIDS
		if($type != "maxbid2"){
		$result = $this->_user_check_maxbid($postid, $userid, $newamount);
		}	 
		
		// ADD LOG
		$CORE->FUNC("add_log",
				array(				 
					"type" 			=> "offer_new",								
					"postid"		=> $postid,	
					 	
					"to" 			=> get_post_field( 'post_author', $postid ), 						
					"from" 			=> $userid,
										
					"alert_uid1" 	=> get_post_field( 'post_author', $postid ),	
					"alert_uid2"  	=> $userid, 
					
				)
		);	 
		 
 
			
		// RETURN TRUE OR FALSE IF BEEN OUTBID		
		return $result;
	
	}
	
	/*
		This function gets the winning bidder
		for an auction
	*/
	function _get_winner($postid, $action_type = ""){
	
	
		// GET CURRENY BID HISTORY
		$history = get_post_meta($postid,'current_bid_data',true);	
		if(!is_array($history) || is_array($history) && empty($history)){ return array("user" => "nobidders", "hid" => "nobidders", "reserve_met" => "no", "userid" => 0 ); }
		
		// SORT BY PRICE AND RETURN LAST ONE
		uksort($history, array($this, "order_bidhiustory_bykey") );
	 	
		// GET IN CORRECT ORDER
		$history = array_reverse($history, true);
		
		// CHECK TO SEE IF A RESERVE IS MET
		$reserve_price = get_post_meta($postid,'price_reserve',true);
		if($reserve_price == "" || !is_numeric($reserve_price) ){ $reserve_price = 0; }
		
		$current_price = get_post_meta($postid,'price_current',true);
		if($current_price == "" || !is_numeric($current_price) ){ $current_price = 1; }
		
		$reserve_is_met = "no";
		if($current_price >= $reserve_price){
			$reserve_is_met = "yes";
		}
		 	 
		$narray = array_merge( array("reserve_met" => $reserve_is_met), array_values($history)[0] );
		// RETURN THE TOP RESULT
		return $narray; 
	
	} 
	/*
		this function checks a listing for a max bid price
		after an auction has ended and then
		makes a new bid
	*/
	function sortByOrder($a, $b) {
    return $a['max_amount'] - $b['max_amount'];
	}
	function _user_has_maxbid($postid){
	
		//1. GET USER META		
		$maxbid = get_post_meta($postid,'user_maxbid_data',true);
		if(!is_array($maxbid)){ $maxbid = array(); }
		
		// REVERSE ORDER BY MAX AMOUNT
		usort($maxbid, array($this, 'sortByOrder') );		
		$maxbid = array_reverse($maxbid);		
	 	
		//2. GET CURRENT PRICE
		$current_price = get_post_meta($postid,'price_current',true);
		if($current_price == "" || !is_numeric($current_price) ){ return false; }
		
		foreach($maxbid as $userid => $mb){
			
			// CHECK IF SOMEONE HAS BID MORE
			if($mb['max_amount'] > $current_price){
			 
				return array_merge(array("userid" => $userid), $mb );		
			}
		}		 
		
		return false;		
	}
	
	/*
		this function returns the max bid data
		for a listing 
	
	*/
	
     // Define the custom sort function
     function max_price_custom_sort($a,$b) {
          return $a['max_amount']<$b['max_amount'];
     }
	function _user_check_maxbid($postid, $uid, $amount){ global $CORE, $userdata;
	
		//1. GET USER META		
		$maxbid = get_post_meta($postid,'user_maxbid_data',true);
		if(!is_array($maxbid)){ $maxbid = array(); }
		 
		//2. REMOVE MY MAX BID JUST INCASE IV SET ONE
		if(isset($maxbid[$uid])){
		unset($maxbid[$uid]);
		}		 
		 // MAKE SURE IS NOT EMPTY
		if(!empty($maxbid) ){
			
			// SORT BY PRICE HIGHEST FIRST
			uasort($maxbid, array($this, "max_price_custom_sort" ) );
			
			// GET FIRST ENTRY FROM THE STACK
			$user1 = array_values($maxbid)[0];	
			$user1_id = array_keys($maxbid)[0];
			
		 	// NOW DO CHECKS
			$canUpdate = false; 			
			if( $user1['max_amount'] > $amount  ){ // ) && $user1['max_amount'] > $user2['max_amount']
			 	
				if(_ppt(array('lst','at_bidinc')) == ""){
				$newamount = $amount + 1;	
				}else{				
				$newamount = $amount + _ppt(array('lst','at_bidinc')); 
				} 
								
				$new_uid =  $user1_id; // note
				$canUpdate = true;	
					
			} 
			
			//IF CAN UPDATE
			if($canUpdate){
		 
				// ADD NEW BID				
				$this->_add_bid($postid, $new_uid, $newamount, "final",  "maxbid2");
				
				update_post_meta($postid,'price_current', hook_price_save($newamount));  //hh
				 
					
				// RETURN				
				return "outbid";	
			}
		
		}// END CHECK MAX BID
	 	
		// remove own bid
		if(isset($maxbid[$uid])){
			// GET MY MAX BID
			$my_maxbid = $maxbid[$uid]['max_amount'];
			// THEN REMOVE ME
			unset($maxbid[$uid]); 
		
		}
		
 
	 	
		// CHECK AGAINST RESERVE PRICE
		$reserve_price = get_post_meta($postid,'price_reserve',true);
		if($reserve_price == "" || !is_numeric($reserve_price) ){ $reserve_price = 0; }
		
		if($amount <  $reserve_price){
		return "reserve_notmet";
		}
		
		return "ok";		
	}	
	/*
		This function sets a users max bid 
		price for each item
	
	*/
	function _user_set_maxbid($userid, $postid, $amount){
	
		//1. GET USER META		
		$maxbid = get_post_meta($postid,'user_maxbid_data',true);		
		if(!is_array($maxbid)){ $maxbid = array(); }
		$maxbid_old = $maxbid;
		
		// CHECK IF EXISTING MAX BID EXISTS AND UPDATE
		// OTHERWISE ASSUME NEW BIG		
		if(isset($maxbid[$userid])){
		
			$maxbid[$userid] = array('max_amount' => $amount, 'updated' => current_time( 'mysql' ));
			
			update_post_meta($postid,'user_maxbid_data',$maxbid);
			 
			// DONT UPDATE BIDDING
			if(isset($maxbid_old[$userid]['max_amount']) && $maxbid_old[$userid]['max_amount'] > 0){	 
			die();
			}
			//return;
		
		}		
		
		// MAX BID
		$maxbid[$userid] = array('max_amount' => $amount, 'updated' => current_time( 'mysql' ));
		
		// SAVE
		update_post_meta($postid,'user_maxbid_data',$maxbid);
		
		// NOW MAKE A NEW BID
		$current_price = get_post_meta($postid,'price_current',true);
		if($current_price == "" || !is_numeric($current_price) ){ $current_price = 0; }		 
		
		if($maxbid > $current_price){		 	
			
			// CHECK IF WE HAVE ANY BID HISTORY
			$history = get_post_meta($postid,'current_bid_data',true);
			if( (!is_array($history) || is_array($history) && empty($history) ) && $amount >= $current_price){			
			$newamount = $current_price;
			}else{						
				 
				if(_ppt(array('lst','at_bidinc')) == ""){
					$newamount = $current_price + 1;	
				}else{				
					$newamount = $current_price + _ppt(array('lst','at_bidinc')); 
				}			
					
			}
			
			
			$this->_add_bid($postid, $userid, $newamount, "final",  "maxbid.");
		
		}
		
	}
	

	function get_mybid($postid, $uid){
	 
		// ALL BIDS
		$bidding_history = get_post_meta($postid,'current_bid_data',true);
		 
		if(!is_array($bidding_history)){ $bidding_history = array(); }
		
		 uksort($bidding_history,  array($this, "order_bidhiustory_bykey") );
		$bidding_history = array_reverse($bidding_history, true);
		
		if(is_array($bidding_history)){
		
			foreach($bidding_history as $j){
			
				if($j['userid'] == $uid){
				 	
				return hook_price($j['amount']);
				
				}		
			}
		
		}else{
		
			return 0;
			
		}
	}
	
	
	/*
		This function deals with all the form submmission
		sent by the user
	*/
	function _wp_head(){ global $CORE, $post, $userdata; 		

		
		if(isset($_POST['auction_action'])){
		
			
			switch($_POST['auction_action']){  
 		
				case "deletehistory": {
				
				
					$newdata = array();
					$user_bidding_data = get_user_meta($userdata->ID,'user_bidding_data',true);
				 
					$user_bidding_data = array_reverse($user_bidding_data, true);
					foreach($user_bidding_data as $key => $data){
					
							if(!isset($data['postid']) ){ continue; } 
							
							if($_POST['hid'] == $data['postid']){
							
							}else{
							
							$newdata[] = $data;
							
							}				
					}
					 
					 update_user_meta($userdata->ID, 'user_bidding_data', $newdata);
				
				
				} break; 
			
				case "relist": {
					
					// HANDLE THE RELIST
					$this->_relist_auction($post->ID);
					
					// GIVE USER SOME NICE FEEDBACK
					$GLOBALS['error_message'] = "Auction Relisted Successfully";
				
				} break;
			
				case "buynow": {
				  	
					// CHECK USER IS A MEMBER
					$CORE->Authorize();
					
					// CHECK ITS NOT BEEN SOLD ALREAYY?
					if(get_post_meta($post->ID,'listing_expiry_date',true) == ""){ return; }	
				 	 
					// GET BUY NOW PRICE
					$price_current = get_post_meta($post->ID,'price_current',true);
					$bin_price = get_post_meta($post->ID,'price_bin',true);
					
					// CHECK IF THE CURRENT PRICE IS HIGHER THAN THE BUY NOW PRICE
					//if($bin_price < $price_current ){
					//	$bin_price = $price_current;
					//}
					
					// SAVE
					update_post_meta($post->ID,'price_current', hook_price_save($bin_price)); 
					 
					// ADD HISTORY				 
					$this->_add_bid($post->ID, $userdata->ID, $bin_price, "final", "buynow");					
					
					// SEND EMAIL
					$this->_email_bidders($post->ID,"sold");
				 
					// END THE AUCTION
					$this->_end_auction($post->ID);
					
					// CHECK FOR QTY SO WE CAN HIDE THE BUY NOW BTN
					// AND SHOW PAYMENT OPTIONS
					$qty = get_post_meta($post->ID,'qty', true);
					
					if($qty == ""){ $qty = 0; }		
					if( $qty > 0 ){
		
					 	// SAVE A RECORD OF BUY NOW FOR THIS
						// USER SO WE CAN SHOW PAYMENT FORM DATA
						$buynowdata = get_post_meta($post->ID,'user_buynow_data',true);
						if(!is_array($buynowdata)){ $buynowdata = array(); }
						
						if(isset($buynowdata[$userdata->ID])){
						$buynowdata[$userdata->ID] = array("price" => $bin_price, "date" => current_time( 'mysql' ), "qty" => $buynowdata[$userdata->ID]['qty'] + 1, "username" =>  $CORE->USER("get_username", $userdata->ID) );
						}else{
						$buynowdata[$userdata->ID] = array("price" => $bin_price, "date" => current_time( 'mysql' ), "qty" => 1, "username" =>  $CORE->USER("get_username", $userdata->ID) );
						}
						
						update_post_meta($post->ID,'user_buynow_data', $buynowdata);
						
						// REDUCE QTY BY ONE
						update_post_meta($post->ID,'qty', get_post_meta($post->ID,'qty', true) - 1 );					
					
					}else{
					
						// SEND EMAILS
						
						
					
					}
					// HANDLE THE AUCTION ITEM
					
					// GIVE USER SOME NICE FEEDBACK
					$GLOBALS['error_message'] = "Buy Now Successfull";
					 
				
				} break; // end buy now 
				
			
			} // end switch	
		
		
		}// end auction actions
	
	
	
	}	
	
	
	
	
function ajax_actions(){ global $CORE, $post, $wpdb;
	
	 
	
		// RELIST ACTION FOR ADMIN
	 	if(is_admin() && isset($_GET['resetaction']) && is_numeric($_GET['resetaction']) ){
		 
		$this->_relist_auction($_GET['resetaction'], $forceReset = 1);
		}
		
 
		if(isset($_POST['auction_action']) && $_POST['auction_action'] !=""){
		
			switch($_POST['auction_action']){
			
				case "set_maxbid": {
				 
				die($this->_user_set_maxbid($_POST['uid'], $_POST['pid'], $_POST['amount']));
				
				} break;
			
				case "bidhistory": {
				
					if(!is_numeric($_POST['pid'])){ return; }
					
					// CHECK FOR MORE BIDS
					$this->refresh_bids($_POST['pid']);
					
					die($this->bidding_history($_POST['pid'], true));
				
				} break;
			
				case "buybox_bid": {
					
					$status = 0; $outbid = 0;
					
					// CHECK USER IS A MEMBER
					$CORE->Authorize();
					
					// MAKE SURE PRICES ARE VALID
					if(!is_numeric($_POST['amount']) || !is_numeric($_POST['pid']) ){ return; }
					
					// SWITCH AUCTION TYPE
					switch($_POST['type']){
					
						case "auction": {
						
							// CURRENT PRICE OF ITEM
							$current_price = get_post_meta($_POST['pid'],'price_current',true);
							if($current_price == ""){ $current_price = 0; }	
							
							// CHECK IF WE HAVE ANY BID HISTORY
							$canPost = false;
							$history = get_post_meta($_POST['pid'],'current_bid_data',true);
							if( (!is_array($history) || is_array($history) && empty($history) ) && $_POST['amount'] >= $current_price){
							$canPost = true;							
							}
						 
							// CHECK THE NEW PRICE IS GREAT THAN THE CURRENT PRICE
							if($canPost || ( $_POST['amount'] > $current_price) ){
														
								//1. ADD BID
								$outbid = $this->_add_bid($_POST['pid'], $_POST['uid'], $_POST['amount'], "final",  "newbid"); 
								
								// EMAIL THE OLD BIDDER TO LET THEM KNOW
								// THERE IS A NEW BID
								$this->_email_bidders($_POST['pid'],"newbid");
								
								// INCREASE TIMER BY 30 SECONDS
								$expiry_date = get_post_meta($_POST['pid'],'listing_expiry_date',true);					
								$expiry_date = date("Y-m-d H:i:s", strtotime( $expiry_date . " +30 seconds") );					
								update_post_meta($_POST['pid'],'listing_expiry_date', $expiry_date );
								
													
								$status = "ok"; 
								 
								
							}else{
							
								// INVALID AMOUNT
								$status = "error_not_greater";							
							
							}
						
						
						} break;
					
						case "penny": {
						
							// CHECK WHICH CREDIT SYSTEM TO USE
							if($_POST['credit_type'] == "tokens"){
							$ckey = "wlt_usertokens";
							$cname = "penny";
							}else{
							$ckey = "wlt_usercredit";
							$cname = "credit";
							}
							
							//3. REMOVE CREDIT FROM USERS PROFILE
							$c = get_user_meta($_POST['uid'], $ckey, true);							
							if($c > 0){
							
								$newcredit = $c - 1;
								update_user_meta($_POST['uid'], $ckey, $newcredit);
										
								//1. CURRENT PRICE
								$outbid = $this->_add_bid($_POST['pid'], $_POST['uid'], $_POST['amount'], "add",  $cname); 
								
								//2. UPDATE TIMER
								$expiry_date = get_post_meta($_POST['pid'],'listing_expiry_date',true);					
								$expiry_date = date("Y-m-d H:i:s", strtotime( $expiry_date . " +30 seconds") );					
								update_post_meta($_POST['pid'],'listing_expiry_date', $expiry_date );
								
								$status = 1;
								
							}else{
								
								// USER HAS RUN OUT OF CREDIT
								$status = "nocredit";
								
							}							
						
						} break;
					
					}
					
					die(json_encode(array("status" => $status, "outbid" => $outbid )));
					
				
				} break; 
			
				case "buybox_load": {
				
				if(is_numeric($_POST['pid'])){
				
					//1. CURRENT PRICE
					$price_current = get_post_meta($_POST['pid'],'price_current',true);
					
					// CHECK FOR BUY NOW PRICE ONLY
					if(get_post_meta($_POST['pid'], 'auction_type', true ) == 2){					
					   $price_current = get_post_meta($_POST['pid'],'price_bin',true);  
					   if(!is_numeric($price_current)){ $price_current = 0; }					   
					}
					
					//2. GET EXPIRY DATE
					$expiry_date = get_post_meta($_POST['pid'],'listing_expiry_date',true);
					
					$new_expires_date = date("Y-m-d H:i:s", strtotime( $expiry_date . " +30 seconds") );
					
					
					//3 GET USER CREDIT
					$auction_type_credit = get_post_meta($_POST['pid'],'auction_type_credit',true);
					if($auction_type_credit == 2){ $ckey = "wlt_usertokens"; }else { $ckey = "wlt_usercredit"; }
					
					$credit = get_user_meta($_POST['uid'], $ckey, true);
					
					// CHECK IF ITS BEEN SOLD
					$expires = get_post_meta($_POST['pid'], 'listing_expiry_date',true);
					
					
        			$new_expires_time = date("Y-m-d H:i:s", strtotime($expires . " +30 seconds") );
					
					
					if($new_expires_time == ""){
						$status = "sold";
					}else{
						$status = "live";
					}
					
					// CHECK FOR CURRENY CONVERSION
					if(isset($_SESSION['currency']) && isset($_SESSION['currency']['code']) && $_SESSION['currency']['code'] != "" && $_SESSION['currency']['code'] != "USD"){
					$price_current = hook_price($price_current);					
					}
					
					 
					$arr = array('price' => $price_current, "date" => $new_expires_date, "credit" => $credit, "status" => $status );

					die(json_encode($arr));
					
				}// end check
				
				
				} break;
				case "live_auction_updating": {
				
				if (isset($_POST['postId'])) {
                $post_id = intval($_POST['postId']);
            
                // Update the post status to 'expired'
                $my_post = array(
                  'ID' => $post_id,
                  'post_status' => 'expired'
                );
                wp_update_post($my_post);
            
                // Update the expiry date meta data
                update_post_meta($post_id, 'live_auction_start_date', '');
                update_post_meta($post_id, 'listing_expiry_date', '');
              }
                
                exit;
				
				} break;
				
				
			
			} // end switch
			
		} // end isset
	}
	
	
 

}










?>