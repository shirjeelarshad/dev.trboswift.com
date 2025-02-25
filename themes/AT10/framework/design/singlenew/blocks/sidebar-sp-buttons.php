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

global $CORE, $userdata, $post;

$qty = get_post_meta($post->ID, "qty", true );
if($qty == ""){ $qty = 10; }
$qty_min = 1;
 
// GET PRODUCT TYPE
$product_type = get_post_meta($post->ID,'type',true);

// INCLUDE BASKET BUTTONS
$inlineBtn = 0;
if(isset($GLOBALS['inlineBtn'])){
$inlineBtn = 1;
}
 

if($qty > 0){ ?>

<div class="row">
  <?php if($qty == 1){ ?>
  <input type="hidden" id="qtyvalue" value="1">
  <?php }elseif($qty > 1){ ?>
  <div class="col-12 <?php if(is_array(_ppt('listingtax')) && in_array("size", _ppt('listingtax'))){  ?>col-lg-6<?php } ?>"  id="qtybox">
    <label class="small text-muted btn-block"><?php echo __("Quantity","premiumpress"); ?></label>
    <div id="qtyvaluewrapper">
      <select class="form-control" id="qtyvalue" onchange="updateqtyfield(this.value);">
        <?php $i=1;  while($i < $qty ){ if($i > 5){ $i++; continue; } ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php $i++; } ?>
        <?php if($qty > 5){ ?>
        <option value="custom">5+</option>
        <?php } ?>
      </select>
    </div>
  </div>
  <?php } ?>
  <?php if(is_array(_ppt('listingtax')) && in_array("size", _ppt('listingtax'))){ 

// SIZE
$cats = get_terms( "size", array( 'hide_empty' => 0, 'parent' => 0  ));

$foundcats 	= wp_get_object_terms( $post->ID, "size" );

if(is_array($foundcats) && !empty($foundcats)){

$ordered_list = array_column($foundcats, 'term_order');
 
array_multisort( $ordered_list, SORT_ASC, $foundcats);

?>
  <div class="col-lg-6">
    <?php /* <a href="<?php echo get_template_directory_uri(); ?>/_shop/sizechart.png" data-gal="prettyPhoto" class="text-underline float-right tiny"><?php echo __("Size Chart","premiumpress"); ?></a> */ ?>
    <label class="small text-muted btn-block"><?php echo $CORE->GEO("translation_tax_key", "size"); ?> </label>
    <select class="form-control field-attribute-select">
      <?php
 
foreach($foundcats as $cat){

$selected_categories[$cat->term_id] = $cat->term_id;

$customprice = get_post_meta($post->ID, 'price_addone_' . $cat->term_id . '_value', true );
if($customprice == "" || !is_numeric($customprice)){
$customprice = 0;
}


?>
      <option 
        
         name="size" 
         value="<?php echo $cat->name; ?>" 
         data-key='size'
         data-value='0'
         data-amount='<?php echo $customprice; ?>' 
         data-stock='100'
         data-tokens='0'        
        > <?php echo $cat->name; ?>
      <?php if($customprice != 0){ ?>
      (+<?php echo hook_price($customprice); ?>)
      <?php } ?>
      </option>
      <?php } ?>
    </select>
  </div>
  <?php } ?>
  <?php 
	
}
		  

if(is_array(_ppt('listingtax')) && in_array("color", _ppt('listingtax'))){ 

// SIZE
$cats = get_terms( "color", array( 'hide_empty' => 0, 'parent' => 0,  'orderby' => 'term_order' ));

$foundcats 	= wp_get_object_terms( $post->ID, "color");
 
if(is_array($foundcats) && !empty($foundcats)){

$ordered_list = array_column($foundcats, 'term_order'); 
array_multisort( $ordered_list, SORT_ASC, $foundcats);
 

?>
  <div class="col-12 mt-2">
    <label class="small text-muted btn-block"><?php echo $CORE->GEO("translation_tax_key", "color"); ?></label>
    <select class="form-control field-attribute-select">
      <?php 

foreach($foundcats as $cat){

$selected_categories[$cat->term_id] = $cat->term_id;

$customprice = get_post_meta($post->ID, 'price_addone_' . $cat->term_id . '_value', true );
if($customprice == "" || !is_numeric($customprice)){
$customprice = 0;
}
?>
      <option name="color" 
         value="<?php echo $cat->name; ?>" 
         data-key='color'
         data-value='0'
         data-amount='<?php echo $customprice; ?>' 
         data-stock='100'
         data-tokens='0'
        ><?php echo $cat->name; ?>
      <?php if($customprice != 0){ ?>
      (+<?php echo hook_price($customprice); ?>)
      <?php } ?>
      </option>
      <?php } ?>
    </select>
  </div>
  <?php } ?>
  <?php } ?>
  <?php 


$tax = get_option('custom_taxonomy');  

 
if(is_array($tax)){
foreach ( $tax as $taxonomy ) {  


if(is_array(_ppt('listingtax')) && in_array($taxonomy, _ppt('listingtax')) && !in_array($taxonomy, array('size','color'))){ 


	// GET DATA
	$cats = get_terms( array( 'taxonomy' => $taxonomy, 'parent' => 0, 'hide_empty' => 0 )  );
if(!empty($cats)){
?>
  <div class="mt-2">
    <label class="small text-muted btn-block"><?php echo $CORE->GEO("translation_tax_key", $taxonomy); ?></label>
    <select class="form-control field-attribute-select">
      <?php 
foreach($cats as $cat){

 
$customprice = 0;
?>
      <option name="<?php echo $taxonomy; ?>" 
         value="<?php echo $cat->name; ?>" 
         data-key='<?php echo $taxonomy; ?>'
         data-value='0'
         data-amount='<?php echo $customprice; ?>' 
         data-stock='100'
         data-tokens='0'
        ><?php echo $cat->name; ?></option>
      <?php } ?>
    </select>
  </div>
  <?php } } ?>
  <?php } } ?>
</div>
<?php if($product_type == 2){ ?>
<a href="<?php echo get_post_meta($post->ID,'buy_link',true); ?>" rel="nofollow" target="_blank" class="btn btn-block btn-lg rounded-0 btn-primary mt-3"> <i class="fa fa-shopping-basket"></i> <?php echo __("Buy Now","premiumpress"); ?> </a>
<?php }else{ ?>
<div class="row mt-4">
  <div class="col-12 <?php if($inlineBtn){?>col-md-6<?php } ?>">
    <button type="button" id="single_addcart_btn" class="btn btn-block btn-lg rounded-0 btn-primary "> <i class="fa fa-shopping-cart"></i> <?php echo __("Add to cart","premiumpress"); ?> </button>
  </div>
  <div class="col-12 <?php if($inlineBtn){?>col-md-6<?php }else{ ?>mt-4<?php } ?>">
    <button type="button" id="single_checkoutnow" class="btn btn-block btn-lg rounded-0 btn-outline-secondary "> <i class="fa fa-shopping-basket"></i> <?php echo __("Buy Now","premiumpress"); ?> </button>
  </div>
</div>
<?php } ?>
<?php }else{ $dd = get_post_meta($post->ID,'stock_outofmsg', true); ?>
<div class="bg-light py-4 text-center font-weight-bold mt-4">
  <?php  if($dd == ""){ echo __("Out of stock","premiumpress"); }else{ echo $dd; } ?>
</div>
<?php } ?>
<script>

function updateqtyfield(qty){


	if(qty == "custom"){
	
		jQuery('#qtyvaluewrapper').html('<input type="text" class="form-control" value="5" id="qtyvalue">');
 
	
	}

}

               
jQuery(document).ready(function(){ 
           
	// UPDATE CART PRICE
	ajax_cart_calculateprice();
    
	
	// QTY UP
	jQuery("a.qtyup").click(function(){
           	
           	var max_amount = <?php echo $qty; ?>;
           	if(jQuery('#item_stock_count').length > 0){
           		max_amount = parseFloat(jQuery('#item_stock_count').text());
           	}
           	
           	if(jQuery('#qtyvalue').val() < max_amount){
           	var nn = parseFloat(jQuery('#qtyvalue').val());
           		
           		jQuery('#qtyvalue').val(nn +1);
           		jQuery('.qtyamount').html(nn +1);
           		ajax_cart_calculateprice();
           	}
           		
           		
	}); 
			

	// QTY DOWN           
	jQuery("a.qtydown").click(function(){
				
				if(jQuery('#qtyvalue').val() > 1){
					var nn = parseFloat(jQuery('#qtyvalue').val());
					
					jQuery('#qtyvalue').val(nn-1);
					jQuery('.qtyamount').html(nn-1);
					ajax_cart_calculateprice();
				}
	}); 
	
	// BUY BUTTON
 	jQuery('#single_addcart_btn').click(function() {					
       if(jQuery('#ppt_shop_required').val() == 1){
                                    
         // ADDD TO CART
         ajax_cart('add', jQuery('#qtyvalue').val(), '<?php echo $post->ID; ?>', '', 'yes');
		 
        }
    });
            
});
   
  
jQuery('#single_checkoutnow').click(function() {					
     
     ajax_cart('add', jQuery('#qtyvalue').val(), '<?php echo $post->ID; ?>', '', 'no');  
     
     setTimeout(function(){
     
     	window.location.href = "<?php echo _ppt(array('links','checkout')); ?>";
     
     }, 2000); 
});   

/*

	// UPDATE STOCK COUNTER
	jQuery('#item_stock_count').html(stock);
	 
	//HIDE BUY AREA OF STOCK IS 0
	if(stock < 1){
		jQuery('#item_buyarea').hide();
		jQuery('#item_outofstockmsg').show();
		jQuery('#qtybox').hide();
	}else {
		jQuery('#item_outofstockmsg').hide();	
	}
*/
     
    
</script>
