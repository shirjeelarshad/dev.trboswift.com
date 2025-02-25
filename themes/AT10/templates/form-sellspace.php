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
   
   global $CORE, $userdata; $shown =1; $counter = 0; 
   
   $sellspace 	= $CORE->ADVERTISING("get_spaces", array() );
   
   $sellspacedata = _ppt('sellspace');
   
   if(empty($sellspace)){ ?>
   
 
   
   
   <?php }elseif(is_array($sellspace) && !empty($sellspace)){ ?>
   
 
      <script>var banner = [];</script>
      
      <div class="package-tab-content">
         
         <?php foreach($sellspace as $key => $sp){ 
		 
		 
		 	// CHECK IF ENABLED
			if(!isset($sellspacedata[$key]) || isset($sellspacedata[$key]) && $sellspacedata[$key] != 1){ continue; }
			
		 
            // GET PRICE
            $price = stripslashes($sellspacedata[$key."_price"]);
            if(!is_numeric($price)){ $price = 10; }
            
            // COUNT EXISTING ADVERTISERS
            $SQL = "SELECT COUNT(*) AS total FROM `".$wpdb->prefix."posts` WHERE post_type='ppt_campaign' AND post_status='publish' AND post_title LIKE ('%". $key ."%') "; 
            $tt = $wpdb->get_results($SQL, OBJECT);
			if(isset($tt[0]->total)){
			$tt = $tt[0]->total;
			}else{
			$tt = 0;
			} 
            
            // COUNT TOTAL LEFT
            $spaceleft = (stripslashes($sellspacedata[$key."_max"]) - $tt );
            
            ?>
         <div class="package-posts py-4 col-12 bg-white shadow-sm mb-4">
            <div class="row">
               <div class="col-md-3 box-price text-center">
                  <div class="text-success h1"><?php echo hook_price($price); ?></div>
                  <p><?php echo __("for","premiumpress"); ?> <?php echo stripslashes($sellspacedata[$key."_days"]); ?> <?php echo __("days","premiumpress"); ?></p>
               </div>
               <div class="col-md-6 text-left box-desc border-left">
               
               <div class="pl-4">
                  <h4 class="mt-2"><?php echo stripslashes($sellspacedata[$key."_name"]); ?></h4>
                  <p><?php echo stripslashes($sellspacedata[$key."_desc"]); ?></p>
                  <p class="text-muted"><?php echo __("Size","premiumpress"); ?>: <?php 
                     echo $sellspacedata[$key."_size"]; ?> <?php if($sellspacedata[$key."_max"] > $sellspace[$key]["max"] ){ ?>(<?php echo __("banner will rotate","premiumpress"); ?>)<?php } ?></p>
              </div>
              
              
               </div>
               <div class="col-md-3 box-btn pt-3">
                  <?php if($spaceleft < 1){ ?>
                  <div class="btn btn-info text-uppercase btn-block font-weight-bold"><?php echo __("Sold Out","premiumpress"); ?></div>
                 
                  <?php }elseif($spaceleft > 0){ ?>
                  
                  <a class="btn btn-success text-uppercase btn-block font-weight-bold"  <?php if($userdata->ID){ ?> href="javascript:void(0);" onclick="processBanner('<?php echo $key; ?>','<?php 
                     echo  $CORE->order_encode(array(               
                     "uid" => $userdata->ID,                
                     "amount" => $price,                
                     "order_id" => "BAN-".$key."-".$userdata->ID."-".rand(),                 
                     "description" => "".stripslashes($sellspacedata[$key."_desc"])."",								
                     ) 								
                     ); 
                     ?>');"<?php }else{ ?>href="<?php echo site_url('wp-login.php?action=login', 'login_post'); ?>"<?php } ?>>
                  <?php echo __("Select Space","premiumpress") ?>
                  </a>            
                  <?php } ?>
                  
                  <div class="mt-3 text-center text-muted"><?php echo $spaceleft; ?> / <?php echo stripslashes($sellspacedata[$key."_max"]); ?> <?php echo __("available","premiumpress"); ?> </div>
               </div>
            </div>
         </div>
         <script>
            banner['<?php echo $key; ?>'] = {
            	name:"<?php echo stripslashes($sellspacedata[$key."_name"]); ?>", 
            	price:"<?php echo $price; ?>", 
            	time:"<?php echo $sellspacedata[$key."_days"]; ?> <?php echo __("days","premiumpress"); ?>",  
            expirydate:"<?php echo hook_date(date( 'd.m.Y H:i:s', strtotime("+ ".$sellspacedata[$key."_days"]." days"))); ?>",
            };
         </script> 
         <?php $counter++; } ?>
         
         
   
   
</div>
<!-- end packages block -->
<?php } ?>

  
<?php if($counter == 0){ ?>
   <div class="bg-light mt-4 p-4 text-center h6">
   <?php echo __("Sold Out!","premiumpress"); ?>
   </div>
<?php } ?>   