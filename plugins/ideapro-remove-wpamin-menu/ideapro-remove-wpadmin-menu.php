<?php 
/**
 * Plugin Name: AutoCoin By Rancoder
 * Description: We want to remove items from the wordpress admin
**/

function ideapro_remove_wpadmin_menus()
{
    remove_menu_page('themes.php');
	remove_menu_page('plugins.php');
	remove_menu_page('index.php');
	remove_menu_page('admin.php?page=design');
}
add_action('admin_menu','ideapro_remove_wpadmin_menus');

function remove_error_from_admin()
{
	?>
	<script>
	   jQuery(document).ready(function($) {
    var css = `
        #adminmenu div.wp-menu-image:before {
            color: #292D32!important;
        }
        
        #adminmenu li:hover {
            background-color: #fff0 !important;
        }
        #adminmenu li:hover div.wp-menu-image:before {
            color: white !important;
        }
        #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, #adminmenu li.opensub>a.menu-top, .folded #adminmenu a.menu-top:hover{
        background-color: #3B634C !important;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        border-radius: 50px;
        margin: 15px;
        }
        #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu div.wp-menu-image:before{
        color:#fff!important;
        }
        
        .folded #adminmenu a.menu-top{
        
    	background: #F8F9FA !important;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        border-radius: 50px;
        margin: 15px;
        }
        
        .folded #adminmenu li.menu-top .wp-submenu>li>a:hover, #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head{
        background-color: #3B634C !important;
        }
        
        
        
        .folded #adminmenu, .folded #adminmenu li.menu-top, .folded #adminmenuback, .folded #adminmenuwrap {
    width: 100px!important;
}
        
        .folded #adminmenu .opensub .wp-submenu{
        left:100px !important;
        
        }
        #adminmenu .wp-submenu a {
        color: #292D32 !important;
        }
        #adminmenu .wp-submenu .wp-submenu-head {
    	color: #000;
    	}
        
        #adminmenu .wp-submenu li:hover a {
            color: #fff !important;
        }
        
        body.wp-admin {
            background: #F8F9FA !important;
        }
        
        .folded #wpcontent, .folded #wpfooter {
            margin-left: 100px;
        }
        
    `;
    var style = $('<style type="text/css"></style>');
    style.html(css);
    $('head').append(style);
});
    
    jQuery(".popup-yt ").css({    
	"display": "none",
    });
    
    jQuery(".btn-system ").css({    
	"display": "none",
    });
    
    
	jQuery(".tab-content ").css({    
	"background": "white",
    });
	
	jQuery(".design-autocoin ").css({    
	"display": "none",
    });
    
    jQuery(".plugin-update-tr ").css({    
	"display": "none",
    });
    
    jQuery(".notice ").css({    
	"display": "none",
    });
    
    jQuery(".card1").css({    
	"display": "none",
    });
    
    jQuery("#header-box").css({    
	"display": "none",
    });
    
     jQuery(".design-display-none").css({    
	"display": "none",
    });
    
    jQuery("#sidebar_help.showme").css({    
	"display": "none!important",
    });
    
    jQuery(".gform-settings-header").css({    
	"display": "none",
    });
    jQuery(".gform-settings-header .gform-settings__wrapper").css({    
	"display": "none",
    });
    
    jQuery("#adminmenu").css({    
	"background": "white",
    "color": "#292D32",
    });
    
    jQuery("#adminmenuback, #adminmenuwrap").css({    
	"background": "white",
    "color": "#292D32",
    });
    
    jQuery("#adminmenu .wp-submenu").css({    
	"background": "white",
    "color": "#292D32",
    });
    

    
    jQuery("#wpadminbar").css({    
	"background": "white",
    "display": "none",
    });
    
    jQuery("html.wp-toolbar").css({    
	
    "padding-top": "0px",
    });
    
    
	</script>
	<?php

}

add_action('admin_footer', 'remove_error_from_admin');

 ?>