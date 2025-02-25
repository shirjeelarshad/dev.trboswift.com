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
 
if(in_array(_ppt(array('design', 'display_comments')), array("0"))){

}elseif(defined('THEME_KEY') && in_array(THEME_KEY, array("ph")) ){

	_ppt_template( 'framework/design/singlenew/blocks/comments-user' );

}elseif(defined('THEME_KEY') && in_array(THEME_KEY, array("ct","dl","at","mj")) ){

	_ppt_template( 'framework/design/singlenew/blocks/comments-all' );

}else{



$allowNewComments = 1;

if( in_array(THEME_KEY, array("mj")) ){

$allowNewComments = 0;

}
 


switch(THEME_KEY){
 
	case "ct":
	case "mj": {
	$title = __("Seller Feedback","premiumpress");
	} break;
	
	case "cm": {
	$title = __("Reviews","premiumpress");
	} break;	 
	
	default: {	
	$title = __("Comments","premiumpress");
	} break;
}

 
 if($post->comment_count == 0 && $post->post_author == 1 && defined('WLT_DEMOMODE')){ $ccu = 3; }else{ $ccu = $post->comment_count; }
 
 ?>
<div class="mb-4 pb-4" <?php if(isset($GLOBALS['hidecomments'] ) ){ ?>style="display:none;"<?php } ?>>
  <h5 class="card-title <?php  if($ccu > 0){ ?>float-left <?php } ?>ml-lg-4"><?php echo $title; ?></h5>
  
  
<?php  if($ccu == 0){ ?>
<div class="my-4 clearfix ml-lg-4">
<span class="btn-rounded bg-light  p-2 px-3 rounded small">
      <span class="mr-2"><i class="fal fa-comments"></i> </span>
      <span class="opacity-8"><?php echo __("No Reviews Found","premiumpress"); ?></span> 
      
      </span>
</div>
<?php } ?>  
  
  
  <?php if($allowNewComments && $ccu > 0){ ?>
  <?php if(!$userdata->ID){ ?>
  <a href="javascript:void(0);" onclick="processLogin();" class="btn btn-sm btn-system float-right ml-2"><span class="tiny mr-2"> <?php echo $ccu;  ?></span> <i class="fal fa-comments-alt text-primary mr-0"></i> </a> <a href="javascript:void(0)" onclick="processLogin();" class="btn btn-sm btn-system float-right mr-0 showcommentsbtn"><i class="fal fa-plus text-primary mr-0"></i> </a>
  <?php }else{ ?>
  <a href="javascript:void(0)" onclick="processCommentAll();" class="btn btn-sm btn-system float-right ml-2"> <span class="tiny mr-2"> <?php echo $ccu;  ?></span> <i class="fal fa-comments-alt text-primary mr-0"></i></a> <a href="javascript:void(0)" onclick="processCommentPop();" class="btn btn-sm btn-system float-right mr-0 showcommentsbtn"><i class="fal fa-plus text-primary mr-0"></i> </a>
  <?php } ?>
  <?php } ?>
</div>
<?php
 





$ratingLabels = $CORE->LAYOUT("captions","rating");	 

 			
	   
	   // STAR RATING
	   $starrating = get_post_meta($post->ID, 'starrating', true);
	   if(!is_numeric($starrating)){ $starrating = 0; }else{ $starrating = number_format($starrating,1); }
	   
	   $starreviews = get_post_meta($post->ID, 'starrating_votes', true);
	   if(!is_numeric($starreviews)){ $starreviews = 1; }
	   
	   $totalscore = 5;
	   $srating = array(0,0,0,0,0,0);
	   $spercent = array(0,0,0,0,0,0);
	   $sextras = array(0,0,0,0,0,0);
	   $c = get_comments( array ('fields' => 'ids', 'post_id' => $post->ID ) );
	   if(!empty($c)){
		foreach($c as $commentid){
			// GET THE RATING VALUE FOR EACH COMMENT
			
			$rt = get_comment_meta( $commentid, 'ratingtotal', true );
			if(!is_numeric($rt)){ $rt =0; }
			
			$totalscore = $totalscore + $rt;	
		   
			// GET THE RATING VALUE FOR EACH COMMENT
			$i=1; while($i < 5){
				$crating = get_comment_meta( $commentid, 'rating'.$i, true );	
				//echo $crating."< (".$i.")--<br>";
				if(!is_numeric($crating)){ $crating = 5; }		
				$sextras[$i] = $sextras[$i] + $crating;
				$i++;
			}
			 
		}
	   }
	   // CLEAN UP FRACTIONS
	   $i=1; 
	   
	   
	   if($starreviews == 0){ $starreviews = 1; }
	   
	   while($i < 5){
		$sextras[$i] = $sextras[$i]/$starreviews;
		$i++;
	   }
	   
	   // FIX TOTAL SCORE
	  $totalscore = get_post_meta($post->ID, 'starrating', true);
	   if(!is_numeric($totalscore)){ $totalscore = 5; }
   
  
  
?>
<script>


jQuery(document).ready(function(){ 


if(jQuery('#commentlistwrap .comment-single').length > 1){
	jQuery('#commentlistwrap .comment-single').hide();
	jQuery('#commentlistwrap .comment-single:nth(0)').fadeIn('slow');
	cc = -1;
	setInterval(function(){		
		
	    jQuery('#commentlistwrap .comment-single').hide();
		cc++;
		jQuery('#commentlistwrap .comment-single:nth('+cc+')').fadeIn('slow');		 
		if(cc == 2){ cc = 0; }
		
	}, 6000);
}	

});



</script>
<div class="clearfix"></div>
<div id="commentlistwrap" <?php if(isset($GLOBALS['hidecomments'])){  ?>style="display:none;"<?php } ?>>
  <?php 

/*

	1. DISPLAY COMMENTS
	
*/


if($post->comment_count == 0 && $post->post_author == 1 && defined('WLT_DEMOMODE')){

	// GET FILE
	_ppt_template('content-comment-example');	

}else{
	
	// BUILD COMMENT BLOCK
	ob_start();
	try {
	
		comments_template();  // GET THE DEFAULT WORDPRESS TEMPLATE FOR COMMENTS
 	
	}
	catch (Exception $e) {
	ob_end_clean();
	throw $e;
	}  
	$comment_form = ob_get_clean();
	echo preg_replace("/<form.*?<\/form>/is","", $comment_form);


}
?>
</div>
<?php
 

/*

	2. DISPLAY FORM BOX
	
*/
 

ob_start();

?>
<textarea id="comment" name="comment" style="min-height:100px;" aria-required="true" class="form-control my-4"></textarea>
<div class="fileupload-buttonbar" style="display:none;">
  <div class="d-flex justify-content-between align-items-center mt-2 mb-4">
    <div class="custom-file">
      <input type="file" id="gallery" name="commentphoto" class="custom-file-input">
      <label class="custom-file-label" for="gallery"><?php echo __("Select .jpg or .png images only.","premiumpress"); ?></label>
    </div>
  </div>
</div>
 
<a href="javascript:void(0);" onclick="jQuery('.fileupload-buttonbar').toggle();" class="small float-right"><i class="fa fa-upload"></i> <?php echo __("Attach Photo","premiumpress"); ?></a>


<button onClick="processrating()" type="submit" class="btn btn-system shadow-sm btn-xl btn-icon icon-before mb-4"><i class="fal fa-comment text-primary"></i> <?php echo __("Save Comment","premiumpress"); ?></button>
<?php
$commentfield = ob_get_clean();

 

/*

	3. DISPLAY RATING BOX
	
*/
$formextra = "";
if(THEME_KEY != "pj"){

if(!is_array($ratingLabels) ){  $ratingLabels = array();  }

ob_start(); ?>
<input type="hidden" name="score" value="5" id="rating-score" />
<input type="hidden" name="nocaptcha" value="1" />
<input type="hidden" name="totalratingitems" value="<?php echo count($ratingLabels); ?>" />

<input type="hidden" name="postauthor" value="<?php echo $post->post_author; ?>" />

<div class="container px-0 px-md-2">
  <div class="row" id="ratingCalculate">
    <div class="col-md-8">
      <?php foreach($ratingLabels as $k => $rating){ ?>
      <div class="py-2 border-bottom">
        <div class="row">
          <div class="col-4">
            <label class="pb-0 mb-0 small font-weight-bold text-uppercase text-muted"><?php echo $rating; ?></label>
          </div>
          <div class="col-8">
            <div class="mt-n2">
              <input type="text" class="rate-range" data-min="0" data-max="5"  name="rating-val" id="<?php echo $k; ?>"  data-step="1"  value="5">
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php if(count($ratingLabels) < 2){ echo $commentfield; $commentfield = ""; } ?>
    </div>
    <div class="col-md-4 hide-mobile">
      <div class="review-total">
        <div class="rating_avg" data-form="AVG({rating-val})"></div>
        <strong><?php echo __("Your Score.","premiumpress"); ?></strong> </div>
      <div class="rating-smiles">
        <div class="d-flex justify-content-center">
          <div><i class="fal fa-frown"></i></div>
          <div><i class="fal fa-smile"></i></div>
          <div><i class="fal fa-laugh-beam"></i></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$formextra = ob_get_clean();

 
}
 
/*

	4. DISPLAY EVERYTHING
	
*/

if($userdata->ID){
$comments_args = array(
	'class_form' 			=> '',
	'id_form' 				=> 'newcomment',
	'label_submit'			=> '',
	'comment_notes_before' 	=> '',
	'title_reply'			=> '', 
	'title_reply_before' 	=> '',
	'comment_notes_after' 	=> '',
	//'submit_field' 			=> '',
	'comment_field' 		=> "".$formextra.''.$commentfield.'',
	'logged_in_as' 			=> '',
);
?>

<!--msg model -->
<div class="comment-modal-wrap shadow hidepage" style="display:none;">
  <div class="comment-modal-wrap-overlay"></div>
  <div class="comment-modal-item">
    <div class="comment-modal-container">
      <div class="card-body">
        <div id="comments-ajax-all" style="max-height: 500px;    overflow: hidden;    overflow-y: scroll;"></div>
        <div id="commentsformbody"> <?php echo comment_form( $comments_args, $post->ID ); ?> </div>
        <a href="javascript:void(0);" onclick="jQuery('.comment-modal-wrap').fadeOut(400);" class="small"><?php echo __("Close Window","premiumpress"); ?></a> </div>
    </div>
  </div>
</div>
<?php

}else{

// LOGIN TO COMMENT
?>


<!--msg model -->
<div class="comment-modal-wrap shadow hidepage" style="display:none;">
  <div class="comment-modal-wrap-overlay"></div>
  <div class="comment-modal-item">
    <div class="comment-modal-container">
      <div class="card-body">
        <div id="comments-ajax-all" style="max-height: 500px;    overflow: hidden;    overflow-y: scroll;"></div>
        <div id="commentsformbody"> </div>
        <a href="javascript:void(0);" onclick="jQuery('.comment-modal-wrap').fadeOut(400);" class="small"><?php echo __("Close Window","premiumpress"); ?></a> </div>
    </div>
  </div>
</div>

<?php }  ?>
<script>

function processCommentPop(){
	 
jQuery("#comments-ajax-all").html('');	 
jQuery("#commentsformbody").show();	 
jQuery(".comment-modal-wrap").fadeIn(400);
   
}

function processCommentAll(){
 	
	jQuery("#comments-ajax-all").html('');
 	jQuery('#commentlistwrap .comment-single').each(function () {	
	 	  
		jQuery("#comments-ajax-all").html(jQuery("#comments-ajax-all").html() + '<div class="comment-single mb-4">'+jQuery(this).html()+'</div>' );	
	});
	jQuery("#commentsformbody").hide();
	jQuery(".comment-modal-wrap").fadeIn(400);
   
}

jQuery(document).ready(function(){ 

if(jQuery(".comment-single").length == 0){
	jQuery(".showcommentsbtn").hide();
}


jQuery("#commentcount").html(jQuery(".comment-single").length);

<?php if(!$allowNewComments){ ?>

if(jQuery(".comment-single").length == 0){
	jQuery('#sec-comments').hide();
}

<?php }elseif(isset($GLOBALS['flag-singlepage']) && $allowNewComments ){ ?>
 
!function(e){e.fn.jAutoCalc=function(t){var s={},u={sum:{rgx:"sum\\({([^}]+)}\\)",exec:function(t,r,s){return m=0,e(l(t),r).each(function(){n=1*o(e(this).val(),s),m+=n}),m}},avg:{rgx:"avg\\({([^}]+)}\\)",exec:function(t,r,s){return m=0,c=e(l(t),r).each(function(){n=1*o(e(this).val(),s),m+=n}).length,m/c}},min:{rgx:"min\\({([^}]+)}\\)",exec:function(t,r,n){return Math.min.apply(this,e(l(t),r).map(function(t,r){return o(e(r).val(),n)}).get())}},max:{rgx:"max\\({([^}]+)}\\)",exec:function(t,r,n){return Math.max.apply(this,e(l(t),r).map(function(t,r){return o(e(r).val(),n)}).get())}},count:{rgx:"count\\({([^}]+)}\\)",exec:function(t,r){return e(l(t),r).length}},countNotEmpty:{rgx:"countNotEmpty\\({([^}]+)}\\)",exec:function(t,r){return e.grep(e(l(t),r),function(t){return e(t).val()}).length}}},a=function(e){for(fields=new Array,r=/{([^}]+)}/gi;null!=(m=r.exec(e));)fields[fields.length]=m[1];return fields},l=function(e){return/^[a-zA-Z].*/.test(e)?':input[name="'+e+'"]':e},o=function(t,r){for(numValue="",numOpts=["0","1","2","3","4","5","6","7","8","9","-"],ch="",dec="",decLoc=-1,thou="",sym="",symLoc=-1,decPlaces=0,sepOpts=s.decimalOpts.concat(s.thousandOpts),z=t.length-1;z>=0;z--)ch=t.charAt(z),-1!=e.inArray(ch,numOpts)?numValue=ch+numValue:""==dec&&-1!=e.inArray(ch,s.decimalOpts)?(decLoc=z,dec=ch,numValue="."+numValue):""==thou&&-1!=e.inArray(ch,s.thousandOpts)?thou=ch:""!=sym||-1!=e.inArray(ch,sepOpts)||0!=z&&z!=t.length-1||(sym=ch,symLoc=z);return""!=dec&&(decPlaces=t.length-decLoc-1,symLoc>decLoc&&decPlaces--),-1!=s.decimalPlaces&&(decPlaces=s.decimalPlaces),2==arguments.length&&(""==r.dec&&""!=dec&&(r.dec=dec),(-1==r.decPlaces&&-1!=decPlaces||-1!=r.decPlaces&&-1!=decPlaces&&decPlaces<r.decPlaces)&&(r.decPlaces=decPlaces),""==r.thou&&""!=thou&&(r.thou=thou),""==r.sym&&""!=sym&&(r.sym=sym,r.symLoc=symLoc)),s.emptyAsZero&&""==numValue&&(numValue="0"),numValue},d=function(t,n,c,a){field="",fieldValue="",numValue="",resultvalue="";var d={dec:"",decPlaces:-1,thou:"",sym:"",symLoc:-1};for(func in u)for(f=u[func],r=new RegExp(f.rgx,"gi");null!=(m=r.exec(t));)v=f.exec(m[1],a,d),t=t.replace(new RegExp(f.rgx,"gi"),v);for(i=0;i<n.length;i++){if(field=n[i],fieldValue=e(l(field),a).val(),numValue=o(fieldValue,d),0==numValue.length)return void c.val("").change();t=t.replace(new RegExp("{"+field+"}","g"),numValue)}t=t.replace(/ /g,""),""==d.dec&&(d.dec=s.decimalOpts[0]),-1==d.decPlaces&&(d.decPlaces=0),""==d.thou&&(d.thou=s.thousandOpts[0]),resultValue=$(t),null==resultValue?resultValue="":resultValue=h(resultValue,d.decPlaces),resultValue=resultValue.replace(/\./g,"<c>"),resultValue=resultValue.replace(/\,/g,"<t>"),resultValue=resultValue.replace(/\<c\>/g,d.dec),resultValue=resultValue.replace(/\<t\>/g,d.thou),d.symLoc>-1&&(0==d.symLoc?resultValue=d.sym+resultValue:resultValue+=d.sym),s.smartIntegers&&(resultValue=resultValue.replace(/[\,\.]0+$/,"")),e.isFunction(s.onShowResult)&&(resultValue=s.onShowResult.call(this,c,resultValue)),c.val(resultValue),s.chainFire&&c.change()},h=function(e,t){for(n=e.toFixed(t)+"",x=n.split("."),x1=x[0],x2=x.length>1?"."+x[1]:"",rgx=/(\d+)(\d{3})/;rgx.test(x1);)x1=x1.replace(rgx,"$1,$2");return x1+x2},g={"+":{op:"+",precedence:10,assoc:"L",exec:function(e,t){return e+t}},"-":{op:"-",precedence:10,assoc:"L",exec:function(e,t){return e-t}},"*":{op:"*",precedence:20,assoc:"L",exec:function(e,t){return e*t}},"/":{op:"/",precedence:20,assoc:"L",exec:function(e,t){return e/t}},"**":{op:"**",precedence:30,assoc:"R",exec:function(e,t){return Math.pow(e,t)}}},p={e:Math.exp(1),pi:4*Math.atan2(1,1)},y=function(e){var t,r,n=e.offset;for(t=0;"0123456789".indexOf(e.string.substr(e.offset,1))>=0&&e.offset<e.string.length;)e.offset++;if("."==e.string.substr(e.offset,1))for(e.offset++;"0123456789".indexOf(e.string.substr(e.offset,1))>=0&&e.offset<e.string.length;)e.offset++;if(e.offset>n)return parseFloat(e.string.substr(n,e.offset-n));if("+"==e.string.substr(e.offset,1))return e.offset++,y(e);if("-"==e.string.substr(e.offset,1))return e.offset++,V(y(e));if("("==e.string.substr(e.offset,1)){if(e.offset++,t=b(e),")"==e.string.substr(e.offset,1))return e.offset++,t;throw e.error="Parsing error: ')' expected","parseError"}if(r=/^[a-z_][a-z0-9_]*/i.exec(e.string.substr(e.offset))){var s=r[0];if(e.offset+=s.length,s in p)return p[s];throw e.error="Semantic error: unknown variable '"+s+"'","unknownVar"}throw e.string.length==e.offset?(e.error="Parsing error at end of string: value expected","valueMissing"):(e.error="Parsing error: unrecognized value","valueNotParsed")},V=function(e){return-e},P=function(e){return"**"==e.string.substr(e.offset,2)?(e.offset+=2,g["**"]):"+-*/".indexOf(e.string.substr(e.offset,1))>=0?g[e.string.substr(e.offset++,1)]:null},b=function(e){for(var t,r=[{precedence:0,assoc:"L"}],n=y(e);;){for(t=P(e)||{precedence:0,assoc:"L"};t.precedence<r[r.length-1].precedence||t.precedence==r[r.length-1].precedence&&"L"==t.assoc;){var s=r.pop();if(!s.exec)return n;n=s.exec(s.value,n)}r.push({op:t.op,precedence:t.precedence,assoc:t.assoc,exec:t.exec,value:n}),n=y(e)}},$=function(e){var t={string:e,offset:0};try{var r=b(t);if(t.offset<t.string.length)throw t.error="Syntax error: junk found at offset "+t.offset,"trailingJunk";return r}catch(n){return void(s.showParseError&&alert(t.error+" ("+n+"):\n"+t.string.substr(0,t.offset)+"<*>"+t.string.substr(t.offset)))}},L=function(t){for(s=e.extend({},e.fn.jAutoCalc.defaults),i=0;i<t.length;i++)"object"==typeof t[i]&&(s=e.extend(s,t[i]));u=e.extend(u,s.funcs),p=e.extend(p,s.vars)},j={init:function(){return this.each(function(){$ctx=e(this),e("["+s.attribute+"]:not([_jac])",$ctx).each(function(){if($this=e(this),eq=$this.attr(s.attribute),fields=a(eq),0!=fields.length){for(i=0;i<fields.length;i++)if(0==e(l(fields[i]),$ctx).length)return;for(field="",name=$this.attr("name"),fireEvents="focus.jautocalc change.jautocalc blur.jautocalc",s.keyEventsFire&&(fireEvents+=" keyup.jautocalc keydown.jautocalc keypress.jautocalc"),i=0;i<fields.length;i++)field=fields[i],e(l(field),$ctx).bind(fireEvents,{equation:eq,equationFields:fields,result:$this,context:$ctx},function(e){d(e.data.equation,e.data.equationFields,e.data.result,e.data.context)});s.readOnlyResults&&$this.attr("readonly",!0),$this.attr("_jac","_jac"),s.initFire&&e(l(fields[0]),$ctx).change()}})})},destroy:function(){return this.each(function(){$ctx=e(this),e("["+s.attribute+"][_jac]",$ctx).each(function(){if($this=e(this),eq=$this.attr(s.attribute),fields=a(eq),0!=fields.length){for(field="",i=0;i<fields.length;i++)field=fields[i],e(l(field),$ctx).unbind(".jautocalc");s.readOnlyResults&&$this.removeAttr("readonly"),$this.removeAttr("_jac")}})})}};return L(arguments),j[t]?j[t].apply(this):j.init.apply(this)},e.fn.jAutoCalc.defaults={attribute:"data-form",thousandOpts:[",","."," "],decimalOpts:[".",","],decimalPlaces:-1,initFire:!0,chainFire:!0,keyEventsFire:!1,readOnlyResults:!0,showParseError:!0,emptyAsZero:!1,smartIntegers:!1,onShowResult:null,funcs:{},vars:{}}}(jQuery);
	
	jQuery( "form#newcomment" ).attr( "enctype", "multipart/form-data" ).attr( "encoding", "multipart/form-data" ).attr( "onsubmit", "return validateCommentForm();" );
	
 
	
   jQuery(".range-slider").ionRangeSlider({
        type: "double",
        keyboard: true
    });
	
    jQuery(".rate-range").ionRangeSlider({
        type: "single",
        hide_min_max: true,
    }); 

    jQuery("#ratingCalculate").jAutoCalc("destroy");
    jQuery("#ratingCalculate").jAutoCalc({
        initFire: true,
        decimalPlaces: 1,
        emptyAsZero: false,
		onShowResult: function( a, b ) {		 
		jQuery('.rating_avg').html(b);	
		jQuery('#rating-score').val(b);	
		
			 
			if(b == 5){		
			jQuery('.fa-frown').removeClass('thisone');
			jQuery('.fa-smile').removeClass('thisone');	
			jQuery('.fa-laugh-beam').addClass('thisone');		
			} else if (b > 2){	
			jQuery('.fa-frown').removeClass('thisone');
			jQuery('.fa-laugh-beam').removeClass('thisone');		
			jQuery('.fa-smile').addClass('thisone');		
			}else{		
			jQuery('.fa-laugh-beam').removeClass('thisone');
			jQuery('.fa-smile').removeClass('thisone');	
			jQuery('.fa-frown').addClass('thisone');
			} 
		}	
		
    });
	
<?php } ?>

});

function validateCommentForm(){

	 	var message = document.getElementById("comment");	 
      				
      	if(message.value == '')
      	{
      		alert("<?php echo __("Please enter a valid comment.","premiumpress") ?>");
      		message.focus();
      		message.style.border = 'thin solid red';
      		return false;
      	}
	 
      	if(message.value.length < 10)
      	{
      		alert("<?php echo __("Your comment is too short.","premiumpress") ?>");
      		message.focus();
      		message.style.border = 'thin solid red';
      		return false;
      	}
		
		return true;
}

function processrating(){

	  	

	jQuery('input[name$="rating-val"]').each(function(index,item){			
		var id = this.id;				  
		jQuery('#newcomment').append('<input type="hidden" name="'+id+'" value="'+jQuery('#'+id).val()+'">');						  
	});
 
	return
	
}

</script>
<?php } ?>