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

global $CORE, $post, $userdata;


 

switch(THEME_KEY){


case "at": {

?>

<?php if(!isset($GLOBALS['global_design3'])){ ?> 
<div class="sub-header mb-3 small">  

<span class="link-dark"><i class="fal <?php echo do_shortcode('[CATEGORYICON codeonly=1]'); ?> text-primary"></i><span class="ml-2"><?php echo do_shortcode('[CATEGORY limit=2]'); ?></span></span>


      <?php if(in_array(_ppt(array('user','favs')), array("","1")) ){ ?>
      <span class="link-dark ml-3">
      <?php if(!$userdata->ID){ ?>
      <a href="javascript:void(0);" onclick="processLogin();"><i class="fal fa-heart text-primary"></i> <?php echo __("Add to favorites","premiumpress") ?></a>
      <?php }else{ ?>
      <?php echo do_shortcode('[FAVS class="mt-2" icon_name="fal fa-heart text-primary" text=1 icon=1]'); ?>
      <?php } ?>
       </span>
      <?php } ?>

</div>
<?php } ?>

  
  
     
        

  
  


<?php

} break;


 } // end switch ?>
   
         
         
      

 <?php if($CORE->USER("membership_hasaccess", "view_profile")){  ?> 


          
          <div class="addeditmenu mr-4" data-key="content"></div>
          
          <div class="card-text <?php if(!isset($GLOBALS['global_design3'])){ ?> addReadMore showlesscontent<?php } ?> mb-4"><?php echo do_shortcode('[CONTENT]'); ?></div>
          
          
          
 <?php if(in_array(_ppt(array('design', 'display_addthis')), array("","1"))){ ?>
<div class="addthis_inline_share_toolbox mb-4"></div>            
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6041aeed65b26d12"></script>
<?php } ?> 

          
          
<?php if(!isset($GLOBALS['global_design3']) && !in_array(THEME_KEY, array("sp","es"))  ){ ?>        
<script>
function AddReadMore() {

    var carLmt = 420;
    var readMoreTxt = " ... <?php echo __("Read More","premiumpress"); ?>";
    var readLessTxt = " <?php echo __("Read Less","premiumpress"); ?>";
 
    jQuery(".addReadMore").each(function() {
        if (jQuery(this).find(".firstSec").length)
            return;

        var allstr = jQuery(this).text();
        if (allstr.length > carLmt) {
            var firstSet = allstr.substring(0, carLmt);
            var secdHalf = allstr.substring(carLmt, allstr.length);
            var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore'  title='Click to Show More'><u>" + readMoreTxt + "</u></span><span class='readLess' title='Click to Show Less'><u>" + readLessTxt + "</u></span>";
            jQuery(this).html(strtoadd);
        }

    });
    jQuery(document).on("click", ".readMore,.readLess", function() {
        jQuery(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
    });
}
jQuery(document).ready(function(){ 
    AddReadMore();
});
</script>
<?php } ?>


      <?php }else{ ?>
    <div class="position-relative">
      <div class="post-body content-blur" style=" width: 100%;    height: 100%;    border: 5px solid #FFF;    background: #FFF;    clip: rect(300px, 415px, 605px, 0);    z-index: 2;    -webkit-transform: translate3d(0, 0, 0);    -webkit-transform-origin: 0 0;    -webkit-filter: blur(5px);    -webkit-backface-visibility: hidden;">
      
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
        
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p>
       
      </div>
      <div style="top:45%; left:-20px;" class="position-absolute w-100 text-center font-weight-bold"> <i class="fa fa-lock-alt mr-2"></i> <?php echo __("Members Only","premiumpress") ?> </div>
    </div>
    <?php } ?>