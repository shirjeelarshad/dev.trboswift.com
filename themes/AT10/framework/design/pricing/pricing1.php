<?php
 
add_filter( 'ppt_blocks_args', 	array('block_pricing1',  'data') );
add_action( 'pricing1',  		array('block_pricing1', 'output' ) );
add_action( 'pricing1-css',  	array('block_pricing1', 'css' ) );
add_action( 'pricing1-js',  	array('block_pricing1', 'js' ) );

class block_pricing1 {

	function __construct(){}		

	public static function data($a){ global $CORE;
  
		$a['pricing1'] = array(
			"name" 	=> "Style 1",
			"image"	=> "pricing1.jpg",
			"cat"	=> "pricing",
			"desc" 	=> "", 
			"data" 	=> array( ),
			
			"defaults" => array(
					
					// TEXT
						
					"title_show" 		=> "yes",
					"title_style" 		=> "1",
					"title_heading" 	=> "h2",
					"title_pos" 		=> "center",
					
					"title" 			=> $CORE->LAYOUT("get_placeholder_text", array('title', "pricing") ),					 
					"subtitle"			=> "",					
					"desc" 				=> $CORE->LAYOUT("get_placeholder_text", array('subtitle', "pricing") ),
					 	
					"title_margin"		=> "mb-3",
					"subtitle_margin"	=> "",
					"desc_margin" 		=> "",					
					
					"title_font" 		=> "",
					"subtitle_font" 	=> "",
					"desc_font" 		=> "",
					 
					"title_txtcolor" 	=> "dark",
					"subtitle_txtcolor" => "primary",
					"desc_txtcolor" 	=> "opacity-5",
					
					"title_txtw" 		=> "",
					"subtitle_txtw" 	=> "",
					 
					
					// BUTTON					
					"btn_show" 			=> "no",						
					"btn_style" 		=> "1",				
					"btn_size" 			=> "",
					"btn_icon" 			=> "",				
					"btn_icon_pos" 		=> "",
					"btn_font" 			=> "",
					"btn_txt" 			=> "",
					"btn_link" 			=> "",
					"btn_bg" 			=> "",
					"btn_bg_txt" 		=> "",					
					"btn_margin" 		=> "mt-4",
					 			
					
					// BUTTON				
					"btn2_show" 		=> "no",						
					"btn2_style" 		=> "2",				
					"btn2_size" 		=> "",
					"btn2_icon" 		=> "",				
					"btn2_icon_pos" 	=> "",
					"btn2_font" 		=> "",
					"btn2_txt" 			=> "",
					"btn2_link" 		=> "",
					"btn2_bg" 			=> "",
					"btn2_bg_txt" 		=> "",					
					"btn2_margin" 		=> "mt-4",
					 
			),
					
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $userdata, $settings;
	
		
		$settings = array( );  
		 
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("pricing1", "pricing", $settings ) );
	 
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		   
		
		// BUILD PACKAGE DATA
		$pricing_data = array();
		$btn = wp_login_url();
		//$settings["pricing_type"] = "packages";
		
		if($settings["pricing_type"] == "packages"){
		 
		
			$paknames = array( __("Basic","premiumpress") , __("Standard","premiumpress") , __("Premium","premiumpress") );
			
			 
			foreach(  $CORE->PACKAGE("get_packages", array() ) as $k => $n){ 
			 	
			  // WORK OUR DAYS
			  $DAYS = _ppt('pak'.$n['key'].'_duration');
			  if($DAYS == ""){ $DAYS =0; }
			   
			  // TUN OFF DURATION FOR AUCTION THEME
			  if(THEME_KEY == "at" && _ppt(array('lst','auction_time')) != '1' ){
			  $DAYS = 0;
			  }
			  
			  $daytext = ""; 
			  switch($DAYS){				
				  case "1": {
					  $daytext = "24 ".__("Hours","premiumpress");
				  } break;
				  case "7": {
					  $daytext = "1 ".__("Week","premiumpress");
				  } break;
				  case "30": {
				  	$daytext =  "1 ".__("Month","premiumpress");
				  } break;
				  case "365": {
				  	$daytext =  "1 ".__("Year","premiumpress");
				  } break;
				  default: { 				  
					  if(is_numeric($DAYS) && $DAYS > 0){
					  $daytext = $DAYS." ".__("Days","premiumpress");
					  }else{
					   $daytext = "";
					  }
				  }
			   } 
			   
			   // DAY  TEXT
			   if(strlen($daytext) > 0){
			   $daytext = __("Live for","premiumpress")." ".$daytext;
			   }
			   
			   // FEATURES
			   $features = array( 2 => array("name" =>  stripslashes(_ppt('pak'.$n['key'].'_desc')), "text" => 1 ),  );
				
				// NAMES
				$name = $CORE->GEO("translate_pak_name", array( stripslashes(_ppt('pak'.$n['key'].'_name')), $n['key'])  );
				 
				$features = array( 2 => array("name" => $CORE->GEO("translate_pak_desc", array( stripslashes(_ppt('pak'.$n['key'].'_desc')), $n['key'])  ), "text" => 1 ),  );
				 
				
				// PACKAGE
				$pricing_data[] = array(
						
						'id' 		=> $n['key'], 	
						'title' 	=> $name,
						'subtitle' 	=> $daytext,
						'price' 	=> $n['price'],
'price_text' => $n['price_text'],
						'paycode' 	=> _ppt('pak'.$n['key'].'_key'),
						'features' 	=> $features,  
						
						'active' => _ppt('pak'.$n['key'].'_highlight'),
						
						'addon_featured' => _ppt('pak'.$n['key'].'_featured'),						
						'addon_sponsored' => _ppt('pak'.$n['key'].'_sponsored'),						
						'addon_homepage' => _ppt('pak'.$n['key'].'_homepage'),
						
						'features1' 	=> $CORE->PACKAGE("get_features_array", array($n['key'],"pak") ),	
						
				);
				 
			 
			}// end while
		
		
		// SELLSPACE ****************************************
		/* **************************************************/
		
		}elseif($settings["pricing_type"] == "advertising"){
			
			$sellspacedata 	= _ppt('sellspace');		
			$sellspace 		= $CORE->ADVERTISING("get_spaces", array() );
			
			if(is_array($sellspace) && !empty($sellspace)){
				
				
				foreach($sellspace as $key => $sp){ 
				
					// CHECK IF ENABLED
					if(!isset($sellspacedata[$key]) || isset($sellspacedata[$key]) && $sellspacedata[$key] != 1){ continue; }
			
				
				 	// WORKOUT PRICE
					 $price = $sellspacedata[$key."_price"];
					 if(is_numeric($price) && $price > 0 ){
					  		$price_txt = hook_price($price);
					 }else{
					 	$price_txt = __("Free","premiumpress");
					 }
				
					$subtitle = stripslashes($sellspacedata[$key."_days"])." ". __("days","premiumpress"); 
					
					// PAY CODE
					$paycode =  $CORE->order_encode(array(  
					               
						  "uid" 			=> $userdata->ID,                
						  "amount" 			=> $price,
						  "order_id" 		=> "BAN-".$key."-".$userdata->ID."-".rand(),                
						  "description" 	=> stripslashes($sellspacedata[$key."_name"]),
						    				                 
					));
					
					 // PAYMENT BUTTON
					 $features = array(
						
						1 => array("name" =>  stripslashes($sellspacedata[$key."_desc"]), "text" => 1 ),	
					   
					 );
					 
					$pricing_data[] = array(
					
						'title' 	=> stripslashes($sellspacedata[$key."_name"]),
						'subtitle' 	=> $subtitle,
						'price' 	=> $price_txt,
						'paycode' 	=> $paycode,
						'features' 	=> $features,
					);		 
					
				
				}
			
			}
		
		// MEMBERSHIPS **************************************
		/* **************************************************/

		}else{		
		  
		 	
		foreach(  $CORE->USER("get_memberships", array() ) as $k => $n){  
				 
				// WORK OUR PRICE
				if($n['price'] == 0){       
					$price_txt = __("FREE","premiumpress");  
				}else{
					 $price_txt = hook_price($n['price']);
				}
				  
					
				if($userdata->ID){ 
				
					 $btn =  $CORE->order_encode(array(  
					               
						   "uid" 					=> $userdata->ID,                
						   "amount" 				=> $n['price'], 
						   "order_id" 				=> "SUBS-mem".$n['key']."-".$userdata->ID."-".rand(),                 
						   "description" 			=> $n['name'],
						   "recurring" 				=> $n['recurring'],    
						   "recurring_days" 		=> $n['duration'],            
						   "couponcode" 			=> "", 					                 
					   		));
				}					 
	  
					//asdad
					$pricing_data[] = array(
						
						'id'		=> $n['key'],
						'title' 	=> $n['name'],
						'subtitle' 	=> $n['duration_text'],
						'price' 	=> $price_txt,
						'paycode' 	=> $btn,
						'features' 	=> array( 1 => array("name" =>  $n['desc'], "text" => 1 ),	),
						
					);  
		
				} 
		
		}
		
		
		$settings["title_pos"] = "center";
		
		 
	 
	ob_start();
	
	?>

<section id="pricing" class="<?php echo $settings['section_class']." ".$settings['section_bg']." ".$settings['section_padding']." ".$settings['section_divider']; ?>">
  <div class="container">
  
  <?php if(isset($_GET['noaccess'])){ ?>
  
  <div class="col-12 text-center mb-5">
    <div class="alert alert-info mb-5 rounded-0 text-center">
        <h4 class="font-weight-bold my-3 text-uppercase"><?php echo __("Whoops, Access Denied!","premiumpress"); ?></h4>
        <p class="lead"><?php echo __("Please upgrade to a different membership package.","premiumpress"); ?></p>        
      </div>
    </div>
  <?php } ?>
  
  
    <?php if($settings['title_show'] == "yes"){ ?>
    <div class="col-12 text-center mb-5">
      <?php _ppt_template( 'framework/design/parts/title' ); ?>
    </div>
    <?php } ?>
  </div>
  

  
  
  <div class="pricing-wrapper">
    <div class="container">
      <div class="row">
        <?php if(empty($pricing_data)){ ?>
        <div class="col-12">
          <div class="bg-light py-5 text-center"> <i class="fal fa-frown"></i> <?php echo __("Everything has sold out!","premiumpress"); ?> </div>
        </div>
        <?php
		 

}elseif(!empty($pricing_data)){
 $i=1; foreach($pricing_data as $pak){ ?>
 
 
        <div class="<?php if(count($pricing_data) == 4){ ?>col-xl-3 col-lg-6 col-md-6 <?php }elseif(count($pricing_data) > 2){ ?>col-md-6  col-lg-4<?php }else{ ?>  col-lg-4 mx-auto<?php } ?>">
        
        
          <div class="price-box <?php if(isset($pak['active']) && $pak['active'] == "1"){?>bg-light<?php } ?>">
            <ul class="pricing-list list-unstyled">
             
              <li class="price-value <?php if($pak['price'] == 0 ){ echo "free ";} ?> <?php if(is_numeric($pak['price']) && $pak['price'] != "0"){ echo $CORE->GEO("price_formatting",array()); } ?> <?php if(count($pricing_data) > 3){ ?>price-set price-small<?php } ?>">
			  <?php if($pak['price'] == "0"){ echo $pak['price_text']; }else{  echo $pak['price']; } ?></li>
              
              <li class="price-title font-weight-bold"><?php echo $pak['title']; ?></li>            
                     
              
              <?php if(is_array($pak['features'])){ foreach($pak['features'] as $f){ ?>               
              
              <li class="price-text border-bottomxx pb-2 clearfix <?php if(isset($f['text'])){ ?>text-center text-muted small<?php } ?>"> <?php echo $f['name']; ?>
                <?php if(isset($f['num'])){ ?>
                <span class="float-right"><?php echo $f['num']; ?></span>
                <?php }elseif(isset($f['icon'])){ ?>
                <i class="<?php echo $f['icon']; ?> float-right mt-2"></i>
                <?php } ?>
              </li>
                 
              
              <?php } } ?>
              
              
              
	             
                                        <?php if(isset($pak['features1']) && is_array($pak['features1']) && !empty($pak['features1']) ){ foreach($pak['features1'] as $f){ ?>
		                                <li><i class="fa <?php if($f['value'] == "1"){?>fa-check<?php }else{ ?>fa-times<?php } ?> mr-2"></i> <?php echo $f['name']; ?></li>
		                                <?php } } ?>                 
	                             
              
              
            </ul>
            <div class="price-tag">
            
              <?php if($settings["pricing_type"] == "memberships"){ ?>
              
            
              
              <a 
								<?php if($userdata->ID){ ?>
                                href="javascript:void(0);" 
                                onclick="processPayment('<?php echo $pak['paycode']; ?>','<?php if($pak['price'] == 0){ echo $pak['price_text']; }else{  echo $pak['price']; } ?>');" 
                                <?php }else{ ?>
                                href="javascript:void(0)" onclick="processLogin(0,'mem<?php echo $pak['id']; ?>');"
                                <?php } ?>> <?php echo __("Select Package","premiumpress"); ?> </a>
            
            
            
            	
                
                
            
            <?php }elseif($settings["pricing_type"] == "packages"){ ?>
              
           
              
              <a   <?php if(isset($GLOBALS['flag-add']) ){ ?>
                                
                                <?php if($userdata->ID){ ?>
								
                                 href="javascript:void(0);" onclick="processPackage('<?php echo $pak['paycode']; ?>'); jQuery('html, body').animate({ scrollTop: 0 }, 'slow');" 
                                 
								<?php }else{ ?>
                                
                                href="javascript:void(0)" onclick="processLogin(0, 'pak<?php echo $pak['id']; ?>');"
                                
                                <?php } ?>
                                
                                
                               
                                <?php }else{ ?>
                                
                                href="<?php echo _ppt(array('links','add')); ?>/?packageid=<?php echo $pak['paycode']; ?>" 
                                
                                <?php } ?>                                 
                                ><?php echo __("Select Package","premiumpress"); ?></a>
                                
                                
          
               
              
              <?php }else{ ?> 
              
            
              
              <a 
								<?php if($userdata->ID){ ?>
                                href="javascript:void(0);" 
                                onclick="processPayment('<?php echo $pak['paycode']; ?>','<?php if($pak['price'] == 0){ echo $pak['price_text']; }else{  echo $pak['price']; } ?>');" 
                                <?php }else{ ?>
                                href="javascript:void(0)" onclick="processLogin(1,'');"
                                <?php } ?>> <?php echo __("Select Package","premiumpress"); ?> </a>
              <?php } ?>
              
              
              
              
              
            </div>
          </div>
        </div>
        <!--end col-md-4 -->
        <?php $i++; } } ?>
      </div>
      <!--end row -->
      
      
      
      <?php if($userdata->ID && $settings["pricing_type"] == "packages" && $CORE->USER("membership_hasaccess", "listings") && $CORE->USER("get_user_free_membership_addon", array("listings", $userdata->ID)) > 0 ){ ?>
      <div class="col-12 mt-4">
      
      <div class="alert alert-info text-center">
      <?php echo str_replace("%s", "<u class='font-weight-bold'>".$CORE->USER("get_user_free_membership_addon", array("listings", $userdata->ID))."</u>", __("You have %s free listings left. Pick any listing package above to continue.","premiumpress")); ?>
      </div>
     
      </div>
      <?php } ?>
      
      
      <?php if(isset($_GET['upgrade']) && $userdata->ID){ $mem = $CORE->USER("get_user_membership", $userdata->ID); $da = $CORE->date_timediff($mem['date_expires'],'');   ?>
      <div class="col-12 mt-4">
      
      <?php if(in_array(_ppt(array('mem','paktime')), array("","1"))){ ?>
      <div class="alert alert-info text-center">
      <?php echo str_replace("%s", "<u class='font-weight-bold'>".$da['days-left']."</u>", __("Buy a new membership today and get the %s days left on your old membership added completely free!","premiumpress")); ?>
      </div>
      <?php } ?>
      
      </div>
      <?php } ?>
      
      
    </div>
    <!--end container -->
  </div>
</section>

 
<script>
 

function processPayment(sid,pp){
   
   	 
       jQuery.ajax({
           type: "POST",
           url: '<?php echo home_url(); ?>/',		
   		data: {
               action: "load_new_payment_form",
   				details: sid, 
           },
           success: function(response) { 
		   
		   jQuery(".payment-modal-wrap").fadeIn(400);
		 
		    jQuery(".payment-modal-container h3").text(pp); 			 
			 
   			jQuery('#ajax-payment-form').html(response);			 
   			
           },
           error: function(e) {
               console.log(e)
           }
       });
   
   }
   
</script>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static function css(){
		ob_start();
		?>
<style>

.bg-primary ul.pricing-list, 
.bg-dark ul.pricing-list, 
.bg-black ul.pricing-list, 
.bg-secondary ul.pricing-list, 
.bg-primary ul.pricing-list .text-muted, 
.bg-dark ul.pricing-list .text-muted, 
.bg-secondary ul.pricing-list .text-muted {
color:#fff !important; 
}
.bg-primary .bg-light ul.pricing-list, 
.bg-dark .bg-light ul.pricing-list, 
.bg-black .bg-light ul.pricing-list, 
.bg-secondary .bg-light ul.pricing-list, 
.bg-primary .bg-light ul.pricing-list .text-muted, 
.bg-dark .bg-light ul.pricing-list .text-muted, 
.bg-secondary .bg-light ul.pricing-list .text-muted  {
color:#111 !important; 
}
 
.bg-primary .price-box:not(.bg-light) .price-tag a, 
.bg-black .price-box:not(.bg-light) .price-tag a, 
.bg-dark .price-box:not(.bg-light) .price-tag a, 
.bg-secondary .price-box:not(.bg-light) .price-tag a { border: 1px solid #fff !important; color:#fff !important;  }

.price-box {
	position: relative;
    margin: 20px 10px 20px 5px;
    padding: 50px 10px 32px 10px;
    overflow: hidden;
    text-align: center;
    border: 1px solid #dfdfdf;
    background-color: transparent;
    border-radius: 8px 8px;
	transition: all 0.3s ease-in-out;
	-webkit-transition: all 0.3s ease-in-out;
}
 

.price-box:hover{
	transform: scale(1.025);
	transition: all 1s;
}

.price-box .price-subtitle,.price-box .price-text{
	 
}

ul.pricing-list{
	padding: 0 30px;
}

ul.pricing-list li.price-title{	
	font-size: 16px;
	line-height: 24px; 	 
}

ul.pricing-list li.price-value{	
	font-size: 70px;
	line-height: 70px;
	display: block;
	margin-bottom: 10px;	 
}

ul.pricing-list li.price-tiny { font-size:20px; }
ul.pricing-list li.price-small { font-size:40px; }
ul.pricing-list li.price-medium { font-size:60px; }

ul.pricing-list li.price-subtitle{	
	margin-bottom: 10px;
	font-size: 16px;
	line-height: 24px;
	 
}

ul.pricing-list li.price-text{
	display: block;	
	text-align: left;
	font-weight: 400;
	margin-bottom: 5px;
}

ul.pricing-list li.price-text i{
	 
}
 
.price-tag a {
	 
	background: transparent;
	 border: 1px solid #111; 
	 color:#111; 
	border-radius: 5px 5px;
	padding: 15px 30px;
	display: inline-block;
	font-size: 15px;
	line-height: 24px;
	font-weight: 600;
	 
	transition: all 0.3s ease-in-out;
	-webkit-transition: all 0.3s ease-in-out;
}

.price-tag a:hover{
	background: #fff;
	border:1px solid #fff;
	color: #e84d3c;
}

.price-tag-line a{
	 
	background: transparent;
	border:1px solid #fff;
	border-radius: 5px 5px;
	padding: 15px 30px;
	display: inline-block;
	font-size: 15px;
	line-height: 24px;
	font-weight: 600;
	margin: 30px 0 5px 0;
	transition: all 0.3s ease-in-out;
	-webkit-transition: all 0.3s ease-in-out;
}

ul.pricing-list .price-tag-line a:hover{
	color: #e84d3c;
	background: #fff;
	border:1px solid #fff;
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
