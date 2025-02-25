<?php

global $settings, $CORE;


// CHECK FOR ELEENTOR DESIGN
$hasSetDesign = _ppt(array('pageassign','listingpage'));

 

  $settings = array(
  "title" => __("Choose Design","premiumpress"), 
  "desc" =>  str_replace("%s", $CORE->LAYOUT("captions","1"), __("Select the %s page design.","premiumpress") ),
  //"video" => "https://www.youtube.com/watch?v=y8wH_LyLbeM",
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?> 
        
		<div class="card card-admin"><div class="card-body">

<div class="row">
      
        <?php
		
		$snames = array(
		
			1 => array(
				"name" => "Default Design", 
				"img" => DEMO_IMG_PATH."newsingle/".THEME_KEY.".jpg",
				"key" => "1",
			),
			
			2 => array(
				"name" => "Coming Soon", 
				"img" => DEMO_IMG_PATH."newsingle/soon.jpg",
				"key" => "soon",
			),	
			
			3 => array(
				"name" => "Coming Soon", 
				"img" => DEMO_IMG_PATH."newsingle/soon.jpg",
				"key" => "soon",
			),			
			 
		);
		
		 
		
		if(in_array(THEME_KEY, array("cm","sp","at","dl","ct","dt","da","rt","mj","es","vt","jb"))){				
			
			$snames[2] = array(			
			 
				"name" => "Design 2", 
				"img" => DEMO_IMG_PATH."newsingle/".THEME_KEY."_2.jpg",
				"key" => "global_design2",				 
			);
			
			$snames[3] = array(			
			 
				"name" => "Design 3", 
				"img" => DEMO_IMG_PATH."newsingle/".THEME_KEY."_3.jpg",
				"key" => "global_design3",				 
			);
		
		
		}
		
		
	 
		 
         
		
		$SetThis = _ppt(array('design','single_layout'));		
		foreach($snames as $i => $n){ ?>
        
  <div class="col-6 col-md-4">
   <div class="card-top-image mb-5 shadow-sm bg-light position-relative" style="height:200px; overflow:hidden;<?php if($SetThis == "" && $n['key'] == 1 || $SetThis == $n['key']){ ?>border:2px solid red;<?php } ?> <?php if(strlen($hasSetDesign) > 2){?>opacity:0.5<?php } ?>">
   
   <img src="<?php echo $n['img']; ?>" class="img-fluid" />
   <div class="text-center bg-dark text-light py-2 position-absolute w-100" style="bottom:0px;"><?php echo $n['name']; ?></div>
   
   </div>
   </div>
   
   <?php $i++; } ?>
   
     </div>  
   
   <?php if(strlen($hasSetDesign) > 2){?>
   
   <div class="alert alert-warning p-4">
   <i class="fa fa-exclamation-triangle"></i> <?php echo str_replace("%s", strtolower($CORE->LAYOUT("captions","1")), __("You have set an Elementor page design for the %s page under Edit Pages tab. Custom page options here will no longer be applied.","premiumpress")); ?>
   </div>
   
   <?php }else{ ?>
    <div class="col-12">
    <div class="row">
    <div class="col-3">
    <label><?php echo __("Selected Design","premiumpress"); ?></label>
    </div>
    <div class="col-6">
    <select name="admin_values[design][single_layout]" class="form-control">
    <?php foreach($snames as $i => $n){ if($n['key'] == "soon"){ continue; } ?>
    <option value="<?php echo $n['key']; ?>" <?php if( $SetThis == $n['key']){ echo "selected=selected"; }  ?>> <?php echo $n['name']; ?> </option>
    <?php  $i++; } ?>
    </select>
    </div>    
    </div> 
  	</div>
    <?php } ?>
    
     
    

<div class="p-4 bg-light text-center mt-4"<?php if(strlen($hasSetDesign) > 2){?>style="display:none;"<?php } ?>>
         <button type="submit" class="btn btn-admin"> <?php echo __("Save Settings","premiumpress"); ?></button>
    	</div>


      
        </div></div>
      
<?php _ppt_template('framework/admin/_form-wrap-bottom' );  ?>



















<?php

global $settings, $CORE;

 
$langs = _ppt('languages');


// DEFAULTS
$showGallery = 0;
$showGridGallery = 0;
$showCarouselGallery = 0;
$showTextOnly = 0; 

if(in_array(THEME_KEY, array("es","rt")) && _ppt(array('design','single_top')) == "" ){
$showGallery = 1; 
}

if(in_array(THEME_KEY, array("dl")) && _ppt(array('design','single_top')) == "" ){
$showCarouselGallery = 1; 
}
 
if(in_array(THEME_KEY, array("cp")) && _ppt(array('design','single_top')) == "" ){
$showTextOnly = 1; 
}

 
?>

<div class="container px-0" <?php if(!in_array(_ppt(array('design','single_layout')), array("","1")) ||  in_array(_ppt(array('design','single_layout')), array("global_design2","global_design3")) ){ ?>style="display:none"<?php } ?>>
  <div class="row">
    <div class="col-md-4 pr-lg-4">
      <h3 class="mt-4"><?php echo __("Default Design","premiumpress"); ?></h3>
      <p class="text-muted lead mb-4"><?php echo __("The listing page is divided into blocks. Here you can choose the content/design of those blocks.","premiumpress"); ?></p>
      
      
      
      <div class="mt-4 border p-3">
      
      
      <div class="row ">
      <div class="col-12 mb-3">
     <div class="bg-light py-3 small text-uppercase font-weight-bold text-center"> Top section</div>
      </div>
       <div class="col-6 mb-3">
     <div class="bg-light py-3 small text-uppercase font-weight-bold text-center"> Middle Left</div>
      </div>
            <div class="col-6 bg mb-3">
     <div class="bg-light py-3 small text-uppercase font-weight-bold text-center"> Middle Right</div>
      </div>
           <?php if(defined('THEME_KEY') && !in_array(THEME_KEY, array("sp","cp","vt"))){ ?>
          <div class="col-6 mb-3">
       <div class="bg-light py-3 small text-uppercase font-weight-bold text-center"> Bottom Left</div>
      </div>
            <div class="col-6 bg mb-3">
       <div class="bg-light py-3 small text-uppercase font-weight-bold text-center"> Bottom Right</div>
      </div>   
      <?php } ?>
      
      </div>
      
      
      
      </div>
      
      
      
      
      
    </div>
    <div class="col-md-8">

<div class="card card-admin" id="carousel-langs" >
  <div class="card-body">
    <div class="row">
    
    <?php if(THEME_KEY != "ph"){ ?>
      <div class="col-12 mb-4">
        <div class="row">
          <div class="col-4">
            <label><?php echo __("Top Section","premiumpress"); ?> <br /> <div class="tiny opacity-5"><?php echo __("Main Header","premiumpress"); ?></div> </label>
            
          </div>
          <div class="col-6">
           
            <select name="admin_values[design][single_top]" class="form-control">
              <option value="" <?php if(_ppt(array('design','single_top')) == "" && !$showGallery){ echo "selected=selected"; }  ?>> <?php echo __("Default","premiumpress"); ?> </option>
              
              <option value="text" <?php if(_ppt(array('design','single_top')) == "text"){ echo "selected=selected"; }  ?>> <?php echo __("Text + Background Image","premiumpress"); ?> </option>
             
               <option value="text-big" <?php if(_ppt(array('design','single_top')) == "text-big"){ echo "selected=selected"; }  ?>> <?php echo __("Text + Big Image + Background Image","premiumpress"); ?> </option>
             
              <option value="textonly" <?php if(_ppt(array('design','single_top')) == "textonly" || $showTextOnly){ echo "selected=selected"; }  ?>> <?php echo __("Text Only","premiumpress"); ?> </option>
             
               <option value="text-split" <?php if(_ppt(array('design','single_top')) == "text-split"){ echo "selected=selected"; }  ?>> <?php echo __("Big Image + Text","premiumpress"); ?> </option>
             
             
              <option value="gallery" <?php if(_ppt(array('design','single_top')) == "gallery" || $showGallery){ echo "selected=selected"; }  ?>> <?php echo __("Gallery - Slider","premiumpress"); ?> </option>
              
              
               <option value="gallery-grid" <?php if(_ppt(array('design','single_top')) == "gallery-grid" || $showGridGallery){ echo "selected=selected"; }  ?>> <?php echo __("Gallery - Grid","premiumpress"); ?> </option>
             
               <option value="gallery-carousel" <?php if(_ppt(array('design','single_top')) == "gallery-carousel" || $showCarouselGallery){ echo "selected=selected"; }  ?>> <?php echo __("Gallery - Carousel","premiumpress"); ?> </option>
             
              
              <option value="video" <?php if(_ppt(array('design','single_top')) == "video"){ echo "selected=selected"; }  ?>> <?php echo __("Video Box","premiumpress"); ?> </option>
              
              
              
               <option value="hide" <?php if(_ppt(array('design','single_top')) == "hide"){ echo "selected=selected"; }  ?>> <?php echo __("Hide Block","premiumpress"); ?> </option>
            </select>
            
             <?php if(_ppt(array('design','single_top')) == "gallery" || $showGallery){ ?>
             
             <label class="mt-4">Max Images</label>
             
             <input class="form-control" name="admin_values[design][gallery_num]" value="<?php 
			 if(is_numeric( _ppt(array('design','gallery_num'))) ){ echo _ppt(array('design','gallery_num')); }else{ echo 3; } ?>" />
               
             <div class="tiny bg-light p-3 mt-2">By default there are 3 images displayed, if the user wants to view more they need to click the "more photos" button which is linked to the login/register/membership system and helps covert visitors into members.</div>
             
             
             <?php } ?>
            
            
            
          </div>
        </div>  
      </div>
      <?php } ?>
      <!-- /************************************ */ -->
      
 
      <div class="col-12 mb-4">
        <div class="row">
          <div class="col-4">
            <label><?php echo __("Middle Left","premiumpress"); ?> <br /> <div class="tiny opacity-5"><?php echo __("Photos Section","premiumpress"); ?></div> </label>
          </div>
          <div class="col-6"> 
            <select name="admin_values[design][single_ml]" class="form-control">
              <option value="" <?php if(_ppt(array('design','single_ml')) == ""){ echo "selected=selected"; }  ?>> <?php echo __("Default","premiumpress"); ?> </option>
              
              
              <option value="author" <?php if(_ppt(array('design','single_ml')) == "author"){ echo "selected=selected"; }  ?>> <?php echo __("Author Box","premiumpress"); ?> </option>
              
              
              <?php if(in_array(THEME_KEY, array("mj","ct","dl","sp","vt","so","cp","ph","at")) ){  ?>
              <option value="rating" <?php if(_ppt(array('design','single_ml')) == "rating"){ echo "selected=selected"; }  ?>> <?php echo __("User Rating Box","premiumpress"); ?> </option>
             <?php } ?>
             
             
             <?php if( $CORE->LAYOUT("captions","maps") && _ppt(array('maps','enable')) == 1 && strlen(_ppt(array('maps','apikey'))) > 2 ){ ?>
                <option value="map" <?php if(_ppt(array('design','single_ml')) == "map"){ echo "selected=selected"; }  ?>> <?php echo __("Map Box","premiumpress"); ?> </option>
             <?php } ?>
             
             
               <option value="video" <?php if(_ppt(array('design','single_ml')) == "video"){ echo "selected=selected"; }  ?>> <?php echo __("Video Box","premiumpress"); ?> </option>
              
              
              <option value="hide" <?php if(_ppt(array('design','single_ml')) == "hide"){ echo "selected=selected"; }  ?>> <?php echo __("Hide Block","premiumpress"); ?> </option>
            </select>
          </div>
        </div>  
      </div>
      
      <!-- /************************************ */ -->
      
      
      <div class="col-12 mb-4">
        <div class="row">
          <div class="col-4">
            <label><?php echo __("Middle Right","premiumpress"); ?> <br /> <div class="tiny opacity-5"><?php echo __("Video/Map/Rating Section","premiumpress"); ?></div></label>
          </div>
          <div class="col-6"> 
            <select name="admin_values[design][single_mr]" class="form-control">
              <option value="" <?php if(_ppt(array('design','single_mr')) == ""){ echo "selected=selected"; }  ?>> <?php echo __("Default","premiumpress"); ?> </option>
               
               
                   <option value="author" <?php if(_ppt(array('design','single_mr')) == "author"){ echo "selected=selected"; }  ?>> <?php echo __("Author Box","premiumpress"); ?> </option>
               
                 <?php if(in_array(THEME_KEY, array("mj","ct","dl","sp","vt","so","cp","ph","at")) ){  ?>
              <option value="rating" <?php if(_ppt(array('design','single_mr')) == "rating"){ echo "selected=selected"; }  ?>> <?php echo __("User Rating Box","premiumpress"); ?> </option>
             <?php } ?>
             
             <?php if( $CORE->LAYOUT("captions","maps") && _ppt(array('maps','enable')) == 1 && strlen(_ppt(array('maps','apikey'))) > 2 ){ ?>
                <option value="map" <?php if(_ppt(array('design','single_mr')) == "map"){ echo "selected=selected"; }  ?>> <?php echo __("Map Box","premiumpress"); ?> </option>
             <?php } ?>
             
               <option value="video" <?php if(_ppt(array('design','single_mr')) == "video"){ echo "selected=selected"; }  ?>> <?php echo __("Video Box","premiumpress"); ?> </option>
               
               
               <option value="hide" <?php if(_ppt(array('design','single_mr')) == "hide"){ echo "selected=selected"; }  ?>> <?php echo __("Hide Block","premiumpress"); ?> </option>
            </select>
          </div>
        </div>  
      </div>
      
      <!-- /************************************ */ -->
      
      <?php if(defined('THEME_KEY') && !in_array(THEME_KEY, array("sp","cp","vt","ll"))){ ?>
      
      <div class="col-12 mb-4">
        <div class="row">
          <div class="col-4">
            <label><?php echo __("Bottom Left","premiumpress"); ?> <br /> <div class="tiny opacity-5"><?php echo __("Details Section","premiumpress"); ?></div> </label>
          </div>
          <div class="col-6"> 
          
          
            <select name="admin_values[design][single_bl]" class="form-control">
              <option value="" <?php if(_ppt(array('design','single_bl')) == ""){ echo "selected=selected"; }  ?>> <?php echo __("Default","premiumpress"); ?> </option>
             <option value="hide" <?php if(_ppt(array('design','single_bl')) == "hide"){ echo "selected=selected"; }  ?>> <?php echo __("Hide Block","premiumpress"); ?> </option>
            </select>
            
            
             
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mt-3">
      <div class="row py-2">
        <div class="col-md-8">
          <label><?php echo __("Video Box","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Show user added video.","premiumpress"); ?></p>
        </div>
        <div class="col-md-4">
          <div class="mt-1">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_details_video').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_details_video').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_details_video')), array("","1"))){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_details_video" name="admin_values[design][display_details_video]" value="<?php if(in_array(_ppt(array('design', 'display_details_video')), array("","1"))){  echo 1; }else{ echo 0; } ?>">
        </div>
      </div>
    </div>
            
            
            
            
            
            
          </div>
        </div>  
      </div>
      
      <!-- /************************************ */ -->
      
      
      
        <div class="col-12 mb-4">
        <div class="row">
          <div class="col-4">
            <label><?php echo __("Bottom Right","premiumpress"); ?> <br /> <div class="tiny opacity-5"><?php echo __("Features Section","premiumpress"); ?></div> </label>
          </div>
          <div class="col-6"> 
            <select name="admin_values[design][single_br]" class="form-control">
              <option value="" <?php if(_ppt(array('design','single_br')) == ""){ echo "selected=selected"; }  ?>> <?php echo __("Default","premiumpress"); ?> </option>
               <option value="hide" <?php if(_ppt(array('design','single_br')) == "hide"){ echo "selected=selected"; }  ?>> <?php echo __("Hide Block","premiumpress"); ?> </option>
            </select>
          </div>
        </div>  
      </div>
      
      <!-- /************************************ */ -->
      
  <?php } ?>
   
    
    <div class="col-12">
    <div class="p-4 bg-light text-center mt-4">
          <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
        </div>
    </div>
    

     </div>
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' );  ?>
<?php

 

  $settings = array(
  
  "title" => __("Page Settings","premiumpress"), 
  "desc" => __("Here you can turn on/off default display options.","premiumpress"),
  
  );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
<div class="card card-admin">
  <div class="card-body">
  
  
  
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Comments &amp; Reviews","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the display of commnets &amp; reviews.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_comments').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_comments').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_comments')), array("","1"))){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_comments" name="admin_values[design][display_comments]" value="<?php if(in_array(_ppt(array('design', 'display_comments')), array("","1"))){  echo 1; }else{ echo 0; } ?>">
        </div>
      </div>
    </div>
  
  
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Login To View Page?","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Force users to login before they can view listing pages.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-4 formrow">
            <label class="radio off">
            <input type="radio" name="toggle" 
                        value="off" onchange="document.getElementById('requirelogin_listings').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
                        value="on" onchange="document.getElementById('requirelogin_listings').value='1'">
            </label>
            <div class="toggle <?php if(_ppt(array('design', 'requirelogin_listings' )) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="requirelogin_listings" name="admin_values[design][requirelogin_listings]" value="<?php echo _ppt(array('design', 'requirelogin_listings' )); ?>">
        </div>
      </div>
    </div> 
  
  
      <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Recommended Listings","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the display of recommended listings.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_related').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_related').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_related')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_related" name="admin_values[design][display_related]" value="<?php if(in_array(_ppt(array('design', 'display_related')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
        </div>
      </div>
    </div>
    
  
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Login To Access","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off to require users to login before viewing.","premiumpress"); ?></p>
        </div>
        <div class="col-md-2">
        
        <label><?php echo __("Photos","premiumpress"); ?></label>
          <div class="mt-2">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_photologin').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_photologin').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_photologin')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_photologin" name="admin_values[design][display_photologin]" value="<?php if(in_array(_ppt(array('design', 'display_photologin')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
       
       
       
         <label class="mt-3"><?php echo __("Comments","premiumpress"); ?></label>
          <div class="mt-2 mb-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_commentslogin').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_commentslogin').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_commentslogin')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_commentslogin" name="admin_values[design][display_commentslogin]" value="<?php if(in_array(_ppt(array('design', 'display_commentslogin')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
       
       
       
        </div>
         <div class="col-md-2">
        
        <label><?php echo __("Videos","premiumpress"); ?></label>
          <div class="mt-2">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_videologin').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_videologin').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_videologin')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_videologin" name="admin_values[design][display_videologin]" value="<?php if(in_array(_ppt(array('design', 'display_videologin')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
       
       
       
        </div> 
        
        
        
      </div>
    </div>  
    
    
     <?php if(defined('THEME_KEY') && in_array(THEME_KEY, array("at","ct"))){ ?>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Delivery","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off to delivery box.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_delivery').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_delivery').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_delivery')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_delivery" name="admin_values[design][display_delivery]" value="<?php if(in_array(_ppt(array('design', 'display_delivery')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
        </div>
      </div>
    </div>  
   <?php } ?>   
   
   
     <?php if(defined('THEME_KEY') && in_array(THEME_KEY, array("at"))){ ?>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Reserve Price","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off to reserve price box.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_reserve').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_reserve').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_reserve')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_reserve" name="admin_values[design][display_reserve]" value="<?php if(in_array(_ppt(array('design', 'display_reserve')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
        </div>
      </div>
    </div>  
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Shipping","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off shipping options.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_shipping').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_shipping').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_shipping')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_shipping" name="admin_values[design][display_shipping]" value="<?php if(in_array(_ppt(array('design', 'display_shipping')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
        </div>
      </div>
    </div>  
   <?php } ?>   
    
    
    <?php if(defined('THEME_KEY') && in_array(THEME_KEY, array("es"))){ ?>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("My Rates","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off to user rates system.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_rates').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_rates').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_rates')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_rates" name="admin_values[design][display_rates]" value="<?php if(in_array(_ppt(array('design', 'display_rates')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
        </div>
      </div>
    </div>  
   <?php } ?>
   
   
   
    <?php if(defined('THEME_KEY') && in_array(THEME_KEY, array("jb"))){ 
	
		$title = __("Default Fields (Job ID, Salary etc)","premiumpress");
	?>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo $title; ?></label>
          <p class="text-muted"><?php echo __("Turn on/off to default fields display.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_core_fields').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_core_fields').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_core_fields')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_core_fields" name="admin_values[design][display_core_fields]" value="<?php if(in_array(_ppt(array('design', 'display_core_fields')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
        </div>
      </div>
    </div>  
   <?php } ?>
   
   
   
    
    <?php if(defined('THEME_KEY') && !in_array(THEME_KEY, array("sp","cp","vt","jb"))){ 
	
		$title = "";
		switch(THEME_KEY){
		
		
			case "es": {
			$title = __("Services","premiumpress");
			} break;
		
			case "da": {
			$title = __("My Interests","premiumpress");
			} break;
		
			case "mj": {
			$title = __("Why Choose Me","premiumpress");
			} break;	
			 
			
			default: {	
			$title = __("Features","premiumpress");
			} break;
		} 
		
	?>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo $title." ".__("Section","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off to features section.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_features').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_features').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_features')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_features" name="admin_values[design][display_features]" value="<?php if(in_array(_ppt(array('design', 'display_features')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
        </div>
      </div>
    </div>  
   <?php } ?>
  

    
    <?php if(in_array(THEME_KEY, array("ph","dl","dt")) ){  ?>
    
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Subtitle Stats Bar","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the bar under the main heading.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
        
        
            <label><?php echo __("Show Bar","premiumpress"); ?></label>
          
          <div class="mt-3">
          
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_subbar').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_subbar').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_subbar')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_subbar" name="admin_values[design][display_subbar]" value="<?php if(in_array(_ppt(array('design', 'display_subbar')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
          
          
          <?php /*
          
          <label class="mt-3"><?php echo __("Show Thumbs Up/Down","premiumpress"); ?></label>
          
            <div class="mt-2">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_subbar_thumbs').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_subbar_thumbs').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_subbar_thumbs')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_subbar_thumbs" name="admin_values[design][display_subbar_thumbs]" value="<?php if(in_array(_ppt(array('design', 'display_subbar_thumbs')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
      
          
          */ ?>
          
          
          
        </div>
      </div>
    </div>
    
    <?php } ?>
    
    
    <?php if( in_array(THEME_KEY, array("vt","cm")) || $CORE->LAYOUT("captions","offers") == ""){ }else{  if(THEME_KEY == "mj"){ }else{ ?>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo $CORE->LAYOUT("captions","offerbtn")." ".__("Button","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the display of the offers box.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_offers').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_offers').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_offers')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_offers" name="admin_values[design][display_offers]" value="<?php if(in_array(_ppt(array('design', 'display_offers')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
        </div>
      </div>
    </div>
    <?php } } ?>
    
    
    
    
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Social Sharing (addthis.com)","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off social media sharing options.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
        
         <label><?php echo __("Show Sharing Box","premiumpress"); ?></label>
         
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_addthis').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_addthis').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_addthis')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_addthis" name="admin_values[design][display_addthis]" value="<?php if(in_array(_ppt(array('design', 'display_addthis')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
          
           <label class="mt-3"><?php echo __("Addthis.com Username","premiumpress"); ?></label>
        
        
        <input class="form-control" name="admin_values[design][display_addthis_username]" value="<?php echo _ppt(array('design', 'display_addthis_username' )); ?>" />
          
          
        </div>
      </div>
    </div>
    
    
    
    
    <?php if( in_array(THEME_KEY, array("dt")) ){ ?>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Claim Listing Button","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the display of the claim listing option.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_claim').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_claim').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'display_claim')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_claim" name="admin_values[design][display_claim]" value="<?php if(in_array(_ppt(array('design', 'display_claim')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
        </div>
      </div>
    </div>
    <?php } ?>
    
    
    <?php if(in_array(THEME_KEY, array("dt","es") )){ ?>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
        <?php if(THEME_KEY == "es"){ ?>
        <label><?php echo __("Meeting Hours","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the display of user meeting hours.","premiumpress"); ?></p>
          
          
        <?php }else{ ?>
          <label><?php echo __("Opening Hours","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the display of business opening hours.","premiumpress"); ?></p>
          
          <?php } ?>
        </div>
        <div class="col-md-5">
          <div class="">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_openinghours').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_openinghours').value='1'">
            </label>
            <div class="toggle <?php if( in_array(_ppt(array('design', "display_openinghours")), array("","1")) ){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_openinghours" name="admin_values[design][display_openinghours]" value="<?php if(in_array(_ppt(array('design', "display_openinghours")), array("","1")) ){ echo 1; }else{ echo 0; } ?>">
          
          <label class="mt-3"><?php echo __("12 Hour Display","premiumpress"); ?></label>
          
            <div class="mt-2">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('element_open12').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('element_open12').value='1'">
            </label>
            <div class="toggle <?php if(in_array(_ppt(array('design', 'element_open12')), array("","1"))){ ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="element_open12" name="admin_values[design][element_open12]" value="<?php if(in_array(_ppt(array('design', 'element_open12')), array("","1"))){  echo 1; }else{ echo 0; }  ?>">
        </div>
          
       
      </div>
    </div>
    
    
 
    
    
    <?php } ?>
    <?php if(THEME_KEY == "mj"){ ?>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Make Offer","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the make offer option.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_offerbtn').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_offerbtn').value='1'">
            </label>
            <div class="toggle <?php if( in_array(_ppt(array('design', 'display_offerbtn')), array("", "1")) ){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_offerbtn" name="admin_values[design][display_offerbtn]" value="<?php if(_ppt(array('design', 'display_offerbtn')) == ""){ echo 1; }else{ echo _ppt(array('design', 'display_offerbtn')); } ?>">
        </div>
      </div>
    </div>
    <?php } ?>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3" <?php if(in_array(_ppt(array('design','single_top')), array("","text","text-big")) ){ }else{ echo "style='display:none'"; }  ?>>
      <div class="row py-2">
        <div class="col-md-12">
          <label><?php echo __("Background Images","premiumpress"); ?> (1150px / 300px)</label>
          <p class="text-muted"><?php echo __("Here you can set your own background images for users to choose from when editing their listing.","premiumpress"); ?></p>
        </div>
        <div class="container">
          <div class="row">
            <?php

$lst_backgrounds = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14);


foreach($lst_backgrounds as $k ){

	$defaultimg = DEMO_IMG_PATH."backgroundimages/".$k.".jpg";
 
?>
            <div class="col-md-6 text-center p-2">
              <figure>
                <div class="position-relative"> <img src="<?php if(_ppt(array('bgimg', $k)) == ""){ echo $defaultimg; }else{ echo _ppt(array('bgimg', $k )); } ?>" alt="img" class="img-fluid"> </div>
              </figure>
              <div class="input-group position-relative">
                <button type="button"  id="path<?php echo $k; ?>" class="position-absolute download_path_select" style="right:10px; top:10px; z-index: 1; font-size: 11px; background:none !important;"><?php echo __("Select File","premiumpress"); ?></button>
                <input class="form-control" id="download_path<?php echo $k; ?>" name="admin_values[bgimg][<?php echo $k; ?>]" value="<?php if(_ppt(array('bgimg', $k)) == ""){ }else{ echo _ppt(array('bgimg', $k )); } ?>" />
              </div>
            </div>
            <?php } ?>
            <input type="hidden" value=""  id="current_bg_id" />
            <script>

jQuery(document).ready(function() {

var my_original_editor = window.send_to_editor;


 	jQuery('.download_path_select').click(function() {     
	
	var thisid = jQuery(this).attr('id');   
	
	jQuery("#current_bg_id").val(thisid);  
           
		   tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		   
			window.send_to_editor = function(html) {	
			 
			 		
				var regex = /src="(.+?)"/;
				var rslt =html.match(regex);
				 
				var imgrex = /wp-image-(.+?)"/;
				var imgid = html.match(imgrex);
			 
				var imgurl = rslt[1];
				var imgaid = imgid[1];
				console.log("#download_"+jQuery("#current_bg_id").val());
				jQuery("#download_"+jQuery("#current_bg_id").val()).val(imgurl); 
				
				tb_remove();
				
				window.send_to_editor = my_original_editor;
			 
			 
			}		   
		   
		   
           return false;
    });
               		
 

}); 
</script>
          </div>
        </div>
      </div>
    </div>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3" <?php if(!in_array(_ppt(array('design','single_layout')), array("","1")) ){ ?>style="display:none"<?php } ?>>
      <div class="row py-2">
        <?php $defaultimg = DEMO_IMG_PATH."backgroundimages/users.jpg"; ?>
        <div class="col-md-6 p-2">
          <label><?php echo __("User Rating Background","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Set the background image for the user rating box.","premiumpress"); ?></p>
          <figure>
            <div class="position-relative"> <img src="<?php if(_ppt(array('bgimg', 'users')) == ""){ echo $defaultimg; }else{ echo _ppt(array('bgimg', 'users' )); } ?>" alt="img" class="img-fluid"> </div>
          </figure>
          <div class="input-group position-relative">
            <button type="button"  id="path55" class="position-absolute download_path_select" style="right:10px; top:10px; z-index: 1; font-size: 11px; background:none !important;"><?php echo __("Select File","premiumpress"); ?></button>
            <input class="form-control" id="download_path55" name="admin_values[bgimg][users]" value="<?php if(_ppt(array('bgimg', 'users')) == ""){ }else{ echo _ppt(array('bgimg', 'users' )); } ?>" />
          </div>
        </div>
        <div class="col-md-6 p-2">
          <label><?php echo __("User Photos Background","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Set the background image for the photos box.","premiumpress"); ?></p>
          <?php $defaultimg = DEMO_IMG_PATH."backgroundimages/photos.jpg"; ?>
          <figure>
            <div class="position-relative"> <img src="<?php if(_ppt(array('bgimg', 'photos')) == ""){ echo $defaultimg; }else{ echo _ppt(array('bgimg', 'photos' )); } ?>" alt="img" class="img-fluid"> </div>
          </figure>
          <div class="input-group position-relative">
            <button type="button"  id="path77" class="position-absolute download_path_select" style="right:10px; top:10px; z-index: 1; font-size: 11px; background:none !important;"><?php echo __("Select File","premiumpress"); ?></button>
            <input class="form-control" id="download_path77" name="admin_values[bgimg][photos]" value="<?php if(_ppt(array('bgimg', 'photos')) == ""){ }else{ echo _ppt(array('bgimg', 'photos' )); } ?>" />
          </div>
        </div>
      </div>
    </div>
    <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>
<?php _ppt_template('framework/admin/_form-wrap-bottom' );  ?>


















<?php if(THEME_KEY == "da"){ ?>
<?php
 
  $settings = array("title" => __("Gift Images","premiumpress"), "desc" => __("Here you can change the gift icon images.","premiumpress") );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
<div class="card card-admin">
  <div class="card-body">
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-7">
          <label><?php echo __("Send Gifts","premiumpress"); ?></label>
          <p class="text-muted"><?php echo __("Turn on/off the option for users to send gifts.","premiumpress"); ?></p>
        </div>
        <div class="col-md-5">
          <div class="mt-3">
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('display_gifts').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('display_gifts').value='1'">
            </label>
            <div class="toggle <?php if( in_array(_ppt(array('design', 'display_gifts')), array("", "1")) ){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="display_gifts" name="admin_values[design][display_gifts]" value="<?php if(_ppt(array('design', 'display_gifts')) == ""){ echo 1; }else{ echo _ppt(array('design', 'display_gifts')); } ?>">
        </div>
      </div>
    </div>
    <!-- ------------------------- -->
    <div class="container px-0 border-bottom mb-3">
      <div class="row py-2">
        <div class="col-md-12">
          <label><?php echo __("Images","premiumpress"); ?> (150x150)</label>
          <p class="text-muted"><?php echo __("Here you can set your own gift images.","premiumpress"); ?></p>
        </div>
        <div class="container">
          <div class="row">
            <?php

$lst_backgrounds = array(1,2,3,4,5,6,7,8,9);


foreach($lst_backgrounds as $k ){

	$defaultimg = get_template_directory_uri()."/_dating/icons/".$k.".png";
 
?>
            <div class="col-md-6 text-center p-2">
              <figure>
                <div class="position-relative"> <img src="<?php if(_ppt(array('bgimg', "gift".$k)) == ""){ echo $defaultimg; }else{ echo _ppt(array('bgimg', "gift".$k )); } ?>" alt="img" class="img-fluid"> </div>
              </figure>
              <div class="input-group position-relative">
                <button type="button"  id="path<?php echo $k; ?>9" class="position-absolute download_path_select" style="right:10px; top:10px; z-index: 1; font-size: 11px; background:none !important;"><?php echo __("Select File","premiumpress"); ?></button>
                <input class="form-control" id="download_path<?php echo $k; ?>9" name="admin_values[bgimg][<?php echo "gift".$k; ?>]" value="<?php if(_ppt(array('bgimg', "gift".$k)) == ""){ }else{ echo _ppt(array('bgimg', "gift".$k )); } ?>" />
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); ?>
<?php } ?>