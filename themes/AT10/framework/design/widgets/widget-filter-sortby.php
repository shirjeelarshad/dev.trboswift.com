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


$sortbyArray = array(

1 => array("id" => "date-d", "name" => __("Newest","premiumpress") ),
2 => array("id" => "date-u", "name" => __("Oldest","premiumpress") ),


7 => array("id" => "price-d", "name" => __("Price","premiumpress")." (".__("Highest","premiumpress").")" ),
8 => array("id" => "price-u", "name" => __("Price","premiumpress")." (".__("Lowest","premiumpress").")"  ),

13 => array("id" => "title-u", "name" => __("Title - A-z","premiumpress")),
14 => array("id" => "title-d", "name" => __("Title - Z-a","premiumpress")),


16 => array("id" => "pop-u", "name" => __("Most Popularity","premiumpress")  ),
17 => array("id" => "pop-d", "name" => __("Least Popularity","premiumpress") ),

18 => array("id" => "featured", "name" => __("Featured","premiumpress") ),

3 => array("id" => "dis-d", "name" => __("Distance (Nearest)","premiumpress") ),
4 => array("id" => "dis-u", "name" => __("Distance (Furthest)","premiumpress") ),

);  

if(in_array(THEME_KEY, array('dt'))){

unset($sortbyArray[7]);
unset($sortbyArray[8]);

}

/*
$sortbyArray = array(
11 => array("id" => "", "name" => __("Times Used","premiumpress") ),
12 => array("id" => "", "name" => __("Expiry Date","premiumpress") ),


1 => array("id" => "", "name" => __("Downloads (High-Low)","premiumpress") ),
2 => array("id" => "", "name" => __("Downloads (Low-High)","premiumpress") ),



5 => array("id" => "", "name" => __("Age (High-Low)","premiumpress") ),
6 => array("id" => "", "name" => __("Age (Low-High)","premiumpress") ),

1 => array("id" => "", "name" => __("Downloads (High-Low)","premiumpress") ),
2 => array("id" => "", "name" => __("Downloads (Low-High)","premiumpress") ),

3 => array("id" => "", "name" => __("Distance (Nearest)","premiumpress") ),
4 => array("id" => "", "name" => __("Distance (Furthest))","premiumpress") ),

5 => array("id" => "", "name" => __("Age (High-Low)","premiumpress") ),
6 => array("id" => "", "name" => __("Age (Low-High)","premiumpress") ),



9 => array("id" => "", "name" => __("Auction Ending","premiumpress")." (".__("Newest","premiumpress").")"  ),
10 => array("id" => "", "name" => __("Auction Ending","premiumpress")." (".__("Oldest","premiumpress").")"   ),

*/ 

 ?>


<select class="customfilter nice-select wide"  id="filter-sortby-main"  name="sort" data-type="select" data-key="sortby" <?php if(!$CORE->isMobileDevice()){ ?>onchange="_filter_update()" <?php } ?>>
    <?php foreach($sortbyArray as $s){ ?>
    <option value="<?php echo $s['id']; ?>" <?php if( isset($_GET['sort']) && $_GET['sort'] == $s['id']){ ?>selected=selected<?php } ?>><?php echo $s['name']; ?></option>
    <?php } ?>
</select> 