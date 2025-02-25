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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }  global $wpdb, $CORE;   ?>


</div>
</div>

</div><!-- end main body wrapper -->
 
<?php _ppt_template('framework/admin/_helpme' ); ?>


<script>
jQuery(document).ready(function() {	
	
	
	jQuery('[data-toggle="tooltip"]').tooltip({
                trigger: 'hover click focus',
                boundary: 'window'
    });
 
  

	// AUTO CLOSE WORDPRESS ADMIN
	document.body.className+=' folded'; 
	  
	// SET PAGE HEADER
	jQuery('#sidebar h1').html('<a href="#">AutoCoin</a>');

	// ADD SIDEBAR LINKS
	var i = 1;
	jQuery('.addjumplink').each(function(index,item){
		  var id = this.id;		  
		 	
			f = '<li><a href="#'+id+'" id="'+id+'-tab" data-targetdiv="'+id+'" class="nav-item nav-link" data-toggle="tab" role="tab" aria-controls="'+id+'" aria-selected="false"><i class="fa fa-chevron-right"></i>' + jQuery(this).data('title') + '</a></li>';
			//' + jQuery(this).data('icon') + '
			
			
			g = '<a href="#'+id+'" id="'+id+'-box" onclick="jQuery(\'.lefttab\').val(\''+ id +'\');closeHelpBoxWindow();"  data-targetdiv="'+id+'" class="col-12 col-md-6  mb-4 icon-box" style="text-decoration:none;"><div class="bg-white shadow-sm p-3 mr-2"><div class="row"><div class="col-3 pt-2 pl-3 text-center"><i class="fal ' + jQuery(this).data('icon') + ' fa-3x"></i></div><div class="col-7 pr-lg-4"><h5 class="mb-2 txt-500 text-dark">' + jQuery(this).data('title') + '</h5><p class="text-muted pb-0">' + jQuery(this).data('desc') + '</p></div><div class="col-2"><i class="fa fa-chevron-right mt-4 opacity-1" style="font-size: 48px;"></i></div></div></div></div></a>';
			
			
			jQuery('#overviewlist').append(g);
		 
		 
		 <?php if(isset($_GET['page']) &&  in_array($_GET['page'], array('settings','design','email','advertising','cart','docs','orders','cashout','listings','members','reports','customfields',"listingsetup","membershipsetup")) ){ ?>
		 
		  jQuery('.jumplinks-<?php echo esc_attr($_GET['page']); ?>').append(f);
		  
		 <?php }else{ ?> 
		 jQuery('#jumplinks').append(f);	
		 <?php } ?>
		 
		 	  
		  i++;
	 });
	  
	 // UPDATE MAIN PAGE DISPLAY
 	<?php if(isset($_GET['page']) && $_GET['page'] == "orders" && isset($_GET['eid'])){ ?> 
	 
	 jQuery('#add-tab').tab('show');
	 
	 <?php }elseif(isset($_GET['page']) && $_GET['page'] == "cashout" && isset($_GET['eid'])){ ?> 
	 
	 jQuery('#add-tab').tab('show');  
	 
 	<?php }elseif(isset($_GET['page']) && $_GET['page'] == "listings" && isset($_GET['eid'])){ ?> 
	 
	 jQuery('#add-tab').tab('show'); 	
	  
 	<?php }elseif(isset($_GET['page']) && $_GET['page'] == "reports" && isset($_GET['eid'])){ ?> 
	 
	 jQuery('#add-tab').tab('show'); 	 
 	
 	<?php }elseif(isset($_GET['page']) && $_GET['page'] == "advertising" && isset($_GET['eid'])){ ?> 
	 
	 jQuery('#add-tab').tab('show'); 	 
  	
	<?php }elseif(isset($_GET['page']) && $_GET['page'] == "members" && isset($_GET['eid'])){ ?> 
	 
	 jQuery('#add-tab').tab('show'); 
	 
	<?php }elseif(isset($_GET['page']) && $_GET['page'] == "email" && isset($_GET['eid'])){ ?> 
	 
	 jQuery('#add-tab').tab('show'); 
	 
	<?php }elseif(isset($_GET['page']) && $_GET['page'] == "cashback" && isset($_GET['eid'])){ ?> 
	 
	 jQuery('#add-tab').tab('show'); 
	  
		 
	 <?php }elseif(isset($_GET['page']) && ( $_GET['page'] == "premiumpress"  ) || isset($_GET['smallwindow'])  ){ ?> 
 	 	  
 	<?php }else{ ?>
 	
  	 //jQuery('#jumplinks li:first-child a').tab('show'); 	

	 jQuery('#content h2').hide();
	  <?php if(isset($_GET['page']) && $_GET['page'] == "plugins" ){ ?>
	  jQuery('#content').prepend('<h2><span><i class="fa fa-plug mr-2"></i> Plugins</span></h2>');	
	 <?php }else{ ?>	
	 jQuery('#content').prepend('<h2><span><i class="fa '+jQuery('.tab-content .tab-pane:first-child').data('icon')+' mr-2"></i> '+jQuery('.tab-content .tab-pane:first-child').data('title')+'</span></h2>');	 
  <?php } ?>
 	<?php } ?>	
	
	
	// ON JUMPLINK CHANGE ADD TITLE	
	jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	
	jQuery('#jumplinks .child li a').each(function () {		
		jQuery(this).removeClass('show active');	
	});
	 
	 var id = this.id;	
	 
	 jQuery(this).addClass('show active');
	 
	 tt = jQuery('#'+id).data('targetdiv');
	 jQuery('#content h2').hide();
	<?php if(isset($_GET['page']) && $_GET['page'] != "members" ){ ?>
	 jQuery('#content').prepend('<h2><span><i class="fa '+jQuery('#'+tt).data('icon')+' mr-2"></i> '+jQuery('#'+tt).data('title')+'</span></h2>');	
	 <?php } ?>
	 tinyScroll();
	    
	});
	
	
	// ON JUMPLINK CHANGE ADD TITLE	
	jQuery('.jumplinks-docs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	
	jQuery('#jumplinks .child li a').each(function () {		
		jQuery(this).removeClass('show active');	
	});
	 
	 var id = this.id;	
	 
	 jQuery(this).addClass('show active');
	 
	 tt = jQuery('#'+id).data('targetdiv');
	 jQuery('#content h2').hide();
	 
	 
	  
	 jQuery('#content').prepend('<h2><span><i class="fa '+jQuery('#'+tt).data('icon')+' mr-2"></i> '+jQuery('#'+tt).data('title')+'</span></h2>');	
	 
	 
	 tinyScroll();
	    
	});
	  
		
	//------------ Tab Displays
	jQuery('#myTab .nav-link').on('click', function() {		
			var self = jQuery(this);
			 var id = this.id;	
			jQuery('.tabinner').val(id);
			
	}); 
	
	<?php 
	if(isset($_POST['tabinner']) && $_POST['tabinner'] != ""){ ?>		 
		jQuery('#myTab a[href="#<?php echo str_replace("-tab","",$_POST['tabinner']); ?>"]').tab('show');		
	<?php } ?>		
		
	//------------ Tab Displays
	jQuery('#jumplinks .nav-link').on('click', function() {		
			var self = jQuery(this);
			 var id = this.id;			
			jQuery('.lefttab').val(id);
			
			closeHelpBoxWindow();
			
	}); 
	
	<?php 
	
	
	if(isset($_GET['testemail'])){
	?>
	jQuery('#jumplinks a[href="#sendemail"]').tab('show');
	<?php
	
	}elseif(isset($_GET['editpages'])){
	?>
	
	
	// REFRESH THE CHECKOUT PAGE
	setTimeout(function(){
	jQuery('#jumplinks a[href="#pagelinking"]').tab('show');
	}, 1000);
	
	<?php
	
	}elseif(isset($_POST['lefttab']) && $_POST['lefttab'] != ""){ ?>
			 
		jQuery('#jumplinks a[href="#<?php echo str_replace("#","",str_replace("-tab","",$_POST['lefttab'])); ?>"]').tab('show');		
		
		<?php }elseif(isset($_GET['lefttab']) && $_GET['lefttab'] != ""){ ?>		 
		jQuery('#jumplinks a[href="#<?php echo str_replace("#","",str_replace("-tab","",$_GET['lefttab'])); ?>"]').tab('show');		
		<?php } ?> 
		
		
		//------------ icon box
		jQuery('.icon-box').on('click', function (e) {
		var self = jQuery(this);
		 var id = this.id;	
		 tt = jQuery('#'+id).data('targetdiv');		 
		 jQuery('#jumplinks a[href="#'+tt+'"]').tab('show');	 		 
		});
		
		//------------ custom list
		jQuery('.customlist').on('click', function (e) {
	 
		var self = jQuery(this);
		 var id = this.id;	
		 tt = jQuery('#'+id).data('targetdiv');		 
		 jQuery('#jumplinks a[href="#'+tt+'"]').tab('show');	 		 
		});
				
		
		//------------ Accordian Tab Display
		jQuery('.accordion .btn-link').on('click', function() {
			var self = jQuery(this);
			jQuery('.ShowThisAccordianTab').val(jQuery(this).attr('data-target'));
			
		}); 	
		<?php if(isset($_POST['showaccordiantab']) && $_POST['showaccordiantab'] != ""){ ?>
		jQuery('<?php echo $_POST['showaccordiantab']; ?>').collapse();
		<?php } ?>
		
	
		<?php if(isset($_POST['tab']) && $_POST['tab'] != ""){ ?>
		// SET DEFAULT TAB IN
		jQuery('#MainTabs a[href="#<?php echo esc_attr($_POST['tab']); ?>"]').tab('show');		
		<?php }elseif(isset($_GET['tab']) && $_GET['tab'] != ""){ ?>
		// SET DEFAULT TAB IN		
		jQuery('#MainTabs a[href="#<?php echo esc_attr($_GET['tab']); ?>"]').tab('show');
		
		
		<?php } ?>
		
		
		// Toggle
		var off = false;
		var toggle = jQuery('.toggle');

		toggle.siblings().hide();
		toggle.show();
 
		jQuery('#content').on('click', '.toggle', function() {
			var self = jQuery(this);

			if (self.hasClass('on')) {
				self.siblings('.off').click();
				self.removeClass('on').addClass('off');
			} else {
				self.siblings('.on').click();
				self.removeClass('off').addClass('on');
			}
		});
		

 		
	// SIDEBAR NAV
	var fullHeight = function() {

		jQuery('.js-fullheight').css('height', jQuery(window).height());
		jQuery(window).resize(function(){
			jQuery('.js-fullheight').css('height', jQuery(window).height());
		});

	};
	fullHeight();

	jQuery('#sidebarCollapse').on('click', function () {
      jQuery('#sidebar').toggleClass('active');
  	});
  
  // NOW TURN OFF THE SPINNER  
  jQuery('#loading-spinnner').hide();
  jQuery('#premiumpress-body').show();
		
		
		// COLOR PICKER
	  <?php if(isset($_GET['page']) && $_GET['page'] == "design" ){ ?>
		jQuery('.myColorPicker').colorPickerByGiro({
			preview: '.myColorPicker-preview'
		});
	 <?php } ?>	

});

	function showfilersbar(){  
		
		jQuery('#filters-extra').toggle();
		jQuery('#filterssidebox').toggle();
	 
	}
	function showactionsbar(){  
		
		jQuery('#actionsbox').toggle();
	 
	}
	
	 
	function doselectall(){
		
		jQuery('#actionsbox').show();
		
		jQuery('.checkbox1').each(function() {
		
			if(this.checked) { 
				this.checked = false;
			}else{
				this.checked = true; 
			} 
		
		});
	}
  
  


 
function showthispage(k){

 
	jQuery('#buttonarea').toggle().html('<a href="javascript:void(0);" onclick="showthispage(\''+ k +'\');" class="btn btn-dark mt-5 btn-sm text-left"><i class="fa fa-arrow-left mr-3" aria-hidden="true"></i> Go Back</a>');
	jQuery('#logoarea').toggle();
	jQuery('#mainsection').toggle();
	jQuery('#'+k).toggle();

}


jQuery(window).on('load',function () {
	jQuery('.confirm').click(function(e)
	{
		if(confirm("Are you sure?"))
		{
		   
		
		}
		else
		{
			 alert('Phew! That was close!');
			e.preventDefault();
		}
	});
});


<?php if(isset($_POST['tab']) && $_POST['tab'] != ""){ ?>
showthispage("<?php echo $_POST['tab']; ?>");
<?php } ?>

</script>






<?php if(isset($GLOBALS['ppt_error']) ){ ?>

<script>
 
jQuery(document).ready(function() {
	notify({
		type: "<?php echo $GLOBALS['ppt_error']['type']; ?>", //alert | success | error | warning | info
        title: "<?php echo $GLOBALS['ppt_error']['title']; ?>",
		position: {
         x: "right", //right | left | center
         y: "top" //top | bottom | center
        },
        icon: '<i class="fal <?php if($GLOBALS['ppt_error']['type'] == "success"){ echo "fa-check"; }else{ echo "fa-exclamation-triangle"; } ?>"></i>',
        message: "<?php if(isset($GLOBALS['ppt_error'])){ echo $GLOBALS['ppt_error']['message'];} ?>&nbsp;"
	});
});
		   
</script>
<?php } ?>


<?php if($CORE->GEO("is_right_to_left", array() )){ ?>
<script>
jQuery(document).ready(function(){ 
     //jQuery("html[lang=ar]").attr("dir", "rtl").find("body").addClass("rtl right-to-left");
	 
});
</script>
<?php } ?>


<?php if(isset($_GET['page']) && $_GET['page'] != 3 && $_GET['page'] != "add" &&  $_GET['page'] != "listings"){ ?>
<!-- FILE UPLOAD FUNCTION --->
<input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
<input type="hidden" value="" name="imgAID" id="imgAID" />
<input type="hidden" value="" name="imgPreviewID" id="imgPreviewID" />
<script >
function ChangeImgBlock(divname){
	document.getElementById("imgIdblock").value = divname;
}
function ChangeAIDBlock(divname){
	document.getElementById("imgAID").value = divname;
}
function ChangeImgPreviewBlock(divname){
	document.getElementById("imgPreviewID").value = divname;
}
jQuery(document).ready(function() {
 
	window.send_to_editor = function(html) {			
	
	var regex = /src="(.+?)"/;
    var rslt =html.match(regex);
 	 
	var imgrex = /wp-image-(.+?)"/;
    var imgid = html.match(imgrex);
 
    var imgurl = rslt[1];
	var imgaid = imgid[1];
	
	jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
	jQuery('#'+document.getElementById("imgAID").value).val(imgaid);
	jQuery('#'+document.getElementById("imgPreviewID").value).attr("src", imgurl ); 
	 
	 tb_remove();
	 <?php //if(isset($_GET['page']) && $_GET['page'] == "design"){ ?>
	 document.admin_save_form.submit();
	 <?php //} ?>
	 
	}
}); 
</script>
<!--- END FILE UPLOAD FUNCTION -->
<?php } ?>


<?php if(isset($_GET['page']) &&  in_array($_GET['page'], array('settings','listingsetup','membershipsetup')) ){ ?>
<script>
/*  ICON BOX */
	jQuery(".login-modal-close, .login-modal-wrap-overlay").on("click", function (e) {
        jQuery(".login-modal-wrap").fadeOut(400);		
    });
	
function loadiconbox(div, current_icon){

	jQuery(".login-modal-wrap").fadeIn(400);
	
	jQuery('#icon_divid_save').val(div);
	jQuery('#icon_divid_save_currenticon').val(current_icon);

}
function processIconSelect(icon){

	 
	jQuery("#"+jQuery('#icon_divid_save').val()).val(icon);
	
	jQuery("#"+jQuery('#icon_divid_save').val()+'_icon').removeClass(jQuery('#icon_divid_save_currenticon').val()).addClass(icon);
	
	jQuery(".login-modal-wrap").fadeOut(400);
 
}
</script>
<!--login modal -->
<input type="hidden" id="icon_divid_save" value="" />
<input type="hidden" id="icon_divid_save_currenticon" value="" />
<div class="login-modal-wrap shadow hidepage" style="display:none;">
  <div class="login-modal-wrap-overlay"></div>
  <div class="login-modal-item"  style=" max-width:1200px;top:5%;">
    <div class="login-modal-container"> 
      <div class="card-body"> 

<?php
		$font_awesome_icons = array (
        'fab fa-500px' =>  '500px',
        'fab fa-accessible-icon' =>  'accessible-icon',
        'fab fa-accusoft' =>  'accusoft',
        'fa fa-address-book' =>  'address-book',
        'far fa-address-book' =>  'address-book',
        'fa fa-address-card' =>  'address-card',
        'far fa-address-card' =>  'address-card',
        'fa fa-adjust' =>  'adjust',
        'fab fa-adn' =>  'adn',
        'fab fa-adversal' =>  'adversal',
        'fab fa-affiliatetheme' =>  'affiliatetheme',
        'fab fa-algolia' =>  'algolia',
        'fa fa-align-center' =>  'align-center',
        'fa fa-align-justify' =>  'align-justify',
        'fa fa-align-left' =>  'align-left',
        'fa fa-align-right' =>  'align-right',
        'fa fa-allergies' =>  'allergies',
        'fab fa-amazon' =>  'amazon',
        'fab fa-amazon-pay' =>  'amazon-pay',
        'fa fa-ambulance' =>  'ambulance',
        'fa fa-american-sign-language-interpreting' =>  'american-sign-language-interpreting',
        'fab fa-amilia' =>  'amilia',
        'fa fa-anchor' =>  'anchor',
        'fab fa-android' =>  'android',
        'fab fa-angellist' =>  'angellist',
        'fa fa-angle-double-down' =>  'angle-double-down',
        'fa fa-angle-double-left' =>  'angle-double-left',
        'fa fa-angle-double-right' =>  'angle-double-right',
        'fa fa-angle-double-up' =>  'angle-double-up',
        'fa fa-angle-down' =>  'angle-down',
        'fa fa-angle-left' =>  'angle-left',
        'fa fa-angle-right' =>  'angle-right',
        'fa fa-angle-up' =>  'angle-up',
        'fab fa-angrycreative' =>  'angrycreative',
        'fab fa-angular' =>  'angular',
        'fab fa-app-store' =>  'app-store',
        'fab fa-app-store-ios' =>  'app-store-ios',
        'fab fa-apper' =>  'apper',
        'fab fa-apple' =>  'apple',
        'fab fa-apple-pay' =>  'apple-pay',
        'fa fa-archive' =>  'archive',
        'fa fa-arrow-alt-circle-down' =>  'arrow-alt-circle-down',
        'far fa-arrow-alt-circle-down' =>  'arrow-alt-circle-down',
        'fa fa-arrow-alt-circle-left' =>  'arrow-alt-circle-left',
        'far fa-arrow-alt-circle-left' =>  'arrow-alt-circle-left',
        'fa fa-arrow-alt-circle-right' =>  'arrow-alt-circle-right',
        'far fa-arrow-alt-circle-right' =>  'arrow-alt-circle-right',
        'fa fa-arrow-alt-circle-up' =>  'arrow-alt-circle-up',
        'far fa-arrow-alt-circle-up' =>  'arrow-alt-circle-up',
        'fa fa-arrow-circle-down' =>  'arrow-circle-down',
        'fa fa-arrow-circle-left' =>  'arrow-circle-left',
        'fa fa-arrow-circle-right' =>  'arrow-circle-right',
        'fa fa-arrow-circle-up' =>  'arrow-circle-up',
        'fa fa-arrow-down' =>  'arrow-down',
        'fa fa-arrow-left' =>  'arrow-left',
        'fa fa-arrow-right' =>  'arrow-right',
        'fa fa-arrow-up' =>  'arrow-up',
        'fa fa-arrows-alt' =>  'arrows-alt',
        'fa fa-arrows-alt-h' =>  'arrows-alt-h',
        'fa fa-arrows-alt-v' =>  'arrows-alt-v',
        'fa fa-assistive-listening-systems' =>  'assistive-listening-systems',
        'fa fa-asterisk' =>  'asterisk',
        'fab fa-asymmetrik' =>  'asymmetrik',
        'fa fa-at' =>  'at',
        'fab fa-audible' =>  'audible',
        'fa fa-audio-description' =>  'audio-description',
        'fab fa-autoprefixer' =>  'autoprefixer',
        'fab fa-avianex' =>  'avianex',
        'fab fa-aviato' =>  'aviato',
        'fab fa-aws' =>  'aws',
        'fa fa-backward' =>  'backward',
        'fa fa-balance-scale' =>  'balance-scale',
        'fa fa-ban' =>  'ban',
        'fa fa-band-aid' =>  'band-aid',
        'fab fa-bandcamp' =>  'bandcamp',
        'fa fa-barcode' =>  'barcode',
        'fa fa-bars' =>  'bars',
        'fa fa-baseball-ball' =>  'baseball-ball',
        'fa fa-basketball-ball' =>  'basketball-ball',
        'fa fa-bath' =>  'bath',
        'fa fa-battery-empty' =>  'battery-empty',
        'fa fa-battery-full' =>  'battery-full',
        'fa fa-battery-half' =>  'battery-half',
        'fa fa-battery-quarter' =>  'battery-quarter',
        'fa fa-battery-three-quarters' =>  'battery-three-quarters',
        'fa fa-bed' =>  'bed',
        'fa fa-beer' =>  'beer',
        'fab fa-behance' =>  'behance',
        'fab fa-behance-square' =>  'behance-square',
        'fa fa-bell' =>  'bell',
        'far fa-bell' =>  'bell',
        'fa fa-bell-slash' =>  'bell-slash',
        'far fa-bell-slash' =>  'bell-slash',
        'fa fa-bicycle' =>  'bicycle',
        'fab fa-bimobject' =>  'bimobject',
        'fa fa-binoculars' =>  'binoculars',
        'fa fa-birthday-cake' =>  'birthday-cake',
        'fab fa-bitbucket' =>  'bitbucket',
        'fab fa-bitcoin' =>  'bitcoin',
        'fab fa-bity' =>  'bity',
        'fab fa-black-tie' =>  'black-tie',
        'fab fa-blackberry' =>  'blackberry',
        'fa fa-blind' =>  'blind',
        'fab fa-blogger' =>  'blogger',
        'fab fa-blogger-b' =>  'blogger-b',
        'fab fa-bluetooth' =>  'bluetooth',
        'fab fa-bluetooth-b' =>  'bluetooth-b',
        'fa fa-bold' =>  'bold',
        'fa fa-bolt' =>  'bolt',
        'fa fa-bomb' =>  'bomb',
        'fa fa-book' =>  'book',
        'fa fa-bookmark' =>  'bookmark',
        'far fa-bookmark' =>  'bookmark',
        'fa fa-bowling-ball' =>  'bowling-ball',
        'fa fa-box' =>  'box',
        'fa fa-box-open' =>  'box-open',
        'fa fa-boxes' =>  'boxes',
        'fa fa-braille' =>  'braille',
        'fa fa-briefcase' =>  'briefcase',
        'fa fa-briefcase-medical' =>  'briefcase-medical',
        'fab fa-btc' =>  'btc',
        'fa fa-bug' =>  'bug',
        'fa fa-building' =>  'building',
        'far fa-building' =>  'building',
        'fa fa-bullhorn' =>  'bullhorn',
        'fa fa-bullseye' =>  'bullseye',
        'fa fa-burn' =>  'burn',
        'fab fa-buromobelexperte' =>  'buromobelexperte',
        'fa fa-bus' =>  'bus',
        'fab fa-buysellads' =>  'buysellads',
        'fa fa-calculator' =>  'calculator',
        'fa fa-calendar' =>  'calendar',
        'far fa-calendar' =>  'calendar',
        'fa fa-calendar-alt' =>  'calendar-alt',
        'far fa-calendar-alt' =>  'calendar-alt',
        'fa fa-calendar-check' =>  'calendar-check',
        'far fa-calendar-check' =>  'calendar-check',
        'fa fa-calendar-minus' =>  'calendar-minus',
        'far fa-calendar-minus' =>  'calendar-minus',
        'fa fa-calendar-plus' =>  'calendar-plus',
        'far fa-calendar-plus' =>  'calendar-plus',
        'fa fa-calendar-times' =>  'calendar-times',
        'far fa-calendar-times' =>  'calendar-times',
        'fa fa-camera' =>  'camera',
        'fa fa-camera-retro' =>  'camera-retro',
        'fa fa-capsules' =>  'capsules',
        'fa fa-car' =>  'car',
        'fa fa-caret-down' =>  'caret-down',
        'fa fa-caret-left' =>  'caret-left',
        'fa fa-caret-right' =>  'caret-right',
        'fa fa-caret-square-down' =>  'caret-square-down',
        'far fa-caret-square-down' =>  'caret-square-down',
        'fa fa-caret-square-left' =>  'caret-square-left',
        'far fa-caret-square-left' =>  'caret-square-left',
        'fa fa-caret-square-right' =>  'caret-square-right',
        'far fa-caret-square-right' =>  'caret-square-right',
        'fa fa-caret-square-up' =>  'caret-square-up',
        'far fa-caret-square-up' =>  'caret-square-up',
        'fa fa-caret-up' =>  'caret-up',
        'fa fa-cart-arrow-down' =>  'cart-arrow-down',
        'fa fa-cart-plus' =>  'cart-plus',
        'fab fa-cc-amazon-pay' =>  'cc-amazon-pay',
        'fab fa-cc-amex' =>  'cc-amex',
        'fab fa-cc-apple-pay' =>  'cc-apple-pay',
        'fab fa-cc-diners-club' =>  'cc-diners-club',
        'fab fa-cc-discover' =>  'cc-discover',
        'fab fa-cc-jcb' =>  'cc-jcb',
        'fab fa-cc-mastercard' =>  'cc-mastercard',
        'fab fa-cc-paypal' =>  'cc-paypal',
        'fab fa-cc-stripe' =>  'cc-stripe',
        'fab fa-cc-visa' =>  'cc-visa',
        'fab fa-centercode' =>  'centercode',
        'fa fa-certificate' =>  'certificate',
        'fa fa-chart-area' =>  'chart-area',
        'fa fa-chart-bar' =>  'chart-bar',
        'far fa-chart-bar' =>  'chart-bar',
        'fa fa-chart-line' =>  'chart-line',
        'fa fa-chart-pie' =>  'chart-pie',
        'fa fa-check' =>  'check',
        'fa fa-check-circle' =>  'check-circle',
        'far fa-check-circle' =>  'check-circle',
        'fa fa-check-square' =>  'check-square',
        'far fa-check-square' =>  'check-square',
        'fa fa-chess' =>  'chess',
        'fa fa-chess-bishop' =>  'chess-bishop',
        'fa fa-chess-board' =>  'chess-board',
        'fa fa-chess-king' =>  'chess-king',
        'fa fa-chess-knight' =>  'chess-knight',
        'fa fa-chess-pawn' =>  'chess-pawn',
        'fa fa-chess-queen' =>  'chess-queen',
        'fa fa-chess-rook' =>  'chess-rook',
        'fa fa-chevron-circle-down' =>  'chevron-circle-down',
        'fa fa-chevron-circle-left' =>  'chevron-circle-left',
        'fa fa-chevron-circle-right' =>  'chevron-circle-right',
        'fa fa-chevron-circle-up' =>  'chevron-circle-up',
        'fa fa-chevron-down' =>  'chevron-down',
        'fa fa-chevron-left' =>  'chevron-left',
        'fa fa-chevron-right' =>  'chevron-right',
        'fa fa-chevron-up' =>  'chevron-up',
        'fa fa-child' =>  'child',
        'fab fa-chrome' =>  'chrome',
        'fa fa-circle' =>  'circle',
        'far fa-circle' =>  'circle',
        'fa fa-circle-notch' =>  'circle-notch',
        'fa fa-clipboard' =>  'clipboard',
        'far fa-clipboard' =>  'clipboard',
        'fa fa-clipboard-check' =>  'clipboard-check',
        'fa fa-clipboard-list' =>  'clipboard-list',
        'fa fa-clock' =>  'clock',
        'far fa-clock' =>  'clock',
        'fa fa-clone' =>  'clone',
        'far fa-clone' =>  'clone',
        'fa fa-closed-captioning' =>  'closed-captioning',
        'far fa-closed-captioning' =>  'closed-captioning',
        'fa fa-cloud' =>  'cloud',
        'fa fa-cloud-download-alt' =>  'cloud-download-alt',
        'fa fa-cloud-upload-alt' =>  'cloud-upload-alt',
        'fab fa-cloudscale' =>  'cloudscale',
        'fab fa-cloudsmith' =>  'cloudsmith',
        'fab fa-cloudversify' =>  'cloudversify',
        'fa fa-code' =>  'code',
        'fa fa-code-branch' =>  'code-branch',
        'fab fa-codepen' =>  'codepen',
        'fab fa-codiepie' =>  'codiepie',
        'fa fa-coffee' =>  'coffee',
        'fa fa-cog' =>  'cog',
        'fa fa-cogs' =>  'cogs',
        'fa fa-columns' =>  'columns',
        'fa fa-comment' =>  'comment',
        'far fa-comment' =>  'comment',
        'fa fa-comment-alt' =>  'comment-alt',
        'far fa-comment-alt' =>  'comment-alt',
        'fa fa-comment-dots' =>  'comment-dots',
        'fa fa-comment-slash' =>  'comment-slash',
        'fa fa-comments' =>  'comments',
        'far fa-comments' =>  'comments',
        'fa fa-compass' =>  'compass',
        'far fa-compass' =>  'compass',
        'fa fa-compress' =>  'compress',
        'fab fa-connectdevelop' =>  'connectdevelop',
        'fab fa-contao' =>  'contao',
        'fa fa-copy' =>  'copy',
        'far fa-copy' =>  'copy',
        'fa fa-copyright' =>  'copyright',
        'far fa-copyright' =>  'copyright',
        'fa fa-couch' =>  'couch',
        'fab fa-cpanel' =>  'cpanel',
        'fab fa-creative-commons' =>  'creative-commons',
        'fa fa-credit-card' =>  'credit-card',
        'far fa-credit-card' =>  'credit-card',
        'fa fa-crop' =>  'crop',
        'fa fa-crosshairs' =>  'crosshairs',
        'fab fa-css3' =>  'css3',
        'fab fa-css3-alt' =>  'css3-alt',
        'fa fa-cube' =>  'cube',
        'fa fa-cubes' =>  'cubes',
        'fa fa-cut' =>  'cut',
        'fab fa-cuttlefish' =>  'cuttlefish',
        'fab fa-d-and-d' =>  'd-and-d',
        'fab fa-dashcube' =>  'dashcube',
        'fa fa-database' =>  'database',
        'fa fa-deaf' =>  'deaf',
        'fab fa-delicious' =>  'delicious',
        'fab fa-deploydog' =>  'deploydog',
        'fab fa-deskpro' =>  'deskpro',
        'fa fa-desktop' =>  'desktop',
        'fab fa-deviantart' =>  'deviantart',
        'fa fa-diagnoses' =>  'diagnoses',
        'fab fa-digg' =>  'digg',
        'fab fa-digital-ocean' =>  'digital-ocean',
        'fab fa-discord' =>  'discord',
        'fab fa-discourse' =>  'discourse',
        'fa fa-dna' =>  'dna',
        'fab fa-dochub' =>  'dochub',
        'fab fa-docker' =>  'docker',
        'fa fa-dollar-sign' =>  'dollar-sign',
        'fa fa-dolly' =>  'dolly',
        'fa fa-dolly-flatbed' =>  'dolly-flatbed',
        'fa fa-donate' =>  'donate',
        'fa fa-dot-circle' =>  'dot-circle',
        'far fa-dot-circle' =>  'dot-circle',
        'fa fa-dove' =>  'dove',
        'fa fa-download' =>  'download',
        'fab fa-draft2digital' =>  'draft2digital',
        'fab fa-dribbble' =>  'dribbble',
        'fab fa-dribbble-square' =>  'dribbble-square',
        'fab fa-dropbox' =>  'dropbox',
        'fab fa-drupal' =>  'drupal',
        'fab fa-dyalog' =>  'dyalog',
        'fab fa-earlybirds' =>  'earlybirds',
        'fab fa-edge' =>  'edge',
        'fa fa-edit' =>  'edit',
        'far fa-edit' =>  'edit',
        'fa fa-eject' =>  'eject',
        'fab fa-elementor' =>  'elementor',
        'fa fa-ellipsis-h' =>  'ellipsis-h',
        'fa fa-ellipsis-v' =>  'ellipsis-v',
        'fab fa-ember' =>  'ember',
        'fab fa-empire' =>  'empire',
        'fa fa-envelope' =>  'envelope',
        'far fa-envelope' =>  'envelope',
        'fa fa-envelope-open' =>  'envelope-open',
        'far fa-envelope-open' =>  'envelope-open',
        'fa fa-envelope-square' =>  'envelope-square',
        'fab fa-envira' =>  'envira',
        'fa fa-eraser' =>  'eraser',
        'fab fa-erlang' =>  'erlang',
        'fab fa-ethereum' =>  'ethereum',
        'fab fa-etsy' =>  'etsy',
        'fa fa-euro-sign' =>  'euro-sign',
        'fa fa-exchange-alt' =>  'exchange-alt',
        'fa fa-exclamation' =>  'exclamation',
        'fa fa-exclamation-circle' =>  'exclamation-circle',
        'fa fa-exclamation-triangle' =>  'exclamation-triangle',
        'fa fa-expand' =>  'expand',
        'fa fa-expand-arrows-alt' =>  'expand-arrows-alt',
        'fab fa-expeditedssl' =>  'expeditedssl',
        'fa fa-external-link-alt' =>  'external-link-alt',
        'fa fa-external-link-square-alt' =>  'external-link-square-alt',
        'fa fa-eye' =>  'eye',
        'fa fa-eye-dropper' =>  'eye-dropper',
        'fa fa-eye-slash' =>  'eye-slash',
        'far fa-eye-slash' =>  'eye-slash',
        'fab fa-facebook' =>  'facebook',
        'fab fa-facebook-f' =>  'facebook-f',
        'fab fa-facebook-messenger' =>  'facebook-messenger',
        'fab fa-facebook-square' =>  'facebook-square',
        'fa fa-fast-backward' =>  'fast-backward',
        'fa fa-fast-forward' =>  'fast-forward',
        'fa fa-fax' =>  'fax',
        'fa fa-female' =>  'female',
        'fa fa-fighter-jet' =>  'fighter-jet',
        'fa fa-file' =>  'file',
        'far fa-file' =>  'file',
        'fa fa-file-alt' =>  'file-alt',
        'far fa-file-alt' =>  'file-alt',
        'fa fa-file-archive' =>  'file-archive',
        'far fa-file-archive' =>  'file-archive',
        'fa fa-file-audio' =>  'file-audio',
        'far fa-file-audio' =>  'file-audio',
        'fa fa-file-code' =>  'file-code',
        'far fa-file-code' =>  'file-code',
        'fa fa-file-excel' =>  'file-excel',
        'far fa-file-excel' =>  'file-excel',
        'fa fa-file-image' =>  'file-image',
        'far fa-file-image' =>  'file-image',
        'fa fa-file-medical' =>  'file-medical',
        'fa fa-file-medical-alt' =>  'file-medical-alt',
        'fa fa-file-pdf' =>  'file-pdf',
        'far fa-file-pdf' =>  'file-pdf',
        'fa fa-file-powerpoint' =>  'file-powerpoint',
        'far fa-file-powerpoint' =>  'file-powerpoint',
        'fa fa-file-video' =>  'file-video',
        'far fa-file-video' =>  'file-video',
        'fa fa-file-word' =>  'file-word',
        'far fa-file-word' =>  'file-word',
        'fa fa-film' =>  'film',
        'fa fa-filter' =>  'filter',
        'fa fa-fire' =>  'fire',
        'fa fa-fire-extinguisher' =>  'fire-extinguisher',
        'fab fa-firefox' =>  'firefox',
        'fa fa-first-aid' =>  'first-aid',
        'fab fa-first-order' =>  'first-order',
        'fab fa-firstdraft' =>  'firstdraft',
        'fa fa-flag' =>  'flag',
        'far fa-flag' =>  'flag',
        'fa fa-flag-checkered' =>  'flag-checkered',
        'fa fa-flask' =>  'flask',
        'fab fa-flickr' =>  'flickr',
        'fab fa-flipboard' =>  'flipboard',
        'fab fa-fly' =>  'fly',
        'fa fa-folder' =>  'folder',
        'far fa-folder' =>  'folder',
        'fa fa-folder-open' =>  'folder-open',
        'far fa-folder-open' =>  'folder-open',
        'fa fa-font' =>  'font',
        'fab fa-font-awesome' =>  'font-awesome',
        'fab fa-font-awesome-alt' =>  'font-awesome-alt',
        'fab fa-font-awesome-flag' =>  'font-awesome-flag',
        'fab fa-fonticons' =>  'fonticons',
        'fab fa-fonticons-fi' =>  'fonticons-fi',
        'fa fa-football-ball' =>  'football-ball',
        'fab fa-fort-awesome' =>  'fort-awesome',
        'fab fa-fort-awesome-alt' =>  'fort-awesome-alt',
        'fab fa-forumbee' =>  'forumbee',
        'fa fa-forward' =>  'forward',
        'fab fa-foursquare' =>  'foursquare',
        'fab fa-free-code-camp' =>  'free-code-camp',
        'fab fa-freebsd' =>  'freebsd',
        'fa fa-frown' =>  'frown',
        'far fa-frown' =>  'frown',
        'fa fa-futbol' =>  'futbol',
        'far fa-futbol' =>  'futbol',
        'fa fa-gamepad' =>  'gamepad',
        'fa fa-gavel' =>  'gavel',
        'fa fa-gem' =>  'gem',
        'far fa-gem' =>  'gem',
        'fa fa-genderless' =>  'genderless',
        'fab fa-get-pocket' =>  'get-pocket',
        'fab fa-gg' =>  'gg',
        'fab fa-gg-circle' =>  'gg-circle',
        'fa fa-gift' =>  'gift',
        'fab fa-git' =>  'git',
        'fab fa-git-square' =>  'git-square',
        'fab fa-github' =>  'github',
        'fab fa-github-alt' =>  'github-alt',
        'fab fa-github-square' =>  'github-square',
        'fab fa-gitkraken' =>  'gitkraken',
        'fab fa-gitlab' =>  'gitlab',
        'fab fa-gitter' =>  'gitter',
        'fa fa-glass-martini' =>  'glass-martini',
        'fab fa-glide' =>  'glide',
        'fab fa-glide-g' =>  'glide-g',
        'fa fa-globe' =>  'globe',
        'fab fa-gofore' =>  'gofore',
        'fa fa-golf-ball' =>  'golf-ball',
        'fab fa-goodreads' =>  'goodreads',
        'fab fa-goodreads-g' =>  'goodreads-g',
        'fab fa-google' =>  'google',
        'fab fa-google-drive' =>  'google-drive',
        'fab fa-google-play' =>  'google-play',
        'fab fa-google-plus' =>  'google-plus',
        'fab fa-google-plus-g' =>  'google-plus-g',
        'fab fa-google-plus-square' =>  'google-plus-square',
        'fab fa-google-wallet' =>  'google-wallet',
        'fa fa-graduation-cap' =>  'graduation-cap',
        'fab fa-gratipay' =>  'gratipay',
        'fab fa-grav' =>  'grav',
        'fab fa-gripfire' =>  'gripfire',
        'fab fa-grunt' =>  'grunt',
        'fab fa-gulp' =>  'gulp',
        'fa fa-h-square' =>  'h-square',
        'fab fa-hacker-news' =>  'hacker-news',
        'fab fa-hacker-news-square' =>  'hacker-news-square',
        'fa fa-hand-holding' =>  'hand-holding',
        'fa fa-hand-holding-heart' =>  'hand-holding-heart',
        'fa fa-hand-holding-usd' =>  'hand-holding-usd',
        'fa fa-hand-lizard' =>  'hand-lizard',
        'far fa-hand-lizard' =>  'hand-lizard',
        'fa fa-hand-paper' =>  'hand-paper',
        'far fa-hand-paper' =>  'hand-paper',
        'fa fa-hand-peace' =>  'hand-peace',
        'far fa-hand-peace' =>  'hand-peace',
        'fa fa-hand-point-down' =>  'hand-point-down',
        'far fa-hand-point-down' =>  'hand-point-down',
        'fa fa-hand-point-left' =>  'hand-point-left',
        'far fa-hand-point-left' =>  'hand-point-left',
        'fa fa-hand-point-right' =>  'hand-point-right',
        'far fa-hand-point-right' =>  'hand-point-right',
        'fa fa-hand-point-up' =>  'hand-point-up',
        'far fa-hand-point-up' =>  'hand-point-up',
        'fa fa-hand-pointer' =>  'hand-pointer',
        'far fa-hand-pointer' =>  'hand-pointer',
        'fa fa-hand-rock' =>  'hand-rock',
        'far fa-hand-rock' =>  'hand-rock',
        'fa fa-hand-scissors' =>  'hand-scissors',
        'far fa-hand-scissors' =>  'hand-scissors',
        'fa fa-hand-spock' =>  'hand-spock',
        'far fa-hand-spock' =>  'hand-spock',
        'fa fa-hands' =>  'hands',
        'fa fa-hands-helping' =>  'hands-helping',
        'fa fa-handshake' =>  'handshake',
        'far fa-handshake' =>  'handshake',
        'fa fa-hashtag' =>  'hashtag',

        'fa fa-hdd' =>  'hdd',
        'far fa-hdd' =>  'hdd',
        'fa fa-heading' =>  'heading',
        'fa fa-headphones' =>  'headphones',
        'fa fa-heart' =>  'heart',
        'far fa-heart' =>  'heart',
        'fa fa-heartbeat' =>  'heartbeat',
        'fab fa-hips' =>  'hips',
        'fab fa-hire-a-helper' =>  'hire-a-helper',
        'fa fa-history' =>  'history',
        'fa fa-hockey-puck' =>  'hockey-puck',
        'fa fa-home' =>  'home',
        'fab fa-hooli' =>  'hooli',
        'fa fa-hospital' =>  'hospital',
        'far fa-hospital' =>  'hospital',
        'fa fa-hospital-alt' =>  'hospital-alt',
        'fa fa-hospital-symbol' =>  'hospital-symbol',
        'fab fa-hotjar' =>  'hotjar',
        'fa fa-hourglass' =>  'hourglass',
        'far fa-hourglass' =>  'hourglass',
        'fa fa-hourglass-end' =>  'hourglass-end',
        'fa fa-hourglass-half' =>  'hourglass-half',
        'fa fa-hourglass-start' =>  'hourglass-start',
        'fab fa-houzz' =>  'houzz',
        'fab fa-html5' =>  'html5',
        'fab fa-hubspot' =>  'hubspot',
        'fa fa-i-cursor' =>  'i-cursor',
        'fa fa-id-badge' =>  'id-badge',
        'far fa-id-badge' =>  'id-badge',
        'fa fa-id-card' =>  'id-card',
        'far fa-id-card' =>  'id-card',
        'fa fa-id-card-alt' =>  'id-card-alt',
        'fa fa-image' =>  'image',
        'far fa-image' =>  'image',
        'fa fa-images' =>  'images',
        'far fa-images' =>  'images',
        'fab fa-imdb' =>  'imdb',
        'fa fa-inbox' =>  'inbox',
        'fa fa-indent' =>  'indent',
        'fa fa-industry' =>  'industry',
        'fa fa-info' =>  'info',
        'fa fa-info-circle' =>  'info-circle',
        'fab fa-instagram' =>  'instagram',
        'fab fa-internet-explorer' =>  'internet-explorer',
        'fab fa-ioxhost' =>  'ioxhost',
        'fa fa-italic' =>  'italic',
        'fab fa-itunes' =>  'itunes',
        'fab fa-itunes-note' =>  'itunes-note',
        'fab fa-java' =>  'java',
        'fab fa-jenkins' =>  'jenkins',
        'fab fa-joget' =>  'joget',
        'fab fa-joomla' =>  'joomla',
        'fab fa-js' =>  'js',
        'fab fa-js-square' =>  'js-square',
        'fab fa-jsfiddle' =>  'jsfiddle',
        'fa fa-key' =>  'key',
        'fa fa-keyboard' =>  'keyboard',
        'far fa-keyboard' =>  'keyboard',
        'fab fa-keycdn' =>  'keycdn',
        'fab fa-kickstarter' =>  'kickstarter',
        'fab fa-kickstarter-k' =>  'kickstarter-k',
        'fab fa-korvue' =>  'korvue',
        'fa fa-language' =>  'language',
        'fa fa-laptop' =>  'laptop',
        'fab fa-laravel' =>  'laravel',
        'fab fa-lastfm' =>  'lastfm',
        'fab fa-lastfm-square' =>  'lastfm-square',
        'fa fa-leaf' =>  'leaf',
        'fab fa-leanpub' =>  'leanpub',
        'fa fa-lemon' =>  'lemon',
        'far fa-lemon' =>  'lemon',
        'fab fa-less' =>  'less',
        'fa fa-level-down-alt' =>  'level-down-alt',
        'fa fa-level-up-alt' =>  'level-up-alt',
        'fa fa-life-ring' =>  'life-ring',
        'far fa-life-ring' =>  'life-ring',
        'fa fa-lightbulb' =>  'lightbulb',
        'far fa-lightbulb' =>  'lightbulb',
        'fab fa-line' =>  'line',
        'fa fa-link' =>  'link',
        'fab fa-linkedin' =>  'linkedin',
        'fab fa-linkedin-in' =>  'linkedin-in',
        'fab fa-linode' =>  'linode',
        'fab fa-linux' =>  'linux',
        'fa fa-lira-sign' =>  'lira-sign',
        'fa fa-list' =>  'list',
        'fa fa-list-alt' =>  'list-alt',
        'far fa-list-alt' =>  'list-alt',
        'fa fa-list-ol' =>  'list-ol',
        'fa fa-list-ul' =>  'list-ul',
        'fa fa-location-arrow' =>  'location-arrow',
        'fa fa-lock' =>  'lock',
        'fa fa-lock-open' =>  'lock-open',
        'fa fa-long-arrow-alt-down' =>  'long-arrow-alt-down',
        'fa fa-long-arrow-alt-left' =>  'long-arrow-alt-left',
        'fa fa-long-arrow-alt-right' =>  'long-arrow-alt-right',
        'fa fa-long-arrow-alt-up' =>  'long-arrow-alt-up',
        'fa fa-low-vision' =>  'low-vision',
        'fab fa-lyft' =>  'lyft',
        'fab fa-magento' =>  'magento',
        'fa fa-magic' =>  'magic',
        'fa fa-magnet' =>  'magnet',
        'fa fa-male' =>  'male',
        'fa fa-map' =>  'map',
        'far fa-map' =>  'map',
        'fa fa-map-marker' =>  'map-marker',
        'fa fa-map-marker-alt' =>  'map-marker-alt',
        'fa fa-map-pin' =>  'map-pin',
        'fa fa-map-signs' =>  'map-signs',
        'fa fa-mars' =>  'mars',
        'fa fa-mars-double' =>  'mars-double',
        'fa fa-mars-stroke' =>  'mars-stroke',
        'fa fa-mars-stroke-h' =>  'mars-stroke-h',
        'fa fa-mars-stroke-v' =>  'mars-stroke-v',
        'fab fa-maxcdn' =>  'maxcdn',
        'fab fa-medapps' =>  'medapps',
        'fab fa-medium' =>  'medium',
        'fab fa-medium-m' =>  'medium-m',
        'fa fa-medkit' =>  'medkit',
        'fab fa-medrt' =>  'medrt',
        'fab fa-meetup' =>  'meetup',
        'fa fa-meh' =>  'meh',
        'far fa-meh' =>  'meh',
        'fa fa-mercury' =>  'mercury',
        'fa fa-microchip' =>  'microchip',
        'fa fa-microphone' =>  'microphone',
        'fa fa-microphone-slash' =>  'microphone-slash',
        'fab fa-microsoft' =>  'microsoft',
        'fa fa-minus' =>  'minus',
        'fa fa-minus-circle' =>  'minus-circle',
        'fa fa-minus-square' =>  'minus-square',
        'far fa-minus-square' =>  'minus-square',
        'fab fa-mix' =>  'mix',
        'fab fa-mixcloud' =>  'mixcloud',
        'fab fa-mizuni' =>  'mizuni',
        'fa fa-mobile' =>  'mobile',
        'fa fa-mobile-alt' =>  'mobile-alt',
        'fab fa-modx' =>  'modx',
        'fab fa-monero' =>  'monero',
        'fa fa-money-bill-alt' =>  'money-bill-alt',
        'far fa-money-bill-alt' =>  'money-bill-alt',
        'fa fa-moon' =>  'moon',
        'far fa-moon' =>  'moon',
        'fa fa-motorcycle' =>  'motorcycle',
        'fa fa-mouse-pointer' =>  'mouse-pointer',
        'fa fa-music' =>  'music',
        'fab fa-napster' =>  'napster',
        'fa fa-neuter' =>  'neuter',
        'fa fa-newspaper' =>  'newspaper',
        'far fa-newspaper' =>  'newspaper',
        'fab fa-nintendo-switch' =>  'nintendo-switch',
        'fab fa-node' =>  'node',
        'fab fa-node-js' =>  'node-js',
        'fa fa-notes-medical' =>  'notes-medical',
        'fab fa-npm' =>  'npm',
        'fab fa-ns8' =>  'ns8',
        'fab fa-nutritionix' =>  'nutritionix',
        'fa fa-object-group' =>  'object-group',
        'far fa-object-group' =>  'object-group',
        'fa fa-object-ungroup' =>  'object-ungroup',
        'far fa-object-ungroup' =>  'object-ungroup',
        'fab fa-odnoklassniki' =>  'odnoklassniki',
        'fab fa-odnoklassniki-square' =>  'odnoklassniki-square',
        'fab fa-opencart' =>  'opencart',
        'fab fa-openid' =>  'openid',
        'fab fa-opera' =>  'opera',
        'fab fa-optin-monster' =>  'optin-monster',
        'fab fa-osi' =>  'osi',
        'fa fa-outdent' =>  'outdent',
        'fab fa-page4' =>  'page4',
        'fab fa-pagelines' =>  'pagelines',
        'fa fa-paint-brush' =>  'paint-brush',
        'fab fa-palfed' =>  'palfed',
        'fa fa-pallet' =>  'pallet',
        'fa fa-paper-plane' =>  'paper-plane',
        'far fa-paper-plane' =>  'paper-plane',
        'fa fa-paperclip' =>  'paperclip',
        'fa fa-parachute-box' =>  'parachute-box',
        'fa fa-paragraph' =>  'paragraph',
        'fa fa-paste' =>  'paste',
        'fab fa-patreon' =>  'patreon',
        'fa fa-pause' =>  'pause',
        'fa fa-pause-circle' =>  'pause-circle',
        'far fa-pause-circle' =>  'pause-circle',
        'fa fa-paw' =>  'paw',
        'fab fa-paypal' =>  'paypal',
        'fa fa-pen-square' =>  'pen-square',
        'fa fa-pencil-alt' =>  'pencil-alt',
        'fa fa-people-carry' =>  'people-carry',
        'fa fa-percent' =>  'percent',
        'fab fa-periscope' =>  'periscope',
        'fab fa-phabricator' =>  'phabricator',
        'fab fa-phoenix-framework' =>  'phoenix-framework',
        'fa fa-phone' =>  'phone',
        'fa fa-phone-slash' =>  'phone-slash',
        'fa fa-phone-square' =>  'phone-square',
        'fa fa-phone-volume' =>  'phone-volume',
        'fab fa-php' =>  'php',
        'fab fa-pied-piper' =>  'pied-piper',
        'fab fa-pied-piper-alt' =>  'pied-piper-alt',
        'fab fa-pied-piper-hat' =>  'pied-piper-hat',
        'fab fa-pied-piper-pp' =>  'pied-piper-pp',
        'fa fa-piggy-bank' =>  'piggy-bank',
        'fa fa-pills' =>  'pills',
        'fab fa-pinterest' =>  'pinterest',
        'fab fa-pinterest-p' =>  'pinterest-p',
        'fab fa-pinterest-square' =>  'pinterest-square',
        'fa fa-plane' =>  'plane',
        'fa fa-play' =>  'play',
        'fa fa-play-circle' =>  'play-circle',
        'far fa-play-circle' =>  'play-circle',
        'fab fa-playstation' =>  'playstation',
        'fa fa-plug' =>  'plug',
        'fa fa-plus' =>  'plus',
        'fa fa-plus-circle' =>  'plus-circle',
        'fa fa-plus-square' =>  'plus-square',
        'far fa-plus-square' =>  'plus-square',
        'fa fa-podcast' =>  'podcast',
        'fa fa-poo' =>  'poo',
        'fa fa-pound-sign' =>  'pound-sign',
        'fa fa-power-off' =>  'power-off',
        'fa fa-prescription-bottle' =>  'prescription-bottle',
        'fa fa-prescription-bottle-alt' =>  'prescription-bottle-alt',
        'fa fa-print' =>  'print',
        'fa fa-procedures' =>  'procedures',
        'fab fa-product-hunt' =>  'product-hunt',
        'fab fa-pushed' =>  'pushed',
        'fa fa-puzzle-piece' =>  'puzzle-piece',
        'fab fa-python' =>  'python',
        'fab fa-qq' =>  'qq',
        'fa fa-qrcode' =>  'qrcode',
        'fa fa-question' =>  'question',
        'fa fa-question-circle' =>  'question-circle',
        'far fa-question-circle' =>  'question-circle',
        'fa fa-quidditch' =>  'quidditch',
        'fab fa-quinscape' =>  'quinscape',
        'fab fa-quora' =>  'quora',
        'fa fa-quote-left' =>  'quote-left',
        'fa fa-quote-right' =>  'quote-right',
        'fa fa-random' =>  'random',
        'fab fa-ravelry' =>  'ravelry',
        'fab fa-react' =>  'react',
        'fab fa-readme' =>  'readme',
        'fab fa-rebel' =>  'rebel',
        'fa fa-recycle' =>  'recycle',
        'fab fa-red-river' =>  'red-river',
        'fab fa-reddit' =>  'reddit',
        'fab fa-reddit-alien' =>  'reddit-alien',
        'fab fa-reddit-square' =>  'reddit-square',
        'fa fa-redo' =>  'redo',
        'fa fa-redo-alt' =>  'redo-alt',
        'fa fa-registered' =>  'registered',
        'far fa-registered' =>  'registered',
        'fab fa-rendact' =>  'rendact',
        'fab fa-renren' =>  'renren',
        'fa fa-reply' =>  'reply',
        'fa fa-reply-all' =>  'reply-all',
        'fab fa-replyd' =>  'replyd',
        'fab fa-resolving' =>  'resolving',
        'fa fa-retweet' =>  'retweet',
        'fa fa-ribbon' =>  'ribbon',
        'fa fa-road' =>  'road',
        'fa fa-rocket' =>  'rocket',
        'fab fa-rocketchat' =>  'rocketchat',
        'fab fa-rockrms' =>  'rockrms',
        'fa fa-rss' =>  'rss',
        'fa fa-rss-square' =>  'rss-square',
        'fa fa-ruble-sign' =>  'ruble-sign',
        'fa fa-rupee-sign' =>  'rupee-sign',
        'fab fa-safari' =>  'safari',
        'fab fa-sass' =>  'sass',
        'fa fa-save' =>  'save',
        'far fa-save' =>  'save',
        'fab fa-schlix' =>  'schlix',
        'fab fa-scribd' =>  'scribd',
        'fa fa-search' =>  'search',
        'fa fa-search-minus' =>  'search-minus',
        'fa fa-search-plus' =>  'search-plus',
        'fab fa-searchengin' =>  'searchengin',
        'fa fa-seedling' =>  'seedling',
        'fab fa-sellcast' =>  'sellcast',
        'fab fa-sellsy' =>  'sellsy',
        'fa fa-server' =>  'server',
        'fab fa-servicestack' =>  'servicestack',
        'fa fa-share' =>  'share',
        'fa fa-share-alt' =>  'share-alt',
        'fa fa-share-alt-square' =>  'share-alt-square',
        'fa fa-share-square' =>  'share-square',
        'far fa-share-square' =>  'share-square',
        'fa fa-shekel-sign' =>  'shekel-sign',
        'fa fa-shield-alt' =>  'shield-alt',
        'fa fa-ship' =>  'ship',
        'fa fa-shipping-fast' =>  'shipping-fast',
        'fab fa-shirtsinbulk' =>  'shirtsinbulk',
        'fa fa-shopping-bag' =>  'shopping-bag',
        'fa fa-shopping-basket' =>  'shopping-basket',
        'fa fa-shopping-cart' =>  'shopping-cart',
        'fa fa-shower' =>  'shower',
        'fa fa-sign' =>  'sign',
        'fa fa-sign-in-alt' =>  'sign-in-alt',
        'fa fa-sign-language' =>  'sign-language',
        'fa fa-sign-out-alt' =>  'sign-out-alt',
        'fa fa-signal' =>  'signal',
        'fab fa-simplybuilt' =>  'simplybuilt',
        'fab fa-sistrix' =>  'sistrix',
        'fa fa-sitemap' =>  'sitemap',
        'fab fa-skyatlas' =>  'skyatlas',
        'fab fa-skype' =>  'skype',
        'fab fa-slack' =>  'slack',
        'fab fa-slack-hash' =>  'slack-hash',
        'fa fa-sliders-h' =>  'sliders-h',
        'fab fa-slideshare' =>  'slideshare',
        'fa fa-smile' =>  'smile',
        'far fa-smile' =>  'smile',
        'fa fa-smoking' =>  'smoking',
        'fab fa-snapchat' =>  'snapchat',
        'fab fa-snapchat-ghost' =>  'snapchat-ghost',
        'fab fa-snapchat-square' =>  'snapchat-square',
        'fa fa-snowflake' =>  'snowflake',
        'far fa-snowflake' =>  'snowflake',
        'fa fa-sort' =>  'sort',
        'fa fa-sort-alpha-down' =>  'sort-alpha-down',
        'fa fa-sort-alpha-up' =>  'sort-alpha-up',
        'fa fa-sort-amount-down' =>  'sort-amount-down',
        'fa fa-sort-amount-up' =>  'sort-amount-up',
        'fa fa-sort-down' =>  'sort-down',
        'fa fa-sort-numeric-down' =>  'sort-numeric-down',
        'fa fa-sort-numeric-up' =>  'sort-numeric-up',
        'fa fa-sort-up' =>  'sort-up',
        'fab fa-soundcloud' =>  'soundcloud',
        'fa fa-space-shuttle' =>  'space-shuttle',
        'fab fa-speakap' =>  'speakap',
        'fa fa-spinner' =>  'spinner',
        'fab fa-spotify' =>  'spotify',
        'fa fa-square' =>  'square',
        'far fa-square' =>  'square',
        'fa fa-square-full' =>  'square-full',
        'fab fa-stack-exchange' =>  'stack-exchange',
        'fab fa-stack-overflow' =>  'stack-overflow',
        'fa fa-star' =>  'star',
        'far fa-star' =>  'star',

        'fa fa-star-half' =>  'star-half',
        'far fa-star-half' =>  'star-half',
        'fab fa-staylinked' =>  'staylinked',
        'fab fa-steam' =>  'steam',
        'fab fa-steam-square' =>  'steam-square',
        'fab fa-steam-symbol' =>  'steam-symbol',
        'fa fa-step-backward' =>  'step-backward',
        'fa fa-step-forward' =>  'step-forward',
        'fa fa-stethoscope' =>  'stethoscope',
        'fab fa-sticker-mule' =>  'sticker-mule',
        'fa fa-sticky-note' =>  'sticky-note',
        'far fa-sticky-note' =>  'sticky-note',
        'fa fa-stop' =>  'stop',
        'fa fa-stop-circle' =>  'stop-circle',
        'far fa-stop-circle' =>  'stop-circle',
        'fa fa-stopwatch' =>  'stopwatch',
        'fab fa-strava' =>  'strava',
        'fa fa-street-view' =>  'street-view',
        'fa fa-strikethrough' =>  'strikethrough',
        'fab fa-stripe' =>  'stripe',
        'fab fa-stripe-s' =>  'stripe-s',
        'fab fa-studiovinari' =>  'studiovinari',
        'fab fa-stumbleupon' =>  'stumbleupon',
        'fab fa-stumbleupon-circle' =>  'stumbleupon-circle',
        'fa fa-subscript' =>  'subscript',
        'fa fa-subway' =>  'subway',
        'fa fa-suitcase' =>  'suitcase',
        'fa fa-sun' =>  'sun',
        'far fa-sun' =>  'sun',
        'fab fa-superpowers' =>  'superpowers',
        'fa fa-superscript' =>  'superscript',
        'fab fa-supple' =>  'supple',
        'fa fa-sync' =>  'sync',
        'fa fa-sync-alt' =>  'sync-alt',
        'fa fa-syringe' =>  'syringe',
        'fa fa-table' =>  'table',
        'fa fa-table-tennis' =>  'table-tennis',
        'fa fa-tablet' =>  'tablet',
        'fa fa-tablet-alt' =>  'tablet-alt',
        'fa fa-tablets' =>  'tablets',
        'fa fa-tachometer-alt' =>  'tachometer-alt',
        'fa fa-tag' =>  'tag',
        'fa fa-tags' =>  'tags',
        'fa fa-tape' =>  'tape',
        'fa fa-tasks' =>  'tasks',
        'fa fa-taxi' =>  'taxi',
        'fab fa-telegram' =>  'telegram',
        'fab fa-telegram-plane' =>  'telegram-plane',
        'fab fa-tencent-weibo' =>  'tencent-weibo',
        'fa fa-terminal' =>  'terminal',
        'fa fa-text-height' =>  'text-height',
        'fa fa-text-width' =>  'text-width',
        'fa fa-th' =>  'th',
        'fa fa-th-large' =>  'th-large',
        'fa fa-th-list' =>  'th-list',
        'fab fa-themeisle' =>  'themeisle',
        'fa fa-thermometer' =>  'thermometer',
        'fa fa-thermometer-empty' =>  'thermometer-empty',
        'fa fa-thermometer-full' =>  'thermometer-full',
        'fa fa-thermometer-half' =>  'thermometer-half',
        'fa fa-thermometer-quarter' =>  'thermometer-quarter',
        'fa fa-thermometer-three-quarters' =>  'thermometer-three-quarters',
        'fa fa-thumbs-down' =>  'thumbs-down',
        'far fa-thumbs-down' =>  'thumbs-down',
        'fa fa-thumbs-up' =>  'thumbs-up',
        'far fa-thumbs-up' =>  'thumbs-up',
        'fa fa-thumbtack' =>  'thumbtack',
        'fa fa-ticket-alt' =>  'ticket-alt',
        'fa fa-times' =>  'times',
        'fa fa-times-circle' =>  'times-circle',
        'far fa-times-circle' =>  'times-circle',
        'fa fa-tint' =>  'tint',
        'fa fa-toggle-off' =>  'toggle-off',
        'fa fa-toggle-on' =>  'toggle-on',
        'fa fa-trademark' =>  'trademark',
        'fa fa-train' =>  'train',
        'fa fa-transgender' =>  'transgender',
        'fa fa-transgender-alt' =>  'transgender-alt',
        'fa fa-trash' =>  'trash',
        'fa fa-trash-alt' =>  'trash-alt',
        'far fa-trash-alt' =>  'trash-alt',
        'fa fa-tree' =>  'tree',
        'fab fa-trello' =>  'trello',
        'fab fa-tripadvisor' =>  'tripadvisor',
        'fa fa-trophy' =>  'trophy',
        'fa fa-truck' =>  'truck',
        'fa fa-truck-loading' =>  'truck-loading',
        'fa fa-truck-moving' =>  'truck-moving',
        'fa fa-tty' =>  'tty',
        'fab fa-tumblr' =>  'tumblr',
        'fab fa-tumblr-square' =>  'tumblr-square',
        'fa fa-tv' =>  'tv',
        'fab fa-twitch' =>  'twitch',
        'fab fa-twitter' =>  'twitter',
        'fab fa-twitter-square' =>  'twitter-square',
        'fab fa-typo3' =>  'typo3',
        'fab fa-uber' =>  'uber',
        'fab fa-uikit' =>  'uikit',
        'fa fa-umbrella' =>  'umbrella',
        'fa fa-underline' =>  'underline',
        'fa fa-undo' =>  'undo',
        'fa fa-undo-alt' =>  'undo-alt',
        'fab fa-uniregistry' =>  'uniregistry',
        'fa fa-universal-access' =>  'universal-access',
        'fa fa-university' =>  'university',
        'fa fa-unlink' =>  'unlink',
        'fa fa-unlock' =>  'unlock',
        'fa fa-unlock-alt' =>  'unlock-alt',
        'fab fa-untappd' =>  'untappd',
        'fa fa-upload' =>  'upload',
        'fab fa-usb' =>  'usb',
        'fa fa-user' =>  'user',
        'far fa-user' =>  'user',
        'fa fa-user-circle' =>  'user-circle',
        'far fa-user-circle' =>  'user-circle',
        'fa fa-user-md' =>  'user-md',
        'fa fa-user-plus' =>  'user-plus',
        'fa fa-user-secret' =>  'user-secret',
        'fa fa-user-times' =>  'user-times',
        'fa fa-users' =>  'users',
        'fab fa-ussunnah' =>  'ussunnah',
        'fa fa-utensil-spoon' =>  'utensil-spoon',
        'fa fa-utensils' =>  'utensils',
        'fab fa-vaadin' =>  'vaadin',
        'fa fa-venus' =>  'venus',
        'fa fa-venus-double' =>  'venus-double',
        'fa fa-venus-mars' =>  'venus-mars',
        'fab fa-viacoin' =>  'viacoin',
        'fab fa-viadeo' =>  'viadeo',
        'fab fa-viadeo-square' =>  'viadeo-square',
        'fa fa-vial' =>  'vial',
        'fa fa-vials' =>  'vials',
        'fab fa-viber' =>  'viber',
        'fa fa-video' =>  'video',
        'fa fa-video-slash' =>  'video-slash',
        'fab fa-vimeo' =>  'vimeo',
        'fab fa-vimeo-square' =>  'vimeo-square',
        'fab fa-vimeo-v' =>  'vimeo-v',
        'fab fa-vine' =>  'vine',
        'fab fa-vk' =>  'vk',
        'fab fa-vnv' =>  'vnv',
        'fa fa-volleyball-ball' =>  'volleyball-ball',
        'fa fa-volume-down' =>  'volume-down',
        'fa fa-volume-off' =>  'volume-off',
        'fa fa-volume-up' =>  'volume-up',
        'fab fa-vuejs' =>  'vuejs',
        'fa fa-warehouse' =>  'warehouse',
        'fab fa-weibo' =>  'weibo',
        'fa fa-weight' =>  'weight',
        'fab fa-weixin' =>  'weixin',
        'fab fa-whatsapp' =>  'whatsapp',
        'fab fa-whatsapp-square' =>  'whatsapp-square',
        'fa fa-wheelchair' =>  'wheelchair',
        'fab fa-whmcs' =>  'whmcs',
        'fa fa-wifi' =>  'wifi',
        'fab fa-wikipedia-w' =>  'wikipedia-w',
        'fa fa-window-close' =>  'window-close',
        'far fa-window-close' =>  'window-close',
        'fa fa-window-maximize' =>  'window-maximize',
        'far fa-window-maximize' =>  'window-maximize',
        'fa fa-window-minimize' =>  'window-minimize',
        'far fa-window-minimize' =>  'window-minimize',
        'fa fa-window-restore' =>  'window-restore',
        'far fa-window-restore' =>  'window-restore',
        'fab fa-windows' =>  'windows',
        'fa fa-wine-glass' =>  'wine-glass',
        'fa fa-won-sign' =>  'won-sign',
        'fab fa-wordpress' =>  'wordpress',
        'fab fa-wordpress-simple' =>  'wordpress-simple',
        'fab fa-wpbeginner' =>  'wpbeginner',
        'fab fa-wpexplorer' =>  'wpexplorer',
        'fab fa-wpforms' =>  'wpforms',
        'fa fa-wrench' =>  'wrench',
        'fa fa-x-ray' =>  'x-ray',
        'fab fa-xbox' =>  'xbox',
        'fab fa-xing' =>  'xing',
        'fab fa-xing-square' =>  'xing-square',
        'fab fa-y-combinator' =>  'y-combinator',
        'fab fa-yahoo' =>  'yahoo',
        'fab fa-yandex' =>  'yandex',
        'fab fa-yandex-international' =>  'yandex-international',
        'fab fa-yelp' =>  'yelp',
        'fa fa-yen-sign' =>  'yen-sign',
        'fab fa-yoast' =>  'yoast',
        'fab fa-youtube' =>  'youtube',
        'fab fa-youtube-square' =>  'youtube-square',
    );
	
	?>
        <?php foreach($font_awesome_icons as $ficon => $fhex){ 
		$ficon = str_replace("far","fa",$ficon);
		?>
        <div style="float:left; padding:5px; background:#fff; border:1px solid #ddd; margin-right:10px; margin-bottom:10px; cursor:pointer; font-size:20px; padding-left:10px; padding-right:10px;" onclick="processIconSelect('fa <?php echo $ficon; ?>');"> <span class="fa <?php echo $ficon; ?>"></span> </div>
        <?php } ?>
        
        <div class="clearfix"></div>

         
         
         
        <div class="login-modal-close text-center"><i class="fal fa-times">&nbsp;</i></div>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<script> var ajax_site_url = "<?php echo home_url(); ?>/"; </script>