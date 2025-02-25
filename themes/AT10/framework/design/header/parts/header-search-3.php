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

<form action="<?php echo home_url(); ?>" class="search position-relative border-bottom" style="max-width:250px;" >
  <input type="text" name="s" class="form-control border-0 typeahead" placeholder="<?php
  
  
  if(THEME_KEY == "cp"){
		
		echo __("Store name or keyword..","premiumpress");
		
		}else{
		
		  echo __("Keyword..","premiumpress");
		  
		}
   
   ?>" autocomplete="off">
  <button type="submit" class="position-absolute btn p-0 m-0" style="top:10px; right:10px;"> <i class="fa fa-search"></i> </button>
</form>
