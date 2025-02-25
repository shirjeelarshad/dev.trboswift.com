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

global $CORE, $userdata; $data = array();
 
 
 switch(THEME_KEY){
	  
	  	case "da": {
		
			$title = __("Profile Visitors","premiumpress");
			
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
			
			// GET USER PROFILE VIEWS
			$totalviews = $CORE->USER("get_rating_likes",  array($userdata->ID, "all") );
			  
			$i = 0; $data1 = array();
			while($i < 7){
			 
				$value = $CORE->USER("get_rating_likes", array($userdata->ID,  date('Y-m-d', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) ) );	
			 
				// DATA
				$data1[] = array("name" => date('jS', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) , "value" => $value);		
					
				$i++;
			}


		
		} break;
		
		default: {
			 	
				if(THEME_KEY == "ll"){
				$title = __("My Course Visitors","premiumpress");
				}else{
				$title = __("My Ad Visitors","premiumpress");
				}
				
				// UPDATE VIEW COUNTER
				
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
					$data[] = array("name" => date('jS', strtotime('-'.$i.' day', strtotime( date('Y-m-d') ))) , "value" => $value);		
						
					$i++;
				}	 
							
		} break;
		 
		
	  }


 
?>


<div class="card mb-4">
  <div class="card-header border-0 bg-white">
    <h4 class="mb-0 text-black"><i class="fal fa-chart-bar mr-2"></i> <?php echo $title; ?></h4>
  </div>
  <div class="card-body text-center border-top position-relative"  style="min-height:300px;">
    <?php if( !$CORE->USER("membership_hasaccess", "visitor_chart") ){  ?>
    <div style="position:absolute; top:0; right:0;     width: 100%;    height: 100%;" class="bg-white y-middle">
      <div class="p-4 text-center">
        <h4><i class="fal fa-lock mr-2"></i> <?php echo __("No Access","premiumpress"); ?></h4>
        <div class="mt-4 small"><?php echo __("Please upgrade your membership to access this feature.","premiumpress"); ?></div>
        <a href="javascript:void(0);" onclick="SwitchPage('membership');" class="btn btn-system btn-md mt-4"><?php echo __("View My Membership","premiumpress"); ?></a> </div>
    </div>
    <?php }else{ ?>
    <?php if(is_array($data) && !empty($data)){ ?>
<script>
 

jQuery(document).ready(function(){
 radialChart1();
});

var radialChart1 = function(){
var options = {
          series: [
		  
		  {
            name: "<?php echo __("User Views","premiumpress"); ?>",
          data:[<?php foreach($data as $h){ ?><?php echo $h['value']; ?>,<?php } ?>],
        },
		
		<?php if(THEME_KEY == "da"){ ?>
		{
          name: "<?php echo __("User Likes","premiumpress"); ?>",
          data:[<?php foreach($data1 as $h){ ?><?php echo $h['value']; ?>,<?php } ?>],
        }
		<?php } ?>
		 
		],
          chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: '<?php echo __("Views This Week","premiumpress"); ?>',
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
           		  categories:[<?php foreach($data as $h){ ?>"<?php echo $h['name']; ?>",<?php } ?>],
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart1"), options);
        chart.render();

}
		
  
</script>
<?php } ?>
    <div id="chart1"></div>
    <?php } ?>
  </div>
</div>
