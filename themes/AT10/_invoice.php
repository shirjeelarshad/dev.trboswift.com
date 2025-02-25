<?php 

if(!isset($_GET['invoiceid']) || !is_numeric($_GET['invoiceid']) ){ header('HTTP/1.0 403 Forbidden'); exit;  }

	// TRY TO GENERATE THE CORRECT SERVER PATH FROM THE FILE LOCATION
	// IF YOUR HERE TO EDIT THE SERVER PATH, EDIT THE VALUE BELOW
	
 	$te = explode("wp-content",$_SERVER['SCRIPT_FILENAME']);
	$SERVER_PATH_HERE = $te[0];
	
	if(file_exists($SERVER_PATH_HERE.'/wp-config.php')){
				 
		require( $SERVER_PATH_HERE.'/wp-config.php' );
	
	}else{
	
		die('<h1>Invoice Path Incorrect</h1>
		<p>The script could not generate the correct server path to your invoice file.</p>
		<p>Please edit the file below and manually set the correct server path.</p>
		<p>'.$_SERVER['SCRIPT_FILENAME'].'</p>');
	
	}
	
	// START MAIN INVOICE CONTENT	
	global $wpdb, $userdata; wp_get_current_user();
	
	// 1. GET INVOICE DSTA
	$data = $CORE->ORDER("get_order", $_GET['invoiceid']);	 
	$order_type = $CORE->ORDER("get_type", $data['order_id']);
 
		// INVOICE FOR OFFERS
		if(isset($order_type['id']) && $order_type['id'] == "OFFER"){ 
		
		$buyerid = get_post_meta($_GET['invoiceid'], "buyer_id", true); 
		$sellerid = get_post_meta($_GET['invoiceid'], "seller_id", true); 
		
		}
		
  
	if($data){ 
	
	
	}else{
	
		die("This invoice no longer exists.");
	}
	
 
 
?>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <title><?php echo __("Invoice","premiumpress") ?> #<?php echo $CORE->ORDER("format_id", $_GET['invoiceid']); ?></title>
   <link rel="stylesheet" href="<?php echo FRAMREWORK_URI; ?>css/_bootstrap.css" media="screen" />
   <link rel="stylesheet" href="<?php echo FRAMREWORK_URI; ?>css/css.premiumpress.css" media="screen" />
</head>
<body>
 
 

 <div class="container">
  <div class="card"> 

  
<div class="card-header">
  
<h1 class="h2">#<?php echo $CORE->ORDER("format_id", $_GET['invoiceid']); ?></h1> 

<?php echo hook_date( $data['order_date']); ?> 

<span class="float-right"> <strong><?php echo __("Status","premiumpress") ?>:</strong> <?php $h = $CORE->ORDER("get_status", $data['order_status']); echo $h['name']; ?></span>

</div>
<div class="card-body">
<div class="row mb-4">
<div class="col-sm-6">

<?php if($order_type['id'] == "OFFER"){  ?>

<h6 class="mb-3"><?php echo __("Seller","premiumpress") ?>:</h6>
	<div><strong><?php echo _ppt(array('company','name')); ?></strong></div>
    <div><?php echo wpautop(_ppt(array('company','address'))); ?></div>
    <div><?php echo _ppt(array('company','phone')); ?></div>
    <div><?php echo _ppt(array('company','email')); ?></div>
<?php }else{ ?>
<h6 class="mb-3"><?php echo __("From","premiumpress") ?>:</h6>

    <div><strong><?php echo _ppt(array('company','name')); ?></strong></div>
    <div><?php echo wpautop(_ppt(array('company','address'))); ?></div>
    <div><?php echo _ppt(array('company','phone')); ?></div>
    <div><?php echo _ppt(array('company','email')); ?></div>
<?php } ?>

</div>

<div class="col-sm-6">

<?php if($order_type['id'] == "OFFER"){   ?>

<h6 class="mb-3"><?php echo __("Buyer","premiumpress") ?>:</h6>

  <div><strong><?php echo $CORE->USER("get_name", $buyerid); ?></strong></div>
    <div><?php echo $CORE->USER("get_address", $buyerid); ?></div>
    <div><?php echo $CORE->USER("get_phone", $buyerid); ?></div>
    
<?php }elseif(is_numeric($data['order_userid'])){  ?>
   
    <h6 class="mb-3"><?php echo __("To","premiumpress") ?>:</h6>
        
    <div><strong><?php echo $CORE->ORDER("user_get_name", $data['order_userid']); ?></strong></div>
    <div><?php echo $CORE->ORDER("user_get_address", $data['order_userid']); ?></div>
    <div><?php echo $CORE->ORDER("user_get_phone", $data['order_userid']); ?></div>
 
<?php } ?>
</div>


</div>

<?php
 
echo $CORE->ORDER("get_order_items", $_GET['invoiceid'] );




?>      

</div>

</div>
</div>
</div>

<div class="printbutton no-print mt-2 text-center" ><a href="javascript:void(0);" onClick="window.print()"><?php echo __("Print Invoice","premiumpress") ?></a></div>


</body>
</html>