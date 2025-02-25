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
 
// GET USER PROFILE VIEWS
$totalviews = $CORE->USER("get_views",  array($userdata->ID, "all") );
 
$i = 0;
while($i < 7){
 
	$value = 0;
	$value += $CORE->USER("get_views", array($userdata->ID,  date('Y-m-d', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) ) );			
	 
		
	// DATA
	$data[] = array("name" => date('jS', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) , "value" => $value);		
		
	$i++;
}
 
?>

<div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
            
            
            <h6><?php echo __("Profile Visitors","premiumpress"); ?> <?php echo number_format($totalviews); ?></h6>
            <p>asd asd asd</p>
            
            </div>
            <div class="card-body">
            
            

 
<canvas height="156"  width="553" id="myChart1" ></canvas>


</div></div>

<script>
var ctx = document.getElementById('myChart1').getContext('2d');
 
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        
		labels:[<?php foreach($data as $h){ ?>"<?php echo $h['name']; ?>",<?php } ?>],
		
        datasets: [{
            
            data:[<?php foreach($data as $h){ ?><?php echo $h['value']; ?>,<?php } ?>],

			label:"<?php echo __("views","premiumpress"); ?>",
			
			
			fill:!0,
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