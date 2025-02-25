<?php

$tabyoutube = 0; $tabvimeo = 0;
if(isset($_GET['eid']) && get_post_meta($_GET['eid'], "youtube_id",true ) != ""){
$tabyoutube = 1;
}


if(_ppt('videoupload_basic') == 0 &&  _ppt("videoupload_youtube") == 0 &&  _ppt("videoupload_vimeo") == 0){
?>
<div class="my-4"></div>
<?php 
}else{

if(_ppt('videoupload_basic') == 0 &&  _ppt("videoupload_youtube") == 1){
$tabyoutube = 1;

}elseif(_ppt('videoupload_basic') == 0 &&  _ppt("videoupload_vimeo") == 1){
$tabvimeo = 1;
}

?>

<div class="card shadow-sm my-5" id="add-media-section">
  <div class="card-body">
    <h4><?php echo __("Videos","premiumpress"); ?></h4>
    <hr class="pb-0 mb-0" />
    <ul class="nav nav-tabs clearfix mt-3">
      <?php if(in_array(_ppt("videoupload_basic"),array("","1"))){ ?>
      <li class="nav-item"> <a class="nav-link py-3 text-dark <?php if( $tabyoutube == 0 ){ echo "active"; } ?>" data-toggle="tab" href="#t2" role="tab"><span class="px-lg-2"><i class="fa fa-video mr-2"></i> <?php echo __("My Videos","premiumpress") ?></span></a> </li>
      <?php } ?>
      <?php if(in_array(_ppt("videoupload_youtube"),array("","1"))){ ?>
      <li class="nav-item"> <a class="nav-link py-3 text-dark <?php if( $tabyoutube == 1 ){ echo "active"; } ?>" data-toggle="tab" href="#t3" role="tab"><span class="px-lg-2"><i class="fab fa-youtube mr-2"></i> <?php echo __("YouTube","premiumpress") ?></span> </a> </li>
      <?php } ?>
      <?php if(in_array(_ppt("videoupload_vimeo"),array("","1"))){ ?>
      <li class="nav-item"> <a class="nav-link py-3 text-dark <?php if( $tabvimeo == 1 ){ echo "active"; } ?>" data-toggle="tab" href="#t4" role="tab"><span class="px-lg-2"><i class="fab fa-vimeo mr-2"></i> <?php echo __("Vimeo","premiumpress") ?></span></a> </li>
      <?php } ?>
    </ul>
    <div class="tab-content p-3 pb-4 bg-white border single" style="margin-top: -1px;">
      <div id="ajax_video_msg"></div>
      <div id="ajax_media_msg"></div>
      <?php if(in_array(_ppt("videoupload_basic"),array("","1"))){ ?>
      <div class="tab-pane fade <?php if(  $tabyoutube == 0 ){ echo "active show"; } ?>" id="t2" role="tabpanel">
        <?php _ppt_template('framework/design/add/add-video' ); ?>
      </div>
      <?php } ?>
      <?php if(in_array(_ppt("videoupload_youtube"),array("","1"))){ ?>
      <div class="tab-pane fade <?php if( $tabyoutube == 1 ){ echo "active show"; } ?>" id="t3" role="tabpanel">
        <?php _ppt_template('framework/design/add/add-youtube' ); ?>
      </div>
      <?php } ?>
      <?php if(in_array(_ppt("videoupload_vimeo"),array("","1"))){ ?>
      <div class="tab-pane fade <?php if(  $tabvimeo == 1 ){ echo "active show"; } ?>" id="t4" role="tabpanel">
        <?php _ppt_template('framework/design/add/add-vimeo' ); ?>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<?php } ?>