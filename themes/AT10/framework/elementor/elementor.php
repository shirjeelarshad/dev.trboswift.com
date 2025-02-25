<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


// GLOBOAL FOOTER FOR CPAGE TEMPLATE CANVUS
add_action(
	'elementor/page_templates/canvas/after_content', function() { global $CORE;
	?>

<?php _ppt_template( 'footer', 'codes' );  ?>

    <?php
	}
);
 

 
//add_action('elementor/widgets/widgets_registered', 'custom_unregister_elementor_widgets');
function custom_unregister_elementor_widgets($obj){
	$elementor_widget_blacklist = array('image','icon','maps');
 
	foreach($elementor_widget_blacklist as $widget_name){
    $obj->unregister_widget_type($widget_name);
  }
 
}


 
 
add_action(
	'elementor/init', function() {
		\Elementor\Plugin::$instance->elements_manager->add_category(
			'premiumpress-new',
			[
				'title' => __( 'PremiumPress V.'.THEME_VERSION, 'premiumpress' ),
				'icon' => 'fa fa-plug',
			],
			1
		);
	}
);


 if( defined('WLT_DEMOMODE') ){
 
add_action(
	'elementor/page_templates/canvas/after_content', function() { global $CORE;
	
	//<style><?php echo $CORE->LAYOUT("load_css", array()); </style>
	?>
    
    
    
    
    
	 <?php if(isset($_GET['preview'])){ ?>
	<script>
		jQuery(document).ready(function() {
		 
		// ADD ADMINIATION TO BLOCKS	
		var code = "";
		var keycode = "";
		var i = 1;
		jQuery('textarea').each(function () {
		
		
		type = jQuery(this).data('key');
		cat = jQuery(this).data('cat');
		
				 
		if(cat != "header" && cat != "footer"  && typeof type != 'undefined'){
			
			keycode = keycode + "$core['design']['slot"+i+"_style'] = \""+type+"\";\n";	
			i++;
		
		}
		
		if(cat == "header"){
			keycode = keycode + "$core['design']['header_style'] = \""+type+"\";\n";	
		}
		
		if(cat == "footer"){
			keycode = keycode + "$core['design']['footer_style'] = \""+type+"\";\n";	
		}
		 
											 
		code = code + jQuery(this).val()+'\n';	
					   
		
		
		});
		
		
		while(i < 10){ 
		
		keycode = keycode + "$core['design']['slot"+i+"_style'] = '';\n";
		
		i++;
		}
		
		
		jQuery('.addtooutput').each(function () {
		
		key = jQuery(this).data('key');
		value = jQuery(this).val();
		
		keycode = keycode + "$core['design']['" + key +"'] = \""+value+"\";\n";	
		
		
		}); 
		
		
		
		jQuery('#finishedoutput').val(keycode +' \n'+code);
	
	 
	});
	</script>
   
    <hr />
    <div class="bg-dark p-3 text-light">Output code for child themes.</div>
	<textarea style="width:100%; height:600px;" id="finishedoutput"></textarea>
	<?php
	}
	
	}
);

}

final class Elementor_Test_Extension {

	private static $_instance = null;
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}
	public function __construct() {

		add_action( 'init', [ $this, 'init' ] );
	 

	}
	
	function theme_prefix_register_elementor_locations( $elementor_theme_manager ) {

		$elementor_theme_manager->register_location( 'header' );
		$elementor_theme_manager->register_location( 'footer' ); 
	}

 
	public function init() {
 

		// Include plugin files
		$this->includes();
		 	
		// Register Theme locations
		add_action( 'elementor/theme/register_locations', [ $this, 'theme_prefix_register_elementor_locations' ] );
		
		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
 	
		// Display Default Styles
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'enqueue_site_styles' ] );
		add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'enqueue_site_scripts' ] );
		
		// EDITOR
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
		 
		
	 	// PREVIEW
		add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_preview_styles' ] );
 
		
		// IN LIVE PREVIEW MODE
		add_action( 'elementor/frontend/before_register_styles', [ $this, 'frontend_styles' ] );

	  	
		// SAVE WIDGET
		add_action( 'elementor/widget/render_content',  [ $this, '_elementor_widget_render' ]  , 10, 3 );
	 		 
	 	
	} 
 
		
	function _elementor_widget_render($content, $widget){ global $CORE;
		
		
		$settings = $widget->get_settings();
		if(isset($settings['type'])){
		switch($settings['type']){
			
			case "header": {
			 
			
			$custom_css =  $CORE->LAYOUT("get_color", array("primary") ); 
			$custom_css .=  $CORE->LAYOUT("get_color", array("secondary") );	
		  
			echo "<style>".$CORE->LAYOUT("load_css", array()).$custom_css."</style>";
			
			} break;
		
		}	  
		}
		   
		return $content;
	
	}
 
 	
	// PREVIEW WINDOW STYLES
	// WHENE DITING
	public function enqueue_preview_styles(){ global $CORE;
 		
		$GLOBALS['NOFOOTERSTYLES'] = 1;
		
	
 		if($CORE->GEO("is_right_to_left", array() )){ 
			wp_register_style( 'ppt-bootstrap', FRAMREWORK_URI.'css/_bootstrap-rtl.css', [], 1 );
		}else{
			wp_register_style( 'ppt-bootstrap', FRAMREWORK_URI.'css/_bootstrap.css', [], 1 );
		}
		
		wp_enqueue_style('ppt-bootstrap'); 
		
	 	wp_register_style( 'ppt-styles', FRAMREWORK_URI.'css/css.premiumpress.css', [], 1 );
		wp_enqueue_style('ppt-styles'); 		
		
		wp_enqueue_script( 'premiumpress-js', FRAMREWORK_URI.'elementor/js/premiumpress.js', array(), 1 );
		 
		// OUTPUT STYLES
		?><style><?php  echo $CORE->LAYOUT("load_css", array()); ?></style><?php 	
			
		
 		
	}	
	
	
	public function enqueue_editor_styles(){ global $CORE;		
		
		// LOADED WHENE EDITING
		wp_register_style( 'ppt-elementor-admin', FRAMREWORK_URI.'elementor/css/elementor-admin.css', [], 1 );
		wp_enqueue_style('ppt-elementor-admin');
			
		 
	}
	
	public function frontend_styles() { global $CORE;
	 	
		
		// THIS IS FOR THE LIVE PREVIEW MODE
		if(isset($_GET['preview_id']) && is_numeric($_GET['preview_id']) ){
			
			if($CORE->GEO("is_right_to_left", array() )){ 
			wp_register_style( 'ppt-bootstrap', FRAMREWORK_URI.'css/_bootstrap-rtl.css', [], 1 );
			}else{
			wp_register_style( 'ppt-bootstrap', FRAMREWORK_URI.'css/_bootstrap.css', [], 1 );
			}
			
			wp_enqueue_style('ppt-bootstrap'); 
			
			wp_register_style( 'ppt-styles', FRAMREWORK_URI.'css/css.premiumpress.css', [], 1 );
			wp_enqueue_style('ppt-styles'); 		
			
			wp_enqueue_script( 'premiumpress-js', FRAMREWORK_URI.'elementor/js/premiumpress.js', array(), 1 );	
			 
		 
		}
		 		 
		 
	}
	/**
	 * Register all script that need for any specific widget on call basis.
	 * @return [type] [description]
	 */
	public function enqueue_editor_scripts() {
	
	
	 
		wp_enqueue_script( 'premiumpress-editor', FRAMREWORK_URI.'elementor/js/editor.js', array(), 1 );
		
		// OUTPUT STYLES
		?><script>var ajax_site_url = "<?php echo home_url(); ?>/index.php";  </script><?php 
		
		
	}

	/**
	 * Loading site related style from here.
	 * @return [type] [description]
	 */
	public function enqueue_site_styles() {

		
		
		
		
	}

	/**
	 * Loading site related script that needs all time such as uikit.
	 * @return [type] [description]
	 */
	public function enqueue_site_scripts() {
		 wp_enqueue_script( 'premiumpress-js', FRAMREWORK_URI.'elementor/js/premiumpress.js', array(), 1 );
 
		//wp_enqueue_script( 'premiumpress-js', FRAMREWORK_URI.'elementor/js/elementor.js', ['jquery', 'elementor-frontend'], 1 );
		
 
	}
 
	public function includes() {
 		
		// NEW IN 4.4.4
		require_once( THEME_PATH . '/framework/elementor/elementor-premiumpress.php' ); 
		
	}
	
	public function register_widgets() {

		// NEW IN 4.4.4.
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Widget_PremiumPress_New_Hero() ); 
		
	}
 

}

Elementor_Test_Extension::instance(); 
?>