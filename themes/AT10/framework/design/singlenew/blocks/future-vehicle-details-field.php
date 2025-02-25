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

$auction_odometer = get_post_meta($post->ID, 'key1', true);

$auction_highlights = wp_get_post_terms($post->ID, 'highlights', true);

$current_price = get_post_meta($post->ID, 'price_current', true);

$formatted_price = number_format($current_price, 2, '.', ',');

$auction_start_date = get_post_meta($post->ID, 'live_auction_start_date', true);

$formatted_live_auction_start_date = date('H:i:s Y/m/d', strtotime($auction_start_date));




?>  
      
 
<table style="border-collapse: collapse; " class="font-size-table">
    <?php 
    if($auction_odometer != ""){
    
    ?>
    <tr>
        <td class="table-padding" style=" text-align: left;">Số km đã đi
:</td>
        <td class="table-padding" style=" text-align: right;"><?php echo $auction_odometer; ?></td>
    </tr>
    <?php }
    if($auction_highlights != ""){
    
    ?>
    <tr>
        <td class="table-padding" style=" text-align: left;">Điểm nổi bật:</td>
        <td class="table-padding" style=" text-align: right;"><?php echo $auction_highlights[0]->name; ?></td>
    </tr>
    <?php }
    if($auction_start_date != ""){
    
    ?>
    
    <tr>
        <td class="table-padding" style=" text-align: left;">Bắt đầu bán trực tuyến:</td>
        <td class="table-padding" style=" text-align: right;"><?php echo $formatted_live_auction_start_date; ?></td>
    </tr>
     <?php }
    
    
    ?>
    
    <tr style="border-top: 1px solid #e5e5e5; padding-top: 5px; margin-top: 3px;">
        <td class="table-padding" style=" text-align: left;">Giá bán:</td>
        <td class="table-padding" style=" text-align: right;"><div class=" text-primary font-weight-bold"><?php echo hook_currency_symbol(''); ?> <span class=" price_<?php echo $post->ID; ?>"></span></div></td>
    </tr>
     
   
</table>

            <script>
  document.addEventListener('DOMContentLoaded', function () {
    var currentPrice_<?php echo $post->ID; ?> = <?php echo $current_price; ?>;
    <?php if (!is_user_logged_in() || in_array('subscriber', $user_roles) || in_array('administrator', $user_roles)) { ?>
    var auctionCustomerPrice_<?php echo $post->ID; ?> = <?php echo $auction_customer_price; ?>;
    var totalPrice_<?php echo $post->ID; ?> = currentPrice_<?php echo $post->ID; ?> + auctionCustomerPrice_<?php echo $post->ID; ?>;
    var formattedPrice_<?php echo $post->ID; ?> = formatPrice_<?php echo $post->ID; ?>(totalPrice_<?php echo $post->ID; ?>);
    <?php } else { ?>
    var formattedPrice_<?php echo $post->ID; ?> = formatPrice_<?php echo $post->ID; ?>(currentPrice_<?php echo $post->ID; ?>);
    <?php } ?>
    // Use getElementsByClassName instead of getElementByClassName
    var elements = document.getElementsByClassName('price_<?php echo $post->ID; ?>');
    for (var i = 0; i < elements.length; i++) {
      elements[i].innerHTML = formattedPrice_<?php echo $post->ID; ?>;
    }
  });

  function formatPrice_<?php echo $post->ID; ?>(price) {
    if (price < 1000) {
      return price;
    } else if (price < 1000000) {
      return (price / 1000).toFixed(1) + 'K';
    } else if (price < 1000000000) {
      return (price / 1000000).toFixed(1) + 'M';
    } else {
      return (price / 1000000000).toFixed(1) + 'B';
    }
  }
</script>

<style >
    
    /* Styles for mobile */
@media screen and (max-width: 992px) {
 
  
  .font-size-table{
       font-size:9px;
  }
  
.table-padding{
    padding: 4px;
}
  
  
  
}
    
    
    
 /* Styles Desk */
    @media screen and (min-width: 992px) {
        
   
  
  .font-size-table{
       font-size:12px;
  }
  
.table-padding{
    padding: 4px;
}
  
  
  
}    
    
</style>