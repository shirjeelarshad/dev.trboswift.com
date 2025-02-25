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

 
 
$bh = get_post_meta($post->ID,'businesshours',true);

$days = array(
__('Monday',"premiumpress"),
__('Tuesday',"premiumpress"),
__('Wednesday',"premiumpress"),
__('Thursday',"premiumpress"),
__('Friday',"premiumpress"),
__('Saturday',"premiumpress"),
__('Sunday',"premiumpress"),
);
 

if(is_array($bh) && !empty($bh) ){ 

 
$i=0; $countClosed = 0; while($i < 7){  if(isset($bh['active'][$i]) && $bh['active'][$i] == 1){ }else{ $countClosed++; } $i++; }

?>

<ul class="working-hour list-unstyled mt-4">
  <?php $i=0; while($i < 7){ 
  
  
  if(_ppt(array('design','element_open12')) == "1"){
  
	  $start =  date('g:i A', strtotime($bh['start'][$i]));
	  
	  $end = date('g:i A', strtotime($bh['end'][$i]));
  
  }else{
	  
	  $start =  date('H:i A', strtotime($bh['start'][$i]));
	  
	  $end =  date('H:i A', strtotime($bh['end'][$i]));
  
  }
  
  ?>
  <li> <?php echo $days[$i]; ?>
    <?php if(isset($bh['active'][$i]) && $bh['active'][$i] == 1){  ?>
    <span>
    <?php  echo $start." - ".$end; ?>
    </span>
    <?php }else{ ?>
    <span><?php if(THEME_KEY == "es"){  echo __("Busy","premiumpress"); }else{ echo __("Closed","premiumpress"); } ?></span>
    <?php } ?>
  </li>
  <?php $i++; } ?>
</ul>
<?php }else{ $showhide = 1; } ?>

<?php if(isset($showhide)){ ?>
 <script>
	   jQuery(document).ready(function(){ 
	   jQuery("#single-display-openinghours").html('');
	   });
	   </script>
<?php } ?>