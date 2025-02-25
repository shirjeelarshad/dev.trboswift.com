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
 
if(1==1){ //_ppt(array('user','stats')) == 1
 

$chartlabels = array();
$i = 0;
while($i < 7){
$chartlabels[] = array("name" => date('jS', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) , "value" => 100);		
$i++;
}
/**********************************************************/


if(THEME_KEY == "da"){ 


// GET USER PROFILE VIEWS
$data_profile_views_total = $CORE->USER("get_rating_likes",  array($userdata->ID, "all") );
$data_profile_views = array();
$i = 0;
while($i < 7){
 
	$value = $CORE->USER("get_rating_likes", array($userdata->ID,  date('Y-m-d', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) ) );	
 
 	// DATA
	$data_profile_views[] = array("name" => date('jS', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) , "value" => $value);		
		
	$i++;
}


}else{

$data_profile_views = array();
if(THEME_KEY !="sp"){ 
	$data_profile_views_total = $CORE->USER("get_views",  array($userdata->ID, "all") ); 
	$i = 0;
	while($i < 7){ 
		$value = 0;
		$value += $CORE->USER("get_views", array($userdata->ID,  date('Y-m-d', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) ) );			
				
		// DATA
		$data_profile_views[] = array("name" => date('jS', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) , "value" => $value);		
		$i++;
	}
}

}

 
 
/**********************************************************/

// UPDATE VIEW COUNTER
$data_listing_views = array();
if(THEME_KEY !="sp"){ 

	$listing_ids = $CORE->PACKAGE("get_user_listing_ids", $userdata->ID);
	// COUNT TOTALS
	$data_listing_views_total = 0;
	if(is_array($listing_ids) && !empty($listing_ids) ){
		foreach($listing_ids as $pid){	
		$data_listing_views_total = $data_listing_views_total +  $CORE->PACKAGE("get_hits",  array($pid, "all") );		
		}
	}
	
	$i = 0;
	while($i < 7){
	 
		$value = 0;
		if(is_array($listing_ids) && !empty($listing_ids) ){
			foreach($listing_ids as $pid){			
				$value += $CORE->PACKAGE("get_hits", array($pid,  date('Y-m-d', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) ) );			
			}
		}
				
		// DATA
		$data_listing_views[] = array("name" => date('jS', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) , "value" => $value);		
			
		$i++;
	}
}
/**********************************************************/
if(THEME_KEY == "da"){ 

}else{
 
$ORDERDATA = "0,0,0,0,0,0,0";
 
	
	$i = 0;
	while($i < 7){
	
		$date = date('Y-m-d', strtotime('-'.$i.' day', strtotime(date('Y-m-d')) ) );
		
		$value = 0;
		$SQL = "select count(*) AS total from ".$wpdb->prefix."posts 
		where ".$wpdb->prefix."posts.post_date LIKE '".$date."' 
		AND ".$wpdb->prefix."posts.post_type='ppt_orders' GROUP BY ID"; // AND ".$wpdb->prefix."posts.post_author = '".$userdata->ID."'
		
			$args = array(
						'post_type' 		=> 'ppt_orders',
												
						'date_query' => array(
								 array(
									'year'  => date('Y', strtotime('-'.$i.' day', strtotime(date('Y-m-d')) ) ),
									'month' => date('m', strtotime('-'.$i.' day', strtotime(date('Y-m-d')) ) ),
									'day'   => date('d', strtotime('-'.$i.' day', strtotime(date('Y-m-d')) ) ),
								),
							),
								
					 
							'meta_query' => array( 
								'user_id'    => array(
									'key' 			=> 'order_userid',	
									'type' 			=> 'NUMERIC',
									'value' 		=> $userdata->ID,
									'compare' 		=> '=',								 					 			
								),					 	
							), 
											 
							
					  );
					 $wp_query1 = new WP_Query($args);
				 
		 $value = $wp_query1->found_posts;
		
				
		// DATA
		$data_orders[] = array("name" => date('jS', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) , "value" => $value);		
			
		$i++;
	}
 
}	 
/**********************************************************/



?>
 
 
<div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0">
          
            <h6><?php echo __("Account Statistics","premiumpress"); ?> </h6>
            <p><?php echo __("Here's a overview + last 7 days.","premiumpress"); ?></p>
            
            </div>
            <div class="card-bodyx">
            
             
<div class="col-9 mx-auto text-center">
<div class="row">

 <?php if(THEME_KEY == "da"){ ?>
 <div class="col-md-2"></div>
 <?php }else{ ?>
    <div class="col-md-4">
    
    <h4 class="mb-0"><?php echo $CORE->USER("get_ordertotal", $userdata->ID); ?></h4>
    <small class=" tiny text-uppercase text-warning"><?php echo __("total orders","premiumpress"); ?></small>
   
    </div>
  <?php } ?>  
	 
    
    <?php if(isset($data_listing_views) && !empty($data_listing_views) ){ ?>
    <div class="col-md-4">
    <h4 class="mb-0"><?php echo number_format($data_listing_views_total); ?></h4>
    <small class=" tiny text-uppercase text-success"><?php if(THEME_KEY == "da"){ echo __("profile views","premiumpress"); }else{ echo __("ad views","premiumpress"); } ?></small>
    </div>
    <?php } ?> 
    
	<?php if(isset($data_profile_views) && !empty($data_profile_views) ){ ?>	
    <div class="col-md-4">
    <h4 class="mb-0"><?php echo number_format($data_profile_views_total); ?></h4>
    <small class="tiny text-uppercase text-info"><?php if(THEME_KEY == "da"){ echo __("profile likes","premiumpress"); }else{ echo __("profile views","premiumpress"); } ?></small>
    </div>
    <?php } ?>  

</div>
</div>
 
 
 <div class="chart-container" >
<canvas height="200"  width="553" id="myChart1" class="mt-n5" style=""></canvas>
</div>

</div></div>

<script>

jQuery(document).ready(function(){ 

var ctx = document.getElementById('myChart1').getContext('2d'); 
var myChart = new Chart(ctx, {
    type: 'line',
	
	
    data: {
        
		labels:[<?php foreach($chartlabels as $h){ ?>"<?php echo $h['name']; ?>",<?php } ?>],
		 
		
				datasets: [
				
				<?php if(isset($data_profile_views) && !empty($data_profile_views) ){ ?>
				{
					
					data:[<?php foreach($data_profile_views as $h){ ?><?php echo $h['value']; ?>,<?php } ?>],
					label:"<?php if(THEME_KEY == "da"){ echo __("profile likes","premiumpress"); }else{ echo __("profile views","premiumpress"); } ?>", 
					//backgroundColor:"#007bff",
					 
					borderColor:"#007bff",
					borderWidth: 2,
				 
					 
					
				},
				<?php } ?>
				
				<?php if(isset($data_listing_views) && !empty($data_listing_views) ){ ?>
				{
					
					data:[<?php foreach($data_listing_views as $h){ ?><?php echo $h['value']; ?>,<?php } ?>],
					label:"<?php if(THEME_KEY == "da"){ echo __("profile views","premiumpress"); }else{ echo __("ad views","premiumpress"); } ?>",					
					//backgroundColor:"#3baf55",
					borderWidth: 2,
					borderColor:"#3baf55",
					//fill:0,
					 
					
				},
				<?php } ?>
				 
				<?php if(THEME_KEY != "da" && strlen($ORDERDATA) > 0 ){ ?>
				{
					
					data:[<?php foreach($data_orders as $h){ ?><?php echo $h['value']; ?>,<?php } ?>],
					label:"<?php echo __("orders","premiumpress"); ?>", 					
					//backgroundColor:"#ffe082",	
					borderWidth: 2,	
					borderColor:"#ffe082",	
					//fill:0,	
					
				},
				<?php } ?>	
					
				]
    },
    options: {
	
		responsive: true, 
		
		 layout: {
            padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }
        },

 
 legend:{display:!1},
 scales:{
 
 xAxes:[
	 {ticks:{fontSize:"11",fontColor:"#969da5", }  ,gridLines:{color:"#fff", zeroLineColor:"rgba(0,0,0,0.05)"}
	 }
 ],
 
 yAxes:[{display:!1,ticks:{beginAtZero:!0}}]
  
        }
    }
});

});	
</script>
<?php  } ?>