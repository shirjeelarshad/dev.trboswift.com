<?php


class core_widget_blank extends WP_Widget {

    function __construct(){
        // widget actual processes		
		$opts = array(
			'classname' => 'core_blank',
			'description' => 'A blank space for custom Text/HTML code.' 
		);
		parent::__construct( 'core_blank',  'Blank Widget' , $opts );		
    }
    function form($instance) {   
	$defaults = array('te' => '');
		$instance = wp_parse_args( $instance, $defaults );		
	 ?>
     <div style="  background: #F7F7F7;  border: 1px solid #ddd;  padding: 10px; padding-top:0px;  margin-top: 20px; margin-bottom:20px;"> 

     <p><b>Content:</b></p>  
  	 <p><textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'te' ); ?>" name="<?php echo $this->get_field_name( 'te' ); ?>"><?php echo esc_attr( $instance['te'] ); ?></textarea></p>
     <?php

		$out = '<p><label for="' . $this->get_field_id('filter') . '">Automatically add paragraphs to text</label>&nbsp;&nbsp;';
		$out .= '<input id="' . $this->get_field_id('filter') . '" name="' . $this->get_field_name('filter') . '" type="checkbox" ' . checked(isset($instance['filter'])? $instance['filter']: 0, true, false) . ' /></p>';
		echo $out;
	?>
    </div>
    <?php
    }
	function update( $new, $old )
	{	
		$clean = $old;
		if (current_user_can('unfiltered_html')) {
		  $clean['te'] = $new['te'];
		} else {
		  $clean['te'] = stripslashes(wp_filter_post_kses(addslashes($new['te'])));
		}
		
		$clean['filter'] = isset($new['filter']);		
		return $clean;
	}
    function widget($args, $instance) {
        // outputs the content of the widget
		
	global $PPT,$CORE; $STRING = ""; @extract($args);
	  
	if ($instance['filter']) {
      $instance['te'] = wpautop($instance['te']);
    }
		echo do_shortcode(stripslashes($instance['te'])); 
 
    }

} // END BLANK WIDGET


class core_widget_blog_categories extends WP_Widget {

    function __construct(){
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widget_blog_categories',
			'description' => 'Blog categories widget.' 
		);
		parent::__construct( 'core_widget_blog_categories',  '{ Blog Sidebar - Categories }' , $opts );		
    }
	function form($instance) { global $wpdb; ?>        
        <div style="padding:50px 0px; text-align:center;">No options available.</div>        
        <hr />
	<?php 	
	}	 	
    function widget($args, $instance) {
	_ppt_template( 'framework/design/widgets/widget', 'blog-categories' ); 
    }
	
} // END BLANK WIDGET


class core_widget_blog_search extends WP_Widget {

    function __construct(){
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widget_blog_search',
			'description' => 'Blog search widget.' 
		);
		parent::__construct( 'core_widget_blog_search',  '{ Blog Sidebar - Search }' , $opts );		
    }
	function form($instance) { global $wpdb; ?>        
        <div style="padding:50px 0px; text-align:center;">No options available.</div>        
        <hr />
	<?php 	
	}	 	
    function widget($args, $instance) {
	_ppt_template( 'framework/design/widgets/widget', 'blog-search' );
    }
	
} // END BLANK WIDGET


class core_widget_blog_recent extends WP_Widget {

    function __construct(){
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widget_blog_recent',
			'description' => 'Blog recent widget.' 
		);
		parent::__construct( 'core_widget_blog_recent',  '{ Blog Sidebar - Recent Posts }' , $opts );		
    }
	function form($instance) { global $wpdb;
		
		$defaults = array( 'num' => 3 );					
		$instance = wp_parse_args( $instance, $defaults ); 
	 ?>        
        
        
      <div class="ppt_widget_field"> 
               
        <div class="ppt_widget_num"><?php echo __("Display Amount","premiumpress"); ?></div>     
        
         <div style="padding:10px 0px 10px 0px;">            
        
        <input type="text" class="ppt_widget_input" id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" value="<?php echo esc_attr( $instance['num'] ); ?>" />    
       
        </div>
        
        </div>      
         
	<?php 	
	}	 	
	function update( $new, $old )	{		
		$clean = $new;
		$clean['num'] = $new['num'];			
		return $clean;
	}
    function widget($args, $instance) {
	
	global $settings;	
	$settings = $instance;	
	
	_ppt_template( 'framework/design/widgets/widget', 'blog-recent' );
    }
	
} // END BLANK WIDGET



class core_widget_menu extends WP_Widget {

    function __construct(){
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widget_menu',
			'description' => 'Display a menu in your sidebar.' 
		);
		parent::__construct( 'core_widget_menu',  'Menu' , $opts );		
    }
	function form($instance) {
	
	global $wpdb;		 
				
		$defaults = array( 'title' => __("Menu","premiumpress") );					
		$instance = wp_parse_args( $instance, $defaults ); 
		?>
        
        <div class="ppt_widget_field"> 
               
        <div class="ppt_widget_title"><?php echo __("Widget Title","premiumpress"); ?></div>   
        
                   
        <input type="text" class="ppt_widget_input" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />    
        
        </div>
       
        
       <div class="ppt_widget_field last"> 
               
        <div class="ppt_widget_title">Choose a menu to display;</div>                
         
        
        <?php $menus = _ppt_elementor_menus(); if(is_array($menus) && !empty($menus)){  ?>
        
        
        <select id="<?php echo $this->get_field_id( 'menu_id' ); ?>" name="<?php echo $this->get_field_name( 'menu_id' ); ?>" class="ppt_widget_input">
		<?php foreach($menus as $key => $name){ ?>
		<option value="<?php echo $key; ?>" <?php if( isset($instance['menu_id']) && esc_attr( $instance['menu_id'] ) == $key){ echo "selected=selected"; } ?>><?php echo $name; ?></option>
		<?php } ?>
		</select>
          
        
        <?php }else{ ?>
        You have not setup any WP menus.
        <?php } ?>
        
        </div>
        
	<?php 
				
	} 	
	function update( $new, $old )	{		
		$clean = $new;
		$clean['title'] = $new['title'];			
		return $clean;
	}
	
    function widget($args, $instance) {
	
	global $settings;	
	$settings = $instance;	
	
	_ppt_template( 'framework/design/widgets/widget', 'menu' );
    }
	
} // END BLANK WIDGET


/******************************************************************************/

class core_widget_coupon_pop extends WP_Widget {

    function __construct(){
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widget_coupon_pop',
			'description' => 'Popular Coupons Widget.' 
		);
		parent::__construct( 'core_widget_coupon_pop',  '{ Popular Coupons Widget }' , $opts );		
    }
	function form($instance) { global $wpdb;
		
		$defaults = array( 'num' => 3 );					
		$instance = wp_parse_args( $instance, $defaults ); 
	 ?>        
        
        
      <div class="ppt_widget_field"> 
               
        <div class="ppt_widget_num"><?php echo __("Display Amount","premiumpress"); ?></div>     
        
         <div style="padding:10px 0px 10px 0px;">            
        
        <input type="text" class="ppt_widget_input" id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" value="<?php echo esc_attr( $instance['num'] ); ?>" />    
       
        </div>
        
        </div>      
         
	<?php 	
	}	 	
	function update( $new, $old )	{		
		$clean = $new;
		$clean['num'] = $new['num'];			
		return $clean;
	}
    function widget($args, $instance) {
	
	global $settings;	
	$settings = $instance;	
	
	_ppt_template( 'framework/design/widgets/widget', 'coupon-pop' );
    }
	
} // END BLANK WIDGET

 
?>