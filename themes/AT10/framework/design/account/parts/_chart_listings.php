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
 
// UPDATE VIEW COUNTER
$data_listingviews = array();
$listing_ids = $CORE->PACKAGE("get_user_listing_ids", $userdata->ID);

// COUNT TOTALS
$totalcount = 0;
if(is_array($listing_ids) && !empty($listing_ids) ){
	foreach($listing_ids as $pid){	
		$totalcount = $totalcount +  $CORE->PACKAGE("get_hits",  array($pid, "all") );		
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
	$data_listingviews[] = array("name" => date('jS', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) , "value" => $value);		
		
	$i++;
}
 
 
?>

<div class="el-tablo bigger highlight bold-label mt-4">
  <div class="value display-4 font-weight-bold"><?php echo number_format($totalcount); ?></div>
  <div class="text-muted"><?php echo $CORE->LAYOUT("captions",1)." ".__("Visitors","premiumpress"); ?></div>
</div>
<canvas id="myChart" style="width:100%; height:120px;"></canvas>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
 
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
	
        labels:[<?php foreach($data as $h){ ?>"<?php echo $h['name']; ?>",<?php } ?>],
		
        datasets: [{
            
            data:[<?php foreach($data as $h){ ?><?php echo $h['value']; ?>,<?php } ?>],

			label:"<?php echo __("views","premiumpress"); ?>",
			
			
 lineTension:.3,
 backgroundColor:"#fff",
 borderColor:"#047bf8",
 borderCapStyle:"butt",
 borderDash:[],
 borderDashOffset:0,
 borderJoinStyle:"miter",
 pointBorderColor:"#fff",
 pointBackgroundColor:"#141E41",
 pointBorderWidth:3,
 pointHoverRadius:10,
 pointHoverBackgroundColor:"#FC2055",
 pointHoverBorderColor:"#fff",
 pointHoverBorderWidth:3,
 pointRadius:5,
 pointHitRadius:10,
			 
			spanGaps:!1

        }]
    },
    options:{
 
 legend:{display:!1},
 scales:{xAxes:[{ticks:{fontSize:"11",fontColor:"#969da5"},gridLines:{color:"rgba(0,0,0,0.05)",zeroLineColor:"rgba(0,0,0,0.05)"}}],yAxes:[{display:!1,ticks:{beginAtZero:!0,max:150}}]
  
        }
    }
});
</script>