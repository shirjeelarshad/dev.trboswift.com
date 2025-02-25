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

<div class="py-4">

    <div>
    <div class="row">
              
        <div class="col-md-3 border-right">  
        
          
        </div>
        <div class="col-md-3 border-right">  
        
        
        </div> 
        
        <div class="col-md-3 border-right">  
        
        
        </div> 
        
        <div class="col-md-3 ">  
        
 

 <label class="custom-control custom-checkbox ">
<input type="checkbox" name="delete" id="delete-seleced" value="1" class="custom-control-input" >
<div class="custom-control-label"> Delete Selected</div>

        
        
        </div> 
        
   <div class="col-12">
   
   <hr />
   
   <button class="btn btn-primary color2 rounded-pill" type="button" onclick="ajax_massupdate_listings();">Update Selected</button>

   
   </div>
    
    </div>    
    </div>   

</div>