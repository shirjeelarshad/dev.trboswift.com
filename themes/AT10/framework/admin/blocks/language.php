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
 

ob_start(); 
?>
<optgroup label="Common Language">

<option value="en_US" <?php if(!is_array(_ppt('languages'))){ echo "selected=selected"; } ?> data-icon="lang lang-en region region-us">English</option>
<option value="es_ES" data-icon="lang lang-es region region-es">Spanish</option>
<option value="fr_FR" data-icon="lang lang-fr region region-fr">French</option>
<option value="zh_CN" data-icon="lang lang-zh region region-cn">Chinese</option>
<option value="de_DE" data-icon="lang lang-de region region-de">German</option>
<option value="ru_RU" data-icon="lang lang-ru region region-ru">Russian</option>
<option value="ar" data-icon="lang lang-ar">Arabic</option>
<option value="ja" data-icon="lang lang-ja">Japanese</option>
<option value="ko_KR" data-icon="lang lang-ko region region-kr">Korean</option>
<option value="it_IT" data-icon="lang lang-it region region-it">Italian</option>
<option value="nl_NL" data-icon="lang lang-nl region region-nl">Dutch</option>
</optgroup>
<optgroup label="Available languages">
<option value="ary" data-icon="lang lang-ary">Moroccan Arabic</option>
<option value="az" data-icon="lang lang-az">Azerbaijani</option>
<option value="azb" data-icon="lang lang-azb">South Azerbaijani</option>
<option value="bg_BG" data-icon="lang lang-bg region region-bg">Bulgarian</option>
<option value="bn_BD" data-icon="lang lang-bn region region-bd">Bengali</option>
<option value="bo" data-icon="lang lang-bo">Tibetan</option>
<option value="bs_BA" data-icon="lang lang-bs region region-ba">Bosnian</option>
<option value="ca" data-icon="lang lang-ca">Catalan</option>
<option value="ceb" data-icon="lang lang-ceb">Cebuano</option>
<option value="cs_CZ" data-icon="lang lang-cs region region-cz">Czech</option>
<option value="cy" data-icon="lang lang-cy">Welsh</option>
<option value="da_DK" data-icon="lang lang-da region region-dk">Danish</option>
<option value="pl_PL" data-icon="lang lang-pl region region-pl">Polish</option>
<option value="tr_TR" data-icon="lang lang-tr region region-tr">Turkish</option>
<option value="el" data-icon="lang lang-el">Greek</option>
<?php /*
<option value="en_CA" data-icon="lang lang-en region region-ca">English (Canada)</option>
<option value="en_NZ" data-icon="lang lang-en region region-nz">English (New Zealand)</option>
<option value="en_AU" data-icon="lang lang-en region region-au">English (Australia)</option>
<option value="en_GB" data-icon="lang lang-en region region-gb">English (UK)</option>
<option value="en_ZA" data-icon="lang lang-en region region-za">English (South Africa)</option>
*/ ?>

<option value="eo" data-icon="lang lang-eo">Esperanto</option>
 
<option value="et" data-icon="lang lang-et">Estonian</option>
<option value="eu" data-icon="lang lang-eu">Basque</option>
<option value="fa_IR" data-icon="lang lang-fa region region-ir">Persian</option>
<option value="fi" data-icon="lang lang-fi">Finnish</option>
 
<option value="gd" data-icon="lang lang-gd">Scottish Gaelic</option>
<option value="gl_ES" data-icon="lang lang-gl region region-es">Galician</option>
<option value="gu" data-icon="lang lang-gu">Gujarati</option>
<option value="haz" data-icon="lang lang-haz">Hazaragi</option>
<option value="he_IL" data-icon="lang lang-he region region-il">Hebrew</option>
<option value="hi_IN" data-icon="lang lang-hi region region-in">Hindi</option>
<option value="hr" data-icon="lang lang-hr">Croatian</option>
<option value="hu_HU" data-icon="lang lang-hu region region-hu">Hungarian</option>
<option value="hy" data-icon="lang lang-hy">Armenian</option>
<option value="id_ID" data-icon="lang lang-id region region-id">Indonesian</option>
<option value="is_IS" data-icon="lang lang-is region region-is">Icelandic</option>
<option value="ka_GE" data-icon="lang lang-ka region region-ge">Georgian</option>
<option value="lt_LT" data-icon="lang lang-lt region region-lt">Lithuanian</option>
<option value="lv" data-icon="lang lang-lv">Latvian</option>
<option value="mk_MK" data-icon="lang lang-mk region region-mk">Macedonian</option>
<option value="mr" data-icon="lang lang-mr">Marathi</option>
<option value="ms_MY" data-icon="lang lang-ms region region-my">Malay</option>
<option value="my_MM" data-icon="lang lang-my region region-mm">Myanmar (Burmese)</option>
<option value="nb_NO" data-icon="lang lang-nb region region-no">Norwegian (Bokmal)</option>
<option value="nl_NL_formal" data-icon="lang lang-nl region region-nl variant variant-formal">Dutch (Formal)</option>
<option value="nn_NO" data-icon="lang lang-nn region region-no">Norwegian (Nynorsk)</option>
<option value="oci" data-icon="lang lang-oci">Occitan</option>

<option value="ps" data-icon="lang lang-ps">Pashto</option>
<option value="pt_PT" data-icon="lang lang-pt region region-pt">Portuguese (Portugal)</option>
<option value="pt_BR" data-icon="lang lang-pt region region-br">Portuguese (Brazil)</option>
<option value="ro_RO" data-icon="lang lang-ro region region-ro">Romanian</option>
<option value="sk_SK" data-icon="lang lang-sk region region-sk">Slovak</option>
<option value="sl_SI" data-icon="lang lang-sl region region-si">Slovenian</option>
<option value="sq" data-icon="lang lang-sq">Albanian</option>
<option value="sr_RS" data-icon="lang lang-sr region region-rs">Serbian</option>
<option value="sv_SE" data-icon="lang lang-sv region region-se">Swedish</option>
<option value="szl" data-icon="lang lang-szl">Silesian</option>
<option value="si_LK" data-icon="lang lang-si">Sinhala</option>
<option value="sk_SK" data-icon="lang lang-sk">Slovak</option>
<option value="th" data-icon="lang lang-th">Thai</option>
<option value="tl" data-icon="lang lang-tl">Tagalog</option>

<option value="ta_LK" data-icon="lang lang-ta">Tamil (Sri Lanka)</option>

<option value="ug_CN" data-icon="lang lang-ug region region-cn">Uighur</option>
<option value="uk" data-icon="lang lang-uk">Ukrainian</option>
<option value="vi" data-icon="lang lang-vi">Vietnamese</option>
<option value="zh_HK" data-icon="lang lang-zh region region-hk">Chinese (Hong Kong)</option>
<option value="zh_TW" data-icon="lang lang-zh region region-tw">Chinese (Taiwan)</option>
</optgroup>
<?php


$languagelist = ob_get_clean(); 
$flaglist = $languagelist;
if(_ppt('languages') != "" && is_array(_ppt('languages')) ){
	foreach(_ppt('languages') as $lang){
 
		$languagelist  = str_replace(''.$lang.'"', ''.$lang.'" selected=selected',$languagelist );
	}
}


$defaultlang = _ppt(array('lang','default'));


?>
<div class="p-4 bg-light">
  <div class="col-12">
    <h5 class="mb-4"><?php echo __("Default Display Language","premiumpress"); ?></h5>
    <select name="admin_values[lang][default]" class="form-control mb-4" style="font-size: 18px !important;    height: 50px !important;">
      <?php

	
	if($defaultlang == ""){ $defaultlang = "en_US"; }
 
	$flaglist  = str_replace('"'.$defaultlang.'"', '"'.$defaultlang.'" selected=selected', $flaglist );		
	
	
	echo $flaglist;
	
	 ?>
    </select>
  </div>
 
</div>
<h5 class="mt-5"><?php echo __("Dropdown Languages","premiumpress"); ?></h5>
<div class="col-12 border-top py-3 mt-4">
  <div class="row">
    <div class="col-md-2">
      <div class="input-group mt-2">
        <div class="formrow">
          <div class="">
            <label class="radio off" style="display: none;">
            <input type="radio" name="toggle" value="off" onchange="document.getElementById('langswitch_onoff').value='0'">
            </label>
            <label class="radio on" style="display: none;">
            <input type="radio" name="toggle" value="on" onchange="document.getElementById('langswitch_onoff').value='1'">
            </label>
            <div class="toggle <?php if( _ppt(array('lang','switch')) == '1'){  ?>on<?php } ?>">
              <div class="yes">ON</div>
              <div class="switch"></div>
              <div class="no">OFF</div>
            </div>
          </div>
        </div>
        <input type="hidden" id="langswitch_onoff" name="admin_values[lang][switch]" value="<?php echo  _ppt(array('lang','switch')); ?>">
      </div>
    </div>
    <div class="col-md-9">
      <label class="w-100"> <?php echo __("Language Switcher","premiumpress"); ?></label>
      <p class="pb-0 btn-block text-muted mb-0 mt-2"><?php echo __("Turn on/off the display of the language switching button.","premiumpress"); ?></p>
      <label class="txt500 mt-4"><?php echo __("Icon","premiumpress"); ?></label>
      <p class="text-muted"><?php echo __("Here you can choose the flag icon for the default language.","premiumpress"); ?></p>
      <select name="admin_values[lang][flagicon]" class="form-control mb-4">
        <?php

	if( _ppt(array('language','flagicon')) != ""){
		$flaglist  = str_replace('"'._ppt(array('language','flagicon')).'"', '"'._ppt(array('language','flagicon')).'" selected=selected', $flaglist );		
	}
	
	echo $flaglist;
	
	 ?>
      </select>
      <select name="admin_values[languages][]" class="form-control mt-4" multiple="multiple" style="width:100%; height:300px !important;">
        <?php echo $languagelist; ?>
      </select>
      <p class="text-muted mt-2"><?php echo __("Press and hold CTRL to select multiple values.","premiumpress"); ?></p>
      
      
      <?php /*
      
      <hr />
   
    <div class="row">
      <div class="col-md-3">
        <div class="input-group mb-2">
          <div class="formrow">
            <div class="">
              <label class="radio off" style="display: none;">
              <input type="radio" name="toggle" value="off" onchange="document.getElementById('langrtl_onoff').value='0'">
              </label>
              <label class="radio on" style="display: none;">
              <input type="radio" name="toggle" value="on" onchange="document.getElementById('langrtl_onoff').value='1'">
              </label>
              <div class="toggle <?php if( _ppt(array('lang','rtl')) == '1'){  ?>on<?php } ?>">
                <div class="yes">ON</div>
                <div class="switch"></div>
                <div class="no">OFF</div>
              </div>
            </div>
          </div>
          <input type="hidden" id="langrtl_onoff" name="admin_values[lang][rtl]" value="<?php if(_ppt(array('lang','rtl')) == ""){ echo 0; }else{ echo _ppt(array('lang','rtl')); } ?>">
        </div>
      </div>
      <div class="col-md-9">
        <label class="w-100"><?php echo __("Right To Left (icons and language)","premiumpress"); ?></label>
        <p class="pb-0 btn-block text-muted mb-0 mt-1"><strong><?php echo __("Only needed if you are using Arabic languages.","premiumpress"); ?></strong></p>
      </div>
    </div>
	
	*/ ?>
  
      
      
      
      
      
    </div>
  </div>
</div>
