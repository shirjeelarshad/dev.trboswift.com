<?php

class Widget_PremiumPress_New_Hero extends \Elementor\Widget_Base {
 
	public function get_name() {
		return 'new-hero';
	}
 
	public function get_title() {
		return __( '{ Morizona }', 'premiumpress' );
	} 
	public function get_icon() {
		return 'premiumpress';
	} 
	public function get_categories() {
		return [ 'premiumpress-new' ];
	} 
	protected function _register_controls() {	 global $CORE; 
	 	
		// BLOCK TYPES
		$block_types = array(); 
		
		foreach($CORE->LAYOUT("get_block_types",array()) as $t){ 
			$block_types[$t['id']] = $t['name']; 
		}
		 
		 
 	
 	
		/**************************************************************************************************************/
		/**************************************************************************************************************/
		/**************************************************************************************************************/
		/**************************************************************************************************************/
		/**************************************************************************************************************/
		
 
		$this->start_controls_section(
			'ppt_block_overview',
			[
				'label' => __( 'PREMIUMPRESS', 'premiumpress' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				
				/*'condition' => [
									'name' => 'type',
									'operator' => '!=',
									'value' => ''
								],*/
			]
		);
		
		
		
		$cats_array = array();
		$code = "";
		$i=1;
		foreach($block_types as $typeid => $type){
		 
			$cats_array[$typeid] = $typeid;
			
			$extracss = "";
			if($i%2){
			$extracss = "margin-right:7px;";
			}
			$code .= "<div style='width: 48%;line-height:50px;float: left;text-align:center;border:1px solid #ddd; margin-bottom:20px;".$extracss."'><a href=\"javascript:void(0);\" onclick=\"ppt_elementor_change_type('".$typeid."');\">".$typeid."</a></div>";
			$i++;
		}// end types
		 		
				
		$this->add_control(
			'div_panel_alert',
			[
				//'label' => __( 'Block Type 1', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,				 
				'raw' => '<script>ppt_update_panel("overview");</script>',
			]
		);	
		
		$this->add_control(
			'div_output1',
			[
				//'label' => __( 'Block Type 1', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				 
				'raw' => '<div id="ppt_elementor_editor_categories">'.$code.'</div>',
			]
		);	
		
		$this->add_control(
			'div_output2',
			[
				//'label' => __( 'Block Type 1', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				 
				'raw' => '<div id="ppt_elementor_editor_layouts"></div>',
			]
		);	
		
		$this->add_control(
			'div_output3',
			[
				//'label' => __( 'Block Type 1', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				 
				'raw' => '<div id="ppt_elementor_editor_preview"></div><input type="hidden" id="lastcheckedpreview" value="">',
			]
		);	
		
		$this->add_control(
			'type',
			[
				'label' => __( 'Category', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $block_types,
				'default' => '',
			]
		);	
		
		
		foreach($block_types as $typeid => $type){
		
			// GET DATA
			$g = $CORE->LAYOUT("load_all_by_cat", $typeid);
			 
			
			if(in_array($g, array('text','icon','listings','header','footer','cta','contact','video','faq','store' ))){
			$order = array_column($g, 'order'); 
   			array_multisort( $order, SORT_ASC, $g);
			}
			
			$k = array();
			foreach($g as $l => $j){
				$k[$l] = $j['name'];
			}
			
			$this->add_control(
					$typeid.'_style',
						[
							'label' => __('Layout', 'premiumpress' ),
							'type' => \Elementor\Controls_Manager::SELECT,
							'options' => $k,
							'default' => '1',
							'condition' => ['type' => $typeid ],
						]
			); 
					 
		
		}// end types
		
		 
		
		
		$this->add_control(
				'pricing_type',
				[
					'label' => __( 'Pricing Type', 'premiumpress' ),
					'type' => \Elementor\Controls_Manager::SELECT, 
					'options' => array( 
							"memberships" 	=> "Memberships",
							"advertising" 	=> "Advertising",
							"packages" 		=> "Listing Packages", 							 
							) ,
					'default' => 'memberships',
					'condition' => ['type' => array('pricing')],
				]
		);
		
		
		$this->add_control(
			'video_link',
			[
				'label' => __( 'Video Link', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '', 'premiumpress' ),
				'placeholder' => "",
				'condition' => ['type' => 'video' ],
			]
		);
		
		
		$this->add_control(
			'image_cta',
			[
				'label' => __( 'Image', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => ['type' => 'cta' ],
			]
		); 
	 
		
 		$this->add_control(
			'image_faq',
			[
				'label' => __( 'Image', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => ['type' => 'faq' ],
			]
		); 	
		
 		$this->add_control(
			'image_icon',
			[
				'label' => __( 'Image', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => ['type' => 'icon' ],
			]
		); 
		
 		$this->add_control(
			'image_subscribe',
			[
				'label' => __( 'Image', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => ['type' => 'subscribe' ],
			]
		); 
			 
 		
		
		
			
		/******************** TITLES **/			
 		
		$this->add_control(
			'title_show',
			[
				'label'   => esc_html__( 'Title &amp; Description', 'premiumpress' ),
				
				'type'    => \Elementor\Controls_Manager::SELECT,				
				'options' => array( 
					"" 		=> "",
					"yes" 	=> "Show",
					"no" 	=> "Hide",							 
				),
				
				'default' => '',
			 	 
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
			]
		);	
	
				
		/******************** BUTTONS **/
		 
		
		$this->add_control(
			'topmenu_show',
			[
				'label'   => esc_html__( 'Show Top Menu', 'premiumpress' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => ['type' => array('header')  ],
			]
		);
			$this->add_control(
			'extra_show',
			[
				'label'   => esc_html__( 'Show Extra', 'premiumpress' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => ['type' => array('header')  ],
			]
		);
		
		$this->add_control(
			'extra_type',
			[
				'label'   => esc_html__( 'Extra Type', 'premiumpress' ),
				'type'    => \Elementor\Controls_Manager::SELECT,				
				'options' => array( 
					"" 			=> "Phone",
					"icons" 	=> "Icons",
					"button" 	=> "Button",
					 						 
				),
				'default' => '',
				'condition' => ['type' => array('header')  ],
			]
		);


		$this->add_control(
			'btn_show',
			[
				'label'   => esc_html__( 'Button 1', 'premiumpress' ),
				'type'    => \Elementor\Controls_Manager::SELECT,				
				'options' => array( 
					"" 		=> "",
					"yes" 	=> "Show",
					"no" 	=> "Hide",							 
				),
				'default' => '',
				'condition' => ['type' => array('text','cta','header','faq','hero','icon','video','intro','store')  ],
			]
		);
		
		
		$this->add_control(
			'btn2_show',
			[
				'label'   => esc_html__( 'Button 2', 'premiumpress' ),
				'type'    => \Elementor\Controls_Manager::SELECT,				
				'options' => array( 
					"" 		=> "",
					"yes" 	=> "Show",
					"no" 	=> "Hide",							 
				),
				'default' => '',
				'condition' => ['type' => array('hero','text','icon','video','intro')  ],
			]
		);
	 	
		
		
				
 
		/******************** HEADER OPTIONS **/
		
		// GLOBAL IMAGE
		$this->add_control(
				'hero_size',
				[
					'label' => __( 'Size', 'premiumpress' ),
					'type' => \Elementor\Controls_Manager::SELECT, 
					'options' => array( 
							"hero-small" 	=> "Slim (400px)",
							"hero-medium" 	=> "Medium (500px)",
							"hero-large" 	=> "Large (800px)",
							"hero-full" 	=> "Full Page",
							) ,
					'default' => 'hero-medium',
					'condition' => ['type' => array('hero','intro')],
				]
		);
		
		// GLOBAL IMAGE
		$this->add_control(
				'hero_overlay',
				[
					'label' => __( 'Overlay Style', 'premiumpress' ),
					'type' => \Elementor\Controls_Manager::SELECT, 
					'options' => array( 
							"" 	=> "None",
									"gradient" 	=> "Gradient",
									"black" 	=> "Black",
									"white" 	=> "White",
									"grey" 		=> "Grey",	
									"green" => "Green",									
									"primary" 	=> "Primary Color",
									"secondary" => "Secondary Color",	
							) ,
					'default' => '',
					'condition' => ['type' => array('hero','intro')],
				]
		);
		
		$this->add_control(
				'hero_txtcolor',
				[
					'label' => __( 'Menu Color', 'premiumpress' ),
					'type' => \Elementor\Controls_Manager::SELECT, 
					'options' => array( 
							"dark" 	=> "Dark",
							"light" 	=> "Light",
							 
							) ,
					'default' => 'light',
					'condition' => ['type' => array('hero','intro')],
				]
		);		
		// GLOBAL IMAGE
		$this->add_control(
				'hero_image',
				[
					'label' => __( 'Image', 'premiumpress' ),
					'type' => \Elementor\Controls_Manager::MEDIA, 
					 
					'condition' => ['type' => array('hero','intro')],
				]
		);
		 
		
		$this->end_controls_section();
		
		
		
		
		
		
		
		
		/************** LISTING PAGE CONTROLS */
 
		$this->start_controls_section(
			'ppt_listngpage',
			[
				'label' => __( 'Listing Page Extras', 'premiumpress' ),	
				 
				
				 'conditions' => [						 
							'terms' => [
								[
									'name' => 'type',
									'operator' => '=',
									'value' => 'listingpage'
								] 						 
							]
						] 
						
				 
			]
		);	
		 
		
		
		$this->add_control(
				'listingpage_title_style',
				[
					'label' => __( 'Title Bar', 'premiumpress' ),
					'type' => \Elementor\Controls_Manager::SELECT, 
					'options' => array( 
							"1" 	=> "Style 1",
							"2" 	=> "Style 2",
							"3" 	=> "Style 3",
							
					 ) ,
					'default' => '1',
					'condition' => ['type' => array('listingpage')],
					"description" => "<br><hr><br>",
				]
		);	
		
		
		$this->add_control(
				'listingpage_images_style',
				[
					'label' => __( 'Images', 'premiumpress' ),
					'type' => \Elementor\Controls_Manager::SELECT, 
					'options' => array( 
							"1" 	=> "Style 1",
							"2" 	=> "Style 2",
							"3" 	=> "Style 3",
							
					 ) ,
					'default' => '1',
					'condition' => ['type' => array('listingpage')],
					"description" => "<br><hr><br>",
				]
		);
		
		$this->end_controls_section();
 	
 	
		/**************************************************************************************************************/
		/**************************************************************************************************************/
		/**************************************************************************************************************/
		/**************************************************************************************************************/
		/**************************************************************************************************************/
			
	
		/************** TITLE CONTROLS */
 
		$this->start_controls_section(
			'ppt_title',
			[
				'label' => __( 'Title &amp; Description', 'premiumpress' ),	
				 
				
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
									'value' => 'slider'
								],
								[
									'name' => 'title_show',
									'operator' => '==',
									'value' => 'yes'
								]						 
							]
						] 
						
				 
			]
		);	
		
		
	/******************** TITLES **/			
 		
			
		$this->add_control(
			'div_panel_alert2',
			[
				//'label' => __( 'Block Type 1', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,				 
				'raw' => '<script>ppt_update_panel("title");</script>',
			]
		);	
	
 		
		
		
		$this->add_control(
			'title_pos',
			[
				'label' => __( 'Position', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				 'options' => array(
				
				"left" 		=> "Left",
				"right" 	=> "Right",
				"center" 	=> "Center", 
				
				),
				'default' => 'left',
				//'condition' => ['title_show' => "yes"],
			]
		);
		
		$this->add_control(
			'title_heading',
			[
				'label' => __( 'Heading', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				 'options' => array(
				
				"h1" 	=> "H1",
				"h2" 	=> "H2",
				"h3" 	=> "H3", 
				"h4" 	=> "H4", 
				
				),
				'default' => 'h2',
				//'condition' => ['title_show' => "yes"],
			]
		);
		
		
		
		$this->add_control(
			'title_style',
			[
				'label' => __( 'Title Style', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
				'options' => array(
				
				"1" 			=> "Style 1",
				"2" 			=> "Style 2",
				"3" 			=> "Style 3",
				"4" 			=> "Style 4",
				"5" 			=> "Style 5",
				"6" 			=> "Style 6",
 				
				),
				'default' => '1',
				//'condition' => ['title_show' => "yes"],
				"description" => "<br><hr><br>",
			]
		);	
		$this->add_control(
			'title',
			[
				'label' 	=> __( 'Title', 'premiumpress' ),
				'type' 		=> \Elementor\Controls_Manager::TEXTAREA,
				'default' 	=> "",			 
				//'condition' => ['title_show' => "yes"],
			]
		);
		$this->add_control(
			'title_font',
			[
				'label' => __( 'Font', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				//'condition' => ['title_show' => "yes"],
			]
		);
		
		
		$this->add_control(
			'title_margin',
			[
				'label' => __( 'Margin Bottom', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
					'mb-0' => "0px",
					'mb-1' => "10px",
					'mb-2' => "20px",
					'mb-3' => "30px" ,
					'mb-4' => "40px",
					'mb-5' => "50px",					
				),
				
				'default' => 'mb-4',
				//'condition' => ['title_show' => "yes" ],
			]
		);
		$this->add_control(
			"title_txtcolor",
			[
				'label' => __( 'Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
				'options' => array(
					'white' 	=> "White", 
					'black' 	=> "Black", 
					
					'light' 	=> "Light",
					'dark' 		=> "Dark",
					 
					"primary" 	=> "Primary Color", 
					"secondary" => "Secondary Color"
					 
					 
				),
				'default' => 'dark',
				//'condition' => ['title_show' => "yes" ],
			]
		);	
		$this->add_control(
			"title_txtw",
			[
				'label' => __( 'Bold', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
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
			]
		);	
			
		
		$this->add_control(
			'subtitle',
			[
				'label' => __( 'Subtitle', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,	
				'default' 	=> "",				
				//'condition' => ['title_show' => "yes"],
			]
		);	
		
		$this->add_control(
			'subtitle_font',
			[
				'label' => __( 'Font', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				//'condition' => ['title_show' => "yes"],
			]
		);
		
		$this->add_control(
			'subtitle_margin',
			[
				'label' => __( 'Margin Bottom', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
					'mb-0' => "0px",
					'mb-1' => "10px",
					'mb-2' => "20px",
					'mb-3' => "30px" ,
					'mb-4' => "40px",
					'mb-5' => "50px",
					
				),
				
				'default' => 'mb-4',
				//'condition' => ['title_show' => "yes" ],
			]
		);	
		$this->add_control(
			"subtitle_txtcolor",
			[
				'label' => __( 'Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
				'options' => array(
					'white' 	=> "White", 
					'black' 	=> "Black", 
					
					'light' 	=> "Light",
					'dark' 		=> "Dark",
					 
					"primary" 	=> "Primary Color", 
					"secondary" => "Secondary Color"
				),
				'default' => 'dark',
				//'condition' => ['title_show' => "yes" ],
			]
		);	
		
		$this->add_control(
			"subtitle_txtw",
			[
				'label' => __( 'Bold', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
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
			]
		);	
		
		$this->add_control(
			'desc',
			[
				'label' => __( 'Description', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,	
				'default' 	=> "",									
				//'condition' => ['title_show' => "yes"],
			]
		);
		$this->add_control(
			'desc_font',
			[
				'label' => __( 'Font', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				//'condition' => ['title_show' => "yes"],
			]
		);
		$this->add_control(
			'desc_margin',
			[
				'label' => __( 'Margin Bottom', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
					'mb-0' => "0px",
					'mb-1' => "10px",
					'mb-2' => "20px",
					'mb-3' => "30px" ,
					'mb-4' => "40px",
					'mb-5' => "50px",
					
				),
				
				'default' => 'mb-4',
				//'condition' => ['title_show' => "yes" ],
			]
		);
		$this->add_control(
			"desc_txtcolor",
			[
				'label' => __( 'Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
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
				//'condition' => ['title_show' => "yes" ],
			]
		);	
		
		$this->end_controls_section();	
	
	
		/************** BUTTON CONTROLS */
 
		$this->start_controls_section(
			'ppt_button',
			[
				'label' => __( 'Button', 'premiumpress' ),	
		 		'condition' => ['btn_show' => "yes"  ],	
				 
			]
		);	
		
			
		$this->add_control(
			'div_panel_alert3',
			[
				//'label' => __( 'Block Type 1', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,				 
				'raw' => '<script>ppt_update_panel("btn");</script>',
			]
		);	
	 
		
		$this->add_control(
			'btn_txt',
			[
				'label' => __( 'Caption', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Search Website',				
				'condition' => ['btn_show' => "yes"  ],
			]
		);
		$this->add_control(
			'btn_link',
			[
				'label' => __( 'Link', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'https://', 'premiumpress' ),
				'condition' => ['btn_show' => "yes" ],
			]
		);
		
		$this->add_control(
			'btn_size',
			[
				'label' => __( 'Size', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
					'btn-sm' => "Small",
					'btn-md' => "Medium",
					'btn-lg' => "Large" ,
					'btn-xl' => "Extra Large",
				),
				
				'default' => 'btn-md',
				'condition' => ['btn_show' => "yes" ],
			]
		);
		
		$this->add_control(
			'btn_font',
			[
				'label' => __( 'Font', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				'condition' => ['btn_show' => "yes"],
			]
		);
		
		$this->add_control(
			'btn_style',
			[
				'label' => __( 'Style', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
					"1" 	=> "Normal",
					"2" 	=> "Outlined",	
					"3" 	=> "Normal Rounded",	
					"4" 	=> "Outlined Rounded",
					
					"5" 	=> "Square Edges",
					 
				),
				
				'default' => '1',
				'condition' => ['btn_show' => "yes" ],
			]
		);
		
		$this->add_control(
			'btn_margin',
			[
				'label' => __( 'Margin Top', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
					'mt-0' => "0px",
					'mt-1' => "10px",
					'mt-2' => "20px",
					'mt-3' => "30px" ,
					'mt-4' => "40px",
					'mt-5' => "50px",
					
				),
				
				'default' => 'mt-0',
				'condition' => ['btn_show' => "yes" ],
			]
		);
			
		$this->add_control(
			'btn_icon',
			[
				'label' => __( 'Icon', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => '', 
				],
				'condition' => ['btn_show' => "yes" ],
			]
		);
		$this->add_control(
			'btn_icon_pos',
			[
				'label' => __( 'Icon Position', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array('before' => "Before",'after' => "After" ),
				'default' => 'before',
				'condition' => ['btn_show' => "yes" ],
			]
		);
		$this->add_control(
			'btn_bg',
			[
				'label' => __( 'Button Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
					'primary' 	=> "Primary Color",
					'secondary' => "Secondary Color",
					'light' 	=> "Light Color" ,
					'dark' 		=> "Dark Color",
					
					'orange' 		=> "Orange Color",
				),
				
				'default' => 'primary',
				'condition' => ['btn_show' => "yes" ],
			]
		);	
		
		$this->add_control(
			'btn_bg_txt',
			[
				'label' => __( 'Text Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array('text-dark' => "Dark",'text-light' => "Light" ),
				'default' => 'text-light',
				'condition' => ['btn_show' => "yes", 'type' => array('header','text','video','hero')],
			]
		);	
		
		$this->end_controls_section();
		/***************** END button **/
 	
		
		
		
/************** BUTTON CONTROLS */
 
		$this->start_controls_section(
			'ppt_button2',
			[
				'label' => __( 'Button 2', 'premiumpress' ),	
				  'condition' => ['btn2_show' => "yes"  ],	
				 
			]
		);	
		
	 	
		$this->add_control(
			'div_panel_alert4',
			[
				//'label' => __( 'Block Type 1', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,				 
				'raw' => '<script>ppt_update_panel("btn2");</script>',
			]
		);	
		
		
		
		$this->add_control(
			'btn2_txt',
			[
				'label' => __( 'Caption', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'Join Now',				
				'condition' => ['btn2_show' => "yes"  ],
			]
		);
		$this->add_control(
			'btn2_link',
			[
				'label' => __( 'Link', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'https://', 'premiumpress' ),
				'condition' => ['btn2_show' => "yes" ],
			]
		);
		
		$this->add_control(
			'btn2_size',
			[
				'label' => __( 'Size', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
					'btn-sm' => "Small",
					'btn-md' => "Medium",
					'btn-lg' => "Large" ,
					'btn-xl' => "Extra Large",
				),
				
				'default' => 'btn-md',
				'condition' => ['btn2_show' => "yes" ],
			]
		);
		
		$this->add_control(
			'btn2_font',
			[
				'label' => __( 'Font', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				'condition' => ['btn2_show' => "yes"],
			]
		);
		
		$this->add_control(
			'btn2_style',
			[
				'label' => __( 'Style', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
				
					"1" 	=> "Normal",
					"2" 	=> "Outlined",	
					"3" 	=> "Normal Rounded",	
					"4" 	=> "Outlined Rounded",
					 "5" 	=> "Square Edges",
				),
				
				'default' => '1',
				'condition' => ['btn2_show' => "yes" ],
			]
		);	
		
		$this->add_control(
			'btn2_margin',
			[
				'label' => __( 'Margin Top', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
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
			]
		);
		$this->add_control(
			'btn2_icon',
			[
				'label' => __( 'Icon', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'condition' => ['btn2_show' => "yes" ],
			]
		);
		$this->add_control(
			'btn2_icon_pos',
			[
				'label' => __( 'Icon Position', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array('before' => "Before",'after' => "After" ),
				'default' => 'before',
				'condition' => ['btn2_show' => "yes" ],
			]
		);
		$this->add_control(
			'btn2_bg',
			[
				'label' => __( 'Button Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
					'primary' 	=> "Primary Color",
					'secondary' => "Secondary Color",
					'light' 	=> "Light Color" ,
					'dark' 		=> "Dark Color",
				),
				
				'default' => 'primary',
				'condition' => ['btn2_show' => "yes" ],
			]
		);	
		
		$this->add_control(
			'btn2_bg_txt',
			[
				'label' => __( 'Text Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array('text-dark' => "Dark",'text-light' => "Light" ),
				'default' => 'text-light',
				'condition' => ['btn2_show' => "yes"],
			]
		);	
		
		$this->end_controls_section();
		/***************** END button **/
		
		
		
		
		
		
		
		
		
		
		
		
		/******************** FAQ OPTIONS **/
		
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
								/*[
									'name' => 'faq_title'.$ttt,
									'operator' => '!=',
									'value' => ''
								],*/
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
		
		
 
		
		$this->add_control(
			'faq_title'.$i,
			[
				'label' => __( 'Title', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '', 'premiumpress' ),
				'placeholder' => "",
				'condition' => ['type' => 'faq' ],
			]
		);
		
 		$this->add_control(
			'faq_desc'.$i,
			[
				'label' => __( 'Description', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => __( '', 'premiumpress' ),
				'placeholder' => "",
				'condition' => ['type' => 'faq' ],
			]
		);
		
		$i++; } 
	 
		$this->end_controls_section();
		/***************** END IMAGE OPTIONS **/	
		
		
		
		
	 	
		
		/******************** slider OPTIONS **/
		
		$i=1; while($i < 4){ 
	   $this->end_controls_section();	
		$this->start_controls_section(
			'extra_section'.$i,
			[
				'label' => __( 'Slider Box', 'premiumpress' )." ".$i,	
				'condition' => ['type' => 'slider' ],		
				 
			]
		); 	
		
		$this->add_control(
			'image'.$i,
			[
				'label' => __( 'Image', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => ['type' => 'slider' ],
			]
		); 
		
		$this->add_control(
			'image'.$i."_txtcolor",
			[
				'label' => __( 'Text Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
				'options' => array('dark' => "Dark",'light' => "White" ),
				'default' => 'light',
				'condition' => ['type' => 'slider' ],
			]
		);	
		
		$this->add_control(
			'image'.$i."_txtdir",
			[
				'label' => __( 'Text Location', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
				'options' => array('left' => "Left",'center' => "Centered","right" => "Right" ),
				'default' => 'left',
				'condition' => ['type' => 'slider' ],
			]
		);	
				
		$this->add_control(
			'image'.$i."_title",
			[
				'label' => __( 'Title', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				
				'placeholder' => "",
				'condition' => ['type' => 'slider' ],
			]
		);
		
		$this->add_control(
			'image'.$i."_desc",
			[
				'label' => __( 'Description', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,				
				'placeholder' => "",
				'condition' => ['type' => 'slider' ],
			]
		);
 
		$this->add_control(
			'image'.$i."_btn_text",
			[
				'label' => __( 'Button Text', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => "",
				'condition' => ['type' => 'slider' ],
			]
		);		
		
		$this->add_control(
			'image'.$i."_btn_link",
			[
				'label' => __( 'Button Link', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => home_url()."?s=",
				'placeholder' => "",
				'condition' => ['type' => 'slider' ],
			]
		);
		
		$i++; } 
	 
		$this->end_controls_section(); 
		
		
		
		/******************** USER BLOCK  **/
		   $this->start_controls_section(
					'user_block_section',
					[
						'label' => __( 'User Settings', 'premiumpress' ),						
						'condition' => ['type' => 'users' ],					 
					]
			); 
			
			$this->add_control(
            'user_type',
            [
                'label' => __( 'User Type', 'premiumpress' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    "all" 	=> "All Users",
					"user_fr" 	=> "Freelancers",
					"user_em" 	=> "Employees",
                ],
                'default' => 'all',
				'condition' => ['type' => 'users' ],

            ]
        ); 
			
		
		$this->end_controls_section(); 
		
		/******************** CATEGORY BLOCK  **/
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
	
	/*	
       $this->add_control(
            'cat_orderby',
            [
                'label' => __( 'Order By', 'premiumpress' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(					
					'name' => 'Name',
					'rand' => 'Random',				
					'menu_order' => 'Menu Order',
				),
                'default' => 'name',
				'condition' => ['type' => 'category' ],

            ]
        );

        $this->add_control(
            'cat_order',
            [
                'label' => __( 'Order', 'premiumpress' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ],
                'default' => 'desc',
				'condition' => ['type' => 'category' ],

            ]
        );*/
		
		   $this->add_control(
            'cat_show_list',
            [
                'label' => __( 'List Items', 'premiumpress' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '5',
				'condition' => ['type' => 'category' ],
            ]
        );

		
		
		$this->end_controls_section(); 
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/******************** IMAGE BLOCK OPTIONS **/
		
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
								/*[
									'name' => 'image_block'.$ttt."_title",
									'operator' => '!=',
									'value' => ''
								],*/
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
			
 
		
		$this->add_control(
			'image_block'.$i,
			[
				'label' => __( 'Image', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => ['type' => 'image_block' ],
			]
		); 
		
			$this->add_control(
			'image_block'.$i."_effect",
			[
				'label' => __( 'Effect', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array("1" => "1", "2" => "2  - line (dark)" ,"3" => "3 - line (light)", "4" => "4", "5" => "5 - blank" ),
				'default' => '1',
				'condition' => [ 'type' => 'image_block' ],
			]
		);	
		
		
		$this->add_control(
			'image_block'.$i."_txtpos",
			[
				'label' => __( 'Text Location', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
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
			]
		);	
		
		
		
		
 
		
	
		$this->add_control(
			'image_block'.$i.'_title',
			[
				'label' 	=> __( 'Title', 'premiumpress' ),
				'type' 		=> \Elementor\Controls_Manager::TEXTAREA,
				'default' 	=> "",				 
				'condition' => [ 'type' => 'image_block' ],
				
			]
		);
		$this->add_control(
			'image_block'.$i.'_title_font',
			[
				'label' => __( 'Font', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				'condition' => [ 'type' => 'image_block' ],
			]
		);
		
		$this->add_control(
			'image_block'.$i.'_title_txtsize',
			[
				'label' => __( 'Title Size', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
				'options' => array(
				
					'sm' => "Small",
					'md' => "Medium",
					'lg' => "Large" ,
					'xl' => "Extra Large",
 					'xxl' => "Extra Extra Large",
				),
				'default' => 'md',
				'condition' => [ 'type' => 'image_block' ],
			]
		);
		
		$this->add_control(
			'image_block'.$i.'_title_margin',
			[
				'label' => __( 'Margin Bottom', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
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
			]
		);
		$this->add_control(
			'image_block'.$i.'_title_txtcolor',
			[
				'label' => __( 'Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
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
			]
		);	
		$this->add_control(
			'image_block'.$i.'_title_txtw',
			[
				'label' => __( 'Bold', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
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
			]
		);	
			
		
		$this->add_control(
			'image_block'.$i.'_subtitle',
			[
				'label' => __( 'Subtitle', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,	
				'default' 	=> "",				
				'condition' => [ 'type' => 'image_block' ],
			]
		);	
		
		$this->add_control(
			'image_block'.$i.'_subtitle_txtsize',
			[
				'label' => __( 'Subtitle Size', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
				'options' => array(
				
					'sm' => "Small",
					'md' => "Medium",
					'lg' => "Large" ,
					'xl' => "Extra Large",
					'xxl' => "Extra Extra Large",
 				
				),
				'default' => 'md',
				'condition' => [ 'type' => 'image_block' ],
			]
		);
		
		$this->add_control(
			'image_block'.$i.'_subtitle_font',
			[
				'label' => __( 'Font', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				'condition' => [ 'type' => 'image_block' ],
			]
		);
		
		$this->add_control(
			'image_block'.$i.'_subtitle_margin',
			[
				'label' => __( 'Margin Bottom', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
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
			]
		);	
		$this->add_control(
			'image_block'.$i.'_subtitle_txtcolor',
			[
				'label' => __( 'Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
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
			]
		);	
		
		$this->add_control(
			'image_block'.$i.'_subtitle_txtw',
			[
				'label' => __( 'Bold', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				
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
			]
		);	
		
		 
		
	 
		
		$this->add_control(
			'image_block'.$i."_btn_show",
			[
				'label' => __( 'Button', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				 
				 'options' => array( 
				 
					"yes" 	=> "Show",
					"no" 	=> "Hide",							 
				),
				'default' => 'yes',
				 
				'placeholder' => "",
				'condition' => ['type' => 'image_block' ],
			]
		);
		$this->add_control(
			'image_block'.$i."_btn_txt",
			[
				'label' => __( 'Button Text', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			 
				'default' => 'Button',
				  
				'condition' => ['type' => 'image_block' ],
			]
		);	
		
			$this->add_control(
			'image_block'.$i."_btn_link",
			[
				'label' => __( 'Button Link', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			 
				'default' => 'http://',
				  
				'condition' => ['type' => 'image_block' ],
			]
		);	
		
$this->add_control(
			'image_block'.$i.'_btn_size',
			[
				'label' => __( 'Size', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
					'btn-sm' => "Small",
					'btn-md' => "Medium",
					'btn-lg' => "Large" ,
					'btn-xl' => "Extra Large",
				),
				
				'default' => 'btn-md',
				'condition' => ['type' => 'image_block' ],
			]
		);
		
		$this->add_control(
			'image_block'.$i.'_btn_font',
			[
				'label' => __( 'Font', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				 'options' =>  $CORE->LAYOUT("get_fonts", array() ),
				'default' => '',
				'condition' => ['type' => 'image_block' ],
			]
		);
		
		$this->add_control(
			'image_block'.$i.'_btn_style',
			[
				'label' => __( 'Style', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
					"1" 	=> "Normal",
					"2" 	=> "Outlined",	
					"3" 	=> "Normal Rounded",	
					"4" 	=> "Outlined Rounded",
					 	"5" 	=> "Square Edges",
				),
				
				'default' => '1',
				'condition' => ['type' => 'image_block' ],
			]
		);
		
	 
		$this->add_control(
			'image_block'.$i.'_btn_margin',
			[
				'label' => __( 'Margin Top', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
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
			]
		);
			
		$this->add_control(
			'image_block'.$i.'_btn_icon',
			[
				'label' => __( 'Icon', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => '', 
				],
				'condition' => ['type' => 'image_block' ],
			]
		);
		$this->add_control(
			'image_block'.$i.'_btn_icon_pos',
			[
				'label' => __( 'Icon Position', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array('before' => "Before",'after' => "After" ),
				'default' => 'before',
				'condition' => ['type' => 'image_block' ],
			]
		);
		$this->add_control(
			'image_block'.$i.'_btn_bg',
			[
				'label' => __( 'Button Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
					'primary' 	=> "Primary Color",
					'secondary' => "Secondary Color",
					'light' 	=> "Light Color" ,
					'dark' 		=> "Dark Color",
				),
				
				'default' => 'primary',
				'condition' => ['type' => 'image_block' ],
			]
		);	
		
		$this->add_control(
			'image_block'.$i.'_btn_bg_txt',
			[
				'label' => __( 'Text Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array('text-dark' => "Dark",'text-light' => "Light" ),
				'default' => 'text-light',
				'condition' => ['type' => 'image_block' ],
			]
		);	
		  
		
		$i++; } 
	 
		$this->end_controls_section();
		
		

		/******************** TEXT OPTIONS **/
		
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
								/*[
									'name' => 'text_image'.$ttt.'_title',
									'operator' => '!=',
									'value' => ''
								],*/
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
		  
		$this->add_control(
			'text_image'.$i,
			[
				'label' => __( 'Image', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => ['type' => ['text','video'] ],
			]
		); 
		 
		$this->add_control(
			'text_image'.$i."_title",
			[
				'label' => __( 'Title', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,			 	 
				'condition' => ['type' => ['text','video'] ],
			]
		);
		
		$this->add_control(
			'text_image'.$i."_link",
			[
				'label' => __( 'Link', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,				
				'condition' => ['type' => ['text','video'] ],
			]
		);
		
		$i++; } 
	 
		$this->end_controls_section();
		/***************** END TEXT OPTIONS **/
		
		
		
		
		/******************** AUTHOR OPTIONS **/
		
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
								/*[
									'name' => 'author_name'.$ttt,
									'operator' => '!=',
									'value' => ''
								],*/
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
		
		
		$this->add_control(
			'author_image'.$i,
			[
				'label' => __( 'User Photo', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => ['type' => 'testimonials' ],
			]
		); 
		
		
		$this->add_control(
			'author_name'.$i,
			[
				'label' => __( 'Name', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,				
				'placeholder' => __( 'John Doe', 'premiumpress' ),
				'condition' => ['type' => 'testimonials' ],
			]
		);
		
		$this->add_control(
			'author_job'.$i,
			[
				'label' => __( 'Job Title', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			 
				'placeholder' => "CEO Google",
				'condition' => ['type' => 'testimonials' ],
			]
		);
		
		$this->add_control(
			'author_quote'.$i,
			[
				'label' => __( 'Quote', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
			 	 
				'condition' => ['type' => 'testimonials' ],
			]
		);		
		
		
		$i++; } 
	 
		$this->end_controls_section();
		
		
		/******************** ICON OPTIONS **/
		
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
								/*[
									'name' => 'icon'.$ttt.'_title',
									'operator' => '!=',
									'value' => ''
								],*/
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
					'type' => \Elementor\Controls_Manager::SELECT, 
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
					'type' => \Elementor\Controls_Manager::SELECT, 
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
				'type' => \Elementor\Controls_Manager::TEXTAREA,			 
				'condition' => ['type' => 'icon' ],
			]
		);
		
		$this->add_control(
				'icon'.$i.'_txtcolor',
				[
					'label' => __( 'Title Color', 'premiumpress' ),
					'type' => \Elementor\Controls_Manager::SELECT, 
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
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'condition' => ['type' => 'icon' ],
			]
		);		
		
		
		$this->add_control(
			'icon'.$i."_link",
			[
				'label' => __( 'Link', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,				 
				'condition' => ['type' => 'icon' ],
			]
		);
		
		
		
		$i++; } 
	 
		$this->end_controls_section();
		/***************** END IMAGE OPTIONS **/
		
		
		
		/******************** SECTION **/
		$this->start_controls_section(
			'ppt_footer',
			[
				'label' => __( 'Footer Settings', 'premiumpress' ),
				'condition' => ['type' => array('footer')],				 	
				 
			]
		);	
		
		$this->add_control(
			'footer_description',
			[
				'label' 	=> __( 'Description', 'premiumpress' ),
				'type' 		=> \Elementor\Controls_Manager::TEXTAREA,
				'default' 	=> _ppt(array('company','info')),				 
				'condition' => ['type' => array('footer')],
			]
		);
		
		
		
		$this->add_control(
			'footer_menu1_title',
			[
				'label' => __( 'Menu 1 Title', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,				 
				'condition' => ['type' => array('footer')],
			]
		);
		
		$this->add_control(
			'footer_menu1',
			[
				'label' 	=> __( 'Menu 1 Link', 'premiumpress' ),
				'type' 		=> \Elementor\Controls_Manager::SELECT,
				'options' => _ppt_elementor_menus(),
				'default' 	=> "",				 
				'condition' => ['type' => array('footer')],
			]
		);
		
		
		$this->add_control(
			'footer_menu2_title',
			[
				'label' => __( 'Menu 2 Title', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::TEXT,				 
				'condition' => ['type' => array('footer')],
			]
		);
		
		$this->add_control(
			'footer_menu2',
			[
				'label' 	=> __( 'Menu 2 Links', 'premiumpress' ),
				'type' 		=> \Elementor\Controls_Manager::SELECT,
				'options' => _ppt_elementor_menus(),
				'default' 	=> "",				 
				'condition' => ['type' => array('footer')],
			]
		);		
		
		$this->add_control(
			'footer_copyright_style',
			[
				'label' => __( 'Copyright Style', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
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
				'condition' => ['type' => array('footer')],	
			]
		);
		
		$this->add_control(
			'footer_copyright',
			[
				'label' 	=> __( 'Copyright Text', 'premiumpress' ),
				'type' 		=> \Elementor\Controls_Manager::TEXTAREA,
				'default' 	=> "&copy; ".date("Y")." ".stripslashes(_ppt(array('company','name'))),				 
				'condition' => ['type' => array('footer')],
			]
		);
		
		
		$this->end_controls_section();
				
		
		/******************** SECTION **/
		$this->start_controls_section(
			'ppt_section',
			[
				'label' => __( 'Section', 'premiumpress' ),
				'conditions' => [
				'relation' => 'and',
				'terms' => [		
					 
					[
						'name' 		=> 'type',
						'operator' 	=> '!=',
						'value' 	=> ""
					],
					[
						'name' 		=> 'type',
						'operator' 	=> '!in',
						'value' 	=> ['header','hero','listingpage']
					],	
					 
				]
			]
				 	
				 
			]
		);		
		$this->add_control(
			'section_bg',
			[
				'label' => __( 'Background', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
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
				 
			]
		);
		
		$this->add_control(
			'section_w',
			[
				'label' => __( 'Container Width', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
				
					'container-fluid' 	=> "Full Width (100%)",					
					'container' 		=> "Container (1300px)" ,
					'container-slim' 	=> "Slim (1000px)",
				),
				
				'default' => 'container',
				 
			]
		);
		
		$this->add_control(
			'section_pos',
			[
				'label' => __( 'Text Position', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				 'options' => array(
				
				"" 			=> "default",				 
				"text-center" 	=> "Center", 
				
				),
				'default' => '',
				 
			]
		);	
		
		$this->add_control(
			'section_pattern',
			[
				'label' => __( 'Pattern', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
				'options' => array(
				
					'' 	=> "None",					
					'1' 		=> "Style 1",
					'2' 		=> "Style 2",
					'3' 		=> "Style 3",
					'4' 		=> "Style 4",
					'5' 		=> "Style 5",
					
				),
				
				'default' => '',
				 
			]
		);
			
		$this->add_control(
			'section_padding',
			[
				'label' => __( 'Padding', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::SELECT,				
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
		 
			]
		);			
 
			 
		
		$this->end_controls_section();
		
		
	
		
	
		
		
		
		
 	$this->start_controls_section(
			'listings_section',
			[
				'label' => __( 'Listing Settings', 'premiumpress' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => ['type' => array('listings') ],
			]
		);
		
		
        $this->add_control(
            'card',
            [
                'label' => __( 'Card Style', 'premiumpress' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'small' 		=> 'Small',
                    'blank' 		=> 'Blank',
					'info' 			=> 'Info',
					'list' 			=> 'List',
					'list-small' 	=> 'List Small',
					'list-xsmall' 	=> 'List Extra Small',
 					
                ],
                'default' => 'info',
				'condition' => ['type' => array('listings') ],

            ]
        );
		
		 

        $this->add_control(
            'limit',
            [
                'label' => __( 'Per Page', 'premiumpress' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
               // 'default' => '9',
				'condition' => ['type' => array('listings') ],
				
				"description" => __( 'This option is not used in all design blocks.', 'premiumpress' )
            ]
        );
		 
		 
		 $this->add_control(
            'perrow',
            [
                'label' => __( 'Per Row', 'premiumpress' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => '',
				'condition' => ['type' => array('listings') ],
				
				"description" => __( 'This option is not used in all design blocks.', 'premiumpress' )
				
            ]
        ); 
	
		 
		$this->add_control(
				'custom',
				[
					'label' => __( 'Custom', 'premiumpress' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'options' => _ppt_custom_searchlist(),
					'default' => 'new',
					'condition' => ['type' => array('listings') ],
					
					"description" => __( 'This option is not used in all design blocks.', 'premiumpress' )
				]
		);
 

        $this->add_control(
            'orderby',
            [
                'label' => __( 'Default Order By', 'premiumpress' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array(
					'ID' => 'Post ID',
					'author' => 'Post Author',
					'title' => 'Title',
					'date' => 'Date',
					'modified' => 'Last Modified Date',				
					'rand' => 'Random',				
					'menu_order' => 'Menu Order',
				),
                'default' => 'date',
				'condition' => ['type' => array('listings') ],
				
				"description" => __( 'This option is not used in all design blocks.', 'premiumpress' )

            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __( 'Order', 'premiumpress' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending'
                ],
                'default' => 'desc',
				'condition' => ['type' => array('listings') ],
				
				"description" => __( 'This option is not used in all design blocks.', 'premiumpress' )

            ]
        );
		
		
		$taxK = "listing";
		$taxN = __( 'Category', 'premiumpress' );
		$taxHide = true;
		if(THEME_KEY == "da"){		
			$taxK = "dagender";
			$taxN = __( 'Gender', 'premiumpress' );
			$taxHide = false;
		}
		
		$category_options = array();
		$terms = get_terms( array(
			'taxonomy' => $taxK,
			'hide_empty' => $taxHide,
		));
	
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
			foreach ( $terms as $term ) {
				$category_options[ $term->term_id ] = $term->name;
			}
		}
		
		$this->add_control(
            'cat',
            [
                'label' => $taxN,
                'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' =>  $category_options,                
				'default' => '',
				'condition' => ['type' => array('listings') ],
				
				"description" => __( 'This option is not used in all design blocks.', 'premiumpress' )
            ]
        );
	 

		$this->end_controls_section();		
		
		
		/***************** END LISTING SETTINGS  **/	
		
		
		
		
		
/*
	$this->start_controls_section(
			'globals_section',
			[
				'label' => __( 'Global Settings', 'premiumpress' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => ['type' => array('header') ],
			]
		);
		
 
	  $this->add_control(
			'color_primary',
			[
				'label' => __( 'Primary Color', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => _ppt(array('design','color_primary')),
				'condition' => ['type' => 'header' ],
			]
		);		
	  $this->add_control(
			'color_secondary',
			[
				'label' => __( 'Primary Secondary', 'premiumpress' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => _ppt(array('design','color_secondary')),
				'condition' => ['type' => 'header' ],
			]
		);	
			
		$this->end_controls_section();
*/		
		 	
		
		
		
		
 		

	}
/*
protected function _content_template() {
	?>
	<#
		view.addInlineEditingAttributes( 'title', 'none' );
		view.addInlineEditingAttributes( 'subtitle', 'none' );
		view.addInlineEditingAttributes( 'desc', 'none' );
        view.addInlineEditingAttributes( 'btn_txt', 'none' );
        view.addInlineEditingAttributes( 'btn2_txt', 'none' );
		#>
	<?php
}*/
	
	
	protected function render() {
	
	global $new_settings, $CORE;
 	 	
	$new_settings = array();
	
	$GLOBALS['elementor_render'] = 1;
	
	$s = $this->get_settings_for_display();	
		
	// BUILD ID
	$BLOCKID = "";
	if(strlen($s['type']) > 1){
		$TID =  $s['type']."_style";
		$BLOCKID = $s[$TID];
	} 
		
	if(strlen($s['type']) < 2 ||  strlen($BLOCKID) < 2){	
	
	?>
    <div style="height:300px; line-height:200px; text-align:center;border:2px solid #ddd;">
   <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/framework/images/premiumpress.png" class="" style="height:150px;opacity:0.1; " />
	   <?php if(strlen($s['type']) < 2 ){ ?>
        <div style="color:#999999; margin-top:-50px;">Please select a category</div>        
       <script> window.parent.label_1(); </script>        
       <?php }else{ ?>
        <div style="color:#999999; margin-top:-50px;">Please select your design layout...</div>
        <script> window.parent.label_2(); </script>
        <?php } ?>        
    </div>
    
    <?php	
		
	}elseif(strlen($s['type']) > 1){ 
	 	 
		// SECTIONS
		$new_settings["section_padding"]  	= $s['section_padding'];
		$new_settings["section_bg"] 		= $s['section_bg'];	
		$new_settings["section_pos"] 		= $s['section_pos']; 
		$new_settings["section_w"] 			= $s['section_w']; 
		$new_settings["section_pattern"] 	= $s['section_pattern'];  
		
		
		
	
			// INLINE EDITOR
			/*
			$this->add_inline_editing_attributes( 'title', 'none' );
			$this->add_inline_editing_attributes( 'subtitle', 'none' );
			$this->add_inline_editing_attributes( 'desc', 'none' );			 
			$this->add_inline_editing_attributes( 'btn_txt', 'none' );
			$this->add_inline_editing_attributes( 'btn2_txt', 'none' );
		*/
			 
	 
		// TITLES
		if($s['title_show'] == "yes"){
		
		
		
		$new_settings["title_show"]  = $s['title_show'];
		$new_settings["title"] 		 = $s['title'];
		$new_settings["subtitle"] 	 = $s['subtitle'];
		
		if($s['subtitle'] == ""){
		$new_settings["subtitle"] = " ";
		}
		
		$new_settings["desc"]		 = $s['desc'];		
		if($s['desc'] == ""){
		$new_settings["desc"] = " ";
		}
		
		
		$new_settings["title_style"] = $s['title_style'];	
		$new_settings["title_pos"] 	 = $s['title_pos'];		
		$new_settings["title_heading"] 	 = $s['title_heading'];	
		
		$new_settings["title_margin"] 		 = $s['title_margin'];
		$new_settings["subtitle_margin"] 	 = $s['subtitle_margin'];
		$new_settings["desc_margin"] 		 = $s['desc_margin'];
		
		$new_settings["title_txtcolor"] 	 = $s['title_txtcolor'];
		$new_settings["subtitle_txtcolor"] 	 = $s['subtitle_txtcolor'];
		$new_settings["desc_txtcolor"] 		 = $s['desc_txtcolor'];	

		$new_settings["title_font"] 	 = $s['title_font'];
		$new_settings["subtitle_font"] 	 = $s['subtitle_font'];
		$new_settings["desc_font"] 		 = $s['desc_font'];	

		
		$new_settings["title_txtw"] 	 = $s['title_txtw'];
		$new_settings["subtitle_txtw"] 	 = $s['subtitle_txtw'];
			
		
		}elseif($s['title_show'] == "no"){		
		$new_settings["title_show"]  = $s['title_show'];		
		}	
		
		// BUTTONS
		if($s['btn_show'] == "yes"){
		 
			
		$new_settings["btn_show"]	 = $s['btn_show'];
		$new_settings["btn_link"]	 = $s['btn_link'];
		$new_settings["btn_txt"]	 = $s['btn_txt'];
		$new_settings["btn_bg"]	 	 = $s['btn_bg'];
		$new_settings["btn_bg_txt"]	 = $s['btn_bg_txt'];		
		$new_settings["btn_icon"]	 = $s['btn_icon']['value'];
		$new_settings["btn_icon_pos"]= $s['btn_icon_pos'];
		$new_settings["btn_size"]	 = $s['btn_size'];	
		$new_settings["btn_margin"]	 = $s['btn_margin'];
		$new_settings["btn_style"]	 = $s['btn_style'];
		$new_settings["btn_font"]	 = $s['btn_font'];
		
		}elseif($s['btn_show'] == "no"){		
		$new_settings["btn_show"]  = $s['btn_show'];		
		}
		
		// BUTTONS 2
		if($s['btn2_show'] == "yes"){
		$new_settings["btn2_show"]	 = $s['btn2_show'];
		$new_settings["btn2_link"]	 = $s['btn2_link'];
		$new_settings["btn2_txt"]	 = $s['btn2_txt'];
		$new_settings["btn2_bg"]	 = $s['btn2_bg'];
		$new_settings["btn2_bg_txt"] = $s['btn2_bg_txt'];		
		$new_settings["btn2_icon"]	 = $s['btn2_icon']['value'];
		$new_settings["btn2_icon_pos"]= $s['btn2_icon_pos'];
		$new_settings["btn2_size"]	 	= $s['btn2_size'];
		$new_settings["btn2_margin"]	 = $s['btn2_margin'];
		$new_settings["btn2_style"]	 = $s['btn2_style'];
		
		$new_settings["btn2_font"]	 = $s['btn2_font'];
		
		}elseif($s['btn2_show'] == "no"){		
		$new_settings["btn2_show"]  = $s['btn2_show'];		
		}	
		
	
		
		// HEADER
		if(in_array( $s['type'], array("header") )){
		 
		 
			$new_settings["topmenu_show"]	 = $s['topmenu_show'];			
			$new_settings["extra_show"]		 = $s['extra_show'];
			$new_settings["extra_type"]		 = $s['extra_type'];	
			
			if($new_settings["topmenu_show"] == ""){ $new_settings["topmenu_show"] = "no"; }		
			if($new_settings["extra_show"] == ""){ $new_settings["extra_show"] = "no"; }		
			 
			//$CORE->FUNC("update_core", array( array('design','color_primary'),  $s['color_primary']) );
			//$CORE->FUNC("update_core", array( array('design','color_secondary'),  $s['color_secondary']) );			 			 
			
		}
	
		
		// FOOTER
		if(in_array( $s['type'], array("footer") )){
		
			$new_settings["footer_copyright"]		 	= $s['footer_copyright'];	
			$new_settings["footer_description"]			= $s['footer_description'];				
			$new_settings["footer_copyright_style"]		= $s['footer_copyright_style'];	
			
			$new_settings["footer_menu1"]		= $s['footer_menu1'];	
			$new_settings["footer_menu2"]		= $s['footer_menu2'];	
			
			$new_settings["footer_menu1_title"]		= $s['footer_menu1_title'];	
			$new_settings["footer_menu2_title"]		= $s['footer_menu2_title'];	
			
		}
		
		// USERS
		if(in_array($s['type'], array("users") )){
			
			$new_settings["user_type"]		= $s['user_type'];	
			 
		}
			
		
		// CATEGORY
		if(in_array( $s['type'], array("category") )){
		 
		 
		 //$new_settings["cat_order"]  	= $s['cat_order'];
		 //$new_settings["cat_orderby"] 	= $s['cat_orderby'];
		 $new_settings["cat_show"] 		= $s['cat_show'];
		 $new_settings["cat_show_list"] = $s['cat_show_list'];
		 $new_settings["cat_offset"] 	= $s['cat_offset'];	 
		 
		}
				
		// IMAGES
		if(in_array( $s['type'], array("image_block") )){
		
			$i=1; while($i < 7){  
			if(isset($s["image_block".$i]['url']) && strlen($s["image_block".$i]['url']) > 10){
			$new_settings["image_block".$i] 				= 	$s["image_block".$i]['url']; 
			}
			
			
			$new_settings["image_block".$i."_effect"] 		= 	$s["image_block".$i."_effect"];
			$new_settings["image_block".$i."_txtpos"] 		= 	$s["image_block".$i."_txtpos"];			
			
			if(strlen($s["image_block".$i]['url']) > 10){		
			
			
				$new_settings["image_block".$i."_title"] 		 = $s['image_block'.$i.'_title'];
				$new_settings["image_block".$i."_subtitle"] 	 = $s['image_block'.$i.'_subtitle'];
				
				$new_settings["image_block".$i."_title_margin"] 		= $s['image_block'.$i.'_title_margin'];
				$new_settings["image_block".$i."_subtitle_margin"] 	 = $s['image_block'.$i.'_subtitle_margin'];			 
				
				$new_settings["image_block".$i."_title_txtcolor"] 	 = $s['image_block'.$i.'_title_txtcolor'];
				$new_settings["image_block".$i."_subtitle_txtcolor"] 	 = $s['image_block'.$i.'_subtitle_txtcolor'];
				
				$new_settings["image_block".$i."_title_txtsize"] 	 = $s['image_block'.$i.'_title_txtsize'];
				$new_settings["image_block".$i."_subtitle_txtsize"] 	 = $s['image_block'.$i.'_subtitle_txtsize'];				
							 
		
				$new_settings["image_block".$i."_title_font"] 	 = $s['image_block'.$i.'_title_font'];
				$new_settings["image_block".$i."_subtitle_font"] 	 = $s['image_block'.$i.'_subtitle_font'];				 
				
				$new_settings["image_block".$i."_title_txtw"] 	 = $s['image_block'.$i.'_title_txtw'];
				$new_settings["image_block".$i."_subtitle_txtw"] 	 = $s['image_block'.$i.'_subtitle_txtw'];
				
			
 				$new_settings["image_block".$i."_btn_show"] 	 = $s['image_block'.$i.'_btn_show'];
				$new_settings["image_block".$i."_btn_txt"] 	 	= $s['image_block'.$i.'_btn_txt'];
				$new_settings["image_block".$i."_btn_bg"]	 	 = $s['image_block'.$i.'_btn_bg'];
				$new_settings["image_block".$i."_btn_bg_txt"]	 = $s['image_block'.$i.'_btn_bg_txt'];		
				$new_settings["image_block".$i."_btn_icon"]	 	= $s['image_block'.$i.'_btn_icon']['value'];
				$new_settings["image_block".$i."_btn_icon_pos"]	= $s['image_block'.$i.'_btn_icon_pos'];
				$new_settings["image_block".$i."_btn_size"]	 	= $s['image_block'.$i.'_btn_size'];	
				$new_settings["image_block".$i."_btn_margin"]	 = $s['image_block'.$i.'_btn_margin'];
				$new_settings["image_block".$i."_btn_style"]	 = $s['image_block'.$i.'_btn_style'];
				$new_settings["image_block".$i."_btn_font"]	 	= $s['image_block'.$i.'_btn_font'];
				$new_settings["image_block".$i."_btn_link"] 	= 	$s["image_block".$i."_btn_link"];
 				
			 		
 			}
			
			$i++; }				 		  
		
		}
		
		// TEXT
		if(in_array( $s['type'], array("text","video") )){
		
			$i=1; while($i < 7){ 
		 	
				if( is_array($s['text_image'.$i]) && isset($s['text_image'.$i]['url']) && strlen($s['text_image'.$i]['url']) > 1 ){
				
				 $new_settings["text_image".$i] 			= $s['text_image'.$i]['url'];
				 $new_settings["text_image".$i."_title"] 	= $s['text_image'.$i."_title"];
				 $new_settings["text_image".$i."_link"] 	= $s['text_image'.$i."_link"];
				}
			
			$i++; }				 		  
		
		}
		
		// VIDEO
		if(in_array( $s['type'], array("video") )){		
		
			$new_settings["video_link"] 	= $s['video_link'];
		 
		
		}

		// ICONS
		if(in_array( $s['type'], array("icon") )){
		
			$i=1; while($i < 10){ 
		 	
			if(strlen($s['icon'.$i."_title"]) > 1){
			
				$new_settings["icon".$i] 			= $s['icon'.$i.""]['value'];	
				$new_settings["icon".$i."_title"] 	= $s['icon'.$i."_title"];
				$new_settings["icon".$i."_desc"] 	= $s['icon'.$i."_desc"];
				$new_settings["icon".$i."_link"] 	= $s['icon'.$i."_link"];
				
				$new_settings["icon".$i."_txtcolor"] 	= $s['icon'.$i."_txtcolor"];
				$new_settings["icon".$i."_iconcolor"] 	= $s['icon'.$i."_iconcolor"];
				
				$new_settings["icon".$i."_type"] 	= $s['icon'.$i."_type"];
				
				if(isset($s["icon".$i."_image"]) && strlen($s["icon".$i."_image"]['url']) > 10){			
					$new_settings["icon".$i."_image"] 	= $s['icon'.$i."_image"]['url'];				
				}
			
			}
			
			$i++; }		
			
			
			
			if(isset($s['image_icon']) && strlen($s['image_icon']['url']) > 10){
			
				$new_settings["image_icon"] 				= $s['image_icon']['url'];
				
			}		 		  
		
		}
						
		// TESTIMONIALS
		if(in_array( $s['type'], array("testimonials") )){
		
			$i=1; while($i < 9){ 
			
		 	if(strlen($s['author_name'.$i]) > 2){
			$new_settings["author_quote".$i] 	= $s['author_quote'.$i];
			$new_settings["author_name".$i] 	= $s['author_name'.$i];
			$new_settings["author_image".$i] 	= $s['author_image'.$i]['url'];
			$new_settings["author_job".$i] 		= $s['author_job'.$i];
			}
			
			$i++; }				 		  
		
		}
		
		// LISTING PAGE
		 
		if(in_array( $s['type'], array("listingpage") )){
		
			// TITLE
			//$new_settings["listingpage_title_social"] 	= $s['listingpage_title_social'];
			$new_settings["listingpage_title_style"] 	= $s['listingpage_title_style'];
			
			// GALLERY
			$new_settings["listingpage_images_style"] 	= $s['listingpage_images_style'];
			
 		
		}
		
		
		
		// slider
		if(in_array( $s['type'], array("slider") )){
		
			$i=1; while($i < 5){ 
			
			if(isset($s['image'.$i]) && strlen($s['image'.$i]['url']) > 10){
			
				$new_settings["image".$i] 				= $s['image'.$i]['url'];			
				$new_settings["image".$i."_title"] 		= $s['image'.$i."_title"];		 
				$new_settings["image".$i."_desc"] 		= $s['image'.$i."_desc"];		 
				$new_settings["image".$i."_btn_text"] 	= $s['image'.$i."_btn_text"];		 
				$new_settings["image".$i."_btn_link"] 	= $s['image'.$i."_btn_link"];		 
				$new_settings["image".$i."_txtcolor"] 	= $s['image'.$i."_txtcolor"];
				$new_settings["image".$i."_txtdir"] 	= $s['image'.$i."_txtdir"];
				
			}
			
			$i++; }						 		  
		
		}	
		
		
		// hero
		if(in_array( $s['type'], array("hero","intro") )){
			
		 	$new_settings["hero_image"] 			= $s['hero_image']['url'];			
			$new_settings["hero_size"] 				= $s['hero_size'];	
			$new_settings["hero_overlay"] 			= $s['hero_overlay'];	
			$new_settings["hero_txtcolor"] 			= $s['hero_txtcolor'];			
			
		}
		
		
		// FAQ
		if(in_array( $s['type'], array("faq") )){
		
			$i=1; while($i < 7){ 
		 	
			if(strlen($s['faq_title'.$i]) > 1){
				$new_settings["faq".$i."_title"] = $s['faq_title'.$i];		 
				$new_settings["faq".$i."_desc"] = $s['faq_desc'.$i];
			}
			
			$i++; }		
			
			$new_settings["image_faq"] 			= $s['image_faq']['url'];						 		  
		
		}	
		
		
		// SUBSCRIBE
		if(isset($s['image_subscribe']['url']) && strlen($s['image_subscribe']['url']) > 10){
		 	$new_settings["image_subscribe"] 			= $s['image_subscribe']['url'];			 
		}	
		
		
		// SUBSCRIBE		
		if(in_array( $s['type'], array("cta") )){
		
			if(isset($s['image_cta']['url']) && strlen($s['image_cta']['url']) > 10){
				$new_settings["image_cta"] 			= $s['image_cta']['url'];			 
			} 
		
		}
		
		// PRICING		
		if(in_array( $s['type'], array("pricing") )){
		 
			$new_settings["pricing_type"] = $s['pricing_type'];
		
		}		
		 
		
			
 	
		// DATASTRING
		if(in_array( $s['type'], array("listings") )){
			
			$cats = "";
		 	if(isset($s['cat']) && is_array($s['cat'])){
				foreach($s['cat'] as $c){
					$cats .= $c.",";
				}
			}else{
				$cats = $s['cat']; 
			}
			 
			$customvalue = ""; 
			
			$s['datastring'] = '
			dataonly="1" 
			cat="'.$cats.'" 
			card="'.$s['card'].'" 
			perrow="'.$s['perrow'].'" 
			show="'.$s['limit'].'" 
			custom="'.$s['custom'].'" 
			customvalue="'.$customvalue.'"
			order="'.$s['order'].'" 
			orderby="'.$s['orderby'].'" 
			debug="0"	
			';
			
			$new_settings['datastring'] =  $s['datastring'];
			$new_settings['perrow'] 	=  $s['perrow'];
			$new_settings['card'] 		=  $s['card'];
			$new_settings['limit'] 		=  $s['limit'];
			$new_settings['custom'] 	=  $s['custom'];
			
		} 
		
		
	 
	 	
		// BUILD ID
		$TID =  $s['type']."_style";
		$BLOCKID = $s[$TID];
 		
		// DISPLAY OUTPUT
		do_action($s[$TID]."-css"); 
		do_action($s[$TID]); 
		do_action($s[$TID]."-js");
		 
		
		// PREVIEW OUTPUT CODE
		if(isset($_GET['preview'])){ 
		
		if(!in_array($s['type'], array('header','footer') ) ){
			$gtt = "home";
		}else{
			$gtt = $s['type'];
		}
		
		?>		
		<textarea style="display:none; width:100%; height:500px;" data-key="<?php echo $BLOCKID; ?>" data-cat="<?php echo $s['type']; ?>"> 
        /* <?php echo $BLOCKID; ?> */<?php foreach($new_settings as $k => $g){ ?>    
        $core["<?php echo $gtt; ?>"]["<?php echo $BLOCKID; ?>"]["<?php echo $k; ?>"] = "<?php echo str_replace('"',"'", preg_replace('/\s+/', ' ',$g)); ?>"; <?php } ?>
		</textarea>
		<?php }  
		 
			
 	
	foreach(array('title','subtitle','desc','btn2','btn', 
	
	'image_block1_subtitle', 'image_block2_subtitle', 'image_block3_subtitle', 'image_block4_subtitle', 'image_block5_subtitle', 'image_block6_subtitle',
	'image_block1_title', 'image_block2_title', 'image_block3_title', 'image_block4_title', 'image_block5_title', 'image_block6_title',
	
	'image_block1_btn', 'image_block2_btn', 'image_block3_btn', 'image_block4_btn', 'image_block5_btn', 'image_block6_btn',
	
	) as $jj){ 
	 
	 	if( isset($s[$jj."_font"]) && strlen($s[$jj."_font"]) > 0 && !isset($GLOBALS['font_set_'.$s[$jj."_font"]]) ){
		
		//$GLOBALS['font_set_'.$s[$jj."_font"]] = 1;
		
		if(isset($_GET['preview_id'])){
		?>
        <link href='https://fonts.googleapis.com/css?family=<?php echo $CORE->LAYOUT("get_fonts", array($s[$jj."_font"], "name") ); ?>' rel='stylesheet' type='text/css'>
		<style>.font-<?php echo $s[$jj."_font"]; ?> { font-family: "<?php echo $CORE->LAYOUT("get_fonts", array($s[$jj."_font"], "name") ); ?>", serif; }</style>
        <?php
		}else{
		?>    
		<script>
			jQuery(document).ready(function() {	
				jQuery("head").append("<link href='https://fonts.googleapis.com/css?family=<?php echo $CORE->LAYOUT("get_fonts", array($s[$jj."_font"], "name") ); ?>' rel='stylesheet' type='text/css'>");
				jQuery("head").find('style').append('.font-<?php echo $s[$jj."_font"]; ?> { font-family: "<?php echo $CORE->LAYOUT("get_fonts", array($s[$jj."_font"], "name") ); ?>", serif !important; }');
			});
		</script>         
		<?php	
		}
		}
	}
	
	
	
	if(isset($_GET['action']) || isset($_POST['actions']) ){ 
	
	 
		?>
        
        <script>		  
		 
		// FOCUS ON BLOCK
		// NEW-HERO IS THE NAME OF THE ELEMENTOR CLASS
		// NOT THE BLOCK SO DONT CHANGE THIS
		jQuery(".elementor-widget-new-hero").on("click", function (e) {
		 
		 
			window.parent.ppt_elementor_change_preview();	
		});
		
		
		</script>
        <?php } 
		
		 
		if(isset($_GET['preview']) || isset($_GET['action']) || isset($_POST['actions'])){ 
		?>
        
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
        <?php	
		}
		
		// MUST REMOVE AT THE END
		// OTHERWISE WILL BLEED ONTO ALL
		// TEMPLATE FILES
		$new_settings = array();
		//	
		
		
		} // end if strlen($s['type']) > 1){ 
				
        
	}

}