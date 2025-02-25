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

global $CORE, $settings;
 
 
$settings = array("title" => "Order System", "desc" => "Here is an overview of the order system.");

_ppt_template('framework/admin/_form-wrap-top' ); ?>

<div class="card card-admin">
  <div class="card-body">
    <h6>How it works</h6>
    <hr />
    <p class="lead text-muted">Orders are created when a customer completes the checkout process. Each order is given a unique Order ID.</p>
    <div class="text-center"> <img src="<?php echo DEMO_IMG_PATH; ?>flow2.png" class="img-fluid"   /> </div>
    <h6>Order ID</h6>
    <hr />
    <p class="text-muted lead">Order ID's are non-sequential as they use the default WordPress ID approach. The order ID is constructed using a number of data elements.</p>
    <pre>

{ORDER TYPE} - { USER ID } - { POST ID } - { DATE }

</pre>
    <h6>Order Process</h6>
    <hr />
    <div class="row mb-4">
      <div class="col-4"> Paid </div>
      <div class="col-4"> Processing </div>
      <div class="col-4"> Complete </div>
      <div class="col-12 mt-2">
        <div class="progress">
          <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
<?php

$settings = array("title" => "Order Status", "desc" => "The order status indicated the current status of the order.");

_ppt_template('framework/admin/_form-wrap-top' ); ?>
<table class="table table-bordered bg-white shadow-sm mb-4">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Key</th>
      <th scope="col">Description</th>
      <th scope="col">Color Tag</th>
    </tr>
  </thead>
  <tbody>
    <?php
$types = $CORE->ORDER("get_status",array());
$i=1;
foreach($types as $k => $t){ ?>
    <tr>
      <th scope="row"><?php echo $i; ?></th>
      <td><?php echo $k; ?></td>
      <td><?php echo $t['name']; ?></td>
      <td><div style="background:<?php echo $t['color']; ?>" class="p-2 text-white font-weight-bold text-center"><?php echo $t['color']; ?></div></td>
    </tr>
    <?php  $i++; } ?>
  </tbody>
</table>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
<?php

$settings = array("title" => "Order Process", "desc" => "The order process indicated the current process of the order.");

_ppt_template('framework/admin/_form-wrap-top' ); ?>
<table class="table table-bordered bg-white shadow-sm mb-4">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Key</th>
      <th scope="col">Description</th>
      <th scope="col">Color Tag</th>
    </tr>
  </thead>
  <tbody>
    <?php
$types = $CORE->ORDER("get_process",array());
$i=1;
foreach($types as $k => $t){ ?>
    <tr>
      <th scope="row"><?php echo $i; ?></th>
      <td><?php echo $k; ?></td>
      <td><?php echo $t['name']; ?></td>
      <td><div style="background:<?php echo $t['color']; ?>" class="p-2 text-white font-weight-bold text-center"><?php echo $t['color']; ?></div></td>
    </tr>
    <?php  $i++; } ?>
  </tbody>
</table>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
<?php

$settings = array("title" => "Order Types", "desc" => "Order types are used to indicate what sort of payment the order is for.");

_ppt_template('framework/admin/_form-wrap-top' ); ?>
<table class="table table-bordered bg-white shadow-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Key</th>
      <th scope="col">Description</th>
      <th scope="col">Color Tag</th>
    </tr>
  </thead>
  <tbody>
    <?php
$types = $CORE->ORDER("get_type",array());
$i=1;
foreach($types as $t){ ?>
    <tr>
      <th scope="row"><?php echo $i; ?></th>
      <td><?php echo $t['id']; ?></td>
      <td><?php echo $t['name']; ?></td>
      <td><div style="background:<?php echo $t['color']; ?>" class="p-2 text-white font-weight-bold text-center"><?php echo $t['color']; ?></div></td>
    </tr>
    <?php  $i++; } ?>
  </tbody>
</table>
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
<?php

/*

 


<h4>Basic Commands</h4>
 
<pre class="bg-light">

$orderadd = $CORE->ORDER('add', array('order_id', 'order_status','user_id'));

$CORE->ORDER("get_type", $orderid);

$CORE->ORDER("get_status", $orderid);

$CORE->ORDER("check_exists", $orderid);

$CORE->ORDER("format_id", $orderid);

</pre> 

*/ ?>
