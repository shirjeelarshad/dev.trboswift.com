<?php
 
add_action( 'et_builder_ready', 'evr_initialize_divi_modules' );


add_action( 'admin_enqueue_script', 'divi_editor_scripts' ); 
 
function divi_editor_scripts() {
	
 	 
	wp_enqueue_script( 'premiumpress-divi-editor', FRAMREWORK_URI.'divi/js/editor.js', array(), 1 );
		
	// OUTPUT STYLES
	?><script>var ajax_site_url = "<?php echo home_url(); ?>/index.php";  </script><?php 

}


function evr_initialize_divi_modules() {
	if ( ! class_exists( 'ET_Builder_Module' ) ) { return; }

	
	class EVR_Builder_Module_PremiumPress extends ET_Builder_Module {
		
		public $slug       = 'divi_premiumpress';
		public $vb_support = 'partial';
		
		
		
	
		function init() {
		
			$this->name       = esc_html__( 'PremiumPress', 'premiumpress_divi' );
			$this->slug       = 'divi_premiumpress';
		 
			$this->advanced_options = array(
				'border'                => array(),
				'custom_margin_padding' => array(
					'use_padding' => false,
					'css' => array(
						'important' => 'all',
					),
				),
			);
			
			
 
		    
		}
		
		
	function footer(){	 ?>
		
        <script>
		jQuery(document).ready(function() {	
		 
			 // QUICK FIX FOR LAZY IMAGES
			 jQuery("img").each(function() { 
				   
				   var imgsrc = jQuery(this).attr('data-src');				   
				   if(imgsrc != ""){		   
				   jQuery(this).attr('src', imgsrc);
				   }			   
			 }); 
		  
			// CUSTOM BACKGROUNDS 
			var a = jQuery(".bg-image");
			a.each(function (a) {
				if (jQuery(this).attr("data-bg")) jQuery(this).css("background-image", "url(" + jQuery(this).data("bg") + ")");
			});
			
			// CUSTOM PATTERNS
			var a = jQuery(".bg-pattern");
			a.each(function (a) {
				if (jQuery(this).attr("data-bg")) jQuery(this).css("background-image", "url(" + jQuery(this).data("bg") + ")");
			});
		
			// CUSTOM PATTERNS
			var a = jQuery(".bg-pattern-small");
			a.each(function (a) {
				if (jQuery(this).attr("data-bg")) jQuery(this).css("background-image", "url(" + jQuery(this).data("bg") + ")");
			});
			
		 
		}); 
		 
		</script>	
		 
	<?php }  	
		
	
 
		function get_fields() { global $CORE;
		
		
			// BLOCK TYPES
			$block_types 	= array();
			$block_types[''] = "Select Category...";
			
			$fields 		= array(); 		
				
			foreach($CORE->LAYOUT("get_block_types",array()) as $t){ 
				$block_types[$t['id']] = $t['name']; 
			}
			
		
		
		 	$fields['type'] = array(
				'label'           => esc_html__( 'Block Category', 'premiumpress_divi' ),
				
				'type'            => 'select',
				
				'option_category' => 'basic_option',
				'options'         => $block_types,
				  
				 
				'default' => '',
				
				'toggle_slug' => 'sec_main',
			);
			
			// BUILD TYPE BLOCKA
			foreach($block_types as $typeid => $type){
		
				// GET DATA
				$g = $CORE->LAYOUT("load_all_by_cat", $typeid);			 
				
				if(in_array($g, array('text','icon','listings','header','footer','cta','contact','video','faq','store' ))){
				$order = array_column($g, 'order'); 
				array_multisort( $order, SORT_ASC, $g);
				}
				
				$k = array();
				$k[''] = "Select Design...";
				foreach($g as $l => $j){
					$k[$l] = $j['name'];
				}
				
				$fields[$typeid.'_style'] = array(
					'label' 			=> __('Block Layout', 'premiumpress' )." (".$typeid.")",
					'type'            	=> 'select',					
					'options' 			=> $k,	
					'option_category' => 'basic_option',					
					 
					'show_if'         => array(
						'type' => array( $typeid ),
					),
					
					'default' => '',
					
					'toggle_slug' => 'sec_main',
					
				);
				 
					 
		
			}// end types
			
	
	
	
			/*-------------------------------------------------------------------------------------*/			
			/** GLOBAL ****************************************************************************/
			/*-------------------------------------------------------------------------------------*/
	
	
 		
		$fields['title_show'] = array(
		
				'label'   => esc_html__( 'Title &amp; Description', 'premiumpress' ),
				
				'type'    => "select",				
				'options' => array( 
					"" 		=> "",
					"yes" 	=> "Show",
					"no" 	=> "Hide",							 
				),
				 
				'toggle_slug' => 'sec_main',
				 
				'default' => 'yes',
			 	 
				'conditions' => [						 
							'terms' => [
								[
									'name' => 'type',
									'operator' => '!=',
									'value' => 'header'
								],
								[
									'name' => 'type',
									'operator' => '!=',
									'value' => 'footer'
								],
								[
									'name' => 'type',
									'operator' => '!=',
									'value' => 'search'
								],
								[
									'name' => 'type',
									'operator' => '!=',
									'value' => 'listingpage'
								],
								[
									'name' => 'type',
									'operator' => '!=',
									'value' => ''
								]							 
							]
						]  
			 
		);	
	
			
	

		$fields['btn_show'] = array('label'   => esc_html__( 'Button 1', 'premiumpress' ),
				'type'    => "select",				
				'options' => array( 
					"" 		=> "",
					"yes" 	=> "Show",
					"no" 	=> "Hide",							 
				),
				'default' => 'yes',
				'condition' => ['type' => array('text','cta','header','faq','hero','icon','video')  ],
				
				'toggle_slug' => 'sec_main',
			 
		);
		
		
		$fields['btn2_show'] = array('label'   => esc_html__( 'Button 2', 'premiumpress' ),
				'type'    => "select",				
				'options' => array( 
					"" 		=> "",
					"yes" 	=> "Show",
					"no" 	=> "Hide",							 
				),
				'default' => 'yes',
				'condition' => ['type' => array('hero','text','icon','video')  ],
				
				'toggle_slug' => 'sec_main',
			 
		);	
				
				
				
			/*-------------------------------------------------------------------------------------*/			
			/** HEADER ****************************************************************************/
			/*-------------------------------------------------------------------------------------*/
		 
		
		$fields['topmenu_show'] = array(
		
			'label'   => esc_html__( 'Show Top Menu', 'premiumpress' ),
				
				'type'    => "select",				
				'options' => array( 
					"" 		=> "",
					"yes" 	=> "Show",
					"no" 	=> "Hide",							 
				),
				'default' => 'yes',
				
				'toggle_slug' => 'sec_header',
			 
		);
			$fields['extra_show'] = array(
			
			'label'   => esc_html__( 'Show Extra', 'premiumpress' ),
			'type'    => "select",				
				'options' => array( 
					"" 		=> "",
					"yes" 	=> "Show",
					"no" 	=> "Hide",							 
				),
				'default' => 'yes',
				
				'toggle_slug' => 'sec_header',
			 
		);
		
		$fields['extra_type'] = array(
		
				'label'   => esc_html__( 'Extra Type', 'premiumpress' ),
				'type'    => "select",				
				'options' => array( 
					"" 			=> "Phone",
					"icons" 	=> "Icons",
					"button" 	=> "Button",
					 						 
				),
				'default' => '',
				
				'toggle_slug' => 'sec_header',
			 
		);

	
	
	
			/*-------------------------------------------------------------------------------------*/			
			/** TITLE ****************************************************************************/
			/*-------------------------------------------------------------------------------------*/


		$fields['title_pos'] = array(
				'label' => __( 'Position', 'premiumpress' ),
				'type'            => 'select',
				 'options' => array(
				
				"left" 		=> "Left",
				"right" 	=> "Right",
				"center" 	=> "Center", 
				
				),
				'default' => 'left',
				//'condition' => ['title_show' => "yes"],
				
				
				'toggle_slug' => 'sec_title',
				
		);
		
		$fields['title_heading'] = array(
				'label' => __( 'Heading', 'premiumpress' ),
				'type'            => 'select',
				 'options' => array(
				
				"h1" 	=> "H1",
				"h2" 	=> "H2",
				"h3" 	=> "H3", 
				"h4" 	=> "H4", 
				
				),
				'default' => 'h2',
				
				
				'toggle_slug' => 'sec_title',
				
				
		);
		
		
		
		$fields['title_style'] = array(
				'label' => __( 'Title Style', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
				
				"1" 			=> "Style 1",
				"2" 			=> "Style 2",
				"3" 			=> "Style 3",
				"4" 			=> "Style 4",
 				
				),
				'default' => '2',
				//'condition' => ['title_show' => "yes"],
				"description" => "<br><hr><br>",
				
				'toggle_slug' => 'sec_title',
				
				
		);	
		$fields['title'] = array(
				'label' 	=> __( 'Title', 'premiumpress' ),
				'type'            => 'textarea',
				'default' 	=> "",			 
				
				
				'toggle_slug' => 'sec_title',
		);
		$fields['title_font'] = array(
				'label' => __( 'Font', 'premiumpress' ),
				'type'            => 'select',
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				
				
				'toggle_slug' => 'sec_title',
		);
		
		
		$fields['title_margin'] = array(
				'label' => __( 'Margin Bottom', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'mb-0' => "0px",
					'mb-1' => "10px",
					'mb-2' => "20px",
					'mb-3' => "30px" ,
					'mb-4' => "40px",
					'mb-5' => "50px",					
				),
				
				'default' => 'mb-4',
				
				
				'toggle_slug' => 'sec_title',
		);
		
		$fields['title_txtcolor'] = array(
				'label' => __( 'Color', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
					'white' 	=> "White", 
					'black' 	=> "Black", 
					
					'light' 	=> "Light",
					'dark' 		=> "Dark",
					 
					"primary" 	=> "Primary Color", 
					"secondary" => "Secondary Color"
					 
					 
				),
				'default' => 'dark',
				
				
				'toggle_slug' => 'sec_title',
		);	
		
		$fields['title_txtw'] = array(
				'label' => __( 'Bold', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
				
					'font-weight-normal' 	=> "Normal", 
					'font-weight-bold' 		=> "Bold", 
					
					'text-300' 	=> "300",
					'text-500' 	=> "500",
					'text-700' 	=> "700",
					'text-800' 	=> "800",
					'text-900' 	=> "900",
					
					 
				),
				'default' => 'font-weight-bold',
				//'condition' => ['title_show' => "yes" ],
				"description" => "<br><hr><br>",
				
				'toggle_slug' => 'sec_title',
		);	
			
		
		$fields['subtitle'] = array(
				'label' => __( 'Subtitle', 'premiumpress' ),
				'type'            => 'textarea',	
				'default' 	=> "",				
				
				'toggle_slug' => 'sec_title',
		);	
		
		$fields['subtitle_font'] = array(
				'label' => __( 'Font', 'premiumpress' ),
				'type'            => 'select',
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				
				
				'toggle_slug' => 'sec_title',
		);
		
		$fields['subtitle_margin'] = array(
				'label' => __( 'Margin Bottom', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'mb-0' => "0px",
					'mb-1' => "10px",
					'mb-2' => "20px",
					'mb-3' => "30px" ,
					'mb-4' => "40px",
					'mb-5' => "50px",
					
				),
				
				'default' => 'mb-4',
				'toggle_slug' => 'sec_title',
				
		);	
		$fields['subtitle_txtcolor'] = array(
				'label' => __( 'Color', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
					'white' 	=> "White", 
					'black' 	=> "Black", 
					
					'light' 	=> "Light",
					'dark' 		=> "Dark",
					 
					"primary" 	=> "Primary Color", 
					"secondary" => "Secondary Color"
				),
				'default' => 'dark',
				'toggle_slug' => 'sec_title',
		);	
		
		$fields['subtitle_txtw'] = array(
				'label' => __( 'Bold', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
				
					'font-weight-normal' 	=> "Normal", 
					'font-weight-bold' 		=> "Bold", 
					
					'text-300' 	=> "300",
					'text-500' 	=> "500",
					'text-700' 	=> "700",
					'text-800' 	=> "800",
					'text-900' 	=> "900",
					
					 
				),
				'default' => 'font-weight-bold',
				//'condition' => ['title_show' => "yes" ],
				"description" => "<br><hr><br>",
				
				'toggle_slug' => 'sec_title',
		);	
		
		$fields['desc'] = array(
				'label' => __( 'Description', 'premiumpress' ),
				'type'            => 'textarea',	
				'default' 	=> "",									
				
				'toggle_slug' => 'sec_title',
				
		);
		$fields['desc_font'] = array(
				'label' => __( 'Font', 'premiumpress' ),
				'type'            => 'select',
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				
				'toggle_slug' => 'sec_title',
				
		);
		$fields['desc_margin'] = array(
				'label' => __( 'Margin Bottom', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'mb-0' => "0px",
					'mb-1' => "10px",
					'mb-2' => "20px",
					'mb-3' => "30px" ,
					'mb-4' => "40px",
					'mb-5' => "50px",
					
				),
				
				'default' => 'mb-4',
				
				'toggle_slug' => 'sec_title',
				
		);
		$fields['desc_txtcolor'] = array(
				'label' => __( 'Color', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
					'white' 	=> "White", 
					'black' 	=> "Black", 
					
					'light' 	=> "Light",
					'dark' 		=> "Dark",
					 
					"primary" 	=> "Primary Color", 
					"secondary" => "Secondary Color",
					
					"opacity-5" => "50% Black"
				),
				'default' => 'opacity-5',
				
				'toggle_slug' => 'sec_title',
		);
		
		
		
		
			/*-------------------------------------------------------------------------------------*/			
			/** HERO ****************************************************************************/
			/*-------------------------------------------------------------------------------------*/

	 
	
		
		
	// GLOBAL IMAGE
		$fields['hero_size'] = array(
		
					'label' => __( 'Size', 'premiumpress' ),
					'type' => 'select', 
					'options' => array( 
							"hero-small" 	=> "Slim (400px)",
							"hero-medium" 	=> "Medium (500px)",
							"hero-large" 	=> "Large (800px)",
							"hero-full" 	=> "Full Page",
							) ,
					'default' => 'hero-medium',
					'condition' => ['type' => array('hero')],
					
					'toggle_slug' => 'sec_hero',
				
		);
		
		$fields['hero_txtcolor'] = array(
		
					'label' => __( 'Menu Color', 'premiumpress' ),
					'type' => 'select', 
					'options' => array( 
							"dark" 	=> "Dark",
							"light" 	=> "Light",
							 
							) ,
					'default' => 'light',
					'condition' => ['type' => array('hero')],
					
					'toggle_slug' => 'sec_hero',
				
		);		
		// GLOBAL IMAGE
		$fields['hero_image'] = array(
		
					'label' => __( 'Image', 'premiumpress' ),
					
					'type'               => 'upload',
					'option_category'    => 'basic_option',
					'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
					'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
					'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
					'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'et_builder' ), 
						 
					'condition' => ['type' => array('hero')],
					
					'toggle_slug' => 'sec_hero',
				
		);
		
		


	
			/*-------------------------------------------------------------------------------------*/			
			/** BUTTON 1 ****************************************************************************/
			/*-------------------------------------------------------------------------------------*/

	 
			
		$fields['div_panel_alert3'] = array(
				//'label' => __( 'Block Type 1', 'premiumpress' ),
				'type'            => 'hidden',				 
				'raw' => '<script>ppt_update_panel("btn");</script>',
		);	
	 
		
		$fields['btn_txt'] = array(
				'label' => __( 'Caption', 'premiumpress' ),
				'type'            => 'text',
				'default' => 'Search Website',				
				'condition' => ['btn_show' => "yes"  ],
				
				'toggle_slug' => 'sec_btn1',
				
		);
		$fields['btn_link'] = array(
				'label' => __( 'Link', 'premiumpress' ),
				'type'            => 'text',
				'placeholder' => __( 'https://', 'premiumpress' ),
				
				'toggle_slug' => 'sec_btn1',
		);
		
		$fields['btn_size'] = array(
				'label' => __( 'Size', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'btn-sm' => "Small",
					'btn-md' => "Medium",
					'btn-lg' => "Large" ,
					'btn-xl' => "Extra Large",
				),
				
				'default' => 'btn-md',
				
				'toggle_slug' => 'sec_btn1',
		);
		
		$fields['btn_font'] = array(
				'label' => __( 'Font', 'premiumpress' ),
				'type'            => 'select',
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				
				'toggle_slug' => 'sec_btn1',
		);
		
		$fields['btn_style'] = array(
				'label' => __( 'Style', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					"1" 	=> "Normal",
					"2" 	=> "Outlined",	
					"3" 	=> "Normal Rounded",	
					"4" 	=> "Outlined Rounded",
					
					"5" 	=> "Square Edges",
					 
				),
				
				'default' => '1',
				
				'toggle_slug' => 'sec_btn1',
		);
		
		$fields['btn_margin'] = array(
				'label' => __( 'Margin Top', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'mt-0' => "0px",
					'mt-1' => "10px",
					'mt-2' => "20px",
					'mt-3' => "30px" ,
					'mt-4' => "40px",
					'mt-5' => "50px",
					
				),
				
				'default' => 'mt-0',
				
				'toggle_slug' => 'sec_btn1',
		);
			
		$fields['btn_icon'] = array(
				'label' => __( 'Icon', 'premiumpress' ),
				//'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => '', 
				],
				
				'toggle_slug' => 'sec_btn1',
		);
		$fields['btn_icon_pos'] = array(
				'label' => __( 'Icon Position', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array('before' => "Before",'after' => "After" ),
				'default' => 'before',
				
				'toggle_slug' => 'sec_btn1',
		);
		$fields['btn_bg'] = array(
				'label' => __( 'Button Color', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'primary' 	=> "Primary Color",
					'secondary' => "Secondary Color",
					'light' 	=> "Light Color" ,
					'dark' 		=> "Dark Color",
				),
				
				'default' => 'primary',
				'toggle_slug' => 'sec_btn1',
		);	
		
		$fields['btn_bg_txt'] = array(
				'label' => __( 'Text Color', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array('text-dark' => "Dark",'text-light' => "Light" ),
				'default' => 'text-light',
				 
				
				'toggle_slug' => 'sec_btn1',
				
		);	
	
	
		/*-------------------------------------------------------------------------------------*/			
		/** BUTTON 2 ****************************************************************************/
		/*-------------------------------------------------------------------------------------*/

	
	 
		$fields['div_panel_alert4'] = array(
				//'label' => __( 'Block Type 1', 'premiumpress' ),
				'type'            => 'hidden',				 
				'raw' => '<script>ppt_update_panel("btn2");</script>',
		);	
		
		
		
		$fields['btn2_txt'] = array(
				'label' => __( 'Caption', 'premiumpress' ),
				'type'            => 'text',
				'placeholder' => 'Join Now',				
				'condition' => ['btn2_show' => "yes"  ],
				
				'toggle_slug' => 'sec_btn2',
				
		);
		$fields['btn2_link'] = array(
				'label' => __( 'Link', 'premiumpress' ),
				'type'            => 'text',
				'placeholder' => __( 'https://', 'premiumpress' ),
				'condition' => ['btn2_show' => "yes" ],
				
				'toggle_slug' => 'sec_btn2',
		);
		
		$fields['btn2_size'] = array(
				'label' => __( 'Size', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'btn-sm' => "Small",
					'btn-md' => "Medium",
					'btn-lg' => "Large" ,
					'btn-xl' => "Extra Large",
				),
				
				'default' => 'btn-md',
				'condition' => ['btn2_show' => "yes" ],
				
				'toggle_slug' => 'sec_btn2',
		);
		
		$fields['btn2_font'] = array(
				'label' => __( 'Font', 'premiumpress' ),
				'type'            => 'select',
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				'condition' => ['btn2_show' => "yes"],
				
				'toggle_slug' => 'sec_btn2',
		);
		
		$fields['btn2_style'] = array(
				'label' => __( 'Style', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
				
					"1" 	=> "Normal",
					"2" 	=> "Outlined",	
					"3" 	=> "Normal Rounded",	
					"4" 	=> "Outlined Rounded",
					 "5" 	=> "Square Edges",
				),
				
				'default' => '1',
				'condition' => ['btn2_show' => "yes" ],
				
				'toggle_slug' => 'sec_btn2',
		);	
		
		$fields['btn2_margin'] = array(
				'label' => __( 'Margin Top', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'mt-0' => "0px",
					'mt-1' => "10px",
					'mt-2' => "20px",
					'mt-3' => "30px" ,
					'mt-4' => "40px",
					'mt-5' => "50px",
					
				),
				
				'default' => 'mt-0',
				'condition' => ['btn2_show' => "yes" ],
				
				'toggle_slug' => 'sec_btn2',
		);
		$fields['btn2_icon'] = array(
				'label' => __( 'Icon', 'premiumpress' ),
				//'type' => \Elementor\Controls_Manager::ICONS,
				'condition' => ['btn2_show' => "yes" ],
				
				'toggle_slug' => 'sec_btn2',
		);
		$fields['btn2_icon_pos'] = array(
				'label' => __( 'Icon Position', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array('before' => "Before",'after' => "After" ),
				'default' => 'before',
				'condition' => ['btn2_show' => "yes" ],
				
				'toggle_slug' => 'sec_btn2',
		);
		$fields['btn2_bg'] = array(
				'label' => __( 'Button Color', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'primary' 	=> "Primary Color",
					'secondary' => "Secondary Color",
					'light' 	=> "Light Color" ,
					'dark' 		=> "Dark Color",
				),
				
				'default' => 'primary',
				'condition' => ['btn2_show' => "yes" ],
				
				'toggle_slug' => 'sec_btn2',
		);	
		
		$fields['btn2_bg_txt'] = array(
				'label' => __( 'Text Color', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array('text-dark' => "Dark",'text-light' => "Light" ),
				'default' => 'text-light',
				
				
				'toggle_slug' => 'sec_btn2',
		);	
		
	
 	
	
	
			
			/*-------------------------------------------------------------------------------------*/			
			/** FAQ ****************************************************************************/
			/*-------------------------------------------------------------------------------------*/

/*
	
		$i=1; while($i < 7){ 
	   $this->end_controls_section();	
 
		
		$ttt = $i;
		$ttt = $ttt - 1;
		
		if($i == 1){ 


		   $this->start_controls_section(
					'faq_section'.$i,
					[
						'label' => __( 'FAQ '.$i, 'premiumpress' ),						
						'conditions' => [						 
							'terms' => [
								 
								[
									'name' 		=> 'type',
									'operator' 	=> '==',
									'value' 	=> 'faq'
								]							 
							]
						] 					 
					]
			);  
		
		
		}else{		
		
	   
		   $this->start_controls_section(
					'faq_section'.$i,
					[
						'label' => __( 'FAQ '.$i, 'premiumpress' ),						
						'conditions' => [						 
							'terms' => [
								[
									'name' => 'faq_title'.$ttt,
									'operator' => '!=',
									'value' => ''
								],
								[
									'name' => 'type',
									'operator' => '==',
									'value' => 'faq'
								]							 
							]
						] 					 
					]
			); 
		
		}
		
		
 
		
		$fields['faq_title'.$i,
			[
				'label' => __( 'Title', 'premiumpress' ),
				'type'            => 'text',
				'default' => __( '', 'premiumpress' ),
				'placeholder' => "",
				'condition' => ['type' => 'faq' ],
		);
		
 		$fields['faq_desc'.$i,
			[
				'label' => __( 'Description', 'premiumpress' ),
				'type'            => 'textarea',
				'default' => __( '', 'premiumpress' ),
				'placeholder' => "",
				'condition' => ['type' => 'faq' ],
		);
		
		$i++; } 		
			
			
*/		
 
		
				/*-------------------------------------------------------------------------------------*/			
				/** CATEOGYR ****************************************************************************/
				/*-------------------------------------------------------------------------------------*/
	
/*
		
		
		   $this->start_controls_section(
					'category_block_section',
					[
						'label' => __( 'Category Settings', 'premiumpress' ),						
						'condition' => ['type' => 'category' ],					 
					]
			); 
		
   $this->add_control(
            'cat_show',
            [
                'label' => __( 'Display Amount', 'premiumpress' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '16',
				'condition' => ['type' => 'category' ],
            ]
        );
		
		
		
        $this->add_control(
            'cat_offset',
            [
                'label' => __( 'Offset Amount', 'premiumpress' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '0',
				'condition' => ['type' => 'category' ],
            ]
        );
 
		
		   $this->add_control(
            'cat_show_list',
            [
                'label' => __( 'List Items', 'premiumpress' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '5',
				'condition' => ['type' => 'category' ],
            ]
        );
		
*/		
		
 
				/*-------------------------------------------------------------------------------------*/			
				/** IMAGE BLOCK ****************************************************************************/
				/*-------------------------------------------------------------------------------------*/

	
/*

		
		$i=1; while($i < 7){ 
	   $this->end_controls_section();	
 
		$ttt = $i;
		$ttt = $ttt - 1;
		
		if($i == 1){ 


		   $this->start_controls_section(
					'image_block_section'.$i,
					[
						'label' => __( 'Image', 'premiumpress' )." ".$i,						
						'conditions' => [						 
							'terms' => [
								 
								[
									'name' 		=> 'type',
									'operator' 	=> '==',
									'value' 	=> 'image_block'
								]							 
							]
						] 					 
					]
			);  
		
		
		}else{		
		
	   
		   $this->start_controls_section(
					'image_block_section'.$i,
					[
						'label' => __( 'Image', 'premiumpress' )." ".$i,						
						'conditions' => [						 
							'terms' => [
								[
									'name' => 'image_block'.$ttt."_title",
									'operator' => '!=',
									'value' => ''
								],
								[
									'name' => 'type',
									'operator' => '==',
									'value' => 'image_block'
								]							 
							]
						] 					 
					]
			); 
		
		}
			
 
		
		$fields['image_block'.$i,
			[
				'label' => __( 'Image', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => ['type' => 'image_block' ],
		); 
		
			$fields['image_block'.$i."_effect'] = array(
				'label' => __( 'Effect', 'premiumpress' ),
				'type'            => 'select',
				'options' => array("1" => "1", "2" => "2  - line (dark)" ,"3" => "3 - line (light)", "4" => "4", "5" => "5 - blank" ),
				'default' => '1',
				'condition' => [ 'type' => 'image_block' ],
		);	
		
		
		$fields['image_block'.$i."_txtpos'] = array(
				'label' => __( 'Text Location', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
					'tleft' => "Top Left",
					"tright" => "Top Right",
					"tcenter" => "Top Centered",
					
					'ccenter' => "Centered", 
					
					'bleft' => "Bottom Left",
					"bright" => "Bottom Right",
					"bcenter" => "Bottom Centered",
					
				),
				'default' => 'left',
				'condition' => ['type' => 'image_block' ],
				"description" => "<br><hr><br>",
		);	
		
	
		$fields['image_block'.$i.'_title'] = array(
				'label' 	=> __( 'Title', 'premiumpress' ),
				'type'            => 'textarea',
				'default' 	=> "",				 
				'condition' => [ 'type' => 'image_block' ],
				
		);
		$fields['image_block'.$i.'_title_font'] = array(
				'label' => __( 'Font', 'premiumpress' ),
				'type'            => 'select',
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				'condition' => [ 'type' => 'image_block' ],
		);
		
		$fields['image_block'.$i.'_title_txtsize'] = array(
				'label' => __( 'Title Size', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
				
					'sm' => "Small",
					'md' => "Medium",
					'lg' => "Large" ,
					'xl' => "Extra Large",
 					'xxl' => "Extra Extra Large",
				),
				'default' => 'md',
				'condition' => [ 'type' => 'image_block' ],
		);
		
		$fields['image_block'.$i.'_title_margin'] = array(
				'label' => __( 'Margin Bottom', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'mb-0' => "0px",
					'mb-1' => "10px",
					'mb-2' => "20px",
					'mb-3' => "30px" ,
					'mb-4' => "40px",
					'mb-5' => "50px",					
				),
				
				'default' => 'mb-4',
				'condition' => [ 'type' => 'image_block' ],
		);
		$fields['image_block'.$i.'_title_txtcolor'] = array(
				'label' => __( 'Color', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
					'white' 	=> "White", 
					'black' 	=> "Black", 
					
					'light' 	=> "Light",
					'dark' 		=> "Dark",
					 
					"primary" 	=> "Primary Color", 
					"secondary" => "Secondary Color"
					 
					 
				),
				'default' => 'dark',
				'condition' => [ 'type' => 'image_block' ],
		);	
		$fields['image_block'.$i.'_title_txtw'] = array(
				'label' => __( 'Bold', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
				
					'font-weight-normal' 	=> "Normal", 
					'font-weight-bold' 		=> "Bold", 
					
					'text-300' 	=> "300",
					'text-500' 	=> "500",
					'text-700' 	=> "700",
					'text-800' 	=> "800",
					'text-900' 	=> "900",
					
					 
				),
				'default' => 'font-weight-bold',
				'condition' => [ 'type' => 'image_block' ],
				"description" => "<br><hr><br>",
		);	
			
		
		$fields['image_block'.$i.'_subtitle'] = array(
				'label' => __( 'Subtitle', 'premiumpress' ),
				'type'            => 'textarea',	
				'default' 	=> "",				
				'condition' => [ 'type' => 'image_block' ],
		);	
		
		$fields['image_block'.$i.'_subtitle_txtsize'] = array(
				'label' => __( 'Subtitle Size', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
				
					'sm' => "Small",
					'md' => "Medium",
					'lg' => "Large" ,
					'xl' => "Extra Large",
					'xxl' => "Extra Extra Large",
 				
				),
				'default' => 'md',
				'condition' => [ 'type' => 'image_block' ],
		);
		
		$fields['image_block'.$i.'_subtitle_font'] = array(
				'label' => __( 'Font', 'premiumpress' ),
				'type'            => 'select',
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				'condition' => [ 'type' => 'image_block' ],
		);
		
		$fields['image_block'.$i.'_subtitle_margin'] = array(
				'label' => __( 'Margin Bottom', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'mb-0' => "0px",
					'mb-1' => "10px",
					'mb-2' => "20px",
					'mb-3' => "30px" ,
					'mb-4' => "40px",
					'mb-5' => "50px",
					
				),
				
				'default' => 'mb-4',
				'condition' => [ 'type' => 'image_block' ],
		);	
		$fields['image_block'.$i.'_subtitle_txtcolor'] = array(
				'label' => __( 'Color', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
					'white' 	=> "White", 
					'black' 	=> "Black", 
					
					'light' 	=> "Light",
					'dark' 		=> "Dark",
					 
					"primary" 	=> "Primary Color", 
					"secondary" => "Secondary Color"
				),
				'default' => 'dark',
				'condition' => [ 'type' => 'image_block' ],
		);	
		
		$fields['image_block'.$i.'_subtitle_txtw'] = array(
				'label' => __( 'Bold', 'premiumpress' ),
				'type'            => 'select',
				
				'options' => array(
				
					'font-weight-normal' 	=> "Normal", 
					'font-weight-bold' 		=> "Bold", 
					
					'text-300' 	=> "300",
					'text-500' 	=> "500",
					'text-700' 	=> "700",
					'text-800' 	=> "800",
					'text-900' 	=> "900",
					
					 
				),
				'default' => 'font-weight-bold',
				'condition' => [ 'type' => 'image_block' ],
				"description" => "<br><hr><br>",
		);	
		
		 
		
	 
		
		$fields['image_block'.$i."_btn_show'] = array(
				'label' => __( 'Button', 'premiumpress' ),
				'type'            => 'select',
				 
				 'options' => array( 
				 
					"yes" 	=> "Show",
					"no" 	=> "Hide",							 
				),
				'default' => 'yes',
				 
				'placeholder' => "",
				'condition' => ['type' => 'image_block' ],
		);
		$fields['image_block'.$i."_btn_txt'] = array(
				'label' => __( 'Button Text', 'premiumpress' ),
				'type'            => 'text',
			 
				'default' => 'Button',
				  
				'condition' => ['type' => 'image_block' ],
		);	
		
			$fields['image_block'.$i."_btn_link'] = array(
				'label' => __( 'Button Link', 'premiumpress' ),
				'type'            => 'text',
			 
				'default' => 'http://',
				  
				'condition' => ['type' => 'image_block' ],
		);	
		
$fields['image_block'.$i.'_btn_size'] = array(
				'label' => __( 'Size', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'btn-sm' => "Small",
					'btn-md' => "Medium",
					'btn-lg' => "Large" ,
					'btn-xl' => "Extra Large",
				),
				
				'default' => 'btn-md',
				'condition' => ['type' => 'image_block' ],
		);
		
		$fields['image_block'.$i.'_btn_font'] = array(
				'label' => __( 'Font', 'premiumpress' ),
				'type'            => 'select',
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				'condition' => ['type' => 'image_block' ],
		);
		
		$fields['image_block'.$i.'_btn_style'] = array(
				'label' => __( 'Style', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					"1" 	=> "Normal",
					"2" 	=> "Outlined",	
					"3" 	=> "Normal Rounded",	
					"4" 	=> "Outlined Rounded",
					 	"5" 	=> "Square Edges",
				),
				
				'default' => '1',
				'condition' => ['type' => 'image_block' ],
		);
		
	 
		$fields['image_block'.$i.'_btn_margin'] = array(
				'label' => __( 'Margin Top', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'mt-0' => "0px",
					'mt-1' => "10px",
					'mt-2' => "20px",
					'mt-3' => "30px" ,
					'mt-4' => "40px",
					'mt-5' => "50px",
					
				),
				
				'default' => 'mt-0',
				'condition' => ['type' => 'image_block' ],
		);
			
		$fields['image_block'.$i.'_btn_icon'] = array(
				'label' => __( 'Icon', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => '', 
				],
				'condition' => ['type' => 'image_block' ],
		);
		$fields['image_block'.$i.'_btn_icon_pos'] = array(
				'label' => __( 'Icon Position', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array('before' => "Before",'after' => "After" ),
				'default' => 'before',
				'condition' => ['type' => 'image_block' ],
		);
		$fields['image_block'.$i.'_btn_bg'] = array(
				'label' => __( 'Button Color', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array(
					'primary' 	=> "Primary Color",
					'secondary' => "Secondary Color",
					'light' 	=> "Light Color" ,
					'dark' 		=> "Dark Color",
				),
				
				'default' => 'primary',
				'condition' => ['type' => 'image_block' ],
		);	
		
		$fields['image_block'.$i.'_btn_bg_txt'] = array(
				'label' => __( 'Text Color', 'premiumpress' ),
				'type'            => 'select',				
				'options' => array('text-dark' => "Dark",'text-light' => "Light" ),
				'default' => 'text-light',
				'condition' => ['type' => 'image_block' ],
		);	
		  
		
		$i++; } 
			
			
			
*/			
			
			
			
			
			
			
			
			
				/*-------------------------------------------------------------------------------------*/			
				/** TEXT ****************************************************************************/
				/*-------------------------------------------------------------------------------------*/

/*
		$i=1; while($i < 7){ 
	 	
		$ttt = $i;
		$ttt = $ttt - 1;
		
	   	$this->end_controls_section();
		
		if($i == 1){ 


		   $this->start_controls_section(
					'text_section'.$i,
					[
						'label' => __( 'Image', 'premiumpress' )." ".$i,						
						'conditions' => [						 
							'terms' => [
								 
								[
									'name' 		=> 'type',
									'operator' 	=> 'in',
									'value' 	=> ['text','video'],
								],
								
								
								[
									'name' 		=> 'title_show',
									'operator' 	=> '==',
									'value' 	=> "yes",
								],
															 
							]
						] 					 
					]
			);  
		
		
		}else{		
		
	   
		   $this->start_controls_section(
					'text_section'.$i,
					[
						'label' => __( 'Image', 'premiumpress' )." ".$i,						
						'conditions' => [						 
							'terms' => [
								[
									'name' => 'text_image'.$ttt.'_title',
									'operator' => '!=',
									'value' => ''
								],
								[
									'name' => 'type',
									'operator' => 'in',
									'value' => ['text','video'],
								],						 
							]
						] 					 
					]
			); 
		
		}
		  
		$fields['text_image'.$i,
			[
				'label' => __( 'Image', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => ['type' => ['text','video'] ],
		); 
		 
		$fields['text_image'.$i."_title'] = array(
				'label' => __( 'Title', 'premiumpress' ),
				'type'            => 'text',			 	 
				'condition' => ['type' => ['text','video'] ],
		);
		
		$fields['text_image'.$i."_link'] = array(
				'label' => __( 'Link', 'premiumpress' ),
				'type'            => 'text',				
				'condition' => ['type' => ['text','video'] ],
		);
		
		$i++; } 
*/

			 
				/*-------------------------------------------------------------------------------------*/			
				/** AUTHOR ****************************************************************************/
				/*-------------------------------------------------------------------------------------*/

/*
		$i=1; while($i < 9){ 
	   $this->end_controls_section();	
  
		$ttt = $i;
		$ttt = $ttt - 1;
		
		if($i == 1){ 


		   $this->start_controls_section(
					'author_section'.$i,
					[
						'label' => __( 'Author', 'premiumpress' )." ".$i,						
						'conditions' => [						 
							'terms' => [
								 
								[
									'name' 		=> 'type',
									'operator' 	=> '==',
									'value' 	=> 'testimonials'
								]							 
							]
						] 					 
					]
			);  
		
		
		}else{		
		
	   
		   $this->start_controls_section(
					'author_section'.$i,
					[
						'label' => __( 'Author', 'premiumpress' )." ".$i,						
						'conditions' => [						 
							'terms' => [
								[
									'name' => 'author_name'.$ttt,
									'operator' => '!=',
									'value' => ''
								],
								[
									'name' => 'type',
									'operator' => '==',
									'value' => 'testimonials'
								]							 
							]
						] 					 
					]
			); 
		
		}
		
		
		$fields['author_image'.$i,
			[
				'label' => __( 'User Photo', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => ['type' => 'testimonials' ],
		); 
		
		
		$fields['author_name'.$i,
			[
				'label' => __( 'Name', 'premiumpress' ),
				'type'            => 'text',				
				'placeholder' => __( 'John Doe', 'premiumpress' ),
				'condition' => ['type' => 'testimonials' ],
		);
		
		$fields['author_job'.$i,
			[
				'label' => __( 'Job Title', 'premiumpress' ),
				'type'            => 'text',
			 
				'placeholder' => "CEO Google",
				'condition' => ['type' => 'testimonials' ],
		);
		
		$fields['author_quote'.$i,
			[
				'label' => __( 'Quote', 'premiumpress' ),
				'type'            => 'textarea',
			 	 
				'condition' => ['type' => 'testimonials' ],
		);		
		
		
		$i++; } 
*/

			 
				/*-------------------------------------------------------------------------------------*/			
				/** ICONS ****************************************************************************/
				/*-------------------------------------------------------------------------------------*/
			 /*
				$i=1; while($i < 10){ 
				
			   $this->end_controls_section();	
				
				$ttt = $i;
				$ttt = $ttt - 1;
				
				if($i == 1){ 
		
		
				   $this->start_controls_section(
							'icon_section'.$i,
							[
								'label' => __( 'Icon', 'premiumpress' )." ".$i,						
								'conditions' => [						 
									'terms' => [
										 
										[
											'name' => 'type',
											'operator' => '==',
											'value' => 'icon'
										]							 
									]
								] 					 
							]
					);  
				
				
				}else{		
				
			   
				   $this->start_controls_section(
							'icon_section'.$i,
							[
								'label' => __( 'Icon', 'premiumpress' )." ".$i,							
								'conditions' => [						 
									'terms' => [
										[
											'name' => 'icon'.$ttt.'_title',
											'operator' => '!=',
											'value' => ''
										],
										[
											'name' => 'type',
											'operator' => '==',
											'value' => 'icon'
										]							 
									]
								] 					 
							]
					); 
				
				}
				
			 
				
				$this->add_control(
						'icon'.$i.'_type',
						[
							'label' => __( 'Text Color', 'premiumpress' ),
							'type'            => 'select', 
							'options' => array( 
									"icon" 		=> "Icon",
									"image" 	=> "Image",
									 
									 
									) ,
							'default' => 'icon',
							'condition' => ['type' => array('icon')],
						]
				);	
				
					
				$this->add_control(
					'icon'.$i,
					[
						'label' => __( 'Icon', 'premiumpress' ),
						'type' => \Elementor\Controls_Manager::ICONS,				 
						'condition' => ['icon'.$i.'_type' => 'icon' ],
					]
				);
				
				$this->add_control(
						'icon'.$i.'_iconcolor',
						[
							'label' => __( 'Icon Color', 'premiumpress' ),
							'type'            => 'select', 
							'options' => array( 
							
									"dark" 		=> "Dark",
									"light" 	=> "Light",
									"primary" 	=> "Primary",
									"secondary" => "Secondary",
									
									) ,
							'default' => 'primary',
							'condition' => ['icon'.$i.'_type' => 'icon' ],
						]
				);
				
				
				$this->add_control(
					'icon'.$i.'_image',
					[
						'label' => __( 'Image', 'premiumpress' ),
						'type' => \Elementor\Controls_Manager::MEDIA,
						'default' => [
							'url' => '',
						],
						'condition' => ['icon'.$i.'_type' => 'image'],
					]
				); 
				
				
				$this->add_control(
					'icon'.$i."_title",
					[
						'label' => __( 'Title', 'premiumpress' ),
						'type'            => 'textarea',			 
						'condition' => ['type' => 'icon' ],
					]
				);
				
				$this->add_control(
						'icon'.$i.'_txtcolor',
						[
							'label' => __( 'Title Color', 'premiumpress' ),
							'type'            => 'select', 
							'options' => array( 
									"dark" 		=> "Dark",
									"light" 	=> "Light",
									"primary" 	=> "Primary",
									"secondary" => "Secondary",
									 
									) ,
							'default' => 'dark',
							'condition' => ['type' => array('icon')],
						]
				);	
		
					
				
				
				$this->add_control(
					'icon'.$i."_desc",
					[
						'label' => __( 'Description', 'premiumpress' ),
						'type'            => 'textarea',
						'condition' => ['type' => 'icon' ],
					]
				);		
				
				
				$this->add_control(
					'icon'.$i."_link",
					[
						'label' => __( 'Link', 'premiumpress' ),
						'type'            => 'text',				 
						'condition' => ['type' => 'icon' ],
					]
				);
			 */
			 
				/*-------------------------------------------------------------------------------------*/			
				/** FOOTER ****************************************************************************/
				/*-------------------------------------------------------------------------------------*/

				$fields['footer_description'] = array(
					 
						'label' 	=> __( 'Description', 'premiumpress' ),
						'type'            => 'textarea',
						'default' 	=> _ppt(array('company','info')),				 
						
						'toggle_slug' => 'sec_title',
					 
				);
				
				
				
				$fields['footer_menu1_title'] = array(
					 
						'label' => __( 'Menu 1 Title', 'premiumpress' ),
						'type'            => 'text',				 
						
						'toggle_slug' => 'sec_title',
				);
				
				$fields['footer_menu1'] = array(
					 
						'label' 	=> __( 'Menu 1 Link', 'premiumpress' ),
						'type' => 'select', 
						'options' => _ppt_elementor_menus(),
						'default' 	=> "",				 
						
						'toggle_slug' => 'sec_title',
					 
				);
				
				
				$fields['footer_menu2_title'] = array(
					 
						'label' => __( 'Menu 2 Title', 'premiumpress' ),
						'type'            => 'text',				 
						
						'toggle_slug' => 'sec_title',
					 
				);
				
				$fields['footer_menu2'] = array(
					 
						'label' 	=> __( 'Menu 2 Links', 'premiumpress' ),
						'type' => 'select', 
						'options' => _ppt_elementor_menus(),
						'default' 	=> "",				 
						
						'toggle_slug' => 'sec_title',
					 
				);		
				
				$fields['footer_copyright_style'] = array(
					 
						'label' => __( 'Copyright Style', 'premiumpress' ),
						'type'            => 'select',				
						'options' => array(
							""		=> "Default",
							"1" 	=> "Text Left",
							"2" 	=> "Text Center",	
							"3" 	=> "Text Right",	
							"4" 	=> "Text + Cards",
							"5" 	=> "Text + Social",
							"6" 	=> "Text + Links",
						),
						
						'default' => "",
						
						'toggle_slug' => 'sec_title',
					 
				);
				
				$fields['footer_copyright'] = array(
					 
						'label' 	=> __( 'Copyright Text', 'premiumpress' ),
						'type'            => 'textarea',
						'default' 	=> "&copy; ".date("Y")." ".stripslashes(_ppt(array('company','name'))),				 
						
						'toggle_slug' => 'sec_title',
					 
				);	 
			 
			 
			 
			
				/*-------------------------------------------------------------------------------------*/			
				/** SECTION ****************************************************************************/
				/*-------------------------------------------------------------------------------------*/
				
		 
				$fields['section_bg'] = array(
					 
						'label' => __( 'Background', 'premiumpress' ),
						'type'            => 'select',			
						'options' => array(
							'none' 		=> "None (Use Elemnetor)",	
							'bg-white' 		=> "White",					
							'bg-light' 		=> "Light" ,
							'bg-dark' 		=> "Dark",		
							'bg-black' 		=> "Black",				
							'bg-primary' 	=> "Primary Color",
							'bg-secondary' 	=> "Secondary Color",					 
							
						),
						
						'default' => 'bg-white',
						
						'toggle_slug' => 'sec_section',
					 
				);
				
				$fields['section_w'] = array(
				
						'label' => __( 'Container Width', 'premiumpress' ),
						'type'            => 'select',				
						'options' => array(
						
							'container-fluid' 	=> "Full Width (100%)",					
							'container' 		=> "Container (1300px)" ,
							'container-slim' 	=> "Slim (1000px)",
						),
						
						'default' => 'container',
						
						'toggle_slug' => 'sec_section',
					 
				);
				
				$fields['section_pos'] = array(
					 
						'label' => __( 'Text Position', 'premiumpress' ),
						'type'            => 'select',	
						 'options' => array(
						
							"" 			=> "default",				 
							"text-center" 	=> "Center", 
						
						),
						'default' => '',
						
						'toggle_slug' => 'sec_section',
					 
				);	
				
				$fields['section_pattern'] = array(
					 
						'label' => __( 'Pattern', 'premiumpress' ),
						'type'            => 'select',				
						'options' => array(
						
							'' 	=> "None",					
							'1' 		=> "Style 1",
							'2' 		=> "Style 2",
							'3' 		=> "Style 3",
							'4' 		=> "Style 4",
							'5' 		=> "Style 5",
							
						),
						
						'default' => '',
						'toggle_slug' => 'sec_section',
					 
				);
					
				$fields['section_padding'] = array(
					 
						'label' => __( 'Padding', 'premiumpress' ),
						'type'            => 'select',				
						'options' => array(
						
						"" 					=> "default",
						
						"section-0" 		=> "No Padding",
						
						"z" => "------------",
							
							"section-120" 		=> "120px Padding",
							"section-100" 		=> "100px Padding", 
							"section-80" 		=> "80px Padding", 
							"section-60" 		=> "60px Padding", 						
							"section-40" 		=> "40px Padding",
							"section-20" 		=> "20px Padding",
							
							"a" => "------------",
							
							"section-top-40" 		=> "40px Padding Top",
							"section-top-60" 		=> "60px Padding Top",
							"section-top-80" 		=> "80px Padding Top",
							"section-top-100" 		=> "100px Padding Top",
							"section-top-120" 		=> "120px Padding Top",
							
							"b" => "------------",
							
							"section-bottom-40" 		=> "40px Padding Bottom",
							"section-bottom-60" 		=> "60px Padding Bottom",
							"section-bottom-80" 		=> "80px Padding Bottom",
							"section-bottom-100" 		=> "100px Padding Bottom",
							"section-bottom-120" 		=> "120px Padding Bottom",
							
							
						),
						
						'default' => '',
						'toggle_slug' => 'sec_section',
				  
				);		
			 
			
			
			
			
			
			return $fields;
		}
		
		
	 

		function shortcode_callback( $atts, $content = null, $function_name ) {
		
			global $new_settings, $CORE;
			
			$new_settings = array();
			 
		  	// GET FIELD DATA
			$type                   = $this->shortcode_atts['type'];
			 
			$TID 		=  $type."_style";			
			$layout     = $this->shortcode_atts[$TID];
		 	
			
			// BUILD OUTPUT FIELDS
			if(strlen($type) > 1){	
					
					// SECTIONS
					$new_settings["section_padding"]  	= $this->shortcode_atts['section_padding'];
					$new_settings["section_bg"] 		= $this->shortcode_atts['section_bg'];	
					$new_settings["section_pos"] 		= $this->shortcode_atts['section_pos']; 
					$new_settings["section_w"] 			= $this->shortcode_atts['section_w']; 
					$new_settings["section_pattern"] 	= $this->shortcode_atts['section_pattern'];  
 					
			}
			

  
	 
		// TITLES
		if($this->shortcode_atts['title_show'] == "yes"){
		
	 	
		$new_settings["title_show"]  = $this->shortcode_atts['title_show'];
		$new_settings["title"] 		 = $this->shortcode_atts['title'];
		$new_settings["subtitle"] 	 = $this->shortcode_atts['subtitle'];
		$new_settings["desc"]		 = $this->shortcode_atts['desc'];
		$new_settings["title_style"] = $this->shortcode_atts['title_style'];	
		$new_settings["title_pos"] 	 = $this->shortcode_atts['title_pos'];		
		$new_settings["title_heading"] 	 = $this->shortcode_atts['title_heading'];	
		
		$new_settings["title_margin"] 		 = $this->shortcode_atts['title_margin'];
		$new_settings["subtitle_margin"] 	 = $this->shortcode_atts['subtitle_margin'];
		$new_settings["desc_margin"] 		 = $this->shortcode_atts['desc_margin'];
		
		$new_settings["title_txtcolor"] 	 = $this->shortcode_atts['title_txtcolor'];
		$new_settings["subtitle_txtcolor"] 	 = $this->shortcode_atts['subtitle_txtcolor'];
		$new_settings["desc_txtcolor"] 		 = $this->shortcode_atts['desc_txtcolor'];	

		$new_settings["title_font"] 	 = $this->shortcode_atts['title_font'];
		$new_settings["subtitle_font"] 	 = $this->shortcode_atts['subtitle_font'];
		$new_settings["desc_font"] 		 = $this->shortcode_atts['desc_font'];	

		
		$new_settings["title_txtw"] 	 = $this->shortcode_atts['title_txtw'];
		$new_settings["subtitle_txtw"] 	 = $this->shortcode_atts['subtitle_txtw'];
			
		
		}elseif($this->shortcode_atts['title_show'] == "no"){		
		$new_settings["title_show"]  = $this->shortcode_atts['title_show'];		
		}	
		
		// BUTTONS
		if($this->shortcode_atts['btn_show'] == "yes"){
		 
			
		$new_settings["btn_show"]	 = $this->shortcode_atts['btn_show'];
		$new_settings["btn_link"]	 = $this->shortcode_atts['btn_link'];
		$new_settings["btn_txt"]	 = $this->shortcode_atts['btn_txt'];
		$new_settings["btn_bg"]	 	 = $this->shortcode_atts['btn_bg'];
		$new_settings["btn_bg_txt"]	 = $this->shortcode_atts['btn_bg_txt'];		
		//$new_settings["btn_icon"]	 = $this->shortcode_atts['btn_icon']['value'];
		$new_settings["btn_icon_pos"]= $this->shortcode_atts['btn_icon_pos'];
		$new_settings["btn_size"]	 = $this->shortcode_atts['btn_size'];	
		$new_settings["btn_margin"]	 = $this->shortcode_atts['btn_margin'];
		$new_settings["btn_style"]	 = $this->shortcode_atts['btn_style'];
		$new_settings["btn_font"]	 = $this->shortcode_atts['btn_font'];
		
		}elseif($this->shortcode_atts['btn_show'] == "no"){		
		$new_settings["btn_show"]  = $this->shortcode_atts['btn_show'];		
		}
		
		// BUTTONS 2
		if($this->shortcode_atts['btn2_show'] == "yes"){
		$new_settings["btn2_show"]	 = $this->shortcode_atts['btn2_show'];
		$new_settings["btn2_link"]	 = $this->shortcode_atts['btn2_link'];
		$new_settings["btn2_txt"]	 = $this->shortcode_atts['btn2_txt'];
		$new_settings["btn2_bg"]	 = $this->shortcode_atts['btn2_bg'];
		$new_settings["btn2_bg_txt"] = $this->shortcode_atts['btn2_bg_txt'];		
		//$new_settings["btn2_icon"]	 = $this->shortcode_atts['btn2_icon']['value'];
		$new_settings["btn2_icon_pos"]= $this->shortcode_atts['btn2_icon_pos'];
		$new_settings["btn2_size"]	 	= $this->shortcode_atts['btn2_size'];
		$new_settings["btn2_margin"]	 = $this->shortcode_atts['btn2_margin'];
		$new_settings["btn2_style"]	 = $this->shortcode_atts['btn2_style'];
		
		$new_settings["btn2_font"]	 = $this->shortcode_atts['btn2_font'];
		
		}elseif($this->shortcode_atts['btn2_show'] == "no"){		
		$new_settings["btn2_show"]  = $this->shortcode_atts['btn2_show'];		
		}	
		
	
		
		// HEADER
		if(in_array( $type, array("header") )){
		 
		 
			$new_settings["topmenu_show"]	 = $this->shortcode_atts['topmenu_show'];			
			$new_settings["extra_show"]		 = $this->shortcode_atts['extra_show'];
			$new_settings["extra_type"]		 = $this->shortcode_atts['extra_type'];	
			
			if($new_settings["topmenu_show"] == ""){ $new_settings["topmenu_show"] = "no"; }		
			if($new_settings["extra_show"] == ""){ $new_settings["extra_show"] = "no"; }		
			 
			//$CORE->FUNC("update_core", array( array('design','color_primary'),  $this->shortcode_atts['color_primary']) );
			//$CORE->FUNC("update_core", array( array('design','color_secondary'),  $this->shortcode_atts['color_secondary']) );			 			 
			
		}
	
		
		// FOOTER
		if(in_array( $type, array("footer") )){
		
			$new_settings["footer_copyright"]		 	= $this->shortcode_atts['footer_copyright'];	
			$new_settings["footer_description"]			= $this->shortcode_atts['footer_description'];				
			$new_settings["footer_copyright_style"]		= $this->shortcode_atts['footer_copyright_style'];	
			
			$new_settings["footer_menu1"]		= $this->shortcode_atts['footer_menu1'];	
			$new_settings["footer_menu2"]		= $this->shortcode_atts['footer_menu2'];	
			
			$new_settings["footer_menu1_title"]		= $this->shortcode_atts['footer_menu1_title'];	
			$new_settings["footer_menu2_title"]		= $this->shortcode_atts['footer_menu2_title'];	
			
		}
			
		
		// CATEGORY
		if(in_array( $type, array("category") )){
		 
		 
		 //$new_settings["cat_order"]  	= $this->shortcode_atts['cat_order'];
		 //$new_settings["cat_orderby"] 	= $this->shortcode_atts['cat_orderby'];
		 $new_settings["cat_show"] 		= $this->shortcode_atts['cat_show'];
		 $new_settings["cat_show_list"] = $this->shortcode_atts['cat_show_list'];
		 $new_settings["cat_offset"] 	= $this->shortcode_atts['cat_offset'];	 
		 
		}
				
		// IMAGES
		if(in_array( $type, array("image_block") )){
		
			$i=1; while($i < 7){  
			if(isset($s["image_block".$i]['url']) && strlen($s["image_block".$i]['url']) > 10){
			$new_settings["image_block".$i] 				= 	$s["image_block".$i]['url']; 
			}
			
			
			$new_settings["image_block".$i."_effect"] 		= 	$s["image_block".$i."_effect"];
			$new_settings["image_block".$i."_txtpos"] 		= 	$s["image_block".$i."_txtpos"];			
			
			if(strlen($s["image_block".$i]['url']) > 10){		
			
			
				$new_settings["image_block".$i."_title"] 		 = $this->shortcode_atts['image_block'.$i.'_title'];
				$new_settings["image_block".$i."_subtitle"] 	 = $this->shortcode_atts['image_block'.$i.'_subtitle'];
				
				$new_settings["image_block".$i."_title_margin"] 		= $this->shortcode_atts['image_block'.$i.'_title_margin'];
				$new_settings["image_block".$i."_subtitle_margin"] 	 = $this->shortcode_atts['image_block'.$i.'_subtitle_margin'];			 
				
				$new_settings["image_block".$i."_title_txtcolor"] 	 = $this->shortcode_atts['image_block'.$i.'_title_txtcolor'];
				$new_settings["image_block".$i."_subtitle_txtcolor"] 	 = $this->shortcode_atts['image_block'.$i.'_subtitle_txtcolor'];
				
				$new_settings["image_block".$i."_title_txtsize"] 	 = $this->shortcode_atts['image_block'.$i.'_title_txtsize'];
				$new_settings["image_block".$i."_subtitle_txtsize"] 	 = $this->shortcode_atts['image_block'.$i.'_subtitle_txtsize'];				
							 
		
				$new_settings["image_block".$i."_title_font"] 	 = $this->shortcode_atts['image_block'.$i.'_title_font'];
				$new_settings["image_block".$i."_subtitle_font"] 	 = $this->shortcode_atts['image_block'.$i.'_subtitle_font'];				 
				
				$new_settings["image_block".$i."_title_txtw"] 	 = $this->shortcode_atts['image_block'.$i.'_title_txtw'];
				$new_settings["image_block".$i."_subtitle_txtw"] 	 = $this->shortcode_atts['image_block'.$i.'_subtitle_txtw'];
				
			
 				$new_settings["image_block".$i."_btn_show"] 	 = $this->shortcode_atts['image_block'.$i.'_btn_show'];
				$new_settings["image_block".$i."_btn_txt"] 	 	= $this->shortcode_atts['image_block'.$i.'_btn_txt'];
				$new_settings["image_block".$i."_btn_bg"]	 	 = $this->shortcode_atts['image_block'.$i.'_btn_bg'];
				$new_settings["image_block".$i."_btn_bg_txt"]	 = $this->shortcode_atts['image_block'.$i.'_btn_bg_txt'];		
				$new_settings["image_block".$i."_btn_icon"]	 	= $this->shortcode_atts['image_block'.$i.'_btn_icon']['value'];
				$new_settings["image_block".$i."_btn_icon_pos"]	= $this->shortcode_atts['image_block'.$i.'_btn_icon_pos'];
				$new_settings["image_block".$i."_btn_size"]	 	= $this->shortcode_atts['image_block'.$i.'_btn_size'];	
				$new_settings["image_block".$i."_btn_margin"]	 = $this->shortcode_atts['image_block'.$i.'_btn_margin'];
				$new_settings["image_block".$i."_btn_style"]	 = $this->shortcode_atts['image_block'.$i.'_btn_style'];
				$new_settings["image_block".$i."_btn_font"]	 	= $this->shortcode_atts['image_block'.$i.'_btn_font'];
				$new_settings["image_block".$i."_btn_link"] 	= 	$s["image_block".$i."_btn_link"];
 				
			 		
 			}
			
			$i++; }				 		  
		
		}
		
		// TEXT
		if(in_array( $type, array("text","video") )){
		
			$i=1; while($i < 7){ 
		 	
				if( is_array($this->shortcode_atts['text_image'.$i]) && strlen($this->shortcode_atts['text_image'.$i]['url']) > 1 ){
				
				 $new_settings["text_image".$i] 			= $this->shortcode_atts['text_image'.$i]['url'];
				 $new_settings["text_image".$i."_title"] 	= $this->shortcode_atts['text_image'.$i."_title"];
				 $new_settings["text_image".$i."_link"] 	= $this->shortcode_atts['text_image'.$i."_link"];
				}
			
			$i++; }				 		  
		
		}
		
		// VIDEO
		if(in_array( $type, array("video") )){		
		
			$new_settings["video_link"] 	= $this->shortcode_atts['video_link'];
		 
		
		}

		// ICONS
		if(in_array( $type, array("icon") )){
		
			$i=1; while($i < 10){ 
		 	
			if(strlen($this->shortcode_atts['icon'.$i."_title"]) > 1){
			
				$new_settings["icon".$i] 			= $this->shortcode_atts['icon'.$i.""]['value'];	
				$new_settings["icon".$i."_title"] 	= $this->shortcode_atts['icon'.$i."_title"];
				$new_settings["icon".$i."_desc"] 	= $this->shortcode_atts['icon'.$i."_desc"];
				$new_settings["icon".$i."_link"] 	= $this->shortcode_atts['icon'.$i."_link"];
				
				$new_settings["icon".$i."_txtcolor"] 	= $this->shortcode_atts['icon'.$i."_txtcolor"];
				$new_settings["icon".$i."_iconcolor"] 	= $this->shortcode_atts['icon'.$i."_iconcolor"];
				
				$new_settings["icon".$i."_type"] 	= $this->shortcode_atts['icon'.$i."_type"];
				
				if(isset($s["icon".$i."_image"]) && strlen($s["icon".$i."_image"]['url']) > 10){			
					$new_settings["icon".$i."_image"] 	= $this->shortcode_atts['icon'.$i."_image"]['url'];				
				}
			
			}
			
			$i++; }		
			
			
			
			if(isset($this->shortcode_atts['image_icon']) && strlen($this->shortcode_atts['image_icon']['url']) > 10){
			
				$new_settings["image_icon"] 				= $this->shortcode_atts['image_icon']['url'];
				
			}		 		  
		
		}
						
		// TESTIMONIALS
		if(in_array( $type, array("testimonials") )){
		
			$i=1; while($i < 9){ 
			
		 	if(strlen($this->shortcode_atts['author_name'.$i]) > 2){
			$new_settings["author_quote".$i] 	= $this->shortcode_atts['author_quote'.$i];
			$new_settings["author_name".$i] 	= $this->shortcode_atts['author_name'.$i];
			$new_settings["author_image".$i] 	= $this->shortcode_atts['author_image'.$i]['url'];
			$new_settings["author_job".$i] 		= $this->shortcode_atts['author_job'.$i];
			}
			
			$i++; }				 		  
		
		}
		
		// slider
		if(in_array( $type, array("slider") )){
		
			$i=1; while($i < 5){ 
			
			if(isset($this->shortcode_atts['image'.$i]) && strlen($this->shortcode_atts['image'.$i]['url']) > 10){
			
				$new_settings["image".$i] 				= $this->shortcode_atts['image'.$i]['url'];			
				$new_settings["image".$i."_title"] 		= $this->shortcode_atts['image'.$i."_title"];		 
				$new_settings["image".$i."_desc"] 		= $this->shortcode_atts['image'.$i."_desc"];		 
				$new_settings["image".$i."_btn_text"] 	= $this->shortcode_atts['image'.$i."_btn_text"];		 
				$new_settings["image".$i."_btn_link"] 	= $this->shortcode_atts['image'.$i."_btn_link"];		 
				$new_settings["image".$i."_txtcolor"] 	= $this->shortcode_atts['image'.$i."_txtcolor"];
				$new_settings["image".$i."_txtdir"] 	= $this->shortcode_atts['image'.$i."_txtdir"];
				
			}
			
			$i++; }						 		  
		
		}	
		
		
		// hero
		if(in_array( $type, array("hero") )){
			
		 	 
			$post_id = attachment_url_to_postid($this->shortcode_atts['hero_image']);
			if($post_id !== 0){
				$attachment = wp_get_attachment_image_src($post_id, $image_size);
				if($attachment){
					$new_settings["hero_image"]  = $attachment[0];
					//$image_width = $attachment[1];
					//$image_height = $attachment[2];
				}
			}
			
					
			$new_settings["hero_size"] 				= $this->shortcode_atts['hero_size'];	
			$new_settings["hero_txtcolor"] 			= $this->shortcode_atts['hero_txtcolor'];			
			
		}
		
		
		// FAQ
		if(in_array( $type, array("faq") )){
		
			$i=1; while($i < 7){ 
		 	
			if(strlen($this->shortcode_atts['faq_title'.$i]) > 1){
				$new_settings["faq".$i."_title"] = $this->shortcode_atts['faq_title'.$i];		 
				$new_settings["faq".$i."_desc"] = $this->shortcode_atts['faq_desc'.$i];
			}
			
			$i++; }		
			
			$new_settings["image_faq"] 			= $this->shortcode_atts['image_faq']['url'];						 		  
		
		}	
		
		
		// SUBSCRIBE
		if(isset($this->shortcode_atts['image_subscribe']['url']) && strlen($this->shortcode_atts['image_subscribe']['url']) > 10){
		 	$new_settings["image_subscribe"] 			= $this->shortcode_atts['image_subscribe']['url'];			 
		}	
		
		
		// SUBSCRIBE		
		if(in_array( $type, array("cta") )){
		
			if(isset($this->shortcode_atts['image_cta']['url']) && strlen($this->shortcode_atts['image_cta']['url']) > 10){
				$new_settings["image_cta"] 			= $this->shortcode_atts['image_cta']['url'];			 
			} 
		
		}
		
		// PRICING		
		if(in_array( $type, array("pricing") )){
		 
			$new_settings["pricing_type"] = $this->shortcode_atts['pricing_type'];
		
		}



		 add_action( 'wp_footer', array($this, 'footer' ) ); 
		 do_action($layout."-js");	
		 do_action($layout."-css"); 
			// DISPLAY OUTPUT
			if(strlen($layout) > 2){
			
				ob_start(); 
				
				do_action($layout); 
							
				$output = ob_get_contents();
				ob_end_clean(); 
			
			}else{
			
				$output = '<div class="et_pb_module">Please select a layout.</div>';			 
			
			}

			return $output; 
			
		}
		
		
public function get_settings_modal_toggles() {

  return array(
  
    'advanced' => array(
	
      'toggles' => array(
	  
	   'sec_main' => array(
		
          	'priority' => 1, 
         	 'title' => 'Select a design block..',
		  ),
	  
        'sec_title' => array(
		
          	'priority' => 2, 
         	 'title' => 'Title &amp; Description',
		  ),
		  
        'sec_btn1' => array(
		
          	'priority' => 2, 
         	 'title' => 'Button 1',
		  ),
		  
        'sec_btn2' => array(
		
          	'priority' => 3, 
         	 'title' => 'Button 2',
		  ),
		  
        'sec_hero' => array(
		
          	'priority' => 2, 
         	 'title' => 'Hero',
		  ),
		  
		  
        'sec_header' => array(
		
          	'priority' => 4, 
         	 'title' => 'Header',
		  ),
		  
        'sec_footer' => array(
		
          	'priority' => 4, 
         	 'title' => 'Footer',
		  ),		  
		  		  		  
        'sec_section' => array(
		
          	'priority' => 5, 
         	 'title' => 'Section Padding/Size',
		  ),
		  
		  		
      ),
	  
    ),
	
  );
}


	}
	
	new EVR_Builder_Module_PremiumPress;	
	
}