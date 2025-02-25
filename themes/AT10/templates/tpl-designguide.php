<?php
/*
Template Name: [ DESIGN - GUIDE ]
*/

global $settings;

$GLOBALS['flag-testing'] = 1;
 
$pages = array(



1 => array("id" => 1, "name" => "Heros", "path" => "hero"),
//2 => array("id" => 1, "name" => "Headers", "path" => "headers"),
//3 => array("id" => 3, "name" => "Footers", "path" => "footers"),
//16 => array("id" => 16, "name" => "Titles", "path" => "titles"),	

//1 => array("id" => 1, "name" => "Inner Pages", "path" => "innerpages"),

//0 => array("id" => 1, "name" => "Color Setup", "path" => "colors"),

//18 => array("id" => 1, "name" => "Widgets - Single ", "path" => "widgets-single"),


//10 => array("id" => 10, "name" => "Hero", "path" => "hero"),

//17 => array("id" => 17, "name" => "Categories", "path" => "categories"),

//



//1 => array("id" => 2, "name" => "Typography", "path" => "typography"),
	
 
	
	
	// 
	

//9 => array("id" => 9, "name" => "Box - Listing", "path" => "box-listing"),

 


//18 => array("id" => 18, "name" => "Widgets - Blog", "path" => "widgets-blog"),

//18 => array("id" => 18, "name" => "Widgets", "path" => "widgets"),
	

			
	
	//
	//4 => array("id" => 4, "name" => "Headers - Nav", "path" => "headers-nav"),
	
	
	
	//7 => array("id" => 7, "name" => "Footers - Bottom", "path" => "footers-top"),
	//8 => array("id" => 8, "name" => "Footers - Bottom", "path" => "footers-bot"),
	
	
	//
	
	//11 => array("id" => 11, "name" => "Blog", "path" => "blog"),
	//12 => array("id" => 12, "name" => "Featured", "path" => "featured"),
	//14 => array("id" => 14, "name" => "Listings", "path" => "listings"),
	//15 => array("id" => 15, "name" => "Services", "path" => "services"),
	
	
	
	 
	
	
);		
?>
<!--

=========================================================
* PremiumPress Themes
=========================================================

* Product Page: https://premiumpress.com
* Copyright 2020 Premium Press Limited

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<!DOCTYPE html>
<html lang="en">

<head>
   
<title>PremiumPress - Documentation</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php wp_head(); ?> 
 
</head>

<body>

    <a href="#doc-index" class="btn btn-lg btn-primary btn-block rounded-0 d-lg-none" data-toggle="collapse"
        data-target="#doc-index" aria-expanded="false" aria-controls="doc-index">
        
        <svg class="icon fill-white" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 17C3 17.5523 3.44772 18 4 18H20C20.5523 18 21 17.5523 21 17V17C21 16.4477 20.5523 16 20 16H4C3.44772 16 3 16.4477 3 17V17ZM3 12C3 12.5523 3.44772 13 4 13H20C20.5523 13 21 12.5523 21 12V12C21 11.4477 20.5523 11 20 11H4C3.44772 11 3 11.4477 3 12V12ZM4 6C3.44772 6 3 6.44772 3 7V7C3 7.55228 3.44772 8 4 8H20C20.5523 8 21 7.55228 21 7V7C21 6.44772 20.5523 6 20 6H4Z" />
        </svg>
        <span class="h6 text-white">Menu</span>
    </a>
    
    
    <section class="container-fluid py-4">
        <div class="row">
            <!-- Sidebar -->
<div class="col-12 col-lg-2 border-right pt-3 pt-md-3 doc-sidebar">
    <div id="doc-index" class="collapsexx">
        <div class="mb-3 mb-md-4">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/framework/img/logo.png" class="mb-5 img-fluid" alt="menuimage">
            </a>
            <h6 class="mb-2">Getting Started</h6>
            <ul class="nav flex-column">
 
<?php foreach($pages as $p){ ?>
<li class="nav-item"><a class="nav-link <?php if($p['id'] == 1){ ?>active<?php } ?>" id="v-pills-<?php echo $p['id']; ?>-tab" data-toggle="pill"
   href="#v-pills-<?php echo $p['id']; ?>" role="tab" aria-controls="v-pills-<?php echo $p['id']; ?>" aria-selected="true"><?php echo $p['name']; ?></a>
 </li>
<?php } ?>
                
            </ul>
        </div>

        <div class="mb-3 mb-md-4">
        
            <h6 class="mb-2">Components</h6>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="" class="nav-link">Accordions</a>
                </li>             
            </ul>
        </div>
    </div>
</div>
<!-- End of Sidebar -->
<!-- Content -->
<div class="col-12 col-lg-10">

               
<div class="tab-content  pl-lg-5" id="v-pills-tabContent">
	<?php foreach($pages as $p){ ?>
    
    <div class="tab-pane fade <?php if($p['id'] == 1){ ?>show active<?php } ?>" id="v-pills-<?php echo $p['id']; ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $p['id']; ?>-tab">
    <div class="container">
        <div class="pt-0 pb-5">
            <div class="border-bottom mb-5">
            <h1 class="display-4"><?php echo $p['name']; ?></h1>
            <p class="lead text-dark">Use accordions to show content when clicking on a tab element.</p>
            </div>
            
            <?php
			
			$settings = array('class' => 'bg-light');
            _ppt_template('framework/design/'.$p['path']);  
			 
            ?>
            
            
        </div>
    </div>
    </div><!-- end tab -->
    
    <?php } ?> 
</div>      
                


</div><!-- end col 12 -->
                
</div> 
</section><!-- end main section -->


</body>
<?php wp_footer(); ?>
</html>