<?php
 
add_filter( 'ppt_blocks_args', 	array('block_contact2',  'data') );
add_action( 'contact2',  		array('block_contact2', 'output' ) );
add_action( 'contact2-css',  	array('block_contact2', 'css' ) );
add_action( 'contact2-js',  	array('block_contact2', 'js' ) );

class block_contact2 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['contact2'] = array(
			"name" 	=> "Style 2",
			"image"	=> "contact2.jpg",
			"cat"	=> "contact",
			"desc" 	=> "", 
			"data" 	=> array( ),
			"order" => 2,				
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	
	
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("contact2", "contact", $settings ) );   
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
	 
	ob_start();
	?><section class="no-divider" style="margin-bottom:-40px; min-height:500px;">
 <div class="container">
	<div class="cont-top card bg-white border-0 shadow-sm">
	<div class="row">
	 <div class="col-md-4 ">
	 	<div class="item-01">
	 		<div class="icon-01">
	 	    <i class="fal fa-home"></i>
	 		</div>
	 		<div class="text-02">
	 		<h3><?php echo __("Address","premiumpress") ?></h3>
	 		<p><?php echo _ppt(array('company','address')); ?></p>
	 		</div>	
	 	</div>
	 	</div>	
	 	<div class="col-md-4">
	 	<div class="item-01">
	 		<div class="icon-01">
	 		<i class="fal fa-envelope" aria-hidden="true"></i>	
	 		</div>
	 		<div class="text-02">
	 		<h3><?php echo __("Email","premiumpress") ?></h3>
	 		<h6 class="mb-0 mt-3"><?php echo _ppt(array('company','email')); ?></h6>
	 	 
	 		</div>	
	 	</div>
	 	</div>	
	 	<div class="col-md-4">
	 	<div class="item-01">
	 		<div class="icon-01">
	 		<i class="fal fa-phone" aria-hidden="true"></i>	
	 		</div>
	 		<div class="text-02">
	 		<h3><?php echo __("Phone","premiumpress") ?></h3>
	 		<h6 class="mb-0 mt-3"><?php echo _ppt(array('company','phone')); ?></h6>
	 		</div>	
	 	</div>
	 	</div>	
	</div>	
	</div>
</div>
<div class="card-map">
<div id="map" style="min-height:400px; width:100%;"></div>
</div>


</section>
<div class="clearfix"></div>
<script>
					var map;
					function initMap1() {
					  map = new google.maps.Map(document.getElementById('map'), {
					    center: {lat: <?php echo _ppt(array('company','map-lat')); ?>, lng: <?php echo  _ppt(array('company','map-log')); ?>},
					    zoom: 8
					  });
					}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo _ppt(array('maps','apikey')); ?>&callback=initMap1" async defer></script>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		 
		ob_start();
		?>
 <style>
 .cont-top{
margin-top: 120px;
background-color: #F8F9F9 ;
padding: 20px 40px;
 

}
.cont-top .icon-01{
font-size:30px;
float:left;
padding-right: 30px;
margin-top:0px;
}
.cont-top .icon-02 {
	margin-left:50px;
}
.cont-top .text-02{
	margin-left:60px;
}
.cont-top .text-02 a{
	color:#566573 ;
}
.card-map{
	position: absolute;
	margin-top:-80px;
	z-index:-1;
	width: 100%;
}
 </style>
        <?php	
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
		public static function js(){
		return "";
		ob_start();
		?>
 
        <?php	
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;
		}	
}

?>