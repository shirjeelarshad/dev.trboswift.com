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

if(!_ppt_checkfile("author.php")){

$GLOBALS['flag-author'] = 1;
 
global $CORE, $authorID, $CORE;
 
// TURN ON/OFF DISPLAY 
if(_ppt(array('user','allow_profile')) == 0){ 
	header("location: ".home_url());
	exit();
}

// CHECK WE HAVE A PROFILE ALREADY
// IF SO LINK DIRECTLY TOO IT
if(THEME_KEY == "da"  ){
   	$SQL = "SELECT DISTINCT ".$wpdb->posts.".ID FROM ".$wpdb->posts." WHERE post_type = 'listing_type' AND post_status = 'publish' AND post_author = ('".$userdata->ID."') LIMIT 1";				 
   	$query = $wpdb->get_results($SQL, OBJECT);
   	if(!empty($query)){
		$link =  get_permalink($query[0]->ID);
		header("location: ".$link);
		exit();
   	}
} 


	// ADD PUBLIC LOG
	if($userdata->ID){
		$CORE->FUNC("add_log",
			array(				 
				"type" 		=> "public_profile_view",
				"to" 		=> $authorID, 						
				"from" 		=> $userdata->ID,				
				"public" => 1,		
									 
			)
		);
	}

$subscribers = $CORE->USER("get_subscribers", $authorID);  
$followers = $CORE->USER("get_subscribers_followers", $authorID);  

 
// UPDATE VIEW COUNTER
$CORE->USER("update_views", $authorID);

 


get_header(); ?>

<section class="section-60 bg-light">

  <div class="container">
    <div class="row">
    
      <div class="col-md-3">
        <?php get_template_part( 'framework/design/account/account-sidebar' ); ?>
      </div>
      
      <div class="col-md-9"> 
        
         <?php  if(_ppt(array('user','author_ads')) == 1){ 
		 
		 
		 if($CORE->USER("count_listings", $authorID) == 0){
		 
		 ?>
         
         <div class="card"><div class="card-body text-center py-5">
         
         <h4><?php echo __("Nothing Found","premiumpress") ?></h4>
         <p><?php echo __("This user has not published anything yet.","premiumpress") ?></p>
         
         </div>
         </div>
         
         <?php
		 
		 }else{
		
		 echo do_shortcode('[LISTINGS card_class="col-md-4" dataonly=1 nav=0 custom=author authorid='.$authorID.' ]'); 
		 
		 }
		 
		 
		 }  ?> 
         
          
    </div> 
      
  </div>       
          
</div>
</section>



<?php get_footer(); ?>
<?php } ?>