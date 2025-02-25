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
<form method="get" action="<?php echo home_url(); ?>" class="searchform text-left">
  <input type="hidden" name="s" value="" />
  <input type="hidden" name="type" value="1" />
   <div class="row">
   
   
   
   
  <?php switch(THEME_KEY){ 

case "ll":
case "ex":
case "cp":
case "mj":
case "cm":
case "vt":
case "dt":
case "at":
case "jb":
case "rt":
case "ct":
case "so":
case "pj":
case "sp": {    ?>
   
   
   
    	
       <div class="col-12 mb-3">   
    
    <div class="selectpicker-input-lg relative">
    <select class="selectpicker border " multiple="multiple" data-max-options="1"  data-size="5" data-none-selected-text  data-live-search="true">
         <?php
                  $count = 1;
                  $cats = get_terms( 'listing', array( 'hide_empty' => 1, 'parent' => 0  ));
                  if(!empty($cats)){
                  foreach($cats as $cat){ 
                  if($cat->parent != 0){ continue; } 
                   
                  ?>
          <option value="<?php echo $cat->term_id; ?>" <?php if(isset($_GET['tax-listing']) && $_GET['tax-listing'] == $cat->term_id){ echo "selected=selected"; } ?>> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
          <?php $count++; } } ?>
    </select>    
    
    <label style="font-size:14px;"><?php if(THEME_KEY == "ex"){ echo __("Choose a language","premiumpress"); }else{ echo __("Category","premiumpress"); } ?></label>
    </div>
    <script>
	jQuery(document).ready(function(){ 
	jQuery('select.selectpicker').on('change', function(){
	jQuery(".selectpicker-input-lg label").hide();
  
	});
});
</script> 
        
      </div>
      
      
        <?php if(in_array(THEME_KEY, array("vt","ll"))){ ?>
        <div class="col-12 mb-3"> 
      
        <?php 
		$foundcats 	= get_terms( "level", array( 'hide_empty' => 0  ));
	
			 ?>
        <select class="form-control form-control-custom" name="tax-level">
          <option value=""><?php echo __("All Types","premiumpress"); ?></option>
          <?php if(is_array($foundcats) && !empty($foundcats)){
		foreach($foundcats as $cat){ ?>
          <option value="<?php echo $cat->term_id; ?>"><?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
          <?php
			 
		}
	}	?>
        </select>
        </div>
        <?php } ?>
      
      
      
  <?php } break; 

 case "es":
  case "da": {   
  
   ?>
  
  
   <div class="col-12">
  <div class="row">
  <div class="col-12 col-md-6">
  
  
    <?php if(THEME_KEY == "es"){ ?>
  
    <select name="tax-dathnicity" class="form-control mb-4 mb-md-0 rounded-0"  data-live-search="true">
      <option value=""><?php echo __("Any Ethnicity","premiumpress"); ?></option>
      <?php
$count = 1;
$cats = get_terms( 'dathnicity', array( 'hide_empty' => 0, 'parent' => 0  ));
if(!empty($cats)){
foreach($cats as $cat){ 
if($cat->parent != 0){ continue; } 
 
?>
      <option value="<?php echo $cat->term_id; ?>"> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
      <?php $count++; } } ?>
    </select>
  
  
  <?php }else{ ?>
  
  
    <select name="tax-dagender" class="form-control mb-4 mb-md-0 rounded-0"  data-live-search="true">
      <option value=""><?php echo __("Any Gender","premiumpress"); ?></option>
      <?php
$count = 1;
$cats = get_terms( 'dagender', array( 'hide_empty' => 0, 'parent' => 0  ));
if(!empty($cats)){
foreach($cats as $cat){ 
if($cat->parent != 0){ continue; } 
 
?>
      <option value="<?php echo $cat->term_id; ?>"> <?php echo $CORE->GEO("translation_tax", array($cat->term_id, $cat->name)); ?></option>
      <?php $count++; } } ?>
    </select>
    
    <?php } ?>
    
  </div>
  <div class="col-12 col-md-6">
    <select name="age" class="form-control mb-4 mb-md-0 rounded-0"  data-live-search="true">
      <option value=""><?php echo __("Any Age","premiumpress"); ?></option>
      <option value="20">20+</option>
      <option value="30">30+</option>
      <option value="40">40+</option>
      <option value="50">50+</option>
    </select>
  </div>
  
  <?php if(_ppt(array('maps','enable')) == 1){ ?>
  <div class="col-12 mt-4">
    <div class="form-input position-relative">
      <input name="zipcode" class="form-control" style="height:55px; font-size:18px;" placeholder="<?php echo __("Location","premiumpress"); ?>" />
      <span  style="top: 21px; right: 10px; position: absolute;    z-index: 100;color:#000;"><span class="fal fa-map-marker"></span></span> </div>
  </div>
  <?php } ?>
  
  
  </div>  
  

    
      
  </div>       
      
      
      
 <?php } break; default: { } break;  }  ?> 
      
      
      
      
<?php /*
      
       <div class="col-6"> 
       
       <?php if(THEME_KEY == "ex"){
	   
	   $prices = array(
		   "1" => "A Paid Teacher", 
		   "2" => "A Free Tutor"
	   ); 
	   ?>
       
       <select class="form-control form-control-custom" name="seek1">
          <option value="0"><?php echo __("Looking For","premiumpress"); ?></option>
          
          <?php foreach( $prices as $pk => $pr){ ?>
          <option value="<?php echo $pk; ?>"><?php echo $pr; ?></option>
          <?php } ?>
        </select>   
        
     
        <?php 
		}else{
		
			if(THEME_KEY == "rt"){
			$prices = array("10000","20000","50000","70000","100000","200000","300000","400000","500000","1000000"  ); 
			
			}elseif(THEME_KEY == "mj"){
			$prices = array("5","10","15","20",  "25", "30","40","50","75","100","150","200","250","300","500"); 
			
			}else{
			$prices = array("100","200","500","700","1000","2000","3000","4000","5000" ); 
			}
		
		
		 ?>
        <select class="form-control form-control-custom" name="price1">
          <option value="0"><?php echo __("Min Price","premiumpress"); ?></option>
          <option value="0"><?php echo hook_price(0); ?></option>
          <?php foreach( $prices as $price){ ?>
          <option value="<?php echo $price; ?>"><?php echo hook_price($price); ?></option>
          <?php } ?>
        </select>   
        
        
        
        <?php } ?>
        
        
        
        
        
        
       
       </div>
       <div class="col-6">  
       
         <?php 
		 
		 if(THEME_KEY == "ex"){
	   
	   $prices = array(
		   "100" => "Beginner", 
		   "200" => "Intermedate"
	   ); 
	   ?>
       
       <select class="form-control form-control-custom" name="price1">
          <option value="0"><?php echo __("My Level","premiumpress"); ?></option>
           
          <?php foreach( $prices as $pk => $pr){ ?>
          <option value="<?php echo $pk; ?>"><?php echo $pr; ?></option>
          <?php } ?>
        </select>  
        
        <?php }else{
		
		
			if(THEME_KEY == "rt"){
			$prices = array("10000","20000","50000","70000","100000","200000","300000","400000","500000","1000000"  ); 
			
			}elseif(THEME_KEY == "mj"){
			$prices = array("5","10","15","20",  "25", "30","40","50","75","100","150","200","250","300","500"); 
			
			}else{
			$prices = array("100","200","500","700","1000","2000","3000","4000","5000" ); 
			}
		
		
		 ?>
        <select class="form-control form-control-custom" name="price2">
          <option value=""><?php echo __("Max Price","premiumpress"); ?></option>
          <?php foreach( $prices as $price){ ?>
          <option value="<?php echo $price; ?>"><?php echo hook_price($price); ?></option>
          <?php } ?>
        </select>   
       
       
       <?php } ?>
       
       </div>
       
	   
	   */ ?>
      
      
    
    
    
    <div class="col-12">
      <button class="btn-block btn btn-primary py-3 mt-3" type="submit"> <?php echo __("Search","premiumpress"); ?></button>
    </div>
    
    </div>
  </div> 
  
</form>
