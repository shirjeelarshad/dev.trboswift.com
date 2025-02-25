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


$auction_make = wp_get_post_terms($post->ID, brand);

$auction_model_num = get_post_meta($post->ID, 'modelnum', true);

$auction_model_year = wp_get_post_terms($post->ID, year);

$auction_vin = get_post_meta($post->ID, 'key72706', true);

$auction_odometer = get_post_meta($post->ID, 'key1', true);

$auction_vehicle_color = wp_get_post_terms($post->ID, color);

$auction_location = wp_get_post_terms($post->ID, location);

$auction_run_drive = wp_get_post_terms($post->ID, runs-drives);

$auction_Damage = get_post_meta($post->ID, 'key46187', true);





?>  

<div>  

<span class="live-auction-highlights pb-4 pt-4">Highlights</span>
 
<table style="border-collapse: collapse; width: 100%" class="font-size-table">
    <?php 
    if(!empty($auction_make)){
    
    ?>
    <tr>
        <td class="table-padding">Make:</td>
        <td><?php echo $auction_make[0]->name; ?></td>
    </tr>
     <?php }
    if($auction_model_num != ""){
    
    ?>
    <tr>
        <td class="table-padding">Model:</td>
        <td><?php echo $auction_model_num; ?></td>
    </tr>
     <?php }
    if(!empty($auction_model_year)){
    
    ?>
    <tr>
        <td class="table-padding">Year:</td>
        <td><?php echo $auction_model_year[0]->name; ?></td>
    </tr>
    <?php }
    
    if($auction_vin != ""){
    
    ?>
    <tr>
        <td class="table-padding">VIN:</td>
        <td><?php echo $auction_vin; ?></td>
    </tr>
    <?php }
    
    if($auction_odometer != ""){
    
    ?>
    <tr>
        <td class="table-padding">KM:</td>
        <td><?php echo $auction_odometer; ?></td>
    </tr>
     <?php }
    
    if(!empty($auction_vehicle_color)){
    
    ?>
    <tr>
        <td class="table-padding">Color:</td>
        <td><?php echo $auction_vehicle_color[0]->name; ?></td>
    </tr>
    <?php }
    
    if(!empty($auction_location)){
    
    ?>
    <tr>
        <td class="table-padding">Location:</td>
        <td><?php echo $auction_location[0]->name; ?></td>
    </tr>
     <?php }
     
     if(!empty($auction_run_drive)){
    
    ?>
    <tr>
        <td class="table-padding">Runs & Drives:</td>
        <td><?php echo $auction_run_drive[0]->name; ?></td>
    </tr>
     <?php }
     
    if($auction_Damage != ""){
    
    ?>
    <tr>
        <td class="table-padding">Damage:</td>
        <td><?php echo $auction_Damage; ?></td>
    </tr>
    <?php } ?>
</table>

</div>  

<style >




  /* Responsive Font Size */
  @media screen and (max-width: 768px) {
    .font-size-table td {
      font-size: 14px; /* Adjust the font size as needed */
    }
  }

  /* Hover Effect */
  .font-size-table tr:hover {
    background-color: #f5f5f5; /* Change the background color on hover */
  }

  /* Padding for Table Cells */
  .font-size-table td {
    padding: 8px; /* Adjust the padding as needed */
    text-align: left;
  }

  .font-size-table td:last-child {
    text-align: right;
  }
    
    /* Styles for mobile */
@media screen and (max-width: 992px) {
 
  
  .font-size-table{
       font-size:10px;
  }
  
.table-padding{
    padding: 4px;
    font-weight:bold;
}
  
  
  
}
    
  .table-padding{
    padding: 4px;
    font-weight:bold;
}  
   
    
</style>



