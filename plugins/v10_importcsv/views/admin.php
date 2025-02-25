<?php 

global  $wpdb;


_ppt_template('framework/admin/header' ); ?>

<div class="container mt-4">
<?php
global $settings;

  $settings = array(
  "title" => __("Import/Export Tool","premiumpress"), 
  "desc" => __("Here you can import new files.","premiumpress"),
  "video" => "https://www.youtube.com/watch?v=yRNO4zG3--g",
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>  


<div class="card card-admin"><div class="card-body">

<div class="row" id="picker"id="picker">

    <div class="col-md-5">
    
    <div class="text-center" >
    
    <a href="javascript:void(0);" onclick="showmainpage();" class="btn btn-primary btn-block btn-lg " style="font-size:20px; height:240px;">
    
    <div class="mb-4 btn-block mt-5"><i class="fal fa-file-csv fa-3x"></i></div> 
    <div class="mb-4 btn-block">New Import</div>
    
    </a>
    </div>
    
    </div>
    <div class="col-md-2">
    <div class="divider-or text-muted" style="margin-top:130px;"><span>Or</span></div>
    </div>
    
    <div class="col-md-5">
    <a  href="javascript:void(0);" onclick="showmainpage();"  class="btn btn-secondary btn-block btn-lg" style="font-size:20px; height:240px;">
    
    
    <div class="mb-4 btn-block mt-5"><i class="fal fa-file fa-3x"></i></div> 
    <div class="mb-4 btn-block">Manage Files</div>
    
    </a>
    </div>

</div>
<input type="hidden" name="markscurrentab" id="markscurrentab" value="<?php if(isset($_GET['tt'])){ echo $_GET['tt']; } ?>" />

<div id="importwp-root" style="display:none;"></div>


<script>
function showmainpage(){
jQuery('#picker').hide();
jQuery('#importwp-root').show();
}
</script>
 


</div></div>





<?php

_ppt_template('framework/admin/_form-wrap-bottom' ); 

global $settings;

  $settings = array(
  "title" => __("","premiumpress"), 
  "desc" => __("","premiumpress"),
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); 
   
   $t	= $wpdb->get_row("SELECT count(*) as count FROM $wpdb->posts WHERE post_type='".THEME_TAXONOMY."_type' AND post_status = 'publish'");


   
   ?>  



 <div class="card card-admin"><div class="card-body">
 
 <?php if($t->count > 0){ ?>
 <ul>
 <?php
 

 
 if($t->count != 0){ 
 $rows= round($t->count/1000,1);
 } 
  
   
 if(isset($rows) && $rows > 0){
  
   		$i=0; 
	   while($i < $rows){
	    $csv_s = $i*1000;
	    $csv_e = 1000;
		echo '<li>- <a href="admin.php?page='.$this->properties->plugin_domain.'&exportdata=1&s='.$csv_s.'&e='.$csv_e.'" class="btn btn-system btn-md"><i class="fa fa-long-arrow-right ml-2"></i> Export Records '.$csv_s.' - '.($csv_s+$csv_e).'</a></li>';
		$i++;
	   }
  } else{
  
   echo '<li><a href="admin.php?page='.$this->properties->plugin_domain.'&exportdata=1" class="btn btn-system btn-md"><i class="fa fa-long-arrow-right ml-2"></i> Export All ('.$t->count.' Listings)</a></li>';

  
  }
  
  
	
	?> 
</ul>

<?php }else{ ?>

<div class="text-center">

You have no listing to export.
</div>

<?php } ?>


 

 
 

</div></div> 

<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>  


</div>
<?php _ppt_template('framework/admin/footer' ); ?>




<script>
 
 
jQuery(document).ready(function() {
jQuery('#content h2').html('<span><i class="fal fa-file-csv mr-2"></i> CSV Import Tool</span>');


 

});
</script>
