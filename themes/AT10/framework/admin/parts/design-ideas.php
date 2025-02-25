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


function compare_lastname($a, $b){

	return strnatcmp($a['order'], $b['order']);

} 

$child = $CORE->LAYOUT("load_designs_by_theme", "childtheme_".strtolower(THEME_KEY)); 
if(!empty($child)){
 
usort($child, 'compare_lastname');

?>

<div class="container px-0">
  <div class="row">
    <div class="col-md-4 pr-lg-4">
      <h3 class="mt-4"><?php echo __("Child Themes","premiumpress"); ?></h3>
      <p class="text-muted lead mb-4"><?php echo __("Here you can install any of the child theme designs you've installed.","premiumpress"); ?></p>
    </div>
    <div class="col-md-8">
      <div class="card card-admin">
        <div class="card-body">
          <div class="row">
            <?php foreach($child as $key => $h){ ?>
            <div class="col-md-6 text-center mb-4">
              <div class="card-top-image card-zoom   mb-5">
                <figure style="min-height:150px;"> <img src="<?php echo $h['image']; ?>" class="img-fluid" alt="">
                  <div class="read_more" style="top:30%"> <a href="<?php echo home_url(); ?>/?design=<?php echo $h['key']; ?>" target="_blank"><span class="bg-dark text-white"><i class="fal fa-search"></i> <?php echo __("View Design","premiumpress"); ?></span></a> </div>
                  <div class="read_more" style="top:50%"> <a href="javascript:void(0);" onclick="jQuery('#loaddesign').val('<?php echo $h['key'] ?>');document.loaddemodesign.submit();"><span class="btn-primary color3 text-white"><i class="fal fa-upload"></i> <?php echo __("Install Theme","premiumpress"); ?> </span></a> </div>
                  <?php if(defined('ELEMENTOR_VERSION')){ ?>
                  <div class="read_more" style="top:70%"> <a href="admin.php?page=design&loadpage=<?php echo $h['key'] ?>" target="_blank"><span class="bg-success text-white"> <i class="fab fa-elementor"></i> <?php echo __("Load Elementor","premiumpress"); ?> </span></a> </div>
                  <?php } ?>
                </figure>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="container px-0">
  <div class="row">
    <div class="col-md-4 pr-lg-4">
      <h3 class="mt-4"><?php echo __("Ready Made Ideas","premiumpress"); ?></h3>
      <p class="text-muted lead mb-4"> <?php echo __("Our ready-made ideas are a quick way to setup your website with different default layouts. Click on any of the layouts below to auto-configure your settings. ","premiumpress"); ?> </p>
      <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=design&resetdemo=1" class="btn btn-dark btn-sm roudned-0"><i class="fa fa-sync-alt"></i> <?php echo __("Reset To Demo","premiumpress"); ?></a>
      <?php if(!defined('ELEMENTOR_VERSION')){ ?>
      <a href="admin.php?page=plugins" class="btn shadow-sm btn-system bg-warning text-light mt-5 border-0 btn-md"><i class="fab fa-elementor"></i> <?php echo __("Install Elementor","premiumpress"); ?></a>
      <?php } ?>
      <hr />
      <p class="text-muted lead mb-4"> <strong class="font-weight-bold"><?php echo __("Note","premiumpress"); ?></strong> <?php echo __("Stock images are not included.","premiumpress"); ?> You can find free images online at <a href="https://pixabay.com/" target="_blank" class="link" style="color:#3366FF">pixabay</a> and <a href="https://unsplash.com" target="_blank" style="color:#3366FF">unsplash.com</a> </p>
    </div>
    <div class="col-md-8">
      <div class="card card-admin">
        <div class="card-body">
          <div class="row">
            <?php 

$categories = $CORE->LAYOUT("get_demo_categories", array());
foreach($categories[THEME_KEY] as $cid => $cat){ 
		 	
$g = $CORE->LAYOUT("load_designs_by_theme", $cid);

usort($g, 'compare_lastname');


?>
            <div class="col-12">
              <h4><?php echo $cat; ?></h4>
              <hr />
            </div>
            <?php 

foreach($g as $key => $h){ 

 

?>
            <div class="col-md-4 text-center mb-4">
              <div class="card-top-image card-zoom 5">
                <figure style="min-height:150px;"> <img src="<?php echo $h['image']; ?>" class="img-fluid" alt="">
                  
                  
                  <div class="read_more" style="top:30%"> <a href="<?php echo home_url(); ?>/?design=<?php echo $h['key']; ?>" target="_blank"><span class="bg-dark text-white"><i class="fal fa-search"></i> <?php echo __("View Design","premiumpress"); ?></span></a> </div>
                  
                  <?php if(isset($h['elementor']) && !defined('ELEMENTOR_VERSION')){  }else{ ?>                  
                  
                  <div class="read_more" style="top:50%"> <a href="javascript:void(0);" onclick="jQuery('#loaddesign').val('<?php echo $h['key'] ?>');document.loaddemodesign.submit();"><span class="btn-primary color3 text-white"><i class="fal fa-upload"></i> <?php echo __("Install Theme","premiumpress"); ?></span></a> </div>
                  
                  <?php } ?>
                  
                  
                  <?php if(defined('ELEMENTOR_VERSION')){ ?>               
                
                  <div class="read_more" style="top:70%"> <a href="admin.php?page=design&loadpage=<?php echo $h['key'] ?>" target="_blank"><span class="bg-success text-white"> <i class="fab fa-elementor"></i> <?php echo __("Load Elementor","premiumpress"); ?></span></a> </div>
                  <?php } ?>
                </figure> 
              
              </div>
              
                  
                <div class="mb-5">
              <?php  if(isset($h['elementor']) ){ ?>
              <div class="tiny text-danger">requires elementor</div>
              <?php } ?>
              </div>
              
             
            </div>
            
            <?php } ?>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
