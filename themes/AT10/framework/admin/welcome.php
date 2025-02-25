<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN, $CORE_AUCTION;



// Fetch all posts of type 'listing_type'
$all_listings = get_posts(array(
    'post_type' => 'listing_type',
    'posts_per_page' => -1,
    'post_status' => array('publish', 'closed') // Fetch both active and closed listings
));

$total_bidders = [];
$total_bids = 0;
$total_winners = 0;

foreach ($all_listings as $listing) {
    $post_id = $listing->ID;
    $bidding_history = get_post_meta($post_id, 'current_bid_data', true);

    if (!is_array($bidding_history)) {
        $bidding_history = [];
    }

    // Count the number of bids for this post
    $total_bids += count($bidding_history);

    // Add unique bidders to the total_bidders array
    foreach ($bidding_history as $bid) {
        if (isset($bid['userid']) && !in_array($bid['userid'], $total_bidders)) {
            $total_bidders[] = $bid['userid'];
        }
    }

    // Check if there is a winner for this post
    $winner = $CORE_AUCTION->_get_winner($post_id);
    if ($winner['userid'] !== 0) {
        $total_winners++;
    }
}

$total_bidders_count = count($total_bidders);
 

// UPDATES
if(get_option("ppt_reinstall") != THEME_VERSION){
	if(defined('WLT_DEMOMODE')){
	
	}else{
	//update_option("ppt_license_key_bk", get_option("ppt_license_key") );
	//update_option("ppt_license_key","");
	}	
	//update_option("ppt_reinstall", THEME_VERSION);
}

$emaillogs = get_option('ppt_emaillogs');
if(!is_array($emaillogs)){ $emaillogs = array(); }

 
$i = 0;
while($i < 7){
 
	$value = 0;
	 
	$date = date('Y-m-d', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ) ) );
 	
	if(isset($emaillogs[$date])){
		$value = $emaillogs[$date]['hits'];
	}	 
		
	// DATA
	$data[] = array("name" =>  date('jS M', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) , "value" => $value);		
		
	$i++;
}


function get_user_registration_count_with_interval() {
    global $wpdb;

    // Get the current time
    $current_time = current_time('mysql');
    
    // Define the intervals with their corresponding labels
    $intervals = [
        'hour' => ['HOUR', 'H'],
        'day' => ['DAY', 'D'],
        'week' => ['WEEK', 'W'],
        'month' => ['MONTH', 'M'],
        '6months' => ['MONTH, 6', '1/2Y'],
        'year' => ['YEAR', 'Y']
    ];

    // Initialize the result
    $registration_count = 0;
    $interval_label = '';

    // Loop through each interval
    foreach ($intervals as $key => $interval_data) {
        $interval_sql = $key === '6months' ? 'INTERVAL 6 MONTH' : 'INTERVAL 1 ' . $interval_data[0];

        // Prepare the SQL query
        $SQL = $wpdb->prepare(
            "SELECT COUNT(ID) as count
             FROM {$wpdb->base_prefix}users
             WHERE user_registered >= DATE_SUB(%s, $interval_sql)",
            $current_time
        );

        // Execute the query and get the count
        $result = $wpdb->get_var($SQL);

        if ($result > 0) {
            $registration_count = $result;
            $interval_label = $interval_data[1];
            break;  // Exit the loop if a non-zero count is found
        }
    }

    return ['count' => $registration_count, 'interval' => $interval_label];
}

$data = array_reverse($data);



$count_posts 	= wp_count_posts(THEME_TAXONOMY.'_type'); 
$count_users	= count_users();


$registration_data = get_user_registration_count_with_interval();


$e = array(
	1 => array(
	
		"name" => $CORE->LAYOUT("captions","2"),
		"total" => number_format($count_posts->publish+$count_posts->draft+$count_posts->pending+$count_posts->trash,0),
		"icon" => $CORE->LAYOUT("captions","icon"),
		"color" => "#FFBB38",
        "bgcolor" => "#FFF5D9",
		"link" => "admin.php?page=listings",
		"btn_txt" => __("Manage","premiumpress"),
	),
    
    2 => array(
	
		"name" => __("Bidders","premiumpress"),
		"total" => $total_bidders_count,
		"icon" => "fas fa-clock",
		"color" => "#396AFF",
        "bgcolor" => "#E7EDFF",
		"link" => "admin.php?page=listings",
		"btn_txt" => __("Manage","premiumpress"),
	),
    
    3 => array(
	
		"name" => __("# of Bids","premiumpress"),
		"total" => $total_bids,
		"icon" => "fas fa-briefcase",
		"color" => "#FF82AC",
        "bgcolor" => "#FFE0EB",
		"link" => "admin.php?page=listings",
		"btn_txt" => __("Manage","premiumpress"),
	),
    
    4 => array(
	
		"name" => "Cars Sold",
		"total" => $total_winners,
		"icon" => "fas fa-database",
		"color" => "#004225",
        "bgcolor" => "#DAF4D9",
		"link" => "admin.php?page=listings",
		"btn_txt" => __("Manage","premiumpress"),
	),
    
     5 => array(
	
		"name" => __("New Users","premiumpress"),
		"total" => $registration_data['count'] . " " . $registration_data['interval'],
		"icon" => "fal  fa-users",
		"color" => "#D17AFF",
        "bgcolor" => "#F7E8FF",
		"link" => "admin.php?page=listings",
		"btn_txt" => __("Manage","premiumpress"),
	),
    
    6 => array(
	
		"name" => __("Auctions Revenue","premiumpress"),
		"total" => $CORE->ORDER("get_total", array()),
		"icon" => "fas fa-piggy-bank",
		"color" => "#16DBCC",
        "bgcolor" => "#DCFAF8",
		"link" => "admin.php?page=orders",
		"btn_txt" => __("View","premiumpress"),
	),	
 
	7 => array(
	
		"name" => __("Total Users","premiumpress"),
		"total" => number_format($count_users['total_users']),
		"icon" => "fal  fa-users",
		"color" => "#FFBB38",
        "bgcolor" => "#FFF5D9",
		"link" => "admin.php?page=members",
		"btn_txt" => __("Manage","premiumpress"),
	),
	

	8 => array(
	
		"name" => __("Total Dealers","premiumpress"),
		"total" => "5",
		"icon" => "fas fa-clock",
		"color" => "#396AFF",
        "bgcolor" => "#E7EDFF",
		"link" => "admin.php?page=orders",
		"btn_txt" => __("View","premiumpress"),
	),	
    
    9 => array(
	
		"name" => __("Escrow Orders","premiumpress"),
		"total" => "5",
		"icon" => "fas fa-briefcase",
		"color" => "#FF82AC",
        "bgcolor" => "#FFE0EB",
		"link" => "admin.php?page=orders",
		"btn_txt" => __("View","premiumpress"),
	),	
    
    10 => array(
	
		"name" => __("Finance Orders","premiumpress"),
		"total" => "50",
		"icon" => "fas fa-database",
		"color" => "#004225",
        "bgcolor" => "#DAF4D9",
		"link" => "admin.php?page=orders",
		"btn_txt" => __("View","premiumpress"),
	),	
    11 => array(
	
		"name" => __("Transport Orders","premiumpress"),
		"total" => "50",
		"icon" => "fal  fa-users",
		"color" => "#D17AFF",
        "bgcolor" => "#F7E8FF",
		"link" => "admin.php?page=orders",
		"btn_txt" => __("View","premiumpress"),
	),
    12 => array(
	
		"name" => __("Add-on Revenue","premiumpress"),
		"total" => "50",
		"icon" => "fal  fa-users",
		"color" => "#FFBB38",
        "bgcolor" => "#FFF5D9",
		"link" => "admin.php?page=orders",
		"btn_txt" => __("View","premiumpress"),
	),
	
	
	
);


$f = array(
	1 => array(
	
		"name" => __("User Research","premiumpress"),
		"icon" => "fas fa-search",
		"color" => "#FFBB38",
		"link" => "admin.php?page=membership",
	),
    
    2 => array(
	
		"name" => __("New Escrow Transaction","premiumpress"),
		"icon" => "fas fa-car-side",
		"color" => "#FFBB38",
		"link" => "<?php echo home_url(); ?>/escrow-back-end/",
	),
    
    3 => array(
	
		"name" => __("New Transport Trasaction","premiumpress"),
		"icon" => "fas fa-car",
		"color" => "#FFBB38",
		"link" => "<?php echo home_url(); ?>/credit-application/",
	),
    
    
    
    4 => array(
	
		"name" => __("Promote Action Listing","premiumpress"),
		"icon" => "fas fa-car-crash",
		"color" => "#FFBB38",
		"link" => "admin.php?page=listings",
	),
    
     5 => array(
		"name" => __("Overdue invoices","premiumpress"),
		"icon" => "fas fa-clipboard-list",
		"color" => "#FFBB38",
		"link" => "admin.php?page=listings",
	),
    
    6 => array(
		"name" => __("Escalate Issue","premiumpress"),
		"icon" => "fal fa-tv-retro",
		"color" => "#FFBB38",
		"link" => "admin.php?page=listings",
	)
	
	
	
);


function createDateRangeArray($strDateFrom,$strDateTo) {

 $aryRange=array();

  $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
  $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

  if ($iDateTo>=$iDateFrom) {
    array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry

    while ($iDateFrom<$iDateTo) {
      $iDateFrom+=86400; // add 24 hours
      array_push($aryRange,date('Y-m-d',$iDateFrom));
    }
  }
  return $aryRange;
}
function wlt_chartdata($query=0,$return=false){ global $wpdb; $STRING = "";

	// CHART DATA
	$DATE1 = date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")-5, date("Y")));
	$DATE2 = date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+1, date("Y")));	
	
	$dates = createDateRangeArray($DATE1,$DATE2); 
	
	$newdates = array();
	foreach($dates as $date){	  
	 $newdates[''.$date.''] = 0;
	}
 
	if($return){ return $newdates; }
 
	// GET ALL DATA FOR THE LAST 31 DAYS
	if($query == 0){
	
	$SQL1 = "select ".$wpdb->prefix."posts.post_date from ".$wpdb->prefix."posts where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' GROUP BY ID";
	
	// ORDERS
	}elseif($query == 1){
	
	$SQL1 = "select ".$wpdb->prefix."posts.post_date from ".$wpdb->prefix."posts where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='ppt_orders' GROUP BY ID";
	
	// PACKAGES
	}elseif($query == 2){
		$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='1' GROUP BY ID";
		
	// MEMBERS
	}elseif($query == 3){
	
	 
 
	$SQL1 = "select ".$wpdb->base_prefix."users.user_registered AS post_date from ".$wpdb->base_prefix."users where ".$wpdb->base_prefix."users.user_registered >= '".$DATE1."' and ".$wpdb->base_prefix."users.user_registered < '".$DATE2."' GROUP BY ID";
	
	 
	
	
	}elseif($query == 9){
	$SQL1 = "SELECT order_date AS post_date FROM ".$wpdb->prefix."core_orders LEFT JOIN ".$wpdb->users." ON (".$wpdb->users.".ID = ".$wpdb->prefix."core_orders.user_id) WHERE ".$wpdb->prefix."core_orders.order_date >= '".$DATE1."' and ".$wpdb->prefix."core_orders.order_date < '".$DATE2."'";
	}
 
	$result = $wpdb->get_results($SQL1);
 	if(!$result){ return 0; }
	
	foreach($result as $value){	 
	  	$postDate = explode(" ",$value->post_date);	 
		$newdates[$postDate[0]] ++;
	}	
 	 
	 
	// FORMAT RESULTS FOR CHART	
	$i=1;  
	foreach($newdates as $key=>$val){
		$a = $key; 
		if(!is_numeric($val)){$val=0; }
		 	
		//$STRING .= '['.$i.','.$val.'], ';
		
		$STRING .=  $val.", ";
		
		
		$i++;
				 
	}
	 
	
	// RETURN DATA	
	return $STRING;
 
 

}





 
// LOAD IN HEADER
// _ppt_template('framework/admin/header' ); 
 
?>



<section class="p-4">
    <div class="col-12">
        <div class="row pt-5">



            <?php if(defined('EPC_VERSION')){ ?>
            <div class="col-12">

                <div class="alert alert-danger">

                    <h4><i class="fa fa-exclamation-circle"></i> Important</h4> Your hosting provider has installed an
                    MU Caching plugin which may cause blank pages when you logout.<br />

                </div>

            </div>

            <?php } ?>






            <div class="col-12 mb-4"> <img
                    src="<?php echo esc_url( get_template_directory_uri() ); ?>/framework/images/premiumpress.png"
                    class="float-right position-absolute" style="right:20px; height:150px;opacity:0.1; top:-20px;" />

                <h4>Auction Dashboard</h4>
                <span>


                    <?php
  
  
  
$Hour = date('G', strtotime( date('Y-m-d H:i:s', strtotime(current_time( 'mysql' ) . "+1 minute")) ));

if ( $Hour >= 5 && $Hour <= 11 ) {
    echo __("Good Morning","premiumpress");
} else if ( $Hour >= 12 && $Hour <= 18 ) {
    echo __("Good Afternoon","premiumpress");
} else if ( $Hour >= 19 || $Hour <= 4 ) {
    echo __("Good Evening","premiumpress");
}
  
?>,


                    <strong> <?php echo $CORE->USER("get_name",$userdata->ID); ?></strong> </span>
                <span class="lead"><?php echo __("What would you like to do today?","premiumpress"); ?></span>

                <span class="text-muted"></span>
            </div>
            <div class="col-12">
                <div class="row flex-md-wrap">
                    <?php $i=1; while($i <= 12){ ?>
                    <div class="col-md-2 mb-2 p-2">
                        <div class="shadow-sm bg-white d-flex align-items-center"
                            style="border-radius: 20px; overflow:hidden; min-height: 109px;">
                            <div class="card-body position-relative pl-lg-4 row" style="gap:10px">

                                <div
                                    style="width:50.04px; height:50.04px; border-radius: 100%; display:flex; justify-content:center;align-items:center; background: <?php echo $e[$i]['bgcolor']; ?>">
                                    <i class="<?php echo $e[$i]['icon']; ?>"
                                        style="font-size:25px; color: <?php echo $e[$i]['color']; ?>"></i>
                                </div>
                                <div>
                                    <span style="color:#A1A1A1"><?php echo $e[$i]['name']; ?></span>
                                    <h6
                                        class="text-dark <?php if($i == 6){ echo $CORE->GEO("price_formatting",array()); } ?>">
                                        <?php echo $e[$i]['total']; ?></h6>
                                    <!--<a href="<?php echo $e[$i]['link']; ?>" class="btn btn-light rounded-0 btn-sm float-right mt-n3"><?php echo $e[$i]['btn_txt']; ?></a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++; } ?>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="row">
                    <div class="col-12 px-0">
                        <style>
                        .notice-warning {
                            margin-bottom: 40px;
                        }
                        </style>

                    </div>
                    <div class="col-md-8">
                        <div class="bg-white shadow-sm" style="border-radius: 20px;">
                            <div class="card-body">
                                <canvas height="250" width="600" id="myChart"></canvas>
                            </div>
                            <script>
                            jQuery(document).ready(function() {


                                window.chartColors = {
                                    red: 'rgb(255, 99, 132)',
                                    orange: 'rgb(255, 159, 64)',
                                    yellow: '#BF9B3E',
                                    green: '#668573',
                                    blue: '#4339F2',
                                    purple: 'rgb(153, 102, 255)',
                                    grey: 'rgb(201, 203, 207)'
                                };


                                var ctx = document.getElementById('myChart').getContext('2d');

                                var myChart = new Chart(ctx, {
                                    type: 'line',
                                    data: {

                                        labels: [
                                            <?php foreach($data as $h){ ?> "<?php echo $h['name']; ?>",
                                            <?php } ?>
                                        ],

                                        datasets: [{


                                                label: "<?php echo __("New","premiumpress")." ".$CORE->LAYOUT("captions","2"); ?>",

                                                backgroundColor: window.chartColors.red,
                                                borderColor: window.chartColors.green,
                                                data: [<?php echo wlt_chartdata(0); ?>],
                                                fill: false,
                                            },


                                            {
                                                label: "<?php echo __("New Orders","premiumpress"); ?>",
                                                fill: false,
                                                backgroundColor: window.chartColors.blue,
                                                borderColor: window.chartColors.blue,
                                                data: [<?php echo wlt_chartdata(1); ?>],
                                            },

                                            {
                                                label: "<?php echo __("New Users","premiumpress"); ?>",
                                                fill: false,
                                                backgroundColor: window.chartColors.yellow,
                                                borderColor: window.chartColors.yellow,
                                                data: [<?php echo wlt_chartdata(3); ?>],
                                            }

                                        ],
                                    },
                                    options: {
                                        responsive: true,
                                        title: {
                                            display: false,
                                            text: 'Reports'
                                        },
                                        tooltips: {
                                            mode: 'index',
                                            intersect: false,
                                        },
                                        hover: {
                                            mode: 'nearest',
                                            intersect: true
                                        },
                                        scales: {
                                            xAxes: [{
                                                display: true,
                                                scaleLabel: {
                                                    display: true,
                                                    labelString: 'Month'
                                                }
                                            }],
                                            yAxes: [{
                                                display: true,
                                                scaleLabel: {
                                                    display: true,
                                                    labelString: 'Value'
                                                }
                                            }]
                                        },
                                    },
                                });

                            });
                            </script>
                        </div>



                        <!-- All Bids block start -->
                        <div class="bg-white shadow-sm mt-3 d-none" style="border-radius: 20px;">
                            <div class="card-body">




                                <ul id="all-bids" class="nav justify-content-start nav-pills mb-3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="bids-tab active" id="pills-bids-all-tab" data-toggle="pill"
                                            data-target="#pills-bids-all" type="button" role="tab"
                                            aria-controls="pills-bids-all" aria-selected="true">All Bids</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="bids-tab" id="pills-active-bids-tab" data-toggle="pill"
                                            data-target="#pills-active-bids" type="button" role="tab"
                                            aria-controls="pills-active-bids" aria-selected="false">Active Bids</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="bids-tab" id="pills-closed-bids-tab" data-toggle="pill"
                                            data-target="#pills-closed-bids" type="button" role="tab"
                                            aria-controls="pills-closed-bids" aria-selected="false">Closed Bid</a>
                                    </li>
                                </ul>


                                <?php
                
                
 

 // Fetch all posts of type 'listing_type'
$all_listings = get_posts(array(
    'post_type' => 'listing_type',
    'posts_per_page' => -1,
    'post_status' => array('publish', 'closed') // Fetch both active and closed listings
));

$active_bids = [];
$closed_bids = [];
$all_bids = []; // To store all bids

foreach ($all_listings as $listing) {
    $post_id = $listing->ID;
    $bidding_history = get_post_meta($post_id, 'current_bid_data', true);

    if (!is_array($bidding_history)) {
        $bidding_history = array();
    }

    // Sort bid history by date
    uksort($bidding_history, 'order_bidhiustory_bykey');
    $bidding_history = array_reverse($bidding_history, true);

    // Group bids based on post status
    if ($listing->post_status == 'publish') {
        if (!empty($bidding_history)) {
            $active_bids[$post_id] = $bidding_history;
            $all_bids[$post_id] = $bidding_history; // Add to all bids
        }
    } else {
        if (!empty($bidding_history)) {
            $closed_bids[$post_id] = $bidding_history;
            $all_bids[$post_id] = $bidding_history; // Add to all bids
        }
    }
}

 


echo '<div class="tab-content" id="pills-tabContent">';

echo '<div class="tab-pane fade show active" id="pills-bids-all" role="tabpanel" aria-labelledby="pills-bids-all-tab">';
if (!empty($all_bids)) {
echo '<div class="table" >';
            echo '<div> <div  class="d-flex" style=" margin-bottom:5px; color: #909090; font-family: Inter; font-style: normal; font-weight: 400;"><div class="col">Bid Number</div> <div class="col">Car Name</div> <div class="col">Bidder Name </div> <div class="col">Bid Amount</div> <div class="col">Bid Type</div> <div class="col"></div> </div> </div>';
            
    echo display_bids($all_bids);
    echo '</div>';
    
} else {
    echo '<div class="py-4 text-center"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/Group222.png" /><br><h6><i class="fal fa-frown mr-2"></i> ' . __("There's nothing here yet.", "premiumpress") . '</h6></div>';
}
echo '</div>';

echo '<div class="tab-pane fade" id="pills-active-bids" role="tabpanel" aria-labelledby="pills-active-bids-tab">';
if (!empty($active_bids)) {

echo '<div class="table" >';
            echo '<div> <div  class="d-flex" style=" margin-bottom:5px; color: #909090; font-family: Inter; font-style: normal; font-weight: 400;"><div class="col">Bid Number</div> <div class="col">Car Name</div> <div class="col">Bidder Name </div> <div class="col">Bid Amount</div> <div class="col">Bid Type</div> <div class="col"></div> </div> </div>';
    echo display_bids($active_bids);
    echo '</div>';
} else {
    echo '<div class="py-4 text-center"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/Group222.png" /><br><h6><i class="fal fa-frown mr-2"></i> ' . __("There's nothing here yet.", "premiumpress") . '</h6></div>';
}
echo '</div>';

echo '<div class="tab-pane fade" id="pills-closed-bids" role="tabpanel" aria-labelledby="pills-closed-bids-tab">';
if (!empty($closed_bids)) {
echo '<div class="table" >';
            echo '<div> <div  class="d-flex" style=" margin-bottom:5px; color: #909090; font-family: Inter; font-style: normal; font-weight: 400;"><div class="col">Bid Number</div> <div class="col">Car Name</div> <div class="col">Bidder Name </div> <div class="col">Bid Amount</div> <div class="col">Bid Type</div> <div class="col"></div> </div> </div>';
    echo display_bids($closed_bids);
    echo '</div>';
} else {
    echo '<div class="py-4 text-center"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/Group222.png" /><br><h6><i class="fal fa-frown mr-2"></i> ' . __("There's nothing here yet.", "premiumpress") . '</h6></div>';
}
echo '</div>';

echo '</div>';

    


function display_bids($bids_group) {
    ob_start();

    $has_bids = false;

    foreach ($bids_group as $post_id => $bids) {
        // Check if there are bids for any post
        if (!empty($bids)) {
            $has_bids = true;
            
            
            foreach ($bids as $date => $bhistory) {
                echo '<div  class="deletebid' . $date . ' d-flex"  style="font-size:12px; padding:10px 5px; margin-bottom:5px; border-radius: 6px;background: #F5F7FA;">';
                echo '<div class="col">' . $date . '</div>';
                echo '<div class="col"><a href="' . admin_url() . '/admin.php?page=listings&eid=' . $post_id . '">' . get_the_title($post_id) . '</a></div>';
                echo '<div class="col"><a href="' . get_author_posts_url($bhistory['userid']) . '">' . $bhistory['user'] . ' (' . $bhistory['userid'] . ')</a></div>';
                echo '<div class="col">' . hook_price($bhistory['amount']) . '</div>';
                echo '<div class="col">' . $bhistory['bid_type'] . '</div>';
                echo '<div class="col"><a href="javascript:void(0);" onclick="auction_delete_bid(' . $date .', ' . $post_id . ');"><i
												class="fa fa-times"></i></a></div>';
                echo '</div>';
            }
            
           
        }
    }

    // If no bids are found across all posts, show the message
    if (!$has_bids) {
        echo '<div class="py-4 text-center"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/08/Group222.png" /><br><h6><i class="fal fa-frown mr-2"></i> ' . __("There's nothing here yet.", "premiumpress") . '</h6></div>';
    }

    return ob_get_clean();
}



function order_bidhiustory_bykey($a, $b)
	{
		if ($a == $b)
			$r = 0;
		else
			$r = ($a > $b) ? 1 : -1;
		return $r;
	}




                
  ?>


                                <script>
                                function auction_delete_bid(bid, postid) {

                                    // RESET
                                    jQuery('.deletebid' + bid).removeClass('d-flex').hide();

                                    jQuery.ajax({
                                        type: "POST",
                                        url: '<?php echo home_url(); ?>/',
                                        dataType: 'json',
                                        data: {
                                            admin_action: "auction_deletebid",
                                            pid: postid,
                                            bid: bid,
                                        },
                                        success: function(response) {
                                            if (response.status == "ok") {

                                            } else {

                                            }
                                        },
                                        error: function(e) {
                                            console.log(e)
                                        }
                                    });

                                }
                                </script>



                            </div><!-- Close Body -->
                        </div> <!-- All Bids block closed -->


                        <div class="bg-white shadow-sm mt-3" style="border-radius: 20px;">
                            <div class="card-body">
                                <h6 class="my-2">New Leads</h6>


                                <?php

echo '<div>';
echo '<div class="d-flex" style="margin-bottom:5px; color: #909090; font-family: Inter; font-style: normal; font-weight: 400;">';
echo '<div class="col">Form Name</div>';
echo '<div class="col">Last Submission</div>';
echo '<div class="col">Views</div>';
echo '<div class="col">Submissions</div>';
echo '<div class="col">Conversion Rate</div>';
echo '</div>';

echo display_all_leads('Escrow Orders', 318301);
echo display_all_leads('Finance Applications', 324878);

echo '</div>';

function display_all_leads($formName, $form_id) {
    global $wpdb;

    // Total Submissions
    $total_submissions = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT COUNT(*) FROM wp_frmt_form_entry WHERE form_id = %d",
            $form_id
        )
    );

    // Last Submission Date
    $last_submission = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT MAX(date_created) FROM wp_frmt_form_entry WHERE form_id = %d",
            $form_id
        )
    );

    // Format the last submission date
    $formatted_last_submission = $last_submission ? date('M d, Y @ g:i A', strtotime($last_submission)) : 'N/A';

    // Total Views
    $form_view = Forminator_Form_Views_Model::get_instance();
    $total_views = $form_view->count_views($form_id);

    // Conversion Rate
    $conversion_rate = $total_views > 0 ? round(($total_submissions / $total_views) * 100, 2) : 0;

    // Build the HTML output
    $output = '<div class="d-flex" style="font-size:12px; padding:10px 5px; margin-bottom:5px; border-radius: 6px;background: #F5F7FA;">';
    $output .= '<div class="col">' . $formName . '</div>';
    $output .= '<div class="col">' . $formatted_last_submission . '</div>';
    $output .= '<div class="col">' . $total_views . '</div>';
    $output .= '<div class="col">' . $total_submissions . '</div>';
    $output .= '<div class="col">' . $conversion_rate . '%</div>';
    $output .= '</div>';

    return $output;
}

?>



                            </div><!-- Close Body -->

                        </div> <!-- New Leads block closed -->


                        <?php //  _ppt_template('framework/design/account/parts/_chat'); ?>


                    </div><!-- col-8 closed -->

                    <div class="col-md-4">
                        <div class="bg-white shadow-sm" style="border-radius: 20px;">
                            <div class="card-body">
                                <div class="row flex-md-wrap">
                                    <?php $i=1; while($i <= 6){ ?>
                                    <a class="col-md-6 mb-2 p-2" href="<?php echo $f[$i]['link']; ?>" target="blank">
                                        <div class="d-flex align-items-center justify-content-between"
                                            style="background:#F5F7FA; border-radius: 20px; overflow:hidden; min-height: 109px;">
                                            <div class="card-body position-relative pl-lg-4 row">

                                                <div class="col-3 p-0">
                                                    <div
                                                        style="width:50.04px; height:50.04px; border-radius: 100%; display:flex; justify-content:center;align-items:center; background: #014127">
                                                        <i class="<?php echo $f[$i]['icon']; ?>"
                                                            style="font-size:20px; color: white;"></i>
                                                    </div>
                                                </div>
                                                <div class="col-7">
                                                    <span
                                                        style="color:#014127; font-size:12px;"><?php echo $f[$i]['name']; ?></span>
                                                </div>

                                                <span class="col-2 p-0"><i class="fas fa-external-link-alt"
                                                        style="color:#014127"></i></span>

                                            </div>
                                        </div>
                                    </a>
                                    <?php $i++; } ?>
                                </div>
                            </div>
                        </div>


                        <div class="bg-white shadow-sm mt-3" style="border-radius: 20px;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6><?php echo __("Recent Activity","premiumpress"); ?></h6>
                                    <a href="admin.php?page=reports" class="btn btn-light rounded-pill"><i
                                            class="fa fa-arrow-right"></i>
                                        <small><?php echo __("View All Activity","premiumpress"); ?></small></a>
                                </div>
                                <hr />
                                <?php

 
$wp_query = new WP_Query( array( 'post_type' => 'ppt_logs', 'posts_per_page' => 8  )); 

$tt = $wpdb->get_results($wp_query->request, OBJECT);
if ( $wp_query->have_posts() ) {
     
	 
	 while ( $wp_query->have_posts() ) {
    $wp_query->the_post();
	  
	    
		$data = $CORE->FUNC("format_logtype", $wp_query->post->ID );
		$user_id = $data['userid'];
		
		if(!is_numeric($user_id)){ continue; }
		 
		?>
                                <div class="row no-gutters d-flex align-items-center mb-2 recentactivity pb-2"
                                    style="font-size:12px; padding:10px 5px; border-radius: 6px;background: #F5F7FA;">
                                    <div class="col-md-1"> <a href="<?php echo get_author_posts_url($user_id); ?>"
                                            class="text-dark" target="_blank" style="overflow:hidden;">
                                            <div style="padding: 3px;
    border-radius: 100%;
    background: #014127;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;">
                                                <?php  echo str_replace("avatar ","avatar img-fluid ",get_avatar( $user_id, 20 )); ?>
                                            </div>
                                        </a> </div>
                                    <div class="col-md-4 text-center text-muted small">
                                        <div><i class="fal fa-clock text-secondary"></i> <span
                                                class="text-black"><?php echo $data['time']; ?></span></div>
                                    </div>
                                    <div class="col-md-7">
                                        <i class="<?php echo $data['icon']; ?> float-left pr-1 text-secondary"></i>
                                        <div class="small text-black"><?php echo $data['name']; ?></div>
                                        <div class="tiny mt-2 text-muted small">
                                            <?php echo $data['desc']; ?>
                                        </div>
                                    </div>


                                </div>
                                <?php

	  
	  }
}else{
?>
                                <div class="text-muted"><?php echo __("No recent activity.","premiumpress"); ?></div>
                                <?php } ?>
                            </div>
                        </div> <!-- Recent activity closed -->


                        <div class="bg-white shadow-sm mt-3" style="border-radius: 20px;">
                            <div class="card-body">
                                <h6><?php echo __("New Users","premiumpress"); ?></h6>
                                <ul class="list-group list-group-flush">
                                    <?php
 $i=0;
while($i < 6){

	$DATE1 = date("Y-m-d",mktime(0, 0, 0, date("m")-$i, 1, date("Y")));
	$DATE2 = date("Y-m-d",mktime(0, 0, 0, date("m")-$i, 30, date("Y")));
 

	if($i == 0){
	$days = 0;
	}else{
	$days = $i * 28;
	}
	
	$count = $wpdb->get_var("SELECT count(*) FROM ".$wpdb->base_prefix."users WHERE  ".$wpdb->base_prefix."users.user_registered >= '".$DATE1."' and ".$wpdb->base_prefix."users.user_registered < '".$DATE2."' ");

?>
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0 text-muted">
                                        <span
                                            class="small"><?php echo date('F Y', strtotime("-".$days." days")); ?></span>
                                        <span
                                            class="badge <?php if($count > 0){ ?>bg-success<?php }else{ ?>bg-secondary<?php } ?> text-white badge-pill">
                                            <?php echo $count; ?> </span> </li>
                                    <?php
$i++;
} 
?>
                                </ul>
                            </div>
                        </div> <!-- New users -->



                    </div><!-- col-4 closed -->


                    <div class="col-md-12 ">


                        <!-- New Orders block start -->
                        <div class="bg-white shadow-sm mt-5" style="border-radius: 20px;">
                            <div class="card-body">

                                <div id="loadingSpinner" class="spinner-overlay" style="display:none;">
                                    <div class="spinner-grow text-light" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>


                                <ul id="new-leads" class="nav justify-content-start nav-pills mb-3" role="tablist">
                                    <!-- <li class="nav-item" role="presentation">
                        <a class="active" id="pills-auction-orders-tab" data-toggle="pill"
                            data-target="#pills-auction-orders" type="button" role="tab" aria-controls="pills-auction-orders"
                            aria-selected="true">Auction Orders</a>
                    </li> -->
                                    <li class="nav-item" role="presentation">
                                        <a class="bids-tab active" id="pills-escrow-orders-tab" data-toggle="pill"
                                            data-target="#pills-escrow-orders" type="button" role="tab"
                                            aria-controls="pills-escrow-orders" aria-selected="true">Escrow Orders</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="bids-tab" id="pills-finance-applications-tab" data-toggle="pill"
                                            data-target="#pills-finance-applications" type="button" role="tab"
                                            aria-controls="pills-finance-applications" aria-selected="false">Finance
                                            Applications</a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="bids-tab" id="pills-transport-orders-tab" data-toggle="pill"
                                            data-target="#pills-transport-orders" type="button" role="tab"
                                            aria-controls="pills-transport-orders" aria-selected="false">Transport
                                            Orders</a>
                                    </li>

                                </ul>



                                <div class="tab-content" id="pills-order-content">

                                    <div class="tab-pane fade" id="pills-auction-orders" role="tabpanel"
                                        aria-labelledby="pills-auction-orders-tab">
                                        <?php // _ppt_template('framework/admin/parts/orders-table-dashboard' ); ?>
                                    </div>

                                    <div class="tab-pane fade show active" id="pills-escrow-orders" role="tabpanel"
                                        aria-labelledby="pills-escrow-orders-tab">
                                        <?php _ppt_template('framework/admin/account-escrow-data'); ?>
                                    </div>


                                    <div class="tab-pane fade " id="pills-finance-applications" role="tabpanel"
                                        aria-labelledby="pills-finance-applications-tab">
                                        <?php _ppt_template('framework/admin/account-finance-data'); ?>
                                    </div>

                                    <div class="tab-pane fade " id="pills-transport-orders" role="tabpanel"
                                        aria-labelledby="pills-transport-orders-tab">

                                    </div>


                                </div> <!-- Orders tab content closed -->


                            </div><!-- Close Body -->
                        </div> <!-- New Orders block closed -->


                    </div>

                    <div class="col-md-4">

                    </div>

                </div>
</section>





<div id="popupDisclaimer">
    <div class="modal-dialog">
        <div class="modal-content bg-white position-relative" style="border-radius:20px;">
            <button onclick="jQuery('#popupDisclaimer').fadeOut(400);" type="button" class="btn btn-light rounded-pill"
                style="position: absolute; right: 30px; top: 15px; z-index:5;"><i class="fal fa-times"></i></button>
            <div class="modal-body">

            </div>

        </div>
    </div>
</div>

<style>
/* Style for the popup */
#popupDisclaimer {
    display: none;
    position: fixed;
    top: 0px;
    right: 0;
    bottom: 0;
    left: 0;
    outline: 0;
    z-index: 9999;
    overflow-x: hidden;
    overflow-y: auto;
    /* padding-right: 17px; */
    /* opacity: 1; */
    transition: opacity .15s linear;
    background: #0000008a;
    width: 100%;
    align-items: center;
    justify-content: center;
}


#popupDisclaimer .modal-content {
    padding: 20px;
    border-radius: 20px;
}



@media (min-width: 576px) {
    #popupDisclaimer .modal-dialog {
        max-width: 70%;
        margin: 1.75rem auto;
    }

    .c29 {
        background-color: #ffffff;

        padding: 72pt 72pt 72pt 72pt
    }
}
</style>




<style>
ul#all-bids {
    border-bottom: 1px solid #ddd;
}

ul#all-bids.nav li {
    padding: 0px;
    margin-bottom: 0px;
}



ul#all-bids.nav li a {
    padding: 5px 20px 5px 20px;
    background: white;
    color: #909090;
    border: 1px solid #fff0;

}

ul#all-bids.nav li a.active {
    font-weight: bold;
    color: #202224;
    border-bottom: 1px solid #000;
}

ul#new-leads {
    border-bottom: 1px solid #ddd;
}

ul#new-leads.nav li {
    padding: 5px;
    margin-bottom: 0px;
}



ul#new-leads.nav li a {
    padding: 5px 20px 5px 20px;
    background: white;
    color: #909090;
    border: 1px solid #fff0;

}

ul#new-leads.nav li a.active {
    font-weight: bold;
    color: #202224;
    border-bottom: 1px solid #000;
}

.avatar.img-fluid {
    border-radius: 100%;
    width: 20px;
    height: 20px;
}



/* Step Process Start */


.progress-container {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin-bottom: 30px;
    width: 100%;
}

.progress-container::before {
    content: '';
    background-color: #ddd;
    position: absolute;
    left: 20px;
    transform: translateY(-50%);
    height: 1px;
    width: calc(100% - 30px);
    z-index: 0;
}

.progress {
    background-color: #3B634C;
    position: absolute;
    left: 20px;
    transform: translateY(-50%);
    height: 1px;
    width: 0%;
    z-index: 0;
    transition: 400ms ease;
}

.step-wrap {
    display: grid;
    text-align: center;
    width: 50px;
    z-index: 1;
    justify-content: center;
    justify-items: center;
}

.step-wrap p {

    color: #aaa;
}

.step-wrap.active p {
    font-weight: 500;
    color: #000;
    transition: 400ms ease;
}

.circle {
    background-color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 400ms ease;
}


.circle .step-title {
    border-radius: 50%;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #BC9F4C;
    font-weight: 400;
    font-size: 10px;
}

.step-wrap.active .circle {
    border-color: #BC9F4C;
}

.step-wrap.active .step-title {
    background-color: #124326;
    box-shadow: none;
    color: #fff;
}


.btn:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}


@media screen and (min-width: 500px) {
    .circle {

        border: 4px solid #f8f9fa;

        height: 35px;
        width: 35px;
    }

    .progress-container::before {

        top: 18px;
    }

    .progress {
        top: 18px;
    }

    .step-wrap p {
        font-weight: 400;
        font-size: 10px;
    }

}

@media screen and (max-width: 500px) {
    .circle {
        border: 2px solid #f8f9fa;
        height: 25px;
        width: 25px;
    }

    .progress-container::before {
        top: 13px;
    }

    .progress {
        top: 13px;
    }

    .step-wrap p {
        font-weight: 400;
        font-size: 7px;
    }

}

/* Step Process Stop */



.spinner-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
</style>

<?php


// _ppt_template('framework/admin/footer' ); 
?>