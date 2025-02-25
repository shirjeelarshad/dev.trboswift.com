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

global $wpdb, $CORE, $CORE_ADMIN;

 
// GET PAGES
$page_links = array();
$pages = get_pages();
foreach ( $pages as $page ) { 

	$link = get_page_link( $page->ID );
	
	$page_links[$page->ID] = array("id" => $link , "name" => $page->post_title);

}

// PAGE LINKS ARRAY
$pagelinksarray = array(

	"myaccount" 	=> array("name"=> __("My Account","premiumpress"), "type" => "select",  "pagelinks" => 1, ),
	"callback" 		=> array("name"=> __("Callback","premiumpress"), "type" => "select",  "pagelinks" => 1, ),
	"add" 			=> array("name"=> __("Add Listing","premiumpress"), "type" => "select",  "pagelinks" => 1,),
 
	"blog" 			=> array("name"=> __("Blog","premiumpress"), "type" => "select",  "pagelinks" => 1, ),			
	"sellspace" 	=> array("name"=> __("Advertising Page","premiumpress"), "type" => "select", "pagelinks" => 1, ),			
			 
	"aboutus" 		=> array("name"=> __("About Us Page","premiumpress"), "type" => "select",  "pagelinks" => 1, ),			
	
	"memberships" 	=> array("name"=> "Memberships", "type" => "select",  ),
	
	"contact" 		=> array("name"=> __("Contact Form","premiumpress"), "type" => "select", "pagelinks" => 1, ),
	"terms" 		=> array("name"=> __("Terms &amp; Conditions Page","premiumpress"), "type" => "select", "pagelinks" => 1, ),
	"privacy" 		=> array("name"=> __("Privacy Page","premiumpress"), "type" => "select", "pagelinks" => 1, ),	
			
	"faq" 			=> array("name"=> __("FAQ Page","premiumpress"), "type" => "select", "pagelinks" => 1, ),	
	"testimonials" 	=> array("name"=> __("Testimonials Page","premiumpress"), "type" => "select", "pagelinks" => 1, ),	
			
	"how" 			=> array("name"=> __("How it works","premiumpress"), "type" => "select",  "pagelinks" => 1, ),
			
	"stores" 			=> array("name"=> __("Stores","premiumpress"), "type" => "select",  "pagelinks" => 1, ),
	"categories" 		=> array("name"=> __("Category List","premiumpress"), "type" => "select",  "pagelinks" => 1, ),
	
	"email_verify" 			=> array("name"=> __("Email Verified (Thank You Page)","premiumpress"), "type" => "select",  "pagelinks" => 1, ),
	
	
	 
);

 



if( !$CORE->LAYOUT("captions","memberships") ){ 
unset($pagelinksarray['memberships']);
}

if(!in_array(THEME_KEY, array("cp","cm")) ){
unset($pagelinksarray['stores']);
}

if(THEME_KEY == "sp"){

	$pagelinksarray["cart"] 	= array("name"	=> __("Cart","premiumpress"), 	"type" => "select",  );			
	$pagelinksarray["checkout"] = array("name"	=> __("Checkout Page","premiumpress"), "type" => "select",  );
	
	unset($pagelinksarray['offers']);
	unset($pagelinksarray['add']);
	 
}

if(THEME_KEY == "so"){

	$pagelinksarray["cart"] 	= array("name"	=> __("Cart","premiumpress"), 	"type" => "select",  );			
	$pagelinksarray["checkout"] = array("name"	=> __("Checkout Page","premiumpress"), "type" => "select",  );
	 
	 
}

if(in_array(THEME_KEY, array("da")) ){
$pagelinksarray["chatroom"] 	= array("name"	=> __("Chatroom","premiumpress"), 	"type" => "select",  );			
	
}


foreach($pagelinksarray  as $key => $link){

$value = _ppt(array("links",$key));
 
  
 ?>
<!-- ------------------------- -->

<div class="container px-0 border-bottom mb-3" <?php /* if($key == "add" && _ppt(array('lst','adminonly')) == 1 ){ $value = ""; echo "style='display:none;'"; }*/ ?>>
  <div class="row py-2">
    <div class="col-md-4">
      <label><?php echo str_replace("(","<br>(",$link['name']); ?></label>
  
    </div>
    <div class="col-md-8">
    
    <div class="position-relative">
       <input class="form-control" type="text" id="pagelinkfor<?php echo $key; ?>" name="admin_values[links][<?php echo $key; ?>]" value="<?php echo $value; ?>">
       
       <?php if(_ppt(array("links",$key)) != ""){ ?>
       <span class="input-group-addon" style="top: 10px;    right: 10px;    position: absolute;    z-index: 100;"> <a href="<?php echo _ppt(array("links",$key)); ?>" target="_blank"> <span class="fal fa-external-link"></span></a> </span>
       <?php } ?>
    </div>
       
       <select class="form-control-sm mt-2 border-0 bg-light" onchange="jQuery('#pagelinkfor<?php echo $key; ?>').val(this.value)">
       <option></option>
       <?php
	   foreach($page_links as $p){
	   ?>
       <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
       <?php } ?>
       </select>
     
    </div>
  </div>
</div>
<!-- ------------------------- -->
<?php
 
} 
?> 