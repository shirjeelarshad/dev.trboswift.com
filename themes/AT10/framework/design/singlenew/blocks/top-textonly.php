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

global $CORE, $userdata;
 

 
?>
<?php if(defined('THEME_KEY') && THEME_KEY == "cp"){ ?>

<?php _ppt_template( 'framework/design/cards/cp/list' ); ?>

<div class="position-relative card card-body  card-top-image mb-4 top-gallery">
  <div class="pt-4 mx-2"> <div id="printme"><?php echo do_shortcode("[CONTENT]");  ?></div>
  
  
  <?php $type = strip_tags(do_shortcode('[CTYPE]')); if(strpos(strtolower($type), "print") !== false){ ?>
  
   <a href="javascript:void(0)" onClick="jQuery('#printme').print();"  class="btn btn-system btn-md "><i class="fal fa-print mr-2 text-primary mr-3"></i> <?php echo __("Print Coupon","premiumpress") ?></a>
  
  
  <script>
  
 
!function(e){"use strict";function t(t,n,r){for(var o=e(t),i=o.clone(n,r),a=o.find("textarea").add(o.filter("textarea")),l=i.find("textarea").add(i.filter("textarea")),c=o.find("select").add(o.filter("select")),d=i.find("select").add(i.filter("select")),f=0,s=a.length;f<s;++f)e(l[f]).val(e(a[f]).val());for(f=0,s=c.length;f<s;++f)for(var p=0,u=c[f].options.length;p<u;++p)!0===c[f].options[p].selected&&(d[f].options[p].selected=!0);return i}function n(n){var r=e("");try{r=t(n)}catch(t){r=e("<span />").html(n)}return r}function r(t,n,r){var o=e.Deferred();try{var i=(t=t.contentWindow||t.contentDocument||t).document||t.contentDocument||t;r.doctype&&i.write(r.doctype),i.write(n),i.close();var a=!1,l=function(){if(!a){t.focus();try{t.document.execCommand("print",!1,null)||t.print(),e("body").focus()}catch(e){t.print()}t.close(),a=!0,o.resolve()}};e(t).on("load",l),setTimeout(l,r.timeout)}catch(e){o.reject(e)}return o}function o(e,t){return r(window.open(),e,t).always(function(){try{t.deferred.resolve()}catch(e){console.warn("Error notifying deferred",e)}})}function i(e){return!!("object"==typeof Node?e instanceof Node:e&&"object"==typeof e&&"number"==typeof e.nodeType&&"string"==typeof e.nodeName)}e.print=e.fn.print=function(){var a,l,c=this;c instanceof e&&(c=c.get(0)),i(c)?(l=e(c),arguments.length>0&&(a=arguments[0])):arguments.length>0?i((l=e(arguments[0]))[0])?arguments.length>1&&(a=arguments[1]):(a=arguments[0],l=e("html")):l=e("html");var d={globalStyles:!0,mediaPrint:!1,stylesheet:null,noPrintSelector:".no-print",iframe:!0,append:null,prepend:null,manuallyCopyFormValues:!0,deferred:e.Deferred(),timeout:750,title:null,doctype:"<!doctype html>"};a=e.extend({},d,a||{});var f=e("");a.globalStyles?f=e("style, link, meta, base, title"):a.mediaPrint&&(f=e("link[media=print]")),a.stylesheet&&(f=e.merge(f,e('<link rel="stylesheet" href="'+a.stylesheet+'">')));var s=t(l);if((s=e("<span/>").append(s)).find(a.noPrintSelector).remove(),s.append(t(f)),a.title){var p=e("title",s);0===p.length&&(p=e("<title />"),s.append(p)),p.text(a.title)}s.append(n(a.append)),s.prepend(n(a.prepend)),a.manuallyCopyFormValues&&(s.find("input").each(function(){var t=e(this);t.is("[type='radio']")||t.is("[type='checkbox']")?t.prop("checked")&&t.attr("checked","checked"):t.attr("value",t.val())}),s.find("select").each(function(){e(this).find(":selected").attr("selected","selected")}),s.find("textarea").each(function(){var t=e(this);t.text(t.val())}));var u,h,m,y,v=s.html();try{a.deferred.notify("generated_markup",v,s)}catch(e){console.warn("Error notifying deferred",e)}if(s.remove(),a.iframe)try{u=v,m=e((h=a).iframe+""),0===(y=m.length)&&(m=e('<iframe height="0" width="0" border="0" wmode="Opaque"/>').prependTo("body").css({position:"absolute",top:-999,left:-999})),r(m.get(0),u,h).done(function(){setTimeout(function(){0===y&&m.remove()},1e3)}).fail(function(e){console.error("Failed to print from iframe",e),o(u,h)}).always(function(){try{h.deferred.resolve()}catch(e){console.warn("Error notifying deferred",e)}})}catch(e){console.error("Failed to print from iframe",e.stack,e.message),o(v,a)}else o(v,a);return this}}(jQuery);
  </script>
  
  
  <?php } ?>
  
      <?php if(in_array(_ppt(array('design','display_comments')), array("","1")) ){ ?>
    
     <a href="javascript:void(0)"  <?php if(!$userdata->ID){ ?> onclick="processLogin();" <?php }else{ ?>onclick="processCommentPop();"<?php } ?>  class="btn btn-system btn-md "><i class="fal fa-comments mr-2 text-primary"></i> <?php echo __("Write Review","premiumpress") ?></a>
     
 
 <?php  $GLOBALS['hidecomments'] = 1; _ppt_template( 'framework/design/singlenew/blocks/comments' ); ?>

     <?php } ?>
 
  
  </div>
</div>
<?php
 if(in_array(_ppt(array('design', 'display_related')), array("","1"))){
ob_start();
global $new_settings;
$new_settings['title'] = __("Related Deals","premiumpress");
$new_settings['section_padding'] = "section-bottom-40";
$new_settings['custom'] = "related";
$new_settings['datastring'] = "custom='related'";
$CORE->LAYOUT("load_single_block", "listings7a");
$new_settings['section_padding'] = "";
$new_settings['title'] = "";
$new_settings['datastring'] = "";
$new_settings['custom'] = "";
$MAINSTRINGSTRING = ob_get_contents();	
ob_end_clean();

echo str_replace("container","container px-0", $MAINSTRINGSTRING);
}


 
?>
<?php }else{ ?>
<div class="position-relative card card-body  card-top-image mb-4 top-gallery">
  <div class="pt-4 mx-2">
    <?php _ppt_template( 'framework/design/singlenew/blocks/top-content' ); ?>
    

    
  </div>
</div>
<?php } ?>
