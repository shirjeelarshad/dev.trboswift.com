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

global $CORE, $post, $userdata; 

 $rates = array(
1 => __("1 Hour","premiumpress"),
2=> __("2 Hours","premiumpress"),
3 => __("3 Hours","premiumpress"),
4 =>__("6 Hours","premiumpress"),
5 => __("12 Hours","premiumpress"),
);


?>

  <div class="card card-listing <?php if(isset($GLOBALS['global_design3'])){ echo "border-0"; } ?>">
    <div class="filter-content collapse show nocolapse" id="collapse-sec-sidebar">
      <div class="card-body">
        <div class="addeditmenu" data-key="callrates"></div>
        <h5><?php echo __("My Rates","premiumpress") ?></h5>
        <ul class="list-group list-group-flush small mb-3">
          <?php  foreach($rates as $k => $r){ 
	   
	   $int = get_post_meta($post->ID, 'rate_incall'.$k, true ); 
	   $out = get_post_meta($post->ID, 'rate_outcall'.$k, true ); 
	   
	   if(!is_numeric($int)){ $int = 0; }
	   if(!is_numeric($out)){ $out = 0; }
	   
	   if($out != 0 || $int != 0){
	   ?>
          <li class="list-group-item px-0 d-flex justify-content-between align-items-center"> <span><i class="fal fa-clock mr-2"></i> <?php echo $r ?></span> <span class="inline-flex items-center font-weight-bold order-status-icon status-2"> <span class="pr-2px leading-relaxed whitespace-no-wrap">
            <?php if($int != 0){ ?>
            <span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price($int); ?></span>
            <?php }else{ ?>
            <i class="fa fa-times"></i>
            <?php } ?>
            </span> </span> <span class="inline-flex items-center font-weight-bold order-status-icon status-1"> <span class="pr-2px leading-relaxed whitespace-no-wrap">
            <?php if($out != 0){ ?>
            <span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo hook_price($out); ?></span>
            <?php }else{ ?>
            <i class="fa fa-times"></i>
            <?php } ?>
            </span> </span> </li>
          <?php } } ?>
        </ul>
        <div class="text-center text-lg-right mb-3"> <span class="inline-flex items-center font-weight-bold order-status-icon status-2  mr-2"> <span class="dot mr-2"></span> <span class="pr-2px leading-relaxed whitespace-no-wrap"> <?php echo __("Incall","premiumpress") ?></span> </span> <span class="inline-flex items-center font-weight-bold order-status-icon status-1"> <span class="dot mr-2"></span> <span class="pr-2px leading-relaxed whitespace-no-wrap"> <?php echo __("Outcall","premiumpress") ?></span> </span> </div>
  
        
        
      </div>
    </div>
     </div>
  