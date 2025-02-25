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

global $CORE;

$emaillogs = get_option('ppt_emaillogs');
if(!is_array($emaillogs)){ $emaillogs = array(); }

 
$i = 0; $data = array();
while($i < 7){
 
	$value = 0;
	 
	$date = date('Y-m-d', strtotime('-'.$i.' day', strtotime( date('Y-m-d') )));
	
	if(isset($emaillogs[$date])){
		$value = $emaillogs[$date]['hits'];
	}
	 
		
	// DATA
	$data[] = array("name" =>  date('jS M', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) , "value" => $value);		
		
	$i++;
}
 
 
function reverseArray($arr){
	 
	$start=0;
	$a = array();
    $i=6;
    while ($i > -1) 
    { 
	
	 	if(is_array($arr[$i])){
        $a[] = $arr[$i];
		}
		 
        $i--; 
    }  
	 
	return $a;	 
	
}  
 
$data = reverseArray($data);
 


?>

   <style>
   
   #overview-box { display:none; }
   </style> 

 


<div class="card card-body shadow-sm mb-5">

<canvas height="200" width="600" id="myChart"></canvas>
</div>

<script>
jQuery(document).ready(function() {

var ctx = document.getElementById('myChart').getContext('2d');
 
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
	
        labels:[<?php foreach($data as $h){ ?>"<?php echo $h['name']; ?>",<?php } ?>],
		
        datasets: [{
            
            data:[<?php foreach($data as $h){ ?><?php echo $h['value']; ?>,<?php } ?>],

			label:"<?php echo __("emails sent","premiumpress"); ?>",
			
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
 scales:{xAxes:[{ticks:{fontSize:"11",fontColor:"#969da5"},gridLines:{color:"rgba(0,0,0,0.05)",zeroLineColor:"rgba(0,0,0,0.05)"}}],yAxes:[{display:!1,ticks:{beginAtZero:!0,max:65}}]
  
        }
    }
});

});
</script>
 

<div id="overviewlist" class="row"> </div>  