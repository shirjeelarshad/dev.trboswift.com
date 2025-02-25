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

global $CORE, $post;


 
// GET OLD PRICE
$oldprice = get_post_meta($post->ID,'old_price',true); 

if(in_array(THEME_KEY, array("da","es")) && $CORE->USER("get_online_status", $post->post_author)){ ?>     
             
<div class="featured-ribbon hide-mobile bg-success"><span><?php echo __("Online","premiumpress"); ?></span></div>  
 
  <?php
  }elseif(get_post_meta($post->ID, "status", true ) == 1){ ?>
   <div class="featured-ribbon hide-mobile"><span><?php echo __("Sold","premiumpress"); ?></span></div>
  <?php }elseif(is_numeric($oldprice) && $oldprice > 0){ ?>
   <div class="featured-ribbon hide-mobile"><span><?php echo __("On Sale","premiumpress"); ?></span></div>
  <?php }elseif($CORE->PACKAGE("featured",$post->ID)){ ?>
  <div class="featured-ribbon hide-mobile"><span><?php echo __("Featured","premiumpress"); ?></span></div>
  <?php }elseif($CORE->PACKAGE("sponsored",$post->ID)){ ?>
  <div class="featured-ribbon hide-mobile"><span><?php echo __("Sponsored","premiumpress"); ?></span></div> 
 <?php } ?>