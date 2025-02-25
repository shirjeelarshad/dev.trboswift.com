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


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

  
?> 

<style>
 

.project .row {
    margin: 0;
    padding: 15px 0;
    margin-bottom: 15px
}

.project div[class*='col-'] {
    border-right: 1px solid #eee
}

.project .text h3 {
    margin-bottom: 0;
    color: #555
}

.project .text small {
    color: #aaa;
    font-size: 0.75em
}

 
.project .image {
    max-width: 50px;
    min-width: 50px;
    height: 50px;
    margin-right: 15px
}

.project .time,
.project .comments,
.project .project-progress {
    color: #999;
    font-size: 0.9em;
    margin-right: 20px
}

.project .time i,
.project .comments i,
.project .project-progress i {
    margin-right: 5px
}

.project .project-progress {
    width: 200px
}

.project .project-progress .progress {
    height: 4px
}

.project .card {
    margin-bottom: 0
}

@media (max-width: 991px) {
    .project .right-col {
        margin-top: 20px;
        margin-left: 65px
    }
    .project .project-progress {
        width: 150px
    }
}

@media (max-width: 480px) {
    .project .project-progress {
        display: none
    }
}
.has-shadow {
    -webkit-box-shadow: 2px 2px 2px rgba(0,0,0,0.1), -1px 0 2px rgba(0,0,0,0.05);
    box-shadow: 2px 2px 2px rgba(0,0,0,0.1), -1px 0 2px rgba(0,0,0,0.05);
}
 
</style>


<div class="container px-0">
    <div class="row">
        <div class="col-md-4 pr-lg-4">                
        <h3 class="mt-4">Elementor Templates</h3>        
        <p class="text-muted lead mb-4">These pages are pre-built designs we've created to get you started. You can customize them anyway you like and reinstall if you want to start again.</p>
        
        
        
        
 <?php if(!defined('ELEMENTOR_VERSION')){ ?> 

<div class="alert alert-success p-2">

    <div class="row">
 
    <div class="col-md-12 mt-4">
    
    <div class="h5 mb-3">Elementor Plugin <u>Required</u> </div>
    
    <p class="lead">To edit the page content you need to install Elementor.</p>
    
    <p>Elementor is a <b>free</b> WordPress plugin that allows you to visually design your website pages using drag-and-drop elements. </p>
    
    <a href="<?php echo home_url(); ?>/wp-admin/plugin-install.php?tab=plugin-information&plugin=elementor" class="btn btn-success btn-block mt-3 rounded-0" id="elp">Install Plugin</a>
    
    </div>
    </div> 

</div>
 
<?php }elseif(current_user_can('administrator') && defined('ELEMENTOR_VERSION') ){ ?>

<a href="javascript:void(0);" onclick="AutoInstallElementor();" class="btn btn-sm  btn-success"><i class="fal fa-cog mr-2"></i> Auto Install &amp; Setup</a>
   
<script>
function AutoInstallElementor(){

jQuery('.project').hide();
jQuery('.projects').html("<div class='mb-4'><i class='fa fa-spinner  fa-spin fa-1x fa-fw'></i> installing...</div>");

jQuery.ajax({
        type: "POST",
        url: '<?php echo home_url(); ?>/wp-admin/admin.php?page=design',	
		 	
		data: {
            doinstallelementor: "1"			 
        },
        success: function(response) {	
		 	
			//if(response == "ok"){
					
				jQuery('.projects').html("<i class='fa fa-check-circle text-success'></i> Templates Installed Successfully. Page refresh in <b>3</b> seconds...");
				 
				setTimeout(function() {
					window.location.href = "<?php echo home_url(); ?>/wp-admin/admin.php?page=design&setup=done";
				}, 3000);
				
			//}else{			
			//	jQuery('.projects').html("<i class='fa fa-close text-danger'></i> Installation Failed");		
			//}			
        },
        error: function(e) {
            console.log(e)
        }
    }); 

}

<?php if(isset($_GET['autosetup'])){ ?>
jQuery(document).ready(function(){
AutoInstallElementor();
});
<?php } ?>

</script>
<?php } ?>
       
        
        
        
        
        
        
        
        
        
        
        
        </div>
        <div class="col-md-8">            
        
		<div class="card card-admin"><div class="card-body">
        
        
        



        
        
        
 



<?php

// GET INSTALL HISTORY
$data = get_option('premiumpress_elemetor_templates');
if(!is_array($data)){ $data = array(); }

 
$templates = hook_v9_admin_elementor_templates(array());

  
if(!empty($templates)){ foreach($templates as $key => $t){


$elementor_file = $t['file'];	
			
 
?>

  <!-- Project-->
  <div class="project b7">
    <div class="row bg-white border">
      <div class="left-col col-lg-6 d-flex align-items-center justify-content-between">
        <div class="project-title d-flex align-items-center">
          
          <?php if(isset($t['image']) && strlen($t['image']) > 1){ ?>
		  <div class="image has-shadow" style="overflow:hidden;">		  
          <a href="<?php echo $t['image']; ?>" target="_blank"><img src="<?php echo $t['image']; ?>" alt="<?php echo $t['name']; ?>" class="img-fluid"></a>
          </div>
          <?php } ?>
          
         
          <div class="text">
            <h3 class="h5 mb-2"><?php echo $t['name']; ?></h3>
            
<?php if(isset($data[$key]['date'])){ ?>
<small>Last installed on <?php echo hook_date($data[$key]['date']); ?></small>
<?php }else{ ?>
<small>Never installed.</small>
<?php } ?>
           
            <!-- <small><?php echo $t['description']; ?></small> -->
          </div>
        </div>
      
      </div>
      <div class="right-col col-lg-6 d-flex align-items-center">
      
      
      

<?php
	
	if(file_exists($elementor_file)){ 

?>
    <a href="<?php if(!defined('ELEMENTOR_VERSION')){ echo "#";}else{ ?> <?php echo home_url(); ?>/wp-admin/admin.php?page=design&install_e_t=<?php echo $key; ?>&lefttab=elementor-tab<?php } ?>" <?php if(!defined('ELEMENTOR_VERSION')){ ?>onclick="alert('Please install the Elementor plugin first.'); jQuery('#elp').addClass('btn-success');"<?php } ?> class="btn btn-primary mr-2 rounded-0 btn-sm"><?php if(isset($data[$key]['template_id'])){ ?>Reinstall<?php }else{ ?>Install Template<?php } ?></a>
    <?php if(isset($t['video']) && $t['video'] != ""){ ?>
    <a href="<?php echo $t['video']; ?>" target="_blank" class="btn btn-primary rounded-0">Watch Video Tutorial</a>
    <?php } ?>

<?php }else{ ?>

<div class="text-center w-100">Template file missing!</div>

<?php } ?>


    <?php if(isset($data[$key]['template_id']) && !is_object($data[$key]['template_id']) && defined('ELEMENTOR_VERSION') ){ ?>
    
    
    <a href="<?php echo home_url()."/wp-admin/post.php?post=".$data[$key]['template_id']."&action=elementor"; ?>" target="_blank" class="btn btn-secondary mr-2 rounded-0 btn-sm">Edit/ Preview</a>
    
     
        <?php if(isset($t['homepage']) && $t['homepage'] ){ ?>
        
        <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=design&sethomepage=<?php echo $data[$key]['page_id']; ?>&lefttab=elementor-tab" class="btn btn-warning btn-sm mr-2 rounded-0 btn-sm">Set homepage</a>
         
        <?php } ?>
        
        
         <?php if(isset($t['header']) && $t['header'] ){ ?>
         
        <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=design&setheader=<?php echo $data[$key]['page_id']; ?>&lefttab=elementor-tab" class="btn btn-warning btn-sm mr-2 rounded-0 btn-sm">Set header</a> 
         
        <?php } ?>
        
        
         <?php if(isset($t['footer']) && $t['footer'] ){ ?>
         
        <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=design&setfooter=<?php echo $data[$key]['page_id']; ?>&lefttab=elementor-tab" class="btn btn-warning btn-sm mr-2 rounded-0 btn-sm">Set footer</a>
        <?php } ?>
        
        
    <?php } ?>
        
        
       
      </div>
    </div>
  </div> 

 


<?php } } ?>

<?php if(empty($templates)){ ?>

<div>There are no Elementor templates for this design.</div>

<?php } ?>





<div class="mt-5">

<?php

$elementorArray = array();
$args = array('post_type' 			=> 'elementor_library', 'posts_per_page' 	=> 12, "s" => "home");
$wp_query = new WP_Query($args);
$tt = $wpdb->get_results($wp_query->request, OBJECT);
if(!empty($tt)){ foreach($tt as $p){
$elementorArray[$p->ID] = get_the_title($p->ID);
} }
if(!empty($elementorArray)){
?>
<ul class="small">
<?php  foreach ( $elementorArray as $key => $title ) { ?>
<li>#<?php echo $key; ?> - <?php echo $title; ?> <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=design&sethomepagesingle=<?php echo $key; ?>&lefttab=elementor-tab"><u>Set as homepage</u></a></li>
<?php } ?>
</ul>
<?php } ?>

</div>
 


</div></div></div></div></div>

 














 



 

 

<script>

function sff(){
jQuery('#tab-pagebuilder').hide();
jQuery('.ppt_submenu a[href="#tab-pageassign"]').tab('show');
	 	
}
</script>
 