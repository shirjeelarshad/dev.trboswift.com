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
if (!defined('THEME_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

//die(print_r(_ppt_elementor_defaultvalue('title_show')));


global $CORE;

$GLOBALS['flag-home'] = 1;

$pageLinkingID = _ppt_pagelinking("homepage");

if (substr($pageLinkingID, 0, 9) == "elementor" && !isset($_GET['design'])) {


    // CHECK ELMENTOR CANVUS		
    if (get_post_meta(substr($pageLinkingID, 10, 100), "_wp_page_template", true) != "elementor_header_footer") {
        define('NOHEADERFOOTER', 1);
    }

    get_header();

    echo do_shortcode("[premiumpress_elementor_template id='" . substr($pageLinkingID, 10, 100) . "']");

    get_footer();

} else {


    if (_ppt(array('design', 'slot1_style')) == "elementor" && defined('ELEMENTOR_VERSION') && isset($_SESSION['design_preview']) && strlen($_SESSION['design_preview']) > 1) { // CHILD THEME PREVIEWS

        _ppt_template('home', 'elementor');

    } elseif (!_ppt_checkfile("home.php")) {


        get_header();

        ?>

        <style>
            .get-button {
                border-radius: 25px;
                margin-bottom: -50px;
                background:white;
                box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
                
            }

            .get-button-block-bottom-border {
                border-bottom: 4px solid #bc9f4c;
            }
            
            .unfair-advantage{
            padding-top:250px; margin-bottom: 150px;
            z-index: 0;position: relative;}


           .comparison-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            z-index: 1;
        }
        .comparison-table th, .comparison-table td {
            
            text-align: center;
            vertical-align: middle;
            z-index: 2;
        }
        .comparison-table th {
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 0px;
            padding-bottom: 0px;
            max-width: 150px;;
    		width: 18%;
        }
        
        .comparison-table th div {
            background-color: white;
            width: 100%;
            display: block;
            padding: 25px;
        	height: 80px;
            border-top-left-radius: 15px;
    		border-top-right-radius: 15px;
            z-index: 3;
        }
        
        .comparison-table .table-bottom td span{
        border-bottom-left-radius: 15px;
    	border-bottom-right-radius: 15px;
        z-index: 4;
        }
        
        .comparison-table td {
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 0px;
            padding-bottom: 0px;
            max-width: 18%;
    		width: 18%;
        }
        
         .comparison-table td span {
         background-color: white;
        width: 100%;
        display: block;
        padding: 25px;
        height: 80px;
        }
        
        .canadas-first-consumer{
        font-size:50px;
        }
        
        /* Mobile version */
        
        @media (max-width:500px){
        .canadas-first-consumer{
        font-size:25px !important;
        }
        
        .comparison-table td span {
            background-color: white;
            width: 100%;
            display: block;
            padding: 5px;
            height: 50px;
            font-size: 10px;
        }
        .comparison-table td span i {
            font-size: 15px;
        }
        
        
        
        .get-button {
                margin-bottom: -200px;
                background:transparent;
                box-shadow: none;
                
            }
            
            .get-button .get-button-block-bottom-border {
                border-radius: 25px;
                background:white;
                padding: 50px 10px !important;
                box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
                margin-bottom: 20px;
            }
            
            .unfair-advantage {
            padding-top: 420px;
        }
        .unfair-advantage h1, .our-vehicles h1, .looking-sell h1, .home-bottom h1,.partners h1{
        font-size:18px !important;
        margin-bottom:30px
        }
        
        
        .looking-sell img{
        
        margin-top: 50px !important;
        
        }
        
    .comparison-table th div {
    
    display: block;
    padding: 5px !important;
    display: flex;
    align-items: center;
    justify-content: center;
}

.comparison-table td span {
    background-color: white;
    width: 100%;
    display: block;
    padding: 5px;
    height: 60px;
}

.comparison-table .label-column {
    max-width: 30% !important;
    width: 30%;
}


.home-background-bottom {
    
    width: 100% !important;
    
}

.home-background-left {
    
    display: none;
}

.home-background-car1, .home-background-car2  {
    display: none;
}
        
        }
        
        /* Mobile version close */
        
        .comparison-table th img {
            max-height: 40px;
            max-width: 150px;
            width: 100%;
            object-fit: contain;
        }
        
        .comparison-table th .non-turbo {
    	mix-blend-mode: luminosity;            
        }
        
        .comparison-table td.checkmark {
            color: #3B634C;
        }
        .comparison-table td.crossmark {
            color: #B90101;
        }
        .comparison-table .label-column {
            max-width: 28% !important;
    		width: 28%;
            text-align: left;
            font-weight: bold;
        }
        .comparison-table .header-column {
            
        }
        .comparison-table .header-column img {
            display: block;
            margin: 0 auto;
        }
        
        .row-header{
        font-size:14px;
        }
        .comparison-table td span i{
        font-size:30px;
        }
        
        @media (max-width:450px){
        
        .comparison-table {
        
        overflow-x: scroll;
    }

       
        
        .comparison-table .label-column {
    max-width: 120px !important;
    width: 120px !important;
}

	.comparison-table th {
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 0px;
    padding-bottom: 0px;
    max-width: 80px;
    }
    
    .comparison-table th div {
    background-color: white;
    width: 100%;
    display: block;
    padding: 5px;
    height: 30px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.comparison-table th img {
    max-height: 30px;
    max-width: 50px;
    object-fit: contain;
}


.comparison-table td span {
    background-color: white;
    width: 100%;
    display: block;
    padding: 10px;
    height: 50px;
}

.comparison-table td {
    padding-left: 5px;
    padding-right: 5px;
    
    /* max-width: 10%; */
    width: 100px;
}
	
    .comparison-table td span i {
    font-size: 15px;
}
        
    .row-header {
    font-size: 12px;
}    
      
       
        }
        
        
        .owl-nav .owl-next{
        position: absolute;
    left: 10px;
    top: 160px;
    z-index:0;
        transform: rotate(180deg);
     background: white !important;
    width: 40px;
    height: 40px;
    display: flex !important;
    justify-content: center;
    align-items: center;
    border-radius: 50px !important;
    padding: 0px !important;
    margin: 0px !important;
    
    
        }
        
        .owl-nav .owl-prev {
        position: absolute;
    right: 10px;
    top: 160px;
    z-index:0;
    transform: rotate(180deg);
        background: white !important;
    width: 40px;
    height: 40px;
    display: flex !important;
    justify-content: center;
    align-items: center;
    border-radius: 50px !important;
    padding: 0px !important;
    margin: 0px !important;
        
        }
        
        .owl-nav .owl-prev:focus,  .owl-nav .owl-next:focus {
          background-color: yellow;
          border:0px solid #fff;
        }
        
        .owl-nav .owl-prev span,  .owl-nav .owl-next span{
    	font-size: 20px !important;
        color:black;
        
        }
        
        .owl-nav .owl-prev span:hover,  .owl-nav .owl-next span:hover
    	
        color:black;
        
        }
        
        .owl-carousel .owl-stage-outer .owl-stage{
        z-index:11;
        }
        
        
    .new-search {
    border-radius: 10px !important;
    border: 0px solid #fff;
    font-family: var(--e-global-typography-primary-font-family), Inter;
    }
    
    
    
    .new-search:not(.img-user):not(.no-resize) figure a img{
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    }
    
    .new-search .card-body{
     border-bottom-left-radius: 10px;
    	border-bottom-right-radius: 10px;
    }
    
    
    
    .partners-listings .owl-stage-outer .owl-stage .owl-item{
        text-align: center;
    }
    
    
    
    .aiVideo {
        border-radius: 25px; /* Inner border radius */
    }

    #aiVideoContainer {
        padding: 10px;
        border-radius: 25px; /* Outer border radius */
        border: 1px solid #fff;
    }
    
    
    .bottomSellWithUs{
    transition: all .3s ease-in-out;
    border-bottom: 1px solid #ededed;
    background-color: #fff;
    padding: 0;
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    z-index: 500;
    
    }
    
    .home-background-left{
    position: absolute;
    top: 0px;
    right: -569px;
    width: 1554.3px;
    height: 2391.6px;
    object-fit: contain;
    z-index: 0;
    
    }
    
    .home-background-bottom{
    position: absolute;
    top: 526px;
    left: -250px;
    width: 2157px;
    z-index: 0;
    
    }
    
    .z-index{
    position:relative;
    z-index:1;
    }
    
    .home-background-car1{
    position: absolute;
    top: 900.9px;
    right: 114px;
    width: 51.7px;
    height: 60.4px;
    object-fit: contain;
    z-index: 2;
    }
    
    .home-background-car2{
    position: absolute;
    top: 970.9px;
    right: 83px;
    width: 51.7px;
    height: 60.4px;
    object-fit: contain;
    z-index: 2;
    }
    
    
    
    
    .hero-buttons {
    align-self: stretch;
    justify-content: flex-start;
    padding: 0 0 0 8px;
    text-align: left;
    color: #272727;
}

.hero-browse, .hero-buttons {
    flex-direction: row;
    box-sizing: border-box;
}

.hero-browse, .hero-buttons, .hero-slogan1 {
    display: flex;
    align-items: flex-start;
    max-width: 100%;
}

.hero-browse {
    flex: 1;
    box-shadow: 0 170px 48px transparent, 0 109px 43px rgba(138, 138, 138, 0.01), 0 61px 37px rgba(138, 138, 138, 0.05), 0 27px 27px rgba(138, 138, 138, 0.09), 0 7px 15px rgba(138, 138, 138, 0.1);
    border-radius: 32px;
    background-color: #fff;
    justify-content: space-between;
    padding: 34px 86px 0;
    gap: 100px;
    z-index: 4;
}

.hero-browse-child {
    height: 269px;
    width: 1531px;
    position: relative;
    box-shadow: 0 170px 48px transparent, 0 109px 43px rgba(138, 138, 138, 0.01), 0 61px 37px rgba(138, 138, 138, 0.05), 0 27px 27px rgba(138, 138, 138, 0.09), 0 7px 15px rgba(138, 138, 138, 0.1);
    border-radius: 32px;
    background-color: #fff;
    display: none;
    max-width: 100%;
}

.hero-slogan {
    width: 40%;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    gap:31px;
}

.heading-61, .hero-slogan {
    display: flex;
    max-width: 100%;
}

.hero-headings {
    width: 523px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    gap: 15px;
    max-width: 100%;
}

.heading-6 {
    margin: 0;
    width: 298px;
    position: relative;
    font-size: 30px;
    line-height: 30px;
    font-weight: 600;
    font-family: inherit;
    display: flex;
    align-items: center;
    z-index: 5;
    
}

.browse-the-largest {
    align-self: stretch;
    position: relative;
    font-size: var(--font-size-lg);
    line-height: 27px;
    font-family: var(--font-inter);
    color: var(--color-dimgray-100);
    z-index: 5;
}

.frame-child {
    height: 68px;
    width: 213px;
    position: relative;
    border-radius: var(--br-80xl);
    background-color: var(--color-darkslategray-100);
    display: none;
}

.frame-item {
    height: 68px;
    width: 213px;
    position: relative;
    border-radius: var(--br-80xl);
    background-color: var(--color-darkslategray-100);
    display: none;
}

.rectangle-parent {
    cursor: pointer;
    border: 0;
    padding: var(--padding-mini) var(--padding-3xs) var(--padding-base) var(--padding-12xl);
    background-color: var(--color-darkslategray-100);
    display: flex;
    flex-direction: row;
    align-items: flex-end;
    justify-content: flex-start;
    gap: var(--gap-11xl);
}

.get-started-wrapper {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-end;
    padding: 0 0 var(--padding-7xs);
}

.get-started {
    position: relative;
    font-size: var(--font-size-lg);
    line-height: 24px;
    font-family: var(--font-inter);
    color: var(--color-white);
    text-align: left;
    display: inline-block;
    min-width: 105px;
    white-space: nowrap;
    z-index: 1;
}

.button {
    height: 37px;
    width: 37px;
    position: relative;
    border-radius: var(--br-lg-5);
    background-color: var(--color-white);
    z-index: 1;
}

vector-icon {
    position: absolute;
    top: 11.5px;
    left: 11.5px;
    width: 14px;
    height: 14px;
    z-index: 2;
}

.hero-divider {
    align-self: stretch;
    height: 6px;
    position: relative;
    background-color: var(--color-darkkhaki-100);
}

.hero-divider, .rectangle-parent {
    border-radius: var(--br-80xl);
    z-index: 5;
}


.vector-icon {
    position: absolute;
    top: 4px;
    left: 4px;
    width: 30px;
    height: 30px;
    z-index: 2;
}

.hero-slogan1 {
  width: 40%;
  flex-direction: column;
  justify-content: flex-start;
  gap: var(--gap-12xl);
}

.heading-6-sell-or-trade-your-parent {
    width: 523px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    gap: var(--gap-mini);
    max-width: 100%;
}

.heading-61 {
    margin: 0;
    width: 500px;
    position: relative;
    font-size: 30px;
    line-height: 30px;
    font-weight: 600;
    font-family: inherit;
    align-items: center;
    z-index: 5;
}

.heading-61, .hero-slogan {
    display: flex;
    max-width: 100%;
}

.skip-the-dealership {
    align-self: stretch;
    position: relative;
    font-size: var(--font-size-lg);
    line-height: 27px;
    font-family: var(--font-inter);
    color: var(--color-dimgray-100);
    z-index: 5;
}

.rectangle-group {
    cursor: pointer;
    border: 0;
    padding: var(--padding-mini) var(--padding-3xs) var(--padding-base) var(--padding-12xl);
    background-color: var(--color-darkslategray-100);
    display: flex;
    flex-direction: row;
    align-items: flex-end;
    justify-content: flex-start;
    gap: var(--gap-11xl);
}

.hero-slogan-child, .rectangle-group {
    border-radius: var(--br-80xl);
    z-index: 5;
}

.get-started-container {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-end;
    padding: 0 0 var(--padding-7xs);
}

.rectangle-group {
    cursor: pointer;
    border: 0;
    padding: var(--padding-mini) var(--padding-3xs) var(--padding-base) var(--padding-12xl);
    background-color: var(--color-darkslategray-100);
    display: flex;
    flex-direction: row;
    align-items: flex-end;
    justify-content: flex-start;
    gap: var(--gap-11xl);
}

.get-started1 {
    position: relative;
    font-size: var(--font-size-lg);
    line-height: 24px;
    font-family: var(--font-inter);
    color: var(--color-white);
    text-align: left;
    display: inline-block;
    min-width: 105px;
    white-space: nowrap;
    z-index: 1;
    cursor: pointer;
}


.button1 {
    height: 37px;
    width: 37px;
    position: relative;
    border-radius: var(--br-lg-5);
    background-color: var(--color-white);
    z-index: 1;
}

.vector-icon1 {
    position: absolute;
    top: 4px;
    left: 4px;
    width: 30px;
    height: 30px;
    z-index: 2;
}


.hero-slogan-child {
    align-self: stretch;
    height: 6px;
    position: relative;
    background-color: var(--color-darkkhaki-100);
}

.hero-slogan-child, .rectangle-group {
    border-radius: var(--br-80xl);
    z-index: 5;
}



/* Get button for mobile */


.rectangle-parent32 {
    box-shadow: 0 170px 48px transparent, 0 109px 43px rgba(138, 138, 138, 0.01), 0 61px 37px rgba(138, 138, 138, 0.05), 0 27px 27px rgba(138, 138, 138, 0.09), 0 7px 15px rgba(138, 138, 138, 0.1);
    border-radius: var(--br-base);
    background-color: var(--color-white);
    align-items: flex-start;
    padding: var(--padding-12xl) var(--padding-4xs) 0;
    gap: var(--gap-2xs-3);
    flex-shrink: 0;
    debug_commit: 448091;
    z-index: 2;
    margin-top: -53px;
    font-size: var(--font-size-3xl);
    color: var(--color-gray-300);
}

.frame-parent16, .rectangle-parent32 {
    align-self: stretch;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    box-sizing: border-box;
    max-width: 100%;
}

.frame-wrapper7 {
    align-self: stretch;
    flex-direction: row;
    padding: 0 var(--padding-3xs) 0 var(--padding-7xs);
}

.frame-wrapper7, .heading-6-shop-cars-parent, .shop-hundreds-of-vehicles-to-f-parent {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
}


.heading-6-shop-cars-parent {
    flex: 1;
    flex-direction: column;
    gap: var(--gap-3xs);
}

.frame-wrapper7, .heading-6-shop-cars-parent, .shop-hundreds-of-vehicles-to-f-parent {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
}

.heading-69 {
    margin: 0;
    width: 298px;
    position: relative;
    font-size: inherit;
    line-height: 30px;
    font-weight: 600;
    font-family: inherit;
    display: flex;
    align-items: center;
    z-index: 3;
}

.frame-wrapper7, .heading-6-shop-cars-parent, .shop-hundreds-of-vehicles-to-f-parent {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
}

.shop-hundreds-of-vehicles-to-f-parent {
    align-self: stretch;
    flex-direction: column;
    gap: var(--gap-3xl);
    font-size: var(--font-size-xs);
    color: var(--color-dimgray-100);
    font-family: var(--font-inter);
}

.shop-hundreds-of {
    align-self: stretch;
    position: relative;
    line-height: 20px;
    z-index: 3;
}

.rectangle-parent33 {
    cursor: pointer;
    border: 0;
    padding: var(--padding-8xs) var(--padding-10xs) var(--padding-8xs) var(--padding-2xs);
    background-color: var(--color-darkslategray-100);
    border-radius: var(--br-80xl);
    display: flex;
    flex-direction: row;
    align-items: flex-end;
    justify-content: flex-start;
    z-index: 3;
}

.get-started-frame {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-end;
    padding: 0 0 var(--padding-5xs-9);
}


.frame-child49 {
    height: 30px;
    width: 30px;
    position: relative;
    z-index: 1;
}

.frame-child50 {
    align-self: stretch;
    height: 6px;
    position: relative;
    border-radius: var(--br-80xl);
    background-color: var(--color-darkkhaki-100);
    z-index: 3;
}



.frame-wrapper8 {
    flex-direction: row;
    box-sizing: border-box;
    font-size: var(--font-size-3xl);
    color: var(--color-gray-300);
}

.frame-parent15, .frame-wrapper8 {
    align-self: stretch;
}
.frame-parent15, .frame-wrapper8, .rectangle-parent34 {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    max-width: 100%;
}

.rectangle-parent34 {
    flex: 1;
    box-shadow: 0 170px 48px transparent, 0 109px 43px rgba(138, 138, 138, 0.01), 0 61px 37px rgba(138, 138, 138, 0.05), 0 27px 27px rgba(138, 138, 138, 0.09), 0 7px 15px rgba(138, 138, 138, 0.1);
    border-radius: var(--br-base);
    background-color: var(--color-white);
    flex-direction: column;
    padding: var(--padding-12xl) var(--padding-4xs) 0;
    box-sizing: border-box;
    gap: var(--gap-2xs-3);
}

.frame-parent15, .frame-wrapper8, .rectangle-parent34 {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    max-width: 100%;
}


.frame-wrapper9 {
    align-self: stretch;
    flex-direction: row;
    padding: 0 var(--padding-3xs) 0 var(--padding-7xs);
}

.frame-wrapper9, .heading-6-shop-cars-group, .tell-us-about-your-ride-styl-parent {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
}


.heading-6-shop-cars-group {
    flex: 1;
    flex-direction: column;
    gap: var(--gap-3xs);
}

.frame-wrapper9, .heading-6-shop-cars-group, .tell-us-about-your-ride-styl-parent {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
}

.heading-610 {
    margin: 0;
    width: 298px;
    position: relative;
    font-size: inherit;
    line-height: 30px;
    font-weight: 600;
    font-family: inherit;
    display: flex;
    align-items: center;
    z-index: 1;
}

.frame-wrapper9, .heading-6-shop-cars-group, .tell-us-about-your-ride-styl-parent {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
}

.tell-us-about-your-ride-styl-parent {
    align-self: stretch;
    flex-direction: column;
    gap: var(--gap-3xl);
    font-size: var(--font-size-xs);
    color: var(--color-dimgray-100);
    font-family: var(--font-inter);
}

.tell-us-about {
    align-self: stretch;
    position: relative;
    line-height: 20px;
    z-index: 1;
}

.rectangle-parent35 {
    cursor: pointer;
    border: 0;
    padding: var(--padding-8xs) var(--padding-10xs) var(--padding-8xs) var(--padding-2xs);
    background-color: var(--color-darkslategray-100);
    border-radius: var(--br-80xl);
    display: flex;
    flex-direction: row;
    align-items: flex-end;
    justify-content: flex-start;
    z-index: 1;
}

.frame-child52 {
    height: 40px;
    width: 126px;
    position: relative;
    border-radius: var(--br-80xl);
    background-color: var(--color-darkslategray-100);
    display: none;
}

.get-started-wrapper1 {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-end;
    padding: 0 0 var(--padding-5xs-9);
}

.get-started7 {
    width: 89.3px;
    height: 14.1px;
    position: relative;
    font-size: var(--font-size-xs);
    line-height: 24px;
    font-family: var(--font-inter);
    color: var(--color-white);
    text-align: left;
    display: flex;
    align-items: center;
    flex-shrink: 0;
    white-space: nowrap;
    z-index: 1;
}

.frame-child53 {
    height: 30px;
    width: 30px;
    position: relative;
    z-index: 1;
}


.frame-child54 {
    align-self: stretch;
    height: 6px;
    position: relative;
    border-radius: var(--br-80xl);
    background-color: var(--color-darkkhaki-100);
    z-index: 1;
}

.get-started6 {
    width: 89.3px;
    height: 14.1px;
    position: relative;
    font-size: var(--font-size-xs);
    line-height: 24px;
    font-family: var(--font-inter);
    color: var(--color-white);
    text-align: left;
    display: flex;
    align-items: center;
    flex-shrink: 0;
    white-space: nowrap;
    z-index: 1;
}


/* Main Header Text */



@media(max-width:1000px){


.an-all-in-one-auto1{
    
    line-height: 20px;
    font-family: var(--font-inter);
    
    height: 40px;
    z-index: 2;
    height: 56px;
    z-index: 5;
    font-size: 12px;

}
}







        </style>

        <div class="main-home-body" style="background:#f1f1f1;">

            <div class="home-banner-block">
                <div style="
            height: 690px;
            background-image: url('<?php echo get_template_directory_uri(); ?>/framework/images/AdobeStock_436184331.jpeg');
            background-repeat: no-repeat, repeat;
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            z-index: 1;
            " class="col-12">
                    <div class="col-12 banner-content container d-flex align-items-center">
                        <div class="mt-5 text-white">
                            <h1 class="canadas-first-consumer" id="canadasFirstConsumer">
            Canada’s First<br>Consumer Car Auction
          </h1>
          
                            
                        </div>

                    </div>
                    
                    
           <!-- Hero Buttons desktop start -->         
           <div class="container">         
            <div class="hero-buttons d-none d-lg-flex">
            <div class="hero-browse">
              <div class="hero-browse-child"></div>
              <div class="hero-slogan">
                <div class="hero-headings">
                  <h1 class="heading-6">Auctions</h1>
                  <div class="browse-the-largest">
                    Browse the largest selection of cars in Canada, with
                    verified information at your fingertips
                  </div>
                </div>
                <a href="<?php echo home_url(); ?>/?s=" class="rectangle-parent">
                  <div class="frame-child"></div>
                  <div class="get-started-wrapper">
                    <div class="get-started">Get Started</div>
                  </div>
                  <div class="button">
                    <img class="vector-icon" alt="" src="<?php echo get_template_directory_uri(); ?>/framework/images/group-1321314646.svg" />
                  </div>
                </a>
                <div class="hero-divider"></div>
              </div>
              <div class="hero-slogan1">
                <div class="heading-6-sell-or-trade-your-parent">
                  <h1 class="heading-61">Sell your car</h1>
                  <div class="skip-the-dealership">
                    Skip the dealership and tire kickers - get the maximum value for your car
                  </div>
                </div>
                <a href="<?php echo home_url(); ?>/sell-a-car/" class="rectangle-group">
                  <div class="frame-item"></div>
                  <div class="get-started-container">
                    <div class="get-started1">Get Started</div>
                  </div>
                  <div class="button1">
                    <img
                      class="vector-icon1"
                      alt=""
                      src="<?php echo get_template_directory_uri(); ?>/framework/images/group-1321314646.svg"
                    />
                  </div>
                </a>
                <div class="hero-slogan-child"></div>
              </div>
            </div>
          </div>
         </div>
         <!-- Hero Buttons desktop close -->
          
          
          <div class="d-block d-lg-none" style="margin-bottom: -337px;">
          <div class="rectangle-parent32">
            <div class="frame-child47"></div>
            <div class="frame-wrapper7">
              <div class="heading-6-shop-cars-parent">
                <h2 class="heading-69">Auctions</h2>
                <div class="shop-hundreds-of-vehicles-to-f-parent">
                  <div class="shop-hundreds-of">
                    Browse the largest selection of cars in Canada, with
                    verified information at your fingertips
                  </div>
                  <a href="<?php echo home_url(); ?>/?s=" class="rectangle-parent33">
                    <div class="frame-child48"></div>
                    <div class="get-started-frame">
                      <div class="get-started6">Get Started</div>
                    </div>
                    <img
                      class="frame-child49"
                      alt=""
                      src="<?php echo get_template_directory_uri(); ?>/framework/images/group-1321314646.svg"
                    />
                  </a>
                </div>
              </div>
            </div>
            <div class="frame-child50"></div>
          </div>
          
          <div class="frame-wrapper8 mt-5">
          <div class="rectangle-parent34">
            <div class="frame-child51"></div>
            <div class="frame-wrapper9">
              <div class="heading-6-shop-cars-group">
                <h2 class="heading-610">Sell your car</h2>
                <div class="tell-us-about-your-ride-styl-parent">
                  <div class="tell-us-about">
                    Skip the dealership and tire kickers - get the maximum value for your car​.
                  </div>
                  <a href="<?php echo home_url(); ?>/sell-a-car/" class="rectangle-parent35">
                    <div class="frame-child52"></div>
                    <div class="get-started-wrapper1">
                      <div class="get-started7">Get Started</div>
                    </div>
                    <img
                      class="frame-child53"
                      alt=""
                      src="<?php echo get_template_directory_uri(); ?>/framework/images/group-1321314646.svg"
                    />
                  </a>
                </div>
              </div>
            </div>
            <div class="frame-child54"></div>
          </div>
        </div>
          
          
          
          </div>
          
<!-- Home Middle get-button-group close -->
                </div><!-- Home banner image block  close -->

            </div> <!-- Home banner close -->


            <div class="home-middle-block">
            <img class="home-background-left" src="<?php echo get_template_directory_uri(); ?>/framework/images/ellipse-185.svg" />
			 <img class="home-background-bottom" src="<?php echo get_template_directory_uri(); ?>/framework/images/ellipse-186.svg" />

			<img class="home-background-car1" src="<?php echo get_template_directory_uri(); ?>/framework/images/group-1000009785@2x.png" />
			<img class="home-background-car2" src="<?php echo get_template_directory_uri(); ?>/framework/images/group-1000009785@2x.png" />
            
                <div class="unfair-advantage">
                    <h1 class="text-center bold">Your unfair advantage</h1>

         <div class="container pt-2">
                        <table class="comparison-table">

                            <thead>
                                <tr>
                                    <th class="label-column"><div></div></th>
                                    <th class="header-column"><div><img
                                            src="<?php echo get_template_directory_uri(); ?>/framework/images/TurboBid_DD3.svg"
                                            alt="TurboBid"></div></th>
                                    <th class="header-column"><div><img class="non-turbo"  src="<?php echo get_template_directory_uri(); ?>/framework/images/image-34.svg"
                                            alt="Kijiji Autos"></div></th>
                                            
                                    <th class="header-column"><div><img class="non-turbo" src="<?php echo get_template_directory_uri(); ?>/framework/images/image-78.svg" alt="AutoTrader"></div>
                                    </th>
                                    <th class="header-column"><div>
                                    <img src="<?php echo get_template_directory_uri(); ?>/framework/images/image-36.svg" class="d-none d-md-block non-turbo" alt="Facebook Marketplace">  <img src="<?php echo get_template_directory_uri(); ?>/framework/images/image-41.svg" class="d-block d-md-none non-turbo" alt="Facebook Marketplace">
                                    </div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                     <td class="label-column"><span class="row-header">Online Car Listings</span></td>
                                    <td class="checkmark"><span><i class="fas fa-check-circle"></i></span></td>
                                    <td class="checkmark"><span><i class="fas fa-check-circle"></i></span></td>
                                    <td class="checkmark"><span><i class="fas fa-check-circle"></i></span></td>
                                    <td class="checkmark"><span><i class="fas fa-check-circle"></i></span></td>
                                </tr>
                                <tr>
                                    <td class="label-column"><span class="row-header">AI Inspections & Valuations</span></td>
                                    <td class="checkmark"><span><i class="fas fa-check-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                </tr>
                                <tr>
                                    <td class="label-column"><span class="row-header">Full Document Package</span></td>
                                    <td class="checkmark"><span><i class="fas fa-check-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                </tr>
                                <tr>
                                    <td class="label-column"><span class="row-header">Consumer Auctions</span></td>
                                    <td class="checkmark"><span><i class="fas fa-check-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                </tr>
                                
                                 <tr>
                                    <td class="label-column"><span class="row-header">Escrow</span></td>
                                    <td class="checkmark"><span><i class="fas fa-check-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                </tr>
                                
                                 <tr class="table-bottom">
                                    <td class="label-column"><span class="row-header">Warranty</span></td>
                                    <td class="checkmark"><span><i class="fas fa-check-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                    <td class="crossmark"><span><i class="fas fa-times-circle"></i></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div><!-- Your unfair advantage block close -->

				<div  class="container our-vehicles mt-5 z-index" >
                 <div class="text-center"> 
                <h1 class="text-center bold">All our vehicles are fully<br>inspected, using AI</h1>
                <span>TurboBid customers are protected with our AI inspection</span></div>
                
                <div class="mt-3">
                <div id="aiVideoContainer">
    <video id="aiVideo " class="aiVideo" style="width:100%!important;"  autoplay loop playsinline defaultmuted preload="auto">
        <source src="<?php echo home_url(); ?>/wp-content/uploads/2024/06/WhatsApp-Video-2024-06-03-at-2.24.10-AM.mp4" type="video/mp4">
    </video>
</div>



                
                </div>
                
                </div><!-- Home our vehicles Block close -->
                
                
             <div class="looking-sell z-index">
            
            <div class="text-center py-5"> 
            <h1 class="text-center bold">Looking to sell?</h1>
            <span>Upload your vehicle and get the most competitive price in Canada!</span>
            </div>
            
            <div class="container d-block d-md-flex justify-content-center pt-5">
            <div class="col-12 col-md-6" style="z-index:5">
            <div class=" bg-white get-button px-4  py-5">
            <h3>VIN</h3>
            
            <form id="vehicle-form">
        <div class="form-group position-relative">
            <label>Vehicle Identification Number</label>
            <input type="text" class="form-control rounded-pill" placeholder="Enter vin number" name="vehicle-identification-number" id="vehicle-identification-number" value="" autocomplete="vehicle-identification-number">
        </div>
        
       <!-- <div class="form-group position-relative">
            <label>Model Year</label>
            <input type="text" class="form-control rounded-pill" placeholder="Enter car model year" name="modelyear" id="modelyear" value="" autocomplete="modelyear">
        </div> -->
        
        <div class="mt-1">
            <button type="button" class="btn btn-secondary rounded-pill icon-after col-12" id="get-started">Get Started</button>
        </div>
    </form>
    
    <script>
        jQuery(document).ready(function($) {
            $('#get-started').on('click', function() {
                const vin = $('#vehicle-identification-number').val();
               // const modelYear = $('#modelyear').val();

                if (!vin) {
                    alert('Please enter VIN number.');
                    return;
                }

                const apiUrl = `https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/${vin}?format=json`;

                $.getJSON(apiUrl, function(data) {
                    let make = '';
                    let model = '';
                    let year = '';

                    data.Results.forEach(result => {
                        if (result.Variable === 'Make') {
                            make = result.Value;
                        } else if (result.Variable === 'Model') {
                            model = result.Value;
                        } else if (result.Variable === 'Model Year') {
                            year = result.Value;
                        }
                    });

                    if (!make || !model || !year) {
                        alert('Failed to retrieve vehicle information. Please check the VIN.');
                        return;
                    }

                   const redirectUrl = `<?php echo home_url(); ?>/list-your-car/?vin=${encodeURIComponent(vin)}&myear=${encodeURIComponent(year)}&make=${encodeURIComponent(make)}&model=${encodeURIComponent(model)}`;
                    window.location.href = redirectUrl;
                }).fail(function() {
                    alert('Error connecting to the API. Please try again later.');
                });
            });
        });
    </script>
            </div>
           </div>
            <div class="col-12 col-md-6" >
            <img src="<?php echo get_template_directory_uri(); ?>/framework/images/group-1321314845@2x.png" style="width: 100%;
    height: 100%; margin-top:-100px;" />
            </div>
            
            </div><!-- Home Looking to sell? Block close -->   

            </div><!-- Home Middle Block close -->
            
            
            <style>
        .owl-carousel .owl-stage-outer .owl-stage {
            transition: left 0.3s, right 0.3s;
        }
    </style>

			<div class="home-bottom" style="
            background-image: url(&quot;<?php echo home_url(); ?>/wp-content/uploads/2024/06/Ellipse-187.png&quot;);
           background-repeat: no-repeat;
            background-size: 100% 1263px;
            background-position-x: 0px;
            background-position-y: -617px;
            padding-top: 150px;
           
            " >
            
             <div class="col-12"> 
             
              <h1 class="text-center text-white bold">Current auctions</h1>
                <div class="clearfix"></div>
                
                <div class="container">
               <?php echo do_shortcode('[LISTINGS dataonly=1 card_class="col-md-3 col-lg-3 col-xl-3" nav=0 custom=endsoon]'); ?> 
                </div>
                
                <div class="d-none related-listings owl-carousel owl-theme">
                    <?php
                    
                     $data = str_replace(".00", "", do_shortcode('[LISTINGS dataonly=1 nav=0 small=1 carousel=1 custom=endsoon]'));
                    

                    if (strlen($data) < 10) {
                      //  $data = str_replace(".00", "", do_shortcode('[LISTINGS dataonly=1 nav=0 small=1 carousel=1 custom=endsoon]'));
                    }

                   // echo $data;

                    if (_ppt(array('lst', 'hide_featuredimage')) == "1") {
                     //   $GLOBALS['flag-singlepage'] = 1;
                    }

                    ?>
                </div>
                
                
            </div>
            
            <script> 
jQuery(document).ready(function(){ 
		 
	var owl = jQuery(".related-listings").owlCarousel({
            loop: false,
            margin: 20,
            nav: true,
            dots: false,
            lazyLoad: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 4
                },
                1200: {
                    items: 5
                }
            },
            onInitialized: setStagePosition,
            onTranslated: setStagePosition
        }); 
	
	function setStagePosition(event) {
            var itemIndex = event.item.index;
            var itemCount = event.item.count;
            var itemsPerPage = event.page.size;

            var stage = jQuery('.related-listings .owl-stage-outer .owl-stage');

            if (itemIndex === 0) {
                stage.css('left', '80px');
            } else {
                stage.css('left', '0');
            }

            if (itemIndex >= itemCount - itemsPerPage) {
                stage.css('right', '80px');
            } else {
                stage.css('right', '0');
            }
        }
        
	});		 
</script>


            
            </div><!-- Home bottom Block close -->


			<div class="partners col-12 py-5 mb-5">
            <h1 class="text-center bold pb-4">Our Partners</h1>

            <div class="partners-listings owl-carousel owl-theme owl-loaded owl-drag">
    <div class="owl-stage-outer">
        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0.25s ease 0s; width: 3623px;">
            <div class="owl-item" style="width: 281.84px; margin-right: 20px;"><img src="<?php echo home_url(); ?>/wp-content/uploads/2024/04/guardtree_logo_200x_7637d0ea-ff89-4241-a6ad-b77ae116ca75_200x.png" /></div>
           
  
           
        </div>
    </div>
    
    <div class="owl-dots"></div>
</div>

 <script> 
jQuery(document).ready(function(){ 
		 
	var owl = jQuery(".partners-listings").owlCarousel({
            loop: true,
            margin: 20,
            nav: false,
            dots: true,
            lazyLoad: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                },
                1200: {
                    items: 1
                }
            },
        }); 
        
	});		 
</script>
            
            
            </div><!-- Home bottom partners close -->
			

<div class="bottomSellWithUs p-2  text-center bg-primary" >
<span class="small text-white font-weight-bold text-mobile-9">Sell with us — it’s free! Apply in just 5 minutes. <a href="<?php echo home_url(); ?>/sell-a-car/" class="text-white font-weight-bold">Get Started<a/></span>

<a onclick="jQuery('.bottomSellWithUs').fadeOut(400);" class="btn close-stripe d-block">
            <i class="fas fa-times"></i>
      </a>
</div>


        </div>

        <?php

        get_footer();

    }

}

?>