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

global $CORE, $wpdb;

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
 
  
?>

<div class="container px-0">
  <div class="row">
    <div class="col-md-4 pr-lg-4">
      <h3 class="mt-4"><?php echo __("Send Newsletter","premiumpress"); ?></h3>
      <p class="text-muted lead mb-4"><?php echo __("Here you can send a mass email to all newsletter subscribers","premiumpress"); ?></p>
    </div>
    <div class="col-md-8">
      <div class="card card-admin">
        <div class="card-body">
          <form method="post" name="admin_email" id="admin_email" action="admin.php?page=email" >
            <input type="hidden" name="action" value="sendnewsletter" />
            <label class="txt500"><?php echo __("Subject","premiumpress"); ?></label>
            <input type="text" name="subject" class="form-control mt-2"/>
            <label class="txt500 mt-4"><?php echo __("Content","premiumpress"); ?></label>
            
 <?php

$content = "";
 

 echo wp_editor( $content, 'newsletter_message', array( 'textarea_name' => 'newsletter_message', 'editor_height' => '300px !important') );  ?>   
            
            
<div class=" mt-4">
<label class="font-weight-bold"><?php echo __("Email Shortcodes","premiumpress"); ?></label>

<?php $shortcodes = $CORE->email_message_filter('',array("unsubscribe" => "unsubscribe link"), true, "newsletter"); ?>
<select class="form-control" id="newslettershortcodes" onchange="appendText(this.value,'newsletter_message')">
<option></option>
	<?php foreach($shortcodes as $key => $sc){ ?>
    <option value="<?php echo $key; ?>"><?php echo "(".$key.") = ".$sc; ?></option>
    <?php } ?>
</select>

 

</div>           
            
            
            
            
            <div class="p-4 bg-light text-center mt-4">
              <button type="submit" class="btn btn-admin"><?php echo __("Send Newsletter","premiumpress"); ?></button>
            </div>
          </form>
          <div class="alert alert-info mt-3 rounded-0 small"><i class="fa fa-info-circle mr-1"></i> <strong><?php echo __("Remember","premiumpress"); ?></strong> <?php echo __("Use the short code <code>(unsubscribe)</code> within your email to include an unsubscribe link for users to subscribe from your newsletter list.","premiumpress"); ?></div>
          
          <hr />
          
          
          <?php
		    // ORDERS
			$args = array(
				'post_type' 		=> 'ppt_newsletter',
				'posts_per_page' 	=> 500,
				'paged' 			=> 1,
				
					'meta_query' => array( 
						'user_id'    => array(
							'key' 			=> 'news_email',	
							'value' 		=> "",
							'compare' 		=> '!=',								 					 			
						),	
						
						'verified'    => array(
							'key' 			=> 'news_verified',	
							'value' 		=> "yes",
							'compare' 		=> '=',								 					 			
						),				 	
					), 
				 
					
			  );
			  
			  
			  $wp_query1 = new WP_Query($args);    
			  $emails = $wpdb->get_results($wp_query1->request, OBJECT);
			   
		  ?>
          
         <div class="opacity-5"><?php echo str_replace("%s", "<strong>".$wp_query1->found_posts."</strong>", __("This email will be sent to %s verified users.","premiumpress") ); ?></div>
          
          
          
        </div>
      </div>
    </div>
  </div>
</div>
