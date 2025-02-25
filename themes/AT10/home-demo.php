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
 
global $CORE, $settings;

if(get_option("ppt_license_key") == "" && get_option("ppt_reinstall") == ""){

include( 'framework/installation.php' ); 
 
}else{


$theme_settings 		= $CORE->LAYOUT("captions", "all");
$categories 	= $CORE->LAYOUT("get_demo_categories", array());

$tick1 = '<svg aria-hidden="true" style="width:16px;color:orange" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-star fa-w-18"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z" class=""></path></svg>';

?>
<style>
div, h3, img, li, p, span, ul {
	margin:0;
	padding:0;
	border:0;
	font-weight:inherit;
	font-style:inherit;
	font-family:inherit;
	vertical-align:baseline;
}
ul {
	list-style:none;
}
::-moz-selection {
background:#46deff;
color:#fff;
}
::selection {
background:#46deff;
color:#fff;
}
ul {
	list-style:none inside;
}
p {
	font:1.3em/1.3em;
}
a {
	text-decoration:none;
}
.clear {
	clear:both;
}
a {
	color:#3496ff;
}
a:hover {
	color:#e44;
}
.clear {
	clear:both;
}
h3 {
	color:#2f3a44;
}
h3 {
	font-size:22px;
}
h3 {
	font-size:18px;
}
a {
	color:#3496ff;
}
a:hover {
	color:#e44;
}
.sidebar_content {
	max-width:350px;
}
.version_details {
	border-radius:3px;
	background: #ffffed;
	border: 1px solid #efe9d4;
	text-align: left;
	text-align:left;
	margin:40px auto;
	padding:30px 10px 0 30px;
}
.version_details .details_section {
	margin:0 0 30px;
}
.version_details h3 {
	font-weight:600;
	font-size:20px;
	color:#534a37;
	margin:0 0 15px;
}
.version_details li {
	font-size:16px;
	padding:0 0 8px;
	color:#534a37;
}
.version_details li span {
	font-weight:600;
	color:#a59981;
	margin:0 0 5px;
}
.version_details li.version span {
	display:block;
	text-transform:uppercase;
	font-size:14px;
	font-weight:700;
}
.version_details li.version {
	margin:0 0 20px;
}
.demo_side {
	color:#4f5e6d;
	padding:40px 35px;
	margin:0 0 40px;
	border:1px solid #dfe4ea;
	border-radius:2px;
	background:#fff;
}
.demo_side a.buy_main {
	background-color:#2b6;
	color:#fff;
	font-weight:500;
	font-size:20px;
	padding:17px 25px;
	display:block;
	text-align:center;
	border-radius:2px;
	cursor:pointer;
	outline:0;
	position:relative;
-webkit-transition:all .3s;
-o-transition:all .3s;
transition:all .3s;
}
.demo_side a.buy_main:hover {
	background:#0c7;
}
.demo_side h3 {
	color:#242628;
	margin:33px 0 13px;
	font-size:23px;
	font-weight:600;
}
.demo_side ul li {
	position:relative;
	margin:0 0 14px;
	padding:3px 0 0 34px;
}
.demo_side ul li:before {
 	font-weight:400;
	font-variant:normal;
	text-transform:none;
	line-height:1;
	color:#2b6;
	margin-right:.5em;
	left:0;
	top:6px;
	position:absolute;
	font-size:20px;
	-webkit-font-smoothing:antialiased;
}
.demo_side ul li:before {
	content:"\f14a";
	font-family:"Font Awesome 5 Pro";
}
.demo_side_all {
	color:#fff;
	padding:40px 35px;
	margin:0 0 40px;
	border-radius:2px;
	background:#525663;
}
.demo_side_all a.buy_main {
	background-color:#fff;
	color:#2f3a44;
	font-weight:500;
	font-size:20px;
	padding:17px 25px;
	display:block;
	text-align:center;
	border-radius:2px;
	cursor:pointer;
	outline:0;
	position:relative;
-webkit-transition:all .3s;
-o-transition:all .3s;
transition:all .3s;
	margin:30px 0 0;
}
.demo_side_all a.buy_main:hover {
	background:#123;
	color:#fff;
}
.demo_side_all h3 {
	color:#fff;
	margin:0 0 20px;
	font-size:23px;
	font-weight:600;
}
.demo_side_all ul {
	margin-top:25px;
}
.demo_side_all ul li {
	position:relative;
	margin:0 0 14px;
	padding:3px 0 0 34px;
}
.demo_side_all ul li:before {
	
	font-weight:400;
	font-variant:normal;
	text-transform:none;
	line-height:1;
	color:#7ae86e;
	margin-right:.5em;
	left:0;
	top:0;
	position:absolute;
	width:25px;
	height:25px;
	font-size:26px;
	-webkit-font-smoothing:antialiased;
}
.demo_side_all ul li:before {
	content:"\f00c";
	font-family:"Font Awesome 5 Pro";
}
.demo_side_all p {
	opacity:.8;
}
.sidebar_review {
	color:#fff;
	padding:40px 25px;
	margin:0 0 40px;
	border:1px solid #dfe4ea;
	border-radius:2px;
	background:#e5e9ec;
	background:-webkit-gradient(linear, left top, left bottom, from(#eceff3), to(rgba(245, 247, 249, .62)));
	background:-webkit-linear-gradient(top, #eceff3 0, rgba(245, 247, 249, .62) 100%);
	background:-o-linear-gradient(top, #eceff3 0, rgba(245, 247, 249, .62) 100%);
	background:linear-gradient(to bottom, #eceff3 0, rgba(245, 247, 249, .62) 100%);
	text-align:center;
}
.sidebar_review h3 {
	color:#242628;
	text-align:center;
	margin:0 0 25px;
}
.sidebar_review a {
	color:#7d7f82;
	text-align:center;
	text-decoration:none;
	border-bottom:1px solid #ccc;
	padding-bottom:1px;
}
.sidebar_review a:hover {
	border-bottom-color:transparent;
}
.stars_review {
	margin:40px 0 0;
}
.stars_review li:before {
	content:'"';
	position:absolute;
	font-size:100px;
	font-weight:500;
	opacity:.2;
	top:-20px;
	left:-25px;
	line-height:1;
}
.stars_review li {
	display:block;
	margin:0 0 40px;
	position:relative;
	text-align:left;
}
.stars_review li p {
	display:block;
	font-size:20px;
	margin:0 0 10px;
	color:#313a43;
	z-index:10;
	line-height:1.5;
	position:relative;
}
.stars_review li span {
	color:#7d7f82;
	margin:6px 0 0;
	vertical-align:middle;
	display:inline-block;
}
.stars_review li span em {	 
	color:#edb240; 
}
.stars_review li:nth-child(2) {
margin-bottom:25px;
text-align:right;
}
.stars_review li:nth-child(2) img {
float:right;
margin:0 0 0 10px;
}
.stars_review li:nth-child(2) p {
font-size:20px;
font-weight:400;
}
.stars_review li:nth-child(2):before {
display:none;
}
.stars_review li:nth-child(2):after {
content:'"';
position:absolute;
font-size:100px;
font-weight:500;
opacity:.2;
top:-20px;
right:-25px;
line-height:1;
}
.stars_review img {
	max-width:35px;
	height:auto;
	border-radius:50%;
	float:left;
	margin:0 10px 0 0;
}
 
 
.logo-svg{content:"";background:url(https://www.premiumpress.com/wp-content/themes/premiumpress/img/premiumpress.svg);background-repeat:no-repeat;background-size:65%;background-position-y:15px;height:50px;width:100%;text-indent:-999px;max-width:300px;}
@media (max-width:575.98px){
.logo-svg{background-size:100%;max-width:200px;}
}
@media (min-width:576px) and (max-width:767.98px){
.logo-svg{background-size:90%;max-width:250px;}
}
@media (min-width:768px) and (max-width:991.98px){
.logo-svg{background-size:90%;max-width:250px;}
}
@media (min-width:992px) and (max-width:1199.98px){
.logo-svg{background-size:90%;max-width:250px;}
}
#header{border-bottom:1px solid #ddd;}
#header img{max-width:40px;}
a{color:#2368da;text-decoration:none;background-color:transparent;-webkit-text-decoration-skip:objects;}
a:hover{color:#0056b3;text-decoration:underline;}
svg:not(:root){overflow:hidden;vertical-align:middle;}
.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;vertical-align:middle;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;padding:.375rem .75rem;font-size:1rem;line-height:1.5;border-radius:.25rem;transition:color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
@media screen and (prefers-reduced-motion:reduce){
.btn{transition:none;}
}
.btn:focus,.btn:hover{text-decoration:none;}
.btn:focus{outline:0;box-shadow:0 0 0 .2rem rgba(0,123,255,.25);}
.btn:disabled{opacity:.65;}
.collapse:not(.show){display:none;}
.nav-link{display:block;padding:.5rem 1rem;}
.nav-link:focus,.nav-link:hover{text-decoration:none;}
.navbar{position:relative;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-ms-flex-align:center;align-items:center;-ms-flex-pack:justify;justify-content:space-between;padding:.5rem 1rem;}
.navbar>.container{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-ms-flex-align:center;align-items:center;-ms-flex-pack:justify;justify-content:space-between;}
.navbar-brand{display:inline-block;padding-top:.3125rem;padding-bottom:.3125rem;margin-right:1rem;font-size:1.25rem;line-height:inherit;white-space:nowrap;}
.navbar-brand:focus,.navbar-brand:hover{text-decoration:none;}
.navbar-nav{display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;padding-left:0;margin-bottom:0;list-style:none;}
.navbar-nav .nav-link{padding-right:0;padding-left:0;}
.navbar-collapse{-ms-flex-preferred-size:100%;flex-basis:100%;-ms-flex-positive:1;flex-grow:1;-ms-flex-align:center;align-items:center;}
.navbar-toggler{padding:.25rem .75rem;font-size:1.25rem;line-height:1;background-color:transparent;border:1px solid transparent;border-radius:.25rem; }
.navbar-toggler:focus,.navbar-toggler:hover{text-decoration:none;}
@media (max-width:767.98px){
.navbar-expand-md>.container{padding-right:0;padding-left:0;}
}
@media (min-width:768px){
.navbar-expand-md{-ms-flex-flow:row nowrap;flex-flow:row nowrap;-ms-flex-pack:start;justify-content:flex-start;}
.navbar-expand-md .navbar-nav{-ms-flex-direction:row;flex-direction:row;}
.navbar-expand-md .navbar-nav .nav-link{padding-right:.5rem;padding-left:.5rem;}
.navbar-expand-md>.container{-ms-flex-wrap:nowrap;flex-wrap:nowrap;}
.navbar-expand-md .navbar-collapse{display:-ms-flexbox!important;display:flex!important;-ms-flex-preferred-size:auto;flex-basis:auto;}
.navbar-expand-md .navbar-toggler{display:none;}
}
.navbar-light .navbar-brand{color:rgba(0,0,0,.9);}
.navbar-light .navbar-brand:focus,.navbar-light .navbar-brand:hover{color:rgba(0,0,0,.9);}
.navbar-light .navbar-nav .nav-link{color:#434656;}
.navbar-light .navbar-nav .nav-link:focus,.navbar-light .navbar-nav .nav-link:hover{color:rgba(0,0,0,.7);}
.navbar-light .navbar-toggler{color:rgba(0,0,0,.5);border-color:rgba(0,0,0,.1);cursor:pointer;}
.border-0{border:0!important;}
.mr-3{margin-right:1rem!important;}
.text-white{color:#fff!important;}
button::-moz-focus-inner{padding:0;border:0;}
.navbar-brand{padding-top:0;padding-bottom:0;}
.navbar{padding:20px 0px;}
header .navbar-nav > .nav-item{position:relative;padding:0px 10px;}
header .nav-link:hover{color:#999999;}
header .nav-item:after{content:"";border-right:1px solid #66696d;left:0px;top:15px;height:10px;position:absolute;}
header .nav-item:first-child{padding-left:0px;}
header .nav-item:first-child:after{border:0px;}
@media (min-width:992px){
.navbar-expand-md .navbar-nav .nav-link{padding-right:0.75rem;padding-left:0.75rem;font-weight:bold;}
}
@media (min-width:768px) and (max-width:992px){
.navbar-brand{margin-right:1rem;}
.navbar-expand-md .navbar-nav .nav-link{font-size:14px;font-weight:bold;}
.btn-yellow{background:#FFB400;display:none!important;height:38px;}
.navbar-nav{margin-top:0px!important;}
header .navbar-nav > .nav-item:nth-child(2){display:none;}
}
@media (min-width:576px) and (max-width:768px){
#header .btn-yellow{display:none!important;}
}
ul{margin:0;padding:0;list-style:none;}
@media (min-width:1200px){
.navbar-nav > .nav-item{font-size:1.25rem;}
.nav-link{font-size:16px;font-weight:600;}
}
@media (min-width:992px) and (max-width:1199.98px){
.nav-link{font-size:16px;}
.navbar-nav > .nav-item{padding:0px;}
.nav-item:after{border:0px;}
}
@media (min-width:576px) and (max-width:991.98px){
.navbar-nav{margin-top:40px;}
}
@media (max-width:575.98px){
#header .btn-yellow{display:none!important;}
.navbar-brand{margin-right:0px;}
.navbar-nav{margin-top:40px;}
header .nav-item{display:inline-block;text-align:center;font-size:18px;font-weight:bold;}
header .nav-item:after{display:none!important;}
}
.btn-yellow{background:#FFB400;box-shadow:0px 3px 0px 0px #d89b0a;}
header,nav{display:block;}
img{vertical-align:middle;border-style:none;}
.text-white{color:#fff;}

.btn-yellow {
    background: #FFB400 !important;
    box-shadow: 0px 3px 0px 0px #d89b0a !important;
}
</style>

<header id="header" class="header bg-white">
  <nav class="navbar navbar-expand-md navbar-light">
    <div class="container" style="position: relative;"> <a href="https://www.premiumpress.com/" class="navbar-brand logo-svg">AutoCoin WordPress Themes</a>
  
      <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-bar-icon" onclick="showmobilemenu();">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img" focusable="false">
        <path stroke="black" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
      </svg>
      </span> </button>
      <div id="navbarSupportedContent" class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a href="https://www.premiumpress.com/premium-wordpress-themes/" class="nav-link">Our Themes</a></li>
          <li class="nav-item"><a href="https://www.premiumpress.com/plugins/" class="nav-link">Plugins</a></li>
          <li class="nav-item"><a href="https://www.premiumpress.com/forums/" class="nav-link">Forum</a></li>
          <li class="nav-item"><a href="https://www.premiumpress.com/contact/" class="nav-link">Support</a></li>
          <li class="nav-item"><a href="https://www.premiumpress.com/blog/" class="nav-link">Blog</a></li>
        </ul>
      </div>
    </div>
  </nav>
</header>


<section class="section-100">
<div class="container px-0">
<div class="row">
  <div class="col-12 <?php if(defined('WLT_DEMOMODE')){ ?>col-lg-8<?php } ?>">
    <div class="row">
      <div class="col-md-12">
        <h1 style="font-weight: 700;"><?php echo THEME_NAME; ?>
          <?php if(defined('WLT_DEMOMODE')){ ?>
          Demo
          <?php } ?>
        </h1>
        <?php if(defined('WLT_DEMOMODE')){ ?>
        <h6 class="py-3 opacity-5">All designs below are included free with this theme.</h6>
        <?php } ?>
      </div>
      <?php foreach($categories[THEME_KEY] as $cid => $cat){  ?>
      <div class="col-12"  id="listing3-carousel-<?php echo $cid; ?>">
        <div class="<?php if($CORE->GEO("is_right_to_left", array() )){ echo "float-left"; }else{ echo "float-right"; } ?> mt-n3"> 
        <a class="btn bg-white btn-sm text-muted prev px-2 mt-2 border">
        <i class="fa fa-angle-left px-1" aria-hidden="true"></i></a> 
        <a class="btn bg-white btn-sm text-muted next px-2 mt-2 border"><i class="fa fa-angle-right px-1" aria-hidden="true"></i></a>        
        </div>
        <?php if(is_array($cat)){ ?>
        <h6><?php echo $cat[0]; ?></h6>
        <div class="opacity-5">
          <p><?php echo $cat[1]; ?></p>
        </div>
        <?php }else{ ?>
        <h6><?php echo $cat; ?></h6>
        <?php } ?>
        <hr />
        <?php $g = $CORE->LAYOUT("load_designs_by_theme", $cid); ?>
        <div  class="owl-carousel owl-theme">
          <?php $i = 1; foreach($CORE->multisort($g, array('order')) as $key => $h){ ?>
          <div class="card-top-image card-zoom mb-5 shadow-sm shadow-sm conceptidea p-2 bg-white">
            <?php if(defined('WLT_DEMOMODE')){ ?>
            <figure> <a href="<?php echo home_url(); ?>/?design=<?php echo $h['key']; ?>" onclick="_paq.push(['trackEvent', 'DEMO WEBSITE - VIEW', '<?php echo $h['key']; ?>', '', '0']);"  class="ga_v10_demo"  data-cat="<?php echo strtoupper(THEME_KEY); ?>" data-themename="<?php echo $h['key']; ?>" target="_blank"> <img src="<?php echo $h['image']; ?>" class="img-fluid lazy" alt="demo">
              <div class="read_more"><span class="bg-dark text-white">view design</span></div>
              </a> </figure>
            <?php }else{ ?>
            <figure> <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=design&defaultdesign=<?php echo $h['key']; ?>" target="_blank"> <img src="<?php echo $h['image']; ?>" class="img-fluid lazy" alt="demo">
              <div class="read_more"><span class="bg-dark text-white"><i class="fal fa-upload"></i> <?php echo __("Install Design","premiumpress"); ?></span></div>
              </a>
              <div class="read_more" style="top:30%"> <a href="<?php echo home_url(); ?>/?design=<?php echo $h['key']; ?>" target="_blank"><span class="bg-dark text-white"><i class="fal fa-search"></i> <?php echo __("View Design","premiumpress"); ?></span></a> </div>
            </figure>
            <?php } ?>
          </div>
          <?php $i++; } ?>
        </div>
        <script> 
jQuery(document).ready(function(){ 
		 
	var owl = jQuery("#listing3-carousel-<?php echo $cid; ?> .owl-carousel").owlCarousel({
        loop: false,
        margin: 20,
        nav: false,
        dots: false,		
        responsive: {
            0: {
                items: 2
            },
			 
            600: {
                items: 2
            },
			
			 
			
            1000: {
                items: 3
            }
        },        
    }); 
	
	owl.owlCarousel();
	
	// REFRESH	
	setTimeout(function(){	
   		owl.trigger('refresh.owl.carousel');
	}, 2000); 
 
  jQuery("#listing3-carousel-<?php echo $cid; ?> .next").click(function(){
    owl.trigger('next.owl.carousel');
	owl.trigger('refresh.owl.carousel');
  })
  jQuery("#listing3-carousel-<?php echo $cid; ?> .prev").click(function(){
    owl.trigger('prev.owl.carousel');
	owl.trigger('refresh.owl.carousel');
  })
	
	
});
	 
</script>
      </div>
      <?php } // end category loop ?>
    </div>
  </div>
  <?php if(defined('WLT_DEMOMODE')){ ?>
  <div class="col-12 col-lg-4">
    <div class="sidebar_content pl-lg-4">
      <div class="demo_side">
        <div> <a href="<?php echo $theme_settings['link']; ?>?from_demo=1" class="edd-add-to-cart button white buy_main" target="_blank" onclick="_paq.push(['trackEvent', 'DEMO WEBSITE - BTN', 'Buy Top', '', '0']);">Buy Now</a>
      
       </div>
        <h3>What's Included:</h3>
        <ul>
          <li data-toggle="tooltip" data-title="Setup as many websites as you like - no extra cost. For client websites, you need the developer license."><strong style="border-bottom:1px dotted #ddd;">Unlimited Installations</strong> <i class="fa fa-flame text-danger ml-2"></i> </li>
          <li><strong>Automatic Updates</strong></li>
          <li><strong>WordPress 5.x Ready</strong></li>
          <li data-toggle="tooltip" data-title="You can pick and choose from 150+ design blocks and easily customize your website."><strong  style="border-bottom:1px dotted #ddd;">150+ Design Blocks</strong></li>
          <li><strong>Multiple Languages</strong> </li>
          <li><strong>25+ Payment Gateways</strong> </li>
          <li data-toggle="tooltip" data-title="Works with Elementor FREE Version (does not require the PRO version)"><strong  style="border-bottom:1px dotted #ddd;"> <span style="color:#c5305b"><i class="fab fa-elementor"></i> Elementor</span> Integration </strong> </li>
          <li><strong>Demo Content</strong></li>
          <li><strong>Quick &amp; Easy Install</strong></li>
        </ul>
      </div>
      <div class="version_details">
        <div class="version_details_wrapper">
          <div class="details_section">
            <h3>Theme Details</h3>
            <ul>
              <li class="version"><span>Current version:</span> <?php echo THEME_VERSION; ?></li>
              <li class="version"><span>Last Update:</span> <?php echo THEME_VERSION_DATE; ?></li>
            </ul>
          </div>
          <div class="details_section">
            <h3>Languages Included</h3>
            <ul class="row m-0">
              <?php  $g = $CORE->LAYOUT("load_designs_by_theme", "lang");   ?>
              <?php $i = 1; foreach($CORE->multisort($g, array('order')) as $key => $h){  $icon = explode("_",$h['lang']); 
		  
		  if(isset($icon[1])){ $icon1 = "flag flag-".strtolower($icon[1]); }else{ $icon1 = "flag flag-".$icon[0]; }  	 ?>
              <li class="version col-md-6"> <span><span class="<?php echo $icon1; ?> float-left mr-2 mt-1"></span> <?php echo $h['name']; ?></span> <a href="<?php echo home_url(); ?>/?design=<?php echo $h['key']; ?>&l=<?php echo $h['lang']; ?>" class="small" target="_blank" onclick="_paq.push(['trackEvent', 'DEMO WEBSITE - LANGUAGE', 'Buy Top', '', '0']);">View Demo</a> </li>
              <?php } ?>
            </ul>
            <p class="small"><i class="fal fa-info-circle mr-2 mb-2"></i> Note. You can change text and create new language files. <a href="https://www.youtube.com/watch?v=4yoCSvH8xjU" target="_blank">Watch Video</a></p>
          </div>
          <div class="clear"></div>
        </div>
      </div>
      <div class="card card-body mb-5"> <img data-src="https://www.premiumpress.com/wp-content/themes/premiumpress/img/demo/bottom.jpg" class="img-fluid lazy" alt="plugins" /> </div>
      <div class="sidebar_review">
        <h3>Trusted by <strong>65,000</strong> Happy Customers!</h3>
        <ul class="stars_review">
          <li>
            <p>I use AutoCoin themes for all my client webistes.</p>
            <img data-src="https://www.premiumpress.com/wp-content/themes/premiumpress/img/user/3.png" class="lazy" alt="review" > <span>David Kakoczki <?php echo $tick1.$tick1.$tick1.$tick1.$tick1; ?></span></li>
          <li>
            <p>Fantastic value for money! Highly Recommended.</p>
            <img data-src="https://www.premiumpress.com/wp-content/themes/premiumpress/img/user/5.png" class="lazy" alt="review" > <span><?php echo $tick1.$tick1.$tick1.$tick1.$tick1; ?> Mark Hepple</span></li>
        </ul>
        <a href="https://www.premiumpress.com/reviews/?fromdemopage=1" target="_blank" onclick="_paq.push(['trackEvent', 'DEMO WEBSITE - BTN', 'Reviews', '', '0']);">view all reviews</a></div>
 
    </div>
    <?php } ?>
  </div>
</div>
</section>
<script>
jQuery(document).ready(function() {	
	
	
	jQuery('[data-toggle="tooltip"]').tooltip({
                trigger: 'hover click focus',
                boundary: 'window'
    });</script>
<script type="text/javascript">
  var _paq = window._paq = window._paq || [];
 
  _paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="https://premiumpress.matomo.cloud/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.src='//cdn.matomo.cloud/premiumpress.matomo.cloud/matomo.js'; s.parentNode.insertBefore(g,s);
  })();  
 
</script>
<div class="scroll-nav-wrapper"></div>
<section class="section-40 bg-black text-white text-center">
  <p class="mb-3">Made with love <i class="fa fa-heart text-danger mx-2">&nbsp;</i> by AutoCoin</p>
</section>
<?php } // end install ?>
