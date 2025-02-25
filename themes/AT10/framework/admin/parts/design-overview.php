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

global $CORE;

 
?> 
   <style>
   
   #intro-box { display:none; }
   </style> 
     
     <p class="lead text-muted"><?php echo __("What would you like to do?","premiumpress"); ?></p>
     
    
    <div class="row">
    
        <div class="col-lg-6 mb-4">  
        
        <div class="card1 shadow" style="background: #e43546 url(<?php echo get_template_directory_uri()."/framework/admin/"; ?>images/bg2.png) no-repeat right top;">   
         
        <h3 class="text-white"> <?php echo __("Edit Design","premiumpress"); ?></h3>
        <p class="text-white mt-3" style="font-size:16px;"><?php echo __("Edit current design.","premiumpress"); ?></p>
        
        <a href="#homepage" id="homepage-box1" data-targetdiv="pagelinking" onclick="jQuery('.lefttab').val('pagelinking-tab');" class="btn btn-sm btn-admin color3 mt-3 customlist" ><i class="fa fa-home"></i> <?php echo __("Edit Pages","premiumpress"); ?></a>
        
        </div>
    </div>
    
     <div class="col-lg-6 mb-4">
        
        <div class="card1 shadow" style="background:#0866c6 url(<?php echo get_template_directory_uri()."/framework/admin/"; ?>images/bg1.png) no-repeat right top;">   
        
        <h3 class="text-white"><?php echo __("New Design","premiumpress"); ?></h3>
        <p class="text-white mt-3" style="font-size:16px;"><?php echo __("View all designs.","premiumpress"); ?></p>
        
        <a href="#ideas" id="ideas-box1" data-targetdiv="ideas" class="btn btn-sm btn-admin color3 mt-3 customlist"><i class="fa fa-search"></i> <?php echo __("View Designs","premiumpress"); ?></a>
        
        </div> 
    
    	</div> 
    
    </div> 


<hr />

<div id="overviewlist" class="row"> </div>  