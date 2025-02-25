<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;


   // ADD ON STYLES
   wp_enqueue_style('addform', FRAMREWORK_URI.'css/_submitform.css');
   wp_enqueue_style('addform'); 
   
   
 

	if( $CORE->LAYOUT("captions","maps") && _ppt(array('maps','enable')) == 1  ){
				
		if(_ppt(array("maps","provider")) == "mapbox"){
	 
			wp_enqueue_style('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css');
			wp_enqueue_script('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js');
			  
		}elseif(_ppt(array("maps","provider")) == "google"){
				
			wp_enqueue_script('maps', $CORE->GEO("maps_google_link", array() ), array(), THEME_VERSION, $footer = true);	
		}
	}
   
  
// LOAD IN MAIN DEFAULTS
if(function_exists('current_user_can') && current_user_can('administrator')){



if(isset($_GET['duplicate'])){

	// Get id of post to be duplicated and data from it
	$post_id = $_GET['duplicate'];
	$post = get_post( $post_id );
	
	// duplicate the post
	if ( isset( $post ) && $post != null ) {
	
	// args for new post
	$args = array(
	'comment_status' => $post->comment_status,
	'ping_status'    => $post->ping_status,
	'post_author'    => $post->post_author,
	'post_content'   => $post->post_content,
	'post_excerpt'   => $post->post_excerpt,
	'post_name'      => $post->post_name,
	'post_parent'    => $post->post_parent,
	'post_password'  => $post->post_password,
	'post_status'    => 'publish',
	'post_title'     => "copy: ".$post->post_title,
	'post_type'      => $post->post_type,
	'to_ping'        => $post->to_ping,
	'menu_order'     => $post->menu_order
	);
	
	// insert the new post
	$new_post_id = wp_insert_post( $args );
	
	// add taxonomy terms to the new post
	
	// identify taxonomies that apply to the post type
	$taxonomies = get_object_taxonomies( $post->post_type );
	
	// add the taxonomy terms to the new post
	foreach ( $taxonomies as $taxonomy ) {
	 $post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
	 wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
	}
	
	// use SQL queries to duplicate postmeta
	$post_metas = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
	  
	if ( count( $post_metas ) !=0 ) { 
 	foreach ( $post_metas as $pm ) { 
	 update_post_meta($new_post_id, $pm->meta_key,$pm->meta_value);
	}
 	}  
	
	?>
    <h1>Duplicate Complete</h1>
    <p>Your new listing can be <a href="admin.php?page=listings&eid=<?php echo $new_post_id; ?>">found here.</a></p>
    <?php
    exit; 

 } else {

  // display an error message if the post id of the post to be duplicated can't be found
  wp_die( __( 'Post cannot be found. Please select a post to duplicate.', 'premiumpress' ) );
 }


}

	// COUPON CODE SETTINGS
	if(isset($_POST['custom']['newlisting']) && is_numeric($_POST['custom']['newlisting'])){
	 
			// ADD SYSTEM TRANSACTION				
			$my_post = array();				
			$my_post['post_title'] 		= $_POST['custom']['post_name']; 
			$my_post['post_type'] 		= "listing_type"; 
			$my_post['post_status'] 	= "publish";
			$my_post['post_content'] 	= ""; 
			
			// UPDATE
			if($_POST['newlisting'] == 1){
			
				$payment_id = wp_insert_post( $my_post );
			
				// ADD LOG ENTRY
				//$CORE->ADDLOG('(cron) Micro Job Finished.',  $job_seller_id, $p->ID,"",'listing', $p->ID);
			
			}else{
			
				$my_post['ID'] 	= $_POST['custom']['newlisting'];
				$payment_id = $_POST['custom']['newlisting'];
				wp_update_post( $my_post );
			
				// ADD LOG ENTRY
				//$CORE->ADDLOG('(cron) Micro Job Finished.',  $job_seller_id, $p->ID,"",'listing', $p->ID);
			
			} 
	
			// CUSTOM FIELDS
			if(isset($_POST['custom']) && is_array($_POST['custom']) && !empty($_POST['custom']) ){
				foreach($_POST['custom'] as $kk => $vv){
					 update_post_meta($payment_id, $kk, $vv);
				}
			} 				
	
	
	}

}











 
if(!defined('WLT_DEMOMODE') && current_user_can('administrator')){

if(isset($_POST['TransferFormMemberships']) && is_numeric($_POST['from']) && is_numeric($_POST['to'])){
 
 if($_POST['from'] == "-2"){
 
 	$SQL = "SELECT mt1.ID FROM ".$wpdb->prefix."users AS mt1
	LEFT JOIN ".$wpdb->prefix."usermeta AS mt2 ON (mt1.ID = mt2.user_id AND mt2.meta_key = 'ppt_membership')
	WHERE mt2.meta_key IS NULL 
	GROUP BY mt1.ID";
	$result = mysql_query($SQL, $wpdb->dbh);					 
		if (mysql_num_rows($result) > 0) {
			while ($val = mysql_fetch_object($result)){
			update_user_meta($val->ID,'ppt_membership',$_POST['to']);
			}
		}
 
 }elseif($_POST['from'] == "-1"){
 $gg = explode(",",$_POST['all']); $ext = "";
 foreach($gg  as $gh){
 $ext .= "AND ".$wpdb->prefix."usermeta.meta_value != '".$gh."' ";
 }
 $SQL = "UPDATE ".$wpdb->prefix."usermeta SET ".$wpdb->prefix."usermeta.meta_value = '".$_POST['to']."' WHERE ".$wpdb->prefix."usermeta.meta_key = 'ppt_membership' AND ".$wpdb->prefix."usermeta.meta_value != '".$_POST['from']."' ". $ext;
 
 mysql_query($SQL);
 }else{
 $SQL = "UPDATE ".$wpdb->prefix."usermeta SET ".$wpdb->prefix."usermeta.meta_value = '".$_POST['to']."' WHERE ".$wpdb->prefix."usermeta.meta_key = 'ppt_membership' AND ".$wpdb->prefix."usermeta.meta_value = '".$_POST['from']."'";
 mysql_query($SQL);
 }
 
 $GLOBALS['error_message'] = "Memberships Transfered Successfully";
 
}


if(isset($_POST['TransferFormListings']) && is_numeric($_POST['from']) && is_numeric($_POST['to'])){
 
 if($_POST['from'] == "-2"){
 
 	$SQL = "SELECT ".$wpdb->prefix."posts.ID, mt2.meta_value FROM ".$wpdb->prefix."posts 
	LEFT JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id AND mt2.meta_key = 'packageID')
	WHERE ".$wpdb->prefix."posts.post_type = '".THEME_TAXONOMY."_type' 
	AND ( ".$wpdb->prefix."posts.post_status = 'draft' OR ".$wpdb->prefix."posts.post_status = 'publish' )  
	AND mt2.meta_key IS NULL 
	GROUP BY ".$wpdb->prefix."posts.ID";
	$result = mysql_query($SQL, $wpdb->dbh);					 
		if (mysql_num_rows($result) > 0) {
			while ($val = mysql_fetch_object($result)){
			update_post_meta($val->ID,'packageID',$_POST['to']);
			}
		}
 
 }elseif($_POST['from'] == "-1"){
 $gg = explode(",",$_POST['all']); $ext = "";
 foreach($gg  as $gh){
 $ext .= "AND ".$wpdb->prefix."postmeta.meta_value != '".$gh."' ";
 }
 $SQL = "UPDATE ".$wpdb->prefix."postmeta SET ".$wpdb->prefix."postmeta.meta_value = '".$_POST['to']."' WHERE ".$wpdb->prefix."postmeta.meta_key = 'packageID' AND ".$wpdb->prefix."postmeta.meta_value != '".$_POST['from']."' ". $ext;
 mysql_query($SQL);
 }else{
 $SQL = "UPDATE ".$wpdb->prefix."postmeta SET ".$wpdb->prefix."postmeta.meta_value = '".$_POST['to']."' WHERE ".$wpdb->prefix."postmeta.meta_key = 'packageID' AND ".$wpdb->prefix."postmeta.meta_value = '".$_POST['from']."'";
 mysql_query($SQL);
 }
 
 $GLOBALS['error_message'] = "Listing Transfered Successfully";
 
}

}

if(!defined('WLT_DEMOMODE') && current_user_can('administrator')){
	// REMOVE PACKAGE FIELD
	if(isset($_POST['newsubmissionfield'])){
	
		// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
		$submissionfields = get_option("submissionfields");
		
	// FIX FOR TAX 	
	if($_POST['submissionfield']['fieldtype'] == "taxonomy"){
		$_POST['submissionfield']['key'] = "tax_".date('dmyhis');
	}
 
		if(!is_array($submissionfields)){ $submissionfields = array(); }
		// ADD ONE NEW FIELD 
		if(!isset($_POST['eid'])){
			$_POST['submissionfield']['ID'] = count($submissionfields);
			array_push($submissionfields, $_POST['submissionfield']);
			
			$GLOBALS['error_message'] = "Custom Field Added Successfully";
		}else{
			$submissionfields[$_POST['eid']] = $_POST['submissionfield'];
			
			$GLOBALS['error_message'] = "Custom Field Updated Successfully";
		}
		// SAVE ARRAY DATA		 
		update_option( "submissionfields", $submissionfields);
					
	}elseif(isset($_GET['delete_submission_field']) && is_numeric($_GET['delete_submission_field'] )){
	
		// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
		$submissionfields = get_option("submissionfields");
		if(!is_array($submissionfields)){ $submissionfields = array(); }	
		
		// DELETE SELECTED VALUE
		unset($submissionfields[$_GET['delete_submission_field']]);
		
		// SAVE ARRAY DATA
		update_option( "submissionfields", $submissionfields);
		
		$_POST['tab'] = "submission";
		$GLOBALS['error_message'] = "Custom Field Removed Successfully";
	

	}
}

 
 

 
_ppt_template('framework/admin/header' ); 

?>
 

<div class="tab-content">


        <div class="tab-pane <?php  if(isset($_GET['eid']) && is_numeric($_GET['eid']) || isset($_GET['addnew']) ){ }else{ ?>active<?php } ?> addjumplink" 
        data-title="All <?php echo $CORE->LAYOUT("captions","2"); ?>" 
        data-icon="fa-stars" 
        id="listings" 
        role="tabpanel" aria-labelledby="listings-tab"> 
        
         <?php  if(isset($_GET['eid']) && is_numeric($_GET['eid']) || isset($_GET['addnew']) ){ }else{ _ppt_template('framework/admin/parts/listings-table' ); } ?>
    
        </div>     

      
        <div class="tab-pane <?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) || isset($_GET['addnew']) ){?>active<?php } ?> addjumplink" 
        data-title="Add <?php echo $CORE->LAYOUT("captions","1"); ?>" 
        data-icon="fa-plus" 
        id="add" 
        role="tabpanel" aria-labelledby="add-tab">

		<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) || isset($_GET['addnew']) ){  _ppt_template('framework/admin/parts/listings-add' ); } ?> 

        </div>           
          
      
        
             
</div><!-- end tabs -->


<?php if(isset($_GET['addnew']) ){ ?>
<script>
jQuery(document).ready(function() {

	jQuery('#add-tab').tab('show'); 	
	ProcessAdminPackage();
	
});
</script>
<?php } ?>
 
         


<form id="TransferFormListing" name="TransferFormListing" method="post" action="">
<input type="hidden" name="TransferFormListings" id="go" />
<input type="hidden" name="tab" id="ShowTab" value="packages">
<input type="hidden" name="from" id="fromL" value="" />
<input type="hidden" name="to" id="toL" value="" />
</form> 

<div style="display:none">
   <div id="customfieldlist_new">
      <li class="cfielditem">
         <div class="heading">
            <div class="name">New Custom Field</div>
         </div>
         <div class="inside">   
            <input type="hidden" name="cfield[values][]" value=""  />
            <input type="hidden" name="cfield[cat][]" value=""  />
            <input type="hidden" name="cfield[fieldtype][]" value="input"  />
            <input type="hidden" name="cfield[required][]" value="0"  />
            <label>Display Caption</label>
            <input type="text" name="cfield[name][]" value=""  style="width:100%;" class="form-control"  />  
            <input type="hidden" id="newcfieldkey" name="cfield[dbkey][]" value="custom-"  />
            <button class="btn btn-primary mt-2 " type="submit">Save</button>
         </div>
      </li>
   </div>
</div>
<script>
jQuery(document).ready(function() {
	jQuery('#newcfieldkey').val( "custom-" + ( jQuery('#customfieldlist li').length + 1 ) );
});

</script>

<div style="display:none">
   <div id="customfieldlist1_new">
      <li class="cfielditem">
         <div class="heading">
            <div class="name">New Enhancement</div>
         </div>
         <div class="inside">    
            <label>Display Caption</label>
            <input type="text" name="cenhancement[name][]" value=""  style="width:100%; font-size:11px;" class="form-control"  />  
            <button class="btn btn-primary margin-top1" type="submit">Save</button>
         </div>
      </li>
   </div>
</div>
<div style="display:none">
   <div id="package-list_new">
      <li class="cfielditem">
         <div class="heading">
            <div class="name">New Package</div>
         </div>
         <div class="inside">
            <label>Package Name <span class="required">*</span></label>
            <input type="text" name="cpackages[name][]" value="" id="nfaqt" class="form-control" />  
            <input type="hidden" name="cpackages[price][]" value="100"  />  
            <input type="hidden" name="cpackages[key][]" value="pack<?php echo rand(); ?>"   />    
            <input type="hidden" name="cpackages[html][]" value="0"   />    
            <input type="hidden" name="cpackages[recurring][]" value="0"   />    
            <input type="hidden" name="cpackages[files][]" value="100"   />    
            <input type="hidden" name="cpackages[cats][]" value="100"   />    
            <input type="hidden" name="cpackages[days][]" value="30"   />    
            <input type="hidden" name="cpackages[subtitle][]" value=""   />
            <input type="hidden" name="cpackages[stars][]" value="0"   />
            <input type="hidden" name="cpackages[icon][]" value="fa fa-star"   />
            <input type="hidden" name="cpackages[active][]" value="0"   />
            <hr />
            <button class="btn btn-primary" type="submit" onclick="checknotblank()">Save</button>
         </div>
      </li>
   </div>
</div>



 
<?php _ppt_template('framework/admin/footer' );  ?>