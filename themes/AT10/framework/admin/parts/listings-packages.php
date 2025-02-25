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
   
   global $wpdb, $CORE, $settings;
   
   
   // GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
   $packagefields = get_option("packagefields");
   if(!is_array($packagefields)){ $packagefields = array(); }
   
    
   // GET LIST OF CATEGORIES FOR SELECTION
   $categorylist = $CORE->CategoryList(array(0,false,0,THEME_TAXONOMY,0,0,true));
   $categorylistarray = get_terms(THEME_TAXONOMY,"orderby=count&order=desc&get=all");
   $new_categorylistarray = array();
   foreach($categorylistarray as $cad){
   $new_categorylistarray[$cad->term_id] = $cad;
   }
   
   // PACKAGE FEATURES
   $pakfeatures = $CORE->PACKAGE("get_package_all_features", array());

	// GET LANGUAGES
	$langs = _ppt('languages');

?>
 
 
<div class="">



  <div class="row">
    <div class="col-md-4 pr-lg-4">
      <h3 class="mt-4"><?php echo __("Packages","premiumpress"); ?></h3>
      <p class="text-muted lead mb-4"><?php echo __("Packages allow you to charge users to add their content to your website.","premiumpress"); ?></p>
      
      
      <a href="https://www.youtube.com/watch?v=jDO87LHqUIk" class="btn btn-danger shadow-sm btn-sm px-3 popup-yt mb-4"><i class="fa fa-video mr-1"></i> <?php echo __("watch video","premiumpress"); ?></a>
      
    </div>
    <div class="col-md-8">
      <div class="card card-admin">
        <div class="card-body">
        
       
        
        
          <?php if( THEME_KEY == "daxxxxx"){ ?>
          <?php }else{ ?>
          <script>
            function doformcheck(a, div){
             
            	if(jQuery(a).prop('checked') ){	
            	jQuery('#'+div).val( 1 );
            	}else{
            	jQuery('#'+div).val( 0 );	
            	}
            
            }
         </script>
          <div class="accordion border " id="accPackages">
            <?php $i=0; $captionID = 1;
               $paknames = array('Free','Featured','Sponsored' );
               
               while($i < 10){   ?>
            <div class="card-header p-0 mb-0 bg-white" id="heading<?php echo $i; ?>">
              <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
              <?php if(_ppt('pak'.$i.'_enable') == 1){ echo "<span class='badge badge-success float-right mr-3 mt-3 mr-5'>enabled</span>"; } ?>
              <?php if(_ppt('pak'.$i.'_r') == 1){ echo "<span class='badge badge-danger float-right mr-3 mt-3  mr-5'>recurring</span>"; } ?>
              <h5 class="mb-0">
                <div class="title" style="font-size:16px;"> <span class="span-red bg-light text-dark mr-3"><?php echo $captionID; ?></span>
                  <?php if(strlen(_ppt('pak'.$i.'_price')) > 0 && is_numeric(_ppt('pak'.$i.'_price')) && _ppt('pak'.$i.'_name') != ""){ ?>
                  <span class="span-yellow mr-3 <?php echo $CORE->GEO("price_formatting",array()); ?>"><?php echo _ppt('pak'.$i.'_price'); ?></span>
                  <?php } ?>
                  <?php if(_ppt('pak'.$i.'_name') == ""){ if(isset($paknames[$i])){ echo $paknames[$i]; }else{ echo "-"; }  }else{ echo _ppt('pak'.$i.'_name'); }?>
                </div>
              </h5>
              </button>
            </div>
            <div id="collapse<?php echo $i; ?>" class="collapse" aria-labelledby="heading<?php echo $i; ?>" data-parent="#accPackages">
              <div class="card-body bg-light border mb-4 pb-4">
                <div class="row border-bottom pb-3 mb-3" >
                  <div class="col-md-2 formrow">
                    <div>
                      <label class="radio off">
                      <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('enablepak<?php echo $i; ?>').value='0'">
                      </label>
                      <label class="radio on">
                      <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('enablepak<?php echo $i; ?>').value='1'">
                      </label>
                      <div class="toggle <?php if(  _ppt('pak'.$i.'_enable') == '1'){  ?>on<?php } ?>">
                        <div class="yes">ON</div>
                        <div class="switch"></div>
                        <div class="no">OFF</div>
                      </div>
                    </div>
                    <input type="hidden" id="enablepak<?php echo $i; ?>" name="admin_values[pak<?php echo $i; ?>_enable]" 
                             value="<?php if(_ppt('pak'.$i.'_enable') == ""){ if(isset($paknames[$i]) ){ echo 1; }else{ echo 0; } }else{ echo _ppt('pak'.$i.'_enable'); } ?>">
                  </div>
                  <div class="col-md-6 ">
                    <label class="font-weight-bold mb-2"><?php echo __("Enable Package","premiumpress"); ?> </label>
                  </div>
                </div>
                <div class="row py-2">
                  <div class="col-2">
                    <input type="hidden" name="admin_values[pak<?php echo $i; ?>_icon]"  id="pak<?php echo $i; ?>_icon"  value="<?php if(_ppt('pak'.$i.'_icon') == ""){ echo "fa fa-cog"; }else{ echo _ppt('pak'.$i.'_icon'); } ?>" />
                    <i class="<?php if( _ppt('pak'.$i.'_icon')  != ""){ echo str_replace("fa fa ","fa ", _ppt('pak'.$i.'_icon') ); }else{ echo "fa fa-cog"; }  ?> fa-3x float-left mr-2 fa-1x border p-2" style="cursor:pointer;" id="pak<?php echo $i; ?>_icon_icon" onclick="loadiconbox('pak<?php echo $i; ?>_icon','<?php if( _ppt('pak'.$i.'_icon') != ""){ echo _ppt('pak'.$i.'_icon'); }else{ echo "fa fa-cog"; }  ?>');"></i> </div>
                  <div class="col-10">
                    <div class="row">
                      <div class="col-md-9">
                        <label class="txt500 mb-2 w-100"><?php echo __("Name","premiumpress"); ?> <span class="float-right small"><a href="javascript:void(0);" class="btn btn-sm btn-system" onclick="jQuery('#customdisplay<?php echo  $i; ?>').toggle();"><?php echo __("Custom Display Features","premiumpress"); ?></a></span> </label>
                        <input type="text" name="admin_values[pak<?php echo $i; ?>_name]" value="<?php if(_ppt('pak'.$i.'_name') == ""){ if(isset($paknames[$i]) ){ echo $paknames[$i]; }else{ echo ""; }  }else{ echo _ppt('pak'.$i.'_name'); } ?>" class="form-control">
                        <input type="hidden" name="admin_values[pak<?php echo $i; ?>_key]" value="<?php echo $i; ?>" >
                      </div>
                      <div class="col-md-3">
                        <label><?php echo __("Highlight","premiumpress"); ?></label>
                        <div class="formrow mt-2">
                          <label class="radio off">
                          <input type="radio" name="toggle" 
            value="off" onchange="document.getElementById('pak<?php echo $i; ?>_highlight').value='0'">
                          </label>
                          <label class="radio on">
                          <input type="radio" name="toggle"
            value="on" onchange="document.getElementById('pak<?php echo $i; ?>_highlight').value='1'">
                          </label>
                          <div class="toggle <?php if( _ppt('pak'.$i.'_highlight') == '1'){  ?>on<?php } ?>">
                            <div class="yes">ON</div>
                            <div class="switch"></div>
                            <div class="no">OFF</div>
                          </div>
                        </div>
                        <input type="hidden" id="pak<?php echo $i; ?>_highlight" name="admin_values[pak<?php echo $i; ?>_highlight]" value="<?php if(_ppt('pak'.$i.'_highlight') == ""){ echo 0; }else{ echo _ppt('pak'.$i.'_highlight'); } ?>">
                      </div>
                    </div>
                    <?php /***********************************************************************/ ?>
                    <?php if(is_array($langs) && !empty($langs) && count($langs) > 1 ){ ?>
                    <div id="" class="" >
                      <?php foreach(_ppt('languages') as $lang){
			
					$icon = explode("_",$lang); 
			
					if(_ppt(array('lang','default')) == "en_US" && isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
				
				?>
                      <div class="mt-3">
                        <div class="mb-2 small">
                          <div class="flag flag-<?php if(isset($icon[1])){ echo strtolower($icon[1]); }else{ echo $icon[0]; } ?> mr-2">&nbsp;</div>
                          <?php echo $CORE->GEO("get_lang_name", $lang); ?> </div>
                        <input type="text" name="admin_values[pak<?php echo $i; ?>_name_<?php echo strtolower($lang); ?>]" value="<?php if(_ppt('pak'.$i.'_name_'.strtolower($lang)) == ""){ if(isset($paknames[$i]) ){ echo $paknames[$i]; }else{ echo ""; }  }else{ echo _ppt('pak'.$i.'_name_'.strtolower($lang)); } ?>" class="form-control">
                      </div>
                      <?php } ?>
                    </div>
                    <?php } ?>
                    <?php /***********************************************************************/ ?>
                  </div>
                </div>
                <!-- end row -->
                <div class="mt-3 mb-3">
                  <label><?php echo __("Description","premiumpress"); ?></label>
                  <textarea name="admin_values[pak<?php echo $i; ?>_desc]" class="form-control" style="height:100px !important;"><?php if(_ppt('pak'.$i.'_desc') == ""){ }else{     echo stripslashes(_ppt('pak'.$i.'_desc')); }?>
</textarea>
                </div>
                <?php /***********************************************************************/ ?>
                <?php if(is_array($langs) && !empty($langs) && count($langs) > 1 ){ ?>
                <div id="" class="" >
                  <?php foreach(_ppt('languages') as $lang){
			
					$icon = explode("_",$lang); 
			
					if(_ppt(array('lang','default')) == "en_US" && isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
				
				?>
                  <div class="mt-3">
                    <div class="mb-2 small">
                      <div class="flag flag-<?php if(isset($icon[1])){ echo strtolower($icon[1]); }else{ echo $icon[0]; } ?> mr-2">&nbsp;</div>
                      <?php echo $CORE->GEO("get_lang_name", $lang); ?> </div>
                    <textarea name="admin_values[pak<?php echo $i; ?>_desc_<?php echo strtolower($lang); ?>]" class="form-control" style="height:100px !important;"><?php if(_ppt('pak'.$i.'_desc_'.strtolower($lang)) == ""){ }else{ echo _ppt('pak'.$i.'_desc_'.strtolower($lang)); } ?>
</textarea>
                  </div>
                  <?php } ?>
                </div>
                <?php } ?>
                <?php /***********************************************************************/ ?>
                <div  id="customdisplay<?php echo  $i; ?>" style="display:none;">
                  <label class="my-4"><?php echo __("Custom Display Features","premiumpress"); ?></label>
                  <div class="row mb-4">
                    <?php $f =1; while($f < 9){ ?>
                    <div class="col-md-6 mb-4 border-bottom pb-4">
                      <div class="position-relative">
                        <input type="text" name="admin_values[pak<?php echo $i; ?>_txt<?php echo $f; ?>]" value="<?php if(_ppt('pak'.$i.'_txt'.$f) == ""){ echo ""; }else{ echo _ppt('pak'.$i.'_txt'.$f); } ?>" class="form-control" style="padding-left:45px !important;">
                        <input type="hidden" name="admin_values[pak<?php echo $i; ?>_txt<?php echo $f; ?>_val]" id="pak<?php echo $i; ?>_txt<?php echo $f; ?>_val" value="<?php echo _ppt('pak'.$i.'_txt'.$f.'_val');  ?>" />
                        <i class="fa <?php if(_ppt('pak'.$i.'_txt'.$f.'_val') != "0"){ ?>fa-check text-success<?php }else{ ?>fa-times text-danger<?php } ?> position-absolute" onclick="changeCheckB('pak<?php echo $i; ?>_txt<?php echo $f; ?>_val')" id="pak<?php echo $i; ?>_txt<?php echo $f; ?>_val_check" style="top:15px; left:15px; cursor:pointer;"></i> </div>
                      <?php if(is_array($langs) && !empty($langs) && count($langs) > 1 ){ ?>
                      <div id="" class="" >
                        <?php foreach(_ppt('languages') as $lang){
			
					$icon = explode("_",$lang); 
			
					if(_ppt(array('lang','default')) == "en_US" && isset($icon[1]) && strtolower($icon[1]) == "us"){ continue; } 
				
				?>
                        <div class="mt-3">
                          <div class="mb-2 small">
                            <div class="flag flag-<?php if(isset($icon[1])){ echo strtolower($icon[1]); }else{ echo $icon[0]; } ?> mr-2">&nbsp;</div>
                            <?php echo $CORE->GEO("get_lang_name", $lang); ?> </div>
                          <input type="text" name="admin_values[pak<?php echo $i; ?>_txt<?php echo $f; ?>_<?php echo strtolower($lang); ?>]" value="<?php if(_ppt('pak'.$i.'_txt'.$f.'_'.strtolower($lang)) == ""){ echo _ppt('pak'.$i.'_txt'.$f); }else{ echo _ppt('pak'.$i.'_txt'.$f.'_'.strtolower($lang)); } ?>" class="form-control">
                        </div>
                        <?php } ?>
                      </div>
                      <?php } ?>
                    </div>
                    <?php  $f++; } ?>
                  </div>
                </div>
                <div class="row py-2">
                  <div class="col-md-4">
                    <label><?php echo __("Price","premiumpress"); ?> <span class="required">*</span></label>
                    <div class="input-group"> <span class="input-group-prepend input-group-text"><?php echo hook_currency_symbol(''); ?></span>
                      <input type="text" name="admin_values[pak<?php echo $i; ?>_price]" value="<?php if(_ppt('pak'.$i.'_price') == ""){ echo 0; }else{ echo _ppt('pak'.$i.'_price'); } ?>" class="form-control val-numeric">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label><?php echo __("Recurring Payment","premiumpress"); ?></label>
                    <div class="formrow mt-2">
                      <label class="radio off">
                      <input type="radio" name="toggle" 
            value="off" onchange="document.getElementById('pak<?php echo $i; ?>_r').value='0'">
                      </label>
                      <label class="radio on">
                      <input type="radio" name="toggle"
            value="on" onchange="document.getElementById('pak<?php echo $i; ?>_r').value='1'">
                      </label>
                      <div class="toggle <?php if( _ppt('pak'.$i.'_r') == '1'){  ?>on<?php } ?>">
                        <div class="yes">ON</div>
                        <div class="switch"></div>
                        <div class="no">OFF</div>
                      </div>
                    </div>
                    <input type="hidden" id="pak<?php echo $i; ?>_r" name="admin_values[pak<?php echo $i; ?>_r]" value="<?php echo _ppt('pak'.$i.'_r'); ?>">
                  </div>
                </div>
                <?php
if(_ppt(array('lst','websitepackages')) == 1 && !empty($pakfeatures)){

 ?>
                <div class="col-md-12 px-0 mt-5">
                  <div class="border p-3 bg-white shadow-sm"> <i class="fal fa-check float-left mr-4 fa-3x mt-2"></i>
                    <h6 class="mt-2"><?php echo __("Package Features","premiumpress"); ?></h6>
                    <p><?php echo __("Choose which features come with this listing.","premiumpress"); ?></p>
                    <div class="bg-white p-3 ">
                      <?php  foreach(  $pakfeatures as $pak_key => $fea){   ?>
                      <div class="row py-3 border-top">
                        <div class="col small"> 
                        
                        
                        <label  class="ppt-tooltip-show"> <?php echo $fea['name']; ?>
                         <?php if(isset($fea['desc'])){ ?>
        <i class="fal fa-info-circle ml-2 ppt-tooltip-show" style="cursor:pointer"></i>
        
        <div class="ppt-tooltip bg-dark p-2 shadow" style="height: auto !important;
    text-align: left;
    font-size: 14px;
    max-width: 400px !important; "> <i class="fal fa-info-circle ml-2 fa-2x float-left pr-3" style="cursor:pointer"></i> <?php echo $fea['desc']; ?></div> 
        
        <?php } ?>
        
        </label>
                        
                        
                        
                        </div>
                        <div class="col-md-3">
                          <?php if(isset($fea['inputbox'])){ ?>
                          <div class="position-relative">
                            <input type="text" value="<?php if(_ppt('pak'.$i.'_'.$fea['key']) == ""){ echo 10; }else{ echo _ppt('pak'.$i.'_'.$fea['key']); } ?>" name="admin_values[pak<?php echo $i; ?>_<?php echo $fea['key']; ?>]" class="form-control" />
                            <?php if($fea['key'] == "duration"){ ?>
                            <div class="position-absolute text-muted small" style="bottom: 8px;    right: 10px;">days</div>
                            <?php } ?>
                          </div>
                          <?php }else{ ?>
                          <label class="custom-control custom-checkbox">
                          <input type="checkbox" 
                    value="1" 
                   
                    class="custom-control-input" 
                    id="pak<?php echo $i; ?>_<?php echo $fea['key']; ?>check" 
                    onchange="ChekME('#pak<?php echo $i; ?>_<?php echo $fea['key']; ?>');"
                     
                    <?php if(_ppt('pak'.$i.'_'.$fea['key']) == 1){ ?>checked=checked<?php } ?>>
                          <input type="hidden" name="admin_values[pak<?php echo $i; ?>_<?php echo $fea['key']; ?>]" id="pak<?php echo $i; ?>_<?php echo $fea['key']; ?>add" value="<?php if(_ppt('pak'.$i.'_'.$fea['key']) == ""){ echo 1; }else{ echo _ppt('pak'.$i.'_'.$fea['key']); } ?>">
                          <span class="custom-control-label">&nbsp;</span> </label>
                          <?php } ?>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                
                
                  
            <div>
            
            <hr />
            
            <p class="font-weight-bold"><?php echo __("Custom Package Link","premiumpress"); ?></p>
            
            <p><?php echo __("Ideal for use in your own pricing table designs or email links.","premiumpress"); ?></p>
            
            <p><a href="<?php echo _ppt(array('links','add')); ?>?pakid=<?php echo $i; ?>" target="_blank"><?php echo _ppt(array('links','add')); ?>?pakid=<?php echo $i; ?></a></p>
            
            </div>
                
                
                
                
                
                
                
                <?php }   ?>
              </div>
            </div>
          
            
            <?php $i++; $captionID++; } ?>
            
            
            
            
            
            
          </div>
          <?php } ?>
          <div class="p-4 bg-light text-center mt-4">
            <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
 
 $addons_array = $CORE->PACKAGE("get_packages_addons", array() );
 if(!empty($addons_array)){
 
  $settings = array("title" => __("Listing Promotions","premiumpress"), "desc" => __("Here you can setup pricing for listing add-ons. Set all values to OFF to hide display on the frontend.","premiumpress") );
   _ppt_template('framework/admin/_form-wrap-top' ); ?>
<div class="card card-admin">
  <div class="card-body">
    <div class="container px-0  border-bottom mb-3 ">
      <div class="row">
        <div class="col-6"> </div>
        <div class="col-3">
          <label><?php echo __("Price","premiumpress"); ?></label>
        </div>
        <div class="col-3">
          <label><?php echo __("Enable","premiumpress"); ?></label>
        </div>
      </div>
    </div>
    <?php foreach( $addons_array as $a){ ?>
    <div class="container px-0  border-bottom mb-3">
      <div class="row">
        <div class="col-6">
          <label><span class="<?php echo $a['color']; ?>"><?php echo $a['name']; ?></span></label>
          <p class="text-muted"><?php echo $a['desc']; ?></p>
        </div>
        <div class="col-3">
          <div class="position-relative">
            <input type="text" value="<?php if( _ppt(array('lst', $a['key'].'_price')) == ""){ echo 10; }else{ echo _ppt(array('lst', $a['key'].'_price')); } ?>" name="admin_values[lst][<?php echo $a['key']; ?>_price]" class="form-control" />
            <div class="position-absolute text-muted small" style="bottom: 8px; right: 10px;"><?php echo hook_currency_code(''); ?></div>
          </div>
        </div>
        <div class="col-3">
          <div>
            <label class="radio off">
            <input type="radio" name="toggle" 
               value="off" onchange="document.getElementById('<?php echo $a['key']; ?>_enable').value='0'">
            </label>
            <label class="radio on">
            <input type="radio" name="toggle"
               value="on" onchange="document.getElementById('<?php echo $a['key']; ?>_enable').value='1'">
            </label>
            <div class="toggle <?php if( _ppt(array('lst', $a['key'].'_enable')) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
          <input type="hidden" id="<?php echo $a['key']; ?>_enable" name="admin_values[lst][<?php echo $a['key']; ?>_enable]" value="<?php echo _ppt(array('lst', $a['key'].'_enable')); ?>">
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="p-4 bg-light text-center mt-4">
      <button type="submit" class="btn btn-admin"><?php echo __("Save Settings","premiumpress"); ?></button>
    </div>
  </div>
</div>
<!-- end admin card -->
<?php _ppt_template('framework/admin/_form-wrap-bottom' ); 

}
?>
 