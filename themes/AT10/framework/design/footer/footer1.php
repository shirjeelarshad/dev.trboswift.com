<?php
 
add_filter( 'ppt_blocks_args', 	array('block_footer1',  'data') );
add_action( 'footer1',  		array('block_footer1', 'output' ) );
add_action( 'footer1-css',  	array('block_footer1', 'css' ) );
add_action( 'footer1-js',  	array('block_footer1', 'js' ) );

class block_footer1 {

	function __construct(){}		

	public static function data($a){ 
  
		$a['footer1'] = array(
			"name" 	=> "Style 1",
			"image"	=> "footer1.jpg",
			"cat"	=> "footer",
			"order" => 1,
			"desc" 	=> "", 
			"data" 	=> array( ),			
		);		
		
		return $a;
	
	} public static function output(){ global $CORE, $new_settings, $settings;
	  
		$settings = array( );
	
		// ADD ON SYSTEM DEFAULTS
		$settings = $CORE->LAYOUT("get_block_settings_defaults", array("footer1", "footer", $settings ) );
			  
		// UPDATE DATA FROM ELEMENTOR OR CHILD THEMES
		if(is_array($new_settings)){
			 foreach($settings as $h => $j){
				if(isset($new_settings[$h]) && $new_settings[$h] != ""){
					$settings[$h] = $new_settings[$h];
				}
			 }
		} 
		
    
 	
	ob_start();
	?>
  <style>
  
  .footer .img-fluid{
  
      max-width: 150px;
      object-fit:contain;
  }

  .footer .vactor{
 position: absolute;
    bottom: 81px;
    right: -80px;
    /* transform: rotate(5deg); */
    object-fit: contain;
    background-repeat: no-repeat;
    width: 330px;


  }

.socialMediaIcon{
      background: #3B634C;
    padding: 10px;
    border-radius: 100px;
    color: white;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}
  
  </style>
    
<footer class="footer position-relative pb-5 <?php echo $settings['section_class']." ".$settings['section_padding']." ".$settings['section_divider']; ?>" style="background:#F4F4F4;">

<img src="<?php echo home_url(); ?>/wp-content/uploads/2025/01/Vector.png" class="vactor" />
<div class="container">
    <div class="row">
    
      <div class="col-12 col-lg-5  text-md-left pb-4 pr-5">
        <?php		 
// SET DEFAULTS
ob_start();
dynamic_sidebar('footer1'); 
$footer1 = ob_get_clean();
if(strlen($footer1) > 10){ echo $footer1; }else{	 
?>
        <a href="<?php echo home_url(); ?>">
        <?php 
								 
								 if(in_array($settings['section_bg'], array('bg-light','','bg-white'))){
								 
								 echo str_replace("text-primary","",str_replace("text-secondary","",str_replace("text-muted","", $CORE->LAYOUT("get_logo","dark") ))); 
								 
								 }else{
								 
								 echo str_replace("text-primary","",str_replace("text-secondary","",str_replace("text-muted","", $CORE->LAYOUT("get_logo","light") )));
								  
								 }
								 
								 ?>
        </a>
        <p class="mt-4 opacity-8 small line-height-30">
          <?php if(isset($settings['footer_description']) && strlen($settings['footer_description']) > 2){ ?>
          <?php  echo $settings['footer_description'];
          ?>
          <?php }elseif(strlen(_ppt(array('company','mission'))) > 2){ echo _ppt(array('company','mission')); }else{ ?>
          
          
         
          <?php } ?>
        </p>
        
        <div class="socials mt-4 <?php if(in_array($settings['section_bg'], array('bg-light','','bg-white'))){ ?>dark<?php } ?>" >
         
         
          <?php if(_ppt(array('company','facebook')) != ""){ 
		  
		  $fb_link = _ppt(array('company','facebook'));
		  if(strpos($fb_link,"facebook.com") === false){		  
		  	$fb_link = "https://www.facebook.com/"._ppt(array('company','facebook'));		  
		  }		  
		  
		  ?>
          <a class="h5 mr-4" target="_blank" href="<?php echo $fb_link; ?>" title="Facebook"><i class="socialMediaIcon fab fa-facebook-f"></i></a>
          <?php } ?>

          
     
     
          
           <?php if(_ppt(array('company','twitter')) != ""){ 
		  
		  $tw_link = _ppt(array('company','twitter'));

		  if(strpos($tw_link ,"twitter.com") === false){		  
		  	$tw_link  = "https://www.twitter.com/"._ppt(array('company','twitter'));		  
		  }	
		  
		  ?>
          <a class="h5 mr-4" target="_blank" href="<?php echo $tw_link; ?>" title="Twitter"><i class="socialMediaIcon fab fa-twitter"></i></a>
          <?php } ?>

      <?php if(_ppt(array('company','instagram')) != ""){ 
		  
		   $in_link = _ppt(array('company','instagram'));
		  if(strpos($in_link ,"instagram.com") === false){		  
		  	$in_link  = "https://www.instagram.com/"._ppt(array('company','instagram'));		  
		  }	
		  
		  ?>
          <a class="h5 text-gray mr-4" target="_blank" href="<?php echo $in_link; ?>" title="Instagram"><i class="socialMediaIcon fab fa-instagram"></i></a>
          <?php } ?>

          
          <a class="h5 mr-4" target="_blank" href="#" title="Linkedin"><i class="socialMediaIcon fab fa-linkedin-in"></i></a>
          <a class="h5 mr-4" target="_blank" href="#" title="TikTok"><i class="socialMediaIcon fab fa-tiktok"></i></a>

          
        </div>
       
        <?php } ?>
      </div>
      <div class="col-lg-2 col-md-6 col-sm-6 col-6 ">
        <?php		 
// SET DEFAULTS
ob_start();
dynamic_sidebar('footer2'); 
$footer1 = ob_get_clean();
if(strlen($footer1) > 10){ echo $footer1; }else{	 
?>
        <?php if(isset($settings['footer_menu1']) && $settings['footer_menu1'] == "none"){ ?>
        <?php }else{ ?>
        <?php if(isset($settings['footer_menu1_title']) && strlen($settings['footer_menu1_title']) > 2){ ?>
        <div class="h6 font-weight-bold"><?php echo $settings['footer_menu1_title']; ?></div>
        <?php }else{ ?>
        <div class="h6 font-weight-bold text-uppercase"><?php echo __("Useful Links","premiumpress"); ?></div>
        <?php } ?>
        <div style="line-height:35px;">
          <?php if(isset($settings['footer_menu1']) && strlen($settings['footer_menu1']) > 2){ ?>
          <?php echo str_replace("nav-link","opacity-8",do_shortcode('[MAINMENU menu_name="'.$settings['footer_menu1'].'" class="links-vertical list-unstyled"][/MAINMENU]')); ?>
          <?php }else{ ?>
          <?php echo str_replace("nav-link","opacity-8",do_shortcode('[MAINMENU footer=1 class="links-vertical list-unstyled"][/MAINMENU]')); ?>
          <?php } ?>
        </div>
        <?php } ?>
        <?php } ?>
      </div>
      <div class="col-lg-2 col-md-6 col-sm-6 col-6 ">
        <?php if(isset($settings['footer_menu2']) && $settings['footer_menu2'] == "none"){ ?>
        <?php }else{ ?>
        <?php if(isset($settings['footer_menu2_title']) && strlen($settings['footer_menu2_title']) > 2){ ?>
        <div class="h6 font-weight-bold"><?php echo $settings['footer_menu2_title']; ?></div>
        <?php }else{ ?>
      
        <?php } ?>
        <div style="line-height:35px;">
          <?php if(isset($settings['footer_menu2']) && strlen($settings['footer_menu2']) > 2){ ?>
          <?php echo str_replace("nav-link","opacity-8",do_shortcode('[MAINMENU menu_name="'.$settings['footer_menu2'].'" class="links-vertical list-unstyled"][/MAINMENU]')); ?>
          <?php }else{ ?>
          <ul class="links-vertical list-unstyled" style="line-height:35px;">
<li><a class="" href="#"><?php echo __("Resources","premiumpress"); ?></a></li>
<li><a class="" href="<?php echo home_url(); ?>/terms/#section24"><?php echo __("Arbitration","premiumpress"); ?></a></li>   <li><a class="" href="<?php echo home_url(); ?>/terms/#support"><?php echo __("Support","premiumpress"); ?></a></li>  
			<li><a class="" href="https://shorturl.at/oKPR5" target="_blank"><?php echo __("GuardTree for used car","premiumpress"); ?></a></li>
          </ul>
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <div class="col-lg-3 col-md-6 col-12 my-md-5 mt-lg-0 pl-2 pl-md-5">
        <?php		 
// SET DEFAULTS
ob_start();
dynamic_sidebar('footer3'); 
$footer1 = ob_get_clean();
if(strlen($footer1) > 10){ echo $footer1; }else{	 
?>
        <div class="h6 font-weight-bold"><?php echo __("Subscribe to our news letter","premiumpress"); ?></div>
       
        <?php 
							 ob_start();							 
							 _ppt_template( 'framework/design/widgets/widget-newsletter' ); 
							 $output = ob_get_contents();
							ob_end_clean();	
							if($settings['section_bg'] != "bg-primary"){
							echo str_replace("btn-primary"," btn-secondary",$output);
							}else{
							echo $output;
							
							}
							 ?>
        <div class="small opacity-8 mt-4"><?php echo __("We'll never share your details.<Br>See our","premiumpress"); ?> <a class="text-secondary" href="<?php echo _ppt(array('links','privacy')); ?>"><?php echo __("Privacy Policy","premiumpress"); ?></a> | <a class="text-secondary" href="<?php echo home_url(); ?>/terms/"><?php echo __("Terms Of Use ","premiumpress"); ?></a></div>
        <?php } ?>
        
        
         
      </div>
      <!-- Footer four block close -->
      <div class="col-md-12 small text-center text-md-left">
        <hr class="bg-white my-4" style="opacity:0.2" />
        <?php

// FOOTE BOTTOM
_ppt_template( 'framework/design/footer/parts/bottom-center' ); 
?>
      </div>
    </div>
  </div>
</footer>
<?php
		$output = ob_get_contents();
		ob_end_clean();
		echo $output;	
	
	}
		public static  function css(){
		return "";
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