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
        <h3 class="mt-4"><?php echo __("Import Subscribers","premiumpress"); ?></h3>        
        <p class="text-muted lead mb-4"><?php echo __("Here you can import newsletter subscribers.","premiumpress"); ?></p>
        
         <a href="https://www.youtube.com/watch?v=A23nzR48OkU" class="btn btn-danger text-light mt-4 shadow-sm btn-sm px-3 popup-yt"><i class="fa fa-video mr-1"></i> <?php echo __("watch video","premiumpress"); ?></a>
   
        
        
        </div>
        <div class="col-md-8">            
        
		<div class="card card-admin"><div class="card-body">  
 

<form method="post"  action="admin.php?page=email" >
 
<input type="hidden" name="action" value="importemails" />  
 
<div class="mt-3 mb-3 text-muted"><?php echo __("Enter email addresses below, each on a new line with optional name values. <br /> Import format is: <b> example@hotmail.com","premiumpress"); ?></b></div>

<textarea class="form-control" id="import_emails_data" style="height:400px !important;" name="import_emails"></textarea>  
                
 
  <div class="p-4 bg-light text-center mt-4">
         <button type="submit" class="btn btn-admin"><?php echo __("Import Subscribers","premiumpress"); ?></button>
    	</div>
     
 
</form>
      
        
        </div><!-- end col 8 -->
      

    </div></div>  <!-- end admin card -->
        
        

</div></div>  <!-- end row -->
        