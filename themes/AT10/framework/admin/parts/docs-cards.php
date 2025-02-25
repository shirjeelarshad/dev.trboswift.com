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
   
   global $CORE_ADMIN;
   
  
   ?> 
   
   
<?php

$folderArray = array(

	1 => array("path" => "cards") ,
);



$i=1;
foreach($folderArray as $p){

// LOAD FOOTER DATA
$HandlePath = get_template_directory()."/framework/design/".$p['path']."/"; 
$images = array();
if($handle1 = opendir($HandlePath)) {      
	while(false !== ($file = readdir($handle1))){	
		if(strlen($file) > 5 && substr($file, -3) == "php" ){
		$file = trim(str_replace(".php","", str_replace("","", $file)));
		$images[]  = $file;			 	
		}
	}	
}

?>
<div class="row">

<?php
foreach($images as $img){
 
?>

<div class="col-4">

<?php
 
$settings = array("class" => ""); 
get_template_part('framework/design/cards/'.$img); 
 
?>

</div> 

<?php } ?>
</div> 
<?php $i++; } ?>    
 