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

   
   $campaigns = new WP_Query( array('posts_per_page' => 200, 'post_type' => 'ppt_campaign', 'orderby' => 'post_date', 'order' => 'desc', 'author' => $userdata->ID  ) );
   
     
   $showcart = false; 
   
   $sellspacedata = _ppt('sellspace'); 
   
   // get user banners
   $mybanners = $CORE->ADVERTISING("get_user_banners", array($userdata->ID) );
 ?>
<div class="card">
<div class="card-body">
<div class="container px-0">
   <div class="row">
    
      <div class="col-md-12">
 
 
 

   
      
            <div class="text-right mb-3">
               <a href="<?php echo _ppt(array('links','sellspace')); ?>" class="btn btn-md shadow-sm btn-system"><u><?php echo __("Buy more banners","premiumpress"); ?></u></a>
            </div>
            <table class="table table-bordered table-striped small">
               <thead>
                  <tr>
                     
                     <th><?php echo __("Campaign","premiumpress"); ?></th>
                    
                     <th class="text-center"><?php echo __("Size","premiumpress"); ?></th>
                     <th class="text-center"><?php echo __("Views","premiumpress"); ?></th>
                     <th class="text-center"><?php echo __("Clicks","premiumpress"); ?></th>
                     <th class="text-center"><?php echo __("Time Left","premiumpress"); ?></th>
                     
                      <th class="text-center"  style="width:170px;"><?php echo __("Actions","premiumpress"); ?></th>
                  </tr>
               </thead>
               <tbody>
                  
                     <?php if(!empty($campaigns->posts)){  
                        foreach($campaigns->posts as $order){ 
                                                         // BITS
                                                         $bits = explode("-",$order->post_title);
                                                         
                                                         // TIME LEFT
                                                         $timeleft = get_post_meta($order->ID, 'listing_expiry_date',true);
                                                         
                                                         // GET ACTIVE BANNER ID
                                                         $activebannerID = get_post_meta($order->ID, 'bannerid', true);
                        								 
                        								 //campaign name								 
                        								 $campaignID = get_post_meta($order->ID, 'location', true);
                        								 
                        								 // BANNER SIZE
                        								 $size = $sellspacedata[$campaignID.'_size'];
                        								 $size_parts = explode("x", $size);								 
                        								  
                                                         // AVAILABLE BANNERS
                                                         $avibanner = $CORE->ADVERTISING("get_user_banners", array($userdata->ID, $size_parts[0], $size_parts[1]) ); 
                                                        
                        								  
                                                         
                        ?>
                        
                  <tr class="row-<?php echo $order->ID; ?>">
                  
                     
                     <td >
					 
					 
                     <div class="font-weight-bold">#<?php echo $order->ID; ?> - <?php 
					 
					 
					 $loc = $CORE->ADVERTISING("get_spaces",  $campaignID); 
					 
					 echo  $loc['n']; ?></div>
                     
                     <?php $status = $CORE->ADVERTISING("campaign_status", $order->ID); ?>

<div style=" padding:5px; background:<?php echo $status['color']; ?>; color:#fff; margin-top:5px; text-align:center; font-size:11px; width:100%; text-transform:uppercase">
<?php echo $status['short']; ?></div>
                     
                     </td>
                  
                     
                     <td class="text-center">
					 
					<?php echo $size; ?>
                     
                     </td>
                     <td class="text-center"><?php echo $CORE->ADVERTISING("campaign_impressions", $order->ID); ?></td>
                     <td class="text-center"><?php echo $CORE->ADVERTISING("campaign_clicks", $order->ID); ?></td>
                     
                     
                     <td class="text-center">
                    <?php $e =  $CORE->ADVERTISING("campaign_expires", $order->ID); 

if($e['expired']){ echo __("Finished","premiumpress"); }else{ ?>

<?php echo $e['date'];  ?>

<div class="small mt-2"><?php echo $e['days'];  ?> left</div>

<?php } ?>
                     </td>
                     
                     
                        <td> 


 <a href="javascript:void();" class="btn btn-system btn-md" onclick="jQuery('#bannerbox<?php echo $order->ID; ?>').toggle();"><?php echo __("Edit Banner","premiumpress"); ?> </a>
                     
                     
                     </td>
                     
                  </tr>
                  <tr>
                     <td colspan="7" style="text-align:center; display:none;" id="bannerbox<?php echo $order->ID; ?>">
                        <?php  if(is_array($avibanner) && !empty($avibanner) ){ ?>
                        <form action="" method="post" class="p-0 m-0">
                           <input type="hidden" name="action" value="sellspace_set" />
                           <input type="hidden" name="cid" value="<?php echo $order->ID; ?>" />
                           <div class="row">
                              <div class="col-md-5">
                                 <select name="bannerid"  class="form-control form-control-sm">
                                    <?php if($activebannerID != "" && $activebannerID != 0 ){ }else{ ?>                                    
                                    <option><?php echo __("Select Banner","premiumpress"); ?></option>
                                    <?php } ?>
                                    <?php 
                                       foreach( $avibanner as $kh){ ?>
                                    <option value="<?php echo $kh['id']; ?>" <?php selected( $activebannerID, $kh['id'] ); ?>> <?php echo $kh['name']; ?> </option>
                                    <?php } ?>
                                 </select>
                              </div>
                              <div class="col-md-5">
                                 <input type="input" name="camurl" value="<?php echo get_post_meta($order->ID, 'url', true); ?>" placeholder="http://..." class="form-control form-control-sm" />
                              </div>
                              <div class="col-md-2">
                                 <button class="btn btn-success btn-sm pull-right rounded-0 btn-block text-uppercase"><?php echo __("save","premiumpress"); ?></button>   
                              </div>
                           </div>
                        </form>
                        <?php }else{ ?>
                        <i class=" fa fa-warning"></i> <?php echo __("Please upload a banner size","premiumpress"); ?>:  <?php echo $size_parts[0]; ?>px / <?php echo $size_parts[1]; ?>px
                        <?php } ?>
                     </td>
                  </tr>
                  <?php } } ?>
                  <?php if(empty($campaigns->posts)){   ?>
                  <td colspan="6">
                     <div class="text-center"><?php echo __("No Advertising Purchased","premiumpress"); ?></div>
                  </td>
                  <?php } ?>
                 
               </tbody>
            </table>
            <h5 class="mt-5"><?php echo __("Upload Banner","premiumpress"); ?></h5>
            <hr />
            <div class="bg-light p-3 mb-4">
               <form action="" method="post" class="p-3 bg-light" enctype="multipart/form-data"  id="bupload">
                  <input type="hidden" name="action" value="sellspace" />
                  <input type="file" name="ppt_banner[]" onfocus="jQuery('#savemb').show();" />
                  <button type="submit" class="btn btn-success rounded-0 float-right" id="savemb" style="display:none;"><?php echo __("Upload Banner","premiumpress"); ?></button>   
               </form>
            </div>
            <?php if(!empty($mybanners)){	?>
            <div class="row">
               <?php foreach($mybanners as $k=> $ban){  ?>
               <div class="col-6" id="bannerbox-<?php echo $ban['id']; ?>">
                  <div class="border p-2 mb-4">
                     <div class="text-center">
                        <a href="<?php echo $ban['img']; ?>" target="_blank" class="frame"><img src="<?php echo $ban['img']; ?>" class="img-fluid"></a>
                     </div>
                     <div class="container">
                        <div class="row mt-2 border-top pt-2">
                           <div class="col-md-10">
                              <div class="mt-1 small"><?php echo $ban['name']." (".$ban['w']; ?> X <?php echo $ban['h'].")"; ?> </div>
                           </div>
                           <div class="col-md-2 text-right">
                              
                              
                                 <button class="btn btn-sm btn-danger rounded-0 text-uppercase float-right" type="button" onclick="ajax_banner_delete('<?php echo $ban['id']; ?>');"><i class="fa fa-trash"></i></button>
                              
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <?php } ?>
            </div>
            <?php }else{ ?>
            <div class="text-muted"><?php echo __("No banners found","premiumpress"); ?></div>
            <?php } ?>       
            
 
   
</div></div></div>
</div></div>
<script>

function ajax_banner_delete(id){


if(confirm("<?php echo __("Are you sure?","premiumpress"); ?>")) {
		   
 
// RESET
jQuery('#ajax_response_msg').html("");	
 
jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/',	
		dataType: 'json',	
		data: {
            action: "sellspace_delete",
			delid: id,
        },
        success: function(response) {
	 
 
			if(response.status == "ok"){
			 		
				// HIDE ROW
				jQuery('#bannerbox-'+id).hide();	
				 
				 
  		 	
			}else{			
				jQuery('#ajax_response_msg1').html("Error trying to delete.");			
			}			
        },
        error: function(e) {
            alert("error gere "+e)
        }
    });
	
}
	
}// end are you sure 
</script>