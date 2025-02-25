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


$SQL = "SELECT DISTINCT meta_value FROM ".$wpdb->prefix."postmeta AS mt1 WHERE mt1.meta_key = 'msg_stick' AND mt1.meta_value LIKE ('%[".$userdata->ID."]%') ORDER BY meta_id DESC";
		$useridlist = array(); 
		$result = $wpdb->get_results($SQL);
		 
		foreach($result as $j){
		
			$h = str_replace("[]","",$j->meta_value);
			$k = explode("]", $h);
			foreach($k as $n){
			
				$id = str_replace("[","",$n);
				if(is_numeric($id)  ){ //&& $userdata->ID != $id
				
					$date = date("Y-m-d H:i:s");				 
				 
					// GET THE LAST CHAT TIME 					
					$SQL = "SELECT ".$wpdb->prefix."posts.post_date, ".$wpdb->prefix."posts.post_content, mt1.meta_value as v FROM ".$wpdb->prefix."posts 
					INNER JOIN ".$wpdb->prefix."postmeta AS mt1 ON (".$wpdb->prefix."posts.ID = mt1.post_id AND  mt1.meta_key = 'msg_stick' 
					AND ( mt1.meta_value LIKE '%[".$id."][".$userdata->ID."]%' OR  mt1.meta_value LIKE '%[".$userdata->ID."][".$id."]%' ) )  
					WHERE  1= 1
					AND ".$wpdb->prefix."posts.post_status = 'publish' 
					AND ".$wpdb->prefix."posts.post_type = 'ppt_message' ORDER BY ".$wpdb->prefix."posts.post_date DESC LIMIT 1";					 
					$result = $wpdb->get_results($SQL);	
					
					foreach($result as $bb){
					
					
						$date = $bb->post_date;
						$content = strip_tags($bb->post_content);
						
						 
						preg_match("/\[smile:(.+?)\]/", $content, $matches);	
						if(isset($matches[1]) && is_numeric($matches[1]) ){
							
							$smiles = $CORE->USER("smiles", 0);			
							$content = str_replace("[smile:".$matches[1]."]","<i class='ppt-smile-icon icon-size-chatwindow icon-".$smiles[$matches[1]]."'></i>", $content);
							
							  
						
						}
				
						
						$metav = $bb->v;
						
						$useridlist[$id] = array("uid" => $id, "last" => $date, "content" => $content, "meta" => $metav);
					}
					 
					
					 
				
				}			
			}		
		}
		
		 
	 	array_multisort(array_map('strtotime',array_column($useridlist,'last')),SORT_DESC,  $useridlist);
 
?>

<div class="card mb-4">
  <div class="card-header d-sm-flex d-block  bg-white">
    <h4 class=" text-black mb-0"><i class="fal fa-envelope mr-2"></i> <?php echo __("Recent Messages","premiumpress") ?></h4>
  </div>
  <div class="pt-3 position-relative" style="min-height:300px;">
  
  
  
  
  <?php if( !$CORE->USER("membership_hasaccess", "msg_read") ){  ?>
<div style="position:absolute; top:0; right:0;     width: 100%;    height: 100%;" class="bg-white y-middle">

   <div class="p-4 text-center">
   
    <h4><i class="fal fa-lock mr-2"></i> <?php echo __("No Access","premiumpress"); ?></h4>	
    
	<div class="mt-4 small"><?php echo __("Please upgrade your membership to access this feature.","premiumpress"); ?></div>
    
    <a href="javascript:void(0);" onclick="SwitchPage('membership');" class="btn btn-system btn-md mt-4"><?php echo __("View My Membership","premiumpress"); ?></a>
    </div>

</div>

<?php }elseif(empty($useridlist)){ ?>

<div style="position:absolute; top:0; right:0;     width: 100%;    height: 100%;" class="bg-white y-middle">

   <div class="p-4 text-center">
   
    <h4><i class="fal fa-frown mr-2"></i> <?php echo __("No Messages","premiumpress"); ?></h4>	
    
	<div class="mt-4 small"><?php echo __("You haven't received any messages.","premiumpress"); ?></div>
  
    </div>

</div>

<?php }else{ 

	

$k = 1;
foreach($useridlist as $u => $ud){

/*
$kh = explode("]", $ud['meta']);
if(isset($kh[1])){
	$kt = number_format(str_replace("[","",$kh[1]));
	echo $kt;
	//if($kt != $userdata->ID){
	$ud['uid'] = $kt;
	//}
}

echo "/".$ud['uid']."<--";
*/
 

		if(!isset($lastuid )){ $lastuid = $ud['uid']; } // GET FIRST ID FOR OUR USER LIST
		
		$vv = $CORE->date_timediff($ud['last']);
		 
		if($ud['uid'] == $userdata->ID){ continue; }
		if($k > 2){ $k++; continue; } 
		
		
		
		
		?>
    <div class="media mb-4 border-bottom p-3" data-uid="<?php echo $ud['uid']; ?>">
      <div class="image-bx mr-sm-4 mr-2" style="max-width:50px;"> <?php echo $CORE->USER("get_photo", $ud['uid']); ?> </div>
      <div class="media-body d-sm-flex justify-content-between d-block align-items-center">
        <div class="w-100"> <span class="small opacity-5 float-right"><?php echo $vv['string-small']; ?> <?php echo __("ago","premiumpress") ?></span>
          <h6 class="mb-sm-2 mb-0"><a href="<?php echo $CORE->USER("get_user_profile_link", $ud['uid']); ?>" class="text-black"><?php echo $CORE->USER("get_username", $ud['uid']); ?></a></h6>
          <p class="text-black mb-sm-3 mb-1 pb-0 small"><?php echo substr($ud['content'],0,200); ?></p>
          <a <?php echo $CORE->USER("get_message_link", $ud['uid']); ?> class="btn btn-system btn-sm"><i class="fal fa-paper-plane mr-2 text-primary"></i> <?php echo __("Reply","premiumpress") ?></a> </div>
      </div>
    </div>
    <?php
		$k++; } ?>
    <div class="text-center mb-3 pb-2"> <a onclick="SwitchPage('messages');" href="javascript:void(0);" class="text-decoration-none small text-dark"><?php echo __("View All Messages","premiumpress") ?></a> </div>
 <?php } ?>
 
 
  </div>
</div>

    
