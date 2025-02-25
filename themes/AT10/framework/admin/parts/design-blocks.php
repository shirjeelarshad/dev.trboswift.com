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
   
   global $CORE; ?>
<?php 

if(isset($_GET['sid'])){


$CORE->LAYOUT("load_blocks", $CORE->LAYOUT("get_blocks_data", array()) ); 


}else{ 



?>

<div class="row">
  <div class="<?php if(!isset($_GET['smallwindow'])){  ?>col-md-4 pr-lg-4 <?php }else{ ?>col-md-3 pl-4<?php } ?>">
    <?php if(!isset($_GET['smallwindow'])){  ?>
    <h3 class="mt-4 count-all"><?php echo __("All Blocks","premiumpress"); ?> <span></span> </h3>
    <p class="text-muted lead"><?php echo __("Here you can view all the design blocks integrated into this theme.","premiumpress"); ?></p>
    <?php } ?>
    <ul class="list-group list-group-flush mt-5 <?php if(!isset($_GET['smallwindow'])){  ?>pr-4 <?php } ?>">
      <?php 
	
	 
	$allblocks = $CORE->LAYOUT("get_block_types",array());
	
	 
	
	foreach($allblocks as $type){ 
	
	
	if(isset($_GET['pagekey']) && $_GET['pagekey'] == "home" && in_array($type['id'], array("header","footer"))){
	 continue;
	}
	 
	
	?>
      <li class=" mb-2 d-flex justify-content-between align-items-center border-bottom pb-2"> <a href="#" onclick="jQuery('.blocklist').hide(); jQuery('#blocklist-<?php echo $type['id']; ?>').show();jQuery('.lazy').trigger('appear'); tinyScroll();" class="text-dark"> <?php echo $type['name']; ?> </a> <span class="badge badge-pill count-<?php echo $type['id']; ?>" style="background:#e43546;color:#fff;">0</span> </li>
      <?php } ?>
    </ul>
    <script>
               jQuery(document).ready(function(){ 
               
               jQuery('.count-all span').html( '('+jQuery('.blocktype').length+')');
			    
			   <?php foreach($CORE->LAYOUT("get_block_types",array()) as $type){ ?>
               jQuery('.count-<?php echo $type['id']; ?>').html( jQuery('.<?php echo $type['id']; ?>').length); 
               <?php } ?>
               
               
               });
       </script>
  </div>
  <div class="col">
    <div class="card card-admin">
      <div class="card-body">
        <?php 
 
 $i=1; foreach($CORE->LAYOUT("get_block_types",array()) as $type){ 
 
 
 if(isset($_GET['pagekey']) && $_GET['pagekey'] == "home" && in_array($type['id'], array("header","footer"))){
	 continue;

}
 
 ?>
        <div id="blocklist-<?php echo $type['id']; ?>" class="blocklist"  <?php if($i != 1){ ?>style="display:none;"<?php } $i++; ?>> <a href="<?php echo home_url(); ?>/?ppt_live_preview=1&tid=<?php echo $type['id']; ?>" target="_blank" class="btn btn-system shadow-sm mt-n2 float-right btn-md "><?php echo __("Preview All","premiumpress"); ?> <i class="fa fa-search mr-0 ml-2"></i> </a>
          <h4><?php echo $type['name']; ?></h4>
          <hr />
          <?php 
	   
	   // GET DATA
		$g = $CORE->LAYOUT("load_all_by_cat", $type['id']);
			
		if(in_array($type['id'], array('text','icon','listings','header','footer','cta','contact','video','faq','hero'))){
			$order = array_column($g, 'order'); 
   			array_multisort( $order, SORT_ASC, $g);
		}
	   
	   
	   foreach($g as $tid => $g){ 
	   
	    
	   if($tid == "hero_map1" && _ppt(array('maps','enable')) != 1){
	   continue;
	   } 
	   
	   if($tid == "listingpage_openinghours" && THEME_KEY != "dt"){
	   continue;
	   } 
	   
	   if(in_array(THEME_KEY, array("da","at")) && substr($tid,0,12) == "listingpage_" && substr($tid,0,15) != "listingpage_new"){
	   
	   continue;
	   }
	   
	   
	   if(strpos(strtolower($g['name']),"test")  !== false){ continue; }
	   
	   
	   ?>
          <div class="position-relative border blocktype <?php echo $type['id']; ?> shadow-sm" style="min-height:100px;"> <a href="<?php echo home_url(); ?>/?s=&ppt_live_preview=1&tid=<?php echo $type['id']; ?>&sid=<?php echo $tid; ?>" target="_blank"> <img <?php if(!isset($_GET['smallwindow'])){ ?>data-<?php } ?>src="<?php echo $CORE->LAYOUT("get_block_prewview", $tid  ); ?>" class="img-fluid lazy w-100" /> </a> </div>
          <div class=" my-2 d-flex justify-content-between align-items-center">
            <div class="text-muted font-weight-bold text-uppercase small"> <?php echo $g['name']; ?> </div>
            <ul class="list-inline mb-0">
              <?php if(isset($_GET['smallwindow'])){ ?>
              <li class="list-inline-item"><a href="javascript:void(0);" class="btn btn-system shadow-sm btn-md" 
         onclick="setThisDesign('<?php echo $tid; ?>','<?php echo esc_attr($_GET['tid']); ?>');"><?php echo __("select design","premiumpress"); ?> <i class="fa fa-angle-double-right mr-0 ml-2"></i> </a> </li>
              <?php }else{ ?>
              <li>
                <button data-settingid="<?php echo $tid; ?>" data-pagekey="home" class="loadsettingsbox btn btn-system shadow-sm" type="button"><i class="fa fa-cog m-0"></i> <?php echo __("Settings","premiumpress"); ?></button>
              </li>
              <?php } ?>
            </ul>
          </div>
          <hr />
          <?php } ?>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>
