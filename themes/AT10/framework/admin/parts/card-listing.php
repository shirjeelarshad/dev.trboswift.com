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

global $CORE, $post;

 
?>

<tr id="postid-<?php echo $post->ID; ?>">
  <td><input class="checkbox1" type="checkbox" name="check[]" onclick="jQuery('#actionsbox').show();" value="<?php echo $post->ID; ?>">
  </td>
  <td class="pr-0"><ul class="list-inline mb-0">
      <li class="list-inline-item">
        <?php if(!in_array(THEME_KEY, array("cp", "pj"))){ ?>
        <a href="<?php echo get_permalink($post->ID); ?>" class="text-dark float-left" target="_blank" style="max-width:55px; max-height:55px; overflow:hidden;">
        <?php  echo str_replace("img-fluid","avatar img-fluid", str_replace("data-src","src", do_shortcode('[IMAGE link=0 w=55]'))); ?>
        </a>
        <?php } ?>
        <div class="float-left font-weight-bold" style="max-width: 230px;
    overflow: hidden;"> <a href="<?php echo get_permalink($post->ID); ?>" class="text-dark" target="_blank" style="max-height:48px; overflow:hidden;">
          <?php  echo do_shortcode('[TITLE]'); ?>
          </a>
          <div class="small">
            <ul class="list-inline mb-0 pb-0 positon-relative">
            
            
            
             <?php if(in_array(THEME_KEY, array("da"))){ ?>
             
              <li class="list-inline-item"> <?php  echo do_shortcode('[GENDER]'); ?></li>
             
             <?php }else{ ?>
             
             <?php  echo str_replace("a hr","a target='_blank' hr",do_shortcode('[CATEGORY]')); ?>
             <?php } ?>
            
            
            <?php if(in_array(THEME_KEY, array("cp"))){ ?>
           
            <li class="list-inline-item"> <?php  echo do_shortcode('[STORENAME]'); ?></li>
           
            <?php }  ?>
            
            <?php if( $CORE->LAYOUT("captions","listings")  && get_post_meta($post->ID ,'live_auction_start_date', true) != ""){ ?>
            
            <li class="list-inline-item">
            <u><i class="fal fa-clock ml-1"></i> <?php echo __("Live Aution","premiumpress"); ?> </u>
            </li>
            
            <?php } else {  if( $CORE->LAYOUT("captions","listings")  && get_post_meta($post->ID ,'listing_expiry_date', true) != ""){ ?>
           <li class="list-inline-item">
            <u><i class="fal fa-clock ml-1"></i> <?php echo do_shortcode('[TIMELEFT postid="'.$post->ID.'" layout="1" text_before="" text_ended="Not Set" key="listing_expiry_date"]'); ?> </u>
            </li>
            <?php } } ?>
            
            
            <?php if(!in_array(THEME_KEY, array("cp","sp","cm"))){ ?>
            <li class="list-inline-item">  <a href="admin.php?page=members&eid=<?php echo $post->post_author; ?>" target="_blank" class="font-weight-normal"><?php echo $CORE->USER("get_username", $post->post_author); ?></a></li>
            <?php } ?>
			
           
            
         </ul>
            
            
          </div>
        </div>
      </li>
    </ul></td>
    
  <?php if(in_array(THEME_KEY, array("at"))){ ?>
  
  <td class="text-center"><?php  echo do_shortcode('[STATUS]'); ?>
    <div class="small mt-2">
      <?php  echo do_shortcode('[BIDS]'); ?>
      <?php echo __("bids","premiumpress"); ?></div>
      
      </td>
      
      
  <?php }elseif(in_array(THEME_KEY, array("dt"))){ ?>
  
  <td class="text-center"> 
  
   <?php  echo do_shortcode('[LEADS]'); ?>
      
      </td>



  <?php }elseif(in_array(THEME_KEY, array("cp"))){ ?>
  <td class="text-center"><div class="small mt-2">
      <?php  //echo do_shortcode('[RATING]'); ?>
    </div>
    <div class="mt-2 small">
      <?php  if(do_shortcode('[VERIFIED]') == 1){ ?>
      <span class="text-success"><i class="fa fa-check"></i> <?php echo __( 'Verified', 'premiumpress' ); ?></span>
      <?php }else{ ?>
      <span><?php echo __( 'Not Verified', 'premiumpress' ); ?></span>
      <?php } ?>
    </div></td>
  <?php }elseif(in_array(THEME_KEY, array("ct","dl","jb","mj"))){ ?>
  <td class="text-center"><?php  echo do_shortcode('[OFFERS]'); ?>
    <?php if(in_array(THEME_KEY, array("ct","dl","jb"))){ ?>
    <div class="small text-muted">
      <?php if(get_post_meta($post->ID, "status", true ) == 0){ ?>
      <?php echo __("available","premiumpress"); ?>
      <?php }else{ ?>
      <strong><?php echo __("unavailable","premiumpress"); ?></strong>
      <?php } ?>
    </div>
    <?php } ?>
  </td>
  <?php } ?>


  <td class="text-center">
 
  
    <?php  echo do_shortcode('[HITS]'); ?>
 
  
</td>
  
  
  
  
  
  <td class="text-center"><?php if(in_array(THEME_KEY, array("dt")) && _ppt(array('design', 'single-offers'))  == '1'){ ?>
    <?php if(get_post_meta($post->ID, "claimed", true ) == ""){ ?>
    <span class="text-muted">-</span>
    <?php }else{ ?>
    <div class="btn btn-system btn-sm"><i class="fa fa-check text-success"></i> <?php echo __("claimed","premiumpress"); ?></div>
    <?php } ?>
    <?php }elseif(in_array(THEME_KEY, array("dt")) ){ ?>
    <?php  echo do_shortcode('[CITY]'); ?>
    <?php }elseif(in_array(THEME_KEY, array("cp"))){ ?>
    <?php  echo do_shortcode('[USED]'); ?>
    <?php }elseif(in_array(THEME_KEY, array("vt"))){ ?>
    <?php  if(in_array(_ppt(array('lst', 'vt_levels')), array("","1"))){ echo do_shortcode('[LEVEL btn=1]'); } ?>
     <?php }elseif(in_array(THEME_KEY, array("ph"))){ ?>
    <?php  echo do_shortcode('[DOWNLOADS]'); ?>
    
    <?php }elseif(in_array(THEME_KEY, array("da"))){ ?>
    <?php  echo do_shortcode('[AGE]'); ?>
    
    <?php }else{ ?>
    <span class="<?php echo $CORE->GEO("price_formatting",array()); ?>"><?php  echo do_shortcode('[PRICE]'); ?></span>
    <?php } ?>
  </td>
  <td class="text-center"> 
     
    
    <?php echo $CORE->PACKAGE("get_status_formatted",  $post->ID ); ?> 
    
    <?php if(THEME_KEY != "sp"){ ?>
    <div class="small mt-2">
      <?php  $pp =  $CORE->PACKAGE('get_package',$post->ID); if(is_array($pp)){ echo $pp['name']; } ?>
    </div>
    <?php } ?> 
    
  </td>
  <td>
  
  <div class="d-flex justify-content-between ">
  
      <div>
      
      <div class="mb-3"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=listings&eid=<?php echo $post->ID; ?>" class="btn btn-system btn-md shadow-sm btn-block"><?php echo __("Edit","premiumpress"); ?> </a></div>
      
      <a href="javascript:void(0);" onclick="ajax_listing_delete('<?php echo $post->ID; ?>')"  class="btn btn-system  btn-md shadow-sm btn-block"><?php echo __("Delete","premiumpress"); ?></a>
      
      </div>
      <div class="ml-3">
      
         <?php
		 
		 $sp = get_post_meta($post->ID ,'sponsored', true) ;
		 $sf = get_post_meta($post->ID ,'featured', true);
		 $sh = get_post_meta($post->ID ,'homepage', true);
		 
		 ?>          
                
              
                    
                <div class="mb-1">
                
                <span class="btn btn-system tiny <?php if($sf != 1){ ?>opacity-5<?php } ?>" style="cursor:default" data-toggle="tooltip" data-placement="top" title="<?php echo __("Featured","premiumpress"); ?> <?php if($sf == 1){ echo __("Enabled","premiumpress"); }else{ echo __("Disabled","premiumpress"); } ?>">
                <i class="fa fa-star <?php if($sf == 1){ ?>text-warning<?php } ?> pr-0 mr-0" style="font-size:12px;"></i>
                </span>
                
                </div>
                
                  <div class="mb-1">
                
                <span class="btn btn-system tiny <?php if($sp != 1){ ?>opacity-5<?php } ?>" style="cursor:default" data-toggle="tooltip" data-placement="top" title="<?php echo __("Sponsored","premiumpress"); ?> <?php if($sf == 1){ echo __("Enabled","premiumpress"); }else{ echo __("Disabled","premiumpress"); } ?>">
                <i class="fa fa-circle  pr-0 mr-0 <?php if($sp == 1){ ?>text-danger<?php } ?>" style="font-size:12px;"></i>
                </span>
                
                </div>
                
                 
               <div> 
               <span class="btn btn-system tiny <?php if($sh != 1){ ?>opacity-5<?php } ?>" style="cursor:default" data-toggle="tooltip" data-placement="top" title="<?php echo __("Homepage","premiumpress"); ?> <?php if($sf == 1){ echo __("Enabled","premiumpress"); }else{ echo __("Disabled","premiumpress"); } ?>">
               <i class="fa fa-home <?php if($sh == 1){ ?>text-info<?php } ?> pr-0 mr-0" style="font-size:12px;"></i>
               </span>
               
               </div>
                
      
      </div>
  </div>
  
  
  </td>
</tr>
